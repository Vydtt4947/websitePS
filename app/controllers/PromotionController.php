<?php
// File: app/controllers/PromotionController.php

require_once __DIR__ . '/../models/PromotionModel.php';
require_once __DIR__ . '/../models/CustomerModel.php';

class PromotionController {

    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        require_once __DIR__ . '/../views/pages/promotion.php';
    }

    public function tierBenefits() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $promotionModel = new PromotionModel();
        $customerModel = new CustomerModel();
        
        // Lấy thông tin phân khúc của khách hàng hiện tại
        $customerTierInfo = null;
        if (isset($_SESSION['customer_id'])) {
            $customerTierInfo = $customerModel->getCustomerTierInfo($_SESSION['customer_id']);
        }
        
        require_once __DIR__ . '/../views/pages/tier_benefits.php';
    }


}
?>
