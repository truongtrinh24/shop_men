-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 01, 2025 lúc 05:14 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `shop_men`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `account`
--

CREATE TABLE `account` (
  `account_id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `status_account` tinyint(1) NOT NULL DEFAULT 1,
  `customer_email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`account_id`, `password`, `role_id`, `status_account`, `customer_email`) VALUES
(1, 'admin123', 1, 1, 'admin@gmail.com'),
(2, 'emp123', 2, 1, 'employee@gmail.com'),
(3, 'trg113115', 3, 1, 'trinhtruong25303@gmail.com'),
(4, 'cust456', 3, 1, 'customer2@example.com'),
(5, 'cust789', 3, 1, 'customer3@example.com'),
(6, 'cust101', 3, 1, 'customer4@example.com'),
(7, 'cust112', 3, 1, 'customer5@example.com'),
(8, 'cust131', 3, 1, 'customer6@example.com'),
(9, 'cust415', 3, 1, 'customer7@example.com'),
(10, 'cust161', 3, 1, 'customer8@example.com');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `activity`
--

CREATE TABLE `activity` (
  `id` int(11) NOT NULL,
  `activity_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `activity`
--

INSERT INTO `activity` (`id`, `activity_name`) VALUES
(1, 'Quản lý sản phẩm'),
(2, 'Xử lý đơn hàng'),
(3, 'Quản lý khách hàng'),
(4, 'Nhập hàng'),
(5, 'Kiểm kho'),
(6, 'Quản lý giảm giá'),
(7, 'Xem báo cáo'),
(8, 'Hỗ trợ khách hàng'),
(9, 'Quản lý nhân viên'),
(10, 'Cập nhật thông tin');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`id`, `account_id`, `product_id`, `quantity`) VALUES
(1, 3, 2, 2),
(2, 4, 2, 1),
(3, 5, 2, 3),
(4, 6, 2, 1),
(5, 7, 2, 4),
(6, 8, 2, 2),
(7, 9, 2, 1),
(8, 10, 2, 3),
(9, 3, 2, 2),
(10, 4, 2, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `id_type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`id`, `name`, `id_type`) VALUES
(1, 'Áo thun', 1),
(2, 'Áo sơ mi', 1),
(3, 'Áo polo', 1),
(4, 'Quần short', 2),
(5, 'Quần tây', 2),
(6, 'Quần jean', 2),
(7, 'Quần kaki', 2),
(9, 'Áo khoác', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category_type`
--

CREATE TABLE `category_type` (
  `id` int(11) NOT NULL,
  `name_category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `category_type`
--

INSERT INTO `category_type` (`id`, `name_category`) VALUES
(1, 'Áo nam'),
(2, 'Quần Nam');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `color`
--

CREATE TABLE `color` (
  `id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `color`
--

INSERT INTO `color` (`id`, `description`) VALUES
(1, 'Trắng'),
(2, 'Đen'),
(3, 'Xanh dương'),
(4, 'Đỏ'),
(5, 'Vàng'),
(6, 'Xám'),
(7, 'Nâu'),
(8, 'Hồng'),
(9, 'Tím'),
(10, 'Xanh lá');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_address` text DEFAULT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `customer_address`, `customer_phone`, `customer_email`, `account_id`) VALUES
(1, 'Admin User', 'Hà Nội', '0912345678', 'admin@gmail.com', 1),
(2, 'Employee User', 'TP.HCM', '0987654321', 'employee@gmail.com', 2),
(3, 'Trịnh Trường', 'Đà Nẵng', '0935123456', 'trinhtruong25303@gmail.com', 3),
(4, 'Customer 2', 'Cần Thơ', '0909123456', 'customer2@example.com', 4),
(5, 'Customer 3', 'Hải Phòng', '0978123456', 'customer3@example.com', 5),
(6, 'Customer 4', 'Nha Trang', '0945123456', 'customer4@example.com', 6),
(7, 'Customer 5', 'Huế', '0923123456', 'customer5@example.com', 7),
(8, 'Customer 6', 'Vũng Tàu', '0967123456', 'customer6@example.com', 8),
(9, 'Customer 7', 'Quy Nhơn', '0918123456', 'customer7@example.com', 9),
(10, 'Customer 8', 'Pleiku', '0933123456', 'customer8@example.com', 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `detail_import`
--

CREATE TABLE `detail_import` (
  `import_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `detail_task_role`
--

CREATE TABLE `detail_task_role` (
  `role_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `detail_task_role`
--

INSERT INTO `detail_task_role` (`role_id`, `task_id`, `activity_id`) VALUES
(1, 1, 1),
(1, 2, 2),
(1, 3, 3),
(1, 9, 9),
(2, 2, 2),
(2, 4, 4),
(2, 5, 5),
(2, 8, 7),
(3, 6, 8),
(3, 7, 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `discount`
--

CREATE TABLE `discount` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount_percentage` decimal(5,2) NOT NULL,
  `max_discount` decimal(10,2) DEFAULT NULL,
  `min_order_value` decimal(10,2) DEFAULT NULL,
  `expiry_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `discount`
--

INSERT INTO `discount` (`id`, `code`, `discount_percentage`, `max_discount`, `min_order_value`, `expiry_date`, `created_at`) VALUES
(1, 'FREESHIP', 100.00, 50000.00, 350000.00, '2025-04-30', '2025-03-29 02:00:00'),
(2, 'SALE20', 20.00, 100000.00, 500000.00, '2025-05-15', '2025-03-29 02:00:00'),
(3, 'SALE15', 15.00, 75000.00, 300000.00, '2025-06-01', '2025-03-29 02:00:00'),
(4, 'NEWUSER', 25.00, 120000.00, 400000.00, '2025-07-01', '2025-03-29 02:00:00'),
(5, 'SUMMER5', 5.00, 30000.00, 150000.00, '2025-08-15', '2025-03-29 02:00:00'),
(6, 'FLASH30', 30.00, 150000.00, 600000.00, '2025-04-10', '2025-03-29 02:00:00'),
(7, 'WEEKEND10', 10.00, 60000.00, 250000.00, '2025-05-20', '2025-03-29 02:00:00'),
(8, 'VIP15', 15.00, 90000.00, 350000.00, '2025-06-30', '2025-03-29 02:00:00'),
(9, 'HOLIDAY20', 20.00, 110000.00, 450000.00, '2025-12-31', '2025-03-29 02:00:00'),
(10, 'BACK2SCHOOL', 10.00, 40000.00, 200000.00, '2025-09-01', '2025-03-29 02:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `employee_name` varchar(255) NOT NULL,
  `employee_phone` varchar(20) DEFAULT NULL,
  `employee_address` text DEFAULT NULL,
  `employee_email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `employee`
--

INSERT INTO `employee` (`id`, `employee_name`, `employee_phone`, `employee_address`, `employee_email`) VALUES
(1, 'Nguyễn Văn X', '0912345671', 'Hà Nội', 'employee1@example.com'),
(2, 'Trần Thị Y', '0987654322', 'TP.HCM', 'employee2@example.com'),
(3, 'Lê Văn Z', '0935123457', 'Đà Nẵng', 'employee3@example.com'),
(4, 'Phạm Thị W', '0909123457', 'Cần Thơ', 'employee4@example.com'),
(5, 'Hoàng Văn T', '0978123457', 'Hải Phòng', 'employee5@example.com'),
(6, 'Ngô Thị U', '0945123457', 'Nha Trang', 'employee6@example.com'),
(7, 'Đỗ Văn V', '0923123457', 'Huế', 'employee7@example.com'),
(8, 'Bùi Thị Q', '0967123457', 'Vũng Tàu', 'employee8@example.com'),
(9, 'Vũ Văn R', '0918123457', 'Quy Nhơn', 'employee9@example.com'),
(10, 'Lý Thị S', '0933123457', 'Pleiku', 'employee10@example.com');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `import`
--

CREATE TABLE `import` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `date_import` date NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `import`
--

INSERT INTO `import` (`id`, `supplier_id`, `employee_id`, `date_import`, `total`) VALUES
(1, 1, 1, '2025-03-01', 1500000.00),
(2, 2, 2, '2025-03-02', 1600000.00),
(3, 3, 3, '2025-03-03', 1550000.00),
(4, 4, 4, '2025-03-04', 1450000.00),
(5, 5, 5, '2025-03-05', 1500000.00),
(6, 6, 6, '2025-03-06', 1480000.00),
(7, 7, 7, '2025-03-07', 1520000.00),
(8, 8, 8, '2025-03-08', 1570000.00),
(9, 9, 9, '2025-03-09', 1490000.00),
(10, 10, 10, '2025-03-10', 1530000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status_order_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `discount_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `account_id`, `total_price`, `status_order_id`, `created_at`, `discount_id`, `employee_id`) VALUES
(1, 3, 400000.00, 1, '2025-03-29 03:00:00', 1, 1),
(2, 4, 200000.00, 2, '2025-03-29 03:05:00', NULL, 2),
(3, 5, 600000.00, 3, '2025-03-29 03:10:00', 2, 3),
(4, 6, 200000.00, 1, '2025-03-29 03:15:00', NULL, 4),
(5, 7, 800000.00, 2, '2025-03-29 03:20:00', 3, 5),
(6, 8, 400000.00, 3, '2025-03-29 03:25:00', 1, 6),
(7, 9, 200000.00, 1, '2025-03-29 03:30:00', NULL, 7),
(8, 10, 600000.00, 2, '2025-03-29 03:35:00', 2, 8),
(9, 3, 400000.00, 3, '2025-03-29 03:40:00', 1, 9),
(10, 4, 200000.00, 1, '2025-03-29 03:45:00', NULL, 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `product_image` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `Attribute` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `stock`, `category_id`, `description`, `created_at`, `product_image`, `quantity`, `Attribute`) VALUES
(1, 'Áo thun nam', 200000.00, 50, 1, 'Áo thun cotton thoáng mát', '2025-03-29 02:00:00', 'product1.png', 1, 'Size L, Màu trắng'),
(2, 'Quần jean nam', 350000.00, 30, 2, 'Quần jean ống suông', '2025-03-29 02:00:00', 'product1.png', 1, 'Size 32, Màu xanh'),
(3, 'Giày thể thao', 500000.00, 20, 3, 'Giày thể thao nhẹ', '2025-03-29 02:00:00', 'product1.png', 1, 'Size 42, Màu đen'),
(4, 'Mũ lưỡi trai', 100000.00, 100, 4, 'Mũ lưỡi trai thời trang', '2025-03-29 02:00:00', 'product1.png', 1, 'Màu xám'),
(5, 'Túi xách nữ', 450000.00, 15, 5, 'Túi xách da cao cấp', '2025-03-29 02:00:00', 'product1.png', 1, 'Màu nâu'),
(6, 'Áo sơ mi nam', 300000.00, 25, 6, 'Áo sơ mi công sở', '2025-03-29 02:00:00', 'product1.png', 1, 'Size M, Màu trắng'),
(7, 'Quần short nam', 150000.00, 40, 7, 'Quần short vải kaki', '2025-03-29 02:00:00', 'product1.png', 1, 'Size 30, Màu đen'),
(9, 'Áo khoác nam', 600000.00, 10, 9, 'Áo khoác chống gió', '2025-03-29 02:00:00', 'public/assets/clients/img/product1.png', 1, 'Size XL, Màu xanh');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_color`
--

CREATE TABLE `product_color` (
  `product_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product_color`
--

INSERT INTO `product_color` (`product_id`, `color_id`) VALUES
(1, 1),
(1, 9),
(2, 3),
(3, 2),
(4, 6),
(5, 7),
(6, 1),
(7, 2),
(9, 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `position` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `position`) VALUES
(1, 1, 'product1.png', 1),
(2, 1, 'product1.png', 1),
(3, 1, 'product1.png', 1),
(4, 4, 'images/hat1.jpg', 1),
(5, 5, 'images/bag1.jpg', 1),
(6, 6, 'images/shirt2.jpg', 1),
(7, 7, 'images/short1.jpg', 1),
(9, 9, 'images/jacket1.jpg', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_size`
--

CREATE TABLE `product_size` (
  `product_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product_size`
--

INSERT INTO `product_size` (`product_id`, `size_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 9),
(5, 10),
(6, 4),
(7, 5),
(9, 7);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'employee'),
(3, 'customer');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `size`
--

CREATE TABLE `size` (
  `id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `size`
--

INSERT INTO `size` (`id`, `description`) VALUES
(1, 'L'),
(2, '32'),
(3, '42'),
(4, 'M'),
(5, '30'),
(6, 'L'),
(7, 'XL'),
(8, 'M'),
(9, 'S'),
(10, 'XS');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `status_order`
--

CREATE TABLE `status_order` (
  `id` int(11) NOT NULL,
  `status_order_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `status_order`
--

INSERT INTO `status_order` (`id`, `status_order_name`) VALUES
(1, 'Chờ xác nhận'),
(2, 'Đã xác nhận'),
(3, 'Đã hủy');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `supplier_phone` varchar(20) DEFAULT NULL,
  `supplier_address` text DEFAULT NULL,
  `supplier_email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `supplier`
--

INSERT INTO `supplier` (`id`, `supplier_name`, `supplier_phone`, `supplier_address`, `supplier_email`) VALUES
(1, 'Công ty A', '0912345681', 'Hà Nội', 'supplier1@example.com'),
(2, 'Công ty B', '0987654332', 'TP.HCM', 'supplier2@example.com'),
(3, 'Công ty C', '0935123468', 'Đà Nẵng', 'supplier3@example.com'),
(4, 'Công ty D', '0909123468', 'Cần Thơ', 'supplier4@example.com'),
(5, 'Công ty E', '0978123468', 'Hải Phòng', 'supplier5@example.com'),
(6, 'Công ty F', '0945123468', 'Nha Trang', 'supplier6@example.com'),
(7, 'Công ty G', '0923123468', 'Huế', 'supplier7@example.com'),
(8, 'Công ty H', '0967123468', 'Vũng Tàu', 'supplier8@example.com'),
(9, 'Công ty I', '0918123468', 'Quy Nhơn', 'supplier9@example.com'),
(10, 'Công ty K', '0933123468', 'Pleiku', 'supplier10@example.com');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `task_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `task`
--

INSERT INTO `task` (`id`, `task_name`) VALUES
(1, 'Thêm sản phẩm'),
(2, 'Xác nhận đơn hàng'),
(3, 'Cập nhật thông tin khách hàng'),
(4, 'Nhập kho'),
(5, 'Kiểm tra tồn kho'),
(6, 'Hỗ trợ khách hàng'),
(7, 'Xem lịch sử đơn hàng'),
(8, 'Tạo báo cáo'),
(9, 'Quản lý nhân sự');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`account_id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `fk_account_customer_email` (`customer_email`);

--
-- Chỉ mục cho bảng `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category_type` (`id_type`);

--
-- Chỉ mục cho bảng `category_type`
--
ALTER TABLE `category_type`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `customer_email` (`customer_email`),
  ADD KEY `fk_customer_account` (`account_id`);

--
-- Chỉ mục cho bảng `detail_import`
--
ALTER TABLE `detail_import`
  ADD PRIMARY KEY (`import_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `detail_task_role`
--
ALTER TABLE `detail_task_role`
  ADD PRIMARY KEY (`role_id`,`task_id`,`activity_id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `activity_id` (`activity_id`);

--
-- Chỉ mục cho bảng `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Chỉ mục cho bảng `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_email` (`employee_email`);

--
-- Chỉ mục cho bảng `import`
--
ALTER TABLE `import`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `status_order_id` (`status_order_id`),
  ADD KEY `discount_id` (`discount_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `product_color`
--
ALTER TABLE `product_color`
  ADD PRIMARY KEY (`product_id`,`color_id`),
  ADD KEY `color_id` (`color_id`);

--
-- Chỉ mục cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `product_size`
--
ALTER TABLE `product_size`
  ADD PRIMARY KEY (`product_id`,`size_id`),
  ADD KEY `size_id` (`size_id`);

--
-- Chỉ mục cho bảng `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `status_order`
--
ALTER TABLE `status_order`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `supplier_email` (`supplier_email`);

--
-- Chỉ mục cho bảng `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `account`
--
ALTER TABLE `account`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `category_type`
--
ALTER TABLE `category_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `color`
--
ALTER TABLE `color`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `discount`
--
ALTER TABLE `discount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `import`
--
ALTER TABLE `import`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `size`
--
ALTER TABLE `size`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `status_order`
--
ALTER TABLE `status_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `account_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_account_customer_email` FOREIGN KEY (`customer_email`) REFERENCES `customer` (`customer_email`);

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `fk_category_type` FOREIGN KEY (`id_type`) REFERENCES `category_type` (`id`);

--
-- Các ràng buộc cho bảng `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `fk_customer_account` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `detail_import`
--
ALTER TABLE `detail_import`
  ADD CONSTRAINT `detail_import_ibfk_1` FOREIGN KEY (`import_id`) REFERENCES `import` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_import_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `detail_task_role`
--
ALTER TABLE `detail_task_role`
  ADD CONSTRAINT `detail_task_role_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_task_role_ibfk_2` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_task_role_ibfk_3` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `import`
--
ALTER TABLE `import`
  ADD CONSTRAINT `import_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `import_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`status_order_id`) REFERENCES `status_order` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`discount_id`) REFERENCES `discount` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `product_color`
--
ALTER TABLE `product_color`
  ADD CONSTRAINT `product_color_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_color_ibfk_2` FOREIGN KEY (`color_id`) REFERENCES `color` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `product_size`
--
ALTER TABLE `product_size`
  ADD CONSTRAINT `product_size_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_size_ibfk_2` FOREIGN KEY (`size_id`) REFERENCES `size` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
