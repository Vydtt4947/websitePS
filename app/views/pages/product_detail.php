<?php
// Hàm để lấy ảnh cho từng sản phẩm
function getProductImage($productName) {
    $productName = strtolower(trim($productName));
    
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
    <link rel="stylesheet" href="/websitePS/assets/css/style.css">
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
            background-color: var(--secondary-color);
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, #00796b 100%);
            color: white;
            padding: 6rem 0 4rem;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://images.unsplash.com/photo-1578985545062-69928b1d9587?q=80&w=1987&auto=format&fit=crop') center/cover;
            opacity: 0.1;
            z-index: 1;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .hero-badge {
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            display: inline-block;
            margin-bottom: 1rem;
            font-weight: 500;
            animation: fadeInUp 1s ease;
        }
        
        .hero-title {
            font-family: var(--heading-font);
            font-size: 3.5rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            animation: fadeInLeft 1s ease;
        }
        
        .hero-subtitle {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
            animation: fadeInLeft 1s ease 0.2s both;
        }
        
        /* Product Section */
        .product-section {
            padding: 4rem 0;
        }
        
        .product-container {
            background-color: white;
            border-radius: 25px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 3rem;
        }
        
        .product-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #00796b 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .product-header h1 {
            font-family: var(--heading-font);
            font-size: 2.5rem;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .product-content {
            padding: 3rem;
        }
        
        .product-gallery {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        /* Product Features Section - Tận dụng không gian dư */
        .product-features-section {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #fff5e6 100%);
            border-radius: 20px;
            padding: 2.5rem;
            margin-top: 2rem;
            border: 1px solid #e9ecef;
        }
        
        .features-title {
            font-family: var(--heading-font);
            color: var(--text-color);
            margin-bottom: 2rem;
            text-align: center;
            font-size: 1.8rem;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }
        
        .feature-item {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }
        
        .feature-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .feature-item i {
            color: var(--primary-color);
            font-size: 2rem;
            margin-bottom: 1rem;
            display: block;
        }
        
        .feature-item h5 {
            color: var(--text-color);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        
        .feature-item p {
            color: #6c757d;
            margin: 0;
            font-size: 0.9rem;
        }
        
        /* Purchase Section */
        .purchase-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 20px;
            padding: 2rem;
            margin-top: 2rem;
            border: 1px solid #dee2e6;
        }
        
        .quantity-section {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .quantity-control {
            display: flex;
            align-items: center;
            background: #ffffff;
            border-radius: 50px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .quantity-control:hover {
            box-shadow: 0 12px 35px rgba(0,0,0,0.15);
            border-color: var(--primary-color);
        }
        
        .quantity-btn {
            width: 50px;
            height: 50px;
            border: none;
            background: linear-gradient(145deg, #ffffff, #f0f0f0);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 1.2rem;
            font-weight: 700;
            position: relative;
            overflow: hidden;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .quantity-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: var(--primary-color);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1;
        }
        
        .quantity-btn:hover::before {
            width: 100%;
            height: 100%;
        }
        
        .quantity-btn i {
            position: relative;
            z-index: 2;
            transition: all 0.3s ease;
        }
        
        .quantity-btn:hover {
            color: white;
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0,150,136,0.3);
        }
        
        .quantity-btn:active {
            transform: scale(0.95);
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.2);
        }
        
        .quantity-input {
            width: 80px;
            text-align: center;
            border: none;
            padding: 1rem 0.5rem;
            font-size: 1.2rem;
            font-weight: 700;
            background: linear-gradient(145deg, #f8f9fa, #ffffff);
            color: var(--text-color);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .quantity-input:focus {
            outline: none;
            background: linear-gradient(145deg, #ffffff, #f0f8ff);
            box-shadow: inset 0 2px 8px rgba(0,150,136,0.1);
            color: var(--primary-color);
        }
        
        .quantity-input::-webkit-outer-spin-button,
        .quantity-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        
        .quantity-input[type=number] {
            -moz-appearance: textfield;
        }
        
        /* Purchase Section - Redesigned */
        .purchase-section {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 25px;
            padding: 2.5rem;
            margin-top: 2rem;
            border: 2px solid #e9ecef;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .purchase-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), #00796b, var(--primary-color));
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }
        
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        
        .purchase-section:hover {
            box-shadow: 0 15px 40px rgba(0,0,0,0.12);
            transform: translateY(-2px);
        }
        
        .quantity-section {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-color) 0%, #00796b 100%);
            border: none;
            color: white;
            padding: 15px 30px;
            font-weight: 600;
            transition: all 0.3s;
            border-radius: 25px;
            box-shadow: 0 5px 15px rgba(0,150,136,0.3);
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,150,136,0.4);
            color: white;
        }
        
        .add-to-cart-btn {
            width: 100%;
            padding: 18px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }
        
        .login-required-section {
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
            border: 1px solid #bee5eb;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            color: #0c5460;
            text-align: center;
        }
        
        .login-required-section i {
            font-size: 2rem;
            margin-bottom: 1rem;
            display: block;
        }
        
        .footer {
            background-color: var(--text-color);
            color: var(--secondary-color);
            padding: 3rem 0;
            margin-top: 4rem;
        }
        
        .footer a {
            color: var(--secondary-color);
            text-decoration: none;
        }
        
        .footer a:hover {
            text-decoration: underline;
        }
        
        .product-gallery img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .product-gallery:hover img {
            transform: scale(1.05);
        }
        
        .product-info h2 {
            font-family: var(--heading-font);
            color: var(--text-color);
            margin-bottom: 1.5rem;
            font-size: 2rem;
        }
        
        .product-tags {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }
        
        .product-tag {
            background: linear-gradient(135deg, var(--primary-color) 0%, #00796b 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 15px rgba(0,150,136,0.3);
            transition: all 0.3s ease;
        }
        
        .product-tag:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,150,136,0.4);
        }
        
        .product-tag.stock {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            box-shadow: 0 4px 15px rgba(40,167,69,0.3);
        }
        
        .product-price {
            font-size: 3rem;
            font-weight: 700;
            color: #dc3545;
            margin-bottom: 2rem;
            text-shadow: 2px 2px 4px rgba(220,53,69,0.2);
        }
        
        .product-meta {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid #dee2e6;
        }
        
        .meta-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #dee2e6;
        }
        
        .meta-item:last-child {
            border-bottom: none;
        }
        
        .meta-label {
            font-weight: 600;
            color: var(--text-color);
        }
        
        .meta-value {
            color: var(--primary-color);
            font-weight: 500;
        }
        
        .product-description {
            color: #6c757d;
            line-height: 1.8;
            margin-bottom: 2rem;
            font-size: 1.1rem;
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 15px;
            border-left: 4px solid var(--primary-color);
        }
        
        /* Product Features Section - Tận dụng không gian dư */
        .product-features-section {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #fff5e6 100%);
            border-radius: 20px;
            padding: 2.5rem;
            margin-top: 2rem;
            border: 1px solid #e9ecef;
        }
        
        .features-title {
            font-family: var(--heading-font);
            color: var(--text-color);
            margin-bottom: 2rem;
            text-align: center;
            font-size: 1.8rem;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }
        
        .feature-item {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }
        
        .feature-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .feature-item i {
            color: var(--primary-color);
            font-size: 2rem;
            margin-bottom: 1rem;
            display: block;
        }
        
        .feature-item h5 {
            color: var(--text-color);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        
        .feature-item p {
            color: #6c757d;
            margin: 0;
            font-size: 0.9rem;
        }
        

        
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-color) 0%, #00796b 100%);
            border: none;
            color: white;
            padding: 15px 30px;
            font-weight: 600;
            transition: all 0.3s;
            border-radius: 25px;
            box-shadow: 0 5px 15px rgba(0,150,136,0.3);
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,150,136,0.4);
            color: white;
        }
        
        .add-to-cart-btn {
            width: 100%;
            padding: 18px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }
        
        .login-required-section {
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
            border: 1px solid #bee5eb;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            color: #0c5460;
            text-align: center;
        }
        
        .login-required-section i {
            font-size: 2rem;
            margin-bottom: 1rem;
            display: block;
        }
        
        /* Related Products */
        .related-products {
            margin-top: 4rem;
        }
        
        .related-title {
            text-align: center;
            margin-bottom: 3rem;
            color: var(--text-color);
            font-family: var(--heading-font);
            font-size: 2.5rem;
        }
        
        .product-card {
            border: 1px solid #eee;
            border-radius: 20px;
            transition: all 0.3s ease;
            background-color: white;
            overflow: hidden;
            height: 100%;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .product-card:hover {
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            transform: translateY(-8px);
        }
        
        .product-card img,
        .product-card-img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .product-card:hover img,
        .product-card:hover .product-card-img {
            transform: scale(1.1);
        }
        
        .product-card-body {
            padding: 1.5rem;
        }
        
        .product-card-title {
            font-family: var(--heading-font);
            color: var(--text-color);
            margin-bottom: 0.5rem;
            font-size: 1.2rem;
        }
        
        .product-card-price {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 1.3rem;
        }
        
        /* Animations */
        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .product-content {
                padding: 2rem 1.5rem;
            }
            
            .product-gallery img {
                height: 300px;
            }
            
            .features-grid {
                grid-template-columns: 1fr;
            }
            
            .product-features-section {
                padding: 2rem 1.5rem;
            }
            
            .product-price {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body>

<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 9999;">
        <i class="fas fa-check-circle me-2"></i>
        <?= $_SESSION['success_message'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<!-- Navigation -->
<?php include __DIR__ . '/layouts/navbar.php'; ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content text-center">
            <div class="hero-badge">
                <i class="fas fa-star me-2"></i>
                Chi tiết sản phẩm
            </div>
            <h1 class="hero-title"><?= htmlspecialchars($product['TenSP']) ?></h1>
            <p class="hero-subtitle">Khám phá hương vị tuyệt vời của <?= htmlspecialchars($product['TenSP']) ?> được làm từ tâm huyết</p>
        </div>
    </div>
</section>

<!-- Product Section -->
<section class="product-section">
    <div class="container">
        <div class="product-container">
            <div class="product-header">
                <h1><?= htmlspecialchars($product['TenSP']) ?></h1>
            </div>
            
            <div class="product-content">
                <div class="row g-5">
                    <!-- Product Image -->
                    <div class="col-lg-6">
                        <div class="product-gallery">
                            <img src="<?= getProductImage($product['TenSP']) ?>" 
                                 alt="<?= htmlspecialchars($product['TenSP']) ?>">
                        </div>
                        
                        <!-- Product Features Section - Tận dụng không gian dư -->
                        <div class="product-features-section">
                            <h3 class="features-title">
                                <i class="fas fa-star me-2"></i>
                                Đặc điểm nổi bật
                            </h3>
                            <div class="features-grid">
                                <div class="feature-item">
                                    <i class="fas fa-leaf"></i>
                                    <h5>Nguyên liệu tươi</h5>
                                    <p>100% nguyên liệu tự nhiên, không chất bảo quản</p>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-clock"></i>
                                    <h5>Làm mới mỗi ngày</h5>
                                    <p>Bánh được làm tươi mỗi sáng, đảm bảo hương vị tốt nhất</p>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-award"></i>
                                    <h5>Chất lượng cao</h5>
                                    <p>Quy trình sản xuất khép kín, đạt tiêu chuẩn vệ sinh</p>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-shipping-fast"></i>
                                    <h5>Giao hàng nhanh</h5>
                                    <p>Giao hàng trong vòng 30 phút tại khu vực nội thành</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product Info -->
                    <div class="col-lg-6">
                        <div class="product-info">
                            <!-- Product Tags -->
                            <div class="product-tags">
                                <span class="product-tag">
                                    <i class="fas fa-tag"></i>
                                    <?= htmlspecialchars($product['TenDanhMuc'] ?? 'Chưa phân loại') ?>
                                </span>
                                <span class="product-tag stock">
                                    <i class="fas fa-check"></i>
                                    Còn hàng
                                </span>
                            </div>
                            
                            <!-- Product Price -->
                            <div class="product-price">
                                <?= number_format($product['DonGia'], 0, ',', '.') ?> ₫
                            </div>
                            
                            <!-- Product Meta Information -->
                            <div class="product-meta">
                                <div class="meta-item">
                                    <span class="meta-label">Mã sản phẩm:</span>
                                    <span class="meta-value"><?= $product['MaSP'] ?></span>
                                </div>
                                <div class="meta-item">
                                    <span class="meta-label">Số lượng còn lại:</span>
                                    <span class="meta-value">29 sản phẩm</span>
                                </div>
                                <div class="meta-item">
                                    <span class="meta-label">Danh mục:</span>
                                    <span class="meta-value"><?= htmlspecialchars($product['TenDanhMuc'] ?? 'Chưa phân loại') ?></span>
                                </div>
                            </div>
                            
                            <!-- Product Description -->
                            <div class="product-description">
                                <strong>Mô tả sản phẩm:</strong><br>
                                <?= htmlspecialchars($product['MoTa']) ?>
                            </div>

                            <!-- Purchase Section -->
                            <div class="purchase-section">
                                <?php if (isset($_SESSION['customer_id'])): ?>
                                    <form action="/websitePS/public/cart/add" method="POST">
                                        <input type="hidden" name="productId" value="<?= $product['MaSP'] ?>">
                                        
                                        <div class="quantity-section">
                                            <label for="quantity" class="form-label fw-bold" style="color: var(--primary-color); font-size: 1.1rem; margin-bottom: 0.5rem;">
                                                <i class="fas fa-sort-numeric-up me-2"></i>Số lượng:
                                            </label>
                                            <div class="quantity-control">
                                                <button type="button" class="quantity-btn" onclick="changeQuantity(-1)">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="number" id="quantity" name="quantity" class="quantity-input" value="1" min="1">
                                                <button type="button" class="quantity-btn" onclick="changeQuantity(1)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary-custom add-to-cart-btn">
                                            <i class="fas fa-shopping-cart me-2"></i>
                                            Thêm vào giỏ hàng
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <div class="login-required-section">
                                        <i class="fas fa-info-circle"></i>
                                        <strong>Vui lòng đăng nhập để mua hàng</strong>
                                        <p class="mt-2 mb-0">Đăng nhập để có thể thêm sản phẩm vào giỏ hàng và đặt hàng</p>
                                    </div>
                                    <a href="/websitePS/public/customerauth/login" class="btn btn-primary-custom w-100">
                                        <i class="fas fa-sign-in-alt me-2"></i>
                                        Đăng nhập ngay
                                    </a>
                                    <div class="text-center mt-3">
                                        <small class="text-muted">Chưa có tài khoản? 
                                            <a href="/websitePS/public/customerauth/register" class="text-decoration-none">Đăng ký miễn phí</a>
                                        </small>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Related Products Section -->
        <div class="related-products">
            <h2 class="related-title">
                <i class="fas fa-heart me-2"></i>
                Sản phẩm liên quan
            </h2>
            <div class="row g-4">
                <?php if (!empty($relatedProducts)): ?>
                    <?php foreach ($relatedProducts as $relatedProduct): ?>
                        <div class="col-md-4">
                            <a href="/websitePS/public/products/show/<?= $relatedProduct['MaSP'] ?>" class="text-decoration-none">
                                <div class="product-card">
                                    <img src="<?= getProductImage($relatedProduct['TenSP']) ?>" 
                                         alt="<?= htmlspecialchars($relatedProduct['TenSP']) ?>" 
                                         class="product-card-img">
                                    <div class="product-card-body">
                                        <h5 class="product-card-title"><?= htmlspecialchars($relatedProduct['TenSP']) ?></h5>
                                        <p class="text-muted"><?= htmlspecialchars($relatedProduct['TenDanhMuc'] ?? 'Chưa phân loại') ?></p>
                                        <div class="product-card-price"><?= number_format($relatedProduct['DonGia'], 0, ',', '.') ?> ₫</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Fallback products if no related products found -->
                    <div class="col-md-4">
                        <a href="/websitePS/public/products/show/1" class="text-decoration-none">
                            <div class="product-card">
                                <img src="<?= getProductImage('Bánh Tiramisu') ?>" alt="Bánh Tiramisu" class="product-card-img">
                                <div class="product-card-body">
                                    <h5 class="product-card-title">Bánh Tiramisu</h5>
                                    <p class="text-muted">Bánh ngọt</p>
                                    <div class="product-card-price">120,000 ₫</div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="/websitePS/public/products/show/2" class="text-decoration-none">
                            <div class="product-card">
                                <img src="<?= getProductImage('Bánh Mì Sourdough') ?>" alt="Bánh Mì Sourdough" class="product-card-img">
                                <div class="product-card-body">
                                    <h5 class="product-card-title">Bánh Mì Sourdough</h5>
                                    <p class="text-muted">Bánh mì</p>
                                    <div class="product-card-price">85,000 ₫</div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="/websitePS/public/products/show/3" class="text-decoration-none">
                            <div class="product-card">
                                <img src="<?= getProductImage('Bánh Chocolate Cake') ?>" alt="Bánh Chocolate Cake" class="product-card-img">
                                <div class="product-card-body">
                                    <h5 class="product-card-title">Bánh Chocolate Cake</h5>
                                    <p class="text-muted">Bánh kem</p>
                                    <div class="product-card-price">180,000 ₫</div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
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
<script>
function changeQuantity(change) {
    const input = document.getElementById('quantity');
    const newValue = parseInt(input.value) + change;
    if (newValue >= 1) {
        input.value = newValue;
    }
}

// Prevent manual input of negative numbers
document.getElementById('quantity').addEventListener('input', function() {
    if (this.value < 1) {
        this.value = 1;
    }
});
</script>
</body>
</html>
