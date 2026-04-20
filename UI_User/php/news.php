<!doctype html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <title>Tin tức | Yummy Seoul – Tiệm ăn vặt Hàn Quốc</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta
    name="description"
    content="Cập nhật tin tức và ưu đãi mới nhất của cửa hàng" />
  <link rel="icon" type="image/x-icon" href="../../Image/homepage/logo.png" />
  <link
    rel="stylesheet"
    href="../css/news.css" />
  <link
    rel="stylesheet"
    href="../css/home.css" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link
    href="https://fonts.googleapis.com/css2?family=Asap:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap"
    rel="stylesheet" />
</head>

<body>
  <?php $page = "news"; ?>
  <!--Lấy header-->
  <?php include '../../Header_Footer/php/header.php'; ?>
  
  <!-- ======= THÔNG TIN ======= -->
  <section class="section tin-tuc">
    <div class="section-title-wrap fade-up">
      <div class="section-title">TIN TỨC – SỰ KIỆN</div>
      <div class="section-divider"></div>
    </div>
    <div class="news-grid">
      <div class="news-card fade-up delay-1">
        <div class="news-card-img">
          <img
            src="../../Image/news/new1.png"
            alt="Tin tức 1"
            onerror="this.style.display = 'none'" />
        </div>
        <div class="news-card-body">
          <div class="news-card-title">
            [Tháng 3 – 4] Chào hè Giảm 30% đồ uống
          </div>
          <div class="news-card-desc">
            Mùa hè nóng bức... Phải giải nhiệt ngay thôi. Toàn bộ đồ uống giảm
            tới 30%...
          </div>
          <a href="summer_deal.php" class="news-card-more">Xem thêm →</a>
        </div>
      </div>
      <div class="news-card fade-up delay-2">
        <div class="news-card-img">
          <img
            src="../../Image/news/new2.png"
            alt="Tin tức 2"
            onerror="this.style.display = 'none'" />
        </div>
        <div class="news-card-body">
          <div class="news-card-title">Ưu đãi thành viên mới</div>
          <div class="news-card-desc">
            WOA! Chúng mình xin gửi tới những khách hàng mới phiếu giảm giá 20.000VND cho đơn hàng đầu tiên. Nhập ngay “BANMOI” để nhận ưu đãi...
          </div>
          <a href="offer.php" class="news-card-more">Xem thêm →</a>
        </div>
      </div>
      <div class="news-card fade-up delay-3">
        <div class="news-card-img">
          <img
            src="../../Image/news/new3.png"
            alt="Tin tức 3"
            onerror="this.style.display = 'none'" />
        </div>
        <div class="news-card-body">
          <div class="news-card-title">Đôi lời từ đội ngũ phát triển</div>
          <div class="news-card-desc">
            Đội ngũ phát triển Yummy Seoul xin chân thành cảm ơn sự tin tưởng
            và ủng hộ từ khách hàng...
          </div>
          <a href="DevThanks.php" class="news-card-more">Xem thêm →</a>
        </div>
      </div>
    </div>
  </section>
  <div
    class="page-subtitle"
    style="
        text-align: center;
        margin-top: 8px;
        margin-bottom: 20px;
        font-size: 16px;
        color: #666;
        font-weight: 400;
      ">
    <strong>Cập nhật thông tin mới nhất và các khuyến mãi hấp dẫn từ cửa hàng</strong>
  </div>

  <!--Lấy footer-->
  <?php include '../../Header_Footer/php/footer.php'; ?>

  <!-- ======= JAVASCRIPT ======= -->
  <script src="../js/news.js"></script>
</body>

</html>