<?php
// File: app/models/EmployeeModel.php
require_once __DIR__ . '/../../config/database.php';

class EmployeeModel {
    private PDO $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    /** Lấy 1 nhân viên theo MaNV */
    public function find(int $maNV): ?array {
        $sql = "SELECT n.*, u.username, u.email AS user_email, u.role
                FROM nhanvien n
                LEFT JOIN users u ON u.user_id = n.user_id
                WHERE n.MaNV = :id
                LIMIT 1";
        $st = $this->db->prepare($sql);
        $st->execute([':id' => $maNV]);
        $row = $st->fetch();
        return $row ?: null;
    }

    /** Lấy 1 nhân viên theo user_id (liên kết qua bảng users) */
    public function findByUserId(int $userId): ?array {
        $sql = "SELECT n.*, u.username, u.email AS user_email, u.role
                FROM nhanvien n
                LEFT JOIN users u ON u.user_id = n.user_id
                WHERE n.user_id = :uid
                LIMIT 1";
        $st = $this->db->prepare($sql);
        $st->execute([':uid' => $userId]);
        $row = $st->fetch();
        return $row ?: null;
    }

    /** Danh sách nhân viên + tìm kiếm + phân trang */
    public function list(array $opts = []): array {
        $limit  = max(1, (int)($opts['limit']  ?? 20));
        $offset = max(0, (int)($opts['offset'] ?? 0));
        $q      = trim($opts['q'] ?? '');

        $cond = [];
        $p = [];
        if ($q !== '') {
            $cond[] = "(n.HoTen LIKE :q OR n.Email LIKE :q OR u.username LIKE :q)";
            $p[':q'] = "%{$q}%";
        }
        $where = $cond ? ("WHERE " . implode(" AND ", $cond)) : "";

        $sql = "SELECT n.MaNV, n.HoTen, n.Email, n.SoDienThoai, u.username, u.role
                FROM nhanvien n
                LEFT JOIN users u ON u.user_id = n.user_id
                $where
                ORDER BY n.MaNV DESC
                LIMIT :lim OFFSET :off";
        $st = $this->db->prepare($sql);
        foreach ($p as $k => $v) $st->bindValue($k, $v);
        $st->bindValue(':lim', $limit, PDO::PARAM_INT);
        $st->bindValue(':off', $offset, PDO::PARAM_INT);
        $st->execute();
        return $st->fetchAll();
    }

    /** Tạo mới 1 nhân viên */
    public function create(array $data): bool {
        $sql = "INSERT INTO nhanvien (HoTen, Email, SoDienThoai, CCCD, NgaySinh, user_id)
                VALUES (:ten, :email, :sdt, :cccd, :ngay, :uid)";
        $st = $this->db->prepare($sql);
        $uid = $data['user_id'] ?? null; // có thể null nếu chưa gắn tài khoản
        return $st->execute([
            ':ten'   => trim($data['HoTen'] ?? ''),
            ':email' => trim($data['Email'] ?? ''),
            ':sdt'   => trim($data['SoDienThoai'] ?? ''),
            ':cccd'  => trim($data['CCCD'] ?? ''),
            ':ngay'  => ($data['NgaySinh'] ?? null) ?: null,
            ':uid'   => $uid !== '' ? $uid : null,
        ]);
    }

    /**
     * Tạo nhân viên kèm tự động tạo tài khoản users (role = staff) và liên kết user_id.
     * Trả về: [success=>bool, user_id=>int|null, temp_password=>string|null, username=>string|null, message=>string]
     */
    public function createWithUser(array $data): array {
        $result = ['success' => false, 'user_id' => null, 'temp_password' => null, 'username' => null, 'message' => ''];

        $email = trim($data['Email'] ?? '');
        $fullName = trim($data['HoTen'] ?? '');
        if ($email === '') {
            $result['message'] = 'Email là bắt buộc để tạo tài khoản người dùng.';
            return $result;
        }

        try {
            $this->db->beginTransaction();

            // 1) Tạo username từ email hoặc tên và đảm bảo duy nhất
            $baseUsername = $this->makeBaseUsername($email, $fullName);
            $username = $this->ensureUniqueUsername($baseUsername);

            // 2) Kiểm tra email đã tồn tại trên bảng users
            $stCk = $this->db->prepare('SELECT user_id FROM users WHERE email = :e LIMIT 1');
            $stCk->execute([':e' => $email]);
            $existingUserId = (int)($stCk->fetchColumn() ?: 0);
            if ($existingUserId) {
                // Nếu đã tồn tại user với email này, không tạo mới để tránh trùng
                $result['message'] = 'Email đã tồn tại trong hệ thống người dùng.';
                $this->db->rollBack();
                return $result;
            }

            // 3) Tạo tài khoản users với role staff - mật khẩu: 'staff' + 4 số cuối CCCD
            $cccdRaw = trim($data['CCCD'] ?? '');
            $digits = preg_replace('/\D/', '', $cccdRaw);
            $last4 = substr(str_pad($digits, 4, '0', STR_PAD_LEFT), -4);
            $tempPassword = 'staff' . $last4;
            $hash = password_hash($tempPassword, PASSWORD_DEFAULT);

            $insUser = $this->db->prepare('INSERT INTO users (username, email, password, role, created_at) VALUES (:u,:e,:p,:r,NOW(3))');
            $insUser->execute([':u' => $username, ':e' => $email, ':p' => $hash, ':r' => 'staff']);
            $newUserId = (int)$this->db->lastInsertId();

            // 4) Tạo bản ghi nhân viên và gắn user_id
            $insEmp = $this->db->prepare("INSERT INTO nhanvien (HoTen, Email, SoDienThoai, CCCD, NgaySinh, user_id)
                                          VALUES (:ten, :email, :sdt, :cccd, :ngay, :uid)");
            $insEmp->execute([
                ':ten'   => $fullName,
                ':email' => $email,
                ':sdt'   => trim($data['SoDienThoai'] ?? ''),
                ':cccd'  => trim($data['CCCD'] ?? ''),
                ':ngay'  => ($data['NgaySinh'] ?? null) ?: null,
                ':uid'   => $newUserId,
            ]);

            $this->db->commit();
            $result['success'] = true;
            $result['user_id'] = $newUserId;
            $result['temp_password'] = $tempPassword;
            $result['username'] = $username;
            $result['message'] = 'Đã tạo nhân viên và tài khoản người dùng.';
            return $result;
        } catch (Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            $result['message'] = 'Lỗi tạo nhân viên/tài khoản: ' . $e->getMessage();
            return $result;
        }
    }

    /** Cập nhật hồ sơ nhân viên (bảng nhanvien) và đồng bộ email sang users nếu thay đổi */
    public function updateProfile(int $maNV, array $data): bool {
        $cur = $this->find($maNV);
        if (!$cur) return false;

        $sql = "UPDATE nhanvien
                SET HoTen = :ten,
                    SoDienThoai = :sdt,
                    CCCD = :cccd,
                    Email = :email,
                    NgaySinh = :ngay
                WHERE MaNV = :id";
        $st = $this->db->prepare($sql);
        $ok = $st->execute([
            ':ten'   => $data['HoTen']        ?? $cur['HoTen'],
            ':sdt'   => $data['SoDienThoai']  ?? $cur['SoDienThoai'],
            ':cccd'  => $data['CCCD']         ?? $cur['CCCD'],
            ':email' => $data['Email']        ?? $cur['Email'],
            ':ngay'  => $data['NgaySinh']     ?? $cur['NgaySinh'],
            ':id'    => $maNV,
        ]);

        // Đồng bộ users.email nếu có liên kết user_id và email thay đổi
        $userId = (int)($cur['user_id'] ?? 0);
        if ($ok && $userId && isset($data['Email']) && $data['Email'] !== $cur['Email']) {
            $u = $this->db->prepare("UPDATE users SET email = :e WHERE user_id = :uid");
            $u->execute([':e' => $data['Email'], ':uid' => $userId]);
        }
        return $ok;
    }
    

    /** Đếm phục vụ phân trang (áp dụng cùng điều kiện tìm kiếm như list) */
    public function countAll(string $q = ''): int {
        $cond = [];
        $p = [];
        if ($q !== '') {
            $cond[] = "(n.HoTen LIKE :q OR n.Email LIKE :q OR u.username LIKE :q)";
            $p[':q'] = "%{$q}%";
        }
        $where = $cond ? ("WHERE " . implode(" AND ", $cond)) : "";
        $sql = "SELECT COUNT(*) FROM nhanvien n
                LEFT JOIN users u ON u.user_id = n.user_id
                $where";
        $st = $this->db->prepare($sql);
        foreach ($p as $k => $v) $st->bindValue($k, $v);
        $st->execute();
        return (int)$st->fetchColumn();
    }

    // Cập nhật role của tài khoản users liên kết với nhân viên
    public function updateRole(int $maNV, string $role): bool {
        // Lấy user_id từ bảng nhanvien
        $st = $this->db->prepare('SELECT user_id FROM nhanvien WHERE MaNV = :id LIMIT 1');
        $st->execute([':id' => $maNV]);
        $userId = (int)$st->fetchColumn();
        if (!$userId) return false; // chưa liên kết tài khoản

        $u = $this->db->prepare('UPDATE users SET role = :r WHERE user_id = :uid');
        return $u->execute([':r' => $role, ':uid' => $userId]);
    }

    // Xóa nhân viên theo MaNV
    public function delete(int $maNV): bool {
        $sql = 'DELETE FROM nhanvien WHERE MaNV = :id';
        $st = $this->db->prepare($sql);
        return $st->execute([':id' => $maNV]);
    }

    private function makeBaseUsername(string $email, string $fullName): string {
        if ($email !== '') {
            $local = strtolower(preg_replace('/[^a-z0-9._-]/i', '', explode('@', $email)[0] ?? ''));
            if ($local !== '') return $local;
        }
        $name = strtolower(trim($fullName));
        $name = preg_replace('/[^a-z0-9]+/i', '.', $name);
        $name = trim($name, '.');
        return $name !== '' ? $name : 'staff';
    }

    private function ensureUniqueUsername(string $base): string {
        $username = $base;
        $i = 0;
        $st = $this->db->prepare('SELECT COUNT(*) FROM users WHERE username = :u');
        while (true) {
            $st->execute([':u' => $username]);
            $cnt = (int)$st->fetchColumn();
            if ($cnt === 0) return $username;
            $i++;
            $username = $base . $i;
        }
    }

    private function generateTempPassword(int $length = 10): string {
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789!@#$%^&*';
        $out = '';
        $max = strlen($chars) - 1;
        for ($i = 0; $length > $i; $i++) {
            $out .= $chars[random_int(0, $max)];
        }
        return $out;
    }
}
