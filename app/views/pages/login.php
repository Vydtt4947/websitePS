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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #009688;
            --secondary-color: #fdf5e6;
            --text-color: #5d4037;
            --heading-font: 'Playfair Display', serif;
            --body-font: 'Roboto', sans-serif;
            --light-bg: #f8f9fa;
            --white: #ffffff;
        }

        body {
            font-family: var(--body-font);
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(0, 150, 136, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(0, 121, 107, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 50% 10%, rgba(0, 150, 136, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 10% 60%, rgba(0, 121, 107, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 90% 40%, rgba(0, 150, 136, 0.08) 0%, transparent 50%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Floating Shapes */
        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .shape {
            position: absolute;
            opacity: 0.1;
            animation: float-shape 15s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            background: var(--primary-color);
            border-radius: 50%;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 60px;
            height: 60px;
            background: var(--primary-color);
            border-radius: 20px;
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }

        .shape:nth-child(3) {
            width: 100px;
            height: 100px;
            background: var(--primary-color);
            border-radius: 50% 20% 50% 20%;
            top: 80%;
            left: 20%;
            animation-delay: 4s;
        }

        .shape:nth-child(4) {
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            border-radius: 10px;
            top: 30%;
            right: 30%;
            animation-delay: 6s;
        }

        .shape:nth-child(5) {
            width: 70px;
            height: 70px;
            background: var(--primary-color);
            border-radius: 50%;
            top: 70%;
            left: 70%;
            animation-delay: 8s;
        }

        @keyframes float-shape {
            0%, 100% {
                transform: translateY(0px) rotate(0deg) scale(1);
                opacity: 0.1;
            }
            25% {
                transform: translateY(-30px) rotate(90deg) scale(1.1);
                opacity: 0.2;
            }
            50% {
                transform: translateY(-15px) rotate(180deg) scale(0.9);
                opacity: 0.15;
            }
            75% {
                transform: translateY(-25px) rotate(270deg) scale(1.05);
                opacity: 0.18;
            }
        }

        /* Animated Background Pattern */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23009688' fill-opacity='0.03'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"),
                url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23009688' fill-opacity='0.02'%3E%3Cpath d='M20 20c0 11.046-8.954 20-20 20s-20-8.954-20-20 8.954-20 20-20 20 8.954 20 20z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
            z-index: -1;
            animation: pattern-move 30s linear infinite;
        }

        @keyframes pattern-move {
            0% {
                background-position: 0 0, 0 0;
            }
            100% {
                background-position: 60px 60px, 40px 40px;
            }
        }

        /* Gradient Overlay */
        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(0, 150, 136, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(0, 121, 107, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(0, 150, 136, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 60% 60%, rgba(0, 121, 107, 0.12) 0%, transparent 50%),
                radial-gradient(circle at 10% 30%, rgba(0, 150, 136, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 90% 70%, rgba(0, 121, 107, 0.1) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
            animation: gradient-shift 25s ease-in-out infinite;
        }

        @keyframes gradient-shift {
            0%, 100% {
                opacity: 1;
                transform: scale(1) rotate(0deg);
            }
            33% {
                opacity: 0.8;
                transform: scale(1.1) rotate(1deg);
            }
            66% {
                opacity: 0.9;
                transform: scale(0.95) rotate(-1deg);
            }
        }

        /* Particle Effect */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: var(--primary-color);
            border-radius: 50%;
            opacity: 0.3;
            animation: particle-float 20s linear infinite;
        }

        .particle:nth-child(1) { left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { left: 20%; animation-delay: 2s; }
        .particle:nth-child(3) { left: 30%; animation-delay: 4s; }
        .particle:nth-child(4) { left: 40%; animation-delay: 6s; }
        .particle:nth-child(5) { left: 50%; animation-delay: 8s; }
        .particle:nth-child(6) { left: 60%; animation-delay: 10s; }
        .particle:nth-child(7) { left: 70%; animation-delay: 12s; }
        .particle:nth-child(8) { left: 80%; animation-delay: 14s; }
        .particle:nth-child(9) { left: 90%; animation-delay: 16s; }
        .particle:nth-child(10) { left: 95%; animation-delay: 18s; }

        @keyframes particle-float {
            0% {
                top: 100%;
                opacity: 0;
                transform: translateY(0) scale(0);
            }
            10% {
                opacity: 0.3;
                transform: translateY(-10px) scale(1);
            }
            90% {
                opacity: 0.3;
                transform: translateY(-90vh) scale(1);
            }
            100% {
                top: -10px;
                opacity: 0;
                transform: translateY(-100vh) scale(0);
            }
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            width: 100%;
            max-width: 800px;
            display: flex;
            min-height: 550px;
        }

        .login-image {
            flex: 0.8;
            background: var(--primary-color);
            background-image: url('https://images.unsplash.com/photo-1578985545062-69928b1d9587?q=80&w=1000&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .login-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0, 150, 136, 0.8) 0%, rgba(0, 121, 107, 0.9) 100%);
        }

        .login-image-content {
            text-align: center;
            color: white;
            z-index: 1;
            position: relative;
        }

        .login-image-content h2 {
            font-family: var(--heading-font);
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .login-image-content p {
            font-family: var(--body-font);
            font-size: 1rem;
            opacity: 0.9;
            max-width: 250px;
            margin: 0 auto;
        }

        .login-form {
            flex: 1.2;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .form-header h1 {
            font-family: var(--heading-font);
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }

        .form-header p {
            font-family: var(--body-font);
            color: #666;
            font-size: 0.9rem;
        }

        .form-group {
            margin-bottom: 1rem;
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 0.75rem 0.75rem 2.5rem;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            font-family: var(--body-font);
            font-size: 0.9rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            background: white;
            box-shadow: 0 0 0 4px rgba(0, 150, 136, 0.1);
            transform: translateY(-1px);
        }

        .form-control:hover {
            border-color: #c1c7cd;
            background: #f0f2f5;
        }

        .form-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 1rem;
            transition: color 0.3s ease;
        }

        .form-control:focus + .form-icon {
            color: var(--primary-color);
        }

        .btn-login {
            width: 100%;
            padding: 0.75rem;
            background: var(--primary-color);
            border: none;
            border-radius: 10px;
            color: white;
            font-family: var(--body-font);
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 0.75rem;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 150, 136, 0.3);
            background: #00796b;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .form-footer {
            text-align: center;
            margin-top: 1.5rem;
        }

        .form-footer p {
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .form-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .form-footer a:hover {
            color: #00796b;
            text-decoration: underline;
        }

        .divider {
            text-align: center;
            margin: 1.5rem 0;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e1e5e9;
            z-index: 1;
        }

        .divider span {
            background: white;
            padding: 0 1.5rem;
            color: #666;
            font-size: 0.9rem;
            position: relative;
            z-index: 2;
            font-weight: 500;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .alert-danger {
            background: #fee;
            color: #c53030;
        }

        .alert-success {
            background: #f0fff4;
            color: #2f855a;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            color: #666;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: var(--primary-color);
            transform: translateX(-3px);
        }

        .back-link i {
            margin-right: 0.5rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                max-width: 100%;
                min-height: auto;
            }

            .login-image {
                display: none;
            }

            .login-form {
                padding: 1.5rem;
            }

            .form-header h1 {
                font-size: 1.5rem;
            }

            .form-control {
                padding: 0.75rem 0.75rem 0.75rem 2.5rem;
            }

            .form-icon {
                left: 0.75rem;
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            .login-form {
                padding: 1rem;
            }

            .form-header h1 {
                font-size: 1.25rem;
            }

            .btn-login {
                padding: 0.75rem;
                font-size: 0.9rem;
            }
        }

        /* Animation */
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

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>
</head>
<body>
    <!-- Background Effects -->
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    
    <div class="particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>
    
    <div class="login-container fade-in-up">
        <div class="login-image">
            <div class="login-image-content">
                <h2>🦜 Parrot Smell</h2>
                <p>Chào mừng bạn trở lại! Hãy đăng nhập để tiếp tục trải nghiệm mua sắm tuyệt vời.</p>
            </div>
        </div>
        
        <div class="login-form">
            <div class="form-header">
                <h1>Đăng nhập</h1>
                <p>Nhập thông tin tài khoản của bạn</p>
            </div>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?= $error ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?= $_SESSION['error_message'] ?>
                </div>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= $_SESSION['success_message'] ?>
                </div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>
            
            <form action="/websitePS/public/customerauth/authenticate" method="POST">
                <div class="form-group">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email của bạn" required>
                    <i class="fas fa-envelope form-icon"></i>
                </div>
                
                <div class="form-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required>
                    <i class="fas fa-lock form-icon"></i>
                </div>
                
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    Đăng nhập
                </button>
            </form>
            
            <div class="divider">
                <span>hoặc</span>
            </div>
            
            <div class="form-footer">
                <p>Chưa có tài khoản? 
                    <a href="/websitePS/public/customerauth/register">Tạo tài khoản mới</a>
                </p>
                <p class="mt-3">
                    <a href="/websitePS/public/" class="back-link">
                        <i class="fas fa-arrow-left"></i>
                        Quay về trang chủ
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>