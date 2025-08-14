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
            SELECT dh.MaDH, dh.NgayDatHang, dh.TongTien, dh.TrangThai as TenTrangThai
            FROM donhang dh
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
        $query = "INSERT INTO khachhang (HoTen, Email, SoDienThoai) VALUES (:hoTen, :email, :soDienThoai)";
        $stmt = $this->db->prepare($query);
        
        // Tạo biến trung gian để tránh lỗi bindParam với toán tử ??
        $phone = $data['phone'] ?? '';
        
        $stmt->bindParam(':hoTen', $data['fullname']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':soDienThoai', $phone);
        return $stmt->execute();
    }
    public function updateProfile($id, $data) {
        $query = "UPDATE khachhang SET 
                    HoTen = :hoTen, 
                    SoDienThoai = :soDienThoai, 
                    NgaySinh = :ngaySinh,
                    DiaChiGiaoHang = :diaChiGiaoHang,
                    TinhThanh = :tinhThanh,
                    QuanHuyen = :quanHuyen,
                    GhiChuGiaoHang = :ghiChuGiaoHang
                  WHERE MaKH = :id";
        $stmt = $this->db->prepare($query);
        
        // Tạo biến trung gian để tránh lỗi bindParam với toán tử ??
        $diaChiGiaoHang = $data['DiaChiGiaoHang'] ?? '';
        $tinhThanh = $data['TinhThanh'] ?? '';
        $quanHuyen = $data['QuanHuyen'] ?? '';
        $ghiChuGiaoHang = $data['GhiChuGiaoHang'] ?? '';
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':hoTen', $data['HoTen']);
        $stmt->bindParam(':soDienThoai', $data['SoDienThoai']);
        $stmt->bindParam(':ngaySinh', $data['NgaySinh']);
        $stmt->bindParam(':diaChiGiaoHang', $diaChiGiaoHang);
        $stmt->bindParam(':tinhThanh', $tinhThanh);
        $stmt->bindParam(':quanHuyen', $quanHuyen);
        $stmt->bindParam(':ghiChuGiaoHang', $ghiChuGiaoHang);
        return $stmt->execute();
    }

}