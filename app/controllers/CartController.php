<?php
// File: app/controllers/CartController.php

require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/CartModel.php';
require_once __DIR__ . '/../models/PromotionModel.php';

class CartController {

    public function index() {
        if (!isset($_SESSION['customer_id'])) {
            header('Location: /websitePS/public/customerauth/login');
            exit();
        }
        
        $cartModel = new CartModel();
        $promotionModel = new PromotionModel();
        $cart = $cartModel->getCart($_SESSION['customer_id']);
        
        // Tính toán tổng tiền và áp dụng ưu đãi
        $total = 0;
        $appliedPromotions = [];
        $totalDiscount = 0;
        
        // Tính tổng tiền và kiểm tra ưu đãi cho từng sản phẩm
        foreach ($cart as $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $total += $itemTotal;
            
            // Kiểm tra ưu đãi cho từng sản phẩm
            if (!empty($item['category'])) {
                // 50% OFF Cupcake
                $cupcakePromotion = $promotionModel->calculateDiscount('flash_sale_cupcake', $itemTotal, $item['category']);
                if ($cupcakePromotion['discount'] > 0) {
                    $appliedPromotions[] = $cupcakePromotion;
                    $totalDiscount += $cupcakePromotion['discount'];
                }
                
                // 25% OFF Bánh Kem
                $cakePromotion = $promotionModel->calculateDiscount('birthday_cake_25', $itemTotal, $item['category']);
                if ($cakePromotion['discount'] > 0) {
                    $appliedPromotions[] = $cakePromotion;
                    $totalDiscount += $cakePromotion['discount'];
                }
            }
        }
        
        // Kiểm tra ưu đãi miễn phí vận chuyển
        $shippingPromotion = $promotionModel->calculateDiscount('free_shipping', $total);
        if ($shippingPromotion['discount'] > 0) {
            $appliedPromotions[] = $shippingPromotion;
            $totalDiscount += $shippingPromotion['discount'];
        }
        
        // Kiểm tra ưu đãi giảm giá 20% cho đơn hàng từ 500k
        $generalPromotion = $promotionModel->calculateDiscount('general_20', $total);
        if ($generalPromotion['discount'] > 0) {
            $appliedPromotions[] = $generalPromotion;
            $totalDiscount += $generalPromotion['discount'];
        }
        
        // Tính phí vận chuyển
        $shippingFee = 0;
        if ($total < 100000) {
            $shippingFee = 15000;
        }
        
        // Áp dụng miễn phí vận chuyển nếu có ưu đãi
        if ($shippingPromotion['discount'] > 0) {
            $shippingFee = 0;
        }
        
        $finalTotal = $total - $totalDiscount + $shippingFee;
        
        require_once __DIR__ . '/../views/pages/cart.php';
    }

    public function add() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['customer_id'])) {
            $_SESSION['error_message'] = 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!';
            header('Location: /websitePS/public/customerauth/login');
            exit();
        }

        // Xử lý cả GET và POST request
        $productId = null;
        $quantity = 1;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['productId'] ?? null;
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
        } else {
            // GET request từ trang danh sách sản phẩm
            $productId = $_GET['productId'] ?? null;
            $quantity = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 1;
        }

        if (!$productId || $quantity <= 0) {
            // Không cho phép thêm số lượng âm hoặc bằng 0
            header('Location: /websitePS/public/products/list');
            exit();
        }

        $cartModel = new CartModel();
        $productModel = new ProductModel();
        $product = $productModel->getProductById($productId);

        if ($product) {
            if ($cartModel->addCartItem($_SESSION['customer_id'], $productId, $quantity)) {
                // Thêm thông báo thành công
                $_SESSION['success_message'] = 'Đã thêm ' . $product['TenSP'] . ' vào giỏ hàng!';
            } else {
                $_SESSION['error_message'] = 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng!';
            }
        }
        
        // Redirect về trang trước đó hoặc giỏ hàng
        $redirectUrl = $_SERVER['HTTP_REFERER'] ?? '/websitePS/public/cart';
        header('Location: ' . $redirectUrl);
        exit();
    }

    public function remove($id) {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['customer_id'])) {
            header('Location: /websitePS/public/customerauth/login');
            exit();
        }

        $cartModel = new CartModel();
        $cartModel->removeCartItem($_SESSION['customer_id'], $id);
        header('Location: /websitePS/public/cart');
        exit();
    }

    public function update($id, $change) {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['customer_id'])) {
            header('Location: /websitePS/public/customerauth/login');
            exit();
        }

        $cartModel = new CartModel();
        
        // Lấy giỏ hàng hiện tại để tính số lượng mới
        $cart = $cartModel->getCart($_SESSION['customer_id']);
        if (isset($cart[$id])) {
            $newQuantity = $cart[$id]['quantity'] + (int)$change;
            $cartModel->updateCartItem($_SESSION['customer_id'], $id, $newQuantity);
        }
        
        header('Location: /websitePS/public/cart');
        exit();
    }
}