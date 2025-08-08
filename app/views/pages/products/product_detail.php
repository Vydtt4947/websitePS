<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['TenSP']) ?> - Parrot Smell</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #009688;
            --text-color: #5d4037;
            --heading-font: 'Playfair Display', serif;
            --body-font: 'Roboto', sans-serif;
        }
        body { 
            font-family: var(--body-font);
            background-color: #f8f9fa; 
        }
        .navbar-brand {
            font-family: var(--heading-font);
            color: var(--primary-color) !important;
        }
        .product-gallery img {
            border-radius: 0.5rem;
        }
        .btn-primary-custom {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            padding: 12px 30px;
            font-weight: 500;
            transition: background-color 0.3s;
        }
        .btn-primary-custom:hover {
            background-color: #00796b;
            border-color: #00796b;
        }
        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
        }
        .footer {
            background-color: var(--text-color);
            color: #fdf5e6;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fs-3" href="/websitePS/public/">🦜 Parrot Smell</a>
    </div>
</nav>

<div class="container my-5">
    <div class="card p-4 shadow-sm">
        <div class="row g-5">
            <div class="col-lg-6 product-gallery">
                <img src="https://images.unsplash.com/photo-1588195538326-c5b1e9f80a1b?q=80&w=1950&auto=format&fit=crop" class="img-fluid w-100" alt="<?= htmlspecialchars($product['TenSP']) ?>">
            </div>
            <div class="col-lg-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/websitePS/public/">Trang chủ</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($product['TenSP']) ?></li>
                    </ol>
                </nav>
                
                <h1 class="display-5" style="font-family: var(--heading-font);"><?= htmlspecialchars($product['TenSP']) ?></h1>
                <p class="lead text-muted"><?= htmlspecialchars($product['MoTa']) ?></p>
                <h2 class="text-danger my-4"><?= number_format($product['DonGia'], 0, ',', '.') ?> đ</h2>

                <form action="/websitePS/public/cart/add" method="POST">
                    <input type="hidden" name="productId" value="<?= $product['MaSP'] ?>">
                    <div class="d-flex align-items-center mb-4">
                        <label for="quantity" class="form-label me-3 mb-0">Số lượng:</label>
                        <input type="number" id="quantity" name="quantity" class="form-control" value="1" min="1" style="width: 80px;">
                    </div>

                    <button type="submit" class="btn btn-primary-custom btn-lg w-100">
                        <i class="fa fa-shopping-cart me-2"></i> Thêm vào giỏ hàng
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<footer class="footer pt-5 pb-4">
    <div class="container text-center">
        <p>&copy; 2025 Parrot Smell Bakery. All Rights Reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
