<?php
// File: app/controllers/ReviewController.php

require_once __DIR__ . '/../models/ReviewModel.php';
require_once __DIR__ . '/../models/ProductModel.php';

class ReviewController {

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Hiển thị form đánh giá sản phẩm
     */
    public function form($productId) {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['customer_id'])) {
            $_SESSION['error_message'] = 'Bạn cần đăng nhập để đánh giá sản phẩm';
            header('Location: /websitePS/public/auth/login');
            exit();
        }

        $reviewModel = new ReviewModel();
        $productModel = new ProductModel();

        // Lấy thông tin sản phẩm
        $product = $productModel->getProductById($productId);
        if (!$product) {
            $_SESSION['error_message'] = 'Sản phẩm không tồn tại';
            header('Location: /websitePS/public/');
            exit();
        }

        // Kiểm tra khách hàng có thể đánh giá không
        $canReview = $reviewModel->canCustomerReview($_SESSION['customer_id'], $productId);
        
        // Lấy đánh giá hiện tại của khách hàng (nếu có)
        $existingReview = $reviewModel->getCustomerReview($_SESSION['customer_id'], $productId);

        // Lấy đánh giá của sản phẩm
        $reviews = $reviewModel->getProductReviews($productId, 10, true);
        $productRating = $reviewModel->getAverageRating($productId, true);

        // Hiển thị view
        require_once __DIR__ . '/../views/reviews/review_form.php';
    }

    /**
     * Xử lý gửi đánh giá
     */
    public function submit() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['customer_id'])) {
            $_SESSION['error_message'] = 'Bạn cần đăng nhập để đánh giá sản phẩm';
            header('Location: /websitePS/public/auth/login');
            exit();
        }

        // Kiểm tra method POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /websitePS/public/');
            exit();
        }

        $reviewModel = new ReviewModel();

        // Lấy dữ liệu từ form
        $productId = $_POST['product_id'] ?? null;
        $orderId = $_POST['order_id'] ?? null;
        $rating = $_POST['rating'] ?? null;
        $content = trim($_POST['content'] ?? '');

                        // Validation cơ bản
                if (!$productId || !$orderId || !$rating) {
                    $_SESSION['error_message'] = 'Vui lòng chọn số sao đánh giá';
                    header('Location: /websitePS/public/customerorders/show/' . $orderId);
                    exit();
                }

        // Gửi đánh giá
        $result = $reviewModel->createReview(
            $_SESSION['customer_id'],
            $productId,
            $orderId,
            $rating,
            $content
        );

        if ($result['success']) {
            $_SESSION['success_message'] = $result['message'];
            // Redirect về trang sản phẩm để khách hàng thấy đánh giá của mình
            header('Location: /websitePS/public/products/show/' . $productId);
        } else {
            $_SESSION['error_message'] = $result['message'];
            // Nếu lỗi, vẫn redirect về trang sản phẩm để khách hàng có thể sửa lại
            header('Location: /websitePS/public/products/show/' . $productId);
        }
        exit();
    }

    /**
     * Hiển thị tất cả đánh giá của sản phẩm
     */
    public function product($productId) {
        $reviewModel = new ReviewModel();
        $productModel = new ProductModel();

        // Lấy thông tin sản phẩm
        $product = $productModel->getProductById($productId);
        if (!$product) {
            $_SESSION['error_message'] = 'Sản phẩm không tồn tại';
            header('Location: /websitePS/public/');
            exit();
        }

        // Lấy đánh giá
        $reviews = $reviewModel->getProductReviews($productId, 50, false); // Lấy cả đánh giá chưa xác thực
        $productRating = $reviewModel->getAverageRating($productId, true); // Chỉ tính đánh giá xác thực
        $reviewStats = $reviewModel->getReviewStatistics($productId);

        // Kiểm tra khách hàng có thể đánh giá không
        $canReview = null;
        if (isset($_SESSION['customer_id'])) {
            $canReview = $reviewModel->canCustomerReview($_SESSION['customer_id'], $productId);
        }

        // Hiển thị view
        require_once __DIR__ . '/../views/reviews/product_reviews.php';
    }

    /**
     * API để lấy đánh giá sản phẩm (cho AJAX)
     */
    public function api($productId) {
        header('Content-Type: application/json');
        
        $reviewModel = new ReviewModel();
        
        $reviews = $reviewModel->getProductReviews($productId, 10, true);
        $rating = $reviewModel->getAverageRating($productId, true);
        
        echo json_encode([
            'success' => true,
            'data' => [
                'reviews' => $reviews,
                'rating' => $rating,
                'productId' => $productId,
                'totalReviews' => count($reviews)
            ]
        ]);
        exit();
    }

    /**
     * Hiển thị trang quản lý đánh giá (cho admin)
     */
    public function admin() {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            $_SESSION['error_message'] = 'Bạn không có quyền truy cập trang này';
            header('Location: /websitePS/public/');
            exit();
        }

        $reviewModel = new ReviewModel();
        
        // Lấy thống kê tổng quát
        $overallStats = $reviewModel->getReviewStatistics();
        
        // Lấy đánh giá gần đây
        $recentReviews = $reviewModel->getProductReviews(null, 20, false);
        
        // Hiển thị view
        require_once __DIR__ . '/../views/admin/reviews_management.php';
    }

    /**
     * Xóa đánh giá (cho admin)
     */
    public function delete($reviewId) {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            $_SESSION['error_message'] = 'Bạn không có quyền thực hiện hành động này';
            header('Location: /websitePS/public/');
            exit();
        }

        $reviewModel = new ReviewModel();
        
        // Thực hiện xóa đánh giá
        $result = $reviewModel->deleteReview($reviewId);
        
        if ($result['success']) {
            $_SESSION['success_message'] = 'Đã xóa đánh giá thành công';
        } else {
            $_SESSION['error_message'] = $result['message'];
        }
        
        header('Location: /websitePS/public/admin/review');
        exit();
    }
}
