<?php
// File: app/models/StaffModel.php
require_once __DIR__ . '/../../config/database.php';

class StaffModel {
    private PDO $db;
    public function __construct() { $this->db = (new Database())->getConnection(); }

    public function find(int $maNV): ?array {
        $sql = "SELECT n.*, u.username, u.email AS user_email, u.role
                FROM nhanvien n
                LEFT JOIN users u ON u.user_id = n.user_id
                WHERE n.MaNV=:id LIMIT 1";
        $st = $this->db->prepare($sql);
        $st->execute([':id'=>$maNV]);
        $row = $st->fetch();
        return $row ?: null;
    }

    public function findByUserId(int $userId): ?array {
        $sql = "SELECT n.*, u.username, u.email AS user_email, u.role
                FROM nhanvien n
                LEFT JOIN users u ON u.user_id = n.user_id
                WHERE n.user_id=:uid LIMIT 1";
        $st = $this->db->prepare($sql);
        $st->execute([':uid'=>$userId]);
        $row = $st->fetch();
        return $row ?: null;
    }

    public function list(array $opts = []): array {
        $limit  = (int)($opts['limit']  ?? 20);
        $offset = (int)($opts['offset'] ?? 0);
        $q      = trim($opts['q'] ?? '');

        $cond=[]; $p=[];
        if ($q !== '') {
            $cond[] = "(n.HoTen LIKE :q OR n.Email LIKE :q OR u.username LIKE :q)";
            $p[':q'] = "%$q%";
        }
        $where = $cond ? ("WHERE ".implode(" AND ", $cond)) : "";

        $sql = "SELECT n.MaNV, n.HoTen, n.Email, n.SoDienThoai, u.username, u.role
                FROM nhanvien n
                LEFT JOIN users u ON u.user_id = n.user_id
                $where
                ORDER BY n.MaNV DESC
                LIMIT :lim OFFSET :off";
        $st = $this->db->prepare($sql);
        foreach ($p as $k=>$v) $st->bindValue($k, $v);
        $st->bindValue(':lim', $limit, PDO::PARAM_INT);
        $st->bindValue(':off', $offset, PDO::PARAM_INT);
        $st->execute();
        return $st->fetchAll();
    }

    public function updateProfile(int $maNV, array $data): bool {
        // Lấy liên kết user
        $cur = $this->find($maNV);
        if (!$cur) return false;
        $userId = (int)($cur['user_id'] ?? 0);

        $sql = "UPDATE nhanvien
                SET HoTen=:ten, SoDienThoai=:sdt, CCCD=:cccd, Email=:email, NgaySinh=:ngay
                WHERE MaNV=:id";
        $st = $this->db->prepare($sql);
        $ok = $st->execute([
            ':ten'   => $data['HoTen'] ?? $cur['HoTen'],
            ':sdt'   => $data['SoDienThoai'] ?? $cur['SoDienThoai'],
            ':cccd'  => $data['CCCD'] ?? $cur['CCCD'],
            ':email' => $data['Email'] ?? $cur['Email'],
            ':ngay'  => $data['NgaySinh'] ?? $cur['NgaySinh'],
            ':id'    => $maNV,
        ]);

        // Đồng bộ users.email nếu thay đổi
        if ($ok && $userId && isset($data['Email']) && $data['Email'] !== $cur['Email']) {
            $u = $this->db->prepare("UPDATE users SET email=:e WHERE user_id=:uid");
            $u->execute([':e'=>$data['Email'], ':uid'=>$userId]);
        }
        return $ok;
    }

    /** Thay đổi role tài khoản liên kết (admin/staff) */
    public function updateRole(int $maNV, string $role): bool {
        if (!in_array($role, ['admin','staff','member'], true)) return false;
        $cur = $this->find($maNV);
        if (!$cur || empty($cur['user_id'])) return false;

        $st = $this->db->prepare("UPDATE users SET role=:r WHERE user_id=:uid");
        return $st->execute([':r'=>$role, ':uid'=>(int)$cur['user_id']]);
    }
}
