-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th8 09, 2025 lúc 02:09 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `test1`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `baocao`
--

CREATE TABLE `baocao` (
  `MaBC` int(11) NOT NULL,
  `TenBC` varchar(255) NOT NULL,
  `LoaiBC` varchar(100) DEFAULT NULL,
  `NgayTao` date NOT NULL,
  `MaNV` int(11) DEFAULT NULL,
  `DuongDan` text DEFAULT NULL,
  `NoiDung` varchar(1000) DEFAULT NULL,
  `TrangThaiDuyet` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietdonhang`
--

CREATE TABLE `chitietdonhang` (
  `MaDH` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `SoLuong` int(11) NOT NULL CHECK (`SoLuong` > 0),
  `DonGia` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhgia`
--

CREATE TABLE `danhgia` (
  `MaDG` int(11) NOT NULL,
  `MaKH` int(11) DEFAULT NULL,
  `MaDH` int(11) DEFAULT NULL,
  `SoSao` tinyint(1) NOT NULL CHECK (`SoSao` between 1 and 5),
  `NoiDung` text NOT NULL,
  `DanhGia` int(11) DEFAULT NULL,
  `NgayDanhGia` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhmuc`
--

CREATE TABLE `danhmuc` (
  `MaDM` int(11) NOT NULL,
  `TenDanhMuc` varchar(100) NOT NULL,
  `MoTa` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `diachi`
--

CREATE TABLE `diachi` (
  `MaDC` int(11) NOT NULL,
  `SoNha` varchar(255) DEFAULT NULL,
  `Phuong` varchar(100) DEFAULT NULL,
  `Quan` varchar(100) DEFAULT NULL,
  `ThanhPho` varchar(100) DEFAULT NULL,
  `MaKH` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhang`
--

CREATE TABLE `donhang` (
  `MaDH` int(11) NOT NULL,
  `MaKH` int(11) DEFAULT NULL,
  `MaNV` int(11) DEFAULT NULL,
  `NgayDatHang` datetime NOT NULL,
  `TrangThai` enum('Pending','Processing','Completed','Cancelled') NOT NULL DEFAULT 'Pending',
  `MaKhuyenMai` int(11) DEFAULT NULL,
  `MaDC` int(11) DEFAULT NULL,
  `TongTien` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `MaKH` int(11) NOT NULL,
  `HoTen` varchar(100) NOT NULL,
  `SoDienThoai` varchar(15) DEFAULT NULL,
  `CCCD` varchar(12) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `NgaySinh` date DEFAULT NULL,
  `DiemTichLuy` int(11) DEFAULT 0,
  `MaPK` int(11) DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `kho`
--

CREATE TABLE `kho` (
  `MaKho` int(11) NOT NULL,
  `MaSP` int(11) DEFAULT NULL,
  `MaNV` int(11) DEFAULT NULL,
  `MaNL` int(11) DEFAULT NULL,
  `NgayGiaoDich` datetime NOT NULL,
  `LoaiGiaoDich` enum('Nhap','Xuat') NOT NULL,
  `SoLuong` int(11) NOT NULL CHECK (`SoLuong` >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khuyenmai`
--

CREATE TABLE `khuyenmai` (
  `MaKM` int(11) NOT NULL,
  `TenKM` varchar(255) NOT NULL,
  `MoTa` text DEFAULT NULL,
  `PhanTramGiamGia` decimal(5,2) DEFAULT NULL,
  `SoTienGiamGia` decimal(10,2) DEFAULT NULL,
  `NgayBatDau` date DEFAULT NULL,
  `NgayKetThuc` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lichsu_donhang`
--

CREATE TABLE `lichsu_donhang` (
  `MaLS` int(11) NOT NULL,
  `MaDH` int(11) NOT NULL,
  `NgayThayDoi` datetime NOT NULL DEFAULT current_timestamp(),
  `GhiChu` text DEFAULT NULL,
  `MaNV` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguyenlieu`
--

CREATE TABLE `nguyenlieu` (
  `MaNL` int(11) NOT NULL,
  `TenNL` varchar(100) NOT NULL,
  `MoTa` text DEFAULT NULL,
  `DonViTinh` varchar(20) DEFAULT NULL,
  `SoLuong` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhanvien`
--

CREATE TABLE `nhanvien` (
  `MaNV` int(11) NOT NULL,
  `HoTen` varchar(100) NOT NULL,
  `SoDienThoai` varchar(15) DEFAULT NULL,
  `CCCD` varchar(20) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `NgaySinh` date DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phankhuckh`
--

CREATE TABLE `phankhuckh` (
  `MaPK` int(11) NOT NULL,
  `TenPK` varchar(100) NOT NULL,
  `MoTa` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `MaSP` int(11) NOT NULL,
  `TenSP` varchar(100) NOT NULL,
  `MoTa` text DEFAULT NULL,
  `DonGia` decimal(10,2) NOT NULL,
  `MaDM` int(11) DEFAULT NULL,
  `SoLuong` int(11) UNSIGNED NOT NULL DEFAULT 0 CHECK (`SoLuong` >= 0),
  `HinhAnh` varchar(255) DEFAULT NULL,
  `TrangThai` enum('Available','OutOfStock','Discontinued') NOT NULL DEFAULT 'Available',
  `NgayThem` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thanhtoan`
--

CREATE TABLE `thanhtoan` (
  `MaTT` int(11) NOT NULL,
  `MaDH` int(11) NOT NULL,
  `MaNV` int(11) DEFAULT NULL,
  `PTTT` varchar(100) DEFAULT NULL,
  `SoTien` decimal(12,2) NOT NULL,
  `NgayThanhToan` datetime NOT NULL,
  `TrangThai` enum('Pending','Completed','Failed') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `role` enum('admin','member','staff') NOT NULL DEFAULT 'member'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vanchuyen`
--

CREATE TABLE `vanchuyen` (
  `MaGH` int(11) NOT NULL,
  `MaDH` int(11) NOT NULL,
  `DVVC` varchar(100) DEFAULT NULL,
  `MaVanDon` varchar(50) DEFAULT NULL,
  `PhiShip` decimal(10,2) DEFAULT 0.00,
  `NgayGiaoHang` date DEFAULT NULL,
  `NgayNhanHangDuKien` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `baocao`
--
ALTER TABLE `baocao`
  ADD PRIMARY KEY (`MaBC`),
  ADD KEY `MaNV` (`MaNV`);

--
-- Chỉ mục cho bảng `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD PRIMARY KEY (`MaDH`,`MaSP`),
  ADD KEY `MaSP` (`MaSP`);

--
-- Chỉ mục cho bảng `danhgia`
--
ALTER TABLE `danhgia`
  ADD PRIMARY KEY (`MaDG`),
  ADD KEY `MaKH` (`MaKH`),
  ADD KEY `MaDonHang` (`MaDH`);

--
-- Chỉ mục cho bảng `danhmuc`
--
ALTER TABLE `danhmuc`
  ADD PRIMARY KEY (`MaDM`);

--
-- Chỉ mục cho bảng `diachi`
--
ALTER TABLE `diachi`
  ADD PRIMARY KEY (`MaDC`),
  ADD KEY `MaKH` (`MaKH`);

--
-- Chỉ mục cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD PRIMARY KEY (`MaDH`),
  ADD KEY `MaKH` (`MaKH`),
  ADD KEY `MaNV` (`MaNV`),
  ADD KEY `MaDiaChiGiaoHang` (`MaDC`),
  ADD KEY `MaKhuyenMai` (`MaKhuyenMai`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`MaKH`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `MaPK` (`MaPK`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `kho`
--
ALTER TABLE `kho`
  ADD PRIMARY KEY (`MaKho`),
  ADD KEY `MaSP` (`MaSP`),
  ADD KEY `MaNL` (`MaNL`),
  ADD KEY `MaNV` (`MaNV`);

--
-- Chỉ mục cho bảng `khuyenmai`
--
ALTER TABLE `khuyenmai`
  ADD PRIMARY KEY (`MaKM`);

--
-- Chỉ mục cho bảng `lichsu_donhang`
--
ALTER TABLE `lichsu_donhang`
  ADD PRIMARY KEY (`MaLS`),
  ADD KEY `MaDH` (`MaDH`),
  ADD KEY `MaNV` (`MaNV`);

--
-- Chỉ mục cho bảng `nguyenlieu`
--
ALTER TABLE `nguyenlieu`
  ADD PRIMARY KEY (`MaNL`);

--
-- Chỉ mục cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`MaNV`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `phankhuckh`
--
ALTER TABLE `phankhuckh`
  ADD PRIMARY KEY (`MaPK`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`MaSP`),
  ADD KEY `MaDM` (`MaDM`);

--
-- Chỉ mục cho bảng `thanhtoan`
--
ALTER TABLE `thanhtoan`
  ADD PRIMARY KEY (`MaTT`),
  ADD KEY `MaDonHang` (`MaDH`),
  ADD KEY `MaNV` (`MaNV`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `vanchuyen`
--
ALTER TABLE `vanchuyen`
  ADD PRIMARY KEY (`MaGH`),
  ADD KEY `MaDonHang` (`MaDH`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `baocao`
--
ALTER TABLE `baocao`
  MODIFY `MaBC` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `danhgia`
--
ALTER TABLE `danhgia`
  MODIFY `MaDG` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `danhmuc`
--
ALTER TABLE `danhmuc`
  MODIFY `MaDM` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `diachi`
--
ALTER TABLE `diachi`
  MODIFY `MaDC` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `donhang`
--
ALTER TABLE `donhang`
  MODIFY `MaDH` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `MaKH` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `kho`
--
ALTER TABLE `kho`
  MODIFY `MaKho` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `khuyenmai`
--
ALTER TABLE `khuyenmai`
  MODIFY `MaKM` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `lichsu_donhang`
--
ALTER TABLE `lichsu_donhang`
  MODIFY `MaLS` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `nguyenlieu`
--
ALTER TABLE `nguyenlieu`
  MODIFY `MaNL` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `MaNV` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `phankhuckh`
--
ALTER TABLE `phankhuckh`
  MODIFY `MaPK` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `MaSP` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `thanhtoan`
--
ALTER TABLE `thanhtoan`
  MODIFY `MaTT` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `vanchuyen`
--
ALTER TABLE `vanchuyen`
  MODIFY `MaGH` int(11) NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `baocao`
--
ALTER TABLE `baocao`
  ADD CONSTRAINT `baocao_ibfk_1` FOREIGN KEY (`MaNV`) REFERENCES `nhanvien` (`MaNV`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD CONSTRAINT `chitietdonhang_ibfk_1` FOREIGN KEY (`MaDH`) REFERENCES `donhang` (`MaDH`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chitietdonhang_ibfk_2` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `danhgia`
--
ALTER TABLE `danhgia`
  ADD CONSTRAINT `danhgia_ibfk_1` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `danhgia_ibfk_2` FOREIGN KEY (`MaDH`) REFERENCES `donhang` (`MaDH`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `diachi`
--
ALTER TABLE `diachi`
  ADD CONSTRAINT `diachi_ibfk_1` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `donhang_ibfk_1` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `donhang_ibfk_2` FOREIGN KEY (`MaNV`) REFERENCES `nhanvien` (`MaNV`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `donhang_ibfk_3` FOREIGN KEY (`MaDC`) REFERENCES `diachi` (`MaDC`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `donhang_ibfk_4` FOREIGN KEY (`MaKhuyenMai`) REFERENCES `khuyenmai` (`MaKM`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD CONSTRAINT `khachhang_ibfk_1` FOREIGN KEY (`MaPK`) REFERENCES `phankhuckh` (`MaPK`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `khachhang_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `kho`
--
ALTER TABLE `kho`
  ADD CONSTRAINT `kho_ibfk_1` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `kho_ibfk_2` FOREIGN KEY (`MaNL`) REFERENCES `nguyenlieu` (`MaNL`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `kho_ibfk_3` FOREIGN KEY (`MaNV`) REFERENCES `nhanvien` (`MaNV`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `lichsu_donhang`
--
ALTER TABLE `lichsu_donhang`
  ADD CONSTRAINT `lichsu_donhang_ibfk_1` FOREIGN KEY (`MaDH`) REFERENCES `donhang` (`MaDH`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lichsu_donhang_ibfk_2` FOREIGN KEY (`MaNV`) REFERENCES `nhanvien` (`MaNV`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD CONSTRAINT `nhanvien_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`MaDM`) REFERENCES `danhmuc` (`MaDM`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `thanhtoan`
--
ALTER TABLE `thanhtoan`
  ADD CONSTRAINT `thanhtoan_ibfk_1` FOREIGN KEY (`MaDH`) REFERENCES `donhang` (`MaDH`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `thanhtoan_ibfk_2` FOREIGN KEY (`MaNV`) REFERENCES `nhanvien` (`MaNV`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `vanchuyen`
--
ALTER TABLE `vanchuyen`
  ADD CONSTRAINT `vanchuyen_ibfk_1` FOREIGN KEY (`MaDH`) REFERENCES `donhang` (`MaDH`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
