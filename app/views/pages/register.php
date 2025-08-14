<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản - Parrot Smell</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/websitePS/assets/css/style.css">
    <style>
        .auth-page {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary-color) 0%, #00796b 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }
        
        .auth-container {
            max-width: 500px;
            width: 100%;
            margin: 0 auto;
        }
        
        .auth-card {
            background-color: var(--white);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 3rem;
            animation: fadeIn 0.6s ease-out;
        }
        
        .auth-brand {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .auth-title {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--text-color);
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
        
        .form-floating label {
            color: #6c757d;
        }
        
        .btn-register {
            width: 100%;
            padding: 12px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 1.1rem;
            margin-top: 1rem;
        }
        
        .auth-footer {
            text-align: center;
            margin-top: 2rem;
            color: var(--text-color);
        }
        
        .auth-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }
        
        .auth-footer a:hover {
            text-decoration: underline;
        }
        
        .divider {
            text-align: center;
            margin: 2rem 0;
            position: relative;
        }
        
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background-color: #e9ecef;
        }
        
        .divider span {
            background-color: var(--white);
            padding: 0 1rem;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .password-requirements {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
<div class="auth-page">
    <div class="auth-container">
        <div class="auth-card fade-in">
            <div class="auth-brand">
                <a href="/websitePS/public/" class="auth-brand">🦜 Parrot Smell</a>
            </div>
            
            <h2 class="auth-title">Tạo tài khoản mới</h2>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger fade-in">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?= $error ?>
                </div>
            <?php endif; ?>
            
            <form action="/websitePS/public/customerauth/store" method="POST">
                <div class="form-floating">
                    <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Họ và Tên" required>
                    <label for="fullname">Họ và Tên</label>
                </div>
                
                <div class="form-floating">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                    <label for="email">Email</label>
                </div>
                
                <div class="form-floating">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required>
                    <label for="password">Mật khẩu</label>
                </div>
                
                <div class="password-requirements">
                    <i class="fas fa-info-circle me-1"></i>
                    Mật khẩu phải có ít nhất 6 ký tự
                </div>
                
                <button type="submit" class="btn btn-primary-custom btn-register">
                    <i class="fas fa-user-plus me-2"></i>
                    Đăng ký
                </button>
            </form>
            
            <div class="divider">
                <span>hoặc</span>
            </div>
            
            <div class="auth-footer">
                <p>Đã có tài khoản? 
                    <a href="/websitePS/public/customerauth/login">Đăng nhập ngay</a>
                </p>
                <p class="mt-2">
                    <a href="/websitePS/public/">
                        <i class="fas fa-arrow-left me-1"></i>
                        Quay về trang chủ
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
