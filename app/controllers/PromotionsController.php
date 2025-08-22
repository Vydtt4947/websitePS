<?php
// File: app/controllers/PromotionsController.php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/KhuyenMaiModel.php';

class PromotionsController extends BaseController {
    private KhuyenMaiModel $kmModel;

    public function __construct() {
        parent::__construct();
        $this->requireRole(['admin']);
        $this->kmModel = new KhuyenMaiModel();
        $this->activePage = 'promotions';
    }

    public function index() {
        $search = trim($_GET['search'] ?? '');
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = isset($_GET['perPage']) ? (int)$_GET['perPage'] : 10;
        if (!in_array($perPage, [5,10,20,50], true)) { $perPage = 10; }
        $pagination = $this->kmModel->getPaginated($search, $page, $perPage);
        $data = [
            'pageTitle' => 'Quản lý Khuyến mãi',
            'promotions' => $pagination['promotions'],
            'total' => $pagination['total'],
            'perPage' => $pagination['perPage'],
            'currentPage' => $pagination['currentPage'],
            'totalPages' => $pagination['totalPages'],
            'searchTerm' => $search
        ];
        $this->renderView('promotions/index.php', $data);
    }

    public function create() {
        $data = ['pageTitle' => 'Thêm Khuyến mãi'];
        $this->renderView('promotions/create.php', $data);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->sanitizeInput();
            if ($this->validate($data)) {
                if ($this->kmModel->create($data)) {
                    $this->setFlashMessage('success', 'Thêm khuyến mãi thành công');
                    header('Location: /websitePS/public/promotions'); exit();
                }
                $this->setFlashMessage('danger', 'Không thể thêm khuyến mãi');
            }
            header('Location: /websitePS/public/promotions/create'); exit();
        }
    }

    public function edit($id) {
        $promo = $this->kmModel->getById((int)$id);
        if (!$promo) { http_response_code(404); echo 'Không tìm thấy khuyến mãi'; return; }
        $data = [ 'pageTitle' => 'Chỉnh sửa Khuyến mãi', 'promotion' => $promo ];
        $this->renderView('promotions/edit.php', $data);
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->sanitizeInput();
            if ($this->validate($data, (int)$id)) {
                if ($this->kmModel->update((int)$id, $data)) {
                    $this->setFlashMessage('success', 'Cập nhật khuyến mãi thành công');
                    header('Location: /websitePS/public/promotions'); exit();
                }
                $this->setFlashMessage('danger', 'Không thể cập nhật khuyến mãi');
            }
            header('Location: /websitePS/public/promotions/edit/' . (int)$id); exit();
        }
    }

    public function delete($id) {
        if ($this->kmModel->delete((int)$id)) {
            $this->setFlashMessage('success', 'Xóa khuyến mãi thành công');
        } else {
            $this->setFlashMessage('danger', 'Không thể xóa khuyến mãi');
        }
        header('Location: /websitePS/public/promotions'); exit();
    }

    public function show($id) {
        $promo = $this->kmModel->getById((int)$id);
        if (!$promo) { http_response_code(404); echo 'Không tìm thấy khuyến mãi'; return; }
        $data = [
            'pageTitle' => 'Chi tiết Khuyến mãi',
            'promotion' => $promo
        ];
        $this->renderView('promotions/show.php', $data);
    }

    private function sanitizeInput(): array {
        return [
            'TenKM' => trim($_POST['TenKM'] ?? ''),
            'MoTa' => trim($_POST['MoTa'] ?? ''),
            'PhanTramGiamGia' => trim($_POST['PhanTramGiamGia'] ?? ''),
            'SoTienGiamGia' => trim($_POST['SoTienGiamGia'] ?? ''),
            'NgayBatDau' => trim($_POST['NgayBatDau'] ?? ''),
            'NgayKetThuc' => trim($_POST['NgayKetThuc'] ?? '')
        ];
    }

    private function validate(array $data, int $id = 0): bool {
        if ($data['TenKM'] === '') {
            $this->setFlashMessage('danger', 'Tên khuyến mãi không được để trống');
            return false;
        }
        // Chỉ cho phép nhập một trong hai loại giảm giá
        if ($data['PhanTramGiamGia'] !== '' && $data['SoTienGiamGia'] !== '') {
            $this->setFlashMessage('danger', 'Chỉ được nhập phần trăm GIẢM GIÁ hoặc số tiền GIẢM GIÁ, không phải cả hai');
            return false;
        }
        if ($data['PhanTramGiamGia'] === '' && $data['SoTienGiamGia'] === '') {
            $this->setFlashMessage('danger', 'Cần nhập phần trăm hoặc số tiền giảm giá');
            return false;
        }
        if ($data['PhanTramGiamGia'] !== '' && (!is_numeric($data['PhanTramGiamGia']) || $data['PhanTramGiamGia'] <= 0 || $data['PhanTramGiamGia'] > 100)) {
            $this->setFlashMessage('danger', 'Phần trăm giảm giá phải là số > 0 và <= 100');
            return false;
        }
        if ($data['SoTienGiamGia'] !== '' && (!is_numeric($data['SoTienGiamGia']) || $data['SoTienGiamGia'] <= 0)) {
            $this->setFlashMessage('danger', 'Số tiền giảm giá phải là số > 0');
            return false;
        }
        if ($data['NgayBatDau'] && $data['NgayKetThuc'] && $data['NgayBatDau'] > $data['NgayKetThuc']) {
            $this->setFlashMessage('danger', 'Ngày bắt đầu phải trước hoặc bằng ngày kết thúc');
            return false;
        }
        return true;
    }
}
