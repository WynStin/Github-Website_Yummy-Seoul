let cart = [];
const SHIPPING_FEE = 20000;
let discountPercent = 0;
let appliedPromoCode = '';
let pendingConfirmAction = null; // Lưu hàm cần thực hiện sau khi xác nhận

// Danh sách mã giảm giá hợp lệ
const validPromoCodes = {
    'CHAOBANMOI': { type: 'percent', value: 10, desc: 'Giảm 10% (Lần đầu mua)', minOrder: 0, firstTimeOnly: true },
    'MUC10': { type: 'fixed', value: 10000, desc: 'Giảm 10k', minOrder: 99000 },
    'MUC20': { type: 'fixed', value: 20000, desc: 'Giảm 20k', minOrder: 169000 },
    'MUC30': { type: 'fixed', value: 30000, desc: 'Giảm 30k', minOrder: 249000 },
    'THITOTNHA': { type: 'shipping', value: 15000, desc: 'Giảm 15k phí vận chuyển' }
};

// ===== MODAL FUNCTIONS =====
// Hàm hiển thị modal thông báo
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

function confirmAction() {
    if (pendingConfirmAction && typeof pendingConfirmAction === 'function') {
        pendingConfirmAction();
    }
    closeConfirmModal();
}

// Đóng modal khi bấm ra ngoài
<<<<<<< HEAD
document.addEventListener('DOMContentLoaded', function() {
    const messageModal = document.getElementById('messageModal');
    const confirmModal = document.getElementById('confirmModal');
    
    if (messageModal) {
        messageModal.addEventListener('click', function(e) {
=======
document.addEventListener('DOMContentLoaded', function () {
    const messageModal = document.getElementById('messageModal');
    const confirmModal = document.getElementById('confirmModal');

    if (messageModal) {
        messageModal.addEventListener('click', function (e) {
>>>>>>> 87304a4299906a5e635c73f146a68b2bf396c6c9
            if (e.target === this) {
                closeMessageModal();
            }
        });
    }
<<<<<<< HEAD
    
    if (confirmModal) {
        confirmModal.addEventListener('click', function(e) {
=======

    if (confirmModal) {
        confirmModal.addEventListener('click', function (e) {
>>>>>>> 87304a4299906a5e635c73f146a68b2bf396c6c9
            if (e.target === this) {
                closeConfirmModal();
            }
        });
    }
});
// ===== CART FUNCTIONS =====
// Hàm định dạng giá tiền
function formatPrice(price) {
    return price.toLocaleString('vi-VN') + 'đ';
}
// Hàm tải giỏ hàng từ localStorage
function loadCart() {
    const savedCart = localStorage.getItem('cart');
    if (savedCart) {
        cart = JSON.parse(savedCart);
    }
<<<<<<< HEAD
    
=======

>>>>>>> 87304a4299906a5e635c73f146a68b2bf396c6c9
    // ✅ Load mã giảm giá nếu có
    const savedPromo = localStorage.getItem('appliedPromoCode');
    if (savedPromo) {
        appliedPromoCode = savedPromo;
        applyStoredPromo();
    }
<<<<<<< HEAD
    
=======

>>>>>>> 87304a4299906a5e635c73f146a68b2bf396c6c9
    renderCart();
    updateSummary();
}
// Hàm lưu giỏ hàng vào localStorage
function saveCart() {
    localStorage.setItem('cart', JSON.stringify(cart));
<<<<<<< HEAD
    
=======

>>>>>>> 87304a4299906a5e635c73f146a68b2bf396c6c9
    // ✅ Kích hoạt sự kiện để Header (header.js) cập nhật số lượng ngay lập tức
    window.dispatchEvent(new Event('cartUpdated'));
}
// Hàm hiển thị giỏ hàng
function renderCart() {
    const cartItems = document.getElementById('cartItems');
    const itemCount = document.getElementById('itemCount');
<<<<<<< HEAD
    
=======

>>>>>>> 87304a4299906a5e635c73f146a68b2bf396c6c9
    // Cập nhật số lượng loại sản phẩm trong giỏ
    itemCount.textContent = cart.length;

    if (cart.length === 0) {// Hiển thị thông báo giỏ hàng trống
        cartItems.innerHTML = `
            <div class="empty-cart">
                <div class="empty-cart-icon">🛒</div>
                <h3>Giỏ hàng trống</h3>
                <p>Hãy thêm sản phẩm vào giỏ hàng để tiếp tục mua sắm</p>
                <button class="shop-now-btn" onclick="window.location.href='/page/category/product/product.htm'">
                    Mua sắm ngay
                </button>
            </div>
        `;
        document.getElementById('checkoutBtn').disabled = true;
        return;
    }

    document.getElementById('checkoutBtn').disabled = false;

    cartItems.innerHTML = cart.map((item, index) => `
        <div class="cart-item">
            <div class="item-image" style="cursor: pointer;" onclick="goToProductDetail(${item.id})">
                <img src="${item.image || 'https://via.placeholder.com/120'}" alt="${item.title}">
            </div>
            <div class="item-details">
                <div class="item-header">
                    <div onclick="goToProductDetail(${item.id})" style="cursor: pointer;">
                        <div class="item-name">${item.title}</div>
                        
                        ${item.selectedOptions && Array.isArray(item.selectedOptions) && item.selectedOptions.length > 0 ? `
                            <div class="item-options-display" style="font-size: 12px; color: #666; margin-top: 4px; background: #f9f9f9; padding: 4px 8px; border-radius: 4px;">
                                ${item.selectedOptions.map(opt => `
                                    <div style="margin-bottom: 2px;">
                                        <i class="fa-solid fa-caret-right" style="color: #ff6b35; font-size: 10px;"></i> 
                                        ${opt.name}: <strong>${opt.value}</strong>
                                    </div>
                                `).join('')}
                            </div>
                        ` : ''}

                        <div class="item-price">${formatPrice(item.price)}</div>
                    </div>
                    <button class="delete-btn" onclick="removeItem(${index})" title="Xóa sản phẩm">
                        <i class="fa fa-trash-alt"></i>
                    </button>
                </div>
                
                <div class="item-footer">
                    <div class="quantity-control">
                        <button class="qty-btn" onclick="decreaseQty(${index})" ${item.quantity <= 1 ? 'disabled' : ''}>
                            −
                        </button>
                        <div class="qty-display">${item.quantity}</div>
                        <button class="qty-btn" onclick="increaseQty(${index})">
                            +
                        </button>
                    </div>
                    <div class="item-total">
                        Thành tiền: <span>${formatPrice(item.price * item.quantity)}</span>
                    </div>
                </div>
            </div>
        </div>
    `).join('');
}
// Hàm tăng số lượng sản phẩm
function increaseQty(index) {
    cart[index].quantity++;
    saveCart();
    renderCart();
    updateSummary();
}
// Hàm giảm số lượng sản phẩm
function decreaseQty(index) {
    if (cart[index].quantity > 1) {
        cart[index].quantity--;
        saveCart();
        renderCart();
        updateSummary();
    }
}
// Hàm xóa sản phẩm khỏi giỏ hàng
function removeItem(index) {
<<<<<<< HEAD
    showConfirmModal("Xác nhận xóa", "Bạn có chắc muốn xóa sản phẩm này?", function() {
=======
    showConfirmModal("Xác nhận xóa", "Bạn có chắc muốn xóa sản phẩm này?", function () {
>>>>>>> 87304a4299906a5e635c73f146a68b2bf396c6c9
        cart.splice(index, 1);// Xóa sản phẩm khỏi mảng
        saveCart();// Lưu lại giỏ hàng
        renderCart();// Hiển thị lại giỏ hàng
        updateSummary();// Cập nhật lại tổng tiền
        showNotification('Đã xóa sản phẩm khỏi giỏ hàng', 'success');// Hiển thị thông báo
    });
}
// Hàm cập nhật tổng tiền, phí vận chuyển, giảm giá
function updateSummary() {
    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);// Tính tổng tiền hàng
    const shipping = cart.length > 0 ? SHIPPING_FEE : 0;// Phí vận chuyển cố định nếu có sản phẩm trong giỏ
    // Tính giảm giá
    let discount = 0;
    let discountText = '';
    let autoDiscount = 0;
    let promoInfo = ''; // Lưu thông tin các chương trình tự động
<<<<<<< HEAD
    
    // ===== TỰ ĐỘNG GIẢM GIÁ NƯỚC LỌC =====
    // Giảm 50% nước lọc khi mua "Mỳ Trộn Không Khô" hoặc "Mỳ Cay Không Cay"
    const hasMiTronKhongKho = cart.some(item => 
        item.title && (item.title.includes('Mì trộn') || item.title.includes('Mỳ Trộn'))
    );
    const hasMiCayKhongCay = cart.some(item => 
        item.title && (item.title.includes('Mì cay') || item.title.includes('Mỳ Cay'))
    );
    const waterItem = cart.find(item => item.id === 125);
    
=======

    // ===== TỰ ĐỘNG GIẢM GIÁ NƯỚC LỌC =====
    // Giảm 50% nước lọc khi mua "Mỳ Trộn Không Khô" hoặc "Mỳ Cay Không Cay"
    const hasMiTronKhongKho = cart.some(item =>
        item.title && (item.title.includes('Mì trộn') || item.title.includes('Mỳ Trộn'))
    );
    const hasMiCayKhongCay = cart.some(item =>
        item.title && (item.title.includes('Mì cay') || item.title.includes('Mỳ Cay'))
    );
    const waterItem = cart.find(item => item.id === 125);

>>>>>>> 87304a4299906a5e635c73f146a68b2bf396c6c9
    if ((hasMiTronKhongKho || hasMiCayKhongCay) && waterItem) {
        autoDiscount += (waterItem.price * 0.5);
        promoInfo += 'Mỳ Trộn Không Khô - Mỳ Cay Không Cay\n';
    }
<<<<<<< HEAD
    
=======

>>>>>>> 87304a4299906a5e635c73f146a68b2bf396c6c9
    // ===== CHƯƠNG TRÌNH THEO GIỜ =====
    const now = new Date();// Lấy thời gian hiện tại
    const hours = now.getHours();// Lấy giờ hiện tại
    const minutes = now.getMinutes();// Lấy phút hiện tại
    const currentTime = hours * 60 + minutes; // Tính thành phút
<<<<<<< HEAD
    
=======

>>>>>>> 87304a4299906a5e635c73f146a68b2bf396c6c9
    // Chương trình "xế chiều nạp mood": 13:30 - 17:30, giảm 5% đồ uống
    const xeChieuStart = 13 * 60 + 30;  // 13:30
    const xeChieuEnd = 17 * 60 + 30;    // 17:30
    let xeChieuDiscount = 0;
<<<<<<< HEAD
    
=======

>>>>>>> 87304a4299906a5e635c73f146a68b2bf396c6c9
    if (currentTime >= xeChieuStart && currentTime <= xeChieuEnd) {// Kiểm tra có phải trong khung giờ xế chiều
        const drinkItems = cart.filter(item => item.id >= 120 && item.id <= 139);// Lọc đồ uống theo ID
        if (drinkItems.length > 0) {
            drinkItems.forEach(item => {
                xeChieuDiscount += (item.price * item.quantity * 0.05);
            });
            promoInfo += '🌆 Xế chiều nạp mood (đồ uống -5%)\n';
        }
    }
    autoDiscount += xeChieuDiscount;// Cộng vào tổng giảm giá tự động
<<<<<<< HEAD
    
=======

>>>>>>> 87304a4299906a5e635c73f146a68b2bf396c6c9
    // Chương trình "cú đêm Việt mộ": 22:30 - 02:30, giảm 5% ăn vặt
    const cuDemStart = 22 * 60 + 30;   // 22:30
    const cuDemEnd = 2 * 60 + 30;      // 02:30 (ngày hôm sau)
    let cuDemDiscount = 0;
<<<<<<< HEAD
    
    // Kiểm tra có phải trong khung giờ cú đêm
    const isCuDem = currentTime >= cuDemStart || currentTime <= cuDemEnd;
    
=======

    // Kiểm tra có phải trong khung giờ cú đêm
    const isCuDem = currentTime >= cuDemStart || currentTime <= cuDemEnd;

>>>>>>> 87304a4299906a5e635c73f146a68b2bf396c6c9
    if (isCuDem) {
        const snackItems = cart.filter(item => item.id >= 42 && item.id <= 61);
        if (snackItems.length > 0) {
            snackItems.forEach(item => {
                cuDemDiscount += (item.price * item.quantity * 0.05);
            });
            promoInfo += '🌙 Cú đêm Việt mộ (ăn vặt -5%)\n';
        }
    }
    autoDiscount += cuDemDiscount;
<<<<<<< HEAD
    
=======

>>>>>>> 87304a4299906a5e635c73f146a68b2bf396c6c9
    // ===== KIỂM TRA ĐIỀU KIỆN MÃ GIẢM GIÁ =====
    const promo = validPromoCodes[appliedPromoCode];// Lấy thông tin mã giảm giá nếu có
    if (promo) {// Nếu có mã giảm giá được áp dụng
        let canApply = true;//
        // Kiểm tra đơn hàng tối thiểu
        if (promo.minOrder && subtotal < promo.minOrder) {// Nếu đơn hàng không đủ điều kiện
            canApply = false;
            appliedPromoCode = '';
<<<<<<< HEAD
            showNotification(Mã yêu cầu đơn tối thiểu ${formatPrice(promo.minOrder)}, 'warning');// Thông báo lỗi
        }
        // Kiểm tra lần đầu mua
        if (promo.firstTimeOnly && canApply) {// Nếu mã chỉ áp dụng cho lần đầu mua
            const currentUser = JSON.parse(sessionStorage.getItem('currentUser') || localStorage.getItem('currentUser') || '{}');// Lấy thông tin người dùng hiện tại
            const userPurchases = JSON.parse(localStorage.getItem('userPurchases') || '{}');// Lấy lịch sử mua hàng của người dùng
            // Kiểm tra nếu người dùng đã từng mua hàng
            if (currentUser.username && userPurchases[currentUser.username] && userPurchases[currentUser.username].length > 0) {// Nếu đã mua hàng trước đó
                canApply = false;// Không thể áp dụng mã
                appliedPromoCode = '';
                showNotification('Mã CHAOBANMOI chỉ áp dụng cho lần đầu mua', 'warning');
            }
        }
        // Áp dụng mã giảm giá nếu đủ điều kiện
        if (canApply) {
            if (promo.type === 'percent') {// Giảm theo phần trăm
                discount = subtotal * (promo.value / 100);// Giảm theo phần trăm
                discountText = -${promo.value}%;// Hiển thị phần trăm giảm
            } else if (promo.type === 'fixed') {// Giảm theo số tiền cố định
                discount = promo.value;// Giảm số tiền cố định
                discountText = -${formatPrice(promo.value)};// Hiển thị số tiền giảm
            } else if (promo.type === 'shipping') {
                discount = Math.min(promo.value, shipping);
                discountText = Miễn phí ship ${formatPrice(promo.value)};
            }
        }
    }
    // Tính tổng cuối cùng
    const total = subtotal + shipping - discount - autoDiscount;// Tổng tiền cuối cùng sau khi trừ giảm giá và cộng phí vận chuyển

    document.getElementById('subtotal').textContent = formatPrice(subtotal);
    document.getElementById('shipping').textContent = formatPrice(shipping);
    
    // Hiển thị thông tin giảm giá
    let finalDiscountText = '';
    const totalDiscount = discount + autoDiscount;
    if (totalDiscount > 0) {
        finalDiscountText = -${formatPrice(totalDiscount)};// Hiển thị tổng giảm giá
    } else {
        finalDiscountText = '-0đ';// Nếu không có giảm giá
    }
    
    document.getElementById('discount').textContent = finalDiscountText;
    document.getElementById('total').textContent = formatPrice(total);
    
    // Hiển thị thông tin chương trình tự động
    updatePromoDisplay(promoInfo);
=======
            showNotification(Mã yêu cầu đơn tối thiểu ${ formatPrice(promo.minOrder)
        }, 'warning');// Thông báo lỗi
    }
    // Kiểm tra lần đầu mua
    if (promo.firstTimeOnly && canApply) {// Nếu mã chỉ áp dụng cho lần đầu mua
        const currentUser = JSON.parse(sessionStorage.getItem('currentUser') || localStorage.getItem('currentUser') || '{}');// Lấy thông tin người dùng hiện tại
        const userPurchases = JSON.parse(localStorage.getItem('userPurchases') || '{}');// Lấy lịch sử mua hàng của người dùng
        // Kiểm tra nếu người dùng đã từng mua hàng
        if (currentUser.username && userPurchases[currentUser.username] && userPurchases[currentUser.username].length > 0) {// Nếu đã mua hàng trước đó
            canApply = false;// Không thể áp dụng mã
            appliedPromoCode = '';
            showNotification('Mã CHAOBANMOI chỉ áp dụng cho lần đầu mua', 'warning');
        }
    }
    // Áp dụng mã giảm giá nếu đủ điều kiện
    if (canApply) {
        if (promo.type === 'percent') {// Giảm theo phần trăm
            discount = subtotal * (promo.value / 100);// Giảm theo phần trăm
            discountText = -${ promo.value }%;// Hiển thị phần trăm giảm
        } else if (promo.type === 'fixed') {// Giảm theo số tiền cố định
            discount = promo.value;// Giảm số tiền cố định
            discountText = -${ formatPrice(promo.value) };// Hiển thị số tiền giảm
        } else if (promo.type === 'shipping') {
            discount = Math.min(promo.value, shipping);
            discountText = Miễn phí ship ${ formatPrice(promo.value) };
        }
    }
}
// Tính tổng cuối cùng
const total = subtotal + shipping - discount - autoDiscount;// Tổng tiền cuối cùng sau khi trừ giảm giá và cộng phí vận chuyển

document.getElementById('subtotal').textContent = formatPrice(subtotal);
document.getElementById('shipping').textContent = formatPrice(shipping);

// Hiển thị thông tin giảm giá
let finalDiscountText = '';
const totalDiscount = discount + autoDiscount;
if (totalDiscount > 0) {
    finalDiscountText = -${ formatPrice(totalDiscount) };// Hiển thị tổng giảm giá
} else {
    finalDiscountText = '-0đ';// Nếu không có giảm giá
}

document.getElementById('discount').textContent = finalDiscountText;
document.getElementById('total').textContent = formatPrice(total);

// Hiển thị thông tin chương trình tự động
updatePromoDisplay(promoInfo);
>>>>>>> 87304a4299906a5e635c73f146a68b2bf396c6c9
}
// Hàm cập nhật hiển thị thông tin khuyến mãi
function updatePromoDisplay(promoInfo = '') {
    const promoDisplay = document.getElementById('promoDisplay');// Khung hiển thị khuyến mãi
    if (!promoDisplay) return;
<<<<<<< HEAD
    
    let html = '';
    
=======

    let html = '';

>>>>>>> 87304a4299906a5e635c73f146a68b2bf396c6c9
    // Hiển thị các chương trình tự động
    if (promoInfo) {
        html += `
            <div class="promo-tag auto-promo" style="background: #fef3c7; border: 1px solid #fcd34d;">
                <div class="promo-tag-content">
                    <div class="promo-tag-badge" style="background: #f59e0b; color: white;">✨</div>
                    <div class="promo-tag-info">
                        <span class="promo-tag-label" style="color: #d97706; font-weight: 600;">Chương trình khuyến mãi</span>
                        <div style="white-space: pre-line; font-size: 12px; color: #92400e;">
                            ${promoInfo.trim()}
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
<<<<<<< HEAD
    
=======

>>>>>>> 87304a4299906a5e635c73f146a68b2bf396c6c9
    // Hiển thị mã giảm giá người dùng áp dụng
    if (appliedPromoCode && validPromoCodes[appliedPromoCode]) {
        const promo = validPromoCodes[appliedPromoCode];
        html += `
            <div class="promo-tag">
                <div class="promo-tag-content">
                    <div class="promo-tag-badge">✓</div>
                    <div class="promo-tag-info">
                        <span class="promo-tag-label">Mã áp dụng</span>
                        <div>
                            <span class="promo-tag-code">${appliedPromoCode}</span>
                            <span class="promo-tag-desc"> • ${promo.desc}</span>
                        </div>
                    </div>
                </div>
                <button onclick="removePromoCode()" class="promo-remove-btn" title="Xóa mã giảm giá">
                    <i class="fa fa-times"></i>
                    <span>Xóa</span>
                </button>
            </div>
        `;
    }
<<<<<<< HEAD
    
=======

>>>>>>> 87304a4299906a5e635c73f146a68b2bf396c6c9
    promoDisplay.innerHTML = html;
}

// 🎨 TOAST NOTIFICATION SYSTEM
// 🎨 TOAST NOTIFICATION SYSTEM (Đã đồng bộ icon với detail)
// Hàm hiển thị thông báo dạng toast
function showNotification(message, type = 'info', duration = 3000) {
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'toast-container';
        document.body.appendChild(container);
    }

    // Thay đổi từ Emoji sang FontAwesome Icons
    const icons = {
        success: '<i class="fa-solid fa-circle-check"></i>',
        error: '<i class="fa-solid fa-circle-xmark"></i>',
        warning: '<i class="fa-solid fa-triangle-exclamation"></i>',
        info: '<i class="fa-solid fa-circle-info"></i>'
    };

    const toast = document.createElement('div');
<<<<<<< HEAD
    toast.className = toast ${type};
=======
    toast.className = toast ${ type };
>>>>>>> 87304a4299906a5e635c73f146a68b2bf396c6c9
    toast.innerHTML = `
        <span class="toast-icon">${icons[type] || icons.info}</span>
        <span class="toast-text">${message}</span>
        <button class="toast-close" onclick="this.parentElement.remove()">✕</button>
    `;

    container.appendChild(toast);

    // Hiệu ứng tự động đóng
    setTimeout(() => {
        if (toast.parentElement) {
            toast.classList.add('remove');
            setTimeout(() => toast.remove(), 300);
        }
    }, duration);
}
// Hàm áp dụng mã giảm giá
function applyPromo() {
    const promoInput = document.getElementById('promoInput');
    // Tự động chuyển thành chữ hoa
    promoInput.value = promoInput.value.toUpperCase();// Chuyển mã nhập thành chữ hoa
    const code = promoInput.value.trim();// Lấy mã nhập vào và loại bỏ khoảng trắng
<<<<<<< HEAD
// Kiểm tra mã nhập vào
=======
    // Kiểm tra mã nhập vào
>>>>>>> 87304a4299906a5e635c73f146a68b2bf396c6c9
    if (!code) {
        showNotification('Vui lòng nhập mã giảm giá!', 'warning');
        return;
    }
<<<<<<< HEAD
// Kiểm tra mã có hợp lệ không
=======
    // Kiểm tra mã có hợp lệ không
>>>>>>> 87304a4299906a5e635c73f146a68b2bf396c6c9
    const promo = validPromoCodes[code];
    if (!promo) {
        showNotification('Mã giảm giá không hợp lệ', 'error');
        promoInput.value = '';
        return;
    }
<<<<<<< HEAD
    
    // ===== KIỂM TRA ĐIỀU KIỆN =====
    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);// Tính tổng tiền hàng
    
    // Kiểm tra đơn hàng tối thiểu
    if (promo.minOrder && subtotal < promo.minOrder) {
        showNotification(Mã "${code}" yêu cầu đơn tối thiểu ${formatPrice(promo.minOrder)}. Đơn hiện tại: ${formatPrice(subtotal)}, 'warning');
        promoInput.value = '';
        return;
    }
    
    // Kiểm tra lần đầu mua
    if (promo.firstTimeOnly) {
        const currentUser = JSON.parse(sessionStorage.getItem('currentUser') || localStorage.getItem('currentUser') || '{}');
        const userPurchases = JSON.parse(localStorage.getItem('userPurchases') || '{}');
        
        if (currentUser.username && userPurchases[currentUser.username] && userPurchases[currentUser.username].length > 0) {
            showNotification('Mã CHAOBANMOI chỉ áp dụng cho lần đầu mua', 'warning');
            promoInput.value = '';
            return;
        }
    }
    
    // Mã hợp lệ - áp dụng
    appliedPromoCode = code;
    localStorage.setItem('appliedPromoCode', code);// Lưu mã vào localStorage
    showNotification(Áp dụng mã thành công! ${promo.desc}, 'success');// Thông báo thành công
    promoInput.value = '';
    updateSummary();
=======

    // ===== KIỂM TRA ĐIỀU KIỆN =====
    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);// Tính tổng tiền hàng

    // Kiểm tra đơn hàng tối thiểu
    if (promo.minOrder && subtotal < promo.minOrder) {
        showNotification(Mã "${code}" yêu cầu đơn tối thiểu ${ formatPrice(promo.minOrder)
    }. Đơn hiện tại: ${ formatPrice(subtotal) }, 'warning');
    promoInput.value = '';
    return;
}

// Kiểm tra lần đầu mua
if (promo.firstTimeOnly) {
    const currentUser = JSON.parse(sessionStorage.getItem('currentUser') || localStorage.getItem('currentUser') || '{}');
    const userPurchases = JSON.parse(localStorage.getItem('userPurchases') || '{}');

    if (currentUser.username && userPurchases[currentUser.username] && userPurchases[currentUser.username].length > 0) {
        showNotification('Mã CHAOBANMOI chỉ áp dụng cho lần đầu mua', 'warning');
        promoInput.value = '';
        return;
    }
}

// Mã hợp lệ - áp dụng
appliedPromoCode = code;
localStorage.setItem('appliedPromoCode', code);// Lưu mã vào localStorage
showNotification(Áp dụng mã thành công! ${ promo.desc }, 'success');// Thông báo thành công
promoInput.value = '';
updateSummary();
>>>>>>> 87304a4299906a5e635c73f146a68b2bf396c6c9
}
// Hàm áp dụng mã giảm giá đã lưu
function applyStoredPromo() {
    if (appliedPromoCode && validPromoCodes[appliedPromoCode]) {
        console.log('✅ Mã giảm giá đã áp dụng:', appliedPromoCode);
    }
}
// Hàm xóa mã giảm giá
function removePromoCode() {
    appliedPromoCode = '';
    localStorage.removeItem('appliedPromoCode');
    showNotification('Đã xóa mã giảm giá', 'info');
    updateSummary();
}
// Hàm điều hướng tới trang thanh toán
function checkout() {
    if (cart.length === 0) {
        showMessageModal("Giỏ hàng trống", "Giỏ hàng của bạn đang trống. Vui lòng thêm sản phẩm trước khi thanh toán!");
        return;
    }
<<<<<<< HEAD
    
=======

>>>>>>> 87304a4299906a5e635c73f146a68b2bf396c6c9
    window.location.href = '/page/checkout/checkout.htm';
}

// Hàm điều hướng tới trang chi tiết sản phẩm
function goToProductDetail(productId) {
<<<<<<< HEAD
    window.location.href = /page/category/detail/detail.htm?id=${productId};
=======
    window.location.href = /page/category / detail / detail.htm ? id = ${ productId };
>>>>>>> 87304a4299906a5e635c73f146a68b2bf396c6c9
}

loadCart();

// Lắng nghe sự kiện cập nhật giỏ từ các trang khác (VD: random picker, detail page, etc)
<<<<<<< HEAD
window.addEventListener('cartUpdated', function() {
=======
window.addEventListener('cartUpdated', function () {
>>>>>>> 87304a4299906a5e635c73f146a68b2bf396c6c9
    loadCart();
});
via.placeholder.com