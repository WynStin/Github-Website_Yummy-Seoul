let cart = [];
const SHIPPING_FEE = 20000;
let appliedPromoCode = localStorage.getItem('appliedPromoCode') || '';
let pendingConfirmAction = null;

// Cập nhật Danh sách mã giảm giá từ Database Duy gửi
const validPromoCodes = {
    'XINCHAO20': { phan_tram: 20, giam_max: 50000, min_don: 150000, freeship: false },
    'FREESHIPKOREA': { phan_tram: 0, giam_max: 0, min_don: 300000, freeship: true },
    'CHAOBANMOI': { phan_tram: 10, giam_max: 30000, min_don: 0, freeship: false }
};

// ===== MODAL FUNCTIONS (GIỮ NGUYÊN) =====
function showMessageModal(title, message) {
    const modalTitle = document.getElementById('modalTitle');
    const modalMessage = document.getElementById('modalMessage');
    if (modalTitle) modalTitle.textContent = title;
    if (modalMessage) modalMessage.textContent = message;
    const modal = document.getElementById('messageModal');
    if (modal) modal.classList.add('active');
}

function closeMessageModal() {
    const modal = document.getElementById('messageModal');
    if (modal) modal.classList.remove('active');
}

function showConfirmModal(title, message, onConfirm) {
    const confirmTitle = document.getElementById('confirmTitle');
    const confirmMessage = document.getElementById('confirmMessage');
    if (confirmTitle) confirmTitle.textContent = title;
    if (confirmMessage) confirmMessage.textContent = message;
    pendingConfirmAction = onConfirm;
    const modal = document.getElementById('confirmModal');
    if (modal) modal.classList.add('active');
}

// ===== CART FUNCTIONS =====
function formatPrice(price) {
    return price.toLocaleString('vi-VN') + 'đ';
}

function loadCart() {
    const savedCart = localStorage.getItem('cart');
    if (savedCart) {
        cart = JSON.parse(savedCart);
    }
    renderCart();
    updateSummary();
}

function saveCart() {
    localStorage.setItem('cart', JSON.stringify(cart));
    window.dispatchEvent(new Event('cartUpdated'));
}

function renderCart() {
    const cartItemsList = document.getElementById('cartItemsList');
    const badge = document.getElementById('itemCountBadge');
    if (badge) badge.textContent = `${cart.length} sản phẩm`;

    if (cart.length === 0) {
        cartItemsList.innerHTML = `
            <div class="empty-cart-box">
                <div class="empty-cart-icon">🛒</div>
                <h3>Giỏ hàng trống</h3>
                <p>Hãy thêm sản phẩm vào giỏ hàng để tiếp tục mua sắm</p>
                <button class="shop-now-btn" onclick="window.location.href='home.php'">Mua sắm ngay</button>
            </div>
        `;
        const checkoutBtn = document.getElementById('checkoutBtn');
        if (checkoutBtn) checkoutBtn.disabled = true;
        return;
    }

    const checkoutBtn = document.getElementById('checkoutBtn');
    if (checkoutBtn) checkoutBtn.disabled = false;

    // Render danh sách theo cấu trúc ảnh mẫu
    // Thay đoạn map trong renderCart() bằng đoạn này:
    cartItemsList.innerHTML = cart.map((item, index) => `
    <div class="cart-item-card">
        <div class="item-main-info">
            <img src="${item.image}" alt="${item.title}" class="item-img-small">
            <div class="item-text">
                <h3 style="color: var(--brown-deep);">${item.title}</h3>
                <p class="item-price-text" style="margin:0; color: #ff5722; font-weight: bold;">${formatPrice(item.price)}</p>
                
                <div class="quantity-control-small">
                    <button onclick="decreaseQty(${index})">−</</button>
                    <input type="number" value="${item.quantity}" readonly>
                    <button onclick="increaseQty(${index})">+</button>
                </div>
            </div>
            <button class="delete-icon-btn" onclick="removeItem(${index})">
                <i class="fa-solid fa-trash-can"></i>
            </button>
        </div>
        <div class="item-total-display">
            Thành tiền: <span style="color: var(--red-brown); font-weight: 700;">${formatPrice(item.price * item.quantity)}</span>
        </div>
    </div>
    `).join('');

    // Đừng quên gọi updateSummary() ở cuối render
    updateSummary();
}

function increaseQty(index) {
    cart[index].quantity++;
    saveCart();
    renderCart();
    updateSummary();
}

function decreaseQty(index) {
    if (cart[index].quantity > 1) {
        cart[index].quantity--;
        saveCart();
        renderCart();
        updateSummary();
    }
}

function removeItem(index) {
    // Sử dụng modal xác nhận cũ của Duy
    cart.splice(index, 1);
    saveCart();
    renderCart();
    updateSummary();
    showNotification('Đã xóa sản phẩm khỏi giỏ hàng', 'success');
}

// Cập nhật lại logic trong hàm updateSummary của Duy
function updateSummary() {
    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    let shipping = cart.length > 0 ? SHIPPING_FEE : 0;
    let discount = 0;

    // CHỖ CẦN SỬA 2: Kiểm tra mã từ Database
    const promo = validPromoCodes[appliedPromoCode];

    if (promo) {
        // Kiểm tra điều kiện đơn hàng tối thiểu (don_hang_min)
        if (subtotal >= promo.min_don) {
            // 1. Tính giảm giá theo % (phan_tram_giam)
            if (promo.phan_tram > 0) {
                let tempDiscount = subtotal * (promo.phan_tram / 100);
                // 2. Giới hạn bởi mức giảm tối đa (giam_toi_da)
                discount = Math.min(tempDiscount, promo.giam_max);
            }
            // 3. Kiểm tra nếu có hỗ trợ Freeship (co_freeship)
            if (promo.freeship) {
                shipping = 0;
            }
        } else {
            // Nếu không đủ đơn tối thiểu thì tự động hủy mã và thông báo
            appliedPromoCode = '';
            localStorage.removeItem('appliedPromoCode');
            if (typeof showNotification === 'function') {
                showNotification(`Mã yêu cầu đơn từ ${formatPrice(promo.min_don)}`, 'warning');
            }
        }
    }

    // Giữ nguyên các dòng cập nhật giao diện (innerHTML/textContent) phía dưới của Duy
    document.getElementById('subtotal').textContent = formatPrice(subtotal);
    document.getElementById('shipping').textContent = formatPrice(shipping);
    document.getElementById('discount').textContent = `-${formatPrice(discount)}`;
    document.getElementById('total').textContent = formatPrice(subtotal + shipping - discount);
}

function applyPromo() {
    const input = document.getElementById('promoInput');
    const code = input.value.toUpperCase().trim();
    if (validPromoCodes[code]) {
        const promo = validPromoCodes[code];
        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);

        if (subtotal >= promo.min_don) {
            appliedPromoCode = code;
            localStorage.setItem('appliedPromoCode', code);
            showNotification('Áp dụng mã thành công!', 'success');
            updateSummary();
        } else {
            showNotification(`Đơn tối thiểu ${formatPrice(promo.min_don)}`, 'warning');
        }
    } else {
        showNotification('Mã không hợp lệ', 'error');
    }
    input.value = '';
}

function updatePromoDisplay(info) {
    const display = document.getElementById('promoDisplay');
    if (appliedPromoCode) {
        display.innerHTML = `<div class="promo-active-tag">Mã áp dụng: ${appliedPromoCode} <i class="fa fa-times" onclick="removePromo()"></i></div>`;
    } else {
        display.innerHTML = info ? `<div class="auto-promo-info">${info}</div>` : '';
    }
}

function removePromo() {
    appliedPromoCode = '';
    localStorage.removeItem('appliedPromoCode');
    updateSummary();
}

function showNotification(message, type = 'success') {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.innerHTML = `
        <i class="fa-solid ${type === 'success' ? 'fa-circle-check' : 'fa-circle-xmark'}"></i>
        <span>${message}</span>
    `;
    container.appendChild(toast);
    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 500);
    }, 3000);
}

function checkout() {
    const currentCart = JSON.parse(localStorage.getItem('cart') || '[]');
    
    if (currentCart.length === 0) {
        showNotification('Giỏ hàng của bạn đang trống!', 'warning');
        return;
    }

    // Nếu isLoggedIn là 1 (đã có session từ PHP)
    if (isLoggedIn === 1) { 
        window.location.href = 'checkout.php';
    } else {
        showNotification('Vui lòng đăng nhập để thanh toán', 'warning');
        
        setTimeout(() => {
            // Quan trọng: Gửi thêm tham số redirect để trang Login xử lý
            window.location.href = LOGIN_URL + '?redirect=checkout.php';
        }, 1200);
    }
}
loadCart();