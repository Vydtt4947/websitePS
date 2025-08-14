<?php
// File: app/controllers/CheckoutController.php

require_once __DIR__ . '/../models/OrderModel.php';
require_once __DIR__ . '/../models/CartModel.php';
require_once __DIR__ . '/../models/PromotionModel.php';

class CheckoutController {

    public function index() {
        if (!isset($_SESSION['customer_id'])) {
            header('Location: /websitePS/public/customerauth/login');
            exit();
        }
        
        $cartModel = new CartModel();
        $promotionModel = new PromotionModel();
        $cart = $cartModel->getCart($_SESSION['customer_id']);
        
        if (empty($cart)) {
            header('Location: /websitePS/public/');
            exit();
        }
        
        // Tính toán tổng tiền và áp dụng ưu đãi (giống như CartController)
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
        
        // Lấy thông tin customer để hiển thị thông tin giao hàng đã lưu
        require_once __DIR__ . '/../models/CustomerModel.php';
        $customerModel = new CustomerModel();
        $customer = $customerModel->getCustomerById($_SESSION['customer_id']);
        
        require_once __DIR__ . '/../views/pages/checkout.php';
    }

    public function placeOrder() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['customer_id'])) {
                header('Location: /websitePS/public/customerauth/login');
                exit();
            }
            
            $cartModel = new CartModel();
            $promotionModel = new PromotionModel();
            $cart = $cartModel->getCart($_SESSION['customer_id']);
            
            if (empty($cart)) {
                header('Location: /websitePS/public/');
                exit();
            }

            // Tính toán tổng tiền và áp dụng ưu đãi (giống như CartController)
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
            
            $totalWithShipping = $total - $totalDiscount + $shippingFee;

            // Xử lý thông tin giao hàng
            if (isset($_POST['useSavedAddress']) && $_POST['useSavedAddress'] == '1') {
                // Sử dụng địa chỉ đã lưu
                $addressParts = [];
                if (!empty($_POST['savedAddress'])) {
                    $addressParts[] = $_POST['savedAddress'];
                }
                if (!empty($_POST['savedQuanHuyen'])) {
                    $addressParts[] = $_POST['savedQuanHuyen'];
                }
                if (!empty($_POST['savedTinhThanh'])) {
                    $addressParts[] = $_POST['savedTinhThanh'];
                }
                
                $customerData = [
                    'fullname' => $_SESSION['customer_name'],
                    'phone' => $_SESSION['customer_phone'] ?? '',
                    'email' => $_SESSION['customer_email'],
                    'address' => implode(', ', $addressParts),
                    'note' => $_POST['savedGhiChu'] ?? ''
                ];
            } else {
                // Sử dụng địa chỉ mới nhập
                $customerData = [
                    'fullname' => $_POST['fullname'],
                    'phone' => $_POST['phone'],
                    'email' => $_POST['email'],
                    'address' => $_POST['address'],
                    'note' => $_POST['note'] ?? ''
                ];
            }

            try {
                // Get payment method
                $paymentMethod = $_POST['payment_method'] ?? 'cod';
                
                // Debug logging
                error_log("Checkout data: " . print_r($customerData, true));
                error_log("Cart data: " . print_r($cart, true));
                error_log("Total: " . $total);
                error_log("Shipping fee: " . $shippingFee);
                error_log("Total with shipping: " . $totalWithShipping);
                error_log("Payment method: " . $paymentMethod);
                
                $orderModel = new OrderModel();
                $orderId = $orderModel->createOrder($customerData, $cart, $totalWithShipping, $paymentMethod, $appliedPromotions);

                if ($orderId) {
                    // Xóa giỏ hàng sau khi đặt hàng thành công
                    $cartModel->clearCart($_SESSION['customer_id']);
                    header('Location: /websitePS/public/checkout/thankyou/' . $orderId);
                    exit();
                } else {
                    error_log("Order creation failed - no order ID returned");
                    $_SESSION['error_message'] = "Đã có lỗi xảy ra khi tạo đơn hàng, vui lòng thử lại.";
                    header('Location: /websitePS/public/checkout');
                    exit();
                }
            } catch (Exception $e) {
                error_log("Checkout error: " . $e->getMessage());
                error_log("Checkout error trace: " . $e->getTraceAsString());
                $_SESSION['error_message'] = "Đã có lỗi xảy ra khi tạo đơn hàng: " . $e->getMessage();
                header('Location: /websitePS/public/checkout');
                exit();
            }
        }
    }

    public function thankyou($orderId) {
        // Lấy thông tin đơn hàng để hiển thị
        try {
            $orderModel = new OrderModel();
            $orderDetails = $orderModel->getOrderDetailsById($orderId);
            
            if ($orderDetails && $orderDetails['info']['MaKH'] == $_SESSION['customer_id']) {
                require_once __DIR__ . '/../views/pages/thankyou.php';
            } else {
                header('Location: /websitePS/public/');
                exit();
            }
        } catch (Exception $e) {
            error_log("Thankyou page error: " . $e->getMessage());
            header('Location: /websitePS/public/');
            exit();
        }
    }
}