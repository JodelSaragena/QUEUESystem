-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2025 at 04:55 AM
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
-- Database: `queueing`
--

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `title`, `description`, `file_path`, `created_by`, `created_at`) VALUES
(11, 'New', 'New', 'uploads/1741833817_NC.pdf', 'A_Doc', '2025-03-13 02:43:37');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `age` int(11) NOT NULL,
  `birthday` date NOT NULL,
  `address` text NOT NULL,
  `contact` varchar(50) NOT NULL,
  `role` enum('admin','tellerwithdraw','tellerdeposit','telleropenaccount','tellerDocumentation','tellerCrewing','tellerTechOps','tellerSourcing','tellerTanker','tellerWelfare') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `gender`, `age`, `birthday`, `address`, `contact`, `role`, `created_at`) VALUES
(1, 'Jodels Saragena', 'Female', 21, '2003-06-19', 'CEbu', '09238173730', 'tellerCrewing', '2025-03-13 07:40:35'),
(2, 'JL', 'Male', 25, '1999-03-30', 'Minglanilla', '09876545678', 'tellerDocumentation', '2025-03-17 06:06:31'),
(3, 'James', 'Male', 24, '1999-07-13', 'Pardo', '0964563463', 'tellerSourcing', '2025-03-17 06:07:26'),
(4, 'Jade', 'Female', 35, '1980-09-23', 'Cebu', '09237234621472', 'admin', '2025-03-17 06:23:10'),
(5, 'Brayan', 'Male', 25, '1999-03-30', 'Cebu', '098635138755', 'tellerwithdraw', '2025-03-17 06:45:02'),
(6, 'Emma Pantz', 'Female', 25, '1999-03-30', 'Cebu', '098374613413', 'tellerdeposit', '2025-03-17 06:45:40'),
(7, 'Timothy Do', 'Male', 25, '1999-03-30', 'CEbu', '09775722242', 'telleropenaccount', '2025-03-17 06:46:07'),
(8, 'Blythe', 'Female', 25, '1999-03-30', 'Cev', '0967867547', 'tellerTanker', '2025-03-17 06:47:46');

-- --------------------------------------------------------

--
-- Table structure for table `queue`
--

CREATE TABLE `queue` (
  `id` int(11) NOT NULL,
  `queue_number` varchar(10) NOT NULL,
  `transaction_type` enum('deposit','withdrawal','open_account') NOT NULL,
  `status` enum('waiting','serving','done') DEFAULT 'waiting',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_generated` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `queue`
--

INSERT INTO `queue` (`id`, `queue_number`, `transaction_type`, `status`, `created_at`, `updated_at`, `date_generated`) VALUES
(170, 'D-1', 'deposit', 'done', '2025-03-11 06:00:30', '2025-03-11 06:02:00', '2025-03-18'),
(171, 'W-1', 'withdrawal', 'done', '2025-03-11 06:00:31', '2025-03-11 06:02:01', '2025-03-18'),
(172, 'A-1', 'open_account', 'done', '2025-03-11 06:00:32', '2025-03-11 06:08:00', '2025-03-18'),
(173, 'W-2', 'withdrawal', 'done', '2025-03-11 06:00:33', '2025-03-11 06:07:58', '2025-03-18'),
(174, 'D-2', 'deposit', 'done', '2025-03-11 06:00:34', '2025-03-11 06:02:02', '2025-03-18'),
(175, 'W-3', 'withdrawal', 'done', '2025-03-11 06:00:35', '2025-03-12 13:51:13', '2025-03-18'),
(176, 'D-3', 'deposit', 'done', '2025-03-11 06:49:15', '2025-03-11 06:50:15', '2025-03-18'),
(177, 'W-4', 'withdrawal', 'done', '2025-03-11 06:49:16', '2025-03-11 06:50:11', '2025-03-18'),
(178, 'W-5', 'withdrawal', 'done', '2025-03-11 06:49:16', '2025-03-11 06:50:13', '2025-03-18'),
(179, 'A-2', 'open_account', 'done', '2025-03-11 06:49:18', '2025-03-11 06:49:39', '2025-03-18'),
(180, 'W-6', 'withdrawal', 'done', '2025-03-11 06:49:19', '2025-03-11 06:50:12', '2025-03-18'),
(181, 'A-3', 'open_account', 'done', '2025-03-11 06:49:19', '2025-03-11 06:49:40', '2025-03-18'),
(182, 'W-7', 'withdrawal', 'done', '2025-03-11 06:49:21', '2025-03-17 05:39:58', '2025-03-18'),
(183, 'W-8', 'withdrawal', 'done', '2025-03-11 06:49:21', '2025-03-11 06:50:22', '2025-03-18'),
(184, 'W-9', 'withdrawal', 'done', '2025-03-11 06:49:21', '2025-03-11 06:50:21', '2025-03-18'),
(185, 'A-4', 'open_account', 'done', '2025-03-11 06:49:22', '2025-03-11 06:50:08', '2025-03-18'),
(186, 'A-5', 'open_account', 'done', '2025-03-11 06:49:22', '2025-03-11 06:49:42', '2025-03-18'),
(187, 'A-6', 'open_account', 'done', '2025-03-11 06:49:23', '2025-03-11 06:50:17', '2025-03-18'),
(188, 'A-7', 'open_account', 'done', '2025-03-11 06:49:23', '2025-03-11 06:50:09', '2025-03-18'),
(189, 'D-4', 'deposit', 'done', '2025-03-11 06:49:24', '2025-03-11 06:50:20', '2025-03-18'),
(190, 'D-5', 'deposit', 'done', '2025-03-11 06:49:24', '2025-03-11 06:50:11', '2025-03-18'),
(191, 'D-6', 'deposit', 'done', '2025-03-11 06:50:29', '2025-03-11 06:50:42', '2025-03-18'),
(192, 'A-8', 'open_account', 'done', '2025-03-11 06:50:30', '2025-03-12 13:51:16', '2025-03-18'),
(193, 'D-7', 'deposit', 'done', '2025-03-11 06:50:47', '2025-03-12 13:51:14', '2025-03-18'),
(194, 'D-8', 'deposit', 'done', '2025-03-11 06:50:47', '2025-03-13 08:49:07', '2025-03-18'),
(195, 'A-9', 'open_account', 'done', '2025-03-11 06:50:48', '2025-03-12 03:59:12', '2025-03-18'),
(196, 'A-10', 'open_account', 'done', '2025-03-11 06:50:49', '2025-03-12 13:51:16', '2025-03-18'),
(197, 'D-9', 'deposit', 'done', '2025-03-11 06:50:50', '2025-03-12 13:51:13', '2025-03-18'),
(198, 'D-10', 'deposit', 'done', '2025-03-11 06:50:50', '2025-03-12 13:51:11', '2025-03-18'),
(199, 'D-11', 'deposit', 'done', '2025-03-11 06:50:50', '2025-03-12 13:51:15', '2025-03-18'),
(200, 'D-12', 'deposit', 'done', '2025-03-11 06:50:50', '2025-03-12 13:51:12', '2025-03-18'),
(201, 'D-13', 'deposit', 'done', '2025-03-11 06:50:51', '2025-03-12 13:51:15', '2025-03-18'),
(202, 'D-14', 'deposit', 'done', '2025-03-11 06:50:51', '2025-03-13 08:48:48', '2025-03-18'),
(203, 'D-15', 'deposit', 'done', '2025-03-11 06:50:51', '2025-03-12 13:51:12', '2025-03-18'),
(204, 'A-11', 'open_account', 'done', '2025-03-11 06:50:52', '2025-03-12 13:51:16', '2025-03-18'),
(205, 'A-12', 'open_account', 'done', '2025-03-11 06:50:52', '2025-03-11 06:51:48', '2025-03-18'),
(206, 'A-13', 'open_account', 'done', '2025-03-11 06:50:52', '2025-03-17 05:40:08', '2025-03-18'),
(207, 'A-14', 'open_account', 'done', '2025-03-11 06:50:53', '2025-03-12 13:51:11', '2025-03-18'),
(208, 'A-15', 'open_account', 'done', '2025-03-11 06:50:53', '2025-03-17 05:40:07', '2025-03-18'),
(209, 'W-10', 'withdrawal', 'done', '2025-03-12 13:47:48', '2025-03-12 13:51:14', '2025-03-18'),
(210, 'W-11', 'withdrawal', 'done', '2025-03-12 13:51:23', '2025-03-17 05:39:59', '2025-03-18'),
(211, 'W-12', 'withdrawal', 'done', '2025-03-12 13:51:23', '2025-03-17 05:39:57', '2025-03-18'),
(212, 'D-16', 'deposit', 'done', '2025-03-12 13:51:24', '2025-03-13 08:49:12', '2025-03-18'),
(213, 'A-16', 'open_account', 'done', '2025-03-12 13:51:24', '2025-03-17 05:40:05', '2025-03-18'),
(214, 'A-17', 'open_account', 'done', '2025-03-12 13:51:38', '2025-03-17 05:40:06', '2025-03-18'),
(215, 'D-17', 'deposit', 'done', '2025-03-13 08:48:16', '2025-03-13 08:49:10', '2025-03-18'),
(216, 'W-13', 'withdrawal', 'done', '2025-03-13 08:48:17', '2025-03-17 05:40:27', '2025-03-18'),
(217, 'A-18', 'open_account', 'done', '2025-03-13 08:48:17', '2025-03-17 05:47:08', '2025-03-18'),
(218, 'D-18', 'deposit', 'done', '2025-03-13 08:48:19', '2025-03-17 05:39:51', '2025-03-18'),
(219, 'A-19', 'open_account', 'done', '2025-03-13 08:48:20', '2025-03-17 05:40:07', '2025-03-18'),
(220, 'D-19', 'deposit', 'done', '2025-03-13 08:48:21', '2025-03-17 05:39:51', '2025-03-18'),
(221, 'W-14', 'withdrawal', 'done', '2025-03-13 08:48:22', '2025-03-17 05:40:24', '2025-03-18'),
(222, 'W-15', 'withdrawal', 'done', '2025-03-13 08:48:23', '2025-03-17 05:40:29', '2025-03-18'),
(223, 'A-20', 'open_account', 'done', '2025-03-13 08:48:23', '2025-03-17 02:44:43', '2025-03-18'),
(224, 'W-16', 'withdrawal', 'done', '2025-03-13 08:48:25', '2025-03-17 05:40:30', '2025-03-18'),
(225, 'W-17', 'withdrawal', 'done', '2025-03-13 08:48:25', '2025-03-17 05:40:47', '2025-03-18'),
(226, 'W-18', 'withdrawal', 'done', '2025-03-17 02:38:20', '2025-03-17 05:41:58', '2025-03-18'),
(227, 'A-21', 'open_account', 'done', '2025-03-17 02:38:21', '2025-03-17 05:42:01', '2025-03-18'),
(228, 'D-20', 'deposit', 'done', '2025-03-17 02:38:22', '2025-03-17 05:39:47', '2025-03-18'),
(229, 'W-19', 'withdrawal', 'done', '2025-03-17 02:38:22', '2025-03-17 05:40:46', '2025-03-18'),
(230, 'D-21', 'deposit', 'done', '2025-03-17 02:38:24', '2025-03-17 05:47:05', '2025-03-18'),
(231, 'A-22', 'open_account', 'done', '2025-03-17 05:47:18', '2025-03-17 05:47:25', '2025-03-18'),
(232, 'A-23', 'open_account', 'done', '2025-03-17 05:47:19', '2025-03-17 05:48:24', '2025-03-18'),
(233, 'A-24', 'open_account', 'done', '2025-03-17 05:47:19', '2025-03-17 05:47:27', '2025-03-18'),
(234, 'A-25', 'open_account', 'done', '2025-03-17 05:47:19', '2025-03-17 05:47:27', '2025-03-18'),
(235, 'A-26', 'open_account', 'done', '2025-03-17 05:47:20', '2025-03-17 05:48:19', '2025-03-18'),
(236, 'A-27', 'open_account', 'done', '2025-03-17 05:47:20', '2025-03-17 05:48:21', '2025-03-18'),
(237, 'D-22', 'deposit', 'done', '2025-03-17 05:47:37', '2025-03-17 05:48:28', '2025-03-18'),
(238, 'W-20', 'withdrawal', 'done', '2025-03-17 05:47:37', '2025-03-17 05:47:45', '2025-03-18'),
(239, 'W-21', 'withdrawal', 'done', '2025-03-17 05:47:38', '2025-03-17 05:47:47', '2025-03-18'),
(240, 'D-23', 'deposit', 'waiting', '2025-03-17 05:48:37', '2025-03-17 05:48:37', '2025-03-18'),
(241, 'D-24', 'deposit', 'waiting', '2025-03-17 05:48:37', '2025-03-17 05:48:37', '2025-03-18'),
(242, 'D-25', 'deposit', 'waiting', '2025-03-17 05:48:37', '2025-03-17 05:48:37', '2025-03-18'),
(243, 'D-26', 'deposit', 'waiting', '2025-03-17 05:48:38', '2025-03-17 05:48:38', '2025-03-18'),
(244, 'W-22', 'withdrawal', 'waiting', '2025-03-18 03:39:49', '2025-03-18 03:39:49', '2025-03-18');

-- --------------------------------------------------------

--
-- Table structure for table `tellers`
--

CREATE TABLE `tellers` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','tellerwithdraw','tellerdeposit','telleropenaccount','tellerdocumentation','tellercrewing','tellertechOps','tellersourcing','tellertanker','tellerwelfare') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tellers`
--

INSERT INTO `tellers` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(14, 'tellerdeposit', '$2y$10$T9rBvIoepKGp5dNeqFDvHOjxq3cn3dZ0Jrt5chSlynCaFgZnFUm2K', 'tellerdeposit', '2025-03-10 08:43:30'),
(16, 'telleropenaccount', '$2y$10$qFYAL5vPaqPCMzE3v/5BnOwxBgyoggtz1hGzrfomw9pLhnJsl2NcG', 'telleropenaccount', '2025-03-11 02:38:06'),
(17, 'tellerwithdraw', '$2y$10$f/SJD6aC577tptazukLOQ.CoAyLWEWxjRS87ZNmGU5sZRJOYaILIC', 'tellerwithdraw', '2025-03-11 03:24:46'),
(19, 'admin', '$2y$10$VdrysxWX7RxhBcKDMPX1SubQXapEe7GhAHEhIwPw2FWoHQ38qsSRi', 'admin', '2025-03-12 14:03:29'),
(21, 'A_Doc', '$2y$10$rw8.Ozvr9RFEFfy6ao1mgOY56Ft1uX2zoZCzRc5Cq9OhcBPK2UqNW', 'tellerdocumentation', '2025-03-12 14:17:43'),
(23, 'Acrewing', '$2y$10$Lsd.O2FoY6qZegUJ3g7o9.IWeLszX9RsOfXotjEhu/OTuBqcny5ba', 'tellercrewing', '2025-03-12 14:37:56'),
(24, 'A_Creewing', '$2y$10$WBnookp6bY2EdFpiV3WRR.qnEF.Zopv0f0qNVy3/pNj3MnkUtV5aq', 'tellercrewing', '2025-03-13 03:35:37'),
(25, 'A_Source', '$2y$10$ZCfXkC0PpIVRrY3lL5CJBu7rXH.379G0wmdSU6rxhMogtjGv1PWne', 'tellersourcing', '2025-03-17 05:56:36'),
(26, 'A_Tanker', '$2y$10$c02WvMAFhklhEZlnqHyCGuEa0ZJ9Ihdh5go26WgXc7j9IQ8Vvg9Sq', 'tellertanker', '2025-03-17 07:17:12'),
(27, 'A_Welfare', '$2y$10$zCudmARCzjMu9fNnVQVZLOTZ4ZEaER.IifEN33JNiIdp1r4rLgf8K', 'tellerwelfare', '2025-03-17 07:59:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `queue_number` (`queue_number`);

--
-- Indexes for table `tellers`
--
ALTER TABLE `tellers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `queue`
--
ALTER TABLE `queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=260;

--
-- AUTO_INCREMENT for table `tellers`
--
ALTER TABLE `tellers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
