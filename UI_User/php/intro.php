<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../../Image/homepage/logo.png">
    <title>Giới thiệu | Yummy Seoul – Tiệm ăn vặt Hàn Quốc</title>
    <link href="https://fonts.googleapis.com/css2?family=Asap:wght@400;600;700&family=Dancing+Script:wght@600&family=Satisfy&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/intro.css">
    <link
    href="https://fonts.googleapis.com/css2?family=Asap:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap"
    rel="stylesheet" />
</head>

<body class="yummy-story-version">
    <?php $page = "intro"; ?>
    <?php include '../../Header_Footer/php/header.php'; ?>

    <!--Background-->
    <section class="storytelling-hero">
        <div class="floating-decor">
            <div class="cherry-blossom blossom-1"></div>
            <div class="cherry-blossom blossom-2"></div>
            <div class="leaf leaf-1"></div>
            <div class="heart heart-1"></div>
            <div class="cherry-blossom blossom-3"></div>
        </div>

        <!--Thông tin bên trái-->
        <div class="container-custom">
            <div class="intro-flex-container">
                <div class="intro-text-section fade-up">
                    <div class="intro-handwritten">"Ăn là ghiền - chuẩn vị Seoul"</div>
                    <h1 class="main-title">Khát Vọng <br><span class="highlight">Yummy Seoul</span></h1>
                    <p class="story-p">
                        Tại 207 Giải Phóng, Yummy Seoul không chỉ bán món ăn, chúng mình bán những ký ức rực rỡ của Seoul. Hãy đến và trải nghiệm ẩm thực chuẩn vị Hàn Quốc nhất nào <3
                    </p>
                    <div class="intro-action">
                        <a href="contact.php" class="btn-polaroid-style">Liên hệ ngay</a>
                    </div>
                </div>

                <!--Thông tin bên phải-->
                <div class="intro-gallery-wrap fade-up delay-2">
                    <div class="polaroid-frame p-1">
                        <img src="../../Image/homepage/banner1.jpg" alt="Seoul Taste">
                        <div class="polaroid-label">Seoul Vibes</div>
                    </div>
                    <div class="polaroid-frame p-2">
                        <img src="../../Image/homepage/banner2.jpg" alt="Kitchen Love">
                        <div class="polaroid-label">Kitchen Love</div>
                    </div>
                    <div class="polaroid-frame p-3">
                        <img src="../../Image/homepage/banner3.png" alt="Our Story">
                        <div class="polaroid-label">Our Story</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--Phần hành trình bên dưới-->
    <section id="stagger-start" class="stagger-grid-section">
        <div class="container-custom">
            <div class="stagger-grid">
                <div class="stagger-item text-block fade-right">
                    <div class="number-bg">01</div>
                    <h3>Nguyên liệu tử tế</h3>
                    <p>Chúng mình tin rằng món ăn ngon nhất khi được nấu từ những nguyên liệu tươi sạch nhất. Sốt được nhập trực tiếp từ Hàn Quốc để giữ trọn vị bản xứ.</p>
                </div>
                <div class="stagger-item image-block fade-left">
                    <img src="../../Image/monan/tokbokki.jpg" alt="Ingredients">
                    <div class="image-deco-box"></div>
                </div>
            </div>

            <div class="stagger-grid reverse">
                <div class="stagger-item text-block fade-left">
                    <div class="number-bg">02</div>
                    <h3>Sáng tạo là linh hồn</h3>
                    <p>Đội ngũ bếp tại Yummy Seoul luôn thử nghiệm những công thức sốt mới mỗi tuần để đảm bảo bạn luôn tìm thấy sự bất ngờ khi ghé thăm.</p>
                </div>
                <div class="stagger-item image-block fade-right">
                    <img src="../../Image/monan/garansotcay.jpg" alt="Creativity">
                    <div class="image-deco-box gold"></div>
                </div>
            </div>
        </div>
    </section>

    <!--Thanh chỉ số-->
    <section class="stats-interactive-section">
        <div class="container-custom">
            <div class="stats-wrapper">
                <div class="stat-box" data-target="1000">
                    <h2 class="counter">0</h2>
                    <span>Khách hàng tin yêu</span>
                </div>
                <div class="stat-box" data-target="20">
                    <h2 class="counter">0</h2>
                    <span>Món ăn độc quyền</span>
                </div>
                <div class="stat-box" data-target="100">
                    <h2 class="counter">0</h2>
                    <span>Tận tâm</span>
                </div>
            </div>
        </div>
    </section>

    <?php include '../../Header_Footer/php/footer.php'; ?>
    <script src="../js/intro.js"></script>
</body>

</html>