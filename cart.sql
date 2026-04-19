-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2025 at 04:57 PM
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
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `order_id` varchar(50) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `book_name` varchar(255) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_mode` varchar(50) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `shipping_address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `order_id`, `book_id`, `book_name`, `username`, `amount`, `payment_mode`, `date`, `quantity`, `shipping_address`) VALUES
(1, 'ORD679a3b9fa4805', 5, 'the silent patient', 'Suzanne', 250.00, 'upi', '2025-01-29 15:30:55', 1, NULL),
(2, 'ORD679a3b9fa4805', 12, 'Twisted Love', 'Suzanne', 400.00, 'upi', '2025-01-29 15:30:55', 1, NULL),
(3, 'ORD679a669983537', 9, 'twisted games', 'vydehi', 299.00, 'upi', '2025-01-29 18:34:17', 1, NULL),
(4, 'ORD679a669983537', 6, 'love on the brain', 'vydehi', 558.00, 'upi', '2025-01-29 18:34:17', 1, NULL),
(5, 'ORD679a669983537', 5, 'the silent patient', 'vydehi', 250.00, 'upi', '2025-01-29 18:34:17', 1, NULL),
(6, 'ORD679a669983537', 23, 'to die for', 'vydehi', 389.00, 'upi', '2025-01-29 18:34:17', 1, NULL),
(7, 'ORD679a669983537', 26, 'metamorphosis', 'vydehi', 159.00, 'upi', '2025-01-29 18:34:17', 1, NULL),
(8, 'ORD679a7ae4c869c', 5, 'the silent patient', 'sowmya', 250.00, 'upi', '2025-01-29 20:00:52', 1, NULL),
(9, 'ORD679a7ae4c869c', 32, 'harry potter and the deathly hallows', 'sowmya', 450.00, 'upi', '2025-01-29 20:00:52', 1, NULL),
(10, 'ORD679a7ae4c869c', 74, 'atomic habits', 'sowmya', 550.00, 'upi', '2025-01-29 20:00:52', 1, NULL),
(11, 'ORD679a7ae4c869c', 25, 'dune', 'sowmya', 450.00, 'upi', '2025-01-29 20:00:52', 1, NULL),
(12, 'ORD679a7ae4c869c', 51, 'your inner fish', 'sowmya', 199.00, 'upi', '2025-01-29 20:00:52', 1, NULL),
(13, 'ORD679a7ae4c869c', 55, 'are you my mother', 'sowmya', 59.00, 'upi', '2025-01-29 20:00:52', 1, NULL),
(14, 'ORD679a7c5c5bf11', 2, 'The children of tiime', 'shyam', 350.00, 'cod', '2025-01-29 20:07:08', 1, NULL),
(15, 'ORD679a7c5c5bf11', 79, 'ram scion of ikshvaku', 'shyam', 300.00, 'cod', '2025-01-29 20:07:08', 1, NULL),
(16, 'ORD679a7c5c5bf11', 26, 'metamorphosis', 'shyam', 159.00, 'cod', '2025-01-29 20:07:08', 1, NULL),
(17, 'ORD679a8014e17fe', 9, 'twisted games', 'vasavi', 299.00, 'card', '2025-01-29 20:23:00', 1, NULL),
(18, 'ORD679a8014e17fe', 18, 'the origin of species', 'vasavi', 350.00, 'card', '2025-01-29 20:23:00', 1, NULL),
(19, 'ORD679a8014e17fe', 47, 'being and time', 'vasavi', 350.00, 'card', '2025-01-29 20:23:00', 1, NULL),
(20, 'ORD679a80739ece7', 4, 'the fury', 'vasavi', 700.00, 'card', '2025-01-29 20:24:35', 1, NULL),
(21, 'ORD679a815e03764', 5, 'the silent patient', 'vasavi', 500.00, 'card', '2025-01-29 20:28:30', 1, NULL),
(22, 'ORD679a84ba87de4', 51, 'your inner fish', 'vasavi', 199.00, 'card', '2025-01-29 20:42:50', 1, NULL),
(23, 'ORD679a84ba87de4', 43, 'the rainbow fish', 'vasavi', 49.00, 'card', '2025-01-29 20:42:50', 1, NULL),
(24, 'ORD679a8605a534b', 9, 'twisted games', 'vasavi', 299.00, 'card', '2025-01-29 20:48:21', 1, NULL),
(25, 'ORD679a868804167', 2, 'The children of tiime', 'vasavi', 350.00, 'card', '2025-01-29 20:50:32', 1, NULL),
(26, 'ORD679a870f0f568', 5, 'the silent patient', 'vasavi', 250.00, 'card', '2025-01-29 20:52:47', 1, NULL),
(27, 'ORD679a881ae0909', 54, 'the picture of dorian gray', 'vasavi', 319.00, 'card', '2025-01-29 20:57:14', 1, NULL),
(28, 'ORD679a894feb373', 35, 'dont believe everything you think', 'vasavi', 129.00, 'card', '2025-01-29 21:02:23', 1, NULL),
(29, 'ORD679b397b01772', 5, 'the silent patient', 'vidit', 500.00, 'card', '2025-01-30 09:34:03', 1, NULL),
(30, 'ORD679b397b01772', 26, 'metamorphosis', 'vidit', 159.00, 'card', '2025-01-30 09:34:03', 1, NULL),
(31, 'ORD679b397b01772', 50, 'becoming', 'vidit', 350.00, 'card', '2025-01-30 09:34:03', 1, NULL),
(32, 'ORD679b397b01772', 34, 'gulliver travels', 'vidit', 459.00, 'card', '2025-01-30 09:34:03', 1, NULL),
(33, 'ORD679b397b01772', 52, 'the art of letting go', 'vidit', 129.00, 'card', '2025-01-30 09:34:03', 1, NULL),
(34, 'ORD679b3c54e253f', 5, 'the silent patient', 'sandy', 750.00, 'cod', '2025-01-30 09:46:12', 1, NULL),
(35, 'ORD679bb80067ba6', 2, 'The children of tiime', 'sandhya', 350.00, 'cod', '2025-01-30 18:33:52', 1, NULL),
(36, 'ORD679bb80067ba6', 79, 'ram scion of ikshvaku', 'sandhya', 300.00, 'cod', '2025-01-30 18:33:52', 1, NULL),
(37, 'ORD679bb80067ba6', 10, 'the striker', 'sandhya', 329.00, 'cod', '2025-01-30 18:33:52', 1, NULL),
(38, 'ORD679bb80067ba6', 5, 'the silent patient', 'sandhya', 250.00, 'cod', '2025-01-30 18:33:52', 1, NULL),
(39, 'ORD679c889d2f3e3', 79, 'ram scion of ikshvaku', 'sreej1234', 300.00, 'cod', '2025-01-31 09:23:57', 1, NULL),
(40, 'ORD679f42d02251f', 10, 'The Striker', 'sowmya', 658.00, 'cod', '2025-02-02 11:02:56', 1, NULL),
(41, 'ORD679f42d02251f', 9, 'Twisted Games', 'sowmya', 598.00, 'cod', '2025-02-02 11:02:56', 1, NULL),
(42, 'ORD679f42d02251f', 52, 'The Art of Letting Go', 'sowmya', 258.00, 'cod', '2025-02-02 11:02:56', 1, NULL),
(43, 'ORD679f42d02251f', 50, 'Becoming', 'sowmya', 700.00, 'cod', '2025-02-02 11:02:56', 1, NULL),
(44, 'ORD67a0754d49c41', 87, 'Children of Memory', 'Guest', 600.00, 'cod', '2025-02-03 08:50:37', 1, NULL),
(45, 'ORD67a08c26cdb4f', 6, 'Love on the Brain', 'Guest', 279.00, 'cod', '2025-02-03 10:28:06', 1, NULL),
(46, 'ORD67a08dcc12901', 4, 'The Silent Patient', 'Guest', 250.00, 'cod', '2025-02-03 10:35:08', 1, NULL),
(47, 'ORD67a096cd74b20', 4, 'The Silent Patient', 'charvi', 500.00, 'cod', '2025-02-03 11:13:33', 1, NULL),
(48, 'ORD67a096cd74b20', 2, 'Lords of Creation', 'charvi', 365.00, 'cod', '2025-02-03 11:13:33', 1, NULL),
(49, 'ORD67a19eb264c55', 12, 'Twisted Games', 'devishya', 299.00, 'cod', '2025-02-04 05:59:30', 1, NULL),
(50, 'ORD67a1dbc45d688', 86, 'Letters to Milena', 'Ntkx', 500.00, 'cod', '2025-02-04 10:20:04', 1, NULL),
(51, 'ORD67a1dbc45d688', 5, 'The Maidens', 'Ntkx', 200.00, 'cod', '2025-02-04 10:20:04', 1, NULL),
(52, 'ORD67aa2782ea637', 2, 'Lords of Creation', 'Krishi', 365.00, 'cod', '2025-02-10 17:21:22', 1, NULL),
(53, 'ORD67aa2782ea637', 5, 'The Maidens', 'Krishi', 200.00, 'cod', '2025-02-10 17:21:22', 1, NULL),
(54, 'ORD67aa2782ea637', 8, 'Under One Roof', 'Krishi', 277.00, 'cod', '2025-02-10 17:21:22', 1, NULL),
(55, 'ORD67aa2782ea637', 22, 'Palace of Illusions', 'Krishi', 300.00, 'cod', '2025-02-10 17:21:22', 1, NULL),
(56, 'ORD67aa2782ea637', 26, 'To Die For', 'Krishi', 389.00, 'cod', '2025-02-10 17:21:22', 1, NULL),
(57, 'ORD67aae41d7ef9e', 12, 'Twisted Games', 'Jyotsana', 299.00, 'cod', '2025-02-11 06:46:05', 1, NULL),
(58, 'ORD67b17f3795e09', 2, 'Lords of Creation', 'sowmya', 365.00, 'cod', '2025-02-16 07:01:27', 1, NULL),
(59, 'ORD67b17f3795e09', 1, 'Children of Memory', 'sowmya', 1200.00, 'cod', '2025-02-16 07:01:27', 1, NULL),
(60, 'ORD67b17fcae1702', 3, 'The Fury', 'sowmya', 350.00, 'cod', '2025-02-16 07:03:54', 1, NULL),
(61, 'ORD67b17fcae1702', 4, 'The Silent Patient', 'sowmya', 250.00, 'cod', '2025-02-16 07:03:54', 1, NULL),
(62, 'ORD67b180e0b5df7', 14, 'King of Sloth', 'sowmya', 279.00, 'cod', '2025-02-16 07:08:32', 1, NULL),
(63, 'ORD67b180e0b5df7', 15, 'Twisted Love', 'sowmya', 400.00, 'cod', '2025-02-16 07:08:32', 1, NULL),
(64, 'ORD67b180e0b5df7', 12, 'Twisted Games', 'sowmya', 299.00, 'cod', '2025-02-16 07:08:32', 1, NULL),
(65, 'ORD67b44ac722298', 5, 'The Maidens', 'Jerry', 400.00, 'cod', '2025-02-18 09:54:31', 1, NULL),
(66, 'ORD67b44ac722298', 9, 'Ram Scion of Ikshvaku', 'Jerry', 300.00, 'cod', '2025-02-18 09:54:31', 1, NULL),
(67, 'ORD67b44ac722298', 10, 'Sita: Warrior of Mithila ', 'Jerry', 400.00, 'cod', '2025-02-18 09:54:31', 1, NULL),
(68, 'ORD67b44ac722298', 11, 'Ravan: Enemy of Aryavarta', 'Jerry', 300.00, 'cod', '2025-02-18 09:54:31', 1, NULL),
(69, 'ORD67b44ac722298', 12, 'Twisted Games', 'Jerry', 299.00, 'cod', '2025-02-18 09:54:31', 1, NULL),
(70, 'ORD67b44ac722298', 22, 'Palace of Illusions', 'Jerry', 300.00, 'cod', '2025-02-18 09:54:31', 1, NULL),
(71, 'ORD67b44ac722298', 25, 'The Da Vinci Code ', 'Jerry', 289.00, 'cod', '2025-02-18 09:54:31', 1, NULL),
(72, 'ORD67b44ac722298', 31, 'The Metamorphosis', 'Jerry', 159.00, 'cod', '2025-02-18 09:54:31', 1, NULL),
(73, 'ORD67b44ac722298', 32, 'Gone Girl', 'Jerry', 329.00, 'cod', '2025-02-18 09:54:31', 1, NULL),
(74, 'ORD67b44ac722298', 75, 'The Adventures of Sherlock Holmes', 'Jerry', 109.00, 'cod', '2025-02-18 09:54:31', 1, NULL),
(75, 'ORD67b44ac722298', 86, 'Letters to Milena', 'Jerry', 500.00, 'cod', '2025-02-18 09:54:31', 1, NULL),
(76, 'ORD67b44ac722298', 55, 'The Book Theif', 'Jerry', 289.00, 'cod', '2025-02-18 09:54:31', 1, NULL),
(77, 'ORD67b44b9491818', 4, 'The Silent Patient', 'amanda', 250.00, 'cod', '2025-02-18 09:57:56', 1, NULL),
(78, 'ORD67b44b9491818', 3, 'The Fury', 'amanda', 350.00, 'cod', '2025-02-18 09:57:56', 1, NULL),
(79, 'ORD67b44c3c2a8d1', 19, 'Red, White and Royal Blue', 'amanda', 658.00, 'cod', '2025-02-18 10:00:44', 1, NULL),
(80, 'ORD67b569a78f059', 2, 'Lords of Creation', 'sowmya', 365.00, 'cod', '2025-02-19 06:18:31', 1, NULL),
(81, 'ORD67b569a78f059', 3, 'The Fury', 'sowmya', 350.00, 'cod', '2025-02-19 06:18:31', 1, NULL),
(82, 'ORD67b56dba6e6fa', 4, 'The Silent Patient', 'sowmya', 250.00, 'cod', '2025-02-19 06:35:54', 1, NULL),
(83, 'ORD67b56dba6e6fa', 2, 'Lords of Creation', 'sowmya', 365.00, 'cod', '2025-02-19 06:35:54', 1, NULL),
(84, 'ORD67b56dba6e6fa', 1, 'Children of Memory', 'sowmya', 600.00, 'cod', '2025-02-19 06:35:54', 1, NULL),
(85, 'ORD67b56dba6e6fa', 8, 'Under One Roof', 'sowmya', 277.00, 'cod', '2025-02-19 06:35:54', 1, NULL),
(86, 'ORD67b5834e8f7b3', 10, 'Sita: Warrior of Mithila ', 'mittu', 800.00, 'cod', '2025-02-19 08:07:58', 1, NULL),
(87, 'ORD67b5f4c9cf3e9', 3, 'The Fury', 'Kajol', 350.00, 'cod', '2025-02-19 16:12:09', 1, NULL),
(88, 'ORD67b5f4c9cf3e9', 4, 'The Silent Patient', 'Kajol', 250.00, 'cod', '2025-02-19 16:12:09', 1, NULL),
(89, 'ORD67b5f4ed9bbd2', 4, 'The Silent Patient', 'Kajol', 250.00, 'upi', '2025-02-19 16:12:45', 1, NULL),
(90, 'ORD67b5f4ed9bbd2', 9, 'Ram Scion of Ikshvaku', 'Kajol', 300.00, 'upi', '2025-02-19 16:12:45', 1, NULL),
(91, 'ORD67b5f5ec1e1da', 3, 'The Fury', 'vaishnavi', 350.00, 'upi', '2025-02-19 16:17:00', 1, NULL),
(92, 'ORD67b5f5ec1e1da', 5, 'The Maidens', 'vaishnavi', 200.00, 'upi', '2025-02-19 16:17:00', 1, NULL),
(93, 'ORD67b5f744f2f45', 8, 'Under One Roof', 'vaishnavi', 277.00, 'upi', '2025-02-19 16:22:44', 1, NULL),
(94, 'ORD67b5f744f2f45', 6, 'Love on the Brain', 'vaishnavi', 279.00, 'upi', '2025-02-19 16:22:44', 1, NULL),
(95, 'ORD67b5f744f2f45', 7, 'Not in Love', 'vaishnavi', 500.00, 'upi', '2025-02-19 16:22:44', 1, NULL),
(96, 'ORD67b5f913dec87', 15, 'Twisted Love', 'vaishnavi', 400.00, 'cod', '2025-02-19 16:30:27', 1, NULL),
(97, 'ORD67b5f913dec87', 14, 'King of Sloth', 'vaishnavi', 279.00, 'cod', '2025-02-19 16:30:27', 1, NULL),
(98, 'ORD67b5f913dec87', 34, 'Good Girl\'s Guide to Murder', 'vaishnavi', 400.00, 'cod', '2025-02-19 16:30:27', 1, NULL),
(99, 'ORD67b6f0d1d79d8', 72, 'Audacious Optimism', 'sowmya', 789.00, 'cod', '2025-02-20 10:07:29', 1, NULL),
(100, 'ORD67b6f0d1d79d8', 85, 'The Stranger Beside Me', 'sowmya', 400.00, 'cod', '2025-02-20 10:07:29', 1, NULL),
(101, 'ORD67b6f0d1d79d8', 76, 'The Hunger Games', 'sowmya', 319.00, 'cod', '2025-02-20 10:07:29', 1, NULL),
(102, 'ORD67b6f1b58c6f6', 3, 'The Fury', 'sowmya', 350.00, 'cod', '2025-02-20 10:11:17', 1, NULL),
(103, 'ORD67b6f1b58c6f6', 5, 'The Maidens', 'sowmya', 200.00, 'cod', '2025-02-20 10:11:17', 1, NULL),
(104, 'ORD67b6f42c4028d', 61, 'The Art of Letting Go', 'sowmya', 129.00, 'cod', '2025-02-20 10:21:48', 1, ''),
(105, 'ORD67b6f42c4028d', 84, 'The Pairing', 'sowmya', 1490.00, 'cod', '2025-02-20 10:21:48', 1, ''),
(106, 'ORD67b6f42c4028d', 9, 'Ram Scion of Ikshvaku', 'sowmya', 300.00, 'cod', '2025-02-20 10:21:48', 1, ''),
(107, 'ORD67b6f43eac5bf', 22, 'Palace of Illusions', 'sowmya', 300.00, 'cod', '2025-02-20 10:22:06', 1, ''),
(108, 'ORD67b6f511eaccf', 8, 'Under One Roof', 'sowmya', 277.00, 'cod', '2025-02-20 10:25:37', 1, ''),
(109, 'ORD67b6f511eaccf', 24, 'Verity', 'sowmya', 199.00, 'cod', '2025-02-20 10:25:37', 1, ''),
(110, 'ORD67b6f632bf943', 7, 'Not in Love', 'sowmya', 500.00, 'cod', '2025-02-20 10:30:26', 1, ''),
(111, 'ORD67b6f632bf943', 27, 'Howl\'s Moving Castle', 'sowmya', 400.00, 'cod', '2025-02-20 10:30:26', 1, ''),
(112, 'ORD67b6f632bf943', 31, 'The Metamorphosis', 'sowmya', 159.00, 'cod', '2025-02-20 10:30:26', 1, ''),
(113, 'ORD67b6f6e7a9886', 2, 'Lords of Creation', 'sowmya', 365.00, 'cod', '2025-02-20 10:33:27', 1, ''),
(114, 'ORD67b6f6e7a9886', 11, 'Ravan: Enemy of Aryavarta', 'sowmya', 300.00, 'cod', '2025-02-20 10:33:27', 1, ''),
(115, 'ORD67b73a5854b83', 63, 'The Picture of Dorian Gray', 'vydehi', 319.00, 'cod', '2025-02-20 15:21:12', 1, ''),
(116, 'ORD67b73a5854b83', 89, 'Crime and Punishment', 'vydehi', 879.00, 'cod', '2025-02-20 15:21:12', 1, ''),
(117, 'ORD67b73b1ea8f8a', 6, 'Love on the Brain', 'vydehi', 837.00, 'cod', '2025-02-20 15:24:30', 1, ''),
(118, 'ORD67b73b4904d3c', 3, 'The Fury', 'vydehi', 700.00, 'cod', '2025-02-20 15:25:13', 1, ''),
(119, 'ORD67b73b4904d3c', 4, 'The Silent Patient', 'vydehi', 250.00, 'cod', '2025-02-20 15:25:13', 1, ''),
(120, 'ORD67b73dd2d17ee', 2, 'Lords of Creation', 'vydehi', 730.00, 'cod', '2025-02-20 15:36:02', 1, ''),
(121, 'ORD67b73dd2d17ee', 3, 'The Fury', 'vydehi', 350.00, 'cod', '2025-02-20 15:36:02', 1, ''),
(122, 'ORD67b73e0d1a787', 22, 'Palace of Illusions', 'vydehi', 600.00, 'cod', '2025-02-20 15:37:01', 1, ''),
(123, 'ORD67b73ef7cc4af', 14, 'King of Sloth', 'sowmya', 558.00, 'cod', '2025-02-20 15:40:55', 1, ''),
(124, 'ORD67b7403aed90d', 4, 'The Silent Patient', 'Suzanne', 250.00, 'cod', '2025-02-20 15:46:18', 1, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
