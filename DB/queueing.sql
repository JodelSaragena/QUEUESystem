-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2025 at 06:59 AM
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
(266, 'W-1', 'withdrawal', 'done', '2025-03-18 03:57:14', '2025-03-18 05:59:29', '2025-03-18'),
(267, 'D-1', 'deposit', 'done', '2025-03-18 03:57:14', '2025-03-18 05:59:13', '2025-03-18'),
(268, 'A-1', 'open_account', 'done', '2025-03-18 03:57:15', '2025-03-18 05:59:20', '2025-03-18'),
(269, 'W-2', 'withdrawal', 'done', '2025-03-18 03:57:15', '2025-03-18 05:59:35', '2025-03-18'),
(270, 'W-3', 'withdrawal', 'done', '2025-03-18 03:57:16', '2025-03-18 05:59:30', '2025-03-18'),
(271, 'A-2', 'open_account', 'done', '2025-03-18 03:57:16', '2025-03-18 05:59:22', '2025-03-18'),
(272, 'A-3', 'open_account', 'done', '2025-03-18 03:57:17', '2025-03-18 05:59:21', '2025-03-18'),
(273, 'A-4', 'open_account', 'done', '2025-03-18 03:57:17', '2025-03-18 05:59:22', '2025-03-18'),
(274, 'A-5', 'open_account', 'done', '2025-03-18 03:57:17', '2025-03-18 05:59:23', '2025-03-18'),
(275, 'W-4', 'withdrawal', 'done', '2025-03-18 03:57:18', '2025-03-18 05:59:34', '2025-03-18'),
(276, 'W-5', 'withdrawal', 'done', '2025-03-18 03:57:18', '2025-03-18 05:59:34', '2025-03-18'),
(277, 'D-2', 'deposit', 'done', '2025-03-18 03:57:19', '2025-03-18 05:59:14', '2025-03-18'),
(278, 'D-3', 'deposit', 'done', '2025-03-18 03:57:19', '2025-03-18 05:59:15', '2025-03-18');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=279;

--
-- AUTO_INCREMENT for table `tellers`
--
ALTER TABLE `tellers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
