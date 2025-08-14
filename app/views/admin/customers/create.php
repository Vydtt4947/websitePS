<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Khách hàng mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Thêm Khách hàng mới</h1>
    <hr>
    <form action="/websitePS/public/customers/store" method="POST">
        <div class="mb-3">
            <label for="maKH" class="form-label">Mã Khách hàng (ví dụ: KH016)</label>
            <input type="text" class="form-control" id="maKH" name="maKH" required>
        </div>
        <div class="mb-3">
            <label for="hoTen" class="form-label">Họ Tên</label>
            <input type="text" class="form-control" id="hoTen" name="hoTen" required>
        </div>
        <div class="mb-3">
            <label for="soDienThoai" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" id="soDienThoai" name="soDienThoai">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="mb-3">
            <label for="ngaySinh" class="form-label">Ngày sinh</label>
            <input type="date" class="form-control" id="ngaySinh" name="ngaySinh">
        </div>
        <div class="mb-3">
            <label for="maPL" class="form-label">Phân loại</label>
            <select class="form-select" id="maPL" name="maPL">
                <?php foreach ($segments as $segment): ?>
                <option value="<?= $segment['MaPL'] ?>"><?= htmlspecialchars($segment['TenPhanLoai']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="/websitePS/public/customers" class="btn btn-secondary">Hủy</a>
    </form>
</div>
</body>
</html>
