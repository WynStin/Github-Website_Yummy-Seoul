-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th4 07, 2026 lúc 10:49 AM
-- Phiên bản máy phục vụ: 8.4.7
-- Phiên bản PHP: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `csdl_web`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chi_tiet_don_hang`
--

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
) ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chi_tiet_gio_hang`
--

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
) ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danh_muc_mon_an`
--

DROP TABLE IF EXISTS `danh_muc_mon_an`;
CREATE TABLE IF NOT EXISTS `danh_muc_mon_an` (
  `id_danh_muc` int NOT NULL AUTO_INCREMENT,
  `ten_danh_muc` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mo_ta` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id_danh_muc`),
  UNIQUE KEY `ten_danh_muc` (`ten_danh_muc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `don_hang`
--

DROP TABLE IF EXISTS `don_hang`;
CREATE TABLE IF NOT EXISTS `don_hang` (
  `id_don_hang` int NOT NULL AUTO_INCREMENT,
  `id_khach_hang` int NOT NULL,
  `id_khuyen_mai` int DEFAULT NULL,
  `ngay_tao_don` datetime DEFAULT CURRENT_TIMESTAMP,
  `tien_ship` decimal(10,2) NOT NULL,
  `tong_gia` decimal(10,2) NOT NULL,
  `trang_thai` enum('Đã đặt','Đang xử lý','Đang giao','Hoàn thành','Đã hủy') COLLATE utf8mb4_unicode_ci DEFAULT 'Đã đặt',
  `dia_chi_giao_hang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pt_thanh_toan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ghi_chu` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id_don_hang`),
  KEY `id_khach_hang` (`id_khach_hang`),
  KEY `id_khuyen_mai` (`id_khuyen_mai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `gio_hang`
--

DROP TABLE IF EXISTS `gio_hang`;
CREATE TABLE IF NOT EXISTS `gio_hang` (
  `id_gio_hang` int NOT NULL AUTO_INCREMENT,
  `id_khach_hang` int NOT NULL,
  `id_khuyen_mai` int DEFAULT NULL,
  `tien_ship` decimal(10,2) DEFAULT '0.00',
  `tong_gia` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id_gio_hang`),
  UNIQUE KEY `id_khach_hang` (`id_khach_hang`),
  KEY `id_khuyen_mai` (`id_khuyen_mai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khuyen_mai`
--

DROP TABLE IF EXISTS `khuyen_mai`;
CREATE TABLE IF NOT EXISTS `khuyen_mai` (
  `id_khuyen_mai` int NOT NULL AUTO_INCREMENT,
  `ma_khuyen_mai` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phan_tram_giam` int DEFAULT NULL,
  `giam_toi_da` decimal(10,2) DEFAULT NULL,
  `ngay_het_han` datetime NOT NULL,
  `co_freeship` enum('Có','Không') COLLATE utf8mb4_unicode_ci DEFAULT 'Không',
  `so_luong` int NOT NULL,
  `don_hang_min` decimal(10,2) DEFAULT '0.00',
  `trang_thai` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'Hiệu lực',
  PRIMARY KEY (`id_khuyen_mai`),
  UNIQUE KEY `ma_khuyen_mai` (`ma_khuyen_mai`)
) ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mon_an`
--

DROP TABLE IF EXISTS `mon_an`;
CREATE TABLE IF NOT EXISTS `mon_an` (
  `id_mon_an` int NOT NULL AUTO_INCREMENT,
  `id_danh_muc` int DEFAULT NULL,
  `ten_mon` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mo_ta` text COLLATE utf8mb4_unicode_ci,
  `gia_ban` decimal(10,2) NOT NULL,
  `hinh_anh` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trang_thai` enum('Còn hàng','Hết hàng') COLLATE utf8mb4_unicode_ci DEFAULT 'Còn hàng',
  `so_luong_ton` int NOT NULL,
  `so_luot_xem` int DEFAULT '0',
  `so_luong_da_ban` int DEFAULT '0',
  `ngay_tao` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_mon_an`),
  KEY `id_danh_muc` (`id_danh_muc`)
) ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoi_dung`
--

DROP TABLE IF EXISTS `nguoi_dung`;
CREATE TABLE IF NOT EXISTS `nguoi_dung` (
  `id_nguoi_dung` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mat_khau` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ho_ten` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `so_dien_thoai` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dia_chi_mac_dinh` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vai_tro` enum('Khách hàng','Quản lý') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Khách hàng',
  `trang_thai` enum('Hoạt động','Bị khóa') COLLATE utf8mb4_unicode_ci DEFAULT 'Hoạt động',
  `ngay_tao` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_nguoi_dung`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `so_dien_thoai` (`so_dien_thoai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Ràng buộc đối với các bảng kết xuất
--

--
-- Ràng buộc cho bảng `chi_tiet_don_hang`
--
ALTER TABLE `chi_tiet_don_hang`
  ADD CONSTRAINT `chi_tiet_don_hang_ibfk_1` FOREIGN KEY (`id_don_hang`) REFERENCES `don_hang` (`id_don_hang`) ON DELETE CASCADE,
  ADD CONSTRAINT `chi_tiet_don_hang_ibfk_2` FOREIGN KEY (`id_mon_an`) REFERENCES `mon_an` (`id_mon_an`);

--
-- Ràng buộc cho bảng `chi_tiet_gio_hang`
--
ALTER TABLE `chi_tiet_gio_hang`
  ADD CONSTRAINT `chi_tiet_gio_hang_ibfk_1` FOREIGN KEY (`id_gio_hang`) REFERENCES `gio_hang` (`id_gio_hang`) ON DELETE CASCADE,
  ADD CONSTRAINT `chi_tiet_gio_hang_ibfk_2` FOREIGN KEY (`id_mon_an`) REFERENCES `mon_an` (`id_mon_an`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `don_hang`
--
ALTER TABLE `don_hang`
  ADD CONSTRAINT `don_hang_ibfk_1` FOREIGN KEY (`id_khach_hang`) REFERENCES `nguoi_dung` (`id_nguoi_dung`),
  ADD CONSTRAINT `don_hang_ibfk_2` FOREIGN KEY (`id_khuyen_mai`) REFERENCES `khuyen_mai` (`id_khuyen_mai`);

--
-- Ràng buộc cho bảng `gio_hang`
--
ALTER TABLE `gio_hang`
  ADD CONSTRAINT `gio_hang_ibfk_1` FOREIGN KEY (`id_khach_hang`) REFERENCES `nguoi_dung` (`id_nguoi_dung`) ON DELETE CASCADE,
  ADD CONSTRAINT `gio_hang_ibfk_2` FOREIGN KEY (`id_khuyen_mai`) REFERENCES `khuyen_mai` (`id_khuyen_mai`) ON DELETE SET NULL;

--
-- Ràng buộc cho bảng `mon_an`
--
ALTER TABLE `mon_an`
  ADD CONSTRAINT `mon_an_ibfk_1` FOREIGN KEY (`id_danh_muc`) REFERENCES `danh_muc_mon_an` (`id_danh_muc`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
