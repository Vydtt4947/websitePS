<?php
// File: app/models/AuthModel.php
require_once __DIR__ . '/../../config/database.php';

class AuthModel {
    private PDO $db;

    public function __construct() {
        $this->db = (new Database())->getConnection(); // PDO trỏ DB cake_shop
    }

    // Chỉ cho phép role admin|staff
    public function attemptLogin(string $email, string $password, array $rolesAllowed = ['admin','staff']) {
        $sql = "
            SELECT 
                u.user_id,
                u.username,
                u.email          AS user_email,
                u.password       AS user_password,
                u.role,
                n.MaNV,
                n.HoTen,
                n.Email          AS emp_email,
                n.SoDienThoai,
                n.CCCD,
                n.NgaySinh
            FROM users u
            LEFT JOIN nhanvien n ON n.user_id = u.user_id
            WHERE u.email = :email
            LIMIT 1
        ";
        $st = $this->db->prepare($sql);
        $st->bindValue(':email', $email);
        $st->execute();
        $row = $st->fetch(PDO::FETCH_ASSOC);

        if (!$row) return false;
        if (!isset($row['user_password']) || !password_verify($password, $row['user_password'])) return false;
        if (!empty($rolesAllowed) && !in_array($row['role'], $rolesAllowed, true)) return false;

        unset($row['user_password']);
        return $row;
    }

    public function checkEmailExists(string $email): bool {
        $st = $this->db->prepare("SELECT 1 FROM users WHERE email = :email LIMIT 1");
        $st->bindValue(':email', $email);
        $st->execute();
        return (bool)$st->fetchColumn();
    }

    public function createEmployee(array $data): bool {
        $hoTen  = trim($data['HoTen']  ?? '');
        $email  = trim($data['Email']  ?? '');
        $pass   =        $data['MatKhau'] ?? '';
        $role   = 'staff';

        if ($hoTen==='' || $email==='' || $pass==='') return false;
        if ($this->checkEmailExists($email)) return false;

        $username = trim($data['username'] ?? '');
        if ($username==='') {
            $username = explode('@', $email)[0] ?? 'user';
            $username = preg_replace('/[^a-zA-Z0-9_.-]/', '', $username) ?: 'user';
        }

        $hash = password_hash($pass, PASSWORD_DEFAULT);

        try {
            $this->db->beginTransaction();

            // users
            $su = $this->db->prepare("INSERT INTO users (username, email, password, role) VALUES (:u,:e,:p,:r)");
            $su->execute([':u'=>$username, ':e'=>$email, ':p'=>$hash, ':r'=>$role]);
            $userId = (int)$this->db->lastInsertId();

            // nhanvien (MaNV AUTO_INCREMENT)
            $se = $this->db->prepare("INSERT INTO nhanvien (HoTen, Email, user_id) VALUES (:ten,:email,:uid)");
            $se->execute([':ten'=>$hoTen, ':email'=>$email, ':uid'=>$userId]);

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();

            // Nếu trùng username -> thử biến thể 1 lần
            if ((int)($e->errorInfo[1] ?? 0) === 1062 && stripos($e->getMessage(), 'username') !== false) {
                try {
                    $this->db->beginTransaction();
                    $username2 = $username . '_' . substr(uniqid('', true), -4);

                    $su = $this->db->prepare("INSERT INTO users (username, email, password, role) VALUES (:u,:e,:p,:r)");
                    $su->execute([':u'=>$username2, ':e'=>$email, ':p'=>$hash, ':r'=>$role]);
                    $userId = (int)$this->db->lastInsertId();

                    $se = $this->db->prepare("INSERT INTO nhanvien (HoTen, Email, user_id) VALUES (:ten,:email,:uid)");
                    $se->execute([':ten'=>$hoTen, ':email'=>$email, ':uid'=>$userId]);

                    $this->db->commit();
                    return true;
                } catch (PDOException $e2) {
                    $this->db->rollBack();
                    return false;
                }
            }
            return false;
        }
    }
}
