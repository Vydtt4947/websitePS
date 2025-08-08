<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Parrot Smell</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style> 
        body { background-color: #f8f9fa; font-family: 'Roboto', sans-serif; } 
        .auth-container { max-width: 450px; }
        .auth-brand {
            font-family: 'Playfair Display', serif;
            color: #009688 !important;
            font-size: 2.5rem;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="auth-container w-100">
        <div class="text-center mb-4">
            <a href="/websitePS/public/" class="auth-brand">🦜 Parrot Smell</a>
        </div>
        <div class="card p-4 shadow-sm">
            <h2 class="text-center mb-4">Đăng nhập</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="/websitePS/public/customerauth/authenticate" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Tên đăng nhập</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                <p class="text-center mt-3">Chưa có tài khoản? <a href="/websitePS/public/customerauth/register">Tạo tài khoản</a></p>
            </form>
        </div>
    </div>
</div>
</body>
</html>