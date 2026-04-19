<!doctype html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/x-icon" href="../../Image/homepage/logo.png">
    <meta name="Home description" content="Yummy Seoul - Tiệm ăn vặt Hàn Quốc" />
    <meta name="keywords" content="Yummy Seoul, Tiệm ăn vặt, Hàn Quốc" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hướng dẫn đặt món | Yummy Seoul – Tiệm ăn vặt Hàn Quốc</title>
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
            HƯỚNG DẪN ĐẶT ĐƠN HÀNG
        </div>

        <div class="container" style="max-width: 850px; margin: 0 auto; padding: 20px; background: #fff; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">

            <div class="guide-section" style="margin-bottom: 35px;">
                <h2 style="color: var(--red-brown); border-bottom: 2px solid var(--cream-dark); padding-bottom: 10px; font-size: 1.5rem;">
                    <i class="fas fa-shopping-basket"></i> Các bước mua hàng trực tuyến
                </h2>
                <div style="padding: 15px; line-height: 1.8;">
                    <ol>
                        <li><strong>Đăng nhập tài khoản:</strong> Để đảm bảo quyền lợi và tích lũy lịch sử mua hàng, quý khách vui lòng đăng nhập trước khi thanh toán.</li>
                        <li><strong>Lựa chọn món ăn:</strong> Truy cập "Thực đơn", tìm kiếm món ăn theo tên hoặc lọc theo khoảng giá phù hợp.</li>
                        <li><strong>Thêm vào giỏ hàng:</strong> Chọn món và số lượng mong muốn (hệ thống sẽ kiểm tra để không vượt quá tồn kho thực tế).</li>
                        <li><strong>Kiểm tra giỏ hàng:</strong> Truy cập giỏ hàng để cập nhật số lượng hoặc xóa món trước khi tiến hành thanh toán.</li>
                        <li><strong>Hoàn tất đơn hàng:</strong> Điền địa chỉ giao hàng, áp dụng mã khuyến mãi (nếu có) và chọn phương thức thanh toán.</li>
                    </ol>
                </div>
            </div>

            <div class="guide-section" style="margin-bottom: 35px; background-color: #fdfaf5; padding: 20px; border-radius: 10px;">
                <h2 style="color: var(--red-brown); border-bottom: 2px solid var(--cream-dark); padding-bottom: 10px; font-size: 1.5rem;">
                    <i class="fas fa-sync-alt"></i> Theo dõi trạng thái đơn hàng
                </h2>
                <p style="margin-top: 10px;">Sau khi đặt hàng thành công, đơn hàng của quý khách sẽ trải qua các giai đoạn sau:</p>
                <div style="display: flex; justify-content: space-between; margin-top: 15px; text-align: center; font-size: 0.85rem;">
                    <div style="flex: 1;"><i class="fas fa-file-invoice" style="font-size: 1.5rem; color: #451715;"></i><br>Đã đặt</div>
                    <div style="flex: 1;"><i class="fas fa-spinner" style="font-size: 1.5rem; color: #451715;"></i><br>Đang xử lý</div>
                    <div style="flex: 1;"><i class="fas fa-shipping-fast" style="font-size: 1.5rem; color: #451715;"></i><br>Đang giao</div>
                    <div style="flex: 1;"><i class="fas fa-check-double" style="font-size: 1.5rem; color: #451715;"></i><br>Hoàn thành</div>
                </div>
            </div>

            <div class="guide-section" style="margin-bottom: 30px;">
                <h2 style="color: #d9534f; border-bottom: 2px solid #f2dede; padding-bottom: 10px; font-size: 1.5rem;">
                    <i class="fas fa-exclamation-triangle"></i> Chính sách hủy đơn hàng
                </h2>
                <div style="padding: 15px; border-left: 4px solid #d9534f; background: #f9f9f9; margin-top: 10px;">
                    <p>Nhằm đảm bảo tính chính xác của kho hàng và quyền lợi khách hàng:</p>
                    <ul style="list-style: none; padding-left: 0; line-height: 1.8;">
                        <li><i class="fas fa-clock"></i> Quý khách có quyền <strong>hủy đơn hàng trực tuyến trong vòng 10 phút</strong> kể từ khi đặt đơn.</li>
                        <li><i class="fas fa-ban"></i> Chức năng hủy sẽ bị khóa nếu đơn hàng đã chuyển sang trạng thái "Đang xử lý" hoặc "Đang giao".</li>
                    </ul>
                </div>
            </div>

            <div style="text-align: center; margin-top: 40px;">
                <a href="product.php" class="modal-btn modal-btn-primary" style="text-decoration: none; display: inline-block; width: auto; padding: 15px 35px; border-radius: 8px;">
                    BẮT ĐẦU ĐẶT MÓN
                </a>
            </div>
        </div>
    </div>

    <?php
    include '../../Header_Footer/php/footer.php';
    ?>

</body>

</html>