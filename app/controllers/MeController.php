<?php
// File: app/controllers/MeController.php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/EmployeeModel.php';

class MeController extends BaseController {
    private UserModel $userModel;
    private EmployeeModel $employeeModel;

    public function __construct() {
        parent::__construct();
        // Cho phép cả admin & staff
        $this->requireRole(['admin','staff']);
        $this->activePage = 'me';
        $this->userModel = new UserModel();
        $this->employeeModel = new EmployeeModel();
    }

    public function index() {
        $userId = (int)($_SESSION['user_id'] ?? 0);
        if (!$userId) { http_response_code(403); exit('Chưa đăng nhập.'); }
        $user = $this->userModel->find($userId);
        $employee = null;
        if (!empty($user['MaNV'])) {
            $employee = $this->employeeModel->find((int)$user['MaNV']);
        } else {
            // Thử đồng bộ từ session MaNV nếu có
            if (isset($_SESSION['MaNV'])) {
                $employee = $this->employeeModel->find((int)$_SESSION['MaNV']);
            }
        }
        $data = [
            'pageTitle' => 'Tài khoản của tôi',
            'user' => $user,
            'employee' => $employee
        ];
        $this->renderView('me/index.php', $data);
    }

    public function updateUser() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: /websitePS/public/me'); exit; }
        $userId = (int)($_SESSION['user_id'] ?? 0);
        if (!$userId) { http_response_code(403); exit('Chưa đăng nhập.'); }
        $user = $this->userModel->find($userId);
        if (!$user) { http_response_code(404); exit('Không tìm thấy user.'); }

        $data = [
            'username' => trim($_POST['username'] ?? ''),
            'email'    => trim($_POST['email'] ?? ''),
            'role'     => ($user['role']==='admin') ? ($_POST['role'] ?? $user['role']) : $user['role'],
        ];

        $oldPassword = $_POST['current_password'] ?? '';
        $newPassword = trim($_POST['password'] ?? '');
        $confirmPass = $_POST['password_confirm'] ?? '';

        if ($newPassword !== '') {
            // Yêu cầu nhập mật khẩu hiện tại & xác nhận trùng khớp
            if ($oldPassword === '' || !password_verify($oldPassword, $user['password'] ?? '')) {
                $this->setFlashMessage('danger','Mật khẩu hiện tại không đúng.');
                header('Location: /websitePS/public/me');
                exit;
            }
            if ($newPassword !== $confirmPass) {
                $this->setFlashMessage('danger','Xác nhận mật khẩu mới không khớp.');
                header('Location: /websitePS/public/me');
                exit;
            }
            $data['password'] = $newPassword;
        }

        if ($this->userModel->update($userId, $data)) {
            $this->setFlashMessage('success','Đã cập nhật thông tin đăng nhập.');
            $_SESSION['username'] = $data['username'];
        } else {
            $this->setFlashMessage('danger','Cập nhật thông tin đăng nhập thất bại.');
        }
        header('Location: /websitePS/public/me');
        exit;
    }

    public function updateProfile() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: /websitePS/public/me'); exit; }
        $userId = (int)($_SESSION['user_id'] ?? 0);
        if (!$userId) { http_response_code(403); exit('Chưa đăng nhập.'); }
        $user = $this->userModel->find($userId);
        if (!$user || empty($user['MaNV'])) { $this->setFlashMessage('danger','Chưa liên kết hồ sơ nhân viên.'); header('Location: /websitePS/public/me'); exit; }
        $maNV = (int)$user['MaNV'];

        $payload = [
            'HoTen'       => trim($_POST['HoTen'] ?? ''),
            'Email'       => trim($_POST['Email'] ?? ''),
            'SoDienThoai' => trim($_POST['SoDienThoai'] ?? ''),
            'CCCD'        => trim($_POST['CCCD'] ?? ''),
            'NgaySinh'    => trim($_POST['NgaySinh'] ?? ''),
        ];

        if ($this->employeeModel->updateProfile($maNV, $payload)) {
            $this->setFlashMessage('success','Đã cập nhật hồ sơ cá nhân.');
            $_SESSION['HoTenNV'] = $payload['HoTen'];
        } else {
            $this->setFlashMessage('danger','Cập nhật hồ sơ thất bại.');
        }
        header('Location: /websitePS/public/me');
        exit;
    }
}
