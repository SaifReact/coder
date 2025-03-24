-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 21, 2021 at 08:36 AM
-- Server version: 10.3.32-MariaDB
-- PHP Version: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `brandscollec_shopping`
--
CREATE DATABASE IF NOT EXISTS `brandscollec_shopping` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `brandscollec_shopping`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `updationDate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `creationDate`, `updationDate`) VALUES
(1, 'admin', '9ea986c4fa3eb4b4a4d7430db8734468', '2017-01-24 16:21:18', '02-04-2021 04:12:23 PM');

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `bannerName` varchar(100) NOT NULL,
  `bannerType` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `bannerName`, `bannerType`) VALUES
(1, 'Slider', 'SL'),
(2, 'Middle Ads', 'MA'),
(3, 'Last Ads', 'LA'),
(4, 'Others', 'OT');

-- --------------------------------------------------------

--
-- Table structure for table `basic`
--

CREATE TABLE `basic` (
  `id` int(11) NOT NULL,
  `compName` varchar(50) NOT NULL,
  `compDescription` longtext NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone1` varchar(25) NOT NULL,
  `phone2` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `facebook` varchar(100) NOT NULL,
  `twitter` varchar(100) NOT NULL,
  `linkedin` varchar(100) NOT NULL,
  `updationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `basic`
--

INSERT INTO `basic` (`id`, `compName`, `compDescription`, `address`, `phone1`, `phone2`, `email`, `logo`, `currency`, `facebook`, `twitter`, `linkedin`, `updationDate`) VALUES
(1, 'BrandsCollection', '                                                                                                            Hello, Bangladesh...                                                                                                            ', '                                                                                                            10/A-3, Bardhan Bari, Ward#09, Darus Salam Thana, Mirpur-1, Dhaka-1216.                                                                            ', '01712-446623', '+88 01829-041699', 'info@brandscollection.com.bd', 'logo.png', 'Tk', 'facebook', 'twitter', 'linkedin', '2020-12-16 16:13:36');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `brandsName` varchar(255) NOT NULL,
  `brandsImage` varchar(255) NOT NULL,
  `postingDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `brandsName`, `brandsImage`, `postingDate`) VALUES
(1, 'Arong', 'arong.png', '2021-01-08 17:31:40'),
(2, 'Easy', 'easy.png', '2021-01-08 17:33:01'),
(3, 'Infinity', 'infinity.png', '2021-01-08 17:34:05'),
(4, 'Muslim Sweets', 'muslim.jpg', '2021-01-08 20:19:10'),
(5, 'Personal Products', 'honeytree.jpg', '2021-01-09 05:49:58'),
(6, 'Raymond', 'raymond.jpg', '2021-01-11 11:29:15'),
(7, '  Cats Eye', 'catseye.jpg', '2021-01-11 11:30:06'),
(8, ' Richman', 'richman.jpg', '2021-01-11 11:30:47'),
(9, 'Yellow', 'yellow.jpg', '2021-01-11 16:00:23'),
(10, 'Panjeree', 'panjeri.png', '2021-01-11 16:31:13'),
(11, 'à¦¦à¦¿ à¦°à§Ÿà§‡à¦² à¦¸à¦¾à§Ÿà§‡à¦¨à§à¦Ÿà¦¿à¦«à¦¿à¦• à¦ªà¦¾à¦¬à¦²à¦¿à¦•à§‡à¦¶à¦¨à§à¦¸', 'royal.jpg', '2021-01-12 16:27:49'),
(12, 'No brand', 'no-brand.jpg', '2021-04-01 04:56:47'),
(13, 'Dove', 'Dove-Logo.png', '2021-04-16 14:12:22');

-- --------------------------------------------------------

--
-- Table structure for table `cashoffpayment`
--

CREATE TABLE `cashoffpayment` (
  `id` int(11) NOT NULL,
  `cashoff` int(11) NOT NULL,
  `status` varchar(30) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `value` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cashoffpayment`
--

INSERT INTO `cashoffpayment` (`id`, `cashoff`, `status`, `creation_date`, `value`) VALUES
(1, 50, 'Active', '2021-01-21 01:59:49', 0.5);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `categoryName` varchar(255) DEFAULT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `catImage` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `categoryName`, `creationDate`, `catImage`) VALUES
(6, 'Fashion', '2017-02-20 19:18:52', 'fashion.jpg'),
(7, 'Cosmetics', '2020-12-24 19:21:35', 'cosmetics.jpg'),
(8, 'Mobile Phones', '2021-01-04 04:33:49', 'mobile.png'),
(9, 'Foods and Grocery ', '2021-01-04 05:28:30', 'grocery.jpg'),
(10, 'Education', '2021-01-11 11:33:14', 'education.jpg'),
(11, 'Medicine', '2021-01-11 11:34:51', 'medicine.jpg'),
(12, 'Bazar ', '2021-03-25 07:09:02', 'cat-3.jpg'),
(13, 'Offer', '2021-05-28 05:22:21', 'offer.png');

-- --------------------------------------------------------

--
-- Table structure for table `color`
--

CREATE TABLE `color` (
  `id` int(11) NOT NULL,
  `colorName` varchar(255) NOT NULL,
  `colorType` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `color`
--

INSERT INTO `color` (`id`, `colorName`, `colorType`) VALUES
(1, 'All Colors', 'All'),
(2, 'Blue', 'B'),
(3, 'Green', 'G'),
(4, 'Orange', 'O'),
(5, 'Yellow', 'Y'),
(6, 'Pink', 'P'),
(7, 'Purple', 'Pu'),
(8, 'Violet', 'V'),
(9, 'Turquoise', 'T'),
(10, 'Gold', 'Go'),
(11, 'Lime', 'L'),
(12, 'Aqua', 'A'),
(13, 'Navy', 'N'),
(14, 'Cobal', 'C'),
(15, 'Teal', 'Te'),
(16, 'Brown', 'B'),
(17, 'White', 'W'),
(18, 'Black', 'Bl'),
(19, 'Red', 'R');

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `id` int(11) NOT NULL,
  `curName` varchar(50) NOT NULL,
  `shortCurrency` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `curName`, `shortCurrency`) VALUES
(1, 'BDT', 'Tk'),
(2, 'Rupee', 'Rs');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `imagesName` varchar(255) NOT NULL,
  `images` varchar(255) NOT NULL,
  `buttonName` varchar(50) NOT NULL,
  `imageSelect` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `modal`
--

CREATE TABLE `modal` (
  `id` int(11) NOT NULL,
  `modalName` varchar(30) NOT NULL,
  `dataToggle` varchar(50) NOT NULL,
  `description` varchar(1024) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `icon` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `modal`
--

INSERT INTO `modal` (`id`, `modalName`, `dataToggle`, `description`, `creationDate`, `icon`) VALUES
(1, 'Seller Policy', 'sellPolicy', 'Hello', '2021-01-23 16:23:38', 'fa-file-text'),
(2, 'Return Policy', 'retPolicy', 'Hi', '2021-01-23 16:24:04', 'fa-mail-reply'),
(3, 'Support Policy', 'supPolicy', 'Bangladesh', '2021-01-23 16:24:16', 'fa-support'),
(4, 'My Profile', 'myProfile', 'Country', '2021-01-23 16:24:42', 'fa-dashboard');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `productId` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `orderDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `orderId` varchar(100) DEFAULT NULL,
  `orderStatus` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `userId`, `productId`, `quantity`, `orderDate`, `orderId`, `orderStatus`) VALUES
(147, 10, '28', 1, '2021-01-27 16:16:42', 'ORD8626', 'Print'),
(149, 10, '29', 1, '2021-01-27 16:22:39', 'ORD6337', 'N'),
(150, 10, '27', 1, '2021-01-27 17:14:51', 'ORD9806', 'Print'),
(151, 10, '36', 1, '2021-01-27 17:14:51', 'ORD9806', 'Print'),
(152, 10, '28', 1, '2021-01-28 17:05:14', 'ORD7899', 'N'),
(153, 10, '36', 1, '2021-01-28 17:05:54', 'ORD9316', 'N'),
(154, 10, '37', 1, '2021-01-28 19:49:09', 'ORD549', 'N'),
(155, 10, '27', 1, '2021-01-31 03:05:13', 'ORD4714', 'Completed'),
(156, 10, '29', 1, '2021-02-02 06:54:16', 'ORD889', 'N'),
(157, 10, '29', 1, '2021-02-04 05:52:51', 'ORD4398', 'N'),
(158, 14, '29', 1, '2021-02-12 10:17:36', 'ORD8019', 'On The Way'),
(159, 14, '31', 1, '2021-02-12 10:17:36', 'ORD8019', 'On The Way'),
(160, 14, '32', 1, '2021-02-12 10:33:01', 'ORD4649', 'Completed'),
(161, 14, '34', 1, '2021-02-12 10:34:26', 'ORD7208', 'Completed'),
(162, 14, '42', 1, '2021-02-12 10:34:26', 'ORD7208', 'Completed'),
(163, 14, '28', 1, '2021-02-12 10:36:59', 'ORD4064', 'Delivered Process'),
(164, 14, '35', 1, '2021-02-12 10:36:59', 'ORD4064', 'Delivered Process'),
(165, 14, '40', 1, '2021-02-12 10:36:59', 'ORD4064', 'Delivered Process'),
(166, 10, '27', 1, '2021-02-13 16:23:03', 'ORD6656 ', 'Delivered Process'),
(167, 10, '30', 1, '2021-02-13 16:23:03', 'ORD6656', 'Delivered Process'),
(168, 10, '31', 2, '2021-02-13 16:23:03', 'ORD6656', 'Delivered Process'),
(169, 10, '39', 1, '2021-02-13 16:23:03', 'ORD6656', 'Delivered Process'),
(170, 10, '40', 2, '2021-02-13 16:23:03', 'ORD6656', 'Delivered Process'),
(171, 14, '29', 1, '2021-02-17 16:34:21', 'ORD7497', 'Completed'),
(172, 14, '33', 5, '2021-02-17 16:34:21', 'ORD7497', 'Completed'),
(173, 14, '35', 1, '2021-02-17 16:34:21', 'ORD7497', 'Completed'),
(174, 21, '27', 3, '2021-02-19 10:03:38', 'ORD9574', 'Completed'),
(175, 21, '28', 1, '2021-02-19 10:03:38', 'ORD9574', 'Completed'),
(176, 21, '40', 1, '2021-02-19 10:03:38', 'ORD9574', 'Completed'),
(177, 22, '28', 1, '2021-02-19 10:12:54', 'ORD1418', 'Print'),
(178, 22, '34', 1, '2021-02-19 10:12:54', 'ORD1418', 'Print'),
(179, 22, '36', 4, '2021-02-19 10:12:54', 'ORD1418', 'Print'),
(180, 22, '40', 1, '2021-02-19 10:12:54', 'ORD1418', 'Print'),
(181, 1, '36', 1, '2021-02-19 10:15:25', 'ORD9818', 'N'),
(182, 1, '28', 1, '2021-02-19 10:18:57', 'ORD1290', 'N'),
(183, 23, '29', 1, '2021-02-19 11:15:28', 'ORD6402', 'Completed'),
(184, 1, '30', 1, '2021-02-19 11:22:51', 'ORD4589', 'N'),
(185, 1, '27', 1, '2021-02-19 16:52:50', 'ORD4660', 'N'),
(186, 1, '36', 3, '2021-02-19 16:52:50', 'ORD4660', 'N'),
(187, 1, '40', 4, '2021-02-19 16:52:50', 'ORD4660', 'N'),
(188, 1, '28', 1, '2021-02-19 17:14:11', 'ORD9988', 'N'),
(189, 1, '29', 1, '2021-02-19 17:14:11', 'ORD9988', 'N'),
(190, 1, '37', 1, '2021-02-19 17:14:11', 'ORD9988', 'N'),
(191, 23, '29', 1, '2021-02-19 18:41:24', 'ORD4345', 'Completed'),
(192, 1, '43', 1, '2021-02-20 11:47:53', 'ORD1010', 'N'),
(193, 24, '40', 1, '2021-02-21 06:14:52', 'ORD8766', 'Completed'),
(194, 24, '44', 2, '2021-02-21 06:14:52', 'ORD8766', 'Completed'),
(195, 23, '32', 1, '2021-02-21 06:27:32', 'ORD7620', 'Delivered Process'),
(196, 23, '43', 1, '2021-02-21 06:27:32', 'ORD7620', 'Delivered Process'),
(197, 23, '30', 1, '2021-02-21 06:27:55', 'ORD784', 'Completed'),
(198, 1, '27', 1, '2021-02-21 09:27:41', 'ORD3420', 'N'),
(199, 10, '27', 2, '2021-02-21 09:39:13', 'ORD1231', 'Completed'),
(200, 10, '28', 2, '2021-02-21 09:39:13', 'ORD1231', 'Completed'),
(201, 23, '31', 1, '2021-02-22 17:10:22', 'ORD1898', 'Completed'),
(202, 23, '39', 1, '2021-02-22 17:10:22', 'ORD1898', 'Completed'),
(203, 10, '40', 3, '2021-02-23 14:09:27', 'ORD2180', 'N'),
(204, 10, '27', 1, '2021-02-23 14:37:55', 'ORD6891', 'Completed'),
(205, 10, '30', 1, '2021-02-23 14:37:55', 'ORD6891', 'Completed'),
(206, 23, '49', 1, '2021-02-28 16:17:18', 'ORD4711', 'Delivered Process'),
(207, 23, '27', 1, '2021-03-02 17:00:52', 'ORD7050', 'Delivered Process'),
(208, 23, '40', 2, '2021-03-02 17:00:52', 'ORD7050', 'Delivered Process'),
(209, 23, '27', 1, '2021-03-08 07:26:09', 'ORD4272', 'N'),
(210, 23, '28', 1, '2021-03-08 07:26:09', 'ORD4272', 'N'),
(211, 23, '30', 2, '2021-03-08 07:26:09', 'ORD4272', 'N'),
(212, 23, '27', 3, '2021-03-09 01:26:10', 'ORD2153', 'Delivered Process'),
(213, 23, '40', 5, '2021-03-09 01:26:10', 'ORD2153', 'Delivered Process'),
(214, 23, '27', 1, '2021-03-14 15:42:39', 'ORD5349', 'In Process'),
(215, 23, '55', 1, '2021-03-14 15:42:39', 'ORD5349', 'In Process'),
(216, 23, '36', 2, '2021-03-15 16:05:29', 'ORD3147', 'Completed'),
(217, 23, '55', 1, '2021-03-15 16:05:29', 'ORD3147', 'Completed'),
(218, 23, '30', 1, '2021-03-18 16:04:14', 'ORD7738', 'Completed'),
(219, 23, '40', 1, '2021-03-18 16:04:14', 'ORD7738', 'Completed'),
(220, 23, '55', 3, '2021-03-18 16:04:14', 'ORD7738', 'Completed'),
(221, 23, '61', 1, '2021-04-01 04:52:38', 'ORD5799', 'In Process'),
(222, 23, '64', 1, '2021-04-01 04:52:38', 'ORD5799', 'In Process'),
(223, 26, '58', 2, '2021-04-04 05:02:19', 'ORD2624', 'N'),
(224, 26, '77', 1, '2021-04-04 05:02:19', 'ORD2624', 'N'),
(225, 23, '61', 1, '2021-04-09 03:59:46', 'ORD9803', 'In Process'),
(226, 23, '62', 1, '2021-04-09 03:59:46', 'ORD9803', 'In Process'),
(227, 23, '116', 1, '2021-04-09 03:59:46', 'ORD9803', 'In Process'),
(228, 23, '83', 1, '2021-04-15 04:36:54', 'ORD1388', 'N'),
(229, 23, '61', 1, '2021-04-15 04:38:10', 'ORD9457', 'N'),
(230, 23, '55', 1, '2021-04-15 04:41:49', 'ORD8549', 'In Process'),
(231, 23, '84', 1, '2021-04-15 04:41:49', 'ORD8549', 'In Process'),
(232, 23, '56', 1, '2021-04-16 10:23:39', 'ORD1319', 'In Process'),
(233, 23, '69', 1, '2021-04-16 10:23:39', 'ORD1319', 'In Process'),
(234, 4, '32', 2, '2021-04-18 03:29:36', 'ORD9974', 'N'),
(235, 23, '89', 1, '2021-04-23 13:40:17', 'ORD8378', 'N'),
(236, 23, '69', 1, '2021-05-22 12:04:14', 'ORD5880', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `ordertrackhistory`
--

CREATE TABLE `ordertrackhistory` (
  `id` int(11) NOT NULL,
  `orderId` varchar(100) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `remark` mediumtext DEFAULT NULL,
  `postingDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ordertrackhistory`
--

INSERT INTO `ordertrackhistory` (`id`, `orderId`, `status`, `remark`, `postingDate`) VALUES
(29, 'ORD8626', 'in Process', 'hi', '2021-01-27 16:30:42'),
(30, 'ORD8626', 'Delivered', 'Deliver within 24 hours.', '2021-01-27 17:07:00'),
(31, 'ORD9806', 'in Process', 'In Process', '2021-01-27 17:20:44'),
(32, 'ORD9806', 'Delivered', 'Delivered within 24 hours.', '2021-01-27 17:21:37'),
(33, 'ORD8626', 'Completed', 'Complete for Voucher', '2021-01-28 17:10:56'),
(34, 'ORD8626', 'Print', 'Product Delivered Within 24 Hours.', '2021-01-28 19:18:43'),
(35, 'ORD9806', 'Completed', 'hi', '2021-01-28 19:22:19'),
(36, 'ORD4714', 'In Process', 'hi', '2021-01-31 03:06:03'),
(37, 'ORD9806', 'Print', 'Product Delivered Within 24 Hours.', '2021-01-31 03:08:22'),
(38, 'ORD8019', 'On The Way', 'j', '2021-02-12 10:27:56'),
(39, 'ORD4649', 'In Process', 'kj', '2021-02-12 10:35:07'),
(40, 'ORD7208', 'Completed', 'j', '2021-02-12 10:35:23'),
(41, 'ORD4064', 'In Process', 'jghg', '2021-02-12 10:37:27'),
(42, 'ORD4064', 'Delivered Process', 'jhjj', '2021-02-12 10:38:24'),
(43, 'ORD4714', 'Completed', 'hlo', '2021-02-12 16:53:58'),
(44, 'ORD4714', 'Print', 'Product Delivered Within 24 Hours.', '2021-02-13 14:37:40'),
(45, 'ORD6656', 'In Process', 'hi', '2021-02-13 17:41:48'),
(46, 'ORD6656', 'Delivered Process', 'Hello', '2021-02-13 18:05:00'),
(47, 'ORD4714', 'Completed', 'hlo', '2021-02-17 16:30:38'),
(48, 'ORD7497', 'In Process', '10', '2021-02-17 16:36:13'),
(49, 'ORD7497', 'Completed', 'gh', '2021-02-17 16:38:48'),
(50, 'ORD4649', 'Completed', 'j', '2021-02-19 09:05:05'),
(51, 'ORD9574', 'Completed', '1', '2021-02-19 10:04:47'),
(52, 'ORD1418', 'Completed', 'jewel', '2021-02-19 10:13:53'),
(53, 'ORD1418', 'In Process', 'bnjm', '2021-02-19 10:14:59'),
(54, 'ORD1418', 'Completed', 'hgj', '2021-02-19 10:16:08'),
(55, 'ORD6402', 'In Process', 'ghf', '2021-02-19 11:16:18'),
(56, 'ORD6402', 'Delivered Process', 'rt', '2021-02-19 11:17:13'),
(57, 'ORD6402', 'Completed', 'dg', '2021-02-19 11:17:44'),
(58, 'ORD4345', 'In Process', 'fg', '2021-02-19 18:41:47'),
(59, 'ORD4345', 'Completed', 'à¦†à¦¸à¦¦', '2021-02-20 11:48:34'),
(60, 'ORD8766', 'Completed', 'f', '2021-02-21 06:17:50'),
(61, 'ORD7620', 'Delivered Process', 'fg', '2021-02-21 06:29:33'),
(62, 'ORD784', 'Completed', 'vcb', '2021-02-21 06:30:23'),
(63, 'ORD1231', 'In Process', 'hi', '2021-02-21 09:40:43'),
(64, 'ORD1898', 'In Process', 'g', '2021-02-22 17:10:53'),
(65, 'ORD6891', 'In Process', 'hello', '2021-02-23 14:47:26'),
(66, 'ORD1231', 'Completed', 'f', '2021-02-28 16:08:22'),
(67, 'ORD4711', 'Delivered Process', 'hfdgh', '2021-02-28 16:18:47'),
(68, 'ORD7050', 'Delivered Process', 'hgj', '2021-03-02 17:02:01'),
(69, 'ORD2153', 'In Process', 'dfg', '2021-03-09 01:28:11'),
(70, 'ORD2153', 'Delivered Process', 'let me know all', '2021-03-09 01:31:14'),
(71, 'ORD5349', 'In Process', 'for any requirment plz call', '2021-03-14 15:43:53'),
(72, 'ORD3147', 'Completed', 'ok', '2021-03-15 16:27:42'),
(73, 'ORD1898', 'Completed', 'ok', '2021-03-15 16:46:22'),
(74, 'ORD6891', 'Completed', 'k', '2021-03-15 16:46:47'),
(75, 'ORD7738', 'In Process', '5654', '2021-03-18 16:07:30'),
(76, 'ORD7738', 'Completed', '2545', '2021-03-18 16:08:23'),
(77, 'ORD5799', 'In Process', 'v', '2021-04-01 04:52:59'),
(78, 'ORD9803', 'In Process', 'x', '2021-04-09 04:00:12'),
(79, 'ORD8549', 'In Process', 'sdfg', '2021-04-15 04:44:22'),
(80, 'ORD1319', 'In Process', '12:30 del', '2021-04-16 10:24:33'),
(81, 'ORD1418', 'Print', 'Product Delivered Within 24 Hours.', '2021-04-18 05:43:21');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `orderId` varchar(255) DEFAULT NULL,
  `paymentMethod` varchar(5) DEFAULT NULL,
  `userId` int(20) DEFAULT NULL,
  `payAmount` int(100) DEFAULT NULL,
  `dueAmount` int(100) DEFAULT NULL,
  `fullAmount` int(100) DEFAULT NULL,
  `creation_date` datetime DEFAULT current_timestamp(),
  `delCharge` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `orderId`, `paymentMethod`, `userId`, `payAmount`, `dueAmount`, `fullAmount`, `creation_date`, `delCharge`) VALUES
(47, 'ORD8626', 'COD', 10, 0, 81000, 81000, '2021-01-27 22:16:42', NULL),
(48, 'ORD6337', 'CBM', 10, 4500, 85500, 90000, '2021-01-27 22:22:39', NULL),
(49, 'ORD9806', 'CBM', 10, 2250, 430, 2680, '2021-01-27 23:14:51', NULL),
(50, 'ORD7899', 'COD', 10, 0, 81000, 81000, '2021-01-28 23:05:14', NULL),
(51, 'ORD9316', 'CBM', 10, 5788, -3538, 2250, '2021-01-28 23:05:54', NULL),
(52, 'ORD549', 'COD', 10, 0, 4, 4, '2021-01-29 01:49:09', NULL),
(53, 'ORD4714', 'COD', 10, 0, 430, 430, '2021-01-31 09:05:13', NULL),
(54, 'ORD6346', 'COD', 1, 0, 81733, 81733, '2021-02-02 11:33:12', NULL),
(55, 'ORD889', 'COD', 10, 0, 90000, 90000, '2021-02-02 12:54:16', NULL),
(56, 'ORD4398', 'COD', 10, 0, 90000, 90000, '2021-02-04 11:52:51', NULL),
(57, 'ORD8019', 'COD', 14, 0, 105215, 105215, '2021-02-12 16:17:36', NULL),
(58, 'ORD4649', 'COD', 14, 0, 215, 215, '2021-02-12 16:33:01', NULL),
(59, 'ORD7208', 'CBM', 14, 3380, 30273, 33653, '2021-02-12 16:34:26', NULL),
(60, 'ORD4064', 'COD', 14, 0, 97450, 97450, '2021-02-12 16:36:59', NULL),
(61, 'ORD6656', 'COD', 10, 0, 48453, 48453, '2021-02-13 22:23:03', NULL),
(62, 'ORD7497', 'COD', 14, 0, 106500, 106500, '2021-02-17 22:34:21', NULL),
(63, 'ORD9574', 'COD', 21, 0, 81730, 81730, '2021-02-19 16:03:38', NULL),
(64, 'ORD1418', 'COD', 22, 0, 116870, 116870, '2021-02-19 16:12:54', NULL),
(65, 'ORD9818', 'COD', 1, 0, 2250, 2250, '2021-02-19 16:15:25', NULL),
(66, 'ORD1290', 'COD', 1, 0, 81000, 81000, '2021-02-19 16:18:57', NULL),
(67, 'ORD6402', 'COD', 23, 0, 90000, 90000, '2021-02-19 17:15:28', NULL),
(68, 'ORD4589', 'COD', 1, 0, 16660, 16660, '2021-02-19 17:22:51', NULL),
(69, 'ORD4660', 'COD', 1, 0, 2980, 2980, '2021-02-19 22:52:50', NULL),
(70, 'ORD9988', 'COD', 1, 0, 171004, 171004, '2021-02-19 23:14:11', NULL),
(71, 'ORD4345', 'COD', 23, 0, 90000, 90000, '2021-02-20 00:41:24', NULL),
(72, 'ORD1010', 'COD', 1, 0, 1150, 1150, '2021-02-20 17:47:53', NULL),
(73, 'ORD8766', 'COD', 24, 0, 650, 650, '2021-02-21 12:14:52', NULL),
(74, 'ORD7620', 'COD', 23, 0, 1365, 1365, '2021-02-21 12:27:32', NULL),
(75, 'ORD784', 'CBM', 23, 5000, 11660, 16660, '2021-02-21 12:27:55', NULL),
(76, 'ORD3420', 'COD', 1, 0, 430, 430, '2021-02-21 15:27:41', NULL),
(77, 'ORD1231', 'COD', 10, 0, 162855, 162855, '2021-02-21 15:39:13', NULL),
(78, 'ORD1898', 'COD', 23, 0, 15548, 15548, '2021-02-22 23:10:22', NULL),
(79, 'ORD2180', 'COD', 1, 0, 900, 900, '2021-02-23 20:09:27', NULL),
(80, 'ORD6891', 'COD', 10, 0, 17090, 17090, '2021-02-23 20:37:55', NULL),
(81, 'ORD4711', 'COD', 23, 0, 325, 325, '2021-02-28 22:17:19', NULL),
(82, 'ORD7050', 'COD', 23, 0, 730, 730, '2021-03-02 23:00:52', NULL),
(83, 'ORD4272', 'COD', 23, 0, 114750, 114750, '2021-03-08 13:26:09', NULL),
(84, 'ORD2153', 'COD', 23, 0, 2780, 2780, '2021-03-09 07:26:10', NULL),
(85, 'ORD5349', 'COD', 23, 0, 720, 720, '2021-03-14 21:42:39', NULL),
(86, 'ORD3147', 'COD', 23, 0, 2540, 2540, '2021-03-15 22:05:29', NULL),
(87, 'ORD7738', 'COD', 23, 0, 17250, 17250, '2021-03-18 22:04:14', NULL),
(88, 'ORD5799', 'COD', 23, 0, 80, 80, '2021-04-01 10:52:38', NULL),
(89, 'ORD2624', 'COD', 26, 0, 150, 150, '2021-04-04 11:02:19', NULL),
(90, 'ORD9803', 'COD', 23, 0, 290, 290, '2021-04-09 09:59:46', NULL),
(91, 'ORD1388', 'CBM', 23, 9360, -9080, 280, '2021-04-15 10:36:54', NULL),
(92, 'ORD9457', 'CBM', 23, 9360, -9320, 40, '2021-04-15 10:38:10', NULL),
(93, 'ORD8549', 'CBM', 23, 2500, -1930, 570, '2021-04-15 10:41:49', NULL),
(94, 'ORD1319', 'COD', 23, 0, 340, 340, '2021-04-16 16:23:39', NULL),
(95, 'ORD9974', 'COD', 4, 0, 300, 300, '2021-04-18 09:29:36', NULL),
(96, 'ORD8378', 'COD', 23, 0, 395, 395, '2021-04-23 19:40:17', NULL),
(97, 'ORD5880', 'COD', 23, 0, 20, 20, '2021-05-22 18:04:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `productreviews`
--

CREATE TABLE `productreviews` (
  `id` int(11) NOT NULL,
  `productId` int(11) DEFAULT NULL,
  `quality` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `summary` varchar(255) DEFAULT NULL,
  `review` longtext DEFAULT NULL,
  `reviewDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `productreviews`
--

INSERT INTO `productreviews` (`id`, `productId`, `quality`, `price`, `value`, `name`, `summary`, `review`, `reviewDate`) VALUES
(5, 27, 1, 2, 4, 'saifur', 'hello', 'hi', '2021-01-18 17:16:57'),
(6, 27, 1, 2, 4, 'saifur', 'hello', 'hi', '2021-01-18 17:20:13'),
(7, 27, 1, 2, 4, 'saifur', 'hello', 'hi', '2021-01-18 17:20:58'),
(8, 27, 1, 2, 4, 'saifur', 'hello', 'hi', '2021-01-18 17:22:04'),
(9, 27, 1, 2, 4, 'saifur', 'hello', 'hi', '2021-01-18 17:22:52'),
(10, 27, 1, 2, 4, 'saifur', 'hello', 'hi', '2021-01-18 17:23:34'),
(11, 27, 1, 2, 4, 'saifur', 'hello', 'hi', '2021-01-18 17:25:14'),
(12, 27, 1, 2, 4, 'saifur', 'hello', 'hi', '2021-01-18 17:38:03'),
(13, 27, 1, 2, 4, 'saifur', 'hello', 'hi', '2021-01-18 17:40:55'),
(14, 27, 1, 2, 4, 'saifur', 'hello', 'hi', '2021-01-18 17:43:59'),
(15, 27, 1, 2, 4, 'saifur', 'hello', 'hi', '2021-01-18 17:44:32'),
(16, 33, 1, 2, 3, 'Mosharof', 'hello', 'hi', '2021-01-19 06:22:02');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `subCategory` int(11) DEFAULT NULL,
  `productName` varchar(255) DEFAULT NULL,
  `productCompany` varchar(255) DEFAULT NULL,
  `productPrice` int(11) DEFAULT NULL,
  `productPriceBeforeDiscount` int(11) DEFAULT NULL,
  `productDescription` longtext DEFAULT NULL,
  `productImage1` varchar(255) DEFAULT NULL,
  `productImage2` varchar(255) DEFAULT NULL,
  `productImage3` varchar(255) DEFAULT NULL,
  `shippingCharge` int(11) DEFAULT NULL,
  `productAvailability` varchar(255) DEFAULT NULL,
  `postingDate` timestamp NULL DEFAULT current_timestamp(),
  `updationDate` varchar(255) DEFAULT NULL,
  `size` varchar(10) NOT NULL,
  `color` varchar(10) NOT NULL,
  `price_off_percent` int(11) NOT NULL,
  `cashback` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category`, `subCategory`, `productName`, `productCompany`, `productPrice`, `productPriceBeforeDiscount`, `productDescription`, `productImage1`, `productImage2`, `productImage3`, `shippingCharge`, `productAvailability`, `postingDate`, `updationDate`, `size`, `color`, `price_off_percent`, `cashback`) VALUES
(27, 6, 13, 'Long Dress', '2', 425, 500, '                                    Hello                                    ', '1.jpg', 'aamb-coporation.png', 'bank_asia_logo.jpg', 5, 'In Stock', '2020-12-17 17:44:18', NULL, 'A', 'All', 15, 75),
(28, 8, 14, 'Sony Experia 1', '2', 81000, 89999, 'Brand new from our showroom with all papers', 'Sony-89999-Xperia-1.jpg', 'Sony-89999-Xperia-1.jpg', 'Sony-89999-Xperia-1.jpg', 0, 'In Stock', '2021-01-04 04:52:53', NULL, 'A', 'P', 10, 9000),
(29, 8, 14, 'Sony Experia 1 2020', '2', 90000, 90000, '&nbsp;new year collection                                    ', 'sony-xperia-x-mobile-phone-price-speci.jpg', 'sony-xperia-x-mobile-phone-price-speci.jpg', 'sony-xperia-x-mobile-phone-price-speci.jpg', 0, 'In Stock', '2021-01-04 05:08:13', NULL, 'A', 'W', 0, 0),
(30, 8, 15, 'Samsung A20', '2', 16660, 17000, '                                    New year                                    ', 'Samsung-16999-Galaxy-A20e.jpg', 'Samsung-16999-Galaxy-A20e.jpg', 'Samsung-16999-Galaxy-A20e.jpg', 0, 'In Stock', '2021-01-04 05:13:17', NULL, 'A', 'Bl', 2, 340),
(31, 8, 15, 'Samsung J7', '2', 15215, 17900, '                                    &nbsp;advanced security                                                                        ', 'Samsung-Galaxy-J7.jpg', 'Samsung-Galaxy-J7.jpg', '', 0, 'In Stock', '2021-01-04 05:14:57', NULL, 'A', 'Bl', 15, 2685),
(32, 9, 18, 'Apple', '2', 150, 150, '&nbsp;Fresh                                    ', 'mqdefault.jpg', 'mqdefault.jpg', 'mqdefault.jpg', 65, 'In Stock', '2021-01-04 05:33:17', NULL, 'M', 'G', 0, 0),
(33, 9, 18, 'Dragon', '2', 300, 270, '                                    &nbsp;Imported                                                                        ', 'dragon_fruit_3.jpg', 'download (2).jpg', 'dragon_fruit_3.jpg', 50, 'In Stock', '2021-01-04 05:34:58', NULL, 'M', 'R', 10, 30),
(34, 8, 15, 'Samsung Galaxy M51 ', '2', 33320, 34000, '<span style=\"color: rgb(44, 47, 52); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Oxygen, Oxygen-Sans, Ubuntu, Cantarell, &quot;Helvetica Neue&quot;, &quot;Open Sans&quot;, Arial, sans-serif; font-size: 15px;\">&nbsp; 6.7 inches Full HD+ Super AMOLED screen. The back camera is of quad<span style=\"background-color: rgb(0, 255, 0);\"> 64+12+5+5</span> with PDAF, ultrawide, depth sensor, dedicated macro camera, LED flash etc. and Ultra HD video recording. The front camera is of <span style=\"background-color: rgb(0, 153, 204);\">32 MP</span>. Galaxy M51&nbsp;comes with<span style=\"background-color: rgb(0, 204, 255);\"> 7000 </span>mAh massive battery with<span style=\"background-color: rgb(0, 204, 153);\"> 25W fast charging.</span> It has<span style=\"background-color: rgb(0, 255, 0);\"> 8 GB RAM</span>, up to 2.2 GHz octa-core CPU and Adreno 618 GPU. It is powered by Qualcomm Snapdragon 730G (8 nm) chipset. The device comes with <span style=\"background-color: rgb(255, 153, 102);\">128 GB</span> internal storage and dedicated MicroSD slot. There is a side-mounted fingerprint sensor in this phone</span>                                    ', 'samsung-galaxy-m51.jpg', 'samsung-galaxy-m51.jpg', 'samsung-galaxy-m51.jpg', 0, 'In Stock', '2021-01-05 18:00:38', NULL, 'A', 'All', 2, 680),
(35, 8, 15, 'Samsung Galaxy A21s', '2', 16150, 16999, '<span style=\"font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Oxygen, Oxygen-Sans, Ubuntu, Cantarell, &quot;Helvetica Neue&quot;, &quot;Open Sans&quot;, Arial, sans-serif; font-size: 15px;\"><b><font color=\"#990000\">&nbsp; 6.5</font></b></span><span style=\"font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Oxygen, Oxygen-Sans, Ubuntu, Cantarell, &quot;Helvetica Neue&quot;, &quot;Open Sans&quot;, Arial, sans-serif; font-size: 15px;\"><font color=\"#2c2f34\"> inches HD+ PLS TFT screen. It has a left punch-hole front camera design. The back camera is of quad </font><b style=\"\"><font color=\"#990000\">48+8+2+2 MP</font></b><font color=\"#2c2f34\"> with PDAF, LED flash, ultrawide lens, depth sensor, dedicated macro camera etc. and Full HD video recording. The front camera is of </font><font color=\"#990000\"><b>13 MP</b></font><font color=\"#2c2f34\">. Samsung Galaxy A21s comes with</font><font color=\"#990000\"> 5000 mAh</font><font color=\"#2c2f34\"> battery and 15W fast charging. It has </font><b style=\"\"><font color=\"#990000\">3, 4 or 6 GB RAM</font></b><font color=\"#2c2f34\">, up to 2.2 GHz octa-core CPU and Mali G52 GPU. It is powered by a Exynos 850 (8 nm) chipset. The device comes with</font><font color=\"#990000\"> 32 or 64 GB</font><font color=\"#2c2f34\"> internal storage&nbsp;</font></span>', 'Galaxy-A21s.jpg', 'Galaxya21s.jpg', 'samsung_galaxy_a21.jpg', 0, 'In Stock', '2021-01-05 18:09:36', NULL, 'A', 'All', 5, 850),
(36, 6, 13, 'Three Peace', '3', 2250, 2500, '                                    collection 2021                                    ', 'W-6-1.jpg', 'W-6-1.jpg', 'W-6-1.jpg', 0, 'In Stock', '2021-01-09 06:00:03', NULL, 'A', 'All', 10, 250),
(37, 11, 22, 'Napa', '12', 4, 4, '&nbsp;prescription first                                    ', '66-85.jpg', '66-85.jpg', '66-85.jpg', 0, 'In Stock', '2021-01-11 16:02:33', NULL, 'A', 'All', 0, 0),
(38, 11, 23, 'SENORA  (BELT SYSTEM)', '12', 144, 160, '&nbsp;date: 2021                                    ', 'senora-regular-flow-belt-system-600x600.jpg', 'senora-regular-flow-belt-system-600x600.jpg', 'senora-regular-flow-belt-system-600x600.jpg', 0, 'In Stock', '2021-01-11 16:11:24', NULL, 'A', 'All', 10, 16),
(39, 10, 24, 'à¦®à¦¾à¦§à§à¦¯à¦®à¦¿à¦• à¦°à¦¸à¦¾à§Ÿà¦¨', '12', 333, 350, '2021', 'cemestry.jpg', 'cemestry.jpg', 'cemestry.jpg', 0, 'In Stock', '2021-01-11 16:32:19', NULL, 'A', 'All', 5, 18),
(40, 10, 25, 'à¦¸à¦¾à¦§à¦¾à¦°à¦£ à¦¬à¦¿à¦œà§à¦žà¦¾à¦¨ (à§¯à¦®-à§§à§¦à¦® à¦¶à§à¦°à§‡à¦£à¦¿)', '12', 300, 300, '&nbsp;Special cashback for registered members.                                    ', '4c19413bf_196167.jpg', 'logo.png', '4c19413bf_196167.jpg', 0, 'In Stock', '2021-01-12 16:33:16', NULL, 'A', 'All', 0, 0),
(41, 10, 25, 'à¦ªà¦¦à¦¾à¦°à§à¦¥à¦¬à¦¿à¦œà§à¦žà¦¾à¦¨ (à§¯à¦®-à§§à§¦à¦® à¦¶à§à¦°à§‡à¦£à¦¿)', '12', 400, 400, 'tk 50 cash back', '4e3a90e43_183799.jpg', 'logo.png', '4e3a90e43_183799.jpg', 0, 'In Stock', '2021-01-12 16:36:05', NULL, 'A', 'All', 0, 0),
(42, 10, 25, 'à¦œà§€à¦¬à¦¬à¦¿à¦œà§à¦žà¦¾à¦¨ (à§¯à¦®-à§§à§¦à¦® à¦¶à§à¦°à§‡à¦£à¦¿)', '12', 333, 370, '                                                                        2021                                                                        ', 'biology.png', 'biology.png', 'biology.png', 0, 'In Stock', '2021-01-14 16:36:37', NULL, 'A', 'All', 10, 37),
(43, 10, 26, 'Casio Scientific Calculator (fx-100MS)', '9', 1150, 1150, '                                                                        100% Guaranty&nbsp;                                                                        ', 'casio-fx-100ms3.jpg', 'casio-fx-100ms3.jpg', 'casio-fx-100ms3.jpg', 0, 'In Stock', '2021-02-20 11:23:32', NULL, 'A', 'Bl', 0, 0),
(44, 10, 26, 'Casio Scientific Calculator (fx-100MS)', '9', 350, 350, '                                                                        Copy&nbsp;                                                                        ', 'casio-fx-100ms3.jpg', 'casio-fx-100ms3.jpg', 'casio-fx-100ms3.jpg', 0, 'In Stock', '2021-02-20 11:26:48', NULL, 'A', 'Bl', 0, 0),
(45, 10, 26, 'Casio Scientific Calculator (fx-570MS)', '9', 1150, 1150, '                                                                        &nbsp; Actual&nbsp;                                                                        ', '5703.jpg', '5702.jpg', 'casio-scientific-calculator-fx-570ms 1.jpg', 0, 'In Stock', '2021-02-20 11:40:08', NULL, 'A', 'Bl', 0, 0),
(46, 10, 26, 'Casio Scientific Calculator (fx-570MS)', '9', 250, 250, '                                                                        &nbsp;Copy                                                                                                            ', '5703.jpg', '5702.jpg', 'casio-scientific-calculator-fx-570ms 1.jpg', 0, 'In Stock', '2021-02-20 11:41:48', NULL, 'A', 'Bl', 0, 0),
(47, 10, 27, 'à¦®à¦¾à¦§à§à¦¯à¦®à¦¿à¦• à¦—à¦£à¦¿à¦¤ à¦ªà¦¾à¦žà§à¦œà§‡à¦°à§€', '10', 395, 395, '                                                                        à¦®à¦¾à¦§à§à¦¯à¦®à¦¿à¦• à¦—à¦£à¦¿à¦¤ à¦ªà¦¾à¦žà§à¦œà§‡à¦°à§€ ssc 2023                                                                        ', 'punjeree-math-12.jpeg', 'punjeree-math-1.png', 'punjeree-math-12.jpeg', 0, 'In Stock', '2021-02-24 08:43:57', NULL, 'A', 'All', 0, 0),
(48, 10, 27, 'à¦®à¦¾à¦§à§à¦¯à¦®à¦¿à¦• à¦°à¦¸à¦¾à§Ÿà¦¨', '10', 390, 390, '                                                                        ssc 2023                                                                        ', '179eec066_195214.jpg', 'BA30012115-chemistry-2021.jpeg', '179eec066_195214.jpg', 0, 'In Stock', '2021-02-24 08:59:58', NULL, 'A', 'All', 0, 0),
(49, 10, 27, 'à¦®à¦¾à¦§à§à¦¯à¦®à¦¿à¦• à¦œà§€à¦¬à¦¬à¦¿à¦œà§à¦žà¦¾à¦¨', '10', 325, 325, '                                    <span style=\"color: rgb(84, 102, 113); font-family: SolaimanLipi; font-size: 14.6667px; background-color: rgb(250, 250, 250);\">à¦¶à§à¦°à§‡à¦£à¦¿: à¦¨à¦¬à¦®</span><br style=\"color: rgb(84, 102, 113); font-family: SolaimanLipi; font-size: 14.6667px; background-color: rgb(250, 250, 250);\"><span style=\"color: rgb(84, 102, 113); font-family: SolaimanLipi; font-size: 14.6667px; background-color: rgb(250, 250, 250);\">à¦¬à¦¿à¦­à¦¾à¦—: à¦¬à¦¿à¦œà§à¦žà¦¾à¦¨ à¦¬à¦¿à¦­à¦¾à¦—</span><br style=\"color: rgb(84, 102, 113); font-family: SolaimanLipi; font-size: 14.6667px; background-color: rgb(250, 250, 250);\"><span style=\"color: rgb(84, 102, 113); font-family: SolaimanLipi; font-size: 14.6667px; background-color: rgb(250, 250, 250);\">à¦¸à¦‚à¦¸à§à¦•à¦°à¦£: à§¨à§¦à§¨à§§</span><br style=\"color: rgb(84, 102, 113); font-family: SolaimanLipi; font-size: 14.6667px; background-color: rgb(250, 250, 250);\"><span style=\"color: rgb(84, 102, 113); font-family: SolaimanLipi; font-size: 14.6667px; background-color: rgb(250, 250, 250);\">à¦ªà§ƒà¦·à§à¦ à¦¾: à§®à§§à§¬</span>                                                                        ', 'biology.png', 'biology.png', 'biology.png', 0, 'In Stock', '2021-02-24 17:18:16', NULL, 'A', 'All', 0, 0),
(50, 10, 27, 'à¦®à¦¾à¦§à§à¦¯à¦®à¦¿à¦• à¦‰à¦šà§à¦šà¦¤à¦° à¦—à¦£à¦¿à¦¤', '10', 345, 345, '                                    ssc 2023                                    ', 'hm21.png', 'hm1.png', 'hm1.png', 0, 'In Stock', '2021-02-24 17:45:34', NULL, 'A', 'All', 0, 0),
(52, 10, 26, 'Original Casio Scientific Calculator (FX-991ES PLUS)', '9', 1500, 1500, '                                    <h2 style=\"box-sizing: border-box; font-family: Roboto, sans-serif; font-weight: 300; line-height: 30px; color: rgb(68, 69, 70); margin-bottom: 0px; font-size: 25px;\"><i>3 Years Warranty&nbsp;</i></h2>                                                                        ', 'original1.jpg', 'cc2c6ccee3619b79d277f32cf0f1cbdd.jpg', 'cc2c6ccee3619b79d277f32cf0f1cbdd.jpg', 0, 'In Stock', '2021-03-02 17:44:53', NULL, 'A', 'All', 0, 0),
(53, 10, 26, '  Casio Scientific Calculator (FX-991Ex)', '9', 1600, 1600, '                                    <h2 style=\"box-sizing: border-box; font-family: Roboto, sans-serif; font-weight: 300; line-height: 30px; color: rgb(68, 69, 70); margin-bottom: 0px; font-size: 25px;\">3 Years&nbsp; Warranty</h2>                                                                        ', 'Original.jpg', 'Original.jpg', 'Original3.jpg', 0, 'In Stock', '2021-03-02 17:54:02', NULL, 'A', 'All', 0, 0),
(54, 9, 21, 'Honey / à¦®à¦§à§', '9', 1000, 1000, '&nbsp;Personal collection from trusted persons', 'honey-Pure.jpg', 'honey-Pure.jpg', 'honey-Pure.jpg', 0, 'In Stock', '2021-03-03 04:28:32', NULL, 'A', 'All', 0, 0),
(55, 7, 20, 'Wild Stone', '9', 290, 290, '                                    2021                                    ', '71PJl888+SL._SL1100_.jpg', '71PJl888+SL._SL1100_.jpg', '71PJl888+SL._SL1100_.jpg', 0, 'In Stock', '2021-03-09 01:39:10', NULL, 'A', 'All', 0, 0),
(56, 7, 29, 'Black Shine Shampoo 375ml', '9', 320, 320, '                                    100% trusted.                                    ', 'sunsilk-shampoo-stunning-black-shine-375-ml.jpg', '0086024_sunsilk-shampoo-stunning-black-shine-375ml_550.jpeg', '0086024_sunsilk-shampoo-stunning-black-shine-375ml_550.jpeg', 0, 'In Stock', '2021-03-25 07:08:08', NULL, 'A', 'Bl', 0, 0),
(57, 7, 29, 'Sunsilk Shampoo Hair Fall Solution 180ml', '9', 184, 184, '                                    <div style=\"text-align: center;\">100% trusted</div>                                    ', '0002672_sunsilk-shampoo-hair-fall-solution-180-ml_510.png', '266835_7-sunsilk-hair-fall-solution-shampoo.jpg', '0316761_sunsilk-shampoo-hair-fall-solution-180ml.jpeg', 0, 'In Stock', '2021-03-25 07:19:23', NULL, 'A', 'All', 0, 0),
(58, 7, 29, 'Sunsilk  Conditionar 80ml', '9', 65, 65, '                                    100% trusted                                    ', '8901030610882.png', '0114329_sunsilk-conditioner-perfect-straight-80ml_550.jpeg', '0114329_sunsilk-conditioner-perfect-straight-80ml_550.jpeg', 0, 'In Stock', '2021-03-25 07:39:11', NULL, 'A', 'All', 0, 0),
(60, 12, 30, 'à¦²à¦¾à¦‰', '12', 50, 50, '                                    100% quality guaranty                                    ', 'lau1.jpg', 'lau3.jpg', 'lau.jpg', 0, 'In Stock', '2021-03-30 06:50:31', NULL, 'A', 'All', 0, 0),
(61, 12, 30, 'à¦šà¦¾à¦²-à¦•à§à¦®à§œà¦¾', '12', 40, 40, '                                                                        100% quality guaranty                                                                                                            ', 'chalkumra1.jpg', 'chalkumra3.jpg', 'chalkumra.jpg', 0, 'In Stock', '2021-03-30 06:58:45', NULL, 'A', 'All', 0, 0),
(62, 12, 30, 'à¦¬à§‡à¦—à§à¦¨ à¦—à§‹à¦²', '12', 40, 40, '                                                                        100% quality guaranty                                                                                                            ', 'roundbegun1.jpg', 'roundbegun2.jpg', 'roundbegun3.jpg', 0, 'In Stock', '2021-03-30 07:05:04', NULL, 'A', 'All', 0, 0),
(64, 12, 30, 'à¦¬à§‡à¦—à§à¦¨ à¦²à¦®à§à¦¬à¦¾', '12', 40, 40, '                                    100% quality guaranty                                                                        ', 'longbegun.jpg', 'longbegun.jpg', 'longbegun.jpg', 0, 'In Stock', '2021-03-30 07:09:39', NULL, 'A', 'Bl', 0, 0),
(65, 12, 30, 'à¦¶à¦¸à¦¾', '12', 50, 50, '                                    100% quality guaranty                                                                        ', 'shosha.jpg', 'shosha.jpg', 'shosha3.jpg', 0, 'In Stock', '2021-03-30 07:36:17', NULL, 'A', 'G', 0, 0),
(66, 12, 30, 'à¦–à¦¿à¦°à¦¾', '12', 30, 30, '                                    100% quality guaranty                                                                        ', 'khira.jpg', 'khira2.jpg', 'khira3.jpg', 0, 'In Stock', '2021-03-30 07:41:39', NULL, 'A', 'G', 0, 0),
(67, 12, 30, 'à¦†à¦²à§', '12', 30, 30, '                                                                        100% quality guaranty                                                                                                            ', 'alu2.jpg', 'alu1.jpg', 'potato.jpg', 0, 'In Stock', '2021-03-30 07:51:43', NULL, 'A', 'All', 0, 0),
(68, 12, 30, 'à¦²à¦¾à¦² à¦†à¦²à§', '12', 27, 30, '                                                                        100% quality guaranty                                                                                                            ', 'potoato.round.jpg', 'potoato.round.jpg', 'red-potato.jpg', 0, 'In Stock', '2021-03-30 07:56:57', NULL, 'A', 'All', 10, 3),
(69, 12, 30, 'à¦ªà§‡à¦ªà§‡', '12', 20, 20, '                                    100% quality guaranty                                                                        ', 'pepe.jpg', 'pepe.jpg', 'Papaya.jpg', 0, 'In Stock', '2021-03-30 08:23:33', NULL, 'A', 'G', 0, 0),
(70, 12, 30, 'à¦®à¦¿à¦·à§à¦Ÿà¦¿ à¦•à§à¦®à§œà¦¾', '12', 20, 20, '                                    &nbsp;100% quality guaranty                                                                        ', 'MISTI-KUMRA.jpg', 'MISTI-KUMRA.jpg', 'kumra.jpg', 0, 'In Stock', '2021-03-30 08:41:14', NULL, 'A', 'O', 0, 0),
(71, 12, 30, 'à¦²à¦¾à¦² à¦¶à¦¾à¦•', '12', 15, 15, '                                    &nbsp;100% quality guaranty                                                                        ', 'lalshak.png', 'lalshak.png', 'lalshak.jpg', 0, 'In Stock', '2021-03-30 09:51:53', NULL, 'A', 'R', 0, 0),
(72, 12, 30, 'à¦ªà¦¾à¦Ÿ à¦¶à¦¾à¦•', '12', 10, 10, '                                    &nbsp;100% quality guaranty                                                                        ', 'patshak.jpg', 'patshak.jpg', 'patshakk.jpg', 0, 'In Stock', '2021-03-30 09:56:50', NULL, 'A', 'G', 0, 0),
(73, 12, 30, 'à¦ªà§ à¦¶à¦¾à¦•', '12', 20, 20, '                                    &nbsp;100% quality guaranty                                                                        ', 'pui.jpg', 'pui2.jpg', 'pui-shak1.jpg', 0, 'In Stock', '2021-03-30 09:59:50', NULL, 'A', 'G', 0, 0),
(74, 12, 30, 'à¦•à¦²à¦®à¦¿ à¦¶à¦¾à¦•', '12', 10, 10, '                                    &nbsp;100% quality guaranty                                                                        ', 'kolmi.jpg', 'kolmi2.webp', 'kshak.jpg', 0, 'In Stock', '2021-03-30 10:02:57', NULL, 'A', 'G', 0, 0),
(75, 12, 30, 'à¦²à¦¤à¦¿', '12', 60, 60, '                                                    100% quality guaranty                                                         ', 'loti.jpg', 'loti.jpg', 'lottir.png', 0, 'In Stock', '2021-04-02 15:32:48', NULL, 'A', 'G', 0, 0),
(76, 12, 30, 'à¦²à§‡à¦¬à§', '12', 40, 40, '                                                                     100% quality guaranty                                        ', 'lebu.jpg', 'lebu.jpg', 'lemon.jpg', 0, 'In Stock', '2021-04-02 15:50:49', NULL, 'A', 'G', 0, 0),
(77, 12, 30, 'à¦à¦²à§‹à¦¬à§‡à¦°à¦¾', '12', 20, 20, '                                                                  100% quality guaranty                                           ', '1733idea99aloe-vera.png', '1733idea99aloe-vera.png', 'alovera.jpg', 0, 'In Stock', '2021-04-02 16:27:18', NULL, 'A', 'G', 0, 0),
(78, 7, 29, 'Closeup Toothpaste Freshness Cool Mint', '12', 120, 120, '                                               MRP                                                             ', 'close.webp', 'close.webp', 'close.webp', 0, 'In Stock', '2021-04-02 16:58:23', NULL, 'A', 'All', 0, 0),
(81, 12, 30, 'à¦°à§‹à¦œà¦¾à¦° à¦–à¦¾à¦¬à¦¾à¦°', '12', 100, 80, '                                                                                            collected                                                                                        ', 'piyaju.jpeg', 'piyaju.jpeg', 'ifter.jpg', 0, 'In Stock', '2021-04-03 18:01:20', NULL, 'A', 'All', 20, 20),
(82, 7, 20, 'Nivea Fresh Natural Roll On 50ml', '12', 199, 199, '                                              MRP                                                              ', 'nevima.roll50.jpg', 'nevia.roll.50.jpg', 'nevima.roll50.jpg', 0, 'In Stock', '2021-04-05 06:24:38', NULL, 'A', 'All', 0, 0),
(83, 7, 20, 'Nivea Pearl & Beauty Body Spray 150ml', '12', 280, 280, '                                                mrp                                                            ', 'nivea-pearl-beauty.jpg', 'nivea-pearl-beauty.jpg', 'nivea-pearl-beauty.jpg', 0, 'In Stock', '2021-04-05 06:47:31', NULL, 'A', 'All', 0, 0),
(84, 7, 20, 'Nivea Men Cool Kick Body Spray 150ml', '12', 280, 280, '                                               mrp                                                             ', 'neviamen.jpg', 'neviamen.jpg', 'neviamen.jpg', 0, 'In Stock', '2021-04-05 06:50:54', NULL, 'A', 'All', 0, 0),
(85, 7, 20, 'Layer Shot Deep Desire Body Spray 135ml', '12', 365, 365, '                                                     mrp                                                       ', 'layershot.jpg', 'layershot.jpg', 'layershot.jpg', 0, 'In Stock', '2021-04-05 06:55:47', NULL, 'A', 'All', 0, 0),
(86, 7, 20, 'Layer Shot Craze Body Spray 135ml', '12', 395, 395, '                                                       mrp                                                     ', 'layercraze.jpeg', 'layercraze.jpeg', 'layercraze.jpeg', 0, 'In Stock', '2021-04-05 06:58:53', NULL, 'A', 'All', 0, 0),
(87, 7, 20, 'Layer Shot Dynamic Body Spray 135ml', '12', 370, 370, '                                                 mrp                                                           ', 'shotgolddynamic.jpg', 'shotgolddynamic.jpg', 'shotgolddynamic.jpg', 0, 'In Stock', '2021-04-05 07:03:59', NULL, 'A', 'All', 0, 0),
(88, 7, 20, 'ARMAF Body Spray Club De Nuit 200ml (Women)', '12', 380, 400, '                                                            mrp                                                ', 'armaf.jpg', 'armaf.jpg', 'armaf.jpg', 0, 'In Stock', '2021-04-05 07:07:30', NULL, 'A', 'All', 5, 20),
(89, 7, 20, 'ARMAF High Street Body Spray 200ml', '12', 395, 395, '                                                mrp                                                            ', 'armaf-High-Street-W-200ml.jpg', 'armaf-High-Street-W-200ml.jpg', 'armaf-High-Street-W-200ml.jpg', 0, 'In Stock', '2021-04-05 07:11:07', NULL, 'A', 'All', 0, 0),
(90, 7, 20, 'ARMAF Tag-Him Body Spray 200ml', '12', 395, 395, '                                          mrp                                                                  ', 'TAG-HIM-1.jpg', 'TAG-HIM-1.jpg', 'TAG-HIM-1.jpg', 0, 'In Stock', '2021-04-05 07:17:21', NULL, 'A', 'All', 0, 0),
(91, 12, 31, 'à¦¬à§à¦°à§Ÿà¦²à¦¾à¦° à¦šà¦¾à¦®à§œà¦¾à¦›à¦¾à§œà¦¾ (à¦ªà§à¦°à¦¤à¦¿ à¦•à§‡à¦œà¦¿)', '12', 245, 245, '                                                 fresh                                                           ', 'broiler.jpg', 'broiler.jpg', 'BWTS.jpg', 0, 'In Stock', '2021-04-07 04:39:46', NULL, 'A', 'All', 0, 0),
(92, 12, 31, 'à¦¬à§à¦°à§Ÿà¦²à¦¾à¦° à¦šà¦¾à¦®à§œà¦¾à¦¸à¦¹ (à¦ªà§à¦°à¦¤à¦¿ à¦•à§‡à¦œà¦¿)', '12', 235, 235, '                                                   fresh                                                         ', 'BROILER-WITH-SKIN.jpg', 'BROILER-WITH-SKIN.jpg', 'bws.jpg', 0, 'In Stock', '2021-04-07 04:43:01', NULL, 'A', 'All', 0, 0),
(93, 12, 31, 'à¦²à§‡à§Ÿà¦¾à¦° à¦®à§à¦°à¦—à§€ à¦šà¦¾à¦®à§œà¦¾à¦¸à¦¹ (à¦ªà§à¦°à¦¤à¦¿ à¦•à§‡à¦œà¦¿)', '12', 290, 290, '                                                           fresh                                                 ', '54951_1.jpg', 'BROILER-WITH-SKIN.jpg', 'lear.jpg', 0, 'In Stock', '2021-04-07 04:48:14', NULL, 'A', 'All', 0, 0),
(94, 12, 31, 'à¦—à¦°à§à¦° à¦®à¦¾à¦‚à¦¸ à¦¹à¦¾à§œà¦¸à¦¹ (à¦ªà§à¦°à¦¤à¦¿ à¦•à§‡à¦œà¦¿)', '12', 560, 560, '                                            fresh                                                                ', 'beaf1.jpg', 'beaf-steaks-6228215.jpg', 'beaf.jpg', 0, 'In Stock', '2021-04-07 04:53:29', NULL, 'A', 'R', 0, 0),
(95, 12, 31, 'à¦–à¦¾à¦¸à¦¿à¦° à¦®à¦¾à¦‚à¦¸ (à¦ªà§à¦°à¦¤à¦¿ à¦•à§‡à¦œà¦¿)', '12', 920, 920, '                                             halal                                                               ', 'goat.jpg', 'mutton-bone-in.jpg', 'goat1.png', 0, 'In Stock', '2021-04-07 05:02:42', NULL, 'A', 'R', 0, 0),
(96, 12, 31, 'à¦—à¦°à§à¦° à¦•à¦²à¦¿à¦œà¦¾ (à¦ªà§à¦°à¦¤à¦¿ à¦•à§‡à¦œà¦¿)', '12', 600, 600, '                                                halal                                                            ', 'liver1.jpg', 'liver1.jpg', 'liver.jpg', 0, 'In Stock', '2021-04-07 05:05:15', NULL, 'A', 'R', 0, 0),
(98, 12, 32, 'à¦•à¦¾à¦šà¦•à¦¿ à¦®à¦¾à¦› (à¦ªà§à¦°à¦¤à¦¿ à¦•à§‡à¦œà¦¿)', '12', 450, 450, '                                                                                   fresh                                                                                                 ', 'kachki.png', 'Kachkig.jpg', 'kachki1.png', 0, 'In Stock', '2021-04-07 10:47:35', NULL, 'A', 'All', 0, 0),
(99, 12, 32, 'à¦ªà¦¾à¦¬à¦¦à¦¾ à¦®à¦¾à¦› (à¦›à§‹à¦Ÿ- à¦ªà§à¦°à¦¤à¦¿ à¦•à§‡à¦œà¦¿)', '12', 400, 400, '                                                  fresh                                                          ', 'pabda-fish-500-gm.png', 'pabda-fish-500-gm.png', 'pabda.jpg', 0, 'In Stock', '2021-04-07 10:53:34', NULL, 'A', 'W', 0, 0),
(100, 12, 32, 'à¦ªà¦¾à¦¬à¦¦à¦¾ à¦®à¦¾à¦› (à¦¬à§œ- à¦ªà§à¦°à¦¤à¦¿ à¦•à§‡à¦œà¦¿)', '12', 500, 500, '                                              fresh                                                              ', 'pabdabig.jpg', 'Pabda-01.jpg', 'pabdabig1.png', 0, 'In Stock', '2021-04-07 10:55:53', NULL, 'XXL', 'W', 0, 0),
(101, 12, 32, 'à¦•à§ˆ à¦®à¦¾à¦›', '12', 220, 220, '                                             fresh                                                               ', 'koi.png', 'koi.png', 'koi.jpg', 0, 'In Stock', '2021-04-07 10:59:34', NULL, 'L', 'All', 0, 0),
(102, 12, 32, 'à¦•à§ˆ à¦®à¦¾à¦› à¦ªà§à¦°à¦•à§à¦°à¦¿à§Ÿà¦¾à¦—à¦¤', '12', 300, 300, '                                                fresh                                                            ', 'koi-fish.png', 'koi.png', 'kkk.png', 0, 'In Stock', '2021-04-07 11:01:59', NULL, 'A', 'All', 0, 0),
(103, 12, 32, 'à¦®à¦²à¦¾ à¦®à¦¾à¦›', '12', 300, 300, '                                            fresh                                                                ', 'mola.jpg', 'mola-mas.jpg', 'mola1.png', 0, 'In Stock', '2021-04-07 11:04:31', NULL, 'A', 'All', 0, 0),
(104, 12, 32, 'à¦¸à§à¦¬à¦°-à¦ªà§à¦Ÿà¦¿ à¦®à¦¾à¦›', '12', 200, 200, '                                                fresh                                                            ', 'sor.jpg', 'maxresdefault.jpg', 'sor1.png', 0, 'In Stock', '2021-04-07 11:07:18', NULL, 'A', 'All', 0, 0),
(105, 12, 32, 'à¦¬à¦¾à¦¤à¦¾à¦¸à§€ à¦®à¦¾à¦›', '12', 540, 540, '                                                fresh                                                            ', 'Batashi.jpg', 'Batashi.jpg', 'batasi.jpg', 0, 'In Stock', '2021-04-07 11:37:44', NULL, 'A', 'All', 0, 0),
(106, 12, 32, 'à¦‡à¦²à¦¿à¦¶ à¦®à¦¾à¦› (à§­à§¦à§¦-à§®à§¦à§¦ à¦—à§à¦°à¦¾à¦®)', '12', 690, 690, '                                                                                          fresh                                                                                          ', 'Hilsha.jpg', '1 (1).JPG', 'Hilsha1.jpg', 0, 'In Stock', '2021-04-07 11:42:40', NULL, 'A', 'W', 0, 0),
(107, 12, 32, 'à¦‡à¦²à¦¿à¦¶ à¦®à¦¾à¦› (à§§.à§¨-à§§.à§« à¦•à§‡à¦œà¦¿)', '12', 1480, 1480, '                                                           fresh                                                 ', 'Hilsha.jpg', '1 (1).JPG', 'Hilsha1.png', 0, 'In Stock', '2021-04-07 11:53:48', NULL, 'A', 'All', 0, 0),
(108, 12, 32, 'à¦•à¦¾à¦¤à¦²à¦¾ à¦®à¦¾à¦› à§© à¦•à§‡à¦œà¦¿+', '12', 310, 310, '                                               FRESH                                                             ', 'katla.jpg', 'KATLA.jpg', 'k.jpg', 0, 'In Stock', '2021-04-07 12:20:09', NULL, 'A', 'All', 0, 0),
(109, 12, 32, 'à¦•à¦¾à¦¤à¦²à¦¾ à¦®à¦¾à¦› à§¨ à¦•à§‡à¦œà¦¿+', '12', 250, 250, '                                                             FRESH                                               ', 'katla.jpg', 'KATLA.jpg', 'k.jpg', 0, 'In Stock', '2021-04-07 12:21:54', NULL, 'A', 'All', 0, 0),
(110, 12, 32, 'à¦Ÿà¦¾à¦Ÿà¦•à¦¿à¦¨à¦¿ à¦®à¦¾à¦› à¦ªà§à¦°à¦¤à¦¿ à¦•à§‡à¦œà¦¿', '12', 240, 240, '                                              fresh                                                              ', 'Tatkini.png', 'tatkini.jpg', 'Tatkini1.jpg', 0, 'In Stock', '2021-04-08 09:14:52', NULL, 'A', 'All', 0, 0),
(111, 12, 32, 'à¦°à§à¦‡ à¦®à¦¾à¦› (à§§-à§¨ à¦•à§‡à¦œà¦¿)', '12', 230, 230, '                                                                             fresh                                                                                                       ', 'rui.png', 'roi.jpg', 'rui1.jpg', 0, 'In Stock', '2021-04-08 09:21:34', NULL, 'A', 'All', 0, 0),
(112, 12, 32, 'à¦°à§à¦‡ à¦®à¦¾à¦› (à§¨-à§© à¦•à§‡à¦œà¦¿)', '12', 270, 270, '                                                       fresh                                                     ', 'rui.png', 'roi.jpg', 'rui1.jpg', 0, 'In Stock', '2021-04-08 09:25:32', NULL, 'A', 'All', 0, 0),
(113, 12, 32, 'à¦—à¦²à¦¦à¦¾ à¦šà¦¿à¦‚à¦¡à¦¼à¦¿ à¦®à¦¾à¦› à¦ªà§à¦°à¦¤à¦¿ à¦•à§‡à¦œà¦¿', '12', 700, 700, '                                                   fresh                                                         ', '1591980400.jpg', 'golda.jpg', '15919804001.jpg', 0, 'In Stock', '2021-04-08 09:33:37', NULL, 'A', 'All', 0, 0),
(114, 12, 32, 'à¦¬à§‹à§Ÿà¦¾à¦² à¦®à¦¾à¦› (à§«à§¦à§¦-à§®à§¦à§¦ à¦—à§à¦°à¦¾à¦® )', '12', 420, 420, '                                               fresh                                                             ', 'à¦¨à¦ªà¦œ.jpeg', 'boal.jpg', 'à¦¨à¦ªà¦œ1.jpg', 0, 'In Stock', '2021-04-08 09:38:56', NULL, 'A', 'All', 0, 0),
(115, 12, 32, 'à¦¬à§‹à§Ÿà¦¾à¦² à¦®à¦¾à¦› (à§§-à§¨ à¦•à§‡à¦œà¦¿ )', '12', 600, 600, '                                                                                      fresh                                                                                              ', 'à¦¨à¦ªà¦œ.jpeg', 'boalf.jpg', 'à¦¨à¦ªà¦œ1.jpg', 0, 'In Stock', '2021-04-08 09:42:16', NULL, 'A', 'All', 0, 0),
(116, 7, 29, 'Dove Shampoo Nourishing Oil Care', '12', 210, 210, '                                                                               100% trusted                                                                                                     ', '0103629_dove-shampoo-intense-repair-170ml_550.jpeg', '0103629_dove-shampoo-intense-repair-170ml_550.jpeg', '0103629_dove-shampoo-intense-repair-170ml_550.jpeg', 0, 'In Stock', '2021-04-08 09:53:50', NULL, 'A', 'W', 0, 0),
(117, 7, 29, 'Dove Hair Fall Rescue Shampoo', '12', 370, 370, '                                                            100% trusted                                                ', '31.jpeg', 'dove-hair-fall-rescue-shampoo-350ml.jpg', '31.jpeg', 0, 'In Stock', '2021-04-08 10:01:02', NULL, 'A', 'All', 0, 0),
(118, 7, 29, 'Dove Beauty Cream Bar 100gm White', '12', 75, 75, '                                                                                                                                                                 100%                                                                                                                                                                   ', 'DOVE-BEAUTY-BAR-WHITE-100-GM.png', 'DOVE-BEAUTY-BAR-WHITE-100-GM.png', 'DOVE-BEAUTY-BAR-WHITE-100-GM.png', 0, 'In Stock', '2021-04-08 10:06:06', NULL, 'A', 'All', 0, 0),
(119, 7, 29, 'Dove Beauty Cream Bar 100gm Pink', '12', 75, 75, '                                                                                         100%                                                                                           ', '6281006481312-1618965-png.jpg', '6281006481312-1618965-png.jpg', '6281006481312-1618965-png.jpg', 0, 'In Stock', '2021-04-08 10:10:25', NULL, 'A', 'All', 0, 0),
(120, 7, 29, 'Dove Face Wash Beauty Moisture 50g', '12', 160, 160, '                                                                                          100%                                                                                          ', '0103135_dove-face-wash-beauty-moisture-50g_550.jpeg', '0103135_dove-face-wash-beauty-moisture-50g_550.jpeg', '0103135_dove-face-wash-beauty-moisture-50g_550.jpeg', 0, 'In Stock', '2021-04-08 10:14:47', NULL, 'A', 'W', 0, 0),
(121, 7, 29, 'Clear Men Cool Sport Menthol Anti Dandruff Shampoo', '12', 240, 240, '                                                       100%                                                     ', '2d83ae708757-265.jpg', '2d83ae708757-265.jpg', '2d83ae708757-265.jpg', 0, 'In Stock', '2021-04-08 10:26:06', NULL, 'A', 'All', 0, 0),
(122, 7, 29, 'Clear Anti Dandruff Complete Active Care Shampoo', '12', 200, 200, '                                                   100%                                                        ', '0090374_clear-shampoo-complete-active-care-anti-dandruff-180ml_550.jpeg', '0090374_clear-shampoo-complete-active-care-anti-dandruff-180ml_550.jpeg', '0090374_clear-shampoo-complete-active-care-anti-dandruff-180ml_550.jpeg', 0, 'In Stock', '2021-04-08 10:28:34', NULL, 'A', 'All', 0, 0),
(123, 7, 29, 'Tresemme Keratin Smooth Shampoo', '12', 240, 240, '                                                   100%                                                         ', 'Tresemme185-ml.jpg', 'Tresemme185-ml.jpg', 'Tresemme185-ml.jpg', 0, 'In Stock', '2021-04-08 10:33:42', NULL, 'A', 'All', 0, 0),
(124, 7, 29, 'Lux Soap Rose & Vitamin-E 100gm', '12', 38, 38, '                                                               100%                                             ', 'Lux.jpg', 'Lux.jpg', 'Lux.jpg', 0, 'In Stock', '2021-04-10 02:56:00', NULL, 'A', 'All', 0, 0),
(125, 7, 29, 'Lux Soap Bar Sensuous Sandal', '12', 50, 50, '                                                         100%                                                ', 'lux1.jpeg', 'lux1.jpeg', 'lux1.jpeg', 0, 'In Stock', '2021-04-10 02:59:52', NULL, 'A', 'All', 0, 0),
(126, 7, 29, 'Lux Botanicals Camellia & AloeVera Soap 100gm', '12', 40, 40, '                                                   100%                                                         ', 'lux3.jpg', 'lux3.jpg', 'lux3.jpg', 0, 'In Stock', '2021-04-10 03:02:20', NULL, 'A', 'All', 0, 0),
(127, 7, 29, 'Lux Jasmin & Vitamin-E Soap', '12', 55, 55, '                                                     100%                                                       ', 'Lux150.png', 'Lux150.png', 'Lux150.png', 0, 'In Stock', '2021-04-10 03:08:49', NULL, 'A', 'All', 0, 0),
(128, 7, 29, 'Lifebuoy Total Soap', '12', 46, 46, '                                                             100%                                               ', 'LIFEBUOY150.jpg', 'LIFEBUOY150.jpg', 'LIFEBUOY150.jpg', 0, 'In Stock', '2021-04-10 03:23:33', NULL, 'A', 'All', 0, 0),
(129, 7, 29, 'Lifebuoy Soap Bar Turmeric & Honey', '12', 35, 35, '                                              100%                                                              ', 'Lifebuoy75.png', 'Lifebuoy75.png', 'Lifebuoy75.png', 0, 'In Stock', '2021-04-10 03:28:33', NULL, 'A', 'All', 0, 0),
(130, 7, 29, 'Lifebuoy Soap Bar Neem And AloeVera', '12', 38, 38, '                                                 100%                                                           ', 'life.png', 'life.png', 'life.png', 0, 'In Stock', '2021-04-10 03:32:23', NULL, 'A', 'All', 0, 0),
(131, 7, 29, 'Lifebuoy Soap Lemon Fresh', '12', 48, 48, '                                                    100%                                                        ', 'Lifebuo150.jpg', 'Lifebuo150.jpg', 'Lifebuo150.jpg', 0, 'In Stock', '2021-04-10 03:35:43', NULL, 'A', 'All', 0, 0),
(132, 7, 29, 'Neem Original Olive & AloeVera Soap 75g', '12', 35, 35, '                                                                                                  Neem Original Olive & Aloe Vera Soap 75g (117)                                                                                  ', 'neemm.jpg', 'neemm.jpg', 'neemm.jpg', 0, 'In Stock', '2021-04-12 04:40:39', NULL, 'A', 'All', 0, 0),
(133, 7, 29, 'Imperial Leather Soap 200g', '12', 140, 140, '                                                            Imperial Leather Soap 200g                                                ', 'imperial.jpeg', 'imperial.jpeg', 'imperial.jpeg', 0, 'In Stock', '2021-04-12 04:50:28', NULL, 'A', 'All', 0, 0),
(134, 7, 29, 'Imperial Leather Soap 115g', '12', 115, 115, '                                                                      Imperial Leather Soap 115g (119)                                      ', 'imperia.jpg', 'imperia.jpg', 'imperia.jpg', 0, 'In Stock', '2021-04-12 04:53:45', NULL, 'A', 'All', 0, 0),
(135, 7, 29, 'Dettol  Cool Soap 125 gm (120)', '12', 62, 62, '          Dettol  Cool Soap 125 gm (120)                          ', 'detolcool.jpg', 'detolcool.jpg', 'detolcool.jpg', 0, 'In Stock', '2021-04-12 04:56:52', NULL, 'A', 'All', 0, 0),
(136, 7, 29, 'Dettol Soap 75 gm  (121)', '12', 42, 42, '               Dettol Soap 75 Gm Original                     ', 'dettol.jpeg', 'dettol.jpeg', 'dettol.jpeg', 0, 'In Stock', '2021-04-12 04:59:25', NULL, 'A', 'All', 0, 0),
(137, 7, 29, 'Savlon Fresh Antiseptic Soap 100 gm (122)', '12', 50, 50, '          Savlon Fresh Antiseptic Soap 100 Gm                          ', 'savlon.jpg', 'savlon.jpg', 'savlon.jpg', 0, 'In Stock', '2021-04-12 05:04:39', NULL, 'A', 'All', 0, 0),
(138, 7, 29, 'Savlon Antiseptic Soap Active 125g (123)', '12', 59, 59, '         Savlon Antiseptic Soap Active 125g                           ', 'sav.jpg', 'sav.jpg', 'sav.jpg', 0, 'In Stock', '2021-04-12 05:09:25', NULL, 'A', 'All', 0, 0),
(139, 7, 29, 'Wild Stone Ultra Sensual Soap 125 gm (124)', '12', 120, 120, '             Wild Stone Ultra Sensual Soap\r\n125 gm                       ', 'wildstone.jpg', 'wildstone.jpg', 'wildstone.jpg', 0, 'In Stock', '2021-04-12 05:44:13', NULL, 'A', 'All', 0, 0),
(140, 7, 29, 'Wild Stone Forest Spice Soap 125 gm (125)', '12', 120, 120, '                   Wild Stone Forest Spice Soap                 ', 'wild.jpg', 'wild.jpg', 'wild.jpg', 0, 'In Stock', '2021-04-12 05:49:03', NULL, 'A', 'All', 0, 0),
(141, 9, 19, 'Teer Soyabean Oil 2liters', '12', 276, 276, '                                                   Teer Soyabean Oil 2Ltr                                                          ', 'teer.jpg', 'teer.jpg', 'teer.jpg', 0, 'In Stock', '2021-04-15 06:10:52', NULL, 'A', 'All', 0, 0),
(142, 9, 19, 'Teer Soyabean Oil 5liters', '12', 660, 660, '                                                  Teer Soyabean Oil 5 Ltr                                                          ', 'teer5.jpg', 'teer5.jpg', 'teer5.jpg', 0, 'In Stock', '2021-04-15 06:15:13', NULL, 'A', 'All', 0, 0),
(143, 9, 19, 'Rupchanda Soyabean Oil 5liters', '12', 660, 660, '                                                      Rupchanda  Soyabean Oil                                                      ', 'rupchada5.jpg', 'rupchada5.jpg', 'rupchada5.jpg', 0, 'In Stock', '2021-04-15 06:18:50', NULL, 'A', 'All', 0, 0),
(144, 9, 19, 'Rupchanda Soyabean Oil 2liters', '12', 276, 276, '                                               Rupchanda Soyabean Oil 2 ltr                                                     ', 'rupchada2.jpg', 'rupchada2.jpg', 'rupchada2.jpg', 0, 'In Stock', '2021-04-15 06:21:20', NULL, 'A', 'All', 0, 0),
(145, 9, 19, 'Fresh Soyabean Oil 5liters', '12', 660, 660, '                                                 Fresh Soyabean Oil                                                           ', 'fresh5.jpg', 'fresh5.jpg', 'fresh5.jpg', 0, 'In Stock', '2021-04-15 06:24:27', NULL, 'A', 'All', 0, 0),
(146, 9, 19, 'Fresh Soyabean Oil 2liters', '12', 274, 274, '                                            fresh  soyabean oil 2 ltr                                                                 ', 'fresh2.jpg', 'fresh2.jpg', 'fresh2.jpg', 0, 'In Stock', '2021-04-15 06:32:23', NULL, 'A', 'All', 0, 0),
(147, 9, 19, 'à¦¸à¦°à¦¿à¦·à¦¾ à¦¤à§‡à¦²  à¦ªà§à¦°à¦¤à¦¿ à¦²à¦¿à¦Ÿà¦¾à¦°', '12', 220, 220, '                                                   à¦¸à¦°à¦¿à¦·à¦¾ à¦¤à§‡à¦²                                                          ', 'sorishar1.jpg', 'sorishar1.jpg', 'sorishar1.jpg', 0, 'In Stock', '2021-04-15 06:39:51', NULL, 'A', 'All', 0, 0),
(148, 9, 19, 'à¦¸à¦°à¦¿à¦·à¦¾ à¦¤à§‡à¦² (à¦˜à¦¾à¦¨à§€)  à¦ªà§à¦°à¦¤à¦¿ à¦²à¦¿à¦Ÿà¦¾à¦°', '12', 350, 350, '                                                    à¦¸à¦°à¦¿à¦·à¦¾ à¦¤à§‡à¦²                                                         ', 'sorishar1.jpg', '0000.jpg', 'sorishar1.jpg', 0, 'In Stock', '2021-04-15 06:43:12', NULL, 'A', 'All', 0, 0),
(149, 9, 19, 'à¦˜à¦¿ à¦ªà§à¦°à¦¤à¦¿ à¦•à§‡à¦œà¦¿', '12', 1300, 1300, '                                          à¦˜à¦¿ à¦ªà§à¦°à¦¤à¦¿ à¦•à§‡à¦œà¦¿                                    ', 'ghi1.jpg', 'ghi1.jpg', 'ghi1.jpg', 0, 'In Stock', '2021-04-15 06:48:11', NULL, 'A', 'All', 0, 0),
(150, 9, 19, 'à¦˜à¦¿ à¦ªà§à¦°à¦¤à¦¿ à¦•à§‡à¦œà¦¿', '12', 800, 800, '                                               à¦˜à¦¿ à¦ªà§à¦°à¦¤à¦¿ à¦•à§‡à¦œà¦¿                                                             ', 'ghi1.jpg', 'ghi1.jpg', 'ghi1.jpg', 0, 'In Stock', '2021-04-15 06:49:06', NULL, 'A', 'All', 0, 0),
(151, 9, 19, 'ACI Salt 1Kg (136)', '12', 32, 32, '                     ACI Salt 1Kg               ', 'salt.jpg', 'salt.jpg', 'salt.jpg', 0, 'In Stock', '2021-04-15 10:09:41', NULL, 'A', 'All', 0, 0),
(152, 9, 19, 'ACI Salt 0.5 kg  ( 137 )', '12', 18, 18, '         ACI Salt 1Kg                           ', 'salt.5.jpeg', 'salt.5.jpeg', 'salt.5.jpeg', 0, 'In Stock', '2021-04-15 10:13:27', NULL, 'A', 'All', 0, 0),
(153, 9, 19, 'Fresh Refined Sugar 1 kg (138 )', '12', 78, 78, '              Fresh Refined Sugar                      ', 'freshsugar.jpeg', 'freshsugar.jpeg', 'freshsugar.jpeg', 0, 'In Stock', '2021-04-15 10:16:31', NULL, 'A', 'W', 0, 0),
(154, 9, 19, 'à¦¤à¦¾à¦² à¦®à¦¿à¦›à§œà¦¿ à¦ªà§à¦°à¦¤à¦¿ à¦•à§‡à¦œà¦¿ (à§§à§©à§¯)', '12', 200, 200, '                (Tal Misri)                    ', 'misri.jpg', 'misri.jpg', 'misri.jpg', 0, 'In Stock', '2021-04-15 10:20:08', NULL, 'A', 'W', 0, 0),
(155, 9, 33, 'à¦¹à¦²à§à¦¦à§‡à¦° à¦—à§à§œà¦¾ 200 gm (à§§à§ªà§¦)', '12', 95, 95, '                  Radhuni Turmeric Powder                   ', 'holjud.jpg', 'holjud.jpg', 'holjud.jpg', 0, 'In Stock', '2021-04-15 10:31:13', NULL, 'A', 'Y', 0, 0),
(156, 9, 33, 'à¦°à¦¾à¦§à§à¦¨à¦¿ à¦¹à¦²à§à¦¦ à¦—à§à§œ à§¨à§¦à§¦ à¦—à§à¦°à¦¾à¦® (à§§à§ªà§¦)', '12', 95, 95, '               Radhuni Turmeric Powder                      ', 'holjud.jpg', 'holjud.jpg', 'holjud.jpg', 0, 'In Stock', '2021-04-15 10:33:09', NULL, 'A', 'Y', 0, 0),
(157, 9, 33, 'à¦°à¦¾à¦§à§à¦¨à¦¿ à¦¹à¦²à§à¦¦ à¦—à§à§œ à§§à§¦à§¦ à¦—à§à¦°à¦¾à¦® (à§§à§ªà§§)', '12', 50, 50, '            à¦°à¦¾à¦§à§à¦¨à¦¿ à¦¹à¦²à§à¦¦ à¦—à§à§œ                    ', 'radhuni100g.png', 'radhuni100g.png', 'radhuni100g.png', 0, 'In Stock', '2021-04-15 10:36:13', NULL, 'A', 'Y', 0, 0),
(158, 9, 33, 'à¦¹à¦²à§à¦¦à§‡à¦° à¦—à§à§œà¦¾ à§§00 gm (à¦¸à¦‚à¦—à§ƒà¦¹à§€à¦¤) (à§§à§ª2)', '12', 42, 42, '                                                    à¦¸à¦‚à¦—à§ƒà¦¹à§€à¦¤                                                        ', 'à¦¸à¦‚à¦—à§ƒà¦¹à§€à¦¤.jpg', 'à¦¸à¦‚à¦—à§ƒà¦¹à§€à¦¤.jpg', 'à¦¸à¦‚à¦—à§ƒà¦¹à§€à¦¤.jpg', 0, 'In Stock', '2021-04-15 10:41:05', NULL, 'A', 'Y', 0, 0),
(159, 9, 33, 'à¦°à¦¾à¦§à§à¦¨à¦¿ à¦®à¦°à¦¿à¦š à¦—à§à§œ à§¨à§¦à§¦ à¦—à§à¦°à¦¾à¦® (à§§à§ªà§©)', '12', 100, 100, '                                                à¦°à¦¾à¦§à§à¦¨à¦¿ à¦®à¦°à¦¿à¦š à¦—à§à§œ à§¨à§¦à§¦ à¦—à§à¦°à¦¾à¦® (à§§à§ªà§©)                                                            ', 'chilli_2_radhunui.jpg', 'chilli_2_radhunui.jpg', 'chilli_2_radhunui.jpg', 0, 'In Stock', '2021-04-22 14:16:50', NULL, 'A', 'R', 0, 0),
(160, 9, 33, 'à¦°à¦¾à¦§à§à¦¨à¦¿ à¦®à¦°à¦¿à¦š à¦—à§à§œ à§«à§¦ à¦—à§à¦°à¦¾à¦® (144)', '12', 30, 30, '                     à¦°à¦¾à¦§à§à¦¨à¦¿ à¦®à¦°à¦¿à¦š à¦—à§à§œ à§«à§¦ à¦—à§à¦°à¦¾à¦® (144)               ', 'chilli_2_radhunui.jpg', 'chilli_2_radhunui.jpg', 'chilli_2_radhunui.jpg', 0, 'In Stock', '2021-04-22 14:21:33', NULL, 'A', 'R', 0, 0),
(161, 9, 33, 'à¦°à¦¾à¦§à§à¦¨à¦¿ à¦§à¦¨à¦¿à§Ÿà¦¾  à¦—à§à§œ à§¨à§¦à§¦ à¦—à§à¦°à¦¾à¦® (145)', '12', 65, 65, '                           à¦°à¦¾à¦§à§à¦¨à¦¿ à¦§à¦¨à¦¿à§Ÿà¦¾  à¦—à§à§œ à§¨à§¦à§¦ à¦—à§à¦°à¦¾à¦® (145)         ', 'dhonia.jpg', 'dhonia.jpg', 'dhonia.jpg', 0, 'In Stock', '2021-04-22 14:24:34', NULL, 'A', 'All', 0, 0),
(162, 9, 33, 'à¦°à¦¾à¦§à§à¦¨à¦¿ à¦§à¦¨à¦¿à§Ÿà¦¾  à¦—à§à§œ 50 à¦—à§à¦°à¦¾à¦® (146)', '12', 20, 20, 'à¦°à¦¾à¦§à§à¦¨à¦¿ à¦§à¦¨à¦¿à§Ÿà¦¾  à¦—à§à§œ 50 à¦—à§à¦°à¦¾à¦® (146)                  ', 'dhonia.jpg', 'dhonia.jpg', 'dhonia.jpg', 0, 'In Stock', '2021-04-22 14:31:13', NULL, 'A', 'R', 0, 0),
(163, 9, 33, 'à¦°à¦¾à¦§à§à¦¨à¦¿ à¦ªà¦¾à¦à¦š à¦«à§‹à§œà¦¨ 5à§¦ à¦—à§à¦°à¦¾à¦® (147)', '12', 22, 22, '                    à¦°à¦¾à¦§à§à¦¨à¦¿ à¦ªà¦¾à¦à¦š à¦«à§‹à§œà¦¨ 5à§¦ à¦—à§à¦°à¦¾à¦®                 ', 'pach.webp', 'pach.webp', 'pach.webp', 0, 'In Stock', '2021-04-22 14:44:48', NULL, 'A', 'R', 0, 0),
(164, 9, 33, 'à¦°à¦¾à¦§à§à¦¨à¦¿ à¦œà¦¿à¦°à¦¾ à¦—à§à§œà¦¾  à§§à§¦à§¦ à¦—à§à¦°à¦¾à¦® (148)', '12', 80, 80, 'à¦°à¦¾à¦§à§à¦¨à¦¿ à¦œà¦¿à¦°à¦¾ à¦—à§à§œà¦¾  à§§à§¦à§¦ à¦—à§à¦°à¦¾à¦® (148)                     ', 'jira.jpg', 'jira.jpg', 'jira.jpg', 0, 'In Stock', '2021-04-22 14:52:00', NULL, 'A', 'All', 0, 0),
(165, 9, 33, 'à¦°à¦¾à¦§à§à¦¨à¦¿ à¦œà¦¿à¦°à¦¾ à¦—à§à§œà¦¾ 50 à¦—à§à¦°à¦¾à¦® (149)', '12', 43, 43, '                  à¦°à¦¾à¦§à§à¦¨à¦¿ à¦œà¦¿à¦°à¦¾ à¦—à§à§œà¦¾ 50 à¦—à§à¦°à¦¾à¦® (149)                  ', 'jira.jpg', 'jira.jpg', 'jira.jpg', 0, 'In Stock', '2021-04-22 14:57:38', NULL, 'A', 'All', 0, 0),
(166, 9, 33, 'à¦°à¦¾à¦§à§à¦¨à¦¿ à¦—à¦°à§à¦° à¦®à¦¾à¦‚à¦¸ à¦®à¦¸à¦²à¦¾ à§§à§¦à§¦ à¦—à§à¦°à¦¾à¦® (à§§à§«à§¦)', '12', 65, 65, '                           à¦°à¦¾à¦§à§à¦¨à¦¿ à¦—à¦°à§à¦° à¦®à¦¾à¦‚à¦¸ à¦®à¦¸à¦²à¦¾ à§§à§¦à§¦ à¦—à§à¦°à¦¾à¦® (à§§à§«à§¦)         ', 'beef.png', 'beef.png', 'beef.png', 0, 'In Stock', '2021-04-22 15:05:26', NULL, 'A', 'All', 0, 0),
(167, 9, 33, 'à¦°à¦¾à¦§à§à¦¨à¦¿ à¦•à¦¾à¦¬à¦¾à¦¬ à¦®à¦¸à¦²à¦¾  à§«à§¦ à¦—à§à¦°à¦¾à¦® (à§§à§«à§§)', '12', 90, 90, '            à¦°à¦¾à¦§à§à¦¨à¦¿ à¦•à¦¾à¦¬à¦¾à¦¬ à¦®à¦¸à¦²à¦¾  à§«à§¦ à¦—à§à¦°à¦¾à¦® (à§§à§«à§§)                        ', 'kabab.png', 'kabab.png', 'kabab.png', 0, 'In Stock', '2021-04-22 15:11:12', NULL, 'A', 'All', 0, 0),
(168, 9, 33, ' à¦°à¦¾à¦§à§à¦¨à¦¿  à¦°à§‹à¦¸à§à¦Ÿ à¦®à¦¸à¦²à¦¾ à§©à§« à¦—à§à¦°à¦¾à¦®  (à§§à§«à§¨)', '12', 60, 60, '                     à¦°à¦¾à¦§à§à¦¨à¦¿  à¦°à§‹à¦¸à§à¦Ÿ à¦®à¦¸à¦²à¦¾ à§©à§« à¦—à§à¦°à¦¾à¦®  (à§§à§«à§¨)                ', 'radhuni35gm.jpg', 'radhuni35gm.jpg', 'radhuni35gm.jpg', 0, 'In Stock', '2021-04-22 15:19:19', NULL, 'A', 'All', 0, 0),
(169, 9, 33, 'à¦°à¦¾à¦§à§à¦¨à¦¿ à¦®à§à¦°à¦—à¦¿  à¦®à¦¾à¦‚à¦¸ à¦®à¦¸à¦²à¦¾ 2à§¦ à¦—à§à¦°à¦¾à¦® (à§§à§«2)', '12', 15, 15, '                                    à¦°à¦¾à¦§à§à¦¨à¦¿ à¦®à§à¦°à¦—à¦¿  à¦®à¦¾à¦‚à¦¸ à¦®à¦¸à¦²à¦¾ 2à§¦ à¦—à§à¦°à¦¾à¦® (à§§à§«2)', 'radhunichickenmasala20.jpg', 'radhunichickenmasala20.jpg', 'radhunichickenmasala20.jpg', 0, 'In Stock', '2021-04-23 16:00:41', NULL, 'A', 'R', 0, 0),
(170, 9, 33, 'à¦°à¦¾à¦§à§à¦¨à¦¿  à¦¬à§‹à¦°à¦¹à¦¾à¦¨à¦¿ à¦®à¦¸à¦²à¦¾ 5à§¦ à¦—à§à¦°à¦¾à¦® (à§§à§«3)', '12', 35, 35, '                     à¦°à¦¾à¦§à§à¦¨à¦¿  à¦¬à§‹à¦°à¦¹à¦¾à¦¨à¦¿ à¦®à¦¸à¦²à¦¾ 5à§¦ à¦—à§à¦°à¦¾à¦® (à§§à§«3)              ', 'borhani.jpg', 'borhani.jpg', 'borhani.jpg', 0, 'In Stock', '2021-04-23 16:05:30', NULL, 'A', 'All', 0, 0),
(171, 9, 33, 'à¦°à¦¾à¦§à§à¦¨à¦¿  à¦—à¦°à¦® à¦®à¦¸à¦²à¦¾ 4à§¦ à¦—à§à¦°à¦¾à¦® (à§§à§«4)', '12', 60, 60, '                                à¦°à¦¾à¦§à§à¦¨à¦¿  à¦—à¦°à¦® à¦®à¦¸à¦²à¦¾ 4à§¦ à¦—à§à¦°à¦¾à¦® (à§§à§«4)    ', 'radhuni-garam-masala-40-gm.jpg', 'radhuni-garam-masala-40-gm.jpg', 'radhuni-garam-masala-40-gm.jpg', 0, 'In Stock', '2021-04-23 16:08:43', NULL, 'A', 'All', 0, 0),
(172, 9, 33, 'à¦°à¦¾à¦§à§à¦¨à¦¿  à¦®à¦¾à¦›à§‡à¦°  à¦®à¦¸à¦²à¦¾ à§§à§¦à§¦ à¦—à§à¦°à¦¾à¦® (à§§à§«à§«)', '12', 55, 55, '                à¦°à¦¾à¦§à§à¦¨à¦¿  à¦®à¦¾à¦›à§‡à¦°  à¦®à¦¸à¦²à¦¾ à§§à§¦à§¦ à¦—à§à¦°à¦¾à¦® (à§§à§«à§«)                    ', 'mach.jpg', 'mach.jpg', 'mach.jpg', 0, 'In Stock', '2021-04-23 16:11:30', NULL, 'A', 'All', 0, 0),
(173, 9, 33, 'à¦°à¦¾à¦§à§à¦¨à¦¿  à¦¬à¦¿à¦°à¦¿à§Ÿà¦¾à¦¨à¦¿ à¦®à¦¸à¦²à¦¾ à§ªà§¦à§¦ à¦—à§à¦°à¦¾à¦® (à§§à§«à§¬)', '12', 55, 55, '                                    à¦°à¦¾à¦§à§à¦¨à¦¿  à¦¬à¦¿à¦°à¦¿à§Ÿà¦¾à¦¨à¦¿ à¦®à¦¸à¦²à¦¾ à§ªà§¦à§¦ à¦—à§à¦°à¦¾à¦® (à§§à§«à§¬)', 'biriani.jpg', 'biriani.jpg', 'biriani.jpg', 0, 'In Stock', '2021-04-23 16:16:08', NULL, 'A', 'All', 0, 0),
(174, 9, 34, 'Ispahani Mirzapore Best Leaf Tea 400 gm( 157)', '12', 190, 190, '                              400 gm      ', 'TEA.png', 'TEA.png', 'TEA.png', 0, 'In Stock', '2021-04-24 05:05:18', NULL, 'A', 'All', 0, 0),
(175, 9, 34, 'Ispahani Mirzapore Tea Bag 50 pcs ( 158 )', '12', 90, 90, '               Ispahani Mirzapore Tea Bag\r\n50 pcs                     ', 'TEA BAG.jpg', 'TEA BAG.jpg', 'TEA BAG.jpg', 0, 'In Stock', '2021-04-24 05:09:03', NULL, 'A', 'All', 0, 0),
(176, 9, 34, 'Ispahani Mirzapore Best Leaf Tea 200 gm( 158)', '12', 110, 110, '                          Ispahani Mirzapore Best Leaf Tea 200 gm( 158)          ', 'ispahani200.jpg', 'ispahani200.jpg', 'ispahani200.jpg', 0, 'In Stock', '2021-04-24 14:44:33', NULL, 'A', 'All', 0, 0),
(177, 9, 34, 'Brooke Bond Taaza Tea Bag 50 pcs ( 159 )', '12', 85, 85, '                                Brooke Bond Taaza Tea Bag 50 pcs\r\n100 gm    ', 'taaza.jpg', 'taaza.jpg', 'taaza.jpg', 0, 'In Stock', '2021-04-24 14:47:49', NULL, 'A', 'All', 0, 0),
(178, 9, 34, 'Seylon Gold Tea 500 gm ( 160 )', '12', 210, 210, '                Seylon Gold Tea\r\n500 gm                    ', 'seylon.jpg', 'seylon.jpg', 'seylon.jpg', 0, 'In Stock', '2021-04-24 14:50:32', NULL, 'A', 'All', 0, 0),
(179, 9, 34, 'NestlÃ© Nescafe 3 in 1 Coffee Mix ( 161 )', '12', 30, 30, '                        NestlÃ© Nescafe 3 in 1 Coffee Mix            ', 'Coffee-1.jpeg', 'Coffee-1.jpeg', 'Coffee-1.jpeg', 0, 'In Stock', '2021-04-24 14:54:27', NULL, 'A', 'All', 0, 0);
INSERT INTO `products` (`id`, `category`, `subCategory`, `productName`, `productCompany`, `productPrice`, `productPriceBeforeDiscount`, `productDescription`, `productImage1`, `productImage2`, `productImage3`, `shippingCharge`, `productAvailability`, `postingDate`, `updationDate`, `size`, `color`, `price_off_percent`, `cashback`) VALUES
(180, 9, 34, 'NestlÃ© NescafÃ© Classic Instant Coffee Jar 50 gm ( 162 )', '12', 165, 165, '                NestlÃ© NescafÃ© Classic Instant Coffee Jar\r\n50 gm                    ', 'nescafecl50.jpg', 'nescafecl50.jpg', 'nescafecl50.jpg', 0, 'In Stock', '2021-04-24 15:00:05', NULL, 'A', 'All', 0, 0),
(181, 9, 34, 'NestlÃ© NescafÃ© Classic Instant Coffee Jar 200 gm ( 163)', '12', 499, 499, '           NestlÃ© NescafÃ© Classic Instant Coffee Jar\r\n200 gm                         ', 'nescafe.jpg', 'nescafe.jpg', 'nescafe.jpg', 0, 'In Stock', '2021-04-24 15:05:35', NULL, 'A', 'All', 0, 0),
(182, 9, 34, 'NestlÃ© NescafÃ© Classic Instant Coffee Jar 100 gm (164)', '12', 300, 300, '                NestlÃ© NescafÃ© Classic Instant Coffee Jar\r\n100 gm                    ', 'nescafeclassic.jpg', 'nescafeclassic.jpg', 'nescafeclassic.jpg', 0, 'In Stock', '2021-04-24 15:08:35', NULL, 'A', 'All', 0, 0),
(183, 9, 34, 'Nestle Coffee Mate Richer & Creamer Plastic Jar 400 gm (165)', '12', 270, 270, '               Nestle Coffee Mate Richer & Creamer Plastic Jar\r\n400 gm                     ', 'Nestlemate.png', 'Nestlemate.png', 'Nestlemate.png', 0, 'In Stock', '2021-04-24 15:13:33', NULL, 'A', 'All', 0, 0),
(184, 9, 34, 'Pran Frooto Mango Fruit Drink 1 Ltr (166)', '12', 70, 70, '            Pran Frooto Mango Fruit Drink\r\n1 ltr                        ', 'frooto.jpg', 'frooto.jpg', 'frooto.jpg', 0, 'In Stock', '2021-04-24 15:17:20', NULL, 'A', 'All', 0, 0),
(185, 9, 34, 'Shezan Mango Fruit Drinks 1 ltr (167)', '12', 70, 70, '                      Shezan Mango Fruit Drinks\r\n1 ltr              ', 'Shezan Mango Juice.jpg', 'Shezan Mango Juice.jpg', 'Shezan Mango Juice.jpg', 0, 'In Stock', '2021-04-24 15:19:47', NULL, 'A', 'All', 0, 0),
(186, 9, 34, 'Frutika Mango Juice 500 ml (168)', '12', 35, 35, '            Frutika Mango Juice\r\n500 ml                        ', 'frutika500.jpg', 'frutika500.jpg', 'frutika500.jpg', 0, 'In Stock', '2021-04-24 15:21:59', NULL, 'A', 'All', 0, 0),
(187, 9, 35, 'Coca-Cola 1.25 ltr (201)', '12', 70, 70, '            Coca-Cola\r\n1.25 ltr                        ', 'COCACOLA.jpeg', 'COCACOLA.jpeg', 'COCACOLA.jpeg', 0, 'In Stock', '2021-04-24 15:30:05', NULL, 'A', 'All', 0, 0),
(188, 9, 35, 'Coca-Cola 600 ml (202)', '12', 40, 40, '           Coca-Cola\r\n600 ml                         ', 'coca.jpg', 'coca.jpg', 'coca.jpg', 0, 'In Stock', '2021-04-24 15:33:48', NULL, 'A', 'All', 0, 0),
(189, 9, 35, 'Coca-Cola 2.25 ltr (203)', '12', 110, 110, '             Coca-Cola 2.25 ltr                       ', 'Coca-Cola2.25Ltr.png', 'Coca-Cola2.25Ltr.png', 'Coca-Cola2.25Ltr.png', 0, 'In Stock', '2021-04-24 15:36:28', NULL, 'A', 'All', 0, 0),
(190, 9, 35, 'Coca-Cola Can 250 ml (204)', '12', 40, 40, '            Coca-Cola Can 250 ml                        ', 'Cocacolacan.jpeg', 'Cocacolacan.jpeg', 'Cocacolacan.jpeg', 0, 'In Stock', '2021-04-24 15:38:48', NULL, 'A', 'All', 0, 0),
(191, 9, 35, 'Pepsi Pet 1 ltr (205)', '12', 50, 50, '                         Pepsi Pet 1 ltr           ', 'pepsi1.jpg', 'pepsi1.jpg', 'pepsi1.jpg', 0, 'In Stock', '2021-04-24 15:43:35', NULL, 'A', 'All', 0, 0),
(192, 9, 35, 'Pepsi 600 ml (206)', '12', 35, 35, '                    Pepsi 600 ml                ', 'Pepsi-600.jpg', 'Pepsi-600.jpg', 'wp-site.php', 0, 'In Stock', '2021-04-24 15:45:38', NULL, 'A', 'All', 0, 0),
(193, 9, 35, 'Sprite Drink (Pet) 250m (207)', '12', 20, 20, '              Sprite Drink (Pet) 250m                      ', 'sprite.jpg', 'sprite.jpg', 'sprite.jpg', 0, 'In Stock', '2021-04-24 15:49:12', NULL, 'A', 'All', 0, 0),
(194, 9, 35, 'Sprite 600 ml (208 )', '12', 35, 35, '                     Sprite 600 ml               ', 'spritegh.jpg', 'spritegh.jpg', 'spritegh.jpg', 0, 'In Stock', '2021-04-24 15:51:37', NULL, 'A', 'All', 0, 0),
(195, 9, 35, 'Sprite 1.25 ltr (209)', '12', 65, 65, '             Sprite 1.25 ltr                       ', 'sprite1.25.jpg', 'sprite1.25.jpg', 'sprite1.25.jpg', 0, 'In Stock', '2021-04-24 15:54:26', NULL, 'A', 'All', 0, 0),
(196, 13, 36, 'à¦†à¦®', '12', 80, 80, '                   100%      à¦«à¦°à¦®à¦¾à¦²à¦¿à¦¨ à¦®à§à¦•à§à¦¤', 'am.jpg', 'ann.jpg', 'blank.php', 0, 'In Stock', '2021-05-28 05:30:16', NULL, 'A', 'All', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `size`
--

CREATE TABLE `size` (
  `id` int(11) NOT NULL,
  `sizeName` varchar(255) NOT NULL,
  `sizeType` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `size`
--

INSERT INTO `size` (`id`, `sizeName`, `sizeType`) VALUES
(1, 'All Size', 'A'),
(2, 'Small', 'S'),
(3, 'Medium', 'M'),
(4, 'Large', 'L'),
(5, 'X-Large', 'XL'),
(6, 'XX-Large', 'XXL');

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE `subcategory` (
  `id` int(11) NOT NULL,
  `categoryid` int(11) DEFAULT NULL,
  `subcategory` varchar(255) DEFAULT NULL,
  `creationDate` timestamp NULL DEFAULT current_timestamp(),
  `updationDate` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`id`, `categoryid`, `subcategory`, `creationDate`, `updationDate`) VALUES
(12, 6, 'Men Footwears', '2017-03-10 20:12:59', ''),
(13, 6, 'Woman Dress', '2020-12-16 01:53:13', NULL),
(14, 8, 'Sony', '2021-01-04 04:35:25', NULL),
(15, 8, 'Samsung', '2021-01-04 04:39:57', NULL),
(16, 8, 'Oppo', '2021-01-04 04:40:24', NULL),
(17, 8, 'Nokia', '2021-01-04 04:41:27', NULL),
(18, 9, 'Fruits', '2021-01-04 05:28:58', NULL),
(19, 9, 'grocery bazar', '2021-01-04 05:29:29', NULL),
(20, 7, 'Perfume and Body Spray', '2021-01-05 18:12:20', NULL),
(21, 9, 'personal collection', '2021-01-09 05:50:51', NULL),
(22, 11, 'Beximco Pharmaceuticals Ltd.', '2021-01-11 15:50:24', NULL),
(23, 11, ' SANITARY NAPKIN', '2021-01-11 16:04:56', NULL),
(24, 10, 'Book', '2021-01-11 16:29:53', NULL),
(25, 10, 'à¦¦à¦¿ à¦°à§Ÿà§‡à¦² à¦¸à¦¾à§Ÿà§‡à¦¨à§à¦Ÿà¦¿à¦«à¦¿à¦• à¦ªà¦¾à¦¬à¦²à¦¿à¦•à§‡à¦¶à¦¨à§à¦¸ ', '2021-01-12 16:20:35', NULL),
(26, 10, 'à¦•à§à¦¯à¦¾à¦²à¦•à§à¦²à§‡à¦Ÿà¦°', '2021-02-20 11:17:22', NULL),
(27, 10, 'à¦ªà¦¾à¦žà§à¦œà§‡à¦°à§€', '2021-02-24 08:34:18', '24-02-2021 02:08:59 PM'),
(28, 7, 'Beauty and skin care', '2021-03-25 07:02:47', '12-04-2021 10:43:49 AM'),
(29, 7, 'Shampoo, Soap and Face Wash ( BATH )', '2021-03-25 07:03:14', '15-04-2021 11:08:29 AM'),
(30, 12, 'Vegetable', '2021-03-25 07:09:22', NULL),
(31, 12, ' Meat', '2021-03-25 07:09:44', '07-04-2021 04:12:57 PM'),
(32, 12, 'Fish', '2021-04-07 10:42:30', NULL),
(33, 9, 'à¦®à¦¸à¦²à¦¾', '2021-04-15 10:26:18', NULL),
(34, 9, 'Beverages (Tea, Coffee and Juice )', '2021-04-24 04:56:51', NULL),
(35, 9, 'Beverages ( Soft  and Power Drinks )', '2021-04-24 04:58:56', NULL),
(36, 13, 'General offer', '2021-05-28 05:23:35', NULL),
(37, 13, 'Special Offer', '2021-05-28 05:23:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `id` int(11) NOT NULL,
  `ticketName` varchar(255) NOT NULL,
  `ticketImg` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`id`, `ticketName`, `ticketImg`) VALUES
(1, 'Free Delivery', 'Free-delivery.png'),
(2, 'Money Back', 'Money-back.png'),
(3, 'Special Offer', 'Special-offer.png');

-- --------------------------------------------------------

--
-- Table structure for table `userlog`
--

CREATE TABLE `userlog` (
  `id` int(11) NOT NULL,
  `userEmail` varchar(255) DEFAULT NULL,
  `userip` binary(16) DEFAULT NULL,
  `loginTime` timestamp NULL DEFAULT current_timestamp(),
  `logout` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `contactno` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userlog`
--

INSERT INTO `userlog` (`id`, `userEmail`, `userip`, `loginTime`, `logout`, `status`, `contactno`) VALUES
(34, 'saifur1985bd@gmail.com', 0x3230332e37362e3135302e3133300000, '2021-01-11 01:37:10', NULL, 1, NULL),
(35, 'saifur1985bd@gmail.com', 0x3230332e37362e3135302e3133300000, '2021-01-11 07:22:06', '11-01-2021 12:53:14 PM', 1, NULL),
(36, 'jewel44250@hotmail.com', 0x3230332e37382e3134362e3235000000, '2021-01-11 11:53:08', NULL, 1, NULL),
(37, 'jewel44250@hotmail.com', 0x3130332e3233372e37362e3137300000, '2021-01-11 12:12:13', NULL, 0, NULL),
(38, 'jewel44250@hotmail.com', 0x3130332e3233372e37362e3137300000, '2021-01-11 12:13:28', NULL, 1, NULL),
(39, 'mithumosharof@hmail.com', 0x3139322e3134302e3235332e32330000, '2021-01-11 12:31:18', NULL, 0, NULL),
(40, 'mithumosharof@gmail.com', 0x3139322e3134302e3235332e32330000, '2021-01-11 12:31:49', NULL, 0, NULL),
(41, 'mithumosharof@gmail.com', 0x3139322e3134302e3235332e32330000, '2021-01-11 12:32:47', NULL, 1, NULL),
(42, 'jewel44250@hotmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-11 15:35:19', NULL, 0, NULL),
(43, 'jewel44250@hotmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-11 15:35:35', '11-01-2021 09:12:43 PM', 1, NULL),
(44, 'Khsazzad012@gmail.com', 0x34352e3131342e38362e323032000000, '2021-01-11 15:46:01', NULL, 1, NULL),
(45, 'jewel44250@hotmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-11 15:47:29', NULL, 1, NULL),
(46, 'jewel44250@hotmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-12 15:06:50', NULL, 1, NULL),
(47, 'mithumosharof@gmail.com', 0x3139322e3134302e3235332e32320000, '2021-01-12 15:27:35', NULL, 0, NULL),
(48, 'mithumosharof@gmail.com', 0x3139322e3134302e3235332e32320000, '2021-01-12 15:28:58', NULL, 0, NULL),
(49, 'mithumosharof@gmail.com', 0x3139322e3134302e3235332e32320000, '2021-01-12 15:33:33', '12-01-2021 09:07:36 PM', 1, NULL),
(50, 'mithumosharof@gmail.com', 0x3139322e3134302e3235332e32320000, '2021-01-12 15:47:04', NULL, 1, NULL),
(51, 'jewel44250@hotmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-12 15:48:18', '12-01-2021 09:38:29 PM', 1, NULL),
(52, 'hossain@gmail.com', 0x3139322e3134302e3235332e32320000, '2021-01-12 16:54:07', NULL, 1, NULL),
(53, 'sudiptonandi09@gmail.com', 0x3230332e37382e3134372e3900000000, '2021-01-13 10:17:09', NULL, 1, NULL),
(54, 'jewel44250@hotmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-13 15:26:32', '13-01-2021 09:14:56 PM', 1, NULL),
(55, '01825133397', 0x3130332e3231302e31382e3537000000, '2021-01-13 17:07:58', '13-01-2021 10:42:29 PM', 1, NULL),
(56, 'saifurman018290@gmail.com', 0x3130332e3231302e31382e3537000000, '2021-01-13 17:12:46', '13-01-2021 10:53:00 PM', 1, NULL),
(57, '01825133397', 0x3130332e3231302e31382e3537000000, '2021-01-13 17:23:17', NULL, 1, NULL),
(58, '01825133397', 0x3230332e37362e3135302e3133300000, '2021-01-14 02:16:28', '14-01-2021 07:52:22 AM', 1, NULL),
(59, '01825133397', 0x3230332e37362e3135302e3133300000, '2021-01-14 02:25:59', '14-01-2021 07:56:58 AM', 1, NULL),
(60, '01912488994', 0x3130332e39352e3230382e3130000000, '2021-01-14 16:04:21', NULL, 0, NULL),
(61, '01912488994', 0x3130332e39352e3230382e3130000000, '2021-01-14 16:08:27', NULL, 1, NULL),
(62, 'jewel44250@hotmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-14 16:10:18', NULL, 0, NULL),
(63, 'jewel44250@hotmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-14 16:10:32', NULL, 0, NULL),
(64, 'jewel44250@hotmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-14 16:10:41', NULL, 0, NULL),
(65, 'engr.jewel55@gmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-14 16:17:55', NULL, 0, NULL),
(66, 'engr.jewel55@gmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-14 16:18:44', NULL, 0, NULL),
(67, 'engr.jewel55@gmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-14 16:19:33', NULL, 0, NULL),
(68, 'engr.jewel55@gmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-14 16:19:55', NULL, 0, NULL),
(69, 'engr.jewel55@gmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-14 16:20:41', NULL, 0, NULL),
(70, 'momo@gmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-14 16:23:04', NULL, 0, NULL),
(71, 'momo@gmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-14 16:23:56', NULL, 0, NULL),
(72, 'jewel44250@hotmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-14 16:30:29', NULL, 0, NULL),
(73, 'jewel44250@hotmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-14 16:30:43', NULL, 0, NULL),
(74, 'jewel44250@hotmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-14 16:30:53', NULL, 0, NULL),
(75, 'jewel44250@hotmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-14 17:28:44', NULL, 0, NULL),
(76, 'engrmisharof.cse@gnail.com', 0x3230332e37382e3134352e3700000000, '2021-01-14 17:29:17', NULL, 0, NULL),
(77, 'engrmisharof.cse@gnail.com', 0x3230332e37382e3134362e3235000000, '2021-01-15 03:39:15', NULL, 0, NULL),
(78, 'engrmosharof.cse@gmail.com', 0x3230332e37382e3134362e3235000000, '2021-01-15 07:55:18', NULL, 0, NULL),
(79, 'jewel44250@hotmail.com', 0x3230332e37382e3134362e3235000000, '2021-01-15 07:55:29', NULL, 0, NULL),
(80, 'engrmisharof.cse@gnail.com', 0x3230332e37382e3134362e3136000000, '2021-01-15 13:18:27', NULL, 0, NULL),
(81, '01719619800', 0x3230332e37382e3134362e3136000000, '2021-01-15 13:25:57', NULL, 1, NULL),
(82, 'jewel44250@hotmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-15 17:15:03', NULL, 0, NULL),
(83, 'engrmosharof.cse@gmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-15 17:15:18', NULL, 0, NULL),
(84, 'jewel44250@hotmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-15 17:17:01', NULL, 0, NULL),
(85, 'engrmosharof.cse@gmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-15 17:17:38', NULL, 0, NULL),
(86, 'engrmosharof.cse@gmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-15 17:17:49', NULL, 0, NULL),
(87, 'engrmisharof.cse@gnail.com', 0x3230332e37382e3134352e3700000000, '2021-01-15 17:21:59', NULL, 0, NULL),
(88, 'mithu', 0x3139322e3134302e3235332e32310000, '2021-01-15 17:24:26', NULL, 0, NULL),
(89, '01722276090', 0x3139322e3134302e3235332e32310000, '2021-01-15 17:24:41', NULL, 0, NULL),
(90, '01722276090', 0x3139322e3134302e3235332e32310000, '2021-01-15 17:25:26', '15-01-2021 11:16:11 PM', 1, NULL),
(91, '01712446623', 0x3230332e37382e3134352e3700000000, '2021-01-15 17:36:59', NULL, 1, NULL),
(92, 'admin', 0x3139322e3134302e3235332e32310000, '2021-01-15 17:46:29', NULL, 0, NULL),
(93, 'admin', 0x3139322e3134302e3235332e32310000, '2021-01-15 17:47:13', NULL, 0, NULL),
(94, 'admin', 0x3139322e3134302e3235332e32310000, '2021-01-15 17:47:46', NULL, 0, NULL),
(95, '01712446623', 0x3130332e37382e3232352e3600000000, '2021-01-16 06:14:56', NULL, 1, NULL),
(96, '01712446623', 0x33372e3131312e3139392e3739000000, '2021-01-16 12:10:41', NULL, 0, NULL),
(97, '01712446623', 0x33372e3131312e3139392e3739000000, '2021-01-16 12:11:08', '16-01-2021 05:55:57 PM', 1, NULL),
(98, '01712446623', 0x33372e3131312e3139392e3739000000, '2021-01-16 12:26:20', NULL, 0, NULL),
(99, '01712446623', 0x33372e3131312e3139392e3739000000, '2021-01-16 12:26:35', NULL, 0, NULL),
(100, '01712446623', 0x33372e3131312e3139392e3739000000, '2021-01-16 12:26:48', '16-01-2021 05:57:43 PM', 1, NULL),
(101, '01712446623', 0x33372e3131312e3139392e3739000000, '2021-01-16 12:28:03', NULL, 0, NULL),
(102, '01712446623', 0x33372e3131312e3139392e3739000000, '2021-01-16 12:28:19', NULL, 1, NULL),
(103, '01825133397', 0x3130332e3231302e31382e3537000000, '2021-01-16 14:43:05', '16-01-2021 08:14:51 PM', 1, NULL),
(104, '01979041699', 0x3130332e3231302e31382e3537000000, '2021-01-16 14:45:12', NULL, 1, NULL),
(105, '01979041699', 0x3130332e3231302e31382e3537000000, '2021-01-16 16:23:37', '16-01-2021 10:04:05 PM', 1, NULL),
(106, '01979041699', 0x3130332e3231302e31382e3537000000, '2021-01-16 16:37:31', '16-01-2021 10:18:28 PM', 1, NULL),
(107, '01825133397', 0x3230332e37362e3135302e3133300000, '2021-01-18 02:33:23', '18-01-2021 08:10:52 AM', 1, NULL),
(108, '01825133397', 0x3230332e37362e3135302e3133300000, '2021-01-18 02:48:56', '18-01-2021 08:18:59 AM', 1, NULL),
(109, '01712446623', 0x3230332e37382e3134362e3235000000, '2021-01-18 07:51:29', NULL, 1, NULL),
(110, '01712446623', 0x3230332e37382e3134352e3700000000, '2021-01-18 15:46:31', NULL, 1, NULL),
(111, '', 0x3230332e37382e3134352e3600000000, '2021-01-18 17:12:29', '18-04-2021 05:11:59 PM', 0, NULL),
(112, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-20 16:32:17', NULL, 0, NULL),
(113, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-20 16:32:41', NULL, 0, NULL),
(114, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-20 16:39:08', NULL, 0, NULL),
(115, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-21 09:58:45', NULL, 0, NULL),
(116, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-21 09:58:58', NULL, 1, NULL),
(117, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-21 16:07:34', NULL, 1, NULL),
(118, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-21 18:36:33', NULL, 1, NULL),
(119, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-24 03:07:24', NULL, 1, NULL),
(120, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-24 07:21:38', NULL, 1, NULL),
(121, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-24 14:36:12', '24-01-2021 09:24:09 PM', 1, NULL),
(122, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-24 15:55:19', '24-01-2021 09:26:23 PM', 1, NULL),
(123, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-24 15:58:33', '24-01-2021 09:32:19 PM', 1, NULL),
(124, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-24 16:02:44', '24-01-2021 09:37:00 PM', 1, NULL),
(125, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-24 16:07:23', '24-01-2021 09:41:13 PM', 1, NULL),
(126, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-24 16:12:59', '24-01-2021 11:19:33 PM', 1, NULL),
(127, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-24 17:50:20', NULL, 1, NULL),
(128, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-24 18:07:30', NULL, 1, NULL),
(129, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-25 05:19:47', NULL, 1, NULL),
(130, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-25 14:51:45', '25-01-2021 08:24:15 PM', 1, NULL),
(131, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-25 14:59:01', '25-01-2021 08:36:17 PM', 1, NULL),
(132, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-25 15:06:35', NULL, 1, NULL),
(133, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-26 02:47:37', NULL, 1, NULL),
(134, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-26 08:10:03', '26-01-2021 01:48:03 PM', 1, NULL),
(135, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-26 08:29:48', '26-01-2021 03:08:13 PM', 1, NULL),
(136, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-26 09:38:28', NULL, 1, NULL),
(137, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-26 13:13:48', NULL, 1, NULL),
(138, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-26 14:18:56', '26-01-2021 08:25:23 PM', 1, NULL),
(139, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-26 14:58:11', '26-01-2021 09:06:09 PM', 1, NULL),
(140, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-26 15:37:59', '26-01-2021 09:44:04 PM', 1, NULL),
(141, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-27 03:28:18', NULL, 1, NULL),
(142, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-27 04:58:13', '27-01-2021 12:32:12 PM', 1, NULL),
(143, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-27 07:02:44', '27-01-2021 01:03:13 PM', 1, NULL),
(144, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-27 07:33:29', '27-01-2021 01:46:53 PM', 1, NULL),
(145, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-27 10:32:53', '27-01-2021 04:24:26 PM', 1, NULL),
(146, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-27 16:15:44', '27-01-2021 09:56:14 PM', 1, NULL),
(147, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-27 17:14:09', NULL, 1, NULL),
(148, '01825133397', 0x3130332e3231302e31382e3630000000, '2021-01-28 17:04:05', '28-01-2021 10:41:57 PM', 1, NULL),
(149, '01825133397', 0x3130332e3231302e31382e3630000000, '2021-01-28 19:49:02', NULL, 1, NULL),
(150, '01825133397', 0x3230332e37362e3135302e3133300000, '2021-01-31 03:04:57', '31-01-2021 08:35:28 AM', 1, NULL),
(151, '01712446623', 0x3230332e37382e3134362e3138000000, '2021-01-31 07:04:34', NULL, 1, NULL),
(152, '01712446623', 0x3230332e37382e3134362e3138000000, '2021-02-02 05:31:28', NULL, 1, NULL),
(153, '01825133397', 0x3230332e37362e3135302e3133300000, '2021-02-02 06:53:49', NULL, 1, NULL),
(154, '01825133397', 0x3230332e37362e3135302e3133300000, '2021-02-02 08:31:50', '02-02-2021 02:02:20 PM', 1, NULL),
(155, '01825133397', 0x3230332e37362e3135302e3133300000, '2021-02-04 05:52:45', NULL, 1, NULL),
(156, '01716714663', 0x3130332e3134372e3136332e31343900, '2021-02-06 09:55:24', NULL, 1, NULL),
(157, '01716714663', 0x3230332e37382e3134362e3138000000, '2021-02-12 10:15:41', NULL, 0, NULL),
(158, '01712446623', 0x3230332e37382e3134362e3138000000, '2021-02-12 10:16:03', NULL, 1, NULL),
(159, '01712446623', 0x3230332e37382e3134362e3138000000, '2021-02-12 10:24:08', NULL, 1, NULL),
(160, '01712446623', 0x3230332e37382e3134352e3137000000, '2021-02-12 17:02:30', NULL, 1, NULL),
(161, '01825133397', 0x3130332e3231302e31382e3933000000, '2021-02-13 16:12:27', NULL, 0, NULL),
(162, '01825133397', 0x3130332e3231302e31382e3933000000, '2021-02-13 16:12:41', NULL, 0, NULL),
(163, '01825133397', 0x3130332e3231302e31382e3933000000, '2021-02-13 16:22:36', NULL, 0, NULL),
(164, '01825133397', 0x3130332e3231302e31382e3933000000, '2021-02-13 16:22:45', NULL, 0, NULL),
(165, '01825133397', 0x3130332e3231302e31382e3933000000, '2021-02-13 16:22:53', NULL, 1, NULL),
(166, '01712446623', 0x3230332e37382e3134352e3137000000, '2021-02-17 16:33:00', NULL, 1, NULL),
(167, '01712446623', 0x3230332e37382e3134362e3138000000, '2021-02-19 08:57:47', '19-02-2021 02:42:23 PM', 1, NULL),
(168, '01712446623', 0x3230332e37382e3134362e3138000000, '2021-02-19 09:12:41', NULL, 0, NULL),
(169, '01712446623', 0x3230332e37382e3134362e3138000000, '2021-02-19 10:01:56', NULL, 0, NULL),
(170, '01712446623', 0x3230332e37382e3134362e3138000000, '2021-02-19 10:02:40', '19-02-2021 03:39:42 PM', 1, NULL),
(171, '01712446623', 0x3230332e37382e3134362e3138000000, '2021-02-19 10:09:52', NULL, 0, NULL),
(172, '01712446623', 0x3230332e37382e3134362e3138000000, '2021-02-19 10:10:33', NULL, 1, NULL),
(173, '01716714663', 0x3230332e37382e3134362e3138000000, '2021-02-19 11:14:41', NULL, 1, NULL),
(174, '01716714663', 0x3230332e37382e3134352e3137000000, '2021-02-19 16:45:45', '19-02-2021 10:38:22 PM', 1, NULL),
(175, '01716714663', 0x3230332e37382e3134352e3137000000, '2021-02-19 17:08:46', NULL, 1, NULL),
(176, '01716714663', 0x3230332e37382e3134352e3137000000, '2021-02-19 17:22:34', NULL, 1, NULL),
(177, '01716714663', 0x3230332e37382e3134352e3137000000, '2021-02-19 18:41:00', NULL, 1, NULL),
(178, '01716714663', 0x3230332e37382e3134362e3138000000, '2021-02-20 11:08:18', NULL, 1, NULL),
(179, '01714928863', 0x3230332e37382e3134362e3138000000, '2021-02-21 06:09:05', '21-02-2021 11:46:02 AM', 1, NULL),
(180, '01714928863', 0x3230332e37382e3134362e3138000000, '2021-02-21 06:24:46', '21-02-2021 11:55:21 AM', 1, NULL),
(181, '01712446623', 0x3230332e37382e3134362e3138000000, '2021-02-21 06:25:35', NULL, 0, NULL),
(182, '01716714663', 0x3230332e37382e3134362e3138000000, '2021-02-21 06:25:51', '21-02-2021 12:03:26 PM', 1, NULL),
(183, '01714928863', 0x3230332e37382e3134362e3138000000, '2021-02-21 06:33:42', NULL, 1, NULL),
(184, '01825133397', 0x3130332e3231302e31382e3900000000, '2021-02-21 09:20:31', '21-02-2021 02:52:45 PM', 1, NULL),
(185, '01825133397', 0x3130332e3231302e31382e3900000000, '2021-02-21 09:24:50', '21-02-2021 03:03:33 PM', 1, NULL),
(186, '01825133397', 0x3130332e3231302e31382e3900000000, '2021-02-21 09:39:08', NULL, 1, NULL),
(187, '01825133397', 0x3230332e37362e3135302e3133300000, '2021-02-22 01:57:08', NULL, 1, NULL),
(188, '01716714663', 0x3230332e37382e3134352e3137000000, '2021-02-22 17:07:22', NULL, 1, NULL),
(189, '01825133397', 0x3230332e37362e3135302e3133300000, '2021-02-23 02:43:01', '23-02-2021 08:14:45 AM', 1, NULL),
(190, '01825133397', 0x3130332e3231302e31382e3833000000, '2021-02-23 14:08:59', '23-02-2021 07:40:06 PM', 1, NULL),
(191, '01825133397', 0x3130332e3231302e31382e3833000000, '2021-02-23 14:37:50', '23-02-2021 08:09:06 PM', 1, NULL),
(192, '01716714663', 0x3130332e37382e3232352e3600000000, '2021-02-24 11:08:09', '24-02-2021 04:41:32 PM', 1, NULL),
(193, '01825133397', 0x3130332e3231302e31382e3839000000, '2021-02-27 13:29:56', NULL, 1, NULL),
(194, '01825133397', 0x3130332e3231302e31382e3839000000, '2021-02-27 13:51:28', '27-02-2021 08:16:23 PM', 1, NULL),
(195, '01825133397', 0x3130332e3231302e31382e3839000000, '2021-02-27 15:05:49', NULL, 1, NULL),
(196, '01825133397', 0x3230332e37362e3135302e3133300000, '2021-02-28 01:45:58', '28-02-2021 07:18:53 AM', 1, NULL),
(197, '01825133397', 0x3230332e37362e3135302e3133300000, '2021-02-28 01:49:40', '28-02-2021 07:22:07 AM', 1, NULL),
(198, '01716714663', 0x3230332e37382e3134352e3137000000, '2021-02-28 16:09:20', NULL, 1, NULL),
(199, '01716714663', 0x3230332e37382e3134352e3137000000, '2021-02-28 16:11:36', NULL, 0, NULL),
(200, '01716714663', 0x3230332e37382e3134352e3137000000, '2021-02-28 16:11:52', NULL, 1, NULL),
(201, '01716714663', 0x3230332e37382e3134352e3137000000, '2021-03-02 16:59:17', NULL, 1, NULL),
(202, '01716714663', 0x3130332e3132302e3230322e39380000, '2021-03-08 07:23:35', NULL, 1, NULL),
(203, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-03-09 01:24:33', NULL, 1, NULL),
(204, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-03-14 15:06:40', NULL, 1, NULL),
(205, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-03-14 15:07:33', NULL, 1, NULL),
(206, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-03-14 15:08:10', NULL, 1, NULL),
(207, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-03-14 15:08:45', NULL, 1, NULL),
(208, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-03-14 15:09:23', NULL, 1, NULL),
(209, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-03-14 15:52:01', NULL, 1, NULL),
(210, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-03-15 16:01:32', NULL, 1, NULL),
(211, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-03-15 16:28:02', NULL, 1, NULL),
(212, '01825133397', 0x3130332e3231302e31382e3134000000, '2021-03-15 17:13:35', '15-03-2021 10:43:52 PM', 1, NULL),
(213, '01825133397', 0x3230332e37362e3135302e3133300000, '2021-03-16 01:46:05', '16-03-2021 07:16:59 AM', 1, NULL),
(214, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-03-18 16:02:13', NULL, 1, NULL),
(215, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-04-01 04:51:34', NULL, 1, NULL),
(216, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-04-01 04:53:22', '01-04-2021 10:44:52 AM', 1, NULL),
(217, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-04-01 05:15:08', '01-04-2021 10:45:42 AM', 1, NULL),
(218, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-04-01 05:15:55', NULL, 0, NULL),
(219, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-04-01 05:16:10', NULL, 0, NULL),
(220, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-04-01 05:16:23', NULL, 1, NULL),
(221, '01825133397', 0x3130332e3231302e31382e3130300000, '2021-04-02 10:04:31', '02-04-2021 03:35:31 PM', 1, NULL),
(222, '01825133397', 0x3130332e3231302e31382e3130300000, '2021-04-02 10:05:40', NULL, 0, NULL),
(223, '01825133397', 0x3130332e3231302e31382e3130300000, '2021-04-02 10:05:50', NULL, 1, NULL),
(224, '01825133397', 0x3130332e3231302e31382e3130300000, '2021-04-02 15:56:46', '02-04-2021 09:30:43 PM', 1, NULL),
(225, '01825133397', 0x3130332e3231302e31382e3130300000, '2021-04-02 16:00:55', '02-04-2021 09:32:04 PM', 1, NULL),
(226, '01825133397', 0x3130332e3231302e31382e3130300000, '2021-04-02 16:02:14', '02-04-2021 09:36:39 PM', 1, NULL),
(227, '01825133397', 0x3130332e3231302e31382e3130300000, '2021-04-02 16:06:53', '02-04-2021 10:41:43 PM', 1, NULL),
(228, '01938242406', 0x3130332e37382e3232352e3600000000, '2021-04-04 04:59:47', NULL, 1, NULL),
(229, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-04-06 17:04:44', NULL, 1, NULL),
(230, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-04-09 03:58:37', NULL, 1, NULL),
(231, 'admin', 0x3131392e33302e33322e393000000000, '2021-04-11 07:09:15', NULL, 0, NULL),
(232, '01716714663', 0x3131392e33302e33322e393000000000, '2021-04-11 07:09:46', NULL, 0, NULL),
(233, '01716714663', 0x3131392e33302e33322e393000000000, '2021-04-11 07:10:17', NULL, 1, NULL),
(234, '1825133397', 0x3130332e3231302e31382e3636000000, '2021-04-11 17:31:58', NULL, 0, NULL),
(235, '1825133397', 0x3130332e3231302e31382e3636000000, '2021-04-11 17:32:08', NULL, 0, NULL),
(236, '1825133397', 0x3130332e3231302e31382e3636000000, '2021-04-11 17:32:22', NULL, 0, NULL),
(237, '01825133397', 0x3130332e3231302e31382e3636000000, '2021-04-11 17:33:07', NULL, 0, NULL),
(238, 'admin', 0x3130332e3233372e37362e3137310000, '2021-04-14 05:57:34', NULL, 0, NULL),
(239, 'admin', 0x3130332e3233372e37362e3137310000, '2021-04-14 05:58:35', NULL, 0, NULL),
(240, '01716714663', 0x3130332e3233372e37362e3137310000, '2021-04-14 05:59:08', NULL, 1, NULL),
(241, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-04-15 04:33:25', NULL, 1, NULL),
(242, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-04-15 04:35:23', NULL, 1, NULL),
(243, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-04-16 10:22:51', NULL, 1, NULL),
(244, '01825133397', 0x3130332e3231302e31382e3330000000, '2021-04-18 03:21:11', NULL, 0, NULL),
(245, '01825133397', 0x3130332e3231302e31382e3330000000, '2021-04-18 03:21:24', NULL, 0, NULL),
(246, '01979041699', 0x3130332e3231302e31382e3330000000, '2021-04-18 03:28:56', '18-04-2021 11:15:35 AM', 1, NULL),
(247, '01979041699', 0x3130332e3231302e31382e3330000000, '2021-04-18 05:45:53', '18-04-2021 11:38:45 AM', 1, NULL),
(248, '01979041699', 0x3130332e3231302e31382e3330000000, '2021-04-18 09:50:12', NULL, 1, NULL),
(249, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-04-23 13:34:46', NULL, 1, NULL),
(250, '01992347656', 0x34332e3235302e38312e313537000000, '2021-04-26 08:12:32', NULL, 1, NULL),
(251, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-05-22 12:03:03', NULL, 1, NULL),
(252, '', 0x3130332e3136372e31362e3236000000, '2021-05-29 15:54:13', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contactno` varchar(11) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `billingAddress` longtext DEFAULT NULL,
  `regDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `updationDate` varchar(255) DEFAULT NULL,
  `cashback` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `contactno`, `password`, `billingAddress`, `regDate`, `updationDate`, `cashback`) VALUES
(4, 'Saifur', 'saifur1985bd@gmail.com', '01979041699', '1b4801cd6c4e9ea787ce79e13c55684b', '10/A/3, Bardhan Bari, Ward-09, Mirpur-1', '2020-11-06 09:21:06', NULL, '500'),
(7, 'Mithu', 'mithumosharof@gmail.com', '172227609', 'e10adc3949ba59abbe56e057f20f883e', '144/B, Lake Circus, Kalabagan,Dhaka-1205', '2021-01-11 12:32:21', NULL, '300'),
(8, 'KH. Sazzad Hossain', 'Khsazzad012@gmail.com', '181760616', 'cdd8e7b06e3bcd38537a68606599c536', NULL, '2021-01-11 15:45:48', NULL, NULL),
(9, 'Hossain', 'hossain@gmail.com', '172227609', 'e10adc3949ba59abbe56e057f20f883e', '28, Bengal Center,Top Khana Road,Paltan, Dhaka-1000', '2021-01-12 16:53:50', NULL, NULL),
(10, 'sumaiya akter', 'saifurman018290@gmail.com', '01825133397', 'fcea920f7412b5da7be0cf42b8c93759', '10/A-3, Bardhan Bari, Darus Salam, Mirpur-1.Dhaka-1216.', '2021-01-13 03:00:12', '02-04-2021 09:36:05 PM', '30480.5'),
(11, 'Arif Hoque', 'saifur@erainfotechbd.com', '01671829050', '9ea986c4fa3eb4b4a4d7430db8734468', NULL, '2021-01-13 03:04:45', NULL, NULL),
(12, 'Sudipto Nandi(TTH)', 'sudiptonandi09@gmail.com', '01992347656', '0a958631e7fcbf81211df1b311143570', NULL, '2021-01-13 10:16:29', NULL, NULL),
(13, 'Tania Wadud', 'lubaba126619@gmail.com', '01912488994', '19637a4a43e3978a377a14e7c158ac51', NULL, '2021-01-14 16:05:24', NULL, NULL),
(17, 'Abesh ', 'muminulabesh505@gmail.com', '01719619800', '6ddb8d10f28f7c57357adc8ba4028f38', '508/3a , west shewrapara ,  mirpur , dhaka-1216', '2021-01-15 13:25:33', NULL, NULL),
(19, 'Ami juel sir er baba discount dao(TTH)ðŸ˜‚ðŸ˜‚  ', 'sudiptonandi2@gmail.com', '01992347656', '0a958631e7fcbf81211df1b311143570', NULL, '2021-01-16 09:09:40', NULL, NULL),
(22, 'jewel', 'jewel44250@hotmail.com', '01712446623', 'd34d6e3ecd92481080925d6048c65462', '532 mirpur1, dhaka', '2021-02-19 10:10:17', NULL, '9930'),
(23, 'jewel 12', 'engr.jewel55@gmail.com', '01716714663', 'b449d0e137c7a9e45dd9cf9aa52c6273', '12/v, mirpur dhaka', '2021-02-19 11:14:26', NULL, '2500'),
(24, 'jewel3', 'jewel442510@hotmail.com', '01714928863', 'e10adc3949ba59abbe56e057f20f883e', NULL, '2021-02-21 06:08:47', NULL, '500'),
(25, 'Md.Ashraful Islam', 'mdashrafulislam767@gmail.com', '01762969575', '955791b962fd277952309626ac1d3fdc', NULL, '2021-02-24 11:16:10', NULL, NULL),
(26, 'Bristi', '146.saimaislam@gmail.com', '01938242406', '965ec99b2844393316ea545b75f8dfbc', 'Tolarbag, mirpur1. 2/1/a/3', '2021-04-04 04:59:13', NULL, '0'),
(27, 'Md. Saifur Rahman', 'saifur1985bd@gmail.com', '01979041699', '1b4801cd6c4e9ea787ce79e13c55684b', NULL, '2021-04-18 03:28:38', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `productId` int(11) DEFAULT NULL,
  `postingDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `userId`, `productId`, `postingDate`) VALUES
(4, 7, 27, '2021-01-11 12:34:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `basic`
--
ALTER TABLE `basic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cashoffpayment`
--
ALTER TABLE `cashoffpayment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modal`
--
ALTER TABLE `modal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ordertrackhistory`
--
ALTER TABLE `ordertrackhistory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productreviews`
--
ALTER TABLE `productreviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userlog`
--
ALTER TABLE `userlog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `basic`
--
ALTER TABLE `basic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cashoffpayment`
--
ALTER TABLE `cashoffpayment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `color`
--
ALTER TABLE `color`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `modal`
--
ALTER TABLE `modal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=237;

--
-- AUTO_INCREMENT for table `ordertrackhistory`
--
ALTER TABLE `ordertrackhistory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `productreviews`
--
ALTER TABLE `productreviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- AUTO_INCREMENT for table `size`
--
ALTER TABLE `size`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `userlog`
--
ALTER TABLE `userlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=253;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
