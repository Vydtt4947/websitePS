<?php
// File: app/models/CustomerAuthModel.php
require_once __DIR__ . '/../../config/database.php';

class CustomerAuthModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    /**
     * Kiểm tra xem email của khách hàng đã tồn tại chưa.
     * @param string $email Email cần kiểm tra.
     * @return bool True nếu email đã tồn tại.
     */
    public function checkEmailExists($email) {
        $query = "SELECT MaKH FROM khachhang WHERE Email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    /**
     * Tạo một khách hàng mới.
     * @param array $data Dữ liệu khách hàng (MaKH, HoTen, Email, MatKhau).
     * @return bool True nếu tạo thành công.
     */
    public function createCustomer($data) {
        $hashedPassword = password_hash($data['MatKhau'], PASSWORD_DEFAULT);
        // Giả sử khách hàng mới mặc định thuộc phân loại 1
        $defaultSegment = 1;

        $query = "INSERT INTO khachhang (MaKH, HoTen, Email, MatKhau, MaPL) 
                  VALUES (:maKH, :hoTen, :email, :matKhau, :maPL)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maKH', $data['MaKH']);
        $stmt->bindParam(':hoTen', $data['HoTen']);
        $stmt->bindParam(':email', $data['Email']);
        $stmt->bindParam(':matKhau', $hashedPassword);
        $stmt->bindParam(':maPL', $defaultSegment, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Xác thực thông tin đăng nhập của khách hàng.
     * @param string $email Email khách hàng.
     * @param string $password Mật khẩu khách hàng.
     * @return array|false Trả về thông tin khách hàng nếu thành công.
     */
    public function attemptLogin($email, $password) {
        $query = "SELECT * FROM khachhang WHERE Email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$customer) {
            return false;
        }

        if (isset($customer['MatKhau']) && password_verify($password, $customer['MatKhau'])) {
            return $customer;
        } else {
            return false;
        }
    }
}