<?php
// File: app/models/WarehouseModel.php
// Quản lý tồn kho sản phẩm và nguyên liệu
require_once __DIR__ . '/../../config/database.php';

class WarehouseModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    // ============ STOCK GETTERS ============
    public function getProductStock(int $productId): int {
        $sql = "SELECT SoLuong FROM sanpham WHERE MaSP = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)($row['SoLuong'] ?? 0);
    }

    public function getIngredientStock(int $ingredientId): int {
        $sql = "SELECT SoLuong FROM nguyenlieu WHERE MaNL = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $ingredientId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)($row['SoLuong'] ?? 0);
    }

    // ============ STOCK ADJUSTMENT (PRODUCT) ============
    public function importProduct(int $productId, int $quantity, ?int $employeeId = null): bool {
        if ($quantity <= 0) return false;
        return $this->adjustProductStock($productId, $quantity, $employeeId);
    }

    public function exportProduct(int $productId, int $quantity, ?int $employeeId = null): bool {
        if ($quantity <= 0) return false;
        return $this->adjustProductStock($productId, -$quantity, $employeeId);
    }

    public function adjustProductStock(int $productId, int $change, ?int $employeeId = null): bool {
        try {
            $this->db->beginTransaction();

            // Kiểm tra tồn kho hiện tại
            $current = $this->getProductStock($productId);
            $newQty = $current + $change;
            if ($newQty < 0) {
                throw new Exception('Số lượng xuất vượt quá tồn kho hiện tại.');
            }

            // Cập nhật tồn kho sản phẩm
            $update = $this->db->prepare("UPDATE sanpham SET SoLuong = SoLuong + :change WHERE MaSP = :id");
            $update->bindParam(':change', $change, PDO::PARAM_INT);
            $update->bindParam(':id', $productId, PDO::PARAM_INT);
            $update->execute();

            // Ghi nhận giao dịch kho
            $type = $change >= 0 ? 'Nhap' : 'Xuat';
            $qty = abs($change);
            $log = $this->db->prepare(
                "INSERT INTO kho (MaSP, MaNV, NgayGiaoDich, LoaiGiaoDich, SoLuong) VALUES (:maSP, :maNV, NOW(3), :loai, :soLuong)"
            );
            $log->bindParam(':maSP', $productId, PDO::PARAM_INT);
            if ($employeeId === null) {
                $log->bindValue(':maNV', null, PDO::PARAM_NULL);
            } else {
                $log->bindValue(':maNV', $employeeId, PDO::PARAM_INT);
            }
            $log->bindParam(':loai', $type);
            $log->bindParam(':soLuong', $qty, PDO::PARAM_INT);
            $log->execute();

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('adjustProductStock error: ' . $e->getMessage());
            return false;
        }
    }

    // ============ STOCK ADJUSTMENT (INGREDIENT) ============
    public function importIngredient(int $ingredientId, int $quantity, ?int $employeeId = null): bool {
        if ($quantity <= 0) return false;
        return $this->adjustIngredientStock($ingredientId, $quantity, $employeeId);
    }

    public function exportIngredient(int $ingredientId, int $quantity, ?int $employeeId = null): bool {
        if ($quantity <= 0) return false;
        return $this->adjustIngredientStock($ingredientId, -$quantity, $employeeId);
    }

    public function adjustIngredientStock(int $ingredientId, int $change, ?int $employeeId = null): bool {
        try {
            $this->db->beginTransaction();

            // Kiểm tra tồn kho hiện tại
            $current = $this->getIngredientStock($ingredientId);
            $newQty = $current + $change;
            if ($newQty < 0) {
                throw new Exception('Số lượng nguyên liệu xuất vượt quá tồn kho hiện tại.');
            }

            // Cập nhật tồn kho nguyên liệu
            $update = $this->db->prepare("UPDATE nguyenlieu SET SoLuong = SoLuong + :change WHERE MaNL = :id");
            $update->bindParam(':change', $change, PDO::PARAM_INT);
            $update->bindParam(':id', $ingredientId, PDO::PARAM_INT);
            $update->execute();

            // Ghi nhận giao dịch kho
            $type = $change >= 0 ? 'Nhap' : 'Xuat';
            $qty = abs($change);
            $log = $this->db->prepare(
                "INSERT INTO kho (MaNL, MaNV, NgayGiaoDich, LoaiGiaoDich, SoLuong) VALUES (:maNL, :maNV, NOW(3), :loai, :soLuong)"
            );
            $log->bindParam(':maNL', $ingredientId, PDO::PARAM_INT);
            if ($employeeId === null) {
                $log->bindValue(':maNV', null, PDO::PARAM_NULL);
            } else {
                $log->bindValue(':maNV', $employeeId, PDO::PARAM_INT);
            }
            $log->bindParam(':loai', $type);
            $log->bindParam(':soLuong', $qty, PDO::PARAM_INT);
            $log->execute();

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('adjustIngredientStock error: ' . $e->getMessage());
            return false;
        }
    }

    // ============ TRANSACTIONS LISTING ============
    public function getTransactions(array $filters = [], int $limit = 20, int $offset = 0): array {
        $where = [];
        $params = [];

        if (!empty($filters['type'])) {
            $where[] = 'k.LoaiGiaoDich = :type';
            $params[':type'] = $filters['type']; // 'Nhap' | 'Xuat'
        }
        if (!empty($filters['productId'])) {
            $where[] = 'k.MaSP = :maSP';
            $params[':maSP'] = (int)$filters['productId'];
        }
        if (!empty($filters['ingredientId'])) {
            $where[] = 'k.MaNL = :maNL';
            $params[':maNL'] = (int)$filters['ingredientId'];
        }
        if (!empty($filters['from'])) {
            $where[] = 'k.NgayGiaoDich >= :from';
            $params[':from'] = $filters['from']; // Y-m-d or datetime
        }
        if (!empty($filters['to'])) {
            $where[] = 'k.NgayGiaoDich <= :to';
            $params[':to'] = $filters['to'];
        }

        $whereSql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

        $sql = "
            SELECT k.*, sp.TenSP, nl.TenNL, nv.HoTen AS TenNV
            FROM kho k
            LEFT JOIN sanpham sp ON k.MaSP = sp.MaSP
            LEFT JOIN nguyenlieu nl ON k.MaNL = nl.MaNL
            LEFT JOIN nhanvien nv ON k.MaNV = nv.MaNV
            $whereSql
            ORDER BY k.NgayGiaoDich DESC, k.MaKho DESC
            LIMIT :limit OFFSET :offset
        ";
        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Total count for pagination
        $countSql = "SELECT COUNT(*) FROM kho k $whereSql";
        $countStmt = $this->db->prepare($countSql);
        foreach ($params as $key => $value) {
            $countStmt->bindValue($key, $value);
        }
        $countStmt->execute();
        $total = (int)$countStmt->fetchColumn();

        return [
            'items' => $rows,
            'total' => $total,
            'limit' => $limit,
            'offset' => $offset,
        ];
    }

    // ============ LOW STOCK REPORTS ============
    public function getLowStockProducts(int $threshold = 5): array {
        $sql = "SELECT MaSP, TenSP, SoLuong FROM sanpham WHERE SoLuong <= :threshold ORDER BY SoLuong ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':threshold', $threshold, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLowStockIngredients(int $threshold = 10): array {
        $sql = "SELECT MaNL, TenNL, SoLuong FROM nguyenlieu WHERE SoLuong <= :threshold ORDER BY SoLuong ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':threshold', $threshold, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ============ INVENTORY SUMMARY ============
    public function getInventorySummary(): array {
        $productSummary = $this->db->query("SELECT COUNT(*) AS total_items, COALESCE(SUM(SoLuong),0) AS total_qty FROM sanpham")->fetch(PDO::FETCH_ASSOC);
        $ingredientSummary = $this->db->query("SELECT COUNT(*) AS total_items, COALESCE(SUM(SoLuong),0) AS total_qty FROM nguyenlieu")->fetch(PDO::FETCH_ASSOC);
        return [
            'products' => [
                'count' => (int)($productSummary['total_items'] ?? 0),
                'quantity' => (int)($productSummary['total_qty'] ?? 0),
            ],
            'ingredients' => [
                'count' => (int)($ingredientSummary['total_items'] ?? 0),
                'quantity' => (int)($ingredientSummary['total_qty'] ?? 0),
            ],
        ];
    }

    // ============ ORDER STOCK APPLICATION ============
    // Trừ tồn kho theo chi tiết đơn hàng (xuất kho)
    public function applyOrderStockDeduction(int $orderId, ?int $employeeId = null): bool {
        try {
            $this->db->beginTransaction();

            // Lấy chi tiết đơn hàng
            $detailSql = "
                SELECT ctdh.MaSP, ctdh.SoLuong
                FROM chitietdonhang ctdh
                WHERE ctdh.MaDH = :maDH
            ";
            $stmt = $this->db->prepare($detailSql);
            $stmt->bindParam(':maDH', $orderId, PDO::PARAM_INT);
            $stmt->execute();
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Kiểm tra tồn kho đủ để trừ
            foreach ($items as $item) {
                $available = $this->getProductStock((int)$item['MaSP']);
                if ($available < (int)$item['SoLuong']) {
                    throw new Exception('Không đủ tồn kho cho sản phẩm ID ' . $item['MaSP']);
                }
            }

            // Thực hiện trừ tồn và ghi log
            foreach ($items as $item) {
                $this->adjustProductStock((int)$item['MaSP'], -((int)$item['SoLuong']), $employeeId);
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('applyOrderStockDeduction error: ' . $e->getMessage());
            return false;
        }
    }

    // Hoàn lại tồn kho nếu đơn bị hủy
    public function revertOrderStock(int $orderId, ?int $employeeId = null): bool {
        try {
            $this->db->beginTransaction();

            $detailSql = "
                SELECT ctdh.MaSP, ctdh.SoLuong
                FROM chitietdonhang ctdh
                WHERE ctdh.MaDH = :maDH
            ";
            $stmt = $this->db->prepare($detailSql);
            $stmt->bindParam(':maDH', $orderId, PDO::PARAM_INT);
            $stmt->execute();
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($items as $item) {
                $this->adjustProductStock((int)$item['MaSP'], (int)$item['SoLuong'], $employeeId);
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('revertOrderStock error: ' . $e->getMessage());
            return false;
        }
    }
}
