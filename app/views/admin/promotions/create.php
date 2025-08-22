<?php
// File: app/views/admin/promotions/create.php
?>
<h2>Thêm Khuyến mãi</h2>
<form method="post" action="/websitePS/public/promotions/store">
    <div class="mb-3">
        <label class="form-label">Tên khuyến mãi *</label>
        <input type="text" name="TenKM" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Mô tả</label>
        <textarea name="MoTa" class="form-control" rows="3"></textarea>
    </div>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Phần trăm giảm (%)</label>
            <input type="number" step="0.01" min="0" max="100" name="PhanTramGiamGia" class="form-control" placeholder="VD: 10">
        </div>
        <div class="col-md-6">
            <label class="form-label">Số tiền giảm (VNĐ)</label>
            <input type="number" step="1000" min="0" name="SoTienGiamGia" class="form-control" placeholder="VD: 30000">
        </div>
    </div>
    <p class="text-muted small mt-1">Chỉ nhập một trong hai: phần trăm hoặc số tiền.</p>
    <div class="row g-3 mt-2">
        <div class="col-md-6">
            <label class="form-label">Ngày bắt đầu</label>
            <input type="date" name="NgayBatDau" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Ngày kết thúc</label>
            <input type="date" name="NgayKetThuc" class="form-control">
        </div>
    </div>
    <div class="mt-4">
        <a href="/websitePS/public/promotions" class="btn btn-secondary">Quay lại</a>
        <button class="btn btn-primary" type="submit">Lưu</button>
    </div>
</form>
