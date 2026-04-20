document.addEventListener('DOMContentLoaded', function () {
    const toastContainer = document.getElementById('toast-container');

    // 1. Hàm tạo thông báo "bay" (Toast)
    function showToast(message, status = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast ${status}`;
        toast.innerHTML = `
            <i class="fa-solid ${status === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation'}"></i>
            <span>${message}</span>
        `;
        toastContainer.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(20px)';
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    }

    // 2. Chặn tất cả các Form (Thêm và Sửa) để gửi qua AJAX
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = e.submitter;
            if (submitBtn) formData.append(submitBtn.name, submitBtn.value);

            fetch(window.location.href, { 
                method: 'POST',
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    showToast(data.message, data.status);
                    if (data.status === 'success' && form.classList.contains('add-member-grid')) {
                        form.reset(); 
                        setTimeout(() => location.reload(), 1500); 
                    }
                })
                .catch(() => showToast('Lỗi kết nối!', 'error'));
        });
    });

    // 3. Sửa chức năng tìm kiếm (Lấy dữ liệu từ input)
    const searchInput = document.getElementById('searchMember');
    const memberRows = document.querySelectorAll('.member-row');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const query = this.value.toLowerCase().trim();
            memberRows.forEach(row => {
                // Lấy giá trị trực tiếp từ các ô nhập liệu trong bảng
                const userName = row.querySelector('input[name="user_name"]').value.toLowerCase();
                const hoTen = row.querySelector('input[name="ho_ten"]').value.toLowerCase();
                const sdt = row.querySelector('input[name="so_dien_thoai"]').value.toLowerCase();
                
                if (userName.includes(query) || hoTen.includes(query) || sdt.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});