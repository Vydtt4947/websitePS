<?php
// File: app/models/PromotionModel.php
require_once __DIR__ . '/../../config/database.php';

class PromotionModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    // PHƯƠNG THỨC TÍNH TOÁN ƯU ĐÃI DỰA TRÊN PHÂN KHÚC KHÁCH HÀNG
    public function calculateTierDiscount($customerId, $orderTotal) {
        if (!$customerId) {
            return [
                'discount' => 0,
                'discountType' => 'percentage',
                'description' => '',
                'promotionType' => 'tier_discount'
            ];
        }

        // Lấy thông tin phân khúc khách hàng
        $query = "SELECT kh.MaPK, pk.TenPK, pk.MoTa,
                         COALESCE(SUM(CASE WHEN dh.TrangThai = 'Delivered' THEN dh.TongTien ELSE 0 END), 0) as totalSpent
                  FROM khachhang kh
                  LEFT JOIN phankhuckh pk ON kh.MaPK = pk.MaPK
                  LEFT JOIN donhang dh ON kh.MaKH = dh.MaKH
                  WHERE kh.MaKH = :customerId
                  GROUP BY kh.MaKH, kh.MaPK, pk.TenPK, pk.MoTa";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':customerId', $customerId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return [
                'discount' => 0,
                'discountType' => 'percentage',
                'description' => '',
                'promotionType' => 'tier_discount'
            ];
        }

        $tierName = $result['TenPK'] ?? 'Chưa phân loại';
        $totalSpent = $result['totalSpent'];

        // Xác định ưu đãi dựa trên phân khúc
        $discount = 0;
        $description = '';

        switch ($tierName) {
            case 'Bronze':
                if ($orderTotal >= 200000) {
                    $discount = $orderTotal * 0.05; // 5%
                    $description = 'Ưu đãi Bronze: Giảm 5% cho đơn hàng từ 200k';
                }
                break;
            
            case 'Silver':
                if ($orderTotal >= 150000) {
                    $discount = $orderTotal * 0.08; // 8%
                    $description = 'Ưu đãi Silver: Giảm 8% cho đơn hàng từ 150k';
                }
                break;
            
            case 'Gold':
                if ($orderTotal >= 100000) {
                    $discount = $orderTotal * 0.12; // 12%
                    $description = 'Ưu đãi Gold: Giảm 12% cho đơn hàng từ 100k';
                }
                break;
            
            case 'Platinum':
                if ($orderTotal >= 80000) {
                    $discount = $orderTotal * 0.15; // 15%
                    $description = 'Ưu đãi Platinum: Giảm 15% cho đơn hàng từ 80k';
                }
                break;
            
            case 'Diamond':
                if ($orderTotal >= 50000) {
                    $discount = $orderTotal * 0.18; // 18%
                    $description = 'Ưu đãi Diamond: Giảm 18% cho đơn hàng từ 50k';
                }
                break;
            
            case 'VIP':
                // VIP luôn được giảm giá
                $discount = $orderTotal * 0.20; // 20%
                $description = 'Ưu đãi VIP: Giảm 20% cho mọi đơn hàng';
                break;
            
            default:
                // Chưa phân loại - không có ưu đãi
                $discount = 0;
                $description = '';
                break;
        }

        return [
            'discount' => $discount,
            'discountType' => 'percentage',
            'description' => $description,
            'promotionType' => 'tier_discount',
            'tierName' => $tierName,
            'totalSpent' => $totalSpent
        ];
    }

    // PHƯƠNG THỨC TỰ ĐỘNG ÁP DỤNG ƯU ĐÃI PHÂN KHÚC VÀO GIỎ HÀNG
    public function autoApplyTierDiscount($customerId, $orderTotal) {
        if (!$customerId) {
            return [
                'discount' => 0,
                'discountType' => 'percentage',
                'description' => '',
                'promotionType' => 'tier_discount',
                'isAutoApplied' => false
            ];
        }

        // Lấy thông tin phân khúc khách hàng
        $query = "SELECT kh.MaPK, pk.TenPK, pk.MoTa,
                         COALESCE(SUM(CASE WHEN dh.TrangThai = 'Delivered' THEN dh.TongTien ELSE 0 END), 0) as totalSpent
                  FROM khachhang kh
                  LEFT JOIN phankhuckh pk ON kh.MaPK = pk.MaPK
                  LEFT JOIN donhang dh ON kh.MaKH = dh.MaKH
                  WHERE kh.MaKH = :customerId
                  GROUP BY kh.MaKH, kh.MaPK, pk.TenPK, pk.MoTa";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':customerId', $customerId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return [
                'discount' => 0,
                'discountType' => 'percentage',
                'description' => '',
                'promotionType' => 'tier_discount',
                'isAutoApplied' => false
            ];
        }

        $tierName = $result['TenPK'] ?? 'Chưa phân loại';
        $totalSpent = $result['totalSpent'];

        // Xác định ưu đãi dựa trên phân khúc
        $discount = 0;
        $description = '';
        $isAutoApplied = false;

        switch ($tierName) {
            case 'Bronze':
                if ($orderTotal >= 200000) {
                    $discount = $orderTotal * 0.05; // 5%
                    $description = 'Ưu đãi Bronze: Giảm 5% cho đơn hàng từ 200k';
                    $isAutoApplied = true;
                }
                break;
            
            case 'Silver':
                if ($orderTotal >= 150000) {
                    $discount = $orderTotal * 0.08; // 8%
                    $description = 'Ưu đãi Silver: Giảm 8% cho đơn hàng từ 150k';
                    $isAutoApplied = true;
                }
                break;
            
            case 'Gold':
                if ($orderTotal >= 100000) {
                    $discount = $orderTotal * 0.12; // 12%
                    $description = 'Ưu đãi Gold: Giảm 12% cho đơn hàng từ 100k';
                    $isAutoApplied = true;
                }
                break;
            
            case 'Platinum':
                if ($orderTotal >= 80000) {
                    $discount = $orderTotal * 0.15; // 15%
                    $description = 'Ưu đãi Platinum: Giảm 15% cho đơn hàng từ 80k';
                    $isAutoApplied = true;
                }
                break;
            
            case 'Diamond':
                if ($orderTotal >= 50000) {
                    $discount = $orderTotal * 0.18; // 18%
                    $description = 'Ưu đãi Diamond: Giảm 18% cho đơn hàng từ 50k';
                    $isAutoApplied = true;
                }
                break;
            
            case 'VIP':
                // VIP luôn được giảm giá
                $discount = $orderTotal * 0.20; // 20%
                $description = 'Ưu đãi VIP: Giảm 20% cho mọi đơn hàng';
                $isAutoApplied = true;
                break;
            
            default:
                // Chưa phân loại - không có ưu đãi
                $discount = 0;
                $description = '';
                $isAutoApplied = false;
                break;
        }

        return [
            'discount' => $discount,
            'discountType' => 'percentage',
            'description' => $description,
            'promotionType' => 'tier_discount',
            'tierName' => $tierName,
            'totalSpent' => $totalSpent,
            'isAutoApplied' => $isAutoApplied,
            'isSelected' => $isAutoApplied // Tự động chọn nếu được áp dụng
        ];
    }

    // PHƯƠNG THỨC TÍNH TOÁN TẤT CẢ ƯU ĐÃI (TIER + MÃ GIẢM GIÁ) - THEO THỨ TỰ VỚI GIỚI HẠN 40%
    public function calculateAllDiscounts($customerId, $orderTotal, $productCategory = null, $selectedPromotions = []) {
        $allPromotions = [];
        $remainingTotal = $orderTotal;
        $totalDiscount = 0;
        $maxDiscount = $orderTotal * 0.4; // Giới hạn tối đa 40%
        $maxPromotions = 3; // Giới hạn tối đa 3 khuyến mãi được chọn
        $selectedCount = 0;

        // 1. Ưu đãi dựa trên phân khúc khách hàng (TỰ ĐỘNG ÁP DỤNG)
        $tierDiscount = $this->autoApplyTierDiscount($customerId, $remainingTotal);
        if ($tierDiscount['discount'] > 0 && $tierDiscount['isAutoApplied']) {
            // Tự động áp dụng ưu đãi phân khúc
            $actualTierDiscount = min($tierDiscount['discount'], $maxDiscount - $totalDiscount);
            if ($actualTierDiscount > 0) {
                $tierDiscount['discount'] = $actualTierDiscount;
                $tierDiscount['originalDiscount'] = $tierDiscount['discount'];
                $tierDiscount['isSelected'] = true;
                $tierDiscount['isAutoApplied'] = true; // Đánh dấu là tự động áp dụng
                $allPromotions[] = $tierDiscount;
                $totalDiscount += $actualTierDiscount;
                $remainingTotal -= $actualTierDiscount;
                $selectedCount++;
            }
        } else {
            // Đánh dấu ưu đãi tier không được áp dụng
            $tierDiscount['isSelected'] = false;
            $tierDiscount['isAutoApplied'] = false;
            $allPromotions[] = $tierDiscount;
        }

        // 2. Mã giảm giá từ database (theo lựa chọn của khách hàng)
        $databasePromotions = $this->getDatabasePromotions($customerId, $remainingTotal, $productCategory);
        
        foreach ($databasePromotions as $promotion) {
            // Kiểm tra xem khách hàng có chọn ưu đãi này không
            $isSelected = in_array($promotion['promotionType'], $selectedPromotions);
            
            if ($isSelected && $promotion['discount'] > 0 && $remainingTotal > 0 && $totalDiscount < $maxDiscount && $selectedCount < $maxPromotions) {
                // Tính toán giảm giá có thể áp dụng
                $availableDiscount = $maxDiscount - $totalDiscount;
                $promotionDiscount = min($promotion['discount'], $remainingTotal, $availableDiscount);
                
                if ($promotionDiscount > 0) {
                    $promotion['discount'] = $promotionDiscount;
                    $promotion['originalDiscount'] = $promotion['discount'];
                    $promotion['isSelected'] = true;
                    $promotion['isAutoApplied'] = false; // Đánh dấu là khách hàng chọn
                    
                    $allPromotions[] = $promotion;
                    $totalDiscount += $promotionDiscount;
                    $remainingTotal -= $promotionDiscount;
                    $selectedCount++;
                }
            } else {
                // Đánh dấu ưu đãi không được chọn
                $promotion['isSelected'] = false;
                $promotion['isAutoApplied'] = false;
                $allPromotions[] = $promotion;
            }
        }

        return [
            'promotions' => $allPromotions,
            'totalDiscount' => $totalDiscount,
            'finalTotal' => $orderTotal - $totalDiscount,
            'remainingTotal' => $remainingTotal,
            'maxDiscount' => $maxDiscount,
            'discountPercentage' => ($totalDiscount / $orderTotal) * 100
        ];
    }

    // PHƯƠNG THỨC LẤY TẤT CẢ ƯU ĐÃI CÓ THỂ ÁP DỤNG
    public function getAvailablePromotions($customerId, $orderTotal, $productCategory = null) {
        $availablePromotions = [];
        
        // 1. Ưu đãi phân khúc
        $tierDiscount = $this->calculateTierDiscount($customerId, $orderTotal);
        if ($tierDiscount['discount'] > 0) {
            $availablePromotions[] = $tierDiscount;
        }
        
        // 2. Mã giảm giá từ database
        $databasePromotions = $this->getDatabasePromotions($customerId, $orderTotal, $productCategory);
        foreach ($databasePromotions as $promotion) {
            if ($promotion['discount'] > 0) {
                $availablePromotions[] = $promotion;
            }
        }
        
        return $availablePromotions;
    }

    // PHƯƠNG THỨC LẤY MÃ GIẢM GIÁ TỪ DATABASE
    private function getDatabasePromotions($customerId, $orderTotal, $productCategory = null) {
        $promotions = [];
        
        try {
            // Lấy tất cả khuyến mãi đang hoạt động từ database
            $query = "SELECT * FROM khuyenmai 
                     WHERE NgayBatDau <= CURDATE() 
                     AND NgayKetThuc >= CURDATE() 
                     ORDER BY MaKM DESC";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $databasePromotions = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($databasePromotions as $promo) {
                $discount = 0;
                $discountType = '';
                $description = '';
                
                // Tính toán giảm giá dựa trên loại khuyến mãi
                if ($promo['PhanTramGiamGia'] > 0) {
                    // Giảm giá theo phần trăm
                    $discount = $orderTotal * ($promo['PhanTramGiamGia'] / 100);
                    $discountType = 'percentage';
                    $description = $promo['MoTa'] . ' - Giảm ' . $promo['PhanTramGiamGia'] . '%';
                } elseif ($promo['SoTienGiamGia'] > 0) {
                    // Giảm giá theo số tiền cố định
                    $discount = min($promo['SoTienGiamGia'], $orderTotal);
                    $discountType = 'fixed';
                    $description = $promo['MoTa'] . ' - Giảm ' . number_format($promo['SoTienGiamGia'], 0, ',', '.') . ' VNĐ';
                }
                
                if ($discount > 0) {
                    $promotions[] = [
                        'discount' => $discount,
                        'discountType' => $discountType,
                        'description' => $description,
                        'promotionType' => 'db_promo_' . $promo['MaKM'],
                        'promotionId' => $promo['MaKM'],
                        'promotionName' => $promo['TenKM'],
                        'originalDiscount' => $discount
                    ];
                }
            }
            
        } catch (Exception $e) {
            error_log("Error getting database promotions: " . $e->getMessage());
        }
        
        return $promotions;
    }

    // PHƯƠNG THỨC LẤY THÔNG TIN ƯU ĐÃI THEO PHÂN KHÚC
    public function getTierBenefits($tierName) {
        $benefits = [
            'Bronze' => [
                'discount' => '5%',
                'minOrder' => '200,000đ',
                'description' => 'Giảm 5% cho đơn hàng từ 200k',
                'icon' => 'fas fa-medal',
                'color' => '#cd7f32'
            ],
            'Silver' => [
                'discount' => '8%',
                'minOrder' => '150,000đ',
                'description' => 'Giảm 8% cho đơn hàng từ 150k',
                'icon' => 'fas fa-medal',
                'color' => '#c0c0c0'
            ],
            'Gold' => [
                'discount' => '12%',
                'minOrder' => '100,000đ',
                'description' => 'Giảm 12% cho đơn hàng từ 100k',
                'icon' => 'fas fa-medal',
                'color' => '#ffd700'
            ],
            'Platinum' => [
                'discount' => '15%',
                'minOrder' => '80,000đ',
                'description' => 'Giảm 15% cho đơn hàng từ 80k',
                'icon' => 'fas fa-gem',
                'color' => '#e5e4e2'
            ],
            'Diamond' => [
                'discount' => '18%',
                'minOrder' => '50,000đ',
                'description' => 'Giảm 18% cho đơn hàng từ 50k',
                'icon' => 'fas fa-gem',
                'color' => '#b9f2ff'
            ],
            'VIP' => [
                'discount' => '20%',
                'minOrder' => 'Không giới hạn',
                'description' => 'Giảm 20% cho mọi đơn hàng',
                'icon' => 'fas fa-crown',
                'color' => '#ff6b35'
            ]
        ];

        return $benefits[$tierName] ?? null;
    }

    // PHƯƠNG THỨC TÍNH TOÁN MÃ GIẢM GIÁ THEO LOẠI
    public function calculateDiscount($promotionType, $orderTotal, $productCategory = null) {
        $discount = 0;
        $discountType = '';
        $description = '';

        // Kiểm tra nếu là mã giảm giá từ database
        if (strpos($promotionType, 'db_promo_') === 0) {
            $promotionId = str_replace('db_promo_', '', $promotionType);
            $databasePromotions = $this->getDatabasePromotions(null, $orderTotal, $productCategory);
            
            foreach ($databasePromotions as $promo) {
                if ($promo['promotionId'] == $promotionId) {
                    $discount = $promo['discount'];
                    $discountType = $promo['discountType'];
                    $description = $promo['description'];
                    break;
                }
            }
        }

        return [
            'discount' => $discount,
            'discountType' => $discountType,
            'description' => $description,
            'promotionType' => $promotionType
        ];
    }

    public function isPromotionActive($promotionType) {
        // Kiểm tra nếu là mã giảm giá từ database
        if (strpos($promotionType, 'db_promo_') === 0) {
            $promotionId = str_replace('db_promo_', '', $promotionType);
            try {
                $query = "SELECT COUNT(*) FROM khuyenmai 
                         WHERE MaKM = :id 
                         AND NgayBatDau <= CURDATE() 
                         AND NgayKetThuc >= CURDATE()";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':id', $promotionId);
                $stmt->execute();
                return $stmt->fetchColumn() > 0;
            } catch (Exception $e) {
                error_log("Error checking promotion active: " . $e->getMessage());
                return false;
            }
        }
        
        // Ưu đãi phân khúc luôn active
        if ($promotionType === 'tier_discount') {
            return true;
        }
        
        return false;
    }

    public function getActivePromotions() {
        $promotions = [];
        
        try {
            // Lấy tất cả khuyến mãi đang hoạt động từ database
            $query = "SELECT MaKM, TenKM, MoTa FROM khuyenmai 
                     WHERE NgayBatDau <= CURDATE() 
                     AND NgayKetThuc >= CURDATE() 
                     ORDER BY MaKM DESC";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $databasePromotions = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($databasePromotions as $promo) {
                $promotions['db_promo_' . $promo['MaKM']] = $promo['TenKM'] . ' - ' . $promo['MoTa'];
            }
            
        } catch (Exception $e) {
            error_log("Error getting active promotions: " . $e->getMessage());
        }
        
        // Thêm ưu đãi phân khúc
        $promotions['tier_discount'] = 'Ưu đãi phân khúc khách hàng';
        
        return $promotions;
    }

    /**
     * Lấy danh sách ưu đãi có thể chọn bằng checkbox (chỉ ưu đãi phân khúc)
     */
    public function getSelectablePromotions() {
        $promotions = [];
        
        // Chỉ trả về ưu đãi phân khúc để hiển thị checkbox
        $promotions[] = [
            'promotionType' => 'tier_discount',
            'description' => 'Ưu đãi phân khúc khách hàng',
            'discount' => 0, // Sẽ được tính toán dựa trên phân khúc thực tế
            'icon' => 'fas fa-crown',
            'color' => '#ffc107'
        ];
        
        return $promotions;
    }

    /**
     * Kiểm tra và validate mã khuyến mãi từ input của khách hàng
     */
    public function validateCouponCode(string $couponCode, float $orderTotal = 0): ?array {
        try {
            // Debug log
            error_log("DEBUG validateCouponCode: Validating coupon code: " . $couponCode);
            
            // Trước tiên, kiểm tra xem mã có tồn tại không (không quan tâm ngày tháng)
            $checkSql = "SELECT * FROM khuyenmai WHERE TenKM = :coupon_code LIMIT 1";
            $checkStmt = $this->db->prepare($checkSql);
            $checkStmt->bindParam(':coupon_code', $couponCode, PDO::PARAM_STR);
            $checkStmt->execute();
            $checkResult = $checkStmt->fetch(PDO::FETCH_ASSOC);
            
            error_log("DEBUG validateCouponCode: Raw check result: " . json_encode($checkResult));
            
            if (!$checkResult) {
                error_log("DEBUG validateCouponCode: Coupon code not found in database");
                return null;
            }
            
            // Kiểm tra trạng thái (nếu có cột TrangThai)
            if (isset($checkResult['TrangThai']) && $checkResult['TrangThai'] !== 'active') {
                error_log("DEBUG validateCouponCode: Coupon status is not active: " . $checkResult['TrangThai']);
                return null;
            }
            
            // Kiểm tra ngày tháng
            $currentDate = date('Y-m-d');
            $startDate = $checkResult['NgayBatDau'];
            $endDate = $checkResult['NgayKetThuc'];
            
            error_log("DEBUG validateCouponCode: Current date: " . $currentDate);
            error_log("DEBUG validateCouponCode: Start date: " . $startDate);
            error_log("DEBUG validateCouponCode: End date: " . $endDate);
            
            // So sánh ngày tháng
            if ($startDate > $currentDate) {
                error_log("DEBUG validateCouponCode: Coupon start date is in the future");
                return null;
            }
            
            if ($endDate < $currentDate) {
                error_log("DEBUG validateCouponCode: Coupon end date has passed");
                return null;
            }
            
            // Kiểm tra điều kiện đơn hàng cho mã FREESHIP
            if (strtoupper($couponCode) === 'FREESHIP') {
                if ($orderTotal < 500000) {
                    error_log("DEBUG validateCouponCode: FREESHIP requires order total >= 500,000 VND, current: " . $orderTotal);
                    return null;
                }
                error_log("DEBUG validateCouponCode: FREESHIP order total requirement met: " . $orderTotal);
            }
            
            error_log("DEBUG validateCouponCode: Coupon is valid and active");
            
            // Trả về thông tin đầy đủ bao gồm promotionType để sử dụng trong logic
            $result = $checkResult;
            $result['promotionType'] = 'db_promo_' . $checkResult['MaKM'];
            $result['displayName'] = $checkResult['TenKM'];
            $result['description'] = $checkResult['MoTa'];
            
            return $result;
            
        } catch (Exception $e) {
            error_log("Error validating coupon code: " . $e->getMessage());
            return null;
        }
    }
}
?>
