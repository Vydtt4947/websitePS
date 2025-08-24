<?php
// File: app/models/KhuyenMaiModel.php
require_once __DIR__ . '/../../config/database.php';

class KhuyenMaiModel {
    private PDO $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    // Phương thức test để kiểm tra kết nối
    public function testConnection(): array {
        try {
            $stmt = $this->db->query('SELECT COUNT(*) as total FROM khuyenmai');
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return ['success' => true, 'total' => $result['total']];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    // Phương thức lấy tất cả khuyến mãi (không phân trang)
    public function getAll(): array {
        try {
            $stmt = $this->db->query('SELECT * FROM khuyenmai ORDER BY MaKM DESC');
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Lỗi khi lấy tất cả khuyến mãi: " . $e->getMessage());
            return [];
        }
    }

    public function getPaginated(string $search = '', int $page = 1, int $perPage = 10): array {
        $offset = ($page - 1) * $perPage;
        $where = '';
        $params = [];
        if ($search !== '') {
            $where = "WHERE TenKM LIKE :s OR MoTa LIKE :s";
            $params[':s'] = '%' . $search . '%';
        }

        $countSql = "SELECT COUNT(*) FROM khuyenmai $where";
        $stmt = $this->db->prepare($countSql);
        foreach ($params as $k => $v) { $stmt->bindValue($k, $v); }
        $stmt->execute();
        $total = (int)$stmt->fetchColumn();

        $sql = "SELECT * FROM khuyenmai $where ORDER BY MaKM DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        foreach ($params as $k => $v) { $stmt->bindValue($k, $v); }
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'promotions' => $items,
            'total' => $total,
            'currentPage' => $page,
            'perPage' => $perPage,
            'totalPages' => max(1, (int)ceil($total / $perPage))
        ];
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare('SELECT * FROM khuyenmai WHERE MaKM = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function create(array $data): bool {
        $sql = 'INSERT INTO khuyenmai (TenKM, MoTa, PhanTramGiamGia, SoTienGiamGia, NgayBatDau, NgayKetThuc) VALUES (:TenKM, :MoTa, :PhanTramGiamGia, :SoTienGiamGia, :NgayBatDau, :NgayKetThuc)';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':TenKM', $data['TenKM']);
        $stmt->bindValue(':MoTa', $data['MoTa'] ?: null);
        $stmt->bindValue(':PhanTramGiamGia', $data['PhanTramGiamGia'] !== '' ? $data['PhanTramGiamGia'] : null);
        $stmt->bindValue(':SoTienGiamGia', $data['SoTienGiamGia'] !== '' ? $data['SoTienGiamGia'] : null);
        $stmt->bindValue(':NgayBatDau', $data['NgayBatDau'] ?: null);
        $stmt->bindValue(':NgayKetThuc', $data['NgayKetThuc'] ?: null);
        return $stmt->execute();
    }

    public function update(int $id, array $data): bool {
        $sql = 'UPDATE khuyenmai SET TenKM=:TenKM, MoTa=:MoTa, PhanTramGiamGia=:PhanTramGiamGia, SoTienGiamGia=:SoTienGiamGia, NgayBatDau=:NgayBatDau, NgayKetThuc=:NgayKetThuc WHERE MaKM=:id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':TenKM', $data['TenKM']);
        $stmt->bindValue(':MoTa', $data['MoTa'] ?: null);
        $stmt->bindValue(':PhanTramGiamGia', $data['PhanTramGiamGia'] !== '' ? $data['PhanTramGiamGia'] : null);
        $stmt->bindValue(':SoTienGiamGia', $data['SoTienGiamGia'] !== '' ? $data['SoTienGiamGia'] : null);
        $stmt->bindValue(':NgayBatDau', $data['NgayBatDau'] ?: null);
        $stmt->bindValue(':NgayKetThuc', $data['NgayKetThuc'] ?: null);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare('DELETE FROM khuyenmai WHERE MaKM = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Lấy khuyến mãi theo danh mục sản phẩm
     */
    public function getByCategory(int $categoryId): array {
        try {
            $sql = "
                SELECT km.* 
                FROM khuyenmai km
                INNER JOIN khuyenmai_danhmuc kmd ON km.MaKM = kmd.MaKM
                WHERE kmd.MaDM = :categoryId
                ORDER BY km.MaKM DESC
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Lỗi khi lấy khuyến mãi theo danh mục: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Lấy khuyến mãi còn hiệu lực
     */
    public function getActive(): array {
        try {
            $currentDate = date('Y-m-d');
            $sql = "
                SELECT * FROM khuyenmai 
                WHERE (NgayKetThuc IS NULL OR NgayKetThuc >= :currentDate)
                AND (NgayBatDau IS NULL OR NgayBatDau <= :currentDate)
                ORDER BY MaKM DESC
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':currentDate', $currentDate);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Lỗi khi lấy khuyến mãi còn hiệu lực: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Lấy khuyến mãi sắp hết hạn (còn 7 ngày)
     */
    public function getExpiringSoon(): array {
        try {
            $currentDate = date('Y-m-d');
            $sevenDaysLater = date('Y-m-d', strtotime('+7 days'));
            
            $sql = "
                SELECT * FROM khuyenmai 
                WHERE NgayKetThuc BETWEEN :currentDate AND :sevenDaysLater
                ORDER BY NgayKetThuc ASC
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':currentDate', $currentDate);
            $stmt->bindValue(':sevenDaysLater', $sevenDaysLater);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Lỗi khi lấy khuyến mãi sắp hết hạn: " . $e->getMessage());
            return [];
        }
    }
}
