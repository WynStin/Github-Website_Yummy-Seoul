// ======================================================
// HERO CAROUSEL
// ======================================================
(function () {
  const slides = document.getElementById('heroSlides');
  const dots = document.querySelectorAll('.hero-dot');
  const prevBtn = document.getElementById('heroPrev');
  const nextBtn = document.getElementById('heroNext');

  if (!slides) return;

  let current = 0;
  const total = document.querySelectorAll('.hero-slide').length;
  let autoTimer;

  function goTo(index) {
    current = (index + total) % total;
    slides.style.transform = `translateX(-${current * 100}%)`;
    dots.forEach((d, i) => d.classList.toggle('active', i === current));
  }

  function next() { goTo(current + 1); }
  function prev() { goTo(current - 1); }

  function startAuto() {
    autoTimer = setInterval(next, 4000);
  }

  function resetAuto() {
    clearInterval(autoTimer);
    startAuto();
  }

  if (nextBtn) nextBtn.addEventListener('click', () => { next(); resetAuto(); });
  if (prevBtn) prevBtn.addEventListener('click', () => { prev(); resetAuto(); });

  dots.forEach((dot, i) => {
    dot.addEventListener('click', () => { goTo(i); resetAuto(); });
  });

  document.addEventListener("DOMContentLoaded", function () {
    // 1. Khởi tạo Slider Món Mới (Giữ nguyên cái cũ của bạn)
    new Swiper('.new-products-slider', {
      slidesPerView: 5,
      spaceBetween: 15,
      loop: true,
      autoplay: { delay: 3000 },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      breakpoints: {
        320: { slidesPerView: 1 },
        768: { slidesPerView: 2 },
        1024: { slidesPerView: 3 },
        1300: { slidesPerView: 5 }
      }
    });

    // 2. Khởi tạo Slider Món Xem Nhiều (Nếu bạn đã thêm phần này)
    new Swiper('.most-viewed-slider', {
      slidesPerView: 5,
      spaceBetween: 15,
      loop: true,
      autoplay: { delay: 3500 },
      navigation: {
        nextEl: '.most-viewed-next',
        prevEl: '.most-viewed-prev',
      },
      breakpoints: {
        320: { slidesPerView: 1 },
        1300: { slidesPerView: 5 }
      }
    });

    // 3. FIX LỖI: Khởi tạo Slider Món Bán Chạy
    new Swiper('.best-seller-slider', {
      slidesPerView: 5,      // Bắt buộc có dòng này để không bị to hình
      spaceBetween: 15,
      loop: true,
      autoplay: {
        delay: 4000,
        disableOnInteraction: false,
      },
      navigation: {
        nextEl: '.best-seller-next', // Phải khớp với class ở file PHP
        prevEl: '.best-seller-prev',
      },
      breakpoints: {
        320: { slidesPerView: 1 },
        768: { slidesPerView: 2 },
        1024: { slidesPerView: 3 },
        1300: { slidesPerView: 5 }
      }
    });
  });

  // Mở file Public/js/home.js
  document.addEventListener("DOMContentLoaded", function () {
    // ... (Giữ nguyên các đoạn code khởi tạo Swiper cũ) ...

    // THÊM LOGIC RANDOM VÀO ĐÂY
    const btnRandom = document.getElementById('btnRandomFood');
    const resultDisplay = document.getElementById('randomResult');

    if (btnRandom) {
      btnRandom.addEventListener('click', function () {
        const productElements = document.querySelectorAll('.product-name');
        const foodList = Array.from(productElements).map(el => el.textContent.trim());

        if (foodList.length > 0) {
          resultDisplay.classList.remove('show');
          btnRandom.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ĐANG CHỌN...';

          setTimeout(() => {
            const randomIndex = Math.floor(Math.random() * foodList.length);
            const chosenFood = foodList[randomIndex];
            resultDisplay.innerHTML = `Thử ngay: <span style="color: #c0392b;">${chosenFood}</span> ✨`;
            resultDisplay.classList.add('show');
            btnRandom.innerHTML = '<i class="fas fa-dice"></i> GỢI Ý MÓN ĂN';
          }, 700);
        }
      });
    }
  });

  startAuto();
})();