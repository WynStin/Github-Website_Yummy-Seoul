<!doctype html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="Home description" content="Yummy Seoul - Tiệm ăn vặt Hàn Quốc"
    <meta name="keywords" content="Yummy Seoul - Tiệm ăn vặt Hàn Quốc"
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Yummy Seoul – Tiệm ăn vặt Hàn Quốc</title>
    <link
        rel="stylesheet"
        href="/Github-Website_Yummy-Seoul/Public/css/home.css"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Asap:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap"
      rel="stylesheet"
    />

  </head>
  <body>
    <!-- ======= TOP BAR ======= -->
    <header>
      <div class="topbar">
        <div class="topbar-logo">
          <!-- LOGO: thay src bằng link ảnh logo thực -->
          <img
            src="/Github-Website_Yummy-Seoul/Public/img/homepage/logo.png"
            style="width: 60px; height: 60px; object-fit: cover"
          />
        </div>
        <div class="search-bar">
          <input type="text" placeholder="Tìm kiếm..." />
          <button>🔍</button>
        </div>
        <div class="topbar-actions">
          <button class="btn-outline">Đăng nhập</button>
          <button class="btn-filled">Đăng ký</button>
        </div>
      </div>


      <nav class="navbar">
        <ul class="nav-links">
          <li><a href="#" class="active">Trang chủ</a></li>
          <li><a href="#">Giới thiệu</a></li>
          <li><a href="#">Sản phẩm</a></li>
          <!-- <li><a href="#">Khuyến mãi</a></li> -->
          <li><a href="#">Tin tức</a></li>
          <li><a href="#">Liên hệ</a></li>
        </ul>
        <div class="nav-phone"><span></span> 0000.000.000</div>
      </nav>
    </header>


    <!-- ======= HERO CAROUSEL ======= -->
    <section class="hero" id="hero">
      <div class="hero-slides" id="heroSlides">
        <!-- Slide 1 -->
        <div class="hero-slide">
          <div class="hero-img-placeholder">
            <!-- HÌNH ẢNH BANNER 1: thay src bằng link ảnh thực -->
            <img
              src="../../Public/img/homepage/banner_yummy.png"
              alt="Banner 1"
              onerror="this.style.display = 'none'"
              
            />
          </div>
          <div class="hero-overlay"></div>
        </div>
        <!-- Slide 2 -->
        <div class="hero-slide">
          <div class="hero-img-placeholder">
            <img
              src="/Github-Website_Yummy-Seoul/Public/img/homepage/banner_center.png"
              alt="Banner 2"
              onerror="this.style.display = 'none'"
            />
          </div>
          <div class="hero-overlay"></div>
        </div>
        <!-- Slide 3 -->
        <div class="hero-slide">
          <div class="hero-img-placeholder">
            <img
              src="/Github-Website_Yummy-Seoul/Public/img/homepage/banner2.jpg"
              alt="Banner 3"
              onerror="this.style.display = 'none'"
            />
          </div>
          <div class="hero-overlay"></div>
        </div>
      </div>
      <button class="hero-btn-prev" id="heroPrev">‹</button>
      <button class="hero-btn-next" id="heroNext">›</button>
      <div class="hero-dots" id="heroDots">
        <button class="hero-dot active"></button>
        <button class="hero-dot"></button>
        <button class="hero-dot"></button>
      </div>
    </section>


    <!-- ======= MÓN MỚI ======= -->
    <section class="section mon-moi">
      <div class="section-title-wrap fade-up">
        <div class="section-title">MÓN MỚI</div>
        <div class="section-divider"></div>
      </div>
      <div class="product-grid">
        <!-- Lặp lại card này cho từng sản phẩm -->
        <div class="product-card fade-up delay-1">
          <div class="product-card-img">
            <!-- HÌNH SẢN PHẨM: thay src bằng link ảnh thực -->
            <img
              src="/Github-Website_Yummy-Seoul/Public/img/monan/mituongden.jpg"
              alt="Mì tương đen"
              onerror="this.style.display = 'none'"
            />
          </div>
          <div class="product-card-body">
            <div class="product-name">Mì tương đen</div>
            <div class="product-price">75.000 VND</div>
          </div>
        </div>
        <div class="product-card fade-up delay-2">
          <div class="product-card-img">
            <img
              src="/Github-Website_Yummy-Seoul/Public/img/monan/mandu.jpg"
              alt="Mandu chiên"
              onerror="this.style.display = 'none'"
            />
          </div>
          <div class="product-card-body">
            <div class="product-name">Mandu chiên</div>
            <div class="product-price">40.000 VND</div>
          </div>
        </div>
        <div class="product-card fade-up delay-3">
          <div class="product-card-img">
            <img
              src="/Github-Website_Yummy-Seoul/Public/img/monan/gasottuongtoi.jpg"
              alt="Gà sốt tương tỏi"
              onerror="this.style.display = 'none'"
            />
          </div>
          <div class="product-card-body">
            <div class="product-name">Gà sốt tương tỏi</div>
            <div class="product-price">155.000 VND</div>
          </div>
        </div>
        <div class="product-card fade-up delay-4">
          <div class="product-card-img">
            <img
              src="/Github-Website_Yummy-Seoul/Public/img/monan/combobulgogi.jpg"
              alt="Cơm bò xào Bulgogi"
              onerror="this.style.display = 'none'"
            />
          </div>
          <div class="product-card-body">
            <div class="product-name">Cơm bò xào Bulgogi</div>
            <div class="product-price">95.000 VND</div>
          </div>
        </div>
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
          <a href="#" class="btn-datngay">Đặt ngay</a>
        </div>
        <div class="hom-nay-products">
          <div class="product-card fade-up delay-1">
            <div class="product-card-img">
              <img
                src="/Github-Website_Yummy-Seoul/Public/img/monan/kimbapchien.jpg"
                alt="Kimbap chiên"
                onerror="this.style.display = 'none'"
              />
            </div>
            <div class="product-card-body">
              <div class="product-name">Kimbap chiên</div>
              <div class="product-price">60.000 VND</div>
            </div>
          </div>
          <div class="product-card fade-up delay-2">
            <div class="product-card-img">
              <img
                src="/Github-Website_Yummy-Seoul/Public/img/monan/gakhongxuong.jpg"
                alt="Gà rán không xương"
                onerror="this.style.display = 'none'"
              />
            </div>
            <div class="product-card-body">
              <div class="product-name">Gà rán không xương</div>
              <div class="product-price">120.000 VND</div>
            </div>
          </div>
          <div class="product-card fade-up delay-3">
            <div class="product-card-img">
              <img
                src="/Github-Website_Yummy-Seoul/Public/img/monan/milanh.jpg"
                alt="Mì lạnh Naengmyeon"
                onerror="this.style.display = 'none'"
              />
            </div>
            <div class="product-card-body">
              <div class="product-name">Mì lạnh Naengmyeon</div>
              <div class="product-price">90.000 VND</div>
            </div>
          </div>
        </div>
      </div>
    </section>


    <!-- ======= ABOUT BANNER ======= -->
    <section class="about-banner">
      <div class="about-bg">
        <!-- HÌNH NỀN ABOUT: thay src bằng link ảnh thực -->
        <img
          src="/Github-Website_Yummy-Seoul/Public/img/homepage/banner1.jpg"
          alt="Background"
          onerror="this.style.display = 'none'"
        />
      </div>
      <div class="about-content fade-up">
        <div class="about-title">Tiệm ăn vặt Yummy Seoul</div>
        <p class="about-desc">
Tiệm hiện giao nhanh trong 30–45 phút, chỉ nhận đơn trong bán kính dưới 5km gồm các quận Đống Đa, Hoàn Kiếm và Hai Bà Trưng để đảm bảo món ăn luôn nóng hổi khi đến tay khách hàng.
<br /><br />
Tất cả đơn hàng đều được đóng gói chuẩn chất lượng với đồ nóng giữ nhiệt và đồ uống tách đá riêng, cùng mức phí ship hợp lý theo từng khu vực để khách yên tâm khi đặt món.
        </p>
        <a href="#" class="about-xemthem">Xem thêm</a>
      </div>
    </section>


    <!-- ======= SẢN PHẨM BÁN CHẠY ======= -->
    <section class="section best-seller">
      <div class="section-title-wrap fade-up">
        <div class="best-seller-label">BEST SELLER</div>
        <div class="section-title">SẢN PHẨM BÁN CHẠY</div>
        <div class="section-divider"></div>
      </div>
      <div class="best-seller-grid">
        <!-- TOP 2 -->
        <div class="bs-card fade-up delay-1">
          <div class="bs-badge">
            <span class="medal">🥈</span><span class="rank">TOP 2</span>
          </div>
          <div class="bs-card-img">
            <img
              src="/Github-Website_Yummy-Seoul/Public/img/monan/garansotcay.jpg"
              alt="Top 2"
              onerror="this.style.display = 'none'"
            />
          </div>
          <div class="bs-card-body">
            <div class="bs-name">Gà rán sốt cay</div>
            <div class="bs-prices">
              <span class="bs-price-current">155.000 VND</span>
              <span class="bs-price-old">180.000 VND</span>
            </div>
            <button class="btn-buy">Mua ngay</button>
          </div>
        </div>
        <!-- TOP 1 -->
        <div class="bs-card top1 fade-up delay-2">
          <div class="bs-badge">
            <span class="medal">🥇</span><span class="rank">TOP 1</span>
          </div>
          <div class="bs-card-img">
            <img
              src="/Github-Website_Yummy-Seoul/Public/img/monan/tokbokki.jpg"
              alt="Top 1"
              onerror="this.style.display = 'none'"
            />
          </div>
          <div class="bs-card-body">
            <div class="bs-name">Tokbokki truyền thống</div>
            <div class="bs-prices">
              <span class="bs-price-current">45.000 VND</span>
              <span class="bs-price-old">60.000 VND</span>
            </div>
            <button class="btn-buy">Mua ngay</button>
          </div>
        </div>
        <!-- TOP 3 -->
        <div class="bs-card fade-up delay-3">
          <div class="bs-badge">
            <span class="medal">🥉</span><span class="rank">TOP 3</span>
          </div>
          <div class="bs-card-img">
            <img
              src="/Github-Website_Yummy-Seoul/Public/img/monan/kimbaptruyenthong.jpg"
              alt="Top 3"
              onerror="this.style.display = 'none'"
            />
          </div>
          <div class="bs-card-body">
            <div class="bs-name">Kimbap truyền thống</div>
            <div class="bs-prices">
              <span class="bs-price-current">50.000 VND</span>
              <span class="bs-price-old">65.000 VND</span>
            </div>
            <button class="btn-buy">Mua ngay</button>
          </div>
        </div>
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
              src="YOUR_NEWS_IMAGE_URL"
              alt="Tin tức 1"
              onerror="this.style.display = 'none'"
            />
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
              onerror="this.style.display = 'none'"
            />
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
              onerror="this.style.display = 'none'"
            />
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


    <!-- ======= FOOTER ======= -->
    <footer>
      <div class="footer-grid">
        <!-- Cột 1: Brand -->
        <div class="footer-brand">
          <div class="footer-logo-wrap">
            <img
              src="../../Public/img/homepage/logo.png"
              style="width: 75px; height: 75px; object-fit: cover"
            />
            <div>
              <div class="footer-brand-name">
                Tiệm ăn vặt <br />
                Yummy Seoul
              </div>
            </div>
          </div>
          <div class="footer-info">
            <div class="footer-info" style="margin-top: 8px">
              📞 0000.000.000
            </div>
            <strong>Giờ hoạt động:</strong> 10:00 a.m – 23:00 p.m<br />
            Tất cả các ngày trong tuần (trừ ngày lễ)<br /><br />
            <strong>Email:</strong> YummySeoul@gmail.com<br />
            <strong>Địa chỉ:</strong> 207 Giải Phóng, P. Đồng Tâm,<br />
            Q. Hai Bà Trưng, TP. Hà Nội
          </div>
        </div>


        <!-- Cột 2: Chính sách -->
        <div class="footer-col">
          <h4>Chính Sách</h4>
          <ul>
            <li><a href="#">Chính sách thanh toán khi đặt hàng</a></li>
            <li><a href="#">Chính sách giao nhận hàng</a></li>
            <li><a href="#">Chính sách về sản phẩm</a></li>
            <li><a href="#">Chính sách bảo mật</a></li>
          </ul>
          <br />
          <h4>Thông Tin</h4>
          <ul>
            <li><a href="#">Tin tức - Sự kiện</a></li>
          </ul>
        </div>


        <!-- Cột 3: Kết nối + Hướng dẫn -->
        <div class="footer-col">
          <h4>Kết Nối</h4>
          <div class="social-links">
            <a href="#" class="social-btn social-fb">f</a>
            <a href="#" class="social-btn social-ig">IG</a>
            <a href="#" class="social-btn social-yt">▶</a>
          </div>
          <br />
          <h4>Hướng Dẫn</h4>
          <ul>
            <li><a href="#">Hướng dẫn đặt đơn hàng</a></li>
            <li><a href="#">Hướng dẫn thanh toán</a></li>
            <li><a href="#">Hướng dẫn hủy đơn hàng</a></li>
          </ul>
        </div>
      </div>


      <div class="footer-bottom">© 2026 – Tiệm Ăn Vặt Yummy Seoul</div>
    </footer>


    <!-- ======= JAVASCRIPT ======= -->
    <script>
      // ----- Hero Carousel -----
      const slides = document.querySelectorAll(".hero-slide");
      const dots = document.querySelectorAll(".hero-dot");
      let current = 0,
        autoTimer;


      function goTo(n) {
        slides[current].style.display = "none";
        dots[current].classList.remove("active");
        current = (n + slides.length) % slides.length;
        slides[current].style.display = "block";
        dots[current].classList.add("active");
      }


      function initCarousel() {
        slides.forEach(
          (s, i) => (s.style.display = i === 0 ? "block" : "none"),
        );
        dots.forEach((d, i) =>
          d.addEventListener("click", () => {
            goTo(i);
            resetTimer();
          }),
        );
        document.getElementById("heroPrev").addEventListener("click", () => {
          goTo(current - 1);
          resetTimer();
        });
        document.getElementById("heroNext").addEventListener("click", () => {
          goTo(current + 1);
          resetTimer();
        });
        autoTimer = setInterval(() => goTo(current + 1), 4500);
      }


      function resetTimer() {
        clearInterval(autoTimer);
        autoTimer = setInterval(() => goTo(current + 1), 4500);
      }


      initCarousel();


      // ----- Scroll fade-up -----
      const fadeEls = document.querySelectorAll(".fade-up");
      const observer = new IntersectionObserver(
        (entries) => {
          entries.forEach((e) => {
            if (e.isIntersecting) {
              e.target.style.animationPlayState = "running";
            }
          });
        },
        { threshold: 0.12 },
      );
      fadeEls.forEach((el) => {
        el.style.animationPlayState = "paused";
        observer.observe(el);
      });
    </script>
  </body>
</html>