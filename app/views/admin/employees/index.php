<?php
// Biến mong đợi từ controller:
// $staff (mảng nhân viên), $totalStaff (int), $perPage (int), $currentPage (int), $searchTerm (string)
$perPage     = $perPage     ?? 10;
$currentPage = $currentPage ?? 1;
$totalEmployee  = $totalEmployee ?? 0;
$searchTerm  = $searchTerm  ?? '';
$totalPages  = max(1, (int)ceil($totalEmployee / max(1, $perPage)));
?>
<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Quản lý Nhân viên</h2>
  </div>

  <form class="row g-2 mb-3" method="get" action="/websitePS/public/employees">
    <div class="col-auto">
      <input type="text" class="form-control" name="search" placeholder="Tìm theo tên, email, username"
             value="<?= htmlspecialchars($searchTerm) ?>">
      <a class="btn btn-primary" href="/websitePS/public/employees/create">+ Thêm nhân viên</a>

    </div>
    <div class="col-auto">
      <select class="form-select" name="perPage">
        <?php foreach ([5,10,20,50] as $n): ?>
          <option value="<?= $n ?>" <?= ($perPage==$n?'selected':'') ?>><?= $n ?>/trang</option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-auto">
      <button class="btn btn-outline-secondary" type="submit">Lọc</button>
    </div>
  </form>

  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead>
        <tr>
          <th>MaNV</th>
          <th>Họ tên</th>
          <th>Email</th>
          <th>SĐT</th>
          <th>Role</th>
          <th class="text-end">Hành động</th>
        </tr>
      </thead>
      <tbody>
      <?php if (!empty($staff)): foreach ($staff as $row): ?>
        <tr>
          <td><?= (int)$row['MaNV'] ?></td>
          <td><?= htmlspecialchars($row['HoTen'] ?? '') ?></td>
          <td><?= htmlspecialchars($row['Email'] ?? '') ?></td>
          <td><?= htmlspecialchars($row['SoDienThoai'] ?? '') ?></td>
          <td><span class="badge bg-secondary"><?= htmlspecialchars($row['role'] ?? 'staff') ?></span></td>
          <td class="text-end">
            <a class="btn btn-sm btn-outline-primary" href="/websitePS/public/employees/show/<?= (int)$row['MaNV'] ?>">Xem</a>
            <a class="btn btn-sm btn-outline-warning" href="/websitePS/public/employees/edit/<?= (int)$row['MaNV'] ?>">Sửa</a>
            <form method="post" action="/websitePS/public/employees/delete/<?= (int)$row['MaNV'] ?>" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa nhân viên này?');">
              <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
            </form>
          </td>
        </tr>
      <?php endforeach; else: ?>
        <tr><td colspan="7" class="text-center text-muted">Không có dữ liệu.</td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>

  <?php if ($totalPages > 1): ?>
  <nav aria-label="pagination">
    <ul class="pagination justify-content-center">
      <?php for ($p=1; $p<=$totalPages; $p++): ?>
        <li class="page-item <?= $p==$currentPage?'active':'' ?>">
          <a class="page-link"
             href="/websitePS/public/employees?search=<?= urlencode($searchTerm) ?>&perPage=<?= (int)$perPage ?>&page=<?= $p ?>">
            <?= $p ?>
          </a>
        </li>
      <?php endfor; ?>
    </ul>
  </nav>
  <?php endif; ?>
</div>
