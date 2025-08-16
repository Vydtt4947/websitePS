<?php
// app/views/admin/user/show.php
?>
<div class="container">
    <h1 class="mb-4">Chi tiết Người dùng</h1>

    <?php if (!empty($user)): ?>
    <div class="card mb-3">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-3 fw-semibold">ID</div>
                <div class="col-md-9"><?= (int)($user['user_id'] ?? 0) ?></div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 fw-semibold">Username</div>
                <div class="col-md-9"><?= htmlspecialchars($user['username'] ?? '') ?></div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 fw-semibold">Email</div>
                <div class="col-md-9"><?= htmlspecialchars($user['email'] ?? '') ?></div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 fw-semibold">Role</div>
                <div class="col-md-9"><span class="badge bg-secondary text-uppercase"><?= htmlspecialchars($user['role'] ?? '') ?></span></div>
            </div>
            <?php if (!empty($user['HoTenNV'])): ?>
            <div class="row mb-2">
                <div class="col-md-3 fw-semibold">Nhân viên liên kết</div>
                <div class="col-md-9"><?= htmlspecialchars($user['HoTenNV']) ?></div>
            </div>
            <?php endif; ?>
            <div class="row mb-2">
                <div class="col-md-3 fw-semibold">Ngày tạo</div>
                <div class="col-md-9"><?= htmlspecialchars($user['created_at'] ?? '') ?></div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="d-flex gap-2">
        <a href="/websitePS/public/users" class="btn btn-outline-secondary">Quay lại</a>
        <?php if (!empty($user['user_id'])): ?>
        <a href="/websitePS/public/users/edit/<?= (int)$user['user_id'] ?>" class="btn btn-primary">Sửa</a>
        <?php endif; ?>
    </div>
</div>
