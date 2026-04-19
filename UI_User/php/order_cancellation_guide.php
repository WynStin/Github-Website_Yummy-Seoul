<!doctype html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/x-icon" href="../../Image/homepage/logo.png">
    <meta name="Home description" content="Yummy Seoul - Tiệm ăn vặt Hàn Quốc" />
    <meta name="keywords" content="Yummy Seoul, Tiệm ăn vặt, Hàn Quốc" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hướng dẫn hủy đơn | Yummy Seoul – Tiệm ăn vặt Hàn Quốc</title>
    <link
        rel="stylesheet"
        href="../css/home.css" />
    <link
        rel="stylesheet"
        href="../css/product.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Asap:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap"
        rel="stylesheet" />

</head>

<body>
    <?php
    include '../../Header_Footer/php/header.php';
    ?>

    <div class="product-page">
        <div class="page-title">
            HƯỚNG DẪN HỦY ĐƠN HÀNG
        </div>

        <div class="container" style="max-width: 850px; margin: 0 auto; padding: 20px; background: #fff; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">

            <div class="guide-section" style="margin-bottom: 35px;">
                <h2 style="color: #d9534f; border-bottom: 2px solid #f2dede; padding-bottom: 10px; font-size: 1.5rem;">
                    <i class="fas fa-clock"></i> Quy định về thời gian hủy đơn
                </h2>
                <div style="padding: 15px; line-height: 1.8;">
                    <p>Để đảm bảo quyền lợi của khách hàng và tính chính xác của kho hàng, Yummy Seoul áp dụng chính sách hủy đơn như sau:</p>
                    <ul>
                        <li>Hệ thống hỗ trợ cơ chế <strong>hủy đơn linh hoạt trong vòng 10 phút</strong> kể từ thời điểm đặt đơn thành công.</li>
                        <li>Mốc thời gian này được tính tự động dựa trên trường <code>ngay_tao_don</code> trong hệ thống dữ liệu.</li>
                    </ul>
                </div>
            </div>

            <div class="guide-section" style="margin-bottom: 35px; background-color: #fff5f5; padding: 20px; border-radius: 10px;">
                <h2 style="color: var(--red-brown); border-bottom: 2px solid var(--cream-dark); padding-bottom: 10px; font-size: 1.5rem;">
                    <i class="fas fa-exclamation-circle"></i> Điều kiện áp dụng
                </h2>
                <div style="padding: 15px; line-height: 1.8;">
                    <p>Quý khách chỉ có thể thực hiện thao tác hủy đơn khi thỏa mãn các điều kiện:</p>
                    <ol>
                        <li>Đơn hàng đang ở trạng thái <strong>"Đã đặt"</strong>.</li>
                        <li>Đơn hàng <strong>chưa được người quản lý chuyển sang trạng thái</strong> "Đang xử lý", "Đang giao" hoặc "Hoàn thành".</li>
                        <li>Thao tác thực hiện trong khung giờ vàng 10 phút đầu tiên.</li>
                    </ol>
                </div>
            </div>

            <div class="guide-section" style="margin-bottom: 30px;">
                <h2 style="color: var(--red-brown); border-bottom: 2px solid var(--cream-dark); padding-bottom: 10px; font-size: 1.5rem;">
                    <i class="fas fa-list-ol"></i> Các bước hủy đơn trực tuyến
                </h2>
                <ul style="list-style: none; padding-left: 0; line-height: 2;">
                    <li><i class="fas fa-user-circle"></i> <strong>Bước 1:</strong> Đăng nhập vào tài khoản cá nhân trên website.</li>
                    <li><i class="fas fa-history"></i> <strong>Bước 2:</strong> Truy cập vào mục <strong>"Lịch sử đơn hàng"</strong>.</li>
                    <li><i class="fas fa-search-plus"></i> <strong>Bước 3:</strong> Tìm đơn hàng cần hủy và nhấn xem <strong>"Chi tiết đơn hàng"</strong>.</li>
                    <li><i class="fas fa-times-circle" style="color: #d9534f;"></i> <strong>Bước 4:</strong> Nếu còn trong thời hạn 10 phút, nút <strong>"Hủy đơn hàng"</strong> sẽ hiển thị. Nhấn xác nhận để hoàn tất.</li>
                </ul>
            </div>

            <div style="text-align: center; margin-top: 40px;">
                <a href="product.php" class="modal-btn modal-btn-primary" style="text-decoration: none; display: inline-block; width: auto; padding: 15px 35px; border-radius: 8px;">
                    QUAY LẠI CỬA HÀNG
                </a>
            </div>
        </div>
    </div>

    <?php
    include '../../Header_Footer/php/footer.php';
    ?>

</body>

</html>