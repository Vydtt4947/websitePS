<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Parrot Smell</title>
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
            max-width: 450px;
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
        
        .btn-login {
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
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .auth-page {
                padding: 0.75rem 0;
            }
            
            .auth-container {
                max-width: 100%;
                padding: 0 0.75rem;
            }
            
            .auth-card {
                padding: 1.5rem 1rem;
                border-radius: 12px;
                margin: 0 0.5rem;
            }
            
            .auth-title {
                font-size: 1.4rem;
                margin-bottom: 1.25rem;
            }
            
            .form-floating .form-control {
                padding: 0.75rem 0.5rem;
                font-size: 16px; /* Prevent zoom on iOS */
            }
            
            .btn-login {
                padding: 8px 20px;
                font-size: 0.9rem;
            }
            
            .auth-footer {
                margin-top: 1.25rem;
            }
            
            .auth-footer p {
                font-size: 0.85rem;
            }
        }
        
        @media (max-width: 480px) {
            .auth-card {
                padding: 1.25rem 0.75rem;
            }
            
            .auth-title {
                font-size: 1.2rem;
            }
            
            .form-floating {
                margin-bottom: 0.75rem;
            }

        }
        
        /* Animation for fadeIn */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in {
            animation: fadeIn 0.6s ease-out;
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
            
            <h2 class="auth-title">Đăng nhập</h2>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger fade-in">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?= $error ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger fade-in">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?= $_SESSION['error_message'] ?>
                </div>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success fade-in">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= $_SESSION['success_message'] ?>
                </div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>
            
            <form action="/websitePS/public/customerauth/authenticate" method="POST">
                <div class="form-floating">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                    <label for="email">Email</label>
                </div>
                
                <div class="form-floating">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required>
                    <label for="password">Mật khẩu</label>
                </div>
                
                <button type="submit" class="btn btn-primary-custom btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    Đăng nhập
                </button>
            </form>
            
            <div class="divider">
                <span>hoặc</span>
            </div>
            
            <div class="auth-footer">
                <p>Chưa có tài khoản? 
                    <a href="/websitePS/public/customerauth/register">Tạo tài khoản mới</a>
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
</html>