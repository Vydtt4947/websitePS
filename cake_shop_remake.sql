-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th8 14, 2025 lúc 08:42 AM
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
-- Cơ sở dữ liệu: `cake_shop_remake`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `baocao`
--

CREATE TABLE `baocao` (
  `MaBC` int(11) NOT NULL,
  `TenBC` varchar(255) NOT NULL,
  `LoaiBC` varchar(100) DEFAULT NULL,
  `NgayTao` date NOT NULL DEFAULT current_timestamp(3),
  `MaNV` int(11) DEFAULT NULL,
  `DuongDan` text DEFAULT NULL,
  `NoiDung` varchar(1000) DEFAULT NULL,
  `TrangThaiDuyet` tinyint(1) NOT NULL DEFAULT 0
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

--
-- Đang đổ dữ liệu cho bảng `chitietdonhang`
--

INSERT INTO `chitietdonhang` (`MaDH`, `MaSP`, `SoLuong`, `DonGia`) VALUES
(1, 3, 1, 120000.00),
(11, 4, 1, 35000.00),
(12, 3, 1, 120000.00),
(12, 4, 1, 35000.00),
(13, 4, 1, 35000.00),
(14, 2, 1, 45000.00),
(15, 4, 1, 35000.00),
(16, 4, 1, 35000.00),
(17, 2, 1, 45000.00),
(18, 4, 1, 35000.00),
(19, 1, 1, 85000.00),
(19, 4, 1, 35000.00),
(20, 3, 1, 120000.00),
(21, 2, 1, 45000.00),
(22, 2, 1, 45000.00);

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
  `NgayDanhGia` date NOT NULL DEFAULT current_timestamp(3),
  `MaSP` int(11) DEFAULT NULL
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

--
-- Đang đổ dữ liệu cho bảng `danhmuc`
--

INSERT INTO `danhmuc` (`MaDM`, `TenDanhMuc`, `MoTa`) VALUES
(1, 'Bánh ngọt', 'Các loại bánh ngọt truyền thống và hiện đại'),
(2, 'Bánh mì', 'Bánh mì tươi và các loại bánh mì đặc biệt'),
(3, 'Bánh kem', 'Bánh kem sinh nhật và các dịp đặc biệt');

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

--
-- Đang đổ dữ liệu cho bảng `diachi`
--

INSERT INTO `diachi` (`MaDC`, `SoNha`, `Phuong`, `Quan`, `ThanhPho`, `MaKH`) VALUES
(1, NULL, NULL, NULL, NULL, NULL),
(2, '140/11 Bình Thạnh', '27', 'Bình Thạnh', 'Bình Thạnh', NULL),
(3, '140/11 Bình Thạnh', '27', 'Bình Thạnh', 'Bình Thạnh', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhang`
--

CREATE TABLE `donhang` (
  `MaDH` int(11) NOT NULL,
  `MaKH` int(11) DEFAULT NULL,
  `MaNV` int(11) DEFAULT NULL,
  `NgayDatHang` datetime(3) NOT NULL,
  `TrangThai` enum('Pending','Processing','Completed','Cancelled') NOT NULL DEFAULT 'Pending',
  `PhuongThucThanhToan` varchar(50) DEFAULT 'cod',
  `MaKhuyenMai` int(11) DEFAULT NULL,
  `MaDC` int(11) DEFAULT NULL,
  `TongTien` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `donhang`
--

INSERT INTO `donhang` (`MaDH`, `MaKH`, `MaNV`, `NgayDatHang`, `TrangThai`, `PhuongThucThanhToan`, `MaKhuyenMai`, `MaDC`, `TongTien`) VALUES
(1, NULL, NULL, '2025-08-13 14:27:39.000', 'Processing', 'cod', NULL, 2, 120000.00),
(11, NULL, NULL, '2025-08-14 00:41:50.000', 'Pending', 'cod', NULL, NULL, 35000.00),
(12, NULL, NULL, '2025-08-14 12:02:19.000', 'Pending', 'cod', NULL, NULL, 155000.00),
(13, 79, NULL, '2025-08-14 12:06:41.000', 'Cancelled', 'cod', NULL, NULL, 35000.00),
(14, 79, NULL, '2025-08-14 12:50:45.000', 'Cancelled', 'cod', NULL, NULL, 45000.00),
(15, 79, NULL, '2025-08-14 13:06:33.000', 'Cancelled', 'cod', NULL, NULL, 35000.00),
(16, 79, NULL, '2025-08-14 13:14:29.000', 'Cancelled', 'cod', NULL, NULL, 50000.00),
(17, 79, NULL, '2025-08-14 13:15:36.000', 'Cancelled', 'cod', NULL, NULL, 60000.00),
(18, 79, NULL, '2025-08-14 13:26:51.000', 'Cancelled', 'cod', NULL, NULL, 50000.00),
(19, 79, NULL, '2025-08-14 13:27:30.000', 'Cancelled', 'cod', NULL, NULL, 120000.00),
(20, 79, NULL, '2025-08-14 13:33:11.000', 'Cancelled', 'bank', NULL, NULL, 120000.00),
(21, 79, NULL, '2025-08-14 13:39:03.000', 'Cancelled', 'bank', NULL, NULL, 60000.00),
(22, 79, NULL, '2025-08-14 13:41:04.000', 'Cancelled', 'bank', NULL, NULL, 60000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giohang`
--

CREATE TABLE `giohang` (
  `MaGH` int(11) NOT NULL,
  `MaKH` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `SoLuong` int(11) NOT NULL DEFAULT 1,
  `NgayThem` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `DiemTichLuy` int(11) NOT NULL DEFAULT 0,
  `MaPK` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime(3) NOT NULL DEFAULT current_timestamp(3),
  `MatKhau` varchar(255) DEFAULT NULL,
  `DiaChiGiaoHang` text DEFAULT NULL,
  `TinhThanh` varchar(100) DEFAULT NULL,
  `QuanHuyen` varchar(100) DEFAULT NULL,
  `GhiChuGiaoHang` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`MaKH`, `HoTen`, `SoDienThoai`, `CCCD`, `Email`, `NgaySinh`, `DiemTichLuy`, `MaPK`, `user_id`, `created_at`, `MatKhau`, `DiaChiGiaoHang`, `TinhThanh`, `QuanHuyen`, `GhiChuGiaoHang`) VALUES
(78, 'Phương Nguyễn Hoàng', NULL, NULL, 'cucxac.fuong227@gmail.com', NULL, 0, NULL, NULL, '2025-08-14 00:23:42.840', NULL, NULL, NULL, NULL, NULL),
(79, 'phuongnh0954', '0856473291', NULL, 'phuongnh0954@ut.edu.vn', '0000-00-00', 0, NULL, 4, '2025-08-14 00:30:26.246', NULL, '02 Võ Oanh', 'TP. Hồ Chí Minh', 'Bình Thạnh', 'Trường Đại Học GTVT TPHCM');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `kho`
--

CREATE TABLE `kho` (
  `MaKho` int(11) NOT NULL,
  `MaSP` int(11) DEFAULT NULL,
  `MaNV` int(11) DEFAULT NULL,
  `MaNL` int(11) DEFAULT NULL,
  `NgayGiaoDich` datetime(3) NOT NULL,
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

--
-- Đang đổ dữ liệu cho bảng `khuyenmai`
--

INSERT INTO `khuyenmai` (`MaKM`, `TenKM`, `MoTa`, `PhanTramGiamGia`, `SoTienGiamGia`, `NgayBatDau`, `NgayKetThuc`) VALUES
(1, 'WELCOME10', 'Giảm 10% cho khách hàng mới', 10.00, NULL, '2025-08-09', '2025-09-08'),
(2, 'FREESHIP', 'Miễn phí vận chuyển cho đơn hàng trên 500k', NULL, 30000.00, '2025-08-09', '2025-10-08');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lichsu_donhang`
--

CREATE TABLE `lichsu_donhang` (
  `MaLS` int(11) NOT NULL,
  `MaDH` int(11) NOT NULL,
  `NgayThayDoi` datetime(3) NOT NULL DEFAULT current_timestamp(3),
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
  `SoLuong` int(11) NOT NULL DEFAULT 0
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
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nhanvien`
--

INSERT INTO `nhanvien` (`MaNV`, `HoTen`, `SoDienThoai`, `CCCD`, `Email`, `NgaySinh`, `user_id`) VALUES
(1, 'Nguyen Van A', '0909123456', NULL, 'employee@parrotsmell.com', NULL, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phankhuckh`
--

CREATE TABLE `phankhuckh` (
  `MaPK` int(11) NOT NULL,
  `TenPK` varchar(100) NOT NULL,
  `MoTa` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `phankhuckh`
--

INSERT INTO `phankhuckh` (`MaPK`, `TenPK`, `MoTa`) VALUES
(1, 'Bronze', 'Khách hàng mới'),
(2, 'Silver', 'Khách hàng thân thiết'),
(3, 'Gold', 'Khách hàng VIP');

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
  `NgayThem` datetime(3) NOT NULL DEFAULT current_timestamp(3)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`MaSP`, `TenSP`, `MoTa`, `DonGia`, `MaDM`, `SoLuong`, `HinhAnh`, `TrangThai`, `NgayThem`) VALUES
(1, 'Bánh Tiramisu', 'Bánh tiramisu truyền thống Ý với hương vị cà phê đậm đà', 85000.00, 1, 50, 'https://images.unsplash.com/photo-1714385905983-6f8e06fffae1?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'Available', '2025-08-09 13:05:54.645'),
(2, 'Bánh Mì Sourdough', 'Bánh mì sourdough với vỏ giòn và ruột mềm', 45000.00, 2, 100, 'https://plus.unsplash.com/premium_photo-1664640733898-d5c3f71f44e1?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'Available', '2025-08-09 13:05:54.645'),
(3, 'Bánh Chocolate Cake', 'Bánh chocolate đen với kem tươi', 120000.00, 3, 29, 'https://images.unsplash.com/photo-1606890737304-57a1ca8a5b62?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8Y2hvY29sYXRlJTIwY2FrZXxlbnwwfHwwfHx8MA%3D%3D', 'Available', '2025-08-09 13:05:54.645'),
(4, 'Bánh Croissant', 'Bánh croissant Pháp với lớp vỏ xốp giòn', 35000.00, 2, 80, 'https://images.unsplash.com/photo-1600521853186-93b88b3a07b0?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTR8fGNyb2lzc2FudHxlbnwwfHwwfHx8MA%3D%3D', 'Available', '2025-08-09 13:05:54.645');

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
  `NgayThanhToan` datetime(3) NOT NULL,
  `TrangThai` enum('Pending','Completed','Failed') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `thanhtoan`
--

INSERT INTO `thanhtoan` (`MaTT`, `MaDH`, `MaNV`, `PTTT`, `SoTien`, `NgayThanhToan`, `TrangThai`) VALUES
(1, 1, NULL, 'Tiền mặt', 120000.00, '2025-08-13 14:27:39.000', 'Completed');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime(3) NOT NULL DEFAULT current_timestamp(3),
  `role` enum('admin','member','staff') NOT NULL DEFAULT 'member'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `created_at`, `role`) VALUES
(1, 'admin', 'admin@parrotsmell.com', '$2a$12$fBFdn7JgFcUO/HtCQfJGFu3KQdB4Bp7YhAR0RRgmV.D8EeKJFBZ0O', '2025-08-09 13:05:54.583', 'admin'),
(4, 'phuongnh0954', 'phuongnh0954@ut.edu.vn', '$2y$10$mVSuZiC63dOMRTGzrbEAJOM18d3zZ9QLDMHRb/8U.je33LN71G3hy', '2025-08-13 22:02:33.456', 'member');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vanchuyen`
--

CREATE TABLE `vanchuyen` (
  `MaGH` int(11) NOT NULL,
  `MaDH` int(11) NOT NULL,
  `DVVC` varchar(100) DEFAULT NULL,
  `MaVanDon` varchar(50) DEFAULT NULL,
  `PhiShip` decimal(10,2) NOT NULL DEFAULT 0.00,
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
  ADD KEY `MaDonHang` (`MaDH`),
  ADD KEY `danhgia_MaSP_fkey` (`MaSP`);

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
-- Chỉ mục cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`MaGH`),
  ADD UNIQUE KEY `unique_customer_product` (`MaKH`,`MaSP`),
  ADD KEY `fk_giohang_khachhang` (`MaKH`),
  ADD KEY `fk_giohang_sanpham` (`MaSP`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`MaKH`),
  ADD UNIQUE KEY `khachhang_user_id_key` (`user_id`),
  ADD UNIQUE KEY `khachhang_Email_key` (`Email`),
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
  ADD UNIQUE KEY `nhanvien_user_id_key` (`user_id`),
  ADD UNIQUE KEY `nhanvien_Email_key` (`Email`),
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
  ADD UNIQUE KEY `users_email_key` (`email`),
  ADD UNIQUE KEY `users_username_key` (`username`);

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
  MODIFY `MaDM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `diachi`
--
ALTER TABLE `diachi`
  MODIFY `MaDC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `donhang`
--
ALTER TABLE `donhang`
  MODIFY `MaDH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `giohang`
--
ALTER TABLE `giohang`
  MODIFY `MaGH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `MaKH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT cho bảng `kho`
--
ALTER TABLE `kho`
  MODIFY `MaKho` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `khuyenmai`
--
ALTER TABLE `khuyenmai`
  MODIFY `MaKM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `MaNV` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `phankhuckh`
--
ALTER TABLE `phankhuckh`
  MODIFY `MaPK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `MaSP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `thanhtoan`
--
ALTER TABLE `thanhtoan`
  MODIFY `MaTT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  ADD CONSTRAINT `baocao_MaNV_fkey` FOREIGN KEY (`MaNV`) REFERENCES `nhanvien` (`MaNV`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD CONSTRAINT `chitietdonhang_MaDH_fkey` FOREIGN KEY (`MaDH`) REFERENCES `donhang` (`MaDH`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chitietdonhang_MaSP_fkey` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `danhgia`
--
ALTER TABLE `danhgia`
  ADD CONSTRAINT `danhgia_MaDH_fkey` FOREIGN KEY (`MaDH`) REFERENCES `donhang` (`MaDH`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `danhgia_MaKH_fkey` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `danhgia_MaSP_fkey` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `diachi`
--
ALTER TABLE `diachi`
  ADD CONSTRAINT `diachi_MaKH_fkey` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `donhang_MaDC_fkey` FOREIGN KEY (`MaDC`) REFERENCES `diachi` (`MaDC`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `donhang_MaKH_fkey` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `donhang_MaKhuyenMai_fkey` FOREIGN KEY (`MaKhuyenMai`) REFERENCES `khuyenmai` (`MaKM`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `donhang_MaNV_fkey` FOREIGN KEY (`MaNV`) REFERENCES `nhanvien` (`MaNV`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD CONSTRAINT `fk_giohang_khachhang` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_giohang_sanpham` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD CONSTRAINT `khachhang_MaPK_fkey` FOREIGN KEY (`MaPK`) REFERENCES `phankhuckh` (`MaPK`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `khachhang_user_id_fkey` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `kho`
--
ALTER TABLE `kho`
  ADD CONSTRAINT `kho_MaNL_fkey` FOREIGN KEY (`MaNL`) REFERENCES `nguyenlieu` (`MaNL`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `kho_MaNV_fkey` FOREIGN KEY (`MaNV`) REFERENCES `nhanvien` (`MaNV`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `kho_MaSP_fkey` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `lichsu_donhang`
--
ALTER TABLE `lichsu_donhang`
  ADD CONSTRAINT `lichsu_donhang_MaDH_fkey` FOREIGN KEY (`MaDH`) REFERENCES `donhang` (`MaDH`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lichsu_donhang_MaNV_fkey` FOREIGN KEY (`MaNV`) REFERENCES `nhanvien` (`MaNV`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD CONSTRAINT `nhanvien_user_id_fkey` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `sanpham_MaDM_fkey` FOREIGN KEY (`MaDM`) REFERENCES `danhmuc` (`MaDM`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `thanhtoan`
--
ALTER TABLE `thanhtoan`
  ADD CONSTRAINT `thanhtoan_MaDH_fkey` FOREIGN KEY (`MaDH`) REFERENCES `donhang` (`MaDH`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `thanhtoan_MaNV_fkey` FOREIGN KEY (`MaNV`) REFERENCES `nhanvien` (`MaNV`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `vanchuyen`
--
ALTER TABLE `vanchuyen`
  ADD CONSTRAINT `vanchuyen_MaDH_fkey` FOREIGN KEY (`MaDH`) REFERENCES `donhang` (`MaDH`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
