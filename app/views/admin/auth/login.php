<!DOCTYPE html> 
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($pageTitle ?? 'Đăng nhập') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body{display:flex;align-items:center;justify-content:center;height:100vh;background:#f8f9fa}
        .login-card{width:100%;max-width:420px}
        .brand{font-weight:600;letter-spacing:.3px}
        .small-muted{font-size:.9rem;color:#6c757d}
    </style>
</head>
<body>
<?php
// Bỏ tự tính $base; controller truyền $loginAction. Fallback nếu truy cập sai cách.
if (!isset($loginAction)) {
    $loginAction = '/websitePS/public/admin.php?controller=auth&action=handleLogin';
}
?>
<div class="card login-card shadow-sm">
    <div class="card-body p-4">
        <h3 class="card-title text-center mb-1 brand">Parrot Smell Admin</h3>
        <p class="text-center small-muted mb-4">Đăng nhập dành cho <strong>Admin/Staff</strong></p>

        <?php if (isset($_GET['success']) && $_GET['success']==='registered'): ?>
            <div class="alert alert-success">Tạo tài khoản thành công, vui lòng đăng nhập.</div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <?php if ($_GET['error'] === 'empty'): ?>
                <div class="alert alert-warning">Vui lòng nhập email và mật khẩu.</div>
            <?php else: ?>
                <div class="alert alert-danger">Email hoặc mật khẩu không đúng, hoặc bạn không có quyền truy cập.</div>
            <?php endif; ?>
        <?php endif; ?>

        <form action="<?= htmlspecialchars($loginAction) ?>" method="POST" novalidate>
            <div class="mb-3">
                <label for="email" class="form-label">Email đăng nhập</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="admin@domain.com" required />
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required />
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Đăng nhập</button>
            </div>
           
        </form>
    </div>
</div>
</body>
</html>
