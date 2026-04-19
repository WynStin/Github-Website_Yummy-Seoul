<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khung Tìm Kiếm Yummy Seoul</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f1ea; /* Nền trung tính để nổi bật thiết kế */
        }

        .search-container {
            position: relative;
            width: 90%;
            max-width: 600px; /* Chiều rộng tối đa */
            margin: 0 auto;
            text-align: center;
        }

        /* --- Khung Tìm Kiếm Chính --- */
        .search-bar {
            background-color: #f9f1d0; /* Màu kem vàng */
            border-radius: 50px;
            padding: 10px 20px 10px 45px; /* Chừa chỗ cho icon */
            font-size: 16px;
            border: none;
            width: 100%;
            box-sizing: border-box; /* Đảm bảo padding không làm tăng chiều rộng */
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            position: relative;
            z-index: 2; /* Nằm trên các hình trang trí */
        }

        .search-bar:focus {
            outline: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        /* --- Biểu Tượng Kính Lúp --- */
        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            z-index: 3;
            /* Thay bằng icon thực tế nếu có */
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="%23a0a0a0" class="bi bi-search" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg>');
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
        }

        /* --- Các Yếu Tố Trang Trí Xung Quanh --- */
        .decoration {
            position: absolute;
            pointer-events: none; /* Không cho phép tương tác chuột */
            z-index: 1; /* Nằm dưới khung tìm kiếm */
        }

        /* Tháp N Seoul */
        .seoul-tower {
            width: 30px;
            height: 80px;
            background-color: #5c6bc0; /* Màu xanh nước biển nhạt */
            border-radius: 5px;
            top: -85px;
            left: 50%;
            transform: translateX(-50%);
            /* Thay bằng icon tháp thực tế nếu có */
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="32" viewBox="0 0 16 32"><rect x="6" y="0" width="4" height="28" fill="%235c6bc0"/><rect x="2" y="10" width="12" height="4" fill="%23e0e0e0"/></svg>');
            background-repeat: no-repeat;
            background-position: bottom center;
        }

        /* Các Bát Đồ Ăn (Gợi ý vị trí) */
        .food-bowl {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #8d6e63; /* Màu nâu đất của bát */
            border: 2px solid #5d4037;
            top: -65px;
            box-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .food-bowl.left { left: 10%; }
        .food-bowl.right { right: 10%; }

        /* Hoa Đào (Gợi ý vị trí) */
        .cherry-blossom {
            width: 35px;
            height: 35px;
            background-color: #ffcdd2; /* Màu hồng nhạt */
            border-radius: 50%;
            top: -40px;
            /* Thay bằng icon hoa đào thực tế */
        }

        .cherry-blossom.left-top { left: 5%; }
        .cherry-blossom.right-top { right: 5%; }
        .cherry-blossom.left-bottom { left: -10px; top: 10px; }
        .cherry-blossom.right-bottom { right: -10px; top: 10px; }

        /* Lá Cây (Gợi ý vị trí) */
        .leaf {
            width: 25px;
            height: 25px;
            background-color: #a5d6a7; /* Màu xanh lá nhạt */
            border-radius: 50% 0 50% 0;
            top: -25px;
        }

        .leaf.left-top { left: 0; }
        .leaf.right-top { right: 0; }

        /* Trái Tim (Gợi ý vị trí) */
        .heart {
            width: 15px;
            height: 15px;
            background-color: #ef9a9a; /* Màu hồng nhạt */
            transform: rotate(-45deg);
            top: -50px;
            /* Thay bằng icon trái tim thực tế */
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="%23ef9a9a" class="bi bi-heart-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/></svg>');
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
        }

        .heart.left { left: 15%; top: -55px; }
        .heart.right { right: 15%; top: -55px; }
        .heart.right-far { right: 30%; top: -70px; }

    </style>
</head>
<body>

<div class="search-container">
    <div class="decoration seoul-tower"></div>
    <div class="decoration food-bowl left"></div>
    <div class="decoration food-bowl right"></div>
    
    <div class="decoration cherry-blossom left-top"></div>
    <div class="decoration cherry-blossom right-top"></div>
    <div class="decoration cherry-blossom left-bottom"></div>
    <div class="decoration cherry-blossom right-bottom"></div>
    
    <div class="decoration leaf left-top"></div>
    <div class="decoration leaf right-top"></div>
    
    <div class="decoration heart left"></div>
    <div class="decoration heart right"></div>
    <div class="decoration heart right-far"></div>

    <i class="search-icon"></i>
    <input type="text" class="search-bar" placeholder="Tìm kiếm...">
</div>

</body>
</html>