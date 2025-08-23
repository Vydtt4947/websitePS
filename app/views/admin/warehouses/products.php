<div class="d-flex justify-content-between align-items-center mb-4">
  <h1>Tồn kho Sản phẩm</h1>
  <a href="/websitePS/public/warehouses" class="btn btn-outline-secondary"><i class="fa fa-arrow-left"></i> Quay lại</a>
</div>

<div class="card shadow-sm mb-3">
  <div class="card-body">
    <form class="row g-2" method="GET" action="/websitePS/public/warehouses/products">
      <div class="col-9 col-md-10">
        <input type="text" name="search" class="form-control" placeholder="Tìm theo tên sản phẩm..." value="<?= htmlspecialchars($search ?? '') ?>">
      </div>
      <div class="col-3 col-md-2 d-grid">
        <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Tìm</button>
      </div>
    </form>
  </div>
</div>

<div class="card shadow-sm">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead><tr><th>ID</th><th>Tên sản phẩm</th><th>Số lượng tồn</th></tr></thead>
        <tbody>
          <?php if (!empty($items)): foreach ($items as $it): ?>
            <tr>
              <td><?= (int)$it['MaSP'] ?></td>
              <td><?= htmlspecialchars($it['TenSP'] ?? '') ?></td>
              <td><?= (int)$it['SoLuong'] ?></td>
            </tr>
          <?php endforeach; else: ?>
            <tr><td colspan="3" class="text-center text-muted">Không có dữ liệu</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <?php
      $totalPages = isset($total, $perPage) && $perPage > 0 ? (int)ceil($total / $perPage) : 1;
      $currentPage = (int)($currentPage ?? 1);
    ?>
    <?php if ($totalPages > 1): ?>
      <nav>
        <ul class="pagination justify-content-center">
          <?php for ($i=1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= $i===$currentPage ? 'active' : '' ?>">
              <a class="page-link" href="/websitePS/public/warehouses/products?page=<?= $i ?>&search=<?= urlencode($search ?? '') ?>"><?= $i ?></a>
            </li>
          <?php endfor; ?>
        </ul>
      </nav>
    <?php endif; ?>
  </div>
</div>