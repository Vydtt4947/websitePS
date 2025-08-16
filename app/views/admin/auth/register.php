<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Đăng ký') ?> - Trang Quản trị</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { display: flex; align-items: center; justify-content: center; height: 100vh; background-color: #f8f9fa; }
        .register-form { width: 100%; max-width: 450px; padding: 15px; }
    </style>
</head>
<body>
<?php
$base     = rtrim(str_replace('\\','/', dirname($_SERVER['PHP_SELF'])), '/');
$postUrl  = $base . '/admin.php?controller=auth&action=handleRegister';
$loginUrl = $base . '/admin.php?controller=auth';
?>
<main class="form-signin text-center register-form">
    <form action="<?= htmlspecialchars($postUrl) ?>" method="POST">
        <h1 class="h3 mb-3 fw-normal">🦜 Đăng ký tài khoản</h1>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                <?php
                    switch ($_GET['error']) {
                        case 'empty': echo 'Vui lòng điền đầy đủ thông tin.'; break;
                        case 'password_mismatch': echo 'Mật khẩu xác nhận không khớp.'; break;
                        case 'email_exists': echo 'Email này đã được sử dụng.'; break;
                        default: echo 'Đã có lỗi xảy ra. Vui lòng thử lại.'; break;
                    }
                ?>
            </div>
        <?php endif; ?>

        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="hoTen" name="HoTen" placeholder="Họ và Tên" required>
            <label for="hoTen">Họ và Tên</label>
        </div>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="email" name="Email" placeholder="name@example.com" required>
            <label for="email">Địa chỉ Email</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="password" name="MatKhau" placeholder="Mật khẩu" required>
            <label for="password">Mật khẩu</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="passwordConfirm" name="MatKhauXacNhan" placeholder="Xác nhận mật khẩu" required>
            <label for="passwordConfirm">Xác nhận mật khẩu</label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Đăng ký</button>
        <p class="mt-3">
            Đã có tài khoản? <a href="<?= htmlspecialchars($loginUrl) ?>">Đăng nhập ngay</a>
        </p>
    </form>
</main>
</body>
</html>
