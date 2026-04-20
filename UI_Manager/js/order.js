document.addEventListener('DOMContentLoaded', function() {
    // 1. Xác nhận trước khi cập nhật trạng thái
    const statusForms = document.querySelectorAll('.order-list form');
    
    statusForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const select = this.querySelector('select');
            const status = select.value;
            
            // Nếu chuyển sang trạng thái "Đã hủy", yêu cầu xác nhận kỹ hơn
            if (status === 'Đã hủy') {
                if (!confirm('Bạn có chắc chắn muốn HỦY đơn hàng này không?')) {
                    e.preventDefault(); // Dừng việc gửi form
                }
            }
        });
    });

    // 2. Tự động ẩn thông báo thành công sau 3 giây (nếu bạn có thêm thông báo)
    const alert = document.querySelector('.alert-success');
    if (alert) {
        setTimeout(() => {
            alert.style.display = 'none';
        }, 3000);
    }
});