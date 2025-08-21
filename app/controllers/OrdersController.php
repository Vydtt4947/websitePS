<?php
// File: app/controllers/OrdersController.php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/OrderModel.php';

class OrdersController extends BaseController {
    private $orderModel;

    public function __construct() {
        parent::__construct();
        // Chỉ cho phép admin và staff
        $this->requireRole(['admin','staff']);
        $this->orderModel = new OrderModel();
        $this->activePage = 'orders';
    }

    public function index() {
        $data = [
            'pageTitle' => 'Quản lý Đơn hàng',
            'orders' => $this->orderModel->getAllOrders()
        ];
        // SỬA LỖI: Bỏ 'admin/' khỏi đường dẫn
        $this->renderView('orders/index.php', $data);
    }

    public function show($id) {
        // Khởi tạo session nếu chưa có
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $data = [
            'pageTitle' => 'Chi tiết Đơn hàng #' . $id,
            'orderDetails' => $this->orderModel->getOrderDetailsById($id),
            'statuses' => $this->orderModel->getAllStatuses()
        ];
        // SỬA LỖI: Bỏ 'admin/' khỏi đường dẫn
        $this->renderView('orders/show.php', $data);
    }
    

    
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['trangThai'])) {
            // Khởi tạo session nếu chưa có
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
            $statusId = $_POST['trangThai'];
            $result = $this->orderModel->updateStatus($id, $statusId);
            
            if ($result) {
                $_SESSION['success_message'] = 'Cập nhật trạng thái đơn hàng thành công!';
            } else {
                $_SESSION['error_message'] = 'Có lỗi xảy ra khi cập nhật trạng thái đơn hàng!';
            }
            
            header('Location: /websitePS/public/orders/show/' . $id);
            exit();
        }
    }
}