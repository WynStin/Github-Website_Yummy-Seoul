<?php
// 1. Nạp cấu hình database và Model
require_once '../../Config/db.php';
require_once '../../Models/ProductModel.php';

// 2. Khởi tạo Model
$productModel = new ProductModel($pdo);

// 3. Lấy dữ liệu cho các section trên trang chủ
$newProducts = $productModel->getTop10Newest();
$mostViewedProducts = $productModel->getTop10MostViewed();
$bestSellerProducts = $productModel->getTop10BestSeller();

// Sau khi có dữ liệu ở trên, phần dưới sẽ là HTML để hiển thị
?>

<!doctype html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <link rel="icon" type="image/x-icon" href="../../Public/img/homepage/logo.png">
  <meta name="Home description" content="Yummy Seoul - Tiệm ăn vặt Hàn Quốc" />
  <meta name="keywords" content="Yummy Seoul, Tiệm ăn vặt, Hàn Quốc" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Yummy Seoul – Tiệm ăn vặt Hàn Quốc</title>
  <link
    rel="stylesheet"
    href="../../Public/css/home.css" />
  <link
    href="https://fonts.googleapis.com/css2?family=Asap:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

</head>

<body>
  <?php $page = "home"; ?>
  <!--Lấy header-->
  <?php include 'layout/header.php'; ?>

  <!-- ======= HERO CAROUSEL ======= -->
  <section class="hero-section">
    <div class="hero-container">
      <div class="hero" id="hero">
        <div class="hero-slides" id="heroSlides">
          <div class="hero-slide">
            <div class="hero-img-placeholder">
              <img src="../../Public/img/homepage/banner_yummy.png" alt="Banner 1" />
            </div>
          </div>
          <div class="hero-slide">
            <div class="hero-img-placeholder">
              <img src="../../Public/img/homepage/banner_center.png" alt="Banner 2" />
            </div>
          </div>
          <div class="hero-slide">
            <div class="hero-img-placeholder">
              <img src="../../Public/img/homepage/banner2.jpg" alt="Banner 3" />
            </div>
          </div>
        </div>
        <button class="hero-btn-prev" id="heroPrev">‹</button>
        <button class="hero-btn-next" id="heroNext">›</button>
        <div class="hero-dots" id="heroDots">
          <button class="hero-dot active"></button>
          <button class="hero-dot"></button>
          <button class="hero-dot"></button>
        </div>
      </div>
    </div>
  </section>

  <!-- ======= MÓN MỚI ======= -->
  <section class="section mon-moi">
    <div class="section-title-wrap">
      <div class="section-title">MÓN MỚI</div>
      <div class="section-divider"></div>
    </div>

    <div class="slider-container">
      <div class="swiper new-products-slider">
        <div class="swiper-wrapper">
          <?php if (!empty($newProducts)): ?>
            <?php foreach ($newProducts as $product): ?>
              <div class="swiper-slide">
                <div class="product-card">
                  <div class="product-card-img">
                    <img src="../../Public/img/monan/<?php echo $product['hinh_anh']; ?>"
                      alt="<?php echo $product['ten_mon']; ?>"
                      onerror="this.src='../../Public/img/default-food.png'">
                  </div>
                  <div class="product-card-body">
                    <h3 class="product-name"><?php echo $product['ten_mon']; ?></h3>
                    <div class="product-prices">
                      <span class="price-current">
                        <?php echo number_format($product['gia_ban'], 0, ',', '.'); ?> VND
                      </span>
                    </div>
                    <button class="btn-muahang">MUA HÀNG</button>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p style="text-align: center; width: 100%;">Hiện chưa có món mới nào.</p>
          <?php endif; ?>
        </div>
      </div>

      <div class="swiper-button-prev custom-nav"></div>
      <div class="swiper-button-next custom-nav"></div>
    </div>
  </section>


  <!-- ======= HÔM NAY ĂN GÌ? ======= -->
  <section class="section hom-nay">
    <div class="hom-nay-inner">
      <div class="hom-nay-text fade-up">
        <h2>HÔM NAY ĂN GÌ?</h2>
        <p>
          Khám phá ngay những món ăn đến từ xứ sở kim chi,
          hứa hẹn sẽ đem lại những trải nghiệm ẩm thực độc đáo đến với bạn!
        </p>
        <a href="product.php" class="btn-datngay">Đặt ngay</a>
      </div>

      <div class="hom-nay-categories">
        <a href="product.php?category=1" class="cat-card fade-up delay-1">
          <div><img src="../../Public/img/monan/comchienkimchi.jpg" alt="Cơm (Rice)" /></div>
          <div class="cat-name">Cơm (Rice)</div>
        </a>
        <a href="product.php?category=2" class="cat-card fade-up delay-2">
          <div><img src="../../Public/img/monan/gasottuongtoi.jpg" height="230px" alt="Gà (Chicken)" /></div>
          <div class="cat-name">Gà (Chicken)</div>
        </a>
        <a href="product.php?category=3" class="cat-card fade-up delay-3">
          <div><img src="../../Public/img/monan/milanh.jpg" alt="Mì (Noodles)" /></div>
          <div class="cat-name">Mì (Noodles)</div>
        </a>
        <a href="product.php?category=4" class="cat-card fade-up delay-1">
          <div><img src="../../Public/img/monan/lauquandoi.jpg" alt="Lẩu & Súp (Stew)" /></div>
          <div class="cat-name">Lẩu & Súp (Stew)</div>
        </a>
        <a href="product.php?category=5" class="cat-card fade-up delay-2">
          <div><img src="../../Public/img/monan/khoaitaychien.jpg" alt="Đồ ăn nhẹ (Snacks)" /></div>
          <div class="cat-name">Đồ ăn nhẹ (Snacks)</div>
        </a>
        <a href="product.php?category=6" class="cat-card fade-up delay-3">
          <div><img src="../../Public/img/monan/trasuakhoaimon.jpg" height="200px" alt="Đồ uống (Drinks)" /></div>
          <div class="cat-name">Đồ uống (Drinks)</div>
        </a>
      </div>
    </div>
  </section>

  <section class="section xem-nhieu">
    <div class="section-title-wrap">
      <div class="section-title">MÓN XEM NHIỀU NHẤT</div>
      <div class="section-divider"></div>
    </div>

    <div class="slider-container">
      <div class="swiper most-viewed-slider">
        <div class="swiper-wrapper">
          <?php if (!empty($mostViewedProducts)): ?>
            <?php foreach ($mostViewedProducts as $product): ?>
              <div class="swiper-slide">
                <div class="product-card">
                  <div class="product-card-img">
                    <img src="../../Public/img/monan/<?php echo $product['hinh_anh']; ?>"
                      alt="<?php echo $product['ten_mon']; ?>"
                      onerror="this.src='../../Public/img/default-food.png'">
                  </div>
                  <div class="product-card-body">
                    <h3 class="product-name"><?php echo $product['ten_mon']; ?></h3>
                    <div class="product-prices">
                      <span class="price-current">
                        <?php echo number_format($product['gia_ban'], 0, ',', '.'); ?> VND
                      </span>
                    </div>
                    <button class="btn-muahang">MUA HÀNG</button>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p style="text-align: center; width: 100%;">Hiện chưa có dữ liệu món ăn.</p>
          <?php endif; ?>
        </div>
      </div>

      <div class="swiper-button-prev most-viewed-prev custom-nav"></div>
      <div class="swiper-button-next most-viewed-next custom-nav"></div>
    </div>
  </section>

  <!-- ======= ABOUT BANNER ======= -->
  <section class="about-banner">
    <div class="about-bg">
      <!-- HÌNH NỀN ABOUT: thay src bằng link ảnh thực -->
      <img
        src="../../Public/img/homepage/banner1.jpg"
        alt="Background"
        onerror="this.style.display = 'none'" />
    </div>
    <div class="about-content fade-up">
      <div class="about-title">Tiệm ăn vặt Yummy Seoul</div>
      <p class="about-desc">
        Tiệm hiện giao nhanh trong 30–45 phút, chỉ nhận đơn trong bán kính dưới 5km gồm các quận Đống Đa, Hoàn Kiếm và Hai Bà Trưng để đảm bảo món ăn luôn nóng hổi khi đến tay khách hàng.
        <br /><br />
        Tất cả đơn hàng đều được đóng gói chuẩn chất lượng với đồ nóng giữ nhiệt và đồ uống tách đá riêng, cùng mức phí ship hợp lý theo từng khu vực để khách yên tâm khi đặt món.
      </p>
      <a href="intro.php" class="about-xemthem">Xem thêm</a>
    </div>
  </section>


  <!-- ======= SẢN PHẨM BÁN CHẠY ======= -->
  <section class="section ban-chay">
    <div class="section-title-wrap">
      <div class="section-title">MÓN BÁN CHẠY NHẤT</div>
      <div class="section-divider"></div>
    </div>

    <div class="slider-container">
      <div class="swiper best-seller-slider">
        <div class="swiper-wrapper">
          <?php if (!empty($bestSellerProducts)): ?>
            <?php foreach ($bestSellerProducts as $product): ?>
              <div class="swiper-slide">
                <div class="product-card">
                  <div class="product-card-img">
                    <img src="../../Public/img/monan/<?php echo $product['hinh_anh']; ?>"
                      alt="<?php echo $product['ten_mon']; ?>"
                      onerror="this.src='../../Public/img/default-food.png'">
                  </div>
                  <div class="product-card-body">
                    <h3 class="product-name"><?php echo $product['ten_mon']; ?></h3>
                    <div class="product-prices">
                      <span class="price-current">
                        <?php echo number_format($product['gia_ban'], 0, ',', '.'); ?> VND
                      </span>
                    </div>
                    <button class="btn-muahang btn-bling">MUA HÀNG</button>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p style="text-align: center; width: 100%;">Hiện chưa có dữ liệu bán chạy.</p>
          <?php endif; ?>
        </div>
      </div>

      <div class="swiper-button-prev best-seller-prev custom-nav"></div>
      <div class="swiper-button-next best-seller-next custom-nav"></div>
    </div>
  </section>


  <!-- ======= TIN TỨC – SỰ KIỆN ======= -->
  <section class="section tin-tuc">
    <div class="section-title-wrap fade-up">
      <div class="section-title">TIN TỨC – SỰ KIỆN</div>
      <div class="section-divider"></div>
    </div>
    <div class="news-grid">
      <div class="news-card fade-up delay-1">
        <div class="news-card-img">
          <img
            src="../../Public/img/news/new1.png"
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
            src="../../Public/img/news/new2.png"
            alt="Tin tức 2"
            onerror="this.style.display = 'none'" />
        </div>
        <div class="news-card-body">
          <div class="news-card-title">Ưu đãi thành viên mới</div>
          <div class="news-card-desc">
            WOA! Chúng mình xin gửi tới những khách hàng mới phiếu giảm giá 20.000VND cho đơn hàng đầu tiên. Nhập ngay "BANMOI" để nhận ưu đãi...
          </div>
          <a href="offer.php" class="news-card-more">Xem thêm →</a>
        </div>
      </div>
      <div class="news-card fade-up delay-3">
        <div class="news-card-img">
          <img
            src="../../Public/img/news/new3.png"
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

  <!--Lấy footer-->
  <?php include 'layout/footer.php'; ?>

  <!-- ======= JAVASCRIPT ======= -->
  <script src="../../Public/js/home.js"></script>
</body>

</html>