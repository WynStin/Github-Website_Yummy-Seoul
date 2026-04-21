<?php
require_once '../../SQL_Connect/db.php';

$error_message = "";
$success_message = "";

// 3. XỬ LÝ ĐĂNG NHẬP
if (isset($_POST['login_action'])) {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Kiểm tra xem biến $pdo có tồn tại không
    if (!isset($pdo)) {
        die("Lỗi: Biến kết nối database \$pdo chưa được định nghĩa.");
    }

    $stmt = $pdo->prepare("SELECT * FROM nguoi_dung WHERE user_name = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && $password === $user['mat_khau']) {
        if ($user['trang_thai'] === 'Bị khóa') {
            $error_message = "Tài khoản của bạn đã bị khóa!";
        } else {
            // --- SỬA TÊN BIẾN SESSION TẠI ĐÂY ---
            // Đổi từ 'user_id' thành 'id_nguoi_dung' để khớp với checkout.php
            $_SESSION['id_nguoi_dung'] = $user['id_nguoi_dung']; 
            $_SESSION['username'] = $user['user_name'];
            $_SESSION['ho_ten'] = $user['ho_ten'];
            $_SESSION['vai_tro'] = $user['vai_tro'];
            $_SESSION['logged_in'] = true;

            // Kiểm tra xem có yêu cầu chuyển hướng cụ thể không
            if (!empty($_POST['redirect'])) {
                $location = $_POST['redirect'];
            } else {
                $location = "home.php"; // Mặc định về trang chủ
            }

            header("Location: " . $location);
            exit();
        }
    } else {
        $error_message = "Tên đăng nhập hoặc mật khẩu không đúng!";
    }
}

// --- Thêm đoạn này vào sau phần xử lý Đăng nhập (login_action) ---

if (isset($_POST['register_action'])) {
    $ho_ten = trim($_POST['ho_ten'] ?? '');
    $user_name = trim($_POST['user_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $so_dien_thoai = trim($_POST['so_dien_thoai'] ?? '');
    $dia_chi = trim($_POST['dia_chi'] ?? '');
    $mat_khau = $_POST['mat_khau'] ?? '';

    // 1. Kiểm tra trùng lặp (Thêm check cả số điện thoại)
    $stmt = $pdo->prepare("SELECT id_nguoi_dung FROM nguoi_dung WHERE user_name = ? OR email = ? OR so_dien_thoai = ?");
    $stmt->execute([$user_name, $email, $so_dien_thoai]);

    if ($stmt->rowCount() > 0) {
        // Lấy dữ liệu đã tồn tại để báo lỗi cụ thể cho người dùng
        $existing = $stmt->fetch();
        $error_message = "Tên đăng nhập, Email hoặc Số điện thoại này đã được sử dụng!";
    } else {
        // 2. Nếu không trùng thì mới INSERT
        try {
            $sql = "INSERT INTO nguoi_dung (ho_ten, user_name, email, so_dien_thoai, dia_chi_mac_dinh, mat_khau, vai_tro, trang_thai) 
                    VALUES (?, ?, ?, ?, ?, ?, 'Khách hàng', 'Hoạt động')";
            $insert = $pdo->prepare($sql);
            $insert->execute([$ho_ten, $user_name, $email, $so_dien_thoai, $dia_chi, $mat_khau]);
            $success_message = "Đăng ký thành công! Vui lòng đăng nhập.";
        } catch (PDOException $e) {
            // Trường hợp có lỗi bất ngờ khác từ CSDL
            $error_message = "Lỗi hệ thống: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
    <link rel="icon" type="image/x-icon" href="../../Image/homepage/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../css/login_register.css">
</head>

<body>
    <!--Khối container chính-->
    <div class="container">
        <!--Nút trở về home-->
        <a class='back-home' href='home.php' title='Về trang chủ'>
            <i class="fas fa-arrow-left"></i>
        </a>

        <!--Trên mobile-->
        <div class="mobile-toggle">
            <button class="btn active" onclick="showLogin()">Đăng nhập</button>
            <button class="btn" onclick="showSignup()">Đăng ký</button>
        </div>

        <div class="container-forms">
            <div class="container-info">
                <div class="info-item">
                    <p>Đã có tài khoản?</p>
                    <button class="btn" onclick="toggleForms()">Đăng nhập</button>
                </div>
                <div class="info-item">
                    <p>Chưa có tài khoản?</p>
                    <button class="btn" onclick="toggleForms()">Đăng ký</button>
                </div>
            </div>

            <div class="container-form">
                <form class="form-item log-in" method="POST" action="">
                    <h1>Đăng nhập</h1>

                    <input type="hidden" name="redirect" value="<?php echo isset($_GET['redirect']) ? htmlspecialchars($_GET['redirect']) : ''; ?>">

                    <?php if (isset($error_message)) echo "<p style='color:red;'>$error_message</p>"; ?>

                    <div class="input-container">
                        <input type="text" name="username" placeholder="Tên đăng nhập" required />
                        <i class="fas fa-user input-icon"></i>
                    </div>
                    <div class="password-container">
                        <input type="password" name="password" id="loginPassword" placeholder="Mật khẩu" required />
                        <i class="fas fa-lock input-icon"></i>
                    </div>

                    <button class="btn btn-submit" type="submit" name="login_action">Đăng nhập</button>

                    <div class="divider"><span>hoặc</span></div>

                    <div class="social-login">
                        <button type="button" class="social-btn google" onclick="loginWithGoogle()">
                            <i class="fab fa-google"></i>
                            <span>Đăng nhập với Google</span>
                        </button>
                        <button type="button" class="social-btn facebook" onclick="loginWithFacebook()">
                            <i class="fab fa-facebook-f"></i>
                            <span>Đăng nhập với Facebook</span>
                        </button>
                    </div>
                </form>

                <form class="form-item sign-up" method="POST" action="">
                    <h1>Đăng ký</h1>

                    <input type="hidden" name="redirect" value="<?php echo isset($_GET['redirect']) ? htmlspecialchars($_GET['redirect']) : ''; ?>">

                    <?php if (isset($success_message)) echo "<p style='color:green;'>$success_message</p>"; ?>
                    <?php if (isset($error_message) && isset($_POST['register_action'])) echo "<p style='color:red;'>$error_message</p>"; ?>

                    <div class="input-container">
                        <input type="text" name="ho_ten" placeholder="Họ và tên" required />
                        <i class="fas fa-address-card input-icon"></i>
                    </div>
                    <div class="input-container">
                        <input type="text" name="user_name" placeholder="Tên đăng nhập" required />
                        <i class="fas fa-user input-icon"></i>
                    </div>
                    <div class="input-container">
                        <input type="email" name="email" placeholder="Email" required />
                        <i class="fas fa-envelope input-icon"></i>
                    </div>
                    <div class="input-container">
                        <input type="tel" name="so_dien_thoai" placeholder="Số điện thoại" required />
                        <i class="fas fa-phone input-icon"></i>
                    </div>
                    <div class="input-container">
                        <input type="text" name="dia_chi" placeholder="Địa chỉ mặc định" required />
                        <i class="fas fa-map-marker-alt input-icon"></i>
                    </div>
                    <div class="password-container">
                        <input type="password" name="mat_khau" id="rePassword" placeholder="Mật khẩu" required />
                        <i class="fas fa-lock input-icon"></i>
                        <i class="fas fa-eye-slash toggle-password" onclick="togglePasswordVisibility('rePassword', this)"></i>
                    </div>

                    <button class="btn btn-submit" type="submit" name="register_action">Đăng ký</button>
                </form>
            </div>
        </div>

        <script src="../js/login_register.js">
        </script>
</body>

</html>