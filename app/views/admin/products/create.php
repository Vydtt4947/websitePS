<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Thêm Sản phẩm mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
                    <option value="<?= $category['MaDanhMuc'] ?>"><?= htmlspecialchars($category['TenDanhMuc']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
        <a href="/websitePS/public/products" class="btn btn-secondary">Hủy</a>
    </form>
</div>
</body>
</html>