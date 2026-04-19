<?php
class ProductModel
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    // Lấy thông tin chi tiết 1 món ăn (BỔ SUNG)
    public function getProductById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM mon_an WHERE id_mon_an = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getProducts($category = 'all', $search = '', $sort = 'default', $minPrice = null, $maxPrice = null, $limit = 6, $offset = 0)
    {
        $whereClauses = [];
        $params = [];

        if (!empty($category) && $category !== 'all') {
            $whereClauses[] = "id_danh_muc = :cat";
            $params[':cat'] = $category;
        }

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

        $orderBy = "ORDER BY id_mon_an DESC";
        switch ($sort) {
            case 'priceAsc': $orderBy = "ORDER BY gia_ban ASC"; break;
            case 'priceDesc': $orderBy = "ORDER BY gia_ban DESC"; break;
            case 'nameAsc': $orderBy = "ORDER BY ten_mon ASC"; break;
            case 'nameDesc': $orderBy = "ORDER BY ten_mon DESC"; break;
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
        return $this->db->query("SELECT * FROM mon_an ORDER BY ngay_tao DESC LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function incrementViewCount($id)
    {
        $stmt = $this->db->prepare("UPDATE mon_an SET so_luot_xem = so_luot_xem + 1 WHERE id_mon_an = :id");
        return $stmt->execute([':id' => $id]);
    }
}