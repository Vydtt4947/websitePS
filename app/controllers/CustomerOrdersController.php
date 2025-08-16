<?php
// File: app/controllers/CustomerOrdersController.php
require_once __DIR__ . '/../models/OrderModel.php';
require_once __DIR__ . '/../models/ReviewModel.php';

class CustomerOrdersController {
    private $orderModel;
    private $reviewModel;

    public function __construct() {
        // Khởi tạo session nếu chưa có
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->orderModel = new OrderModel();
        $this->reviewModel = new ReviewModel();
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

        // Kiểm tra khả năng đánh giá cho từng sản phẩm
        $reviewStatus = [];
        if ($orderDetails['info']['TenTrangThai'] === 'Delivered') {
            foreach ($orderDetails['items'] as $item) {
                // Kiểm tra đã đánh giá đơn hàng này chưa
                $existingReviewsForProductByCustomer = $this->reviewModel->getCustomerReview($customerId, $item['MaSP']);
                $hasReviewedThisSpecificOrder = false;
                $reviewForThisSpecificOrder = null;
                
                if ($existingReviewsForProductByCustomer) {
                    foreach ($existingReviewsForProductByCustomer as $review) {
                        if ($review['MaDH'] == $id) {
                            $hasReviewedThisSpecificOrder = true;
                            $reviewForThisSpecificOrder = $review;
                            break;
                        }
                    }
                }
                
                if ($hasReviewedThisSpecificOrder) {
                    // Đã đánh giá đơn hàng này
                    $reviewStatus[$item['MaSP']] = [
                        'canReview' => false,
                        'reason' => 'Bạn đã đánh giá sản phẩm này cho đơn hàng này',
                        'existingReview' => $reviewForThisSpecificOrder,
                        'orderId' => $id
                    ];
                } else {
                    // Chưa đánh giá đơn hàng này
                    $reviewStatus[$item['MaSP']] = [
                        'canReview' => true,
                        'reason' => 'Bạn có thể đánh giá sản phẩm này cho đơn hàng này',
                        'existingReview' => null,
                        'orderId' => $id
                    ];
                }
            }
        }

        // Render view trực tiếp
        require_once __DIR__ . '/../views/pages/order_detail.php';
    }

    public function cancel($id) {
        // Kiểm tra đăng nhập khách hàng
        if (!isset($_SESSION['customer_id'])) {
            if ($this->isAjaxRequest()) {
                http_response_code(403);
                echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập để thực hiện thao tác này!']);
                return;
            } else {
                header('Location: /websitePS/public/customerauth/login');
                exit();
            }
        }

        $customerId = $_SESSION['customer_id'];
        
        // Lấy chi tiết đơn hàng và kiểm tra quyền sở hữu
        $orderDetails = $this->orderModel->getOrderDetailsById($id);
        
        // Kiểm tra xem đơn hàng có thuộc về khách hàng này không
        if (!$orderDetails || $orderDetails['info']['MaKH'] != $customerId) {
            if ($this->isAjaxRequest()) {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Không tìm thấy đơn hàng hoặc bạn không có quyền hủy đơn hàng này!']);
                return;
            } else {
                http_response_code(404);
                echo "404 - Không tìm thấy đơn hàng hoặc bạn không có quyền hủy đơn hàng này!";
                exit();
            }
        }

        // Kiểm tra trạng thái đơn hàng - chỉ cho phép hủy khi đang ở trạng thái Pending
        if ($orderDetails['info']['TenTrangThai'] !== 'Pending') {
            if ($this->isAjaxRequest()) {
                echo json_encode(['success' => false, 'message' => 'Không thể hủy đơn hàng này. Chỉ có thể hủy đơn hàng chưa được xác nhận.']);
                return;
            } else {
                $_SESSION['error_message'] = 'Không thể hủy đơn hàng này. Chỉ có thể hủy đơn hàng chưa được xác nhận.';
                header('Location: /websitePS/public/customerorders/show/' . $id);
                exit();
            }
        }

        // Thực hiện hủy đơn hàng
        if ($this->orderModel->updateStatus($id, 'Cancelled')) {
            if ($this->isAjaxRequest()) {
                echo json_encode(['success' => true, 'message' => 'Đơn hàng đã được hủy thành công!']);
                return;
            } else {
                $_SESSION['success_message'] = 'Đơn hàng đã được hủy thành công!';
            }
        } else {
            if ($this->isAjaxRequest()) {
                echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra khi hủy đơn hàng. Vui lòng thử lại!']);
                return;
            } else {
                $_SESSION['error_message'] = 'Có lỗi xảy ra khi hủy đơn hàng. Vui lòng thử lại!';
            }
        }

        // Chỉ redirect nếu không phải AJAX request
        if (!$this->isAjaxRequest()) {
            header('Location: /websitePS/public/customerorders/show/' . $id);
            exit();
        }
    }
    
    private function isAjaxRequest() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}
