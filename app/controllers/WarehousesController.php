<?php
// File: app/controllers/WarehousesController.php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/WarehouseModel.php';
require_once __DIR__ . '/../../config/database.php';

class WarehousesController extends BaseController {
    private WarehouseModel $warehouseModel;
    private PDO $db;

    public function __construct() {
        parent::__construct();
        // Cho phép admin và staff truy cập mục Kho
        $this->requireRole(['admin','staff']);
        // Khớp với key đang dùng trong sidebar để highlight menu
        $this->activePage = 'warehouses';
        $this->warehouseModel = new WarehouseModel();
        $this->db = (new Database())->getConnection();
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    // Trang tổng quan kho: tóm tắt, cảnh báo sắp hết, nhật ký giao dịch
    public function index() {
        $pageTitle = 'Quản lý Kho';

        // Filters cho bảng giao dịch
        $filters = [
            'type' => $_GET['type'] ?? '',            // 'Nhap' | 'Xuat'
            'productId' => isset($_GET['productId']) && $_GET['productId'] !== '' ? (int)$_GET['productId'] : null,
            'ingredientId' => isset($_GET['ingredientId']) && $_GET['ingredientId'] !== '' ? (int)$_GET['ingredientId'] : null,
            'from' => $_GET['from'] ?? '',
            'to'   => $_GET['to'] ?? '',
        ];

        $page    = max(1, (int)($_GET['page'] ?? 1));
        $perPage = max(1, min(100, (int)($_GET['perPage'] ?? 10)));
        $offset  = ($page - 1) * $perPage;

        $summary = $this->warehouseModel->getInventorySummary();
        $lowProducts    = $this->warehouseModel->getLowStockProducts((int)($_GET['productThreshold'] ?? 5));
        $lowIngredients = $this->warehouseModel->getLowStockIngredients((int)($_GET['ingredientThreshold'] ?? 10));
        $tx = $this->warehouseModel->getTransactions($filters, $perPage, $offset);

        $data = [
            'pageTitle' => $pageTitle,
            'summary' => $summary,
            'lowProducts' => $lowProducts,
            'lowIngredients' => $lowIngredients,
            'transactions' => $tx['items'] ?? [],
            'total' => $tx['total'] ?? 0,
            'perPage' => $tx['limit'] ?? $perPage,
            'currentPage' => $page,
            'filters' => $filters,
        ];
        $this->renderView('warehouses/index.php', $data);
    }

    // Nhập kho sản phẩm
    public function importProduct() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: /websitePS/public/warehouses'); exit(); }
        $productId = (int)($_POST['productId'] ?? 0);
        $quantity  = (int)($_POST['quantity'] ?? 0);
        if ($productId <= 0 || $quantity <= 0) {
            $this->setFlashMessage('danger', 'Dữ liệu nhập không hợp lệ.');
            header('Location: /websitePS/public/warehouses'); exit();
        }
        $employeeId = $_SESSION['MaNV'] ?? null;
        $ok = $this->warehouseModel->importProduct($productId, $quantity, $employeeId ? (int)$employeeId : null);
        $this->setFlashMessage($ok ? 'success' : 'danger', $ok ? 'Nhập kho sản phẩm thành công!' : 'Không thể nhập kho sản phẩm.');
        header('Location: /websitePS/public/warehouses'); exit();
    }

    // Xuất kho sản phẩm
    public function exportProduct() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: /websitePS/public/warehouses'); exit(); }
        $productId = (int)($_POST['productId'] ?? 0);
        $quantity  = (int)($_POST['quantity'] ?? 0);
        if ($productId <= 0 || $quantity <= 0) {
            $this->setFlashMessage('danger', 'Dữ liệu xuất không hợp lệ.');
            header('Location: /websitePS/public/warehouses'); exit();
        }
        $employeeId = $_SESSION['MaNV'] ?? null;
        $ok = $this->warehouseModel->exportProduct($productId, $quantity, $employeeId ? (int)$employeeId : null);
        $this->setFlashMessage($ok ? 'success' : 'danger', $ok ? 'Xuất kho sản phẩm thành công!' : 'Không thể xuất kho sản phẩm.');
        header('Location: /websitePS/public/warehouses'); exit();
    }

    // Nhập kho nguyên liệu
    public function importIngredient() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: /websitePS/public/warehouses'); exit(); }
        $ingredientId = (int)($_POST['ingredientId'] ?? 0);
        $quantity     = (int)($_POST['quantity'] ?? 0);
        if ($ingredientId <= 0 || $quantity <= 0) {
            $this->setFlashMessage('danger', 'Dữ liệu nhập không hợp lệ.');
            header('Location: /websitePS/public/warehouses'); exit();
        }
        $employeeId = $_SESSION['MaNV'] ?? null;
        $ok = $this->warehouseModel->importIngredient($ingredientId, $quantity, $employeeId ? (int)$employeeId : null);
        $this->setFlashMessage($ok ? 'success' : 'danger', $ok ? 'Nhập kho nguyên liệu thành công!' : 'Không thể nhập kho nguyên liệu.');
        header('Location: /websitePS/public/warehouses'); exit();
    }

    // Xuất kho nguyên liệu
    public function exportIngredient() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: /websitePS/public/warehouses'); exit(); }
        $ingredientId = (int)($_POST['ingredientId'] ?? 0);
        $quantity     = (int)($_POST['quantity'] ?? 0);
        if ($ingredientId <= 0 || $quantity <= 0) {
            $this->setFlashMessage('danger', 'Dữ liệu xuất không hợp lệ.');
            header('Location: /websitePS/public/warehouses'); exit();
        }
        $employeeId = $_SESSION['MaNV'] ?? null;
        $ok = $this->warehouseModel->exportIngredient($ingredientId, $quantity, $employeeId ? (int)$employeeId : null);
        $this->setFlashMessage($ok ? 'success' : 'danger', $ok ? 'Xuất kho nguyên liệu thành công!' : 'Không thể xuất kho nguyên liệu.');
        header('Location: /websitePS/public/warehouses'); exit();
    }

    // Danh sách tồn kho sản phẩm (đơn giản)
    public function products() {
        $pageTitle = 'Tồn kho Sản phẩm';
        $search = trim($_GET['search'] ?? '');
        $page    = max(1, (int)($_GET['page'] ?? 1));
        $perPage = max(1, min(100, (int)($_GET['perPage'] ?? 10)));
        $offset  = ($page - 1) * $perPage;

        $params = [];
        $where  = '';
        if ($search !== '') {
            $where = 'WHERE TenSP LIKE :kw';
            $params[':kw'] = "%$search%";
        }

        $sql = "SELECT MaSP, TenSP, SoLuong FROM sanpham $where ORDER BY MaSP DESC LIMIT :limit OFFSET :offset";
        $st  = $this->db->prepare($sql);
        foreach ($params as $k=>$v) { $st->bindValue($k, $v); }
        $st->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $st->bindValue(':offset', $offset, PDO::PARAM_INT);
        $st->execute();
        $items = $st->fetchAll();

        $countSql = "SELECT COUNT(*) FROM sanpham " . ($where ? 'WHERE TenSP LIKE :kw' : '');
        $ct = $this->db->prepare($countSql);
        if ($where) { $ct->bindValue(':kw', "%$search%"); }
        $ct->execute();
        $total = (int)$ct->fetchColumn();

        $data = [
            'pageTitle' => $pageTitle,
            'items' => $items,
            'total' => $total,
            'perPage' => $perPage,
            'currentPage' => $page,
            'search' => $search,
        ];
        $this->renderView('warehouses/products.php', $data);
    }

    // Danh sách tồn kho nguyên liệu (đơn giản)
    public function ingredients() {
        $pageTitle = 'Tồn kho Nguyên liệu';
        $search = trim($_GET['search'] ?? '');
        $page    = max(1, (int)($_GET['page'] ?? 1));
        $perPage = max(1, min(100, (int)($_GET['perPage'] ?? 10)));
        $offset  = ($page - 1) * $perPage;

        $params = [];
        $where  = '';
        if ($search !== '') {
            $where = 'WHERE TenNL LIKE :kw';
            $params[':kw'] = "%$search%";
        }

        $sql = "SELECT MaNL, TenNL, SoLuong FROM nguyenlieu $where ORDER BY MaNL DESC LIMIT :limit OFFSET :offset";
        $st  = $this->db->prepare($sql);
        foreach ($params as $k=>$v) { $st->bindValue($k, $v); }
        $st->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $st->bindValue(':offset', $offset, PDO::PARAM_INT);
        $st->execute();
        $items = $st->fetchAll();

        $countSql = "SELECT COUNT(*) FROM nguyenlieu " . ($where ? 'WHERE TenNL LIKE :kw' : '');
        $ct = $this->db->prepare($countSql);
        if ($where) { $ct->bindValue(':kw', "%$search%"); }
        $ct->execute();
        $total = (int)$ct->fetchColumn();

        $data = [
            'pageTitle' => $pageTitle,
            'items' => $items,
            'total' => $total,
            'perPage' => $perPage,
            'currentPage' => $page,
            'search' => $search,
        ];
        $this->renderView('warehouses/ingredients.php', $data);
    }
}
