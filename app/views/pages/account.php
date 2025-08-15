<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài khoản của tôi - Parrot Smell</title>
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
</body>
</html>