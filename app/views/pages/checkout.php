<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán - Parrot Smell</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/websitePS/assets/css/style.css">
    <style>
        .checkout-page {
            min-height: 100vh;
            background-color: var(--light-bg);
        }
        
        .checkout-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #00796b 100%);
            color: var(--white);
            padding: 3rem 0;
            margin-bottom: 3rem;
        }
        
        .checkout-title {
            font-family: var(--heading-font);
            margin-bottom: 0.5rem;
        }
        
        .checkout-subtitle {
            opacity: 0.9;
            font-size: 1.1rem;
        }
        
        .checkout-container {
            background-color: var(--white);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .order-summary {
            background-color: var(--white);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 2rem;
            position: sticky;
            top: 2rem;
        }
        
        .summary-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--primary-color);
        }
        
        .summary-header h4 {
            color: var(--primary-color);
            margin: 0;
        }
        
        .summary-badge {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
        }
        
        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 1rem 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .order-item:last-child {
            border-bottom: none;
        }
        
        .item-details h6 {
            margin: 0 0 0.5rem 0;
            color: var(--text-color);
        }
        
        .item-details small {
            color: #6c757d;
        }
        
        .item-price {
            color: var(--text-color);
            font-weight: 500;
        }
        
        .total-section {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 2px solid #e9ecef;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }
        
        .total-row.final {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #e9ecef;
        }
        
        .form-section {
            margin-bottom: 2rem;
        }
        
        .form-section h4 {
            color: var(--text-color);
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--primary-color);
        }
        
        .form-floating {
            margin-bottom: 1.5rem;
        }
        
        .form-floating .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 1rem 0.75rem;
        }
        
        .form-floating .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 150, 136, 0.25);
        }
        
        .btn-place-order {
            width: 100%;
            padding: 15px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 1.1rem;
            margin-top: 2rem;
        }
        
        .payment-methods {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .payment-method {
            flex: 1;
            padding: 1rem;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .payment-method:hover {
            border-color: var(--primary-color);
        }
        
        .payment-method.selected {
            border-color: var(--primary-color);
            background-color: rgba(0, 150, 136, 0.1);
        }
        
        .payment-method i {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
        
                 .breadcrumb-nav {
             margin-bottom: 2rem;
         }
         
         /* QR Code Modal Styles */
         .qr-code-container {
             max-width: 400px;
             margin: 0 auto;
         }
         
         .qr-code-card {
             background: white;
             border-radius: 15px;
             padding: 1.5rem;
             box-shadow: 0 10px 30px rgba(0,0,0,0.1);
             border: 1px solid #e9ecef;
         }
         
         .qr-header {
             display: flex;
             align-items: center;
             margin-bottom: 1rem;
             padding-bottom: 1rem;
             border-bottom: 1px solid #e9ecef;
         }
         
         .bank-logo {
             margin-right: 1rem;
         }
         
         .bank-logo i {
             font-size: 2rem;
         }
         
         .account-info {
             flex: 1;
         }
         
         .account-name {
             font-weight: 600;
             color: #007bff;
             font-size: 0.9rem;
         }
         
         .account-number {
             font-size: 0.8rem;
             color: #6c757d;
         }
         
         .qr-code-image {
             margin: 1.5rem 0;
             text-align: center;
         }
         
         .qr-code-image img {
             max-width: 200px;
             border: 1px solid #e9ecef;
             border-radius: 10px;
         }
         
         .qr-footer {
             margin-top: 1rem;
             padding-top: 1rem;
             border-top: 1px solid #e9ecef;
         }
         
         .payment-info {
             margin-bottom: 1rem;
         }
         
         .amount, .order-id {
             margin-bottom: 0.5rem;
             font-size: 0.9rem;
         }
         
         .qr-logos {
             display: flex;
             justify-content: space-between;
             align-items: center;
         }
         
         .qr-logo {
             padding: 0.25rem 0.5rem;
             border-radius: 5px;
             font-size: 0.7rem;
             font-weight: 600;
         }
         
         .qr-logo.vietqr {
             background-color: #dc3545;
             color: white;
         }
         
         .qr-logo.napas {
             background-color: #28a745;
             color: white;
         }
         
         .payment-instructions {
             background-color: #f8f9fa;
             border-radius: 10px;
             padding: 1rem;
             margin-top: 1rem;
         }
         
         .payment-instructions h6 {
             color: var(--primary-color);
             margin-bottom: 0.5rem;
         }
         
         .payment-instructions ol {
             margin-bottom: 0;
             padding-left: 1.2rem;
         }
         
         .payment-instructions li {
             margin-bottom: 0.25rem;
             font-size: 0.9rem;
         }
    </style>
</head>
<body>
<div class="checkout-page">
    <!-- Navigation -->
    <?php include __DIR__ . '/layouts/navbar.php'; ?>

    <!-- Checkout Header -->
    <div class="checkout-header">
        <div class="container text-center">
            <h1 class="checkout-title">Thanh toán</h1>
            <p class="checkout-subtitle">Hoàn tất đơn hàng của bạn</p>
        </div>
    </div>

    <div class="container">
        <?php if (!isset($_SESSION['customer_id'])): ?>
            <div class="checkout-container">
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-lock" style="font-size: 4rem; color: var(--primary-color);"></i>
                    </div>
                    <h3>Vui lòng đăng nhập để thanh toán</h3>
                    <p class="text-muted mb-4">Bạn cần đăng nhập để thực hiện đặt hàng và thanh toán</p>
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
        <?php else: ?>
            <div class="breadcrumb-nav">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/websitePS/public/">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="/websitePS/public/cart">Giỏ hàng</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Thanh toán</li>
                    </ol>
                </nav>
            </div>
        
        <?php
        // Sử dụng các biến đã được tính toán từ CheckoutController
        // Nếu không có, tính toán lại
        if (!isset($total)) {
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }
        }
        
        if (!isset($shippingFee)) {
            $shippingFee = 0;
            if ($total < 100000) {
                $shippingFee = 15000;
            }
        }
        
        // Đảm bảo $finalTotal được định nghĩa
        if (!isset($finalTotal)) {
            $finalTotal = $total + $shippingFee;
        }
        
        // Debug logging
        error_log("Checkout page - Total: " . $total);
        error_log("Checkout page - Shipping fee: " . $shippingFee);
        error_log("Checkout page - Final total: " . $finalTotal);
        ?>
        
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="checkout-container">
                    <!-- Thông tin khách hàng -->
                                         <?php if (isset($_SESSION['error_message'])): ?>
                         <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                             <i class="fas fa-exclamation-triangle me-2"></i>
                             <?= htmlspecialchars($_SESSION['error_message']) ?>
                             <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                         </div>
                         <?php unset($_SESSION['error_message']); ?>
                     <?php endif; ?>
                     
                     <div class="form-section mb-4">
                         <h4>
                             <i class="fas fa-user me-2"></i>
                             Thông tin khách hàng
                         </h4>
                        <div class="alert alert-info">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Họ và tên:</strong> <?= htmlspecialchars($_SESSION['customer_name'] ?? '') ?>
                                </div>
                                <div class="col-md-6">
                                    <strong>Email:</strong> <?= htmlspecialchars($_SESSION['customer_email'] ?? '') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h4>
                            <i class="fas fa-shipping-fast me-2"></i>
                            Thông tin giao hàng
                        </h4>
                        
                        <?php if (!empty($customer['DiaChiGiaoHang']) || !empty($customer['TinhThanh'])): ?>
                            <div class="alert alert-info mb-3">
                                <h6><i class="fas fa-info-circle me-2"></i>Thông tin giao hàng đã lưu</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Địa chỉ:</strong> <?= htmlspecialchars($customer['DiaChiGiaoHang'] ?? '') ?>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Tỉnh/Thành:</strong> <?= htmlspecialchars($customer['TinhThanh'] ?? '') ?>
                                    </div>
                                    <?php if (!empty($customer['QuanHuyen'])): ?>
                                        <div class="col-md-6">
                                            <strong>Quận/Huyện:</strong> <?= htmlspecialchars($customer['QuanHuyen']) ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($customer['GhiChuGiaoHang'])): ?>
                                        <div class="col-md-6">
                                            <strong>Ghi chú:</strong> <?= htmlspecialchars($customer['GhiChuGiaoHang']) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="mt-2">
                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="toggleAddressForm()">
                                        <i class="fas fa-edit me-1"></i>Thay đổi địa chỉ
                                    </button>
                                    <button type="button" class="btn btn-sm btn-success" onclick="useSavedAddress()">
                                        <i class="fas fa-check me-1"></i>Sử dụng địa chỉ này
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <form action="/websitePS/public/checkout/placeOrder" method="POST" id="checkoutForm">
                            <div class="row g-3" id="addressForm" <?= (!empty($customer['DiaChiGiaoHang']) && !empty($customer['TinhThanh'])) ? 'style="display: none;"' : '' ?>>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="fullname" name="fullname" 
                                               placeholder="Họ và Tên" 
                                               value="<?= isset($_SESSION['customer_name']) ? htmlspecialchars($_SESSION['customer_name']) : '' ?>" 
                                               required>
                                        <label for="fullname">Họ và Tên</label>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="tel" class="form-control" id="phone" name="phone" 
                                               placeholder="Số điện thoại" 
                                               value="<?= isset($_SESSION['customer_phone']) ? htmlspecialchars($_SESSION['customer_phone']) : '' ?>" 
                                               required>
                                        <label for="phone">Số điện thoại</label>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" name="email" 
                                               placeholder="Email" 
                                               value="<?= isset($_SESSION['customer_email']) ? htmlspecialchars($_SESSION['customer_email']) : '' ?>" 
                                               required>
                                        <label for="email">Email</label>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" id="address" name="address" 
                                                  placeholder="Địa chỉ nhận hàng" 
                                                  rows="3" required><?= isset($_SESSION['customer_address']) ? htmlspecialchars($_SESSION['customer_address']) : '' ?></textarea>
                                        <label for="address">Địa chỉ nhận hàng</label>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" id="note" name="note" placeholder="Ghi chú (tùy chọn)" rows="2"></textarea>
                                        <label for="note">Ghi chú (tùy chọn)</label>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Hidden fields for saved address -->
                            <input type="hidden" id="savedAddress" name="savedAddress" value="<?= htmlspecialchars($customer['DiaChiGiaoHang'] ?? '') ?>">
                            <input type="hidden" id="savedTinhThanh" name="savedTinhThanh" value="<?= htmlspecialchars($customer['TinhThanh'] ?? '') ?>">
                            <input type="hidden" id="savedQuanHuyen" name="savedQuanHuyen" value="<?= htmlspecialchars($customer['QuanHuyen'] ?? '') ?>">
                            <input type="hidden" id="savedGhiChu" name="savedGhiChu" value="<?= htmlspecialchars($customer['GhiChuGiaoHang'] ?? '') ?>">
                            <input type="hidden" id="useSavedAddress" name="useSavedAddress" value="<?= (!empty($customer['DiaChiGiaoHang']) && !empty($customer['TinhThanh'])) ? '1' : '0' ?>">
                            
                            <div class="form-section">
                                <h4>
                                    <i class="fas fa-credit-card me-2"></i>
                                    Phương thức thanh toán
                                </h4>
                                
                                <div class="payment-methods">
                                    <div class="payment-method selected" onclick="selectPayment('cod')">
                                        <i class="fas fa-money-bill-wave"></i>
                                        <div>Thanh toán khi nhận hàng</div>
                                    </div>
                                    <div class="payment-method" onclick="selectPayment('bank')">
                                        <i class="fas fa-university"></i>
                                        <div>Chuyển khoản ngân hàng</div>
                                    </div>
                                </div>
                                
                                <input type="hidden" name="payment_method" id="payment_method" value="cod">
                            </div>
                            
                                                         <button type="submit" class="btn btn-primary-custom btn-place-order" id="submitOrderBtn">
                                 <i class="fas fa-check me-2"></i>
                                 <span id="submitBtnText">Hoàn tất đơn hàng</span>
                             </button>
                         </form>
                         
                         <!-- QR Code Modal for Bank Transfer -->
                         <div class="modal fade" id="qrCodeModal" tabindex="-1" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
                             <div class="modal-dialog modal-dialog-centered">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                         <h5 class="modal-title" id="qrCodeModalLabel">
                                             <i class="fas fa-qrcode me-2"></i>Thanh toán qua MBBank
                                         </h5>
                                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                     </div>
                                     <div class="modal-body text-center">
                                         <div class="qr-code-container">
                                             <div class="qr-code-card">
                                                 <div class="qr-header">
                                                     <div class="bank-logo">
                                                         <i class="fas fa-university text-danger"></i>
                                                     </div>
                                                     <div class="account-info">
                                                         <div class="account-name">NGUYEN HOANG PHUONG</div>
                                                         <div class="account-number">44331515001531</div>
                                                     </div>
                                                 </div>
                                                                                                                                                     <div class="qr-code-image">
                                                       <img src="https://i.ibb.co/VqKJ8M1/mbbank-qr.png" alt="MBBank QR Code" class="img-fluid" style="max-width: 200px; border: 1px solid #e9ecef; border-radius: 10px;">
                                                   </div>
                                                 <div class="qr-footer">
                                                     <div class="payment-info">
                                                         <div class="amount">Số tiền: <strong><?= number_format(isset($finalTotal) ? $finalTotal : ($total + $shippingFee), 0, ',', '.') ?> đ</strong></div>
                                                         <div class="order-id">Mã đơn hàng: <strong>#<?= uniqid('PS') ?></strong></div>
                                                     </div>
                                                     <div class="qr-logos">
                                                         <span class="qr-logo vietqr">VIETQR</span>
                                                         <span class="qr-logo napas">napas 247</span>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="payment-instructions mt-3">
                                             <h6><i class="fas fa-info-circle me-2"></i>Hướng dẫn thanh toán:</h6>
                                             <ol class="text-start">
                                                 <li>Mở ứng dụng ngân hàng của bạn</li>
                                                 <li>Chọn tính năng quét mã QR</li>
                                                 <li>Quét mã QR bên trên</li>
                                                 <li>Kiểm tra thông tin và xác nhận thanh toán</li>
                                                 <li>Lưu lại biên lai thanh toán</li>
                                             </ol>
                                         </div>
                                     </div>
                                     <div class="modal-footer">
                                         <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                             <i class="fas fa-times me-2"></i>Đóng
                                         </button>
                                         <button type="button" class="btn btn-success" onclick="confirmPayment()">
                                             <i class="fas fa-check me-2"></i>Đã thanh toán
                                         </button>
                                     </div>
                                 </div>
                             </div>
                         </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="order-summary">
                    <div class="summary-header">
                        <h4>
                            <i class="fas fa-receipt me-2"></i>
                            Đơn hàng của bạn
                        </h4>
                        <span class="summary-badge"><?= count($cart) ?> sản phẩm</span>
                    </div>
                    
                    <div class="order-items">
                        <?php foreach ($cart as $item): ?>
                            <?php $subtotal = $item['price'] * $item['quantity']; ?>
                            <div class="order-item">
                                <div class="item-details">
                                    <h6><?= htmlspecialchars($item['name']) ?></h6>
                                    <small>Số lượng: <?= $item['quantity'] ?></small>
                                </div>
                                <div class="item-price"><?= number_format($subtotal, 0, ',', '.') ?> đ</div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="total-section">
                        <div class="total-row">
                            <span>Tổng tiền hàng:</span>
                            <span><?= number_format($total, 0, ',', '.') ?> đ</span>
                        </div>
                        
                        <?php if (!empty($appliedPromotions)): ?>
                            <div class="total-row" style="background: #f8f9fa; border-radius: 10px; margin: 10px 0; padding: 15px;">
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
                        
                        <?php if (isset($totalDiscount) && $totalDiscount > 0): ?>
                            <div class="total-row">
                                <span>Tổng giảm giá:</span>
                                <span style="color: #dc3545;">-<?= number_format($totalDiscount, 0, ',', '.') ?> đ</span>
                            </div>
                        <?php endif; ?>
                        
                        <div class="total-row">
                            <span>Phí vận chuyển:</span>
                            <span><?= $shippingFee > 0 ? number_format($shippingFee, 0, ',', '.') . ' đ' : 'Miễn phí' ?></span>
                        </div>
                        <div class="total-row final">
                            <span>Tổng cộng:</span>
                            <span><?= number_format(isset($finalTotal) ? $finalTotal : ($total + $shippingFee), 0, ',', '.') ?> đ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function selectPayment(method) {
    // Remove selected class from all payment methods
    document.querySelectorAll('.payment-method').forEach(el => {
        el.classList.remove('selected');
    });
    
    // Add selected class to clicked method
    event.currentTarget.classList.add('selected');
    
    // Update hidden input
    document.getElementById('payment_method').value = method;
    
    // Update button text
    const submitBtnText = document.getElementById('submitBtnText');
    if (submitBtnText) {
        submitBtnText.textContent = method === 'bank' ? 'Hiển thị QR Code' : 'Hoàn tất đơn hàng';
    }
}

function toggleAddressForm() {
    const addressForm = document.getElementById('addressForm');
    const useSavedBtn = document.querySelector('button[onclick="useSavedAddress()"]');
    const toggleBtn = document.querySelector('button[onclick="toggleAddressForm()"]');
    
    if (addressForm.style.display === 'none') {
        addressForm.style.display = 'block';
        toggleBtn.innerHTML = '<i class="fas fa-times me-1"></i>Hủy thay đổi';
        toggleBtn.className = 'btn btn-sm btn-outline-danger';
        useSavedBtn.style.display = 'none';
        document.getElementById('useSavedAddress').value = '0';
        
        // Add required attributes back when showing form
        const fullnameField = document.getElementById('fullname');
        const phoneField = document.getElementById('phone');
        const emailField = document.getElementById('email');
        const addressField = document.getElementById('address');
        
        if (fullnameField) fullnameField.setAttribute('required', 'required');
        if (phoneField) phoneField.setAttribute('required', 'required');
        if (emailField) emailField.setAttribute('required', 'required');
        if (addressField) addressField.setAttribute('required', 'required');
    } else {
        addressForm.style.display = 'none';
        toggleBtn.innerHTML = '<i class="fas fa-edit me-1"></i>Thay đổi địa chỉ';
        toggleBtn.className = 'btn btn-sm btn-outline-primary';
        useSavedBtn.style.display = 'inline-block';
        
        // Remove required attributes when hiding form
        const requiredFields = addressForm.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            field.removeAttribute('required');
        });
    }
}

function useSavedAddress() {
    const addressForm = document.getElementById('addressForm');
    const toggleBtn = document.querySelector('button[onclick="toggleAddressForm()"]');
    const useSavedBtn = document.querySelector('button[onclick="useSavedAddress()"]');
    
    // Remove required attributes from hidden form fields
    const requiredFields = addressForm.querySelectorAll('[required]');
    requiredFields.forEach(field => {
        field.removeAttribute('required');
    });
    
    addressForm.style.display = 'none';
    toggleBtn.innerHTML = '<i class="fas fa-edit me-1"></i>Thay đổi địa chỉ';
    toggleBtn.className = 'btn btn-sm btn-outline-primary';
    useSavedBtn.style.display = 'none';
    document.getElementById('useSavedAddress').value = '1';
    
    // Show success message
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-success alert-dismissible fade show';
    alertDiv.innerHTML = `
        <i class="fas fa-check-circle me-2"></i>Đã chọn sử dụng địa chỉ đã lưu
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.querySelector('.form-section').insertBefore(alertDiv, document.querySelector('.form-section').firstChild);
}

// Form validation và submission handling
document.addEventListener('DOMContentLoaded', function() {
    const checkoutForm = document.getElementById('checkoutForm');
    const submitBtn = document.getElementById('submitOrderBtn');
    const addressForm = document.getElementById('addressForm');
    
    // Initialize form state based on saved address
    const useSavedAddress = document.getElementById('useSavedAddress');
    if (useSavedAddress && useSavedAddress.value === '1') {
        // If using saved address, remove required attributes from hidden form
        if (addressForm) {
            const requiredFields = addressForm.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                field.removeAttribute('required');
            });
        }
    }
    
         if (checkoutForm) {
         checkoutForm.addEventListener('submit', function(e) {
             e.preventDefault();
             
             try {
                 // Get payment method
                 const paymentMethod = document.getElementById('payment_method').value;
                 
                 // Validate form
                 const useSavedAddressValue = document.getElementById('useSavedAddress').value;
                 
                 if (useSavedAddressValue === '0') {
                     // Validate required fields for new address
                     const fullname = document.getElementById('fullname').value.trim();
                     const phone = document.getElementById('phone').value.trim();
                     const email = document.getElementById('email').value.trim();
                     const address = document.getElementById('address').value.trim();
                     
                     if (!fullname || !phone || !email || !address) {
                         alert('Vui lòng điền đầy đủ thông tin giao hàng!');
                         return;
                     }
                 }
                 
                                   // If bank transfer, show QR code modal
                  if (paymentMethod === 'bank') {
                      // Update order ID in modal with a more realistic format
                      const orderId = 'PS' + Date.now();
                      const orderIdElement = document.querySelector('.order-id strong');
                      if (orderIdElement) {
                          orderIdElement.textContent = '#' + orderId;
                      }
                     
                     // Show QR code modal
                     const qrModalElement = document.getElementById('qrCodeModal');
                     if (qrModalElement) {
                         const qrModal = new bootstrap.Modal(qrModalElement);
                         qrModal.show();
                     } else {
                         console.error('QR modal element not found');
                         alert('Có lỗi xảy ra khi hiển thị QR code!');
                     }
                     return;
                 }
                 
                 // If COD, proceed with normal submission
                 // Disable button to prevent double submission
                 if (submitBtn) {
                     submitBtn.disabled = true;
                     const submitBtnText = document.getElementById('submitBtnText');
                     if (submitBtnText) {
                         submitBtnText.textContent = 'Đang xử lý...';
                     }
                 }
                 
                 // Submit the form
                 console.log('Submitting order...');
                 checkoutForm.submit();
             } catch (error) {
                 console.error('Error in form submission:', error);
                 alert('Có lỗi xảy ra: ' + error.message);
                 
                 // Re-enable button if there's an error
                 if (submitBtn) {
                     submitBtn.disabled = false;
                     const submitBtnText = document.getElementById('submitBtnText');
                     if (submitBtnText) {
                         const paymentMethod = document.getElementById('payment_method').value;
                         submitBtnText.textContent = paymentMethod === 'bank' ? 'Hiển thị QR Code' : 'Hoàn tất đơn hàng';
                     }
                 }
             }
         });
     }
    
         // Add click handler for submit button as backup
     if (submitBtn) {
         submitBtn.addEventListener('click', function(e) {
             console.log('Submit button clicked');
         });
     }
 });
 
 // Function to handle payment confirmation
 function confirmPayment() {
     // Close QR modal
     const qrModal = bootstrap.Modal.getInstance(document.getElementById('qrCodeModal'));
     if (qrModal) {
         qrModal.hide();
     }
     
     // Show confirmation dialog
     if (confirm('Bạn đã hoàn tất thanh toán chưa? Chúng tôi sẽ xác nhận đơn hàng sau khi kiểm tra.')) {
         try {
             // Disable button to prevent double submission
             const submitBtn = document.getElementById('submitOrderBtn');
             if (submitBtn) {
                 submitBtn.disabled = true;
                 const submitBtnText = document.getElementById('submitBtnText');
                 if (submitBtnText) {
                     submitBtnText.textContent = 'Đang xử lý...';
                 }
             }
             
             // Submit the form
             console.log('Submitting order with bank transfer...');
             const checkoutForm = document.getElementById('checkoutForm');
             if (checkoutForm) {
                 checkoutForm.submit();
             } else {
                 console.error('Checkout form not found');
                 alert('Có lỗi xảy ra, vui lòng thử lại!');
             }
         } catch (error) {
             console.error('Error submitting form:', error);
             alert('Có lỗi xảy ra khi xử lý đơn hàng: ' + error.message);
         }
     }
 }
</script>
</body>
</html>