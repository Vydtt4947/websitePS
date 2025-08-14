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

    public function getOrderDetailsById($id) {
        $queryOrder = "
            SELECT dh.*, kh.HoTen, kh.Email, kh.SoDienThoai, dh.TrangThai as TenTrangThai, dh.PhuongThucThanhToan
            FROM donhang dh
            JOIN khachhang kh ON dh.MaKH = kh.MaKH
            WHERE dh.MaDH = :id
        ";
        $stmtOrder = $this->db->prepare($queryOrder);
        $stmtOrder->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtOrder->execute();
        $orderDetails['info'] = $stmtOrder->fetch(PDO::FETCH_ASSOC);

        $queryItems = "
            SELECT sp.TenSP, ctdh.SoLuong, ctdh.DonGia
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
        $stmt = $this->db->prepare("SELECT * FROM trangthaidonhang");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($orderId, $statusId) {
        $query = "UPDATE donhang SET TrangThai = :statusId WHERE MaDH = :orderId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':statusId', $statusId);
        $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
        return $stmt->execute();
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
            
            // Nếu chưa có customer, tạo customer mới
            if (!$customerId) {
                $customerId = $this->createCustomerIfNotExists($customerData);
                error_log("Created new customer ID: " . $customerId);
            }

            // Debug: Log final customer ID
            error_log("Final customer ID for order: " . $customerId);

            // Tạo đơn hàng với customer ID đã có
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
}