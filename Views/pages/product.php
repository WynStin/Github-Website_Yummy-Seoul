<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thực đơn | Yummy Seoul – Tiệm ăn vặt Hàn Quốc</title>
    <link rel="icon" type="image/x-icon" href="../../Public/img/homepage/logo.png">

    <link href="https://fonts.googleapis.com/css2?family=Asap:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="../../Public/css/home.css">
    <link rel="stylesheet" href="../../Public/css/product.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>

<body class="product-page">
    <?php $page = "product"; ?>
    <?php include 'layout/header.php'; ?>

    <div class="page-title" id="pageTitle">Thực đơn Yummy Seoul</div>

    <div class="mobile-category-bar">
        <div class="nav-scroll-container">
            <button class="nav-item active" data-category="all">Tất cả</button>
            <button class="nav-item" data-category="com">Cơm (Rice)</button>
            <button class="nav-item" data-category="ga">Gà (Chicken)</button>
            <button class="nav-item" data-category="mi">Mì (Noodles)</button>
            <button class="nav-item" data-category="lau-sup">Lẩu & Súp</button>
            <button class="nav-item" data-category="an-nhe">Đồ ăn nhẹ</button>
            <button class="nav-item" data-category="do-uong">Đồ uống</button>
        </div>
    </div>

    <button class="mobile-menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
    </button>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="container">
        <aside class="sidebar" id="sidebar">
            <h3>Danh Mục Menu</h3>
            <ul id="menu">
                <li data-category="all" class="active">Tất Cả Sản Phẩm</li>
                <li data-category="com">Cơm (Rice)</li>
                <li data-category="ga">Gà (Chicken)</li>
                <li data-category="mi">Mì (Noodles)</li>
                <li data-category="lau-sup">Lẩu & Súp (Stew)</li>
                <li data-category="an-nhe">Đồ ăn nhẹ (Snacks)</li>
                <li data-category="do-uong">Đồ uống (Drinks)</li>
            </ul>

            <h3 style="margin-top: 30px;">Hỗ trợ khách hàng</h3>
            <ul>
                <li><a href="#"><i class="fas fa-question-circle"></i> Hướng dẫn mua hàng</a></li>
                <li><a href="#"><i class="fas fa-shipping-fast"></i> Chính sách giao hàng</a></li>
                <li><a href="#"><i class="fas fa-undo"></i> Chính sách đổi trả</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="products-header">
                <h2 id="categoryTitle">Tất cả sản phẩm</h2>
                <div class="view-options">
                    <button class="view-btn active" id="gridView" title="Xem dạng lưới">
                        <i class="fas fa-th-large"></i>
                    </button>
                    <button class="view-btn" id="listView" title="Xem dạng danh sách">
                        <i class="fas fa-list"></i>
                    </button>

                    <span class="sort-label">Sắp xếp:</span>
                    <select class="sort-select" id="sortSelect">
                        <option value="default">Mặc định</option>
                        <option value="priceAsc">Giá tăng dần</option>
                        <option value="priceDesc">Giá giảm dần</option>
                        <option value="nameAsc">Tên A-Z</option>
                        <option value="nameDesc">Tên Z-A</option>
                    </select>
                </div>
            </div>

            <section id="productsContainer" class="product-grid">
                <?php
                try {
                    // Sử dụng biến $pdo từ file db.php
                    $stmt = $pdo->query("SELECT * FROM products");

                    while ($row = $stmt->fetch()) {
                ?>
                        <div class="product-card">
                            <div class="product-image">
                                <img src="../../Public/img/monan/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                            </div>
                            <div class="product-info">
                                <h3 class="product-name"><?php echo $row['name']; ?></h3>
                                <div class="price-container">
                                    <span class="current-price"><?php echo number_format($row['price'], 0, ',', '.'); ?>đ</span>
                                </div>
                                <button class="buy-btn">MUA HÀNG</button>
                            </div>
                        </div>
                <?php
                    }
                } catch (PDOException $e) {
                    echo "Lỗi truy vấn: " . $e->getMessage();
                }
                ?>
            </section>

            <div id="paginationContainer" class="pagination"></div>
        </main>
    </div>

    <div class="modal" id="quickActionModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Tùy chọn sản phẩm</h2>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="product-info-modal">
                    <div class="product-name-modal" id="modalProductName">Tên món ăn</div>
                    <div class="product-price-modal" id="modalProductPrice">0đ</div>
                </div>
                <div class="quantity-section-modal">
                    <span class="quantity-label-modal">Số lượng:</span>
                    <div class="quantity-controls-modal">
                        <button class="quantity-btn-modal" onclick="decreaseQuantityModal()">−</button>
                        <input type="number" class="quantity-input-modal" id="modalQuantity" value="1" min="1" max="99">
                        <button class="quantity-btn-modal" onclick="increaseQuantityModal()">+</button>
                    </div>
                </div>
            </div>
            <div class="modal-actions">
                <button class="modal-btn" onclick="addToCartFromModal()">
                    <i class="fas fa-shopping-cart"></i> Thêm vào giỏ
                </button>
                <button class="modal-btn modal-btn-primary" onclick="buyNowFromModal()">
                    <i class="fas fa-bolt"></i> Mua ngay
                </button>
            </div>
        </div>
    </div>

    <?php include 'layout/footer.php'; ?>

    <script src="../../Public/js/product.js"></script>
</body>

</html>