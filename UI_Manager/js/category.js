document.addEventListener('DOMContentLoaded', function() {

    const searchInput = document.getElementById('categorySearch');
    const tableRows = document.querySelectorAll('#categoryTable tbody tr');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const term = this.value.toLowerCase().trim();

            tableRows.forEach(row => {
                const catId = row.querySelector('td:first-child').innerText.toLowerCase();
                const catName = row.querySelector('.cat-name').innerText.toLowerCase();
                const catDesc = row.querySelector('.cat-desc').innerText.toLowerCase();

                if (catId.includes(term) || catName.includes(term) || catDesc.includes(term)) {
                    row.style.display = ""; 
                } else {
                    row.style.display = "none"; 
                }
            });
        });
    }
    const deleteButtons = document.querySelectorAll('.btn-delete-red');

    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const row = this.closest('tr');
            const catName = row.querySelector('.cat-name').innerText;
            const deleteUrl = this.getAttribute('href');

            if (confirm(`⚠️ CẢNH BÁO QUAN TRỌNG:\nBạn có chắc chắn muốn xóa danh mục "${catName}"?\n\nLưu ý: Nếu xóa danh mục này, các món ăn thuộc nhóm này có thể bị mất phân loại!`)) {
                window.location.href = deleteUrl;
            }
        });
    });

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