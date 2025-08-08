<?php
// File: app/models/OrderModel.php
require_once __DIR__ . '/../../config/database.php';

class OrderModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function getRecentOrders(int $limit = 5) {
        $query = "
            SELECT 
                dh.MaDH, kh.HoTen, dh.NgayDatHang, dh.TongTien, 
                tt.TenTrangThai, tt.MaTrangThai
            FROM donhang dh
            JOIN khachhang kh ON dh.MaKH = kh.MaKH
            JOIN trangthaidonhang tt ON dh.TrangThai = tt.MaTrangThai
            ORDER BY dh.NgayDatHang DESC LIMIT :limit
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTodaysRevenue() {
        $query = "SELECT SUM(TongTien) as total FROM donhang WHERE DATE(NgayDatHang) = CURDATE() AND TrangThai != 5";
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
            WHERE NgayDatHang >= CURDATE() - INTERVAL 7 DAY AND TrangThai != 5
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
                dh.TongTien, tt.TenTrangThai, tt.MaTrangThai
            FROM donhang dh
            JOIN khachhang kh ON dh.MaKH = kh.MaKH
            JOIN trangthaidonhang tt ON dh.TrangThai = tt.MaTrangThai
            ORDER BY dh.NgayDatHang DESC
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderDetailsById($id) {
        $queryOrder = "
            SELECT dh.*, kh.HoTen, kh.SoDienThoai, kh.Email, tt.TenTrangThai
            FROM donhang dh
            JOIN khachhang kh ON dh.MaKH = kh.MaKH
            JOIN trangthaidonhang tt ON dh.TrangThai = tt.MaTrangThai
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
        $stmt->bindParam(':statusId', $statusId, PDO::PARAM_INT);
        $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}