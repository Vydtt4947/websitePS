<?php
// File: app/controllers/IngredientsController.php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/IngredientModel.php';

class IngredientsController extends BaseController {
    private IngredientModel $ingredientModel;

    public function __construct() {
        $this->ingredientModel = new IngredientModel();
        $this->activePage = 'ingredients';
    }

    // === ADMIN METHODS ===
    public function index() {
        parent::__construct();
        $this->requireRole(['admin']);
        $searchTerm = $_GET['search'] ?? '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = isset($_GET['perPage']) ? (int)$_GET['perPage'] : 10;
        if (!in_array($perPage, [5,10,20,50], true)) { $perPage = 10; }
        $pagination = $this->ingredientModel->getIngredientsPaginated($searchTerm, $page, $perPage);
        $data = [
            'pageTitle' => 'Quản lý Nguyên liệu',
            'ingredients' => $pagination['ingredients'],
            'totalIngredients' => $pagination['total'],
            'perPage' => $pagination['perPage'],
            'currentPage' => $pagination['currentPage'],
            'searchTerm' => $searchTerm,
        ];
        $this->renderView('ingredients/index.php', $data);
    }

    public function create() {
        parent::__construct();
        $this->requireRole(['admin']);
        $data = ['pageTitle' => 'Thêm Nguyên liệu'];
        $this->renderView('ingredients/create.php', $data);
    }

    public function store() {
        parent::__construct();
        $this->requireRole(['admin']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ten = trim($_POST['tenNL'] ?? '');
            $moTa = trim($_POST['moTa'] ?? '');
            $dvt = trim($_POST['donViTinh'] ?? '');
            $soLuong = (int)($_POST['soLuong'] ?? 0);
            if ($soLuong < 0) { $soLuong = 0; }
            if ($ten === '') {
                $this->setFlashMessage('danger', 'Tên nguyên liệu không được bỏ trống.');
                header('Location: /websitePS/public/ingredients/create'); exit();
            }
            $ok = $this->ingredientModel->createIngredient($ten, $moTa ?: null, $dvt ?: null, $soLuong);
            $this->setFlashMessage($ok ? 'success' : 'danger', $ok ? 'Thêm nguyên liệu thành công!' : 'Không thể thêm nguyên liệu.');
            header('Location: /websitePS/public/ingredients'); exit();
        }
    }

    public function edit($id) {
        parent::__construct();
        $this->requireRole(['admin']);
        $ingredient = $this->ingredientModel->getIngredientById((int)$id);
        if (!$ingredient) { http_response_code(404); echo 'Không tìm thấy nguyên liệu'; return; }
        $data = [
            'pageTitle' => 'Chỉnh sửa Nguyên liệu',
            'ingredient' => $ingredient
        ];
        $this->renderView('ingredients/edit.php', $data);
    }

    public function update($id) {
        parent::__construct();
        $this->requireRole(['admin']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ten = trim($_POST['tenNL'] ?? '');
            $moTa = trim($_POST['moTa'] ?? '');
            $dvt = trim($_POST['donViTinh'] ?? '');
            $soLuong = (int)($_POST['soLuong'] ?? 0);
            if ($soLuong < 0) { $soLuong = 0; }
            if ($ten === '') {
                $this->setFlashMessage('danger', 'Tên nguyên liệu không được bỏ trống.');
                header('Location: /websitePS/public/ingredients/edit/' . (int)$id); exit();
            }
            $ok = $this->ingredientModel->updateIngredient((int)$id, $ten, $moTa ?: null, $dvt ?: null, $soLuong);
            $this->setFlashMessage($ok ? 'success' : 'danger', $ok ? 'Cập nhật nguyên liệu thành công!' : 'Không thể cập nhật nguyên liệu.');
            header('Location: /websitePS/public/ingredients'); exit();
        }
    }

    public function delete($id) {
        parent::__construct();
        $this->requireRole(['admin']);
        $ok = $this->ingredientModel->deleteIngredient((int)$id);
        $this->setFlashMessage($ok ? 'success' : 'danger', $ok ? 'Xóa nguyên liệu thành công!' : 'Không thể xóa nguyên liệu.');
        header('Location: /websitePS/public/ingredients'); exit();
    }

    public function show($id) {
        parent::__construct();
        $this->requireRole(['admin']);
        $ingredient = $this->ingredientModel->getIngredientById((int)$id);
        $data = [
            'pageTitle' => 'Chi tiết Nguyên liệu',
            'ingredient' => $ingredient
        ];
        $this->renderView('ingredients/show.php', $data);
    }
}
