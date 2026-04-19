<?php 
// Kết nối CSDL
include '../../SQL_Connect/db.php'; 

try {
    // Lấy danh sách danh mục từ bảng danh_muc_mon_an
    $sql = "SELECT * FROM danh_muc_mon_an ORDER BY id_danh_muc ASC";
    $stmt = $pdo->query($sql);
    $categories = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Lỗi kết nối: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý danh mục | Yummy Seoul</title>
    <link href="https://fonts.googleapis.com/css2?family=Asap:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/category.css">
</head>
<body>
    <div class="admin-container">
        <aside class="admin-sidebar">
            <div class="sidebar-logo">
                <img src="../../Image/homepage/logo.png" alt="Logo">
                <span>Yummy Admin</span>
            </div>
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="nav-link"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
                <a href="product.php" class="nav-link"><i class="fa-solid fa-bowl-food"></i> Quản lý món ăn</a>
                <a href="category.php" class="nav-link active"><i class="fa-solid fa-list"></i> Quản lý danh mục</a>
                <a href="order.php" class="nav-link"><i class="fa-solid fa-cart-shopping"></i> Quản lý đơn hàng</a>
                <a href="member.php" class="nav-link"><i class="fa-solid fa-users"></i> Quản lý thành viên</a>
                <div class="nav-divider"></div>
                <a href="../../UI_User/php/home.php" class="nav-link"><i class="fa-solid fa-house"></i> Về trang chủ</a>
            </nav>
        </aside>

        <main class="admin-main">
            <header class="main-header">
                <h2>Quản lý danh mục món ăn</h2>
                <button class="btn-add-gold" onclick="window.location.href='add_category.php'">
                    <i class="fa-solid fa-plus"></i> Thêm danh mục mới
                </button>
            </header>

            <div class="filter-section card">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="categorySearch" placeholder="Tìm tên danh mục hoặc mô tả...">
                </div>
            </div>

            <div class="category-list card">
                <table class="admin-table" id="categoryTable">
                    <thead>
                        <tr>
                            <th style="width: 80px;">ID</th>
                            <th style="width: 250px;">Tên danh mục</th>
                            <th>Mô tả chi tiết</th>
                            <th style="width: 120px;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $cat): ?>
                        <tr>
                            <td>#<?php echo $cat['id_danh_muc']; ?></td>
                            <td><strong class="cat-name"><?php echo $cat['ten_danh_muc']; ?></strong></td>
                            <td class="cat-desc"><?php echo $cat['mo_ta']; ?></td>
                            <td>
                                <div class="action-btns">
                                    <a href="edit_category.php?id=<?php echo $cat['id_danh_muc']; ?>" class="btn-edit"><i class="fa-solid fa-pen"></i></a>
                                    <a href="#" class="btn-delete"><i class="fa-solid fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    <script src="../js/category.js"></script>
</body>
</html>