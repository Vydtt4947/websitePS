<?php
// File: app/models/CustomerModel.php
require_once __DIR__ . '/../../config/database.php';

class CustomerModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function getNewCustomersThisMonth() {
        $query = "SELECT COUNT(MaKH) as count FROM khachhang WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    public function getAllCustomers() {
        $query = "
            SELECT kh.MaKH, kh.HoTen, kh.SoDienThoai, kh.Email, COALESCE(pk.TenPK, 'Chưa phân loại') as TenPK
            FROM khachhang kh
            LEFT JOIN phankhuckh pk ON kh.MaPK = pk.MaPK
            ORDER BY kh.MaKH ASC
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCustomerById($id) {
        $stmt = $this->db->prepare("SELECT * FROM khachhang WHERE MaKH = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllCustomerSegments() {
        $stmt = $this->db->prepare("SELECT * FROM phankhuckh");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function createCustomer($data) {
        // Xử lý MaPK - nếu rỗng hoặc null thì set thành NULL
        $maPK = null;
        if (!empty($data['maPK'])) {
            $maPK = (int)$data['maPK'];
        }
        
        $query = "INSERT INTO khachhang (MaKH, HoTen, SoDienThoai, Email, NgaySinh, MaPK) VALUES (:maKH, :hoTen, :soDienThoai, :email, :ngaySinh, :maPK)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maKH', $data['maKH']);
        $stmt->bindParam(':hoTen', $data['hoTen']);
        $stmt->bindParam(':soDienThoai', $data['soDienThoai']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':ngaySinh', $data['ngaySinh']);
        $stmt->bindValue(':maPK', $maPK, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateCustomer($id, $data) {
        // Xử lý MaPK - nếu rỗng hoặc null thì set thành NULL
        $maPK = null;
        if (!empty($data['maPK'])) {
            $maPK = (int)$data['maPK'];
        }
        
        $query = "UPDATE khachhang SET HoTen = :hoTen, SoDienThoai = :soDienThoai, Email = :email, NgaySinh = :ngaySinh, MaPK = :maPK WHERE MaKH = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':hoTen', $data['hoTen']);
        $stmt->bindParam(':soDienThoai', $data['soDienThoai']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':ngaySinh', $data['ngaySinh']);
        $stmt->bindValue(':maPK', $maPK, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteCustomer($id) {
        try {
            $this->db->beginTransaction();
            
            // 1. Lấy user_id trước khi xóa khách hàng
            $getUserIdQuery = "SELECT user_id FROM khachhang WHERE MaKH = :id";
            $getUserIdStmt = $this->db->prepare($getUserIdQuery);
            $getUserIdStmt->bindParam(':id', $id);
            $getUserIdStmt->execute();
            $customer = $getUserIdStmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$customer) {
                $this->db->rollBack();
                return false; // Khách hàng không tồn tại
            }
            
            $userId = $customer['user_id'];
            
            // 2. Xóa khách hàng trước (vì có foreign key constraint)
            $deleteCustomerStmt = $this->db->prepare("DELETE FROM khachhang WHERE MaKH = :id");
            $deleteCustomerStmt->bindParam(':id', $id);
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
    public function getOrderHistoryByCustomerId($customerId) {
        $query = "
            SELECT dh.MaDH, dh.NgayDatHang, dh.TongTien, dh.TrangThai as TenTrangThai
            FROM donhang dh
            WHERE dh.MaKH = :customerId
            ORDER BY dh.NgayDatHang DESC
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':customerId', $customerId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM khachhang WHERE Email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function registerCustomer($data) {
        $query = "INSERT INTO khachhang (HoTen, Email, SoDienThoai) VALUES (:hoTen, :email, :soDienThoai)";
        $stmt = $this->db->prepare($query);
        
        // Tạo biến trung gian để tránh lỗi bindParam với toán tử ??
        $phone = $data['phone'] ?? '';
        
        $stmt->bindParam(':hoTen', $data['fullname']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':soDienThoai', $phone);
        return $stmt->execute();
    }
    public function updateProfile($id, $data) {
        $query = "UPDATE khachhang SET 
                    HoTen = :hoTen, 
                    SoDienThoai = :soDienThoai, 
                    NgaySinh = :ngaySinh,
                    DiaChiGiaoHang = :diaChiGiaoHang,
                    TinhThanh = :tinhThanh,
                    QuanHuyen = :quanHuyen,
                    GhiChuGiaoHang = :ghiChuGiaoHang
                  WHERE MaKH = :id";
        $stmt = $this->db->prepare($query);
        
        // Tạo biến trung gian để tránh lỗi bindParam với toán tử ??
        $diaChiGiaoHang = $data['DiaChiGiaoHang'] ?? '';
        $tinhThanh = $data['TinhThanh'] ?? '';
        $quanHuyen = $data['QuanHuyen'] ?? '';
        $ghiChuGiaoHang = $data['GhiChuGiaoHang'] ?? '';
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':hoTen', $data['HoTen']);
        $stmt->bindParam(':soDienThoai', $data['SoDienThoai']);
        $stmt->bindParam(':ngaySinh', $data['NgaySinh']);
        $stmt->bindParam(':diaChiGiaoHang', $diaChiGiaoHang);
        $stmt->bindParam(':tinhThanh', $tinhThanh);
        $stmt->bindParam(':quanHuyen', $quanHuyen);
        $stmt->bindParam(':ghiChuGiaoHang', $ghiChuGiaoHang);
        return $stmt->execute();
    }

    // PHƯƠNG THỨC TÍNH TOÁN VÀ CẬP NHẬT PHÂN LOẠI KHÁCH HÀNG
    public function updateCustomerTier($customerId) {
        // Lấy phân loại hiện tại của khách hàng
        $currentTierQuery = "SELECT kh.MaPK, pk.TenPK 
                            FROM khachhang kh 
                            LEFT JOIN phankhuckh pk ON kh.MaPK = pk.MaPK 
                            WHERE kh.MaKH = :customerId";
        $currentStmt = $this->db->prepare($currentTierQuery);
        $currentStmt->bindParam(':customerId', $customerId);
        $currentStmt->execute();
        $currentResult = $currentStmt->fetch(PDO::FETCH_ASSOC);
        $currentTier = $currentResult['TenPK'] ?? 'Chưa phân loại';

        // Tính tổng tiền mua hàng của khách hàng (chỉ tính đơn hàng đã hoàn thành)
        $query = "SELECT COALESCE(SUM(TongTien), 0) as totalSpent 
                  FROM donhang 
                  WHERE MaKH = :customerId AND TrangThai = 'Delivered'";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':customerId', $customerId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalSpent = $result['totalSpent'];

        // Xác định phân loại dựa trên tổng tiền mua hàng
        $newTier = null;
        $newTierName = '';
        if ($totalSpent >= 20000000) { // 20 triệu VND
            $newTier = 6; // VIP
            $newTierName = 'VIP';
        } elseif ($totalSpent >= 10000000) { // 10 triệu VND
            $newTier = 5; // Diamond
            $newTierName = 'Diamond';
        } elseif ($totalSpent >= 5000000) { // 5 triệu VND
            $newTier = 4; // Platinum
            $newTierName = 'Platinum';
        } elseif ($totalSpent >= 2000000) { // 2 triệu VND
            $newTier = 3; // Gold
            $newTierName = 'Gold';
        } elseif ($totalSpent >= 1000000) { // 1 triệu VND
            $newTier = 2; // Silver
            $newTierName = 'Silver';
        } elseif ($totalSpent >= 500000) { // 500k VND
            $newTier = 1; // Bronze
            $newTierName = 'Bronze';
        }

        // Kiểm tra xem có thay đổi cấp không
        $hasChanged = false;
        $changeType = '';
        
        if ($newTier !== null) {
            // Logic lên cấp
            if ($currentTier === 'Chưa phân loại' && $newTierName !== 'Chưa phân loại') {
                $hasChanged = true;
                $changeType = 'upgrade';
            } elseif ($currentTier === 'Bronze' && in_array($newTierName, ['Silver', 'Gold', 'Platinum', 'Diamond', 'VIP'])) {
                $hasChanged = true;
                $changeType = 'upgrade';
            } elseif ($currentTier === 'Silver' && in_array($newTierName, ['Gold', 'Platinum', 'Diamond', 'VIP'])) {
                $hasChanged = true;
                $changeType = 'upgrade';
            } elseif ($currentTier === 'Gold' && in_array($newTierName, ['Platinum', 'Diamond', 'VIP'])) {
                $hasChanged = true;
                $changeType = 'upgrade';
            } elseif ($currentTier === 'Platinum' && in_array($newTierName, ['Diamond', 'VIP'])) {
                $hasChanged = true;
                $changeType = 'upgrade';
            } elseif ($currentTier === 'Diamond' && $newTierName === 'VIP') {
                $hasChanged = true;
                $changeType = 'upgrade';
            }
            
            // Logic hạ cấp
            elseif ($currentTier === 'VIP' && in_array($newTierName, ['Diamond', 'Platinum', 'Gold', 'Silver', 'Bronze', 'Chưa phân loại'])) {
                $hasChanged = true;
                $changeType = 'downgrade';
            } elseif ($currentTier === 'Diamond' && in_array($newTierName, ['Platinum', 'Gold', 'Silver', 'Bronze', 'Chưa phân loại'])) {
                $hasChanged = true;
                $changeType = 'downgrade';
            } elseif ($currentTier === 'Platinum' && in_array($newTierName, ['Gold', 'Silver', 'Bronze', 'Chưa phân loại'])) {
                $hasChanged = true;
                $changeType = 'downgrade';
            } elseif ($currentTier === 'Gold' && in_array($newTierName, ['Silver', 'Bronze', 'Chưa phân loại'])) {
                $hasChanged = true;
                $changeType = 'downgrade';
            } elseif ($currentTier === 'Silver' && in_array($newTierName, ['Bronze', 'Chưa phân loại'])) {
                $hasChanged = true;
                $changeType = 'downgrade';
            } elseif ($currentTier === 'Bronze' && $newTierName === 'Chưa phân loại') {
                $hasChanged = true;
                $changeType = 'downgrade';
            }
        }

        // Cập nhật phân loại khách hàng
        if ($newTier !== null) {
            $updateQuery = "UPDATE khachhang SET MaPK = :maPK WHERE MaKH = :customerId";
            $updateStmt = $this->db->prepare($updateQuery);
            $updateStmt->bindParam(':maPK', $newTier, PDO::PARAM_INT);
            $updateStmt->bindParam(':customerId', $customerId);
            $result = $updateStmt->execute();

            // Nếu có thay đổi cấp, lưu thông tin để hiển thị thông báo
            if ($hasChanged && $result) {
                $this->saveTierChangeNotification($customerId, $newTierName, $totalSpent, $changeType);
            }

            return $result;
        }

        return true;
    }

    // PHƯƠNG THỨC LƯU THÔNG BÁO THAY ĐỔI CẤP
    private function saveTierChangeNotification($customerId, $newTier, $totalSpent, $changeType) {
        // Lưu vào session để hiển thị thông báo
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $_SESSION['tier_change'] = [
            'customer_id' => $customerId,
            'new_tier' => $newTier,
            'total_spent' => $totalSpent,
            'change_type' => $changeType,
            'timestamp' => time()
        ];
    }

    // PHƯƠNG THỨC KIỂM TRA VÀ LẤY THÔNG BÁO THAY ĐỔI CẤP
    public function getTierChangeNotification() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (isset($_SESSION['tier_change'])) {
            $notification = $_SESSION['tier_change'];
            unset($_SESSION['tier_change']); // Xóa sau khi lấy
            return $notification;
        }
        
        return null;
    }

    // PHƯƠNG THỨC LẤY THÔNG TIN PHÂN LOẠI VÀ TIẾN ĐỘ
    public function getCustomerTierInfo($customerId) {
        // Lấy thông tin phân loại hiện tại
        $query = "SELECT kh.MaPK, pk.TenPK, pk.MoTa,
                         COALESCE(SUM(CASE WHEN dh.TrangThai = 'Delivered' THEN dh.TongTien ELSE 0 END), 0) as totalSpent
                  FROM khachhang kh
                  LEFT JOIN phankhuckh pk ON kh.MaPK = pk.MaPK
                  LEFT JOIN donhang dh ON kh.MaKH = dh.MaKH
                  WHERE kh.MaKH = :customerId
                  GROUP BY kh.MaKH, kh.MaPK, pk.TenPK, pk.MoTa";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':customerId', $customerId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        // Tính toán thông tin phân loại
        $totalSpent = $result['totalSpent'];
        $currentTier = $result['TenPK'] ?? 'Chưa phân loại';
        
        // Xác định phân loại tiếp theo và tiến độ
        $nextTier = null;
        $progressToNext = 0;
        $amountNeeded = 0;

        if ($totalSpent < 500000) {
            $nextTier = 'Bronze';
            $amountNeeded = 500000 - $totalSpent;
            $progressToNext = ($totalSpent / 500000) * 100;
        } elseif ($totalSpent < 1000000) {
            $nextTier = 'Silver';
            $amountNeeded = 1000000 - $totalSpent;
            $progressToNext = (($totalSpent - 500000) / 500000) * 100;
        } elseif ($totalSpent < 2000000) {
            $nextTier = 'Gold';
            $amountNeeded = 2000000 - $totalSpent;
            $progressToNext = (($totalSpent - 1000000) / 1000000) * 100;
        } elseif ($totalSpent < 5000000) {
            $nextTier = 'Platinum';
            $amountNeeded = 5000000 - $totalSpent;
            $progressToNext = (($totalSpent - 2000000) / 3000000) * 100;
        } elseif ($totalSpent < 10000000) {
            $nextTier = 'Diamond';
            $amountNeeded = 10000000 - $totalSpent;
            $progressToNext = (($totalSpent - 5000000) / 5000000) * 100;
        } elseif ($totalSpent < 20000000) {
            $nextTier = 'VIP';
            $amountNeeded = 20000000 - $totalSpent;
            $progressToNext = (($totalSpent - 10000000) / 10000000) * 100;
        } else {
            $nextTier = 'Đã đạt cấp cao nhất';
            $progressToNext = 100;
        }

        return [
            'currentTier' => $currentTier,
            'totalSpent' => $totalSpent,
            'nextTier' => $nextTier,
            'amountNeeded' => $amountNeeded,
            'progressToNext' => min(100, max(0, $progressToNext))
        ];
    }

}