<?php
// 1. Kết nối CSDL
include '../../SQL_Connect/db.php';

try {
    // 2. Thống kê tổng doanh thu (Chỉ tính những đơn hàng đã 'Hoàn thành')
    $stmtRev = $pdo->query("SELECT SUM(tong_gia) FROM don_hang WHERE trang_thai = 'Hoàn thành'");
    $totalRevenue = $stmtRev->fetchColumn() ?: 0;

    // 3. Thống kê tổng đơn hàng (Tất cả trạng thái)
    $stmtOrders = $pdo->query("SELECT COUNT(*) FROM don_hang");
    $totalOrders = $stmtOrders->fetchColumn() ?: 0;

    // 4. Thống kê số lượng khách hàng (Lọc theo vai_tro)
    $stmtUsers = $pdo->query("SELECT COUNT(*) FROM nguoi_dung WHERE vai_tro = 'Khách hàng'");
    $totalUsers = $stmtUsers->fetchColumn() ?: 0;

    // 5. Lấy danh sách 5 đơn hàng mới nhất
    $stmtLatest = $pdo->query("SELECT * FROM don_hang ORDER BY ngay_tao_don DESC LIMIT 5");
    $latestOrders = $stmtLatest->fetchAll(PDO::FETCH_ASSOC);

    // --- MỚI: Lấy doanh thu 7 ngày gần nhất cho biểu đồ ---
    // Truy vấn này lấy tổng giá các đơn 'Hoàn thành' theo từng ngày
    $stmtChart = $pdo->query("SELECT DATE_FORMAT(ngay_tao_don, '%d/%m') as ngay, SUM(tong_gia) as doanh_thu 
                              FROM don_hang 
                              WHERE trang_thai = 'Hoàn thành' 
                              GROUP BY DATE(ngay_tao_don) 
                              ORDER BY ngay_tao_don ASC 
                              LIMIT 7");
    $chartRows = $stmtChart->fetchAll(PDO::FETCH_ASSOC);
    
    // Tách dữ liệu ra 2 mảng để JS dễ đọc
    $chartLabels = array_column($chartRows, 'ngay');
    $chartValues = array_column($chartRows, 'doanh_thu');

} catch (PDOException $e) {
    die("Lỗi kết nối CSDL: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="vi">

    <head>
        <meta charset="UTF-8">
        <title>Dashboard | Yummy Seoul – Tiệm ăn vặt Hàn Quốc</title>
        <link rel="icon" type="image/x-icon" href="../../Image/homepage/logo.png">
        <link href="https://fonts.googleapis.com/css2?family=Asap:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="../css/dashboard.css">
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
                    <a href="dashboard.php" class="nav-link active"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
                    <a href="products.php" class="nav-link"><i class="fa-solid fa-bowl-food"></i> Quản lý món ăn</a>
                    <a href="category.php" class="nav-link"><i class="fa-solid fa-list"></i> Quản lý danh mục</a>
                    <a href="order.php" class="nav-link"><i class="fa-solid fa-cart-shopping"></i> Quản lý đơn hàng</a>
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

                    <div class="card" style="margin-bottom: 30px;">
                        <div class="card-header">
                            <h3>Phân tích doanh thu thực tế</h3>
                        </div>
                        <div style="height: 300px; position: relative;">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>

                    <div class="recent-orders card" style="overflow-x: auto;">
                        <div class="card-header">
                            <h3>Đơn hàng mới nhất</h3>
                            <a href="order.php" class="view-all">Xem tất cả</a>
                        </div>
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Mã đơn</th>
                                    <th>ID Khách</th>
                                    <th>ID KM</th>
                                    <th>Ngày đặt</th>
                                    <th>Tiền ship</th>
                                    <th>Tổng giá</th>
                                    <th>Trạng thái</th>
                                    <th>Địa chỉ giao</th>
                                    <th>Thanh toán</th>
                                    <th>Ghi chú</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($latestOrders)): ?>
                                    <tr>
                                        <td colspan="10" class="empty-state">
                                            <i class="fa-solid fa-folder-open" style="font-size: 2rem; display: block; margin-bottom: 10px;"></i>
                                            Chưa có đơn hàng nào trong hệ thống.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($latestOrders as $order): ?>
                                        <tr>
                                            <td>#DH<?php echo $order['id_don_hang']; ?></td>
                                            <td><?php echo $order['id_khach_hang']; ?></td>
                                            <td><?php echo $order['id_khuyen_mai'] ?: 'Trống'; ?></td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($order['ngay_tao_don'])); ?></td>
                                            <td><?php echo number_format($order['tien_ship'], 0, ',', '.'); ?>đ</td>
                                            <td><strong><?php echo number_format($order['tong_gia'], 0, ',', '.'); ?>đ</strong></td>
                                            <td>
                                                <span class="badge status-<?php echo mb_strtolower(str_replace(' ', '-', $order['trang_thai']), 'UTF-8'); ?>">
                                                    <?php echo $order['trang_thai']; ?>
                                                </span>
                                            </td>
                                            <td><?php echo htmlspecialchars($order['dia_chi_giao_hang']); ?></td>
                                            <td><?php echo $order['pt_thanh_toan']; ?></td>
                                            <td><small><?php echo htmlspecialchars($order['ghi_chu'] ?: 'Không'); ?></small></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        
        <script>
            const chartLabels = <?php echo json_encode($chartLabels); ?>;
            const chartData = <?php echo json_encode($chartValues); ?>;
            
            // Nếu database trống, hiển thị mặc định để biểu đồ không bị lỗi trắng
            const finalLabels = chartLabels.length > 0 ? chartLabels : ['Chưa có dữ liệu'];
            const finalData = chartData.length > 0 ? chartData : [0];
        </script>

        <script src="../js/dashboard.js"></script>

    </body>
</html>