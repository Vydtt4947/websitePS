<div class="d-flex justify-content-between align-items-center mb-4">
  <h1>Quản lý Kho</h1>
</div>

<div class="row g-3 mb-4">
  <div class="col-md-3">
    <div class="card shadow-sm h-100">
      <div class="card-body">
        <h6 class="text-muted mb-1">Tổng sản phẩm</h6>
        <div class="fs-4 fw-bold"><?= (int)($summary['products']['count'] ?? 0) ?></div>
        <div class="small text-muted">SL tồn: <?= (int)($summary['products']['quantity'] ?? 0) ?></div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card shadow-sm h-100">
      <div class="card-body">
        <h6 class="text-muted mb-1">Tổng nguyên liệu</h6>
        <div class="fs-4 fw-bold"><?= (int)($summary['ingredients']['count'] ?? 0) ?></div>
        <div class="small text-muted">SL tồn: <?= (int)($summary['ingredients']['quantity'] ?? 0) ?></div>
      </div>
    </div>
  </div>
</div>

<div class="row g-3 mb-4">
  <div class="col-lg-6">
    <div class="card shadow-sm h-100">
      <div class="card-header bg-light">Nhập/Xuất kho Sản phẩm</div>
      <div class="card-body">
        <form class="row g-2" method="POST" action="/websitePS/public/warehouses/importProduct">
          <div class="col-5 col-md-5">
            <select name="productId" class="form-select" required>
              <option value="" hidden>Chọn sản phẩm...</option>
              <?php foreach(($allProducts ?? []) as $p): ?>
                <option value="<?= (int)$p['MaSP'] ?>">[<?= (int)$p['MaSP'] ?>] <?= htmlspecialchars($p['TenSP']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-5 col-md-4">
            <input type="number" min="1" class="form-control" name="quantity" placeholder="Số lượng" required>
          </div>
          <div class="col-2 col-md-3 d-grid">
            <button class="btn btn-success" type="submit"><i class="fa fa-arrow-down"></i> Nhập</button>
          </div>
        </form>
        <hr>
        <form class="row g-2" method="POST" action="/websitePS/public/warehouses/exportProduct">
          <div class="col-5 col-md-5">
            <select name="productId" class="form-select" required>
              <option value="" hidden>Chọn sản phẩm...</option>
              <?php foreach(($allProducts ?? []) as $p): ?>
                <option value="<?= (int)$p['MaSP'] ?>">[<?= (int)$p['MaSP'] ?>] <?= htmlspecialchars($p['TenSP']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-5 col-md-4">
            <input type="number" min="1" class="form-control" name="quantity" placeholder="Số lượng" required>
          </div>
          <div class="col-2 col-md-3 d-grid">
            <button class="btn btn-danger" type="submit"><i class="fa fa-arrow-up"></i> Xuất</button>
          </div>
        </form>
        <div class="mt-3">
          <a class="btn btn-outline-primary btn-sm" href="/websitePS/public/warehouses/products"><i class="fa fa-list"></i> Xem danh sách tồn SP</a>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card shadow-sm h-100">
      <div class="card-header bg-light">Nhập/Xuất kho Nguyên liệu</div>
      <div class="card-body">
        <form class="row g-2" method="POST" action="/websitePS/public/warehouses/importIngredient">
          <div class="col-5 col-md-5">
            <select name="ingredientId" class="form-select" required>
              <option value="" hidden>Chọn nguyên liệu...</option>
              <?php foreach(($allIngredients ?? []) as $ing): ?>
                <option value="<?= (int)$ing['MaNL'] ?>">[<?= (int)$ing['MaNL'] ?>] <?= htmlspecialchars($ing['TenNL']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-5 col-md-4">
            <input type="number" min="1" class="form-control" name="quantity" placeholder="Số lượng" required>
          </div>
          <div class="col-2 col-md-3 d-grid">
            <button class="btn btn-success" type="submit"><i class="fa fa-arrow-down"></i> Nhập</button>
          </div>
        </form>
        <hr>
        <form class="row g-2" method="POST" action="/websitePS/public/warehouses/exportIngredient">
          <div class="col-5 col-md-5">
            <select name="ingredientId" class="form-select" required>
              <option value="" hidden>Chọn nguyên liệu...</option>
              <?php foreach(($allIngredients ?? []) as $ing): ?>
                <option value="<?= (int)$ing['MaNL'] ?>">[<?= (int)$ing['MaNL'] ?>] <?= htmlspecialchars($ing['TenNL']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-5 col-md-4">
            <input type="number" min="1" class="form-control" name="quantity" placeholder="Số lượng" required>
          </div>
          <div class="col-2 col-md-3 d-grid">
            <button class="btn btn-danger" type="submit"><i class="fa fa-arrow-up"></i> Xuất</button>
          </div>
        </form>
        <div class="mt-3">
          <a class="btn btn-outline-primary btn-sm" href="/websitePS/public/warehouses/ingredients"><i class="fa fa-list"></i> Xem danh sách tồn NL</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row g-3 mb-4">
  <div class="col-lg-6">
    <div class="card shadow-sm h-100">
      <div class="card-header bg-warning-subtle">Sản phẩm sắp hết</div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-sm table-hover mb-0">
            <thead><tr><th>ID</th><th>Tên</th><th>SL</th></tr></thead>
            <tbody>
            <?php if (!empty($lowProducts)): foreach ($lowProducts as $p): ?>
              <tr><td><?= (int)$p['MaSP'] ?></td><td><?= htmlspecialchars($p['TenSP']) ?></td><td><?= (int)$p['SoLuong'] ?></td></tr>
            <?php endforeach; else: ?>
              <tr><td colspan="3" class="text-center text-muted">Không có mục nào</td></tr>
            <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card shadow-sm h-100">
      <div class="card-header bg-warning-subtle">Nguyên liệu sắp hết</div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-sm table-hover mb-0">
            <thead><tr><th>ID</th><th>Tên</th><th>SL</th></tr></thead>
            <tbody>
            <?php if (!empty($lowIngredients)): foreach ($lowIngredients as $i): ?>
              <tr><td><?= (int)$i['MaNL'] ?></td><td><?= htmlspecialchars($i['TenNL']) ?></td><td><?= (int)$i['SoLuong'] ?></td></tr>
            <?php endforeach; else: ?>
              <tr><td colspan="3" class="text-center text-muted">Không có mục nào</td></tr>
            <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card shadow-sm">
  <div class="card-header bg-light">Nhật ký giao dịch kho</div>
  <div class="card-body">
    <form class="row g-2 mb-3" method="GET" action="/websitePS/public/warehouses">
      <div class="col-6 col-md-2">
        <select name="type" class="form-select">
          <option value="">Loại GD</option>
          <option value="Nhap" <?= ($filters['type'] ?? '')==='Nhap' ? 'selected' : '' ?>>Nhập</option>
          <option value="Xuat" <?= ($filters['type'] ?? '')==='Xuat' ? 'selected' : '' ?>>Xuất</option>
        </select>
      </div>
      <div class="col-6 col-md-2">
        <input class="form-control" type="number" name="productId" value="<?= htmlspecialchars((string)($filters['productId'] ?? '')) ?>" placeholder="ID SP">
      </div>
      <div class="col-6 col-md-2">
        <input class="form-control" type="number" name="ingredientId" value="<?= htmlspecialchars((string)($filters['ingredientId'] ?? '')) ?>" placeholder="ID NL">
      </div>
      <div class="col-6 col-md-2">
        <input class="form-control" type="date" name="from" value="<?= htmlspecialchars($filters['from'] ?? '') ?>">
      </div>
      <div class="col-6 col-md-2">
        <input class="form-control" type="date" name="to" value="<?= htmlspecialchars($filters['to'] ?? '') ?>">
      </div>
      <div class="col-6 col-md-2 d-grid">
        <button class="btn btn-primary" type="submit"><i class="fa fa-filter"></i> Lọc</button>
      </div>
    </form>

    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Ngày</th>
            <th>Loại</th>
            <th>SP</th>
            <th>NL</th>
            <th>Số lượng</th>
            <th>Nhân viên</th>
          </tr>
        </thead>
        <tbody>
        <?php if (!empty($transactions)): foreach ($transactions as $row): ?>
          <tr>
            <td><?= (int)($row['MaKho'] ?? 0) ?></td>
            <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($row['NgayGiaoDich'] ?? 'now'))) ?></td>
            <td><span class="badge bg-<?= ($row['LoaiGiaoDich'] ?? '')==='Nhap' ? 'success' : 'danger' ?>"><?= htmlspecialchars($row['LoaiGiaoDich'] ?? '') ?></span></td>
            <td><?= !empty($row['MaSP']) ? ('#'.$row['MaSP'].' - '.htmlspecialchars($row['TenSP'] ?? '')) : '' ?></td>
            <td><?= !empty($row['MaNL']) ? ('#'.$row['MaNL'].' - '.htmlspecialchars($row['TenNL'] ?? '')) : '' ?></td>
            <td><?= (int)($row['SoLuong'] ?? 0) ?></td>
            <td><?= htmlspecialchars($row['TenNV'] ?? '-') ?></td>
          </tr>
        <?php endforeach; else: ?>
          <tr><td colspan="7" class="text-center text-muted">Không có giao dịch</td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>

    <?php
      $totalPages = isset($total, $perPage) && $perPage > 0 ? (int)ceil($total / $perPage) : 1;
      $currentPage = (int)($currentPage ?? 1);
      if ($totalPages < 1) $totalPages = 1;
    ?>
    <?php if ($totalPages > 1): ?>
      <nav>
        <ul class="pagination justify-content-center">
          <?php for ($i=1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= $i===$currentPage ? 'active' : '' ?>">
              <a class="page-link" href="/websitePS/public/warehouses?page=<?= $i ?>&type=<?= urlencode($filters['type'] ?? '') ?>&productId=<?= urlencode((string)($filters['productId'] ?? '')) ?>&ingredientId=<?= urlencode((string)($filters['ingredientId'] ?? '')) ?>&from=<?= urlencode($filters['from'] ?? '') ?>&to=<?= urlencode($filters['to'] ?? '') ?>"><?= $i ?></a>
            </li>
          <?php endfor; ?>
        </ul>
      </nav>
    <?php endif; ?>
  </div>
</div>