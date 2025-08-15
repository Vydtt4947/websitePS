<div class="container mt-3">
    <h3>Sửa thông tin: <?= htmlspecialchars($customer['HoTen']) ?></h3>
    <hr>
    <form action="/websitePS/public/customers/update/<?= $customer['MaKH'] ?>" method="POST">
        <div class="mb-3">
            <label for="hoTen" class="form-label">Họ Tên</label>
            <input type="text" class="form-control" id="hoTen" name="hoTen" value="<?= htmlspecialchars($customer['HoTen']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="soDienThoai" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" id="soDienThoai" name="soDienThoai" value="<?= htmlspecialchars($customer['SoDienThoai']) ?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($customer['Email']) ?>">
        </div>
        <div class="mb-3">
            <label for="ngaySinh" class="form-label">Ngày sinh</label>
            <input type="date" class="form-control" id="ngaySinh" name="ngaySinh" value="<?= htmlspecialchars($customer['NgaySinh']) ?>">
        </div>
        <div class="mb-3">
            <label for="maPK" class="form-label">Phân loại</label>
            <select class="form-select" id="maPK" name="maPK">
                <option value="">Chưa phân loại</option>
                <?php foreach ($segments as $segment): ?>
                <option value="<?= $segment['MaPK'] ?>" <?= ($customer['MaPK'] == $segment['MaPK'] && $customer['MaPK'] !== null) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($segment['TenPK']) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="/websitePS/public/customers" class="btn btn-secondary">Hủy</a>
    </form>
</div>
