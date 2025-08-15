<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Quản lý Đơn hàng</h1>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Mã ĐH</th>
                        <th>Khách hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($orders)): ?>
                        <tr>
                            <td colspan="6" class="text-center">Không có đơn hàng nào.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?= htmlspecialchars($order['MaDH']) ?></td>
                            <td><?= htmlspecialchars($order['TenKhachHang']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($order['NgayDatHang'])) ?></td>
                            <td><?= number_format($order['TongTien'], 0, ',', '.') ?> đ</td>
                            <td>
                                <?php
                                    $statusClass = '';
                                    $statusText = '';
                                    switch ($order['TenTrangThai']) {
                                        case 'Pending': 
                                            $statusClass = 'bg-warning text-dark'; 
                                            $statusText = 'Chờ xử lý';
                                            break;
                                        case 'Processing': 
                                            $statusClass = 'bg-info text-dark'; 
                                            $statusText = 'Đang xử lý';
                                            break;
                                        case 'Shipping': 
                                            $statusClass = 'bg-primary'; 
                                            $statusText = 'Đang giao hàng';
                                            break;
                                        case 'Delivered': 
                                            $statusClass = 'bg-success'; 
                                            $statusText = 'Đã giao hàng';
                                            break;
                                        case 'Cancelled': 
                                            $statusClass = 'bg-danger'; 
                                            $statusText = 'Đã hủy';
                                            break;
                                        default: 
                                            $statusClass = 'bg-secondary'; 
                                            $statusText = $order['TenTrangThai'];
                                    }
                                ?>
                                <span class="badge <?= $statusClass ?>"><?= htmlspecialchars($statusText) ?></span>
                            </td>
                            <td class="text-end">
                                <a href="/websitePS/public/orders/show/<?= $order['MaDH'] ?>" class="btn btn-sm btn-info">
                                    <i class="fa fa-eye"></i> Xem chi tiết
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
