<?php
// File: app/views/pages/cart_summary.php
// View riêng cho cart summary để sử dụng với AJAX

// Đảm bảo các biến cần thiết đã được định nghĩa
$cart = isset($cart) ? $cart : [];
$total = isset($total) ? $total : 0;
$shippingFee = isset($shippingFee) ? $shippingFee : 0;
$finalTotal = isset($finalTotal) ? $finalTotal : ($total + $shippingFee);
$appliedPromotions = isset($appliedPromotions) ? $appliedPromotions : [];
$totalDiscount = isset($totalDiscount) ? $totalDiscount : 0;
$availablePromotions = isset($availablePromotions) ? $availablePromotions : [];
$selectedPromotions = isset($selectedPromotions) ? $selectedPromotions : [];
?>

<div class="cart-summary">
    <div class="summary-header">
        <h4><i class="fas fa-receipt me-2"></i>Tóm tắt đơn hàng</h4>
    </div>
    
    <div class="summary-item">
        <span class="summary-label">Số sản phẩm:</span>
        <span class="summary-value"><?= count($cart) ?></span>
    </div>
    
    <div class="summary-item">
        <span class="summary-label">Tổng tiền hàng:</span>
        <span class="summary-value"><?= number_format($total, 0, ',', '.') ?> đ</span>
    </div>
    
         <!-- Chọn ưu đãi (chỉ cho khách hàng đã đăng nhập) -->
     <?php if (isset($_SESSION['customer_id'])): ?>
        <div class="promotion-section-cart">
            <div class="promotion-title-cart">
                <i class="fas fa-gift me-2"></i>Chọn ưu đãi (Tùy chọn - Tối đa 3 khuyến mãi):
            </div>
            <div style="font-size: 0.85rem; color: #6c757d; margin-bottom: 10px; font-style: italic;">
                <i class="fas fa-info-circle me-1"></i>
                Bạn có thể chọn 0-3 khuyến mãi hoặc không chọn khuyến mãi nào
            </div>
                
                <form method="POST" action="/websitePS/public/cart" id="promotionForm" style="margin: 0;">
                    <!-- Hidden input để đảm bảo form luôn có data khi submit -->
                    <input type="hidden" name="promotion_form_submitted" value="1">
                    <?php 
                    // Hiển thị tất cả ưu đãi khách hàng có thể chọn (bao gồm cả tier discount)
                    $selectablePromotions = $availablePromotions;
                    ?>
                                         <?php if (!empty($selectablePromotions)): ?>
                         <?php foreach ($selectablePromotions as $promotion): ?>
                             <?php 
                             $isSelected = in_array($promotion['promotionType'], $selectedPromotions);
                             $selectedCount = count($selectedPromotions);
                             // Cho phép bỏ chọn tất cả khuyến mãi, không disable
                             $isDisabled = false;
                             ?>
                                                           <div class="promotion-option-cart">
                                 <div style="display: flex; align-items: center;">
                                     <div style="flex: 1; min-width: 0;">
                                         <label style="display: flex; align-items: center; margin: 0; cursor: pointer;">
                                             <input type="checkbox" 
                                                    name="selected_promotions[]" 
                                                    value="<?= $promotion['promotionType'] ?>"
                                                    <?= $isSelected ? 'checked' : '' ?>
                                                    onchange="updatePromotions()"
                                                    style="margin-right: 10px; cursor: pointer;">
                                             <span style="color: #495057; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                 <?php if ($promotion['promotionType'] === 'tier_discount'): ?>
                                                     <i class="fas fa-crown me-2" style="color: #ffc107;"></i>
                                                 <?php elseif (strpos($promotion['promotionType'], 'db_promo_') === 0): ?>
                                                     <i class="fas fa-tag me-2" style="color: #6f42c1;"></i>
                                                 <?php endif; ?>
                                                 <?= htmlspecialchars($promotion['description']) ?>
                                                 <?php if ($promotion['discount'] > 0): ?>
                                                     <span class="badge bg-success ms-2" style="font-size: 0.7rem;">
                                                         -<?= number_format($promotion['discount'], 0, ',', '.') ?> ₫
                                                     </span>
                                                 <?php endif; ?>
                                             </span>
                                         </label>
                                     </div>
                                 </div>
                             </div>
                         <?php endforeach; ?>
                     <?php else: ?>
                         <div style="text-align: center; padding: 15px; color: #6c757d; font-style: italic;">
                             <i class="fas fa-info-circle me-2"></i>
                             Hiện tại không có ưu đãi khuyến mãi nào khả dụng cho đơn hàng này
                         </div>
                     <?php endif; ?>
                    
                    <?php if (!empty($selectablePromotions)): ?>
                        <div class="promotion-info-cart">
                            <div style="text-align: center; font-size: 0.8rem; color: #6c757d;">
                                Đã chọn: <span id="selected-count"><?= count($selectedPromotions) ?></span>/3 khuyến mãi
                                <div id="no-promotion-message" style="<?= count($selectedPromotions) === 0 ? '' : 'display: none;' ?>">
                                    <span style="color: #28a745; font-weight: 500;">✓ Không áp dụng khuyến mãi</span>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div style="margin-top: 15px; text-align: center;">
                        <button type="submit" style="display: none;" id="hiddenSubmitBtn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
    
         <!-- Hiển thị ưu đãi đã áp dụng (chỉ cho khách hàng đã đăng nhập) -->
     <?php if (isset($_SESSION['customer_id'])): ?>
        <div class="summary-item" style="background: #f8f9fa; border-radius: 10px; margin: 10px 0; padding: 15px;">
            <div style="width: 100%;">
                <div style="color: #28a745; font-weight: 600; margin-bottom: 10px;">
                    <i class="fas fa-check-circle me-2"></i>Ưu đãi đã áp dụng:
                </div>
                
                                 <!-- Tất cả ưu đãi đã áp dụng -->
                 <div id="applied-promotions-list">
                     <?php 
                     $stepNumber = 1;
                     foreach ($appliedPromotions as $promotion): 
                     ?>
                         <div style="margin-bottom: 5px; padding: 6px; background: white; border-radius: 6px; border-left: 3px solid #28a745;">
                             <div style="display: flex; align-items: center;">
                                 <span style="color: #6c757d; font-size: 0.8rem; font-weight: 600;">
                                     <?= $stepNumber ?>. 
                                     <?php if ($promotion['promotionType'] === 'tier_discount'): ?>
                                         <i class="fas fa-crown me-1" style="color: #ffd700;"></i>
                                     <?php elseif (strpos($promotion['promotionType'], 'db_promo_') === 0): ?>
                                         <i class="fas fa-tag me-1" style="color: #6f42c1;"></i>
                                     <?php endif; ?>
                                     <?= htmlspecialchars($promotion['description']) ?>
                                 </span>
                             </div>
                         </div>
                     <?php 
                         $stepNumber++;
                     endforeach; 
                     ?>
                 </div>
                 <?php if (empty($appliedPromotions)): ?>
                     <div style="text-align: center; padding: 10px; color: #6c757d; font-style: italic; font-size: 0.8rem;">
                         <i class="fas fa-info-circle me-1"></i>
                         Chưa có ưu đãi nào được áp dụng
                     </div>
                 <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
    
    <?php
    // Hiển thị thông tin phân khúc khách hàng (chỉ khi có ưu đãi tier discount được áp dụng)
    $tierPromotion = null;
    foreach ($appliedPromotions as $promotion) {
        if ($promotion['promotionType'] === 'tier_discount' && isset($promotion['isSelected']) && $promotion['isSelected']) {
            $tierPromotion = $promotion;
            break;
        }
    }
    
    if ($tierPromotion): ?>
        <div class="summary-item" style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); border-radius: 10px; margin: 10px 0; padding: 15px; border-left: 4px solid #ffc107;">
            <div style="width: 100%;">
                <div style="color: #856404; font-weight: 600; margin-bottom: 8px;">
                    <i class="fas fa-crown me-2" style="color: #ffd700;"></i>
                    Ưu đãi <?= htmlspecialchars($tierPromotion['tierName']) ?> (Đã chọn)
                </div>
                <div style="font-size: 0.85rem; color: #856404;">
                    Tổng chi tiêu: <?= number_format($tierPromotion['totalSpent'], 0, ',', '.') ?> đ
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <!-- Phần nhập mã khuyến mãi -->
    <div class="coupon-section" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 10px; margin: 15px 0; padding: 15px; border: 1px solid #dee2e6;">
        <div style="color: #495057; font-weight: 600; margin-bottom: 10px;">
            <i class="fas fa-ticket-alt me-2" style="color: #007bff;"></i>Mã khuyến mãi
        </div>
        <div style="display: flex; gap: 10px;">
            <input type="text" 
                   id="coupon-code" 
                   name="coupon_code" 
                   placeholder="Nhập mã khuyến mãi..." 
                   style="flex: 1; padding: 10px 12px; border: 1px solid #ced4da; border-radius: 5px; font-size: 0.9rem;"
                   value="<?= htmlspecialchars($_POST['coupon_code'] ?? '') ?>">
            <button type="button" 
                    onclick="applyCoupon(event)" 
                    style="padding: 10px 15px; background: linear-gradient(135deg, #007bff, #0056b3); color: white; border: none; border-radius: 5px; font-weight: 500; cursor: pointer;">
                <i class="fas fa-check me-1"></i>Áp dụng
            </button>
        </div>
        <div id="coupon-message" style="margin-top: 8px; font-size: 0.85rem; display: none;"></div>
        
        <!-- Hiển thị mã khuyến mãi đã áp dụng -->
        <?php if (isset($_SESSION['customer_id']) && !empty($selectedPromotions)): ?>
            <div id="applied-coupons" style="margin-top: 10px;">
                <?php foreach ($selectedPromotions as $promotionType): ?>
                    <?php if (strpos($promotionType, 'db_promo_') === 0): ?>
                        <div class="applied-coupon" style="background: #e8f5e8; border: 1px solid #28a745; border-radius: 5px; padding: 8px 12px; margin: 5px 0; display: flex; justify-content: space-between; align-items: center;">
                            <span style="color: #155724; font-size: 0.85rem;">
                                <i class="fas fa-check-circle me-2" style="color: #28a745;"></i>
                                <?php 
                                // Lấy tên thực tế của mã khuyến mãi
                                $couponName = $promotionType;
                                if (isset($_SESSION['applied_coupons'][$promotionType]['displayName'])) {
                                    $couponName = $_SESSION['applied_coupons'][$promotionType]['displayName'];
                                }
                                ?>
                                Mã: <?= htmlspecialchars($couponName) ?>
                            </span>
                            <button type="button" 
                                    onclick="removeCoupon('<?= $promotionType ?>')" 
                                    style="background: #dc3545; color: white; border: none; border-radius: 3px; padding: 4px 8px; font-size: 0.75rem; cursor: pointer;">
                                <i class="fas fa-times me-1"></i>Bỏ
                            </button>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
         <?php if (isset($_SESSION['customer_id'])): ?>
         <div class="summary-item">
             <span class="summary-label">Tổng giảm giá:</span>
             <span class="summary-value" id="total-discount" style="color: <?= $totalDiscount > 0 ? '#dc3545' : '#6c757d' ?>;">
                 <?= $totalDiscount > 0 ? '-' . number_format($totalDiscount, 0, ',', '.') . ' đ' : '0 đ' ?>
             </span>
         </div>
     <?php endif; ?>
    
    <div class="summary-item">
        <span class="summary-label">Phí vận chuyển:</span>
        <span class="summary-value"><?= $shippingFee > 0 ? number_format($shippingFee, 0, ',', '.') . ' đ' : 'Miễn phí' ?></span>
    </div>
    
    <div class="summary-item">
        <span class="summary-label">Tổng cộng:</span>
        <span class="summary-value summary-total"><?= number_format($finalTotal, 0, ',', '.') ?> đ</span>
    </div>
    
    <!-- Link tra cứu đơn hàng cho khách vãng lai -->
    <?php if (!isset($_SESSION['customer_id'])): ?>
        <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border: 2px solid #dee2e6; border-radius: 15px; margin: 20px 0; padding: 20px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
            <div style="margin-bottom: 15px;">
                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary-color), #00796b); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; box-shadow: 0 4px 15px rgba(0,150,136,0.3);">
                    <i class="fas fa-search" style="font-size: 1.5rem; color: white;"></i>
                </div>
                <h5 style="color: var(--text-color); font-weight: 600; margin-bottom: 8px; font-family: var(--heading-font);">
                    Tra cứu đơn hàng
                </h5>
                <p style="font-size: 0.95rem; color: #6c757d; margin-bottom: 20px; line-height: 1.4;">
                    Đã đặt hàng trước đó?<br>
                    Tra cứu tình trạng đơn hàng của bạn
                </p>
            </div>
            <a href="/websitePS/public/ordertracking" class="btn btn-primary-custom" style="width: 100%; padding: 12px 20px; font-weight: 500; border-radius: 25px; box-shadow: 0 4px 15px rgba(0,150,136,0.3);">
                <i class="fas fa-search me-2"></i>
                Tra cứu đơn hàng
            </a>
        </div>
    <?php endif; ?>
    
    <div class="action-buttons">
        <a href="/websitePS/public/products/list" class="btn-continue">
            <i class="fas fa-arrow-left me-2"></i>
            Tiếp tục mua sắm
        </a>
        <a href="/websitePS/public/checkout" class="btn-checkout">
            <i class="fas fa-credit-card me-2"></i>
            Thanh toán ngay
        </a>
    </div>
</div>
