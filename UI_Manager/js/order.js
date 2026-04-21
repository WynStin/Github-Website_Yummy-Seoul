document.addEventListener('DOMContentLoaded', function() {
    const statusForms = document.querySelectorAll('.order-list form');
    
    statusForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const select = this.querySelector('select');
            const status = select.value;
        
            if (status === 'Đã hủy') {
                if (!confirm('Bạn có chắc chắn muốn HỦY đơn hàng này không?')) {
                    e.preventDefault(); 
                }
            }
        });
    });

    const alert = document.querySelector('.alert-success');
    if (alert) {
        setTimeout(() => {
            alert.style.display = 'none';
        }, 3000);
    }
});