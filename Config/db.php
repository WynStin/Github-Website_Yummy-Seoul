<?php
// 1. Khai báo các thông số kết nối
$host = 'localhost';
$db   = 'yummy_seoul';
$user = 'root';
$pass = ''; // Mặc định của XAMPP/WarpServer là trống
$charset = 'utf8mb4';

// 2. Thiết lập chuỗi DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// 3. Các tùy chọn cấu hình cho PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // 4. Tạo đối tượng kết nối PDO
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // 5. Xử lý lỗi nếu kết nối thất bại
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>