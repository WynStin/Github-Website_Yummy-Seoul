<?php 
include '../../../Config/db.php'; 

try {
    // 1. Lấy danh sách danh mục để đổ vào ô Select (Bộ lọc)
    $categories = $pdo->query("SELECT * FROM danh_muc_mon_an")->fetchAll();

    // 2. Lấy danh sách món ăn đầy đủ thuộc tính
    $sql = "SELECT m.*, d.ten_danh_muc 
            FROM mon_an m 
            LEFT JOIN danh_muc_mon_an d ON m.id_danh_muc = d.id_danh_muc 
            ORDER BY m.id_mon_an DESC";
    $products = $pdo->query($sql)->fetchAll();
} catch (PDOException $e) { die("Lỗi: " . $e->getMessage()); }
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý thực đơn | Yummy Seoul</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../../Public/css/admin/product.css">
</head>
<body>
    <div class="admin-container">
        <aside class="admin-sidebar">
            <div class="sidebar-logo">
                <img src="../../../Public/img/homepage/logo.png" alt="Logo">
                <span>Yummy Admin</span>
            </div>
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="nav-link"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
                <a href="product.php" class="nav-link active"><i class="fa-solid fa-bowl-food"></i> Quản lý món ăn</a>
                <a href="category.php" class="nav-link"><i class="fa-solid fa-list"></i> Quản lý danh mục</a>
                <a href="order.php" class="nav-link"><i class="fa-solid fa-cart-shopping"></i> Quản lý đơn hàng</a>
                <a href="member.php" class="nav-link"><i class="fa-solid fa-users"></i> Quản lý thành viên</a>
                <div class="nav-divider"></div>
                <a href="../home.php" class="nav-link"><i class="fa-solid fa-house"></i> Về trang chủ</a>
            </nav>
        </aside>

        <main class="admin-main">
            <header class="main-header">
                <h2>Quản lý thực đơn</h2>
                <button class="btn-add-primary" onclick="window.location.href='add_product.php'">
                    <i class="fa-solid fa-plus"></i> Thêm món mới
                </button>
            </header>

            <div class="filter-section card">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="searchInput" placeholder="Tìm tên món ăn (ví dụ: Cơm trộn, Gà sốt...)...">
                </div>
                <div class="filter-box">
                    <select id="categoryFilter">
                        <option value="">Tất cả danh mục</option>
                        <?php foreach($categories as $cat): ?>
                            <option value="<?php echo $cat['ten_danh_muc']; ?>">
                                <?php echo $cat['ten_danh_muc']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="product-list card">
                <table class="admin-table" id="productTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ảnh</th>
                            <th>Tên & Mô tả</th>
                            <th>Danh mục</th>
                            <th>Giá bán</th>
                            <th>Kho/Bán</th>
                            <th>Lượt xem</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $p): ?>
                        <tr>
                            <td>#<?php echo $p['id_mon_an']; ?></td>
                            <td><img src="../../../Public/img/monan/<?php echo $p['hinh_anh']; ?>" class="product-thumb"></td>
                            <td>
                                <strong><?php echo $p['ten_mon']; ?></strong>
                                <p class="desc-text"><?php echo mb_strimwidth($p['mo_ta'], 0, 40, "..."); ?></p>
                            </td>
                            <td><span class="category-tag"><?php echo $p['ten_danh_muc']; ?></span></td>
                            <td class="price-text"><?php echo number_format($p['gia_ban'], 0, ',', '.'); ?>đ</td>
                            <td><div class="stock-info"><span>Tồn: <?php echo $p['so_luong_ton']; ?></span><br><small>Bán: <?php echo $p['so_luong_da_ban']; ?></small></div></td>
                            <td><i class="fa-solid fa-eye" style="color:var(--gold-primary)"></i> <?php echo $p['so_luot_xem']; ?></td>
                            <td><span class="badge <?php echo ($p['trang_thai'] == 'Còn hàng') ? 'status-on' : 'status-off'; ?>"><?php echo $p['trang_thai']; ?></span></td>
                            <td>
                                <div class="action-btns">
                                    <a href="edit_product.php?id=<?php echo $p['id_mon_an']; ?>" class="btn-edit"><i class="fa-solid fa-pen"></i></a>
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
    <script src="../../../Public/js/admin/product.js"></script>
</body>
</html>