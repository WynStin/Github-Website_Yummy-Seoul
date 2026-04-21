<?php
include '../../SQL_Connect/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $ten = $_POST['ten_mon'];
    $mo_ta = $_POST['mo_ta'];
    $gia = $_POST['gia_ban'];
    $id_dm = $_POST['id_danh_muc'];
    $ton = $_POST['so_luong_ton'];
    $hinh = "default.jpg"; 

    try {
        $sql = "INSERT INTO mon_an (ten_mon, mo_ta, gia_ban, id_danh_muc, so_luong_ton, hinh_anh, ngay_tao) VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $pdo->prepare($sql)->execute([$ten, $mo_ta, $gia, $id_dm, $ton, $hinh]);
        header("Location: product.php?msg=added");
        exit();
    } catch (PDOException $e) {
        die("Lỗi thêm: " . $e->getMessage());
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_product'])) {
    $id = $_POST['id_mon_an'];
    $ten = $_POST['ten_mon'];
    $mo_ta = $_POST['mo_ta'];
    $gia = $_POST['gia_ban'];
    $ton = $_POST['so_luong_ton'];
    $luot_xem = $_POST['so_luot_xem'];
    $da_ban = $_POST['so_luong_da_ban'];
    $trang_thai = $_POST['trang_thai'];

    try {
        $sql = "UPDATE mon_an SET ten_mon = ?, mo_ta = ?, gia_ban = ?, so_luong_ton = ?, so_luot_xem = ?, so_luong_da_ban = ?, trang_thai = ? WHERE id_mon_an = ?";
        $pdo->prepare($sql)->execute([$ten, $mo_ta, $gia, $ton, $luot_xem, $da_ban, $trang_thai, $id]);
        header("Location: product.php?msg=updated");
        exit();
    } catch (PDOException $e) {
        die("Lỗi cập nhật: " . $e->getMessage());
    }
}
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    try {
        $pdo->prepare("DELETE FROM mon_an WHERE id_mon_an = ?")->execute([$id]);
        header("Location: product.php?msg=deleted");
        exit();
    } catch (PDOException $e) {
        die("Lỗi xóa: " . $e->getMessage());
    }
}

$categories = $pdo->query("SELECT * FROM danh_muc_mon_an")->fetchAll();
$products = $pdo->query("SELECT m.*, d.ten_danh_muc FROM mon_an m LEFT JOIN danh_muc_mon_an d ON m.id_danh_muc = d.id_danh_muc ORDER BY m.id_mon_an DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý món ăn | Yummy Seoul - Tiệm ăn vặt Hàn Quốc</title>
    <link rel="icon" type="image/x-icon" href="../../Image/homepage/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Asap:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/product.css">
    <style>
        .product-list-wrapper { overflow-x: auto; background: #fff; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .admin-table { min-width: 1500px; width: 100%; border-collapse: collapse; }
        .search-container { margin-bottom: 20px; display: flex; gap: 10px; }
        .search-input { padding: 10px 15px; border: 1px solid #ddd; border-radius: 8px; width: 300px; }
        .edit-input-large { width: 100%; min-width: 150px; padding: 5px; border: 1px solid #ddd; border-radius: 4px; }
        .add-form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
    </style>
</head>
<body>
    <div class="admin-container">
        <aside class="admin-sidebar">
            <div class="sidebar-logo"><img src="../../Image/homepage/logo.png" alt="Logo"><span>Yummy Admin</span></div>
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="nav-link"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
                <a href="product.php" class="nav-link active"><i class="fa-solid fa-bowl-food"></i> Quản lý món ăn</a>
                <a href="category.php" class="nav-link"><i class="fa-solid fa-list"></i> Quản lý danh mục</a>
                <a href="order.php" class="nav-link"><i class="fa-solid fa-cart-shopping"></i> Quản lý đơn hàng</a>
                <a href="user.php" class="nav-link"><i class="fa-solid fa-users"></i> Quản lý thành viên</a>
                <div class="nav-divider"></div>
                <a href="../../UI_User/php/home.php" class="nav-link"><i class="fa-solid fa-house"></i> Về trang chủ</a>
            </nav>
        </aside>

        <main class="admin-main">
            <header class="main-header"><h2>Quản lý thực đơn chi tiết</h2></header>

            <?php if (isset($_GET['msg'])): ?>
                <div class="alert-msg" id="alertBox" style="background:#dcfce7; color:#166534; padding:15px; border-radius:8px; margin-bottom:20px;">
                    <i class="fa-solid fa-circle-check"></i>
                    <?php 
                        if($_GET['msg'] == 'added') echo " Thêm thành công!"; 
                        if($_GET['msg'] == 'updated') echo " Đã cập nhật database!";
                        if($_GET['msg'] == 'deleted') echo " Đã xóa khỏi hệ thống!";
                    ?>
                </div>
            <?php endif; ?>

            <div class="card" style="margin-bottom: 30px;">
                <h3 style="margin-bottom:15px; color: #f59e0b;">Thêm món ăn mới</h3>
                <form method="POST" class="add-form-grid">
                    <input type="text" name="ten_mon" class="edit-input-large" placeholder="Tên món..." required>
                    <textarea name="mo_ta" class="edit-input-large" placeholder="Mô tả món ăn..."></textarea>
                    <input type="number" name="gia_ban" class="edit-input-large" placeholder="Giá bán..." required>
                    <select name="id_danh_muc" class="edit-input-large">
                        <?php foreach ($categories as $c): ?>
                            <option value="<?= $c['id_danh_muc'] ?>"><?= $c['ten_danh_muc'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="number" name="so_luong_ton" class="edit-input-large" placeholder="Số lượng kho" value="100">
                    <button type="submit" name="add_product" class="btn-add-primary">Thêm món</button>
                </form>
            </div>

            <div class="search-container">
                <input type="text" id="searchInput" class="search-input" placeholder="🔍 Tìm tên món ăn...">
            </div>

            <div class="product-list-wrapper">
                <table class="admin-table" id="productTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ảnh</th>
                            <th>Tên món & Mô tả</th>
                            <th>Giá (đ)</th>
                            <th>Danh mục</th>
                            <th>Kho</th>
                            <th>Lượt xem</th>
                            <th>Đã bán</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $p): ?>
                        <tr>
                            <form method="POST">
                                <input type="hidden" name="id_mon_an" value="<?= $p['id_mon_an'] ?>">
                                <td>#<?= $p['id_mon_an'] ?></td>
                                <td><img src="../../Image/monan/<?= $p['hinh_anh'] ?>" class="product-thumb" style="width:50px; height:50px; object-fit:cover;"></td>
                                <td>
                                    <input type="text" name="ten_mon" value="<?= htmlspecialchars($p['ten_mon']) ?>" class="edit-input-large" style="font-weight:bold;"><br>
                                    <textarea name="mo_ta" class="edit-input-large" style="font-size:11px; margin-top:5px;"><?= htmlspecialchars($p['mo_ta']) ?></textarea>
                                </td>
                                <td><input type="number" name="gia_ban" value="<?= (int)$p['gia_ban'] ?>" class="edit-input-large" style="width:90px;"></td>
                                <td><span class="category-tag"><?= $p['ten_danh_muc'] ?></span></td>
                                <td><input type="number" name="so_luong_ton" value="<?= $p['so_luong_ton'] ?>" class="edit-input-large" style="width:60px;"></td>
                                <td><input type="number" name="so_luot_xem" value="<?= $p['so_luot_xem'] ?>" class="edit-input-large" style="width:60px;"></td>
                                <td><input type="number" name="so_luong_da_ban" value="<?= $p['so_luong_da_ban'] ?>" class="edit-input-large" style="width:60px;"></td>
                                <td>
                                    <select name="trang_thai" class="edit-input-large">
                                        <option value="Còn hàng" <?= $p['trang_thai'] == 'Còn hàng' ? 'selected' : '' ?>>Còn hàng</option>
                                        <option value="Hết hàng" <?= $p['trang_thai'] == 'Hết hàng' ? 'selected' : '' ?>>Hết hàng</option>
                                    </select>
                                </td>
                                <td style="font-size:11px; color:#888;"><?= $p['ngay_tao'] ?></td>
                                <td>
                                    <div class="action-btns">
                                        <button type="submit" name="update_product" class="btn-edit" title="Lưu thay đổi"><i class="fa-solid fa-floppy-disk"></i></button>
                                        <a href="product.php?delete_id=<?= $p['id_mon_an'] ?>" class="btn-delete" onclick="return confirm('Bạn có chắc muốn xóa vĩnh viễn món này?')"><i class="fa-solid fa-trash"></i></a>
                                    </div>
                                </td>
                            </form>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#productTable tbody tr');
            
            rows.forEach(row => {
                let text = row.querySelector('input[name="ten_mon"]').value.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
        setTimeout(() => {
            let box = document.getElementById('alertBox');
            if (box) box.style.display = 'none';
        }, 3000);
    </script>
</body>
</html>