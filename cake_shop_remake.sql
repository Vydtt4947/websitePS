-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 23, 2025 at 08:13 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cake_shop_remake`
--

-- --------------------------------------------------------

--
-- Table structure for table `chitietdonhang`
--

CREATE TABLE `chitietdonhang` (
  `MaDH` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `SoLuong` int(11) NOT NULL CHECK (`SoLuong` > 0),
  `DonGia` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `chitietdonhang`
--

INSERT INTO `chitietdonhang` (`MaDH`, `MaSP`, `SoLuong`, `DonGia`) VALUES
(44, 3, 1, 120000.00),
(46, 2, 2, 45000.00),
(46, 3, 2, 120000.00),
(46, 6, 2, 750000.00),
(47, 4, 1, 35000.00),
(48, 3, 1, 120000.00),
(49, 3, 1, 120000.00),
(50, 3, 2, 120000.00),
(51, 3, 1, 120000.00),
(52, 3, 1, 120000.00),
(53, 1, 1, 85000.00),
(53, 2, 1, 45000.00),
(53, 3, 1, 120000.00),
(53, 4, 1, 35000.00),
(53, 5, 1, 500000.00),
(53, 6, 1, 750000.00),
(54, 5, 1, 500000.00),
(54, 6, 1, 750000.00),
(55, 4, 1, 35000.00),
(56, 2, 1, 45000.00),
(57, 3, 1, 120000.00),
(57, 4, 1, 35000.00),
(57, 8, 1, 500000.00),
(58, 3, 1, 120000.00),
(58, 4, 2, 35000.00),
(59, 6, 1, 750000.00),
(60, 3, 1, 120000.00),
(60, 4, 1, 35000.00),
(60, 8, 1, 500000.00),
(61, 5, 1, 500000.00),
(61, 6, 1, 750000.00),
(62, 2, 1, 45000.00);

-- --------------------------------------------------------

--
-- Table structure for table `danhgia`
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

--
-- Dumping data for table `danhgia`
--

INSERT INTO `danhgia` (`MaDG`, `MaKH`, `MaDH`, `SoSao`, `NoiDung`, `DanhGia`, `NgayDanhGia`, `MaSP`) VALUES
(7, 100, 61, 4, 'ngon đó', NULL, '2025-08-23', 6),
(8, 100, 62, 3, 'ffegrghrh', NULL, '2025-08-23', 2);

-- --------------------------------------------------------

--
-- Table structure for table `danhmuc`
--

CREATE TABLE `danhmuc` (
  `MaDM` int(11) NOT NULL,
  `TenDanhMuc` varchar(100) NOT NULL,
  `MoTa` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `danhmuc`
--

INSERT INTO `danhmuc` (`MaDM`, `TenDanhMuc`, `MoTa`) VALUES
(1, 'Bánh ngọt', 'Các loại bánh ngọt truyền thống và hiện đại'),
(2, 'Bánh mì', 'Bánh mì tươi và các loại bánh mì đặc biệt'),
(3, 'Bánh kem', 'Bánh kem sinh nhật và các dịp đặc biệt');

-- --------------------------------------------------------

--
-- Table structure for table `diachi`
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
-- Dumping data for table `diachi`
--

INSERT INTO `diachi` (`MaDC`, `SoNha`, `Phuong`, `Quan`, `ThanhPho`, `MaKH`) VALUES
(1, NULL, NULL, NULL, NULL, NULL),
(2, '140/11 Bình Thạnh', '27', 'Bình Thạnh', 'Bình Thạnh', NULL),
(3, '140/11 Bình Thạnh', '27', 'Bình Thạnh', 'Bình Thạnh', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `donhang`
--

CREATE TABLE `donhang` (
  `MaDH` int(11) NOT NULL,
  `MaKH` int(11) DEFAULT NULL,
  `MaNV` int(11) DEFAULT NULL,
  `NgayDatHang` datetime(3) NOT NULL,
  `TrangThai` enum('Pending','Processing','Shipping','Delivered','Cancelled') NOT NULL DEFAULT 'Pending',
  `PhuongThucThanhToan` varchar(50) NOT NULL DEFAULT 'cod',
  `MaKhuyenMai` int(11) DEFAULT NULL,
  `MaDC` int(11) DEFAULT NULL,
  `TongTien` decimal(12,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `donhang`
--

INSERT INTO `donhang` (`MaDH`, `MaKH`, `MaNV`, `NgayDatHang`, `TrangThai`, `PhuongThucThanhToan`, `MaKhuyenMai`, `MaDC`, `TongTien`) VALUES
(44, NULL, NULL, '2025-08-15 22:36:45.000', 'Delivered', 'cod', NULL, NULL, 120000.00),
(45, NULL, NULL, '2025-08-15 23:06:14.000', 'Cancelled', 'cod', NULL, NULL, 237500.00),
(46, NULL, NULL, '2025-08-15 23:41:55.000', 'Cancelled', 'bank', NULL, NULL, 1098000.00),
(47, NULL, NULL, '2025-08-15 23:55:51.000', 'Cancelled', 'cod', NULL, NULL, 270750.00),
(48, NULL, NULL, '2025-08-16 13:54:43.000', 'Delivered', 'bank', NULL, NULL, 120000.00),
(49, NULL, NULL, '2025-08-16 16:40:40.000', 'Delivered', 'cod', NULL, NULL, 120000.00),
(50, NULL, NULL, '2025-08-16 17:14:59.000', 'Delivered', 'bank', NULL, NULL, 180000.00),
(51, NULL, NULL, '2025-08-16 17:22:26.000', 'Delivered', 'cod', NULL, NULL, 120000.00),
(52, NULL, NULL, '2025-08-16 17:29:28.000', 'Delivered', 'cod', NULL, NULL, 90000.00),
(53, NULL, NULL, '2025-08-16 18:25:28.000', 'Delivered', 'bank', NULL, NULL, 1071000.00),
(54, NULL, NULL, '2025-08-16 18:44:32.000', 'Cancelled', 'cod', NULL, NULL, 750000.00),
(55, NULL, NULL, '2025-08-16 18:53:00.000', 'Cancelled', 'cod', NULL, NULL, 50000.00),
(56, NULL, NULL, '2025-08-16 19:13:02.000', 'Pending', 'cod', NULL, NULL, 60000.00),
(57, NULL, NULL, '2025-08-20 06:44:05.000', 'Pending', 'bank', NULL, NULL, 393000.00),
(58, 95, NULL, '2025-08-22 21:53:00.000', 'Delivered', 'cod', NULL, NULL, 142500.00),
(59, 95, NULL, '2025-08-22 21:54:28.000', 'Delivered', 'bank', NULL, NULL, 450000.00),
(60, 99, NULL, '2025-08-22 22:04:50.000', 'Delivered', 'cod', NULL, NULL, 655000.00),
(61, 100, NULL, '2025-08-23 01:22:59.000', 'Delivered', 'cod', NULL, NULL, 750000.00),
(62, 100, NULL, '2025-08-23 23:17:29.000', 'Delivered', 'cod', NULL, NULL, 60000.00);

-- --------------------------------------------------------

--
-- Table structure for table `giohang`
--

CREATE TABLE `giohang` (
  `MaGH` int(11) NOT NULL,
  `MaKH` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `SoLuong` int(11) NOT NULL DEFAULT 1,
  `NgayThem` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `giohang`
--

INSERT INTO `giohang` (`MaGH`, `MaKH`, `MaSP`, `SoLuong`, `NgayThem`) VALUES
(90, 95, 3, 1, '2025-08-22 14:56:35');

-- --------------------------------------------------------

--
-- Table structure for table `khachhang`
--

CREATE TABLE `khachhang` (
  `MaKH` int(11) NOT NULL,
  `HoTen` varchar(100) NOT NULL,
  `SoDienThoai` varchar(15) DEFAULT NULL,
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
-- Dumping data for table `khachhang`
--

INSERT INTO `khachhang` (`MaKH`, `HoTen`, `SoDienThoai`, `Email`, `NgaySinh`, `DiemTichLuy`, `MaPK`, `user_id`, `created_at`, `MatKhau`, `DiaChiGiaoHang`, `TinhThanh`, `QuanHuyen`, `GhiChuGiaoHang`) VALUES
(95, 'Nguyen Hoang Phuong', '0325093767', 'boyvncraft2272000@gmail.com', NULL, 0, 1, 15, '2025-08-22 21:51:00.730', '$2y$10$wtQbWAJV//839KS.MFLaruKSMzP4CZoIyoGIbdySaeAgJPjUeLsX6', NULL, NULL, NULL, NULL),
(99, 'Phương Nguyễn Hoàng', '0325093757', 'cucxacdufong@gmail.com', NULL, 0, 1, NULL, '2025-08-22 22:04:50.227', NULL, NULL, NULL, NULL, NULL),
(100, 'Đinh Thúy Vy', '0348675235', 'dinhvy789@gmail.com', '2025-08-20', 0, 1, 20, '2025-08-23 00:37:04.068', '$2y$10$q9vtwhAGyA0g1tDWyte92eUzXVLNC6Gc.rI7eBLYaapqUF2y7wRGa', '123 Đường A', 'TP. Hồ Chí Minh', 'Quận 1', ''),
(101, 'Lê văn A', '0654987123', 'levana@gmail.com', NULL, 0, NULL, 25, '2025-08-23 23:34:18.115', '$2y$10$boYPPCLynjK5v9UdpXZdC.YwR67WMFN7DaLymIxbTyAZ.hDAztYty', NULL, NULL, NULL, NULL);

--
-- Triggers `khachhang`
--
DELIMITER $$
CREATE TRIGGER `tr_khachhang_delete_user` AFTER DELETE ON `khachhang` FOR EACH ROW BEGIN
  IF OLD.user_id IS NOT NULL THEN
    DELETE FROM users WHERE user_id = OLD.user_id;
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `kho`
--

CREATE TABLE `kho` (
  `MaKho` int(11) NOT NULL,
  `MaSP` int(11) DEFAULT NULL,
  `MaNV` int(11) DEFAULT NULL,
  `MaNL` int(11) DEFAULT NULL,
  `NgayGiaoDich` datetime(3) NOT NULL,
  `LoaiGiaoDich` enum('Nhap','Xuat') NOT NULL,
  `SoLuong` int(11) NOT NULL CHECK (`SoLuong` > 0)
) ;

--
-- Dumping data for table `kho`
--

INSERT INTO `kho` (`MaKho`, `MaSP`, `MaNV`, `MaNL`, `NgayGiaoDich`, `LoaiGiaoDich`, `SoLuong`) VALUES
(2, 8, 8, NULL, '2025-08-23 23:41:40.242', 'Nhap', 9),
(3, 6, 8, NULL, '2025-08-23 23:42:37.670', 'Nhap', 10),
(4, 2, 8, NULL, '2025-08-23 23:42:54.737', 'Xuat', 16);

-- --------------------------------------------------------

--
-- Table structure for table `khuyenmai`
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
-- Dumping data for table `khuyenmai`
--

INSERT INTO `khuyenmai` (`MaKM`, `TenKM`, `MoTa`, `PhanTramGiamGia`, `SoTienGiamGia`, `NgayBatDau`, `NgayKetThuc`) VALUES
(1, 'WELCOME10', 'Giảm 10% cho khách hàng mới', 10.00, NULL, '2025-08-09', '2025-09-08'),
(2, 'FREESHIP', 'Miễn phí vận chuyển cho đơn hàng trên 500k', NULL, 30000.00, '2025-08-09', '2025-10-08'),
(3, 'LEQUOCKHANH', 'Nhân dịp Quốc Khánh 2/9, cửa hàng giảm giá đặc biệt cho tất cả các loại bánh ngọt và bánh kem.', 20.00, NULL, '2025-08-30', '2025-09-03');

-- --------------------------------------------------------

--
-- Table structure for table `lichsu_donhang`
--

CREATE TABLE `lichsu_donhang` (
  `MaLS` int(11) NOT NULL,
  `MaDH` int(11) NOT NULL,
  `NgayThayDoi` datetime(3) NOT NULL DEFAULT current_timestamp(3),
  `GhiChu` text DEFAULT NULL,
  `MaNV` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nguyenlieu`
--

CREATE TABLE `nguyenlieu` (
  `MaNL` int(11) NOT NULL,
  `TenNL` varchar(100) NOT NULL,
  `MoTa` text DEFAULT NULL,
  `DonViTinh` varchar(20) NOT NULL,
  `SoLuong` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `nguyenlieu`
--

INSERT INTO `nguyenlieu` (`MaNL`, `TenNL`, `MoTa`, `DonViTinh`, `SoLuong`) VALUES
(1, 'Bột mì số 11', 'Dùng làm bánh mì, bánh ngọt, có độ protein cao', 'kg', 50),
(2, 'Bơ lạt Anchor', 'Bơ nhạt nhập khẩu, dùng làm bánh', 'kg', 20),
(3, 'Đường cát trắng', 'Nguyên liệu cơ bản cho các loại bánh', 'kg', 100),
(4, 'Trứng gà', 'Trứng gà tươi, size M', 'quả', 300),
(5, 'Sữa tươi không đường', 'Dùng để làm bánh flan, gato, tiramisu', 'lít', 30),
(6, 'Sô cô la đen', 'Chocolate nguyên chất 70%', 'kg', 10),
(7, 'Kem whipping cream', 'Kem béo động vật', 'ml', 5000),
(8, 'Bột cacao nguyên chất', 'Bột cacao dùng để làm bánh, pha chế', 'kg', 15),
(9, 'Men nở instant', 'Men khô dùng trong làm bánh mì', 'gói', 40),
(10, 'Bột nở (baking powder)', 'Dùng trong các loại bánh nở nhanh', 'gói', 25);

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

CREATE TABLE `nhanvien` (
  `MaNV` int(11) NOT NULL,
  `HoTen` varchar(100) NOT NULL,
  `SoDienThoai` varchar(15) DEFAULT NULL,
  `CCCD` varchar(20) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `NgaySinh` date NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `nhanvien`
--

INSERT INTO `nhanvien` (`MaNV`, `HoTen`, `SoDienThoai`, `CCCD`, `Email`, `NgaySinh`, `user_id`) VALUES
(7, 'Lương Tú Linh', '0909123456', '087305014946', 'tulinhkhung123@gmail.com', '1999-06-15', 23),
(8, 'Admin', '0909123456', '083234821234', 'admin@parrotsmell.com', '2002-05-23', 24);

--
-- Triggers `nhanvien`
--
DELIMITER $$
CREATE TRIGGER `tr_nhanvien_delete_user` AFTER DELETE ON `nhanvien` FOR EACH ROW BEGIN
  IF OLD.user_id IS NOT NULL THEN
    DELETE FROM users WHERE user_id = OLD.user_id;
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `phankhuckh`
--

CREATE TABLE `phankhuckh` (
  `MaPK` int(11) NOT NULL,
  `TenPK` varchar(100) NOT NULL,
  `MoTa` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `phankhuckh`
--

INSERT INTO `phankhuckh` (`MaPK`, `TenPK`, `MoTa`) VALUES
(1, 'Bronze', 'Khách hàng Bronze - Chi tiêu từ 500,000đ'),
(2, 'Silver', 'Khách hàng Silver - Chi tiêu từ 1,000,000đ'),
(3, 'Gold', 'Khách hàng Gold - Chi tiêu từ 2,000,000đ'),
(4, 'Platinum', 'Khách hàng Platinum - Chi tiêu từ 5,000,000đ'),
(5, 'Diamond', 'Khách hàng Diamond - Chi tiêu từ 10,000,000đ'),
(6, 'VIP', 'Khách hàng VIP - Chi tiêu từ 20,000,000đ');

-- --------------------------------------------------------

--
-- Table structure for table `sanpham`
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
-- Dumping data for table `sanpham`
--

INSERT INTO `sanpham` (`MaSP`, `TenSP`, `MoTa`, `DonGia`, `MaDM`, `SoLuong`, `HinhAnh`, `TrangThai`, `NgayThem`) VALUES
(1, 'Bánh Tiramisu', 'Bánh tiramisu truyền thống Ý với hương vị cà phê đậm đà', 85000.00, 1, 50, 'https://images.unsplash.com/photo-1714385905983-6f8e06fffae1?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'Available', '2025-08-09 13:05:54.645'),
(2, 'Bánh Mì Sourdough', 'Bánh mì sourdough với vỏ giòn và ruột mềm', 45000.00, 2, 84, 'https://plus.unsplash.com/premium_photo-1664640733898-d5c3f71f44e1?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'Available', '2025-08-09 13:05:54.645'),
(3, 'Bánh Chocolate Cake', 'Bánh chocolate đen với kem tươi', 120000.00, 3, 29, 'https://images.unsplash.com/photo-1606890737304-57a1ca8a5b62?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8Y2hvY29sYXRlJTIwY2FrZXxlbnwwfHwwfHx8MA%3D%3D', 'Available', '2025-08-09 13:05:54.645'),
(4, 'Bánh Croissant', 'Bánh croissant Pháp với lớp vỏ xốp giòn', 35000.00, 2, 86, 'https://images.unsplash.com/photo-1600521853186-93b88b3a07b0?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTR8fGNyb2lzc2FudHxlbnwwfHwwfHx8MA%3D%3D', 'Available', '2025-08-09 13:05:54.645'),
(5, 'Bánh Kem Mây Hồng', 'Bánh kem 2 tầng phủ sốt dâu hồng, xen kẽ lớp kem tươi mịn, trang trí mâm xôi tươi bắt mắt – lựa chọn hoàn hảo cho mọi bữa tiệc ngọt ngào!', 500000.00, 3, 0, 'https://plus.unsplash.com/premium_photo-1713447395823-2e0b40b75a89?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8Y2FrZXxlbnwwfHwwfHx8MA%3D%3D', 'Available', '2025-08-15 12:17:51.378'),
(6, 'Bánh Kem Trái Tim Anh Đào', 'Bánh kem hình trái tim với lớp kem phủ màu trắng ngà tinh tế, viền quanh bằng những chấm kem nhỏ xinh, tạo cảm giác mềm mại và sang trọng. Trên mặt bánh nổi bật với một quả anh đào đỏ tươi đặt trên lớp kem tươi cuộn tròn, làm điểm nhấn ngọt ngào và lãng mạn. Thiết kế đơn giản nhưng rất thanh lịch, phù hợp để tặng người thương, sinh nhật, kỷ niệm tình yêu hoặc các dịp đặc biệt.', 750000.00, 3, 10, 'https://plus.unsplash.com/premium_photo-1679047666503-28884e055869?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MjV8fGNha2V8ZW58MHx8MHx8fDA%3D', 'Available', '2025-08-15 12:25:00.371'),
(8, 'Bánh Cam Mọng Nước', 'Bánh gồm nhiều lớp bông lan mềm mịn, xen kẽ các lớp kem cam tươi mát, phủ trên cùng là lớp thạch cam óng ánh và trang trí thêm một lát cam cùng trái việt quất tươi nổi bật. Hương vị bánh thơm ngọt, chua nhẹ, kết hợp vị tươi mát của cam và sự mềm mại của bông lan, tạo cảm giác thanh nhẹ, sảng khoái. Phù hợp làm món tráng miệng, dùng kèm trà chiều hoặc trong các buổi tiệc nhẹ.', 500000.00, 3, 9, 'https://images.unsplash.com/photo-1642069251474-5cc71cfdf49b?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8Y2FrZSUyMHN3ZWV0fGVufDB8fDB8fHww', 'Available', '2025-08-16 20:56:52.518');

-- --------------------------------------------------------

--
-- Table structure for table `thanhtoan`
--

CREATE TABLE `thanhtoan` (
  `MaTT` int(11) NOT NULL,
  `MaDH` int(11) NOT NULL,
  `MaNV` int(11) DEFAULT NULL,
  `PTTT` varchar(100) NOT NULL,
  `SoTien` decimal(12,2) NOT NULL,
  `NgayThanhToan` datetime(3) NOT NULL,
  `TrangThai` enum('Pending','Completed','Failed') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
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
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `created_at`, `role`) VALUES
(15, 'boyvncraft2272000', 'boyvncraft2272000@gmail.com', '$2y$10$wtQbWAJV//839KS.MFLaruKSMzP4CZoIyoGIbdySaeAgJPjUeLsX6', '2025-08-22 21:51:00.728', 'member'),
(20, 'dinhvy789', 'dinhvy789@gmail.com', '$2y$10$q9vtwhAGyA0g1tDWyte92eUzXVLNC6Gc.rI7eBLYaapqUF2y7wRGa', '2025-08-23 00:37:04.067', 'member'),
(23, 'tulinhkhung123', 'tulinhkhung123@gmail.com', '$2y$10$/atDr3KdCada.ZrnCDo33uPWkWkLCzIPhrMvemA0b2uUPD6uytQ7K', '2025-08-23 01:04:16.667', 'staff'),
(24, 'admin', 'admin@parrotsmell.com', '$2y$10$8FtcO3K1aXNOvFxhAR2T/OQq2LMmWpXNckhYaRTqvdji0l9IAVveq', '2025-08-23 01:06:09.701', 'admin'),
(25, 'levana', 'levana@gmail.com', '$2y$10$boYPPCLynjK5v9UdpXZdC.YwR67WMFN7DaLymIxbTyAZ.hDAztYty', '2025-08-23 23:34:18.111', 'member');

-- --------------------------------------------------------

--
-- Table structure for table `vanchuyen`
--

CREATE TABLE `vanchuyen` (
  `MaGH` int(11) NOT NULL,
  `MaDH` int(11) NOT NULL,
  `DVVC` varchar(100) NOT NULL,
  `MaVanDon` varchar(50) DEFAULT NULL,
  `PhiShip` decimal(10,2) NOT NULL DEFAULT 0.00,
  `NgayGiaoHang` date DEFAULT NULL,
  `NgayNhanHangDuKien` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD PRIMARY KEY (`MaDH`,`MaSP`),
  ADD KEY `MaSP` (`MaSP`);

--
-- Indexes for table `danhgia`
--
ALTER TABLE `danhgia`
  ADD PRIMARY KEY (`MaDG`),
  ADD KEY `MaKH` (`MaKH`),
  ADD KEY `MaDonHang` (`MaDH`),
  ADD KEY `danhgia_MaSP_fkey` (`MaSP`);

--
-- Indexes for table `danhmuc`
--
ALTER TABLE `danhmuc`
  ADD PRIMARY KEY (`MaDM`);

--
-- Indexes for table `diachi`
--
ALTER TABLE `diachi`
  ADD PRIMARY KEY (`MaDC`),
  ADD KEY `MaKH` (`MaKH`);

--
-- Indexes for table `donhang`
--
ALTER TABLE `donhang`
  ADD PRIMARY KEY (`MaDH`),
  ADD KEY `MaKH` (`MaKH`),
  ADD KEY `MaNV` (`MaNV`),
  ADD KEY `MaDiaChiGiaoHang` (`MaDC`),
  ADD KEY `MaKhuyenMai` (`MaKhuyenMai`);

--
-- Indexes for table `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`MaGH`),
  ADD UNIQUE KEY `unique_customer_product` (`MaKH`,`MaSP`),
  ADD KEY `fk_giohang_khachhang` (`MaKH`),
  ADD KEY `fk_giohang_sanpham` (`MaSP`);

--
-- Indexes for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`MaKH`),
  ADD UNIQUE KEY `khachhang_user_id_key` (`user_id`),
  ADD UNIQUE KEY `khachhang_Email_key` (`Email`),
  ADD KEY `MaPK` (`MaPK`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `kho`
--
ALTER TABLE `kho`
  ADD PRIMARY KEY (`MaKho`),
  ADD KEY `MaSP` (`MaSP`),
  ADD KEY `MaNL` (`MaNL`),
  ADD KEY `MaNV` (`MaNV`);

--
-- Indexes for table `khuyenmai`
--
ALTER TABLE `khuyenmai`
  ADD PRIMARY KEY (`MaKM`);

--
-- Indexes for table `lichsu_donhang`
--
ALTER TABLE `lichsu_donhang`
  ADD PRIMARY KEY (`MaLS`),
  ADD KEY `MaDH` (`MaDH`),
  ADD KEY `MaNV` (`MaNV`);

--
-- Indexes for table `nguyenlieu`
--
ALTER TABLE `nguyenlieu`
  ADD PRIMARY KEY (`MaNL`);

--
-- Indexes for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`MaNV`),
  ADD UNIQUE KEY `nhanvien_user_id_key` (`user_id`),
  ADD UNIQUE KEY `nhanvien_Email_key` (`Email`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `phankhuckh`
--
ALTER TABLE `phankhuckh`
  ADD PRIMARY KEY (`MaPK`);

--
-- Indexes for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`MaSP`),
  ADD KEY `MaDM` (`MaDM`);

--
-- Indexes for table `thanhtoan`
--
ALTER TABLE `thanhtoan`
  ADD PRIMARY KEY (`MaTT`),
  ADD KEY `MaDonHang` (`MaDH`),
  ADD KEY `MaNV` (`MaNV`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `users_email_key` (`email`),
  ADD UNIQUE KEY `users_username_key` (`username`);

--
-- Indexes for table `vanchuyen`
--
ALTER TABLE `vanchuyen`
  ADD PRIMARY KEY (`MaGH`),
  ADD KEY `MaDonHang` (`MaDH`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `danhgia`
--
ALTER TABLE `danhgia`
  MODIFY `MaDG` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `danhmuc`
--
ALTER TABLE `danhmuc`
  MODIFY `MaDM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `diachi`
--
ALTER TABLE `diachi`
  MODIFY `MaDC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `donhang`
--
ALTER TABLE `donhang`
  MODIFY `MaDH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `giohang`
--
ALTER TABLE `giohang`
  MODIFY `MaGH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `MaKH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `kho`
--
ALTER TABLE `kho`
  MODIFY `MaKho` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `khuyenmai`
--
ALTER TABLE `khuyenmai`
  MODIFY `MaKM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lichsu_donhang`
--
ALTER TABLE `lichsu_donhang`
  MODIFY `MaLS` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nguyenlieu`
--
ALTER TABLE `nguyenlieu`
  MODIFY `MaNL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `MaNV` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `phankhuckh`
--
ALTER TABLE `phankhuckh`
  MODIFY `MaPK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `MaSP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `thanhtoan`
--
ALTER TABLE `thanhtoan`
  MODIFY `MaTT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `vanchuyen`
--
ALTER TABLE `vanchuyen`
  MODIFY `MaGH` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD CONSTRAINT `chitietdonhang_MaDH_fkey` FOREIGN KEY (`MaDH`) REFERENCES `donhang` (`MaDH`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chitietdonhang_MaSP_fkey` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `danhgia`
--
ALTER TABLE `danhgia`
  ADD CONSTRAINT `danhgia_MaDH_fkey` FOREIGN KEY (`MaDH`) REFERENCES `donhang` (`MaDH`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `danhgia_MaKH_fkey` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `danhgia_MaSP_fkey` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `diachi`
--
ALTER TABLE `diachi`
  ADD CONSTRAINT `diachi_MaKH_fkey` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `donhang_MaDC_fkey` FOREIGN KEY (`MaDC`) REFERENCES `diachi` (`MaDC`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `donhang_MaKH_fkey` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `donhang_MaKhuyenMai_fkey` FOREIGN KEY (`MaKhuyenMai`) REFERENCES `khuyenmai` (`MaKM`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `donhang_MaNV_fkey` FOREIGN KEY (`MaNV`) REFERENCES `nhanvien` (`MaNV`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `giohang`
--
ALTER TABLE `giohang`
  ADD CONSTRAINT `fk_giohang_khachhang` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_giohang_sanpham` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`) ON DELETE CASCADE;

--
-- Constraints for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD CONSTRAINT `khachhang_MaPK_fkey` FOREIGN KEY (`MaPK`) REFERENCES `phankhuckh` (`MaPK`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `khachhang_user_id_fkey` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `kho`
--
ALTER TABLE `kho`
  ADD CONSTRAINT `kho_MaNL_fkey` FOREIGN KEY (`MaNL`) REFERENCES `nguyenlieu` (`MaNL`) ON UPDATE CASCADE,
  ADD CONSTRAINT `kho_MaNV_fkey` FOREIGN KEY (`MaNV`) REFERENCES `nhanvien` (`MaNV`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `kho_MaSP_fkey` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`) ON UPDATE CASCADE;

--
-- Constraints for table `lichsu_donhang`
--
ALTER TABLE `lichsu_donhang`
  ADD CONSTRAINT `lichsu_donhang_MaDH_fkey` FOREIGN KEY (`MaDH`) REFERENCES `donhang` (`MaDH`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lichsu_donhang_MaNV_fkey` FOREIGN KEY (`MaNV`) REFERENCES `nhanvien` (`MaNV`) ON UPDATE CASCADE;

--
-- Constraints for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD CONSTRAINT `nhanvien_user_id_fkey` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `sanpham_MaDM_fkey` FOREIGN KEY (`MaDM`) REFERENCES `danhmuc` (`MaDM`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `thanhtoan`
--
ALTER TABLE `thanhtoan`
  ADD CONSTRAINT `thanhtoan_MaDH_fkey` FOREIGN KEY (`MaDH`) REFERENCES `donhang` (`MaDH`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `thanhtoan_MaNV_fkey` FOREIGN KEY (`MaNV`) REFERENCES `nhanvien` (`MaNV`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `vanchuyen`
--
ALTER TABLE `vanchuyen`
  ADD CONSTRAINT `vanchuyen_MaDH_fkey` FOREIGN KEY (`MaDH`) REFERENCES `donhang` (`MaDH`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
