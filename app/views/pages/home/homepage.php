<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiệm bánh Parrot Smell - Bánh tươi mỗi ngày</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #009688;
            --secondary-color: #fdf5e6;
            --text-color: #5d4037;
            --heading-font: 'Playfair Display', serif;
            --body-font: 'Roboto', sans-serif;
        }
        body {
            font-family: var(--body-font);
            color: var(--text-color);
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            background-color: #fff;
        }
        .navbar-brand {
            font-family: var(--heading-font);
            font-weight: 700;
            color: var(--primary-color) !important;
        }
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('https://images.unsplash.com/photo-1588195538326-c5b1e9f80a1b?q=80&w=1950&auto=format&fit=crop') no-repeat center center;
            background-size: cover;
            height: 80vh;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .hero-section h1 {
            font-family: var(--heading-font);
            font-size: 4rem;
        }
        .btn-primary-custom {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            padding: 12px 30px;
            font-weight: 500;
            transition: all 0.3s;
        }
        .btn-primary-custom:hover {
            background-color: #00796b;
            border-color: #00796b;
            transform: translateY(-2px);
        }
        .section-title {
            font-family: var(--heading-font);
            color: var(--text-color);
            margin-bottom: 40px;
        }
        .product-card {
            border: 1px solid #eee;
            transition: all 0.3s;
        }
        .product-card:hover {
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transform: translateY(-5px);
        }
        .footer {
            background-color: var(--text-color);
            color: var(--secondary-color);
        }
        .footer a {
            color: var(--secondary-color);
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fs-3" href="/websitePS/public/" style="font-family: 'Playfair Display', serif; color: #009688 !important;">🦜 Parrot Smell</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link active" href="/websitePS/public/">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="/websitePS/public/products/list">Sản phẩm</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Khuyến mãi</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Về chúng tôi</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Liên hệ</a></li>
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
                            <li><a class="dropdown-item" href="#">Tài khoản của tôi</a></li>
                            <li><a class="dropdown-item" href="#">Lịch sử đơn hàng</a></li>
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

<section class="hero-section">
    <div class="container">
        <h1 class="display-3">Ngọt ngào từng khoảnh khắc</h1>
        <p class="lead mb-4">Khám phá thế giới bánh tươi ngon được làm từ tâm huyết mỗi ngày.</p>
        <a href="#" class="btn btn-primary-custom rounded-pill">Khám Phá Thực Đơn</a>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h2 class="text-center section-title">Sản phẩm nổi bật</h2>
        <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php 
                    $productChunks = array_chunk($products, 3); 
                ?>
                <?php foreach ($productChunks as $index => $chunk): ?>
                    <div class="carousel-item <?= ($index == 0) ? 'active' : '' ?>">
                        <div class="row">
                            <?php foreach ($chunk as $product): ?>
                                <div class="col-md-4 mb-4 d-flex">
                                    <a href="/websitePS/public/products/show/<?= $product['MaSP'] ?>" class="text-decoration-none text-dark w-100">
                                        <div class="card product-card h-100 w-100">
                                            <img src="https://images.unsplash.com/photo-1578985545062-69928b1d9587?q=80&w=1987&auto=format&fit=crop" class="card-img-top" alt="<?= htmlspecialchars($product['TenSP']) ?>">
                                            <div class="card-body d-flex flex-column">
                                                <h5 class="card-title"><?= htmlspecialchars($product['TenSP']) ?></h5>
                                                <p class="card-text text-muted small"><?= htmlspecialchars($product['TenDanhMuc']) ?></p>
                                                <h6 class="text-danger mt-auto"><?= number_format($product['DonGia'], 0, ',', '.') ?> đ</h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        </div>
    </div>
</section>

<footer class="footer pt-5 pb-4">
    <div class="container text-center text-md-start">
        <div class="row">
            <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mb-4">
                <h6 class="text-uppercase fw-bold">🦜 Parrot Smell Bakery</h6>
                <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: var(--primary-color); height: 2px"/>
                <p>Nơi mỗi chiếc bánh là một tác phẩm nghệ thuật, mang đến niềm vui và sự ngọt ngào cho cuộc sống của bạn.</p>
            </div>
            <div class="col-md-4 col-lg-2 col-xl-2 mx-auto mb-4">
                <h6 class="text-uppercase fw-bold">Liên kết</h6>
                <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: var(--primary-color); height: 2px"/>
                <p><a href="#!">Về chúng tôi</a></p>
                <p><a href="#!">Chính sách giao hàng</a></p>
                <p><a href="#!">Điều khoản dịch vụ</a></p>
            </div>
            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                <h6 class="text-uppercase fw-bold">Liên hệ</h6>
                <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: var(--primary-color); height: 2px"/>
                <p><i class="fas fa-home me-3"></i> 123 Đường Bánh Ngọt, TP.HCM</p>
                <p><i class="fas fa-envelope me-3"></i> contact@parrotsmell.com</p>
                <p><i class="fas fa-phone me-3"></i> 0123 456 789</p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>