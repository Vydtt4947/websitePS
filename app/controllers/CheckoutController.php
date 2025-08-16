<?php
// File: app/controllers/CheckoutController.php

require_once __DIR__ . '/../models/OrderModel.php';
require_once __DIR__ . '/../models/CartModel.php';
require_once __DIR__ . '/../models/SessionCartModel.php';
require_once __DIR__ . '/../models/PromotionModel.php';

class CheckoutController {

    public function index() {
        // Không cần kiểm tra đăng nhập - cho phép khách vãng lai checkout
        
        $cartModel = new CartModel();
        $sessionCartModel = new SessionCartModel();
        $promotionModel = new PromotionModel();
        
        // Lấy giỏ hàng dựa trên trạng thái đăng nhập
        if (isset($_SESSION['customer_id'])) {
            $cart = $cartModel->getCart($_SESSION['customer_id']);
        } else {
            $cart = $sessionCartModel->getCart();
        }
        
        if (empty($cart)) {
            header('Location: /websitePS/public/');
            exit();
        }
        
        // Tính toán tổng tiền
        $total = 0;
        $productCategories = [];
        
        foreach ($cart as $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $total += $itemTotal;
            
            // Thu thập danh mục sản phẩm để kiểm tra ưu đãi
            if (!empty($item['category'])) {
                $productCategories[] = $item['category'];
            }
        }
        
        // Lấy ưu đãi được chọn từ session
        $selectedPromotions = isset($_SESSION['selected_promotions']) ? $_SESSION['selected_promotions'] : [];
        
        // Chỉ tính ưu đãi cho khách hàng đã đăng nhập
        $appliedPromotions = [];
        $totalDiscount = 0;
        $finalTotal = $total;
        
        if (isset($_SESSION['customer_id'])) {
            // Sử dụng logic ưu đãi mới với lựa chọn của khách hàng
            $discountResult = $promotionModel->calculateAllDiscounts($_SESSION['customer_id'], $total, implode(',', $productCategories), $selectedPromotions);
            
            $appliedPromotions = array_filter($discountResult['promotions'], function($promotion) {
                return isset($promotion['isSelected']) && $promotion['isSelected'];
            });
            $totalDiscount = $discountResult['totalDiscount'];
            $finalTotal = $discountResult['finalTotal'];
        }
        
        // Tính phí vận chuyển - chỉ tính khi có sản phẩm trong giỏ hàng
        $shippingFee = 0;
        if (!empty($cart) && $total < 100000) {
            $shippingFee = 15000;
        }
        
        // Kiểm tra xem có ưu đãi miễn phí vận chuyển không
        foreach ($appliedPromotions as $promotion) {
            if ($promotion['promotionType'] === 'free_shipping') {
                $shippingFee = 0;
                break;
            }
        }
        
        $finalTotal += $shippingFee;
        
        // Lấy thông tin khách hàng để hiển thị địa chỉ đã lưu (chỉ khi đã đăng nhập)
        if (isset($_SESSION['customer_id'])) {
            require_once __DIR__ . '/../models/CustomerModel.php';
            $customerModel = new CustomerModel();
            $customer = $customerModel->getCustomerById($_SESSION['customer_id']);
            
            // Set session variables for customer info
            $_SESSION['customer_name'] = $customer['HoTen'] ?? '';
            $_SESSION['customer_email'] = $customer['Email'] ?? '';
            $_SESSION['customer_phone'] = $customer['SoDienThoai'] ?? '';
            $_SESSION['customer_address'] = $customer['DiaChiGiaoHang'] ?? '';
        } else {
            // Khách vãng lai - không có thông tin đã lưu
            $_SESSION['customer_name'] = '';
            $_SESSION['customer_email'] = '';
            $_SESSION['customer_phone'] = '';
            $_SESSION['customer_address'] = '';
        }
        
        require_once __DIR__ . '/../views/pages/checkout.php';
    }

    public function process() {
        // Không cần kiểm tra đăng nhập - cho phép khách vãng lai đặt hàng

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /websitePS/public/cart');
            exit();
        }

        $cartModel = new CartModel();
        $sessionCartModel = new SessionCartModel();
        $orderModel = new OrderModel();
        $promotionModel = new PromotionModel();
        
        // Lấy giỏ hàng dựa trên trạng thái đăng nhập
        if (isset($_SESSION['customer_id'])) {
            $cart = $cartModel->getCart($_SESSION['customer_id']);
        } else {
            $cart = $sessionCartModel->getCart();
        }
        
        if (empty($cart)) {
            header('Location: /websitePS/public/');
            exit();
        }

        // Tính toán tổng tiền
        $total = 0;
        $productCategories = [];
        
        foreach ($cart as $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $total += $itemTotal;
            
            // Thu thập danh mục sản phẩm để kiểm tra ưu đãi
            if (!empty($item['category'])) {
                $productCategories[] = $item['category'];
            }
        }
        
        // Lấy ưu đãi được chọn từ session
        $selectedPromotions = isset($_SESSION['selected_promotions']) ? $_SESSION['selected_promotions'] : [];
        
        // Chỉ tính ưu đãi cho khách hàng đã đăng nhập
        $appliedPromotions = [];
        $totalDiscount = 0;
        $finalTotal = $total;
        
        if (isset($_SESSION['customer_id'])) {
            // Sử dụng logic ưu đãi mới với lựa chọn của khách hàng
            $discountResult = $promotionModel->calculateAllDiscounts($_SESSION['customer_id'], $total, implode(',', $productCategories), $selectedPromotions);
            
            $appliedPromotions = array_filter($discountResult['promotions'], function($promotion) {
                return isset($promotion['isSelected']) && $promotion['isSelected'];
            });
            $totalDiscount = $discountResult['totalDiscount'];
            $finalTotal = $discountResult['finalTotal'];
        }
        
        // Tính phí vận chuyển - chỉ tính khi có sản phẩm trong giỏ hàng
        $shippingFee = 0;
        if (!empty($cart) && $total < 100000) {
            $shippingFee = 15000;
        }
        
        // Kiểm tra xem có ưu đãi miễn phí vận chuyển không
        foreach ($appliedPromotions as $promotion) {
            if ($promotion['promotionType'] === 'free_shipping') {
                $shippingFee = 0;
                break;
            }
        }
        
        $finalTotal += $shippingFee;

        // Lấy thông tin khách hàng
        $useSavedAddress = $_POST['useSavedAddress'] ?? '0';
        
        if ($useSavedAddress === '1' && isset($_SESSION['customer_id'])) {
            // Sử dụng địa chỉ đã lưu (chỉ cho khách hàng đã đăng nhập)
            $customerData = [
                'fullname' => $_SESSION['customer_name'] ?? '',
                'email' => $_SESSION['customer_email'] ?? '',
                'phone' => $_SESSION['customer_phone'] ?? '',
                'address' => $_POST['savedAddress'] ?? ''
            ];
        } else {
            // Sử dụng địa chỉ mới
            $customerData = [
                'fullname' => $_POST['fullname'] ?? '',
                'email' => $_POST['email'] ?? '',
                'phone' => $_POST['phone'] ?? '',
                'address' => $_POST['address'] ?? ''
            ];
        }

        $paymentMethod = $_POST['payment_method'] ?? 'cod';

        // Tạo đơn hàng
        $orderId = $orderModel->createOrder($customerData, $cart, $finalTotal, $paymentMethod, $appliedPromotions);

        if ($orderId) {
            // Xóa giỏ hàng sau khi đặt hàng thành công
            if (isset($_SESSION['customer_id'])) {
                $cartModel->clearCart($_SESSION['customer_id']);
            } else {
                $sessionCartModel->clearCart();
            }
            
            // Xóa selected promotions sau khi đặt hàng thành công
            unset($_SESSION['selected_promotions']);
            
            // Lưu thông tin đơn hàng vừa đặt vào session cho khách vãng lai
            if (!isset($_SESSION['customer_id'])) {
                $_SESSION['recent_order_id'] = $orderId;
                $_SESSION['recent_order_time'] = time();
            }
            
            // Redirect đến trang thank you với order_id
            header('Location: /websitePS/public/checkout/thankyou?order_id=' . $orderId);
        } else {
            $_SESSION['error_message'] = 'Có lỗi xảy ra khi đặt hàng!';
            header('Location: /websitePS/public/checkout');
        }
        exit();
    }

    /**
     * Method tương thích ngược cho placeOrder
     * Chuyển hướng đến process để tránh lỗi 404
     */
    public function placeOrder() {
        // Chuyển hướng đến method process
        $this->process();
    }

    /**
     * Trang cảm ơn sau khi đặt hàng thành công
     */
    public function thankyou() {
        // Không cần kiểm tra đăng nhập - cho phép khách vãng lai xem trang cảm ơn

        // Lấy thông tin đơn hàng vừa đặt (nếu có)
        $orderId = $_GET['order_id'] ?? null;
        
        if ($orderId) {
            $orderModel = new OrderModel();
            $orderDetails = $orderModel->getOrderDetailsById($orderId);
            
            // Cho phép xem đơn hàng nếu đã đăng nhập hoặc là khách vãng lai
            if ($orderDetails) {
                if (isset($_SESSION['customer_id'])) {
                    // Khách hàng đã đăng nhập - kiểm tra quyền sở hữu
                    if ($orderDetails['info']['MaKH'] == $_SESSION['customer_id']) {
                        require_once __DIR__ . '/../views/pages/thankyou.php';
                        return;
                    }
                } else {
                    // Khách vãng lai - cho phép xem đơn hàng vừa đặt
                    // Kiểm tra xem đơn hàng có phải là đơn hàng vừa đặt không
                    if (isset($_SESSION['recent_order_id']) && 
                        $_SESSION['recent_order_id'] == $orderId &&
                        isset($_SESSION['recent_order_time']) &&
                        (time() - $_SESSION['recent_order_time']) <= 1800) { // 30 phút
                        
                        // Xóa thông tin đơn hàng vừa đặt khỏi session sau khi xem
                        unset($_SESSION['recent_order_id']);
                        unset($_SESSION['recent_order_time']);
                        
                        require_once __DIR__ . '/../views/pages/thankyou.php';
                        return;
                    }
                }
            }
        }
        
        // Nếu không có order_id hoặc không tìm thấy đơn hàng
        header('Location: /websitePS/public/');
        exit();
    }
}
?>