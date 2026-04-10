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