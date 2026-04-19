<!DOCTYPE html>
<html lang="vi">
<<<<<<< HEAD
=======

>>>>>>> 87304a4299906a5e635c73f146a68b2bf396c6c9
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng | Yummy Seoul</title>
    <link rel="icon" type="image/x-icon" href="/Github-Website_Yummy-Seoul/Public/img/homepage/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Asap:wght@400;600;700&family=Dancing+Script:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<<<<<<< HEAD
    
    <link rel="stylesheet" href="/Github-Website_Yummy-Seoul/Public/css/home.css">
    <link rel="stylesheet" href="/Github-Website_Yummy-Seoul/Public/css/cart.css">
</head>
<body>

    <?php 
        $page = 'cart'; 
        include 'layout/header.php'; 
=======

    <link rel="stylesheet" href="/Github-Website_Yummy-Seoul/Public/css/home.css">
    <link rel="stylesheet" href="/Github-Website_Yummy-Seoul/Public/css/cart.css">
</head>

<body>

    <?php
    $page = 'cart';
    include 'layout/header.php';
>>>>>>> 87304a4299906a5e635c73f146a68b2bf396c6c9
    ?>

    <main class="cart-page-container">
        <div class="cart-decorations">
            <div class="decor-item blossom-1"></div>
            <div class="decor-item leaf-1"></div>
            <div class="decor-item heart-1"></div>
            <div class="decor-item blossom-2"></div>
        </div>

        <div class="container-custom">
            <div class="cart-header fade-up">
                <a href="home.php" class="back-to-shop"><i class="fa-solid fa-arrow-left"></i> Tiếp tục mua sắm</a>
                <h1 class="cart-title">Giỏ hàng của bạn</h1>
                <div class="cart-subtitle-handwritten">Đừng để bụng đói khi về nhà nhé!</div>
            </div>

            <div class="cart-main-layout">
                <div class="cart-items-column fade-up delay-1">
                    <div class="cart-table-header">
                        <span>Sản phẩm</span>
                        <span>Số lượng</span>
                        <span>Tổng</span>
                    </div>

                    <div id="cartItemsList">
                        <div class="cart-item-row">
                            <div class="item-info">
                                <div class="item-img">
                                    <img src="/Github-Website_Yummy-Seoul/Public/img/monan/combobulgogi.jpg" alt="Cơm Bulgogi">
                                </div>
                                <div class="item-details">
                                    <h3>Cơm bò xào Bulgogi</h3>
                                    <p class="unit-price">95.000đ</p>
                                    <button class="remove-item"><i class="fa-solid fa-trash-can"></i> Xóa</button>
                                </div>
                            </div>
                            <div class="item-quantity">
                                <div class="quantity-control">
                                    <button>-</button>
                                    <input type="number" value="1" min="1">
                                    <button>+</button>
                                </div>
                            </div>
                            <div class="item-total">95.000đ</div>
                        </div>

                        <div class="cart-item-row">
                            <div class="item-info">
                                <div class="item-img">
                                    <img src="/Github-Website_Yummy-Seoul/Public/img/monan/coca.jpg" alt="Coca">
                                </div>
                                <div class="item-details">
                                    <h3>Coca Cola lon</h3>
                                    <p class="unit-price">20.000đ</p>
                                    <button class="remove-item"><i class="fa-solid fa-trash-can"></i> Xóa</button>
                                </div>
                            </div>
                            <div class="item-quantity">
                                <div class="quantity-control">
                                    <button>-</button>
                                    <input type="number" value="2" min="1">
                                    <button>+</button>
                                </div>
                            </div>
                            <div class="item-total">40.000đ</div>
                        </div>
                    </div>
                </div>

                <div class="cart-summary-column fade-up delay-2">
                    <div class="summary-box">
                        <h2 class="summary-title">Hóa đơn của bạn</h2>
<<<<<<< HEAD
                        
=======

>>>>>>> 87304a4299906a5e635c73f146a68b2bf396c6c9
                        <div class="summary-row">
                            <span>Tạm tính</span>
                            <span id="subtotal">135.000đ</span>
                        </div>
                        <div class="summary-row">
                            <span>Vận chuyển</span>
                            <span id="shipping">15.000đ</span>
                        </div>
                        <div class="summary-row discount">
                            <span>Giảm giá</span>
                            <span id="discount">-0đ</span>
                        </div>

                        <div class="promo-box">
                            <input type="text" placeholder="Nhập mã ưu đãi...">
                            <button>Áp dụng</button>
                        </div>

                        <div class="summary-divider"></div>
<<<<<<< HEAD
                        
=======

>>>>>>> 87304a4299906a5e635c73f146a68b2bf396c6c9
                        <div class="summary-row total">
                            <span>Tổng cộng</span>
                            <span id="total">150.000đ</span>
                        </div>

                        <button class="btn-checkout">Tiến hành thanh toán</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include 'layout/footer.php'; ?>

    <script src="/Github-Website_Yummy-Seoul/Public/js/home.js"></script>
    <script src="/Github-Website_Yummy-Seoul/Public/js/cart.js"></script>
</body>
<<<<<<< HEAD
=======

>>>>>>> 87304a4299906a5e635c73f146a68b2bf396c6c9
</html>