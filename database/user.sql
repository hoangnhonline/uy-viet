-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2017 at 01:46 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maps`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `type` tinyint(4) NOT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `company_id` int(11) NOT NULL,
  `group_user_id` int(11) NOT NULL,
  `remember_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_user` int(11) DEFAULT NULL,
  `updated_user` int(11) DEFAULT NULL,
  `company_user_id` int(11) DEFAULT NULL,
  `operator_user_id` int(11) DEFAULT NULL,
  `executive_user_id` int(11) DEFAULT NULL,
  `supervisor_user_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `fullname`, `email`, `type`, `phone`, `status`, `create_time`, `company_id`, `group_user_id`, `remember_token`, `created_at`, `updated_at`, `created_user`, `updated_user`, `company_user_id`, `operator_user_id`, `executive_user_id`, `supervisor_user_id`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'Uy Việt', 'admin@gmail.com', 1, '01657 060 XXX', 1, '0000-00-00 00:00:00', 1, 0, '1x5k9WzIMSYgZyDLnX7uQgNHJxQU0HVziVX1nFIc9f3FpM6PaCNRyp5WiGOa', '0000-00-00 00:00:00', '2017-07-25 10:09:13', NULL, NULL, NULL, NULL, NULL, NULL),
(34, 'hung', 'e10adc3949ba59abbe56e057f20f883e', 'Cao Mạnh Hùng', 'a@a', 2, '093', 1, '2017-01-06 06:45:27', 5, 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(31, 'tran', '21232f297a57a5a743894a0e4a801fc3', 'tran', 'a@a', 5, '099', 1, '2016-12-22 22:22:15', 1, 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(30, 'hangkhong', '3f98801b81bf08237688075400ef653c', 'Hàng không Việt Nam', 'a@a', 2, 'a@a091', 1, '2016-12-22 21:36:46', 6, 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(32, 'ti', 'c4ca4238a0b923820dcc509a6f75849b', 'ti', 'a@a', 4, 'admin', 1, '2016-12-23 21:21:23', 1, 16, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 28, 28, 37, 38, NULL, NULL),
(18, 'hoasinh', 'c33367701511b4f6020ec61ded352059', 'Hoa Sinh', 'a@hoasinh', 5, '090', 1, '2016-12-23 21:43:54', 1, 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 32, 32, 37, NULL, 32, NULL),
(28, 'tien', '21232f297a57a5a743894a0e4a801fc3', 'tien', 'a@a', 3, 'a@a', 1, '2016-12-22 20:34:28', 1, 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 37, 37, NULL, NULL, NULL, NULL),
(35, 'tienuv', '25d55ad283aa400af464c76d713c07ad', 'tien', 'a@a', 1, '', 1, '2017-02-24 05:09:11', 1, 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(37, 'hoang_company', 'e10adc3949ba59abbe56e057f20f883e', 'Hoang ', 'hoang_company@gmail.com', 2, '087654321', 1, '2017-06-20 06:56:51', 1, 4, 'r88rKLLvXMN1P2rJL7aueSsx0Ihigo4MMhBuM1HuL3ucNXMiRX8RcvkTo9ql', '2017-06-20 06:56:51', '2017-06-21 02:17:23', 1, 1, NULL, NULL, NULL, NULL),
(38, 'hoang_operator', 'e10adc3949ba59abbe56e057f20f883e', 'hoang_operator', 'hoang_operator@gmail.com', 3, '0765432122', 1, '2017-06-20 07:28:42', 1, 0, 'lgM1NpT4kIoNmuYBWci2e7T3vpY0FJXCX4b8DRPLyT15S5m4P1pclG0ccxeA', '2017-06-20 07:28:42', '2017-06-21 02:37:19', 37, 37, 37, NULL, NULL, NULL),
(39, 'uv_company', 'e10adc3949ba59abbe56e057f20f883e', 'UV Company', 'uv_company@gmail.com', 2, '1234', 1, '2017-07-25 06:59:06', 1, 4, 'OmLqzzCSP2PRbFW0OZZD5MmAhSLcp7YimQjKTmitvTxAJY08cwQadc8kHH8Y', '2017-07-25 06:59:06', '2017-07-25 10:19:46', 1, 1, NULL, NULL, NULL, NULL),
(41, 'uv_operator_1', 'e10adc3949ba59abbe56e057f20f883e', 'UV Operator 1', 'uv_operator_1@gmail.com', 3, '123', 1, '2017-07-25 07:19:56', 1, 0, 'vuF4yOPVViAGHEKk3pEJqVKAh45YPJBLWcpJsIdEEZBLSakLwVKKJW5Ahwvu', '2017-07-25 07:19:56', '2017-07-25 10:23:06', 1, 1, 39, NULL, NULL, NULL),
(42, 'uv_executive_1', 'e10adc3949ba59abbe56e057f20f883e', 'UV Execitive 1', 'uv_executive_1@gmail.com', 4, '123', 1, '2017-07-25 07:27:22', 1, 0, '7Qynfy8kUVWTc563tIrf5pIxJLRhCt1R1Nzf5kDAxEBxGBxlgeMYSge3KEa3', '2017-07-25 07:27:22', '2017-07-25 10:23:20', 1, 1, 39, 41, NULL, NULL),
(43, 'uv_supervisor_1', 'e10adc3949ba59abbe56e057f20f883e', 'UV Supervisor 1', 'uv_supervisor_1@gmail.com', 5, '1234556', 1, '2017-07-25 07:30:27', 1, 0, 'oP0pnecJQ20w59tmv87HoQgIm0W8QwUy6AXcFUpUP8qx6h5ora8j0oLAwbRZ', '2017-07-25 07:30:27', '2017-07-25 10:23:31', 1, 1, 39, 41, 42, NULL),
(44, 'uv_supervisor_2', 'e10adc3949ba59abbe56e057f20f883e', 'UV Supervisor 2', 'uv_supervisor_2@gmail.com', 5, '123', 1, '2017-07-25 07:33:38', 1, 0, NULL, '2017-07-25 07:33:38', '2017-07-25 07:33:38', 1, 1, 39, 41, 42, NULL),
(45, 'uv_sale_1', 'e10adc3949ba59abbe56e057f20f883e', 'UV Sale 1', 'uv_sale_1@gmail.com', 6, '123', 1, '2017-07-25 07:35:43', 1, 4, NULL, '2017-07-25 07:35:43', '2017-07-25 10:08:27', 1, 1, 39, 41, 42, 43),
(46, 'uv_sale_2', 'e10adc3949ba59abbe56e057f20f883e', 'UV Sale 2', 'uv_sale_2@gmail.com', 6, '123', 1, '2017-07-25 07:37:13', 1, 0, NULL, '2017-07-25 07:37:13', '2017-07-25 07:37:13', 1, 1, 39, 41, 42, 43),
(47, 'operator_create_by_com', 'e10adc3949ba59abbe56e057f20f883e', 'operator create by com', 'operator_create_by_com@gmail.com', 3, '123', 1, '2017-07-25 14:46:58', 1, 6, NULL, '2017-07-25 14:46:58', '2017-07-25 15:23:05', 39, 39, 39, NULL, NULL, NULL),
(48, 'executive_create_by_com', 'e10adc3949ba59abbe56e057f20f883e', 'Excutive create by uv company', 'executive_create_by_com@gmail.com', 4, '123', 1, '2017-07-25 14:53:31', 1, 0, NULL, '2017-07-25 14:53:31', '2017-07-25 14:53:31', 39, 39, 39, 47, NULL, NULL),
(49, 'supervisor_create_by_com', 'e10adc3949ba59abbe56e057f20f883e', 'Supervisor create by com', 'supervisor_create_by_com@gmail.com', 5, '123456', 1, '2017-07-25 15:01:25', 1, 6, NULL, '2017-07-25 15:01:25', '2017-07-25 15:01:25', 39, 39, 39, 47, 48, NULL),
(50, 'sale_create_by_com', 'e10adc3949ba59abbe56e057f20f883e', 'Sale create by com', 'sale_create_by_com@gmail.com', 6, '123456', 1, '2017-07-25 15:03:22', 1, 0, NULL, '2017-07-25 15:03:22', '2017-07-25 15:03:22', 39, 39, 39, 47, 48, 49);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
