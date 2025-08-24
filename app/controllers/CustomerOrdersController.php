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

    /**
     * API để lấy danh sách đơn hàng của khách hàng (JSON)
     */
    public function getOrdersApi() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Kiểm tra đăng nhập khách hàng
        if (!isset($_SESSION['customer_id'])) {
            header('Content-Type: application/json');
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để xem đơn hàng'
            ]);
            exit();
        }
        
        try {
            $customerId = $_SESSION['customer_id'];
            
            // Lấy danh sách đơn hàng
            $orders = $this->orderModel->getOrdersByCustomerId($customerId);
            
            // Lấy thống kê đơn hàng
            $orderStats = [
                'total' => count($orders),
                'pending' => 0,
                'processing' => 0,
                'shipped' => 0,
                'delivered' => 0,
                'cancelled' => 0
            ];
            
            foreach ($orders as $order) {
                $status = strtolower($order['TenTrangThai'] ?? 'pending');
                switch ($status) {
                    case 'pending':
                        $orderStats['pending']++;
                        break;
                    case 'processing':
                        $orderStats['processing']++;
                        break;
                    case 'shipped':
                        $orderStats['shipped']++;
                        break;
                    case 'delivered':
                        $orderStats['delivered']++;
                        break;
                    case 'cancelled':
                        $orderStats['cancelled']++;
                        break;
                }
            }
            
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'data' => [
                    'orders' => $orders,
                    'statistics' => $orderStats,
                    'customerId' => $customerId
                ]
            ]);
            
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi lấy danh sách đơn hàng',
                'error' => $e->getMessage()
            ]);
        }
        exit();
    }

    /**
     * API để lấy chi tiết đơn hàng (JSON)
     */
    public function getOrderDetailApi($id) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Kiểm tra đăng nhập khách hàng
        if (!isset($_SESSION['customer_id'])) {
            header('Content-Type: application/json');
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để xem đơn hàng'
            ]);
            exit();
        }
        
        try {
            $customerId = $_SESSION['customer_id'];
            
            // Lấy chi tiết đơn hàng
            $orderDetails = $this->orderModel->getOrderDetailsById($id);
            
            // Kiểm tra quyền sở hữu
            if (!$orderDetails || $orderDetails['info']['MaKH'] != $customerId) {
                header('Content-Type: application/json');
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => 'Không tìm thấy đơn hàng hoặc bạn không có quyền xem đơn hàng này'
                ]);
                exit();
            }
            
            // Kiểm tra khả năng đánh giá cho từng sản phẩm
            $reviewStatus = [];
            if ($orderDetails['info']['TenTrangThai'] === 'Delivered') {
                foreach ($orderDetails['items'] as $item) {
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
                    
                    $reviewStatus[$item['MaSP']] = [
                        'canReview' => !$hasReviewedThisSpecificOrder,
                        'reason' => $hasReviewedThisSpecificOrder ? 
                            'Bạn đã đánh giá sản phẩm này cho đơn hàng này' : 
                            'Bạn có thể đánh giá sản phẩm này cho đơn hàng này',
                        'existingReview' => $reviewForThisSpecificOrder,
                        'orderId' => $id
                    ];
                }
            }
            
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'data' => [
                    'order' => $orderDetails,
                    'reviewStatus' => $reviewStatus,
                    'customerId' => $customerId
                ]
            ]);
            
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi lấy chi tiết đơn hàng',
                'error' => $e->getMessage()
            ]);
        }
        exit();
    }

    /**
     * API để hủy đơn hàng (JSON)
     */
    public function cancelOrderApi($id) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Content-Type: application/json');
            http_response_code(405);
            echo json_encode([
                'success' => false,
                'message' => 'Method not allowed'
            ]);
            exit();
        }
        
        // Kiểm tra đăng nhập khách hàng
        if (!isset($_SESSION['customer_id'])) {
            header('Content-Type: application/json');
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để thực hiện thao tác này'
            ]);
            exit();
        }
        
        try {
            $customerId = $_SESSION['customer_id'];
            
            // Lấy chi tiết đơn hàng và kiểm tra quyền sở hữu
            $orderDetails = $this->orderModel->getOrderDetailsById($id);
            
            if (!$orderDetails || $orderDetails['info']['MaKH'] != $customerId) {
                header('Content-Type: application/json');
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => 'Không tìm thấy đơn hàng hoặc bạn không có quyền hủy đơn hàng này'
                ]);
                exit();
            }
            
            // Kiểm tra trạng thái đơn hàng có thể hủy không
            $currentStatus = $orderDetails['info']['TenTrangThai'] ?? '';
            if (!in_array($currentStatus, ['Pending', 'Processing'])) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Không thể hủy đơn hàng ở trạng thái: ' . $currentStatus
                ]);
                exit();
            }
            
            // Thực hiện hủy đơn hàng
            $result = $this->orderModel->cancelOrder($id);
            
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Đã hủy đơn hàng thành công!'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Không thể hủy đơn hàng'
                ]);
            }
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi hủy đơn hàng',
                'error' => $e->getMessage()
            ]);
        }
        exit();
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
