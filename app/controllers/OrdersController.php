<?php
// File: app/controllers/OrdersController.php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/OrderModel.php';

class OrdersController extends BaseController {
    private $orderModel;

    public function __construct() {
        parent::__construct();
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
            $statusId = $_POST['trangThai'];
            $this->orderModel->updateStatus($id, $statusId);
            header('Location: /websitePS/public/orders/show/' . $id);
            exit();
        }
    }
}