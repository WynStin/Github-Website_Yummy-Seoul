<?php
require_once '../../SQL_Connect/db.php'; // Đảm bảo file này đã có session_start()

// 1. CHẶN TRUY CẬP TRÁI PHÉP: Nếu chưa đăng nhập, đẩy sang login kèm lệnh quay lại
if (!isset($_SESSION['id_nguoi_dung'])) {
    header("Location: login_register.php?redirect=checkout.php");
    exit();
}

// 2. LẤY DỮ LIỆU: Truy vấn thông tin người dùng để đổ vào form ngay lập tức
$userId = $_SESSION['id_nguoi_dung'];
$stmt = $pdo->prepare("SELECT * FROM nguoi_dung WHERE id_nguoi_dung = ?");
$stmt->execute([$userId]);
$currentUser = $stmt->fetch();
?>

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
            <div class="modal-body-checkout"><p id="modalMessage"></p></div>
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
            <div class="modal-body-checkout"><p id="confirmMessage"></p></div>
            <div class="modal-actions-checkout">
                <button class="modal-btn-checkout" onclick="closeConfirmModal()">Hủy</button>
                <button class="modal-btn-checkout modal-btn-primary-checkout" id="confirmBtn">Xác nhận</button>
            </div>
        </div>
    </div>

    <div class="modal-checkout" id="successModal">
        <div class="modal-content-checkout">
            <div class="modal-header-checkout"><h2>🎉 Đặt hàng thành công!</h2></div>
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
        
        // Đồng bộ ngay vào trình duyệt để JS không check thiếu dữ liệu
        if (userData) {
            sessionStorage.setItem("currentUser", JSON.stringify({
                username: userData.ho_ten || userData.ten_dang_nhap,
                email: userData.email,
                phone: userData.so_dien_thoai
            }));
        }
    </script>

    <script src="../js/checkout.js"></script>

</body>
</html>