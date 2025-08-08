<?php
// File: app/models/CustomerModel.php
require_once __DIR__ . '/../../config/database.php';

class CustomerModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function getNewCustomersThisMonth() {
        $query = "SELECT COUNT(MaKH) as count FROM khachhang WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    public function getAllCustomers() {
        $query = "
            SELECT kh.MaKH, kh.HoTen, kh.SoDienThoai, kh.Email, pk.TenPhanLoai
            FROM khachhang kh
            LEFT JOIN phankhuckh pk ON kh.MaPL = pk.MaPL
            ORDER BY kh.MaKH ASC
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCustomerById($id) {
        $stmt = $this->db->prepare("SELECT * FROM khachhang WHERE MaKH = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllCustomerSegments() {
        $stmt = $this->db->prepare("SELECT * FROM phankhuckh");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function createCustomer($data) {
        $query = "INSERT INTO khachhang (MaKH, HoTen, SoDienThoai, Email, NgaySinh, MaPL) VALUES (:maKH, :hoTen, :soDienThoai, :email, :ngaySinh, :maPL)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maKH', $data['maKH']);
        $stmt->bindParam(':hoTen', $data['hoTen']);
        $stmt->bindParam(':soDienThoai', $data['soDienThoai']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':ngaySinh', $data['ngaySinh']);
        $stmt->bindParam(':maPL', $data['maPL'], PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateCustomer($id, $data) {
        $query = "UPDATE khachhang SET HoTen = :hoTen, SoDienThoai = :soDienThoai, Email = :email, NgaySinh = :ngaySinh, MaPL = :maPL WHERE MaKH = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':hoTen', $data['hoTen']);
        $stmt->bindParam(':soDienThoai', $data['soDienThoai']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':ngaySinh', $data['ngaySinh']);
        $stmt->bindParam(':maPL', $data['maPL'], PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteCustomer($id) {
        $stmt = $this->db->prepare("DELETE FROM khachhang WHERE MaKH = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function getOrderHistoryByCustomerId($customerId) {
        $query = "
            SELECT dh.MaDH, dh.NgayDatHang, dh.TongTien, tt.TenTrangThai, tt.MaTrangThai
            FROM donhang dh
            JOIN trangthaidonhang tt ON dh.TrangThai = tt.MaTrangThai
            WHERE dh.MaKH = :customerId
            ORDER BY dh.NgayDatHang DESC
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':customerId', $customerId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM khachhang WHERE Email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function registerCustomer($data) {
        $query = "INSERT INTO khachhang (MaKH, HoTen, Email, Password, MaPL) VALUES (:maKH, :hoTen, :email, :password, 1)";
        $stmt = $this->db->prepare($query);
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        $maKH = 'KH' . time();
        $stmt->bindParam(':maKH', $maKH);
        $stmt->bindParam(':hoTen', $data['fullname']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $hashedPassword);
        return $stmt->execute();
    }
    public function updateProfile($id, $data) {
        $query = "UPDATE khachhang SET HoTen = :hoTen, SoDienThoai = :soDienThoai, NgaySinh = :ngaySinh WHERE MaKH = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':hoTen', $data['HoTen']);
        $stmt->bindParam(':soDienThoai', $data['SoDienThoai']);
        $stmt->bindParam(':ngaySinh', $data['NgaySinh']);
        return $stmt->execute();
    }

}