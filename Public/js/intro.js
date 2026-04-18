document.addEventListener('DOMContentLoaded', function () {
    // 1. Intersection Observer cho hiệu ứng xuất hiện
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                // Nếu cuộn tới section stats thì chạy đếm số
                if (entry.target.classList.contains('stats-interactive-section')) {
                    startCounters();
                }
            }
        });
    }, { threshold: 0.2 });

    // Đưa tất cả các phần tử vào danh sách theo dõi
    const targets = document.querySelectorAll('.fade-up, .fade-left, .fade-right, .stats-interactive-section');
    targets.forEach(t => observer.observe(t));

    // 2. Hàm đếm số (Counters)
    function startCounters() {
        const counters = document.querySelectorAll('.counter');
        if (window.counterStarted) return; // Chỉ chạy 1 lần
        window.counterStarted = true;

        counters.forEach(counter => {
            const target = +counter.parentElement.getAttribute('data-target');
            let count = 0;
            const speed = target / 50;

            const updateCount = () => {
                const current = +counter.innerText.replace('+', '').replace('%', ''); // Làm sạch ký tự lạ
                if (current < target) {
                    counter.innerText = Math.ceil(current + speed);
                    setTimeout(updateCount, 25);
                } else {
                    // Điều chỉnh hiển thị ký tự sau số
                    if (target === 1000 || target === 20) {
                        counter.innerText = target + "+";
                    } else if (target === 100) {
                        counter.innerText = target + "%";
                    } else {
                        counter.innerText = target;
                    }
                }
            };
            updateCount();
        });
    }

    // 3. Hiệu ứng Parallax nhẹ cho Polaroid
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const frames = document.querySelectorAll('.polaroid-frame');
        frames.forEach((frame, index) => {
            const speed = (index + 1) * 0.05;
            frame.style.transform = `rotate(${index === 1 ? 6 : -6}deg) translateY(${scrolled * speed}px)`;
        });
    });
});