<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Chi tiết Khách hàng</h3>
    <a href="/websitePS/public/customers" class="btn btn-secondary">Quay lại danh sách</a>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <img src="https://i.pravatar.cc/150?u=<?= htmlspecialchars($customer['MaKH']) ?>" class="rounded-circle mb-3" alt="Avatar">
                <h4 class="card-title"><?= htmlspecialchars($customer['HoTen']) ?></h4>
                <p class="text-muted"><?= htmlspecialchars($customer['MaKH']) ?></p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($customer['Email']) ?></li>
                <li class="list-group-item"><strong>SĐT:</strong> <?= htmlspecialchars($customer['SoDienThoai']) ?></li>
                <li class="list-group-item"><strong>Ngày sinh:</strong> <?= date('d/m/Y', strtotime($customer['NgaySinh'])) ?></li>
            </ul>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                Lịch sử mua hàng
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Mã ĐH</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($orderHistory)): ?>
                                <tr><td colspan="4" class="text-center">Khách hàng này chưa có đơn hàng nào.</td></tr>
                            <?php else: ?>
                                <?php foreach ($orderHistory as $order): ?>
                                <tr>
                                    <td><a href="/websitePS/public/orders/show/<?= $order['MaDH'] ?>">#<?= htmlspecialchars($order['MaDH']) ?></a></td>
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
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
