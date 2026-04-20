// --- CONFIG DATA ---
const validPromoCodes = {
    'CHAOBANMOI': { type: 'percent', value: 10, desc: 'Giảm 10% (Lần đầu mua)', minOrder: 0, firstTimeOnly: true },
    'MUC10': { type: 'fixed', value: 10000, desc: 'Giảm 10k', minOrder: 99000 },
    'MUC20': { type: 'fixed', value: 20000, desc: 'Giảm 20k', minOrder: 169000 },
    'MUC30': { type: 'fixed', value: 30000, desc: 'Giảm 30k', minOrder: 249000 },
    'THITOTNHA': { type: 'shipping', value: 15000, desc: 'Giảm 15k phí vận chuyển' }
};

let appliedPromoCode = '';
let pendingConfirmAction = null;

// ===== MODAL FUNCTIONS =====
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

document.addEventListener('DOMContentLoaded', function() {
    const confirmBtn = document.getElementById('confirmBtn');
    if(confirmBtn) {
        confirmBtn.onclick = function() {
            if (pendingConfirmAction) pendingConfirmAction();
            closeConfirmModal();
        };
    }
});

// Đóng modal khi bấm ra ngoài
document.addEventListener('DOMContentLoaded', function() {
    const modals = ['messageModal', 'confirmModal'];
    modals.forEach(id => {
        const modal = document.getElementById(id);
        if (modal) {
            modal.addEventListener('click', (e) => { if (e.target === modal) id === 'messageModal' ? closeMessageModal() : closeConfirmModal(); });
        }
    });
});

// Kiểm tra đăng nhập
function checkAuth() {
    const currentUser = sessionStorage.getItem("currentUser");
    if (!currentUser) {
        // Sửa đường dẫn này cho đúng với file login của bạn
        window.location.href = "../php/checkout.php"; 
        return null;
    }
    return JSON.parse(currentUser);
}

function getCartItems() {
    return JSON.parse(localStorage.getItem('cart') || '[]');
}

function formatMoney(amount) {
    return amount.toLocaleString('vi-VN') + 'đ';
}

function calculateTotal(items) {
    return items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
}

function removeItem(productId) {
    showConfirmModal("Xác nhận xóa", "Bạn chắc chắn muốn xóa món này?", function() {
        let cart = getCartItems();
        cart = cart.filter(item => item.id != productId);
        localStorage.setItem('cart', JSON.stringify(cart));
        showToast('Đã xóa món ăn', 'success');
        renderCheckout(checkAuth());
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
    // Lưu ý: Đảm bảo có successModal trong checkout.php hoặc render nó trong HTML bên dưới
    const modal = document.getElementById('successModal');
    if(modal) {
        const content = modal.querySelector('.modal-body-text');
        if(content) content.innerHTML = `Tổng thanh toán: <b>${totalStr}</b><br>Hình thức: ${method}`;
        modal.classList.add('active');
    }
}

window.selectPaymentNew = function(element, method) {
    const parent = element.parentElement;
    parent.querySelectorAll('.payment-option').forEach(el => el.classList.remove('active'));
    element.classList.add('active');
    document.getElementById('selectedPaymentMethod').value = method;
}

function applyPromoCode() {
    const input = document.getElementById('checkoutPromoInput');
    const code = input.value.trim().toUpperCase();
    if (!code) { showToast('Vui lòng nhập mã!', 'warning'); return; }
    
    const promo = validPromoCodes[code];
    if (!promo) { showToast('Mã không tồn tại', 'error'); return; }
    
    localStorage.setItem('appliedPromoCode', code);
    showToast(`Áp dụng thành công: ${promo.desc}`, 'success');
    renderCheckout(checkAuth());
}

function removePromoCode() {
    localStorage.removeItem('appliedPromoCode');
    renderCheckout(checkAuth());
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

    // Gửi dữ liệu về Server
    const response = await fetch('save_order.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(orderData)
    });

    const result = await response.json();
    if (result.success) {
        localStorage.removeItem('cart'); // Xóa giỏ hàng sau khi đặt xong
        showSuccessModal(formatMoney(orderData.total + 20000), paymentMethod);
    } else {
        alert("Có lỗi xảy ra: " + result.message);
    }
}

function recordUserPurchases(cartItems) {
    try {
        const user = JSON.parse(sessionStorage.getItem('currentUser'));
        if (!user) return;
        let purchases = JSON.parse(localStorage.getItem('userPurchases') || '{}');
        if (!purchases[user.username]) purchases[user.username] = [];
        cartItems.forEach(item => {
            purchases[user.username].push({ productId: item.id, date: new Date().toLocaleDateString('vi-VN') });
        });
        localStorage.setItem('userPurchases', JSON.stringify(purchases));
    } catch (e) {}
}

// ===== HÀM RENDER ĐÃ SỬA CLASS CHO KHỚP CSS =====
function renderCheckout(user) {
    const cartItems = getCartItems();
    if (cartItems.length === 0) {
        document.getElementById('app').innerHTML = `
            <div class="checkout-page" style="text-align:center;">
                <i class="fas fa-shopping-basket" style="font-size:60px; color:#ccc;"></i>
                <h2>Giỏ hàng đang trống</h2>
                <a href="product.php" class="btn-place-order" style="display:inline-block; width:auto; padding:10px 30px;">Mua sắm ngay</a>
            </div>`;
        return;
    }

    const subtotal = calculateTotal(cartItems);
    const shipping = 20000;
    const savedPromo = localStorage.getItem('appliedPromoCode') || '';
    let discount = 0;
    
    const promo = validPromoCodes[savedPromo];
    if (promo && subtotal >= (promo.minOrder || 0)) {
        if (promo.type === 'percent') discount = subtotal * (promo.value / 100);
        else if (promo.type === 'fixed') discount = promo.value;
        else if (promo.type === 'shipping') discount = Math.min(promo.value, shipping);
    }

    const html = `
        <div class="checkout-page">
            <h1 class="page-title">Xác nhận thanh toán</h1>
            <div id="toast-container"></div>

            <form onsubmit="placeOrder(event)" class="checkout-grid">
                <div class="checkout-main">
                    <div class="card-checkout">
                        <h3><i class="fas fa-map-marker-alt"></i> Thông tin giao hàng</h3>
                        <div class="form-group-checkout">
                            <label>Người nhận</label>
                            <input type="text" name="fullname" value="${user.username}" required>
                        </div>
                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px;">
                            <div class="form-group-checkout">
                                <label>Số điện thoại</label>
                                <input type="tel" name="phone" value="${user.phone || ''}" required placeholder="09xxxxxxxx">
                            </div>
                            <div class="form-group-checkout">
                                <label>Email</label>
                                <input type="email" name="email" value="${user.email}" required>
                            </div>
                        </div>
                        <div class="form-group-checkout">
                            <label>Địa chỉ chi tiết</label>
                            <input type="text" name="address" placeholder="Số nhà, tên đường..." required>
                        </div>
                    </div>

                    <div class="card-checkout">
                        <h3><i class="fas fa-wallet"></i> Phương thức thanh toán</h3>
                        <input type="hidden" id="selectedPaymentMethod" name="paymentMethod" value="cod">
                        
                        <div class="payment-option active" onclick="selectPaymentNew(this, 'cod')" style="border: 1px solid #eee; padding: 15px; border-radius: 10px; margin-bottom: 10px; cursor: pointer;">
                            <h4>Thanh toán tiền mặt (COD)</h4>
                            <p style="font-size:12px; color:#666;">Thanh toán khi nhận hàng</p>
                        </div>
                        <div class="payment-option" onclick="selectPaymentNew(this, 'banking')" style="border: 1px solid #eee; padding: 15px; border-radius: 10px; cursor: pointer;">
                            <h4>Chuyển khoản VietQR</h4>
                            <p style="font-size:12px; color:#666;">Techcombank - 3023022006</p>
                        </div>
                    </div>
                </div>

                <div class="checkout-summary">
                    <div class="card-summary">
                        <h3 style="color:#fff; border-bottom: 1px solid rgba(255,255,255,0.2); padding-bottom:10px;">Đơn hàng của bạn</h3>
                        <div style="max-height: 200px; overflow-y: auto; margin-bottom: 20px;">
                            ${cartItems.map(item => `
                                <div class="item-minimal">
                                    <span>${item.title} x${item.quantity}</span>
                                    <span>${formatMoney(item.price * item.quantity)}</span>
                                </div>
                            `).join('')}
                        </div>

                        <div class="promo-section" style="margin-bottom:20px;">
                            <div style="display:flex; gap:5px;">
                                <input type="text" id="checkoutPromoInput" placeholder="Mã giảm giá" style="flex:1; padding:8px; border-radius:5px; border:none;">
                                <button type="button" onclick="applyPromoCode()" style="padding:8px 15px; background:#e2b96a; border:none; border-radius:5px; cursor:pointer;">Dùng</button>
                            </div>
                            ${savedPromo ? `<div style="margin-top:5px; font-size:12px; color:#ffeda3;">Đang dùng: ${savedPromo} <i class="fas fa-times" onclick="removePromoCode()" style="cursor:pointer"></i></div>` : ''}
                        </div>

                        <div class="summary-line"><span>Tạm tính</span><span>${formatMoney(subtotal)}</span></div>
                        <div class="summary-line"><span>Phí ship</span><span>${formatMoney(shipping)}</span></div>
                        ${discount > 0 ? `<div class="summary-line"><span>Giảm giá</span><span>-${formatMoney(discount)}</span></div>` : ''}
                        <div class="summary-line total">
                            <span>Tổng cộng</span>
                            <span>${formatMoney(subtotal + shipping - discount)}</span>
                        </div>

                        <button type="submit" class="btn-place-order">XÁC NHẬN ĐẶT HÀNG</button>
                    </div>
                </div>
            </form>
        </div>
    `;
    document.getElementById('app').innerHTML = html;
}

window.onload = function() {
    // Không dùng sessionStorage nữa mà dùng userData từ PHP đổ ra
    if (typeof userData !== 'undefined' && userData !== null) {
        renderCheckout(userData);
    } else {
        window.location.href = '../php/login_register.php';
    }
};