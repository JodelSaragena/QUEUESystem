-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2025 at 05:41 AM
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
-- Database: `queue`
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
(142, 'A-1', 'Done', '2025-03-26 03:16:33', '2025-03-26 12:00:01', '2025-03-26', 'ADMIN', 'Teller1'),
(143, 'A-2', 'Done', '2025-03-26 03:16:34', '2025-03-26 15:38:48', '2025-03-26', 'ADMIN', 'Teller2'),
(144, 'B-1', 'Done', '2025-03-26 03:16:35', '2025-03-27 06:43:19', '2025-03-26', 'ACCOUNTS', 'Teller1'),
(145, 'C-1', 'Done', '2025-03-26 03:16:36', '2025-03-27 06:44:26', '2025-03-26', 'DOCUMENTATION', 'Teller1'),
(146, 'D-1', 'Waiting', '2025-03-26 03:16:38', '2025-03-26 03:16:38', '2025-03-26', 'CREWING', 'Teller1'),
(147, 'E-1', 'Waiting', '2025-03-26 03:16:39', '2025-03-26 03:16:39', '2025-03-26', 'TECHOPS', 'Teller1'),
(148, 'F-1', 'Done', '2025-03-26 03:16:40', '2025-03-27 06:33:37', '2025-03-26', 'SOURCING', 'Teller1'),
(149, 'G-1', 'Done', '2025-03-26 03:16:41', '2025-03-27 06:37:07', '2025-03-26', 'TANKER', 'Teller1'),
(150, 'H-1', 'Done', '2025-03-26 03:16:41', '2025-03-27 16:26:56', '2025-03-26', 'WELFARE', 'Teller1'),
(151, 'A-3', 'Done', '2025-03-26 05:17:53', '2025-03-26 05:39:53', '2025-03-26', 'ADMIN', 'Teller3'),
(152, 'A-4', 'Done', '2025-03-26 05:36:46', '2025-03-26 13:52:50', '2025-03-26', 'ADMIN', 'Teller1'),
(153, 'A-5', 'Done', '2025-03-26 05:37:24', '2025-03-26 13:53:50', '2025-03-26', 'ADMIN', 'Teller1'),
(154, 'A-6', 'Done', '2025-03-26 06:26:02', '2025-03-26 15:45:03', '2025-03-26', 'ADMIN', 'Teller3'),
(155, 'A-7', 'Done', '2025-03-26 06:26:05', '2025-03-26 15:09:17', '2025-03-26', 'ADMIN', 'Teller1'),
(156, 'A-8', 'Done', '2025-03-26 06:32:30', '2025-03-26 15:40:41', '2025-03-26', 'ADMIN', 'Teller2'),
(157, 'A-9', 'Done', '2025-03-26 06:33:30', '2025-03-26 15:16:23', '2025-03-26', 'ADMIN', 'Teller1'),
(158, 'A-10', 'Done', '2025-03-26 06:33:54', '2025-03-26 15:16:32', '2025-03-26', 'ADMIN', 'Teller1'),
(159, 'A-11', 'Done', '2025-03-26 06:35:48', '2025-03-26 15:38:49', '2025-03-26', 'ADMIN', 'Teller2'),
(160, 'A-12', 'Waiting', '2025-03-26 06:41:33', '2025-03-26 06:41:33', '2025-03-26', 'ADMIN', 'Teller3'),
(161, 'A-13', 'Done', '2025-03-26 08:39:49', '2025-03-26 15:17:36', '2025-03-26', 'ADMIN', 'Teller1'),
(162, 'A-14', 'Done', '2025-03-26 08:40:23', '2025-03-26 15:17:38', '2025-03-26', 'ADMIN', 'Teller1'),
(163, 'A-15', 'Done', '2025-03-26 08:45:01', '2025-03-26 15:31:20', '2025-03-26', 'ADMIN', 'Teller1'),
(164, 'A-16', 'Done', '2025-03-26 08:53:38', '2025-03-26 15:38:49', '2025-03-26', 'ADMIN', 'Teller2'),
(165, 'A-17', 'Done', '2025-03-26 09:07:19', '2025-03-26 15:36:07', '2025-03-26', 'ADMIN', 'Teller1'),
(166, 'C-2', 'Waiting', '2025-03-26 09:08:38', '2025-03-26 09:08:38', '2025-03-26', 'DOCUMENTATION', 'Teller3'),
(167, 'C-3', 'Done', '2025-03-26 09:09:50', '2025-03-27 06:44:46', '2025-03-26', 'DOCUMENTATION', 'Teller1'),
(168, 'A-18', 'Done', '2025-03-26 13:59:59', '2025-03-26 15:42:59', '2025-03-26', 'ADMIN', 'Teller2'),
(169, 'A-19', 'Done', '2025-03-26 15:31:50', '2025-03-26 15:36:48', '2025-03-26', 'ADMIN', 'Teller1'),
(170, 'A-20', 'Done', '2025-03-26 15:31:56', '2025-03-26 15:36:50', '2025-03-26', 'ADMIN', 'Teller1'),
(171, 'A-21', 'Done', '2025-03-26 15:37:00', '2025-03-26 15:42:56', '2025-03-26', 'ADMIN', 'Teller2'),
(172, 'A-22', 'Done', '2025-03-26 15:37:07', '2025-03-26 15:37:53', '2025-03-26', 'ADMIN', 'Teller1'),
(173, 'A-23', 'Done', '2025-03-26 15:37:10', '2025-03-26 15:38:39', '2025-03-26', 'ADMIN', 'Teller1'),
(174, 'A-24', 'Done', '2025-03-26 15:43:43', '2025-03-26 15:45:38', '2025-03-26', 'ADMIN', 'Teller1'),
(175, 'A-25', 'Done', '2025-03-26 15:43:47', '2025-03-26 15:49:39', '2025-03-26', 'ADMIN', 'Teller1'),
(176, 'A-26', 'Done', '2025-03-26 15:43:52', '2025-03-27 06:13:12', '2025-03-26', 'ADMIN', 'Teller1'),
(177, 'A-1', 'Done', '2025-03-27 06:45:50', '2025-03-27 17:39:38', '2025-03-27', 'ADMIN', 'Teller2'),
(178, 'A-2', 'Waiting', '2025-03-27 06:46:03', '2025-03-27 06:46:03', '2025-03-27', 'ADMIN', 'Teller3'),
(179, 'B-1', 'Done', '2025-03-27 06:46:21', '2025-03-28 01:44:53', '2025-03-27', 'ACCOUNTS', 'Teller1'),
(180, 'B-2', 'Waiting', '2025-03-27 06:46:26', '2025-03-27 06:46:26', '2025-03-27', 'ACCOUNTS', 'Teller2'),
(181, 'B-3', 'Waiting', '2025-03-27 06:46:30', '2025-03-27 06:46:30', '2025-03-27', 'ACCOUNTS', 'Teller3'),
(182, 'B-4', 'Waiting', '2025-03-27 06:46:37', '2025-03-27 06:46:37', '2025-03-27', 'ACCOUNTS', 'Teller3'),
(183, 'C-1', 'Waiting', '2025-03-27 06:46:42', '2025-03-27 06:46:42', '2025-03-27', 'DOCUMENTATION', 'Teller1'),
(184, 'B-5', 'Waiting', '2025-03-27 06:46:47', '2025-03-27 06:46:47', '2025-03-27', 'ACCOUNTS', 'Teller2'),
(185, 'B-6', 'Waiting', '2025-03-27 06:46:52', '2025-03-27 06:46:52', '2025-03-27', 'ACCOUNTS', 'Teller3'),
(186, 'C-2', 'Waiting', '2025-03-27 06:46:57', '2025-03-27 06:46:57', '2025-03-27', 'DOCUMENTATION', 'Teller1'),
(187, 'C-3', 'Waiting', '2025-03-27 06:47:02', '2025-03-27 06:47:02', '2025-03-27', 'DOCUMENTATION', 'Teller2'),
(188, 'C-4', 'Waiting', '2025-03-27 06:47:08', '2025-03-27 06:47:08', '2025-03-27', 'DOCUMENTATION', 'Teller3'),
(189, 'D-1', 'Waiting', '2025-03-27 06:47:15', '2025-03-27 06:47:15', '2025-03-27', 'CREWING', 'Teller1'),
(190, 'D-2', 'Waiting', '2025-03-27 06:47:20', '2025-03-27 06:47:20', '2025-03-27', 'CREWING', 'Teller2'),
(191, 'D-3', 'Waiting', '2025-03-27 06:47:27', '2025-03-27 06:47:27', '2025-03-27', 'CREWING', 'Teller3'),
(192, 'E-1', 'Waiting', '2025-03-27 06:47:34', '2025-03-27 06:47:34', '2025-03-27', 'TECHOPS', 'Teller1'),
(193, 'D-4', 'Waiting', '2025-03-27 06:47:40', '2025-03-27 06:47:40', '2025-03-27', 'CREWING', 'Teller2'),
(197, 'E-4', 'Waiting', '2025-03-27 06:48:05', '2025-03-27 06:48:05', '2025-03-27', 'TECHOPS', 'Teller3'),
(198, 'F-1', 'Done', '2025-03-27 06:48:11', '2025-03-27 16:29:14', '2025-03-27', 'SOURCING', 'Teller1'),
(202, 'G-2', 'Done', '2025-03-27 06:48:31', '2025-03-27 16:27:43', '2025-03-27', 'TANKER', 'Teller2'),
(205, 'H-2', 'Done', '2025-03-27 06:48:50', '2025-03-27 16:26:32', '2025-03-27', 'WELFARE', 'Teller2'),
(206, 'H-3', 'Done', '2025-03-27 06:48:56', '2025-03-27 16:26:14', '2025-03-27', 'WELFARE', 'Teller3'),
(207, 'A-3', 'Done', '2025-03-27 08:00:16', '2025-03-27 15:52:47', '2025-03-27', 'ADMIN', 'Teller1'),
(213, 'A-1', 'Done', '2025-03-27 17:40:22', '2025-03-28 01:37:51', '2025-03-28', 'ADMIN', 'Teller1'),
(214, 'A-2', 'Done', '2025-03-27 17:40:28', '2025-03-28 01:55:13', '2025-03-28', 'ADMIN', 'Teller2'),
(215, 'D-1', 'Done', '2025-03-27 17:44:09', '2025-03-28 08:34:13', '2025-03-28', 'CREWING', 'Teller1'),
(216, 'A-3', 'Done', '2025-03-28 01:37:01', '2025-03-28 01:38:09', '2025-03-28', 'ADMIN', 'Teller1'),
(217, 'A-4', 'Done', '2025-03-28 01:37:09', '2025-03-28 01:39:24', '2025-03-28', 'ADMIN', 'Teller1'),
(218, 'D-2', 'Done', '2025-03-28 01:37:14', '2025-03-28 08:34:54', '2025-03-28', 'CREWING', 'Teller1'),
(221, 'A-5', 'Done', '2025-03-28 01:44:33', '2025-03-28 01:55:50', '2025-03-28', 'ADMIN', 'Teller1'),
(223, 'B-1', 'Done', '2025-03-28 01:53:16', '2025-03-28 01:53:53', '2025-03-28', 'ACCOUNTS', 'Teller1'),
(224, 'B-2', 'Done', '2025-03-28 01:53:27', '2025-03-28 01:54:49', '2025-03-28', 'ACCOUNTS', 'Teller1'),
(225, 'A-6', 'Done', '2025-03-28 01:59:30', '2025-03-28 01:59:56', '2025-03-28', 'ADMIN', 'Teller2'),
(226, 'A-7', 'Done', '2025-03-28 02:02:44', '2025-03-28 02:03:16', '2025-03-28', 'ADMIN', 'Teller1'),
(227, 'A-8', 'Done', '2025-03-28 02:17:03', '2025-03-28 02:17:51', '2025-03-28', 'ADMIN', 'Teller1'),
(228, 'C-1', 'Waiting', '2025-03-28 02:41:06', '2025-03-28 02:41:06', '2025-03-28', 'DOCUMENTATION', 'Teller1'),
(229, 'E-1', 'Waiting', '2025-03-28 02:44:28', '2025-03-28 02:44:28', '2025-03-28', 'TECHOPS', 'Teller1'),
(230, 'F-1', 'Waiting', '2025-03-28 02:46:35', '2025-03-28 02:46:35', '2025-03-28', 'SOURCING', 'Teller1'),
(231, 'G-1', 'Waiting', '2025-03-28 02:47:16', '2025-03-28 02:47:16', '2025-03-28', 'TANKER', 'Teller1'),
(232, 'A-9', 'Done', '2025-03-28 08:28:27', '2025-03-28 08:29:09', '2025-03-28', 'ADMIN', 'Teller1'),
(233, 'A-10', 'Done', '2025-03-28 08:29:04', '2025-03-28 08:30:13', '2025-03-28', 'ADMIN', 'Teller2'),
(234, 'A-11', 'Done', '2025-03-28 08:30:31', '2025-03-28 08:34:00', '2025-03-28', 'ADMIN', 'Teller1'),
(235, 'B-3', 'Done', '2025-03-28 08:33:04', '2025-03-28 08:33:29', '2025-03-28', 'ACCOUNTS', 'Teller1'),
(236, 'A-1', 'Done', '2025-03-31 02:13:34', '2025-03-31 02:15:09', '2025-03-31', 'ADMIN', 'Teller1'),
(237, 'A-2', 'Done', '2025-03-31 05:36:23', '2025-03-31 08:00:36', '2025-03-31', 'ADMIN', 'Teller2'),
(238, 'B-1', 'Done', '2025-03-31 05:36:29', '2025-03-31 15:35:22', '2025-03-31', 'ACCOUNTS', 'Teller1'),
(239, 'A-3', 'Done', '2025-03-31 07:34:48', '2025-03-31 14:10:21', '2025-03-31', 'ADMIN', 'teller1'),
(240, 'A-4', 'Done', '2025-03-31 14:07:31', '2025-03-31 14:15:12', '2025-03-31', 'ADMIN', 'teller3'),
(241, 'A-5', 'Done', '2025-03-31 14:07:36', '2025-03-31 14:24:42', '2025-03-31', 'ADMIN', 'teller3'),
(242, 'A-6', 'Done', '2025-03-31 14:24:53', '2025-03-31 14:33:14', '2025-03-31', 'ADMIN', 'teller3'),
(243, 'A-7', 'Done', '2025-03-31 14:24:57', '2025-03-31 14:33:40', '2025-03-31', 'ADMIN', 'teller3'),
(244, 'A-8', 'Done', '2025-03-31 14:36:19', '2025-03-31 14:45:26', '2025-03-31', 'ADMIN', ''),
(245, 'A-9', 'Done', '2025-03-31 14:36:22', '2025-03-31 14:46:14', '2025-03-31', 'ADMIN', 'teller3'),
(246, 'A-10', 'Done', '2025-03-31 14:36:25', '2025-03-31 14:58:57', '2025-03-31', 'ADMIN', ''),
(247, 'A-11', 'Done', '2025-03-31 14:44:19', '2025-03-31 14:58:58', '2025-03-31', 'ADMIN', ''),
(248, 'A-12', 'Done', '2025-03-31 15:00:08', '2025-03-31 15:03:05', '2025-03-31', 'ADMIN', ''),
(249, 'A-13', 'Done', '2025-03-31 15:00:12', '2025-03-31 15:10:22', '2025-03-31', 'ADMIN', ''),
(250, 'A-14', 'Done', '2025-03-31 15:10:18', '2025-03-31 15:11:12', '2025-03-31', 'ADMIN', ''),
(251, 'A-15', 'Done', '2025-03-31 15:11:21', '2025-03-31 15:11:58', '2025-03-31', 'ADMIN', 'teller3'),
(252, 'A-16', 'Done', '2025-03-31 15:14:28', '2025-03-31 15:23:28', '2025-03-31', 'ADMIN', 'teller1'),
(253, 'A-17', 'Done', '2025-03-31 15:23:37', '2025-03-31 15:24:19', '2025-03-31', 'ADMIN', 'teller2'),
(254, 'A-18', 'Done', '2025-03-31 15:23:40', '2025-03-31 15:34:45', '2025-03-31', 'ADMIN', 'teller3'),
(255, 'A-19', 'Done', '2025-03-31 15:35:42', '2025-03-31 15:36:34', '2025-03-31', 'ADMIN', 'teller1'),
(256, 'A-20', 'Done', '2025-03-31 15:35:45', '2025-03-31 15:36:36', '2025-03-31', 'ADMIN', 'teller1'),
(257, 'A-21', 'Done', '2025-03-31 15:37:43', '2025-03-31 15:38:27', '2025-03-31', 'ADMIN', 'teller1'),
(258, 'A-22', 'Done', '2025-03-31 15:37:46', '2025-03-31 15:40:45', '2025-03-31', 'ADMIN', 'teller1'),
(259, 'A-23', 'Done', '2025-03-31 15:37:48', '2025-03-31 15:40:46', '2025-03-31', 'ADMIN', 'teller2'),
(260, 'A-24', 'Done', '2025-03-31 15:40:34', '2025-03-31 15:41:19', '2025-03-31', 'ADMIN', 'teller2'),
(261, 'A-25', 'Done', '2025-03-31 15:40:36', '2025-03-31 15:59:52', '2025-03-31', 'ADMIN', 'teller1'),
(262, 'A-26', 'Done', '2025-03-31 15:58:21', '2025-03-31 15:59:53', '2025-03-31', 'ADMIN', 'teller1'),
(263, 'A-1', 'Done', '2025-03-31 16:00:14', '2025-03-31 16:01:23', '2025-04-01', 'ADMIN', 'teller1'),
(264, 'A-2', 'Done', '2025-03-31 16:00:18', '2025-03-31 16:01:29', '2025-04-01', 'ADMIN', 'teller2'),
(265, 'A-3', 'Done', '2025-03-31 16:02:03', '2025-03-31 16:02:51', '2025-04-01', 'ADMIN', 'teller1'),
(266, 'A-4', 'Done', '2025-03-31 16:02:05', '2025-03-31 16:02:52', '2025-04-01', 'ADMIN', 'teller1'),
(267, 'A-5', 'Done', '2025-03-31 16:03:39', '2025-03-31 16:09:02', '2025-04-01', 'ADMIN', 'teller1'),
(268, 'A-6', 'Done', '2025-03-31 16:03:41', '2025-03-31 16:09:38', '2025-04-01', 'ADMIN', 'teller1'),
(269, 'A-7', 'Done', '2025-03-31 16:09:07', '2025-03-31 16:10:05', '2025-04-01', 'ADMIN', 'teller1'),
(270, 'A-8', 'Done', '2025-03-31 16:10:09', '2025-03-31 16:12:10', '2025-04-01', 'ADMIN', 'teller1'),
(271, 'A-9', 'Done', '2025-03-31 16:10:11', '2025-03-31 16:12:11', '2025-04-01', 'ADMIN', 'teller1'),
(272, 'A-10', 'Done', '2025-03-31 16:12:59', '2025-03-31 16:21:20', '2025-04-01', 'ADMIN', 'teller1'),
(273, 'A-11', 'Done', '2025-03-31 16:13:02', '2025-03-31 16:21:21', '2025-04-01', 'ADMIN', 'teller1'),
(274, 'A-12', 'Done', '2025-03-31 16:14:06', '2025-03-31 16:22:59', '2025-04-01', 'ADMIN', 'teller1'),
(275, 'A-13', 'Done', '2025-03-31 16:17:28', '2025-03-31 16:23:29', '2025-04-01', 'ADMIN', 'teller1'),
(276, 'A-14', 'Done', '2025-03-31 16:19:05', '2025-03-31 16:24:11', '2025-04-01', 'ADMIN', 'teller1'),
(277, 'A-15', 'Done', '2025-03-31 16:21:37', '2025-03-31 16:24:53', '2025-04-01', 'ADMIN', 'teller1'),
(278, 'A-16', 'Done', '2025-03-31 16:24:45', '2025-03-31 16:25:21', '2025-04-01', 'ADMIN', 'teller1'),
(279, 'A-17', 'Done', '2025-03-31 16:25:42', '2025-04-01 05:38:43', '2025-04-01', 'ADMIN', 'teller1'),
(280, 'A-18', 'Done', '2025-03-31 16:25:44', '2025-04-01 05:39:00', '2025-04-01', 'ADMIN', 'teller1'),
(281, 'A-19', 'Done', '2025-04-01 05:38:38', '2025-04-01 05:44:23', '2025-04-01', 'ADMIN', 'teller1'),
(282, 'A-20', 'Done', '2025-04-01 05:43:11', '2025-04-01 05:48:36', '2025-04-01', 'ADMIN', 'teller1'),
(283, 'A-21', 'Done', '2025-04-01 05:47:33', '2025-04-01 05:49:11', '2025-04-01', 'ADMIN', 'teller1'),
(284, 'A-22', 'Done', '2025-04-01 05:48:49', '2025-04-01 05:49:10', '2025-04-01', 'ADMIN', 'teller1'),
(285, 'A-23', 'Done', '2025-04-01 06:01:16', '2025-04-01 06:02:05', '2025-04-01', 'ADMIN', 'teller1'),
(286, 'A-24', 'Done', '2025-04-01 06:01:27', '2025-04-01 06:02:20', '2025-04-01', 'ADMIN', 'teller1'),
(287, 'A-25', 'Done', '2025-04-01 06:01:49', '2025-04-01 06:03:10', '2025-04-01', 'ADMIN', 'teller1'),
(288, 'A-26', 'Done', '2025-04-01 06:02:54', '2025-04-01 06:03:35', '2025-04-01', 'ADMIN', 'teller1'),
(289, 'A-27', 'Done', '2025-04-01 06:02:56', '2025-04-01 06:03:57', '2025-04-01', 'ADMIN', 'teller1'),
(290, 'A-28', 'Done', '2025-04-01 06:02:59', '2025-04-01 06:05:00', '2025-04-01', 'ADMIN', 'teller1'),
(291, 'A-29', 'Done', '2025-04-01 06:04:01', '2025-04-01 06:05:45', '2025-04-01', 'ADMIN', 'teller1'),
(292, 'A-30', 'Done', '2025-04-01 06:04:54', '2025-04-01 06:06:13', '2025-04-01', 'ADMIN', 'teller1'),
(293, 'A-31', 'Done', '2025-04-01 06:06:18', '2025-04-01 06:07:11', '2025-04-01', 'ADMIN', 'teller1'),
(294, 'A-32', 'Done', '2025-04-01 06:06:20', '2025-04-01 06:08:08', '2025-04-01', 'ADMIN', 'teller1'),
(295, 'A-33', 'Done', '2025-04-01 06:06:22', '2025-04-01 06:08:09', '2025-04-01', 'ADMIN', 'teller1'),
(296, 'A-34', 'Done', '2025-04-01 06:08:13', '2025-04-01 06:09:08', '2025-04-01', 'ADMIN', 'teller1'),
(297, 'A-35', 'Done', '2025-04-01 06:08:17', '2025-04-01 06:10:08', '2025-04-01', 'ADMIN', 'teller1'),
(298, 'A-36', 'Done', '2025-04-01 06:08:25', '2025-04-01 06:10:35', '2025-04-01', 'ADMIN', 'teller1'),
(299, 'A-37', 'Done', '2025-04-01 06:09:59', '2025-04-01 06:11:30', '2025-04-01', 'ADMIN', 'teller1'),
(300, 'A-38', 'Done', '2025-04-01 06:11:09', '2025-04-01 06:11:31', '2025-04-01', 'ADMIN', 'teller1'),
(301, 'A-39', 'Done', '2025-04-01 06:11:35', '2025-04-01 06:12:08', '2025-04-01', 'ADMIN', 'teller1'),
(302, 'A-40', 'Done', '2025-04-01 06:11:38', '2025-04-01 06:12:07', '2025-04-01', 'ADMIN', 'teller1'),
(303, 'A-41', 'Done', '2025-04-01 06:12:40', '2025-04-01 06:13:31', '2025-04-01', 'ADMIN', 'teller1'),
(304, 'A-42', 'Done', '2025-04-01 06:12:42', '2025-04-01 06:14:19', '2025-04-01', 'ADMIN', 'teller1'),
(305, 'A-43', 'Done', '2025-04-01 06:23:07', '2025-04-01 06:23:42', '2025-04-01', 'ADMIN', 'teller1'),
(306, 'A-44', 'Done', '2025-04-01 06:23:10', '2025-04-01 06:23:45', '2025-04-01', 'ADMIN', 'teller1'),
(307, 'A-45', 'Done', '2025-04-01 06:26:32', '2025-04-01 06:27:08', '2025-04-01', 'ADMIN', 'teller1'),
(308, 'A-46', 'Done', '2025-04-01 06:26:34', '2025-04-01 06:33:08', '2025-04-01', 'ADMIN', 'teller1'),
(309, 'A-47', 'Done', '2025-04-01 06:26:37', '2025-04-01 06:33:09', '2025-04-01', 'ADMIN', 'teller1'),
(310, 'A-48', 'Done', '2025-04-01 06:32:28', '2025-04-01 06:34:23', '2025-04-01', 'ADMIN', 'teller1'),
(311, 'A-49', 'Done', '2025-04-01 06:33:17', '2025-04-01 06:56:40', '2025-04-01', 'ADMIN', 'teller2'),
(312, 'A-50', 'Done', '2025-04-01 06:55:43', '2025-04-01 06:56:24', '2025-04-01', 'ADMIN', 'teller2'),
(313, 'A-51', 'Done', '2025-04-01 06:59:15', '2025-04-01 07:00:08', '2025-04-01', 'ADMIN', 'teller1'),
(314, 'A-52', 'Waiting', '2025-04-01 06:59:17', '2025-04-01 06:59:17', '2025-04-01', 'ADMIN', ''),
(315, 'A-1', 'Done', '2025-04-02 02:53:52', '2025-04-02 02:54:32', '2025-04-02', 'ADMIN', 'teller1'),
(316, 'A-2', 'Done', '2025-04-02 02:54:09', '2025-04-02 02:54:53', '2025-04-02', 'ADMIN', 'teller1'),
(317, 'A-3', 'Done', '2025-04-02 02:55:03', '2025-04-02 02:55:58', '2025-04-02', 'ADMIN', 'teller1'),
(318, 'A-4', 'Waiting', '2025-04-02 02:55:06', '2025-04-02 02:55:06', '2025-04-02', 'ADMIN', ''),
(319, 'B-1', 'Done', '2025-04-02 03:01:38', '2025-04-02 03:02:40', '2025-04-02', 'ACCOUNTS', 'teller3'),
(320, 'C-1', 'Done', '2025-04-02 03:04:42', '2025-04-02 03:05:31', '2025-04-02', 'DOCUMENTATION', 'teller1'),
(322, 'D-1', 'Done', '2025-04-02 03:07:20', '2025-04-02 03:08:09', '2025-04-02', 'CREWING', 'teller1'),
(324, 'E-1', 'Done', '2025-04-02 03:09:42', '2025-04-02 03:11:19', '2025-04-02', 'TECHOPS', 'teller1'),
(326, 'F-1', 'Done', '2025-04-02 03:13:33', '2025-04-02 03:14:43', '2025-04-02', 'SOURCING', 'teller1'),
(328, 'G-1', 'Done', '2025-04-02 03:15:54', '2025-04-02 03:17:14', '2025-04-02', 'TANKER', 'teller1'),
(329, 'G-2', 'Done', '2025-04-02 03:15:59', '2025-04-02 03:17:15', '2025-04-02', 'TANKER', 'teller1'),
(330, 'G-3', 'Done', '2025-04-02 03:17:00', '2025-04-02 03:17:43', '2025-04-02', 'TANKER', 'teller1'),
(332, 'H-1', 'Done', '2025-04-02 03:19:55', '2025-04-02 03:20:41', '2025-04-02', 'WELFARE', 'teller1'),
(337, 'H-2', 'Waiting', '2025-04-02 03:55:04', '2025-04-02 03:55:04', '2025-04-02', 'WELFARE', ''),
(338, 'A-1', 'Done', '2025-04-08 04:51:12', '2025-04-08 04:51:35', '2025-04-08', 'ADMIN', 'teller1'),
(339, 'A-2', 'Done', '2025-04-08 04:51:44', '2025-04-08 04:51:52', '2025-04-08', 'ADMIN', 'teller1'),
(340, 'A-3', 'Done', '2025-04-08 05:05:36', '2025-04-08 05:30:36', '2025-04-08', 'ADMIN', 'teller2'),
(341, 'A-4', 'Done', '2025-04-08 05:05:39', '2025-04-08 05:31:07', '2025-04-08', 'ADMIN', 'teller2'),
(366, 'A-5', 'Done', '2025-04-08 07:57:40', '2025-04-08 15:58:21', '2025-04-08', 'ADMIN', 'teller1'),
(367, 'A-6', 'Done', '2025-04-08 08:55:55', '2025-04-08 15:58:46', '2025-04-08', 'ADMIN', 'teller1'),
(368, 'A-7', 'Done', '2025-04-08 10:17:46', '2025-04-08 15:58:26', '2025-04-08', 'ADMIN', 'teller1'),
(369, 'B-1', 'Waiting', '2025-04-08 10:17:48', '2025-04-08 10:17:48', '2025-04-08', 'ACCOUNTS', ''),
(370, 'D-1', 'Waiting', '2025-04-08 10:17:52', '2025-04-08 10:17:52', '2025-04-08', 'CREWING', ''),
(371, 'D-2', 'Waiting', '2025-04-08 10:17:55', '2025-04-08 10:17:55', '2025-04-08', 'CREWING', ''),
(372, 'E-1', 'Waiting', '2025-04-08 10:17:59', '2025-04-08 10:17:59', '2025-04-08', 'TECHOPS', ''),
(373, 'F-1', 'Waiting', '2025-04-08 10:18:02', '2025-04-08 10:18:02', '2025-04-08', 'SOURCING', ''),
(374, 'G-1', 'Waiting', '2025-04-08 10:18:05', '2025-04-08 10:18:05', '2025-04-08', 'TANKER', ''),
(375, 'H-1', 'Waiting', '2025-04-08 10:18:08', '2025-04-08 10:18:08', '2025-04-08', 'WELFARE', ''),
(376, 'G-2', 'Waiting', '2025-04-08 10:18:11', '2025-04-08 10:18:11', '2025-04-08', 'TANKER', ''),
(377, 'A-8', 'Waiting', '2025-04-08 10:18:22', '2025-04-08 10:18:22', '2025-04-08', 'ADMIN', ''),
(378, 'B-2', 'Waiting', '2025-04-08 10:18:24', '2025-04-08 10:18:24', '2025-04-08', 'ACCOUNTS', ''),
(379, 'A-9', 'Waiting', '2025-04-08 15:57:59', '2025-04-08 15:57:59', '2025-04-08', 'ADMIN', ''),
(380, 'A-1', 'Serving', '2025-04-08 16:04:59', '2025-04-08 16:05:17', '2025-04-09', 'ADMIN', 'teller1'),
(381, 'A-2', 'Waiting', '2025-04-09 02:43:23', '2025-04-09 02:43:23', '2025-04-09', 'ADMIN', '');

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
(29, 'Welfare_Teller2', '$2y$10$714N9TSKfKvhs3JaTQSVGenMh8JxnupR3Clw9r5k/WC2YBWp5AnZG', 'teller2', 'WELFARE', '2025-04-02 03:53:12'),
(31, 'Welfare_Teller3', '$2y$10$5.hNpRyZyW6whR3ObFX5u.y26ebs5SZrZY7Zyx38osnbm6f6gON.C', 'teller3', 'WELFARE', '2025-04-02 03:54:34');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=382;

--
-- AUTO_INCREMENT for table `tellers`
--
ALTER TABLE `tellers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
