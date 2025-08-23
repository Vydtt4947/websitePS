<?php
// File: app/views/admin/me/index.php
?>
<div class="container-fluid">
  <h2 class="mb-4">Tài khoản của tôi</h2>

  <div class="row g-4">
    <div class="col-lg-6">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white py-2">
          <strong>Thông tin đăng nhập</strong>
        </div>
        <div class="card-body">
          <?php if ($user): ?>
          <form method="post" action="/websitePS/public/me/updateUser" class="row g-3">
            <div class="col-12">
              <label class="form-label">Username</label>
              <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username'] ?? '') ?>" required>
            </div>
            <div class="col-12">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
            </div>
            <?php if (($user['role'] ?? '') === 'admin'): ?>
            <div class="col-12">
              <label class="form-label">Vai trò</label>
              <select name="role" class="form-select">
                <?php foreach (['admin','staff'] as $r): ?>
                  <option value="<?= $r ?>" <?= (($user['role'] ?? '') === $r) ? 'selected' : '' ?>><?= strtoupper($r) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <?php else: ?>
              <input type="hidden" name="role" value="<?= htmlspecialchars($user['role'] ?? '') ?>">
            <?php endif; ?>
            <div class="col-12">
              <label class="form-label">Mật khẩu hiện tại (bắt buộc khi đổi mật khẩu)</label>
              <input type="password" name="current_password" class="form-control" autocomplete="current-password">
            </div>
            <div class="col-12">
              <label class="form-label">Mật khẩu mới (để trống nếu không đổi)</label>
              <input type="password" name="password" class="form-control" autocomplete="new-password">
            </div>
            <div class="col-12">
              <label class="form-label">Xác nhận mật khẩu mới</label>
              <input type="password" name="password_confirm" class="form-control" autocomplete="new-password">
            </div>
            <div class="col-12 small text-muted">
              * Khi muốn đổi mật khẩu: nhập mật khẩu hiện tại, điền mật khẩu mới và xác nhận trùng khớp.
            </div>
            <div class="col-12 d-flex justify-content-end gap-2">
              <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            </div>
          </form>
          <?php else: ?>
            <div class="alert alert-warning">Không tìm thấy thông tin user.</div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white py-2">
          <strong>Hồ sơ nhân viên</strong>
        </div>
        <div class="card-body">
          <?php if ($employee): ?>
          <form method="post" action="/websitePS/public/me/updateProfile" class="row g-3">
            <div class="col-12">
              <label class="form-label">Họ tên</label>
              <input type="text" name="HoTen" class="form-control" value="<?= htmlspecialchars($employee['HoTen'] ?? '') ?>" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input type="email" name="Email" class="form-control" value="<?= htmlspecialchars($employee['Email'] ?? '') ?>" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Số điện thoại</label>
              <input type="text" name="SoDienThoai" class="form-control" value="<?= htmlspecialchars($employee['SoDienThoai'] ?? '') ?>">
            </div>
            <div class="col-md-6">
              <label class="form-label">CCCD</label>
              <input type="text" name="CCCD" class="form-control" value="<?= htmlspecialchars($employee['CCCD'] ?? '') ?>">
            </div>
            <div class="col-md-6">
              <label class="form-label">Ngày sinh</label>
              <input type="date" name="NgaySinh" class="form-control" value="<?= htmlspecialchars($employee['NgaySinh'] ?? '') ?>">
            </div>
            <div class="col-12 d-flex justify-content-end gap-2">
              <button type="submit" class="btn btn-secondary">Cập nhật hồ sơ</button>
            </div>
          </form>
          <?php else: ?>
            <div class="alert alert-info mb-0">Tài khoản chưa liên kết hồ sơ nhân viên.</div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
