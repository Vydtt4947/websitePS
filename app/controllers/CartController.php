<?php
// File: app/controllers/CartController.php

require_once __DIR__ . '/../models/ProductModel.php';

class CartController {

    public function index() {
        $cart = $_SESSION['cart'] ?? [];
        require_once __DIR__ . '/../views/pages/cart.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['productId'];
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

            if ($quantity <= 0) {
                // Không cho phép thêm số lượng âm hoặc bằng 0
                header('Location: /websitePS/public/products/show/' . $productId);
                exit();
            }

            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            $productModel = new ProductModel();
            $product = $productModel->getProductById($productId);

            if ($product) {
                if (isset($_SESSION['cart'][$productId])) {
                    $_SESSION['cart'][$productId]['quantity'] += $quantity;
                } else {
                    $_SESSION['cart'][$productId] = [
                        'name' => $product['TenSP'],
                        'price' => $product['DonGia'],
                        'quantity' => $quantity,
                        'image' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?q=80&w=1987&auto=format&fit=crop' // Ảnh mẫu
                    ];
                }
            }
            header('Location: /websitePS/public/cart');
            exit();
        }
    }

    public function remove($id) {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        header('Location: /websitePS/public/cart');
        exit();
    }
}