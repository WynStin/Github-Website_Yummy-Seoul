document.addEventListener('DOMContentLoaded', function () {
    const qtyInput = document.getElementById('quantityInput');
    const btnDecrease = document.getElementById('decreaseQty');
    const btnIncrease = document.getElementById('increaseQty');
    const btnAddToCart = document.getElementById('btnAddToCart');
    const btnBuyNow = document.getElementById('btnBuyNow');

    if (!qtyInput) return; // Nếu không tìm thấy sản phẩm, bỏ qua script

// Thay thế đoạn xử lý tăng giảm bằng đoạn này
btnDecrease.addEventListener('click', () => {
    let currentValue = parseInt(qtyInput.value);
    if (currentValue > 1) {
        qtyInput.value = currentValue - 1;
    }
});

btnIncrease.addEventListener('click', () => {
    let currentValue = parseInt(qtyInput.value);
    // Lấy giá trị max từ attribute của thẻ input (chính là so_luong_ton)
    let maxStock = parseInt(qtyInput.getAttribute('max')) || 99; 
    
    if (currentValue < maxStock) {
        qtyInput.value = currentValue + 1;
    } else {
        alert('Số lượng vượt quá sản phẩm có sẵn trong kho!');
    }
});

// Chặn người dùng gõ tay số quá lớn
qtyInput.addEventListener('change', () => {
    let val = parseInt(qtyInput.value);
    let maxStock = parseInt(qtyInput.getAttribute('max')) || 99;

    if (isNaN(val) || val < 1) qtyInput.value = 1;
    if (val > maxStock) {
        qtyInput.value = maxStock;
        alert('Chỉ còn ' + maxStock + ' sản phẩm trong kho!');
    }
});

    // Xử lý Thêm vào giỏ hàng
    const processCart = (productId, quantity, redirect = false) => {
        fetch('add_to_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ productId: productId, quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (redirect) {
                    window.location.href = 'cart.php'; // Chuyển sang trang giỏ hàng
                } else {
                    alert('Đã thêm ' + quantity + ' phần vào giỏ hàng!');
                    // Gọi hàm update UI số lượng giỏ hàng trên Header ở đây nếu có
                }
            } else {
                alert('Lỗi: ' + (data.message || 'Không thể thêm vào giỏ hàng'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi kết nối máy chủ.');
        });
    };

    if (btnAddToCart) {
        btnAddToCart.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            const qty = parseInt(qtyInput.value);
            processCart(productId, qty, false);
        });
    }

    if (btnBuyNow) {
        btnBuyNow.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            const qty = parseInt(qtyInput.value);
            processCart(productId, qty, true);
        });
    }
});