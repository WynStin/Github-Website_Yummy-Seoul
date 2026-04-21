SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";



-- Cơ sở dữ liệu: `yummy_seoul`
-- Cấu trúc bảng cho bảng `chi_tiet_don_hang`
DROP TABLE IF EXISTS `chi_tiet_don_hang`;
CREATE TABLE IF NOT EXISTS `chi_tiet_don_hang` (
  `id_chi_tiet` int NOT NULL AUTO_INCREMENT,
  `id_don_hang` int NOT NULL,
  `id_mon_an` int NOT NULL,
  `so_luong` int NOT NULL,
  `don_gia` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_chi_tiet`),
  KEY `id_don_hang` (`id_don_hang`),
  KEY `id_mon_an` (`id_mon_an`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Cấu trúc bảng cho bảng `chi_tiet_gio_hang`
DROP TABLE IF EXISTS `chi_tiet_gio_hang`;
CREATE TABLE IF NOT EXISTS `chi_tiet_gio_hang` (
  `id_chi_tiet` int NOT NULL AUTO_INCREMENT,
  `id_gio_hang` int NOT NULL,
  `id_mon_an` int NOT NULL,
  `so_luong` int NOT NULL,
  `don_gia` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_chi_tiet`),
  KEY `id_gio_hang` (`id_gio_hang`),
  KEY `id_mon_an` (`id_mon_an`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Cấu trúc bảng cho bảng `danh_muc_mon_an`
DROP TABLE IF EXISTS `danh_muc_mon_an`;
CREATE TABLE IF NOT EXISTS `danh_muc_mon_an` (
  `id_danh_muc` int NOT NULL AUTO_INCREMENT,
  `ten_danh_muc` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mo_ta` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id_danh_muc`),
  UNIQUE KEY `ten_danh_muc` (`ten_danh_muc`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Đang đổ dữ liệu cho bảng `danh_muc_mon_an`
INSERT INTO `danh_muc_mon_an` (`id_danh_muc`, `ten_danh_muc`, `mo_ta`) VALUES
(1, 'Cơm (Rice)', 'Các món cơm trộn, cơm cuộn và cơm phần truyền thống'),
(2, 'Gà (Chicken)', 'Gà rán và gà sốt đặc trưng kiểu Hàn Quốc'),
(3, 'Mì (Noodles)', 'Các loại mì đen, mì lạnh và mì cay Ramen'),
(4, 'Lẩu & Súp (Stew)', 'Các món canh nóng hổi và lẩu dùng kèm cơm'),
(5, 'Đồ ăn nhẹ (Snacks)', 'Món ăn đường phố phổ biến như Tokbokki, Chả cá'),
(6, 'Đồ uống (Drinks)', 'Rượu Soju, nước gạo và các loại giải khát');

-- Cấu trúc bảng cho bảng `don_hang`
DROP TABLE IF EXISTS `don_hang`;
CREATE TABLE IF NOT EXISTS `don_hang` (
  `id_don_hang` int NOT NULL AUTO_INCREMENT,
  `id_khach_hang` int NOT NULL,
  `id_khuyen_mai` int DEFAULT NULL,
  `ngay_tao_don` datetime DEFAULT CURRENT_TIMESTAMP,
  `tien_ship` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tong_gia` decimal(10,2) NOT NULL,
  `trang_thai` enum('Đã đặt','Đang xử lý','Đang giao','Hoàn thành','Đã hủy') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Đã đặt',
  `dia_chi_giao_hang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pt_thanh_toan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ghi_chu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id_don_hang`),
  KEY `id_khach_hang` (`id_khach_hang`),
  KEY `id_khuyen_mai` (`id_khuyen_mai`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
-- Đang đổ dữ liệu cho bảng `don_hang`
INSERT INTO `don_hang` (`id_don_hang`, `id_khach_hang`, `id_khuyen_mai`, `ngay_tao_don`, `tien_ship`, `tong_gia`, `trang_thai`, `dia_chi_giao_hang`, `pt_thanh_toan`, `ghi_chu`) VALUES
(1, 1, NULL, '2026-04-17 10:14:16', 10000.00, 40000.00, 'Hoàn thành', 'Cầu Giấy, Hà Nội', 'Ngân hàng', ''),
(2, 1, NULL, '2026-04-18 10:40:05', 0.00, 50000.00, 'Hoàn thành', 'Đống Đa, Hà Nội', 'Tiền mặt', ''),
(3, 2, NULL, '2026-04-20 14:38:59', 0.00, 35000.00, 'Hoàn thành', 'Đại học KTQD', 'Ngân hàng', NULL);

-- Cấu trúc bảng cho bảng `gio_hang`
DROP TABLE IF EXISTS `gio_hang`;
CREATE TABLE IF NOT EXISTS `gio_hang` (
  `id_gio_hang` int NOT NULL AUTO_INCREMENT,
  `id_khach_hang` int NOT NULL,
  `id_khuyen_mai` int DEFAULT NULL,
  `tien_ship` decimal(10,2) DEFAULT '0.00',
  `tong_gia` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id_gio_hang`),
  UNIQUE KEY `id_khach_hang` (`id_khach_hang`),
  KEY `fk_gio_hang_km` (`id_khuyen_mai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Cấu trúc bảng cho bảng `khuyen_mai`
DROP TABLE IF EXISTS `khuyen_mai`;
CREATE TABLE IF NOT EXISTS `khuyen_mai` (
  `id_khuyen_mai` int NOT NULL AUTO_INCREMENT,
  `ma_khuyen_mai` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phan_tram_giam` int DEFAULT NULL,
  `giam_toi_da` decimal(10,2) DEFAULT NULL,
  `ngay_het_han` datetime NOT NULL,
  `co_freeship` enum('Có','Không') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Không',
  `so_luong` int NOT NULL,
  `don_hang_min` decimal(10,2) DEFAULT '0.00',
  `trang_thai` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Hiệu lực',
  PRIMARY KEY (`id_khuyen_mai`),
  UNIQUE KEY `ma_khuyen_mai` (`ma_khuyen_mai`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
-- Đang đổ dữ liệu cho bảng `khuyen_mai`
INSERT INTO `khuyen_mai` (`id_khuyen_mai`, `ma_khuyen_mai`, `phan_tram_giam`, `giam_toi_da`, `ngay_het_han`, `co_freeship`, `so_luong`, `don_hang_min`, `trang_thai`) VALUES
(1, 'XINCHAO20', 20, 50000.00, '2026-12-31 23:59:59', 'Không', 100, 150000.00, 'Hiệu lực'),
(2, 'FREESHIPKOREA', 0, 0.00, '2026-12-31 23:59:59', 'Có', 500, 300000.00, 'Hiệu lực');
-- Cấu trúc bảng cho bảng `mon_an`

DROP TABLE IF EXISTS `mon_an`;
CREATE TABLE IF NOT EXISTS `mon_an` (
  `id_mon_an` int NOT NULL AUTO_INCREMENT,
  `id_danh_muc` int DEFAULT NULL,
  `ten_mon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mo_ta` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `gia_ban` decimal(10,2) NOT NULL,
  `hinh_anh` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trang_thai` enum('Còn hàng','Hết hàng') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Còn hàng',
  `so_luong_ton` int NOT NULL,
  `so_luot_xem` int DEFAULT '0',
  `so_luong_da_ban` int DEFAULT '0',
  `ngay_tao` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_mon_an`),
  KEY `id_danh_muc` (`id_danh_muc`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Đang đổ dữ liệu cho bảng `mon_an`
INSERT INTO `mon_an` (`id_mon_an`, `id_danh_muc`, `ten_mon`, `mo_ta`, `gia_ban`, `hinh_anh`, `trang_thai`, `so_luong_ton`, `so_luot_xem`, `so_luong_da_ban`, `ngay_tao`) VALUES
(1, 1, 'Cơm trộn Bibimbap', 'Cơm với 8 loại rau củ, thịt bò và trứng chần', 85000.00, 'comtronbibimbap.jpg', 'Còn hàng', 100, 450, 120, '2026-01-10 10:30:00'),
(2, 1, 'Kimbap truyền thống', 'Cơm cuộn rong biển nhân xúc xích và rau củ', 50000.00, 'kimbaptruyenthong.jpg', 'Còn hàng', 80, 310, 85, '2026-01-12 08:15:00'),
(3, 1, 'Cơm chiên Kimchi', 'Cơm chiên cay với kim chi cải thảo và trứng ốp la', 70000.00, 'comchienkimchi.jpg', 'Còn hàng', 100, 280, 60, '2026-01-15 14:20:00'),
(4, 2, 'Gà rán sốt cay', 'Gà chiên giòn rụm với sốt Yangnyeom truyền thống', 155000.00, 'garansotcay.jpg', 'Còn hàng', 30, 520, 145, '2026-02-01 09:00:00'),
(5, 2, 'Gà sốt tương tỏi', 'Gà chiên vị mặn ngọt đậm đà mùi tỏi phi', 155000.00, 'gasottuongtoi.jpg', 'Còn hàng', 30, 380, 90, '2026-02-05 10:30:00'),
(6, 2, 'Gà không xương chiên', 'Gà fillet tẩm bột chiên giòn dễ ăn cho trẻ em', 120000.00, 'gakhongxuong.jpg', 'Còn hàng', 45, 250, 70, '2026-02-10 15:00:00'),
(7, 3, 'Mì tương đen Jajangmyeon', 'Mì trộn sốt đậu đen và thịt heo thái lựu', 75000.00, 'mituongden.jpg', 'Còn hàng', 60, 410, 110, '2026-03-01 08:00:00'),
(8, 3, 'Mì lạnh Naengmyeon', 'Mì sợi nhỏ dùng với nước dùng đá lạnh thanh mát', 90000.00, 'milanh.jpg', 'Còn hàng', 20, 190, 30, '2026-03-05 11:30:00'),
(9, 3, 'Mì cay Ramen hải sản', 'Mì gói Hàn Quốc nấu cay với tôm và mực', 65000.00, 'miramen.jpg', 'Còn hàng', 100, 330, 95, '2026-03-07 12:00:00'),
(10, 3, 'Mì trộn cay Bibim-guksu', 'Mì sợi nhỏ trộn sốt ớt cay và rau sống', 70000.00, 'mitroncay.jpg', 'Còn hàng', 50, 150, 40, '2026-03-10 14:15:00'),
(11, 4, 'Canh Kimchi đậu phụ', 'Súp kim chi nấu cùng thịt ba chỉ béo ngậy', 95000.00, 'canhkimchi.jpg', 'Còn hàng', 40, 290, 75, '2026-03-15 09:30:00'),
(12, 4, 'Canh rong biển', 'Món canh truyền thống thanh đạm, tốt sức khỏe', 60000.00, 'canhrongbien.jpg', 'Còn hàng', 50, 180, 50, '2026-03-20 16:00:00'),
(13, 4, 'Lẩu quân đội Budae Jjigae', 'Lẩu xúc xích, đậu phụ, spam và mì', 250000.00, 'lauquandoi.jpg', 'Còn hàng', 15, 210, 35, '2026-03-25 19:00:00'),
(14, 4, 'Canh đậu phụ non Soondubu', 'Canh đậu phụ siêu mềm với hải sản và trứng', 85000.00, 'canhdauphunon.jpg', 'Còn hàng', 40, 175, 45, '2026-03-28 11:00:00'),
(15, 5, 'Tokbokki truyền thống', 'Bánh gạo dẻo nấu trong sốt ớt cay ngọt', 45000.00, 'tokbokki.jpg', 'Còn hàng', 150, 600, 210, '2026-04-05 08:30:00'),
(16, 5, 'Chả cá Odeng', 'Xiên chả cá nóng hổi kèm nước dùng súp', 15000.00, 'chaca.jpg', 'Còn hàng', 200, 550, 320, '2026-04-10 08:45:00'),
(17, 6, 'Rượu Soju vị Đào', 'Rượu trái cây nồng độ nhẹ dễ uống', 65000.00, 'soju.jpg', 'Còn hàng', 100, 320, 80, '2026-04-12 13:00:00'),
(18, 6, 'Nước gạo rang Woongjin', 'Thức uống truyền thống vị thơm, ngọt thanh', 30000.00, 'nuocgao.png', 'Còn hàng', 150, 240, 65, '2026-04-14 14:00:00'),
(19, 6, 'Coca Cola lon', 'Nước giải khát có gas 330ml', 20000.00, 'coca.jpg', 'Còn hàng', 200, 400, 150, '2026-04-15 14:15:00'),
(20, 6, 'Trà sữa khoai môn', 'Trà sữa vị khoai môn đặc trưng', 45000.00, 'trasuakhoaimon.jpg', 'Còn hàng', 100, 270, 90, '2026-04-16 15:00:00'),
(21, 1, 'Cơm bò xào Bulgogi', 'Cơm trắng ăn kèm thịt bò xào sốt mặn ngọt', 95000.00, 'combobulgogi.jpg', 'Còn hàng', 50, 45, 12, '2026-04-19 09:00:00'),
(22, 1, 'Kimbap chiên xù', 'Cơm cuộn tẩm bột chiên giòn rụm bên ngoài', 65000.00, 'kimbapchien.jpg', 'Còn hàng', 40, 38, 8, '2026-04-19 09:15:00'),
(23, 2, 'Gà rán sốt phô mai', 'Gà chiên giòn đẫm sốt phô mai tan chảy', 165000.00, 'garanphomai.jpg', 'Còn hàng', 25, 62, 15, '2026-04-19 10:20:00'),
(24, 2, 'Cánh gà chiên nước mắm', 'Cánh gà chiên giòn đảo sốt nước mắm kiểu Hàn', 140000.00, 'canhgachienmam.jpg', 'Còn hàng', 35, 25, 5, '2026-04-19 10:45:00'),
(25, 3, 'Mì Udon hải sản', 'Mì sợi to kiểu Hàn nấu nước dùng hải sản thanh', 110000.00, 'miudon.jpg', 'Còn hàng', 35, 30, 7, '2026-04-19 11:30:00'),
(26, 4, 'Súp sườn bò Galbitang', 'Nước dùng trong, sườn bò hầm mềm ngọt', 150000.00, 'supsuonbo.jpg', 'Còn hàng', 20, 18, 3, '2026-04-19 12:00:00'),
(27, 5, 'Mandu chiên', 'Sủi cảo nhân thịt và rau củ chiên giòn', 40000.00, 'mandu.jpg', 'Còn hàng', 80, 55, 20, '2026-04-19 13:45:00'),
(28, 5, 'Khoai tây chiên mật ong', 'Khoai tây giòn tẩm bơ và mật ong ngọt ngào', 45000.00, 'khoaitaychien.jpg', 'Còn hàng', 60, 40, 14, '2026-04-19 14:10:00'),
(29, 5, 'Bánh xèo hải sản Pajeon', 'Bánh xèo nhân hành lá và hải sản áp chảo', 120000.00, 'banhxeo.jpg', 'Còn hàng', 30, 22, 4, '2026-04-19 14:50:00'),
(30, 6, 'Nước ép lê Hàn Quốc', 'Nước ép đóng lon có tép lê tươi', 35000.00, 'nuocle.jpg', 'Còn hàng', 80, 35, 11, '2026-04-19 15:30:00');

-- Cấu trúc bảng cho bảng `nguoi_dung`
DROP TABLE IF EXISTS `nguoi_dung`;
CREATE TABLE IF NOT EXISTS `nguoi_dung` (
  `id_nguoi_dung` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mat_khau` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ho_ten` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `so_dien_thoai` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dia_chi_mac_dinh` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vai_tro` enum('Khách hàng','Quản lý') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Khách hàng',
  `trang_thai` enum('Hoạt động','Bị khóa') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Hoạt động',
  `ngay_tao` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_nguoi_dung`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `so_dien_thoai` (`so_dien_thoai`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Đang đổ dữ liệu cho bảng `nguoi_dung`
INSERT INTO `nguoi_dung` (`id_nguoi_dung`, `user_name`, `mat_khau`, `ho_ten`, `email`, `so_dien_thoai`, `dia_chi_mac_dinh`, `vai_tro`, `trang_thai`, `ngay_tao`) VALUES
(1, 'admin', '123456', 'Hàn Quốc Quản', 'admin@yummyseoul.com', '0912345678', 'Hà Nội', 'Quản lý', 'Hoạt động', '2026-04-19 08:19:54'),
(2, 'TDuong', '11223344', 'Nguyễn Vũ Tùng Dương', 'tDNguyenVU@gmail.com', '0975864531', 'Hai Bà Trưng, Hà Nội', 'Khách hàng', 'Hoạt động', '2026-04-20 12:11:26');
-- Ràng buộc cho bảng `chi_tiet_don_hang`
ALTER TABLE `chi_tiet_don_hang`
  ADD CONSTRAINT `fk_ctdh_don_hang` FOREIGN KEY (`id_don_hang`) REFERENCES `don_hang` (`id_don_hang`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ctdh_mon_an` FOREIGN KEY (`id_mon_an`) REFERENCES `mon_an` (`id_mon_an`);
-- Ràng buộc cho bảng `chi_tiet_gio_hang`
ALTER TABLE `chi_tiet_gio_hang`
  ADD CONSTRAINT `fk_ctgh_gio_hang` FOREIGN KEY (`id_gio_hang`) REFERENCES `gio_hang` (`id_gio_hang`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ctgh_mon_an` FOREIGN KEY (`id_mon_an`) REFERENCES `mon_an` (`id_mon_an`) ON DELETE CASCADE;
-- Ràng buộc cho bảng `don_hang`
ALTER TABLE `don_hang`
  ADD CONSTRAINT `fk_don_hang_khach` FOREIGN KEY (`id_khach_hang`) REFERENCES `nguoi_dung` (`id_nguoi_dung`),
  ADD CONSTRAINT `fk_don_hang_km` FOREIGN KEY (`id_khuyen_mai`) REFERENCES `khuyen_mai` (`id_khuyen_mai`);
-- Ràng buộc cho bảng `gio_hang`
ALTER TABLE `gio_hang`
  ADD CONSTRAINT `fk_gio_hang_khach` FOREIGN KEY (`id_khach_hang`) REFERENCES `nguoi_dung` (`id_nguoi_dung`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_gio_hang_km` FOREIGN KEY (`id_khuyen_mai`) REFERENCES `khuyen_mai` (`id_khuyen_mai`) ON DELETE SET NULL;
-- Ràng buộc cho bảng `mon_an`
ALTER TABLE `mon_an`
  ADD CONSTRAINT `fk_mon_an_danh_muc` FOREIGN KEY (`id_danh_muc`) REFERENCES `danh_muc_mon_an` (`id_danh_muc`) ON DELETE SET NULL;
COMMIT;