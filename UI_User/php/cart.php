<?php
// Ngăn chặn cache trình duyệt
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

require_once '../../SQL_Connect/db.php';

$promoData = [];
try {
    // Truy vấn các mã còn hạn và đang có hiệu lực từ Database của Duy
    $stmt = $pdo->query("SELECT ma_khuyen_mai, phan_tram_giam, giam_toi_da, don_hang_min, co_freeship 
                         FROM khuyen_mai 
                         WHERE trang_thai = 'Hiệu lực' AND ngay_het_han >= NOW()");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
        $promoData[$row['ma_khuyen_mai']] = [
            'phan_tram' => (int)$row['phan_tram_giam'],
            'giam_max' => (int)$row['giam_toi_da'],
            'min_don' => (int)$row['don_hang_min'],
            'freeship' => ($row['co_freeship'] === 'Có')
        ];
    }
} catch (PDOException $e) {
    // Duy có thể để trống hoặc ghi log lỗi tại đây
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../../Image/homepage/logo.png">
    <title>Giỏ Hàng | Yummy Seoul - Tiệm ăn vặt Hàn Quốc</title>
    <link rel="icon" type="image/x-icon" href="/Github-Website_Yummy-Seoul/Public/img/homepage/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Asap:wght@400;600;700&family=Dancing+Script:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/cart.css">
</head>

<body>

    <?php include '../../Header_Footer/php/header.php'; ?>

    <main class="cart-page-container">
        <div class="cart-decorations">
            <div class="decor-item blossom-1"></div>
            <div class="decor-item leaf-1"></div>
            <div class="decor-item heart-1"></div>
            <div class="decor-item blossom-2"></div>
        </div>

        <div class="container-custom">
            <div class="cart-header fade-up">
                <a href="home.php" class="back-to-shop">
                    <i class="fa-solid fa-arrow-left"></i> <strong>Tiếp tục mua sắm</strong>
                </a>

                <div class="title-with-badge">
                    <h1 class="cart-title">Giỏ hàng</h1>
                    <span id="itemCountBadge" class="cart-badge-orange">0 sản phẩm</span>
                </div>

                <div class="cart-subtitle-handwritten">Đừng để bụng đói khi về nhà nhé!</div>
            </div>

            <div class="cart-main-layout">

                <div class="cart-items-column fade-up delay-1" id="cartItemsList">
                </div>

                <div class="cart-summary-column fade-up delay-2">
                    <div class="summary-box">
                        <h2 class="summary-title">Hóa đơn của bạn</h2>
                        <div class="summary-row">
                            <span>Tạm tính</span>
                            <span id="subtotal">0đ</span>
                        </div>
                        <div class="summary-row">
                            <span>Vận chuyển</span>
                            <span id="shipping">20.000đ</span>
                        </div>
                        <div class="summary-row discount">
                            <span>Giảm giá</span>
                            <span id="discount">-0đ</span>
                        </div>

                        <div id="promoDisplay"></div>
                        <div class="promo-box">
                            <input type="text" id="promoInput" placeholder="Nhập mã ưu đãi...">
                            <button onclick="applyPromo()">Áp dụng</button>
                        </div>

                        <div class="summary-divider"></div>
                        <div class="summary-row total">
                            <span>Tổng cộng</span>
                            <span id="total">0đ</span>
                        </div>

                        <button type="button" class="btn-checkout" id="checkoutBtn" onclick="checkout()">
                            Tiến hành thanh toán
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include '../../Header_Footer/php/footer.php'; ?>

    <div id="toast-container" class="toast-container"></div>

    <script>
        const isLoggedIn = <?php echo (isset($_SESSION['id_nguoi_dung']) && !empty($_SESSION['id_nguoi_dung'])) ? 1 : 0; ?>;
    
    // URL trang đăng nhập của bạn
    const LOGIN_URL = 'login_register.php'; 

    console.log("Trạng thái đăng nhập thực tế:", isLoggedIn);
    </script>

    <script src="../js/cart.js?v=<?php echo time(); ?>"></script>

</body>

</html>