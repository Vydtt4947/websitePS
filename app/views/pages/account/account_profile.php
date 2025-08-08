<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân - Parrot Smell</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
                        <form action="/websitePS/public/account/updateProfile" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email (Không thể thay đổi)</label>
                                <input type="email" class="form-control" id="email" value="<?= htmlspecialchars($customer['Email']) ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="HoTen" class="form-label">Họ Tên</label>
                                <input type="text" class="form-control" id="HoTen" name="HoTen" value="<?= htmlspecialchars($customer['HoTen']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="SoDienThoai" class="form-label">Số điện thoại</label>
                                <input type="tel" class="form-control" id="SoDienThoai" name="SoDienThoai" value="<?= htmlspecialchars($customer['SoDienThoai']) ?>">
                            </div>
                            <div class="mb-3">
                                <label for="NgaySinh" class="form-label">Ngày sinh</label>
                                <input type="date" class="form-control" id="NgaySinh" name="NgaySinh" value="<?= htmlspecialchars($customer['NgaySinh']) ?>">
                            </div>
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
