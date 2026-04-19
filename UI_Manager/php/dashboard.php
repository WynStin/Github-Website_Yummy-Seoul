<?php 
// Kết nối CSDL
include '../../SQL_Connect/db.php'; 

try {
    // 1. Thống kê tổng doanh thu (sử dụng cột 'tong_gia')
    $stmtRev = $pdo->query("SELECT SUM(tong_gia) FROM don_hang WHERE trang_thai = 'Hoàn thành'");
    $totalRevenue = $stmtRev->fetchColumn() ?? 0;

    // 2. Thống kê tổng đơn hàng
    $stmtOrders = $pdo->query("SELECT COUNT(*) FROM don_hang");
    $totalOrders = $stmtOrders->fetchColumn();

    // 3. Thống kê số lượng thành viên
    $stmtUsers = $pdo->query("SELECT COUNT(*) FROM nguoi_dung WHERE vai_tro = 'Khách hàng'");
    $totalUsers = $stmtUsers->fetchColumn();

    // SỬA LỖI TẠI ĐÂY: Đổi 'ngay_dat' thành 'ngay_tao_don' theo SQL mới
    $stmtLatest = $pdo->query("SELECT * FROM don_hang ORDER BY ngay_tao_don DESC LIMIT 5");
    $latestOrders = $stmtLatest->fetchAll();

} catch (PDOException $e) {
    die("Lỗi kết nối CSDL: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Yummy Seoul</title>
    <link href="https://fonts.googleapis.com/css2?family=Asap:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
    <div class="admin-container">
        <aside class="admin-sidebar">
            <div class="sidebar-logo">
                <img src="../../Image/homepage/logo.png" alt="Logo">
                <span>Yummy Admin</span>
            </div>
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="nav-link active"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
                <a href="products.php" class="nav-link"><i class="fa-solid fa-bowl-food"></i> Quản lý món ăn</a>
                <a href="category.php" class="nav-link"><i class="fa-solid fa-list"></i> Quản lý danh mục</a>
                <a href="orders.php" class="nav-link"><i class="fa-solid fa-cart-shopping"></i> Quản lý đơn hàng</a>
                <a href="users.php" class="nav-link"><i class="fa-solid fa-users"></i> Quản lý thành viên</a>
                <div class="nav-divider"></div>
                <a href="../../UI_User/php/home.php" class="nav-link"><i class="fa-solid fa-house"></i> Về trang chủ</a>
            </nav>
        </aside>

        <main class="admin-main">
            <header class="main-header">
                <h2>Báo cáo tổng quan</h2>
            </header>

            <div class="dashboard-content">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fa-solid fa-money-bill-trend-up"></i></div>
                        <div class="stat-data">
                            <span class="label">Tổng doanh thu</span>
                            <h3 class="value"><?php echo number_format($totalRevenue, 0, ',', '.'); ?>đ</h3>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fa-solid fa-box"></i></div>
                        <div class="stat-data">
                            <span class="label">Tổng đơn hàng</span>
                            <h3 class="value"><?php echo $totalOrders; ?></h3>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fa-solid fa-user-check"></i></div>
                        <div class="stat-data">
                            <span class="label">Khách hàng</span>
                            <h3 class="value"><?php echo $totalUsers; ?></h3>
                        </div>
                    </div>
                </div>

                <div class="recent-orders card">
                    <div class="card-header">
                        <h3>Đơn hàng mới nhất</h3>
                        <a href="admin_orders.php" class="view-all">Xem tất cả</a>
                    </div>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Mã đơn</th>
                                <th>Ngày đặt</th>
                                <th>Tổng giá</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($latestOrders as $order): ?>
                            <tr>
                                <td>#DH<?php echo $order['id_don_hang']; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($order['ngay_tao_don'])); ?></td>
                                <td><?php echo number_format($order['tong_gia'], 0, ',', '.'); ?>đ</td>
                                <td><span class="badge"><?php echo $order['trang_thai']; ?></span></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>