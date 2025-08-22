<?php
// File: app/views/admin/promotions/show.php
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Chi tiết Khuyến mãi #<?= (int)$promotion['MaKM'] ?></h3>
    <div class="btn-group">
        <a href="/websitePS/public/promotions" class="btn btn-secondary">Quay lại</a>
        <a href="/websitePS/public/promotions/edit/<?= (int)$promotion['MaKM'] ?>" class="btn btn-warning">Sửa</a>
        <a href="/websitePS/public/promotions/delete/<?= (int)$promotion['MaKM'] ?>" class="btn btn-danger" onclick="return confirm('Xóa khuyến mãi này?')">Xóa</a>
    </div>
</div>
<?php
    $now = date('Y-m-d');
    $start = $promotion['NgayBatDau'] ?: null;
    $end = $promotion['NgayKetThuc'] ?: null;
    $statusLabel = 'Không giới hạn';
    $statusClass = 'bg-secondary';
    if ($start || $end) {
        if ($start && $now < $start) { $statusLabel = 'Sắp diễn ra'; $statusClass = 'bg-info text-dark'; }
        elseif ($end && $now > $end) { $statusLabel = 'Đã kết thúc'; $statusClass = 'bg-danger'; }
        elseif (($start && $now >= $start) && ($end && $now <= $end) || ($start && !$end && $now >= $start) || (!$start && $end && $now <= $end)) { $statusLabel = 'Đang diễn ra'; $statusClass = 'bg-success'; }
    }
    $discountText = '-';
    if (!is_null($promotion['PhanTramGiamGia'])) {
        $discountText = rtrim(rtrim($promotion['PhanTramGiamGia'],'0'),'.').'%';
    } elseif (!is_null($promotion['SoTienGiamGia'])) {
        $discountText = number_format($promotion['SoTienGiamGia'],0,',','.').' đ';
    }
?>
<div class="row g-4">
    <div class="col-md-5">
        <div class="card h-100">
            <div class="card-header"><strong>Thông tin chung</strong></div>
            <div class="card-body">
                <p><strong>Tên khuyến mãi:</strong><br><?= htmlspecialchars($promotion['TenKM']) ?></p>
                <p><strong>Mô tả:</strong><br><?= nl2br(htmlspecialchars($promotion['MoTa'])) ?: '<span class="text-muted">(Không có)</span>' ?></p>
                <p><strong>Loại giảm:</strong> <?= $discountText ?></p>
                <p><strong>Ngày bắt đầu:</strong> <?= $promotion['NgayBatDau'] ? date('d/m/Y', strtotime($promotion['NgayBatDau'])) : '<span class="text-muted">(Không đặt)</span>' ?></p>
                <p><strong>Ngày kết thúc:</strong> <?= $promotion['NgayKetThuc'] ? date('d/m/Y', strtotime($promotion['NgayKetThuc'])) : '<span class="text-muted">(Không đặt)</span>' ?></p>
                <p><strong>Trạng thái hiện tại:</strong> <span class="badge <?= $statusClass ?>"><?= htmlspecialchars($statusLabel) ?></span></p>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Ghi chú / Hướng dẫn</strong>
            </div>
            <div class="card-body">
                <ul class="mb-0 small">
                    <li>Chỉ một trong hai trường Phần trăm giảm hoặc Số tiền giảm được áp dụng.</li>
                    <li>Nếu không đặt ngày bắt đầu / kết thúc thì khuyến mãi có hiệu lực không thời hạn (trừ khi bị xóa / chỉnh sửa).</li>
                    <li>Trạng thái dựa trên thời gian hệ thống hiện tại.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
