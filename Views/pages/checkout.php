<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán | Yummy Seoul</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/Github-Website_Yummy-Seoul/Public/img/homepage/logo.png">

    <!-- Font + Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Asap:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="/Github-Website_Yummy-Seoul/Public/css/home.css">
    <link rel="stylesheet" href="/Github-Website_Yummy-Seoul/Public/css/checkout.css">
</head>

<body>

<!-- HEADER -->
<?php include 'layout/header.php'; ?>

<!-- ===== MAIN CONTENT ===== -->
<div class="container" id="app">
    <div class="loading">
        <i class="fas fa-spinner"></i>
        <p>Đang kiểm tra đăng nhập...</p>
    </div>
</div>

<!-- ===== MODAL MESSAGE ===== -->
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

<!-- ===== MODAL CONFIRM ===== -->
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
            <button class="modal-btn-checkout modal-btn-primary-checkout" onclick="confirmAction()">Xác nhận</button>
        </div>
    </div>
</div>

<!-- ===== FOOTER ===== -->
<?php include 'layout/footer.php'; ?>

<!-- JS -->
<script src="/Github-Website_Yummy-Seoul/Public/js/checkout.js"></script>

</body>
</html>