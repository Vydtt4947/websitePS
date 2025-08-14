<?php
// File: app/models/CartModel.php
require_once __DIR__ . '/../../config/database.php';

class CartModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    // Lưu giỏ hàng vào database
    public function saveCart($customerId, $cart) {
        try {
            // Xóa giỏ hàng cũ của khách hàng
            $this->clearCart($customerId);
            
            if (empty($cart)) {
                return true;
            }

            // Thêm từng sản phẩm vào giỏ hàng
            foreach ($cart as $productId => $item) {
                $query = "INSERT INTO giohang (MaKH, MaSP, SoLuong, NgayThem) VALUES (:maKH, :maSP, :soLuong, NOW())";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':maKH', $customerId, PDO::PARAM_INT);
                $stmt->bindParam(':maSP', $productId, PDO::PARAM_INT);
                $stmt->bindParam(':soLuong', $item['quantity'], PDO::PARAM_INT);
                $stmt->execute();
            }
            
            return true;
        } catch (Exception $e) {
            error_log("Error saving cart: " . $e->getMessage());
            return false;
        }
    }

    // Lấy giỏ hàng từ database
    public function getCart($customerId) {
        try {
            $query = "SELECT gh.MaSP, gh.SoLuong, sp.TenSP, sp.DonGia, dm.TenDanhMuc 
                      FROM giohang gh 
                      INNER JOIN sanpham sp ON gh.MaSP = sp.MaSP 
                      LEFT JOIN danhmuc dm ON sp.MaDM = dm.MaDM 
                      WHERE gh.MaKH = :maKH";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':maKH', $customerId, PDO::PARAM_INT);
            $stmt->execute();
            
            $cart = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $cart[$row['MaSP']] = [
                    'name' => $row['TenSP'],
                    'price' => $row['DonGia'],
                    'quantity' => $row['SoLuong'],
                    'category' => $row['TenDanhMuc'] ?? 'Chưa phân loại',
                    'image' => $this->getProductImage($row['TenSP'])
                ];
            }
            
            return $cart;
        } catch (Exception $e) {
            error_log("Error getting cart: " . $e->getMessage());
            return [];
        }
    }

    // Hàm để lấy ảnh cho từng sản phẩm
    private function getProductImage($productName) {
        $productName = strtolower(trim($productName));
        
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

    // Xóa giỏ hàng của khách hàng
    public function clearCart($customerId) {
        try {
            $query = "DELETE FROM giohang WHERE MaKH = :maKH";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':maKH', $customerId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            error_log("Error clearing cart: " . $e->getMessage());
            return false;
        }
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateCartItem($customerId, $productId, $quantity) {
        try {
            if ($quantity <= 0) {
                // Xóa sản phẩm nếu số lượng <= 0
                $query = "DELETE FROM giohang WHERE MaKH = :maKH AND MaSP = :maSP";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':maKH', $customerId, PDO::PARAM_INT);
                $stmt->bindParam(':maSP', $productId, PDO::PARAM_INT);
                $stmt->execute();
            } else {
                // Cập nhật số lượng
                $query = "UPDATE giohang SET SoLuong = :soLuong WHERE MaKH = :maKH AND MaSP = :maSP";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':soLuong', $quantity, PDO::PARAM_INT);
                $stmt->bindParam(':maKH', $customerId, PDO::PARAM_INT);
                $stmt->bindParam(':maSP', $productId, PDO::PARAM_INT);
                $stmt->execute();
            }
            return true;
        } catch (Exception $e) {
            error_log("Error updating cart item: " . $e->getMessage());
            return false;
        }
    }

    // Xóa một sản phẩm khỏi giỏ hàng
    public function removeCartItem($customerId, $productId) {
        try {
            $query = "DELETE FROM giohang WHERE MaKH = :maKH AND MaSP = :maSP";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':maKH', $customerId, PDO::PARAM_INT);
            $stmt->bindParam(':maSP', $productId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            error_log("Error removing cart item: " . $e->getMessage());
            return false;
        }
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addCartItem($customerId, $productId, $quantity) {
        try {
            // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
            $query = "SELECT SoLuong FROM giohang WHERE MaKH = :maKH AND MaSP = :maSP";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':maKH', $customerId, PDO::PARAM_INT);
            $stmt->bindParam(':maSP', $productId, PDO::PARAM_INT);
            $stmt->execute();
            
            $existingItem = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($existingItem) {
                // Cập nhật số lượng
                $newQuantity = $existingItem['SoLuong'] + $quantity;
                return $this->updateCartItem($customerId, $productId, $newQuantity);
            } else {
                // Thêm mới
                $query = "INSERT INTO giohang (MaKH, MaSP, SoLuong, NgayThem) VALUES (:maKH, :maSP, :soLuong, NOW())";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':maKH', $customerId, PDO::PARAM_INT);
                $stmt->bindParam(':maSP', $productId, PDO::PARAM_INT);
                $stmt->bindParam(':soLuong', $quantity, PDO::PARAM_INT);
                $stmt->execute();
                return true;
            }
        } catch (Exception $e) {
            error_log("Error adding cart item: " . $e->getMessage());
            return false;
        }
    }
}
?>
