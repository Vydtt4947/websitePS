<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm - Parrot Smell</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/websitePS/public/assets/css/style.css">
    <style>
        :root {
            --primary-color: #009688;
            --secondary-color: #fdf5e6;
            --text-color: #5d4037;
            --heading-font: 'Playfair Display', serif;
            --body-font: 'Roboto', sans-serif;
        }
        body {
            font-family: var(--body-font);
            color: var(--text-color);
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            background-color: #fff;
        }
        .navbar-brand {
            font-family: var(--heading-font);
            font-weight: 700;
            color: var(--primary-color) !important;
        }
        .btn-primary-custom {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            padding: 12px 30px;
            font-weight: 500;
            transition: all 0.3s;
        }
        .btn-primary-custom:hover {
            background-color: #00796b;
            border-color: #00796b;
            transform: translateY(-2px);
        }
        .btn-outline-primary-custom {
            background-color: transparent;
            border-color: var(--primary-color);
            color: var(--primary-color);
            padding: 12px 30px;
            font-weight: 500;
            transition: all 0.3s;
        }
        .btn-outline-primary-custom:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }
        .products-page {
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .page-title {
            text-align: center;
            padding: 3rem 0 2rem 0;
            background-color: white;
            margin-bottom: 2rem;
        }
        .page-title h1 {
            font-family: var(--heading-font);
            color: var(--text-color);
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
        .search-filter-section {
            background-color: white;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .search-box {
            position: relative;
            display: flex;
            align-items: center;
        }
        .search-box input {
            border: 2px solid #e9ecef;
            border-radius: 25px 0 0 25px;
            padding: 0.75rem 1rem;
            border-right: none;
        }
        .search-box input:focus {
            outline: none;
            border-color: var(--primary-color);
        }
        .search-btn {
            background-color: var(--primary-color);
            border: 2px solid var(--primary-color);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0 25px 25px 0;
            border-left: none;
        }
        .search-btn:hover {
            background-color: #00796b;
            border-color: #00796b;
        }
        .filter-select {
            border: 2px solid #e9ecef;
            border-radius: 25px;
            padding: 0.75rem 1rem;
            background-color: white;
            color: var(--text-color);
            min-width: 200px;
        }
        .filter-select:focus {
            border-color: var(--primary-color);
            outline: none;
        }
        
        .filter-info {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 1rem;
        }
        
        .no-products {
            text-align: center;
            padding: 3rem 0;
        }
        
        .no-products i {
            color: #6c757d;
            margin-bottom: 1rem;
        }
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }
        .product-card {
            background-color: white;
            border: 1px solid #eee;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: all 0.3s;
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .product-image-container {
            position: relative;
            overflow: hidden;
        }
        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .product-card:hover .product-image {
            transform: scale(1.05);
        }
        .stock-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #28a745;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .category-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #6c757d;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .product-info {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .product-title {
            font-family: var(--heading-font);
            color: var(--text-color);
            margin-bottom: 0.5rem;
            font-size: 1.2rem;
            line-height: 1.4;
            font-weight: 600;
        }
        .product-description {
            color: #6c757d;
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 1rem;
            flex-grow: 1;
        }
        .product-price {
            color: var(--primary-color);
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .product-actions {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .btn-add-cart {
            background-color: var(--primary-color);
            border: 2px solid var(--primary-color);
            color: white;
            padding: 0.75rem;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        .btn-add-cart:hover {
            background-color: #00796b;
            border-color: #00796b;
            color: white;
        }
        .btn-view-details {
            background-color: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 0.75rem;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        .btn-view-details:hover {
            background-color: var(--primary-color);
            color: white;
        }
        .pagination-section {
            display: flex;
            justify-content: center;
            margin-top: 3rem;
        }
        .pagination .page-link {
            color: var(--primary-color);
            border-color: #e9ecef;
            border-radius: 10px;
            margin: 0 0.25rem;
        }
        .pagination .page-link:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }
        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .no-products {
            text-align: center;
            padding: 4rem 2rem;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .no-products i {
            font-size: 4rem;
            color: var(--primary-color);
            margin-bottom: 2rem;
        }
        @media (max-width: 768px) {
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1rem;
            }
            .page-title h1 {
                font-size: 2rem;
            }
            .search-filter-section {
                padding: 1rem;
            }
        }
        
        /* Footer Styles */
        .footer {
            background-color: var(--text-color);
            color: var(--secondary-color);
            padding: 3rem 0 2rem;
            margin-top: 4rem;
        }
        
        .footer a {
            color: var(--secondary-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer a:hover {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .footer h6 {
            color: var(--secondary-color);
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>

<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 9999;">
        <i class="fas fa-check-circle me-2"></i>
        <?= $_SESSION['success_message'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<div class="products-page">
    <!-- Navigation -->
        <?php include __DIR__ . '/layouts/navbar.php'; ?>

    <!-- Page Title -->
    <div class="page-title">
        <div class="container">
            <h1>Sản Phẩm</h1>
        </div>
    </div>

    <div class="container">
        <!-- Success Message -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?= $_SESSION['success_message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>
        
        <!-- Search and Filter Section -->
        <div class="search-filter-section">
            <div class="row g-3 align-items-center">
                <div class="col-md-6">
                    <div class="search-box">
                        <input type="text" class="form-control" id="searchInput" 
                               placeholder="Tìm kiếm sản phẩm..." 
                               value="<?= htmlspecialchars($searchTerm ?? '') ?>">
                        <button type="button" class="search-btn" onclick="performSearch()">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <select id="categoryFilter" class="filter-select" onchange="filterProducts()">
                        <option value="">Tất cả danh mục</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['MaDM'] ?>" 
                                    <?= (isset($_GET['category']) && $_GET['category'] == $category['MaDM']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category['TenDanhMuc']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <select id="sortFilter" class="filter-select" onchange="filterProducts()">
                        <option value="name" <?= (isset($_GET['sort']) && $_GET['sort'] == 'name') ? 'selected' : '' ?>>Tên A-Z</option>
                        <option value="name_desc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'name_desc') ? 'selected' : '' ?>>Tên Z-A</option>
                        <option value="price_asc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'price_asc') ? 'selected' : '' ?>>Giá tăng dần</option>
                        <option value="price_desc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'price_desc') ? 'selected' : '' ?>>Giá giảm dần</option>
                    </select>
                </div>
            </div>
            
            <!-- Filter Results Info -->
            <div class="filter-info mt-3" id="filterInfo" style="display: none;">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">
                        <i class="fas fa-filter me-2"></i>
                        <span id="filterText">Đang lọc sản phẩm...</span>
                    </span>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="clearFilters()">
                        <i class="fas fa-times me-1"></i>
                        Xóa bộ lọc
                    </button>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <?php if (empty($products['products'])): ?>
            <div class="no-products">
                <i class="fas fa-search"></i>
                <h3>Không tìm thấy sản phẩm</h3>
                <p class="text-muted mb-4">Hãy thử tìm kiếm với từ khóa khác hoặc chọn danh mục khác</p>
                <a href="/websitePS/public/products/list" class="btn btn-primary-custom">
                    <i class="fas fa-refresh me-2"></i>
                    Xem tất cả sản phẩm
                </a>
            </div>
        <?php else: ?>
            <?php
            // Hàm để lấy ảnh cho từng sản phẩm
            function getProductImage($product) {
                // Ưu tiên sử dụng hình ảnh từ database
                if (!empty($product['HinhAnh'])) {
                    return $product['HinhAnh'];
                }
                
                // Fallback: sử dụng tên sản phẩm để tìm hình ảnh mặc định
                $productName = strtolower(trim($product['TenSP']));
                
                // Map ảnh cho từng sản phẩm cụ thể
                $imageMap = [
                    'tiramisu' => 'https://images.unsplash.com/photo-1714385905983-6f8e06fffae1?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                    'sourdough' => 'https://plus.unsplash.com/premium_photo-1664640733898-d5c3f71f44e1?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                    'chocolate cake' => 'https://images.unsplash.com/photo-1606890737304-57a1ca8a5b62?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8Y2hvY29sYXRlJTIwY2FrZXxlbnwwfHwwfHx8MA%3D%3D',
                    'croissant' => 'https://images.unsplash.com/photo-1600521853186-93b88b3a07b0?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTR8fGNyb2lzc2FudHxlbnwwfHwwfHx8MA%3D%3D'
                ];
                
                // Tìm ảnh phù hợp
                foreach ($imageMap as $keyword => $imageUrl) {
                    if (strpos($productName, $keyword) !== false) {
                        return $imageUrl;
                    }
                }
                
                // Ảnh mặc định nếu không tìm thấy
                return 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?q=80&w=1987&auto=format&fit=crop';
            }
            ?>
            <div class="products-grid" id="productsGrid">
                <?php foreach ($products['products'] as $product): ?>
                    <div class="product-card" 
                         data-name="<?= htmlspecialchars(strtolower($product['TenSP'])) ?>"
                         data-category="<?= htmlspecialchars($product['MaDM']) ?>"
                         data-price="<?= $product['DonGia'] ?>"
                         data-category-name="<?= htmlspecialchars($product['TenDanhMuc']) ?>">
                        <div class="product-image-container">
                            <img src="<?= getProductImage($product) ?>" 
                                 alt="<?= htmlspecialchars($product['TenSP']) ?>" 
                                 class="product-image">
                            <div class="stock-badge">Còn hàng</div>
                            <div class="category-badge"><?= htmlspecialchars($product['TenDanhMuc']) ?></div>
                        </div>
                        
                        <div class="product-info">
                            <h3 class="product-title"><?= htmlspecialchars($product['TenSP']) ?></h3>
                            
                            <p class="product-description">
                                <?= htmlspecialchars(substr($product['MoTa'], 0, 80)) ?>...
                            </p>
                            
                            <div class="product-price">
                                <?= number_format($product['DonGia'], 0, ',', '.') ?> ₫
                            </div>
                            
                            <div class="product-actions">
                                <a href="/websitePS/public/cart/add?productId=<?= $product['MaSP'] ?>&quantity=1" 
                                   class="btn-add-cart">
                                    <i class="fas fa-shopping-cart"></i>
                                    Thêm vào giỏ
                                </a>
                                <a href="/websitePS/public/products/show/<?= $product['MaSP'] ?>" class="btn-view-details">
                                    <i class="fas fa-eye"></i>
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if ($products['totalPages'] > 1): ?>
                <div class="pagination-section">
                    <nav aria-label="Product pagination">
                        <ul class="pagination">
                            <?php if ($products['currentPage'] > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $products['currentPage'] - 1])) ?>">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                            
                            <?php for ($i = max(1, $products['currentPage'] - 2); $i <= min($products['totalPages'], $products['currentPage'] + 2); $i++): ?>
                                <li class="page-item <?= $i == $products['currentPage'] ? 'active' : '' ?>">
                                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($products['currentPage'] < $products['totalPages']): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $products['currentPage'] + 1])) ?>">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<footer class="footer pt-5 pb-4">
    <div class="container text-center text-md-start">
        <div class="row">
            <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mb-4">
                <h6 class="text-uppercase fw-bold">🦜 Parrot Smell</h6>
                <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: var(--primary-color); height: 2px"/>
                <p>Nơi mỗi chiếc bánh là một tác phẩm nghệ thuật, mang đến niềm vui và sự ngọt ngào cho cuộc sống của bạn.</p>
            </div>
            <div class="col-md-4 col-lg-2 col-xl-2 mx-auto mb-4">
                <h6 class="text-uppercase fw-bold">Liên kết</h6>
                <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: var(--primary-color); height: 2px"/>
                <p><a href="/websitePS/public/pages/about">Về chúng tôi</a></p>
                <p><a href="#!">Chính sách giao hàng</a></p>
                <p><a href="#!">Điều khoản dịch vụ</a></p>
            </div>
            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                <h6 class="text-uppercase fw-bold">Liên hệ</h6>
                <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: var(--primary-color); height: 2px"/>
                <p><i class="fas fa-home me-3"></i> 02 Võ Oanh, Phường 25, Quận Bình Thạnh, TP.HCM</p>
                <p><i class="fas fa-envelope me-3"></i> cucxacdufong@gmail.com</p>
                <p><i class="fas fa-phone me-3"></i> 0767 150 474</p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Lưu trữ tất cả sản phẩm ban đầu
let allProducts = [];
let filteredProducts = [];

// Khởi tạo khi trang load
document.addEventListener('DOMContentLoaded', function() {
    // Lưu tất cả sản phẩm ban đầu
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach(card => {
        allProducts.push({
            element: card,
            name: card.dataset.name,
            category: card.dataset.category,
            price: parseFloat(card.dataset.price),
            categoryName: card.dataset.categoryName
        });
    });
    
    // Thêm event listener cho search input
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', debounce(filterProducts, 300));
    
    // Khởi tạo trạng thái ban đầu
    updateFilterInfo();
});

// Debounce function để tránh gọi quá nhiều lần
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Hàm tìm kiếm
function performSearch() {
    filterProducts();
}

// Hàm lọc sản phẩm chính
function filterProducts() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const categoryFilter = document.getElementById('categoryFilter').value;
    const sortFilter = document.getElementById('sortFilter').value;
    
    // Lọc sản phẩm
    filteredProducts = allProducts.filter(product => {
        let matchesSearch = true;
        let matchesCategory = true;
        
        // Lọc theo tìm kiếm
        if (searchTerm) {
            matchesSearch = product.name.includes(searchTerm);
        }
        
        // Lọc theo danh mục
        if (categoryFilter) {
            matchesCategory = product.category === categoryFilter;
        }
        
        return matchesSearch && matchesCategory;
    });
    
    // Sắp xếp sản phẩm
    sortProducts(sortFilter);
    
    // Hiển thị kết quả
    displayProducts();
    
    // Cập nhật thông tin bộ lọc
    updateFilterInfo();
}

// Hàm sắp xếp sản phẩm
function sortProducts(sortType) {
    switch(sortType) {
        case 'name':
            filteredProducts.sort((a, b) => a.name.localeCompare(b.name));
            break;
        case 'name_desc':
            filteredProducts.sort((a, b) => b.name.localeCompare(a.name));
            break;
        case 'price_asc':
            filteredProducts.sort((a, b) => a.price - b.price);
            break;
        case 'price_desc':
            filteredProducts.sort((a, b) => b.price - a.price);
            break;
        default:
            filteredProducts.sort((a, b) => a.name.localeCompare(b.name));
    }
}

// Hàm hiển thị sản phẩm
function displayProducts() {
    const productsGrid = document.getElementById('productsGrid');
    const noProductsDiv = document.querySelector('.no-products');
    
    // Ẩn tất cả sản phẩm
    allProducts.forEach(product => {
        product.element.style.display = 'none';
    });
    
    // Hiển thị sản phẩm đã lọc
    filteredProducts.forEach(product => {
        product.element.style.display = 'block';
    });
    
    // Hiển thị thông báo nếu không có sản phẩm
    if (filteredProducts.length === 0) {
        if (!noProductsDiv) {
            const noProductsHTML = `
                <div class="no-products text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h3>Không tìm thấy sản phẩm</h3>
                    <p class="text-muted mb-4">Hãy thử tìm kiếm với từ khóa khác hoặc chọn danh mục khác</p>
                    <button type="button" class="btn btn-primary-custom" onclick="clearFilters()">
                        <i class="fas fa-refresh me-2"></i>
                        Xem tất cả sản phẩm
                    </button>
                </div>
            `;
            productsGrid.insertAdjacentHTML('afterend', noProductsHTML);
        }
    } else {
        if (noProductsDiv) {
            noProductsDiv.remove();
        }
    }
}

// Hàm cập nhật thông tin bộ lọc
function updateFilterInfo() {
    const filterInfo = document.getElementById('filterInfo');
    const filterText = document.getElementById('filterText');
    const searchTerm = document.getElementById('searchInput').value;
    const categoryFilter = document.getElementById('categoryFilter');
    const sortFilter = document.getElementById('sortFilter');
    
    let filterDescription = [];
    
    if (searchTerm) {
        filterDescription.push(`Tìm kiếm: "${searchTerm}"`);
    }
    
    if (categoryFilter.value) {
        const selectedOption = categoryFilter.options[categoryFilter.selectedIndex];
        filterDescription.push(`Danh mục: ${selectedOption.text}`);
    }
    
    if (sortFilter.value !== 'name') {
        const selectedOption = sortFilter.options[sortFilter.selectedIndex];
        filterDescription.push(`Sắp xếp: ${selectedOption.text}`);
    }
    
    if (filterDescription.length > 0) {
        filterText.textContent = filterDescription.join(' | ');
        filterInfo.style.display = 'block';
    } else {
        filterInfo.style.display = 'none';
    }
}

// Hàm xóa bộ lọc
function clearFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('categoryFilter').value = '';
    document.getElementById('sortFilter').value = 'name';
    
    // Hiển thị tất cả sản phẩm
    allProducts.forEach(product => {
        product.element.style.display = 'block';
    });
    
    // Ẩn thông báo không có sản phẩm
    const noProductsDiv = document.querySelector('.no-products');
    if (noProductsDiv) {
        noProductsDiv.remove();
    }
    
    // Ẩn thông tin bộ lọc
    document.getElementById('filterInfo').style.display = 'none';
}
</script>

</body>
</html>
