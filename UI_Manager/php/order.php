<?php 
include '../../../Config/db.php'; 

try {
    // JOIN với bảng người dùng để lấy họ tên và số điện thoại khách hàng
    $sql = "SELECT d.*, n.ho_ten, n.so_dien_thoai 
            FROM don_hang d 
            JOIN nguoi_dung n ON d.id_khach_hang = n.id_nguoi_dung 
            ORDER BY d.ngay_tao_don DESC";
    $stmt = $pdo->query($sql);
    $orders = $stmt->fetchAll();
} catch (PDOException $e) { die("Lỗi kết nối: " . $e->getMessage()); }
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hệ thống Quản lý Đơn hàng | Yummy Seoul</title>
    <link href="https://fonts.googleapis.com/css2?family=Asap:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../../Public/css/admin/order.css">
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
                <a href="product.php" class="nav-link"><i class="fa-solid fa-bowl-food"></i> Quản lý món ăn</a>
                <a href="category.php" class="nav-link"><i class="fa-solid fa-list"></i> Quản lý danh mục</a>
                <a href="order.php" class="nav-link active"><i class="fa-solid fa-cart-shopping"></i> Quản lý đơn hàng</a>
                <a href="member.php" class="nav-link"><i class="fa-solid fa-users"></i> Quản lý thành viên</a>
                <div class="nav-divider"></div>
                <a href="../home.php" class="nav-link"><i class="fa-solid fa-house"></i> Về trang chủ</a>
            </nav>
        </aside>

        <main class="admin-main">
            <header class="main-header">
                <h2>Danh sách đơn hàng vận hành</h2>
            </header>

            <div class="filter-section card">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="orderSearch" placeholder="Tìm theo Mã đơn (#DH...) hoặc Tên khách hàng...">
                </div>
                <div class="filter-box">
                    <select id="statusFilter">
                        <option value="">Tất cả trạng thái</option>
                        <option value="Đã đặt">🆕 Đơn mới (Đã đặt)</option>
                        <option value="Đang xử lý">⏳ Chờ xử lý</option>
                        <option value="Đang giao">🚚 Đang giao hàng</option>
                        <option value="Hoàn thành">✅ Hoàn thành</option>
                        <option value="Đã hủy">❌ Đã hủy</option>
                    </select>
                </div>
            </div>

            <div class="order-list card">
                <table class="admin-table" id="orderTable">
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Ngày đặt</th>
                            <th>Tổng giá</th>
                            <th>Thanh toán</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $o): ?>
                        <tr>
                            <td><strong>#DH<?php echo $o['id_don_hang']; ?></strong></td>
                            <td>
                                <div class="user-info">
                                    <span class="user-name"><?php echo $o['ho_ten']; ?></span><br>
                                    <small><?php echo $o['so_dien_thoai']; ?></small>
                                </div>
                            </td>
                            <td class="date-text"><?php echo date('d/m/Y H:i', strtotime($o['ngay_tao_don'])); ?></td>
                            <td class="price-text"><?php echo number_format($o['tong_gia'], 0, ',', '.'); ?>đ</td>
                            <td><small class="pay-method"><?php echo $o['pt_thanh_toan']; ?></small></td>
                            <td>
                                <span class="badge status-<?php echo str_replace(' ', '-', strtolower($o['trang_thai'])); ?>">
                                    <?php echo $o['trang_thai']; ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="order_detail.php?id=<?php echo $o['id_don_hang']; ?>" class="btn-view" title="Xem chi tiết đơn"><i class="fa-solid fa-eye"></i></a>
                                    <a href="update_order.php?id=<?php echo $o['id_don_hang']; ?>" class="btn-edit" title="Cập nhật trạng thái"><i class="fa-solid fa-pen-to-square"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    <script src="../../../Public/js/admin/order.js"></script>
</body>
</html>