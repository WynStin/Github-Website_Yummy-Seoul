<!doctype html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <title>Tin tức</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta
      name="description"
      content="Cập nhật tin tức và ưu đãi mới nhất của cửa hàng"
    />
    <link rel="icon" type="image/x-icon" href="/assets/logo.svg" />
    <link
      rel="stylesheet"
      href="../../Public/css/news.css"
    />
    <link
      rel="stylesheet"
      href="../../Public/css/home.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    />
    <link rel="stylesheet" href="news.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Asap:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap"
      rel="stylesheet" />
  </head>

  <body>
      <?php $page = "news"; ?>
      <!--Lấy header-->
      <?php include 'layout/header.php'; ?>
    <div data-include="/src/components/header.htm"></div>
    <div id="breadcrumb-container"></div>
    <script src="/src/js/layouts/breadcrumb.js"></script>
    <script>
      renderBreadcrumb([{ name: "Tin tức", link: "" }]);
    </script>
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
            src="YOUR_NEWS_IMAGE_URL"
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
          <a href="#" class="news-card-more">Xem thêm →</a>
        </div>
      </div>
      <div class="news-card fade-up delay-2">
        <div class="news-card-img">
          <img
            src="YOUR_NEWS_IMAGE_URL"
            alt="Tin tức 2"
            onerror="this.style.display = 'none'" />
        </div>
        <div class="news-card-body">
          <div class="news-card-title">Ưu đãi thành viên mới</div>
          <div class="news-card-desc">
            WOA! Chúng mình xin gửi tới những khách hàng mới phiếu giảm giá 20.000VND cho đơn hàng đầu tiên. Nhập ngay “BANMOI” để nhận ưu đãi...
          </div>
          <a href="#" class="news-card-more">Xem thêm →</a>
        </div>
      </div>
      <div class="news-card fade-up delay-3">
        <div class="news-card-img">
          <img
            src="YOUR_NEWS_IMAGE_URL"
            alt="Tin tức 3"
            onerror="this.style.display = 'none'" />
        </div>
        <div class="news-card-body">
          <div class="news-card-title">Đôi lời từ đội ngũ phát triển</div>
          <div class="news-card-desc">
            Đội ngũ phát triển Yummy Seoul xin chân thành cảm ơn sự tin tưởng
            và ủng hộ từ khách hàng...
          </div>
          <a href="#" class="news-card-more">Xem thêm →</a>
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
      "
    >
      Cập nhật thông tin mới nhất và các khuyến mãi hấp dẫn từ cửa hàng
    </div>

    <main class="container py-4">
      <div class="row">
        <!-- SIDEBAR  -->
        <div class="col-lg-4 col-12">
          <div id="sidebar-container" class="sidebar"></div>
        </div>

        <!-- CỘT DANH SÁCH BÀI VIẾT  -->
        <div class="col-lg-8 col-12 mb-4">
          <div id="news-list"></div>
        </div>
      </div>
    </main>

    <!-- MODAL ZOOM ẢNH-->
    <div id="imageModal" class="image-modal">
      <span class="modal-close">&times;</span>
      <img class="modal-content" id="modalImage" alt="Zoom ảnh" />
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="new-detail/news-data.js"></script>
    <script src="news.js"></script>
    <script src="load-sidebar.js"></script>
    <div data-include="/src/components/chatbot.html"></div>
    <div data-include="/src/components/footer.html"></div>
    <script type="module" src="/src/js/again.js"></script>
  </body>
</html>
