<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết Đơn hàng #<?= $orderDetails['info']['MaDH'] ?> - Parrot Smell</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
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
        }
        
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            background-color: #fff;
        }
        
        .navbar-brand {
            font-family: var(--heading-font);
            font-weight: 700;
            color: var(--primary-color) !important;
        }
        
        .page-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #00796b 100%);
            color: white;
            padding: 3rem 0;
            text-align: center;
        }
        
        .page-header h1 {
            font-family: var(--heading-font);
            font-size: 3rem;
            margin-bottom: 0.5rem;
        }
        
        .page-header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .section-title {
            font-family: var(--heading-font);
            color: var(--text-color);
            margin-bottom: 40px;
            text-align: center;
        }
        
        .order-container {
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid #e9ecef;
        }
        
        .order-info-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid #dee2e6;
        }
        
        .order-info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .order-info-item:last-child {
            border-bottom: none;
        }
        
        .order-info-label {
            font-weight: 600;
            color: var(--text-color);
        }
        
        .order-info-value {
            color: var(--primary-color);
            font-weight: 500;
        }
        
        .product-card {
            background: #fff;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border: 1px solid #e9ecef;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }
        
        .product-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
        }
        
        .product-details {
            flex: 1;
        }
        
        .product-name {
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }
        
        .product-price {
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .product-quantity {
            background-color: var(--secondary-color);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.9rem;
            color: var(--text-color);
        }
        
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .status-pending { background-color: #fff3cd; color: #856404; }
        .status-processing { background-color: #cce5ff; color: #004085; }
        .status-shipping { background-color: #d1ecf1; color: #0c5460; }
        .status-delivered { background-color: #d4edda; color: #155724; }
        .status-cancelled { background-color: #f8d7da; color: #721c24; }
        
        .summary-card {
            background: linear-gradient(135deg, var(--primary-color) 0%, #00796b 100%);
            color: #fff;
            border-radius: 15px;
            padding: 2rem;
            position: sticky;
            top: 2rem;
        }
        
        .summary-title {
            font-family: var(--heading-font);
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }
        
        .summary-item:last-child {
            border-bottom: none;
            font-weight: 700;
            font-size: 1.2rem;
        }
        
        .action-buttons {
            margin-top: 2rem;
        }
        
        .btn-back {
            background-color: rgba(255,255,255,0.2);
            border: 2px solid rgba(255,255,255,0.3);
            color: #fff;
            transition: all 0.3s ease;
        }
        
        .btn-back:hover {
            background-color: rgba(255,255,255,0.3);
            border-color: rgba(255,255,255,0.5);
            color: #fff;
        }
        
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #fff;
            transition: all 0.3s ease;
        }
        
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
            color: #fff;
            transform: translateY(-1px);
        }
        
        .delivery-info {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--primary-color);
        }
        
        .delivery-title {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .delivery-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
        }
        
        .delivery-icon {
            width: 20px;
            margin-right: 0.75rem;
            color: var(--primary-color);
        }
        
        .timeline {
            position: relative;
            padding-left: 30px;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--primary-color);
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -22px;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--primary-color);
            border: 3px solid #fff;
            box-shadow: 0 0 0 2px var(--primary-color);
        }
        
        .timeline-item.active::before {
            background: #28a745;
            box-shadow: 0 0 0 2px #28a745;
        }
        
        .timeline-item.completed::before {
            background: #28a745;
            box-shadow: 0 0 0 2px #28a745;
        }
        
        .timeline-content {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 10px;
            border-left: 3px solid var(--primary-color);
        }
        
        .timeline-content.active {
            background: #e8f5e8;
            border-left-color: #28a745;
        }
        
        /* Review Section Styles */
        .review-section {
            border: 1px solid #e9ecef;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        }
        
        .existing-review {
            border-left: 4px solid #28a745;
            padding-left: 1rem;
        }
        
        .review-form {
            border-left: 4px solid var(--primary-color);
            padding-left: 1rem;
        }
        
        .cannot-review {
            border-left: 4px solid #6c757d;
            padding-left: 1rem;
        }
        
        .rating-input {
            display: flex;
            flex-direction: row-reverse;
            gap: 0.25rem;
        }
        
        .rating-input input[type="radio"] {
            display: none;
        }
        
        .rating-star {
            cursor: pointer;
            font-size: 1.5rem;
            color: #ddd;
            transition: color 0.2s ease;
        }
        
        .rating-star:hover,
        .rating-star:hover ~ .rating-star,
        .rating-input input[type="radio"]:checked ~ .rating-star {
            color: #ffc107;
        }
        
        .rating-stars {
            font-size: 1rem;
        }
        
        .rating-stars .fa-star {
            transition: color 0.2s ease;
        }
        
        .review-content {
            font-style: italic;
            color: #6c757d;
        }
        
        .timeline-content.completed {
            background: #e8f5e8;
            border-left-color: #28a745;
        }
        
        .estimated-delivery {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid #ffc107;
        }
        
        .footer {
            background-color: var(--text-color);
            color: var(--secondary-color);
            margin-top: 4rem;
        }
        
        .footer a {
            color: var(--secondary-color);
            text-decoration: none;
        }
        
        .footer a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 2rem;
            }
            
            .order-container {
                padding: 1.5rem;
            }
            
            .summary-card {
                position: static;
                margin-top: 2rem;
            }
        }
    </style>
</head>
<body>

<?php
// Hàm để lấy ảnh cho từng sản phẩm
function getProductImage($product) {
    // Nếu $product là string (tên sản phẩm), chuyển đổi thành array
    if (is_string($product)) {
        $productName = $product;
        $product = ['TenSP' => $productName, 'HinhAnh' => null];
    }
    
    // Ưu tiên sử dụng hình ảnh từ database
    if (!empty($product['HinhAnh'])) {
        return $product['HinhAnh'];
    }
    
    // Fallback: sử dụng tên sản phẩm để tìm hình ảnh mặc định
    $productName = strtolower(trim($product['TenSP']));
    
    // Map ảnh cho từng sản phẩm cụ thể
    $imageMap = [
        'tiramisu' => 'https://images.unsplash.com/photo-1714385905983-6f8e06fffae1?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'sourdough' => 'https://plus.unsplash.com/premium_photo-1664640733898-d5c3f71f44e1?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'chocolate cake' => 'https://images.unsplash.com/photo-1606890737304-57a1ca8a5b62?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8Y2hvY29sYXRlJTIwY2FrZXxlbnwwfHwwfHx8MA%3D%3D',
        'croissant' => 'https://images.unsplash.com/photo-1600521853186-93b88b3a07b0?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTR8fGNyb2lzc2FudHxlbnwwfHwwfHx8MA%3D%3D'
    ];
    
    // Tìm ảnh phù hợp
    foreach ($imageMap as $keyword => $imageUrl) {
        if (strpos($productName, $keyword) !== false) {
            return $imageUrl;
        }
    }
    
    // Ảnh mặc định nếu không tìm thấy
    return 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?q=80&w=1987&auto=format&fit=crop';
}

// Tính toán thời gian giao hàng dự kiến
function getEstimatedDeliveryTime($orderDate, $status) {
    $orderDateTime = new DateTime($orderDate);
    $now = new DateTime();
    
    switch ($status) {
        case 'Pending':
            return $orderDateTime->modify('+2 hours')->format('d/m/Y H:i');
        case 'Processing':
            return $orderDateTime->modify('+4 hours')->format('d/m/Y H:i');
        case 'Shipping':
            return $orderDateTime->modify('+6 hours')->format('d/m/Y H:i');
        case 'Delivered':
            return 'Đã giao hàng';
        case 'Cancelled':
            return 'Đơn hàng đã hủy';
        default:
            return $orderDateTime->modify('+3 hours')->format('d/m/Y H:i');
    }
}

// Tính toán thời gian đã trôi qua
function getTimeElapsed($orderDate) {
    $orderDateTime = new DateTime($orderDate);
    $now = new DateTime();
    $interval = $now->diff($orderDateTime);
    
    if ($interval->days > 0) {
        return $interval->days . ' ngày ' . $interval->h . ' giờ trước';
    } elseif ($interval->h > 0) {
        return $interval->h . ' giờ ' . $interval->i . ' phút trước';
    } else {
        return $interval->i . ' phút trước';
    }
}

// Lấy trạng thái tiếng Việt
function getStatusInVietnamese($status) {
    $statusMap = [
        'Pending' => 'Chờ xử lý',
        'Processing' => 'Đang xử lý',
        'Shipping' => 'Đang giao hàng',
        'Delivered' => 'Đã giao hàng',
        'Cancelled' => 'Đã hủy'
    ];
    
    return $statusMap[$status] ?? $status;
}

// Tính tổng số lượng sản phẩm
$totalItems = 0;
foreach ($orderDetails['items'] as $item) {
    $totalItems += $item['SoLuong'];
}

// Tính phí vận chuyển - NHẤT QUÁN với logic mới
$shippingFee = 0;
if ($orderDetails['info']['TongTien'] > 0) {  // Có sản phẩm thì tính phí ship
    $shippingFee = 30000;  // 30,000₫ cho TẤT CẢ đơn hàng
}

$estimatedDelivery = getEstimatedDeliveryTime($orderDetails['info']['NgayDatHang'], $orderDetails['info']['TenTrangThai']);
$timeElapsed = getTimeElapsed($orderDetails['info']['NgayDatHang']);
$statusVietnamese = getStatusInVietnamese($orderDetails['info']['TenTrangThai']);
?>

<?php include __DIR__ . '/layouts/navbar.php'; ?>

<!-- Success/Error Messages (Legacy - kept for non-AJAX requests) -->
<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 9999;">
        <i class="fas fa-check-circle me-2"></i>
        <?= $_SESSION['success_message'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 9999;">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <?= $_SESSION['error_message'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1>Chi tiết Đơn hàng</h1>
        <p>Mã đơn hàng: #<?= htmlspecialchars($orderDetails['info']['MaDH']) ?></p>
    </div>
</section>

<!-- Main Content -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Order Information -->
                <div class="order-container">
                    <h3 class="section-title">
                        <i class="fas fa-info-circle me-2"></i>
                        Thông tin đơn hàng
                    </h3>
                    
                    <div class="order-info-card">
                        <div class="order-info-item">
                            <span class="order-info-label">Mã đơn hàng:</span>
                            <span class="order-info-value">#<?= htmlspecialchars($orderDetails['info']['MaDH']) ?></span>
                        </div>
                        <div class="order-info-item">
                            <span class="order-info-label">Ngày đặt hàng:</span>
                            <span class="order-info-value"><?= date('d/m/Y H:i', strtotime($orderDetails['info']['NgayDatHang'])) ?></span>
                        </div>
                        <div class="order-info-item">
                            <span class="order-info-label">Thời gian đã trôi qua:</span>
                            <span class="order-info-value" id="timeElapsed"><?= $timeElapsed ?></span>
                        </div>
                        <div class="order-info-item">
                            <span class="order-info-label">Trạng thái:</span>
                            <span class="status-badge status-<?= strtolower(str_replace(' ', '-', $orderDetails['info']['TenTrangThai'])) ?>">
                                <?= $statusVietnamese ?>
                            </span>
                        </div>
                        <?php if ($orderDetails['info']['TenTrangThai'] === 'Pending'): ?>
                        <div class="order-info-item">
                            <span class="order-info-label">Khả năng hủy:</span>
                            <span class="text-success"><i class="fas fa-check-circle me-1"></i>Có thể hủy</span>
                        </div>
                        <?php elseif ($orderDetails['info']['TenTrangThai'] === 'Cancelled'): ?>
                        <div class="order-info-item">
                            <span class="order-info-label">Khả năng hủy:</span>
                            <span class="text-secondary"><i class="fas fa-ban me-1"></i>Đã hủy trước đó</span>
                        </div>
                        <?php else: ?>
                        <div class="order-info-item">
                            <span class="order-info-label">Khả năng hủy:</span>
                            <span class="text-danger"><i class="fas fa-times-circle me-1"></i>Không thể hủy</span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Delivery Timeline -->
                <div class="order-container">
                    <h3 class="section-title">
                        <i class="fas fa-clock me-2"></i>
                        Tiến trình đơn hàng
                    </h3>
                    
                                         <div class="timeline">
                         <div class="timeline-item completed">
                             <div class="timeline-content completed">
                                 <h6><i class="fas fa-check-circle text-success me-2"></i>Đơn hàng đã được đặt</h6>
                                 <small class="text-muted"><?= date('d/m/Y H:i', strtotime($orderDetails['info']['NgayDatHang'])) ?></small>
                             </div>
                         </div>
                         
                         <?php if ($orderDetails['info']['TenTrangThai'] === 'Cancelled'): ?>
                         <div class="timeline-item completed">
                             <div class="timeline-content completed" style="background: #f8d7da; border-left-color: #dc3545;">
                                 <h6><i class="fas fa-times-circle text-danger me-2"></i>Đơn hàng đã bị hủy</h6>
                                 <small class="text-muted">Đơn hàng đã được hủy bởi khách hàng</small>
                             </div>
                         </div>
                         <?php else: ?>
                         <div class="timeline-item <?= in_array($orderDetails['info']['TenTrangThai'], ['Processing', 'Shipping', 'Delivered']) ? 'completed' : '' ?>">
                             <div class="timeline-content <?= in_array($orderDetails['info']['TenTrangThai'], ['Processing', 'Shipping', 'Delivered']) ? 'completed' : '' ?>">
                                 <h6><i class="fas fa-cog me-2"></i>Đang xử lý</h6>
                                 <small class="text-muted">Chuẩn bị nguyên liệu và nướng bánh</small>
                             </div>
                         </div>
                         
                         <div class="timeline-item <?= in_array($orderDetails['info']['TenTrangThai'], ['Shipping', 'Delivered']) ? 'completed' : '' ?>">
                             <div class="timeline-content <?= in_array($orderDetails['info']['TenTrangThai'], ['Shipping', 'Delivered']) ? 'completed' : '' ?>">
                                 <h6><i class="fas fa-truck me-2"></i>Đang giao hàng</h6>
                                 <small class="text-muted">Đơn hàng đang được vận chuyển</small>
                             </div>
                         </div>
                         
                         <div class="timeline-item <?= $orderDetails['info']['TenTrangThai'] === 'Delivered' ? 'completed' : '' ?>">
                             <div class="timeline-content <?= $orderDetails['info']['TenTrangThai'] === 'Delivered' ? 'completed' : '' ?>">
                                 <h6><i class="fas fa-home me-2"></i>Đã giao hàng</h6>
                                 <small class="text-muted">Đơn hàng đã được giao thành công</small>
                             </div>
                         </div>
                         <?php endif; ?>
                     </div>
                </div>

                <!-- Estimated Delivery -->
                <?php if ($orderDetails['info']['TenTrangThai'] === 'Cancelled'): ?>
                <div class="estimated-delivery" style="background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); border-left-color: #dc3545;">
                    <h5><i class="fas fa-times-circle me-2"></i>Trạng thái đơn hàng</h5>
                    <p class="mb-0"><strong>Đơn hàng đã được hủy</strong></p>
                    <small class="text-muted">Đơn hàng này đã được hủy bởi khách hàng</small>
                </div>
                <?php else: ?>
                <div class="estimated-delivery">
                    <h5><i class="fas fa-calendar-alt me-2"></i>Thời gian giao hàng dự kiến</h5>
                    <p class="mb-0"><strong><?= $estimatedDelivery ?></strong></p>
                    <small class="text-muted">Thời gian có thể thay đổi tùy thuộc vào tình trạng giao thông</small>
                </div>
                <?php endif; ?>

                <!-- Delivery Information -->
                <div class="order-container">
                    <h3 class="section-title">
                        <i class="fas fa-truck me-2"></i>
                        Thông tin giao hàng
                    </h3>
                    
                    <div class="delivery-info">
                        <div class="delivery-title">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            Địa chỉ giao hàng
                        </div>
                        <div class="delivery-item">
                            <i class="fas fa-user delivery-icon"></i>
                            <span><strong>Người nhận:</strong> <?= htmlspecialchars($orderDetails['info']['HoTen']) ?></span>
                        </div>
                        <div class="delivery-item">
                            <i class="fas fa-phone delivery-icon"></i>
                            <span><strong>Số điện thoại:</strong> <?= htmlspecialchars($orderDetails['info']['SoDienThoai'] ?? 'N/A') ?></span>
                        </div>
                        <div class="delivery-item">
                            <i class="fas fa-envelope delivery-icon"></i>
                            <span><strong>Email:</strong> <?= htmlspecialchars($orderDetails['info']['Email']) ?></span>
                        </div>
                        <div class="delivery-item">
                            <i class="fas fa-map-marker-alt delivery-icon"></i>
                            <span><strong>Địa chỉ:</strong> <?= htmlspecialchars($orderDetails['info']['DiaChi'] ?? 'N/A') ?></span>
                        </div>
                    </div>
                </div>

                <!-- Product List -->
                <div class="order-container">
                    <h3 class="section-title">
                        <i class="fas fa-shopping-bag me-2"></i>
                        Sản phẩm đã đặt (<?= $totalItems ?> sản phẩm)
                    </h3>
                    
                    <?php foreach($orderDetails['items'] as $item): ?>
                    <div class="product-card">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <img src="<?= getProductImage($item) ?>" 
                                     alt="<?= htmlspecialchars($item['TenSP']) ?>" 
                                     class="product-image">
                            </div>
                            <div class="col">
                                <div class="product-details">
                                    <div class="product-name"><?= htmlspecialchars($item['TenSP']) ?></div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="product-price"><?= number_format($item['DonGia'], 0, ',', '.') ?> đ</span>
                                        <span class="product-quantity">Số lượng: <?= htmlspecialchars($item['SoLuong']) ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="text-end">
                                    <div class="product-price"><?= number_format($item['DonGia'] * $item['SoLuong'], 0, ',', '.') ?> đ</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Review Section -->
                        <?php if ($orderDetails['info']['TenTrangThai'] === 'Delivered' && isset($reviewStatus[$item['MaSP']])): ?>
                        <div class="review-section mt-3 p-3 bg-light rounded">
                            <?php $reviewInfo = $reviewStatus[$item['MaSP']]; ?>
                            
                            <?php if ($reviewInfo['existingReview']): ?>
                                <!-- Existing Review -->
                                <div class="existing-review">
                                    <h6 class="text-success mb-2">
                                        <i class="fas fa-check-circle me-2"></i>
                                        Bạn đã đánh giá sản phẩm này cho đơn hàng này
                                    </h6>
                                                                         <?php // The existingReview here is a single review object for the current order, not an array ?>
                                     <div class="review-item mb-3 p-3 bg-white rounded border">
                                         <div class="rating-stars mb-2">
                                             <?php for ($i = 1; $i <= 5; $i++): ?>
                                                 <i class="fas fa-star <?= $i <= $reviewInfo['existingReview']['SoSao'] ? 'text-warning' : 'text-muted' ?>"></i>
                                             <?php endfor; ?>
                                             <span class="ms-2"><?= $reviewInfo['existingReview']['SoSao'] ?>/5</span>
                                         </div>
                                         <p class="review-content mb-2"><?= htmlspecialchars($reviewInfo['existingReview']['NoiDung']) ?></p>
                                         <small class="text-muted">
                                             Đánh giá ngày: <?= date('d/m/Y', strtotime($reviewInfo['existingReview']['NgayDanhGia'])) ?>
                                             <?php if (isset($reviewInfo['existingReview']['MaDH'])): ?>
                                                 <br>Đơn hàng #<?= $reviewInfo['existingReview']['MaDH'] ?>
                                             <?php endif; ?>
                                         </small>
                                     </div>
                                </div>
                            <?php elseif ($reviewInfo['canReview']): ?>
                                <!-- Review Form -->
                                <div class="review-form">
                                    <h6 class="text-primary mb-2">
                                        <i class="fas fa-star me-2"></i>
                                        Đánh giá sản phẩm này
                                    </h6>
                                                                         <form action="/websitePS/public/review/submit" method="POST" class="review-form-content">
                                        <input type="hidden" name="product_id" value="<?= $item['MaSP'] ?>">
                                        <input type="hidden" name="order_id" value="<?= $reviewInfo['orderId'] ?>">
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Đánh giá của bạn:</label>
                                            <div class="rating-input">
                                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                                <input type="radio" name="rating" value="<?= $i ?>" id="rating_<?= $item['MaSP'] ?>_<?= $i ?>" required>
                                                <label for="rating_<?= $item['MaSP'] ?>_<?= $i ?>" class="rating-star">
                                                    <i class="fas fa-star"></i>
                                                </label>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                        
                                                                                 <div class="mb-3">
                                             <label for="content_<?= $item['MaSP'] ?>" class="form-label">Nhận xét:</label>
                                             <textarea name="content" id="content_<?= $item['MaSP'] ?>" 
                                                       class="form-control" rows="3" 
                                                       placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm này..."></textarea>
                                         </div>
                                        
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-paper-plane me-2"></i>
                                            Gửi đánh giá
                                        </button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <!-- Cannot Review -->
                                <div class="cannot-review">
                                    <p class="text-muted mb-0">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <?= htmlspecialchars($reviewInfo['reason']) ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="summary-card">
                    <h4 class="summary-title">
                        <i class="fas fa-receipt me-2"></i>
                        Tổng quan đơn hàng
                    </h4>
                    
                    <div class="summary-item">
                        <span>Số sản phẩm:</span>
                        <span><?= $totalItems ?></span>
                    </div>
                    
                    <div class="summary-item">
                        <span>Tổng tiền hàng:</span>
                        <span><?= number_format($orderDetails['info']['TongTien'], 0, ',', '.') ?> đ</span>
                    </div>
                    
                    <div class="summary-item">
                        <span>Phí vận chuyển:</span>
                        <span><?= $shippingFee > 0 ? number_format($shippingFee, 0, ',', '.') . ' đ' : 'Miễn phí' ?></span>
                    </div>
                    
                    <div class="summary-item">
                        <span>Tổng thanh toán:</span>
                        <span><?= number_format($orderDetails['info']['TongTien'], 0, ',', '.') ?> đ</span>
                    </div>
                    
                    <div class="action-buttons">
                        <a href="/websitePS/public/account" class="btn btn-back w-100 mb-2">
                            <i class="fas fa-arrow-left me-2"></i>
                            Quay lại tài khoản
                        </a>
                        
                        <?php if ($orderDetails['info']['TenTrangThai'] === 'Pending'): ?>
                        <button type="button" 
                                class="btn btn-danger w-100"
                                onclick="cancelOrder(<?= $orderDetails['info']['MaDH'] ?>)">
                            <i class="fas fa-times me-2"></i>
                            Hủy đơn hàng
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
    
    <!-- Toast Notification Styles -->
    <style>
        .toast-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            padding: 0;
            min-width: 300px;
            max-width: 400px;
            z-index: 10000;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            border: 1px solid #e9ecef;
        }
        
        .toast-notification.show {
            transform: translateX(0);
        }
        
        .toast-notification.success {
            border-left: 4px solid #28a745;
        }
        
        .toast-notification.error {
            border-left: 4px solid #dc3545;
        }
        
        .toast-close {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            padding: 0;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background-color 0.2s;
        }
        
        .toast-close:hover {
            background-color: #f8f9fa;
            color: #495057;
        }
        
        .toast-header {
            display: flex;
            align-items: center;
            padding: 15px 20px 10px 20px;
            border-bottom: 1px solid #f8f9fa;
        }
        
        .toast-icon {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 12px;
        }
        
        .toast-icon.success {
            background-color: #d4edda;
            color: #155724;
        }
        
        .toast-icon.error {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .toast-title {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
            color: #495057;
        }
        
        .toast-body {
            padding: 10px 20px 15px 20px;
            color: #6c757d;
            font-size: 14px;
            line-height: 1.4;
        }
    </style>
    
    <!-- Toast Notification JavaScript -->
    <script>
        // Toast Notification Function
        function showToast(message, type = 'success') {
            // Remove existing toasts
            const existingToasts = document.querySelectorAll('.toast-notification');
            existingToasts.forEach(toast => toast.remove());
            
            // Create toast element
            const toast = document.createElement('div');
            toast.className = `toast-notification ${type}`;
            
            const icon = type === 'success' ? 'fas fa-check' : 'fas fa-exclamation-triangle';
            const title = type === 'success' ? 'Thành công!' : 'Lỗi!';
            
            toast.innerHTML = `
                <button class="toast-close" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
                <div class="toast-header">
                    <div class="toast-icon ${type}">
                        <i class="${icon}"></i>
                    </div>
                    <h6 class="toast-title">${title}</h6>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
            `;
            
            // Add to page
            document.body.appendChild(toast);
            
            // Show animation
            setTimeout(() => {
                toast.classList.add('show');
            }, 100);
            
            // Auto hide after 4 seconds
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    if (toast.parentElement) {
                        toast.remove();
                    }
                }, 300);
            }, 4000);
        }
        
        // Order Cancellation Function
        function cancelOrder(orderId) {
            if (!confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')) {
                return;
            }
            
            // Show loading state
            const cancelBtn = document.querySelector(`[onclick="cancelOrder(${orderId})"]`);
            const originalText = cancelBtn.innerHTML;
            cancelBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang hủy...';
            cancelBtn.disabled = true;
            
            // Send AJAX request
            fetch(`/websitePS/public/customerorders/cancel/${orderId}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message || 'Đơn hàng đã được hủy thành công!', 'success');
                    
                    // Reload page after a short delay to update the UI
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    showToast(data.message || 'Có lỗi xảy ra khi hủy đơn hàng!', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Có lỗi xảy ra khi hủy đơn hàng!', 'error');
            })
            .finally(() => {
                // Reset button state
                cancelBtn.innerHTML = originalText;
                cancelBtn.disabled = false;
            });
        }
        
        // Cập nhật thời gian đã trôi qua theo thời gian thực
        function updateTimeElapsed() {
            const orderDate = new Date('<?= $orderDetails['info']['NgayDatHang'] ?>');
            const now = new Date();
            const diff = now - orderDate;
            
            // Tính toán thời gian đã trôi qua
            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            
            let timeElapsedText = '';
            if (days > 0) {
                timeElapsedText = days + ' ngày ' + hours + ' giờ trước';
            } else if (hours > 0) {
                timeElapsedText = hours + ' giờ ' + minutes + ' phút trước';
            } else {
                timeElapsedText = minutes + ' phút trước';
            }
            
            // Cập nhật DOM
            const timeElapsedElement = document.getElementById('timeElapsed');
            if (timeElapsedElement) {
                timeElapsedElement.textContent = timeElapsedText;
            }
        }
        
        // Cập nhật thời gian mỗi phút
        setInterval(updateTimeElapsed, 60000); // 60000ms = 1 phút
        
        // Cập nhật ngay lập tức khi trang load
        document.addEventListener('DOMContentLoaded', function() {
            updateTimeElapsed();
        });
        
        // Cập nhật thêm mỗi giây để hiển thị chính xác hơn
        setInterval(updateTimeElapsed, 1000); // 1000ms = 1 giây
    </script>
</body>
</html>
