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
      }, {
        threshold: 0.12
      },
    );
    fadeEls.forEach((el) => {
      el.style.animationPlayState = "paused";
      observer.observe(el);
    });