<?php
include '../../SQL_Connect/db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $id_don = $_POST['id_don_hang'];
    $status_moi = $_POST['trang_thai'];
    
    $current_search = isset($_POST['search_hidden']) ? $_POST['search_hidden'] : '';
    $current_filter = isset($_POST['status_hidden']) ? $_POST['status_hidden'] : '';

    try {
        $updateSql = "UPDATE don_hang SET trang_thai = ? WHERE id_don_hang = ?";
        $pdo->prepare($updateSql)->execute([$status_moi, $id_don]);
        
        header("Location: order.php?msg=updated&search=" . urlencode($current_search) . "&status=" . urlencode($current_filter));
        exit();
    } catch (PDOException $e) {
        die("Lỗi: " . $e->getMessage());
    }
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$filterStatus = isset($_GET['status']) ? $_GET['status'] : '';

try {
    $sql = "SELECT d.*, n.ho_ten, n.so_dien_thoai 
            FROM don_hang d 
            JOIN nguoi_dung n ON d.id_khach_hang = n.id_nguoi_dung 
            WHERE 1=1";

    if ($search != '') {
        $sql .= " AND (d.id_don_hang LIKE :search OR n.ho_ten LIKE :search OR d.dia_chi_giao_hang LIKE :search OR CONCAT('#DH', d.id_don_hang) LIKE :search)";
    }

    $statusOptions = ['Đã đặt', 'Đang xử lý', 'Đang giao', 'Hoàn thành', 'Đã hủy'];
    if (in_array($filterStatus, $statusOptions)) {
        $sql .= " AND d.trang_thai = :status_filter";
    }

    $sql .= " ORDER BY d.ngay_tao_don DESC";
    $stmt = $pdo->prepare($sql);
    
    if ($search != '') $stmt->bindValue(':search', "%$search%");
    if (in_array($filterStatus, $statusOptions)) $stmt->bindValue(':status_filter', $filterStatus);

    $stmt->execute();
    $orders = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Lỗi: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý đơn hàng | Yummy Seoul – Tiệm ăn vặt Hàn Quốc</title>
    <link rel="icon" type="image/x-icon" href="../../Image/homepage/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Asap:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/order.css">
    <link rel="stylesheet" href="../../UI_User/css/home.css">
    <style>
        #success-alert {
            background-color: #dcfce7;
            color: #166534;
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #bbf7d0;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            transition: opacity 0.5s ease;
        }
    </style>
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
                <a href="category.php" class="nav-link"><i class="fa-solid fa-list"></i> Quản lý danh mục</a>
                <a href="order.php" class="nav-link active"><i class="fa-solid fa-cart-shopping"></i> Quản lý đơn hàng</a>
                <a href="user.php" class="nav-link"><i class="fa-solid fa-users"></i> Quản lý thành viên</a>
                <div class="nav-divider"></div>
                <a href="../../UI_User/php/home.php" class="nav-link"><i class="fa-solid fa-house"></i> Về trang chủ</a>
            </nav>
        </aside>

        <main class="admin-main">
            <header class="main-header">
                <h2>Quản lý đơn hàng</h2>

                <?php if (isset($_GET['msg']) && $_GET['msg'] == 'updated'): ?>
                    <div id="success-alert">
                        <i class="fa-solid fa-circle-check"></i> Cập nhật trạng thái đơn hàng thành công!
                    </div>
                <?php endif; ?>
            </header>

            <form method="GET" action="order.php" class="filter-section">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Tìm mã đơn, tên khách hoặc địa chỉ...">
                </div>
                <div class="filter-box">
                    <select name="status" onchange="this.form.submit()">
                        <option value="">Tất cả trạng thái</option>
                        <?php
                        foreach ($statusOptions as $opt) {
                            $sel = ($filterStatus == $opt) ? 'selected' : '';
                            echo "<option value='$opt' $sel>$opt</option>";
                        }
                        ?>
                    </select>
                </div>
            </form>

            <div class="order-list card">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>ID KM</th>
                            <th>Ngày đặt</th>
                            <th>Phí Ship</th>
                            <th>Tổng tiền</th>
                            <th>Thanh toán</th>
                            <th>Địa chỉ & Ghi chú</th>
                            <th>Trạng thái & Cập nhật</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($orders)): ?>
                            <tr>
                                <td colspan="9" style="text-align:center; padding: 30px; color: #888;">Không tìm thấy đơn hàng phù hợp.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($orders as $o): ?>
                                <tr>
                                    <td><strong>#DH<?php echo $o['id_don_hang']; ?></strong></td>
                                    <td>
                                        <strong><?php echo $o['ho_ten']; ?></strong><br>
                                        <small>ID: <?php echo $o['id_khach_hang']; ?></small>
                                    </td>
                                    <td><?php echo $o['id_khuyen_mai'] ?: '-'; ?></td>
                                    <td><?php echo date('d/m/y H:i', strtotime($o['ngay_tao_don'])); ?></td>
                                    <td><?php echo number_format($o['tien_ship'], 0, ',', '.'); ?>đ</td>
                                    <td class="price-text"><?php echo number_format($o['tong_gia'], 0, ',', '.'); ?>đ</td>
                                    <td><small><?php echo $o['pt_thanh_toan']; ?></small></td>
                                    <td>
                                        <div style="max-width: 250px; font-size: 12px;">
                                            <strong>Đ/C:</strong> <?php echo htmlspecialchars($o['dia_chi_giao_hang']); ?><br>
                                            <strong>Ghi chú:</strong> <i><?php echo htmlspecialchars($o['ghi_chu'] ?: 'Không'); ?></i>
                                        </div>
                                    </td>
                                    <td>
                                        <form method="POST" style="display: flex; gap: 8px;">
                                            <input type="hidden" name="id_don_hang" value="<?php echo $o['id_don_hang']; ?>">
                                            
                                            <input type="hidden" name="search_hidden" value="<?php echo htmlspecialchars($search); ?>">
                                            <input type="hidden" name="status_hidden" value="<?php echo htmlspecialchars($filterStatus); ?>">
                                            
                                            <select name="trang_thai" class="status-select">
                                                <?php
                                                foreach ($statusOptions as $st) {
                                                    $selected = ($o['trang_thai'] == $st) ? 'selected' : '';
                                                    echo "<option value='$st' $selected>$st</option>";
                                                }
                                                ?>
                                            </select>
                                            <button type="submit" name="update_status" class="btn-update-fast">Lưu</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.getElementById('success-alert');
            if (alert) {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 3000);
            }
        });
    </script>

    <script src="../js/order.js"></script>

</body>
</html>