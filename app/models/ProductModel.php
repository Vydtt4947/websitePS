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
            LEFT JOIN danhmuc dm ON sp.MaDM = dm.MaDM
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

    public function getProductsForCustomer($searchTerm = '', $category = '', $sort = 'name', $page = 1, $perPage = 12) {
        $offset = ($page - 1) * $perPage;
        
        // Xây dựng câu query cơ bản
        $sql = "
            SELECT SQL_CALC_FOUND_ROWS sp.*, dm.TenDanhMuc
            FROM sanpham sp
            LEFT JOIN danhmuc dm ON sp.MaDM = dm.MaDM
            WHERE 1=1
        ";
        
        $params = [];
        
        // Thêm điều kiện tìm kiếm
        if (!empty($searchTerm)) {
            $sql .= " AND (sp.TenSP LIKE :searchTerm OR sp.MoTa LIKE :searchTerm)";
            $searchPattern = '%' . $searchTerm . '%';
            $params[':searchTerm'] = $searchPattern;
        }
        
        // Thêm điều kiện danh mục
        if (!empty($category)) {
            $sql .= " AND sp.MaDM = :category";
            $params[':category'] = $category;
        }
        
        // Thêm sắp xếp
        switch ($sort) {
            case 'price_asc':
                $sql .= " ORDER BY sp.DonGia ASC";
                break;
            case 'price_desc':
                $sql .= " ORDER BY sp.DonGia DESC";
                break;
            case 'name':
            default:
                $sql .= " ORDER BY sp.TenSP ASC";
                break;
        }
        
        $sql .= " LIMIT :perPage OFFSET :offset";
        
        $stmt = $this->db->prepare($sql);
        
        // Bind các tham số
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindParam(':perPage', $perPage, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Lấy tổng số sản phẩm
        $totalRows = $this->db->query("SELECT FOUND_ROWS()")->fetchColumn();
        
        return [
            'products' => $products,
            'total' => $totalRows,
            'perPage' => $perPage,
            'currentPage' => $page,
            'totalPages' => ceil($totalRows / $perPage)
        ];
    }

    public function getAllProductsWithCategory() {
        $query = "
            SELECT 
                sp.MaSP, sp.TenSP, sp.MoTa, sp.DonGia, dm.TenDanhMuc
            FROM sanpham sp
            LEFT JOIN danhmuc dm ON sp.MaDM = dm.MaDM
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
        $stmt = $this->db->prepare("
            SELECT sp.*, dm.TenDanhMuc 
            FROM sanpham sp
            LEFT JOIN danhmuc dm ON sp.MaDM = dm.MaDM
            WHERE sp.MaSP = :id
        ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createProduct($tenSP, $moTa, $donGia, $maDM, $hinhAnh = null) {
        $stmt = $this->db->prepare("INSERT INTO sanpham (TenSP, MoTa, DonGia, MaDM, HinhAnh) VALUES (:tenSP, :moTa, :donGia, :maDM, :hinhAnh)");
        $stmt->bindParam(':tenSP', $tenSP);
        $stmt->bindParam(':moTa', $moTa);
        $stmt->bindParam(':donGia', $donGia);
        $stmt->bindParam(':maDM', $maDM, PDO::PARAM_INT);
        $stmt->bindParam(':hinhAnh', $hinhAnh);
        return $stmt->execute();
    }

    public function updateProduct($maSP, $tenSP, $moTa, $donGia, $maDM, $hinhAnh = null) {
        $stmt = $this->db->prepare("UPDATE sanpham SET TenSP = :tenSP, MoTa = :moTa, DonGia = :donGia, MaDM = :maDM, HinhAnh = :hinhAnh WHERE MaSP = :maSP");
        $stmt->bindParam(':maSP', $maSP, PDO::PARAM_INT);
        $stmt->bindParam(':tenSP', $tenSP);
        $stmt->bindParam(':moTa', $moTa);
        $stmt->bindParam(':donGia', $donGia);
        $stmt->bindParam(':maDM', $maDM, PDO::PARAM_INT);
        $stmt->bindParam(':hinhAnh', $hinhAnh);
        return $stmt->execute();
    }

    public function deleteProduct($id) {
        $stmt = $this->db->prepare("DELETE FROM sanpham WHERE MaSP = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getRelatedProducts($currentProductId, $currentCategoryId = null, $limit = 3) {
        $sql = "
            SELECT sp.*, dm.TenDanhMuc
            FROM sanpham sp
            LEFT JOIN danhmuc dm ON sp.MaDM = dm.MaDM
            WHERE sp.MaSP != :currentProductId
        ";
        
        $params = [':currentProductId' => $currentProductId];
        
        // Ưu tiên sản phẩm cùng danh mục trước
        if ($currentCategoryId) {
            $sql .= " ORDER BY 
                CASE WHEN sp.MaDM = :currentCategoryId THEN 0 ELSE 1 END,
                RAND()
            ";
            $params[':currentCategoryId'] = $currentCategoryId;
        } else {
            $sql .= " ORDER BY RAND()";
        }
        
        $sql .= " LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFeaturedProducts($limit = 6) {
        $sql = "
            SELECT sp.*, dm.TenDanhMuc
            FROM sanpham sp
            LEFT JOIN danhmuc dm ON sp.MaDM = dm.MaDM
            ORDER BY RAND()
            LIMIT :limit
        ";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductReviews($productId = null, $limit = 10) {
        $sql = "
            SELECT 
                dg.MaDG,
                dg.SoSao,
                dg.NoiDung,
                dg.NgayDanhGia,
                kh.HoTen as TenKhachHang,
                sp.TenSP as TenSanPham,
                sp.MaSP
            FROM danhgia dg
            LEFT JOIN khachhang kh ON dg.MaKH = kh.MaKH
            LEFT JOIN sanpham sp ON dg.MaSP = sp.MaSP
            WHERE 1=1
        ";
        
        $params = [];
        
        if ($productId) {
            $sql .= " AND dg.MaSP = :productId";
            $params[':productId'] = $productId;
        }
        
        $sql .= " ORDER BY dg.NgayDanhGia DESC LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAverageRating($productId = null) {
        $sql = "
            SELECT 
                AVG(SoSao) as TrungBinh,
                COUNT(*) as TongDanhGia
            FROM danhgia
        ";
        
        $params = [];
        
        if ($productId) {
            $sql .= " WHERE MaSP = :productId";
            $params[':productId'] = $productId;
        }
        
        $stmt = $this->db->prepare($sql);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTopRatedProducts($limit = 6) {
        $sql = "
            SELECT 
                sp.MaSP,
                sp.TenSP,
                sp.MoTa,
                sp.DonGia,
                sp.HinhAnh,
                dm.TenDanhMuc,
                AVG(dg.SoSao) as TrungBinhSao,
                COUNT(dg.MaDG) as SoDanhGia
            FROM sanpham sp
            LEFT JOIN danhmuc dm ON sp.MaDM = dm.MaDM
            LEFT JOIN danhgia dg ON sp.MaSP = dg.MaSP
            GROUP BY sp.MaSP
            HAVING TrungBinhSao IS NOT NULL
            ORDER BY TrungBinhSao DESC, SoDanhGia DESC
            LIMIT :limit
        ";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
