<?php
// File: app/controllers/BaseController.php
class BaseController {
    protected $activePage = '';

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (get_class($this) !== 'AuthController' && !isset($_SESSION['user_id'])) {
            // Tính base động theo script hiện tại, rồi chuyển về admin auth
            $base = rtrim(str_replace('\\','/', dirname($_SERVER['PHP_SELF'])), '/');
            header('Location: ' . $base . '/admin.php?controller=auth');
            exit();
        }
    }

    protected function renderView($viewPath, $data = []) {
        extract($data);
        $pageTitle = $data['pageTitle'] ?? 'Trang Quản trị';
        $activePage = $this->activePage;
        $contentView = __DIR__ . '/../views/admin/' . $viewPath;
        // Đảm bảo đường dẫn này khớp với cấu trúc thư mục của bạn
        require_once __DIR__ . '/../views/admin/layouts/admin_layout.php';
    }

    protected function setFlashMessage($type, $message) {
        $_SESSION['flash_message'] = [
            'type' => $type,
            'message' => $message
        ];
    }

    // --- Role helpers for admin area ---
    protected function requireRole(array $roles) {
        $role = $_SESSION['role'] ?? null;
        if (!$role || !in_array($role, $roles, true)) {
            http_response_code(403);
            exit('Bạn không có quyền truy cập trang này.');
        }
    }

    protected function isAdmin(): bool {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    protected function isStaff(): bool {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'staff';
    }
}
