<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Liên hệ | Yummy Seoul – Tiệm ăn vặt Hàn Quốc</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../../Public/img/homepage/logo.png">
    
    <link href="https://fonts.googleapis.com/css2?family=Asap:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../../Public/css/home.css">
    
    <link rel="stylesheet" href="../../Public/css/contact.css">
</head>

<body>
    <?php $page = "contact"; ?>
    <?php include 'layout/header.php'; ?>

    <!--Hiện bản đồ-->
    <div class="map-wrapper">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.696303803893!2d105.8407530750307!3d21.0048066806359!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ac76ccab6dd7%3A0x5503454955364808!2zMjA3IEdp4bqjaSBQaMOzbmcsIMSQ4buTbmcgVMOibSwgSGFpIELDoCBUcsawbmcsIEjDoCBO4buZaSwgVmnhu3QgTmFt!5e0!3m2!1svi!2s!4v1700000000000!5m2!1svi!2s"></iframe>
    </div>

    <div class="content">
        <!--Form nhập thông tin bên trái-->
        <div class="contact-form">
            <h2>Gửi tin nhắn cho Yummy Seoul</h2>
            <form id="contactForm">
                <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div class="form-group">
                        <label>Họ và tên</label>
                        <input type="text" name="name" required minlength="3" placeholder="Tên của bạn">
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" required placeholder="example@gmail.com">
                    </div>
                </div>

                <div class="form-group">
                    <label>Số điện thoại</label>
                    <input type="tel" name="phone" pattern="[0-9]{9,10}" required placeholder="VD: 0987654321">
                </div>

                <div class="form-group">
                    <label>Nội dung liên hệ</label>
                    <textarea name="message" required minlength="10" placeholder="Bạn muốn nhắn nhủ điều gì với tiệm?"></textarea>
                </div>

                <button type="submit" class="btn-submit">Gửi liên hệ ngay</button>

                <div class="success-message" id="successMsg">Yummy Seoul đã nhận được tin nhắn của bạn. Cảm ơn bạn nhé!</div>
            </form>
        </div>

        <!--Thông tin tiệm bên phải-->
        <div class="contact-info">
            <h3>Thông tin tiệm</h3>

            <div class="info-item">
                <svg viewBox="0 0 24 24"><path d="M12 2C8.1 2 5 5.1 5 9c0 5.3 7 13 7 13s7-7.7 7-13c0-3.9-3.1-7-7-7zm0 9.5c-1.4 0-2.5-1.1-2.5-2.5S10.6 6.5 12 6.5s2.5 1.1 2.5 2.5S13.4 11.5 12 11.5z"/></svg>
                <p>207 Giải Phóng, P. Đồng Tâm, Q. Hai Bà Trưng, Hà Nội</p>
            </div>

            <div class="info-item">
                <svg viewBox="0 0 24 24"><path d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24c1.12.37 2.33.57 3.58.57a1 1 0 011 1v3.5a1 1 0 01-1 1C10.3 21.01 2.99 13.7 2.99 4a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.46.57 3.59a1 1 0 01-.25 1.01l-2.19 2.19z"/></svg>
                <p>0912.345.678</p>
            </div>

            <div class="info-item">
                <svg viewBox="0 0 24 24"><path d="M20 4H4a2 2 0 00-2 2v12a2 2 0 002 2h16a2 2 0 002-2V6a2 2 0 00-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                <p>YummySeoul@gmail.com</p>
            </div>

            <div class="info-item">
                <svg viewBox="0 0 24 24"><path d="M12 2a10 10 0 1010 10A10 10 0 0012 2zm1 11h4a1 1 0 000-2h-3V7a1 1 0 00-2 0v5a1 1 0 001 1z"/></svg>
                <p>Thứ 2 – Chủ nhật: 08:00 a.m - 23:00 p.m</p>
            </div>

            <div class="link-social">
                <a href="https://www.instagram.com/" target="_blank">
                    <svg viewBox="0 0 41 40"><rect width="41" height="40" rx="10"/><path d="M20.5 14.2c-3.2 0-5.8 2.6-5.8 5.8s2.6 5.8 5.8 5.8 5.8-2.6 5.8-5.8-2.6-5.8-5.8-5.8zm0 9.5c-2.1 0-3.8-1.7-3.8-3.8s1.7-3.8 3.8-3.8 3.8 1.7 3.8 3.8-1.7 3.8-3.8 3.8z" fill="white"/><circle cx="26.5" cy="14" r="1.5" fill="white"/></svg>
                </a>

                <a href="https://www.facebook.com/" target="_blank">
                    <svg viewBox="0 0 41 40"><rect width="41" height="40" rx="10"/><path d="M24 11.2h-2.4c-2.7 0-4.5 1.8-4.5 4.6v2.2h-3c-.2 0-.4.2-.4.4v3.5c0 .2.2.4.4.4h3v9.8c0 .2.2.4.4.4h3.7c.2 0 .4-.2.4-.4v-9.8h3.7c.2 0 .4-.2.4-.4v-3.5c0-.2-.2-.4-.4-.4h-3.7v-2c0-1.1.5-1.5 1.6-1.5h2.2c.2 0 .4-.2.4-.4v-2.6c0-.2-.2-.4-.4-.4z" fill="white"/></svg>
                </a>
            </div>
        </div>
    </div>

    <?php include 'layout/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/emailjs-com@3/dist/email.min.js"></script>
    <script src="../../Public/js/contact.js"></script>
</body>

</html>