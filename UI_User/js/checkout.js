const validPromoCodes = {
    'XINCHAO20': { 
        id: 1, 
        type: 'percent', 
        value: 20, 
        max: 50000, 
        minOrder: 150000 
    },
    'FREESHIPKOREA': { 
        id: 2, 
        type: 'shipping', 
        value: 20000, 
        minOrder: 300000 
    }
};

let appliedPromoCode = '';
let pendingConfirmAction = null;

function showMessageModal(title, message) {
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalMessage').textContent = message;
    document.getElementById('messageModal').classList.add('active');
}

function closeMessageModal() {
    document.getElementById('messageModal').classList.remove('active');
}

function showConfirmModal(title, message, onConfirm) {
    document.getElementById('confirmTitle').textContent = title;
    document.getElementById('confirmMessage').textContent = message;
    pendingConfirmAction = onConfirm;
    document.getElementById('confirmModal').classList.add('active');
}

function closeConfirmModal() {
    document.getElementById('confirmModal').classList.remove('active');
    pendingConfirmAction = null;
}

document.addEventListener('DOMContentLoaded', function () {
    const confirmBtn = document.getElementById('confirmBtn');
    if (confirmBtn) {
        confirmBtn.onclick = function () {
            if (pendingConfirmAction) pendingConfirmAction();
            closeConfirmModal();
        };
    }

    const modals = ['messageModal', 'confirmModal'];
    modals.forEach(id => {
        const modal = document.getElementById(id);
        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) id === 'messageModal' ? closeMessageModal() : closeConfirmModal();
            });
        }
    });
});

function getCartItems() { return JSON.parse(localStorage.getItem('cart') || '[]'); }
function formatMoney(amount) { return amount.toLocaleString('vi-VN') + 'đ'; }
function calculateTotal(items) { return items.reduce((sum, item) => sum + (item.price * item.quantity), 0); }

function removeItem(productId) {
    showConfirmModal("Xác nhận xóa", "Bạn chắc chắn muốn xóa món này?", function () {
        let cart = getCartItems();
        cart = cart.filter(item => item.id != productId);
        localStorage.setItem('cart', JSON.stringify(cart));
        showToast('Đã xóa món ăn', 'success');
        startCheckoutProcess();
    });
}

function showToast(msg, type = 'success') {
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'toast-container';
        document.body.appendChild(container);
    }
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.innerHTML = `<span class="toast-text">${msg}</span>`;
    container.appendChild(toast);
    setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 300); }, 3000);
}

function showSuccessModal(totalStr, method) {
    const modal = document.getElementById('successModal');
    if (modal) {
        const content = modal.querySelector('.modal-body-text');
        if (content) content.innerHTML = `Tổng thanh toán: <b>${totalStr}</b><br>Hình thức: ${method}`;
        modal.classList.add('active');
    }
}

window.selectPaymentNew = function(element, methodValue) {
    const options = document.querySelectorAll('.payment-option');
    options.forEach(el => el.classList.remove('active'));
    element.classList.add('active');
    document.getElementById('selectedPaymentMethod').value = methodValue;
}

function applyPromoCode() {
    const input = document.getElementById('checkoutPromoInput');
    const code = input.value.trim().toUpperCase();
    if (!code) { showToast('Vui lòng nhập mã!', 'warning'); return; }
    if (!validPromoCodes[code]) { showToast('Mã không tồn tại', 'error'); return; }

    localStorage.setItem('appliedPromoCode', code);
    showToast(`Áp dụng thành công`, 'success');
    startCheckoutProcess();
}

function removePromoCode() {
    localStorage.removeItem('appliedPromoCode');
    startCheckoutProcess();
}

async function placeOrder(event) {
    event.preventDefault();
    const cartItems = getCartItems();
    const address = document.querySelector('input[name="address"]').value;
    const paymentMethod = document.getElementById('selectedPaymentMethod').value;

    const orderData = {
        items: cartItems,
        address: address,
        paymentMethod: paymentMethod,
        total: calculateTotal(cartItems)
    };

    const response = await fetch('save_order.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(orderData)
    });

    const result = await response.json();
    if (result.success) {
        localStorage.removeItem('cart');
        showSuccessModal(formatMoney(orderData.total + 20000), paymentMethod === 'cod' ? 'Tiền mặt' : 'Chuyển khoản');
    } else {
        alert("Lỗi: " + result.message);
    }
}

function renderCheckout(user) {
    const cartItems = getCartItems();
    const app = document.getElementById('app');

    if (cartItems.length === 0) {
        app.innerHTML = `
            <div class="checkout-page" style="text-align:center;">
                <i class="fas fa-shopping-basket" style="font-size:60px; color:#ccc;"></i>
                <h2>Giỏ hàng đang trống</h2>
                <a href="../php/product.php" class="btn-place-order" style="display:inline-block; width:auto; padding:10px 30px; text-decoration:none;">Tiếp tục mua sắm</a>
            </div>`;
        return;
    }

    const subtotal = calculateTotal(cartItems);
    const shipping = 20000;
    const savedPromo = localStorage.getItem('appliedPromoCode') || '';
    let discount = 0;
    let promoIdForDB = ""; 

    const promo = validPromoCodes[savedPromo];
    if (promo && subtotal >= (promo.minOrder || 0)) {
        promoIdForDB = promo.id;
        if (promo.type === 'percent') discount = Math.min(subtotal * (promo.value / 100), promo.max || 999999);
        else if (promo.type === 'fixed') discount = promo.value;
        else if (promo.type === 'shipping') discount = Math.min(promo.value, shipping);
    }

    const finalTotal = subtotal + shipping - discount;

    app.innerHTML = `
        <div class="checkout-page">
            <h1 class="page-title">Xác nhận thanh toán</h1>
            <form action="checkout.php" method="POST" class="checkout-grid">
                <input type="hidden" name="cart_data" value='${JSON.stringify(cartItems)}'>

                <div class="checkout-main">
                    <div class="card-checkout">
                        <h3><i class="fas fa-map-marker-alt"></i> Thông tin giao hàng</h3>
                        
                        <div class="form-group-checkout">
                            <label>Người nhận</label>
                            <input type="text" name="fullname" value="${user.username}" required>
                        </div>

                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px;">
                            <div class="form-group-checkout">
                                <label>Số điện thoại (Không thể đổi)</label>
                                <input type="tel" value="${user.phone}" readonly style="background:#f0f0f0; cursor:not-allowed;">
                            </div>
                            <div class="form-group-checkout">
                                <label>Email (Không thể đổi)</label>
                                <input type="email" value="${user.email}" readonly style="background:#f0f0f0; cursor:not-allowed;">
                            </div>
                        </div>

                        <div class="form-group-checkout">
                            <label>Ghi chú đơn hàng</label>
                            <textarea name="note" placeholder="Ví dụ: Không lấy hành, giao giờ hành chính..."></textarea>
                        </div>

                        <div class="form-group-checkout">
                            <label>Địa chỉ giao hàng chi tiết</label>
                            <input type="text" name="address" value="${user.address || ''}" required>
                        </div>
                    </div>

                    <div class="card-checkout">
                        <h3><i class="fas fa-wallet"></i> Phương thức thanh toán</h3>
                        <input type="hidden" id="selectedPaymentMethod" name="pt_thanh_toan" value="Tiền mặt (COD)">
                        <div class="payment-option active" onclick="selectPaymentNew(this, 'Tiền mặt (COD)')">
                            <h4>Thanh toán tiền mặt (COD)</h4>
                        </div>
                        <div class="payment-option" onclick="selectPaymentNew(this, 'Chuyển khoản VietQR')">
                            <h4>Chuyển khoản VietQR</h4>
                        </div>
                    </div>

                    <input type="hidden" name="id_khuyen_mai" value="${promoIdForDB}">
                    <input type="hidden" name="tien_ship" value="${shipping}">
                    <input type="hidden" name="tong_gia" value="${finalTotal}">
                </div>

                <div class="checkout-summary">
                    <div class="card-summary">
                        <h3>Đơn hàng của bạn</h3>
                        <div class="summary-line"><span>Tạm tính</span><span>${formatMoney(subtotal)}</span></div>
                        <div class="summary-line"><span>Phí ship</span><span>${formatMoney(shipping)}</span></div>
                        ${discount > 0 ? `<div class="summary-line"><span>Giảm giá</span><span>-${formatMoney(discount)}</span></div>` : ''}
                        <div class="summary-line total"><span>Tổng cộng</span><span>${formatMoney(finalTotal)}</span></div>
                        <button type="submit" name="place_order" class="btn-place-order">XÁC NHẬN ĐẶT HÀNG</button>
                    </div>
                </div>
            </form>
        </div>
    `;
}

function startCheckoutProcess() {
    if (typeof userData !== 'undefined' && userData !== null) {
        const formattedUser = {
            username: userData.ho_ten || userData.user_name,
            phone: userData.so_dien_thoai || '',
            email: userData.email || '',
            address: userData.dia_chi_mac_dinh || '',
        };
        sessionStorage.setItem("currentUser", JSON.stringify(formattedUser));
        renderCheckout(formattedUser);
    } else {
        window.location.href = '../php/login_register.php?redirect=checkout.php';
    }
}

startCheckoutProcess();