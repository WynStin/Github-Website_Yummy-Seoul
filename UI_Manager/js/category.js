/**
 * YUMMY SEOUL - Quản lý danh mục JS
 * Chức năng: Tìm kiếm real-time và Xác nhận xóa an toàn
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // --- 1. TÌM KIẾM DANH MỤC TỨC THÌ ---
    const searchInput = document.getElementById('categorySearch');
    const tableRows = document.querySelectorAll('#categoryTable tbody tr');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const term = this.value.toLowerCase().trim();

            tableRows.forEach(row => {
                // Lấy dữ liệu từ các cột: ID, Tên, Mô tả
                const catId = row.querySelector('td:first-child').innerText.toLowerCase();
                const catName = row.querySelector('.cat-name').innerText.toLowerCase();
                const catDesc = row.querySelector('.cat-desc').innerText.toLowerCase();

                // Kiểm tra xem từ khóa có nằm trong bất kỳ cột nào không
                if (catId.includes(term) || catName.includes(term) || catDesc.includes(term)) {
                    row.style.display = ""; // Hiện hàng
                } else {
                    row.style.display = "none"; // Ẩn hàng
                }
            });
        });
    }

    // --- 2. XÁC NHẬN XÓA DANH MỤC ---
    const deleteButtons = document.querySelectorAll('.btn-delete-red');

    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            // Ngăn trình duyệt chuyển trang ngay lập tức
            e.preventDefault();

            // Lấy tên danh mục từ hàng tương ứng để thông báo
            const row = this.closest('tr');
            const catName = row.querySelector('.cat-name').innerText;
            const deleteUrl = this.getAttribute('href');

            // Hộp thoại xác nhận chuyên nghiệp
            if (confirm(`⚠️ CẢNH BÁO QUAN TRỌNG:\nBạn có chắc chắn muốn xóa danh mục "${catName}"?\n\nLưu ý: Nếu xóa danh mục này, các món ăn thuộc nhóm này có thể bị mất phân loại!`)) {
                window.location.href = deleteUrl;
            }
        });
    });

    // --- 3. HIỆU ỨNG NHẤN NÚT (FEEDBACK) ---
    const allButtons = document.querySelectorAll('.btn-edit-gold, .btn-add-gold');
    allButtons.forEach(btn => {
        btn.addEventListener('mousedown', function() {
            this.style.transform = "scale(0.95)";
        });
        btn.addEventListener('mouseup', function() {
            this.style.transform = "scale(1)";
        });
    });
});