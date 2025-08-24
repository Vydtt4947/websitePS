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
            --secondary-color: #fdf5e6;
            --text-color: #5d4037;
            --heading-font: 'Playfair Display', serif;
            --body-font: 'Roboto', sans-serif;
        }
        
        /* Navbar styles to match homepage */
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            background-color: #fff;
        }
        
        .navbar-brand {
            font-family: var(--heading-font);
            font-weight: 700;
            color: var(--primary-color) !important;
        }
        
        /* Product detail page specific styles */
        body {
            font-family: var(--body-font);
            color: var(--text-color);
            background-color: var(--secondary-color);
        }
        
        /* Responsive Design for Product Detail Page */
        @media (max-width: 768px) {
            .hero-section {
                padding: 4rem 0;
                min-height: auto;
                overflow: hidden;
            }
            
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
            
            .product-content {
                padding: 2rem 1.5rem;
                margin: 0 15px;
            }
            
            .product-gallery img {
                height: 300px;
                max-width: 100%;
            }
            
            .product-features-section {
                padding: 2rem 1.5rem;
                margin: 0 15px;
            }
            
            .product-price {
                font-size: 2.5rem;
            }
            
            .purchase-section {
                padding: 2rem 1.5rem;
                margin: 0 15px;
            }
            
            .quantity-control {
                width: 100%;
                max-width: 200px;
            }
            
            .product-meta {
                margin: 0 15px 2rem;
            }
            
            .product-description {
                margin: 0 15px 2rem;
            }
            
            .reviews-section {
                margin: 0 15px;
            }
            
            .related-products {
                margin: 0 15px;
            }
            
            .rating-filter {
                margin-top: 1rem;
            }
            
            .rating-filter .btn-group {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .filter-btn {
                margin: 2px;
                border-radius: 20px !important;
            }
            
            .toast-notification {
                min-width: 280px;
                max-width: 320px;
                right: 10px;
                top: 10px;
            }
        }
        
        @media (max-width: 480px) {
            .hero-section {
                padding: 3rem 0;
            }
            
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-subtitle {
                font-size: 0.9rem;
            }
            
            .product-content {
                padding: 1.5rem 1rem;
                margin: 0 10px;
            }
            
            .product-gallery img {
                height: 250px;
            }
            
            .product-features-section {
                padding: 1.5rem 1rem;
                margin: 0 10px;
            }
            
            .purchase-section {
                padding: 1.5rem 1rem;
                margin: 0 10px;
            }
            
            .product-price {
                font-size: 2rem;
            }
            
            .quantity-control {
                max-width: 180px;
            }
            
            .quantity-btn {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
            
            .quantity-input {
                width: 60px;
                font-size: 1rem;
            }
            
            .product-meta {
                margin: 0 10px 1.5rem;
                padding: 1.5rem;
            }
            
            .product-description {
                margin: 0 10px 1.5rem;
                padding: 1rem;
                font-size: 1rem;
            }
            
            .reviews-section {
                margin: 0 10px;
            }
            
            .related-products {
                margin: 0 10px;
            }
            
            .rating-filter .btn-group {
                flex-direction: column;
                width: 100%;
            }
            
            .filter-btn {
                border-radius: 20px !important;
                margin: 2px 0;
            }
        }
        
        /* Product detail page specific styles */
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
        
        .quantity-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            background: linear-gradient(145deg, #f0f0f0, #e0e0e0);
            color: #999;
            transform: none !important;
            box-shadow: none;
        }
        
        .quantity-btn:disabled:hover {
            transform: none;
            box-shadow: none;
            color: #999;
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
        
        .product-tag.out-of-stock {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            box-shadow: 0 4px 15px rgba(220,53,69,0.3);
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
        
        /* Stock refresh button styling */
        .meta-item .btn-outline-primary {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
            border-radius: 20px;
            transition: all 0.3s ease;
        }
        
        .meta-item .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transform: scale(1.05);
        }
        
        .meta-item .btn-outline-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
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
        
        /* Review Section Styles */
        .reviews-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        }
        
        .review-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .review-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
        }
        
        .rating-input {
            display: flex;
            flex-direction: row-reverse;
            gap: 0.25rem;
        }
        
        .rating-input input[type="radio"] {
            display: none;
        }
        
        .rating-star {
            cursor: pointer;
            font-size: 1.5rem;
            color: #ddd;
            transition: color 0.2s ease;
        }
        
        .rating-star:hover,
        .rating-star:hover ~ .rating-star,
        .rating-input input[type="radio"]:checked ~ .rating-star {
            color: #ffc107;
        }
        
        .rating-stars {
            font-size: 1rem;
        }
        
        .rating-stars .fa-star {
            transition: color 0.2s ease;
        }
        
        .user-avatar {
            background: linear-gradient(135deg, var(--primary-color), #00796b);
        }
        
        .review-form-section .card {
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .review-form-section .card-header {
            background: linear-gradient(135deg, var(--primary-color), #00796b) !important;
            border: none;
        }
        
        /* Rating Filter Styles */
        .rating-filter {
            display: flex;
            align-items: center;
        }
        
        .rating-filter .btn-group {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 25px;
            overflow: hidden;
        }
        
        .filter-btn {
            border: none;
            padding: 8px 16px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
            border-radius: 0 !important;
        }
        
        .filter-btn:first-child {
            border-radius: 25px 0 0 25px !important;
        }
        
        .filter-btn:last-child {
            border-radius: 0 25px 25px 0 !important;
        }
        
        .filter-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .filter-btn.active {
            background: linear-gradient(135deg, var(--primary-color), #00796b);
            color: white;
            border-color: var(--primary-color);
        }
        
        .filter-btn.active:hover {
            background: linear-gradient(135deg, #00796b, var(--primary-color));
        }
        
        /* Review Item Animation */
        .review-item {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            animation: fadeInUp 0.5s ease forwards;
            animation-delay: 0s;
        }
        
        .review-item.hidden {
            opacity: 0;
            transform: scale(0.8) translateY(20px);
            pointer-events: none;
            position: absolute;
            left: -9999px;
        }
        
        .review-item.visible {
            opacity: 1;
            transform: scale(1) translateY(0);
            position: relative;
            left: auto;
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
        
                 /* Toast Notification Styles */
         .toast-notification {
             position: fixed;
             top: 20px;
             right: 20px;
             z-index: 9999;
             min-width: 300px;
             max-width: 400px;
             background: white;
             border-radius: 10px;
             box-shadow: 0 10px 30px rgba(0,0,0,0.2);
             border-left: 4px solid var(--primary-color);
             transform: translateX(100%);
             transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
             overflow: hidden;
         }
         
         .toast-notification.show {
             transform: translateX(0);
         }
         
         .toast-notification.success {
             border-left-color: #28a745;
         }
         
         .toast-notification.error {
             border-left-color: #dc3545;
         }
         
         .toast-header {
             padding: 15px 20px 10px;
             display: flex;
             align-items: center;
             gap: 10px;
         }
         
         .toast-icon {
             width: 24px;
             height: 24px;
             border-radius: 50%;
             display: flex;
             align-items: center;
             justify-content: center;
             color: white;
             font-size: 12px;
         }
         
         .toast-icon.success {
             background: #28a745;
         }
         
         .toast-icon.error {
             background: #dc3545;
         }
         
         .toast-title {
             font-weight: 600;
             color: var(--text-color);
             margin: 0;
             font-size: 14px;
         }
         
         .toast-body {
             padding: 0 20px 15px;
             color: #6c757d;
             font-size: 13px;
             line-height: 1.4;
         }
         
         .toast-close {
             position: absolute;
             top: 10px;
             right: 15px;
             background: none;
             border: none;
             color: #6c757d;
             cursor: pointer;
             font-size: 16px;
             padding: 0;
             width: 20px;
             height: 20px;
             display: flex;
             align-items: center;
             justify-content: center;
             border-radius: 50%;
             transition: all 0.2s ease;
         }
         
         .toast-close:hover {
             background: #f8f9fa;
             color: var(--text-color);
         }
         
         /* Loading Button Styles */
         .add-to-cart-btn:disabled {
             opacity: 0.7;
             cursor: not-allowed;
         }
         
         
         
         /* Responsive Filter */
         @media (max-width: 768px) {
             .rating-filter {
                 margin-top: 1rem;
             }
             
             .rating-filter .btn-group {
                 flex-wrap: wrap;
                 justify-content: center;
             }
             
             .filter-btn {
                 margin: 2px;
                 border-radius: 20px !important;
             }
             
             .toast-notification {
                 min-width: 280px;
                 max-width: 320px;
                 right: 10px;
                 top: 10px;
             }
             
             
         }
    /* === COMPACT TWEAKS (Giảm kích thước tổng thể) === */
    .hero-section { padding: 3rem 0 2rem !important; }
    .hero-title { font-size: clamp(1.9rem, 4.8vw, 2.6rem) !important; }
    .hero-subtitle { font-size: 1rem !important; margin-bottom: 1.25rem !important; }

    .product-content { padding: 2.25rem 2rem !important; }
    @media (max-width: 992px) { .product-content { padding: 1.75rem 1.25rem !important; } }
    @media (max-width: 576px) { .product-content { padding: 1.25rem .9rem !important; } }

    .product-gallery img { height: auto !important; max-height: 360px; aspect-ratio: 4/3; }
    @media (min-width: 1200px) { .product-gallery img { max-height: 380px; } }

    .product-tag { padding: .55rem 1.1rem !important; font-size: .8rem !important; border-radius: 18px !important; }
    .product-tags { gap: .5rem !important; margin-bottom: 1.25rem !important; }

    .product-price { font-size: clamp(1.9rem, 3.2vw, 2.4rem) !important; margin-bottom: 1.25rem !important; text-shadow: none !important; }

    .product-meta { padding: 1.5rem 1.5rem !important; border-radius: 18px !important; }
    .meta-item { padding: .55rem 0 !important; }

    .product-description { font-size: 1rem !important; padding: 1.1rem 1.25rem !important; margin-bottom: 1.5rem !important; }

    .purchase-section { padding: 1.75rem 1.5rem !important; border-radius: 20px !important; }
    .quantity-section { gap: .75rem !important; margin-bottom: 1.25rem !important; }
    .quantity-btn { width: 42px !important; height: 42px !important; font-size: 1rem !important; }
    .quantity-input { width: 70px !important; font-size: 1.05rem !important; padding: .8rem .4rem !important; }
    .add-to-cart-btn { padding: 14px !important; font-size: 1.05rem !important; }

    .feature-item { padding: 1.1rem 1rem !important; }
    .features-title { font-size: 1.5rem !important; margin-bottom: 1.25rem !important; }

    .related-title { font-size: 2rem !important; margin-bottom: 2rem !important; }
    .product-card-title { font-size: 1.05rem !important; }
    .product-card-price { font-size: 1.1rem !important; }
    .product-card img { height: 190px !important; }

    .reviews-section .section-title { font-size: 2rem !important; margin-bottom: 2rem !important; }
    #reviews-container .review-item .card-body { padding: 1rem 1rem 1.1rem !important; }

    /* Giảm bán kính tổng thể để cảm giác gọn hơn */
    .product-container { border-radius: 22px !important; }

    /* Mobile further tightening */
    @media (max-width: 480px) {
        .hero-section { padding: 2.5rem 0 1.5rem !important; }
        .hero-title { font-size: 2.1rem !important; }
        .product-price { font-size: 2rem !important; }
        .product-gallery img { max-height: 300px; }
    }
    /* === EXTRA COMPACT (giảm thêm ~10%) === */
    .product-section > .container,
    .reviews-section > .container,
    .hero-section > .container { max-width: 1100px !important; }
    .hero-section { padding: 2.7rem 0 1.6rem !important; }
    .hero-title { font-size: clamp(1.7rem, 4.2vw, 2.35rem) !important; }
    .hero-subtitle { font-size: .92rem !important; }
    .product-content { padding: 2rem 1.7rem !important; }
    @media (max-width: 992px){ .product-content { padding:1.5rem 1.1rem !important; } }
    .product-gallery img { max-height: 340px !important; }
    .product-tags { gap: .4rem !important; margin-bottom: 1rem !important; }
    .product-tag { padding:.48rem .95rem !important; font-size:.74rem !important; }
    .product-price { font-size: clamp(1.7rem, 2.9vw, 2.15rem) !important; margin-bottom:1rem !important; }
    .product-meta { padding:1.35rem 1.25rem !important; }
    .product-description { font-size:.92rem !important; padding: .95rem 1rem !important; }
    .purchase-section { padding:1.55rem 1.35rem !important; }
    .quantity-btn { width:38px !important; height:38px !important; }
    .quantity-input { width:64px !important; font-size:.95rem !important; }
    .add-to-cart-btn { padding:12px !important; font-size:.95rem !important; }
    .features-title { font-size:1.35rem !important; }
    .feature-item { padding:.9rem .85rem !important; }
    .related-title { font-size:1.8rem !important; }
    .product-card img { height:175px !important; }
    .product-card-title { font-size:.95rem !important; }
    .product-card-price { font-size:1rem !important; }
    .reviews-section .section-title { font-size:1.8rem !important; }
    #reviews-container .review-item .card-body { padding:.85rem .85rem .9rem !important; }
    .footer { padding:2.2rem 0 !important; }
    /* Mobile tighten */
    @media (max-width:480px){
      .hero-title { font-size:1.9rem !important; }
      .product-gallery img { max-height:280px !important; }
      .product-price { font-size:1.9rem !important; }
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
                            <img src="<?= getProductImage($product) ?>" 
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
                                <?php if (($product['SoLuong'] ?? 0) > 0): ?>
                                    <span class="product-tag stock">
                                        <i class="fas fa-check"></i>
                                        Còn hàng
                                    </span>
                                <?php else: ?>
                                    <span class="product-tag out-of-stock">
                                        <i class="fas fa-times"></i>
                                        Hết hàng
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                                                         <!-- Product Price -->
                             <?php if (($product['SoLuong'] ?? 0) > 0): ?>
                                 <div class="product-price">
                                     <?= number_format($product['DonGia'], 0, ',', '.') ?> ₫
                                 </div>
                             <?php else: ?>
                                 <div class="product-price text-muted">
                                     <i class="fas fa-info-circle me-2"></i>Liên hệ để biết giá
                                 </div>
                             <?php endif; ?>
                            
                            <!-- Product Meta Information -->
                            <div class="product-meta">
                                <div class="meta-item">
                                    <span class="meta-label">Mã sản phẩm:</span>
                                    <span class="meta-value"><?= $product['MaSP'] ?></span>
                                </div>
                                <div class="meta-item">
                                    <span class="meta-label">Số lượng còn lại:</span>
                                    <span class="meta-value" id="stockQuantity">
                                        <?php if (($product['SoLuong'] ?? 0) > 0): ?>
                                            <?= $product['SoLuong'] ?> sản phẩm
                                        <?php else: ?>
                                            <span class="text-danger fw-bold">Hết hàng</span>
                                        <?php endif; ?>
                                    </span>
                                    <button type="button" class="btn btn-sm btn-outline-primary ms-2" onclick="refreshStockQuantity()" title="Làm mới số lượng">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
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
                                <?php if (($product['SoLuong'] ?? 0) <= 0): ?>
                                    <div class="alert alert-warning mt-3 mb-0">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        <strong>Sản phẩm hiện tại hết hàng!</strong> 
                                        Bạn có thể liên hệ với chúng tôi để đặt hàng trước hoặc chờ sản phẩm có hàng trở lại.
                                    </div>
                                <?php endif; ?>
                            </div>

                             <!-- Purchase Section -->
                             <?php if (($product['SoLuong'] ?? 0) > 0): ?>
                                 <div class="purchase-section">
                                     <form id="addToCartForm" onsubmit="addToCart(event)">
                                         <input type="hidden" name="productId" value="<?= $product['MaSP'] ?>">
                                         
                                         <div class="quantity-section">
                                             <label for="quantity" class="form-label fw-bold" style="color: var(--primary-color); font-size: 1.1rem; margin-bottom: 0.5rem;">
                                                 <i class="fas fa-sort-numeric-up me-2"></i>Số lượng:
                                             </label>
                                             <div class="quantity-control">
                                                 <button type="button" class="quantity-btn" onclick="changeQuantity(-1)" title="Giảm số lượng">
                                                     <i class="fas fa-minus"></i>
                                                 </button>
                                                 <input type="number" id="quantity" name="quantity" class="quantity-input" value="1" min="1" max="<?= $product['SoLuong'] ?>" title="Nhập số lượng">
                                                 <button type="button" class="quantity-btn" onclick="changeQuantity(1)" title="Tăng số lượng">
                                                     <i class="fas fa-plus"></i>
                                                 </button>
                                             </div>
                                             <small class="text-muted mt-2 d-block">
                                                 <i class="fas fa-info-circle me-1"></i>
                                                 Số lượng tối thiểu: 1, tối đa: <?= $product['SoLuong'] ?>
                                             </small>
                                         </div>

                                         <button type="submit" class="btn btn-primary-custom add-to-cart-btn" id="addToCartBtn">
                                             <i class="fas fa-shopping-cart me-2"></i>
                                             <span id="addToCartText">Thêm vào giỏ hàng</span>
                                             <span id="addToCartLoading" style="display: none;">
                                                 <i class="fas fa-spinner fa-spin me-2"></i>Đang thêm...
                                             </span>
                                         </button>
                                     </form>
                                    
                                    <?php if (!isset($_SESSION['customer_id'])): ?>
                                        <div class="text-center mt-3">
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Bạn đang mua hàng với tư cách khách vãng lai. 
                                                <a href="/websitePS/public/customerauth/login" class="text-decoration-none">Đăng nhập</a> 
                                                để có thêm nhiều lợi ích và ưu đãi khuyến mãi! 
                                                Sau khi đặt hàng, bạn có thể tra cứu tại 
                                                <a href="/websitePS/public/ordertracking" class="text-decoration-none">trang tra cứu đơn hàng</a>.
                                            </small>
                                        </div>
                                    <?php endif; ?>
                                 </div>
                             <?php else: ?>
                                 <div class="purchase-section bg-light">
                                     <div class="text-center py-4">
                                         <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                                         <h4 class="text-warning">Sản phẩm hết hàng</h4>
                                         <p class="text-muted mb-3">Sản phẩm này hiện tại không có sẵn để mua.</p>
                                         <div class="d-flex justify-content-center gap-3">
                                             <button type="button" class="btn btn-outline-primary" onclick="refreshStockQuantity()">
                                                 <i class="fas fa-sync-alt me-2"></i>Kiểm tra lại
                                             </button>
                                             <a href="/websitePS/public/products/list" class="btn btn-primary">
                                                 <i class="fas fa-arrow-left me-2"></i>Xem sản phẩm khác
                                             </a>
                                         </div>
                                     </div>
                                 </div>
                             <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Product Reviews Section -->
        <div class="reviews-section py-5">
            <div class="container">
                <h2 class="section-title text-center mb-5">
                    <i class="fas fa-star me-2"></i>
                    Đánh giá từ khách hàng
                </h2>
                
                <!-- Overall Rating -->
                <?php if (!empty($productRating) && $productRating['TrungBinh'] > 0): ?>
                <div class="text-center mb-4">
                    <div class="d-inline-block bg-white p-4 rounded shadow-sm">
                        <h4 class="text-primary mb-2">Đánh giá trung bình</h4>
                        <div class="d-flex align-items-center justify-content-center mb-2">
                            <?php 
                            $avgRating = round($productRating['TrungBinh'], 1);
                            for ($i = 1; $i <= 5; $i++): 
                            ?>
                                <i class="fas fa-star <?= $i <= $avgRating ? 'text-warning' : 'text-muted' ?>"></i>
                            <?php endfor; ?>
                            <span class="ms-2 fw-bold"><?= $avgRating ?>/5</span>
                        </div>
                        <p class="text-muted mb-0">Dựa trên <?= $productRating['TongDanhGia'] ?> đánh giá xác thực
                            <?php if (isset($reviewStats) && $reviewStats['TongDanhGia'] > 0): ?>
                                <br><small class="text-success">
                                    <i class="fas fa-check-circle me-1"></i>
                                    <?= $reviewStats['TyLeXacThuc'] ?>% đánh giá từ khách hàng đã mua hàng
                                </small>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Review Form for Logged-in Customers -->
                <?php if (isset($_SESSION['customer_id']) && $canReview && $canReview['canReview']): ?>
                <div class="review-form-section mb-5">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-edit me-2"></i>
                                Viết đánh giá của bạn
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php if (count($canReview['purchasedProducts']) > 1): ?>
                            <div class="alert alert-info mb-3">
                                <i class="fas fa-info-circle me-2"></i>
                                Bạn có <?= count($canReview['purchasedProducts']) ?> đơn hàng chưa đánh giá cho sản phẩm này.
                            </div>
                            <?php endif; ?>
                            
                            <?php foreach ($canReview['purchasedProducts'] as $index => $order): ?>
                            <div class="review-form-item mb-4 <?= $index > 0 ? 'border-top pt-3' : '' ?>">
                                <h6 class="text-primary mb-2">
                                    <i class="fas fa-shopping-bag me-2"></i>
                                    Đơn hàng #<?= $order['MaDH'] ?> 
                                    <small class="text-muted">(<?= date('d/m/Y', strtotime($order['NgayDatHang'])) ?>)</small>
                                </h6>
                                
                                <form action="/websitePS/public/review/submit" method="POST">
                                    <input type="hidden" name="product_id" value="<?= $product['MaSP'] ?>">
                                    <input type="hidden" name="order_id" value="<?= $order['MaDH'] ?>">
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Đánh giá của bạn:</label>
                                        <div class="rating-input">
                                            <?php for ($i = 5; $i >= 1; $i--): ?>
                                            <input type="radio" name="rating" value="<?= $i ?>" id="rating_<?= $order['MaDH'] ?>_<?= $i ?>" required>
                                            <label for="rating_<?= $order['MaDH'] ?>_<?= $i ?>" class="rating-star">
                                                <i class="fas fa-star"></i>
                                            </label>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="content_<?= $order['MaDH'] ?>" class="form-label">Nhận xét:</label>
                                        <textarea name="content" id="content_<?= $order['MaDH'] ?>" class="form-control" rows="3" 
                                                  placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm này..."></textarea>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fas fa-paper-plane me-2"></i>
                                        Gửi đánh giá cho đơn hàng #<?= $order['MaDH'] ?>
                                    </button>
                                </form>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php elseif (isset($_SESSION['customer_id']) && $canReview && !$canReview['canReview']): ?>
                <div class="alert alert-info mb-5">
                    <i class="fas fa-info-circle me-2"></i>
                    <?= htmlspecialchars($canReview['reason']) ?>
                </div>
                <?php elseif (!isset($_SESSION['customer_id'])): ?>
                <div class="alert alert-warning mb-5">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Bạn cần <a href="/websitePS/public/customerauth/login" class="alert-link">đăng nhập</a> và mua sản phẩm này để có thể đánh giá.
                </div>
                <?php endif; ?>
                
                <!-- Reviews List with Filter -->
                <?php if (!empty($reviews)): ?>
                <div class="reviews-list">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0">Tất cả đánh giá (<?= count($reviews) ?>)</h4>
                        
                        <!-- Rating Filter -->
                        <div class="rating-filter">
                            <div class="btn-group" role="group" aria-label="Rating filter">
                                <button type="button" class="btn btn-outline-primary filter-btn active" data-rating="all">
                                    <i class="fas fa-star me-1"></i>Tất cả
                                </button>
                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                <button type="button" class="btn btn-outline-warning filter-btn" data-rating="<?= $i ?>">
                                    <?= $i ?> <i class="fas fa-star"></i>
                                </button>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row" id="reviews-container" style="display: flex;">
                        <?php foreach ($reviews as $review): ?>
                        <div class="col-md-6 col-lg-4 mb-4 review-item" data-rating="<?= $review['SoSao'] ?>">
                            <div class="card h-100 shadow-sm review-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="user-avatar text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1"><?= htmlspecialchars($review['TenKhachHang'] ?? 'Khách hàng') ?></h6>
                                            <div class="text-warning rating-stars">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <i class="fas fa-star <?= $i <= $review['SoSao'] ? 'text-warning' : 'text-muted' ?>"></i>
                                                <?php endfor; ?>
                                            </div>
                                            <?php if (isset($review['TrangThaiMuaHang']) && $review['TrangThaiMuaHang'] === 'Đã mua hàng'): ?>
                                                <small class="text-success">
                                                    <i class="fas fa-check-circle me-1"></i>
                                                    Đã mua hàng
                                                    <?php if (isset($review['MaDH'])): ?>
                                                        <br><small class="text-muted">Đơn hàng #<?= $review['MaDH'] ?></small>
                                                    <?php endif; ?>
                                                </small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <p class="card-text"><?= htmlspecialchars($review['NoiDung']) ?></p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <?= date('d/m/Y', strtotime($review['NgayDanhGia'])) ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- No reviews message for filtered results -->
                    <div id="no-reviews-message" class="text-center py-5" style="display: none;">
                        <i class="fas fa-filter fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Không có đánh giá nào phù hợp</h5>
                        <p class="text-muted">Thử chọn bộ lọc khác để xem đánh giá</p>
                    </div>
                </div>
                <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Chưa có đánh giá nào</h5>
                    <p class="text-muted">Hãy là người đầu tiên đánh giá sản phẩm này!</p>
                </div>
                <?php endif; ?>
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
                                    <img src="<?= getProductImage($relatedProduct) ?>" 
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
    const currentValue = parseInt(input.value) || 1;
    const newValue = currentValue + change;
    
    // Đảm bảo số lượng không nhỏ hơn 1
    if (newValue >= 1) {
        input.value = newValue;
        
        // Thêm hiệu ứng visual feedback
        const button = event.target;
        button.style.transform = 'scale(0.95)';
        setTimeout(() => {
            button.style.transform = 'scale(1)';
        }, 150);
        
        // Cập nhật trạng thái nút
        updateQuantityButtonStates();
    }
}

// Cập nhật trạng thái của các nút tăng/giảm
function updateQuantityButtonStates() {
    const input = document.getElementById('quantity');
    const decreaseBtn = document.querySelector('.quantity-btn[onclick*="-1"]');
    const increaseBtn = document.querySelector('.quantity-btn[onclick*="1"]');
    
    const currentValue = parseInt(input.value) || 1;
    
    // Disable nút giảm nếu số lượng = 1
    if (decreaseBtn) {
        decreaseBtn.disabled = currentValue <= 1;
        decreaseBtn.style.opacity = currentValue <= 1 ? '0.5' : '1';
        decreaseBtn.style.cursor = currentValue <= 1 ? 'not-allowed' : 'pointer';
    }
    
    // Enable nút tăng luôn
    if (increaseBtn) {
        increaseBtn.disabled = false;
        increaseBtn.style.opacity = '1';
        increaseBtn.style.cursor = 'pointer';
    }
}

// Prevent manual input of negative numbers and validate input
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.getElementById('quantity');
    
    if (quantityInput) {
        quantityInput.addEventListener('input', function() {
            let value = parseInt(this.value) || 1;
            
            // Đảm bảo giá trị không nhỏ hơn 1
            if (value < 1) {
                value = 1;
            }
            
            // Đảm bảo giá trị không quá lớn (giới hạn 999)
            if (value > 999) {
                value = 999;
            }
            
            this.value = value;
            updateQuantityButtonStates();
        });
        
        // Khởi tạo trạng thái ban đầu
        updateQuantityButtonStates();
    }
});

// Toast Notification Function
function showToast(message, type = 'success') {
    // Remove existing toasts
    const existingToasts = document.querySelectorAll('.toast-notification');
    existingToasts.forEach(toast => toast.remove());
    
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `toast-notification ${type}`;
    
    const icon = type === 'success' ? 'fas fa-check' : 'fas fa-exclamation-triangle';
    const title = type === 'success' ? 'Thành công!' : 'Lỗi!';
    
    toast.innerHTML = `
        <button class="toast-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
        <div class="toast-header">
            <div class="toast-icon ${type}">
                <i class="${icon}"></i>
            </div>
            <h6 class="toast-title">${title}</h6>
        </div>
        <div class="toast-body">
            ${message}
        </div>
    `;
    
    // Add to page
    document.body.appendChild(toast);
    
    // Show animation
    setTimeout(() => {
        toast.classList.add('show');
    }, 100);
    
    // Auto hide after 4 seconds
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => {
            if (toast.parentElement) {
                toast.remove();
            }
        }, 300);
    }, 4000);
}

// Add to Cart Function
function addToCart(event) {
    event.preventDefault();
    
    const form = event.target;
    const quantityInput = document.getElementById('quantity');
    const quantity = parseInt(quantityInput.value) || 1;
    
    // Validate quantity
    if (quantity < 1) {
        showToast('Số lượng phải lớn hơn 0!', 'error');
        quantityInput.value = 1;
        updateQuantityButtonStates();
        return;
    }
    
    if (quantity > 999) {
        showToast('Số lượng không được vượt quá 999!', 'error');
        quantityInput.value = 999;
        updateQuantityButtonStates();
        return;
    }
    
    const formData = new FormData(form);
    const button = document.getElementById('addToCartBtn');
    const textSpan = document.getElementById('addToCartText');
    const loadingSpan = document.getElementById('addToCartLoading');
    
    // Show loading state
    button.disabled = true;
    textSpan.style.display = 'none';
    loadingSpan.style.display = 'inline';
    
    // Send AJAX request
    fetch('/websitePS/public/cart/add', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message || 'Đã thêm sản phẩm vào giỏ hàng thành công!', 'success');
            
            // Reset form
            quantityInput.value = 1;
            updateQuantityButtonStates();
            
            // Update cart count if available
            const cartCountElement = document.querySelector('.cart-count');
            if (cartCountElement && data.cartCount !== undefined) {
                cartCountElement.textContent = data.cartCount;
                cartCountElement.style.display = data.cartCount > 0 ? 'block' : 'none';
            }
        } else {
            showToast(data.message || 'Có lỗi xảy ra khi thêm vào giỏ hàng!', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Có lỗi xảy ra khi thêm vào giỏ hàng!', 'error');
    })
    .finally(() => {
        // Reset button state
        button.disabled = false;
        textSpan.style.display = 'inline';
        loadingSpan.style.display = 'none';
    });
}

// Rating Filter Functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const reviewItems = document.querySelectorAll('.review-item');
    const noReviewsMessage = document.getElementById('no-reviews-message');
    const reviewsContainer = document.getElementById('reviews-container');
    
    if (filterButtons.length > 0) {
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                const selectedRating = this.getAttribute('data-rating');
                
                // Update active button
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                // Filter and sort reviews
                let visibleItems = [];
                let hiddenItems = [];
                
                reviewItems.forEach(item => {
                    const itemRating = item.getAttribute('data-rating');
                    
                    if (selectedRating === 'all' || itemRating === selectedRating) {
                        visibleItems.push(item);
                    } else {
                        hiddenItems.push(item);
                    }
                });
                
                // Sort visible items by rating (highest first) and then by date (newest first)
                visibleItems.sort((a, b) => {
                    const ratingA = parseInt(a.getAttribute('data-rating'));
                    const ratingB = parseInt(b.getAttribute('data-rating'));
                    
                    // First sort by rating (highest first)
                    if (ratingA !== ratingB) {
                        return ratingB - ratingA;
                    }
                    
                    // If same rating, sort by date (newest first)
                    const dateA = a.querySelector('small.text-muted').textContent.trim();
                    const dateB = b.querySelector('small.text-muted').textContent.trim();
                    
                    // Convert date format dd/mm/yyyy to yyyy-mm-dd for comparison
                    const convertDate = (dateStr) => {
                        const parts = dateStr.split('/');
                        return `${parts[2]}-${parts[1]}-${parts[0]}`;
                    };
                    
                    return new Date(convertDate(dateB)) - new Date(convertDate(dateA));
                });
                
                // Clear container and re-append sorted items
                reviewsContainer.innerHTML = '';
                
                // Reset animation delays
                reviewItems.forEach(item => {
                    item.style.animationDelay = '0s';
                });
                
                // Add visible items in sorted order with staggered animation
                visibleItems.forEach((item, index) => {
                    item.classList.remove('hidden');
                    item.classList.add('visible');
                    reviewsContainer.appendChild(item);
                    
                    // Add staggered animation delay
                    item.style.animationDelay = `${index * 0.1}s`;
                });
                
                // Add hidden items at the end (they will be hidden by CSS)
                hiddenItems.forEach(item => {
                    item.classList.add('hidden');
                    item.classList.remove('visible');
                    reviewsContainer.appendChild(item);
                });
                
                // Show/hide no reviews message
                if (visibleItems.length === 0) {
                    noReviewsMessage.style.display = 'block';
                    reviewsContainer.style.display = 'none';
                } else {
                    noReviewsMessage.style.display = 'none';
                    reviewsContainer.style.display = 'flex';
                }
                
                // Update review count
                const reviewCountElement = document.querySelector('.reviews-list h4');
                if (reviewCountElement) {
                    if (selectedRating === 'all') {
                        reviewCountElement.textContent = `Tất cả đánh giá (${reviewItems.length})`;
                    } else {
                        reviewCountElement.textContent = `Đánh giá ${selectedRating} sao (${visibleItems.length})`;
                    }
                }
            });
        });
    }
    
    // ===== STOCK QUANTITY REFRESH FUNCTIONALITY =====
    
    // Lấy product ID từ URL
    const productId = <?= $product['MaSP'] ?>;
    
    /**
     * Refresh số lượng sản phẩm real-time
     */
    function refreshStockQuantity() {
        const stockElement = document.getElementById('stockQuantity');
        const refreshButton = stockElement.nextElementSibling;
        const originalText = refreshButton.innerHTML;
        
        // Hiển thị loading
        refreshButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        refreshButton.disabled = true;
        
        // Gọi API để lấy số lượng mới
        fetch(`/websitePS/public/products/getStockInfo/${productId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Cập nhật hiển thị số lượng
                    if (data.stock > 0) {
                        stockElement.innerHTML = `${data.stock} sản phẩm`;
                        stockElement.className = 'meta-value';
                    } else {
                        stockElement.innerHTML = '<span class="text-danger fw-bold">Hết hàng</span>';
                        stockElement.className = 'meta-value';
                    }
                    
                    // Cập nhật max attribute của input quantity
                    const quantityInput = document.getElementById('quantity');
                    if (quantityInput) {
                        quantityInput.max = data.stock;
                    }
                    
                    // Cập nhật trạng thái nút "Thêm vào giỏ hàng"
                    const addToCartBtn = document.getElementById('addToCartBtn');
                    if (data.stock <= 0) {
                        addToCartBtn.disabled = true;
                        addToCartBtn.innerHTML = '<i class="fas fa-times me-2"></i><span id="addToCartText">Hết hàng</span>';
                        addToCartBtn.className = 'btn btn-secondary add-to-cart-btn';
                    } else {
                        addToCartBtn.disabled = false;
                        addToCartBtn.innerHTML = '<i class="fas fa-shopping-cart me-2"></i><span id="addToCartText">Thêm vào giỏ hàng</span>';
                        addToCartBtn.className = 'btn btn-primary-custom add-to-cart-btn';
                    }
                    
                    // Hiển thị thông báo thành công
                    showToast(`Đã cập nhật số lượng: ${data.stock} sản phẩm`, 'success');
                    
                    console.log(`Stock refreshed: ${data.stock} products`);
                } else {
                    console.error('Failed to refresh stock:', data.message);
                    showToast('Không thể cập nhật số lượng sản phẩm', 'error');
                }
            })
            .catch(error => {
                console.error('Error refreshing stock:', error);
                showToast('Có lỗi xảy ra khi cập nhật số lượng', 'error');
            })
            .finally(() => {
                // Khôi phục trạng thái nút
                refreshButton.innerHTML = originalText;
                refreshButton.disabled = false;
            });
    }
    
    /**
     * Auto-refresh số lượng mỗi 5 phút
     */
    function startStockAutoRefresh() {
        setInterval(() => {
            console.log('Auto-refreshing stock quantity...');
            refreshStockQuantity();
        }, 5 * 60 * 1000); // 5 phút
    }
    
    /**
     * Refresh số lượng khi user tương tác với trang
     */
    function setupStockRefreshTriggers() {
        // Refresh khi user focus vào tab
        document.addEventListener('visibilitychange', () => {
            if (!document.hidden) {
                console.log('Tab focused, refreshing stock...');
                refreshStockQuantity();
            }
        });
        
        // Refresh khi user click vào các phần tử quan trọng
        const importantElements = [
            document.getElementById('addToCartForm'),
            document.querySelector('.quantity-control'),
            document.querySelector('.product-meta')
        ];
        
        importantElements.forEach(element => {
            if (element) {
                element.addEventListener('click', () => {
                    // Debounce để tránh refresh quá nhiều
                    clearTimeout(window.stockRefreshTimeout);
                    window.stockRefreshTimeout = setTimeout(() => {
                        refreshStockQuantity();
                    }, 1000);
                });
            }
        });
    }
    
    // Khởi tạo auto-refresh và triggers
    document.addEventListener('DOMContentLoaded', function() {
        // Bắt đầu auto-refresh sau 10 giây
        setTimeout(() => {
            startStockAutoRefresh();
            setupStockRefreshTriggers();
        }, 10000);
        
        // Refresh lần đầu sau 2 giây
        setTimeout(() => {
            refreshStockQuantity();
        }, 2000);
    });
    
});
</script>
</body>
</html>
