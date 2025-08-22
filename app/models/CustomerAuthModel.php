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
        try {
            // Kiểm tra trong bảng khachhang trước
            $query = "SELECT MaKH FROM khachhang WHERE Email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                return true;
            }
            
            // Kiểm tra trong bảng users để đảm bảo không trùng
            $query = "SELECT user_id FROM users WHERE email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log("Error checking email exists: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Tạo một khách hàng mới.
     * @param array $data Dữ liệu khách hàng (HoTen, Email, MatKhau, SoDienThoai).
     * @return bool True nếu tạo thành công.
     */
    public function createCustomer($data) {
        try {
            // Kiểm tra dữ liệu đầu vào
            if (empty($data['HoTen']) || empty($data['Email']) || empty($data['MatKhau'])) {
                error_log("Missing required data for customer creation");
                return false;
            }
            
            $hashedPassword = password_hash($data['MatKhau'], PASSWORD_DEFAULT);
            
            $this->db->beginTransaction();
            
            // 1. Tạo record trong bảng users
            $username = explode('@', $data['Email'])[0]; // Lấy phần trước @ làm username
            $username = preg_replace('/[^a-zA-Z0-9_.-]/', '', $username) ?: 'user';
            
            // Kiểm tra username đã tồn tại chưa
            $checkUsernameQuery = "SELECT user_id FROM users WHERE username = :username";
            $checkStmt = $this->db->prepare($checkUsernameQuery);
            $checkStmt->bindParam(':username', $username);
            $checkStmt->execute();
            
            if ($checkStmt->rowCount() > 0) {
                // Nếu username đã tồn tại, thêm số ngẫu nhiên
                $username = $username . '_' . substr(uniqid('', true), -4);
            }
            
            $userQuery = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, 'member')";
            $userStmt = $this->db->prepare($userQuery);
            $userStmt->bindParam(':username', $username);
            $userStmt->bindParam(':email', $data['Email']);
            $userStmt->bindParam(':password', $hashedPassword);
            
            try {
                $userStmt->execute();
                error_log("User created successfully with username: " . $username);
            } catch (PDOException $e) {
                // Nếu vẫn lỗi username trùng, thử thêm số khác
                if ($e->getCode() == 23000 && strpos($e->getMessage(), 'username') !== false) {
                    $username = $username . '_' . substr(uniqid('', true), -4);
                    $userStmt->bindParam(':username', $username);
                    $userStmt->execute();
                    error_log("User created with alternative username: " . $username);
                } else {
                    error_log("Error creating user: " . $e->getMessage());
                    throw $e;
                }
            }
            
            $userId = $this->db->lastInsertId();
            error_log("User ID created: " . $userId);
            
            // 2. Tạo record trong bảng khachhang
            $customerQuery = "INSERT INTO khachhang (HoTen, Email, SoDienThoai, user_id, MatKhau) 
                             VALUES (:hoTen, :email, :soDienThoai, :user_id, :matKhau)";
            $customerStmt = $this->db->prepare($customerQuery);
            $customerStmt->bindParam(':hoTen', $data['HoTen']);
            $customerStmt->bindParam(':email', $data['Email']);
            $customerStmt->bindParam(':soDienThoai', $data['SoDienThoai']);
            $customerStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $customerStmt->bindParam(':matKhau', $hashedPassword);
            
            $customerStmt->execute();
            $customerId = $this->db->lastInsertId();
            error_log("Customer created successfully with ID: " . $customerId);
            
            $this->db->commit();
            return true;
            
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error creating customer: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }

    /**
     * Xác thực thông tin đăng nhập của khách hàng.
     * @param string $email Email khách hàng.
     * @param string $password Mật khẩu khách hàng.
     * @return array|false Trả về thông tin khách hàng nếu thành công.
     */
    public function attemptLogin($email, $password) {
        $query = "SELECT kh.*, u.password as user_password 
                  FROM khachhang kh 
                  INNER JOIN users u ON kh.user_id = u.user_id 
                  WHERE kh.Email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$customer) {
            return false;
        }

        // Thử verify password từ bảng users trước
        if (isset($customer['user_password']) && password_verify($password, $customer['user_password'])) {
            // Loại bỏ user_password khỏi kết quả trả về
            unset($customer['user_password']);
            return $customer;
        }
        
        // Nếu không thành công, thử verify từ bảng khachhang (backward compatibility)
        if (isset($customer['MatKhau']) && password_verify($password, $customer['MatKhau'])) {
            return $customer;
        }
        
        return false;
    }

    /**
     * Xóa khách hàng và user tương ứng.
     * @param int $customerId ID khách hàng cần xóa.
     * @return bool True nếu xóa thành công.
     */
    public function deleteCustomer($customerId) {
        try {
            $this->db->beginTransaction();
            
            // 1. Lấy user_id trước khi xóa khách hàng
            $getUserIdQuery = "SELECT user_id FROM khachhang WHERE MaKH = :customerId";
            $getUserIdStmt = $this->db->prepare($getUserIdQuery);
            $getUserIdStmt->bindParam(':customerId', $customerId, PDO::PARAM_INT);
            $getUserIdStmt->execute();
            $customer = $getUserIdStmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$customer) {
                $this->db->rollBack();
                return false; // Khách hàng không tồn tại
            }
            
            $userId = $customer['user_id'];
            
            // 2. Xóa khách hàng trước (vì có foreign key constraint)
            $deleteCustomerStmt = $this->db->prepare("DELETE FROM khachhang WHERE MaKH = :customerId");
            $deleteCustomerStmt->bindParam(':customerId', $customerId, PDO::PARAM_INT);
            $deleteCustomerStmt->execute();
            
            // 3. Xóa user tương ứng
            if ($userId) {
                $roleStmt = $this->db->prepare("SELECT role FROM users WHERE user_id = :uid LIMIT 1");
                $roleStmt->bindParam(':uid', $userId, PDO::PARAM_INT);
                $roleStmt->execute();
                $role = $roleStmt->fetchColumn();
                if ($role && $role !== 'admin') {
                    $deleteUserStmt = $this->db->prepare("DELETE FROM users WHERE user_id = :user_id");
                    $deleteUserStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                    $deleteUserStmt->execute();
                }
            }
            
            $this->db->commit();
            return true;
            
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error deleting customer: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Xóa user theo email (dùng khi cần xóa theo email).
     * @param string $email Email của khách hàng cần xóa.
     * @return bool True nếu xóa thành công.
     */
    public function deleteCustomerByEmail($email) {
        try {
            $this->db->beginTransaction();
            
            // 1. Lấy thông tin khách hàng theo email
            $getCustomerQuery = "SELECT kh.MaKH, kh.user_id 
                                FROM khachhang kh 
                                INNER JOIN users u ON kh.user_id = u.user_id 
                                WHERE kh.Email = :email";
            $getCustomerStmt = $this->db->prepare($getCustomerQuery);
            $getCustomerStmt->bindParam(':email', $email);
            $getCustomerStmt->execute();
            $customer = $getCustomerStmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$customer) {
                $this->db->rollBack();
                return false; // Khách hàng không tồn tại
            }
            
            $customerId = $customer['MaKH'];
            $userId = $customer['user_id'];
            
            // 2. Xóa khách hàng
            $deleteCustomerStmt = $this->db->prepare("DELETE FROM khachhang WHERE MaKH = :customerId");
            $deleteCustomerStmt->bindParam(':customerId', $customerId, PDO::PARAM_INT);
            $deleteCustomerStmt->execute();
            
            // 3. Xóa user
            if ($userId) {
                $roleStmt = $this->db->prepare("SELECT role FROM users WHERE user_id = :uid LIMIT 1");
                $roleStmt->bindParam(':uid', $userId, PDO::PARAM_INT);
                $roleStmt->execute();
                $role = $roleStmt->fetchColumn();
                if ($role && $role !== 'admin') {
                    $deleteUserStmt = $this->db->prepare("DELETE FROM users WHERE user_id = :user_id");
                    $deleteUserStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                    $deleteUserStmt->execute();
                }
            }
            
            $this->db->commit();
            return true;
            
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error deleting customer by email: " . $e->getMessage());
            return false;
        }
    }
}