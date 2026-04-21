<<<<<<< HEAD
<?php 
require_once '../../SQL_Connect/db.php'; 

=======
<?php
require_once '../../SQL_Connect/db.php'; 

<<<<<<< HEAD
=======
// 1. CHẶN TRUY CẬP TRÁI PHÉP: Nếu chưa đăng nhập, đẩy sang login kèm lệnh quay lại
>>>>>>> 67a989c2c13c95a3ec6d6f124ecda703c5e6316f
>>>>>>> c1aedc6a1637a843a3ab575670c60f0d39147ddc
if (!isset($_SESSION['id_nguoi_dung'])) {
    header("Location: login_register.php?redirect=checkout.php");
    exit();
}

<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
// 2. LẤY DỮ LIỆU: Truy vấn thông tin người dùng để đổ vào form ngay lập tức
>>>>>>> 67a989c2c13c95a3ec6d6f124ecda703c5e6316f
>>>>>>> c1aedc6a1637a843a3ab575670c60f0d39147ddc
$userId = $_SESSION['id_nguoi_dung'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    try {
        $pdo->beginTransaction();

        $dia_chi_giao = $_POST['address'];
        $ghi_chu = $_POST['note'] ?? '';
        $pttt = $_POST['pt_thanh_toan'];
        $tien_ship = floatval($_POST['tien_ship']);
        $tong_gia = floatval($_POST['tong_gia']);
        $id_km = !empty($_POST['id_khuyen_mai']) ? $_POST['id_khuyen_mai'] : null;
        $trang_thai = "Đã đặt";

        $sql_order = "INSERT INTO don_hang (id_khach_hang, dia_chi_giao_hang, ghi_chu, pt_thanh_toan, tien_ship, tong_gia, id_khuyen_mai, trang_thai, ngay_tao_don) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt_order = $pdo->prepare($sql_order);
        $stmt_order->execute([$userId, $dia_chi_giao, $ghi_chu, $pttt, $tien_ship, $tong_gia, $id_km, $trang_thai]);
        $id_don_hang = $pdo->lastInsertId();

        if (!isset($_POST['cart_data'])) {
            throw new Exception("Lỗi: Không nhận được dữ liệu món ăn!");
        }
        $cartItems = json_decode($_POST['cart_data'], true);

        $sql_detail = "INSERT INTO chi_tiet_don_hang (id_don_hang, id_mon_an, so_luong, don_gia) VALUES (?, ?, ?, ?)";
        $stmt_detail = $pdo->prepare($sql_detail);

        foreach ($cartItems as $item) {
            $stmt_detail->execute([
                $id_don_hang, 
                $item['id'], 
                $item['quantity'], 
                $item['price']
            ]);
        }

        $pdo->commit();
        echo "<script>
                localStorage.removeItem('cart');
                alert('🎉 Đặt hàng thành công! Đơn hàng của bạn đã được ghi nhận.');
                window.location.href='home.php';
              </script>";
        exit();

    } catch (Exception $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        echo "<script>alert('Lỗi: " . addslashes($e->getMessage()) . "');</script>";
    }
}

$stmt = $pdo->prepare("SELECT * FROM nguoi_dung WHERE id_nguoi_dung = ?");
$stmt->execute([$userId]);
$currentUser = $stmt->fetch();
?>
<<<<<<< HEAD
<script>
    const userData = <?php echo json_encode($currentUser); ?>;
</script>
=======
>>>>>>> 67a989c2c13c95a3ec6d6f124ecda703c5e6316f

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán | Yummy Seoul - Tiệm ăn vặt Hàn Quốc</title>

    <link rel="icon" type="image/x-icon" href="../../Image/homepage/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Asap:wght@400;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/checkout.css">
</head>

<body>

    <?php include '../../Header_Footer/php/header.php'; ?>

    <div id="app"></div>

    <div class="modal-checkout" id="messageModal">
        <div class="modal-content-checkout">
            <div class="modal-header-checkout">
                <h2 id="modalTitle">Thông báo</h2>
                <button class="close-btn-checkout" onclick="closeMessageModal()">&times;</button>
            </div>
            <div class="modal-body-checkout">
                <p id="modalMessage"></p>
            </div>
            <div class="modal-actions-checkout">
                <button class="modal-btn-checkout modal-btn-primary-checkout" onclick="closeMessageModal()">Đóng</button>
            </div>
        </div>
    </div>

    <div class="modal-checkout" id="confirmModal">
        <div class="modal-content-checkout">
            <div class="modal-header-checkout">
                <h2 id="confirmTitle">Xác nhận</h2>
                <button class="close-btn-checkout" onclick="closeConfirmModal()">&times;</button>
            </div>
            <div class="modal-body-checkout">
                <p id="confirmMessage"></p>
            </div>
            <div class="modal-actions-checkout">
                <button class="modal-btn-checkout" onclick="closeConfirmModal()">Hủy</button>
                <button class="modal-btn-checkout modal-btn-primary-checkout" id="confirmBtn">Xác nhận</button>
            </div>
        </div>
    </div>

    <div class="modal-checkout" id="successModal">
        <div class="modal-content-checkout">
            <div class="modal-header-checkout">
                <h2>🎉 Đặt hàng thành công!</h2>
            </div>
            <div class="modal-body-checkout">
                <p class="modal-body-text"></p>
                <p>Cảm ơn Duy đã ủng hộ Yummy Seoul!</p>
            </div>
            <div class="modal-actions-checkout">
                <button class="modal-btn-checkout modal-btn-primary-checkout" onclick="window.location.href='../php/home.php'">Về trang chủ</button>
            </div>
        </div>
    </div>

    <?php include '../../Header_Footer/php/footer.php'; ?>

    <script>
        const userData = <?php echo json_encode($currentUser); ?>;

        if (userData) {
            sessionStorage.setItem("currentUser", JSON.stringify({
                username: userData.ho_ten || userData.user_name,
                email: userData.email,
                phone: userData.so_dien_thoai,
                address: userData.dia_chi_mac_dinh 
            }));
        }
    </script>

    <script src="../js/checkout.js"></script>

<<<<<<< HEAD
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cart = JSON.parse(localStorage.getItem('cart') || '[]');
            if (cart.length === 0) {
                alert('Giỏ hàng trống, mời bạn chọn món!');
                window.location.href = 'product.php';
            }
        });
    </script>
=======
>>>>>>> 67a989c2c13c95a3ec6d6f124ecda703c5e6316f
</body>

</html>