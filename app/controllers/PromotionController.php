<?php
// File: app/controllers/PromotionController.php

require_once __DIR__ . '/../models/KhuyenMaiModel.php';
require_once __DIR__ . '/../models/PromotionModel.php';
require_once __DIR__ . '/../models/CustomerModel.php';

class PromotionController {

    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Lấy dữ liệu khuyến mãi từ database
        $khuyenMaiModel = new KhuyenMaiModel();
        
        try {
            // Test kết nối database trước
            $connectionTest = $khuyenMaiModel->testConnection();
            error_log("Test kết nối database: " . print_r($connectionTest, true));
            
            if (!$connectionTest['success']) {
                error_log("Lỗi kết nối database: " . $connectionTest['error']);
                $promotions = [];
            } else {
                // Lấy tất cả khuyến mãi
                $allPromotions = $khuyenMaiModel->getAll();
                error_log("Tổng số khuyến mãi từ database: " . count($allPromotions));
                
                if (!empty($allPromotions)) {
                    error_log("Khuyến mãi đầu tiên: " . print_r($allPromotions[0], true));
                }
                
                // Lọc khuyến mãi còn hiệu lực (chưa hết hạn) - nới lỏng điều kiện
                $currentDate = date('Y-m-d');
                $activePromotions = array_filter($allPromotions, function($promo) use ($currentDate) {
                    // Kiểm tra nếu có ngày kết thúc
                    if (isset($promo['NgayKetThuc']) && $promo['NgayKetThuc']) {
                        return $promo['NgayKetThuc'] >= $currentDate;
                    }
                    // Nếu không có ngày kết thúc, coi như còn hiệu lực
                    return true;
                });
                
                // Debug: Kiểm tra sau khi lọc
                error_log("Số khuyến mãi sau khi lọc: " . count($activePromotions));
                
                // Truyền dữ liệu vào view
                $promotions = $activePromotions;
                
                // Debug: Kiểm tra biến cuối cùng
                error_log("Biến promotions cuối cùng: " . count($promotions));
            }
            
        } catch (Exception $e) {
            error_log("Lỗi khi lấy dữ liệu khuyến mãi: " . $e->getMessage());
            $promotions = [];
        }
        
        require_once __DIR__ . '/../views/pages/promotion.php';
    }

    // Phương thức test để debug database
    public function test() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        echo "<h1>Test Database Connection</h1>";
        
        try {
            $khuyenMaiModel = new KhuyenMaiModel();
            
            // Test kết nối
            echo "<h2>1. Test Connection</h2>";
            $connectionTest = $khuyenMaiModel->testConnection();
            echo "<pre>" . print_r($connectionTest, true) . "</pre>";
            
            if ($connectionTest['success']) {
                // Test lấy dữ liệu
                echo "<h2>2. Test Get All Data</h2>";
                $allPromotions = $khuyenMaiModel->getAll();
                echo "<p>Tổng số khuyến mãi: " . count($allPromotions) . "</p>";
                
                if (!empty($allPromotions)) {
                    echo "<h3>Dữ liệu khuyến mãi:</h3>";
                    echo "<pre>" . print_r($allPromotions, true) . "</pre>";
                    
                    // Test lọc dữ liệu
                    echo "<h2>3. Test Filter Active Promotions</h2>";
                    $currentDate = date('Y-m-d');
                    echo "<p>Ngày hiện tại: " . $currentDate . "</p>";
                    
                    $activePromotions = array_filter($allPromotions, function($promo) use ($currentDate) {
                        if (isset($promo['NgayKetThuc']) && $promo['NgayKetThuc']) {
                            return $promo['NgayKetThuc'] >= $currentDate;
                        }
                        return true;
                    });
                    
                    echo "<p>Số khuyến mãi còn hiệu lực: " . count($activePromotions) . "</p>";
                    echo "<pre>" . print_r($activePromotions, true) . "</pre>";
                }
            }
            
        } catch (Exception $e) {
            echo "<h2>Error:</h2>";
            echo "<p>" . $e->getMessage() . "</p>";
            echo "<pre>" . $e->getTraceAsString() . "</pre>";
        }
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
