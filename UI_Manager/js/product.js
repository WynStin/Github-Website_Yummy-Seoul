/**
 * YUMMY SEOUL - Quản lý món ăn JS
 * Xử lý: Tìm kiếm, Lọc danh mục, Xác nhận xóa và Xem trước ảnh
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // --- 1. TÌM KIẾM VÀ LỌC MÓN ĂN TẠI CHỖ (REAL-TIME) ---
    const searchInput = document.querySelector('input[name="search"]');
    const categorySelect = document.querySelector('select[name="category"]');
    const tableRows = document.querySelectorAll('.admin-table tbody tr');

    function filterProducts() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : "";
        const categoryTerm = categorySelect ? categorySelect.value.toLowerCase() : "";

        tableRows.forEach(row => {
            // Lấy tên món từ cột thứ 3 và tên danh mục từ cột thứ 4
            const productName = row.querySelector('td:nth-child(3)').innerText.toLowerCase();
            const categoryName = row.querySelector('.category-tag').innerText.toLowerCase();

            // Kiểm tra điều kiện khớp cả tên và danh mục
            const matchesSearch = productName.includes(searchTerm);
            const matchesCategory = categoryTerm === "" || categoryName.includes(categoryTerm);

            if (matchesSearch && matchesCategory) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Sự kiện khi gõ vào ô tìm kiếm
    if (searchInput) {
        searchInput.addEventListener('keyup', filterProducts);
    }

    // Sự kiện khi chọn danh mục
    if (categorySelect) {
        categorySelect.addEventListener('change', filterProducts);
    }


    // --- 2. XÁC NHẬN XÓA MÓN ĂN ---
    const deleteButtons = document.querySelectorAll('.btn-delete');
    
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            // Ngăn chặn link chạy ngay lập tức
            e.preventDefault();
            
            // Lấy tên món ăn từ cùng hàng
            const row = this.closest('tr');
            const productName = row.querySelector('td:nth-child(3) strong').innerText;
            const deleteUrl = this.getAttribute('href');

            // Hiển thị hộp thoại xác nhận chuyên nghiệp
            if (confirm(`⚠️ CẢNH BÁO: Bạn có chắc chắn muốn xóa món "${productName}" không?\nDữ liệu này sẽ mất vĩnh viễn khỏi hệ thống.`)) {
                window.location.href = deleteUrl;
            }
        });
    });


    // --- 3. XỬ LÝ XEM TRƯỚC ẢNH (Dùng cho Form Thêm/Sửa) ---
    // Tìm input file có id là "productImage"
    const imageInput = document.getElementById('productImage');
    const imagePreview = document.querySelector('.product-thumb-preview');

    if (imageInput && imagePreview) {
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                
                // Khi file được đọc xong
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                }
                
                reader.readAsDataURL(file);
            }
        });
    }

    // --- 4. HIỆU ỨNG THÔNG BÁO TỰ TẮT (Nếu có) ---
    const alertMsg = document.querySelector('.alert-success');
    if (alertMsg) {
        setTimeout(() => {
            alertMsg.style.opacity = '0';
            setTimeout(() => alertMsg.remove(), 500);
        }, 3000);
    }
});