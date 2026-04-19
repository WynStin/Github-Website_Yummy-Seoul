<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giới thiệu - Yummy Seoul</title>
    <link href="https://fonts.googleapis.com/css2?family=Asap:wght@400;600;700&family=Dancing+Script:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../Public/css/home.css">
    <link rel="stylesheet" href="../../Public/css/intro.css">
</head>
<body>

    <?php $page = 'intro'; ?>
    <?php include 'layout/header.php'; ?> <main class="intro-page-wrapper">
        
        <div class="floating-decor">
            <div class="cherry-blossom blossom-1"></div>
            <div class="cherry-blossom blossom-2"></div>
            <div class="leaf leaf-1"></div>
            <div class="heart heart-1"></div>
            <div class="cherry-blossom blossom-3"></div>
        </div>

        <section class="intro-hero">
            <div class="container-custom">
                <div class="intro-flex-container">
                    
                    <div class="intro-text-section fade-up">
                        <div class="intro-handwritten">"Ăn là ghiền - chuẩn vị Hàn"</div>
                        <h1>Yummy Seoul</h1>
                        <p class="intro-lead">Nơi mỗi món ăn đều là một niềm vui trọn vẹn.</p>
                        <p class="intro-story">
                            Với chúng tôi, cái tên này là kim chỉ nam cho mọi hoạt động. Đó là khát khao biến mỗi món ăn trao tay khách hàng đều trở thành trải nghiệm ẩm thực chuẩn vị Hàn nhất tại địa chỉ 207 Giải Phóng.
                        </p>
                        <div class="intro-action">
                            <a href="contact.php" class="btn-polaroid-style">Ghé thăm tiệm ngay</a>
                        </div>
                    </div>

                    <div class="intro-gallery-wrap fade-up delay-2">
                        <div class="polaroid-frame p-1">
                            <img src="../../Public/img/homepage/banner1.jpg" alt="Seoul Taste">
                            <div class="polaroid-label">Seoul Vibes</div>
                        </div>
                        <div class="polaroid-frame p-2">
                            <img src="../../Public/img/homepage/banner2.jpg" alt="Kitchen Love">
                            <div class="polaroid-label">Kitchen Love</div>
                        </div>
                        <div class="polaroid-frame p-3">
                            <img src="../../Public/img/homepage/banner3.jpg" alt="Our Story">
                            <div class="polaroid-label">Our Story</div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <?php include 'layout/footer.php'; ?> <script src="../../Public/js/home.js"></script>
</body>
</html>