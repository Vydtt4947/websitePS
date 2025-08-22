<?php
// File: app/views/admin/promotions/index.php
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Danh sách Khuyến mãi</h2>
    <a href="/websitePS/public/promotions/create" class="btn btn-primary"><i class="fa fa-plus"></i> Thêm mới</a>
</div>
<form class="row g-2 mb-3" method="get" action="/websitePS/public/promotions">
    <input type="hidden" name="controller" value="promotions"><!-- fallback không rewrite -->
    <div class="col-auto">
        <input type="hidden" name="controller" value="promotions">
        <input type="text" name="search" value="<?= htmlspecialchars($searchTerm) ?>" class="form-control" placeholder="Tìm tên / mô tả">
    </div>
    <div class="col-auto">
        <select name="perPage" class="form-select" onchange="this.form.submit()">
            <?php foreach ([5,10,20,50] as $n): ?>
                <option value="<?= $n ?>" <?= $perPage == $n ? 'selected' : '' ?>><?= $n ?>/trang</option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-auto">
        <button class="btn btn-secondary" type="submit"><i class="fa fa-search"></i> Tìm</button>
    </div>
</form>
<div class="table-responsive">
<table class="table table-bordered table-hover align-middle">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Tên KM</th>
            <th>Mô tả</th>
            <th>% Giảm</th>
            <th>Số tiền giảm</th>
            <th>Ngày bắt đầu</th>
            <th>Ngày kết thúc</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
    <?php if (empty($promotions)): ?>
        <tr><td colspan="8" class="text-center text-muted">Không có khuyến mãi</td></tr>
    <?php else: foreach ($promotions as $km): ?>
        <tr>
            <td><?= (int)$km['MaKM'] ?></td>
            <td><strong><?= htmlspecialchars($km['TenKM']) ?></strong></td>
            <td style="max-width:250px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="<?= htmlspecialchars($km['MoTa']) ?>"><?= htmlspecialchars($km['MoTa']) ?></td>
            <td><?= $km['PhanTramGiamGia'] !== null ? rtrim(rtrim($km['PhanTramGiamGia'],'0'),'.').'%' : '-' ?></td>
            <td><?= $km['SoTienGiamGia'] !== null ? number_format($km['SoTienGiamGia'],0,',','.') . 'đ' : '-' ?></td>
            <td><?= htmlspecialchars($km['NgayBatDau']) ?></td>
            <td><?= htmlspecialchars($km['NgayKetThuc']) ?></td>
            <td>
                <a class="btn btn-sm btn-warning" href="/websitePS/public/promotions/edit/<?= (int)$km['MaKM'] ?>"><i class="fa fa-edit"></i></a>
                <a class="btn btn-sm btn-danger" href="/websitePS/public/promotions/delete/<?= (int)$km['MaKM'] ?>" onclick="return confirm('Xóa khuyến mãi này?')"><i class="fa fa-trash"></i></a>
                <a class="btn btn-sm btn-info" href="/websitePS/public/promotions/show/<?= (int)$km['MaKM'] ?>"><i class="fa fa-eye"></i></a>
            </td>
        </tr>
    <?php endforeach; endif; ?>
    </tbody>
</table>
</div>
<?php if ($totalPages > 1): ?>
<nav><ul class="pagination">
    <?php for ($p=1; $p <= $totalPages; $p++): ?>
        <li class="page-item <?= $p == $currentPage ? 'active' : '' ?>">
            <a class="page-link" href="/websitePS/public/promotions?page=<?= $p ?>&perPage=<?= $perPage ?>&search=<?= urlencode($searchTerm) ?>"><?= $p ?></a>
        </li>
    <?php endfor; ?>
</ul></nav>
<?php endif; ?>
<p class="text-muted small">Tổng: <?= $total ?> khuyến mãi.</p>
