<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Trang Quản trị - Parrot Smell' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f8f9fa; }
        .sidebar { position: fixed; top: 0; left: 0; height: 100vh; width: 250px; padding: 20px; background-color: #343a40; color: #fff; }
        .sidebar .nav-link { color: #adb5bd; font-size: 1.1em; padding: 10px 15px; border-radius: 5px; transition: all 0.2s; }
        .sidebar .nav-link:hover { color: #fff; background-color: #495057; }
        .sidebar .nav-link.active { color: #fff; background-color: #0d6efd; }
        .sidebar .nav-link .fa { margin-right: 15px; width: 20px; text-align: center;}
        .main-content { margin-left: 250px; padding: 30px; }
    </style>
</head>
<body>
<div class="sidebar">
    <h3 class="text-center mb-4">Parrot Smell</h3>
    <ul class="nav flex-column h-100">
        <li class="nav-item">
            <a class="nav-link <?= ($activePage === 'admin') ? 'active' : '' ?>" href="/websitePS/public/admin"><i class="fa fa-tachometer-alt"></i>Bảng điều khiển</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($activePage === 'orders') ? 'active' : '' ?>" href="/websitePS/public/orders"><i class="fa fa-file-invoice"></i>Quản lý Đơn hàng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($activePage === 'customers') ? 'active' : '' ?>" href="/websitePS/public/customers"><i class="fa fa-users"></i>Quản lý Khách hàng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($activePage === 'products') ? 'active' : '' ?>" href="/websitePS/public/products"><i class="fa fa-cake-candles"></i>Quản lý Sản phẩm</a>
        </li>
        <li class="nav-item mt-auto">
            <a class="nav-link" href="/websitePS/public/auth/logout"><i class="fa fa-sign-out-alt"></i>Đăng xuất</a>
        </li>
    </ul>
</div>
<div class="main-content">
    <?php
        if (isset($_SESSION['flash_message'])) {
            $flash = $_SESSION['flash_message'];
            echo '<div class="alert alert-' . $flash['type'] . ' alert-dismissible fade show" role="alert">';
            echo $flash['message'];
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            echo '</div>';
            unset($_SESSION['flash_message']);
        }
    ?>
    <?php include $contentView; // Dòng 51: Lỗi xảy ra ở đây vì giá trị của $contentView bị sai ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
