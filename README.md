# 🍱 Dự án: Website Đặt Món Ăn Vặt Yummy Seoul - Nhóm 3 (NEU)

Dự án xây dựng hệ thống đặt món trực tuyến theo mô hình MVC (Model-View-Controller). 
Website được thiết kế hiện đại, tối ưu trải nghiệm người dùng dựa trên mẫu giao diện Tiệm ăn vặt Yummy Seoul.

---

## 📁 Cấu trúc Thư mục & Danh sách File Chi tiết

### 1. 📂 Config/ (Cấu hình)
- **db.php**: Kết nối Cơ sở dữ liệu bằng PDO (Đảm bảo an toàn, bảo mật).

### 2. 📂 Models/ (Xử lý dữ liệu SQL)
- **ProductModel.php**: Truy vấn danh sách món ăn, Top 10 sản phẩm, tìm kiếm.
- **CategoryModel.php**: Quản lý các danh mục (Mỳ cay, Kimbap, Tokbokki...).
- **UserModel.php**: Xử lý thông tin khách hàng và phân quyền Admin.
- **OrderModel.php**: Lưu đơn hàng và xử lý logic **Hủy đơn hàng < 10 phút**.

### 3. 📂 Controllers/ (Điều hướng & Logic)
- **ProductController.php**: Điều phối dữ liệu từ Model ra các trang hiển thị món ăn.
- **CartController.php**: Quản lý thêm/sửa/xóa sản phẩm trong giỏ hàng.
- **OrderController.php**: Xử lý quy trình thanh toán và lịch sử mua hàng.

### 4. 📂 Views/ (Giao diện hiển thị - Khớp yêu cầu Giảng viên)
#### 🌐 Nhóm trang Người dùng (Front-end)
- **layout/**: `header.php` (Thanh menu/search), `footer.php` (Thông tin chân trang).
- **pages/home.php**: Trang chủ (Banner, Món Hot, Món mới).
- **pages/menu.php**: Danh sách toàn bộ món ăn (Lọc danh mục & Phân trang).
- **pages/product_detail.php**: Chi tiết món ăn (Giá, Mô tả, Nút đặt món).
- **pages/cart.php**: Giỏ hàng của khách.
- **pages/checkout.php**: Form điền thông tin và đặt hàng.
- **pages/login.php** & **register.php**: Đăng nhập/Đăng ký.
- **pages/order_history.php**: Lịch sử đơn (Có tính năng **Hủy đơn hàng**).

#### ⚙️ Nhóm trang Quản trị (Admin)
- **admin/dashboard.php**: Thống kê doanh thu và đơn hàng.
- **admin/admin_products.php**: Quản lý danh sách món ăn (Thêm/Sửa/Xóa).
- **admin/admin_categories.php**: Quản lý danh mục món ăn.
- **admin/admin_orders.php**: Quản lý trạng thái các đơn hàng từ khách.
- **admin/admin_users.php**: Quản lý danh sách thành viên.

### 5. 📂 Public/ (Tài nguyên tĩnh)
- **css/style.css**: Định dạng giao diện chuẩn Hàn Quốc.
- **img/**: Chứa ảnh món ăn và banner quảng cáo.
- **js/main.js**: Xử lý hiệu ứng và logic đếm ngược 10 phút hủy đơn.

### 6. 📂 SQL/
- **yummy_seoul.sql**: Chứa full cấu trúc bảng và dữ liệu mẫu của dự án.

---

## 🗺️ Lộ trình triển khai (Roadmap)

- [ ] **Giai đoạn 1**: Thiết kế Database chuẩn và Import dữ liệu mẫu vào `yummy_seoul.sql`.
- [ ] **Giai đoạn 2**: Xây dựng Layout (`header`, `footer`) và Trang chủ (`home.php`) dựa trên mẫu Netlify.
- [ ] **Giai đoạn 3**: Hoàn thiện logic Giỏ hàng và Đặt hàng.
- [ ] **Giai đoạn 4**: Cài đặt tính năng nâng cao: **Hủy đơn hàng trong 10 phút** và **Phân trang**.
- [ ] **Giai đoạn 5**: Kiểm thử (Testing) trên Localhost và chuẩn bị báo cáo.

---
*Dự án thuộc học phần Phát triển ứng dụng Web - National Economics University.*
