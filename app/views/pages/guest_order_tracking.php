<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tra cứu đơn hàng - Khách vãng lai - Parrot Smell</title>
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
            overflow-x: hidden; /* tránh thanh cuộn ngang */
        }
        
        .guest-tracking-page {
            height: 50vh;
            padding: 2rem 0;
            display: flex;
            justify-content: center; /* căn giữa ngang */
        }
        
        .guest-scale {
            transform: scale(0.6); /* giữ thu nhỏ 60% */
            transform-origin: top center;
            width: 100%;
            max-width: 1400px; /* giới hạn chiều rộng gốc trước khi scale */
        }
        
        .guest-tracking-container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .guest-tracking-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #00796b 100%);
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 3rem 2rem;
            text-align: center;
            margin-bottom: 0;
        }
        
        .guest-tracking-header h1 {
            font-family: var(--heading-font);
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .guest-tracking-header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .guest-tracking-content {
            background: white;
            border-radius: 0 0 20px 20px;
            padding: 3rem;
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
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
        
        /* Timeline trạng thái đơn hàng */
        .order-timeline {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .timeline-title {
            font-family: var(--heading-font);
            color: var(--text-color);
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }
        
        .timeline-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .timeline-item:last-child {
            margin-bottom: 0;
        }
        
        .timeline-item:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 25px;
            top: 50px;
            width: 2px;
            height: calc(100% - 25px);
            background: #dee2e6;
        }
        
        .timeline-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1.5rem;
            flex-shrink: 0;
            font-size: 1.2rem;
            color: white;
        }
        
        .timeline-icon.completed {
            background: linear-gradient(135deg, #28a745, #20c997);
        }
        
        .timeline-icon.current {
            background: linear-gradient(135deg, var(--primary-color), #00796b);
            animation: pulse 2s infinite;
        }
        
        .timeline-icon.pending {
            background: linear-gradient(135deg, #6c757d, #495057);
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        .timeline-content {
            flex-grow: 1;
        }
        
        .timeline-status {
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }
        
        .timeline-description {
            color: #6c757d;
            font-size: 0.9rem;
            line-height: 1.4;
        }
        
        .timeline-date {
            color: var(--primary-color);
            font-size: 0.85rem;
            font-weight: 500;
            margin-top: 0.5rem;
        }
        
        /* Thông tin bổ sung */
        .additional-info {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            border-left: 4px solid var(--primary-color);
        }
        
        .additional-info h4 {
            color: #1976d2;
            margin-bottom: 1rem;
            font-family: var(--heading-font);
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }
        
        .info-grid-item {
            background: rgba(255,255,255,0.8);
            padding: 1rem;
            border-radius: 10px;
            text-align: center;
        }
        
        .info-grid-label {
            font-size: 0.8rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }
        
        .info-grid-value {
            font-weight: 600;
            color: var(--text-color);
            font-size: 1.1rem;
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
        
        .back-to-home {
            text-align: center;
            margin-top: 2rem;
        }
        
        .btn-back {
            background-color: var(--primary-color);
            border: 2px solid var(--primary-color);
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-back:hover {
            background-color: #00796b;
            border-color: #00796b;
            color: white;
            transform: translateY(-2px);
        }
        
        @media (max-width: 768px) {
            .guest-tracking-header h1 {
                font-size: 2rem;
            }
            
            .guest-tracking-content {
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

<div class="guest-tracking-page">
    <div class="guest-scale">
        <div class="container">
            <div class="guest-tracking-container">
                <div class="guest-tracking-header">
                    <h1><i class="fas fa-search me-3"></i>Tra cứu đơn hàng</h1>
                    <p>Dành cho khách vãng lai - Nhập mã đơn hàng và số điện thoại để theo dõi tình trạng đơn hàng</p>
                </div>
                
                <div class="guest-tracking-content">
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
                                        
                                        // Mô tả chi tiết cho từng trạng thái
                                        $statusDescriptions = [
                                            'Pending' => 'Đơn hàng đã được tiếp nhận và đang chờ xử lý',
                                            'Processing' => 'Đơn hàng đang được chuẩn bị và đóng gói',
                                            'Shipping' => 'Đơn hàng đã được giao cho đơn vị vận chuyển',
                                            'Delivered' => 'Đơn hàng đã được giao thành công',
                                            'Cancelled' => 'Đơn hàng đã được hủy'
                                        ];
                                        $statusDescription = $statusDescriptions[$order['TrangThai']] ?? '';
                                        ?>
                                        <div class="status-badge status-<?= strtolower($order['TrangThai']) ?>">
                                            <?= $statusText ?>
                                        </div>
                                        <?php if ($statusDescription): ?>
                                            <div style="font-size: 0.85rem; color: #6c757d; margin-top: 0.5rem; max-width: 200px;">
                                                <?= $statusDescription ?>
                                            </div>
                                        <?php endif; ?>
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

                            <!-- Timeline trạng thái đơn hàng -->
                            <div class="order-timeline">
                                <h4 class="timeline-title">
                                    <i class="fas fa-route me-2"></i>
                                    Tiến trình đơn hàng
                                </h4>
                                
                                <?php
                                $orderModel = new OrderModel();
                                $currentStatus = $order['TrangThai'];
                                $orderDate = strtotime($order['NgayDatHang']);
                                
                                // Định nghĩa các bước trong timeline
                                $timelineSteps = [
                                    'Pending' => [
                                        'icon' => 'fas fa-clock',
                                        'title' => 'Đơn hàng đã được đặt',
                                        'description' => 'Đơn hàng của bạn đã được tiếp nhận và đang chờ xử lý',
                                        'date' => date('d/m/Y H:i', $orderDate)
                                    ],
                                    'Processing' => [
                                        'icon' => 'fas fa-cogs',
                                        'title' => 'Đang xử lý',
                                        'description' => 'Đơn hàng đang được chuẩn bị và đóng gói',
                                        'date' => $currentStatus == 'Processing' || $currentStatus == 'Shipping' || $currentStatus == 'Delivered' ? date('d/m/Y H:i', $orderDate + 3600) : null
                                    ],
                                    'Shipping' => [
                                        'icon' => 'fas fa-shipping-fast',
                                        'title' => 'Đang giao hàng',
                                        'description' => 'Đơn hàng đã được giao cho đơn vị vận chuyển',
                                        'date' => $currentStatus == 'Shipping' || $currentStatus == 'Delivered' ? date('d/m/Y H:i', $orderDate + 7200) : null
                                    ],
                                    'Delivered' => [
                                        'icon' => 'fas fa-check-circle',
                                        'title' => 'Đã giao hàng',
                                        'description' => 'Đơn hàng đã được giao thành công',
                                        'date' => $currentStatus == 'Delivered' ? date('d/m/Y H:i', $orderDate + 14400) : null
                                    ]
                                ];
                                
                                // Nếu đơn hàng bị hủy
                                if ($currentStatus == 'Cancelled') {
                                    $timelineSteps = [
                                        'Pending' => [
                                            'icon' => 'fas fa-clock',
                                            'title' => 'Đơn hàng đã được đặt',
                                            'description' => 'Đơn hàng của bạn đã được tiếp nhận',
                                            'date' => date('d/m/Y H:i', $orderDate)
                                        ],
                                        'Cancelled' => [
                                            'icon' => 'fas fa-times-circle',
                                            'title' => 'Đơn hàng đã bị hủy',
                                            'description' => 'Đơn hàng đã được hủy theo yêu cầu hoặc do không thể xử lý',
                                            'date' => date('d/m/Y H:i', $orderDate + 3600)
                                        ]
                                    ];
                                }
                                
                                foreach ($timelineSteps as $status => $step):
                                    $isCompleted = false;
                                    $isCurrent = false;
                                    
                                    if ($currentStatus == 'Cancelled') {
                                        $isCompleted = $status == 'Pending' || $status == 'Cancelled';
                                        $isCurrent = $status == 'Cancelled';
                                    } else {
                                        $isCompleted = array_search($status, ['Pending', 'Processing', 'Shipping', 'Delivered']) <= array_search($currentStatus, ['Pending', 'Processing', 'Shipping', 'Delivered']);
                                        $isCurrent = $status == $currentStatus;
                                    }
                                    
                                    $iconClass = $isCompleted ? 'completed' : ($isCurrent ? 'current' : 'pending');
                                ?>
                                    <div class="timeline-item">
                                        <div class="timeline-icon <?= $iconClass ?>">
                                            <i class="<?= $step['icon'] ?>"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <div class="timeline-status"><?= $step['title'] ?></div>
                                            <div class="timeline-description"><?= $step['description'] ?></div>
                                            <?php if ($step['date']): ?>
                                                <div class="timeline-date">
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    <?= $step['date'] ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Thông tin bổ sung -->
                            <div class="additional-info">
                                <h4>
                                    <i class="fas fa-info-circle me-2"></i>
                                    Thông tin bổ sung
                                </h4>
                                <div class="info-grid">
                                    <div class="info-grid-item">
                                        <div class="info-grid-label">Mã đơn hàng</div>
                                        <div class="info-grid-value">#<?= $order['MaDH'] ?></div>
                                    </div>
                                    <div class="info-grid-item">
                                        <div class="info-grid-label">Ngày đặt hàng</div>
                                        <div class="info-grid-value"><?= date('d/m/Y', strtotime($order['NgayDatHang'])) ?></div>
                                    </div>
                                    <div class="info-grid-item">
                                        <div class="info-grid-label">Giờ đặt hàng</div>
                                        <div class="info-grid-value"><?= date('H:i', strtotime($order['NgayDatHang'])) ?></div>
                                    </div>
                                    <div class="info-grid-item">
                                        <div class="info-grid-label">Số sản phẩm</div>
                                        <div class="info-grid-value"><?= isset($orderDetails['items']) ? count($orderDetails['items']) : 0 ?> sản phẩm</div>
                                    </div>
                                    <div class="info-grid-item">
                                        <div class="info-grid-label">Phương thức thanh toán</div>
                                        <div class="info-grid-value"><?= $order['PhuongThucThanhToan'] == 'cod' ? 'Thanh toán khi nhận hàng' : 'Chuyển khoản' ?></div>
                                    </div>
                                    <div class="info-grid-item">
                                        <div class="info-grid-label">Trạng thái hiện tại</div>
                                        <div class="info-grid-value"><?= $orderModel->getOrderStatusText($order['TrangThai']) ?></div>
                                    </div>
                                    <?php if (isset($order) && $order): ?>
                                    <div class="info-grid-item">
                                        <div class="info-grid-label">Thời gian đã trôi qua</div>
                                        <div class="info-grid-value" id="timeElapsed">
                                            <?php
                                            $orderDate = new DateTime($order['NgayDatHang']);
                                            $now = new DateTime();
                                            $interval = $now->diff($orderDate);
                                            
                                            if ($interval->days > 0) {
                                                echo $interval->days . ' ngày ' . $interval->h . ' giờ trước';
                                            } elseif ($interval->h > 0) {
                                                echo $interval->h . ' giờ ' . $interval->i . ' phút trước';
                                            } else {
                                                echo $interval->i . ' phút trước';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
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
                            
                            <!-- Thông tin liên hệ hỗ trợ -->
                            <div style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); border-radius: 15px; padding: 1.5rem; margin-top: 2rem; border-left: 4px solid #ffc107;">
                                <div style="display: flex; align-items: center; margin-bottom: 1rem;">
                                    <i class="fas fa-headset me-3" style="font-size: 1.5rem; color: #856404;"></i>
                                    <h5 style="color: #856404; margin: 0;">Cần hỗ trợ?</h5>
                                </div>
                                <p style="color: #856404; margin-bottom: 1rem;">
                                    Nếu bạn có thắc mắc về đơn hàng hoặc cần hỗ trợ, vui lòng liên hệ với chúng tôi:
                                </p>
                                <div style="display: flex; flex-wrap: wrap; gap: 1rem;">
                                    <div style="background: rgba(255,255,255,0.8); padding: 0.75rem 1rem; border-radius: 10px; flex: 1; min-width: 200px;">
                                        <div style="font-weight: 600; color: #856404; margin-bottom: 0.25rem;">
                                            <i class="fas fa-phone me-2"></i>Hotline
                                        </div>
                                        <div style="color: #856404;">0767 150 474</div>
                                    </div>
                                    <div style="background: rgba(255,255,255,0.8); padding: 0.75rem 1rem; border-radius: 10px; flex: 1; min-width: 200px;">
                                        <div style="font-weight: 600; color: #856404; margin-bottom: 0.25rem;">
                                            <i class="fas fa-envelope me-2"></i>Email
                                        </div>
                                        <div style="color: #856404;">cucxacdufong@gmail.com</div>
                                    </div>
                                </div>
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
                    
                    <!-- Nút về trang chủ -->
                    <div class="back-to-home">
                        <a href="/websitePS/public/" class="btn-back">
                            <i class="fas fa-home me-2"></i>
                            Về trang chủ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
<?php if (isset($order) && $order): ?>
// Cập nhật thời gian đã trôi qua theo thời gian thực
function updateTimeElapsed() {
    const orderDate = new Date('<?= $order['NgayDatHang'] ?>');
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
<?php endif; ?>
</script>

</body>
</html>
