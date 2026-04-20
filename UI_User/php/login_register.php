<?php
require_once '../../SQL_Connect/db.php';

$error_message = "";
$success_message = "";

// 3. XỬ LÝ ĐĂNG NHẬP
if (isset($_POST['login_action'])) {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Kiểm tra xem biến $pdo có tồn tại không để tránh lỗi Fatal Error
    if (!isset($pdo)) {
        die("Lỗi: Biến kết nối database \$pdo chưa được định nghĩa. Hãy kiểm tra file db.php.");
    }

    $stmt = $pdo->prepare("SELECT * FROM nguoi_dung WHERE user_name = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // So sánh trực tiếp mật khẩu dạng 11223344
    if ($user && $password === $user['mat_khau']) { 
        if ($user['trang_thai'] === 'Bị khóa') {
            $error_message = "Tài khoản của bạn đã bị khóa!";
        } else {
            // Lưu thông tin vào Session để web "nhớ" Duy đã đăng nhập
            $_SESSION['user_id'] = $user['id_nguoi_dung'];
            $_SESSION['username'] = $user['user_name'];
            $_SESSION['ho_ten'] = $user['ho_ten'];
            $_SESSION['vai_tro'] = $user['vai_tro'];
            $_SESSION['logged_in'] = true;
            
            // Chuyển hướng về trang chủ
            header("Location: home.php");
            exit();
        }
    } else {
        $error_message = "Tên đăng nhập hoặc mật khẩu không đúng!";
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

        <!--Container con chứa nút chuyển đổi form-->
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

            <!--Container con dạng form đăng nhập-->
            <div class="container-form">
                    <form class="form-item log-in" method="POST" action="">
                        <h1>Đăng nhập</h1>
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

                        <div class="divider">
                            <span>hoặc</span>
                        </div>

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

                    <!--Container con dạng form đăng ký-->
                    <form class="form-item sign-up" onsubmit="register(event)">
                        <h1>Đăng ký</h1>
                        <div class="input-container">
                            <input type="text" id="reFullname" placeholder="Họ và tên" required />
                            <i class="fas fa-address-card input-icon"></i>
                        </div>
                        <div class="input-container">
                            <input type="text" id="reUsername" placeholder="Tên đăng nhập" required />
                            <i class="fas fa-user input-icon"></i>
                        </div>
                        <div class="input-container">
                            <input type="email" id="reEmail" placeholder="Email" required />
                            <i class="fas fa-envelope input-icon"></i>
                        </div>
                        <div class="input-container">
                            <input type="tel" id="rePhone" placeholder="Số điện thoại" required />
                            <i class="fas fa-phone input-icon"></i>
                        </div>
                        <div class="input-container">
                            <input type="text" id="reAddress" placeholder="Địa chỉ mặc định" required />
                            <i class="fas fa-map-marker-alt input-icon"></i>
                        </div>
                        <div class="password-container">
                            <input type="password" id="rePassword" placeholder="Mật khẩu" required />
                            <i class="fas fa-lock input-icon"></i>
                            <i class="fas fa-eye-slash toggle-password"
                                onclick="togglePasswordVisibility('rePassword', this)"></i>
                        </div>
                        <div id="reMessage" class="message"></div>
                        <button class="btn btn-submit" type="submit">Đăng ký</button>

                        <div class="divider">
                            <span>hoặc</span>
                        </div>

                        <div class="social-login">
                            <button type="button" class="social-btn google" onclick="signupWithGoogle()">
                                <i class="fab fa-google"></i>
                                <span>Đăng ký với Google</span>
                            </button>
                            <button type="button" class="social-btn facebook" onclick="signupWithFacebook()">
                                <i class="fab fa-facebook-f"></i>
                                <span>Đăng ký với Facebook</span>
                            </button>
                        </div>
                    </form>
            </div>
        </div>
    </div>

    <script src="../js/login_register.js">
    </script>
</body>

</html>