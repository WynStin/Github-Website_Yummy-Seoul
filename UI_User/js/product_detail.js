document.addEventListener('DOMContentLoaded', function () {
    const qtyInput = document.getElementById('quantityInput');
    const btnDecrease = document.getElementById('decreaseQty');
    const btnIncrease = document.getElementById('increaseQty');
    const btnAddToCart = document.getElementById('btnAddToCart');
    const btnBuyNow = document.getElementById('btnBuyNow');

    if (!qtyInput) return;

    // 1. Xử lý tăng giảm số lượng
    const maxStock = parseInt(qtyInput.getAttribute('max')) || 0;

    btnDecrease.onclick = () => {
        let val = parseInt(qtyInput.value);
        if (val > 1) qtyInput.value = val - 1;
    };

    btnIncrease.onclick = () => {
        let val = parseInt(qtyInput.value);
        if (val < maxStock) {
            qtyInput.value = val + 1;
        } else {
            alert('Số lượng vượt quá sản phẩm có sẵn trong kho!');
        }
    };

    // BỔ SUNG: Kiểm tra khi khách tự nhập số vào ô
    qtyInput.onchange = function () {
        let val = parseInt(this.value);
        if (isNaN(val) || val < 1) {
            alert('Số lượng phải lớn hơn 0!');
            this.value = 1;
        } else if (val > maxStock) {
            alert('Yummy Seoul chỉ còn ' + maxStock + ' sản phẩm!');
            this.value = maxStock;
        }
    };

    // 2. Logic thêm vào LocalStorage (Đồng bộ với cart.js)
    const handleCart = (button, isRedirect) => {
        const product = {
            id: button.getAttribute('data-id'),
            title: button.getAttribute('data-name'), // Đồng bộ key 'title' với cart.js
            price: parseInt(button.getAttribute('data-price')),
            image: button.getAttribute('data-image'),
            quantity: parseInt(qtyInput.value)
        };

        if (!product.id || isNaN(product.price)) {
            alert('Lỗi dữ liệu sản phẩm!');
            return;
        }

        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const existingItem = cart.find(item => item.id === product.id);

        if (existingItem) {
            existingItem.quantity += product.quantity;
        } else {
            cart.push(product);
        }

        localStorage.setItem('cart', JSON.stringify(cart));

        // Kích hoạt sự kiện để Header (nếu có) cập nhật số lượng ngay
        window.dispatchEvent(new Event('cartUpdated'));

        if (isRedirect) {
            window.location.href = 'cart.php';
        } else {
            if (typeof showNotification === 'function') {
                showNotification(`Đã thêm ${product.quantity} phần vào giỏ hàng!`, 'success');
            } else {
                alert('Đã thêm sản phẩm vào giỏ hàng!');
            }
        }
    };

    // 3. Gán sự kiện cho nút bấm
    if (btnAddToCart) btnAddToCart.onclick = function () { handleCart(this, false); };
    if (btnBuyNow) btnBuyNow.onclick = function () { handleCart(this, true); };
});