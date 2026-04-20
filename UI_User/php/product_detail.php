<?php
// Nạp file kết nối và các hàm xử lý (db.php đã có session_start inside)
require_once '../../SQL_Connect/db.php';

// Lấy ID từ URL
$id_mon_an = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product = null;

if ($id_mon_an > 0) {
    // SỬ DỤNG LUÔN HÀM CÓ SẴN TRONG db.php ĐỂ GỘP LOGIC
    $product = getProductById($id_mon_an);
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../../Image/homepage/logo.png">
    <title><?= $product ? htmlspecialchars($product['ten_mon']) : 'Không tìm thấy sản phẩm' ?> | Yummy Seoul - Tiệm ăn vặt Hàn Quốc</title>
    <link href="https://fonts.googleapis.com/css2?family=Asap:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/product_detail.css">
</head>

<body class="detail-page">
    <?php include '../../Header_Footer/php/header.php'; ?>

    <div class="container detail-container">
        <?php if ($product): ?>
            <nav class="breadcrumb">
                <a href="home.php">Trang chủ</a> <i class="fas fa-chevron-right"></i>
                <a href="product.php">Thực đơn</a> <i class="fas fa-chevron-right"></i>
                <span><?= htmlspecialchars($product['ten_mon']) ?></span>
            </nav>

            <div class="product-detail-wrapper">
                <div class="product-gallery">
                    <img id="mainImage" src="../../Image/monan/<?= htmlspecialchars($product['hinh_anh']) ?>" alt="<?= htmlspecialchars($product['ten_mon']) ?>">
                </div>

                <div class="product-info-detail">
                    <h1 class="detail-title"><?= htmlspecialchars($product['ten_mon']) ?></h1>

                    <div class="price-stock-wrapper">
                        <div class="detail-price">
                            <?= number_format($product['gia_ban'], 0, ',', '.') ?>đ
                        </div>
                        <div class="detail-stock-info">
                            <span class="stock-status <?= $product['so_luong_ton'] > 0 ? 'in-stock' : 'out-of-stock' ?>">
                                <?= htmlspecialchars($product['trang_thai']) ?>
                            </span>
                            <span class="stock-count">Kho: <?= htmlspecialchars($product['so_luong_ton']) ?></span>
                        </div>
                    </div>

                    <div class="detail-description">
                        <p><?= !empty($product['mo_ta']) ? nl2br(htmlspecialchars($product['mo_ta'])) : 'Đang cập nhật mô tả...' ?></p>
                    </div>

                    <div class="detail-action-box">
                        <div class="quantity-selector">
                            <span class="qty-label">Số Lượng:</span>
                            <div class="qty-controls">
                                <button type="button" class="qty-btn" id="decreaseQty">-</button>
                                <input type="number" id="quantityInput" value="1" min="1" max="<?= $product['so_luong_ton'] ?>">
                                <button type="button" class="qty-btn" id="increaseQty">+</button>
                            </div>
                        </div>

                        <div class="action-buttons">
                            <button class="btn-add-cart" id="btnAddToCart"
                                data-id="<?= $product['id_mon_an'] ?>"
                                data-name="<?= htmlspecialchars($product['ten_mon']) ?>"
                                data-price="<?= $product['gia_ban'] ?>"
                                data-image="../../Image/monan/<?= htmlspecialchars($product['hinh_anh']) ?>">
                                <i class="fas fa-shopping-cart"></i> Thêm vào giỏ
                            </button>
                            <button class="btn-buy-now" id="btnBuyNow"
                                data-id="<?= $product['id_mon_an'] ?>"
                                data-name="<?= htmlspecialchars($product['ten_mon']) ?>"
                                data-price="<?= $product['gia_ban'] ?>"
                                data-image="../../Image/monan/<?= htmlspecialchars($product['hinh_anh']) ?>">
                                MUA NGAY
                            </button>
                        </div>

                        <div class="product-stats">
                            <p>Có <?= number_format($product['so_luong_da_ban'], 0, ',', '.') ?> lượt mua sản phẩm</p>
                            <p>Có <?= number_format($product['so_luot_xem'], 0, ',', '.') ?> lượt xem sản phẩm</p>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="error-not-found">
                <h2>Opps! Không tìm thấy món ăn này.</h2>
                <p>Món ăn có thể đã bị xóa hoặc đường dẫn không hợp lệ.</p>
                <a href="product.php" class="btn-back">Quay lại thực đơn</a>
            </div>
        <?php endif; ?>
    </div>

    <?php include '../../Header_Footer/php/footer.php'; ?>
    <script src="../js/product_detail.js"></script>
</body>

</html>