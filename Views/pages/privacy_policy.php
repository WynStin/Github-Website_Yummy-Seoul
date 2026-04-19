<!doctype html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/x-icon" href="../../Public/img/homepage/logo.png">
    <meta name="Home description" content="Yummy Seoul - Tiệm ăn vặt Hàn Quốc" />
    <meta name="keywords" content="Yummy Seoul, Tiệm ăn vặt, Hàn Quốc" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Chính sách bảo mật | Yummy Seoul – Tiệm ăn vặt Hàn Quốc</title>
    <link
        rel="stylesheet"
        href="../../Public/css/home.css" />
    <link
        rel="stylesheet"
        href="../../Public/css/product.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Asap:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap"
        rel="stylesheet" />

</head>

<body>
    <?php
    include 'layout/header.php';
    ?>

    <div class="product-page">
        <div class="page-title">
            CHÍNH SÁCH BẢO MẬT
        </div>

        <div class="container" style="max-width: 850px; margin: 0 auto; padding: 20px; background: #fff; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">

            <div class="guide-section" style="margin-bottom: 35px;">
                <h2 style="color: var(--red-brown); border-bottom: 2px solid var(--cream-dark); padding-bottom: 10px; font-size: 1.5rem;">
                    <i class="fas fa-user-shield"></i> Thu thập thông tin cá nhân
                </h2>
                <div style="padding: 15px; line-height: 1.8;">
                    <p>Để phục vụ quá trình đặt hàng và quản lý tài khoản, Yummy Seoul thu thập các thông tin sau từ người dùng:</p>
                    <ul>
                        <li><strong>Thông tin tài khoản:</strong> Tên đăng nhập (user_name), Email và Mật khẩu.</li>
                        <li><strong>Thông tin liên lạc:</strong> Họ tên, Số điện thoại và Địa chỉ mặc định để phục vụ việc giao hàng.</li>
                        <li><strong>Dữ liệu giao dịch:</strong> Lịch sử đơn hàng, phương thức thanh toán và các phản hồi về món ăn.</li>
                    </ul>
                </div>
            </div>

            <div class="guide-section" style="margin-bottom: 35px; background-color: #f0f7ff; padding: 20px; border-radius: 10px;">
                <h2 style="color: #0056b3; border-bottom: 2px solid #cfe2ff; padding-bottom: 10px; font-size: 1.5rem;">
                    <i class="fas fa-lock"></i> Cơ chế bảo mật kỹ thuật
                </h2>
                <div style="padding: 15px; line-height: 1.8;">
                    <p>Chúng tôi áp dụng các tiêu chuẩn kỹ thuật để bảo vệ dữ liệu trong cơ sở dữ liệu MySQL:</p>
                    <ol>
                        <li><strong>Mã hóa mật khẩu:</strong> Mật khẩu người dùng được lưu trữ dưới dạng chuỗi đã mã hóa (Hash), đảm bảo ngay cả quản trị viên cũng không thể đọc được mật khẩu gốc.</li>
                        <li><strong>Tính cô lập giao dịch:</strong> Sử dụng công nghệ lưu trữ dữ liệu đảm bảo các giao dịch đặt hàng diễn ra độc lập, an toàn và không bị sai lệch dữ liệu.</li>
                        <li><strong>Kiểm soát quyền truy cập:</strong> Hệ thống phân quyền rõ ràng (Vai trò: Khách hàng/Quản lý), đảm bảo người dùng chỉ có thể truy cập và chỉnh sửa thông tin của chính mình.</li>
                    </ol>
                </div>
            </div>

            <div class="guide-section" style="margin-bottom: 30px;">
                <h2 style="color: var(--red-brown); border-bottom: 2px solid var(--cream-dark); padding-bottom: 10px; font-size: 1.5rem;">
                    <i class="fas fa-handshake"></i> Cam kết của Yummy Seoul
                </h2>
                <ul style="list-style: none; padding-left: 0; line-height: 2;">
                    <li><i class="fas fa-check-circle" style="color: var(--red-brown);"></i> <strong>Không chia sẻ bên thứ ba:</strong> Thông tin cá nhân của quý khách chỉ được sử dụng cho mục đích nội bộ nhằm xử lý đơn hàng và cải thiện chất lượng dịch vụ tại cửa hàng.</li>
                    <li><i class="fas fa-user-edit" style="color: var(--red-brown);"></i> <strong>Quyền thay đổi:</strong> Quý khách có toàn quyền xem, cập nhật hoặc yêu cầu khóa tài khoản cá nhân thông qua giao diện quản lý thông tin trên website.</li>
                    <li><i class="fas fa-shield-alt" style="color: var(--red-brown);"></i> <strong>An toàn hệ thống:</strong> Chúng tôi thường xuyên rà soát và bảo trì hệ thống để ngăn chặn các truy cập trái phép vào máy chủ dữ liệu.</li>
                </ul>
            </div>

            <div style="text-align: center; margin-top: 40px;">
                <a href="home.php" class="modal-btn modal-btn-primary" style="text-decoration: none; display: inline-block; width: auto; padding: 15px 35px; border-radius: 8px;">
                    VỀ TRANG CHỦ
                </a>
            </div>
        </div>
    </div>

    <?php
    include 'layout/footer.php';
    ?>

</body>

</html>