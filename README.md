# 🍱 Website Đặt Món Ăn Vặt Yummy Seoul - Nhóm 3 (NEU)

Chào mừng đến với dự án Website thương mại điện tử phục vụ đặt món và quản lý tiệm ăn vặt trực tuyến. Dự án được xây dựng dựa trên mô hình MVC và ngôn ngữ PHP.

## 📁 Cấu trúc thư mục (MVC Pattern)
Hệ thống được tổ chức chuyên nghiệp, tách biệt rõ ràng giữa logic, dữ liệu và giao diện:
- **Config/**: Chứa cấu hình kết nối CSDL (PDO).
- **Controllers/**: Tiếp nhận yêu cầu người dùng và điều hướng xử lý.
- **Models/**: Thao tác trực tiếp với CSDL MySQL (CRUD, thống kê).
- **Views/**: Hiển thị giao diện người dùng (HTML/PHP).
- **Public/**: Chứa tài nguyên tĩnh (CSS, JS, Hình ảnh món ăn).
- **SQL/**: Chứa file kịch bản thiết kế cơ sở dữ liệu.

## 🚀 Các tính năng nổi bật (Theo Checklist)

### 👤 Cho Khách hàng
- **Tìm kiếm thông minh**: Tìm món ăn theo tên và lọc nhanh theo khoảng giá.
- **Phân trang**: Danh sách món ăn được phân chia rõ ràng, tối ưu tốc độ tải trang.
- **Hệ thống Top 10**: 
  - Top 10 món ăn bán chạy nhất.
  - Top 10 món ăn được xem nhiều nhất.
  - Top 10 món ăn mới cập nhật.
- **Quản lý đơn hàng**: Cơ chế tự động cho phép **Hủy đơn hàng trong vòng 10 phút** kể từ khi đặt.

### 🔑 Cho Quản lý
- **Báo cáo doanh thu**: Thống kê doanh số và số lượng đơn hàng theo thời gian.
- **Quản trị hệ thống**: Quản lý danh mục, món ăn (cập nhật tồn kho), đơn hàng và người dùng.

## 🛠 Hướng dẫn cài đặt trên WarpServer
1. **Tải mã nguồn**: Clone hoặc download ZIP dự án về thư mục `C:\WarpServer\www\Yummy-Seoul`.
2. **Cài đặt CSDL**: 
   - Truy cập `localhost/phpmyadmin`.
   - Tạo database tên `yummy_seoul`.
   - Import file `/SQL/yummy_seoul.sql` vào database vừa tạo.
3. **Cấu hình**: Kiểm tra file `Config/db.php` để đảm bảo thông số kết nối đúng với server của bạn.
4. **Khởi chạy**: Truy cập `localhost/Yummy-Seoul/index.php`.

---
*Dự án thuộc học phần Phát triển ứng dụng Web - National Economics University.*
