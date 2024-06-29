-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2024 at 07:44 AM
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
-- Database: `assignment`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `cart_item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`cart_item_id`, `user_id`, `product_id`, `quantity`) VALUES
(34, 2, 23, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` varchar(25) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `order_date` datetime NOT NULL,
  `payment_id` int(11) NOT NULL,
  `order_status` enum('Pending','Preparing','Shipped','Delivered','Cancelled') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total_amount`, `order_date`, `payment_id`, `order_status`) VALUES
('ORD202403241759379118', 1, 74.80, '2024-03-24 17:59:37', 0, 'Cancelled'),
('ORD202403241901579285', 1, 20.00, '2024-03-24 19:01:57', 36, 'Preparing'),
('ORD202403251708399060', 3, 107.60, '2024-03-25 17:08:39', 37, 'Preparing'),
('ORD202403251710498015', 3, 55.00, '2024-03-25 17:10:49', 38, 'Preparing'),
('ORD202403252359482660', 1, 37.00, '2024-03-25 23:59:48', 0, 'Cancelled'),
('ORD202403301420501209', 1, 4.60, '2024-03-30 14:20:50', 39, 'Preparing');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` varchar(25) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `price`, `quantity`) VALUES
(24, 'ORD202403241759379118', 24, 7.40, 2),
(25, 'ORD202403241759379118', 6, 20.00, 3),
(27, 'ORD202403241901579285', 6, 20.00, 1),
(28, 'ORD202403251708399060', 20, 107.60, 1),
(29, 'ORD202403251710498015', 5, 27.50, 2),
(30, 'ORD202403252359482660', 24, 7.40, 5),
(31, 'ORD202403301420501209', 2, 4.60, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `contact_no` varchar(20) NOT NULL,
  `address_line1` varchar(100) NOT NULL,
  `address_line2` varchar(100) NOT NULL,
  `address_line3` varchar(100) NOT NULL,
  `postcode` char(5) NOT NULL,
  `city` varchar(20) NOT NULL,
  `state` varchar(20) NOT NULL,
  `payment_method` varchar(20) NOT NULL,
  `total_amount` float(10,2) NOT NULL,
  `payment_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `customer_name`, `contact_no`, `address_line1`, `address_line2`, `address_line3`, `postcode`, `city`, `state`, `payment_method`, `total_amount`, `payment_date`) VALUES
(36, 'Abu', '011239811', 'Jalan xaw', 'Taman waw e', '', '55555', 'Batu Bahat', 'Johor', 'ewallet', 20.00, '2024-03-24 19:02:27'),
(37, 'tester', '0123456789', 'utar, kampar', '', '', '31900', 'Kampar', 'perak', 'ewallet', 107.60, '2024-03-25 17:09:45'),
(38, 'tester', '0123456789', 'utar, kampar', '', '', '31900', 'Kampar', 'perak', 'credit_card', 55.00, '2024-03-25 17:11:29'),
(39, 'test', '21341451', 'waerar', 'weawea', 'weae', '24145', 'wawea', 'aweaw', 'ewallet', 4.60, '2024-03-30 14:26:10');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `product_category` varchar(20) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `record_date` datetime NOT NULL,
  `submitted_by` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_price`, `product_quantity`, `product_category`, `product_image`, `record_date`, `submitted_by`) VALUES
(1, 'Sony wh-ch520 Headphones', 250.00, 7, 'Headphones', 'https://rb.gy/y0ol9t', '2024-03-23 07:48:37', 'tester1'),
(2, 'iPhone 15 Pro Max phone case', 4.60, 13, 'Phone Cases', 'https://rb.gy/fpcn7a', '2024-03-23 07:49:39', 'tester1'),
(3, 'Samsung S23 FE Screen Protector', 15.00, 13, 'Screen Protectors', 'https://rb.gy/eeu5ge', '2024-03-23 08:44:32', 'tester1'),
(4, 'P9 Bluetooh Headphones', 69.90, 4, 'Headphones', 'https://m.media-amazon.com/images/I/814aYc0PsYL._AC_SX425_.jpg', '2024-03-23 07:52:38', 'tester1'),
(5, 'Oppo Find N2 Filp Phone Case', 27.50, 5, 'Phone Cases', 'https://i.pinimg.com/564x/b5/bc/c2/b5bcc2e2ef73d58f441efc2c836d1aee.jpg', '2024-03-21 10:53:28', 'tester1'),
(6, 'Google Pixel 5 Tempered Glass Screen Protector', 20.00, 8, 'Screen Protectors', 'https://static-01.daraz.lk/p/f3da9274eb53ea2fa64e7a054fbe28a9.jpg', '2024-03-21 09:25:14', 'tester1'),
(7, 'Logitech G Pro X Gaming Headset', 300.00, 2, 'Headphones', 'https://i.pinimg.com/564x/0a/cc/74/0acc74472a23a8dfe7473244079346b0.jpg', '2024-03-21 10:14:03', 'tester1'),
(8, 'Vivo Y17s Phone Case', 2.80, 5, 'Phone Cases', 'https://down-my.img.susercontent.com/file/sg-11134201-7rbms-ln27rny13dty5e', '2024-03-21 10:41:29', 'tester1'),
(9, 'iPad Air 5 Paperlike Screen Protector', 39.99, 9, 'Screen Protectors', 'https://m.media-amazon.com/images/I/61yhY94ooVL._AC_UF1000,1000_QL80_.jpg', '2024-03-21 10:52:49', 'tester1'),
(20, 'Heart Shape Bluetooth Headphones', 107.60, 1, 'Headphones', 'https://c1.iggcdn.com/indiegogo-media-prod-cld/image/upload/c_limit,w_620/v1479422796/t9vfjrsqomsq7makfhvg.jpg', '2024-03-23 05:25:11', 'tester1'),
(21, 'Samsung a34 5G Y2K Phone Case', 7.40, 11, 'Phone Cases', 'https://i.pinimg.com/originals/b9/27/fe/b927fe2e6128cdc2af56933ac5d6c9c7.jpg', '2024-03-23 07:34:41', 'tester1'),
(22, 'iPhone 11 Matte Privacy Screen Protector', 10.00, 16, 'Screen Protectors', 'https://rb.gy/wdy31p', '2024-03-23 07:41:34', 'tester1'),
(23, 'JBL Headphones', 94.20, 1, 'Headphones', 'https://target.scene7.com/is/image/Target/GUEST_e5763e81-b6e1-4861-b1e2-e59f22375f0b?wid=400&hei=400&qlt=80&fmt=webp', '2024-03-23 08:33:00', 'tester1'),
(24, 'Huawei Mate 50 Pro Phone Case', 7.40, 9, 'Phone Cases', 'https://m.media-amazon.com/images/I/61SaJoKlzAL.jpg', '2024-03-23 08:40:31', 'tester1'),
(25, 'Redmi 12 Screen Protector', 14.60, 5, 'Screen Protectors', 'https://m.media-amazon.com/images/I/51EwFkHeO8L._SX425_.jpg', '2024-03-23 08:43:12', 'tester1');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL,
  `staff_name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_no` varchar(20) NOT NULL,
  `position` varchar(50) NOT NULL,
  `reg_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `staff_name`, `password`, `email`, `phone_no`, `position`, `reg_date`) VALUES
(1, 'test', '098f6bcd4621d373cade4e832627b4f6', 'test@test', '1234', 'Staff', '2024-03-24 09:45:55'),
(2, 'staff', '5f4dcc3b5aa765d61d8327deb882cf99', 'aaa@gmail.com', '01132136919', 'Staff', '2024-03-24 20:09:18');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `reg_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `email`, `password`, `reg_date`) VALUES
(1, 'test', 'test@test', '098f6bcd4621d373cade4e832627b4f6', '2024-03-15 11:49:51'),
(2, 'user', 'user@user.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2024-03-23 11:49:38'),
(3, 'tester1', 'tester1@gmail.com', '72a3dcef165d9122a45decf13ae20631', '2024-03-25 17:07:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `cart_items_ibfk_2` (`user_id`),
  ADD KEY `cart_items_ibfk_1` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `order_items_ibfk_2` (`product_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `cart_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
