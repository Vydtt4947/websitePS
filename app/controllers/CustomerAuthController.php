<?php
// File: app/controllers/CustomerAuthController.php

// KHÔNG KẾ THỪA TỪ BASECONTROLLER
// require_once __DIR__ . '/BaseController.php'; 
require_once __DIR__ . '/../models/CustomerModel.php';
require_once __DIR__ . '/../models/CartModel.php';

class CustomerAuthController {

    public function login() {
        // Gọi trực tiếp đến file view, không qua renderView
        require_once __DIR__ . '/../views/pages/login.php';
    }

    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $customerModel = new CustomerModel();
            $customer = $customerModel->findByEmail($_POST['email']);

            if ($customer) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['customer_id'] = $customer['MaKH'];
                $_SESSION['customer_name'] = $customer['HoTen'];
                $_SESSION['customer_email'] = $customer['Email'];
                $_SESSION['customer_phone'] = $customer['SoDienThoai'] ?? '';
                
                // Đồng bộ giỏ hàng từ database
                $cartModel = new CartModel();
                $dbCart = $cartModel->getCart($customer['MaKH']);
                
                // Chỉ xử lý session cart nếu nó tồn tại và khác với database cart
                if (!empty($_SESSION['cart'])) {
                    // Nếu có giỏ hàng trong database, chỉ thêm sản phẩm mới từ session
                    if (!empty($dbCart)) {
                        foreach ($_SESSION['cart'] as $productId => $sessionItem) {
                            if (!isset($dbCart[$productId])) {
                                // Chỉ thêm sản phẩm mới từ session vào database
                                $cartModel->addCartItem($customer['MaKH'], $productId, $sessionItem['quantity']);
                            }
                        }
                    } else {
                        // Nếu không có giỏ hàng trong database, lưu toàn bộ session cart
                        $cartModel->saveCart($customer['MaKH'], $_SESSION['cart']);
                    }
                }
                
                // Xóa giỏ hàng session sau khi đã đồng bộ
                unset($_SESSION['cart']);
                
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
            $customerModel = new CustomerModel();
            
            $existingCustomer = $customerModel->findByEmail($_POST['email']);
            if ($existingCustomer) {
                $error = "Email này đã được sử dụng. Vui lòng chọn email khác.";
                require_once __DIR__ . '/../views/pages/register.php';
                exit();
            }

            $customerModel->registerCustomer($_POST);
            
            $customer = $customerModel->findByEmail($_POST['email']);
            if ($customer) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['customer_id'] = $customer['MaKH'];
                $_SESSION['customer_name'] = $customer['HoTen'];
                $_SESSION['customer_email'] = $customer['Email'];
                $_SESSION['customer_phone'] = $customer['SoDienThoai'] ?? '';
                
                // Đồng bộ giỏ hàng từ session vào database cho tài khoản mới
                if (!empty($_SESSION['cart'])) {
                    $cartModel = new CartModel();
                    $cartModel->saveCart($customer['MaKH'], $_SESSION['cart']);
                    unset($_SESSION['cart']);
                }
            }
            header('Location: /websitePS/public/');
            exit();
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
        unset($_SESSION['cart']); // Xóa giỏ hàng session khi logout
        header('Location: /websitePS/public/');
        exit();
    }
}