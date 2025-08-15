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

    // PHƯƠNG THỨC TÍNH TOÁN TẤT CẢ ƯU ĐÃI (TIER + KHÁC) - THEO THỨ TỰ VỚI GIỚI HẠN 40%
    public function calculateAllDiscounts($customerId, $orderTotal, $productCategory = null, $selectedPromotions = []) {
        $allPromotions = [];
        $remainingTotal = $orderTotal;
        $totalDiscount = 0;
        $maxDiscount = $orderTotal * 0.4; // Giới hạn tối đa 40%
        $maxPromotions = 3; // Giới hạn tối đa 3 khuyến mãi được chọn
        $selectedCount = 0;

        // 1. Ưu đãi dựa trên phân khúc khách hàng (chỉ áp dụng khi khách hàng chọn)
        $tierDiscount = $this->calculateTierDiscount($customerId, $remainingTotal);
        if ($tierDiscount['discount'] > 0) {
            $isTierSelected = in_array('tier_discount', $selectedPromotions);
            if ($isTierSelected && $selectedCount < $maxPromotions) {
                $actualTierDiscount = min($tierDiscount['discount'], $maxDiscount - $totalDiscount);
                if ($actualTierDiscount > 0) {
                    $tierDiscount['discount'] = $actualTierDiscount;
                    $tierDiscount['originalDiscount'] = $tierDiscount['discount'];
                    $tierDiscount['isSelected'] = true;
                    $tierDiscount['isAutoApplied'] = false; // Đánh dấu là khách hàng chọn
                    $allPromotions[] = $tierDiscount;
                    $totalDiscount += $actualTierDiscount;
                    $remainingTotal -= $actualTierDiscount;
                    $selectedCount++;
                }
            } else {
                // Đánh dấu ưu đãi tier không được chọn
                $tierDiscount['isSelected'] = false;
                $tierDiscount['isAutoApplied'] = false;
                $allPromotions[] = $tierDiscount;
            }
        }

        // 2. Ưu đãi khuyến mãi thông thường (theo lựa chọn của khách hàng)
        $regularPromotions = $this->calculateRegularPromotions($remainingTotal, $productCategory);
        $sortedPromotions = $this->sortPromotionsByPriority($regularPromotions);
        
        foreach ($sortedPromotions as $promotion) {
            // Kiểm tra xem khách hàng có chọn ưu đãi này không
            $isSelected = in_array($promotion['promotionType'], $selectedPromotions);
            
            // Debug log
            error_log("PromotionModel: Processing promotion " . $promotion['promotionType'] . " - Selected: " . ($isSelected ? 'true' : 'false'));
            
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
                    
                    error_log("PromotionModel: Applied promotion " . $promotion['promotionType'] . " - Discount: " . $promotionDiscount);
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
        
        // 2. Ưu đãi thông thường
        $regularPromotions = $this->calculateRegularPromotions($orderTotal, $productCategory);
        $sortedPromotions = $this->sortPromotionsByPriority($regularPromotions);
        
        foreach ($sortedPromotions as $promotion) {
            if ($promotion['discount'] > 0) {
                $availablePromotions[] = $promotion;
            }
        }
        
        return $availablePromotions;
    }

    // PHƯƠNG THỨC SẮP XẾP ƯU ĐÃI THEO THỨ TỰ ƯU TIÊN
    private function sortPromotionsByPriority($promotions) {
        // Định nghĩa thứ tự ưu tiên (số càng nhỏ càng ưu tiên cao)
        $priorityOrder = [
            'flash_sale_cupcake' => 1,    // Flash sale ưu tiên cao nhất
            'birthday_cake_25' => 2,      // Giảm giá bánh kem
            'general_20' => 3,            // Giảm giá chung
            'free_shipping' => 4          // Miễn phí vận chuyển cuối cùng
        ];

        // Sắp xếp theo thứ tự ưu tiên
        usort($promotions, function($a, $b) use ($priorityOrder) {
            $priorityA = $priorityOrder[$a['promotionType']] ?? 999;
            $priorityB = $priorityOrder[$b['promotionType']] ?? 999;
            return $priorityA - $priorityB;
        });

        return $promotions;
    }

    // PHƯƠNG THỨC TÍNH TOÁN ƯU ĐÃI THÔNG THƯỜNG
    private function calculateRegularPromotions($orderTotal, $productCategory = null) {
        $promotions = [];

        // Flash sale cupcake
        if ($productCategory && strpos(strtolower($productCategory), 'cupcake') !== false) {
            $discount = $orderTotal * 0.5;
            $promotions[] = [
                'discount' => $discount,
                'discountType' => 'percentage',
                'description' => 'Giảm 50% cho bánh Cupcake (Flash Sale)',
                'promotionType' => 'flash_sale_cupcake'
            ];
        }

        // Birthday cake 25%
        if ($productCategory && strpos(strtolower($productCategory), 'bánh kem') !== false) {
            $discount = $orderTotal * 0.25;
            $promotions[] = [
                'discount' => $discount,
                'discountType' => 'percentage',
                'description' => 'Giảm 25% cho bánh kem sinh nhật',
                'promotionType' => 'birthday_cake_25'
            ];
        }

        // General 20% for orders >= 500k
        if ($orderTotal >= 500000) {
            $discount = $orderTotal * 0.2;
            $promotions[] = [
                'discount' => $discount,
                'discountType' => 'percentage',
                'description' => 'Giảm 20% cho đơn hàng từ 500k',
                'promotionType' => 'general_20'
            ];
        }

        // Free shipping for orders >= 300k
        if ($orderTotal >= 300000) {
            $promotions[] = [
                'discount' => 15000,
                'discountType' => 'fixed',
                'description' => 'Miễn phí vận chuyển cho đơn hàng từ 300k',
                'promotionType' => 'free_shipping'
            ];
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

    // PHƯƠNG THỨC CŨ (GIỮ LẠI ĐỂ TƯƠNG THÍCH)
    public function calculateDiscount($promotionType, $orderTotal, $productCategory = null) {
        $discount = 0;
        $discountType = '';
        $description = '';

        switch ($promotionType) {
            case 'flash_sale_cupcake':
                if ($productCategory && strpos(strtolower($productCategory), 'cupcake') !== false) {
                    $discount = $orderTotal * 0.5;
                    $discountType = 'percentage';
                    $description = 'Giảm 50% cho bánh Cupcake (Flash Sale)';
                }
                break;

            case 'birthday_cake_25':
                if ($productCategory && strpos(strtolower($productCategory), 'bánh kem') !== false) {
                    $discount = $orderTotal * 0.25;
                    $discountType = 'percentage';
                    $description = 'Giảm 25% cho bánh kem sinh nhật';
                }
                break;

            case 'general_20':
                if ($orderTotal >= 500000) {
                    $discount = $orderTotal * 0.2;
                    $discountType = 'percentage';
                    $description = 'Giảm 20% cho đơn hàng từ 500k';
                }
                break;

            case 'free_shipping':
                if ($orderTotal >= 300000) {
                    $discount = 15000;
                    $discountType = 'fixed';
                    $description = 'Miễn phí vận chuyển cho đơn hàng từ 300k';
                }
                break;
        }

        return [
            'discount' => $discount,
            'discountType' => $discountType,
            'description' => $description,
            'promotionType' => $promotionType
        ];
    }

    public function isPromotionActive($promotionType) {
        return true; // Tạm thời luôn active
    }

    public function getActivePromotions() {
        return [
            'flash_sale_cupcake' => '50% OFF Cupcake',
            'birthday_cake_25' => 'Giảm 25% Bánh Kem',
            'general_20' => 'Giảm Giá 20%',
            'free_shipping' => 'Miễn Phí Vận Chuyển'
        ];
    }
}
?>
