<?php
session_start();

// 1. Khai báo các thông số kết nối
$host = 'localhost';
$db   = 'yummy_seoul';
$user = 'root';
$pass = ''; // Mặc định của XAMPP là trống
$charset = 'utf8mb4';

// 2. Thiết lập chuỗi DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// 3. Các tùy chọn cấu hình cho PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // 4. Tạo đối tượng kết nối PDO
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // 5. Xử lý lỗi nếu kết nối thất bại
    die("Lỗi kết nối CSDL: " . $e->getMessage());
}

/**
 * Lấy chi tiết 1 món ăn theo ID
 */
function getProductById($id)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM mon_an WHERE id_mon_an = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}

/**
 * Lấy danh sách món ăn có lọc, tìm kiếm, sắp xếp và phân trang
 */
function getProducts($category = 'all', $search = '', $sort = 'default', $minPrice = null, $maxPrice = null, $limit = 6, $offset = 0)
{
    global $pdo;
    $whereClauses = [];
    $params = [];

    // Lọc theo danh mục
    if (!empty($category) && $category !== 'all') {
        $whereClauses[] = "id_danh_muc = :cat";
        $params[':cat'] = $category;
    }

    // Tìm kiếm theo tên hoặc giá
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

    // Lọc theo khoảng giá
    if ($minPrice !== '' && $minPrice !== null) {
        $whereClauses[] = "gia_ban >= :minPrice";
        $params[':minPrice'] = (float)$minPrice;
    }
    if ($maxPrice !== '' && $maxPrice !== null) {
        $whereClauses[] = "gia_ban <= :maxPrice";
        $params[':maxPrice'] = (float)$maxPrice;
    }

    $where = !empty($whereClauses) ? "WHERE " . implode(" AND ", $whereClauses) : "";

    // Sắp xếp
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
    $stmt = $pdo->prepare($sql);

    // Bind các giá trị tham số
    foreach ($params as $key => $val) {
        $stmt->bindValue($key, $val);
    }
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll();
}

/**
 * Đếm tổng số món ăn theo điều kiện lọc (dùng để phân trang)
 */
function countProducts($category = 'all', $search = '', $minPrice = null, $maxPrice = null)
{
    global $pdo;
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
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM mon_an $where");
    $stmt->execute($params);
    return $stmt->fetchColumn();
}

/**
 * Top 10 sản phẩm bán chạy nhất
 */
function getTop10BestSeller()
{
    global $pdo;
    return $pdo->query("SELECT * FROM mon_an ORDER BY so_luong_da_ban DESC LIMIT 10")->fetchAll();
}

/**
 * Top 10 sản phẩm xem nhiều nhất
 */
function getTop10MostViewed()
{
    global $pdo;
    return $pdo->query("SELECT * FROM mon_an ORDER BY so_luot_xem DESC LIMIT 10")->fetchAll();
}

/**
 * Top 10 sản phẩm mới nhất
 */
function getTop10Newest()
{
    global $pdo;
    return $pdo->query("SELECT * FROM mon_an ORDER BY ngay_tao DESC LIMIT 10")->fetchAll();
}
?>