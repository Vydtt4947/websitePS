<?php
// File: app/controllers/ReviewsController.php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/ReviewModel.php';

class ReviewsController extends BaseController {
    private ReviewModel $reviewModel;

    public function __construct() {
        parent::__construct();
        $this->activePage = 'reviews';
        $this->reviewModel = new ReviewModel();
        // Trước đây cho phép admin và staff; yêu cầu mới: chỉ admin được truy cập
        $this->requireRole(['admin']);
    }

    public function index() {
        $opts = [
            'q'          => $_GET['q'] ?? '',
            'rating'     => $_GET['rating'] ?? '',
            'verified'   => $_GET['verified'] ?? '',
            'product_id' => $_GET['product_id'] ?? '',
            'page'       => $_GET['page'] ?? 1,
            'perPage'    => $_GET['perPage'] ?? 10,
        ];
        $list = $this->reviewModel->adminList($opts);
        $stats = $this->reviewModel->getReviewStatistics();
        $data = [
            'pageTitle' => 'Quản lý Đánh giá',
            'reviews'   => $list['data'],
            'total'     => $list['total'],
            'page'      => $list['page'],
            'perPage'   => $list['perPage'],
            'filters'   => $opts,
            'stats'     => $stats
        ];
        $this->renderView('reviews/index.php', $data);
    }

    public function show($id) {
        $id = (int)$id;
        $review = $this->reviewModel->getById($id);
        if (!$review) { http_response_code(404); echo 'Không tìm thấy đánh giá.'; return; }
        $data = [
            'pageTitle' => 'Chi tiết Đánh giá #' . $id,
            'review' => $review
        ];
        $this->renderView('reviews/show.php', $data);
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: /websitePS/public/reviews'); exit; }
        $this->requireRole(['admin']); // chỉ admin xóa
        $res = $this->reviewModel->deleteReview((int)$id);
        $type = $res['success'] ? 'success' : 'danger';
        $this->setFlashMessage($type, $res['message']);
        header('Location: /websitePS/public/reviews');
        exit;
    }
}
