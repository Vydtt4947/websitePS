<?php
// File: app/controllers/CustomersController.php

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/CustomerModel.php';

class CustomersController extends BaseController {
    private $customerModel;

    public function __construct() {
        parent::__construct();
        $this->activePage = 'customers';
        $this->customerModel = new CustomerModel();
    }

    public function index() {
        $data = [
            'pageTitle' => 'Quản lý Khách hàng',
            'customers' => $this->customerModel->getAllCustomers()
        ];
        $this->renderView('customers/index.php', $data);
    }

    public function show($id) {
        $customer = $this->customerModel->getCustomerById($id);
        if (!$customer) { echo "Không tìm thấy khách hàng."; exit; }

        $orderHistory = $this->customerModel->getOrderHistoryByCustomerId($id);
        $data = [
            'pageTitle' => 'Chi tiết Khách hàng: ' . $customer['HoTen'],
            'customer' => $customer,
            'orderHistory' => $orderHistory
        ];
        $this->renderView('customers/show.php', $data);
    }

    public function create() {
        $data = [
            'pageTitle' => 'Thêm Khách hàng mới',
            'segments' => $this->customerModel->getAllCustomerSegments()
        ];
        $this->renderView('customers/create.php', $data);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->customerModel->createCustomer($_POST);
            $this->setFlashMessage('success', 'Đã thêm khách hàng mới thành công!');
            header('Location: /websitePS/public/customers');
            exit();
        }
    }

    // PHƯƠNG THỨC SỬA LỖI VÀ HOÀN CHỈNH
    public function edit($id) {
        $customer = $this->customerModel->getCustomerById($id);
        if (!$customer) { echo "Không tìm thấy khách hàng."; exit; }

        $segments = $this->customerModel->getAllCustomerSegments();
        $data = [
            'pageTitle' => 'Sửa thông tin Khách hàng',
            'customer' => $customer,
            'segments' => $segments
        ];
        $this->renderView('customers/edit.php', $data);
    }

    // PHƯƠNG THỨC MỚI ĐỂ XỬ LÝ CẬP NHẬT
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->customerModel->updateCustomer($id, $_POST);
            $this->setFlashMessage('success', 'Đã cập nhật thông tin khách hàng thành công!');
            header('Location: /websitePS/public/customers');
            exit();
        }
    }

    public function delete($id) {
        $this->customerModel->deleteCustomer($id);
        $this->setFlashMessage('danger', 'Đã xóa khách hàng thành công!');
        header('Location: /websitePS/public/customers');
        exit();
    }
}