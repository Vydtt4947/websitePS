<?php
session_start();

// Bật hiển thị lỗi để dễ dàng gỡ rối
ini_set('display_errors', 1);
error_reporting(E_ALL);

// --- PHẦN ĐIỀU HƯỚNG CHO ADMIN ---
$controllerNameStr = null;
$actionName = null;

// Routing cho admin sẽ dựa hoàn toàn vào query string (?controller=...&action=...)
if (isset($_GET['controller'])) {
    $controllerNameStr = $_GET['controller'];
    $actionName = $_GET['action'] ?? 'index';
} else {
    // Controller mặc định khi truy cập /admin.php là AdminController
    $controllerNameStr = 'admin'; // Sử dụng tên ngắn gọn, ví dụ: 'admin', 'customers'
    $actionName = 'index';
}

// === PHẦN SỬA LỖI NẰM Ở ĐÂY ===
// 1. Viết hoa chữ cái đầu và thêm hậu tố 'Controller'
$controllerClassName = ucfirst($controllerNameStr) . 'Controller';
// 2. Thêm hậu tố '.php' để tạo tên file hoàn chỉnh
$controllerFile = __DIR__ . '/../app/controllers/' . $controllerClassName . '.php';


if (file_exists($controllerFile)) {
    require_once $controllerFile;
    if (class_exists($controllerClassName)) {
        $controller = new $controllerClassName();
        
        $id = $_GET['id'] ?? null;
        
        if (method_exists($controller, $actionName)) {
            // Gọi phương thức và truyền id vào nếu có
            call_user_func_array([$controller, $actionName], $id ? [$id] : []);
        } else {
            echo "Lỗi 404: Không tìm thấy hành động '{$actionName}' trong controller '{$controllerClassName}'.";
        }
    } else {
        echo "Lỗi 404: Không tìm thấy class '{$controllerClassName}'.";
    }
} else {
    echo "Lỗi 404: Không tìm thấy file controller '{$controllerFile}'.";
}