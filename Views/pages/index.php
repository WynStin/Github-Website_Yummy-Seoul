<?php
/**
 * Yummy Seoul - PHP Homepage
 * Main entry point for the storefront application
 */

// Start session for user management
session_start();

// Set timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Define base paths
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/');
define('DOCUMENT_ROOT', __DIR__);

// Simple routing - you can expand this later
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Initialize variables for the storefront
$user_logged_in = isset($_SESSION['user_id']);
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

/**
 * PAGE ROUTING LOGIC
 * Add more pages as needed
 */
switch($page) {
    case 'cart':
        // Cart page logic
        $page_title = 'Giỏ hàng - Yummy Seoul';
        break;
    
    case 'checkout':
        // Checkout page logic
        $page_title = 'Thanh toán - Yummy Seoul';
        break;
    
    case 'account':
        // Account page logic
        if (!$user_logged_in) {
            header('Location: ' . BASE_URL . '?page=login');
            exit;
        }
        $page_title = 'Tài khoản - Yummy Seoul';
        break;
    
    case 'login':
        // Login page logic
        $page_title = 'Đăng nhập - Yummy Seoul';
        break;
    
    case 'home':
    default:
        // Load the main storefront from index.html
        $page_title = 'Yummy Seoul – Tiệm ăn vặt Hàn Quốc';
        break;
}

?>
<?php if ($page === 'home'): ?>
    <!-- Load the main storefront HTML -->
    <?php include 'index.html'; ?>
<?php else: ?>
    <!-- Handle other pages here -->
    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo htmlspecialchars($page_title); ?></title>
        <link href="https://fonts.googleapis.com/css2?family=Asap:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
        <style>
            :root {
                --cream: #fdf6ec;
                --brown-deep: #3b1a0e;
                --red-brown: #451715;
                --gold: #c8922a;
                --text-dark: #2c1a0e;
            }
            * {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }
            body {
                font-family: "Asap", sans-serif;
                color: var(--text-dark);
                background: var(--cream);
            }
            .container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 40px 20px;
                text-align: center;
            }
            h1 {
                color: var(--brown-deep);
                margin-bottom: 20px;
            }
            .back-link {
                display: inline-block;
                margin-top: 20px;
                padding: 10px 20px;
                background: var(--gold);
                color: white;
                text-decoration: none;
                border-radius: 8px;
            }
            .back-link:hover {
                opacity: 0.9;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1><?php echo htmlspecialchars($page_title); ?></h1>
            <p>Trang này đang được phát triển</p>
            <a href="<?php echo BASE_URL; ?>" class="back-link">← Quay lại</a>
        </div>
    </body>
    </html>
<?php endif; ?>
