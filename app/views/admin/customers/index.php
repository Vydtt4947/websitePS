<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Quản lý Khách hàng</h1>
    <a href="/websitePS/public/customers/create" class="btn btn-primary">
        <i class="fa fa-plus"></i> Thêm khách hàng mới
    </a>
</div>
<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Mã KH</th>
                        <th>Họ Tên</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                        <th>Phân loại</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($customers)): ?>
                        <tr><td colspan="6" class="text-center">Chưa có khách hàng nào.</td></tr>
                    <?php else: ?>
                        <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td><?= htmlspecialchars($customer['MaKH']) ?></td>
                            <td><?= htmlspecialchars($customer['HoTen']) ?></td>
                            <td><?= htmlspecialchars($customer['SoDienThoai']) ?></td>
                            <td><?= htmlspecialchars($customer['Email']) ?></td>
                            <td><span class="badge bg-info text-dark"><?= htmlspecialchars($customer['TenPhanLoai']) ?></span></td>
                            <td class="text-center">
                                <a href="/websitePS/public/customers/show/<?= $customer['MaKH'] ?>" class="btn btn-sm btn-info" title="Xem chi tiết">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="/websitePS/public/customers/edit/<?= $customer['MaKH'] ?>" class="btn btn-sm btn-warning" title="Sửa">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="/websitePS/public/customers/delete/<?= $customer['MaKH'] ?>" class="btn btn-sm btn-danger" title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa khách hàng này?');">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
