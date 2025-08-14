<?php
// File: app/models/PromotionModel.php
require_once __DIR__ . '/../../config/database.php';

class PromotionModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

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
