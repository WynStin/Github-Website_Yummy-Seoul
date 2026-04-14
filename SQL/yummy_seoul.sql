SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- 1. Bảng Danh mục món ăn (ĐÃ SỬA DẤU NHÁY)
DROP TABLE IF EXISTS `danh_muc_mon_an`;
CREATE TABLE `danh_muc_mon_an` (
  `id_danh_muc` int NOT NULL AUTO_INCREMENT,
  `ten_danh_muc` varchar(100) NOT NULL,
  `mo_ta` text,
  PRIMARY KEY (`id_danh_muc`),
  UNIQUE KEY `ten_danh_muc` (`ten_danh_muc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Bảng Khuyến mãi
DROP TABLE IF EXISTS `khuyen_mai`;
CREATE TABLE `khuyen_mai` (
  `id_khuyen_mai` int NOT NULL AUTO_INCREMENT,
  `ma_khuyen_mai` varchar(20) NOT NULL,
  `phan_tram_giam` int DEFAULT NULL,
  `giam_toi_da` decimal(10,2) DEFAULT NULL,
  `ngay_het_han` datetime NOT NULL,
  `co_freeship` enum('Có','Không') DEFAULT 'Không',
  `so_luong` int NOT NULL,
  `don_hang_min` decimal(10,2) DEFAULT '0.00',
  `trang_thai` varchar(20) DEFAULT 'Hiệu lực',
  PRIMARY KEY (`id_khuyen_mai`),
  UNIQUE KEY `ma_khuyen_mai` (`ma_khuyen_mai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Bảng Người dùng
DROP TABLE IF EXISTS `nguoi_dung`;
CREATE TABLE `nguoi_dung` (
  `id_nguoi_dung` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `ho_ten` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `so_dien_thoai` varchar(15) NOT NULL,
  `dia_chi_mac_dinh` varchar(255) DEFAULT NULL,
  `vai_tro` enum('Khách hàng','Quản lý') NOT NULL DEFAULT 'Khách hàng',
  `trang_thai` enum('Hoạt động','Bị khóa') DEFAULT 'Hoạt động',
  `ngay_tao` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_nguoi_dung`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `so_dien_thoai` (`so_dien_thoai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Bảng Món ăn
DROP TABLE IF EXISTS `mon_an`;
CREATE TABLE `mon_an` (
  `id_mon_an` int NOT NULL AUTO_INCREMENT,
  `id_danh_muc` int DEFAULT NULL,
  `ten_mon` varchar(100) NOT NULL,
  `mo_ta` text,
  `gia_ban` decimal(10,2) NOT NULL,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `trang_thai` enum('Còn hàng','Hết hàng') DEFAULT 'Còn hàng',
  `so_luong_ton` int NOT NULL,
  `so_luot_xem` int DEFAULT '0',
  `so_luong_da_ban` int DEFAULT '0',
  `ngay_tao` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_mon_an`),
  KEY `id_danh_muc` (`id_danh_muc`),
  CONSTRAINT `fk_mon_an_danh_muc` FOREIGN KEY (`id_danh_muc`) REFERENCES `danh_muc_mon_an` (`id_danh_muc`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Bảng Đơn hàng
DROP TABLE IF EXISTS `don_hang`;
CREATE TABLE `don_hang` (
  `id_don_hang` int NOT NULL AUTO_INCREMENT,
  `id_khach_hang` int NOT NULL,
  `id_khuyen_mai` int DEFAULT NULL,
  `ngay_tao_don` datetime DEFAULT CURRENT_TIMESTAMP,
  `tien_ship` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tong_gia` decimal(10,2) NOT NULL,
  `trang_thai` enum('Đã đặt','Đang xử lý','Đang giao','Hoàn thành','Đã hủy') DEFAULT 'Đã đặt',
  `dia_chi_giao_hang` varchar(255) NOT NULL,
  `pt_thanh_toan` varchar(50) NOT NULL,
  `ghi_chu` text,
  PRIMARY KEY (`id_don_hang`),
  KEY `id_khach_hang` (`id_khach_hang`),
  KEY `id_khuyen_mai` (`id_khuyen_mai`),
  CONSTRAINT `fk_don_hang_khach` FOREIGN KEY (`id_khach_hang`) REFERENCES `nguoi_dung` (`id_nguoi_dung`),
  CONSTRAINT `fk_don_hang_km` FOREIGN KEY (`id_khuyen_mai`) REFERENCES `khuyen_mai` (`id_khuyen_mai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Bảng Chi tiết đơn hàng
DROP TABLE IF EXISTS `chi_tiet_don_hang`;
CREATE TABLE `chi_tiet_don_hang` (
  `id_chi_tiet` int NOT NULL AUTO_INCREMENT,
  `id_don_hang` int NOT NULL,
  `id_mon_an` int NOT NULL,
  `so_luong` int NOT NULL,
  `don_gia` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_chi_tiet`),
  KEY `id_don_hang` (`id_don_hang`),
  KEY `id_mon_an` (`id_mon_an`),
  CONSTRAINT `fk_ctdh_don_hang` FOREIGN KEY (`id_don_hang`) REFERENCES `don_hang` (`id_don_hang`) ON DELETE CASCADE,
  CONSTRAINT `fk_ctdh_mon_an` FOREIGN KEY (`id_mon_an`) REFERENCES `mon_an` (`id_mon_an`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Bảng Giỏ hàng
DROP TABLE IF EXISTS `gio_hang`;
CREATE TABLE `gio_hang` (
  `id_gio_hang` int NOT NULL AUTO_INCREMENT,
  `id_khach_hang` int NOT NULL,
  `id_khuyen_mai` int DEFAULT NULL,
  `tien_ship` decimal(10,2) DEFAULT '0.00',
  `tong_gia` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id_gio_hang`),
  UNIQUE KEY `id_khach_hang` (`id_khach_hang`),
  CONSTRAINT `fk_gio_hang_khach` FOREIGN KEY (`id_khach_hang`) REFERENCES `nguoi_dung` (`id_nguoi_dung`) ON DELETE CASCADE,
  CONSTRAINT `fk_gio_hang_km` FOREIGN KEY (`id_khuyen_mai`) REFERENCES `khuyen_mai` (`id_khuyen_mai`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Bảng Chi tiết giỏ hàng
DROP TABLE IF EXISTS `chi_tiet_gio_hang`;
CREATE TABLE `chi_tiet_gio_hang` (
  `id_chi_tiet` int NOT NULL AUTO_INCREMENT,
  `id_gio_hang` int NOT NULL,
  `id_mon_an` int NOT NULL,
  `so_luong` int NOT NULL,
  `don_gia` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_chi_tiet`),
  KEY `id_gio_hang` (`id_gio_hang`),
  KEY `id_mon_an` (`id_mon_an`),
  CONSTRAINT `fk_ctgh_gio_hang` FOREIGN KEY (`id_gio_hang`) REFERENCES `gio_hang` (`id_gio_hang`) ON DELETE CASCADE,
  CONSTRAINT `fk_ctgh_mon_an` FOREIGN KEY (`id_mon_an`) REFERENCES `mon_an` (`id_mon_an`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

COMMIT;

-- Làm sạch dữ liệu cũ trước khi chèn (tùy chọn)
DELETE FROM `mon_an`;
DELETE FROM `danh_muc_mon_an`;

-- 1. CHÈN DANH MỤC
INSERT INTO `danh_muc_mon_an` (`id_danh_muc`, `ten_danh_muc`, `mo_ta`) VALUES
(1, 'Cơm (Rice)', 'Các món cơm trộn, cơm cuộn và cơm phần truyền thống'),
(2, 'Gà (Chicken)', 'Gà rán và gà sốt đặc trưng kiểu Hàn Quốc'),
(3, 'Mì (Noodles)', 'Các loại mì đen, mì lạnh và mì cay Ramen'),
(4, 'Lẩu & Súp (Stew)', 'Các món canh nóng hổi và lẩu dùng kèm cơm'),
(5, 'Đồ ăn nhẹ (Snacks)', 'Món ăn đường phố phổ biến như Tokbokki, Chả cá'),
(6, 'Đồ uống (Drinks)', 'Rượu Soju, nước gạo và các loại giải khát');

-- 2. CHÈN MÓN ĂN (Mỗi danh mục 5 món)
INSERT INTO `mon_an` (`id_danh_muc`, `ten_mon`, `mo_ta`, `gia_ban`, `so_luong_ton`) VALUES
-- DANH MỤC 1: CƠM
(1, 'Cơm trộn Bibimbap', 'Cơm với 8 loại rau củ, thịt bò và trứng chần', 85000, 100),
(1, 'Kimbap truyền thống', 'Cơm cuộn rong biển nhân xúc xích và rau củ', 50000, 80),
(1, 'Cơm chiên Kimchi', 'Cơm chiên cay với kim chi cải thảo và trứng ốp la', 70000, 100),
(1, 'Cơm bò xào Bulgogi', 'Cơm trắng ăn kèm thịt bò xào sốt mặn ngọt', 95000, 50),
(1, 'Kimbap chiên xù', 'Cơm cuộn tẩm bột chiên giòn rụm bên ngoài', 65000, 40),

-- DANH MỤC 2: GÀ
(2, 'Gà rán sốt cay', 'Gà chiên giòn rụm với sốt Yangnyeom truyền thống', 155000, 30),
(2, 'Gà sốt tương tỏi', 'Gà chiên vị mặn ngọt đậm đà mùi tỏi phi', 155000, 30),
(2, 'Gà không xương chiên', 'Gà fillet tẩm bột chiên giòn dễ ăn cho trẻ em', 120000, 45),
(2, 'Gà rán sốt phô mai', 'Gà chiên giòn đẫm sốt phô mai tan chảy', 165000, 25),
(2, 'Cánh gà chiên nước mắm', 'Cánh gà chiên giòn đảo sốt nước mắm kiểu Hàn', 140000, 35),

-- DANH MỤC 3: MÌ
(3, 'Mì tương đen Jajangmyeon', 'Mì trộn sốt đậu đen và thịt heo thái lựu', 75000, 60),
(3, 'Mì lạnh Naengmyeon', 'Mì sợi nhỏ dùng với nước dùng đá lạnh thanh mát', 90000, 20),
(3, 'Mì cay Ramen hải sản', 'Mì gói Hàn Quốc nấu cay với tôm và mực', 65000, 100),
(3, 'Mì trộn cay Bibim-guksu', 'Mì sợi nhỏ trộn sốt ớt cay và rau sống', 70000, 50),
(3, 'Mì Udon hải sản', 'Mì sợi to kiểu Hàn nấu nước dùng hải sản thanh', 110000, 35),

-- DANH MỤC 4: LẨU & SÚP
(4, 'Canh Kimchi đậu phụ', 'Súp kim chi nấu cùng thịt ba chỉ béo ngậy', 95000, 40),
(4, 'Canh rong biển', 'Món canh truyền thống thanh đạm, tốt sức khỏe', 60000, 50),
(4, 'Lẩu quân đội Budae Jjigae', 'Lẩu xúc xích, đậu phụ, spam và mì', 250000, 15),
(4, 'Canh đậu phụ non Soondubu', 'Canh đậu phụ siêu mềm với hải sản và trứng', 85000, 40),
(4, 'Súp sườn bò Galbitang', 'Nước dùng trong, sườn bò hầm mềm ngọt', 150000, 20),

-- DANH MỤC 5: ĐỒ ĂN NHẸ
(5, 'Tokbokki truyền thống', 'Bánh gạo dẻo nấu trong sốt ớt cay ngọt', 45000, 150),
(5, 'Chả cá Odeng', 'Xiên chả cá nóng hổi kèm nước dùng súp', 15000, 200),
(5, 'Mandu chiên', 'Sủi cảo nhân thịt và rau củ chiên giòn', 40000, 80),
(5, 'Khoai tây chiên mật ong', 'Khoai tây giòn tẩm bơ và mật ong ngọt ngào', 45000, 60),
(5, 'Bánh xèo hải sản Pajeon', 'Bánh xèo nhân hành lá và hải sản áp chảo', 120000, 30),

-- DANH MỤC 6: ĐỒ UỐNG
(6, 'Rượu Soju vị Đào', 'Rượu trái cây nồng độ nhẹ dễ uống', 65000, 100),
(6, 'Nước gạo rang Woongjin', 'Thức uống truyền thống vị thơm, ngọt thanh', 30000, 150),
(6, 'Coca Cola lon', 'Nước giải khát có gas 330ml', 20000, 200),
(6, 'Trà sữa khoai môn', 'Trà sữa vị khoai môn đặc trưng', 45000, 100),
(6, 'Nước ép lê Hàn Quốc', 'Nước ép đóng lon có tép lê tươi', 35000, 80);

INSERT INTO `khuyen_mai` 
(`ma_khuyen_mai`, `phan_tram_giam`, `giam_toi_da`, `ngay_het_han`, `co_freeship`, `so_luong`, `don_hang_min`, `trang_thai`) 
VALUES
-- Mã 1: Giảm 20% cho khách hàng mới, tối đa 50k, áp dụng cho đơn từ 150k
('XINCHAO20', 20, 50000.00, '2026-12-31 23:59:59', 'Không', 100, 150000.00, 'Hiệu lực'),

-- Mã 2: Miễn phí vận chuyển cho đơn hàng từ 300k
('FREESHIPKOREA', 0, 0.00, '2026-12-31 23:59:59', 'Có', 500, 300000.00, 'Hiệu lực');