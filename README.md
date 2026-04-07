# 🍱 Website Đặt Món Ăn Vặt Yummy Seoul - Nhóm 3 (NEU)

Dự án phát triển ứng dụng Web theo mô hình MVC, phục vụ việc đặt món và quản lý tiệm ăn Hàn Quốc trực tuyến. Website được tối ưu hóa cho trải nghiệm người dùng hiện đại và quản lý kho hàng thông minh.

---

## 📁 Cấu trúc thư mục Chi tiết (MVC Architecture)

### 1. ⚙️ Config/ (Cấu hình hệ thống)
- **db.php**: Chốt chặn kết nối CSDL MySQL bằng PDO. Đảm bảo tính bảo mật và hiệu suất truy vấn.

### 2. 🧠 Controllers/ (Điều hướng & Logic)
- **ProductController.php**: Xử lý logic hiển thị món ăn, lọc theo giá và danh mục.
- **CartController.php**: Quản lý thêm/sửa/xóa món ăn trong giỏ hàng (Session).
- **OrderController.php**: Xử lý đặt hàng và kiểm tra điều kiện **Hủy đơn hàng < 10 phút**.
- **UserController.php**: Điều hướng đăng ký, đăng nhập và phân quyền (Admin/User).

### 3. 📊 Models/ (Thao tác Cơ sở dữ liệu)
- **ProductModel.php**: Chứa các truy vấn SQL lấy **Top 10 món bán chạy**, tìm kiếm và phân trang.
- **CategoryModel.php**: Quản lý danh mục món ăn (Mỳ cay, Kimbap, Tokbokki...).
- **OrderModel.php**: Lưu trữ đơn hàng và cập nhật trạng thái đơn.
- **UserModel.php**: Kiểm tra thông tin người dùng và lưu lịch sử mua hàng.

### 4. 🎨 Views/ (Giao diện người dùng)
- **layout/**: 
    - `header.php`: Thanh điều hướng, Logo và ô tìm kiếm.
    - `footer.php`: Thông tin liên hệ và chính sách.
- **pages/**:
    - `home.php`: Trang chủ hiển thị banner khuyến mãi và các bộ sưu tập Top 10.
    - `menu.php`: Trang thực đơn đầy đủ có lọc giá và phân trang.
    - `product_detail.php`: Thông tin chi tiết món ăn.
    - `cart.php`: Giao diện giỏ hàng.
    - `checkout.php`: Form thanh toán và nhập địa chỉ.
- **admin/**:
    - `dashboard.php`: Thống kê doanh thu và đơn hàng.
    - `manage_products.php`: Giao diện CRUD (Thêm/Sửa/Xóa) món ăn.

### 5. 🌐 Public/ (Tài nguyên tĩnh)
- **css/**: Chứa `style.css` định dạng giao diện chuẩn Hàn Quốc.
- **img/**: Chứa ảnh món ăn (Kimbap, Tokbokki...) và Banner khuyến mãi.
- **js/**: Chứa các script xử lý hiệu ứng và thông báo (Alert).

### 6. 🗄️ SQL/ (Dữ liệu hệ thống)
- **yummy_seoul.sql**: File kịch bản chứa toàn bộ cấu trúc bảng và dữ liệu mẫu (món ăn, tài khoản, đơn hàng).

---

## 🚀 Tính năng nổi bật theo yêu cầu
- ✅ **Hệ thống Top 10**: Tự động lọc 10 món bán chạy nhất, mới nhất và xem nhiều nhất.
- ✅ **Tìm kiếm nâng cao**: Tìm theo tên và lọc theo khoảng giá linh hoạt.
- ✅ **Cơ chế Hủy đơn**: Khách hàng chỉ được phép hủy đơn trong vòng 10 phút kể từ khi đặt.
- ✅ **Quản trị Dashboard**: Thống kê doanh thu trực quan cho chủ cửa hàng.

---

## 🛠 Hướng dẫn cài đặt (Localhost - WarpServer)
1. **Clone dự án**: `git clone [URL_Github_Của_Bạn]` vào thư mục `www` của WarpServer.
2. **Import Database**: Tạo database `yummy_seoul` và import file `SQL/yummy_seoul.sql`.
3. **Cấu hình**: Chỉnh sửa thông số trong `Config/db.php` cho khớp với môi trường máy cá nhân.
4. **Khởi chạy**: Truy cập `localhost/Github-Website_Yummy-Seoul/index.php`.

---
*Dự án thuộc học phần Phát triển ứng dụng Web - National Economics University.*
