<?php
// 1. Kiểm tra xem đây có phải là yêu cầu lấy dữ liệu từ Javascript không
if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
    require_once '../../Config/db.php';
    header('Content-Type: application/json');

    $category = $_GET['category'] ?? 'all';
    $sort = $_GET['sort'] ?? 'default';
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 6;
    $offset = ($page - 1) * $limit;

    try {
        $where = ($category !== 'all') ? "WHERE id_danh_muc = :cat" : "";

        // Truy vấn sản phẩm
        $stmt = $pdo->prepare("SELECT * FROM mon_an $where LIMIT :limit OFFSET :offset");
        if ($category !== 'all') $stmt->bindValue(':cat', $category);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Tính tổng trang
        $countStmt = $pdo->prepare("SELECT COUNT(*) FROM mon_an $where");
        if ($category !== 'all') $countStmt->bindValue(':cat', $category);
        $countStmt->execute();
        $totalPages = ceil($countStmt->fetchColumn() / $limit);

        echo json_encode([
            'success' => true,
            'products' => $products,
            'totalPages' => $totalPages,
            'currentPage' => $page
        ]);
        exit; // Dừng lại ở đây, không chạy xuống phần HTML bên dưới
    } catch (Exception $e) {
        echo json_encode(['success' => false]);
        exit;
    }
}

// Nếu không phải yêu cầu AJAX, trang web sẽ chạy tiếp xuống phần HTML bên dưới như bình thường
require_once '../../Config/db.php';
?>

<!DOCTYPE html>
<html lang="vi">

<?php
// Nhúng file kết nối database
require_once '../../Config/db.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thực đơn | Yummy Seoul – Tiệm ăn vặt Hàn Quốc</title>
    <link rel="icon" type="image/x-icon" href="../../Public/img/homepage/logo.png">

    <link href="https://fonts.googleapis.com/css2?family=Asap:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="../../Public/css/home.css">
    <link rel="stylesheet" href="../../Public/css/product.css">
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


    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <button class="mobile-menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
    </button>

    <div class="container">
        <aside class="sidebar" id="sidebar">
            <h3>Danh Mục Menu</h3>
            <ul id="menu">
                <li data-category="all" class="active">Tất Cả Sản Phẩm</li>
                <li data-category="1">Cơm (Rice)</li>
                <li data-category="2">Gà (Chicken)</li>
                <li data-category="3">Mì (Noodles)</li>
                <li data-category="4">Lẩu & Súp (Stew)</li>
                <li data-category="5">Đồ ăn nhẹ (Snacks)</li>
                <li data-category="6">Đồ uống (Drinks)</li>
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
                if (isset($pdo)) {
                    try {
                        $stmt = $pdo->query("SELECT * FROM mon_an");
                        $hasProducts = false;

                        while ($row = $stmt->fetch()) {
                            $hasProducts = true;
                ?>
                            <div class="product-card">
                                <div class="product-image">
                                    <img src="../../Public/img/monan/<?php echo $row['hinh_anh']; ?>" alt="<?php echo $row['ten_mon']; ?>">
                                    <div class="product-overlay">
                                        <button class="quick-view-btn" onclick="openQuickView(<?php echo htmlspecialchars(json_encode($row)); ?>)">Xem nhanh</button>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <h3 class="product-name"><?php echo $row['ten_mon']; ?></h3>
                                    <div class="product-price">
                                        <?php echo number_format($row['gia_ban'], 0, ',', '.'); ?>đ
                                    </div>
                                    <div class="product-actions">
                                        <button class="add-to-cart-btn">
                                            <i class="fas fa-shopping-cart"></i> MUA HÀNG
                                        </button>
                                    </div>
                                </div>
                            </div>
                <?php
                        }

                        if (!$hasProducts) {
                            echo "<div class='no-products'>Hiện tại cửa hàng chưa có món nào.</div>";
                        }
                    } catch (PDOException $e) {
                        echo "<div class='no-products'>Lỗi truy vấn: " . $e->getMessage() . "</div>";
                    }
                }
                ?>
            </section>

            <div id="paginationContainer" class="pagination">
            </div>
        </main>
    </div>

    <div class="modal" id="quickActionModal" style="display: none;">
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

    <script>
        function openQuickView(product) {
            document.getElementById('modalProductName').innerText = product.ten_mon;
            document.getElementById('modalProductPrice').innerText = new Intl.NumberFormat('vi-VN').format(product.gia_ban) + 'đ';
            document.getElementById('modalQuantity').value = 1;
            document.getElementById('quickActionModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('quickActionModal').style.display = 'none';
        }

        function increaseQuantityModal() {
            let input = document.getElementById('modalQuantity');
            input.value = parseInt(input.value) + 1;
        }

        function decreaseQuantityModal() {
            let input = document.getElementById('modalQuantity');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }

        // Đóng modal khi click ra ngoài vùng trắng
        window.onclick = function(event) {
            let modal = document.getElementById('quickActionModal');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>

    <script src="../../Public/js/product.js"></script>
</body>

</html>