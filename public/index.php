<?php
session_start(); // LUÔN LÀ DÒNG ĐẦU TIÊN

// Bật hiển thị lỗi để dễ dàng gỡ rối trong quá trình phát triển
ini_set('display_errors', 1);
error_reporting(E_ALL);

// --- PHẦN ĐIỀU HƯỚNG (ROUTING & DISPATCHER) ---

$controllerName = null;
$actionName = null;
$params = [];

// Ưu tiên xử lý routing dựa trên query string (?controller=...&action=...)
if (isset($_GET['controller'])) {
    $controllerName = ucfirst($_GET['controller']) . 'Controller';
    $actionName = $_GET['action'] ?? 'index';
    $params = [];
}
// Nếu không có query string, xử lý routing dựa trên URL thân thiện (/controller/action/...)
else {
    $base_path = '/websitePS/public';
    $request_uri = $_SERVER['REQUEST_URI'];
    $request_path = strtok($request_uri, '?');
    $route = '/';
    if (substr($request_path, 0, strlen($base_path)) == $base_path) {
        $route = substr($request_path, strlen($base_path));
    }
    $route = trim($route, '/');
    $segments = explode('/', $route);

    // === DÒNG SỬA LỖI NẰM Ở ĐÂY ===
    // Nếu không có segment nào, đặt controller mặc định là 'home' cho trang người dùng
    if (empty($segments[0])) {
        $segments[0] = 'home';
    }

    $controllerName = ucfirst($segments[0]) . 'Controller';
    $actionName = $segments[1] ?? 'index';
    $params = array_slice($segments, 2);
}


// --- PHẦN ĐIỀU HƯỚNG (DISPATCHER) - Giữ nguyên logic của bạn ---
$controllerFile = __DIR__ . '/../app/controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    if (class_exists($controllerName)) {
        $controller = new $controllerName();
        if (method_exists($controller, $actionName)) {
            call_user_func_array([$controller, $actionName], $params);
        } else {
            echo "Lỗi 404: Không tìm thấy hành động '{$actionName}' trong controller '{$controllerName}'.";
        }
    } else {
        echo "Lỗi 404: Không tìm thấy class '{$controllerName}'.";
    }
} else {
    echo "Lỗi 404: Không tìm thấy file controller '{$controllerFile}'.";
}