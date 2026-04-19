<header>
    <div class="topbar">
        <div class="topbar-logo">
            <a href="home.php">
                <img src="../../Public/img/homepage/logo.png" alt="Yummy Seoul Logo" style="width: 80px; height: 80px; object-fit: cover;" />
            </a>
            <span class="logo-text">Tiệm ăn vặt Hàn Quốc</span>
        </div>

        <div class="search-container">

            <div class="admin-wrapper">
                <button type="button" class="admin-btn" onclick="openAdminModal()" title="Đăng nhập quản lý">
                    <svg viewBox="0 0 24 24" width="22" height="22">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" fill="#a0522d" />
                    </svg>
                </button>
            </div>

            <form action="product.php" method="GET" class="search-bar">
                <input type="text" name="search" placeholder="Tìm kiếm món ăn..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
                <button type="submit" class="search-btn">
                    <svg viewBox="0 0 24 24" width="20" height="20">
                        <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" fill="white" />
                    </svg>
                </button>
            </form>

            <div class="cart-wrapper">
                <a href="cart.php" class="cart-btn">
                    <svg viewBox="0 0 24 24" width="22" height="22">
                        <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1.003 1.003 0 0 0 20 4H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z" fill="#a0522d" />
                    </svg>
                </a>
            </div>
        </div>

        <div class="topbar-actions">
            <a href="login_register.php#login" class="btn-outline">Đăng nhập</a>
            <a href="login_register.php#signup" class="btn-outline">Đăng ký</a>
        </div>
    </div>

    <nav class="navbar">
        <ul class="nav-links">
            <li><a href="home.php" class="<?php echo (isset($page) && $page == 'home') ? 'active' : ''; ?>">Trang chủ</a></li>
            <li><a href="intro.php" class="<?php echo (isset($page) && $page == 'intro') ? 'active' : ''; ?>">Giới thiệu</a></li>
            <li><a href="product.php" class="<?php echo (isset($page) && $page == 'product') ? 'active' : ''; ?>">Sản phẩm</a></li>
            <li><a href="news.php" class="<?php echo (isset($page) && $page == 'news') ? 'active' : ''; ?>">Tin tức</a></li>
            <li><a href="contact.php" class="<?php echo (isset($page) && $page == 'contact') ? 'active' : ''; ?>">Liên hệ</a></li>
        </ul>
        <div class="nav-phone">
            <svg viewBox="0 0 24 24" width="18" height="18">
                <path d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24c1.12.37 2.33.57 3.58.57a1 1 0 011 1v3.5a1 1 0 01-1 1C10.3 21.01 2.99 13.7 2.99 4a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.46.57 3.59a1 1 0 01-.25 1.01l-2.19 2.19z" fill="white" />
            </svg>
            <span>0912.345.678</span>
        </div>
    </nav>
</header>

<div id="adminModal" class="admin-modal-overlay">
    <div class="admin-modal-content">
        <div class="admin-modal-header">
            <h3>Tùy chọn quản lý</h3>
            <span class="admin-close" onclick="closeAdminModal()">&times;</span>
        </div>
        <div class="admin-modal-body">
            <form id="adminLoginForm">
                <div class="admin-form-group">
                    <label>Email quản lý</label>
                    <input type="email" id="adminEmail" placeholder="email@gmail.com" required>
                </div>
                <div class="admin-form-group">
                    <label>Mật khẩu</label>
                    <input type="password" id="adminPassword" placeholder="******" required>
                </div>
                <div class="admin-modal-footer">
                    <button type="button" class="btn-huy" onclick="closeAdminModal()">Hủy</button>
                    <button type="submit" class="btn-xacnhan">Đăng nhập</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* CSS Nút bấm Admin */
    .admin-btn {
        background: var(--baby-yellow);
        width: 45px;
        height: 45px;
        border-radius: 50%;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.3s;
    }

    .admin-btn:hover {
        background: var(--pink-soft);
        transform: translateY(-2px);
    }

    /* CSS Giao diện Modal (Bảng đăng nhập) */
    .admin-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        display: none;
        /* Ẩn mặc định */
        align-items: center;
        justify-content: center;
        z-index: 9999;
        backdrop-filter: blur(5px);
    }

    .admin-modal-overlay.open {
        display: flex;
    }

    .admin-modal-content {
        background: var(--baby-cream);
        width: 100%;
        max-width: 400px;
        padding: 25px;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-hover);
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .admin-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .admin-modal-header h3 {
        color: var(--red-brown);
        font-size: 20px;
    }

    .admin-close {
        cursor: pointer;
        font-size: 24px;
        color: var(--text-light);
    }

    .admin-form-group {
        margin-bottom: 15px;
    }

    .admin-form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
        color: var(--red-brown);
    }

    .admin-form-group input {
        width: 100%;
        padding: 10px;
        border-radius: 10px;
        border: 1px solid var(--pink-soft);
        outline: none;
    }

    .admin-modal-footer {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .btn-huy {
        flex: 1;
        padding: 10px;
        border-radius: 10px;
        border: 1.5px solid var(--red-brown);
        cursor: pointer;
        background: #fff;
    }

    .btn-xacnhan {
        flex: 1;
        padding: 10px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        background: var(--red-brown);
        color: #fff;
        font-weight: 600;
    }
</style>

<script>
    // Hàm mở và đóng Modal
    function openAdminModal() {
        document.getElementById('adminModal').classList.add('open');
    }

    function closeAdminModal() {
        document.getElementById('adminModal').classList.remove('open');
    }

    // Xử lý logic đăng nhập khi nhấn Submit
    document.getElementById('adminLoginForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const email = document.getElementById('adminEmail').value;
        const pass = document.getElementById('adminPassword').value;

        // Thay đổi thông tin admin tại đây
        if (email === 'admin@yummyseoul.com' && pass === '123456') {
            window.location.href = '../admin/index.php'; // Đường dẫn trang quản lý
        } else {
            alert('Sai tài khoản hoặc mật khẩu quản lý!');
        }
    });

    // Đóng modal khi click ra ngoài vùng box
    window.onclick = function(event) {
        const modal = document.getElementById('adminModal');
        if (event.target == modal) {
            closeAdminModal();
        }
    }
</script>