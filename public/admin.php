<?php
// File: public/admin.php
session_start();

// Hiển thị lỗi khi dev
ini_set('display_errors', 1);
error_reporting(E_ALL);

// ---- ROUTER ----
$controllerSlug = isset($_GET['controller']) ? strtolower($_GET['controller']) : 'admin';
$actionName     = $_GET['action'] ?? 'index';
$id             = $_GET['id'] ?? null;

// Sanitize
if (!preg_match('/^[a-zA-Z0-9_]+$/', $controllerSlug)) { http_response_code(400); exit('Invalid controller'); }
if (!preg_match('/^[a-zA-Z0-9_]+$/', $actionName))     { http_response_code(400); exit('Invalid action'); }

// Cho phép vào auth khi chưa đăng nhập
$isAuth = ($controllerSlug === 'auth');
if (!$isAuth) {
    $role = $_SESSION['role'] ?? null;
    if (!isset($_SESSION['user_id'], $role) || !in_array($role, ['admin','staff'], true)) {
        $base = rtrim(str_replace('\\','/', dirname($_SERVER['PHP_SELF'])), '/');
        header('Location: '.$base.'/admin.php?controller=auth');
        exit();
    }
}

// Nạp controller
$controllerClassName = ucfirst($controllerSlug) . 'Controller';
$controllerFile      = __DIR__ . '/../app/controllers/' . $controllerClassName . '.php';

if (!file_exists($controllerFile)) {
    http_response_code(404);
    echo "Lỗi 404: Không tìm thấy file controller '{$controllerFile}'.";
    exit();
}

require_once $controllerFile;

if (!class_exists($controllerClassName)) {
    http_response_code(404);
    echo "Lỗi 404: Không tìm thấy class '{$controllerClassName}'.";
    exit();
}

$controller = new $controllerClassName();

if (!method_exists($controller, $actionName)) {
    http_response_code(404);
    echo "Lỗi 404: Không tìm thấy action '{$actionName}' trong '{$controllerClassName}'.";
    exit();
}

// Gọi action
$id !== null
    ? call_user_func_array([$controller, $actionName], [$id])
    : call_user_func([$controller, $actionName]);
