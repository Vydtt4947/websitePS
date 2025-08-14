<?php
// File: app/controllers/AuthController.php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/AuthModel.php';

class AuthController extends BaseController {
    private $authModel;
    private string $base;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->authModel = new AuthModel();
        $this->base = rtrim(str_replace('\\','/', dirname($_SERVER['PHP_SELF'])), '/');
    }

    private function url(string $path, array $params = []): string {
        $u = $this->base . $path; // $path như "/admin.php"
        if (!empty($params)) $u .= (strpos($u,'?')===false?'?':'&').http_build_query($params);
        return $u;
    }

    public function index() {
        $pageTitle    = 'Đăng nhập hệ thống';
$loginAction  = $this->url('/admin.php', ['controller'=>'auth','action'=>'handleLogin']);
        require_once __DIR__ . '/../views/admin/auth/login.php';
    }

    public function handleLogin() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: '.$this->url('/admin.php', ['controller'=>'auth'])); exit();
        }

        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            header('Location: '.$this->url('/admin.php', ['controller'=>'auth','error'=>'empty'])); exit();
        }

        $user = $this->authModel->attemptLogin($email, $password); // email, role admin|staff

        if (!$user) {
            header('Location: '.$this->url('/admin.php', ['controller'=>'auth','error'=>1])); exit();
        }

        session_regenerate_id(true);
        $_SESSION['user_id']  = (int)$user['user_id'];
        $_SESSION['username'] = $user['username'] ?? null;
        $_SESSION['role']     = $user['role'];
        if (!empty($user['MaNV'])) {
            $_SESSION['MaNV']  = (int)$user['MaNV'];
            $_SESSION['HoTen'] = $user['HoTen'] ?? null;
        } else {
            $_SESSION['MaNV']  = null;
            $_SESSION['HoTen'] = $user['username'] ?? null;
        }

        header('Location: '.$this->url('/admin.php')); // -> AdminController::index()
        exit();
    }

    public function register() {
        $pageTitle = 'Đăng ký tài khoản nhân sự';
        require_once __DIR__ . '/../views/admin/auth/register.php';
    }

    public function handleRegister() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: '.$this->url('/admin.php', ['controller'=>'auth','action'=>'register'])); exit();
        }

        $hoTen   = trim($_POST['HoTen'] ?? '');
        $email   = trim($_POST['Email'] ?? '');
        $matKhau = $_POST['MatKhau'] ?? '';
        $confirm = $_POST['MatKhauXacNhan'] ?? '';

        if ($hoTen === '' || $email === '' || $matKhau === '') {
            header('Location: '.$this->url('/admin.php', ['controller'=>'auth','action'=>'register','error'=>'empty'])); exit();
        }
        if ($matKhau !== $confirm) {
            header('Location: '.$this->url('/admin.php', ['controller'=>'auth','action'=>'register','error'=>'password_mismatch'])); exit();
        }
        if ($this->authModel->checkEmailExists($email)) {
            header('Location: '.$this->url('/admin.php', ['controller'=>'auth','action'=>'register','error'=>'email_exists'])); exit();
        }

        $data = [
            'HoTen'   => $hoTen,
            'Email'   => $email,
            'MatKhau' => $matKhau,
            'username'=> $_POST['username'] ?? null,
        ];

        if ($this->authModel->createEmployee($data)) {
            header('Location: '.$this->url('/admin.php', ['controller'=>'auth','success'=>'registered'])); exit();
        } else {
            header('Location: '.$this->url('/admin.php', ['controller'=>'auth','action'=>'register','error'=>'unknown'])); exit();
        }
    }

    public function logout() {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
        }
        session_destroy();
        header('Location: '.$this->url('/admin.php', ['controller'=>'auth'])); exit();
    }
}
