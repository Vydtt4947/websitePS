<?php
// File: app/models/CartModel.php
require_once __DIR__ . '/../../config/database.php';

class CartModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    // Lưu giỏ hàng vào database (đã cải thiện để không xóa giỏ hàng cũ)
    public function saveCart($customerId, $cart, $mergeStrategy = 'smart') {
        try {
            if (empty($cart)) {
                return true;
            }

            error_log("saveCart called for customer ID: $customerId with mergeStrategy: $mergeStrategy");
            error_log("Cart items to save: " . json_encode($cart));

            // Lấy giỏ hàng hiện có
            $existingCart = $this->getCart($customerId);
            error_log("Existing cart items: " . json_encode($existingCart));

            // Nếu sử dụng strategy 'replace', xóa toàn bộ giỏ hàng cũ
            if ($mergeStrategy === 'replace') {
                $this->clearCart($customerId);
                error_log("Cleared existing cart due to 'replace' strategy");
            }

            // Xử lý từng sản phẩm theo strategy
            foreach ($cart as $productId => $item) {
                if (isset($existingCart[$productId])) {
                    // Sản phẩm đã có trong database
                    $existingQuantity = $existingCart[$productId]['quantity'];
                    $newQuantity = $item['quantity'];
                    
                    error_log("Product ID $productId: Existing quantity=$existingQuantity, New quantity=$newQuantity");
                    
                    switch ($mergeStrategy) {
                        case 'replace':
                            // Thay thế hoàn toàn
                            $this->updateCartItem($customerId, $productId, $newQuantity);
                            error_log("Replaced quantity: $existingQuantity -> $newQuantity");
                            break;
                            
                        case 'add':
                            // Cộng dồn (không khuyến khích)
                            $finalQuantity = $existingQuantity + $newQuantity;
                            $this->updateCartItem($customerId, $productId, $finalQuantity);
                            error_log("Added quantities: $existingQuantity + $newQuantity = $finalQuantity");
                            break;
                            
                        case 'smart':
                        default:
                            // Logic thông minh: chỉ cập nhật nếu số lượng mới > số lượng cũ
                            if ($newQuantity > $existingQuantity) {
                                $this->updateCartItem($customerId, $productId, $newQuantity);
                                error_log("Updated quantity: $existingQuantity -> $newQuantity (new > existing)");
                            } else {
                                error_log("Kept existing quantity: $existingQuantity (new <= existing)");
                            }
                            break;
                            
                        case 'preserve_existing':
                            // Bảo toàn giỏ hàng hiện có, KHÔNG merge
                            error_log("Preserved existing quantity: $existingQuantity (strategy: preserve_existing)");
                            break;
                            
                        case 'ignore_session':
                            // HOÀN TOÀN bỏ qua session cart
                            error_log("Ignored session cart completely (strategy: ignore_session) - NO CHANGES");
                            break;
                            
                        case 'session_only':
                            // Chỉ sử dụng session cart
                            $this->updateCartItem($customerId, $productId, $newQuantity);
                            error_log("Used session quantity only: $newQuantity (strategy: session_only)");
                            break;
                    }
                } else {
                    // Sản phẩm mới, thêm vào database
                    if ($mergeStrategy === 'ignore_session') {
                        // Với strategy 'ignore_session', KHÔNG thêm sản phẩm mới
                        error_log("Product ID $productId not in database, but using 'ignore_session' strategy - SKIPPING");
                    } else {
                        $query = "INSERT INTO giohang (MaKH, MaSP, SoLuong, NgayThem) VALUES (:maKH, :maSP, :soLuong, NOW())";
                        $stmt = $this->db->prepare($query);
                        $stmt->bindParam(':maKH', $customerId, PDO::PARAM_INT);
                        $stmt->bindParam(':maSP', $productId, PDO::PARAM_INT);
                        $stmt->bindParam(':soLuong', $item['quantity'], PDO::PARAM_INT);
                        $stmt->execute();
                        error_log("Added new product ID $productId with quantity: " . $item['quantity']);
                    }
                }
            }
            
            // Kiểm tra và xử lý trùng lặp sau khi save
            $this->checkAndFixDuplicates($customerId);
            
            error_log("Cart saved successfully for customer ID: $customerId");
            return true;
        } catch (Exception $e) {
            error_log("Error saving cart: " . $e->getMessage());
            return false;
        }
    }

    // Lấy giỏ hàng từ database
    public function getCart($customerId) {
        try {
            $query = "SELECT gh.MaSP, gh.SoLuong, sp.TenSP, sp.DonGia, sp.HinhAnh, dm.TenDanhMuc 
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
                    'image' => $this->getProductImage($row)
                ];
            }
            
            return $cart;
        } catch (Exception $e) {
            error_log("Error getting cart: " . $e->getMessage());
            return [];
        }
    }

    // Hàm để lấy ảnh cho từng sản phẩm
    private function getProductImage($product) {
        // Nếu $product là string (tên sản phẩm), chuyển đổi thành array
        if (is_string($product)) {
            $productName = $product;
            $product = ['TenSP' => $productName, 'HinhAnh' => null];
        }
        
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

    // Thêm sản phẩm vào giỏ hàng (đã cải thiện để không cộng dồn mặc định)
    public function addCartItem($customerId, $productId, $quantity, $mergeStrategy = 'replace') {
        try {
            // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
            $query = "SELECT SoLuong FROM giohang WHERE MaKH = :maKH AND MaSP = :maSP";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':maKH', $customerId, PDO::PARAM_INT);
            $stmt->bindParam(':maSP', $productId, PDO::PARAM_INT);
            $stmt->execute();
            
            $existingItem = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($existingItem) {
                // Sản phẩm đã có trong giỏ hàng
                $existingQuantity = $existingItem['SoLuong'];
                error_log("Product ID $productId already exists with quantity: $existingQuantity, new quantity: $quantity");
                
                switch ($mergeStrategy) {
                    case 'add':
                        // Cộng dồn số lượng (hành vi cũ - không khuyến khích)
                        $newQuantity = $existingQuantity + $quantity;
                        error_log("Adding quantities: $existingQuantity + $quantity = $newQuantity");
                        return $this->updateCartItem($customerId, $productId, $newQuantity);
                        
                    case 'replace':
                    default:
                        // Thay thế số lượng (hành vi mới - khuyến khích)
                        error_log("Replacing quantity: $existingQuantity -> $quantity");
                        return $this->updateCartItem($customerId, $productId, $quantity);
                        
                    case 'smart':
                        // Logic thông minh: chỉ cập nhật nếu số lượng mới > số lượng cũ
                        if ($quantity > $existingQuantity) {
                            error_log("Updating quantity: $existingQuantity -> $quantity (new > existing)");
                            return $this->updateCartItem($customerId, $productId, $quantity);
                        } else {
                            error_log("Keeping existing quantity: $existingQuantity (new <= existing)");
                            return true;
                        }
                        
                    case 'preserve_existing':
                        // Bảo toàn số lượng hiện có
                        error_log("Preserving existing quantity: $existingQuantity");
                        return true;
                }
            } else {
                // Sản phẩm mới, thêm vào database
                $query = "INSERT INTO giohang (MaKH, MaSP, SoLuong, NgayThem) VALUES (:maKH, :maSP, :soLuong, NOW())";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':maKH', $customerId, PDO::PARAM_INT);
                $stmt->bindParam(':maSP', $productId, PDO::PARAM_INT);
                $stmt->bindParam(':soLuong', $quantity, PDO::PARAM_INT);
                $stmt->execute();
                error_log("Added new product ID $productId with quantity: $quantity");
                return true;
            }
        } catch (Exception $e) {
            error_log("Error adding cart item: " . $e->getMessage());
            return false;
        }
    }

    // Kiểm tra và xử lý trùng lặp sản phẩm trong giỏ hàng
    public function checkAndFixDuplicates($customerId) {
        try {
            $query = "SELECT MaSP, COUNT(*) as count, SUM(SoLuong) as total_quantity 
                      FROM giohang 
                      WHERE MaKH = :maKH 
                      GROUP BY MaSP 
                      HAVING COUNT(*) > 1";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':maKH', $customerId, PDO::PARAM_INT);
            $stmt->execute();
            
            $duplicates = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($duplicates as $duplicate) {
                $productId = $duplicate['MaSP'];
                $totalQuantity = $duplicate['total_quantity'];
                
                // Xóa tất cả các bản ghi trùng lặp
                $query = "DELETE FROM giohang WHERE MaKH = :maKH AND MaSP = :maSP";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':maKH', $customerId, PDO::PARAM_INT);
                $stmt->bindParam(':maSP', $productId, PDO::PARAM_INT);
                $stmt->execute();
                
                // Thêm lại một bản ghi duy nhất với tổng số lượng
                $query = "INSERT INTO giohang (MaKH, MaSP, SoLuong, NgayThem) VALUES (:maKH, :maSP, :soLuong, NOW())";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':maKH', $customerId, PDO::PARAM_INT);
                $stmt->bindParam(':maSP', $productId, PDO::PARAM_INT);
                $stmt->bindParam(':soLuong', $totalQuantity, PDO::PARAM_INT);
                $stmt->execute();
            }
            
            return true;
        } catch (Exception $e) {
            error_log("Error checking and fixing duplicates: " . $e->getMessage());
            return false;
        }
    }

    // Merge giỏ hàng session vào database (dành cho việc đăng nhập)
    public function mergeSessionCart($customerId, $sessionCart, $mergeStrategy = 'smart') {
        try {
            if (empty($sessionCart)) {
                return true;
            }

            // Log để debug
            error_log("Merging session cart for customer ID: $customerId with strategy: $mergeStrategy");
            error_log("Session cart items: " . json_encode($sessionCart));

            // Nếu sử dụng strategy 'replace', xóa toàn bộ giỏ hàng cũ trước
            if ($mergeStrategy === 'replace') {
                $this->clearCart($customerId);
                error_log("Cleared existing cart due to 'replace' strategy");
            }

            $dbCart = $this->getCart($customerId);
            error_log("Existing database cart items: " . json_encode($dbCart));
            
            foreach ($sessionCart as $productId => $sessionItem) {
                if (isset($dbCart[$productId])) {
                    // Nếu sản phẩm đã có trong database
                    $dbQuantity = $dbCart[$productId]['quantity'];
                    $sessionQuantity = $sessionItem['quantity'];
                    
                    error_log("Product ID $productId: DB quantity=$dbQuantity, Session quantity=$sessionQuantity");
                    
                    switch ($mergeStrategy) {
                        case 'replace':
                            // Thay thế hoàn toàn số lượng database bằng session
                            $this->updateCartItem($customerId, $productId, $sessionQuantity);
                            error_log("Replaced quantity: $dbQuantity -> $sessionQuantity");
                            break;
                            
                        case 'add':
                            // Cộng dồn số lượng (hành vi cũ - KHÔNG KHUYẾN KHÍCH)
                            $newQuantity = $dbQuantity + $sessionQuantity;
                            $this->updateCartItem($customerId, $productId, $newQuantity);
                            error_log("Added quantities: $dbQuantity + $sessionQuantity = $newQuantity");
                            break;
                            
                        case 'smart':
                        default:
                            // Logic thông minh: chỉ cập nhật nếu session > database
                            // Điều này giúp tránh việc giảm số lượng không mong muốn
                            if ($sessionQuantity > $dbQuantity) {
                                $this->updateCartItem($customerId, $productId, $sessionQuantity);
                                error_log("Updated quantity: $dbQuantity -> $sessionQuantity (session > db)");
                            } else {
                                error_log("Kept database quantity: $dbQuantity (session <= db)");
                            }
                            break;
                            
                        case 'preserve_existing':
                            // Strategy mới: Bảo toàn giỏ hàng hiện có, KHÔNG merge
                            // KHÔNG thêm sản phẩm mới, KHÔNG cập nhật số lượng
                            error_log("Preserving existing quantity: $dbQuantity (strategy: preserve_existing) - NO CHANGES");
                            break;
                            
                        case 'ignore_session':
                            // Strategy mới: HOÀN TOÀN bỏ qua session cart
                            // KHÔNG làm gì cả, chỉ giữ nguyên database
                            error_log("Ignoring session cart completely (strategy: ignore_session) - NO CHANGES");
                            break;
                            
                        case 'session_only':
                            // Strategy mới: Chỉ sử dụng session cart, bỏ qua database
                            $this->updateCartItem($customerId, $productId, $sessionQuantity);
                            error_log("Used session quantity only: $sessionQuantity (strategy: session_only)");
                            break;
                    }
                } else {
                    // Nếu sản phẩm chưa có trong database
                    if ($mergeStrategy === 'preserve_existing' || $mergeStrategy === 'ignore_session') {
                        // Với strategy 'preserve_existing' hoặc 'ignore_session', KHÔNG thêm sản phẩm mới
                        error_log("Product ID $productId not in database, but using '$mergeStrategy' strategy - SKIPPING");
                    } else {
                        // Với các strategy khác, thêm sản phẩm mới
                        // Sử dụng strategy 'replace' để tránh cộng dồn
                        $this->addCartItem($customerId, $productId, $sessionItem['quantity'], 'replace');
                        error_log("Added new product ID $productId with quantity: " . $sessionItem['quantity']);
                    }
                }
            }
            
            // Kiểm tra và xử lý trùng lặp sau khi merge
            $this->checkAndFixDuplicates($customerId);
            
            error_log("Session cart merge completed successfully for customer ID: $customerId");
            return true;
        } catch (Exception $e) {
            error_log("Error merging session cart: " . $e->getMessage());
            return false;
        }
    }

    // Method mới: Xử lý logic merge hoàn hảo cho từng trường hợp
    public function smartMergeSessionCart($customerId, $sessionCart) {
        try {
            if (empty($sessionCart)) {
                error_log("No session cart to merge for customer ID: $customerId");
                return true;
            }

            error_log("=== SMART MERGE SESSION CART START ===");
            error_log("Customer ID: $customerId");
            error_log("Session cart items: " . json_encode($sessionCart));

            // Lấy giỏ hàng hiện có từ database
            $existingCart = $this->getCart($customerId);
            $isReturningCustomer = !empty($existingCart);
            
            error_log("Existing cart items: " . json_encode($existingCart));
            error_log("Is returning customer: " . ($isReturningCustomer ? 'YES' : 'NO'));

            if ($isReturningCustomer) {
                error_log("RETURNING CUSTOMER: COMPLETELY IGNORING session cart - preserving existing database cart only");
                // Khách hàng cũ: HOÀN TOÀN bỏ qua session cart, chỉ giữ giỏ hàng database
                // KHÔNG merge, KHÔNG thêm sản phẩm mới
                return true;
            } else {
                error_log("NEW CUSTOMER: Using 'smart' strategy");
                // Khách hàng mới: sử dụng strategy smart
                return $this->mergeSessionCart($customerId, $sessionCart, 'smart');
            }
        } catch (Exception $e) {
            error_log("Error in smartMergeSessionCart: " . $e->getMessage());
            return false;
        }
    }
}
?>
