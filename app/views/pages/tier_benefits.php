<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ưu đãi theo phân khúc - Parrot Smell</title>
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
            background-color: #f8f9fa;
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
        
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, #00796b 100%);
            color: white;
            padding: 4rem 0;
            text-align: center;
        }
        
        .hero-title {
            font-family: var(--heading-font);
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .hero-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        .tier-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
            border: 3px solid transparent;
        }
        
        .tier-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .tier-card.current {
            border-color: var(--primary-color);
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }
        
        .tier-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .tier-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin-right: 1rem;
        }
        
        .tier-info h3 {
            font-family: var(--heading-font);
            margin: 0;
            font-size: 1.5rem;
        }
        
        .tier-info p {
            margin: 0;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .tier-benefits {
            margin-bottom: 1.5rem;
        }
        
        .benefit-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
            padding: 0.5rem;
            background: #f8f9fa;
            border-radius: 8px;
        }
        
        .benefit-item i {
            color: var(--primary-color);
            margin-right: 0.5rem;
            width: 20px;
        }
        
        .tier-progress {
            margin-bottom: 1rem;
        }
        
        .progress-bar {
            height: 8px;
            border-radius: 4px;
            background: #e9ecef;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary-color), #00796b);
            transition: width 0.3s ease;
        }
        
        .tier-stats {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            color: #6c757d;
        }
        
        .current-tier-badge {
            background: var(--primary-color);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .footer {
            background-color: var(--text-color);
            color: var(--secondary-color);
            padding: 3rem 0 2rem;
            margin-top: 4rem;
        }
        
        .footer a {
            color: var(--secondary-color);
            text-decoration: none;
        }
        
        .footer a:hover {
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <?php include __DIR__ . '/layouts/navbar.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="hero-title">Ưu Đãi Theo Phân Khúc</h1>
            <p class="hero-subtitle">Khám phá những ưu đãi đặc biệt dành riêng cho từng cấp độ khách hàng</p>
        </div>
    </section>

    <!-- Tier Benefits Section -->
    <section class="py-5">
        <div class="container">
            <?php if ($customerTierInfo): ?>
                <!-- Current Tier Info -->
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="tier-card current">
                            <div class="tier-header">
                                <div class="tier-icon" style="background: var(--primary-color);">
                                    <i class="fas fa-crown"></i>
                                </div>
                                <div class="tier-info">
                                    <h3>Phân khúc hiện tại: <?= htmlspecialchars($customerTierInfo['currentTier']) ?></h3>
                                    <p>Tổng chi tiêu: <?= number_format($customerTierInfo['totalSpent'], 0, ',', '.') ?> đ</p>
                                </div>
                                <div class="current-tier-badge ms-auto">
                                    Phân khúc hiện tại
                                </div>
                            </div>
                            
                            <?php if ($customerTierInfo['nextTier'] !== 'Đã đạt cấp cao nhất'): ?>
                                <div class="tier-progress">
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: <?= $customerTierInfo['progressToNext'] ?>%"></div>
                                    </div>
                                    <div class="tier-stats">
                                        <span>Tiến độ lên <?= htmlspecialchars($customerTierInfo['nextTier']) ?></span>
                                        <span><?= number_format($customerTierInfo['amountNeeded'], 0, ',', '.') ?> đ cần thêm</span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- All Tiers -->
            <div class="row">
                <?php
                $tiers = [
                    'Bronze' => ['color' => '#cd7f32', 'icon' => 'fas fa-medal', 'threshold' => 500000],
                    'Silver' => ['color' => '#c0c0c0', 'icon' => 'fas fa-medal', 'threshold' => 1000000],
                    'Gold' => ['color' => '#ffd700', 'icon' => 'fas fa-medal', 'threshold' => 2000000],
                    'Platinum' => ['color' => '#e5e4e2', 'icon' => 'fas fa-gem', 'threshold' => 5000000],
                    'Diamond' => ['color' => '#b9f2ff', 'icon' => 'fas fa-gem', 'threshold' => 10000000],
                    'VIP' => ['color' => '#ff6b35', 'icon' => 'fas fa-crown', 'threshold' => 20000000]
                ];
                
                foreach ($tiers as $tierName => $tierData):
                    $benefits = $promotionModel->getTierBenefits($tierName);
                    $isCurrentTier = $customerTierInfo && $customerTierInfo['currentTier'] === $tierName;
                ?>
                    <div class="col-lg-6 col-xl-4 mb-4">
                        <div class="tier-card <?= $isCurrentTier ? 'current' : '' ?>">
                            <div class="tier-header">
                                <div class="tier-icon" style="background: <?= $tierData['color'] ?>;">
                                    <i class="<?= $tierData['icon'] ?>"></i>
                                </div>
                                <div class="tier-info">
                                    <h3><?= htmlspecialchars($tierName) ?></h3>
                                    <p>Từ <?= number_format($tierData['threshold'], 0, ',', '.') ?> đ</p>
                                </div>
                                <?php if ($isCurrentTier): ?>
                                    <div class="current-tier-badge ms-auto">
                                        Hiện tại
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <?php if ($benefits): ?>
                                <div class="tier-benefits">
                                    <div class="benefit-item">
                                        <i class="fas fa-percentage"></i>
                                        <span>Giảm giá: <?= $benefits['discount'] ?></span>
                                    </div>
                                    <div class="benefit-item">
                                        <i class="fas fa-shopping-cart"></i>
                                        <span>Đơn hàng tối thiểu: <?= $benefits['minOrder'] ?></span>
                                    </div>
                                    <div class="benefit-item">
                                        <i class="fas fa-gift"></i>
                                        <span><?= $benefits['description'] ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($customerTierInfo): ?>
                                <?php if ($customerTierInfo['totalSpent'] >= $tierData['threshold']): ?>
                                    <div class="text-success">
                                        <i class="fas fa-check-circle me-2"></i>
                                        Đã đạt yêu cầu
                                    </div>
                                <?php else: ?>
                                    <div class="text-muted">
                                        <i class="fas fa-clock me-2"></i>
                                        Cần thêm <?= number_format($tierData['threshold'] - $customerTierInfo['totalSpent'], 0, ',', '.') ?> đ
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Call to Action -->
            <div class="row mt-5">
                <div class="col-12 text-center">
                    <div class="tier-card">
                        <h3 class="mb-3">Bắt đầu mua sắm để nhận ưu đãi!</h3>
                        <p class="mb-4">Mỗi đơn hàng đều góp phần nâng cấp phân khúc của bạn</p>
                        <a href="/websitePS/public/products/list" class="btn btn-primary btn-lg">
                            <i class="fas fa-shopping-bag me-2"></i>
                            Khám phá sản phẩm
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
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
