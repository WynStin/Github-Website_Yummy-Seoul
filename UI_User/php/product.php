<?php
// 1. Nạp cấu hình database (Lúc này db.php đã chứa các hàm xử lý món ăn như getProducts, countProducts)
require_once '../../SQL_Connect/db.php';

// --- ĐÃ LOẠI BỎ KHỞI TẠO MODEL ---

// 2. Xử lý logic tiêu đề hiển thị (dành cho yêu cầu không phải AJAX)
$search = $_GET['search'] ?? '';
$displayTitle = "Tất cả sản phẩm";

if (!empty($search)) {
    $displayTitle = "Kết quả tìm kiếm cho: '" . htmlspecialchars($search) . "'";
}

// 3. Kiểm tra xem đây có phải là yêu cầu lấy dữ liệu (AJAX) từ Javascript không
if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
    header('Content-Type: application/json');
    $category = $_GET['category'] ?? 'all';
    $sort = $_GET['sort'] ?? 'default';
    $search = $_GET['search'] ?? '';
    $minPrice = $_GET['minPrice'] ?? null;
    $maxPrice = $_GET['maxPrice'] ?? null;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $limit = 6;
    $offset = ($page - 1) * $limit;

    try {
        /**
         * GỌI HÀM TRỰC TIẾP TỪ db.php
         * Không còn dùng $productModel-> nữa
         */
        $products = getProducts($category, $search, $sort, $minPrice, $maxPrice, $limit, $offset);
        $totalItems = countProducts($category, $search, $minPrice, $maxPrice);
        $totalPages = ceil($totalItems / $limit);

        echo json_encode([
            'success' => true,
            'products' => $products,
            'totalPages' => $totalPages,
            'currentPage' => $page
        ]);
        exit;
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        exit;
    }
}

// Nếu không phải yêu cầu AJAX, trang web sẽ tiếp tục chạy xuống phần HTML bên dưới
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thực đơn | Yummy Seoul – Tiệm ăn vặt Hàn Quốc</title>
    <link rel="icon" type="image/x-icon" href="../../Image/homepage/logo.png">

    <link href="https://fonts.googleapis.com/css2?family=Asap:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/product.css">
</head>

<body class="product-page">
    <?php $page = "product"; ?>
    <?php include '../../Header_Footer/php/header.php'; ?>

    <div class="page-title" id="pageTitle">Thực đơn Yummy Seoul</div>

    <div class="mobile-category-bar">
        <div class="nav-scroll-container">
            <button class="nav-item active" data-category="all">Tất cả</button>
            <button class="nav-item" data-category="1">Cơm (Rice)</button>
            <button class="nav-item" data-category="2">Gà (Chicken)</button>
            <button class="nav-item" data-category="3">Mì (Noodles)</button>
            <button class="nav-item" data-category="4">Lẩu & Súp</button>
            <button class="nav-item" data-category="5">Đồ ăn nhẹ</button>
            <button class="nav-item" data-category="6">Đồ uống</button>
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
                <li><a href="shipping_policy.php"><i class="fas fa-shipping-fast"></i> Chính sách giao hàng</a></li>
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

                    <div class="price-filter" style="display: flex; gap: 5px; align-items: center; margin-right: 15px;">
                        <input type="number" id="minPriceInput" placeholder="Giá từ" style="width: 80px; padding: 5px; border-radius: 5px; border: 1px solid #ccc;">
                        <span>-</span>
                        <input type="number" id="maxPriceInput" placeholder="đến" style="width: 80px; padding: 5px; border-radius: 5px; border: 1px solid #ccc;">
                        <button onclick="currentPage=1; loadProducts(currentCategory, currentSort, 1)" style="padding: 5px 10px; cursor: pointer; background: var(--red-brown); color: white; border: none; border-radius: 5px;">Lọc</button>
                    </div>

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
                                    <img src="../../Image/monan/<?php echo $row['hinh_anh']; ?>" alt="<?php echo $row['ten_mon']; ?>">
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

    <?php include '../../Header_Footer/php/footer.php'; ?>

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

    <script src="../js/product.js"></script>
</body>

</html>