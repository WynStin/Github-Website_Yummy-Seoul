<?php
include '../../SQL_Connect/db.php';

// --- 1. XỬ LÝ THÊM THÀNH VIÊN THỦ CÔNG (Zalo/Điện thoại) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_member'])) {
    $ho_ten = $_POST['ho_ten'];
    $email = $_POST['email'];
    $sdt = $_POST['so_dien_thoai'];
    $dia_chi_mac_dinh = $_POST['dia_chi_mac_dinh'] ?? '';
    $vai_tro = $_POST['vai_tro'];
    $trang_thai = ($vai_tro == 'Quản trị viên') ? 'Hoạt động' : $_POST['trang_thai'];
    // Mật khẩu mặc định cho khách hàng thêm thủ công
    $mat_khau = password_hash('123456', PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO nguoi_dung (ho_ten, email, so_dien_thoai, dia_chi_mac_dinh, vai_tro, trang_thai, mat_khau, ngay_tao) 
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
        $pdo->prepare($sql)->execute([$ho_ten, $email, $sdt, $dia_chi_mac_dinh, $vai_tro, $trang_thai, $mat_khau]);
        header("Location: member.php?msg=added");
        exit();
    } catch (PDOException $e) {
        die("Lỗi thêm thành viên: " . $e->getMessage());
    }
}

// --- 2. XỬ LÝ CẬP NHẬT THÔNG TIN ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_member'])) {
    $id = $_POST['id_nguoi_dung'];
    $ho_ten = $_POST['ho_ten'];
    $email = $_POST['email'];
    $sdt = $_POST['so_dien_thoai'];
    $dia_chi_mac_dinh = $_POST['dia_chi_mac_dinh'] ?? '';
    $vai_tro = $_POST['vai_tro'];
    // Nếu là Admin thì ép trạng thái luôn là Hoạt động
    $trang_thai = ($vai_tro == 'Quản trị viên') ? 'Hoạt động' : $_POST['trang_thai'];

    try {
        $sql = "UPDATE nguoi_dung SET ho_ten = ?, email = ?, so_dien_thoai = ?, dia_chi_mac_dinh = ?, vai_tro = ?, trang_thai = ? WHERE id_nguoi_dung = ?";
        $pdo->prepare($sql)->execute([$ho_ten, $email, $sdt, $dia_chi_mac_dinh, $vai_tro, $trang_thai, $id]);
        header("Location: member.php?msg=updated");
        exit();
    } catch (PDOException $e) {
        die("Lỗi cập nhật: " . $e->getMessage());
    }
}

// --- 3. LẤY DANH SÁCH THÀNH VIÊN ---
$members = $pdo->query("SELECT * FROM nguoi_dung ORDER BY ngay_tao DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý thành viên | Yummy Seoul - Tiệm ăn vặt Hàn Quốc</title>
    <link rel="icon" type="image/x-icon" href="../../Image/homepage/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Asap:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/user.css">
    <link rel="stylesheet" href="../css/product.css">
    <link rel="stylesheet" href="../../UI_User/css/home.css">
</head>

<body>
    <div class="admin-container">
        <aside class="admin-sidebar">
            <div class="sidebar-logo"><img src="../../Image/homepage/logo.png" alt="Logo"><span>Yummy Admin</span></div>
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="nav-link"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
                <a href="product.php" class="nav-link"><i class="fa-solid fa-bowl-food"></i> Quản lý món ăn</a>
                <a href="category.php" class="nav-link"><i class="fa-solid fa-list"></i> Quản lý danh mục</a>
                <a href="order.php" class="nav-link"><i class="fa-solid fa-cart-shopping"></i> Quản lý đơn hàng</a>
                <a href="member.php" class="nav-link active"><i class="fa-solid fa-users"></i> Quản lý thành viên</a>
                <div class="nav-divider"></div>
                <a href="../../UI_User/php/home.php" class="nav-link"><i class="fa-solid fa-house"></i> Về trang chủ</a>
            </nav>
        </aside>

        <main class="admin-main">
            <header class="main-header">
                <h2>Hệ thống quản lý Thành viên</h2>
            </header>

            <div class="card" style="margin-bottom: 25px; padding: 20px; background: #fff; border-radius: 12px; box-shadow: var(--shadow);">
                <h3 style="color: #f59e0b; margin-bottom: 15px;"><i class="fa-solid fa-user-plus"></i> Thêm khách hàng mới (Zalo/Điện thoại)</h3>
                <form method="POST" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px;">
                    <input type="text" name="ho_ten" placeholder="Họ tên khách..." class="input-edit" required>
                    <input type="email" name="email" placeholder="Email..." class="input-edit">
                    <input type="text" name="so_dien_thoai" placeholder="Số điện thoại..." class="input-edit" required>
                    <input type="text" name="dia_chi_mac_dinh" placeholder="Địa chỉ..." class="input-edit">
                    <select name="vai_tro" class="input-edit">
                        <option value="Khách hàng">Khách hàng</option>
                        <option value="Quản trị viên">Quản trị viên</option>
                    </select>
                    <select name="trang_thai" class="input-edit">
                        <option value="Hoạt động">Hoạt động</option>
                        <option value="Bị khóa">Bị khóa</option>
                    </select>
                    <button type="submit" name="add_member" class="btn-add-primary" style="background: #f59e0b; color: white; border: none; border-radius: 5px; cursor: pointer;">Lưu khách hàng</button>
                </form>
            </div>

            <div class="member-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Họ và Tên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>Vai trò</th>
                            <th>Trạng thái</th>
                            <th>Ngày tham gia</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($members as $m): ?>
                            <tr>
                                <form method="POST">
                                    <input type="hidden" name="id_nguoi_dung" value="<?= $m['id_nguoi_dung'] ?>">
                                    <td>#<?= $m['id_nguoi_dung'] ?></td>
                                    <td><input type="text" name="ho_ten" value="<?= htmlspecialchars($m['ho_ten']) ?>" class="input-edit"></td>
                                    <td><input type="email" name="email" value="<?= htmlspecialchars($m['email']) ?>" class="input-edit"></td>
                                    <td><input type="text" name="so_dien_thoai" value="<?= htmlspecialchars($m['so_dien_thoai']) ?>" class="input-edit"></td>
                                    <td><input type="text" name="dia_chi_mac_dinh" value="<?= htmlspecialchars($m['dia_chi_mac_dinh']) ?>" class="input-edit"></td>
                                    <td>
                                        <select name="vai_tro" class="input-edit">
                                            <option value="Khách hàng" <?= $m['vai_tro'] == 'Khách hàng' ? 'selected' : '' ?>>Khách hàng</option>
                                            <option value="Quản trị viên" <?= $m['vai_tro'] == 'Quản trị viên' ? 'selected' : '' ?>>Quản trị viên</option>
                                        </select>
                                    </td>
                                    <td>
                                        <?php if ($m['vai_tro'] == 'Quản trị viên'): ?>
                                            <span class="status-badge status-active">Hoạt động</span>
                                            <input type="hidden" name="trang_thai" value="Hoạt động">
                                        <?php else: ?>
                                            <select name="trang_thai" class="input-edit">
                                                <option value="Hoạt động" <?= $m['trang_thai'] == 'Hoạt động' ? 'selected' : '' ?>>Hoạt động</option>
                                                <option value="Bị khóa" <?= $m['trang_thai'] == 'Bị khóa' ? 'selected' : '' ?>>Bị khóa</option>
                                            </select>
                                        <?php endif; ?>
                                    </td>
                                    <td style="font-size: 11px;"><?= $m['ngay_tao'] ?></td>
                                    <td>
                                        <button type="submit" name="update_member" class="btn-edit" style="background: none; border: none; color: #059669; cursor: pointer; font-size: 18px;">
                                            <i class="fa-solid fa-floppy-disk"></i>
                                        </button>
                                    </td>
                                </form>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script src="../js/user.js"></script>
</body>

</html>