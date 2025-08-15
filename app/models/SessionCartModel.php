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
        unset($_SESSION['guest_cart']);
        return true;
    }

    // Lưu giỏ hàng session vào database (khi khách hàng đăng nhập)
    public function saveToDatabase($customerId) {
        if (!isset($_SESSION['guest_cart']) || empty($_SESSION['guest_cart'])) {
            return true;
        }

        try {
            $cartModel = new CartModel();
            $result = $cartModel->saveCart($customerId, $_SESSION['guest_cart']);
            
            if ($result) {
                // Xóa giỏ hàng session sau khi lưu thành công
                unset($_SESSION['guest_cart']);
            }
            
            return $result;
        } catch (Exception $e) {
            error_log("Error saving session cart to database: " . $e->getMessage());
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
