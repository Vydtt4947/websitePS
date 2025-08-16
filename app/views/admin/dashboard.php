<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Quản lý - Parrot Smell</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            padding: 20px;
            background-color: #343a40;
            color: #fff;
        }
        .sidebar .nav-link {
            color: #adb5bd;
            font-size: 1.1em;
            padding: 10px 15px;
            border-radius: 5px;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: #fff;
            background-color: #495057;
        }
        .sidebar .nav-link .fa {
            margin-right: 15px;
        }
        .main-content {
            margin-left: 250px;
            padding: 30px;
        }
        .stat-card {
            border-left: 5px solid;
        }
        .stat-card.border-primary { border-left-color: #0d6efd !important; }
        .stat-card.border-success { border-left-color: #198754 !important; }
        .stat-card.border-warning { border-left-color: #ffc107 !important; }
        .stat-card.border-info { border-left-color: #0dcaf0 !important; }
    </style>
</head>
<body>

<div class="sidebar">
    <h3 class="text-center mb-4">Parrot Smell</h3>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link active" href="/websitePS/public/admin"><i class="fa fa-tachometer-alt"></i>Bảng điều khiển</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/websitePS/public/orders"><i class="fa fa-file-invoice"></i>Quản lý Đơn hàng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/websitePS/public/customers"><i class="fa fa-users"></i>Quản lý Khách hàng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/websitePS/public/products"><i class="fa fa-cake-candles"></i>Quản lý Sản phẩm</a>
        </li>
        <li class="nav-item mt-auto">
            <a class="nav-link" href="/websitePS/public/auth/logout"><i class="fa fa-sign-out-alt"></i>Đăng xuất</a>
        </li>
    </ul>
</div>

<div class="main-content">
    <header class="d-flex justify-content-between align-items-center mb-4">
    <h1>Bảng điều khiển</h1>
    <div class="d-flex align-items-center">
        <span class="me-3">Chào, <?= htmlspecialchars($_SESSION['HoTen']) ?>!</span>
        <img src="https://i.pravatar.cc/40?img=1" alt="Avatar" class="rounded-circle">
    </div>
</header>

    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="card stat-card border-primary shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title text-primary">DOANH THU HÔM NAY</h5>
                    <p class="card-text fs-4 fw-bold"><?= number_format($todaysRevenue ?? 0, 0, ',', '.') ?> đ</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card stat-card border-success shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title text-success">ĐƠN HÀNG MỚI (Hôm nay)</h5>
                    <p class="card-text fs-4 fw-bold"><?= $todaysOrders ?? 0 ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card stat-card border-info shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title text-info">KHÁCH HÀNG MỚI (Tháng)</h5>
                    <p class="card-text fs-4 fw-bold"><?= $newCustomers ?? 0 ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card stat-card border-secondary shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title text-secondary">TỔNG SẢN PHẨM</h5>
                    <p class="card-text fs-4 fw-bold"><?= $totalProducts ?? 0 ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card shadow-sm h-100">
                <div class="card-header"><h4>Doanh thu 7 ngày gần nhất</h4></div>
                <div class="card-body">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card shadow-sm h-100">
                <div class="card-header"><h4>Đơn hàng gần đây</h4></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <tbody>
                                <?php if (empty($recentOrders)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Không có đơn hàng nào gần đây.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($recentOrders as $order): ?>
                                        <tr>
                                            <td>
                                                <strong>#<?= htmlspecialchars($order['MaDH']) ?></strong><br>
                                                <small><?= htmlspecialchars($order['HoTen']) ?></small>
                                            </td>
                                            <td class="text-end">
                                                <?= number_format($order['TongTien'], 0, ',', '.') ?> đ<br>
                                                <?php
                                                    $statusText = '';
                                                    switch ($order['TenTrangThai']) {
                                                        case 'Pending': $statusText = 'Chờ xử lý'; break;
                                                        case 'Processing': $statusText = 'Đang xử lý'; break;
                                                        case 'Shipping': $statusText = 'Đang giao hàng'; break;
                                                        case 'Delivered': $statusText = 'Đã giao hàng'; break;
                                                        case 'Cancelled': $statusText = 'Đã hủy'; break;
                                                        default: $statusText = $order['TenTrangThai'];
                                                    }
                                                ?>
                                                <small class="badge bg-light text-dark"><?= htmlspecialchars($statusText) ?></small>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($chartLabels ?? []) ?>,
            datasets: [{
                label: 'Doanh thu (đ)',
                data: <?= json_encode($chartData ?? []) ?>,
                backgroundColor: 'rgba(0, 150, 136, 0.6)',
                borderColor: 'rgba(0, 150, 136, 1)',
                borderWidth: 1,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value, index, values) {
                            if (value >= 1000000) {
                                return (value / 1000000) + 'tr';
                            }
                            if (value >= 1000) {
                                return (value / 1000) + 'k';
                            }
                            return value;
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
</body>
</html>