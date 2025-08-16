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
}
