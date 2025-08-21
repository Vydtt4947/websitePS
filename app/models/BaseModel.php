<?php

class BaseModel {
    protected $conn;

    public function __construct() {
        // Thay đổi thông tin kết nối cho phù hợp với cấu hình của bạn
        $host = '127.0.0.1';
        $dbname = 'cake_shop_remake'; // Tên CSDL bạn đã cung cấp
        $user = 'root';
        $password = ''; // Mật khẩu của bạn

        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
            // Thiết lập chế độ báo lỗi để dễ dàng gỡ rối
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Dừng chương trình nếu không thể kết nối
            die("Lỗi kết nối CSDL: " . $e->getMessage());
        }
    }
}