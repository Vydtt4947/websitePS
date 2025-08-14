<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng của bạn - Parrot Smell</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/websitePS/public/assets/css/style.css">
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
            background-color: #f8f9fa;
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
        .btn-outline-primary-custom {
            background-color: transparent;
            border-color: var(--primary-color);
            color: var(--primary-color);
            padding: 12px 30px;
            font-weight: 500;
            transition: all 0.3s;
        }
        .btn-outline-primary-custom:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, #00796b 100%);
            color: white;
            padding: 4rem 0;
            text-align: center;
        }
        .hero-title {
            font-family: var(--heading-font);
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .hero-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        
        /* Cart Container */
        .cart-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 2.5rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }
        .cart-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), #00796b);
        }
        
        /* Empty Cart */
        .empty-cart {
            text-align: center;
            padding: 4rem 2rem;
        }
        .empty-cart-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 3rem;
            color: var(--primary-color);
        }
        .empty-cart h3 {
            font-family: var(--heading-font);
            color: var(--text-color);
            margin-bottom: 1rem;
        }
        .empty-cart p {
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }
        
        /* Product Cards */
        .product-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border: 1px solid #f1f3f4;
        }
        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        .product-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .product-info h5 {
            font-family: var(--heading-font);
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }
        .product-code {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        .product-price {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-color);
        }
        .product-total {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-color);
        }
        
        /* Quantity Controls */
        .quantity-control {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: #f8f9fa;
            border-radius: 25px;
            padding: 0.5rem;
            width: fit-content;
        }
        .quantity-btn {
            width: 35px;
            height: 35px;
            border: none;
            background: white;
            color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .quantity-btn:hover {
            background: var(--primary-color);
            color: white;
            transform: scale(1.1);
        }
        .quantity-input {
            width: 50px;
            text-align: center;
            border: none;
            background: transparent;
            font-weight: 600;
            color: var(--text-color);
        }
        .quantity-input:focus {
            outline: none;
        }
        
        /* Remove Button */
        .remove-btn {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            border: none;
            color: white;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(255,107,107,0.3);
        }
        .remove-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 15px rgba(255,107,107,0.4);
        }
        
        /* Cart Summary */
        .cart-summary {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 2rem;
            position: sticky;
            top: 2rem;
        }
        .summary-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f1f3f4;
        }
        .summary-header h4 {
            font-family: var(--heading-font);
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }
        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #f1f3f4;
        }
        .summary-item:last-child {
            border-bottom: none;
            font-weight: 700;
            font-size: 1.3rem;
            color: var(--primary-color);
            padding-top: 1.5rem;
            border-top: 2px solid #f1f3f4;
        }
        .summary-label {
            color: #6c757d;
        }
        .summary-value {
            font-weight: 600;
            color: var(--text-color);
        }
        .summary-total {
            color: var(--primary-color) !important;
        }
        
        /* Action Buttons */
        .action-buttons {
            margin-top: 2rem;
        }
        .btn-continue {
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 12px 25px;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 1rem;
            width: 100%;
        }
        .btn-continue:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }
        .btn-checkout {
            background: linear-gradient(135deg, var(--primary-color), #00796b);
            border: none;
            color: white;
            padding: 15px 25px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            width: 100%;
            box-shadow: 0 5px 15px rgba(0,150,136,0.3);
        }
        .btn-checkout:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,150,136,0.4);
            color: white;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            .cart-container {
                padding: 1.5rem;
            }
            .product-card {
                padding: 1rem;
            }
            .product-image {
                width: 80px;
                height: 80px;
            }
            .quantity-control {
                margin: 1rem 0;
            }
        }
        
        /* Footer Styles */
        .footer {
            background-color: var(--text-color);
            color: var(--secondary-color);
            padding: 3rem 0 2rem;
            margin-top: 4rem;
        }
        
        .footer a {
            color: var(--secondary-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer a:hover {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .footer h6 {
            color: var(--secondary-color);
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <?php include __DIR__ . '/layouts/navbar.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="hero-title">Giỏ Hàng Của Bạn</h1>
            <p class="hero-subtitle">Kiểm tra và hoàn tất đơn hàng của bạn</p>
        </div>
    </section>

    <div class="container">
        <?php if (!isset($_SESSION['customer_id'])): ?>
            <div class="cart-container">
                <div class="empty-cart">
                    <div class="empty-cart-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h3>Vui lòng đăng nhập để xem giỏ hàng</h3>
                    <p>Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng và thực hiện đặt hàng</p>
                    <div class="d-flex gap-3 justify-content-center">
                        <a href="/websitePS/public/customerauth/login" class="btn btn-primary-custom">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Đăng nhập
                        </a>
                        <a href="/websitePS/public/customerauth/register" class="btn btn-outline-primary-custom">
                            <i class="fas fa-user-plus me-2"></i>
                            Đăng ký
                        </a>
                    </div>
                </div>
            </div>
        <?php elseif (empty($cart)): ?>
            <div class="cart-container">
                <div class="empty-cart">
                    <div class="empty-cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h3>Giỏ hàng của bạn đang trống</h3>
                    <p>Hãy khám phá các sản phẩm ngon của chúng tôi và thêm vào giỏ hàng</p>
                    <a href="/websitePS/public/products/list" class="btn btn-primary-custom">
                        <i class="fas fa-shopping-bag me-2"></i>
                        Khám phá sản phẩm
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-lg-8">
                    <div class="cart-container">
                        <h3 class="mb-4">
                            <i class="fas fa-shopping-cart me-2 text-primary"></i>
                            Sản phẩm trong giỏ hàng (<?= count($cart) ?>)
                        </h3>
                        
                        <?php $total = 0; ?>
                        <?php foreach ($cart as $id => $item): ?>
                            <?php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; ?>
                            <div class="product-card">
                                <div class="row align-items-center">
                                    <div class="col-md-2 col-4">
                                        <img src="<?= $item['image'] ?>" class="product-image img-fluid">
                                    </div>
                                    <div class="col-md-4 col-8">
                                        <div class="product-info">
                                            <h5><?= htmlspecialchars($item['name']) ?></h5>
                                            <div class="product-code">Mã: <?= $id ?></div>
                                            <div class="product-price"><?= number_format($item['price'], 0, ',', '.') ?> đ</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <div class="quantity-control">
                                            <button class="quantity-btn" onclick="updateQuantity(<?= $id ?>, -1)">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number" class="quantity-input" value="<?= $item['quantity'] ?>" 
                                                   min="1" onchange="updateQuantity(<?= $id ?>, this.value - <?= $item['quantity'] ?>)">
                                            <button class="quantity-btn" onclick="updateQuantity(<?= $id ?>, 1)">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-3 text-end">
                                        <div class="product-total"><?= number_format($subtotal, 0, ',', '.') ?> đ</div>
                                    </div>
                                    <div class="col-md-1 col-3 text-end">
                                        <a href="/websitePS/public/cart/remove/<?= $id ?>" class="remove-btn" 
                                           title="Xóa sản phẩm" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="cart-summary">
                        <div class="summary-header">
                            <h4><i class="fas fa-receipt me-2"></i>Tóm tắt đơn hàng</h4>
                        </div>
                        
                        <div class="summary-item">
                            <span class="summary-label">Số sản phẩm:</span>
                            <span class="summary-value"><?= count($cart) ?></span>
                        </div>
                        
                        <?php
                        // Sử dụng logic ưu đãi từ controller
                        $shippingFee = isset($shippingFee) ? $shippingFee : 0;
                        $finalTotal = isset($finalTotal) ? $finalTotal : ($total + $shippingFee);
                        $appliedPromotions = isset($appliedPromotions) ? $appliedPromotions : [];
                        $totalDiscount = isset($totalDiscount) ? $totalDiscount : 0;
                        ?>
                        
                        <div class="summary-item">
                            <span class="summary-label">Tổng tiền hàng:</span>
                            <span class="summary-value"><?= number_format($total, 0, ',', '.') ?> đ</span>
                        </div>
                        
                        <?php if (!empty($appliedPromotions)): ?>
                            <div class="summary-item" style="background: #f8f9fa; border-radius: 10px; margin: 10px 0; padding: 15px;">
                                <div style="width: 100%;">
                                    <div style="color: #28a745; font-weight: 600; margin-bottom: 10px;">
                                        <i class="fas fa-gift me-2"></i>Ưu đãi đã áp dụng:
                                    </div>
                                    <?php foreach ($appliedPromotions as $promotion): ?>
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px; font-size: 0.9rem;">
                                            <span style="color: #6c757d;"><?= htmlspecialchars($promotion['description']) ?></span>
                                            <span style="color: #dc3545; font-weight: 600;">-<?= number_format($promotion['discount'], 0, ',', '.') ?> đ</span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($totalDiscount > 0): ?>
                            <div class="summary-item">
                                <span class="summary-label">Tổng giảm giá:</span>
                                <span class="summary-value" style="color: #dc3545;">-<?= number_format($totalDiscount, 0, ',', '.') ?> đ</span>
                            </div>
                        <?php endif; ?>
                        
                        <div class="summary-item">
                            <span class="summary-label">Phí vận chuyển:</span>
                            <span class="summary-value"><?= $shippingFee > 0 ? number_format($shippingFee, 0, ',', '.') . ' đ' : 'Miễn phí' ?></span>
                        </div>
                        
                        <div class="summary-item">
                            <span class="summary-label">Tổng cộng:</span>
                            <span class="summary-value summary-total"><?= number_format($finalTotal, 0, ',', '.') ?> đ</span>
                        </div>
                        
                        <div class="action-buttons">
                            <a href="/websitePS/public/products/list" class="btn-continue">
                                <i class="fas fa-arrow-left me-2"></i>
                                Tiếp tục mua sắm
                            </a>
                            <a href="/websitePS/public/checkout" class="btn-checkout">
                                <i class="fas fa-credit-card me-2"></i>
                                Thanh toán ngay
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

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
    function updateQuantity(productId, change) {
        // This would typically make an AJAX call to update the cart
        // For now, we'll just reload the page with the new quantity
        window.location.href = `/websitePS/public/cart/update/${productId}/${change}`;
    }
    </script>
</body>
</html>