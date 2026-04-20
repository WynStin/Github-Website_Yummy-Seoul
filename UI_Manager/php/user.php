<?php
include '../../SQL_Connect/db.php';

// --- XỬ LÝ AJAX ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && (isset($_POST['add_member']) || isset($_POST['update_member']))) {
    header('Content-Type: application/json');
    $response = ['status' => 'error', 'message' => 'Có lỗi xảy ra'];

    if (isset($_POST['add_member'])) {
        $user_name = $_POST['user_name'];
        $ho_ten = $_POST['ho_ten'];
        $email = $_POST['email'];
        $sdt = $_POST['so_dien_thoai'];
        $dia_chi_mac_dinh = $_POST['dia_chi_mac_dinh'] ?? '';
        $vai_tro = $_POST['vai_tro'];
        $trang_thai = ($vai_tro == 'Quản lý' || $vai_tro == 'Quản trị viên') ? 'Hoạt động' : $_POST['trang_thai'];
        
        // SỬA TẠI ĐÂY: Lưu trực tiếp 123456 thay vì dùng password_hash
        $mat_khau = '123456'; 

        try {
            $sql = "INSERT INTO nguoi_dung (user_name, mat_khau, ho_ten, email, so_dien_thoai, dia_chi_mac_dinh, vai_tro, trang_thai, ngay_tao) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
            $pdo->prepare($sql)->execute([$user_name, $mat_khau, $ho_ten, $email, $sdt, $dia_chi_mac_dinh, $vai_tro, $trang_thai]);
            $response = ['status' => 'success', 'message' => 'Thêm thành viên thành công!'];
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                $response['message'] = "Lỗi: Số điện thoại hoặc Tên đăng nhập đã tồn tại!";
            } else {
                $response['message'] = "Lỗi hệ thống: " . $e->getMessage();
            }
        }
    }

    if (isset($_POST['update_member'])) {
        $id = $_POST['id_nguoi_dung'];
        $user_name = $_POST['user_name'];
        $ho_ten = $_POST['ho_ten'];
        $email = $_POST['email'];
        $sdt = $_POST['so_dien_thoai'];
        $dia_chi_mac_dinh = $_POST['dia_chi_mac_dinh'] ?? '';
        $vai_tro = $_POST['vai_tro'];
        $trang_thai = ($vai_tro == 'Quản lý' || $vai_tro == 'Quản trị viên') ? 'Hoạt động' : $_POST['trang_thai'];

        try {
            $sql = "UPDATE nguoi_dung SET user_name = ?, ho_ten = ?, email = ?, so_dien_thoai = ?, dia_chi_mac_dinh = ?, vai_tro = ?, trang_thai = ? WHERE id_nguoi_dung = ?";
            $pdo->prepare($sql)->execute([$user_name, $ho_ten, $email, $sdt, $dia_chi_mac_dinh, $vai_tro, $trang_thai, $id]);
            $response = ['status' => 'success', 'message' => 'Cập nhật thông tin thành công!'];
        } catch (PDOException $e) {
            $response['message'] = ($e->errorInfo[1] == 1062) ? "Lỗi: Thông tin bị trùng lặp!" : $e->getMessage();
        }
    }
    echo json_encode($response);
    exit();
}

$members = $pdo->query("SELECT * FROM nguoi_dung ORDER BY ngay_tao DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý thành viên | Yummy Seoul</title>
    <link rel="icon" type="image/x-icon" href="../../Image/homepage/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Asap:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/user.css">
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

            <div class="card card-add-member">
                <h3><i class="fa-solid fa-user-plus"></i> Thêm thành viên mới</h3>
                <form method="POST" class="add-member-grid">
                    <div class="form-group">
                        <label>Tên đăng nhập</label>
                        <input type="text" name="user_name" placeholder="Username..." class="input-edit" required>
                    </div>
                    <div class="form-group">
                        <label>Họ tên</label>
                        <input type="text" name="ho_ten" placeholder="Họ tên..." class="input-edit" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="Email..." class="input-edit">
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" name="so_dien_thoai" placeholder="SĐT..." class="input-edit" required>
                    </div>
                    <div class="form-group">
                        <label>Vai trò</label>
                        <select name="vai_tro" class="input-edit">
                            <option value="Khách hàng">Khách hàng</option>
                            <option value="Quản lý">Quản lý</option>
                        </select>
                    </div>
                    <input type="hidden" name="trang_thai" value="Hoạt động">
                    <button type="submit" name="add_member" class="btn-add-primary">Lưu thành viên</button>
                </form>
                <p style="font-size: 11px; color: var(--text-muted); margin-top: 10px;">* Mật khẩu mặc định sẽ là: <strong>123456</strong></p>
            </div>

            <div class="search-member-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="searchMember" placeholder="Tìm theo tên, username, SĐT...">
            </div>

            <div class="member-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tài khoản</th>
                            <th>Họ và Tên</th>
                            <th>Liên hệ</th>
                            <th>Địa chỉ</th>
                            <th>Vai trò</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($members as $m): ?>
                            <tr class="member-row">
                                <form method="POST">
                                    <input type="hidden" name="id_nguoi_dung" value="<?= $m['id_nguoi_dung'] ?>">
                                    <td>#<?= $m['id_nguoi_dung'] ?></td>
                                    <td><input type="text" name="user_name" value="<?= htmlspecialchars($m['user_name']) ?>" class="input-edit-row bold-text"></td>
                                    <td>
                                        <input type="text" name="ho_ten" value="<?= htmlspecialchars($m['ho_ten']) ?>" class="input-edit-row">
                                        <div class="date-text">Gia nhập: <?= date('d/m/Y', strtotime($m['ngay_tao'])) ?></div>
                                    </td>
                                    <td>
                                        <div class="contact-inputs">
                                            <input type="email" name="email" value="<?= htmlspecialchars($m['email']) ?>" class="input-edit-row small" placeholder="Email">
                                            <input type="text" name="so_dien_thoai" value="<?= htmlspecialchars($m['so_dien_thoai']) ?>" class="input-edit-row small" placeholder="SĐT">
                                        </div>
                                    </td>
                                    <td><input type="text" name="dia_chi_mac_dinh" value="<?= htmlspecialchars($m['dia_chi_mac_dinh'] ?? '') ?>" class="input-edit-row"></td>
                                    <td>
                                        <select name="vai_tro" class="input-edit-row">
                                            <option value="Khách hàng" <?= $m['vai_tro'] == 'Khách hàng' ? 'selected' : '' ?>>Khách hàng</option>
                                            <option value="Quản lý" <?= ($m['vai_tro'] == 'Quản lý' || $m['vai_tro'] == 'Quản trị viên') ? 'selected' : '' ?>>Quản lý</option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="status-cell-container">
                                            <?php if ($m['vai_tro'] == 'Quản lý' || $m['vai_tro'] == 'Quản trị viên'): ?>
                                                <span class="badge status-on">Đang hoạt động</span>
                                                <input type="hidden" name="trang_thai" value="Hoạt động">
                                            <?php else: ?>
                                                <select name="trang_thai" class="input-edit-row">
                                                    <option value="Hoạt động" <?= $m['trang_thai'] == 'Hoạt động' ? 'selected' : '' ?>>Hoạt động</option>
                                                    <option value="Bị khóa" <?= $m['trang_thai'] == 'Bị khóa' ? 'selected' : '' ?>>Bị khóa</option>
                                                </select>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="submit" name="update_member" class="btn-save-row"><i class="fa-solid fa-floppy-disk"></i></button>
                                    </td>
                                </form>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    <div id="toast-container"></div>
    <script src="../js/user.js"></script>
</body>
</html>