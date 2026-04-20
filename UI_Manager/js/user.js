/**
 * Yummy Seoul - User Management Script
 */
document.addEventListener('DOMContentLoaded', function () {

    // 1. CHỨC NĂNG TÌM KIẾM THỜI GIAN THỰC
    const searchInput = document.getElementById('searchMember');
    const tableRows = document.querySelectorAll('.user-row');

    if (searchInput) {
        searchInput.addEventListener('keyup', function () {
            const query = this.value.toLowerCase().trim();

            tableRows.forEach(row => {
                // Thu thập giá trị từ các ô input trong hàng
                const name = row.querySelector('input[name="ho_ten"]').value.toLowerCase();
                const phone = row.querySelector('input[name="so_dien_thoai"]').value.toLowerCase();
                const email = row.querySelector('input[name="email"]').value.toLowerCase();
                const address = row.querySelector('input[name="dia_chi"]').value.toLowerCase();

                // Kiểm tra nếu bất kỳ trường nào khớp với từ khóa
                if (name.includes(query) || 
                    phone.includes(query) || 
                    email.includes(query) || 
                    address.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // 2. TỰ ĐỘNG ẨN THÔNG BÁO SAU 3 GIÂY
    const alertBox = document.getElementById('alertBox');
    if (alertBox) {
        setTimeout(() => {
            alertBox.style.transition = '0.5s';
            alertBox.style.opacity = '0';
            setTimeout(() => alertBox.remove(), 500);
        }, 3000);
    }

    // 3. XỬ LÝ CLICK DÒNG (TÙY CHỌN - HIGHLIGHT)
    tableRows.forEach(row => {
        row.addEventListener('click', function() {
            tableRows.forEach(r => r.style.background = '');
            this.style.background = '#fffbeb';
        });
    });
});