<?php
// File: app/views/admin/reviews/index.php
?>
<h1 class="mb-4">Quản lý Đánh giá</h1>
<div class="row g-3 mb-4">
  <div class="col-md-8">
    <form class="card card-body" method="get" action="/websitePS/public/reviews">
      <div class="row g-2 align-items-end">
        <div class="col-md-4">
          <label class="form-label">Tìm kiếm</label>
          <input type="text" name="q" value="<?= htmlspecialchars($filters['q']) ?>" class="form-control" placeholder="Khách hàng / sản phẩm / nội dung">
        </div>
        <div class="col-md-2">
          <label class="form-label">Số sao</label>
          <select name="rating" class="form-select">
            <option value="">Tất cả</option>
            <?php for($i=5;$i>=1;$i--): ?>
              <option value="<?= $i ?>" <?= ($filters['rating']==$i?'selected':'') ?>><?= $i ?> sao</option>
            <?php endfor; ?>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label">Xác thực</label>
          <select name="verified" class="form-select">
            <option value="">Tất cả</option>
            <option value="1" <?= ($filters['verified']==='1'?'selected':'') ?>>Đã mua</option>
            <option value="0" <?= ($filters['verified']==='0'?'selected':'') ?>>Chưa mua</option>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label">Mã SP</label>
          <input type="number" name="product_id" value="<?= htmlspecialchars($filters['product_id']) ?>" class="form-control" placeholder="#SP">
        </div>
        <div class="col-md-2">
          <label class="form-label">/Trang</label>
          <select name="perPage" class="form-select">
            <?php foreach([10,20,50] as $pp): ?>
              <option value="<?= $pp ?>" <?= ($filters['perPage']==$pp?'selected':'') ?>><?= $pp ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-12 text-end mt-2">
          <button class="btn btn-primary"><i class="fa fa-filter"></i> Lọc</button>
          <a href="/websitePS/public/reviews" class="btn btn-secondary">Reset</a>
        </div>
      </div>
    </form>
  </div>
  <div class="col-md-4">
    <div class="card h-100">
      <div class="card-body">
        <h5 class="card-title mb-3">Tổng quan</h5>
        <p class="mb-1"><strong>Tổng đánh giá:</strong> <?= (int)$stats['TongDanhGia'] ?></p>
        <p class="mb-1"><strong>Điểm TB:</strong> <?= number_format((float)$stats['TrungBinh'],2) ?></p>
        <p class="mb-1"><strong>Xác thực:</strong> <?= (int)$stats['DanhGiaXacThuc'] ?> (<?= $stats['TyLeXacThuc'] ?? 0 ?>%)</p>
        <p class="mb-0"><strong>Chưa xác thực:</strong> <?= (int)$stats['DanhGiaChuaXacThuc'] ?> (<?= $stats['TyLeChuaXacThuc'] ?? 0 ?>%)</p>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <span><i class="fa fa-list"></i> Danh sách đánh giá</span>
  </div>
  <div class="table-responsive">
    <table class="table table-striped align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Sản phẩm</th>
          <th>Khách hàng</th>
          <th>Sao</th>
          <th>Xác thực</th>
          <th>Nội dung</th>
          <th>Ngày</th>
          <th class="text-end">Hành động</th>
        </tr>
      </thead>
      <tbody>
      <?php if(empty($reviews)): ?>
        <tr><td colspan="8" class="text-center text-muted">Không có đánh giá.</td></tr>
      <?php else: foreach($reviews as $r): ?>
        <tr>
          <td>#<?= $r['MaDG'] ?></td>
          <td><?= htmlspecialchars($r['TenSanPham'] ?? ('SP#'.$r['MaSP'])) ?></td>
          <td><?= htmlspecialchars($r['TenKhachHang'] ?? 'Ẩn danh') ?></td>
          <td><span class="badge bg-warning text-dark"><?= $r['SoSao'] ?>★</span></td>
          <td><?= $r['IsVerified']?'<span class="badge bg-success">Có</span>':'<span class="badge bg-secondary">Không</span>' ?></td>
          <td><?= htmlspecialchars($r['TomTat']) ?></td>
          <td><?= htmlspecialchars($r['NgayDanhGia']) ?></td>
          <td class="text-end">
            <a class="btn btn-sm btn-outline-primary" href="/websitePS/public/reviews/show/<?= $r['MaDG'] ?>"><i class="fa fa-eye"></i></a>
            <?php if(($_SESSION['role']??'')==='admin'): ?>
            <form action="/websitePS/public/reviews/delete/<?= $r['MaDG'] ?>" method="post" class="d-inline" onsubmit="return confirm('Xóa đánh giá #<?= $r['MaDG'] ?>?');">
              <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
            </form>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php
  $totalPages = max(1, ceil($total / $perPage));
  if ($totalPages > 1):
?>
<nav class="mt-3">
  <ul class="pagination justify-content-end mb-0">
    <?php for($p=1;$p<=$totalPages;$p++):
      $qs = $_GET; $qs['page']=$p; $url='/websitePS/public/reviews?'.http_build_query($qs); ?>
      <li class="page-item <?= ($p==$page?'active':'') ?>"><a class="page-link" href="<?= $url ?>"><?= $p ?></a></li>
    <?php endfor; ?>
  </ul>
</nav>
<?php endif; ?>
