<?php
// Biến mong đợi: $nv (bản ghi nhân viên), $roles (mảng roles)
if (!$nv) { echo '<div class="container my-4">Không tìm thấy nhân viên.</div>'; return; }
$roles = $roles ?? ['admin','staff','member'];
$val = fn($k) => htmlspecialchars($nv[$k] ?? '');
$valDate = function($k) use ($nv){ return !empty($nv[$k]) ? date('Y-m-d', strtotime($nv[$k])) : ''; };
?>
<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Sửa Nhân viên #<?= (int)$nv['MaNV'] ?></h2>
    <a class="btn btn-outline-secondary" href="/websitePS/public/employees">Quay lại</a>
  </div>

  <form method="post" action="/websitePS/public/employees/update/<?= (int)$nv['MaNV'] ?>" class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Họ tên</label>
      <input type="text" name="HoTen" class="form-control" value="<?= $val('HoTen') ?>" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Email</label>
      <input type="email" name="Email" class="form-control" value="<?= $val('Email') ?>">
      <div class="form-text">* Sẽ đồng bộ sang bảng users.email nếu có liên kết.</div>
    </div>

    <div class="col-md-6">
      <label class="form-label">Số điện thoại</label>
      <input type="text" name="SoDienThoai" class="form-control" value="<?= $val('SoDienThoai') ?>">
    </div>
    <div class="col-md-6">
      <label class="form-label">CCCD</label>
      <input type="text" name="CCCD" class="form-control" value="<?= $val('CCCD') ?>">
    </div>

    <div class="col-md-6">
      <label class="form-label">Ngày sinh</label>
      <input type="date" name="NgaySinh" class="form-control" value="<?= htmlspecialchars($valDate('NgaySinh')) ?>">
    </div>
    <div class="col-12 d-flex justify-content-end gap-2">
      <a class="btn btn-light" href="/websitePS/public/employees">Hủy</a>
      <button type="submit" class="btn btn-warning">Lưu thay đổi</button>
    </div>
  </form>
</div>
