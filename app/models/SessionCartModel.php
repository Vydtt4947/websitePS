<?php
// File: app/models/SessionCartModel.php
require_once __DIR__ . '/ProductModel.php';

class SessionCartModel {
    
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Lấy giỏ hàng từ session
    public function getCart() {
        return isset($_SESSION['guest_cart']) ? $_SESSION['guest_cart'] : [];
    }

    // Thêm sản phẩm vào giỏ hàng session
    public function addCartItem($productId, $quantity) {
        try {
            $productModel = new ProductModel();
            $product = $productModel->getProductById($productId);
            
            if (!$product) {
                return false;
            }

            if (!isset($_SESSION['guest_cart'])) {
                $_SESSION['guest_cart'] = [];
            }

            // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
            if (isset($_SESSION['guest_cart'][$productId])) {
                $_SESSION['guest_cart'][$productId]['quantity'] += $quantity;
            } else {
                $_SESSION['guest_cart'][$productId] = [
                    'name' => $product['TenSP'],
                    'price' => $product['DonGia'],
                    'quantity' => $quantity,
                    'category' => $product['TenDanhMuc'] ?? 'Chưa phân loại',
                    'image' => $this->getProductImage($product)
                ];
            }

            return true;
        } catch (Exception $e) {
            error_log("Error adding item to session cart: " . $e->getMessage());
            return false;
        }
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng session
    public function updateCartItem($productId, $quantity) {
        if (!isset($_SESSION['guest_cart'])) {
            return false;
        }

        if ($quantity <= 0) {
            // Xóa sản phẩm nếu số lượng <= 0
            unset($_SESSION['guest_cart'][$productId]);
        } else {
            // Cập nhật số lượng
            if (isset($_SESSION['guest_cart'][$productId])) {
                $_SESSION['guest_cart'][$productId]['quantity'] = $quantity;
            }
        }

        return true;
    }

    // Xóa một sản phẩm khỏi giỏ hàng session
    public function removeCartItem($productId) {
        if (isset($_SESSION['guest_cart'][$productId])) {
            unset($_SESSION['guest_cart'][$productId]);
            return true;
        }
        return false;
    }

    // Xóa toàn bộ giỏ hàng session
    public function clearCart() {
        try {
            // Xóa biến session
            unset($_SESSION['guest_cart']);
            
            // Đảm bảo session được lưu
            if (session_status() === PHP_SESSION_ACTIVE) {
                session_write_close();
                session_start();
            }
            
            // Kiểm tra xem đã xóa thành công chưa
            $remainingCart = $this->getCart();
            if (!empty($remainingCart)) {
                error_log("WARNING: Session cart still contains items after clear: " . json_encode($remainingCart));
                // Force clear bằng cách unset trực tiếp
                unset($_SESSION['guest_cart']);
                return false;
            }
            
            error_log("Session cart cleared successfully");
            return true;
        } catch (Exception $e) {
            error_log("Error clearing session cart: " . $e->getMessage());
            return false;
        }
    }

    // Force xóa giỏ hàng session (dùng khi clearCart() thất bại)
    public function forceClearCart() {
        try {
            // Xóa tất cả các biến session liên quan đến giỏ hàng
            unset($_SESSION['guest_cart']);
            unset($_SESSION['cart_count']);
            unset($_SESSION['cart_total']);
            
            // Xóa các biến session khác có thể liên quan
            $sessionKeys = array_keys($_SESSION);
            foreach ($sessionKeys as $key) {
                if (strpos($key, 'cart') !== false || strpos($key, 'guest') !== false) {
                    unset($_SESSION[$key]);
                }
            }
            
            // Đảm bảo session được lưu
            if (session_status() === PHP_SESSION_ACTIVE) {
                session_write_close();
                session_start();
            }
            
            // Kiểm tra kết quả
            $remainingCart = $this->getCart();
            if (empty($remainingCart)) {
                error_log("Session cart force cleared successfully");
                return true;
            } else {
                error_log("ERROR: Session cart still contains items after force clear: " . json_encode($remainingCart));
                return false;
            }
        } catch (Exception $e) {
            error_log("Error force clearing session cart: " . $e->getMessage());
            return false;
        }
    }

    // Xóa hoàn toàn session cart (nuclear option)
    public function nuclearClearCart() {
        try {
            // Xóa tất cả session
            session_destroy();
            
            // Khởi tạo session mới
            session_start();
            
            // Đảm bảo không có session cart
            if (!isset($_SESSION['guest_cart'])) {
                error_log("Session cart nuclear cleared successfully");
                return true;
            } else {
                error_log("ERROR: Session cart still exists after nuclear clear");
                return false;
            }
        } catch (Exception $e) {
            error_log("Error nuclear clearing session cart: " . $e->getMessage());
            return false;
        }
    }

    // Kiểm tra và xóa session cart một cách triệt để
    public function ensureCartCleared() {
        $attempts = 0;
        $maxAttempts = 3;
        
        while ($attempts < $maxAttempts) {
            $attempts++;
            error_log("Attempt $attempts to clear session cart");
            
            // Thử clear thường
            if ($this->clearCart()) {
                error_log("Session cart cleared successfully on attempt $attempts");
                return true;
            }
            
            // Thử force clear
            if ($this->forceClearCart()) {
                error_log("Session cart force cleared successfully on attempt $attempts");
                return true;
            }
            
            // Nếu vẫn còn, đợi một chút rồi thử lại
            if ($attempts < $maxAttempts) {
                usleep(100000); // 0.1 giây
                error_log("Waiting before retry...");
            }
        }
        
        // Nếu tất cả đều thất bại, dùng nuclear option
        error_log("All clear attempts failed, using nuclear option");
        return $this->nuclearClearCart();
    }

    // Lưu giỏ hàng session vào database (khi khách hàng đăng nhập) - ĐÃ CẢI THIỆN
    public function saveToDatabase($customerId, $mergeStrategy = 'smart') {
        if (!isset($_SESSION['guest_cart']) || empty($_SESSION['guest_cart'])) {
            error_log("No session cart to save for customer ID: $customerId");
            return true;
        }

        try {
            error_log("Saving session cart to database for customer ID: $customerId with strategy: $mergeStrategy");
            error_log("Session cart items: " . json_encode($_SESSION['guest_cart']));
            
            $cartModel = new CartModel();
            
            // Sử dụng strategy phù hợp để tránh conflict
            $result = $cartModel->saveCart($customerId, $_SESSION['guest_cart'], $mergeStrategy);
            
            if ($result) {
                error_log("Session cart saved to database successfully");
                // Xóa giỏ hàng session sau khi lưu thành công
                $this->ensureCartCleared();
            } else {
                error_log("ERROR: Failed to save session cart to database");
            }
            
            return $result;
        } catch (Exception $e) {
            error_log("Error saving session cart to database: " . $e->getMessage());
            return false;
        }
    }
    
    // Method mới: Lưu giỏ hàng session với logic thông minh
    public function saveToDatabaseSmart($customerId) {
        if (!isset($_SESSION['guest_cart']) || empty($_SESSION['guest_cart'])) {
            error_log("No session cart to save for customer ID: $customerId");
            return true;
        }

        try {
            error_log("Smart saving session cart to database for customer ID: $customerId");
            error_log("Session cart items: " . json_encode($_SESSION['guest_cart']));
            
            $cartModel = new CartModel();
            
            // Sử dụng method thông minh để tự động chọn strategy phù hợp
            $result = $cartModel->smartMergeSessionCart($customerId, $_SESSION['guest_cart']);
            
            if ($result) {
                error_log("Session cart smart saved to database successfully");
                // Xóa giỏ hàng session sau khi lưu thành công
                $this->ensureCartCleared();
            } else {
                error_log("ERROR: Failed to smart save session cart to database");
            }
            
            return $result;
        } catch (Exception $e) {
            error_log("Error smart saving session cart to database: " . $e->getMessage());
            return false;
        }
    }

    // Hàm để lấy ảnh cho từng sản phẩm
    private function getProductImage($product) {
        // Ưu tiên sử dụng hình ảnh từ database
        if (!empty($product['HinhAnh'])) {
            return $product['HinhAnh'];
        }
        
        // Fallback: sử dụng tên sản phẩm để tìm hình ảnh mặc định
        $productName = strtolower(trim($product['TenSP']));
        
        // Map ảnh cho từng sản phẩm cụ thể
        $imageMap = [
            'tiramisu' => 'https://images.unsplash.com/photo-1714385905983-6f8e06fffae1?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'sourdough' => 'https://plus.unsplash.com/premium_photo-1664640733898-d5c3f71f44e1?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'chocolate cake' => 'https://images.unsplash.com/photo-1606890737304-57a1ca8a5b62?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8Y2hvY29sYXRlJTIwY2FrZXxlbnwwfHwwfHx8MA%3D%3D',
            'croissant' => 'https://images.unsplash.com/photo-1600521853186-93b88b3a07b0?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTR8fGNyb2lzc2FudHxlbnwwfHwwfHx8MA%3D%3D'
        ];
        
        // Tìm ảnh phù hợp
        foreach ($imageMap as $keyword => $imageUrl) {
            if (strpos($productName, $keyword) !== false) {
                return $imageUrl;
            }
        }
        
        // Ảnh mặc định nếu không tìm thấy
        return 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?q=80&w=1987&auto=format&fit=crop';
    }
}
?>
