<?php
include '../../SQL_Connect/db.php';

// --- 1. XỬ LÝ THÊM DANH MỤC ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_category'])) {
    $ten = $_POST['ten_danh_muc'];
    $mota = $_POST['mo_ta'];
    try {
        $stmt = $pdo->prepare("INSERT INTO danh_muc_mon_an (ten_danh_muc, mo_ta) VALUES (?, ?)");
        $stmt->execute([$ten, $mota]);
        header("Location: category.php?msg=added");
        exit();
    } catch (PDOException $e) {
        $error = "Lỗi thêm: " . $e->getMessage();
    }
}

// --- 2. XỬ LÝ CẬP NHẬT DANH MỤC (Sửa ngay tại chỗ) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_category'])) {
    $id = $_POST['id_danh_muc'];
    $ten = $_POST['ten_danh_muc'];
    $mota = $_POST['mo_ta'];
    try {
        $stmt = $pdo->prepare("UPDATE danh_muc_mon_an SET ten_danh_muc = ?, mo_ta = ? WHERE id_danh_muc = ?");
        $stmt->execute([$ten, $mota, $id]);
        header("Location: category.php?msg=updated");
        exit();
    } catch (PDOException $e) {
        $error = "Lỗi cập nhật: " . $e->getMessage();
    }
}

// --- 3. XỬ LÝ XÓA DANH MỤC (Xóa cả món ăn liên quan) ---
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    try {
        $pdo->beginTransaction();
        // Xóa tất cả món ăn thuộc danh mục này trước
        $stmt1 = $pdo->prepare("DELETE FROM mon_an WHERE id_danh_muc = ?");
        $stmt1->execute([$id]);
        // Sau đó xóa danh mục
        $stmt2 = $pdo->prepare("DELETE FROM danh_muc_mon_an WHERE id_danh_muc = ?");
        $stmt2->execute([$id]);

        $pdo->commit();
        header("Location: category.php?msg=deleted");
        exit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        die("Lỗi xóa: " . $e->getMessage());
    }
}

// Lấy danh sách danh mục
$categories = $pdo->query("SELECT * FROM danh_muc_mon_an ORDER BY id_danh_muc ASC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý danh mục | Yummy Seoul – Tiệm ăn vặt Hàn Quốc</title>
    <link rel="icon" type="image/x-icon" href="../../Image/homepage/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Asap:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/category.css">
    <link rel="stylesheet" href="../../UI_User/css/home.css">
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
                <a href="user.php" class="nav-link"><i class="fa-solid fa-users"></i> Quản lý thành viên</a>
                <div class="nav-divider"></div>
                <a href="../../UI_User/php/home.php" class="nav-link"><i class="fa-solid fa-house"></i> Về trang chủ</a>
            </nav>
        </aside>

        <main class="admin-main">
            <header class="main-header">
                <h2>Quản lý danh mục món ăn</h2>
            </header>

            <?php if (isset($_GET['msg'])): ?>
                <div class="alert-msg" id="alertBox">
                    <i class="fa-solid fa-circle-check"></i>
                    <?php
                    if ($_GET['msg'] == 'added') echo "Đã thêm danh mục mới!";
                    if ($_GET['msg'] == 'updated') echo "Đã cập nhật thay đổi!";
                    if ($_GET['msg'] == 'deleted') echo "Đã xóa danh mục và các món ăn liên quan!";
                    ?>
                </div>
            <?php endif; ?>

            <div class="card">
                <h3 style="margin-bottom: 15px;">Thêm danh mục mới</h3>
                <form method="POST" class="add-form-inline">
                    <div>
                        <label style="display:block; font-size: 13px; margin-bottom:5px;">Tên danh mục</label>
                        <input type="text" name="ten_danh_muc" class="input-inline" placeholder="Ví dụ: Gà rán" required style="width:100%;">
                    </div>
                    <div>
                        <label style="display:block; font-size: 13px; margin-bottom:5px;">Mô tả chi tiết</label>
                        <input type="text" name="mo_ta" class="input-inline" placeholder="Mô tả ngắn gọn về danh mục..." style="width:100%;">
                    </div>
                    <button type="submit" name="add_category" class="btn-save-inline">
                        <i class="fa-solid fa-plus"></i> Thêm ngay
                    </button>
                </form>
            </div>

            <div class="category-list card">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">ID</th>
                            <th style="width: 200px;">Tên danh mục</th>
                            <th>Mô tả chi tiết</th>
                            <th style="width: 150px;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $cat): ?>
                            <tr>
                                <form method="POST">
                                    <td>#<?php echo $cat['id_danh_muc']; ?></td>
                                    <td>
                                        <input type="hidden" name="id_danh_muc" value="<?php echo $cat['id_danh_muc']; ?>">
                                        <input type="text" name="ten_danh_muc" value="<?php echo htmlspecialchars($cat['ten_danh_muc']); ?>" class="edit-input" required>
                                    </td>
                                    <td>
                                        <input type="text" name="mo_ta" value="<?php echo htmlspecialchars($cat['mo_ta']); ?>" class="edit-input">
                                    </td>
                                    <td>
                                        <div class="action-btns">
                                            <button type="submit" name="update_category" class="btn-edit" title="Lưu thay đổi">
                                                <i class="fa-solid fa-floppy-disk"></i>
                                            </button>
                                            <a href="category.php?delete_id=<?php echo $cat['id_danh_muc']; ?>"
                                                class="btn-delete"
                                                onclick="return confirm('⚠️ CẢNH BÁO: Xóa danh mục này sẽ XÓA TẤT CẢ món ăn thuộc danh mục này. Bạn chắc chắn chứ?')">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
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
        // Tự động ẩn thông báo sau 3 giây
        const alertBox = document.getElementById('alertBox');
        if (alertBox) {
            setTimeout(() => {
                alertBox.style.display = 'none';
            }, 3000);
        }
    </script>

    <script src="../js/category.js"></script>

</body>

</html>