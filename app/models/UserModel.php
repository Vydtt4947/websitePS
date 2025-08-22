<?php
// File: app/models/UserModel.php
require_once __DIR__ . '/../../config/database.php';

class UserModel {
    private PDO $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    private function sanitizeRole(string $role): string {
        $allowed = ['admin','staff','member'];
        return in_array($role, $allowed, true) ? $role : 'member';
    }

    // Lấy thông tin người dùng theo ID (kèm thông tin nhân viên nếu có)
    public function find(int $userId): ?array {
        $sql = "SELECT u.*, n.MaNV, n.HoTen AS HoTenNV
                FROM users u
                LEFT JOIN nhanvien n ON n.user_id = u.user_id
                WHERE u.user_id = :id LIMIT 1";
        $st = $this->db->prepare($sql);
        $st->bindValue(':id', $userId, PDO::PARAM_INT);
        $st->execute();
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    // Danh sách người dùng với tìm kiếm + phân trang
    public function list(array $opts = []): array {
        $limit  = max(1, (int)($opts['limit']  ?? 10));
        $offset = max(0, (int)($opts['offset'] ?? 0));
        $q      = trim($opts['q'] ?? '');

        $cond = [];
        $p = [];
        if ($q !== '') {
            $cond[] = '(u.username LIKE :q OR u.email LIKE :q)';
            $p[':q'] = "%{$q}%";
        }
        $where = $cond ? ('WHERE ' . implode(' AND ', $cond)) : '';

        $sql = "SELECT u.user_id, u.username, u.email, u.role, u.created_at
                FROM users u
                $where
                ORDER BY u.user_id DESC
                LIMIT :lim OFFSET :off";
        $st = $this->db->prepare($sql);
        foreach ($p as $k=>$v) $st->bindValue($k, $v);
        $st->bindValue(':lim', $limit, PDO::PARAM_INT);
        $st->bindValue(':off', $offset, PDO::PARAM_INT);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function count(array $opts = []): int {
        $q = trim($opts['q'] ?? '');
        $cond = [];
        $p = [];
        if ($q !== '') {
            $cond[] = '(username LIKE :q OR email LIKE :q)';
            $p[':q'] = "%{$q}%";
        }
        $where = $cond ? ('WHERE ' . implode(' AND ', $cond)) : '';
        $st = $this->db->prepare("SELECT COUNT(*) FROM users $where");
        foreach ($p as $k=>$v) $st->bindValue($k, $v);
        $st->execute();
        return (int)$st->fetchColumn();
    }

    public function usernameExists(string $username, ?int $excludeUserId = null): bool {
        if ($excludeUserId) {
            $st = $this->db->prepare('SELECT 1 FROM users WHERE username = :u AND user_id <> :id LIMIT 1');
            $st->execute([':u'=>$username, ':id'=>$excludeUserId]);
        } else {
            $st = $this->db->prepare('SELECT 1 FROM users WHERE username = :u LIMIT 1');
            $st->execute([':u'=>$username]);
        }
        return (bool)$st->fetchColumn();
    }

    public function emailExists(string $email, ?int $excludeUserId = null): bool {
        if ($excludeUserId) {
            $st = $this->db->prepare('SELECT 1 FROM users WHERE email = :e AND user_id <> :id LIMIT 1');
            $st->execute([':e'=>$email, ':id'=>$excludeUserId]);
        } else {
            $st = $this->db->prepare('SELECT 1 FROM users WHERE email = :e LIMIT 1');
            $st->execute([':e'=>$email]);
        }
        return (bool)$st->fetchColumn();
    }

    private function adminsCountExcluding(?int $excludeUserId = null): int {
        if ($excludeUserId) {
            $st = $this->db->prepare("SELECT COUNT(*) FROM users WHERE role='admin' AND user_id <> :id");
            $st->execute([':id'=>$excludeUserId]);
        } else {
            $st = $this->db->query("SELECT COUNT(*) FROM users WHERE role='admin'");
        }
        return (int)$st->fetchColumn();
    }

    // Tạo user mới, trả về user_id hoặc false
    public function create(array $data) {
        $username = trim($data['username'] ?? '');
        $email    = trim($data['email'] ?? '');
        $password = $data['password'] ?? '';
        $role     = $this->sanitizeRole($data['role'] ?? 'member');

        if ($username === '' || $email === '' || $password === '') return false;
        if ($this->usernameExists($username)) return false;
        if ($this->emailExists($email)) return false;

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $st = $this->db->prepare('INSERT INTO users (username, email, password, role, created_at) VALUES (:u,:e,:p,:r,NOW(3))');
        $ok = $st->execute([':u'=>$username, ':e'=>$email, ':p'=>$hash, ':r'=>$role]);
        return $ok ? (int)$this->db->lastInsertId() : false;
    }

    // Cập nhật user (có thể đổi password nếu truyền vào)
    public function update(int $userId, array $data): bool {
        $u = $this->find($userId);
        if (!$u) return false;

        $username = trim($data['username'] ?? ($u['username'] ?? ''));
        $email    = trim($data['email'] ?? ($u['email'] ?? ''));
        $role     = $this->sanitizeRole($data['role'] ?? ($u['role'] ?? 'member'));
        $password = $data['password'] ?? '';

        if ($username === '' || $email === '') return false;
        if ($this->usernameExists($username, $userId)) return false;
        if ($this->emailExists($email, $userId)) return false;

        // Bảo vệ admin cuối cùng khi hạ quyền
        if (($u['role'] ?? '') === 'admin' && $role !== 'admin') {
            if ($this->adminsCountExcluding($userId) === 0) return false;
        }

        if ($password !== '') {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = 'UPDATE users SET username=:u, email=:e, role=:r, password=:p WHERE user_id=:id';
            $params = [':u'=>$username, ':e'=>$email, ':r'=>$role, ':p'=>$hash, ':id'=>$userId];
        } else {
            $sql = 'UPDATE users SET username=:u, email=:e, role=:r WHERE user_id=:id';
            $params = [':u'=>$username, ':e'=>$email, ':r'=>$role, ':id'=>$userId];
        }
        $st = $this->db->prepare($sql);
        return $st->execute($params);
    }

    // Xóa user, chặn xóa mọi tài khoản admin
    public function delete(int $userId): bool {
        $u = $this->find($userId);
        if (!$u) return false;

        // Chặn tuyệt đối xóa admin (kể cả còn nhiều admin)
        if (($u['role'] ?? '') === 'admin') {
            return false;
        }

        try {
            $this->db->beginTransaction();
            $u1 = $this->db->prepare('UPDATE nhanvien SET user_id = NULL WHERE user_id = :uid');
            $u1->execute([':uid'=>$userId]);

            $del = $this->db->prepare('DELETE FROM users WHERE user_id = :id');
            $ok = $del->execute([':id'=>$userId]);
            $this->db->commit();
            return $ok;
        } catch (Throwable $e) {
            $this->db->rollBack();
            return false;
        }
    }
}
