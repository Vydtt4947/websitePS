<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết Đơn hàng #<?= $orderDetails['info']['MaDH'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <!-- Hiển thị thông báo -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['success_message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['error_message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>
    
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Chi tiết Đơn hàng #<?= htmlspecialchars($orderDetails['info']['MaDH']) ?></h2>
        <a href="/websitePS/public/orders" class="btn btn-secondary">Quay lại danh sách</a>
    </div>
    <hr>
    <div class="row g-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header"><strong>Danh sách sản phẩm</strong></div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-end">Đơn giá</th>
                                <th class="text-end">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($orderDetails['items'] as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['TenSP']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($item['SoLuong']) ?></td>
                                <td class="text-end"><?= number_format($item['DonGia'], 0, ',', '.') ?> đ</td>
                                <td class="text-end"><?= number_format($item['DonGia'] * $item['SoLuong'], 0, ',', '.') ?> đ</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold">
                                <td colspan="3" class="text-end">Tổng cộng:</td>
                                <td class="text-end fs-5"><?= number_format($orderDetails['info']['TongTien'], 0, ',', '.') ?> đ</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header"><strong>Thông tin khách hàng</strong></div>
                <div class="card-body">
                    <p><strong>Họ tên:</strong> <?= htmlspecialchars($orderDetails['info']['HoTen']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($orderDetails['info']['Email']) ?></p>
                    <p><strong>SĐT:</strong> <?= htmlspecialchars($orderDetails['info']['SoDienThoai']) ?></p>
                </div>
            </div>
            <div class="card">
                <div class="card-header"><strong>Trạng thái đơn hàng</strong></div>
                <div class="card-body">
                    <form action="/websitePS/public/orders/update/<?= $orderDetails['info']['MaDH'] ?>" method="POST">
                        <div class="mb-3">
                            <select class="form-select" name="trangThai">
                                <?php foreach($statuses as $status): ?>
                                    <option value="<?= $status['TrangThai'] ?>" <?= ($status['TrangThai'] == $orderDetails['info']['TrangThai']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($status['MoTa']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Cập nhật trạng thái</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
