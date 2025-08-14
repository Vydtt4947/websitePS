<?php
// File: app/controllers/BaseController.php
class BaseController {
    protected $activePage = '';

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (get_class($this) !== 'AuthController' && !isset($_SESSION['user_id'])) {
            header('Location: /websitePS/public/auth');
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
}
