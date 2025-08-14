<?php
// File: app/controllers/AdminBaseController.php
require_once __DIR__ . '/../../config/database.php';

class AdminBaseController {
    protected ?PDO $db = null;
    private string $base; // base URL động (ví dụ: "", "/websitePS/public")

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // Tính base dựa trên script đang chạy
        $this->base = rtrim(str_replace('\\','/', dirname($_SERVER['PHP_SELF'])), '/');

        // Cho phép đi qua AuthController để hiển thị form/login
        if (get_class($this) === 'AuthController') return;

        // Kiểm tra đã đăng nhập và đúng vai trò admin/staff chưa
        if (!isset($_SESSION['user_id'], $_SESSION['role']) || !in_array($_SESSION['role'], ['admin','staff'], true)) {
            $this->redirectToLogin();
        }

        // Cố gắng đồng bộ MaNV vào session nếu chưa có (không bắt buộc cho admin)
        if (!isset($_SESSION['MaNV'])) {
            $emp = $this->findEmployeeByUserId((int)$_SESSION['user_id']);
            if ($emp) {
                $_SESSION['MaNV']     = (int)$emp['MaNV'];
                $_SESSION['HoTenNV']  = $emp['HoTen'] ?? null;
                $_SESSION['EmailNV']  = $emp['Email'] ?? null;
            }
        }
    }

    /** Render view: nhúng view con vào layout admin chung. */
    protected function renderView(string $viewPath, array $data = []) {
        extract($data);
        $contentView = __DIR__ . '/../views/' . $viewPath;
        require_once __DIR__ . '/../views/admin/layout/admin_layout.php';
    }

    /** Bắt buộc role cụ thể cho trang */
    protected function requireRole(array $roles) {
        if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $roles, true)) {
            http_response_code(403);
            exit('Bạn không có quyền truy cập trang này.');
        }
    }

    /** Nếu cần hồ sơ nhân viên (MaNV) cho thao tác ghi sổ, gọi hàm này. */
    protected function requireEmployeeProfile(bool $allowAdminWithoutProfile = true) {
        if (isset($_SESSION['MaNV'])) return;
        $role = $_SESSION['role'] ?? null;
        if ($allowAdminWithoutProfile && $role === 'admin') return;
        http_response_code(403);
        exit('Tài khoản chưa liên kết hồ sơ nhân viên.');
    }

    /** Helper build URL: /<base>/path?query=... */
    protected function url(string $path, array $params = []): string {
        $u = $this->base . $path; // $path như "/admin.php"
        if (!empty($params)) $u .= (strpos($u,'?')===false?'?':'&') . http_build_query($params);
        return $u;
    }

    /** Redirect tới trang đăng nhập admin bằng base động */
    private function redirectToLogin() {
        header('Location: ' . $this->url('/admin.php', ['controller' => 'auth']));
        exit();
    }

    /** Kết nối DB */
    protected function getDb(): PDO {
        if (!$this->db) $this->db = (new Database())->getConnection();
        return $this->db;
    }

    /** Tìm hồ sơ nhân viên theo user_id để tự động lấp MaNV vào session. */
    private function findEmployeeByUserId(int $userId): ?array {
        $sql = "SELECT MaNV, HoTen, Email FROM nhanvien WHERE user_id = :uid LIMIT 1";
        $st  = $this->getDb()->prepare($sql);
        $st->bindValue(':uid', $userId, PDO::PARAM_INT);
        $st->execute();
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }
}
