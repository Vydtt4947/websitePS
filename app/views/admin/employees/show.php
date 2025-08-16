<?php
// Biến mong đợi: $nv (bản ghi nhân viên từ EmployeeModel->find)
if (!$nv) { echo '<div class="container my-4">Không tìm thấy nhân viên.</div>'; return; }
$fmtDate = function($d){ return $d ? date('Y-m-d', strtotime($d)) : ''; };
?>
<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Chi tiết Nhân viên #<?= (int)$nv['MaNV'] ?></h2>
    <div>
      <a class="btn btn-outline-secondary me-2" href="/websitePS/public/employees">Danh sách</a>
      <a class="btn btn-warning" href="/websitePS/public/employees/edit/<?= (int)$nv['MaNV'] ?>">Sửa</a>
    </div>
  </div>

  <div class="row g-3">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">Thông tin cá nhân</div>
        <div class="card-body">
          <p><strong>Họ tên:</strong> <?= htmlspecialchars($nv['HoTen'] ?? '') ?></p>
          <p><strong>Email:</strong> <?= htmlspecialchars($nv['Email'] ?? '') ?></p>
          <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($nv['SoDienThoai'] ?? '') ?></p>
          <p><strong>CCCD:</strong> <?= htmlspecialchars($nv['CCCD'] ?? '') ?></p>
          <p><strong>Ngày sinh:</strong> <?= htmlspecialchars($fmtDate($nv['NgaySinh'] ?? null)) ?></p>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card">
        <div class="card-header">Tài khoản liên kết</div>
        <div class="card-body">
          <p><strong>user_id:</strong> <?= htmlspecialchars($nv['user_id'] ?? '') ?></p>
          <p><strong>Username:</strong> <?= htmlspecialchars($nv['username'] ?? '') ?></p>
          <p><strong>Role:</strong> <span class="badge bg-secondary"><?= htmlspecialchars($nv['role'] ?? 'staff') ?></span></p>
          <p><strong>Ngày tạo:</strong> <?= htmlspecialchars($fmtDate($nv['created_at'] ?? null)) ?></p>
        </div>
      </div>
    </div>
  </div>
</div>
