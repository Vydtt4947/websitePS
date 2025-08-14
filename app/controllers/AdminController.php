<?php
// File: app/controllers/AdminController.php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/OrderModel.php';
require_once __DIR__ . '/../models/CustomerModel.php';
require_once __DIR__ . '/../models/ProductModel.php';

class AdminController extends BaseController {
    public function __construct() {
        parent::__construct();
        $this->activePage = 'admin';
    }

    public function index() {
        $orderModel    = new OrderModel();
        $customerModel = new CustomerModel();
        $productModel  = new ProductModel();

        // Helper gọi an toàn: nếu method chưa có -> trả null (tránh Fatal error)
        $safeCall = function ($obj, string $method, ...$args) {
            return (is_object($obj) && method_exists($obj, $method))
                ? $obj->$method(...$args)
                : null;
        };

        $data = [
            'pageTitle'     => 'Bảng điều khiển',
            'todaysRevenue' => $safeCall($orderModel, 'getTodaysRevenue')            ?? 0,
            'todaysOrders'  => $safeCall($orderModel, 'getTodaysOrderCount')         ?? 0,
            'newCustomers'  => $safeCall($customerModel, 'getNewCustomersThisMonth') ?? 0,
            'totalProducts' => $safeCall($productModel,  'getTotalProductCount')     ?? 0,
            'recentOrders'  => $safeCall($orderModel,   'getRecentOrders', 5)        ?? [],
        ];

        // Chart 7 ngày: nếu model chưa có hàm -> để mảng rỗng
        $revenueLast7Days = $safeCall($orderModel, 'getRevenueLast7Days') ?? [];
        $chartLabels = [];
        $chartData   = [];
        if (is_array($revenueLast7Days)) {
            foreach ($revenueLast7Days as $row) {
                if (isset($row['date'], $row['revenue'])) {
                    $chartLabels[] = date('d/m', strtotime($row['date']));
                    $chartData[]   = (float)$row['revenue'];
                }
            }
        }
        $data['chartLabels'] = $chartLabels;
        $data['chartData']   = $chartData;

        $this->renderView('dashboard.php', $data);
    }
}
