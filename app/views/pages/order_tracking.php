<?php
require_once __DIR__ . '/../../models/OrderModel.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?> - Parrot Smell</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/websitePS/public/assets/css/style.css">
    <style>
        :root {
            --primary-color: #009688;
            --secondary-color: #fdf5e6;
            --text-color: #5d4037;
            --heading-font: 'Playfair Display', serif;
            --body-font: 'Roboto', sans-serif;
        }
        
        body {
            font-family: var(--body-font);
            color: var(--text-color);
            background-color: var(--secondary-color);
        }
        
        .tracking-page {
            min-height: 100vh;
            padding: 2rem 0;
        }
        
        .tracking-container {
            background-color: white;
            border-radius: 25px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 3rem;
        }
        
        .tracking-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #00796b 100%);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
        }
        
        .tracking-header h1 {
            font-family: var(--heading-font);
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .tracking-header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .tracking-content {
            padding: 3rem;
        }
        
        .search-form {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 20px;
            padding: 2.5rem;
            margin-bottom: 3rem;
            border: 2px solid #e9ecef;
        }
        
        .form-title {
            font-family: var(--heading-font);
            color: var(--text-color);
            margin-bottom: 2rem;
            text-align: center;
            font-size: 1.8rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 1rem 1.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 150, 136, 0.25);
        }
        
        .btn-search {
            background: linear-gradient(135deg, var(--primary-color) 0%, #00796b 100%);
            border: none;
            color: white;
            padding: 1rem 2rem;
            border-radius: 15px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .btn-search:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,150,136,0.4);
            color: white;
        }
        
        .order-result {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            border: 2px solid #e9ecef;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }
        
        .order-header {
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .order-number {
            font-family: var(--heading-font);
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
        
        .order-date {
            color: #6c757d;
            font-size: 1rem;
        }
        
        .status-badge {
            display: inline-block;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-pending { background-color: #fff3cd; color: #856404; }
        .status-processing { background-color: #d1ecf1; color: #0c5460; }
        .status-shipped { background-color: #cce5ff; color: #004085; }
        .status-delivered { background-color: #d4edda; color: #155724; }
        .status-cancelled { background-color: #f8d7da; color: #721c24; }
        
        .order-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .info-item {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 15px;
            border-left: 4px solid var(--primary-color);
        }
        
        .info-label {
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .info-value {
            color: var(--text-color);
            font-size: 1.1rem;
        }
        
        .order-items {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .items-title {
            font-family: var(--heading-font);
            color: var(--text-color);
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }
        
        .item-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border: 1px solid #e9ecef;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        
        .item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
        }
        
        .item-details {
            flex-grow: 1;
        }
        
        .item-name {
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }
        
        .item-meta {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .item-price {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 1.1rem;
        }
        
        .order-total {
            background: linear-gradient(135deg, var(--primary-color) 0%, #00796b 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
        }
        
        .total-label {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            opacity: 0.9;
        }
        
        .total-amount {
            font-family: var(--heading-font);
            font-size: 2.5rem;
            font-weight: 700;
        }
        
        .error-message {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .error-message i {
            font-size: 2rem;
            margin-bottom: 1rem;
            display: block;
        }
        
        .help-text {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
            border-radius: 15px;
            padding: 1.5rem;
            margin-top: 2rem;
        }
        
        .help-text h5 {
            color: #0c5460;
            margin-bottom: 1rem;
        }
        
        .help-text ul {
            margin-bottom: 0;
            padding-left: 1.5rem;
        }
        
        .help-text li {
            margin-bottom: 0.5rem;
        }
        
        @media (max-width: 768px) {
            .tracking-header h1 {
                font-size: 2rem;
            }
            
            .tracking-content {
                padding: 2rem 1.5rem;
            }
            
            .order-info {
                grid-template-columns: 1fr;
            }
            
            .item-card {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>

<!-- Navigation -->
<?php include __DIR__ . '/layouts/navbar.php'; ?>

<div class="tracking-page">
    <div class="container">
        <div class="tracking-container">
            <div class="tracking-header">
                <h1><i class="fas fa-search me-3"></i>Tra cứu đơn hàng</h1>
                <p>Nhập mã đơn hàng và số điện thoại để theo dõi tình trạng đơn hàng của bạn</p>
            </div>
            
            <div class="tracking-content">
                <!-- Form tra cứu -->
                <div class="search-form">
                    <h3 class="form-title">
                        <i class="fas fa-clipboard-list me-2"></i>
                        Thông tin tra cứu
                    </h3>
                    
                    <form action="/websitePS/public/ordertracking/search" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="orderCode" class="form-label">
                                        <i class="fas fa-hashtag me-2"></i>Mã đơn hàng
                                    </label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="orderCode" 
                                           name="orderCode" 
                                           placeholder="Nhập mã đơn hàng..."
                                           value="<?= htmlspecialchars($orderCode ?? '') ?>"
                                           required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone" class="form-label">
                                        <i class="fas fa-phone me-2"></i>Số điện thoại
                                    </label>
                                    <input type="tel" 
                                           class="form-control" 
                                           id="phone" 
                                           name="phone" 
                                           placeholder="Nhập số điện thoại..."
                                           value="<?= htmlspecialchars($phone ?? '') ?>"
                                           required>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-search">
                            <i class="fas fa-search me-2"></i>
                            Tra cứu đơn hàng
                        </button>
                    </form>
                </div>

                <!-- Hiển thị lỗi -->
                <?php if (isset($error) && $error): ?>
                    <div class="error-message">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h4>Không tìm thấy đơn hàng</h4>
                        <p><?= htmlspecialchars($error) ?></p>
                    </div>
                <?php endif; ?>

                <!-- Hiển thị kết quả đơn hàng -->
                <?php if (isset($order) && $order): ?>
                    <div class="order-result">
                        <div class="order-header">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="order-number">Đơn hàng #<?= $order['MaDH'] ?></div>
                                    <div class="order-date">
                                        <i class="fas fa-calendar me-2"></i>
                                        Đặt hàng: <?= date('d/m/Y H:i', strtotime($order['NgayDatHang'])) ?>
                                    </div>
                                </div>
                                                                 <div class="text-end">
                                     <?php 
                                     $orderModel = new OrderModel();
                                     $statusText = $orderModel->getOrderStatusText($order['TrangThai']);
                                     ?>
                                     <div class="status-badge status-<?= strtolower($order['TrangThai']) ?>">
                                         <?= $statusText ?>
                                     </div>
                                 </div>
                            </div>
                        </div>

                        <!-- Thông tin đơn hàng -->
                        <div class="order-info">
                            <div class="info-item">
                                <div class="info-label">Khách hàng</div>
                                <div class="info-value"><?= htmlspecialchars($order['HoTen'] ?? 'Khách vãng lai') ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Email</div>
                                <div class="info-value"><?= htmlspecialchars($order['Email'] ?? 'Không có') ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Số điện thoại</div>
                                <div class="info-value"><?= htmlspecialchars($order['SoDienThoai'] ?? 'Không có') ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Phương thức thanh toán</div>
                                <div class="info-value"><?= htmlspecialchars($order['PhuongThucThanhToan'] ?? 'Chưa xác định') ?></div>
                            </div>
                        </div>

                        <!-- Chi tiết sản phẩm -->
                        <?php if (isset($orderDetails) && $orderDetails): ?>
                            <div class="order-items">
                                <h4 class="items-title">
                                    <i class="fas fa-shopping-bag me-2"></i>
                                    Chi tiết sản phẩm
                                </h4>
                                
                                <?php foreach ($orderDetails['items'] as $item): ?>
                                    <div class="item-card">
                                        <img src="<?= !empty($item['HinhAnh']) ? $item['HinhAnh'] : 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?q=80&w=1987&auto=format&fit=crop' ?>" 
                                             alt="<?= htmlspecialchars($item['TenSP']) ?>" 
                                             class="item-image">
                                        <div class="item-details">
                                            <div class="item-name"><?= htmlspecialchars($item['TenSP']) ?></div>
                                            <div class="item-meta">
                                                Số lượng: <?= $item['SoLuong'] ?> | 
                                                Đơn giá: <?= number_format($item['DonGia'], 0, ',', '.') ?> ₫
                                            </div>
                                        </div>
                                        <div class="item-price">
                                            <?= number_format($item['SoLuong'] * $item['DonGia'], 0, ',', '.') ?> ₫
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Tổng tiền -->
                        <div class="order-total">
                            <div class="total-label">Tổng tiền đơn hàng</div>
                            <div class="total-amount"><?= number_format($order['TongTien'], 0, ',', '.') ?> ₫</div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Hướng dẫn -->
                <div class="help-text">
                    <h5><i class="fas fa-info-circle me-2"></i>Hướng dẫn tra cứu</h5>
                    <ul>
                        <li><strong>Mã đơn hàng:</strong> Là số thứ tự đơn hàng được cấp khi bạn đặt hàng thành công</li>
                        <li><strong>Số điện thoại:</strong> Số điện thoại bạn đã sử dụng khi đặt hàng</li>
                        <li>Nếu bạn không nhớ mã đơn hàng, vui lòng liên hệ với chúng tôi qua hotline: <strong>0767 150 474</strong></li>
                        <li>Bạn cũng có thể tra cứu trực tiếp bằng cách click vào link trong email xác nhận đơn hàng</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="footer pt-5 pb-4">
    <div class="container text-center text-md-start">
        <div class="row">
            <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mb-4">
                <h6 class="text-uppercase fw-bold">🦜 Parrot Smell</h6>
                <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: var(--primary-color); height: 2px"/>
                <p>Nơi mỗi chiếc bánh là một tác phẩm nghệ thuật, mang đến niềm vui và sự ngọt ngào cho cuộc sống của bạn.</p>
            </div>
            <div class="col-md-4 col-lg-2 col-xl-2 mx-auto mb-4">
                <h6 class="text-uppercase fw-bold">Liên kết</h6>
                <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: var(--primary-color); height: 2px"/>
                <p><a href="/websitePS/public/pages/about">Về chúng tôi</a></p>
                <p><a href="#!">Chính sách giao hàng</a></p>
                <p><a href="#!">Điều khoản dịch vụ</a></p>
            </div>
            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                <h6 class="text-uppercase fw-bold">Liên hệ</h6>
                <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: var(--primary-color); height: 2px"/>
                <p><i class="fas fa-home me-3"></i> 02 Võ Oanh, Phường 25, Quận Bình Thạnh, TP.HCM</p>
                <p><i class="fas fa-envelope me-3"></i> cucxacdufong@gmail.com</p>
                <p><i class="fas fa-phone me-3"></i> 0767 150 474</p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
