<?php
// File: app/controllers/HomeController.php

require_once __DIR__ . '/../models/ProductModel.php';

class HomeController {

    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $productModel = new ProductModel();
        
        // Lấy sản phẩm nổi bật (có thể thêm logic để lấy sản phẩm bán chạy, mới nhất, etc.)
        $products = $productModel->getFeaturedProducts();

        // Gọi view của trang chủ và truyền biến $products sang
        require_once __DIR__ . '/../views/pages/homepage.php';
    }
}