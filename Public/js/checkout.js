// --- CONFIG DATA ---
const validPromoCodes = {
    'CHAOBANMOI': { type: 'percent', value: 10, desc: 'Giảm 10% (Lần đầu mua)', minOrder: 0, firstTimeOnly: true },
    'MUC10': { type: 'fixed', value: 10000, desc: 'Giảm 10k', minOrder: 99000 },
    'MUC20': { type: 'fixed', value: 20000, desc: 'Giảm 20k', minOrder: 169000 },
    'MUC30': { type: 'fixed', value: 30000, desc: 'Giảm 30k', minOrder: 249000 },
    'THITOTNHA': { type: 'shipping', value: 15000, desc: 'Giảm 15k phí vận chuyển' }
};

let appliedPromoCode = '';// Mã giảm giá đã áp dụng
let pendingConfirmAction = null; // Lưu hàm cần thực hiện sau khi xác nhận

// ===== MODAL FUNCTIONS =====
function showMessageModal(title, message) {
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalMessage').textContent = message;
    document.getElementById('messageModal').classList.add('active');
}
// Đóng modal thông báo
function closeMessageModal() {
    document.getElementById('messageModal').classList.remove('active');
}
// Mở modal xác nhận
function showConfirmModal(title, message, onConfirm) {
    document.getElementById('confirmTitle').textContent = title;
    document.getElementById('confirmMessage').textContent = message;
    pendingConfirmAction = onConfirm;
    document.getElementById('confirmModal').classList.add('active');
}
// Đóng modal xác nhận
function closeConfirmModal() {
    document.getElementById('confirmModal').classList.remove('active');
    pendingConfirmAction = null;
}
// Xác nhận hành động
function confirmAction() {
    if (pendingConfirmAction && typeof pendingConfirmAction === 'function') {// Kiểm tra và thực thi hàm đã lưu
        pendingConfirmAction();// Thực thi hàm
    }
    closeConfirmModal();// Đóng modal sau khi xác nhận
}

// Đóng modal khi bấm ra ngoài
document.addEventListener('DOMContentLoaded', function() {
    const messageModal = document.getElementById('messageModal');
    const confirmModal = document.getElementById('confirmModal');
    
    if (messageModal) {
        messageModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeMessageModal();
            }
        });
    }
    
    if (confirmModal) {
        confirmModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeConfirmModal();
            }
        });
    }
});

// kiêm tra đăng nhập
function checkAuth() {
    const currentUser = sessionStorage.getItem("currentUser");// Lấy thông tin user từ sessionStorage
    if (!currentUser) {
        window.location.href = "/page/account/login/login.html#login";// Chuyển hướng về trang đăng nhập nếu chưa đăng nhập
        return null;
    }
    return JSON.parse(currentUser);
}
// Lấy danh sách món trong giỏ hàng
function getCartItems() {
    return JSON.parse(localStorage.getItem('cart') || '[]');
}

// Định dạng tiền tệ
function formatMoney(amount) {
    return amount.toLocaleString('vi-VN') + 'đ';
}
// Tính tổng tiền hàng
function calculateTotal(items) {
    return items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
}

// Xóa món khỏi giỏ hàng
function removeItem(productId) {
    showConfirmModal("Xác nhận xóa", "Bạn chắc chắn muốn xóa món này?", function() {// Hàm thực thi khi xác nhận
        let cart = getCartItems();// Lấy giỏ hàng hiện tại
        cart = cart.filter(item => item.id != productId);// Lọc bỏ món có ID trùng với productId
        localStorage.setItem('cart', JSON.stringify(cart));// Cập nhật giỏ hàng sau khi xóa
        // Hiển thị thông báo
        showToast('Đã xóa món ăn', 'success');
        renderCheckout(checkAuth());// Cập nhật lại giao diện checkout
    });
}
// Hiển thị thông báo dạng toast
function showToast(msg, type = 'success', duration = 3000) {
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'toast-container';
        document.body.appendChild(container);
    }

    const icons = {
        success: '<i class="fa-solid fa-circle-check"></i>',
        error: '<i class="fa-solid fa-circle-xmark"></i>',
        warning: '<i class="fa-solid fa-triangle-exclamation"></i>',
        info: '<i class="fa-solid fa-circle-info"></i>'
    };

    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.innerHTML = `
        <span class="toast-icon">${icons[type] || icons.info}</span>
        <span class="toast-text">${msg}</span>
        <button class="toast-close" onclick="this.parentElement.remove()">✕</button>
    `;

    container.appendChild(toast);

    setTimeout(() => {
        if (toast.parentElement) {
            toast.classList.add('remove');
            setTimeout(() => toast.remove(), 300);
        }
    }, duration);
}
// Hiển thị modal thành công sau khi đặt hàng
function showSuccessModal(totalStr, method) {
    const modal = document.getElementById('successModal');
    const content = modal.querySelector('.modal-body-text');
    content.innerHTML = `Tổng thanh toán: <b>${totalStr}</b><br>Hình thức: ${method}`;
    modal.classList.add('show');
}
// Đóng modal thành công
window.selectPaymentNew = function(element, method) {
  
    const parent = element.parentElement;
    parent.querySelectorAll('.payment-option').forEach(el => el.classList.remove('active'));
    element.classList.add('active');
    document.getElementById('selectedPaymentMethod').value = method;
}
// Hàm áp dụng mã giảm giá
function applyPromoCode() {
    const input = document.getElementById('checkoutPromoInput');// Lấy ô nhập mã giảm giá
    const code = input.value.trim();// Lấy mã nhập vào và loại bỏ khoảng trắng
    
    if (!code) { showToast('Vui lòng nhập mã!', 'warning'); return; }// Kiểm tra nhập mã
    // Kiểm tra mã có hợp lệ không
    const promo = validPromoCodes[code];
    if (!promo) {
        showToast('Mã giảm giá không tồn tại', 'error');
        input.value = '';
        return;
    }
    
    // Kiểm tra điều kiện
    const cartItems = getCartItems();
    const subtotal = calculateTotal(cartItems);
    // Kiểm tra đơn hàng tối thiểu
    if (promo.minOrder && subtotal < promo.minOrder) {
        showToast(`Mã yêu cầu đơn tối thiểu ${formatMoney(promo.minOrder)}`, 'warning');
        input.value = '';
        return;
    }
    // Kiểm tra lần đầu mua
    if (promo.firstTimeOnly) {
        const currentUser = JSON.parse(sessionStorage.getItem('currentUser') || localStorage.getItem('currentUser') || '{}');
        const userPurchases = JSON.parse(localStorage.getItem('userPurchases') || '{}');
        
        if (currentUser.username && userPurchases[currentUser.username] && userPurchases[currentUser.username].length > 0) {
            showToast('Mã CHAOBANMOI chỉ áp dụng cho lần đầu mua', 'warning');
            input.value = '';
            return;
        }
    }
    
    localStorage.setItem('appliedPromoCode', code);// Lưu mã vào localStorage
    showToast(`Áp dụng mã thành công! ${promo.desc}`, 'success');// Thông báo thành công
    input.value = '';// Xóa ô nhập
    renderCheckout(checkAuth());// Cập nhật lại giao diện checkout
}
// Hàm xóa mã giảm giá
function removePromoCode() {
    localStorage.removeItem('appliedPromoCode');
    renderCheckout(checkAuth());
}
// Xử lý đặt hàng
function placeOrder(event) {
    event.preventDefault();
    const form = event.target;
    
    // Validate form
    if (!form.checkValidity()) {
        showToast('Vui lòng điền đủ thông tin nhận hàng', 'error');
        const invalidInput = form.querySelector(':invalid');
        if(invalidInput) invalidInput.focus();
        return;
    }
    
    // Kiểm tra số điện thoại
    const phoneInput = form.querySelector('input[name="phone"]');
    const phoneValue = phoneInput.value.trim();
    
    // Kiểm tra số điện thoại hợp lệ (10-11 chữ số, bắt đầu từ 0)
    const phoneRegex = /^0\d{9,10}$/;
    if (!phoneRegex.test(phoneValue)) {
        showMessageModal("Lỗi", "Vui lòng nhập số điện thoại hợp lệ (10-11 chữ số, bắt đầu bằng 0)!");
        phoneInput.focus();
        return;
    }
    // Lấy món trong giỏ hàng
    const cartItems = getCartItems();
    if (cartItems.length === 0) {
        showToast('Giỏ hàng trống!', 'error');
        return;
    }
    // Lấy phương thức thanh toán
    const paymentMethodEl = document.querySelector('.payment-option.active h4');
    const paymentMethodText = paymentMethodEl ? paymentMethodEl.innerText : 'Thanh toán';
    
    // Ghi nhận đơn hàng (Ở đây ta chỉ mô phỏng, không gửi lên server)
    recordUserPurchases(cartItems);

    // Xóa giỏ hàng và mã giảm giá đã áp dụng
    localStorage.removeItem('cart');
    localStorage.removeItem('appliedPromoCode');

    // Hiển thị modal thành công
    const totalEl = document.querySelector('.summary-line.total span:last-child');
    const totalStr = totalEl ? totalEl.innerText : '0đ';

    showSuccessModal(totalStr, paymentMethodText);
}
// Ghi nhận lịch sử mua hàng của người dùng
function recordUserPurchases(cartItems) {
    try {
        const user = JSON.parse(sessionStorage.getItem('currentUser') || localStorage.getItem('currentUser'));// Lấy thông tin user
        if (!user) return;
        const purchases = JSON.parse(localStorage.getItem('userPurchases') || '{}');// Lấy lịch sử mua hàng hiện tại
        if (!purchases[user.username]) purchases[user.username] = [];// Khởi tạo mảng nếu chưa có
        // Ghi nhận từng món đã mua
        cartItems.forEach(item => {
             if (!purchases[user.username].some(p => p.productId == item.id)) {// Chỉ ghi nhận món chưa mua trước đó
                purchases[user.username].push({// Thêm mục mua hàng mới
                    productId: item.id,
                    productTitle: item.title,
                    purchaseDate: new Date().toLocaleDateString('vi-VN'),
                    quantity: item.quantity
                });
             }
        });
        localStorage.setItem('userPurchases', JSON.stringify(purchases));
        
        // Ghi nhận lần thanh toán riêng biệt
        const paymentHistory = JSON.parse(localStorage.getItem('userPaymentTransactions') || '{}');// Lấy lịch sử thanh toán
        if (!paymentHistory[user.username]) paymentHistory[user.username] = [];// Khởi tạo mảng nếu chưa có
        paymentHistory[user.username].push({// Thêm mục thanh toán mới
            transactionId: Date.now(),// ID giao dịch duy nhất
            paymentDate: new Date().toLocaleDateString('vi-VN'),
            paymentTime: new Date().toLocaleTimeString('vi-VN'),
            itemCount: cartItems.length,
            timestamp: new Date().getTime()
        });
        localStorage.setItem('userPaymentTransactions', JSON.stringify(paymentHistory));
    } catch (e) {}
}

// Hiển thị giao diện trang thanh toán
function renderCheckout(user) {
    const cartItems = getCartItems();
    
    // Empty State
    if (cartItems.length === 0) {
        document.getElementById('app').innerHTML = `
            <div style="height:100vh; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:20px;">
                <i class="fas fa-shopping-basket" style="font-size:60px; color:#e5e7eb;"></i>
                <h2 style="color:#374151;">Giỏ hàng của bạn đang trống</h2>
                <a href="/index.htm" style="padding:12px 24px; background:#1a1a1a; color:white; text-decoration:none; border-radius:8px; font-weight:600;">Quay lại mua sắm</a>
            </div>
        `;
        return;
    }

    // Tính toán đơn hàng
    const subtotal = calculateTotal(cartItems);// Tổng tiền hàng
    const shipping = 20000;
    
    const savedPromo = localStorage.getItem('appliedPromoCode') || '';// Lấy mã giảm giá đã lưu
    appliedPromoCode = savedPromo;
    
    let discount = 0;
    let discountText = '';
    let autoDiscount = 0;
    let promoInfo = '';
    
    // ===== TỰ ĐỘNG GIẢM GIÁ NƯỚC LỌC =====
    // Giảm 50% nước lọc khi mua "Mỳ Trộn Không Khô" hoặc "Mỳ Cay Không Cay"
    const hasMiTronKhongKho = cartItems.some(item => 
        item.title && (item.title.includes('Mì trộn') || item.title.includes('Mỳ Trộn'))
    );
    const hasMiCayKhongCay = cartItems.some(item => 
        item.title && (item.title.includes('Mì cay') || item.title.includes('Mỳ Cay'))
    );
    const waterItem = cartItems.find(item => item.id === 125);
    
    if ((hasMiTronKhongKho || hasMiCayKhongCay) && waterItem) {
        autoDiscount += (waterItem.price * 0.5);
        promoInfo += 'Mỳ Trộn Không Khô - Mỳ Cay Không Cay\n';
    }
    
    // ===== CHƯƠNG TRÌNH THEO GIỜ =====
    const now = new Date();
    const hours = now.getHours();
    const minutes = now.getMinutes();
    const currentTime = hours * 60 + minutes;
    
    // Chương trình "xế chiều nạp mood": 13:30 - 17:30, giảm 5% đồ uống
    const xeChieuStart = 13 * 60 + 30;  // 13:30
    const xeChieuEnd = 17 * 60 + 30;    // 17:30
    let xeChieuDiscount = 0;
    
    if (currentTime >= xeChieuStart && currentTime <= xeChieuEnd) {
        const drinkItems = cartItems.filter(item => item.id >= 120 && item.id <= 139);
        if (drinkItems.length > 0) {
            drinkItems.forEach(item => {
                xeChieuDiscount += (item.price * item.quantity * 0.05);
            });
            promoInfo += '🌆 Xế chiều nạp mood (đồ uống -5%)\n';
        }
    }
    autoDiscount += xeChieuDiscount;
    
    // Chương trình "cú đêm Việt mộ": 22:30 - 02:30, giảm 5% ăn vặt
    const cuDemStart = 22 * 60 + 30;   // 22:30
    const cuDemEnd = 2 * 60 + 30;      // 02:30 (ngày hôm sau)
    let cuDemDiscount = 0;
    
    const isCuDem = currentTime >= cuDemStart || currentTime <= cuDemEnd;
    
    if (isCuDem) {
        const snackItems = cartItems.filter(item => item.id >= 42 && item.id <= 61);
        if (snackItems.length > 0) {
            snackItems.forEach(item => {
                cuDemDiscount += (item.price * item.quantity * 0.05);
            });
            promoInfo += '🌙 Cú đêm Việt mộ (ăn vặt -5%)\n';
        }
    }
    autoDiscount += cuDemDiscount;
    
    // ===== KIỂM TRA ĐIỀU KIỆN MÃ GIẢM GIÁ =====
    const promo = validPromoCodes[appliedPromoCode];// Lấy thông tin mã giảm giá đã áp dụng
    if (promo) {
        let canApply = true;
        
        // Kiểm tra đơn hàng tối thiểu
        if (promo.minOrder && subtotal < promo.minOrder) {
            canApply = false;
            localStorage.removeItem('appliedPromoCode');
            appliedPromoCode = '';
            showToast(`Mã yêu cầu đơn tối thiểu ${formatMoney(promo.minOrder)}`, 'error');
        }
        
        // Kiểm tra lần đầu mua
        if (promo.firstTimeOnly && canApply) {
            const userPurchases = JSON.parse(localStorage.getItem('userPurchases') || '{}');// Lấy lịch sử mua hàng
            
            if (user && userPurchases[user.username] && userPurchases[user.username].length > 0) {// Đã mua hàng trước đó
                canApply = false;// Không thể áp dụng
                localStorage.removeItem('appliedPromoCode');
                appliedPromoCode = '';
                showToast('Mã CHAOBANMOI chỉ áp dụng cho lần đầu mua', 'error');
            }
        }
        
        if (canApply) {
            if (promo.type === 'percent') {
                discount = subtotal * (promo.value / 100);
                discountText = `-${promo.value}%`;
            } else if (promo.type === 'fixed') {
                discount = promo.value;
                discountText = `-${formatMoney(promo.value)}`;
            } else if (promo.type === 'shipping') {
                discount = Math.min(promo.value, shipping);
                discountText = 'FreeShip';
            }
        }
    }
    
    const total = subtotal + shipping - discount - autoDiscount;

// hiển thị giao diện
    const html = `
        <div class="header-modern">
            <div class="header-inner">
                <a href="/index.htm" class="brand">
                    <img src="/assets/logo.svg" alt="Logo" style="height: 40px;">
                </a>
                <a href="/page/category/product/product.htm" class="back-link">
                    <i class="fas fa-arrow-left"></i> 
                    <span>Tiếp tục mua hàng</span>
                </a>
            </div>
        </div>
        <div id="toast-container"></div>

        <form onsubmit="placeOrder(event)" class="checkout-container">
            <div class="grid-wrapper">
                <div class="card-modern">
                    <div class="card-header"><i class="fas fa-map-marker-alt"></i> Thông tin giao hàng</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Người nhận</label>
                            <input type="text" name="fullname" value="${user.username}" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="tel" name="phone" value="${user.phone || ''}" required placeholder="09xxxxxxxx">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" value="${user.email}" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Thành phố</label>
                                <input type="text" value="Hà Nội" readonly class="input-readonly">
                                <input type="hidden" name="city" value="Hà Nội">
                            </div>
                            <div class="form-group">
                                <label>Quận (Nội thành)</label>
                                <select name="district" required>
                                    <option value="">-- Chọn Quận --</option>
                                    <option value="Ba Đình">Ba Đình</option>
                                    <option value="Hoàn Kiếm">Hoàn Kiếm</option>
                                    <option value="Hai Bà Trưng">Hai Bà Trưng</option>
                                    <option value="Đống Đa">Đống Đa</option>
                                    <option value="Cầu Giấy">Cầu Giấy</option>
                                    <option value="Tây Hồ">Tây Hồ</option>
                                    <option value="Thanh Xuân">Thanh Xuân</option>
                                </select>
                                <div class="helper-text">Chú ý: Tiệm chỉ giao trong bán kính 5km</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Địa chỉ chi tiết</label>
                            <input type="text" name="address" placeholder="Số nhà, ngõ, tên tòa nhà..." required>
                        </div>
                        <div class="form-group" style="margin-bottom:0">
                            <label>Ghi chú cho tài xế</label>
                            <textarea name="note" rows="3" placeholder="Ví dụ: Gọi trước khi giao, để ở sảnh..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="card-modern">
                    <div class="card-header"><i class="fas fa-wallet"></i> Thanh toán</div>
                    <div class="card-body">
                        <div style="margin-bottom:24px;">
                            <label style="margin-bottom:12px;">Đơn vị vận chuyển</label>
                            <div class="payment-option active" style="cursor:default; background:#f9fafb; border-color:#e5e7eb; box-shadow:none;">
                                <div class="custom-radio" style="background:#4b5563; border-color:#4b5563;"></div>
                                <div class="option-info">
                                    <h4>Giao Hàng Hỏa Tốc</h4>
                                    <p>Đồng giá nội thành: ${formatMoney(shipping)}</p>
                                </div>
                            </div>
                        </div>

                        <label style="margin-bottom:12px;">Phương thức thanh toán</label>
                        <input type="hidden" id="selectedPaymentMethod" name="paymentMethod" value="cod">
                        
                        <div class="payment-option active" onclick="selectPaymentNew(this, 'cod')">
                            <div class="custom-radio"></div>
                            <div class="option-info">
                                <h4>Thanh toán tiền mặt (COD)</h4>
                                <p>Thanh toán khi nhận hàng</p>
                            </div>
                        </div>
                        <div class="payment-option" onclick="selectPaymentNew(this, 'banking')">
                            <div class="custom-radio"></div>
                            <div class="option-info">
                                <h4>Chuyển khoản Ngân hàng</h4>
                                <p>Quét mã VietQR (24/7)</p>
                            </div>
                            <div class="payment-details">
                                <div class="payment-info-text">
                                    Ngân hàng: <b>TECHCOMBANK</b><br>
                                    STK: <b>3023022006</b><br>
                                    Chủ TK: <b>NGUYEN MANH DUC</b>
                                </div>
                                <img src="/assets/techcombank.jpg" alt="QR Banking" class="qr-code-img">
                                <p class="payment-info-text"><i>Vui lòng nhập nội dung: [Tên KH] + [SĐT] đã đặt hàng</i></p>
                            </div>
                        </div>

                        <div class="payment-option" onclick="selectPaymentNew(this, 'momo')">
                            <div class="custom-radio"></div>
                            <div class="option-info">
                                <h4>Ví MoMo</h4>
                                <p>Thanh toán qua ứng dụng MoMo</p>
                            </div>
                            <div class="payment-details">
                                <img src="/assets/momo.jpg" alt="QR MoMo" class="qr-code-img">
                                <p class="payment-info-text"><i>Vui lòng nhập nội dung: [Tên KH] + [SĐT] đã đặt hàng</i></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-modern sticky-column">
                    <div class="card-header"><i class="fas fa-shopping-bag"></i> Đơn hàng (${cartItems.length})</div>
                    <div class="card-body">
                        <div class="cart-list" style="max-height: 350px; overflow-y: auto; margin-bottom: 10px;">
                            ${cartItems.map(item => `
                                <div class="cart-item">
                                    <div class="item-thumb"><img src="${item.image}" alt="${item.title}" style="width: 100%; height: 100%; object-fit: cover;"></div>
                                    <div class="item-details">
                                        <div class="item-name">${item.title}</div>
                                        ${item.selectedOptions && item.selectedOptions.length > 0 ? `
                                            <div class="item-options" style="font-size: 12px; color: #666; margin-top: 4px;">
                                                ${item.selectedOptions.map(opt => `<div>${opt.name}: ${opt.value}</div>`).join('')}
                                            </div>
                                        ` : ''}
                                        <div class="item-meta">SL: ${item.quantity}</div>
                                    </div>
                                    <div class="item-actions">
                                        <div class="item-price">${formatMoney(item.price * item.quantity)}</div>
                                        <button type="button" class="btn-delete" onclick="removeItem(${item.id})">
                                            <i class="fas fa-trash"></i> Xóa
                                        </button>
                                    </div>
                                </div>
                            `).join('')}
                        </div>

                        <div class="promo-section">
                            <div class="promo-group">
                                <input type="text" id="checkoutPromoInput" placeholder="Mã giảm giá" oninput="this.value = this.value.toUpperCase()">
                                <button type="button" onclick="applyPromoCode()">Áp dụng</button>
                            </div>
                            
                            ${promoInfo ? `
                                <div style="background: #fef3c7; border: 1px solid #fcd34d; border-radius: 8px; padding: 10px; margin-top: 10px; font-size: 12px; color: #92400e; line-height: 1.6;">
                                    <div style="font-weight: 600; margin-bottom: 5px; color: #d97706;">✨ Chương trình khuyến mãi</div>
                                    ${promoInfo.trim().split('\n').map(line => `<div>${line}</div>`).join('')}
                                </div>
                            ` : ''}
                            
                            ${appliedPromoCode ? `
                                <div class="applied-badge">
                                    <span><i class="fas fa-ticket-alt"></i> ${appliedPromoCode}</span>
                                    <i class="fas fa-times" style="cursor:pointer" onclick="removePromoCode()"></i>
                                </div>
                            ` : ''}
                        </div>

                        <div class="summary-line">
                            <span>Tạm tính</span>
                            <span>${formatMoney(subtotal)}</span>
                        </div>
                        <div class="summary-line">
                            <span>Phí vận chuyển</span>
                            <span>${formatMoney(shipping)}</span>
                        </div>
                        ${discount > 0 || autoDiscount > 0 ? `
                        <div class="summary-line" style="color:#059669; font-weight:500;">
                            <span>Giảm giá</span>
                            <span>-${formatMoney(discount + autoDiscount)}</span>
                        </div>` : ''}
                        
                        <div class="summary-line total">
                            <span>Tổng cộng</span>
                            <span>${formatMoney(total)}</span>
                        </div>

                        <button type="submit" class="btn-place-order">Đặt Hàng Ngay</button>
                    </div>
                </div>
            
            </div>
        </form>
        <div class="modal-overlay" id="successModal">
            <div class="modal-content">
                <div style="width:70px; height:70px; background:#d1fae5; border-radius:50%; margin:0 auto 20px; display:flex; align-items:center; justify-content:center;">
                    <i class="fas fa-check" style="font-size:35px; color:#059669;"></i>
                </div>
                <h2 style="font-size:24px; color:#1f2937; margin-bottom:10px;">Đặt hàng thành công!</h2>
                <p class="modal-body-text" style="color:#6b7280; margin-bottom:30px;"></p>
                <a href="/index.htm" style="display:block; width:100%; padding:14px; background:#1f2937; color:white; text-decoration:none; border-radius:12px; font-weight:600;">Về trang chủ</a>
            </div>
        </div>
    `;

// Gán HTML vào trang
    document.getElementById('app').innerHTML = html;
}

// Khởi tạo trang khi load
window.onload = function() {
    const user = checkAuth();
    if (user) renderCheckout(user);
};
