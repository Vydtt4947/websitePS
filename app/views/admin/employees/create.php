<?php
// Mặc định thêm mới vào bảng nhanvien. (Tuỳ dự án, có thể kèm gắn user_id sau.)
$roles = $roles ?? ['admin','staff','member'];
?>
<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Thêm Nhân viên</h2>
    <a class="btn btn-outline-secondary" href="/websitePS/public/employees">Quay lại</a>
  </div>

  <form method="post" action="/websitePS/public/employees/store" class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Họ tên</label>
      <input type="text" name="HoTen" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Email</label>
      <input type="email" name="Email" class="form-control">
    </div>

    <div class="col-md-6">
      <label class="form-label">Số điện thoại</label>
      <input type="text" name="SoDienThoai" class="form-control">
    </div>
    <div class="col-md-6">
      <label class="form-label">CCCD</label>
      <input type="text" name="CCCD" class="form-control">
    </div>

    <div class="col-md-6">
      <label class="form-label">Ngày sinh</label>
      <input type="date" name="NgaySinh" class="form-control">
    </div>

    <div class="col-12 d-flex justify-content-end gap-2">
      <a class="btn btn-light" href="/websitePS/public/employees">Hủy</a>
      <button type="submit" class="btn btn-primary">Lưu</button>
    </div>
  </form>
</div>
