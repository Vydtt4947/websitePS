<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân - Parrot Smell</title>
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
                        <h3 class="mb-4">Thông tin cá nhân</h3>
                        
                        <?php if (isset($_SESSION['success_message'])): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($_SESSION['success_message']) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            <?php unset($_SESSION['success_message']); ?>
                        <?php endif; ?>

                        <form action="/websitePS/public/account/updateProfile" method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="HoTen" class="form-label">Họ và tên</label>
                                    <input type="text" class="form-control" id="HoTen" name="HoTen" value="<?= htmlspecialchars($customer['HoTen'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="Email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="Email" value="<?= htmlspecialchars($customer['Email'] ?? '') ?>" readonly>
                                    <small class="text-muted">Email không thể thay đổi</small>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="SoDienThoai" class="form-label">Số điện thoại</label>
                                    <input type="tel" class="form-control" id="SoDienThoai" name="SoDienThoai" value="<?= htmlspecialchars($customer['SoDienThoai'] ?? '') ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="NgaySinh" class="form-label">Ngày sinh</label>
                                    <input type="date" class="form-control" id="NgaySinh" name="NgaySinh" value="<?= htmlspecialchars($customer['NgaySinh'] ?? '') ?>">
                                </div>
                            </div>

                            <hr class="my-4">
                            <h5 class="mb-3"><i class="fas fa-map-marker-alt me-2"></i>Thông tin giao hàng</h5>
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="DiaChiGiaoHang" class="form-label">Địa chỉ giao hàng</label>
                                    <input type="text" class="form-control" id="DiaChiGiaoHang" name="DiaChiGiaoHang" value="<?= htmlspecialchars($customer['DiaChiGiaoHang'] ?? '') ?>" placeholder="Ví dụ: 123 Đường ABC, Phường XYZ">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="TinhThanh" class="form-label">Tỉnh/Thành phố</label>
                                    <select class="form-select" id="TinhThanh" name="TinhThanh">
                                        <option value="">Chọn tỉnh/thành phố</option>
                                        <option value="Hà Nội" <?= ($customer['TinhThanh'] ?? '') === 'Hà Nội' ? 'selected' : '' ?>>Hà Nội</option>
                                        <option value="TP. Hồ Chí Minh" <?= ($customer['TinhThanh'] ?? '') === 'TP. Hồ Chí Minh' ? 'selected' : '' ?>>TP. Hồ Chí Minh</option>
                                        <option value="Đà Nẵng" <?= ($customer['TinhThanh'] ?? '') === 'Đà Nẵng' ? 'selected' : '' ?>>Đà Nẵng</option>
                                        <option value="Hải Phòng" <?= ($customer['TinhThanh'] ?? '') === 'Hải Phòng' ? 'selected' : '' ?>>Hải Phòng</option>
                                        <option value="Cần Thơ" <?= ($customer['TinhThanh'] ?? '') === 'Cần Thơ' ? 'selected' : '' ?>>Cần Thơ</option>
                                        <option value="An Giang" <?= ($customer['TinhThanh'] ?? '') === 'An Giang' ? 'selected' : '' ?>>An Giang</option>
                                        <option value="Bà Rịa - Vũng Tàu" <?= ($customer['TinhThanh'] ?? '') === 'Bà Rịa - Vũng Tàu' ? 'selected' : '' ?>>Bà Rịa - Vũng Tàu</option>
                                        <option value="Bắc Giang" <?= ($customer['TinhThanh'] ?? '') === 'Bắc Giang' ? 'selected' : '' ?>>Bắc Giang</option>
                                        <option value="Bắc Kạn" <?= ($customer['TinhThanh'] ?? '') === 'Bắc Kạn' ? 'selected' : '' ?>>Bắc Kạn</option>
                                        <option value="Bạc Liêu" <?= ($customer['TinhThanh'] ?? '') === 'Bạc Liêu' ? 'selected' : '' ?>>Bạc Liêu</option>
                                        <option value="Bắc Ninh" <?= ($customer['TinhThanh'] ?? '') === 'Bắc Ninh' ? 'selected' : '' ?>>Bắc Ninh</option>
                                        <option value="Bến Tre" <?= ($customer['TinhThanh'] ?? '') === 'Bến Tre' ? 'selected' : '' ?>>Bến Tre</option>
                                        <option value="Bình Định" <?= ($customer['TinhThanh'] ?? '') === 'Bình Định' ? 'selected' : '' ?>>Bình Định</option>
                                        <option value="Bình Dương" <?= ($customer['TinhThanh'] ?? '') === 'Bình Dương' ? 'selected' : '' ?>>Bình Dương</option>
                                        <option value="Bình Phước" <?= ($customer['TinhThanh'] ?? '') === 'Bình Phước' ? 'selected' : '' ?>>Bình Phước</option>
                                        <option value="Bình Thuận" <?= ($customer['TinhThanh'] ?? '') === 'Bình Thuận' ? 'selected' : '' ?>>Bình Thuận</option>
                                        <option value="Cà Mau" <?= ($customer['TinhThanh'] ?? '') === 'Cà Mau' ? 'selected' : '' ?>>Cà Mau</option>
                                        <option value="Cao Bằng" <?= ($customer['TinhThanh'] ?? '') === 'Cao Bằng' ? 'selected' : '' ?>>Cao Bằng</option>
                                        <option value="Đắk Lắk" <?= ($customer['TinhThanh'] ?? '') === 'Đắk Lắk' ? 'selected' : '' ?>>Đắk Lắk</option>
                                        <option value="Đắk Nông" <?= ($customer['TinhThanh'] ?? '') === 'Đắk Nông' ? 'selected' : '' ?>>Đắk Nông</option>
                                        <option value="Điện Biên" <?= ($customer['TinhThanh'] ?? '') === 'Điện Biên' ? 'selected' : '' ?>>Điện Biên</option>
                                        <option value="Đồng Nai" <?= ($customer['TinhThanh'] ?? '') === 'Đồng Nai' ? 'selected' : '' ?>>Đồng Nai</option>
                                        <option value="Đồng Tháp" <?= ($customer['TinhThanh'] ?? '') === 'Đồng Tháp' ? 'selected' : '' ?>>Đồng Tháp</option>
                                        <option value="Gia Lai" <?= ($customer['TinhThanh'] ?? '') === 'Gia Lai' ? 'selected' : '' ?>>Gia Lai</option>
                                        <option value="Hà Giang" <?= ($customer['TinhThanh'] ?? '') === 'Hà Giang' ? 'selected' : '' ?>>Hà Giang</option>
                                        <option value="Hà Nam" <?= ($customer['TinhThanh'] ?? '') === 'Hà Nam' ? 'selected' : '' ?>>Hà Nam</option>
                                        <option value="Hà Tĩnh" <?= ($customer['TinhThanh'] ?? '') === 'Hà Tĩnh' ? 'selected' : '' ?>>Hà Tĩnh</option>
                                        <option value="Hải Dương" <?= ($customer['TinhThanh'] ?? '') === 'Hải Dương' ? 'selected' : '' ?>>Hải Dương</option>
                                        <option value="Hậu Giang" <?= ($customer['TinhThanh'] ?? '') === 'Hậu Giang' ? 'selected' : '' ?>>Hậu Giang</option>
                                        <option value="Hòa Bình" <?= ($customer['TinhThanh'] ?? '') === 'Hòa Bình' ? 'selected' : '' ?>>Hòa Bình</option>
                                        <option value="Hưng Yên" <?= ($customer['TinhThanh'] ?? '') === 'Hưng Yên' ? 'selected' : '' ?>>Hưng Yên</option>
                                        <option value="Khánh Hòa" <?= ($customer['TinhThanh'] ?? '') === 'Khánh Hòa' ? 'selected' : '' ?>>Khánh Hòa</option>
                                        <option value="Kiên Giang" <?= ($customer['TinhThanh'] ?? '') === 'Kiên Giang' ? 'selected' : '' ?>>Kiên Giang</option>
                                        <option value="Kon Tum" <?= ($customer['TinhThanh'] ?? '') === 'Kon Tum' ? 'selected' : '' ?>>Kon Tum</option>
                                        <option value="Lai Châu" <?= ($customer['TinhThanh'] ?? '') === 'Lai Châu' ? 'selected' : '' ?>>Lai Châu</option>
                                        <option value="Lâm Đồng" <?= ($customer['TinhThanh'] ?? '') === 'Lâm Đồng' ? 'selected' : '' ?>>Lâm Đồng</option>
                                        <option value="Lạng Sơn" <?= ($customer['TinhThanh'] ?? '') === 'Lạng Sơn' ? 'selected' : '' ?>>Lạng Sơn</option>
                                        <option value="Lào Cai" <?= ($customer['TinhThanh'] ?? '') === 'Lào Cai' ? 'selected' : '' ?>>Lào Cai</option>
                                        <option value="Long An" <?= ($customer['TinhThanh'] ?? '') === 'Long An' ? 'selected' : '' ?>>Long An</option>
                                        <option value="Nam Định" <?= ($customer['TinhThanh'] ?? '') === 'Nam Định' ? 'selected' : '' ?>>Nam Định</option>
                                        <option value="Nghệ An" <?= ($customer['TinhThanh'] ?? '') === 'Nghệ An' ? 'selected' : '' ?>>Nghệ An</option>
                                        <option value="Ninh Bình" <?= ($customer['TinhThanh'] ?? '') === 'Ninh Bình' ? 'selected' : '' ?>>Ninh Bình</option>
                                        <option value="Ninh Thuận" <?= ($customer['TinhThanh'] ?? '') === 'Ninh Thuận' ? 'selected' : '' ?>>Ninh Thuận</option>
                                        <option value="Phú Thọ" <?= ($customer['TinhThanh'] ?? '') === 'Phú Thọ' ? 'selected' : '' ?>>Phú Thọ</option>
                                        <option value="Phú Yên" <?= ($customer['TinhThanh'] ?? '') === 'Phú Yên' ? 'selected' : '' ?>>Phú Yên</option>
                                        <option value="Quảng Bình" <?= ($customer['TinhThanh'] ?? '') === 'Quảng Bình' ? 'selected' : '' ?>>Quảng Bình</option>
                                        <option value="Quảng Nam" <?= ($customer['TinhThanh'] ?? '') === 'Quảng Nam' ? 'selected' : '' ?>>Quảng Nam</option>
                                        <option value="Quảng Ngãi" <?= ($customer['TinhThanh'] ?? '') === 'Quảng Ngãi' ? 'selected' : '' ?>>Quảng Ngãi</option>
                                        <option value="Quảng Ninh" <?= ($customer['TinhThanh'] ?? '') === 'Quảng Ninh' ? 'selected' : '' ?>>Quảng Ninh</option>
                                        <option value="Quảng Trị" <?= ($customer['TinhThanh'] ?? '') === 'Quảng Trị' ? 'selected' : '' ?>>Quảng Trị</option>
                                        <option value="Sóc Trăng" <?= ($customer['TinhThanh'] ?? '') === 'Sóc Trăng' ? 'selected' : '' ?>>Sóc Trăng</option>
                                        <option value="Sơn La" <?= ($customer['TinhThanh'] ?? '') === 'Sơn La' ? 'selected' : '' ?>>Sơn La</option>
                                        <option value="Tây Ninh" <?= ($customer['TinhThanh'] ?? '') === 'Tây Ninh' ? 'selected' : '' ?>>Tây Ninh</option>
                                        <option value="Thái Bình" <?= ($customer['TinhThanh'] ?? '') === 'Thái Bình' ? 'selected' : '' ?>>Thái Bình</option>
                                        <option value="Thái Nguyên" <?= ($customer['TinhThanh'] ?? '') === 'Thái Nguyên' ? 'selected' : '' ?>>Thái Nguyên</option>
                                        <option value="Thanh Hóa" <?= ($customer['TinhThanh'] ?? '') === 'Thanh Hóa' ? 'selected' : '' ?>>Thanh Hóa</option>
                                        <option value="Thừa Thiên Huế" <?= ($customer['TinhThanh'] ?? '') === 'Thừa Thiên Huế' ? 'selected' : '' ?>>Thừa Thiên Huế</option>
                                        <option value="Tiền Giang" <?= ($customer['TinhThanh'] ?? '') === 'Tiền Giang' ? 'selected' : '' ?>>Tiền Giang</option>
                                        <option value="Trà Vinh" <?= ($customer['TinhThanh'] ?? '') === 'Trà Vinh' ? 'selected' : '' ?>>Trà Vinh</option>
                                        <option value="Tuyên Quang" <?= ($customer['TinhThanh'] ?? '') === 'Tuyên Quang' ? 'selected' : '' ?>>Tuyên Quang</option>
                                        <option value="Vĩnh Long" <?= ($customer['TinhThanh'] ?? '') === 'Vĩnh Long' ? 'selected' : '' ?>>Vĩnh Long</option>
                                        <option value="Vĩnh Phúc" <?= ($customer['TinhThanh'] ?? '') === 'Vĩnh Phúc' ? 'selected' : '' ?>>Vĩnh Phúc</option>
                                        <option value="Yên Bái" <?= ($customer['TinhThanh'] ?? '') === 'Yên Bái' ? 'selected' : '' ?>>Yên Bái</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="QuanHuyen" class="form-label">Quận/Huyện</label>
                                    <input type="text" class="form-control" id="QuanHuyen" name="QuanHuyen" value="<?= htmlspecialchars($customer['QuanHuyen'] ?? '') ?>" placeholder="Ví dụ: Quận 1, Huyện Củ Chi">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="GhiChuGiaoHang" class="form-label">Ghi chú giao hàng</label>
                                    <textarea class="form-control" id="GhiChuGiaoHang" name="GhiChuGiaoHang" rows="3" placeholder="Ví dụ: Gọi điện trước khi giao, giao vào giờ nghỉ trưa..."><?= htmlspecialchars($customer['GhiChuGiaoHang'] ?? '') ?></textarea>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Cập nhật thông tin
                                </button>
                            </div>
                        </form>
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
