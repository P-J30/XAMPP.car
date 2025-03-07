-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2025 at 07:01 PM
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
-- Database: `car014`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL COMMENT 'รหัสรถ (Primary Key)',
  `brand` varchar(100) NOT NULL COMMENT 'ยี่ห้อรถ เช่น Toyota, Honda',
  `model` varchar(100) NOT NULL COMMENT 'รุ่นรถ เช่น Corolla, Civic',
  `year` year(4) NOT NULL COMMENT 'ปีที่ผลิต',
  `color` varchar(50) DEFAULT NULL COMMENT 'สีของรถ เช่น ขาว, ดำ, แดง',
  `engine_type` varchar(50) DEFAULT NULL COMMENT 'ชนิดเครื่องยนต์ เช่น เบนซิน, ดีเซล, ไฟฟ้า',
  `transmission` enum('Manual','Automatic') DEFAULT NULL COMMENT 'ชนิดของเกียร์ เช่น Manual, Automatic',
  `seats` int(11) DEFAULT NULL COMMENT 'จำนวนที่นั่ง เช่น 4, 5, 7',
  `price` decimal(10,2) DEFAULT NULL COMMENT 'ราคารถ (บาท)',
  `create_date` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่สร้างข้อมูล',
  `update_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'วันที่แก้ไขข้อมูลล่าสุด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ตารางเก็บข้อมูลคุณลักษณะของรถ';

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `brand`, `model`, `year`, `color`, `engine_type`, `transmission`, `seats`, `price`, `create_date`, `update_date`) VALUES
(1, 'toyota', 'CHR', '2024', 'แดง', 'เบนซิน', 'Automatic', 5, 1300000.00, '2025-01-07 00:09:40', '2025-01-07 00:09:40'),
(2, 'Toyota', 'Corolla', '2020', 'White', 'Petrol', 'Automatic', 5, 1200.00, '2025-01-07 00:16:33', '2025-01-07 00:16:33'),
(3, 'Honda', 'Civic', '2021', 'Black', 'Petrol', 'Manual', 5, 1300.00, '2025-01-07 00:16:33', '2025-01-07 00:16:33'),
(4, 'Mazda', 'CX-5', '2019', 'Red', 'Diesel', 'Automatic', 7, 2000.00, '2025-01-07 00:16:33', '2025-01-07 00:16:33'),
(5, 'Nissan', 'March', '2018', 'Blue', 'Petrol', 'Automatic', 4, 900.00, '2025-01-07 00:16:33', '2025-01-07 00:16:33'),
(6, 'Ford', 'Ranger', '2022', 'Silver', 'Diesel', 'Manual', 5, 2500.00, '2025-01-07 00:16:33', '2025-01-07 00:16:33'),
(7, 'toyota', 'CHR', '2024', 'แดง', 'เบนซิน', 'Automatic', 5, 1300000.00, '2025-01-07 00:09:40', '2025-01-07 00:09:40');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL COMMENT 'รหัสลูกค้า (Primary Key)',
  `first_name` varchar(100) NOT NULL COMMENT 'ชื่อลูกค้า',
  `last_name` varchar(100) NOT NULL COMMENT 'นามสกุลลูกค้า',
  `phone_number` varchar(15) NOT NULL COMMENT 'เบอร์โทรศัพท์',
  `email` varchar(150) DEFAULT NULL COMMENT 'อีเมล',
  `address` text DEFAULT NULL COMMENT 'ที่อยู่',
  `driver_license_number` varchar(50) NOT NULL COMMENT 'หมายเลขใบขับขี่',
  `create_date` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่สร้างข้อมูล',
  `update_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'วันที่แก้ไขข้อมูลล่าสุด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `first_name`, `last_name`, `phone_number`, `email`, `address`, `driver_license_number`, `create_date`, `update_date`) VALUES
(1, 'John', 'Doe', '0812345678', 'john.doe@example.com', '123 Main Street, Bangkok', 'B123456789', '2025-01-07 00:16:48', '2025-01-07 00:16:48'),
(2, 'Jane', 'Smith', '0812345679', 'jane.smith@example.com', '456 Elm Street, Chiang Mai', 'C987654321', '2025-01-07 00:16:48', '2025-01-07 00:16:48'),
(3, 'Tom', 'Brown', '0812345680', 'tom.brown@example.com', '789 Oak Street, Phuket', 'D567890123', '2025-01-07 00:16:48', '2025-01-07 00:16:48'),
(4, 'Anna', 'Taylor', '0812345681', 'anna.taylor@example.com', '321 Pine Street, Pattaya', 'E123098765', '2025-01-07 00:16:48', '2025-01-07 00:16:48'),
(5, 'Sara', 'Williams', '0812345682', 'sara.williams@example.com', '654 Maple Street, Hua Hin', 'F543210987', '2025-01-07 00:16:48', '2025-01-07 00:16:48');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

CREATE TABLE `maintenance` (
  `maintenance_id` int(11) NOT NULL COMMENT 'รหัสการซ่อมบำรุง (Primary Key)',
  `car_id` int(11) NOT NULL COMMENT 'รหัสรถ',
  `maintenance_date` date NOT NULL COMMENT 'วันที่ซ่อมบำรุง',
  `description` text DEFAULT NULL COMMENT 'รายละเอียดการซ่อมบำรุง',
  `cost` decimal(10,2) DEFAULT NULL COMMENT 'ค่าใช้จ่ายในการซ่อมบำรุง',
  `status` enum('Scheduled','Completed') DEFAULT 'Scheduled' COMMENT 'สถานะการซ่อมบำรุง'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `maintenance`
--

INSERT INTO `maintenance` (`maintenance_id`, `car_id`, `maintenance_date`, `description`, `cost`, `status`) VALUES
(1, 1, '2025-01-01', 'เปลี่ยนยางและตรวจสอบเครื่องยนต์', 5000.00, 'Completed'),
(2, 2, '2025-01-02', 'ตรวจสอบระบบเบรก', 2000.00, 'Completed'),
(3, 3, '2025-01-03', 'เปลี่ยนถ่ายน้ำมันเครื่อง', 1500.00, 'Scheduled'),
(4, 4, '2025-01-04', 'ตรวจสอบแบตเตอรี่', 1000.00, 'Completed'),
(5, 5, '2025-01-05', 'เปลี่ยนกระจกหน้ารถ', 3000.00, 'Scheduled');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL COMMENT 'รหัสการชำระเงิน (Primary Key)',
  `rental_id` int(11) NOT NULL COMMENT 'รหัสการเช่า',
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่ชำระเงิน',
  `amount` decimal(10,2) NOT NULL COMMENT 'จำนวนเงินที่ชำระ',
  `payment_method` enum('Cash','Credit Card','Bank Transfer') DEFAULT NULL COMMENT 'วิธีการชำระเงิน',
  `payment_status` enum('Pending','Paid') DEFAULT 'Pending' COMMENT 'สถานะการชำระเงิน'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `rental_id`, `payment_date`, `amount`, `payment_method`, `payment_status`) VALUES
(1, 1, '2024-12-31 20:00:00', 6000.00, 'Credit Card', 'Paid'),
(2, 2, '2025-01-03 01:30:00', 3900.00, 'Bank Transfer', 'Paid'),
(3, 3, '2025-01-06 18:45:00', 6000.00, 'Cash', 'Pending'),
(4, 4, '2025-01-01 23:15:00', 0.00, 'Cash', 'Pending'),
(5, 5, '2025-01-04 19:20:00', 7500.00, 'Credit Card', 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `rentals`
--

CREATE TABLE `rentals` (
  `rental_id` int(11) NOT NULL COMMENT 'รหัสการเช่า (Primary Key)',
  `customer_id` int(11) NOT NULL COMMENT 'รหัสลูกค้า',
  `car_id` int(11) NOT NULL COMMENT 'รหัสรถ',
  `rental_start_date` date NOT NULL COMMENT 'วันที่เริ่มเช่า',
  `rental_end_date` date NOT NULL COMMENT 'วันที่สิ้นสุดการเช่า',
  `total_price` decimal(10,2) NOT NULL COMMENT 'ราคารวม',
  `rental_status` enum('Pending','Completed','Cancelled') DEFAULT 'Pending' COMMENT 'สถานะการเช่า',
  `create_date` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่สร้างข้อมูล',
  `update_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'วันที่แก้ไขข้อมูลล่าสุด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rentals`
--

INSERT INTO `rentals` (`rental_id`, `customer_id`, `car_id`, `rental_start_date`, `rental_end_date`, `total_price`, `rental_status`, `create_date`, `update_date`) VALUES
(1, 1, 1, '2025-01-01', '2025-01-05', 6000.00, 'Completed', '2025-01-07 00:17:00', '2025-01-07 00:17:00'),
(2, 2, 2, '2025-01-03', '2025-01-06', 3900.00, 'Completed', '2025-01-07 00:17:00', '2025-01-07 00:17:00'),
(3, 3, 3, '2025-01-07', '2025-01-10', 6000.00, 'Pending', '2025-01-07 00:17:00', '2025-01-07 00:17:00'),
(4, 4, 4, '2025-01-02', '2025-01-05', 2700.00, 'Cancelled', '2025-01-07 00:17:00', '2025-01-07 00:17:00'),
(5, 5, 5, '2025-01-05', '2025-01-08', 7500.00, 'Completed', '2025-01-07 00:17:00', '2025-01-07 00:17:00');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL COMMENT 'รหัสสิทธิ์ (Primary Key)',
  `role_name` varchar(50) NOT NULL COMMENT 'ชื่อสิทธิ์ (เช่น Admin, Staff, Customer)',
  `description` text DEFAULT NULL COMMENT 'คำอธิบายเกี่ยวกับสิทธิ์',
  `create_date` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่สร้างข้อมูล',
  `update_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'วันที่แก้ไขข้อมูลล่าสุด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `description`, `create_date`, `update_date`) VALUES
(1, 'Admin', 'ผู้ดูแลระบบ', '2025-01-07 00:17:42', '2025-01-07 00:17:42'),
(2, 'Staff', 'เจ้าหน้าที่ระบบ', '2025-01-07 00:17:42', '2025-01-07 00:17:42'),
(3, 'Customer', 'ลูกค้าผู้ใช้งาน', '2025-01-07 00:17:42', '2025-01-07 00:17:42'),
(4, 'Maintenance', 'เจ้าหน้าที่ซ่อมบำรุง', '2025-01-07 00:17:42', '2025-01-07 00:17:42'),
(5, 'Manager', 'ผู้จัดการระบบ', '2025-01-07 00:17:42', '2025-01-07 00:17:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL COMMENT 'รหัสผู้ใช้ (Primary Key)',
  `username` varchar(50) NOT NULL COMMENT 'ชื่อผู้ใช้ (สำหรับล็อกอิน)',
  `password` varchar(255) NOT NULL COMMENT 'รหัสผ่านที่เข้ารหัส',
  `first_name` varchar(100) NOT NULL COMMENT 'ชื่อจริง',
  `last_name` varchar(100) NOT NULL COMMENT 'นามสกุล',
  `email` varchar(150) NOT NULL COMMENT 'อีเมล',
  `phone_number` varchar(15) DEFAULT NULL COMMENT 'หมายเลขโทรศัพท์',
  `role_id` int(11) NOT NULL COMMENT 'รหัสสิทธิ์ผู้ใช้',
  `status` enum('Active','Inactive') DEFAULT 'Active' COMMENT 'สถานะบัญชีผู้ใช้',
  `create_date` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่สร้างบัญชี',
  `update_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'วันที่แก้ไขข้อมูลล่าสุด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `first_name`, `last_name`, `email`, `phone_number`, `role_id`, `status`, `create_date`, `update_date`) VALUES
(7, 'admin1', 'hashedpassword1', 'Admin', 'User', 'admin1@example.com', '0812345678', 1, 'Active', '2025-01-07 00:19:06', '2025-01-07 00:19:06'),
(8, 'staff1', 'hashedpassword2', 'Staff', 'User', 'staff1@example.com', '0812345679', 2, 'Active', '2025-01-07 00:19:06', '2025-01-07 00:19:06'),
(9, 'customer1', 'hashedpassword3', 'John', 'Doe', 'customer1@example.com', '0812345680', 3, 'Active', '2025-01-07 00:19:06', '2025-01-07 00:19:06'),
(10, 'maintenance1', 'hashedpassword4', 'Tom', 'Brown', 'maintenance1@example.com', '0812345681', 4, 'Active', '2025-01-07 00:19:06', '2025-01-07 00:19:06'),
(11, 'nuttapol', 'hashedpassword', 'Tom', 'Brown', 'maintenance11@example.com', '0812345681', 4, 'Active', '2025-01-07 00:19:06', '2025-01-07 00:19:06'),
(12, 'manager1', 'hashedpassword5', 'Anna', 'Taylor', 'manager1@example.com', '0812345682', 5, 'Active', '2025-01-07 00:19:06', '2025-01-07 00:19:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`maintenance_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `rental_id` (`rental_id`);

--
-- Indexes for table `rentals`
--
ALTER TABLE `rentals`
  ADD PRIMARY KEY (`rental_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสรถ (Primary Key)', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสลูกค้า (Primary Key)', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `maintenance_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสการซ่อมบำรุง (Primary Key)', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสการชำระเงิน (Primary Key)', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rentals`
--
ALTER TABLE `rentals`
  MODIFY `rental_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสการเช่า (Primary Key)', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสสิทธิ์ (Primary Key)', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสผู้ใช้ (Primary Key)', AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD CONSTRAINT `maintenance_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`rental_id`) REFERENCES `rentals` (`rental_id`);

--
-- Constraints for table `rentals`
--
ALTER TABLE `rentals`
  ADD CONSTRAINT `rentals_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `rentals_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
