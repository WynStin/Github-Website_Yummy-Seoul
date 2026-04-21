document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart');
    if (ctx) {
        const labels = typeof finalLabels !== 'undefined' ? finalLabels : ['Chưa có dữ liệu'];
        const dataValues = typeof finalData !== 'undefined' ? finalData : [0];

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels, 
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: dataValues,
                    borderColor: '#f59e0b', 
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

    const animateNumbers = (el) => {
        const text = el.innerText.replace(/\D/g, ''); 
        const target = parseInt(text);
        
        if (isNaN(target)) return;

        let count = 0;
        const duration = 1500; 
        const frameRate = 1000 / 60; 
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
    document.querySelectorAll('.stat-data .value').forEach(animateNumbers);
});