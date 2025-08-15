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
            height: 100%;
        }
        .product-card:hover {
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transform: translateY(-5px);
        }
        .product-card .card-img-top {
            height: 200px;
            object-fit: cover;
            width: 100%;
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

<?php
// Hàm để lấy ảnh cho từng sản phẩm
function getProductImage($product) {
    // Nếu $product là string (tên sản phẩm), chuyển đổi thành array
    if (is_string($product)) {
        $productName = $product;
        $product = ['TenSP' => $productName, 'HinhAnh' => null];
    }
    
    // Ưu tiên sử dụng hình ảnh từ database
    if (!empty($product['HinhAnh'])) {
        return $product['HinhAnh'];
    }
    
    // Fallback: sử dụng tên sản phẩm để tìm hình ảnh mặc định
    $productName = strtolower(trim($product['TenSP']));
    
    // Map ảnh cho từng sản phẩm cụ thể
    $imageMap = [
        'tiramisu' => 'https://images.unsplash.com/photo-1714385905983-6f8e06fffae1?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'sourdough' => 'https://plus.unsplash.com/premium_photo-1664640733898-d5c3f71f44e1?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'chocolate cake' => 'https://images.unsplash.com/photo-1606890737304-57a1ca8a5b62?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8Y2hvY29sYXRlJTIwY2FrZXxlbnwwfHwwfHx8MA%3D%3D',
        'croissant' => 'https://images.unsplash.com/photo-1600521853186-93b88b3a07b0?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTR8fGNyb2lzc2FudHxlbnwwfHwwfHx8MA%3D%3D'
    ];
    
    // Tìm ảnh phù hợp
    foreach ($imageMap as $keyword => $imageUrl) {
        if (strpos($productName, $keyword) !== false) {
            return $imageUrl;
        }
    }
    
    // Ảnh mặc định nếu không tìm thấy
    return 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?q=80&w=1987&auto=format&fit=crop';
}
?>

<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 9999;">
        <i class="fas fa-check-circle me-2"></i>
        <?= $_SESSION['success_message'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<?php include __DIR__ . '/layouts/navbar.php'; ?>

<section class="hero-section">
    <div class="container">
        <h1 class="display-3">Ngọt ngào từng khoảnh khắc</h1>
        <p class="lead mb-4">Khám phá thế giới bánh tươi ngon được làm từ tâm huyết mỗi ngày.</p>
        <a href="/websitePS/public/products/list" class="btn btn-primary-custom rounded-pill">Thưởng Thức Ngay</a>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <!-- Success Message -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?= $_SESSION['success_message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>
        
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
                                            <img src="<?= getProductImage($product) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['TenSP']) ?>">
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
                <h6 class="text-uppercase fw-bold">🦜 Parrot Smell</h6>
                <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: var(--primary-color); height: 2px"/>
                <p>Nơi mỗi chiếc bánh là một tác phẩm nghệ thuật, mang đến niềm vui và sự ngọt ngào cho cuộc sống của bạn.</p>
            </div>
            <div class="col-md-4 col-lg-2 col-xl-2 mx-auto mb-4">
                <h6 class="text-uppercase fw-bold">Liên kết</h6>
                <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: var(--primary-color); height: 2px"/>
                <p><a href="/websitePS/public/pages/about">Về chúng tôi</a></p>
                <p><a href="#!">Chính sách giao hàng</a></p>
                <p><a href="#!">Điều khoản dịch vụ</a></p>
            </div>
            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                <h6 class="text-uppercase fw-bold">Liên hệ</h6>
                <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: var(--primary-color); height: 2px"/>
                <p><i class="fas fa-home me-3"></i> 02 Võ Oanh, Phường 25, Quận Bình Thạnh, TP.HCM</p>
                <p><i class="fas fa-envelope me-3"></i> cucxacdufong@gmail.com</p>
                <p><i class="fas fa-phone me-3"></i> 0767 150 474</p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>