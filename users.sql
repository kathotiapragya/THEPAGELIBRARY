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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `profile_picture` varchar(255) DEFAULT 'default.jpg',
  `bio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `profile_picture`, `bio`) VALUES
(1, 'abel', 'abel@gmail.com', '$2y$10$X0HJ.Pw05mqCif6bWGhEZuKdoBr8C5hl7D37/rqnupV4XKhN/lU5q', 'user', 'default.jpg', NULL),
(2, 'admin', 'admin@gmail.com', '$2y$10$PHypBJzANg.nzfy7qMbQHuYLmxj78t/UZ8kTNg0clLvzXFKv21zxa', 'user', 'default.jpg', NULL),
(0, 'amanda', 'amanda@gmail.com', '$2y$10$RfAKJ2Z0jHaUFDzdN5LhMuPYSEIKI3EZAouYjg5tUZfow.tc72VRS', 'user', 'default.jpg', 'Amanda is hot'),
(20, 'charvi', 'saicharvithakare@gmail.com', '$2y$10$7Dkp3.aZQROCOeYfKHBDVe04KOLRJZhgLohfRg0zkaJCziO7rIviO', 'user', 'default.jpg', NULL),
(22, 'devishya', 'devishya11@gmail.com', '$2y$10$KHCTdA5uORan/tu7ik7nFOTpZbrAYsGFJsc0YtNbVnkBj5pygC91C', 'user', 'default.jpg', NULL),
(8, 'disha', 'dishapatel@gmail.com', '$2y$10$1X.AHxfyupFAEVE0yib8eOWHbzWXDIL8lZFjrIoyr7.NDqSby6i/m', 'user', 'default.jpg', NULL),
(0, 'Jerry', 'jerry@gmail.com', '$2y$10$6Q/qrc7RKdQSGkQ53Kt.nuWLynl6UMGR93rj31XY4Ube2wYGYjPaS', 'user', 'default.jpg', NULL),
(0, 'jyo', 'jyo@gmail.com', '$2y$10$9FhE48MRZ3ZBYW0tQu2iI.ugiPeYOFfLTVXK/gumLCkUAcvvKyUse', 'user', 'default.jpg', NULL),
(0, 'Jyotsana', 'jyoptsananamulla@gmail.com', '$2y$10$pYFRyWOcfuuOwj14THU9keATqQVKM7UclhX.9q05rcw4sIJu5KPrG', 'user', 'default.jpg', NULL),
(0, 'Kajol', 'kajol@gmail.com', '$2y$10$RMsEzWqEixBQxeaneTyz9uyCUc5A.hvRW0mi9k.nMi7dQYW0.2SRC', 'user', 'default.jpg', NULL),
(0, 'Krishi', 'krishi@gmail.com', '$2y$10$GPl0oOog9.zoAqFQwusaeeD8T18T4tQO4EQZswZfB6MwVwBj7hXiq', 'user', 'default.jpg', NULL),
(0, 'lana', 'lanadel@gmail.com', '$2y$10$jC9qUaps/ui2S00.Bi650.o5rIZxSI7vmMy/3w/HOqbcTzVHtYQR.', 'user', 'default.jpg', NULL),
(0, 'mittu', 'mittu29@gmail.com', '$2y$10$9tAQCsXeNW5Q8/vGUFdKu.XPi9YUEl1SEKEl8enq2VOOfWGx2SAg6', 'user', 'default.jpg', NULL),
(23, 'Ntkx', 'ntkw@gmail.com', '$2y$10$FAeRnvupZzL1fH5B2eqtneUqEWBXExoUiv/gjgxJpx47NXv1CY/Ni', 'user', 'default.jpg', NULL),
(0, 'Pooja', 'pooja@gmail.com', '$2y$10$.JyS.YDB6fKCPxpSevEKUu/7JH8SIfo7FOiWFLNxvkkFYshqB4YTW', 'user', 'default.jpg', NULL),
(0, 'pragya', 'pragyakathotia12@gmail.com', '$2y$10$cnXP2JAtsEs8bASS.5xuBO7W/haucVoXwOZsOZPVe/dVraG6Jc272', 'admin', 'default.jpg', NULL),
(0, 'Rahul', 'rahul@gmail.com', '$2y$10$WtNzSchsCwPlRR/nwBlohuVKopMCPyhfM417OJYIhgNeEmvYt7vdW', 'user', 'default.jpg', NULL),
(0, 'rajani', 'rajani@gmail.com', '$2y$10$Qbnc6Poq9zxHZPEXUBi01O5.K9IGsYNjonXR7p27B5Nqi8NtLtieu', 'user', 'default.jpg', NULL),
(0, 'rhys', 'rhys@gmail.com', '$2y$10$.HLklbYkiS5CuJCs4BoTSOGXaLytyKxs5GGQt31SgsjHnpMoUGg32', 'user', 'default.jpg', NULL),
(0, 'Roza', 'roza@gmail.com', '$2y$10$iC/qm.8EEKP0pT6nrXKtLekFhii.N/v1kn0cwcQeO7mVkQSL11gry', 'user', 'default.jpg', NULL),
(18, 'sandhya', 'sandhya@gmail.com', '$2y$10$g59GwEg7W0qJNeYh.OOOVuQo10Lt.eHyZUN7RSJMvAFopkYm4./Ua', 'user', 'default.jpg', NULL),
(17, 'sandy', 'sady@gmail.com', '$2y$10$7QTe6yH4DvAHAQ04nb3gIeUNwyFYaJK8ZxHAXy8wVPXiKxYzXFApC', 'user', 'default.jpg', NULL),
(0, 'sanjana', 'sanjana@gmail.com', '$2y$10$J/h6HE8eu9rD.TmhNwXFWOVkwC.1pLvarI0gjk5C0BTiJMPk67PG.', 'user', 'default.jpg', NULL),
(0, 'sanju', 'sanju@gmail.com', '$2y$10$/jR5e8mMTf9CZeUSUiLVlO14f3APeT63c8oS6qQsMa1pSdMPUI8ye', 'user', 'default.jpg', NULL),
(5, 'shyam', 'shyam@gmail.com', '$2y$10$5kAlhoQv5NqKLD3fkv.O2.iTi7Qdofqhs39nBCrwNmBFztGaWt026', 'user', 'default.jpg', NULL),
(16, 'Simran', 'simran@gmail.cpm', '$2y$10$Qf0YkQKnQ1z7RYrdZDN9l..p15laQIeWNuJDrHrchmiVABhSSmweG', 'user', 'default.jpg', NULL),
(3, 'sowmya', 'sowmyanair@gmail.com', '$2y$10$OlLxLzjWBNMwfpiQUx6E7O3qutwJPiUnywzU5dpNGufsK4jvLpBR.', 'user', 'uploads/profile_pictures/1738767204_WIN_20241125_13_46_48_Pro.jpg', 'best cr ever'),
(19, 'sreej1234', 'sreejanizam777@gmail.com', '$2y$10$xcqBGGGYxFRILQvJpHTD8OZAFWqpL7cvYiZavyqpWp.1cSScpuc/K', 'user', 'default.jpg', NULL),
(7, 'suditi', 'suditi@gmail.com', '$2y$10$62gYTQSsIXnoTe4giKLGSOLznXx59KV7OfEQA/WFBAyH7jdTd8ezK', 'user', 'default.jpg', NULL),
(4, 'Suzanne', 'zanne@gmail.com', '$2y$10$/IdcPj2.Z6lb9qBfx5LzXuMQKzn6nGRy5O93TX6QX5QCHovOqSGA2', 'user', 'default.jpg', NULL),
(14, 'vaishnavi', 'vaishnaviram@gmail.com', '$2y$10$9aklnEJyA2Wkxjkf3PhrtOis0hYek9XG9LH1ReKjTB5A2m.3OxnMi', 'admin', 'default.jpg', NULL),
(15, 'vasavi', 'vasavi@gmail.com', '$2y$10$zM//xMYRISoX0Y3P.6Qf6OMCsOJF4w5uaLaDpXBtKJMMI3K8gyDe6', 'user', 'default.jpg', NULL),
(21, 'Vedika', 'vedika@gmail.com', '$2y$10$i6ewiS5QxfXOzlwMW0Yr9O0gAfRjSRJ.OB1p2HylirGhUMizJHUXu', 'user', 'default.jpg', NULL),
(9, 'vidit', 'vidit@gmail.com', '$2y$10$8BmN3Rq2WMQpoFkVG31a4.vS59AIm.RcRDZRHSOa1KOV.WB3JrjEa', 'user', 'default.jpg', NULL),
(6, 'Vydehi', 'vydehi@gmail.com', '$2y$10$ZN0sR2HSN1t2bBL2qMgwNetHiu5LKBZyT5tHcDUpt6z53PxkFgIVK', 'user', 'default.jpg', NULL),
(10, 'yashasvi', 'yashasvi@gmail.com', '$2y$10$YNNR1uWoew78DLGZK1VACOSPPnXa9mbFPvC1xAAiqUYZATDmVdw8C', 'user', 'default.jpg', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
