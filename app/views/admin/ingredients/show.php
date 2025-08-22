<?php
// View: admin/ingredients/show.php
// Expect variable: $ingredient (array) with keys: MaNL, TenNL, MoTa, DonViTinh, SoLuong
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Chi tiết Nguyên liệu</h3>
  <a href="/websitePS/public/ingredients" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Quay lại</a>
</div>

<?php if (empty($ingredient)): ?>
  <div class="alert alert-danger">Không tìm thấy dữ liệu nguyên liệu.</div>
<?php else: ?>
  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <div class="row mb-3">
        <div class="col-md-6">
          <h5 class="fw-bold mb-1">#<?= (int)$ingredient['MaNL'] ?> - <?= htmlspecialchars($ingredient['TenNL']) ?></h5>
          <p class="text-muted mb-0">Đơn vị tính: <strong><?= htmlspecialchars($ingredient['DonViTinh'] ?? '-') ?></strong></p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
          <span class="badge bg-primary fs-6">Số lượng: <?= number_format((int)($ingredient['SoLuong'] ?? 0)) ?></span>
        </div>
      </div>
      <hr>
      <div class="mb-3">
        <h6 class="text-uppercase small text-muted mb-2">Mô tả</h6>
        <div class="border rounded p-3 bg-light" style="min-height:80px">
          <?= nl2br(htmlspecialchars($ingredient['MoTa'] !== null && $ingredient['MoTa'] !== '' ? $ingredient['MoTa'] : 'Chưa có mô tả.')) ?>
        </div>
      </div>
      <div class="d-flex gap-2">
        <a href="/websitePS/public/ingredients/edit/<?= (int)$ingredient['MaNL'] ?>" class="btn btn-warning"><i class="fa fa-edit"></i> Sửa</a>
        <a href="/websitePS/public/ingredients/delete/<?= (int)$ingredient['MaNL'] ?>" class="btn btn-danger" onclick="return confirm('Xóa nguyên liệu này?');"><i class="fa fa-trash"></i> Xóa</a>
      </div>
    </div>
  </div>
<?php endif; ?>
