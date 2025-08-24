<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cảm ơn bạn - Parrot Smell</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/websitePS/assets/css/style.css">
    <style>
        .thankyou-content-scale {
            transform: scale(0.6);
            transform-origin: top center;
            width: calc(100% / 0.6); /* compensate so layout width stays similar */
            margin: 0 auto;
        }
        @media (max-width: 768px) {
            .thankyou-content-scale { transform: none; width: 100%; }
        }
        .thankyou-page {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary-color) 0%, #00796b 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }
        
        .thankyou-container {
            width: 100%;
            max-width: 70%; /* widened from 40% to allow content to fit */
            margin: 0 auto;
            transition: max-width .3s ease;
        }
        @media (min-width: 1600px) {
            .thankyou-container { max-width: 60%; }
        }
        /* existing breakpoints updated to reflect new base */
        @media (max-width: 1400px) { .thankyou-container { max-width: 75%; } }
        @media (max-width: 1200px) { .thankyou-container { max-width: 80%; } }
        @media (max-width: 992px) { .thankyou-container { max-width: 85%; } }
        @media (max-width: 768px) { .thankyou-container { max-width: 90%; } }
        @media (max-width: 576px) {
            .thankyou-container { max-width: 95%; }
            .thankyou-card { padding: 1.5rem; }
        }
        
        .thankyou-card {
            background-color: var(--white);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 2.5rem;
            text-align: center;
            animation: fadeIn 0.8s ease-out;
        }
        
        .success-icon {
            width: 100px;
            height: 100px;
            background-color: var(--success-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            animation: bounce 1s ease-in-out;
        }
        
        .success-icon i {
            font-size: 3rem;
            color: var(--white);
        }
        
        .thankyou-title {
            font-family: var(--heading-font);
            color: var(--text-color);
            margin-bottom: 1rem;
            font-size: 2.5rem;
        }
        
        .thankyou-subtitle {
            color: #6c757d;
            font-size: 1.2rem;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .order-details {
            background-color: var(--light-bg);
            border-radius: 15px;
            padding: 2rem;
            margin: 2rem 0;
            text-align: left;
        }
        
        .order-details h5 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            text-align: center;
        }
        
        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .detail-item:last-child {
            border-bottom: none;
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }
        
        .btn-home {
            background-color: var(--primary-color);
            border: 2px solid var(--primary-color);
            color: var(--white);
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .btn-home:hover {
            background-color: #00796b;
            border-color: #00796b;
            color: var(--white);
            transform: translateY(-2px);
        }
        
        .btn-orders {
            background-color: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .btn-orders:hover {
            background-color: var(--primary-color);
            color: var(--white);
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }
        
        .delivery-info {
            background-color: rgba(0, 150, 136, 0.1);
            border: 1px solid var(--primary-color);
            border-radius: 10px;
            padding: 1.5rem;
            margin: 2rem 0;
        }
        
        .delivery-info h6 {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .delivery-info p {
            margin-bottom: 0.5rem;
            color: var(--text-color);
        }

        /* Responsive widths for thank you page */
        @media (max-width: 1400px) {
            .thankyou-container {
                max-width: 75%;
            }
        }
        @media (max-width: 1200px) {
            .thankyou-container {
                max-width: 80%;
            }
        }
        @media (max-width: 992px) {
            .thankyou-container {
                max-width: 85%;
            }
        }
        @media (max-width: 768px) {
            .thankyou-container {
                max-width: 90%;
            }
        }
        @media (max-width: 576px) {
            .thankyou-container {
                max-width: 95%;
            }
            .thankyou-card {
                padding: 1.5rem;
            }
        }
        .order-sections { display: flex; gap: 2rem; align-items: stretch; }
        .order-section-left, .order-section-right { flex: 1; }
        .order-section-right { display: flex; flex-direction: column; }
        .order-section-right .delivery-info { flex: 1; }
        .order-section-right .action-buttons { justify-content: flex-end; margin-top: 1.5rem; }
        @media (max-width: 992px) {
            .order-sections { flex-direction: column; }
            .order-section-right .action-buttons { justify-content: center; }
        }
    </style>
</head>
<body>
<div class="thankyou-page">
    <div class="thankyou-container">
        <div class="thankyou-card">
            <div class="success-icon">
                <i class="fas fa-check"></i>
            </div>
            
            <h1 class="thankyou-title">Cảm ơn bạn!</h1>
            <p class="thankyou-subtitle">
                Đơn hàng của bạn đã được đặt thành công. Chúng tôi sẽ xử lý và giao hàng trong thời gian sớm nhất.
            </p>
            
            <?php
            // Sử dụng giá đã được áp dụng khuyến mãi từ database
            $total = isset($orderDetails['info']['TongTien']) ? $orderDetails['info']['TongTien'] : 0;
            
            // Tính lại subtotal từ items để so sánh
            $subtotal = 0;
            if (isset($orderDetails) && isset($orderDetails['items'])) {
                foreach ($orderDetails['items'] as $item) {
                    $subtotal += $item['DonGia'] * $item['SoLuong'];
                }
            }
            
            // Tính phí vận chuyển cơ bản
            $baseShippingFee = 0;
            if ($subtotal < 100000) {
                $baseShippingFee = 15000;
            }
            
            // Tính tổng giảm giá (nếu có)
            // Nếu total < subtotal + shippingFee thì có giảm giá
            $expectedTotal = $subtotal + $baseShippingFee;
            $discount = 0;
            $actualShippingFee = $baseShippingFee;
            
            if ($total < $expectedTotal) {
                $discount = $expectedTotal - $total;
                // Nếu có giảm giá và total = subtotal thì miễn phí vận chuyển
                if ($total == $subtotal) {
                    $actualShippingFee = 0;
                    $discount = $baseShippingFee;
                }
            }
            
            // Debug logging
            error_log("Thankyou page - Total from DB: " . $total);
            error_log("Thankyou page - Subtotal calculated: " . $subtotal);
            error_log("Thankyou page - Expected total: " . $expectedTotal);
            error_log("Thankyou page - Discount calculated: " . $discount);
            error_log("Thankyou page - Actual shipping fee: " . $actualShippingFee);
            ?>
            <div class="order-details">
                <h5>
                    <i class="fas fa-receipt me-2"></i>
                    Thông tin đơn hàng
                </h5>
                <div class="detail-item">
                    <span>Mã đơn hàng:</span>
                    <span>#<?= isset($orderDetails['info']['MaDH']) ? $orderDetails['info']['MaDH'] : 'PS' . date('YmdHis') ?></span>
                </div>
                <div class="detail-item">
                    <span>Ngày đặt:</span>
                    <span><?= isset($orderDetails['info']['NgayDatHang']) ? date('d/m/Y H:i', strtotime($orderDetails['info']['NgayDatHang'])) : date('d/m/Y H:i') ?></span>
                </div>
                <div class="detail-item">
                    <span>Trạng thái:</span>
                    <span class="text-success">Đã xác nhận</span>
                </div>
                <div class="detail-item">
                    <span>Tổng tiền hàng:</span>
                    <span><?= number_format($subtotal, 0, ',', '.') ?> đ</span>
                </div>
                <?php if ($discount > 0): ?>
                <div class="detail-item" style="color: #dc3545;">
                    <span>Giảm giá:</span>
                    <span>-<?= number_format($discount, 0, ',', '.') ?> đ</span>
                </div>
                <?php endif; ?>
                <div class="detail-item">
                    <span>Phí vận chuyển:</span>
                    <span><?= $actualShippingFee > 0 ? number_format($actualShippingFee, 0, ',', '.') . ' đ' : 'Miễn phí' ?></span>
                </div>
                <div class="detail-item">
                    <span>Tổng cộng:</span>
                    <span><?= number_format($total, 0, ',', '.') ?> đ</span>
                </div>
            </div>
            
            <div class="delivery-info">
                <h6>
                    <i class="fas fa-truck me-2"></i>
                    Thông tin giao hàng
                </h6>
                <p><strong>Thời gian giao hàng:</strong> 2-3 ngày làm việc</p>
                <p><strong>Phí vận chuyển:</strong> 
                    <?= $actualShippingFee > 0 ? number_format($actualShippingFee, 0, ',', '.') . ' đ' : 'Miễn phí' ?>
                </p>
                                 <p><strong>Phương thức thanh toán:</strong> 
                     <?php 
                     $paymentMethod = isset($orderDetails['info']['PhuongThucThanhToan']) ? $orderDetails['info']['PhuongThucThanhToan'] : 'cod';
                     if ($paymentMethod === 'bank') {
                         echo 'Chuyển khoản ngân hàng (MBBank)';
                     } else {
                         echo 'Thanh toán khi nhận hàng';
                     }
                     ?>
                 </p>
            </div>
            
            <div class="action-buttons">
                <a href="/websitePS/public/" class="btn-home">
                    <i class="fas fa-home me-2"></i>
                    Về trang chủ
                </a>
                <?php if (isset($_SESSION['customer_id'])): ?>
                    <a href="/websitePS/public/customerorders/show/<?= isset($orderDetails['info']['MaDH']) ? $orderDetails['info']['MaDH'] : '' ?>" class="btn-orders">
                        <i class="fas fa-list me-2"></i>
                        Xem đơn hàng
                    </a>
                <?php else: ?>
                    <a href="/websitePS/public/ordertracking" class="btn-orders">
                        <i class="fas fa-search me-2"></i>
                        Tra cứu đơn hàng
                    </a>
                <?php endif; ?>
            </div>
            
            <?php if (!isset($_SESSION['customer_id'])): ?>
                <div class="mt-4 p-4 bg-primary text-white rounded">
                    <h6 class="mb-3">
                        <i class="fas fa-info-circle me-2"></i>
                        Thông tin quan trọng cho khách vãng lai
                    </h6>
                    <div class="mb-3">
                        <strong>Mã đơn hàng của bạn:</strong> 
                        <div class="mt-2">
                            <span class="badge bg-white text-primary fs-5 px-3 py-2">#<?= isset($orderDetails['info']['MaDH']) ? $orderDetails['info']['MaDH'] : 'PS' . date('YmdHis') ?></span>
                        </div>
                    </div>
                    <p class="mb-2">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Vui lòng lưu lại mã đơn hàng này!</strong>
                    </p>
                    <p class="mb-0 small">
                        Để tra cứu tình trạng đơn hàng sau này, vui lòng truy cập: 
                        <a href="/websitePS/public/ordertracking" class="text-white text-decoration-underline fw-bold">Trang tra cứu đơn hàng</a>
                        <br>
                        Sử dụng mã đơn hàng và số điện thoại đã đăng ký để tra cứu.
                    </p>
                </div>
            <?php endif; ?>
            
            <div class="mt-4">
                <p class="text-muted">
                    <i class="fas fa-home me-1"></i>
                    Địa chỉ: 02 Võ Oanh, Phường 25, Quận Bình Thạnh, TP.HCM | 
                    <i class="fas fa-envelope me-1"></i>
                    Email: cucxacdufong@gmail.com | 
                    <i class="fas fa-phone me-1"></i>
                    Điện thoại: 0767 150 474
                </p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>