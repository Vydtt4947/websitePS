<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài khoản của tôi - Parrot Smell</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/websitePS/public/assets/css/style.css">
    <link rel="stylesheet" href="/websitePS/public/assets/css/header-footer.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Roboto', sans-serif; }
    </style>
</head>
<body>
    <?php include __DIR__ . '/layouts/navbar.php'; ?>

    <div class="container my-5">
        <div class="row">
            <div class="col-lg-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <img src="https://i.pravatar.cc/150?u=<?= htmlspecialchars($customer['MaKH']) ?>" class="rounded-circle mb-3" width="100" alt="Avatar">
                        <h5><?= htmlspecialchars($customer['HoTen']) ?></h5>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="/websitePS/public/account" class="list-group-item list-group-item-action <?= ($activeTab === 'history') ? 'active' : '' ?>">Lịch sử mua hàng</a>
                        <a href="/websitePS/public/account/profile" class="list-group-item list-group-item-action <?= ($activeTab === 'profile') ? 'active' : '' ?>">Thông tin cá nhân</a>
                        <a href="/websitePS/public/customerauth/logout" class="list-group-item list-group-item-action text-danger">Đăng xuất</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <!-- Thông tin phân loại khách hàng -->
                <?php if (isset($tierInfo) && $tierInfo): ?>
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-crown me-2"></i>Thông tin phân loại khách hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-3">
                                        <?php
                                            $tierClass = '';
                                            $tierIcon = '';
                                                                                         switch ($tierInfo['currentTier']) {
                                                 case 'Bronze':
                                                     $tierClass = 'bg-warning text-dark';
                                                     $tierIcon = '🥉';
                                                     break;
                                                 case 'Silver':
                                                     $tierClass = 'bg-secondary';
                                                     $tierIcon = '🥈';
                                                     break;
                                                 case 'Gold':
                                                     $tierClass = 'bg-warning';
                                                     $tierIcon = '🥇';
                                                     break;
                                                 case 'Platinum':
                                                     $tierClass = 'bg-info';
                                                     $tierIcon = '💎';
                                                     break;
                                                 case 'Diamond':
                                                     $tierClass = 'bg-primary';
                                                     $tierIcon = '💠';
                                                     break;
                                                 case 'VIP':
                                                     $tierClass = 'bg-danger';
                                                     $tierIcon = '👑';
                                                     break;
                                                 default:
                                                     $tierClass = 'bg-light text-dark';
                                                     $tierIcon = '👤';
                                             }
                                        ?>
                                        <span class="badge <?= $tierClass ?> fs-6"><?= $tierIcon ?> <?= htmlspecialchars($tierInfo['currentTier']) ?></span>
                                    </div>
                                    <div>
                                        <strong>Phân loại hiện tại</strong><br>
                                        <small class="text-muted">Tổng chi tiêu: <?= number_format($tierInfo['totalSpent'], 0, ',', '.') ?> đ</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <strong>Phân loại tiếp theo:</strong> <?= htmlspecialchars($tierInfo['nextTier']) ?>
                                    <?php if ($tierInfo['amountNeeded'] > 0): ?>
                                    <br><small class="text-muted">Cần thêm: <?= number_format($tierInfo['amountNeeded'], 0, ',', '.') ?> đ</small>
                                    <?php endif; ?>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-success" role="progressbar" 
                                         style="width: <?= $tierInfo['progressToNext'] ?>%" 
                                         aria-valuenow="<?= $tierInfo['progressToNext'] ?>" 
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <small class="text-muted">Tiến độ: <?= round($tierInfo['progressToNext'], 1) ?>%</small>
                            </div>
                        </div>
                        
                        <!-- Thông tin các cấp độ -->
                        <div class="row mt-3">
                            <div class="col-12">
                                                                 <small class="text-muted">
                                     <strong>Hệ thống phân loại:</strong><br>
                                     • Bronze: Mua hàng từ 500,000đ<br>
                                     • Silver: Mua hàng từ 1,000,000đ<br>
                                     • Gold: Mua hàng từ 2,000,000đ<br>
                                     • Platinum: Mua hàng từ 5,000,000đ<br>
                                     • Diamond: Mua hàng từ 10,000,000đ<br>
                                     • VIP: Mua hàng từ 20,000,000đ
                                 </small>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="mb-4">Lịch sử mua hàng</h3>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Mã ĐH</th>
                                        <th>Ngày đặt</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($orderHistory)): ?>
                                        <tr><td colspan="5" class="text-center">Bạn chưa có đơn hàng nào.</td></tr>
                                    <?php else: ?>
                                        <?php foreach ($orderHistory as $order): ?>
                                        <tr>
                                            <td>#<?= htmlspecialchars($order['MaDH']) ?></td>
                                            <td><?= date('d/m/Y H:i', strtotime($order['NgayDatHang'])) ?></td>
                                            <td><?= number_format($order['TongTien'], 0, ',', '.') ?> đ</td>
                                            <td>
                                                <?php
                                                    $statusClass = '';
                                                    $statusText = '';
                                                    switch ($order['TenTrangThai']) {
                                                        case 'Pending': 
                                                            $statusClass = 'bg-warning text-dark'; 
                                                            $statusText = 'Chờ xử lý';
                                                            break;
                                                        case 'Processing': 
                                                            $statusClass = 'bg-info text-dark'; 
                                                            $statusText = 'Đang xử lý';
                                                            break;
                                                        case 'Shipping': 
                                                            $statusClass = 'bg-primary'; 
                                                            $statusText = 'Đang giao hàng';
                                                            break;
                                                        case 'Delivered': 
                                                            $statusClass = 'bg-success'; 
                                                            $statusText = 'Đã giao hàng';
                                                            break;
                                                        case 'Cancelled': 
                                                            $statusClass = 'bg-danger'; 
                                                            $statusText = 'Đã hủy';
                                                            break;
                                                        default: 
                                                            $statusClass = 'bg-secondary'; 
                                                            $statusText = $order['TenTrangThai'];
                                                    }
                                                ?>
                                                <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                                            </td>
                                            <td class="text-end">
                                                <a href="/websitePS/public/customerorders/show/<?= $order['MaDH'] ?>" class="btn btn-sm btn-outline-primary">Xem</a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
        <!-- Professional Tier Change Notification Modal -->
    <?php if (isset($tierChangeNotification) && $tierChangeNotification): ?>
    <div class="celebration-modal" id="celebrationModal">
        <!-- Fireworks Container -->
        <div class="fireworks-container">
            <div class="firework"></div>
            <div class="firework"></div>
            <div class="firework"></div>
            <div class="firework"></div>
            <div class="firework"></div>
            <div class="firework"></div>
            <div class="sparkle"></div>
            <div class="sparkle"></div>
            <div class="sparkle"></div>
            <div class="sparkle"></div>
            <div class="confetti"></div>
            <div class="confetti"></div>
            <div class="confetti"></div>
            <div class="confetti"></div>
            <div class="confetti"></div>
            <div class="confetti"></div>
            <div class="confetti"></div>
            <div class="confetti"></div>
            <div class="confetti"></div>
        </div>
        
        <div class="celebration-content <?= $tierChangeNotification['change_type'] ?>">
            <!-- Close Button -->
            <button class="close-button" onclick="closeCelebration()">×</button>
            
            <!-- Left Side - Header Section -->
            <div class="celebration-header <?= $tierChangeNotification['change_type'] ?>">
                <?php
                    $tierIcon = '';
                    $tierClass = '';
                    $tierName = '';
                    $benefits = [];
                    $isUpgrade = $tierChangeNotification['change_type'] === 'upgrade';
                    
                    switch ($tierChangeNotification['new_tier']) {
                        case 'Bronze':
                            $tierIcon = '🥉';
                            $tierClass = 'bronze';
                            $tierName = 'Bronze';
                            $benefits = [
                                'Giảm giá 5% cho tất cả sản phẩm',
                                'Ưu tiên xử lý đơn hàng',
                                'Tặng quà sinh nhật',
                                'Thông báo khuyến mãi sớm'
                            ];
                            break;
                        case 'Silver':
                            $tierIcon = '🥈';
                            $tierClass = 'silver';
                            $tierName = 'Silver';
                            $benefits = [
                                'Giảm giá 10% cho tất cả sản phẩm',
                                'Miễn phí vận chuyển cho đơn hàng từ 500k',
                                'Tặng quà sinh nhật cao cấp',
                                'Hỗ trợ khách hàng ưu tiên',
                                'Tham gia chương trình khách hàng thân thiết'
                            ];
                            break;
                        case 'Gold':
                            $tierIcon = '🥇';
                            $tierClass = 'gold';
                            $tierName = 'Gold';
                            $benefits = [
                                'Giảm giá 15% cho tất cả sản phẩm',
                                'Miễn phí vận chuyển cho mọi đơn hàng',
                                'Quà tặng sinh nhật đặc biệt',
                                'Hỗ trợ khách hàng VIP 24/7',
                                'Ưu tiên mua hàng trước khi mở bán',
                                'Tham gia sự kiện đặc biệt'
                            ];
                            break;
                        case 'Platinum':
                            $tierIcon = '💎';
                            $tierClass = 'platinum';
                            $tierName = 'Platinum';
                            $benefits = [
                                'Giảm giá 20% cho tất cả sản phẩm',
                                'Miễn phí vận chuyển cho mọi đơn hàng',
                                'Quà tặng sinh nhật cao cấp',
                                'Hỗ trợ khách hàng VIP 24/7',
                                'Ưu tiên mua hàng trước khi mở bán',
                                'Tham gia sự kiện đặc biệt',
                                'Dịch vụ chăm sóc khách hàng cá nhân'
                            ];
                            break;
                        case 'Diamond':
                            $tierIcon = '💠';
                            $tierClass = 'diamond';
                            $tierName = 'Diamond';
                            $benefits = [
                                'Giảm giá 25% cho tất cả sản phẩm',
                                'Miễn phí vận chuyển cho mọi đơn hàng',
                                'Quà tặng sinh nhật đặc biệt',
                                'Hỗ trợ khách hàng VIP 24/7',
                                'Ưu tiên mua hàng trước khi mở bán',
                                'Tham gia sự kiện đặc biệt',
                                'Dịch vụ chăm sóc khách hàng cá nhân',
                                'Quà tặng độc quyền hàng tháng'
                            ];
                            break;
                        case 'VIP':
                            $tierIcon = '👑';
                            $tierClass = 'vip';
                            $tierName = 'VIP';
                            $benefits = [
                                'Giảm giá 30% cho tất cả sản phẩm',
                                'Miễn phí vận chuyển cho mọi đơn hàng',
                                'Quà tặng sinh nhật đặc biệt',
                                'Hỗ trợ khách hàng VIP 24/7',
                                'Ưu tiên mua hàng trước khi mở bán',
                                'Tham gia sự kiện đặc biệt',
                                'Dịch vụ chăm sóc khách hàng cá nhân',
                                'Quà tặng độc quyền hàng tháng',
                                'Dịch vụ giao hàng ưu tiên',
                                'Tư vấn mua sắm cá nhân'
                            ];
                            break;
                    }
                ?>
                
                <div class="tier-icon"><?= $tierIcon ?></div>
                <h1 class="celebration-title">
                    <?php if ($isUpgrade): ?>
                        🎉 Chúc mừng bạn! 🎉
                    <?php else: ?>
                        📊 Thông báo phân loại
                    <?php endif; ?>
                </h1>
                <p class="celebration-subtitle">
                    <?php if ($isUpgrade): ?>
                        Bạn đã đạt cấp <?= $tierName ?> thành công!
                    <?php else: ?>
                        Phân loại của bạn đã được cập nhật
                    <?php endif; ?>
                </p>
                <div class="tier-badge <?= $tierClass ?>"><?= $tierName ?></div>
            </div>
            
            <!-- Right Side - Body Section -->
            <div class="celebration-body">
                <!-- Stats Display -->
                <div class="tier-stats">
                    <div class="stat-item">
                        <span class="stat-value"><?= number_format($tierChangeNotification['total_spent'], 0, ',', '.') ?> đ</span>
                        <span class="stat-label">Tổng chi tiêu</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-value"><?= $tierName ?></span>
                        <span class="stat-label">Phân loại mới</span>
                    </div>
                </div>
                
                <!-- Message -->
                <p class="celebration-message">
                    <?php if ($isUpgrade): ?>
                        Chúc mừng! Bạn đã đạt cấp <strong><?= $tierName ?></strong> và mở khóa những ưu đãi đặc biệt dưới đây.
                    <?php else: ?>
                        Bạn đã được phân loại lại thành <strong><?= $tierName ?></strong> dựa trên tổng chi tiêu hiện tại.
                    <?php endif; ?>
                </p>
                
                <!-- Benefits or Notes Section -->
                <div class="benefits-section">
                    <?php if ($isUpgrade): ?>
                        <div class="benefits-title">
                            <span>🎁</span>
                            <span>Ưu đãi dành cho bạn</span>
                        </div>
                        <ul class="benefits-list">
                            <?php foreach ($benefits as $benefit): ?>
                            <li><?= htmlspecialchars($benefit) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <div class="benefits-title">
                            <span>💡</span>
                            <span>Lời khuyên</span>
                        </div>
                        <ul class="benefits-list">
                            <li>Mua thêm hàng để lên cấp và nhận ưu đãi tốt hơn</li>
                            <li>Chúng tôi luôn sẵn sàng hỗ trợ bạn</li>
                            <li>Theo dõi tiến độ lên cấp trong trang cá nhân</li>
                        </ul>
                    <?php endif; ?>
                </div>
                
                <!-- Action Button -->
                <button class="celebration-button <?= $tierChangeNotification['change_type'] ?>" onclick="closeCelebration()">
                    <?php if ($isUpgrade): ?>
                        🎊 Tuyệt vời! 🎊
                    <?php else: ?>
                        👍 Đã hiểu
                    <?php endif; ?>
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <style>
        @import url('/websitePS/assets/css/fireworks.css');
    </style>
    
         <script>
         function closeCelebration() {
             const modal = document.getElementById('celebrationModal');
             if (modal) {
                 modal.style.animation = 'fadeOut 0.5s ease-out';
                 setTimeout(() => {
                     modal.remove();
                 }, 500);
             }
         }
         
         // Auto close after 15 seconds for upgrade, 10 seconds for downgrade
         <?php if (isset($tierChangeNotification) && $tierChangeNotification): ?>
         setTimeout(() => {
             closeCelebration();
         }, <?= $tierChangeNotification['change_type'] === 'upgrade' ? '15000' : '10000' ?>);
         <?php endif; ?>
         
         // Add fadeOut animation
         const style = document.createElement('style');
         style.textContent = `
             @keyframes fadeOut {
                 from { 
                     opacity: 1;
                     transform: scale(1);
                 }
                 to { 
                     opacity: 0;
                     transform: scale(0.9);
                 }
             }
         `;
         document.head.appendChild(style);
         
         // Add keyboard support
         document.addEventListener('keydown', function(event) {
             if (event.key === 'Escape') {
                 closeCelebration();
             }
         });
         
         // Add click outside to close
         document.addEventListener('click', function(event) {
             const modal = document.getElementById('celebrationModal');
             if (modal && event.target === modal) {
                 closeCelebration();
             }
         });
     </script>
</body>
</html>