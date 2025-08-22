<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Quản lý Khách hàng</h1>
    <a href="/websitePS/public/customers/create" class="btn btn-primary">
        <i class="fa fa-plus"></i> Thêm khách hàng mới
    </a>
</div>
<div class="card shadow-sm">
    <div class="card-body">
        <?php
        // Helper hiển thị giá trị hoặc fallback khi chưa có thông tin
        $showInfo = function ($val) {
            if ($val === null) return 'Khách hàng chưa cung cấp thông tin';
            $str = is_string($val) ? trim($val) : trim((string)$val);
            return $str !== '' ? htmlspecialchars($str, ENT_QUOTES, 'UTF-8') : 'Khách hàng chưa cung cấp thông tin';
        };
        ?>
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
                            <td><?= $showInfo($customer['HoTen'] ?? null) ?></td>
                            <td><?= $showInfo($customer['SoDienThoai'] ?? null) ?></td>
                            <td><?= $showInfo($customer['Email'] ?? null) ?></td>
                            <td>
                                <?php
                                    $statusClass = '';
                                    $segment = $customer['TenPK'] ?? 'Chưa phân loại';
                                    switch ($segment) {
                                        case 'Bronze': 
                                            $statusClass = 'bg-warning text-dark'; 
                                            break;
                                        case 'Silver': 
                                            $statusClass = 'bg-secondary'; 
                                            break;
                                        case 'Gold': 
                                            $statusClass = 'bg-warning'; 
                                            break;
                                        case 'Chưa phân loại': 
                                            $statusClass = 'bg-light text-dark'; 
                                            break;
                                        default: 
                                            $statusClass = 'bg-info text-dark';
                                    }
                                ?>
                                <span class="badge <?= $statusClass ?>"><?= htmlspecialchars($segment, ENT_QUOTES, 'UTF-8') ?></span>
                            </td>
                            <td class="text-center">
                                <a href="/websitePS/public/customers/show/<?= $customer['MaKH'] ?>" class="btn btn-sm btn-info" title="Xem chi tiết">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="/websitePS/public/customers/edit/<?= $customer['MaKH'] ?>" class="btn btn-sm btn-warning" title="Sửa">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="/websitePS/public/customers/delete/<?= $customer['MaKH'] ?>" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa khách hàng này?');">
                                    <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
