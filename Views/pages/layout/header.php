<!--HEADER-->
<header>
    <div class="topbar">
        <!--Hiện logo-->
        <div class="topbar-logo">
            <a href="home.php">
                <img src="../../Public/img/homepage/logo.png" alt="Yummy Seoul Logo" style="width: 80px; height: 80px; object-fit: cover;" />
            </a>
        </div>

        <!--Hiện thanh tìm kiếm và giỏ hàng-->
        <div class="search-container">
            <div class="search-bar">
                <input type="text" placeholder="Tìm kiếm sản phẩm..." />
                <button class="search-btn">
                    <svg viewBox="0 0 24 24" width="20" height="20">
                        <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" fill="white" />
                    </svg>
                </button>
            </div>

            <div class="cart-wrapper">
                <a href="cart.php" class="cart-btn">
                    <svg viewBox="0 0 24 24" width="22" height="22">
                        <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1.003 1.003 0 0 0 20 4H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z" fill="#a0522d" />
                    </svg>
                </a>
            </div>
        </div>

        <!--Đăng nhập và đăng ký-->
        <div class="topbar-actions">
            <button class="btn-outline">
                <a href="login_register.php#login">Đăng nhập</a>
            </button>
            <button class="btn-outline">
                <a href="login_register.php#login">Đăng ký</a>
            </button>
        </div>
    </div>

    <!--Thanh điều hướng-->
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