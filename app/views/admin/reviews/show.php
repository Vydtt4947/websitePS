<?php
// File: app/views/admin/reviews/show.php
?>
<h1 class="mb-4">Chi tiết Đánh giá #<?= htmlspecialchars($review['MaDG']) ?></h1>
<a href="/websitePS/public/reviews" class="btn btn-sm btn-secondary mb-3"><i class="fa fa-arrow-left"></i> Quay lại</a>
<div class="card mb-4">
  <div class="card-body">
    <div class="row mb-2">
      <div class="col-md-3 text-muted">Sản phẩm:</div>
      <div class="col-md-9"><strong><?= htmlspecialchars($review['TenSanPham'] ?? ('SP#'.$review['MaSP'])) ?></strong> (Mã: <?= (int)$review['MaSP'] ?>)</div>
    </div>
    <div class="row mb-2">
      <div class="col-md-3 text-muted">Khách hàng:</div>
      <div class="col-md-9"><?= htmlspecialchars($review['TenKhachHang'] ?? 'Ẩn danh') ?> (Mã KH: <?= (int)$review['MaKH'] ?>)</div>
    </div>
    <div class="row mb-2">
      <div class="col-md-3 text-muted">Số sao:</div>
      <div class="col-md-9"><span class="badge bg-warning text-dark fs-6"><?= (int)$review['SoSao'] ?> ★</span></div>
    </div>
    <div class="row mb-2">
      <div class="col-md-3 text-muted">Xác thực mua hàng:</div>
      <div class="col-md-9"><?= $review['MaDH']?'<span class="badge bg-success">Có (ĐH #'.(int)$review['MaDH'].')</span>':'<span class="badge bg-secondary">Không</span>' ?></div>
    </div>
    <div class="row mb-2">
      <div class="col-md-3 text-muted">Ngày đánh giá:</div>
      <div class="col-md-9"><?= htmlspecialchars($review['NgayDanhGia']) ?></div>
    </div>
    <div class="row mb-2">
      <div class="col-md-3 text-muted">Nội dung:</div>
      <div class="col-md-9"><div class="border rounded p-3 bg-light"><?= nl2br(htmlspecialchars($review['NoiDung'])) ?></div></div>
    </div>
  </div>
</div>
<?php if(($_SESSION['role']??'')==='admin'): ?>
<form action="/websitePS/public/reviews/delete/<?= (int)$review['MaDG'] ?>" method="post" onsubmit="return confirm('Bạn chắc chắn muốn xóa đánh giá này?');">
  <button class="btn btn-danger"><i class="fa fa-trash"></i> Xóa đánh giá</button>
</form>
<?php endif; ?>
