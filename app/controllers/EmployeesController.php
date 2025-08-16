<?php
// File: app/controllers/EmployeesController.php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/EmployeeModel.php';
require_once __DIR__ . '/../../config/database.php';

class EmployeesController extends BaseController {
    private EmployeeModel $employeeModel;
    private PDO $db;

    public function __construct() {
        parent::__construct();
        $this->activePage = 'employees';
        $this->employeeModel = new EmployeeModel();
        $this->db = (new Database())->getConnection();
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    private function sanitizeRole(string $role): string {
        $allowed = ['admin','staff','member'];
        return in_array($role, $allowed, true) ? $role : 'staff';
    }

    /** Danh sách nhân viên + tìm kiếm + phân trang */
    public function index() {
        $search = trim($_GET['search'] ?? ($_GET['q'] ?? ''));
        $perPage = max(5, (int)($_GET['perPage'] ?? 10));
        $currentPage = max(1, (int)($_GET['page'] ?? 1));
        $offset = ($currentPage - 1) * $perPage;

        $staffList = $this->employeeModel->list([
            'limit' => $perPage,
            'offset' => $offset,
            'q' => $search
        ]);

        // Đếm tổng cho phân trang (khớp điều kiện)
        $totalStaff = $this->employeeModel->countAll($search);

        $data = [
            'pageTitle' => 'Quản lý Nhân viên',
            'staff' => $staffList,
            'totalStaff' => $totalStaff,
            'totalEmployee' => $totalStaff,
            'perPage' => $perPage,
            'currentPage' => $currentPage,
            'searchTerm' => $search,
        ];
        $this->renderView('employees/index.php', $data);
    }

    /** Chi tiết nhân viên */
    public function show($id) {
        $id = (int)$id;
        $nv = $this->employeeModel->find($id);
        if (!$nv) { echo 'Không tìm thấy nhân viên.'; exit; }
        $data = [
            'pageTitle' => 'Chi tiết Nhân viên: ' . ($nv['HoTen'] ?? ('#' . $id)),
            'nv' => $nv
        ];
        $this->renderView('employees/show.php', $data);
    }

    /** Form thêm nhân viên */
    public function create() {
        $data = [
            'pageTitle' => 'Thêm Nhân viên',
            'roles' => ['admin','staff','member']
        ];
        $this->renderView('employees/create.php', $data);
    }

    /** Lưu nhân viên mới */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /websitePS/public/employees'); exit;
        }
        $ok = $this->employeeModel->create($_POST);
        if ($ok) {
            $this->setFlashMessage('success', 'Đã thêm nhân viên mới.');
        } else {
            $this->setFlashMessage('danger', 'Thêm nhân viên thất bại.');
        }
        header('Location: /websitePS/public/employees'); exit;
    }

    /** Form sửa thông tin */
    public function edit($id) {
        $id = (int)$id;
        $nv = $this->employeeModel->find($id);
        if (!$nv) { echo 'Không tìm thấy nhân viên.'; exit; }
        $data = [
            'pageTitle' => 'Sửa Nhân viên #' . $id,
            'nv' => $nv,
            'roles' => ['admin','staff','member']
        ];
        $this->renderView('employees/edit.php', $data);
    }

    /** Cập nhật hồ sơ + role */
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /websitePS/public/employees'); exit;
        }
        $id = (int)$id;

        // 1) Cập nhật hồ sơ cơ bản (nhanvien)
        $ok1 = $this->employeeModel->updateProfile($id, $_POST);

        // 2) Nếu có truyền role -> cập nhật role tài khoản liên kết (users.role)
        $ok2 = true;
        if (isset($_POST['role']) && $_POST['role'] !== '') {
            $role = $this->sanitizeRole($_POST['role']);
            $ok2 = $this->employeeModel->updateRole($id, $role);
        }

        if ($ok1 && $ok2) {
            $this->setFlashMessage('success', 'Đã cập nhật thông tin nhân viên.');
        } else {
            $this->setFlashMessage('danger', 'Cập nhật thất bại.');
        }
        header('Location: /websitePS/public/employees'); exit;
    }

    // Thêm action xóa nhân viên
    public function delete($id) {
        $id = (int)$id;
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            // Chỉ cho phép POST để tránh xóa ngoài ý muốn
            header('Location: /websitePS/public/employees'); exit;
        }
        try {
            $ok = $this->employeeModel->delete($id);
            if ($ok) {
                $this->setFlashMessage('success', 'Đã xóa nhân viên.');
            } else {
                $this->setFlashMessage('danger', 'Xóa nhân viên thất bại.');
            }
        } catch (Throwable $e) {
            $this->setFlashMessage('danger', 'Lỗi khi xóa: ' . $e->getMessage());
        }
        header('Location: /websitePS/public/employees'); exit;
    }
}
