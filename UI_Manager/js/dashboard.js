document.addEventListener('DOMContentLoaded', function() {
    // 1. Khởi tạo Biểu đồ Doanh thu (Sử dụng dữ liệu thực tế từ PHP)
    const ctx = document.getElementById('revenueChart');
    if (ctx) {
        // Kiểm tra nếu biến dữ liệu từ PHP tồn tại, nếu không thì dùng mảng rỗng
        const labels = typeof finalLabels !== 'undefined' ? finalLabels : ['Chưa có dữ liệu'];
        const dataValues = typeof finalData !== 'undefined' ? finalData : [0];

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels, // Dữ liệu ngày tháng thực tế
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: dataValues, // Dữ liệu tiền thực tế
                    borderColor: '#f59e0b', // Màu vàng Gold
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointBackgroundColor: '#f59e0b',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        grid: { color: 'rgba(0,0,0,0.05)' },
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString() + 'đ';
                            }
                        }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    // 2. Hiệu ứng con số nhảy cho các thẻ Thống kê
    const animateNumbers = (el) => {
        const text = el.innerText.replace(/\D/g, ''); // Loại bỏ ký tự không phải số (như 'đ' hoặc '.')
        const target = parseInt(text);
        
        if (isNaN(target)) return; // Nếu không phải số thì bỏ qua

        let count = 0;
        const duration = 1500; // Thời gian chạy hiệu ứng (1.5 giây)
        const frameRate = 1000 / 60; // 60 khung hình trên giây
        const totalFrames = Math.round(duration / frameRate);
        const increment = target / totalFrames;

        const updateCount = () => {
            count += increment;
            if (count < target) {
                el.innerText = Math.floor(count).toLocaleString('vi-VN') + 'đ';
                requestAnimationFrame(updateCount);
            } else {
                el.innerText = target.toLocaleString('vi-VN') + 'đ';
            }
        };
        
        updateCount();
    };

    // Chạy hiệu ứng cho các thẻ có class .value
    document.querySelectorAll('.stat-data .value').forEach(animateNumbers);
});