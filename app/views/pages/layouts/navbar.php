<nav class="navbar navbar-expand-lg sticky-top bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fs-3" href="/websitePS/public/" style="font-family: 'Playfair Display', serif; color: #009688 !important;">🦜 Parrot Smell</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link" href="/websitePS/public/">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="/websitePS/public/products/list">Sản phẩm</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Khuyến mãi</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <?php
                    $cartItemCount = 0;
                    if (!empty($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $item) { $cartItemCount += $item['quantity']; }
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
                            <li><a class="dropdown-item" href="/websitePS/public/account">Tài khoản của tôi</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/websitePS/public/customerauth/logout">Đăng xuất</a></li>
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