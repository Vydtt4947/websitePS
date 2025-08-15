<?php
// File: app/controllers/OrderTrackingController.php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/OrderModel.php';

class OrderTrackingController extends BaseController {
    private $orderModel;

    public function __construct() {
        // Không gọi parent::__construct() - cho phép khách vãng lai truy cập
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->orderModel = new OrderModel();
        $this->activePage = 'order-tracking';
    }

    // Hiển thị form tra cứu đơn hàng
    public function index() {
        // Khởi tạo các biến cho view
        $order = null;
        $orderDetails = null;
        $error = null;
        $orderCode = '';
        $phone = '';
        
        // Sử dụng trang riêng cho khách vãng lai
        require_once __DIR__ . '/../views/pages/guest_order_tracking.php';
    }

    // Xử lý tra cứu đơn hàng
    public function search() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderCode = trim($_POST['orderCode'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            
            // Khởi tạo các biến cho view
            $order = null;
            $orderDetails = null;
            $error = null;
            
            if (empty($orderCode) || empty($phone)) {
                $error = 'Vui lòng nhập đầy đủ mã đơn hàng và số điện thoại';
            } else {
                // Tìm đơn hàng theo mã đơn hàng và số điện thoại
                $order = $this->orderModel->getOrderByCodeAndPhone($orderCode, $phone);
                
                if ($order) {
                    $orderDetails = $this->orderModel->getOrderDetailsById($order['MaDH']);
                } else {
                    $error = 'Không tìm thấy đơn hàng với mã #' . htmlspecialchars($orderCode) . '. Vui lòng kiểm tra lại mã đơn hàng và số điện thoại.';
                }
            }
            
            // Sử dụng trang riêng cho khách vãng lai
            require_once __DIR__ . '/../views/pages/guest_order_tracking.php';
        } else {
            // Nếu không phải POST, chuyển về trang tra cứu
            header('Location: /websitePS/public/ordertracking');
            exit();
        }
    }

    // Hiển thị chi tiết đơn hàng (có thể truy cập trực tiếp bằng URL)
    public function view($orderCode) {
        // Khởi tạo các biến cho view
        $order = null;
        $orderDetails = null;
        $error = null;
        $phone = '';
        
        if (!empty($orderCode)) {
            $order = $this->orderModel->getOrderByCode($orderCode);
            
            if ($order) {
                $orderDetails = $this->orderModel->getOrderDetailsById($order['MaDH']);
            } else {
                $error = 'Không tìm thấy đơn hàng với mã: ' . htmlspecialchars($orderCode);
            }
        } else {
            $error = 'Mã đơn hàng không hợp lệ';
        }
        
        // Sử dụng trang riêng cho khách vãng lai
        require_once __DIR__ . '/../views/pages/guest_order_tracking.php';
    }
}
