<?php require_once '../../SQL_Connect/db.php'; ?>

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

    <div id="app">
        <div class="loading-state" style="text-align: center; padding: 100px; color: #451715;">
            <i class="fas fa-spinner fa-spin" style="font-size: 3rem;"></i>
            <p style="margin-top: 20px; font-weight: 600;">Đang tải thông tin đơn hàng...</p>
        </div>
    </div>

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

    <?php include '../../Header_Footer/php/footer.php'; ?>

    <script src="../js/checkout.js"></script>
    
    <script>
        // Kiểm tra giỏ hàng để tránh lỗi treo trang
        document.addEventListener('DOMContentLoaded', function() {
            const cart = JSON.parse(localStorage.getItem('cart') || '[]');
            if (cart.length === 0) {
                alert('Giỏ hàng trống, mời bạn chọn món!');
                window.location.href = 'product.php';
            }
        });
    </script>
</body>
</html>