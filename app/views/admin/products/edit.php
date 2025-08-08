<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Sửa Sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Sửa Sản phẩm: <?= htmlspecialchars($product['TenSP']) ?></h1>
    <form action="/websitePS/public/products/update/<?= $product['MaSP'] ?>" method="POST">
        <div class="mb-3">
            <label for="tenSP" class="form-label">Tên Sản phẩm</label>
            <input type="text" class="form-control" id="tenSP" name="tenSP" value="<?= htmlspecialchars($product['TenSP']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="moTa" class="form-label">Mô tả</label>
            <textarea class="form-control" id="moTa" name="moTa" rows="3"><?= htmlspecialchars($product['MoTa']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="donGia" class="form-label">Đơn giá</label>
            <input type="number" step="1000" class="form-control" id="donGia" name="donGia" value="<?= htmlspecialchars($product['DonGia']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="maDM" class="form-label">Danh mục</label>
            <select class="form-select" id="maDM" name="maDM" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['MaDanhMuc'] ?>" <?= ($product['MaDM'] == $category['MaDanhMuc']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['TenDanhMuc']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="/websitePS/public/products" class="btn btn-secondary">Hủy</a>
    </form>
</div>
</body>
</html>