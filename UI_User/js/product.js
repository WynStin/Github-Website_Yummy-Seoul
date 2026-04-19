let currentCategory = 'all';
let currentSort = 'default';
let currentPage = 1;
let currentProductId = null;

// Load sản phẩm
// Cập nhật hàm loadProducts trong product.js
async function loadProducts(category = 'all', sort = 'default', page = 1) {
    try {
        const urlParams = new URLSearchParams(window.location.search);
        
        // Lấy từ khóa: Ưu tiên lấy từ URL (cho lần đầu load)
        let searchQuery = urlParams.get('search') || ''; 

        // Nếu nhấn "Lọc" hoặc "Sắp xếp" mà ô tìm kiếm đang có chữ, phải lấy chữ đó
        const headerSearchInput = document.querySelector('.search-box input') || document.querySelector('input[type="search"]');
        if (headerSearchInput && headerSearchInput.value.trim() !== '') {
            searchQuery = headerSearchInput.value.trim();
        }

        const minPrice = document.getElementById('minPriceInput')?.value || '';
        const maxPrice = document.getElementById('maxPriceInput')?.value || '';

        // Tạo query AJAX gửi lên server
        const query = `ajax=1&category=${category}&sort=${sort}&page=${page}&search=${encodeURIComponent(searchQuery)}&minPrice=${minPrice}&maxPrice=${maxPrice}`;

        const response = await fetch(`product.php?${query}`);
        const data = await response.json();

        if (data.success) {
            displayProducts(data.products);
            displayPagination(data.totalPages, data.currentPage);
            
            // Cập nhật tiêu đề: Nếu có tìm kiếm thì hiện "Kết quả cho...", không thì hiện tên danh mục
            const titleElement = document.getElementById('categoryTitle');
            if (searchQuery) {
                titleElement.textContent = `Kết quả cho: "${searchQuery}"`;
            } else {
                updateCategoryTitle(category);
            }
        }
    } catch (error) {
        console.error('Lỗi khi tải sản phẩm:', error);
    }
}

// Hiển thị sản phẩm
function displayProducts(products) {
    const container = document.getElementById('productsContainer');

    if (!products || products.length === 0) {
        container.innerHTML = '<p class="no-products">Hiện chưa có món ăn nào trong danh mục này.</p>';
        return;
    }

    container.innerHTML = products.map(product => `
        <div class="product-card">
            <div class="product-image">
                <img src="../../Image/monan/${product.hinh_anh}" alt="${product.ten_mon}">
                <div class="product-overlay">
                    <button class="quick-view-btn" onclick="openModal(${product.id_mon_an}, '${product.ten_mon}', ${product.gia_ban})">
                        <i class="fas fa-eye"></i> Xem nhanh
                    </button>
                </div>
            </div>
            <div class="product-info">
                <h3 class="product-name">${product.ten_mon}</h3>
                <p class="product-description">${product.mo_ta || ''}</p>
                <div class="product-price">${formatPrice(product.gia_ban)}</div>
                <div class="product-actions">
                    <button class="add-to-cart-btn" onclick="addToCart(${product.id_mon_an})">
                        <i class="fas fa-shopping-cart"></i> Mua hàng
                    </button>
                </div>
            </div>
        </div>
    `).join('');
}

// Format giá - Bỏ Style Currency để giống 85.000đ như bạn muốn
function formatPrice(price) {
    return new Intl.NumberFormat('vi-VN').format(price) + 'đ';
}

// Phân trang - Giữ nguyên logic nhưng hãy đảm bảo paginationContainer tồn tại trong HTML
function displayPagination(totalPages, currentPage) {
    const container = document.getElementById('paginationContainer');
    if (!container) return;

    if (totalPages <= 1) {
        container.innerHTML = '';
        return;
    }

    // Thêm CSS trực tiếp cho container để dàn hàng ngang
    container.style.display = 'flex';
    container.style.justifyContent = 'center';
    container.style.alignItems = 'center';
    container.style.gap = '10px';
    container.style.margin = '40px 0';
    container.style.width = '100%';

    let html = '';

    // Nút Previous
    if (currentPage > 1) {
        html += `<button class="page-btn" onclick="changePage(${currentPage - 1})" style="width:40px; height:40px; border-radius:8px; border:2px solid #e5d1b5; background:#fff; cursor:pointer;"><i class="fas fa-chevron-left"></i></button>`;
    }

    // Các trang số
    for (let i = 1; i <= totalPages; i++) {
        const isActive = (i === currentPage);
        // Định dạng màu sắc dựa trên trạng thái active
        const bgColor = isActive ? '#451715' : '#ffffff';
        const textColor = isActive ? '#ffffff' : '#451715';
        const borderColor = '#451715';

        html += `
            <button class="page-btn ${isActive ? 'active' : ''}" 
                onclick="changePage(${i})" 
                style="
                    width: 40px; 
                    height: 40px; 
                    border-radius: 8px; 
                    font-weight: bold;
                    cursor: pointer;
                    transition: all 0.3s;
                    border: 2px solid ${borderColor}; 
                    background-color: ${bgColor}; 
                    color: ${textColor};
                    display: flex;
                    align-items: center;
                    justify-content: center;
                ">
                ${i}
            </button>`;
    }

    // Nút Next
    if (currentPage < totalPages) {
        html += `<button class="page-btn" onclick="changePage(${currentPage + 1})" style="width:40px; height:40px; border-radius:8px; border:2px solid #e5d1b5; background:#fff; cursor:pointer;"><i class="fas fa-chevron-right"></i></button>`;
    }

    container.innerHTML = html;
}

function changePage(page) {
    console.log("Chuyển sang trang:", page); // Kiểm tra xem hàm có chạy không
    currentPage = page;

    // Gọi lại hàm load sản phẩm với trang mới
    loadProducts(currentCategory, currentSort, page);

    // Cuộn lên đầu danh sách sản phẩm cho mượt
    const productSection = document.getElementById('pageTitle');
    if (productSection) {
        productSection.scrollIntoView({ behavior: 'smooth' });
    }
}

// Cập nhật tiêu đề danh mục
function updateCategoryTitle(category) {
    const titles = {
        'all': 'Tất cả sản phẩm',
        '1': 'Cơm (Rice)',     // Đổi key thành ID số để khớp với DB
        '2': 'Gà (Chicken)',
        '3': 'Mì (Noodles)',
        '4': 'Lẩu & Súp (Stew)',
        '5': 'Đồ ăn nhẹ (Snacks)',
        '6': 'Đồ uống (Drinks)',
        'com': 'Cơm (Rice)',   // Giữ cả text nếu bạn chưa sửa dataset
        'ga': 'Gà (Chicken)',
        'mi': 'Mì (Noodles)'
    };

    document.getElementById('categoryTitle').textContent = titles[category] || titles['all'];
}

// Modal functions
function openModal(id, name, price) {
    currentProductId = id;
    document.getElementById('modalProductName').textContent = name;
    // Sử dụng hàm formatPrice đã sửa ở đoạn trước để hiện đúng "85.000đ"
    document.getElementById('modalProductPrice').textContent = formatPrice(price);
    document.getElementById('modalQuantity').value = 1;
    document.getElementById('quickActionModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('quickActionModal').style.display = 'none';
}

// Các hàm tăng giảm số lượng trong Modal
function increaseQuantityModal() {
    const input = document.getElementById('modalQuantity');
    input.value = parseInt(input.value) + 1;
}

function decreaseQuantityModal() {
    const input = document.getElementById('modalQuantity');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

function addToCartFromModal() {
    const quantity = document.getElementById('modalQuantity').value;
    addToCart(currentProductId, quantity);
    closeModal();
}

function buyNowFromModal() {
    const quantity = document.getElementById('modalQuantity').value;
    addToCart(currentProductId, quantity);
    window.location.href = 'cart.php';
}

// Hàm gửi dữ liệu vào giỏ hàng (Cần file add_to_cart.php xử lý)
function addToCart(productId, quantity = 1) {
    console.log("Adding to cart:", productId, "Quantity:", quantity);

    fetch('add_to_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ productId, quantity })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Đã thêm món ăn vào giỏ hàng của bạn!');
                // Có thể thêm code cập nhật số lượng trên icon giỏ hàng ở đây
            } else {
                alert('Có lỗi xảy ra: ' + data.message);
            }
        })
        .catch(err => console.error('Lỗi kết nối giỏ hàng:', err));
}

// Event listeners
document.addEventListener('DOMContentLoaded', function () {
    // 1. Chỉ gọi loadProducts() nếu bạn ĐÃ CÓ file get_products.php xử lý đúng DB mới
    // Nếu chưa có file đó, hãy tạm comment dòng dưới để dùng dữ liệu từ PHP cho hiện hình đã.
    loadProducts(currentCategory, currentSort, currentPage);

    // 2. Sidebar menu
    document.querySelectorAll('#menu li').forEach(item => {
        item.addEventListener('click', function () {
            document.querySelectorAll('#menu li').forEach(i => i.classList.remove('active'));
            this.classList.add('active');

            currentCategory = this.dataset.category;
            currentPage = 1;
            loadProducts(currentCategory, currentSort, 1);
        });
    });

    // 3. Mobile category bar
    document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('click', function () {
            document.querySelectorAll('.nav-item').forEach(i => i.classList.remove('active'));
            this.classList.add('active');

            currentCategory = this.dataset.category;
            currentPage = 1;
            loadProducts(currentCategory, currentSort, 1);
        });
    });

    // 4. Sort (Sắp xếp)
    const sortSelect = document.getElementById('sortSelect');
    if (sortSelect) {
        sortSelect.addEventListener('change', function () {
            currentSort = this.value;
            currentPage = 1;
            loadProducts(currentCategory, currentSort, 1);
        });
    }

    // 5. Chuyển đổi Grid/List view
    // Chuyển đổi Grid/List view
    const gridBtn = document.getElementById('gridView');
    const listBtn = document.getElementById('listView');
    const productsContainer = document.getElementById('productsContainer');

    if (gridBtn && listBtn) {
        gridBtn.addEventListener('click', function () {
            productsContainer.classList.remove('product-list');
            productsContainer.classList.add('product-grid');
            gridBtn.classList.add('active');
            listBtn.classList.remove('active');
        });

        listBtn.addEventListener('click', function () {
            productsContainer.classList.remove('product-grid');
            productsContainer.classList.add('product-list');
            listBtn.classList.add('active');
            gridBtn.classList.remove('active');
        });
    }

    // 6. QUẢN LÝ MOBILE MENU (SIDEBAR & OVERLAY)
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    if (menuToggle && sidebar && overlay) {
        // Mở menu
        menuToggle.onclick = function (e) {
            e.preventDefault();
            sidebar.classList.add('active');
            overlay.classList.add('active');

            // Chỉ khóa cuộn nếu là màn hình điện thoại
            if (window.innerWidth <= 768) {
                document.body.style.overflow = 'hidden';
            }
        };

        // Đóng menu
        overlay.onclick = function () {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            // Mở khóa cuộn trang
            document.body.style.overflow = 'auto';
        };
    }
});