<?php
// filepath: c:\xampp\htdocs\websitePS\app\controllers\UserController.php
// File: app/controllers/UserController.php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../../config/database.php';

class UsersController extends BaseController {
    private PDO $db;

    public function __construct() {
        parent::__construct();
        $this->activePage = 'users';
        $this->db = (new Database())->getConnection();
        // Chỉ admin mới được truy cập phần Users
        $this->requireRole(['admin']);
    }

    private function sanitizeRole(string $role): string {
        $allowed = ['admin', 'staff', 'member'];
        return in_array($role, $allowed, true) ? $role : 'member';
    }

    // Danh sách người dùng (có tìm kiếm + phân trang)
    public function index() {
        $search = trim($_GET['search'] ?? '');
        $perPage = max(5, (int)($_GET['perPage'] ?? 10));
        $currentPage = max(1, (int)($_GET['page'] ?? 1));
        $offset = ($currentPage - 1) * $perPage;

        $conditions = [];
        $params = [];
        if ($search !== '') {
            $conditions[] = '(username LIKE :q OR email LIKE :q)';
            $params[':q'] = "%{$search}%";
        }
        $where = $conditions ? ('WHERE ' . implode(' AND ', $conditions)) : '';

        // Đếm tổng
        $countSql = "SELECT COUNT(*) FROM users $where";
        $stCount = $this->db->prepare($countSql);
        foreach ($params as $k => $v) $stCount->bindValue($k, $v);
        $stCount->execute();
        $totalUsers = (int)$stCount->fetchColumn();

        // Lấy danh sách
        $sql = "SELECT user_id, username, email, role, created_at
                FROM users
                $where
                ORDER BY user_id DESC
                LIMIT :lim OFFSET :off";
        $st = $this->db->prepare($sql);
        foreach ($params as $k => $v) $st->bindValue($k, $v);
        $st->bindValue(':lim', $perPage, PDO::PARAM_INT);
        $st->bindValue(':off', $offset, PDO::PARAM_INT);
        $st->execute();
        $users = $st->fetchAll(PDO::FETCH_ASSOC) ?: [];

        $data = [
            'pageTitle'   => 'Quản lý Người dùng',
            'users'       => $users,
            'totalUsers'  => $totalUsers,
            'perPage'     => $perPage,
            'currentPage' => $currentPage,
            'searchTerm'  => $search,
        ];
        $this->renderView('users/index.php', $data);
    }

    // Chi tiết người dùng
    public function show($id) {
        $id = (int)$id;
        $sql = "SELECT u.*, n.MaNV, n.HoTen AS HoTenNV
                FROM users u
                LEFT JOIN nhanvien n ON n.user_id = u.user_id
                WHERE u.user_id = :id LIMIT 1";
        $st = $this->db->prepare($sql);
        $st->bindValue(':id', $id, PDO::PARAM_INT);
        $st->execute();
        $user = $st->fetch(PDO::FETCH_ASSOC);
        if (!$user) { echo 'Không tìm thấy người dùng.'; exit; }

        $data = [
            'pageTitle' => 'Chi tiết Người dùng: ' . htmlspecialchars($user['username'] ?? ''),
            'user'      => $user,
        ];
        $this->renderView('users/show.php', $data);
    }

    // Form tạo mới: tắt chức năng, chuyển hướng sang thêm Nhân viên
    public function create() {
        $this->setFlashMessage('info', 'Tài khoản người dùng được tạo tự động khi thêm Nhân viên.');
        header('Location: /websitePS/public/employees/create');
        exit;
    }

    // Lưu tạo mới: tắt chức năng
    public function store() {
        $this->setFlashMessage('danger', 'Không hỗ trợ thêm người dùng trực tiếp. Vui lòng thêm qua mục Nhân viên.');
        header('Location: /websitePS/public/employees/create');
        exit;
    }

    // Form chỉnh sửa
    public function edit($id) {
        $id = (int)$id;
        $st = $this->db->prepare('SELECT user_id, username, email, role FROM users WHERE user_id = :id LIMIT 1');
        $st->execute([':id'=>$id]);
        $user = $st->fetch(PDO::FETCH_ASSOC);
        if (!$user) { echo 'Không tìm thấy người dùng.'; exit; }

        $data = [
            'pageTitle' => 'Sửa Người dùng #' . $id,
            'user'      => $user,
            'roles'     => ['admin','staff','member'],
        ];
        $this->renderView('users/edit.php', $data);
    }

    // Cập nhật
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: /websitePS/public/users'); exit; }
        $id = (int)$id;

        $username = trim($_POST['username'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $role     = $this->sanitizeRole($_POST['role'] ?? 'member');
        $password = $_POST['password'] ?? '';

        if ($username === '' || $email === '') {
            $this->setFlashMessage('danger', 'Vui lòng nhập đầy đủ username và email.');
            header('Location: /websitePS/public/users/edit/' . $id); exit;
        }

        // Kiểm tra trùng username/email (trừ chính nó)
        $ck = $this->db->prepare('SELECT 1 FROM users WHERE (username = :u OR email = :e) AND user_id <> :id LIMIT 1');
        $ck->execute([':u'=>$username, ':e'=>$email, ':id'=>$id]);
        if ($ck->fetchColumn()) {
            $this->setFlashMessage('danger', 'Username hoặc Email đã được sử dụng.');
            header('Location: /websitePS/public/users/edit/' . $id); exit;
        }

        // Bảo vệ: không để mất admin cuối cùng
        $cur = $this->db->prepare('SELECT role FROM users WHERE user_id = :id');
        $cur->execute([':id'=>$id]);
        $current = $cur->fetch(PDO::FETCH_ASSOC);
        if (!$current) { $this->setFlashMessage('danger','Người dùng không tồn tại.'); header('Location: /websitePS/public/users'); exit; }
        if (($current['role'] === 'admin') && ($role !== 'admin')) {
            $cnt = $this->db->query("SELECT COUNT(*) FROM users WHERE role='admin' AND user_id <> " . (int)$id)->fetchColumn();
            if ((int)$cnt === 0) {
                $this->setFlashMessage('danger', 'Không thể hạ quyền vì đây là admin cuối cùng.');
                header('Location: /websitePS/public/users/edit/' . $id); exit;
            }
        }

        if ($password !== '') {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = 'UPDATE users SET username = :u, email = :e, role = :r, password = :p WHERE user_id = :id';
            $params = [':u'=>$username, ':e'=>$email, ':r'=>$role, ':p'=>$hash, ':id'=>$id];
        } else {
            $sql = 'UPDATE users SET username = :u, email = :e, role = :r WHERE user_id = :id';
            $params = [':u'=>$username, ':e'=>$email, ':r'=>$role, ':id'=>$id];
        }
        $st = $this->db->prepare($sql);
        $ok = $st->execute($params);
        if ($ok) {
            $this->setFlashMessage('success', 'Cập nhật người dùng thành công.');
        } else {
            $this->setFlashMessage('danger', 'Cập nhật thất bại.');
        }
        header('Location: /websitePS/public/users'); exit;
    }

    // Xóa người dùng
    public function delete($id) {
        $id = (int)$id;
        // Không cho tự xóa chính mình
        if (isset($_SESSION['user_id']) && (int)$_SESSION['user_id'] === $id) {
            $this->setFlashMessage('danger', 'Không thể tự xóa tài khoản đang đăng nhập.');
            header('Location: /websitePS/public/users'); exit;
        }

        // Kiểm tra role hiện tại
        $st = $this->db->prepare('SELECT role FROM users WHERE user_id = :id');
        $st->execute([':id'=>$id]);
        $row = $st->fetch(PDO::FETCH_ASSOC);
        if (!$row) { $this->setFlashMessage('danger','Người dùng không tồn tại.'); header('Location: /websitePS/public/users'); exit; }

        // Chặn tuyệt đối xóa admin
        if (($row['role'] ?? '') === 'admin') {
            $this->setFlashMessage('danger', 'Không thể xóa tài khoản admin.');
            header('Location: /websitePS/public/users'); exit;
        }

        // Xóa: lưu ý có thể có khóa ngoại từ nhanvien, khachhang...
        try {
            $this->db->beginTransaction();
            // Nếu có bảng nhanvien tham chiếu user_id, nên gỡ liên kết (set null) trước khi xóa user
            $u1 = $this->db->prepare('UPDATE nhanvien SET user_id = NULL WHERE user_id = :uid');
            $u1->execute([':uid'=>$id]);

            $del = $this->db->prepare('DELETE FROM users WHERE user_id = :id');
            $ok = $del->execute([':id'=>$id]);
            $this->db->commit();
            if ($ok) {
                $this->setFlashMessage('success', 'Đã xóa người dùng.');
            } else {
                $this->setFlashMessage('danger', 'Xóa thất bại.');
            }
        } catch (Throwable $e) {
            $this->db->rollBack();
            $this->setFlashMessage('danger', 'Lỗi khi xóa: ' . $e->getMessage());
        }
        header('Location: /websitePS/public/users'); exit;
    }
}
