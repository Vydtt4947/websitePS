<?php
// app/views/admin/user/create.php
?>
<div class="container">
    <h1 class="mb-4">Thêm Người dùng</h1>

    <form method="post" action="/websitePS/public/user/store" class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Mật khẩu</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Vai trò</label>
            <select name="role" class="form-select">
                <?php foreach (($roles ?? ['admin','staff','member']) as $r): ?>
                    <option value="<?= htmlspecialchars($r) ?>"><?= strtoupper($r) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-12 d-flex gap-2 mt-3">
            <a href="/websitePS/public/user" class="btn btn-outline-secondary">Hủy</a>
            <button type="submit" class="btn btn-primary">Lưu</button>
        </div>
    </form>
</div>
