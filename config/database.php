<?php
// File: config/database.php

class Database {
    // Khai báo thông tin kết nối CSDL
    private $host = "localhost"; // hoặc localhost
    private $db_name = "cake_shop";
    private $username = "root";
    private $password = ""; // Mật khẩu của bạn, nếu có
    private $conn;

    /**
     * Phương thức này sẽ tạo và trả về một đối tượng kết nối PDO
     * @return PDO|null Đối tượng kết nối hoặc null nếu thất bại
     * @throws PDOException Nếu kết nối thất bại
     */
    public function getConnection() {
        $this->conn = null;

        try {
            // Tạo chuỗi DSN (Data Source Name)
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8";
            
            // Tạo đối tượng PDO
            $this->conn = new PDO($dsn, $this->username, $this->password);
            
            // Thiết lập chế độ báo lỗi để hiển thị các ngoại lệ
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Đặt chế độ fetch mặc định là mảng kết hợp
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        } catch(PDOException $exception) {
            // Ném ngoại lệ để các lớp khác xử lý (thay vì chỉ echo)
            throw new PDOException("Lỗi kết nối: " . $exception->getMessage());
        }

        return $this->conn;
    }
}