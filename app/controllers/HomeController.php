<?php
// File: app/controllers/HomeController.php

require_once __DIR__ . '/../models/ProductModel.php';

class HomeController {

    public function index() {
        $productModel = new ProductModel();
        
        // Lấy tất cả sản phẩm để hiển thị
        $products = $productModel->getAllProductsWithCategory();

        // Gọi view của trang chủ và truyền biến $products sang
        require_once __DIR__ . '/../views/pages/homepage.php';
    }
}