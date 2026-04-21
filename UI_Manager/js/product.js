document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="search"]');
    const categorySelect = document.querySelector('select[name="category"]');
    const tableRows = document.querySelectorAll('.admin-table tbody tr');

    function filterProducts() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : "";
        const categoryTerm = categorySelect ? categorySelect.value.toLowerCase() : "";

        tableRows.forEach(row => {
            const productName = row.querySelector('td:nth-child(3)').innerText.toLowerCase();
            const categoryName = row.querySelector('.category-tag').innerText.toLowerCase();

            const matchesSearch = productName.includes(searchTerm);
            const matchesCategory = categoryTerm === "" || categoryName.includes(categoryTerm);

            if (matchesSearch && matchesCategory) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        });
    }

    if (searchInput) {
        searchInput.addEventListener('keyup', filterProducts);
    }

    if (categorySelect) {
        categorySelect.addEventListener('change', filterProducts);
    }

    const deleteButtons = document.querySelectorAll('.btn-delete');
    
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const row = this.closest('tr');
            const productName = row.querySelector('td:nth-child(3) strong').innerText;
            const deleteUrl = this.getAttribute('href');

            if (confirm(`⚠️ CẢNH BÁO: Bạn có chắc chắn muốn xóa món "${productName}" không?\nDữ liệu này sẽ mất vĩnh viễn khỏi hệ thống.`)) {
                window.location.href = deleteUrl;
            }
        });
    });

    const imageInput = document.getElementById('productImage');
    const imagePreview = document.querySelector('.product-thumb-preview');

    if (imageInput && imagePreview) {
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
            
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                }
                
                reader.readAsDataURL(file);
            }
        });
    }
    const alertMsg = document.querySelector('.alert-success');
    if (alertMsg) {
        setTimeout(() => {
            alertMsg.style.opacity = '0';
            setTimeout(() => alertMsg.remove(), 500);
        }, 3000);
    }
});