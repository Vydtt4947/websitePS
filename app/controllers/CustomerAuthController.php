<?php
// File: app/controllers/CustomerAuthController.php

// KHÔNG KẾ THỪA TỪ BASECONTROLLER
// require_once __DIR__ . '/BaseController.php'; 
require_once __DIR__ . '/../models/CustomerModel.php';
require_once __DIR__ . '/../models/CustomerAuthModel.php';
require_once __DIR__ . '/../models/CartModel.php';
require_once __DIR__ . '/../models/SessionCartModel.php';

class CustomerAuthController {

    public function login() {
        // Gọi trực tiếp đến file view, không qua renderView
        require_once __DIR__ . '/../views/pages/login.php';
    }

    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validation
            if (empty($_POST['email']) || empty($_POST['password'])) {
                $error = "Vui lòng nhập email và mật khẩu.";
                require_once __DIR__ . '/../views/pages/login.php';
                exit();
            }

            $customerAuthModel = new CustomerAuthModel();
            $customer = $customerAuthModel->attemptLogin($_POST['email'], $_POST['password']);

            if ($customer) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['customer_id'] = $customer['MaKH'];
                $_SESSION['customer_name'] = $customer['HoTen'];
                $_SESSION['customer_email'] = $customer['Email'];
                $_SESSION['customer_phone'] = $customer['SoDienThoai'] ?? '';
                
                // Đồng bộ giỏ hàng session vào database
                $sessionCartModel = new SessionCartModel();
                $sessionCart = $sessionCartModel->getCart();
                
                if (!empty($sessionCart)) {
                    $cartModel = new CartModel();
                    // Sử dụng method merge để tránh duplicate
                    $cartModel->mergeSessionCart($customer['MaKH'], $sessionCart);
                    
                    // Xóa giỏ hàng session sau khi đã đồng bộ
                    $sessionCartModel->clearCart();
                }
                
                header('Location: /websitePS/public/');
                exit();
            } else {
                $error = "Email hoặc mật khẩu không chính xác.";
                // Gọi lại view đăng nhập và truyền biến lỗi
                require_once __DIR__ . '/../views/pages/login.php';
            }
        }
    }

    public function register() {
        // Gọi trực tiếp đến file view
        require_once __DIR__ . '/../views/pages/register.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validation
            if (empty($_POST['fullname']) || empty($_POST['email']) || empty($_POST['password'])) {
                $error = "Vui lòng điền đầy đủ thông tin.";
                require_once __DIR__ . '/../views/pages/register.php';
                exit();
            }

            if (strlen($_POST['password']) < 6) {
                $error = "Mật khẩu phải có ít nhất 6 ký tự.";
                require_once __DIR__ . '/../views/pages/register.php';
                exit();
            }

            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $error = "Email không hợp lệ.";
                require_once __DIR__ . '/../views/pages/register.php';
                exit();
            }

            $customerAuthModel = new CustomerAuthModel();
            
            $existingCustomer = $customerAuthModel->checkEmailExists($_POST['email']);
            if ($existingCustomer) {
                $error = "Email này đã được sử dụng. Vui lòng chọn email khác.";
                require_once __DIR__ . '/../views/pages/register.php';
                exit();
            }

            // Tạo dữ liệu cho CustomerAuthModel
            $customerData = [
                'HoTen' => trim($_POST['fullname']),
                'Email' => trim($_POST['email']),
                'MatKhau' => $_POST['password'],
                'SoDienThoai' => trim($_POST['phone'] ?? '')
            ];

            // Tạo tài khoản mới
            if ($customerAuthModel->createCustomer($customerData)) {
                // Tự động đăng nhập sau khi tạo tài khoản thành công
                $customer = $customerAuthModel->attemptLogin($_POST['email'], $_POST['password']);
                if ($customer) {
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                    $_SESSION['customer_id'] = $customer['MaKH'];
                    $_SESSION['customer_name'] = $customer['HoTen'];
                    $_SESSION['customer_email'] = $customer['Email'];
                    $_SESSION['customer_phone'] = $customer['SoDienThoai'] ?? '';
                    
                    // Đồng bộ giỏ hàng session vào database cho tài khoản mới
                    $sessionCartModel = new SessionCartModel();
                    $sessionCart = $sessionCartModel->getCart();
                    
                    if (!empty($sessionCart)) {
                        $cartModel = new CartModel();
                        // Sử dụng method merge để đảm bảo tính nhất quán
                        $cartModel->mergeSessionCart($customer['MaKH'], $sessionCart);
                        $sessionCartModel->clearCart();
                    }
                    
                    // Thông báo thành công và chuyển hướng
                    $_SESSION['success_message'] = 'Tạo tài khoản thành công! Chào mừng bạn đến với Parrot Smell!';
                    header('Location: /websitePS/public/');
                    exit();
                } else {
                    // Nếu không thể tự động đăng nhập, yêu cầu người dùng đăng nhập thủ công
                    $_SESSION['success_message'] = 'Tạo tài khoản thành công! Vui lòng đăng nhập để tiếp tục.';
                    header('Location: /websitePS/public/customerauth/login');
                    exit();
                }
            } else {
                // Nếu tạo tài khoản thất bại
                $error = "Có lỗi xảy ra khi tạo tài khoản. Vui lòng thử lại.";
                require_once __DIR__ . '/../views/pages/register.php';
                exit();
            }
        }
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION['customer_id']);
        unset($_SESSION['customer_name']);
        unset($_SESSION['customer_email']);
        unset($_SESSION['customer_phone']);
        // Xóa giỏ hàng session khi logout
        $sessionCartModel = new SessionCartModel();
        $sessionCartModel->clearCart();
        header('Location: /websitePS/public/');
        exit();
    }
}