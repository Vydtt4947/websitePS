<?php
// File: app/controllers/ProductsController.php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/ProductModel.php';

class ProductsController extends BaseController {
    private $productModel;

    public function __construct() {
        // Chỉ gọi parent::__construct() cho các phương thức admin
        // Không gọi cho các phương thức dành cho khách hàng
        $this->productModel = new ProductModel();
        $this->activePage = 'products'; // Đặt trang hiện hành
    }

    // === PHƯƠNG THỨC DÀNH CHO ADMIN (cần đăng nhập) ===
    public function index() {
        // Gọi parent constructor để kiểm tra đăng nhập admin
        parent::__construct();
        // Chỉ admin mới được truy cập quản lý sản phẩm
        $this->requireRole(['admin']);
        
        $searchTerm = $_GET['search'] ?? '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        $paginationData = $this->productModel->getProductsPaginated($searchTerm, $page);

        $data = [
            'pageTitle' => 'Quản lý Sản phẩm',
            'products' => $paginationData['products'],
            'totalProducts' => $paginationData['total'],
            'perPage' => $paginationData['perPage'],
            'currentPage' => $paginationData['currentPage'],
            'searchTerm' => $searchTerm
        ];
        $this->renderView('products/index.php', $data);
    }

    public function create() {
        parent::__construct();
        $this->requireRole(['admin']);
        $categories = $this->productModel->getAllCategories();
        require_once __DIR__ . '/../views/admin/products/create.php';
    }

    public function store() {
        parent::__construct();
        $this->requireRole(['admin']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hinhAnh = null;
            
            // Xử lý hình ảnh
            if (!empty($_POST['hinhAnh'])) {
                $hinhAnh = trim($_POST['hinhAnh']);
            }
            
            $this->productModel->createProduct($_POST['tenSP'], $_POST['moTa'], $_POST['donGia'], $_POST['maDM'], $hinhAnh);
            header('Location: /websitePS/public/products');
            exit();
        }
    }

    public function edit($id) {
        parent::__construct();
        $this->requireRole(['admin']);
        $product = $this->productModel->getProductById($id);
        $categories = $this->productModel->getAllCategories();
        require_once __DIR__ . '/../views/admin/products/edit.php';
    }

    public function update($id) {
        parent::__construct();
        $this->requireRole(['admin']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hinhAnh = null;
            
            // Xử lý hình ảnh
            if (!empty($_POST['hinhAnh'])) {
                $hinhAnh = trim($_POST['hinhAnh']);
            }
            
            $this->productModel->updateProduct($id, $_POST['tenSP'], $_POST['moTa'], $_POST['donGia'], $_POST['maDM'], $hinhAnh);
            header('Location: /websitePS/public/products');
            exit();
        }
    }

    public function delete($id) {
        parent::__construct();
        $this->requireRole(['admin']);
        $this->productModel->deleteProduct($id);
        header('Location: /websitePS/public/products');
        exit();
    }

    // === PHƯƠNG THỨC DÀNH CHO KHÁCH HÀNG (không cần đăng nhập) ===
    public function list() {
        // Không gọi parent::__construct() - cho phép khách vãng lai truy cập
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $searchTerm = $_GET['search'] ?? '';
        $category = $_GET['category'] ?? '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $sort = $_GET['sort'] ?? 'name'; // name, price_asc, price_desc

        // Lấy danh sách sản phẩm cho khách hàng
        $products = $this->productModel->getProductsForCustomer($searchTerm, $category, $sort, $page);
        $categories = $this->productModel->getAllCategories();

        require_once __DIR__ . '/../views/pages/products_list.php';
    }

    public function show($id) {
        // Không gọi parent::__construct() - cho phép khách vãng lai truy cập
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $product = $this->productModel->getProductById($id);

        if (!$product) {
            // Trong thực tế, bạn nên hiển thị một trang 404 đẹp hơn
            http_response_code(404);
            echo "404 - Sản phẩm không tồn tại!";
            exit;
        }

        // Lấy sản phẩm liên quan (cùng danh mục hoặc khác danh mục)
        $relatedProducts = $this->productModel->getRelatedProducts($id, $product['MaDM'] ?? null);

        // Lấy đánh giá sản phẩm
        require_once __DIR__ . '/../models/ReviewModel.php';
        $reviewModel = new ReviewModel();
        
        // Lấy đánh giá của sản phẩm (cả đánh giá xác thực và chưa xác thực)
        $reviews = $reviewModel->getProductReviews($id, 20, false);
        $productRating = $reviewModel->getAverageRating($id, true); // Chỉ tính đánh giá xác thực
        $reviewStats = $reviewModel->getReviewStatistics($id);
        
        // Kiểm tra khách hàng có thể đánh giá không
        $canReview = null;
        if (isset($_SESSION['customer_id'])) {
            $canReview = $reviewModel->canCustomerReview($_SESSION['customer_id'], $id);
        }



        require_once __DIR__ . '/../views/pages/product_detail.php';
    }
}
