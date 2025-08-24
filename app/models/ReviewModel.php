<?php
// File: app/models/ReviewModel.php
require_once __DIR__ . '/../../config/database.php';

class ReviewModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    /**
     * Lấy đánh giá sản phẩm với logic nghiệp vụ chính xác
     * @param int|null $productId - ID sản phẩm (null để lấy tất cả)
     * @param int $limit - Số lượng đánh giá tối đa
     * @param bool $onlyVerified - Chỉ lấy đánh giá từ khách hàng đã mua hàng
     * @return array
     */
    public function getProductReviews($productId = null, $limit = 10, $onlyVerified = true) {
        $sql = "
            SELECT 
                dg.MaDG,
                dg.SoSao,
                dg.NoiDung,
                dg.NgayDanhGia,
                dg.MaSP,
                kh.HoTen as TenKhachHang,
                kh.MaKH,
                sp.TenSP as TenSanPham,
                sp.MaSP as MaSanPham,
                CASE 
                    WHEN dg.MaDH IS NOT NULL THEN 'Đã mua hàng'
                    ELSE 'Chưa mua hàng'
                END as TrangThaiMuaHang
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
        
        // Chỉ lấy đánh giá từ khách hàng đã mua hàng nếu yêu cầu
        if ($onlyVerified) {
            $sql .= " AND dg.MaDH IS NOT NULL";
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

    /**
     * Tính điểm đánh giá trung bình với logic nghiệp vụ
     * @param int|null $productId - ID sản phẩm (null để tính tổng quát)
     * @param bool $onlyVerified - Chỉ tính đánh giá từ khách hàng đã mua hàng
     * @return array
     */
    public function getAverageRating($productId = null, $onlyVerified = true) {
        $sql = "
            SELECT 
                AVG(SoSao) as TrungBinh,
                COUNT(*) as TongDanhGia,
                COUNT(CASE WHEN SoSao = 5 THEN 1 END) as SoSao5,
                COUNT(CASE WHEN SoSao = 4 THEN 1 END) as SoSao4,
                COUNT(CASE WHEN SoSao = 3 THEN 1 END) as SoSao3,
                COUNT(CASE WHEN SoSao = 2 THEN 1 END) as SoSao2,
                COUNT(CASE WHEN SoSao = 1 THEN 1 END) as SoSao1
            FROM danhgia
            WHERE 1=1
        ";
        
        $params = [];
        
        if ($productId) {
            $sql .= " AND MaSP = :productId";
            $params[':productId'] = $productId;
        }
        
        // Chỉ tính đánh giá từ khách hàng đã mua hàng nếu yêu cầu
        if ($onlyVerified) {
            $sql .= " AND MaDH IS NOT NULL";
        }
        
        $stmt = $this->db->prepare($sql);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Tính phần trăm cho từng mức sao
        if ($result['TongDanhGia'] > 0) {
            $result['PhanTram5'] = round(($result['SoSao5'] / $result['TongDanhGia']) * 100, 1);
            $result['PhanTram4'] = round(($result['SoSao4'] / $result['TongDanhGia']) * 100, 1);
            $result['PhanTram3'] = round(($result['SoSao3'] / $result['TongDanhGia']) * 100, 1);
            $result['PhanTram2'] = round(($result['SoSao2'] / $result['TongDanhGia']) * 100, 1);
            $result['PhanTram1'] = round(($result['SoSao1'] / $result['TongDanhGia']) * 100, 1);
        } else {
            $result['PhanTram5'] = $result['PhanTram4'] = $result['PhanTram3'] = $result['PhanTram2'] = $result['PhanTram1'] = 0;
        }
        
        return $result;
    }

    /**
     * Lấy sản phẩm có đánh giá cao nhất với logic nghiệp vụ
     * @param int $limit - Số lượng sản phẩm
     * @param bool $onlyVerified - Chỉ tính đánh giá từ khách hàng đã mua hàng
     * @return array
     */
    public function getTopRatedProducts($limit = 6, $onlyVerified = true) {
        $sql = "
            SELECT 
                sp.MaSP,
                sp.TenSP,
                sp.MoTa,
                sp.DonGia,
                sp.HinhAnh,
                dm.TenDanhMuc,
                AVG(dg.SoSao) as TrungBinhSao,
                COUNT(dg.MaDG) as SoDanhGia,
                COUNT(CASE WHEN dg.SoSao = 5 THEN 1 END) as SoSao5
            FROM sanpham sp
            LEFT JOIN danhmuc dm ON sp.MaDM = dm.MaDM
            LEFT JOIN danhgia dg ON sp.MaSP = dg.MaSP
        ";
        
        if ($onlyVerified) {
            $sql .= " AND dg.MaDH IS NOT NULL";
        }
        
        $sql .= "
            GROUP BY sp.MaSP
            HAVING TrungBinhSao IS NOT NULL AND SoDanhGia >= 1
            ORDER BY TrungBinhSao DESC, SoDanhGia DESC, SoSao5 DESC
            LIMIT :limit
        ";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Kiểm tra khách hàng có thể đánh giá sản phẩm không
     * Logic mới: Mỗi đơn hàng là một đánh giá riêng biệt
     * @param int $customerId - ID khách hàng
     * @param int $productId - ID sản phẩm
     * @return array
     */
    public function canCustomerReview($customerId, $productId) {
        if (!$customerId || !$productId) {
            return [
                'canReview' => false,
                'reason' => 'Thông tin không hợp lệ',
                'purchasedProducts' => []
            ];
        }

        // Kiểm tra khách hàng đã mua sản phẩm này chưa
        $sql = "
            SELECT 
                dh.MaDH,
                dh.NgayDatHang,
                dh.TrangThai,
                ctdh.SoLuong,
                ctdh.DonGia
            FROM donhang dh
            INNER JOIN chitietdonhang ctdh ON dh.MaDH = ctdh.MaDH
            WHERE dh.MaKH = :customerId 
            AND ctdh.MaSP = :productId
            AND dh.TrangThai = 'Delivered'
            ORDER BY dh.NgayDatHang DESC
        ";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':customerId', $customerId, PDO::PARAM_INT);
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
        $stmt->execute();
        
        $purchasedProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($purchasedProducts)) {
            return [
                'canReview' => false,
                'reason' => 'Bạn cần mua sản phẩm này trước khi đánh giá',
                'purchasedProducts' => []
            ];
        }
        
        // Kiểm tra các đơn hàng chưa được đánh giá
        $unreviewedOrders = [];
        foreach ($purchasedProducts as $order) {
            // Kiểm tra đã đánh giá đơn hàng này chưa
            $sql = "
                SELECT MaDG, NgayDanhGia
                FROM danhgia
                WHERE MaKH = :customerId 
                AND MaSP = :productId 
                AND MaDH = :orderId
                LIMIT 1
            ";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':customerId', $customerId, PDO::PARAM_INT);
            $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
            $stmt->bindParam(':orderId', $order['MaDH'], PDO::PARAM_INT);
            $stmt->execute();
            
            $existingReview = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$existingReview) {
                $unreviewedOrders[] = $order;
            }
        }
        
        if (empty($unreviewedOrders)) {
            return [
                'canReview' => false,
                'reason' => 'Bạn đã đánh giá tất cả các lần mua sản phẩm này',
                'purchasedProducts' => $purchasedProducts
            ];
        }
        
        return [
            'canReview' => true,
            'reason' => 'Bạn có thể đánh giá sản phẩm này cho các đơn hàng chưa đánh giá',
            'purchasedProducts' => $unreviewedOrders
        ];
    }

    /**
     * Tạo đánh giá mới với validation nghiệp vụ
     * @param int $customerId - ID khách hàng
     * @param int $productId - ID sản phẩm
     * @param int $orderId - ID đơn hàng (để verify)
     * @param int $rating - Điểm đánh giá (1-5)
     * @param string $content - Nội dung đánh giá
     * @return array
     */
    public function createReview($customerId, $productId, $orderId, $rating, $content) {
        // Validation cơ bản
        if (!$customerId || !$productId || !$orderId || !$rating) {
            return [
                'success' => false,
                'message' => 'Thông tin đánh giá không đầy đủ'
            ];
        }
        
        if ($rating < 1 || $rating > 5) {
            return [
                'success' => false,
                'message' => 'Điểm đánh giá phải từ 1-5 sao'
            ];
        }
        
        // Nội dung không bắt buộc, có thể để trống hoặc nhập bất kỳ độ dài nào
        
        // Kiểm tra đã đánh giá đơn hàng này chưa
        $sql = "
            SELECT MaDG, NgayDanhGia
            FROM danhgia
            WHERE MaKH = :customerId 
            AND MaSP = :productId 
            AND MaDH = :orderId
            LIMIT 1
        ";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':customerId', $customerId, PDO::PARAM_INT);
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
        $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        
        $existingReview = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($existingReview) {
            return [
                'success' => false,
                'message' => 'Bạn đã đánh giá sản phẩm này cho đơn hàng này rồi'
            ];
        }
        
        // Kiểm tra đơn hàng có chứa sản phẩm này không
        $sql = "
            SELECT COUNT(*) as count
            FROM chitietdonhang ctdh
            INNER JOIN donhang dh ON ctdh.MaDH = dh.MaDH
            WHERE dh.MaKH = :customerId 
            AND dh.MaDH = :orderId 
            AND ctdh.MaSP = :productId
            AND dh.TrangThai = 'Delivered'
        ";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':customerId', $customerId, PDO::PARAM_INT);
        $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result['count'] == 0) {
            return [
                'success' => false,
                'message' => 'Đơn hàng không hợp lệ hoặc chưa hoàn thành'
            ];
        }
        
        // Tạo đánh giá
        try {
            $sql = "
                INSERT INTO danhgia (MaKH, MaSP, MaDH, SoSao, NoiDung, NgayDanhGia)
                VALUES (:customerId, :productId, :orderId, :rating, :content, NOW())
            ";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':customerId', $customerId, PDO::PARAM_INT);
            $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
            $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
            $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
            $stmt->bindParam(':content', $content);
            
            if ($stmt->execute()) {
                return [
                    'success' => true,
                    'message' => 'Đánh giá đã được gửi thành công',
                    'reviewId' => $this->db->lastInsertId()
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi gửi đánh giá'
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Lấy đánh giá của khách hàng cho sản phẩm
     * @param int $customerId - ID khách hàng
     * @param int $productId - ID sản phẩm
     * @return array|null
     */
    public function getCustomerReview($customerId, $productId) {
        $sql = "
            SELECT 
                dg.MaDG,
                dg.SoSao,
                dg.NoiDung,
                dg.NgayDanhGia,
                dg.MaDH,
                sp.TenSP,
                dh.NgayDatHang
            FROM danhgia dg
            LEFT JOIN sanpham sp ON dg.MaSP = sp.MaSP
            LEFT JOIN donhang dh ON dg.MaDH = dh.MaDH
            WHERE dg.MaKH = :customerId AND dg.MaSP = :productId
            ORDER BY dg.NgayDanhGia DESC
        ";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':customerId', $customerId, PDO::PARAM_INT);
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy thống kê đánh giá chi tiết
     * @param int|null $productId - ID sản phẩm (null để lấy tổng quát)
     * @return array
     */
    public function getReviewStatistics($productId = null) {
        $sql = "
            SELECT 
                COUNT(*) as TongDanhGia,
                AVG(SoSao) as TrungBinh,
                COUNT(CASE WHEN SoSao = 5 THEN 1 END) as SoSao5,
                COUNT(CASE WHEN SoSao = 4 THEN 1 END) as SoSao4,
                COUNT(CASE WHEN SoSao = 3 THEN 1 END) as SoSao3,
                COUNT(CASE WHEN SoSao = 2 THEN 1 END) as SoSao2,
                COUNT(CASE WHEN SoSao = 1 THEN 1 END) as SoSao1,
                COUNT(CASE WHEN MaDH IS NOT NULL THEN 1 END) as DanhGiaXacThuc,
                COUNT(CASE WHEN MaDH IS NULL THEN 1 END) as DanhGiaChuaXacThuc
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
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Tính phần trăm
        if ($result['TongDanhGia'] > 0) {
            $result['TyLeXacThuc'] = round(($result['DanhGiaXacThuc'] / $result['TongDanhGia']) * 100, 1);
            $result['TyLeChuaXacThuc'] = round(($result['DanhGiaChuaXacThuc'] / $result['TongDanhGia']) * 100, 1);
        } else {
            $result['TyLeXacThuc'] = $result['TyLeChuaXacThuc'] = 0;
        }
        
        return $result;
    }

    /**
     * Xóa đánh giá (cho admin)
     * @param int $reviewId - ID đánh giá
     * @return array
     */
    public function deleteReview($reviewId) {
        if (!$reviewId) {
            return [
                'success' => false,
                'message' => 'ID đánh giá không hợp lệ'
            ];
        }

        try {
            // Kiểm tra đánh giá có tồn tại không
            $sql = "SELECT MaDG, MaKH, MaSP FROM danhgia WHERE MaDG = :reviewId";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':reviewId', $reviewId, PDO::PARAM_INT);
            $stmt->execute();
            
            $review = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$review) {
                return [
                    'success' => false,
                    'message' => 'Đánh giá không tồn tại'
                ];
            }

            // Xóa đánh giá
            $sql = "DELETE FROM danhgia WHERE MaDG = :reviewId";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':reviewId', $reviewId, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                return [
                    'success' => true,
                    'message' => 'Đã xóa đánh giá thành công',
                    'deletedReview' => $review
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi xóa đánh giá'
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ];
        }
    }

    public function getById($id) {
        $sql = "SELECT dg.*, kh.HoTen AS TenKhachHang, sp.TenSP AS TenSanPham,
                       CASE WHEN dg.MaDH IS NOT NULL THEN 1 ELSE 0 END AS IsVerified
                FROM danhgia dg
                LEFT JOIN khachhang kh ON dg.MaKH = kh.MaKH
                LEFT JOIN sanpham sp ON dg.MaSP = sp.MaSP
                WHERE dg.MaDG = :id LIMIT 1";
        $st = $this->db->prepare($sql);
        $st->bindValue(':id', $id, PDO::PARAM_INT);
        $st->execute();
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    /**
     * Admin list reviews with filters & pagination
     * @param array $opts [q, rating, verified, product_id, page, perPage]
     * @return array [data,total,page,perPage]
     */
    public function adminList(array $opts = []) {
        $q          = trim($opts['q'] ?? '');
        $rating     = isset($opts['rating']) && $opts['rating'] !== '' ? (int)$opts['rating'] : null;
        $verified   = isset($opts['verified']) && $opts['verified'] !== '' ? (int)$opts['verified'] : null; // 1|0
        $productId  = isset($opts['product_id']) && $opts['product_id'] !== '' ? (int)$opts['product_id'] : null;
        $page       = max(1, (int)($opts['page'] ?? 1));
        $perPage    = max(5, min(100, (int)($opts['perPage'] ?? 10)));
        $offset     = ($page - 1) * $perPage;

        $where  = [];
        $params = [];
        if ($q !== '') {
            $where[] = '(kh.HoTen LIKE :q OR sp.TenSP LIKE :q OR dg.NoiDung LIKE :q)';
            $params[':q'] = '%'.$q.'%';
        }
        if ($rating !== null) { $where[] = 'dg.SoSao = :rating'; $params[':rating'] = $rating; }
        if ($verified !== null) {
            if ($verified === 1) $where[] = 'dg.MaDH IS NOT NULL'; else $where[] = 'dg.MaDH IS NULL';
        }
        if ($productId !== null) { $where[] = 'dg.MaSP = :pid'; $params[':pid'] = $productId; }

        $whereSql = $where ? ('WHERE '.implode(' AND ',$where)) : '';

        $sql = "SELECT dg.MaDG, dg.SoSao, LEFT(dg.NoiDung,150) AS TomTat, dg.NgayDanhGia, dg.MaSP,
                       sp.TenSP AS TenSanPham, kh.HoTen AS TenKhachHang,
                       CASE WHEN dg.MaDH IS NOT NULL THEN 1 ELSE 0 END AS IsVerified
                FROM danhgia dg
                LEFT JOIN sanpham sp ON dg.MaSP = sp.MaSP
                LEFT JOIN khachhang kh ON dg.MaKH = kh.MaKH
                $whereSql
                ORDER BY dg.NgayDanhGia DESC
                LIMIT :limit OFFSET :offset";
        $st = $this->db->prepare($sql);
        foreach ($params as $k=>$v) $st->bindValue($k,$v);
        $st->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $st->bindValue(':offset', $offset, PDO::PARAM_INT);
        $st->execute();
        $data = $st->fetchAll(PDO::FETCH_ASSOC);

        $sqlCount = "SELECT COUNT(*) FROM danhgia dg
                     LEFT JOIN sanpham sp ON dg.MaSP = sp.MaSP
                     LEFT JOIN khachhang kh ON dg.MaKH = kh.MaKH
                     $whereSql";
        $stc = $this->db->prepare($sqlCount);
        foreach ($params as $k=>$v) $stc->bindValue($k,$v);
        $stc->execute();
        $total = (int)$stc->fetchColumn();

        return [
            'data' => $data,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage
        ];
    }
}
