-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2025 at 06:19 AM
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
(298, 'D-1', 'deposit', 'done', '2025-03-19 05:13:55', '2025-03-19 05:19:13', '2025-03-19'),
(299, 'W-1', 'withdrawal', 'done', '2025-03-19 05:13:56', '2025-03-19 05:18:49', '2025-03-19'),
(300, 'A-1', 'open_account', 'done', '2025-03-19 05:13:56', '2025-03-19 05:18:37', '2025-03-19'),
(301, 'W-2', 'withdrawal', 'done', '2025-03-19 05:13:57', '2025-03-19 05:18:50', '2025-03-19'),
(302, 'W-3', 'withdrawal', 'done', '2025-03-19 05:13:58', '2025-03-19 05:18:52', '2025-03-19'),
(303, 'W-4', 'withdrawal', 'done', '2025-03-19 05:13:58', '2025-03-19 05:18:53', '2025-03-19'),
(304, 'W-5', 'withdrawal', 'done', '2025-03-19 05:13:58', '2025-03-19 05:18:53', '2025-03-19'),
(305, 'W-6', 'withdrawal', 'done', '2025-03-19 05:13:59', '2025-03-19 05:18:54', '2025-03-19'),
(306, 'W-7', 'withdrawal', 'done', '2025-03-19 05:13:59', '2025-03-19 05:18:55', '2025-03-19'),
(307, 'W-8', 'withdrawal', 'done', '2025-03-19 05:13:59', '2025-03-19 05:18:56', '2025-03-19'),
(308, 'W-9', 'withdrawal', 'done', '2025-03-19 05:14:00', '2025-03-19 05:18:56', '2025-03-19'),
(309, 'W-10', 'withdrawal', 'done', '2025-03-19 05:14:00', '2025-03-19 05:18:57', '2025-03-19'),
(310, 'W-11', 'withdrawal', 'done', '2025-03-19 05:14:00', '2025-03-19 05:18:58', '2025-03-19'),
(311, 'W-12', 'withdrawal', 'done', '2025-03-19 05:14:01', '2025-03-19 05:18:59', '2025-03-19'),
(312, 'W-13', 'withdrawal', 'done', '2025-03-19 05:14:01', '2025-03-19 05:19:00', '2025-03-19'),
(313, 'W-14', 'withdrawal', 'done', '2025-03-19 05:14:01', '2025-03-19 05:19:00', '2025-03-19'),
(314, 'W-15', 'withdrawal', 'done', '2025-03-19 05:14:01', '2025-03-19 05:19:01', '2025-03-19'),
(315, 'D-2', 'deposit', 'done', '2025-03-19 05:14:02', '2025-03-19 05:19:13', '2025-03-19'),
(316, 'D-3', 'deposit', 'done', '2025-03-19 05:14:02', '2025-03-19 05:19:14', '2025-03-19'),
(317, 'D-4', 'deposit', 'done', '2025-03-19 05:14:02', '2025-03-19 05:19:15', '2025-03-19'),
(318, 'D-5', 'deposit', 'done', '2025-03-19 05:14:03', '2025-03-19 05:19:15', '2025-03-19'),
(319, 'D-6', 'deposit', 'done', '2025-03-19 05:14:03', '2025-03-19 05:19:16', '2025-03-19'),
(320, 'D-7', 'deposit', 'done', '2025-03-19 05:14:03', '2025-03-19 05:19:17', '2025-03-19'),
(321, 'D-8', 'deposit', 'done', '2025-03-19 05:14:03', '2025-03-19 05:19:18', '2025-03-19'),
(322, 'D-9', 'deposit', 'done', '2025-03-19 05:14:03', '2025-03-19 05:19:18', '2025-03-19'),
(323, 'D-10', 'deposit', 'done', '2025-03-19 05:14:04', '2025-03-19 05:19:19', '2025-03-19'),
(324, 'D-11', 'deposit', 'done', '2025-03-19 05:14:04', '2025-03-19 05:19:20', '2025-03-19'),
(325, 'A-2', 'open_account', 'done', '2025-03-19 05:14:05', '2025-03-19 05:18:38', '2025-03-19'),
(326, 'A-3', 'open_account', 'done', '2025-03-19 05:14:06', '2025-03-19 05:18:39', '2025-03-19'),
(327, 'A-4', 'open_account', 'done', '2025-03-19 05:14:06', '2025-03-19 05:18:39', '2025-03-19'),
(328, 'A-5', 'open_account', 'done', '2025-03-19 05:14:06', '2025-03-19 05:18:40', '2025-03-19'),
(329, 'A-6', 'open_account', 'done', '2025-03-19 05:14:06', '2025-03-19 05:18:41', '2025-03-19'),
(330, 'A-7', 'open_account', 'done', '2025-03-19 05:14:07', '2025-03-19 05:18:42', '2025-03-19'),
(331, 'D-1', 'deposit', 'done', '2025-03-20 05:15:32', '2025-03-19 05:19:20', '2025-03-20'),
(332, 'W-1', 'withdrawal', 'done', '2025-03-20 05:15:33', '2025-03-19 05:19:02', '2025-03-20'),
(333, 'W-2', 'withdrawal', 'done', '2025-03-20 05:15:34', '2025-03-19 05:19:02', '2025-03-20'),
(334, 'A-1', 'open_account', 'done', '2025-03-20 05:15:35', '2025-03-19 05:18:42', '2025-03-20'),
(335, 'W-3', 'withdrawal', 'done', '2025-03-20 05:15:35', '2025-03-19 05:19:04', '2025-03-20'),
(336, 'D-2', 'deposit', 'done', '2025-03-20 05:15:35', '2025-03-19 05:19:21', '2025-03-20');

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
(27, 'A_Welfare', '$2y$10$zCudmARCzjMu9fNnVQVZLOTZ4ZEaER.IifEN33JNiIdp1r4rLgf8K', 'tellerwelfare', '2025-03-17 07:59:58'),
(28, 'Admin1', '$2y$10$xCU.VPqXfoHbJ1YiztD1EecZIlbvc/y/O9m1/HVZYtiCAaJlaAtr2', 'admin', '2025-03-18 03:57:58');

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
  ADD UNIQUE KEY `queue_number_2` (`queue_number`,`date_generated`),
  ADD UNIQUE KEY `queue_number_3` (`queue_number`,`date_generated`),
  ADD UNIQUE KEY `queue_number_4` (`queue_number`,`date_generated`),
  ADD UNIQUE KEY `queue_number_5` (`queue_number`,`date_generated`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=337;

--
-- AUTO_INCREMENT for table `tellers`
--
ALTER TABLE `tellers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
