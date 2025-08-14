<?php
// File: app/controllers/CustomerOrdersController.php
require_once __DIR__ . '/../models/OrderModel.php';

class CustomerOrdersController {
    private $orderModel;

    public function __construct() {
        // Khởi tạo session nếu chưa có
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->orderModel = new OrderModel();
    }

    public function show($id) {
        // Kiểm tra đăng nhập khách hàng
        if (!isset($_SESSION['customer_id'])) {
            header('Location: /websitePS/public/customerauth/login');
            exit();
        }

        $customerId = $_SESSION['customer_id'];
        
        // Lấy chi tiết đơn hàng và kiểm tra quyền sở hữu
        $orderDetails = $this->orderModel->getOrderDetailsById($id);
        
        // Kiểm tra xem đơn hàng có thuộc về khách hàng này không
        if (!$orderDetails || $orderDetails['info']['MaKH'] != $customerId) {
            http_response_code(404);
            echo "404 - Không tìm thấy đơn hàng hoặc bạn không có quyền xem đơn hàng này!";
            exit();
        }

        // Render view trực tiếp
        require_once __DIR__ . '/../views/pages/order_detail.php';
    }

    public function cancel($id) {
        // Kiểm tra đăng nhập khách hàng
        if (!isset($_SESSION['customer_id'])) {
            header('Location: /websitePS/public/customerauth/login');
            exit();
        }

        $customerId = $_SESSION['customer_id'];
        
        // Lấy chi tiết đơn hàng và kiểm tra quyền sở hữu
        $orderDetails = $this->orderModel->getOrderDetailsById($id);
        
        // Kiểm tra xem đơn hàng có thuộc về khách hàng này không
        if (!$orderDetails || $orderDetails['info']['MaKH'] != $customerId) {
            http_response_code(404);
            echo "404 - Không tìm thấy đơn hàng hoặc bạn không có quyền hủy đơn hàng này!";
            exit();
        }

        // Kiểm tra trạng thái đơn hàng - chỉ cho phép hủy khi đang ở trạng thái Pending
        if ($orderDetails['info']['TenTrangThai'] !== 'Pending') {
            $_SESSION['error_message'] = 'Không thể hủy đơn hàng này. Chỉ có thể hủy đơn hàng chưa được xác nhận.';
            header('Location: /websitePS/public/customerorders/show/' . $id);
            exit();
        }

        // Thực hiện hủy đơn hàng
        if ($this->orderModel->updateStatus($id, 'Cancelled')) {
            $_SESSION['success_message'] = 'Đơn hàng đã được hủy thành công!';
        } else {
            $_SESSION['error_message'] = 'Có lỗi xảy ra khi hủy đơn hàng. Vui lòng thử lại!';
        }

        header('Location: /websitePS/public/customerorders/show/' . $id);
        exit();
    }
}
