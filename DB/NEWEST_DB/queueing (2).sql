-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2025 at 06:18 AM
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
  `role` enum('admin','accounts','tellerwithdraw','tellerdeposit','telleropenaccount','tellerDocumentation','tellerCrewing','tellerTechOps','tellerSourcing','tellerTanker','tellerWelfare','teller1','teller2','teller3') NOT NULL,
  `department` enum('ADMIN','ACCOUNTS','TELLERWITHDRAW','TELLERDEPOSIT','TELLEROPENACCOUNT','TELLERDOCUMENTATION','TELLERCREWING','TELLERTECHOPS','TELLERSOURCING','TELLERTANKER','TELLERWELFARE') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `gender`, `age`, `birthday`, `address`, `contact`, `role`, `department`, `created_at`) VALUES
(1, 'Jodels Saragena', 'Female', 21, '2003-06-19', 'CEbu', '09238173730', 'tellerCrewing', 'ADMIN', '2025-03-13 07:40:35'),
(2, 'JL', 'Male', 25, '1999-03-30', 'Minglanilla', '09876545678', 'tellerDocumentation', 'ADMIN', '2025-03-17 06:06:31'),
(3, 'James', 'Male', 24, '1999-07-13', 'Pardo', '0964563463', 'tellerSourcing', 'ADMIN', '2025-03-17 06:07:26'),
(4, 'Jade', 'Female', 35, '1980-09-23', 'Cebu', '09237234621472', 'admin', 'ADMIN', '2025-03-17 06:23:10'),
(5, 'Brayan', 'Male', 25, '1999-03-30', 'Cebu', '098635138755', 'tellerwithdraw', 'ADMIN', '2025-03-17 06:45:02'),
(6, 'Emma Pantz', 'Female', 25, '1999-03-30', 'Cebu', '098374613413', 'tellerdeposit', 'ADMIN', '2025-03-17 06:45:40'),
(7, 'Timothy Do', 'Male', 25, '1999-03-30', 'CEbu', '09775722242', 'telleropenaccount', 'ADMIN', '2025-03-17 06:46:07'),
(8, 'Blythe', 'Female', 25, '1999-03-30', 'Cev', '0967867547', 'tellerTanker', 'ADMIN', '2025-03-17 06:47:46');

-- --------------------------------------------------------

--
-- Table structure for table `queue`
--

CREATE TABLE `queue` (
  `id` int(11) NOT NULL,
  `queue_number` varchar(255) DEFAULT NULL,
  `status` enum('Waiting','Serving','Done') DEFAULT 'Waiting',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_generated` date NOT NULL DEFAULT curdate(),
  `department` enum('ADMIN','ACCOUNTS','DOCUMENTATION','CREWING','TECHOPS','SOURCING','TANKER','WELFARE') NOT NULL,
  `teller` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `queue`
--

INSERT INTO `queue` (`id`, `queue_number`, `status`, `created_at`, `updated_at`, `date_generated`, `department`, `teller`) VALUES
(109, 'B-1', 'Waiting', '2025-03-25 05:13:54', '2025-03-25 05:13:54', '2025-03-25', 'ACCOUNTS', 'Teller1'),
(110, 'A-1', 'Waiting', '2025-03-25 05:13:56', '2025-03-25 05:13:56', '2025-03-25', 'ADMIN', 'Teller1'),
(111, 'A-2', 'Waiting', '2025-03-25 05:14:00', '2025-03-25 05:14:00', '2025-03-25', 'ADMIN', 'Teller2'),
(112, 'B-2', 'Waiting', '2025-03-25 05:14:04', '2025-03-25 05:14:04', '2025-03-25', 'ACCOUNTS', 'Teller2'),
(113, 'B-3', 'Waiting', '2025-03-25 05:14:20', '2025-03-25 05:14:20', '2025-03-25', 'ACCOUNTS', 'Teller3'),
(114, 'C-1', 'Waiting', '2025-03-25 05:14:21', '2025-03-25 05:14:21', '2025-03-25', 'DOCUMENTATION', 'Teller1'),
(115, 'D-1', 'Waiting', '2025-03-25 05:14:22', '2025-03-25 05:14:22', '2025-03-25', 'CREWING', 'Teller1'),
(116, 'D-2', 'Waiting', '2025-03-25 05:14:23', '2025-03-25 05:14:23', '2025-03-25', 'CREWING', 'Teller2'),
(117, 'E-1', 'Waiting', '2025-03-25 05:14:25', '2025-03-25 05:14:25', '2025-03-25', 'TECHOPS', 'Teller1'),
(118, 'E-2', 'Waiting', '2025-03-25 05:14:25', '2025-03-25 05:14:25', '2025-03-25', 'TECHOPS', 'Teller2'),
(119, 'F-1', 'Waiting', '2025-03-25 05:14:26', '2025-03-25 05:14:26', '2025-03-25', 'SOURCING', 'Teller1'),
(120, 'F-2', 'Waiting', '2025-03-25 05:14:27', '2025-03-25 05:14:27', '2025-03-25', 'SOURCING', 'Teller2'),
(121, 'G-1', 'Waiting', '2025-03-25 05:14:27', '2025-03-25 05:14:27', '2025-03-25', 'TANKER', 'Teller1'),
(122, 'H-1', 'Waiting', '2025-03-25 05:14:28', '2025-03-25 05:14:28', '2025-03-25', 'WELFARE', 'Teller1'),
(123, 'H-2', 'Waiting', '2025-03-25 05:14:51', '2025-03-25 05:14:51', '2025-03-25', 'WELFARE', 'Teller2'),
(124, 'G-2', 'Waiting', '2025-03-25 05:14:52', '2025-03-25 05:14:52', '2025-03-25', 'TANKER', 'Teller2'),
(125, 'G-3', 'Waiting', '2025-03-25 05:14:53', '2025-03-25 05:14:53', '2025-03-25', 'TANKER', 'Teller3'),
(126, 'H-3', 'Waiting', '2025-03-25 05:14:53', '2025-03-25 05:14:53', '2025-03-25', 'WELFARE', 'Teller3'),
(127, 'F-3', 'Waiting', '2025-03-25 05:14:54', '2025-03-25 05:14:54', '2025-03-25', 'SOURCING', 'Teller3'),
(128, 'D-3', 'Waiting', '2025-03-25 05:14:55', '2025-03-25 05:14:55', '2025-03-25', 'CREWING', 'Teller3'),
(129, 'E-3', 'Waiting', '2025-03-25 05:14:56', '2025-03-25 05:14:56', '2025-03-25', 'TECHOPS', 'Teller3'),
(130, 'C-2', 'Waiting', '2025-03-25 05:15:05', '2025-03-25 05:15:05', '2025-03-25', 'DOCUMENTATION', 'Teller2'),
(131, 'C-3', 'Waiting', '2025-03-25 05:15:07', '2025-03-25 05:15:07', '2025-03-25', 'DOCUMENTATION', 'Teller3'),
(132, 'A-3', 'Waiting', '2025-03-25 05:16:51', '2025-03-25 05:16:51', '2025-03-25', 'ADMIN', 'Teller3');

-- --------------------------------------------------------

--
-- Table structure for table `tellers`
--

CREATE TABLE `tellers` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','teller1','teller2','teller3') NOT NULL,
  `department` enum('ADMIN','ACCOUNTS','DOCUMENTATION','CREWING','TECHOPS','SOURCING','TANKER','WELFARE') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tellers`
--

INSERT INTO `tellers` (`id`, `username`, `password`, `role`, `department`, `created_at`) VALUES
(1, 'admin', '$2y$10$HtS9qzyc2plCN3.1NfyKH.aedZbCpIpDPsv8s.6qMZCvaO42b75qq', 'admin', 'ADMIN', '2025-03-21 05:11:22'),
(2, 'Admin_Teller1', '$2y$10$CgMOe3r.LwjAH/.NQkU/K.7FRlVUmCXMPgRpzjUxDimIX03oEugNC', 'teller1', 'ADMIN', '2025-03-21 05:12:51'),
(3, 'Admin_Teller2', '$2y$10$XIE94bnIJbkonMleqCp/DeK5ia/MbV1TyQAQT2rzQxhEOsDa1fx66', 'teller2', 'ADMIN', '2025-03-21 05:14:06'),
(4, 'Admin_Teller3', '$2y$10$ioJVdY/5suAXSBxrCbPFHOQeTSTkVd6PuUzC4aFy785Y/yc94T2CG', 'teller3', 'ADMIN', '2025-03-21 05:14:15'),
(5, 'Accounts_Teller1', '$2y$10$nLrGHQ8nJTRBZrPeXXbtt.lMqFd1o/zgV.bZuFhpZrosI8UujJHQ6', 'teller1', 'ACCOUNTS', '2025-03-21 05:35:47'),
(6, 'Accounts_Teller2', '$2y$10$VPUKqljejs/.FajklcAQ5utUzxqEDrzL5QD9RQx6VNJ1pJ1fxkXMi', 'teller2', 'ACCOUNTS', '2025-03-21 05:36:10'),
(7, 'Accounts_Teller3', '$2y$10$TqTcHeMEZ22JeDSfu5tuWuObgobXaRm9FaW..HA8iUQ84MHb7mGyC', 'teller3', 'ACCOUNTS', '2025-03-21 05:36:25'),
(8, 'Doc_Teller1', '$2y$10$1zgZacV2lqPAMDmM3bAEEe0Zi4nOBRlLs9TYRX8u5izJ3vK9ULs..', 'teller1', 'DOCUMENTATION', '2025-03-21 08:52:14'),
(9, 'Doc_Teller2', '$2y$10$ipraiL.Vxpkb1.8SzvuTBeRMjff7I.WFxlXgCBQwbuRmjmS9Bz3tW', 'teller2', 'DOCUMENTATION', '2025-03-21 08:53:05'),
(10, 'Doc_Teller3', '$2y$10$Snvug3L2LN43rRvg3gPKU..b9QHk.offUlQIvkTKJ8ThtrgAmT2zO', 'teller3', 'DOCUMENTATION', '2025-03-21 08:53:42'),
(11, 'Crewing_Teller1', '$2y$10$13PzkTVzrS6b5/P5z8MwjuGUjallI9U1s2XF/qSgudT..LpkUWyHS', 'teller1', 'CREWING', '2025-03-21 08:56:07'),
(12, 'Crewing_Teller2', '$2y$10$xH/eKIKGVz5VxvVvgHx.M.PB5aCFIxVwe09j4W081OjHGdDYOiqum', 'teller2', 'CREWING', '2025-03-21 08:57:24'),
(13, 'Crewing_Teller3', '$2y$10$O6.W6/Y3lIl9oRxEpihLY.itl6XxudyttxhqbKkfgzR0ciqdFTs.u', 'teller3', 'CREWING', '2025-03-21 08:58:05'),
(14, 'TechcOps_Teller1', '$2y$10$w2QfLs4pdkwYhKJNGgkDQ.AUetoqeWtWXmFDcyZbthc.J.oXyooSy', 'teller1', 'TECHOPS', '2025-03-21 09:01:10'),
(15, 'TechOps_Teller2', '$2y$10$SAQ4eQEGiA3zsQ26wm.DdOg.GiQ.3D8WwYddVvI.bdQF.8vAkSKz2', 'teller2', 'TECHOPS', '2025-03-21 09:01:34'),
(16, 'TechOps_Teller3', '$2y$10$1sblDLNXty2W1CBqC9IHNuK0qZrM8atyVnJx8R7f6bO9Or3CL7iIK', 'teller3', 'TECHOPS', '2025-03-21 09:02:02'),
(17, 'Sourcing_Teller1', '$2y$10$AhvsCdk780myhbRrzl5pX.HelgpjlC9p3vXTBCoAJ8MxXKK6AbMY.', 'teller1', 'SOURCING', '2025-03-21 09:02:30'),
(18, 'Sourcing_Teller2', '$2y$10$2YQsGCi3T1VVfgmZoTVcLOrWlERfAKfg11DL7nk2WsKl6vEvkpX7S', 'teller2', 'SOURCING', '2025-03-21 09:02:51'),
(19, 'Sourcing_Teller3', '$2y$10$ngbYPTgVfmhjB6bKfXdlBeZLtUIrKLPIxT83ZsvMfHMg0As.8Z2JC', 'teller3', 'SOURCING', '2025-03-21 09:03:21'),
(20, 'Tanker_Teller1', '$2y$10$l4tOeKr.ATBvdN7fz8frluXRv1xCZUF9rL.DfuF2pHh.5D4dILMAS', 'teller1', 'TANKER', '2025-03-24 02:09:12'),
(21, 'Tanker_Teller2', '$2y$10$b/CKAxFAjs4ZMUX.mIX0F.gT1ujtXFG5wvDBCGnekdvhYVeNfdj72', 'teller2', 'TANKER', '2025-03-24 02:09:29'),
(22, 'Tanker_Teller3', '$2y$10$7OxnJRnQ1Dk1KVciQmicD.zWswYuZ1GiwVMNpV/S4d7slE.FXS0eu', 'teller3', 'TANKER', '2025-03-24 02:09:47'),
(23, 'Welfare_Teller1', '$2y$10$1i9S0Cnq.flO0v4WA0HsTOOd8oO0UUVqoBPthTAQljyghZ2DgD.Nq', 'teller1', 'WELFARE', '2025-03-24 02:10:28'),
(24, 'Welfare_Teller2', '$2y$10$/3W608Dq0aTwbE2l4VBGd.PkZ17BLEhQmcp6ehqNYbd273xLe8gkS', 'teller2', 'WELFARE', '2025-03-24 02:10:55'),
(25, 'Welfare_Teller3', '$2y$10$vfoKVmwgpNAnG77W4d98f.dDlfUV/riTDkQ9ItFrTqpGw4dE8Gbi2', 'teller3', 'WELFARE', '2025-03-24 02:11:15');

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
  ADD UNIQUE KEY `queue_number_5` (`queue_number`,`date_generated`),
  ADD UNIQUE KEY `queue_number_7` (`queue_number`,`date_generated`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `tellers`
--
ALTER TABLE `tellers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
