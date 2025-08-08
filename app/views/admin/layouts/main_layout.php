<?php
// Bắt đầu session nếu chưa có để có thể truy cập biến $_SESSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Parrot Smell') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- Thêm CSS tùy chỉnh của bạn ở đây nếu có -->
</head>
<body>
<header> <?php include __DIR__ . '/navbar.php'; ?> </header>
    <header>
        <!-- Thanh điều hướng (Navbar) -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="/websitePS/public/">
                    <strong>🦜 Parrot Smell</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="mainNav">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="/websitePS/public/">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Sản phẩm</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Giỏ hàng <i class="fas fa-shopping-cart"></i></a>
                        </li>
                        
                        <?php if (isset($_SESSION['customer_id'])): ?>
                            <!-- Nếu khách hàng đã đăng nhập -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user"></i> Chào, <?= htmlspecialchars($_SESSION['customer_name']) ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="#">Hồ sơ của tôi</a></li>
                                    <li><a class="dropdown-item" href="#">Lịch sử đơn hàng</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="/websitePS/public/customerauth/logout">Đăng xuất</a></li>
                                </ul>
                            </li>
                        <?php else: ?>
                            <!-- Nếu khách hàng chưa đăng nhập -->
                            <li class="nav-item">
                                <a class="nav-link" href="/websitePS/public/customerauth/login">Đăng nhập</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-primary" href="/websitePS/public/customerauth/register">Đăng ký</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <!-- Đây là nơi nội dung của các trang con sẽ được nhúng vào -->
        <?php if (isset($contentView)) { include $contentView; } ?>
        <?php include __DIR__ . '/navbar.php'; ?>
    </main>

    <footer class="bg-dark text-white text-center p-4 mt-5">
        <div class="container">
            <p class="mb-0">&copy; 2025 Parrot Smell. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>