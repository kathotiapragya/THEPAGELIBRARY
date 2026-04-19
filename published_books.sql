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
-- Table structure for table `published_books`
--

CREATE TABLE `published_books` (
  `title` varchar(200) NOT NULL,
  `author` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `submission_date` datetime DEFAULT current_timestamp(),
  `cover_image` varchar(255) NOT NULL,
  `book_file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `published_books`
--

INSERT INTO `published_books` (`title`, `author`, `content`, `submission_date`, `cover_image`, `book_file`) VALUES
('How to Pass Statistics', 'Ntkx', '', '2025-02-04 10:29:01', 'uploads/images/1738661341_stats.jpg', 'uploads/pdfs/1738661341_The Palace of Illusions.pdf'),
('Cause Why Not?', 'sowmya', '', '2025-02-16 06:55:55', 'uploads/images/1739685355_random.jpg', 'uploads/pdfs/1739685355_A tale of two cities.pdf');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
