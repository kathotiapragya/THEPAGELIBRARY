-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2025 at 04:58 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thepagelibrary`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_payment`
--

CREATE TABLE `user_payment` (
  `user_id` int(11) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `payment_status` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `upi_id` varchar(255) DEFAULT NULL,
  `shipping_address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_payment`
--

INSERT INTO `user_payment` (`user_id`, `payment_method`, `payment_status`, `amount`, `transaction_id`, `payment_date`, `upi_id`, `shipping_address`) VALUES
(1, 'cod', 'Success', 978.00, 'TXN_67b180e0b6357', '2025-02-16 01:38:32', NULL, NULL),
(2, 'cod', 'Success', 3674.00, 'TXN_67b44ac7278bb', '2025-02-18 04:24:31', NULL, NULL),
(3, 'cod', 'Success', 600.00, 'TXN_67b44b9492787', '2025-02-18 04:27:56', NULL, NULL),
(4, 'cod', 'Success', 658.00, 'TXN_67b44c3c2ae60', '2025-02-18 04:30:44', NULL, NULL),
(5, 'cod', 'Success', 715.00, 'TXN_67b569a78f600', '2025-02-19 00:48:31', NULL, NULL),
(6, 'cod', 'Success', 1492.00, 'TXN_67b56dba6fbec', '2025-02-19 01:05:54', NULL, NULL),
(7, 'cod', 'Success', 800.00, 'TXN_67b5834e8fc4e', '2025-02-19 02:37:58', NULL, NULL),
(8, 'upi', 'Pending', 1056.00, 'UPI_TXN_67b5f744f38d9', '2025-02-19 10:52:44', 'vaish@UPI', NULL),
(9, 'cod', 'Success', 1079.00, 'TXN_67b5f913dfbdd', '2025-02-19 11:00:27', NULL, NULL),
(10, 'cod', 'Success', 1508.00, 'TXN_67b6f0d1d8859', '2025-02-20 04:37:29', NULL, NULL),
(11, 'cod', 'Success', 550.00, 'TXN_67b6f1b58d02d', '2025-02-20 04:41:17', NULL, NULL),
(12, 'cod', 'Success', 1919.00, 'TXN_67b6f42c40b33', '2025-02-20 04:51:48', NULL, ''),
(13, 'cod', 'Success', 300.00, 'TXN_67b6f43eaca59', '2025-02-20 04:52:06', NULL, ''),
(14, 'cod', 'Success', 476.00, 'TXN_67b6f511eb06c', '2025-02-20 04:55:37', NULL, ''),
(15, 'cod', 'Success', 1059.00, 'TXN_67b6f632c0768', '2025-02-20 05:00:26', NULL, ''),
(16, 'cod', 'Success', 665.00, 'TXN_67b6f6e7aa2ed', '2025-02-20 05:03:27', NULL, ''),
(17, 'cod', 'Success', 1198.00, 'TXN_67b73a5855b26', '2025-02-20 09:51:12', NULL, ''),
(18, 'cod', 'Success', 837.00, 'TXN_67b73b1ea92cc', '2025-02-20 09:54:30', NULL, ''),
(19, 'cod', 'Success', 950.00, 'TXN_67b73b4905365', '2025-02-20 09:55:13', NULL, ''),
(20, 'cod', 'Success', 1080.00, 'TXN_67b73dd2d1db1', '2025-02-20 10:06:02', NULL, ''),
(21, 'cod', 'Success', 600.00, 'TXN_67b73e0d1abf7', '2025-02-20 10:07:01', NULL, ''),
(22, 'cod', 'Success', 558.00, 'TXN_67b73ef7cc8a0', '2025-02-20 10:10:55', NULL, ''),
(23, 'cod', 'Success', 250.00, 'TXN_67b7403aedbd7', '2025-02-20 10:16:18', NULL, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_payment`
--
ALTER TABLE `user_payment`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_payment`
--
ALTER TABLE `user_payment`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
