<?php
// File: app/controllers/AccountController.php

require_once __DIR__ . '/../models/CustomerModel.php';

class AccountController {

    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['customer_id'])) {
            header('Location: /websitePS/public/customerauth/login');
            exit();
        }
        
        $customerModel = new CustomerModel();
        $customer = $customerModel->getCustomerById($_SESSION['customer_id']);
        $orderHistory = $customerModel->getOrderHistoryByCustomerId($_SESSION['customer_id']);
        $tierInfo = $customerModel->getCustomerTierInfo($_SESSION['customer_id']);
        $tierChangeNotification = $customerModel->getTierChangeNotification();
        $activeTab = 'history'; // Đánh dấu tab đang hoạt động
        
        require_once __DIR__ . '/../views/pages/account.php';
    }

    public function profile() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['customer_id'])) {
            header('Location: /websitePS/public/customerauth/login');
            exit();
        }
        
        $customerModel = new CustomerModel();
        $customer = $customerModel->getCustomerById($_SESSION['customer_id']);
        $tierInfo = $customerModel->getCustomerTierInfo($_SESSION['customer_id']);
        $tierChangeNotification = $customerModel->getTierChangeNotification();
        $activeTab = 'profile'; // Đánh dấu tab đang hoạt động
        
        require_once __DIR__ . '/../views/pages/account_profile.php';
    }

    public function updateProfile() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['customer_id'])) {
            header('Location: /websitePS/public/customerauth/login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $customerModel = new CustomerModel();
            $customerModel->updateProfile($_SESSION['customer_id'], $_POST);

            // Cập nhật lại tên trong session
            $_SESSION['customer_name'] = $_POST['HoTen'];
            
            $_SESSION['success_message'] = 'Cập nhật thông tin thành công!';
            header('Location: /websitePS/public/account/profile');
            exit();
        }
    }
}
