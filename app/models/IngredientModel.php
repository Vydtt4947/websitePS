<?php
// File: app/models/IngredientModel.php
require_once __DIR__ . '/../../config/database.php';

class IngredientModel {
    private PDO $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function getIngredientsPaginated(string $searchTerm = '', int $page = 1, int $perPage = 10): array {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM nguyenlieu WHERE TenNL LIKE :kw ORDER BY MaNL DESC LIMIT :limit OFFSET :offset";
        $st = $this->db->prepare($sql);
        $kw = "%" . $searchTerm . "%";
        $st->bindParam(':kw', $kw);
        $st->bindParam(':limit', $perPage, PDO::PARAM_INT);
        $st->bindParam(':offset', $offset, PDO::PARAM_INT);
        $st->execute();
        $items = $st->fetchAll(PDO::FETCH_ASSOC);
        $total = (int)$this->db->query('SELECT FOUND_ROWS()')->fetchColumn();
        return [
            'ingredients' => $items,
            'total' => $total,
            'perPage' => $perPage,
            'currentPage' => $page
        ];
    }

    public function getIngredientById(int $id): ?array {
        $st = $this->db->prepare('SELECT * FROM nguyenlieu WHERE MaNL = :id');
        $st->bindParam(':id', $id, PDO::PARAM_INT);
        $st->execute();
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function createIngredient(string $tenNL, ?string $moTa, ?string $donViTinh, int $soLuong = 0): bool {
        $st = $this->db->prepare('INSERT INTO nguyenlieu (TenNL, MoTa, DonViTinh, SoLuong) VALUES (:ten, :mota, :dvt, :sl)');
        $st->bindParam(':ten', $tenNL);
        $st->bindParam(':mota', $moTa);
        $st->bindParam(':dvt', $donViTinh);
        $st->bindParam(':sl', $soLuong, PDO::PARAM_INT);
        return $st->execute();
    }

    public function updateIngredient(int $id, string $tenNL, ?string $moTa, ?string $donViTinh, int $soLuong): bool {
        $st = $this->db->prepare('UPDATE nguyenlieu SET TenNL = :ten, MoTa = :mota, DonViTinh = :dvt, SoLuong = :sl WHERE MaNL = :id');
        $st->bindParam(':id', $id, PDO::PARAM_INT);
        $st->bindParam(':ten', $tenNL);
        $st->bindParam(':mota', $moTa);
        $st->bindParam(':dvt', $donViTinh);
        $st->bindParam(':sl', $soLuong, PDO::PARAM_INT);
        return $st->execute();
    }

    public function deleteIngredient(int $id): bool {
        $st = $this->db->prepare('DELETE FROM nguyenlieu WHERE MaNL = :id');
        $st->bindParam(':id', $id, PDO::PARAM_INT);
        return $st->execute();
    }
}
