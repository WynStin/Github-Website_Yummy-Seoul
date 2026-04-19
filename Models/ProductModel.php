<?php
class ProductModel
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function getProducts($category = 'all', $search = '', $sort = 'default', $minPrice = null, $maxPrice = null, $limit = 6, $offset = 0)
    {
        $whereClauses = [];
        $params = [];

        // Lọc theo danh mục
        if (!empty($category) && $category !== 'all') {
            $whereClauses[] = "id_danh_muc = :cat";
            $params[':cat'] = $category;
        }

        // Lọc theo từ khóa (Xóa bỏ BINARY để tìm kiếm tiếng Việt chuẩn hơn)
        // Lọc theo từ khóa (Tìm theo tên HOẶC giá nếu là số)
        if (!empty($search)) {
            if (is_numeric($search)) {
                // Tìm tên chứa số đó HOẶC giá bằng đúng số đó
                $whereClauses[] = "(ten_mon LIKE :search_text OR gia_ban = :search_price)";
                $params[':search_text'] = "%$search%";
                $params[':search_price'] = (float)$search;
            } else {
                // Nếu là chữ, chỉ tìm theo tên
                $whereClauses[] = "ten_mon LIKE :search_text";
                $params[':search_text'] = "%$search%";
            }
        }

        // Lọc theo giá (Ép kiểu float để so sánh với decimal trong DB)
        if ($minPrice !== '' && $minPrice !== null) {
            $whereClauses[] = "gia_ban >= :minPrice";
            $params[':minPrice'] = (float)$minPrice;
        }
        if ($maxPrice !== '' && $maxPrice !== null) {
            $whereClauses[] = "gia_ban <= :maxPrice";
            $params[':maxPrice'] = (float)$maxPrice;
        }

        $where = !empty($whereClauses) ? "WHERE " . implode(" AND ", $whereClauses) : "";

        $orderBy = "ORDER BY id_mon_an DESC";
        switch ($sort) {
            case 'priceAsc':
                $orderBy = "ORDER BY gia_ban ASC";
                break;
            case 'priceDesc':
                $orderBy = "ORDER BY gia_ban DESC";
                break;
            case 'nameAsc':
                $orderBy = "ORDER BY ten_mon ASC";
                break;
            case 'nameDesc':
                $orderBy = "ORDER BY ten_mon DESC";
                break;
        }

        $sql = "SELECT * FROM mon_an $where $orderBy LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countProducts($category = 'all', $search = '', $minPrice = null, $maxPrice = null)
    {
        $whereClauses = [];
        $params = [];
        if (!empty($category) && $category !== 'all') {
            $whereClauses[] = "id_danh_muc = :cat";
            $params[':cat'] = $category;
        }
        // Tìm đến hàm getProducts trong ProductModel.php và thay thế đoạn if (!empty($search))
        // Lọc theo từ khóa (Cập nhật để hỗ trợ tìm cả giá tiền)
        // Lọc theo từ khóa (Tìm theo tên HOẶC giá nếu là số)
        if (!empty($search)) {
            if (is_numeric($search)) {
                $whereClauses[] = "(ten_mon LIKE :search_text OR gia_ban = :search_price)";
                $params[':search_text'] = "%$search%";
                $params[':search_price'] = (float)$search;
            } else {
                $whereClauses[] = "ten_mon LIKE :search_text";
                $params[':search_text'] = "%$search%";
            }
        }
        if ($minPrice !== '' && $minPrice !== null) {
            $whereClauses[] = "gia_ban >= :minPrice";
            $params[':minPrice'] = (float)$minPrice;
        }
        if ($maxPrice !== '' && $maxPrice !== null) {
            $whereClauses[] = "gia_ban <= :maxPrice";
            $params[':maxPrice'] = (float)$maxPrice;
        }

        $where = !empty($whereClauses) ? "WHERE " . implode(" AND ", $whereClauses) : "";
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM mon_an $where");
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

    // Các hàm Top 10 theo yêu cầu
    public function getTop10BestSeller()
    {
        return $this->db->query("SELECT * FROM mon_an ORDER BY so_luong_da_ban DESC LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTop10MostViewed()
    {
        return $this->db->query("SELECT * FROM mon_an ORDER BY so_luot_xem DESC LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTop10Newest()
    {
        return $this->db->query("SELECT * FROM mon_an ORDER BY id_mon_an DESC LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function incrementViewCount($id)
    {
        $stmt = $this->db->prepare("UPDATE mon_an SET so_luot_xem = so_luot_xem + 1 WHERE id_mon_an = :id");
        return $stmt->execute([':id' => $id]);
    }
}
