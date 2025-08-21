<?php
// app/views/admin/user/index.php
?>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Quản lý Người dùng</h1>
    </div>

    <form class="row g-2 mb-3" method="get" action="/websitePS/public/users">
        <div class="col-sm-9 col-md-6">
            <input type="text" name="search" value="<?= htmlspecialchars($searchTerm ?? '') ?>" class="form-control" placeholder="Tìm theo username hoặc email">
        </div>
        <div class="col-sm-3 col-md-2">
            <button class="btn btn-primary w-100" type="submit">Tìm</button>
        </div>
        <div class="col-12 mt-2">
            <div class="alert alert-info py-2 mb-0">Tài khoản người dùng được tạo tự động khi thêm Nhân viên (vai trò mặc định: staff).</div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Ngày tạo</th>
                    <th class="text-end">Thao tác</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= (int)$u['user_id'] ?></td>
                    <td><?= htmlspecialchars($u['username'] ?? '') ?></td>
                    <td><?= htmlspecialchars($u['email'] ?? '') ?></td>
                    <td><span class="badge bg-secondary text-uppercase"><?= htmlspecialchars($u['role'] ?? '') ?></span></td>
                    <td><?= htmlspecialchars($u['created_at'] ?? '') ?></td>
                    <td class="text-end d-flex gap-2 justify-content-end">
                        <a class="btn btn-sm btn-outline-info" href="/websitePS/public/users/show/<?= (int)$u['user_id'] ?>">Xem</a>
                        <a class="btn btn-sm btn-primary" href="/websitePS/public/users/edit/<?= (int)$u['user_id'] ?>">Sửa</a>
                        <form method="post" action="/websitePS/public/users/delete/<?= (int)$u['user_id'] ?>" onsubmit="return confirm('Xóa người dùng này?');">
                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6" class="text-center">Không có dữ liệu.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (($totalUsers ?? 0) > ($perPage ?? 10)): ?>
    <nav>
        <ul class="pagination justify-content-center">
            <?php $totalPages = (int)ceil(($totalUsers ?? 0) / ($perPage ?? 10)); ?>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($i == ($currentPage ?? 1)) ? 'active' : '' ?>">
                    <a class="page-link" href="/websitePS/public/users?page=<?= $i ?>&search=<?= urlencode($searchTerm ?? '') ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php endif; ?>
</div>
