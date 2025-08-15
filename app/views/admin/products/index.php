<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Quản lý Sản phẩm</h1>
    <a href="/websitePS/public/products/create" class="btn btn-primary">
        <i class="fa fa-plus"></i> Thêm sản phẩm mới
    </a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="/websitePS/public/products">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo tên sản phẩm..." value="<?= htmlspecialchars($searchTerm) ?>">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Hình ảnh</th>
                        <th>Tên Sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Đơn giá</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($products)): ?>
                        <tr>
                            <td colspan="6" class="text-center">Không tìm thấy sản phẩm nào.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?= htmlspecialchars($product['MaSP']) ?></td>
                                <td>
                                    <?php if (!empty($product['HinhAnh'])): ?>
                                        <img src="<?= htmlspecialchars($product['HinhAnh']) ?>" 
                                             alt="<?= htmlspecialchars($product['TenSP']) ?>" 
                                             class="img-thumbnail" 
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="bg-light d-flex align-items-center justify-content-center" 
                                             style="width: 60px; height: 60px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($product['TenSP']) ?></td>
                                <td><?= htmlspecialchars($product['TenDanhMuc']) ?></td>
                                <td><?= number_format($product['DonGia'], 0, ',', '.') ?> đ</td>
                                <td class="text-end">
                                    <a href="/websitePS/public/products/edit/<?= $product['MaSP'] ?>" class="btn btn-sm btn-warning">
                                        <i class="fa fa-edit"></i> Sửa
                                    </a>
                                    <a href="/websitePS/public/products/delete/<?= $product['MaSP'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                        <i class="fa fa-trash"></i> Xóa
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php if ($totalProducts > $perPage): ?>
        <nav class="mt-4">
            <ul class="pagination justify-content-center">
                <?php
                    $totalPages = ceil($totalProducts / $perPage);
                    for ($i = 1; $i <= $totalPages; $i++):
                ?>
                    <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                        <a class="page-link" href="/websitePS/public/products?page=<?= $i ?>&search=<?= urlencode($searchTerm) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
        <?php endif; ?>
    </div>
</div>