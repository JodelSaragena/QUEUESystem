-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2025 at 03:50 AM
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
-- Table structure for table `queue`
--

CREATE TABLE `queue` (
  `id` int(11) NOT NULL,
  `queue_number` varchar(255) DEFAULT NULL,
  `status` enum('Waiting','Serving','Done') DEFAULT 'Waiting',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_generated` date NOT NULL DEFAULT curdate(),
  `services` varchar(255) DEFAULT NULL,
  `teller` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `queue`
--

INSERT INTO `queue` (`id`, `queue_number`, `status`, `created_at`, `updated_at`, `date_generated`, `services`, `teller`) VALUES
(141, 'A-1', 'Waiting', '2025-03-25 06:31:47', '2025-03-25 06:31:47', '2025-03-25', 'ADMIN', 'Teller1');

-- --------------------------------------------------------

--
-- Table structure for table `tellers`
--

CREATE TABLE `tellers` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','teller1','teller2','teller3') NOT NULL,
  `services` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tellers`
--

INSERT INTO `tellers` (`id`, `username`, `password`, `role`, `services`, `created_at`) VALUES
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
-- AUTO_INCREMENT for table `queue`
--
ALTER TABLE `queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT for table `tellers`
--
ALTER TABLE `tellers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
