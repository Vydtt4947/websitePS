<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Thêm Sản phẩm mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Thêm Sản phẩm mới</h1>
    <form action="/websitePS/public/products/store" method="POST">
        <div class="mb-3">
            <label for="tenSP" class="form-label">Tên Sản phẩm</label>
            <input type="text" class="form-control" id="tenSP" name="tenSP" required>
        </div>
        <div class="mb-3">
            <label for="moTa" class="form-label">Mô tả</label>
            <textarea class="form-control" id="moTa" name="moTa" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="donGia" class="form-label">Đơn giá</label>
            <input type="number" step="1000" class="form-control" id="donGia" name="donGia" required>
        </div>
        <div class="mb-3">
            <label for="maDM" class="form-label">Danh mục</label>
            <select class="form-select" id="maDM" name="maDM" required>
                <option value="">-- Chọn danh mục --</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['MaDM'] ?>"><?= htmlspecialchars($category['TenDanhMuc']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="hinhAnh" class="form-label">Hình ảnh sản phẩm</label>
            <input type="url" class="form-control" id="hinhAnh" name="hinhAnh" placeholder="Nhập URL hình ảnh (ví dụ: https://example.com/image.jpg)">
            <div class="form-text">
                <i class="fas fa-info-circle"></i>
                Nhập URL hình ảnh từ internet. Hình ảnh sẽ được hiển thị trên trang khách hàng.
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Xem trước hình ảnh</label>
            <div id="imagePreview" class="border rounded p-3 text-center" style="min-height: 200px; background-color: #f8f9fa;">
                <i class="fas fa-image fa-3x text-muted"></i>
                <p class="text-muted mt-2">Hình ảnh sẽ hiển thị ở đây</p>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
        <a href="/websitePS/public/products" class="btn btn-secondary">Hủy</a>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('hinhAnh');
    const imagePreview = document.getElementById('imagePreview');
    
    imageInput.addEventListener('input', function() {
        const imageUrl = this.value.trim();
        
        if (imageUrl) {
            // Tạo hình ảnh mới để kiểm tra
            const img = new Image();
            img.onload = function() {
                imagePreview.innerHTML = `
                    <img src="${imageUrl}" alt="Xem trước" class="img-fluid" style="max-height: 200px; max-width: 100%;">
                    <p class="text-success mt-2"><i class="fas fa-check-circle"></i> Hình ảnh hợp lệ</p>
                `;
            };
            img.onerror = function() {
                imagePreview.innerHTML = `
                    <i class="fas fa-exclamation-triangle fa-3x text-warning"></i>
                    <p class="text-warning mt-2">Không thể tải hình ảnh. Vui lòng kiểm tra URL.</p>
                `;
            };
            img.src = imageUrl;
        } else {
            imagePreview.innerHTML = `
                <i class="fas fa-image fa-3x text-muted"></i>
                <p class="text-muted mt-2">Hình ảnh sẽ hiển thị ở đây</p>
            `;
        }
    });
});
</script>
</body>
</html>