<?php
// Xác định trang hiện tại dựa trên URL
$current_page = '';
$request_uri = $_SERVER['REQUEST_URI'];

// Kiểm tra các trang cụ thể
if (strpos($request_uri, '/products/show/') !== false || strpos($request_uri, '/products/list') !== false) {
    $current_page = 'products';
} elseif (strpos($request_uri, '/promotion/tierBenefits') !== false) {
    $current_page = 'tier_benefits';
} elseif (strpos($request_uri, '/promotion') !== false) {
    $current_page = 'promotion';
} elseif (strpos($request_uri, '/about') !== false) {
    $current_page = 'about';
} elseif (strpos($request_uri, '/contact') !== false) {
    $current_page = 'contact';
} elseif (strpos($request_uri, '/cart') !== false) {
    $current_page = 'cart';
} elseif (strpos($request_uri, '/checkout') !== false) {
    $current_page = 'checkout';
} elseif (strpos($request_uri, '/account') !== false || strpos($request_uri, '/customerorders') !== false) {
    $current_page = 'account';
} elseif ($request_uri == '/websitePS/public/' || $request_uri == '/websitePS/public/index.php' || $request_uri == '/websitePS/public') {
    $current_page = 'home';
}
?>

<nav class="navbar navbar-expand-lg sticky-top bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fs-3" href="/websitePS/public/" style="font-family: 'Playfair Display', serif; color: #009688 !important;">🦜 Parrot Smell</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link <?= $current_page == 'home' ? 'active' : '' ?>" href="/websitePS/public/">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link <?= $current_page == 'products' ? 'active' : '' ?>" href="/websitePS/public/products/list">Sản phẩm</a></li>
                <li class="nav-item"><a class="nav-link <?= $current_page == 'promotion' ? 'active' : '' ?>" href="/websitePS/public/promotion">Khuyến mãi</a></li>
                <li class="nav-item"><a class="nav-link <?= $current_page == 'about' ? 'active' : '' ?>" href="/websitePS/public/about">Về chúng tôi</a></li>
                <li class="nav-item"><a class="nav-link <?= $current_page == 'contact' ? 'active' : '' ?>" href="/websitePS/public/contact">Liên hệ</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <?php
                    $cartItemCount = 0;
                    if (isset($_SESSION['customer_id'])) {
                        try {
                            // Lấy số lượng giỏ hàng từ database cho khách hàng đã đăng nhập
                            require_once __DIR__ . '/../../../models/CartModel.php';
                            $cartModel = new CartModel();
                            $cart = $cartModel->getCart($_SESSION['customer_id']);
                            if (!empty($cart)) {
                                foreach ($cart as $item) { 
                                    $cartItemCount += $item['quantity']; 
                                }
                            }
                        } catch (Exception $e) {
                            // Nếu có lỗi, đặt cartItemCount = 0
                            $cartItemCount = 0;
                        }
                    } else {
                        // Lấy số lượng giỏ hàng từ session cho khách vãng lai
                        if (isset($_SESSION['guest_cart']) && !empty($_SESSION['guest_cart'])) {
                            foreach ($_SESSION['guest_cart'] as $item) { 
                                $cartItemCount += $item['quantity']; 
                            }
                        }
                    }
                ?>
                <a href="/websitePS/public/cart" class="btn btn-outline-light text-dark me-2 position-relative">
                    <i class="fa fa-shopping-cart"></i>
                    <?php if ($cartItemCount > 0): ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?= $cartItemCount ?>
                        </span>
                    <?php endif; ?>
                </a>
                
                <?php if (isset($_SESSION['customer_id'])): ?>
                    <div class="dropdown">
                        <a href="#" class="btn btn-outline-light text-dark dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-user"></i> Chào, <?= htmlspecialchars(explode(' ', trim($_SESSION['customer_name']))[0]) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/websitePS/public/account"><i class="fas fa-user me-2"></i>Tài khoản của tôi</a></li>
                            <li><a class="dropdown-item" href="/websitePS/public/account"><i class="fas fa-history me-2"></i>Lịch sử đơn hàng</a></li>
                            <li><a class="dropdown-item" href="/websitePS/public/promotion/tierBenefits"><i class="fas fa-crown me-2"></i>Ưu đãi phân khúc</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/websitePS/public/customerauth/logout"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="/websitePS/public/customerauth/login" class="btn btn-outline-light text-dark">
                        <i class="fa fa-user"></i> Đăng nhập
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>