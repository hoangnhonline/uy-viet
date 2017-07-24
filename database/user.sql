-- phpMyAdmin SQL Dump
-- version 4.6.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 24, 2017 at 02:11 PM
-- Server version: 5.6.30-1+deb.sury.org~wily+2
-- PHP Version: 5.6.11-1ubuntu3.4

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
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'Uy Việt', 'admin@gmail.com', 1, '01657 060 XXX', 1, '0000-00-00 00:00:00', 1, 0, 'vYAiEOhFUacQT70qEWBuv25qF3ICgfo2Tr8SSTChYE16xjrd8AY31vUch3OL', '0000-00-00 00:00:00', '2017-06-29 01:01:57', NULL, NULL, NULL, NULL, NULL, NULL),
(34, 'hung', 'e10adc3949ba59abbe56e057f20f883e', 'Cao Mạnh Hùng', 'a@a', 2, '093', 1, '2017-01-06 06:45:27', 5, 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(31, 'tran', '21232f297a57a5a743894a0e4a801fc3', 'tran', 'a@a', 5, '099', 1, '2016-12-22 22:22:15', 1, 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(30, 'hangkhong', '3f98801b81bf08237688075400ef653c', 'Hàng không Việt Nam', 'a@a', 2, 'a@a091', 1, '2016-12-22 21:36:46', 6, 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(32, 'ti', 'c4ca4238a0b923820dcc509a6f75849b', 'ti', 'a@a', 4, 'admin', 1, '2016-12-23 21:21:23', 1, 16, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 28, 28, 37, 38, NULL, NULL),
(18, 'hoasinh', 'c33367701511b4f6020ec61ded352059', 'Hoa Sinh', 'a@hoasinh', 5, '090', 1, '2016-12-23 21:43:54', 1, 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 32, 32, 37, NULL, 32, NULL),
(28, 'tien', '21232f297a57a5a743894a0e4a801fc3', 'tien', 'a@a', 3, 'a@a', 1, '2016-12-22 20:34:28', 1, 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 37, 37, NULL, NULL, NULL, NULL),
(35, 'tienuv', '25d55ad283aa400af464c76d713c07ad', 'tien', 'a@a', 1, '', 1, '2017-02-24 05:09:11', 1, 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(37, 'hoang_company', 'e10adc3949ba59abbe56e057f20f883e', 'Hoang ', 'hoang_company@gmail.com', 2, '087654321', 1, '2017-06-20 06:56:51', 1, 4, 'r88rKLLvXMN1P2rJL7aueSsx0Ihigo4MMhBuM1HuL3ucNXMiRX8RcvkTo9ql', '2017-06-20 06:56:51', '2017-06-21 02:17:23', 1, 1, NULL, NULL, NULL, NULL),
(38, 'hoang_operator', 'e10adc3949ba59abbe56e057f20f883e', 'hoang_operator', 'hoang_operator@gmail.com', 3, '0765432122', 1, '2017-06-20 07:28:42', 1, 0, 'lgM1NpT4kIoNmuYBWci2e7T3vpY0FJXCX4b8DRPLyT15S5m4P1pclG0ccxeA', '2017-06-20 07:28:42', '2017-06-21 02:37:19', 37, 37, 37, NULL, NULL, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
