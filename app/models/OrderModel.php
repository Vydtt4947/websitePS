<?php
// File: app/models/OrderModel.php
require_once __DIR__ . '/../../config/database.php';

class OrderModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        if (!$this->db) {
            error_log("Failed to connect to database in OrderModel");
            throw new Exception("Database connection failed");
        }
    }

    public function getRecentOrders(int $limit = 5) {
        $query = "
            SELECT 
                dh.MaDH, kh.HoTen, dh.NgayDatHang, dh.TongTien, 
                dh.TrangThai as TenTrangThai, dh.TrangThai as MaTrangThai
            FROM donhang dh
            JOIN khachhang kh ON dh.MaKH = kh.MaKH
            ORDER BY dh.NgayDatHang DESC LIMIT :limit
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTodaysRevenue() {
        $query = "SELECT SUM(TongTien) as total FROM donhang WHERE DATE(NgayDatHang) = CURDATE() AND TrangThai != 'Cancelled'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function getTodaysOrderCount() {
        $query = "SELECT COUNT(MaDH) as count FROM donhang WHERE DATE(NgayDatHang) = CURDATE()";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    public function getRevenueLast7Days() {
        $query = "
            SELECT DATE(NgayDatHang) as date, SUM(TongTien) as revenue
            FROM donhang
            WHERE NgayDatHang >= CURDATE() - INTERVAL 7 DAY AND TrangThai != 'Cancelled'
            GROUP BY DATE(NgayDatHang) ORDER BY date ASC
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllOrders() {
        $query = "
            SELECT 
                dh.MaDH, kh.HoTen AS TenKhachHang, dh.NgayDatHang, 
                dh.TongTien, dh.TrangThai as TenTrangThai, dh.TrangThai as MaTrangThai
            FROM donhang dh
            JOIN khachhang kh ON dh.MaKH = kh.MaKH
            ORDER BY dh.NgayDatHang DESC
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderById($id) {
        $query = "
            SELECT dh.*, kh.HoTen, kh.Email, kh.SoDienThoai, dh.TrangThai as TenTrangThai, dh.PhuongThucThanhToan
            FROM donhang dh
            LEFT JOIN khachhang kh ON dh.MaKH = kh.MaKH
            WHERE dh.MaDH = :id
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getOrderDetailsById($id) {
        $queryOrder = "
            SELECT dh.*, kh.HoTen, kh.Email, kh.SoDienThoai, dh.TrangThai as TenTrangThai, dh.PhuongThucThanhToan
            FROM donhang dh
            LEFT JOIN khachhang kh ON dh.MaKH = kh.MaKH
            WHERE dh.MaDH = :id
        ";
        $stmtOrder = $this->db->prepare($queryOrder);
        $stmtOrder->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtOrder->execute();
        $orderDetails['info'] = $stmtOrder->fetch(PDO::FETCH_ASSOC);

        $queryItems = "
            SELECT sp.TenSP, sp.HinhAnh, ctdh.SoLuong, ctdh.DonGia
            FROM chitietdonhang ctdh
            JOIN sanpham sp ON ctdh.MaSP = sp.MaSP
            WHERE ctdh.MaDH = :id
        ";
        $stmtItems = $this->db->prepare($queryItems);
        $stmtItems->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtItems->execute();
        $orderDetails['items'] = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

        return $orderDetails;
    }

    public function getAllStatuses() {
        // Return the available status values from the enum in donhang table
        return [
            ['TrangThai' => 'Pending', 'MoTa' => 'Chờ xử lý'],
            ['TrangThai' => 'Processing', 'MoTa' => 'Đang xử lý'],
            ['TrangThai' => 'Shipping', 'MoTa' => 'Đang giao hàng'],
            ['TrangThai' => 'Delivered', 'MoTa' => 'Đã giao hàng'],
            ['TrangThai' => 'Cancelled', 'MoTa' => 'Đã hủy']
        ];
    }

    public function updateStatus($orderId, $statusId) {
        // Lấy trạng thái cũ trước khi cập nhật
        $oldStatusQuery = "SELECT TrangThai, MaKH FROM donhang WHERE MaDH = :orderId";
        $oldStatusStmt = $this->db->prepare($oldStatusQuery);
        $oldStatusStmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
        $oldStatusStmt->execute();
        $oldStatusResult = $oldStatusStmt->fetch(PDO::FETCH_ASSOC);
        
        $oldStatus = $oldStatusResult['TrangThai'] ?? null;
        $customerId = $oldStatusResult['MaKH'] ?? null;
        
        // Cập nhật trạng thái đơn hàng
        $query = "UPDATE donhang SET TrangThai = :statusId WHERE MaDH = :orderId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':statusId', $statusId);
        $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
        $result = $stmt->execute();

        // Xử lý cập nhật phân loại khách hàng
        if ($result && $customerId) {
            require_once __DIR__ . '/CustomerModel.php';
            $customerModel = new CustomerModel();
            
            // Trường hợp 1: Đơn hàng được chuyển thành "Delivered" (lên cấp)
            if ($oldStatus !== 'Delivered' && $statusId === 'Delivered') {
                $customerModel->updateCustomerTier($customerId);
            }
            // Trường hợp 2: Đơn hàng bị hủy từ "Delivered" (hạ cấp)
            else if ($oldStatus === 'Delivered' && $statusId === 'Cancelled') {
                $customerModel->updateCustomerTier($customerId);
            }
            // Trường hợp 3: Đơn hàng được khôi phục từ "Cancelled" về "Delivered" (lên cấp lại)
            else if ($oldStatus === 'Cancelled' && $statusId === 'Delivered') {
                $customerModel->updateCustomerTier($customerId);
            }
        }

        return $result;
    }

    // PHƯƠNG THỨC MỚI ĐỂ TẠO ĐƠN HÀNG
    public function createOrder($customerData, $cart, $total, $paymentMethod = 'cod', $appliedPromotions = []) {
        try {
            $this->db->beginTransaction();

            // Lấy customer ID từ session nếu đã đăng nhập
            $customerId = $_SESSION['customer_id'] ?? null;
            
            // Debug: Log customer ID
            error_log("Session customer_id: " . ($_SESSION['customer_id'] ?? 'null'));
            error_log("Customer ID before create: " . ($customerId ?? 'null'));
            
            // Xử lý khách hàng dựa trên trạng thái đăng nhập
            if ($customerId) {
                // Khách hàng đã đăng nhập - sử dụng customer ID hiện tại
                error_log("Using existing customer ID: " . $customerId);
            } else {
                // Khách vãng lai - tạo customer mới hoặc sử dụng null
                $customerId = $this->createCustomerIfNotExists($customerData);
                error_log("Created new customer ID for guest: " . $customerId);
            }

            // Debug: Log final customer ID
            error_log("Final customer ID for order: " . $customerId);

            // Tạo đơn hàng với customer ID (có thể null cho khách vãng lai)
            $queryOrder = "INSERT INTO donhang (MaKH, NgayDatHang, TongTien, TrangThai, PhuongThucThanhToan) VALUES (:maKH, NOW(), :tongTien, 'Pending', :paymentMethod)";
            $stmtOrder = $this->db->prepare($queryOrder);
            $stmtOrder->bindParam(':maKH', $customerId, PDO::PARAM_INT);
            $stmtOrder->bindParam(':tongTien', $total);
            $stmtOrder->bindParam(':paymentMethod', $paymentMethod);
            $stmtOrder->execute();
            
            // Lấy MaDH vừa tạo
            $orderId = $this->db->lastInsertId();
            error_log("Created order ID: " . $orderId);

            // Thêm chi tiết đơn hàng
            foreach ($cart as $productId => $item) {
                try {
                    $queryDetail = "INSERT INTO chitietdonhang (MaDH, MaSP, SoLuong, DonGia) VALUES (:maDH, :maSP, :soLuong, :donGia)";
                    $stmtDetail = $this->db->prepare($queryDetail);
                    $stmtDetail->bindParam(':maDH', $orderId);
                    $stmtDetail->bindParam(':maSP', $productId);
                    $stmtDetail->bindParam(':soLuong', $item['quantity']);
                    $stmtDetail->bindParam(':donGia', $item['price']);
                    $stmtDetail->execute();
                } catch (Exception $e) {
                    error_log("Error inserting order detail: " . $e->getMessage());
                    error_log("Product ID: " . $productId . ", Quantity: " . $item['quantity'] . ", Price: " . $item['price']);
                    throw $e;
                }
            }
            
            // Lưu thông tin khuyến mãi đã áp dụng (nếu có)
            // Tạm thời comment lại cho đến khi bảng khuyenmai_donhang được tạo
            /*
            if (!empty($appliedPromotions)) {
                foreach ($appliedPromotions as $promotion) {
                    $queryPromotion = "INSERT INTO khuyenmai_donhang (MaDH, LoaiKhuyenMai, MoTa, SoTienGiam) VALUES (:maDH, :loaiKM, :moTa, :soTienGiam)";
                    $stmtPromotion = $this->db->prepare($queryPromotion);
                    $stmtPromotion->bindParam(':maDH', $orderId, PDO::PARAM_INT);
                    $stmtPromotion->bindParam(':loaiKM', $promotion['promotionType']);
                    $stmtPromotion->bindParam(':moTa', $promotion['description']);
                    $stmtPromotion->bindParam(':soTienGiam', $promotion['discount']);
                    $stmtPromotion->execute();
                }
            }
            */

            $this->db->commit();
            return $orderId;

        } catch (Exception $e) {
            $this->db->rollback();
            error_log("Error creating order: " . $e->getMessage());
            error_log("Error details: " . print_r($e->getTrace(), true));
            error_log("Customer ID: " . ($customerId ?? 'null'));
            error_log("Cart data: " . print_r($cart, true));
            error_log("Total: " . $total);
            return false;
        }
    }

    // PHƯƠNG THỨC HỖ TRỢ TẠO KHÁCH HÀNG MỚI NẾU CHƯA CÓ
    private function createCustomerIfNotExists($customerData) {
        // Kiểm tra xem customer đã tồn tại chưa
        $query = "SELECT MaKH FROM khachhang WHERE Email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $customerData['email']);
        $stmt->execute();
        $existingCustomer = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingCustomer) {
            return $existingCustomer['MaKH'];
        }

        // Tạo customer mới - để database tự tạo MaKH
        $query = "INSERT INTO khachhang (HoTen, Email, SoDienThoai) VALUES (:hoTen, :email, :soDienThoai)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':hoTen', $customerData['fullname']);
        $stmt->bindParam(':email', $customerData['email']);
        $stmt->bindParam(':soDienThoai', $customerData['phone']);
        $stmt->execute();

        return $this->db->lastInsertId();
    }

    // PHƯƠNG THỨC TRA CỨU ĐƠN HÀNG CHO KHÁCH VÃNG LAI
    public function getOrderByCode($orderCode) {
        $query = "
            SELECT dh.*, kh.HoTen, kh.Email, kh.SoDienThoai, dh.TrangThai as TenTrangThai, dh.PhuongThucThanhToan
            FROM donhang dh
            LEFT JOIN khachhang kh ON dh.MaKH = kh.MaKH
            WHERE dh.MaDH = :orderCode
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':orderCode', $orderCode, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getOrderByCodeAndPhone($orderCode, $phone) {
        // Debug log
        error_log("Order tracking search - OrderCode: $orderCode, Phone: $phone");
        
        // Thử tìm đơn hàng với số điện thoại khớp chính xác
        $query = "
            SELECT dh.*, kh.HoTen, kh.Email, kh.SoDienThoai, dh.TrangThai as TenTrangThai, dh.PhuongThucThanhToan
            FROM donhang dh
            LEFT JOIN khachhang kh ON dh.MaKH = kh.MaKH
            WHERE dh.MaDH = :orderCode AND kh.SoDienThoai = :phone
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':orderCode', $orderCode, PDO::PARAM_INT);
        $stmt->bindParam(':phone', $phone);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        error_log("Query 1 result: " . print_r($result, true));
        
        if ($result) {
            return $result;
        }
        
        // Nếu không tìm thấy với số điện thoại, thử tìm chỉ với mã đơn hàng
        $query2 = "
            SELECT dh.*, kh.HoTen, kh.Email, kh.SoDienThoai, dh.TrangThai as TenTrangThai, dh.PhuongThucThanhToan
            FROM donhang dh
            LEFT JOIN khachhang kh ON dh.MaKH = kh.MaKH
            WHERE dh.MaDH = :orderCode
        ";
        $stmt2 = $this->db->prepare($query2);
        $stmt2->bindParam(':orderCode', $orderCode, PDO::PARAM_INT);
        $stmt2->execute();
        $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
        
        error_log("Query 2 result: " . print_r($result2, true));
        
        if ($result2) {
            // Nếu tìm thấy đơn hàng nhưng số điện thoại không khớp, vẫn trả về kết quả
            // nhưng log để debug
            error_log("Found order but phone doesn't match. Order phone: " . ($result2['SoDienThoai'] ?? 'NULL') . ", Search phone: $phone");
            return $result2;
        }
        
        return null;
    }

    // Lấy trạng thái đơn hàng dưới dạng text
    public function getOrderStatusText($status) {
        $statusMap = [
            'Pending' => 'Chờ xử lý',
            'Processing' => 'Đang xử lý',
            'Shipped' => 'Đã giao hàng',
            'Delivered' => 'Đã nhận hàng',
            'Cancelled' => 'Đã hủy'
        ];
        
        return $statusMap[$status] ?? $status;
    }

    // Lấy màu sắc cho trạng thái đơn hàng
    public function getOrderStatusColor($status) {
        $colorMap = [
            'Pending' => 'warning',
            'Processing' => 'info',
            'Shipped' => 'primary',
            'Delivered' => 'success',
            'Cancelled' => 'danger'
        ];
        
        return $colorMap[$status] ?? 'secondary';
    }
}