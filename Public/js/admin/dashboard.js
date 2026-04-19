document.addEventListener('DOMContentLoaded', function() {
    // 1. Khởi tạo Biểu đồ Doanh thu (Sử dụng Chart.js)
    const ctx = document.getElementById('revenueChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'CN'],
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: [850000, 1200000, 950000, 1500000, 2100000, 3500000, 4200000],
                    borderColor: '#f59e0b', // Màu vàng Gold
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, grid: { display: false } },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    // 2. Hiệu ứng con số nhảy cho các thẻ Thống kê
    const animateNumbers = (el) => {
        const target = parseInt(el.innerText.replace(/\D/g, ''));
        let count = 0;
        const speed = 2000 / target; // Hoàn thành trong 2 giây

        const updateCount = () => {
            const increment = Math.ceil(target / 100);
            if (count < target) {
                count += increment;
                el.innerText = count > target ? target.toLocaleString() + 'đ' : count.toLocaleString() + 'đ';
                setTimeout(updateCount, 1);
            }
        };
        updateCount();
    };

    document.querySelectorAll('.stat-data .value').forEach(animateNumbers);
});