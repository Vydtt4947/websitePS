<?php
// File: app/controllers/CheckoutController.php

require_once __DIR__ . '/../models/OrderModel.php';

class CheckoutController {

    public function index() {
        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            header('Location: /websitePS/public/');
            exit();
        }
        require_once __DIR__ . '/../views/pages/checkout.php';
    }

    public function placeOrder() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cart = $_SESSION['cart'] ?? [];
            if (empty($cart)) {
                header('Location: /websitePS/public/');
                exit();
            }

            $total = 0;
            foreach($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            $customerData = [
                'fullname' => $_POST['fullname'],
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
                'address' => $_POST['address']
            ];

            $orderModel = new OrderModel();
            $orderId = $orderModel->createOrder($customerData, $cart, $total);

            if ($orderId) {
                unset($_SESSION['cart']);
                header('Location: /websitePS/public/checkout/thankyou/' . $orderId);
                exit();
            } else {
                echo "Đã có lỗi xảy ra khi tạo đơn hàng, vui lòng thử lại.";
            }
        }
    }

    public function thankyou($orderId) {
        require_once __DIR__ . '/../views/pages/thankyou.php';
    }
}