<?php
// View: admin/ingredients/create.php
?>
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="h4 mb-0">Thêm Nguyên liệu</h1>
  <a href="/websitePS/public/ingredients" class="btn btn-outline-secondary"><i class="fa fa-arrow-left"></i> Quay lại</a>
</div>
<div class="card shadow-sm">
  <div class="card-body">
    <form method="post" action="/websitePS/public/ingredients/store" class="row g-3" novalidate>
      <div class="col-md-6">
        <label class="form-label fw-semibold">Tên nguyên liệu <span class="text-danger">*</span></label>
        <input type="text" name="tenNL" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label class="form-label fw-semibold">Đơn vị tính</label>
        <input type="text" name="donViTinh" class="form-control" placeholder="Ví dụ: kg, g, ml, hộp...">
      </div>
      <div class="col-12">
        <label class="form-label fw-semibold">Mô tả</label>
        <textarea name="moTa" rows="3" class="form-control" placeholder="Ghi chú thêm về nguyên liệu"></textarea>
      </div>
      <div class="col-md-4">
        <label class="form-label fw-semibold">Số lượng ban đầu</label>
        <div class="input-group">
          <input type="number" name="soLuong" class="form-control" min="0" step="1" value="0">
          <span class="input-group-text">SL</span>
        </div>
      </div>
      <div class="col-12 d-flex justify-content-end gap-2 mt-3">
        <a href="/websitePS/public/ingredients" class="btn btn-light">Hủy</a>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Lưu</button>
      </div>
    </form>
  </div>
</div>
