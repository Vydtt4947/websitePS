<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân - Parrot Smell</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
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
</body>
</html>
