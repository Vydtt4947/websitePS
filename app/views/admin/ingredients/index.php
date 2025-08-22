<?php
// View: admin/ingredients/index.php
// Expect vars: $ingredients, $totalIngredients, $perPage, $currentPage, $searchTerm
$perPage = $perPage ?? 10;
$currentPage = $currentPage ?? 1;
$totalIngredients = $totalIngredients ?? 0;
$searchTerm = $searchTerm ?? '';
$totalPages = max(1, (int)ceil($totalIngredients / max(1, $perPage)));
?>
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="h3 mb-0">Quản lý Nguyên liệu</h1>
  <a href="/websitePS/public/ingredients/create" class="btn btn-primary"><i class="fa fa-plus"></i> Thêm nguyên liệu</a>
</div>

<div class="card shadow-sm mb-4">
  <div class="card-body">
    <form method="get" action="/websitePS/public/ingredients" class="row gy-2 gx-2 align-items-center">
      <input type="hidden" name="controller" value="ingredients"><!-- giúp fallback nếu rewrite chưa bật -->
      <div class="col-sm-4">
        <input type="text" name="search" class="form-control" placeholder="Tìm theo tên..." value="<?= htmlspecialchars($searchTerm) ?>">
      </div>
      <div class="col-sm-2">
        <select name="perPage" class="form-select" onchange="this.form.submit()">
          <?php foreach ([5,10,20,50] as $n): ?>
            <option value="<?= $n ?>" <?= ($perPage==$n?'selected':'') ?>><?= $n ?>/trang</option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-sm-2">
        <button type="submit" class="btn btn-outline-secondary w-100"><i class="fa fa-filter"></i> Lọc</button>
      </div>
      <?php if ($searchTerm): ?>
      <div class="col-sm-2">
        <a href="/websitePS/public/ingredients" class="btn btn-outline-danger w-100"><i class="fa fa-times"></i> Xóa lọc</a>
      </div>
      <?php endif; ?>
    </form>
  </div>
</div>

<div class="card shadow-sm">
  <div class="card-body table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th style="width:70px">Mã</th>
          <th style="width:220px">Tên nguyên liệu</th>
          <th>Mô tả</th>
          <th style="width:120px">ĐVT</th>
          <th style="width:120px" class="text-end">Số lượng</th>
          <th style="width:140px" class="text-end">Hành động</th>
        </tr>
      </thead>
      <tbody>
      <?php if (!empty($ingredients)): foreach ($ingredients as $row): ?>
        <tr>
          <td><?= (int)$row['MaNL'] ?></td>
          <td class="fw-semibold"><?= htmlspecialchars($row['TenNL']) ?></td>
          <td style="max-width:300px" class="text-truncate" title="<?= htmlspecialchars($row['MoTa'] ?? '') ?>">
            <?= htmlspecialchars(mb_strimwidth($row['MoTa'] ?? '', 0, 80, strlen($row['MoTa'] ?? '')>80 ? '…' : '')) ?>
          </td>
          <td><?= htmlspecialchars($row['DonViTinh'] ?? '-') ?></td>
          <td class="text-end"><?= number_format((int)($row['SoLuong'] ?? 0)) ?></td>
          <td class="text-end">
            <a href="/websitePS/public/ingredients/show/<?= (int)$row['MaNL'] ?>" class="btn btn-sm btn-info" title="Xem"><i class="fa fa-eye"></i></a>
            <a href="/websitePS/public/ingredients/edit/<?= (int)$row['MaNL'] ?>" class="btn btn-sm btn-warning" title="Sửa"><i class="fa fa-edit"></i></a>
            <a href="/websitePS/public/ingredients/delete/<?= (int)$row['MaNL'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xóa nguyên liệu này?');" title="Xóa"><i class="fa fa-trash"></i></a>
          </td>
        </tr>
      <?php endforeach; else: ?>
        <tr><td colspan="6" class="text-center text-muted py-4">Không có dữ liệu.</td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
  <div class="card-footer bg-white">
    <div class="d-flex justify-content-between small text-muted">
      <span>Tổng: <?= (int)$totalIngredients ?> nguyên liệu</span>
      <?php if ($totalPages > 1): ?>
      <nav>
        <ul class="pagination pagination-sm mb-0">
          <?php for ($p=1; $p<=$totalPages; $p++): ?>
            <li class="page-item <?= $p==$currentPage? 'active' : '' ?>">
              <a class="page-link" href="/websitePS/public/ingredients?page=<?= $p ?>&perPage=<?= (int)$perPage ?>&search=<?= urlencode($searchTerm) ?>"><?= $p ?></a>
            </li>
          <?php endfor; ?>
        </ul>
      </nav>
      <?php endif; ?>
    </div>
  </div>
</div>
