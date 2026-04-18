let currentCategory = 'all';
let currentSort = 'default';
let currentPage = 1;
let currentProductId = null;

// Load sản phẩm
async function loadProducts(category = 'all', sort = 'default', page = 1) {
    try {
        const response = await fetch(`get_products.php?category=${category}&sort=${sort}&page=${page}`);
        const data = await response.json();
        
        if (data.success) {
            displayProducts(data.products);
            displayPagination(data.totalPages, data.currentPage);
            updateCategoryTitle(category);
        }
    } catch (error) {
        console.error('Lỗi:', error);
    }
}

// Hiển thị sản phẩm
function displayProducts(products) {
    const container = document.getElementById('productsContainer');
    
    if (products.length === 0) {
        container.innerHTML = '<p class="no-products">Không có sản phẩm nào.</p>';
        return;
    }
    
    container.innerHTML = products.map(product => `
        <div class="product-card">
            <div class="product-image">
                <img src="../../Public/img/products/${product.image}" alt="${product.name}">
                <div class="product-overlay">
                    <button class="quick-view-btn" onclick="openModal(${product.id}, '${product.name}', ${product.price})">
                        <i class="fas fa-eye"></i> Xem nhanh
                    </button>
                </div>
            </div>
            <div class="product-info">
                <h3 class="product-name">${product.name}</h3>
                <p class="product-description">${product.description || ''}</p>
                <div class="product-price">${formatPrice(product.price)}</div>
                <div class="product-actions">
                    <button class="add-to-cart-btn" onclick="addToCart(${product.id})">
                        <i class="fas fa-shopping-cart"></i> Thêm vào giỏ
                    </button>
                </div>
            </div>
        </div>
    `).join('');
}

// Format giá
function formatPrice(price) {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(price);
}

// Phân trang
function displayPagination(totalPages, currentPage) {
    const container = document.getElementById('paginationContainer');
    
    if (totalPages <= 1) {
        container.innerHTML = '';
        return;
    }
    
    let html = '';
    
    // Nút Previous
    if (currentPage > 1) {
        html += `<button class="page-btn" onclick="changePage(${currentPage - 1})">«</button>`;
    }
    
    // Các trang
    for (let i = 1; i <= totalPages; i++) {
        if (i === currentPage) {
            html += `<button class="page-btn active">${i}</button>`;
        } else {
            html += `<button class="page-btn" onclick="changePage(${i})">${i}</button>`;
        }
    }
    
    // Nút Next
    if (currentPage < totalPages) {
        html += `<button class="page-btn" onclick="changePage(${currentPage + 1})">»</button>`;
    }
    
    container.innerHTML = html;
}

function changePage(page) {
    currentPage = page;
    loadProducts(currentCategory, currentSort, page);
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Cập nhật tiêu đề danh mục
function updateCategoryTitle(category) {
    const titles = {
        'all': 'Tất cả sản phẩm',
        'com': 'Cơm (Rice)',
        'ga': 'Gà (Chicken)',
        'mi': 'Mì (Noodles)',
        'lau-sup': 'Lẩu & Súp (Stew)',
        'an-nhe': 'Đồ ăn nhẹ (Snacks)',
        'do-uong': 'Đồ uống (Drinks)'
    };
    
    document.getElementById('categoryTitle').textContent = titles[category] || titles['all'];
}

// Modal functions
function openModal(id, name, price) {
    currentProductId = id;
    document.getElementById('modalProductName').textContent = name;
    document.getElementById('modalProductPrice').textContent = formatPrice(price);
    document.getElementById('modalQuantity').value = 1;
    document.getElementById('quickActionModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('quickActionModal').style.display = 'none';
}

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

function addToCart(productId, quantity = 1) {
    // Gửi request thêm vào giỏ hàng
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
            alert('Đã thêm vào giỏ hàng!');
        }
    });
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Load sản phẩm lần đầu
    loadProducts();
    
    // Sidebar menu
    document.querySelectorAll('#menu li').forEach(item => {
        item.addEventListener('click', function() {
            document.querySelectorAll('#menu li').forEach(i => i.classList.remove('active'));
            this.classList.add('active');
            
            currentCategory = this.dataset.category;
            currentPage = 1;
            loadProducts(currentCategory, currentSort, 1);
        });
    });
    
    // Mobile category
    document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('click', function() {
            document.querySelectorAll('.nav-item').forEach(i => i.classList.remove('active'));
            this.classList.add('active');
            
            currentCategory = this.dataset.category;
            currentPage = 1;
            loadProducts(currentCategory, currentSort, 1);
        });
    });
    
    // Sort
    document.getElementById('sortSelect').addEventListener('change', function() {
        currentSort = this.value;
        currentPage = 1;
        loadProducts(currentCategory, currentSort, 1);
    });
    
    // View mode
    document.getElementById('gridView').addEventListener('click', function() {
        document.getElementById('productsContainer').className = 'product-grid';
        document.querySelectorAll('.view-btn').forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');
    });
    
    document.getElementById('listView').addEventListener('click', function() {
        document.getElementById('productsContainer').className = 'product-list';
        document.querySelectorAll('.view-btn').forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');
    });
    
    // Mobile menu toggle
    document.getElementById('menuToggle')?.addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('active');
        document.getElementById('sidebarOverlay').classList.toggle('active');
    });
    
    document.getElementById('sidebarOverlay')?.addEventListener('click', function() {
        document.getElementById('sidebar').classList.remove('active');
        this.classList.remove('active');
    });
});