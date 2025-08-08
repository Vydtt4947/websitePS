<?php
// File: app/models/ProductModel.php
require_once __DIR__ . '/../../config/database.php';

class ProductModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function getTotalProductCount() {
        $query = "SELECT COUNT(MaSP) as count FROM sanpham";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    public function getProductsPaginated($searchTerm = '', $page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        $sql = "
            SELECT SQL_CALC_FOUND_ROWS sp.*, dm.TenDanhMuc
            FROM sanpham sp
            LEFT JOIN danhmuc dm ON sp.MaDM = dm.MaDanhMuc
            WHERE sp.TenSP LIKE :searchTerm
            ORDER BY sp.MaSP DESC
            LIMIT :perPage OFFSET :offset
        ";
        $stmt = $this->db->prepare($sql);
        $searchPattern = '%' . $searchTerm . '%';
        $stmt->bindParam(':searchTerm', $searchPattern);
        $stmt->bindParam(':perPage', $perPage, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $totalRows = $this->db->query("SELECT FOUND_ROWS()")->fetchColumn();
        return [
            'products' => $products,
            'total' => $totalRows,
            'perPage' => $perPage,
            'currentPage' => $page
        ];
    }

    public function getAllProductsWithCategory() {
        $query = "
            SELECT 
                sp.MaSP, sp.TenSP, sp.MoTa, sp.DonGia, dm.TenDanhMuc
            FROM sanpham sp
            LEFT JOIN danhmuc dm ON sp.MaDM = dm.MaDanhMuc
            ORDER BY sp.MaSP ASC
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllCategories() {
        $stmt = $this->db->prepare("SELECT * FROM danhmuc ORDER BY TenDanhMuc ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id) {
        $stmt = $this->db->prepare("SELECT * FROM sanpham WHERE MaSP = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createProduct($tenSP, $moTa, $donGia, $maDM) {
        $stmt = $this->db->prepare("INSERT INTO sanpham (TenSP, MoTa, DonGia, MaDM) VALUES (:tenSP, :moTa, :donGia, :maDM)");
        $stmt->bindParam(':tenSP', $tenSP);
        $stmt->bindParam(':moTa', $moTa);
        $stmt->bindParam(':donGia', $donGia);
        $stmt->bindParam(':maDM', $maDM, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateProduct($maSP, $tenSP, $moTa, $donGia, $maDM) {
        $stmt = $this->db->prepare("UPDATE sanpham SET TenSP = :tenSP, MoTa = :moTa, DonGia = :donGia, MaDM = :maDM WHERE MaSP = :maSP");
        $stmt->bindParam(':maSP', $maSP, PDO::PARAM_INT);
        $stmt->bindParam(':tenSP', $tenSP);
        $stmt->bindParam(':moTa', $moTa);
        $stmt->bindParam(':donGia', $donGia);
        $stmt->bindParam(':maDM', $maDM, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteProduct($id) {
        $stmt = $this->db->prepare("DELETE FROM sanpham WHERE MaSP = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
