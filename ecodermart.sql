-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2025 at 06:26 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecodermart`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `updationDate` varchar(255) NOT NULL,
  `contactNo` int(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `creationDate`, `updationDate`, `contactNo`) VALUES
(1, 'admin', '9ea986c4fa3eb4b4a4d7430db8734468', '2017-01-24 10:21:18', '02-04-2021 04:12:23 PM', 1540505646);

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `bannerName` varchar(100) NOT NULL,
  `bannerType` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `bannerName`, `bannerType`) VALUES
(1, 'Slider - স্লাইডার', 'SL'),
(2, 'After Slider - স্লাইডারের পরে', 'AS'),
(3, 'After Product - পণ্যের পরে', 'AP'),
(4, 'Left Side - বাম পাশ', 'LS'),
(5, 'Right Side - ডান দিক', 'RS'),
(6, 'Others - অন্যান্য', 'OT');

-- --------------------------------------------------------

--
-- Table structure for table `basic`
--

CREATE TABLE `basic` (
  `id` int(11) NOT NULL,
  `compName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `compName_en` varchar(50) DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `office_phone` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `currency` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `facebook` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `twitter` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `linkedin` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `delivery_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `messanger_group` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `whatapps_group` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `open_time` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `close_time` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `updationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `basic`
--

INSERT INTO `basic` (`id`, `compName`, `compName_en`, `address`, `phone`, `office_phone`, `email`, `logo`, `currency`, `facebook`, `twitter`, `linkedin`, `delivery_method`, `messanger_group`, `whatapps_group`, `open_time`, `close_time`, `updationDate`) VALUES
(1, 'কোডার মার্ট লিঃ', 'Coder Mart Ltd', '10/A-3, Bardhan Bari, Darus Salam, Mirpur-1, Dhaka.', '01540505646', '01829041699', 'info@ecodermart.com', 'cat_67e300b9436dd7.93628532.jpg', 'cat_67e300b9437ca4.92549314.png', 'F', 'T', 'L', 'DM', 'mg', 'wg', '10', '20', '2025-03-25 19:05:47');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `brandsName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `brandsName_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `brandsImage` varchar(255) NOT NULL,
  `postingDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `brandsName`, `brandsName_en`, `brandsImage`, `postingDate`) VALUES
(14, 'আফতাব ফুডস্ লিঃ', 'AFTAB Foods Ltd', 'brand_67c9cd79bc3ad5.46473723.jpg', '2025-03-06 16:29:45'),
(15, 'ইয়োকো ফুডস্ এন্ড এগ্রো লিঃ', 'YOKO Foods & Agro Ltd', 'yoko.jpg', '2025-03-06 16:34:56'),
(16, 'শেফ ফুডস ইন্ডাস্ট্রিস লিঃ', 'CHEF Foods Industries Ltd', 'chef.jpg', '2025-03-06 16:37:32'),
(21, 'কোডার মার্ট লিঃ', 'Coder Mart Ltd', 'coder.jpg', '2025-03-06 18:07:12');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `catName` varchar(255) DEFAULT NULL,
  `catName_en` varchar(255) DEFAULT NULL,
  `catImage` varchar(256) DEFAULT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `catName`, `catName_en`, `catImage`, `creationDate`) VALUES
(2, 'ফল এবং হিমায়িত', 'Fruits & Frozen', 'category_67cdbeb3089d99.55568847.jpg', '2025-03-09 16:15:47'),
(3, 'রান্নার উপকরণ', 'Cooking Ingredients', 'category_67cdc41c8ec2b2.30608349.jpg', '2025-03-09 16:38:52'),
(4, 'চকোলেট এবং ক্যান্ডি', 'Chocolates & Candy', 'category_67cdc43acdded7.36163599.jpg', '2025-03-09 16:39:22'),
(5, 'স্ন্যাকস এবং পানীয়', 'Snacks & Beverages', 'category_67cdc4535c4a08.08438858.JPG', '2025-03-09 16:39:47'),
(7, 'ট্রেডিং পণ্য', 'Trading Products', '', '2025-03-29 18:41:47');

-- --------------------------------------------------------

--
-- Table structure for table `color`
--

CREATE TABLE `color` (
  `id` int(11) NOT NULL,
  `colorName` varchar(255) NOT NULL,
  `colorType` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `color`
--

INSERT INTO `color` (`id`, `colorName`, `colorType`) VALUES
(1, 'All Colors - সমস্ত রং', 'ALL'),
(2, 'Blue - নীল', 'B'),
(3, 'Green - সবুজ', 'G'),
(4, 'Orange - কমলা', 'O'),
(5, 'Yellow - হলুদ', 'Y'),
(6, 'Pink - গোলাপি', 'P'),
(7, 'Violet - বেগুনি', 'V'),
(8, 'Turquoise - ফিরোজা', 'T'),
(9, 'Golden - সোনালী', 'Go'),
(10, 'Lemon - লেমন', 'L'),
(11, 'Sky - আকাশী', 'N'),
(12, 'Brown - বাদামী', 'B'),
(13, 'White - সাদা', 'W'),
(14, 'Black - কালো', 'Bl'),
(15, 'Red - লাল', 'R');

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `id` int(11) NOT NULL,
  `couponCode` varchar(100) NOT NULL,
  `cashOff` float NOT NULL,
  `value` float DEFAULT NULL,
  `status` varchar(3) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupon`
--

INSERT INTO `coupon` (`id`, `couponCode`, `cashOff`, `value`, `status`, `creation_date`) VALUES
(5, 'coupon8.6', 8.6, 0.086, 'A', '2025-03-26 19:49:57');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `cusId` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name_bn` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `compName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `address` text DEFAULT NULL,
  `contactNo` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `totalBuy` float(15,2) NOT NULL DEFAULT 0.00,
  `totalPaid` float(15,2) NOT NULL DEFAULT 0.00,
  `totalDue` float(15,2) NOT NULL DEFAULT 0.00,
  `regDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `cusImg` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `updateDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cusupdeli`
--

CREATE TABLE `cusupdeli` (
  `id` int(11) NOT NULL,
  `forId` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `userName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `userName_bn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `passCode` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `compName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `address` text DEFAULT NULL,
  `contactNo` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `totalBuy` float(15,2) NOT NULL DEFAULT 0.00,
  `totalPaid` float(15,2) NOT NULL DEFAULT 0.00,
  `totalDue` float(15,2) NOT NULL DEFAULT 0.00,
  `regDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `forwarding` varchar(5) DEFAULT NULL,
  `updateDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cusupdeli`
--

INSERT INTO `cusupdeli` (`id`, `forId`, `userName`, `userName_bn`, `password`, `passCode`, `compName`, `address`, `contactNo`, `email`, `totalBuy`, `totalPaid`, `totalDue`, `regDate`, `image`, `status`, `forwarding`, `updateDate`) VALUES
(4, 'usr_11111', 'saifur', 'admin', '3d2172418ce305c7d16d4b05597c6a59', '22222', 'era', 'fgrtfdffg', '01829041688', 'saifur@gmail.com', 0.00, 0.00, 0.00, '2025-03-29 09:26:25', 'usr_67e7f0ac6bee66.21513562.jpg', 'A', 'usr', '2025-03-29 09:26:25'),
(5, 'sup_11111', 'halim', 'jalim', '', '', 'rea', 'hasjhsakj', '01247514584', 'fshgggs@gmail.com', 0.00, 0.00, 0.00, '2025-03-29 10:22:50', 'sup_67e7c9fa3f99a3.37543873.JPG', 'A', 'sup', '2025-03-29 10:22:50'),
(6, 'cus_11111', 'nara', 'kara', '', '', 'ddfd', 'hhfhgfhfgh', '54154411545', 'saifur@gmail.com', 0.00, 0.00, 0.00, '2025-03-29 10:23:38', 'cus_67e7ca2aca63a0.33016527.png', 'A', 'cus', '2025-03-29 10:23:38'),
(8, 'dem_11112', 'nvjh', 'jhgjhg', '', '', 'gfg', 'hhgfhg', '55415674545', 'ggfhg', 0.00, 0.00, 0.00, '2025-03-29 10:24:48', 'dem_67e7ca70b0b915.62240649.png', 'A', 'dem', '2025-03-29 10:24:48'),
(13, 'usr_11112', 'saifurs', 'admins', 'e10adc3949ba59abbe56e057f20f883e', '123456', 'era', 'fgrtfdffg', '01829041699', 'saifur@gmail.com', 0.00, 0.00, 0.00, '2025-03-29 11:08:28', 'usr_67e7d4ac4d3809.50615938.jpg', 'A', 'usr', '2025-03-29 11:08:28'),
(14, 'usr_11113', 'sumaiya', 'সুমাইয়া', '1a100d2c0dab19c4430e7d73762b3423', '333333', 'hooland', 'fdgfggffgdfgd', '01810547599', 'sumaiya@gmail.com', 0.00, 0.00, 0.00, '2025-03-29 17:47:39', 'usr_67e83257757ab8.18479606.JPG', 'A', 'usr', '2025-03-29 17:47:39');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` int(2) NOT NULL,
  `division_id` int(1) NOT NULL,
  `name` varchar(25) NOT NULL,
  `bn_name` varchar(25) NOT NULL,
  `lat` varchar(15) DEFAULT NULL,
  `lon` varchar(15) DEFAULT NULL,
  `url` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `division_id`, `name`, `bn_name`, `lat`, `lon`, `url`) VALUES
(1, 1, 'Comilla', 'কুমিল্লা', '23.4682747', '91.1788135', 'www.comilla.gov.bd'),
(2, 1, 'Feni', 'ফেনী', '23.023231', '91.3840844', 'www.feni.gov.bd'),
(3, 1, 'Brahmanbaria', 'ব্রাহ্মণবাড়িয়া', '23.9570904', '91.1119286', 'www.brahmanbaria.gov.bd'),
(4, 1, 'Rangamati', 'রাঙ্গামাটি', '22.65561018', '92.17541121', 'www.rangamati.gov.bd'),
(5, 1, 'Noakhali', 'নোয়াখালী', '22.869563', '91.099398', 'www.noakhali.gov.bd'),
(6, 1, 'Chandpur', 'চাঁদপুর', '23.2332585', '90.6712912', 'www.chandpur.gov.bd'),
(7, 1, 'Lakshmipur', 'লক্ষ্মীপুর', '22.942477', '90.841184', 'www.lakshmipur.gov.bd'),
(8, 1, 'Chattogram', 'চট্টগ্রাম', '22.335109', '91.834073', 'www.chittagong.gov.bd'),
(9, 1, 'Coxsbazar', 'কক্সবাজার', '21.44315751', '91.97381741', 'www.coxsbazar.gov.bd'),
(10, 1, 'Khagrachhari', 'খাগড়াছড়ি', '23.119285', '91.984663', 'www.khagrachhari.gov.bd'),
(11, 1, 'Bandarban', 'বান্দরবান', '22.1953275', '92.2183773', 'www.bandarban.gov.bd'),
(12, 2, 'Sirajganj', 'সিরাজগঞ্জ', '24.4533978', '89.7006815', 'www.sirajganj.gov.bd'),
(13, 2, 'Pabna', 'পাবনা', '23.998524', '89.233645', 'www.pabna.gov.bd'),
(14, 2, 'Bogura', 'বগুড়া', '24.8465228', '89.377755', 'www.bogra.gov.bd'),
(15, 2, 'Rajshahi', 'রাজশাহী', '24.37230298', '88.56307623', 'www.rajshahi.gov.bd'),
(16, 2, 'Natore', 'নাটোর', '24.420556', '89.000282', 'www.natore.gov.bd'),
(17, 2, 'Joypurhat', 'জয়পুরহাট', '25.09636876', '89.04004280', 'www.joypurhat.gov.bd'),
(18, 2, 'Chapainawabganj', 'চাঁপাইনবাবগঞ্জ', '24.5965034', '88.2775122', 'www.chapainawabganj.gov.bd'),
(19, 2, 'Naogaon', 'নওগাঁ', '24.83256191', '88.92485205', 'www.naogaon.gov.bd'),
(20, 3, 'Jashore', 'যশোর', '23.16643', '89.2081126', 'www.jessore.gov.bd'),
(21, 3, 'Satkhira', 'সাতক্ষীরা', '22.7180905', '89.0687033', 'www.satkhira.gov.bd'),
(22, 3, 'Meherpur', 'মেহেরপুর', '23.762213', '88.631821', 'www.meherpur.gov.bd'),
(23, 3, 'Narail', 'নড়াইল', '23.172534', '89.512672', 'www.narail.gov.bd'),
(24, 3, 'Chuadanga', 'চুয়াডাঙ্গা', '23.6401961', '88.841841', 'www.chuadanga.gov.bd'),
(25, 3, 'Kushtia', 'কুষ্টিয়া', '23.901258', '89.120482', 'www.kushtia.gov.bd'),
(26, 3, 'Magura', 'মাগুরা', '23.487337', '89.419956', 'www.magura.gov.bd'),
(27, 3, 'Khulna', 'খুলনা', '22.815774', '89.568679', 'www.khulna.gov.bd'),
(28, 3, 'Bagerhat', 'বাগেরহাট', '22.651568', '89.785938', 'www.bagerhat.gov.bd'),
(29, 3, 'Jhenaidah', 'ঝিনাইদহ', '23.5448176', '89.1539213', 'www.jhenaidah.gov.bd'),
(30, 4, 'Jhalakathi', 'ঝালকাঠি', '22.6422689', '90.2003932', 'www.jhalakathi.gov.bd'),
(31, 4, 'Patuakhali', 'পটুয়াখালী', '22.3596316', '90.3298712', 'www.patuakhali.gov.bd'),
(32, 4, 'Pirojpur', 'পিরোজপুর', '22.5781398', '89.9983909', 'www.pirojpur.gov.bd'),
(33, 4, 'Barisal', 'বরিশাল', '22.7004179', '90.3731568', 'www.barisal.gov.bd'),
(34, 4, 'Bhola', 'ভোলা', '22.685923', '90.648179', 'www.bhola.gov.bd'),
(35, 4, 'Barguna', 'বরগুনা', '22.159182', '90.125581', 'www.barguna.gov.bd'),
(36, 5, 'Sylhet', 'সিলেট', '24.8897956', '91.8697894', 'www.sylhet.gov.bd'),
(37, 5, 'Moulvibazar', 'মৌলভীবাজার', '24.482934', '91.777417', 'www.moulvibazar.gov.bd'),
(38, 5, 'Habiganj', 'হবিগঞ্জ', '24.374945', '91.41553', 'www.habiganj.gov.bd'),
(39, 5, 'Sunamganj', 'সুনামগঞ্জ', '25.0658042', '91.3950115', 'www.sunamganj.gov.bd'),
(40, 6, 'Narsingdi', 'নরসিংদী', '23.932233', '90.71541', 'www.narsingdi.gov.bd'),
(41, 6, 'Gazipur', 'গাজীপুর', '24.0022858', '90.4264283', 'www.gazipur.gov.bd'),
(42, 6, 'Shariatpur', 'শরীয়তপুর', '23.2060195', '90.3477725', 'www.shariatpur.gov.bd'),
(43, 6, 'Narayanganj', 'নারায়ণগঞ্জ', '23.63366', '90.496482', 'www.narayanganj.gov.bd'),
(44, 6, 'Tangail', 'টাঙ্গাইল', '24.264145', '89.918029', 'www.tangail.gov.bd'),
(45, 6, 'Kishoreganj', 'কিশোরগঞ্জ', '24.444937', '90.776575', 'www.kishoreganj.gov.bd'),
(46, 6, 'Manikganj', 'মানিকগঞ্জ', '23.8602262', '90.0018293', 'www.manikganj.gov.bd'),
(47, 6, 'Dhaka', 'ঢাকা', '23.7115253', '90.4111451', 'www.dhaka.gov.bd'),
(48, 6, 'Munshiganj', 'মুন্সিগঞ্জ', '23.5435742', '90.5354327', 'www.munshiganj.gov.bd'),
(49, 6, 'Rajbari', 'রাজবাড়ী', '23.7574305', '89.6444665', 'www.rajbari.gov.bd'),
(50, 6, 'Madaripur', 'মাদারীপুর', '23.164102', '90.1896805', 'www.madaripur.gov.bd'),
(51, 6, 'Gopalganj', 'গোপালগঞ্জ', '23.0050857', '89.8266059', 'www.gopalganj.gov.bd'),
(52, 6, 'Faridpur', 'ফরিদপুর', '23.6070822', '89.8429406', 'www.faridpur.gov.bd'),
(53, 7, 'Panchagarh', 'পঞ্চগড়', '26.3411', '88.5541606', 'www.panchagarh.gov.bd'),
(54, 7, 'Dinajpur', 'দিনাজপুর', '25.6217061', '88.6354504', 'www.dinajpur.gov.bd'),
(55, 7, 'Lalmonirhat', 'লালমনিরহাট', '25.9165451', '89.4532409', 'www.lalmonirhat.gov.bd'),
(56, 7, 'Nilphamari', 'নীলফামারী', '25.931794', '88.856006', 'www.nilphamari.gov.bd'),
(57, 7, 'Gaibandha', 'গাইবান্ধা', '25.328751', '89.528088', 'www.gaibandha.gov.bd'),
(58, 7, 'Thakurgaon', 'ঠাকুরগাঁও', '26.0336945', '88.4616834', 'www.thakurgaon.gov.bd'),
(59, 7, 'Rangpur', 'রংপুর', '25.7558096', '89.244462', 'www.rangpur.gov.bd'),
(60, 7, 'Kurigram', 'কুড়িগ্রাম', '25.805445', '89.636174', 'www.kurigram.gov.bd'),
(61, 8, 'Sherpur', 'শেরপুর', '25.0204933', '90.0152966', 'www.sherpur.gov.bd'),
(62, 8, 'Mymensingh', 'ময়মনসিংহ', '24.7465670', '90.4072093', 'www.mymensingh.gov.bd'),
(63, 8, 'Jamalpur', 'জামালপুর', '24.937533', '89.937775', 'www.jamalpur.gov.bd'),
(64, 8, 'Netrokona', 'নেত্রকোণা', '24.870955', '90.727887', 'www.netrokona.gov.bd');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `imgType` varchar(5) NOT NULL,
  `image` varchar(255) NOT NULL,
  `imgName` varchar(255) NOT NULL,
  `imgDesc` varchar(255) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `imgType`, `image`, `imgName`, `imgDesc`, `status`) VALUES
(4, 'SL', 'img_67e44a83414858.56217708.jpg', 'banner-1', 'dffsddvdsv', 'I');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `userId`, `productId`, `quantity`, `orderDate`, `orderId`, `orderStatus`) VALUES
(147, 10, '28', 1, '2021-01-27 10:16:42', 'ORD8626', 'Print'),
(149, 10, '29', 1, '2021-01-27 10:22:39', 'ORD6337', 'N'),
(150, 10, '27', 1, '2021-01-27 11:14:51', 'ORD9806', 'Print'),
(151, 10, '36', 1, '2021-01-27 11:14:51', 'ORD9806', 'Print'),
(152, 10, '28', 1, '2021-01-28 11:05:14', 'ORD7899', 'N'),
(153, 10, '36', 1, '2021-01-28 11:05:54', 'ORD9316', 'N'),
(154, 10, '37', 1, '2021-01-28 13:49:09', 'ORD549', 'N'),
(155, 10, '27', 1, '2021-01-30 21:05:13', 'ORD4714', 'Completed'),
(156, 10, '29', 1, '2021-02-02 00:54:16', 'ORD889', 'N'),
(157, 10, '29', 1, '2021-02-03 23:52:51', 'ORD4398', 'N'),
(158, 14, '29', 1, '2021-02-12 04:17:36', 'ORD8019', 'On The Way'),
(159, 14, '31', 1, '2021-02-12 04:17:36', 'ORD8019', 'On The Way'),
(160, 14, '32', 1, '2021-02-12 04:33:01', 'ORD4649', 'Completed'),
(161, 14, '34', 1, '2021-02-12 04:34:26', 'ORD7208', 'Completed'),
(162, 14, '42', 1, '2021-02-12 04:34:26', 'ORD7208', 'Completed'),
(163, 14, '28', 1, '2021-02-12 04:36:59', 'ORD4064', 'Delivered Process'),
(164, 14, '35', 1, '2021-02-12 04:36:59', 'ORD4064', 'Delivered Process'),
(165, 14, '40', 1, '2021-02-12 04:36:59', 'ORD4064', 'Delivered Process'),
(166, 10, '27', 1, '2021-02-13 10:23:03', 'ORD6656 ', 'Delivered Process'),
(167, 10, '30', 1, '2021-02-13 10:23:03', 'ORD6656', 'Delivered Process'),
(168, 10, '31', 2, '2021-02-13 10:23:03', 'ORD6656', 'Delivered Process'),
(169, 10, '39', 1, '2021-02-13 10:23:03', 'ORD6656', 'Delivered Process'),
(170, 10, '40', 2, '2021-02-13 10:23:03', 'ORD6656', 'Delivered Process'),
(171, 14, '29', 1, '2021-02-17 10:34:21', 'ORD7497', 'Completed'),
(172, 14, '33', 5, '2021-02-17 10:34:21', 'ORD7497', 'Completed'),
(173, 14, '35', 1, '2021-02-17 10:34:21', 'ORD7497', 'Completed'),
(174, 21, '27', 3, '2021-02-19 04:03:38', 'ORD9574', 'Completed'),
(175, 21, '28', 1, '2021-02-19 04:03:38', 'ORD9574', 'Completed'),
(176, 21, '40', 1, '2021-02-19 04:03:38', 'ORD9574', 'Completed'),
(177, 22, '28', 1, '2021-02-19 04:12:54', 'ORD1418', 'Print'),
(178, 22, '34', 1, '2021-02-19 04:12:54', 'ORD1418', 'Print'),
(179, 22, '36', 4, '2021-02-19 04:12:54', 'ORD1418', 'Print'),
(180, 22, '40', 1, '2021-02-19 04:12:54', 'ORD1418', 'Print'),
(181, 1, '36', 1, '2021-02-19 04:15:25', 'ORD9818', 'N'),
(182, 1, '28', 1, '2021-02-19 04:18:57', 'ORD1290', 'N'),
(183, 23, '29', 1, '2021-02-19 05:15:28', 'ORD6402', 'Completed'),
(184, 1, '30', 1, '2021-02-19 05:22:51', 'ORD4589', 'N'),
(185, 1, '27', 1, '2021-02-19 10:52:50', 'ORD4660', 'N'),
(186, 1, '36', 3, '2021-02-19 10:52:50', 'ORD4660', 'N'),
(187, 1, '40', 4, '2021-02-19 10:52:50', 'ORD4660', 'N'),
(188, 1, '28', 1, '2021-02-19 11:14:11', 'ORD9988', 'N'),
(189, 1, '29', 1, '2021-02-19 11:14:11', 'ORD9988', 'N'),
(190, 1, '37', 1, '2021-02-19 11:14:11', 'ORD9988', 'N'),
(191, 23, '29', 1, '2021-02-19 12:41:24', 'ORD4345', 'Completed'),
(192, 1, '43', 1, '2021-02-20 05:47:53', 'ORD1010', 'N'),
(193, 24, '40', 1, '2021-02-21 00:14:52', 'ORD8766', 'Completed'),
(194, 24, '44', 2, '2021-02-21 00:14:52', 'ORD8766', 'Completed'),
(195, 23, '32', 1, '2021-02-21 00:27:32', 'ORD7620', 'Delivered Process'),
(196, 23, '43', 1, '2021-02-21 00:27:32', 'ORD7620', 'Delivered Process'),
(197, 23, '30', 1, '2021-02-21 00:27:55', 'ORD784', 'Completed'),
(198, 1, '27', 1, '2021-02-21 03:27:41', 'ORD3420', 'N'),
(199, 10, '27', 2, '2021-02-21 03:39:13', 'ORD1231', 'Completed'),
(200, 10, '28', 2, '2021-02-21 03:39:13', 'ORD1231', 'Completed'),
(201, 23, '31', 1, '2021-02-22 11:10:22', 'ORD1898', 'Completed'),
(202, 23, '39', 1, '2021-02-22 11:10:22', 'ORD1898', 'Completed'),
(203, 10, '40', 3, '2021-02-23 08:09:27', 'ORD2180', 'N'),
(204, 10, '27', 1, '2021-02-23 08:37:55', 'ORD6891', 'Completed'),
(205, 10, '30', 1, '2021-02-23 08:37:55', 'ORD6891', 'Completed'),
(206, 23, '49', 1, '2021-02-28 10:17:18', 'ORD4711', 'Delivered Process'),
(207, 23, '27', 1, '2021-03-02 11:00:52', 'ORD7050', 'Delivered Process'),
(208, 23, '40', 2, '2021-03-02 11:00:52', 'ORD7050', 'Delivered Process'),
(209, 23, '27', 1, '2021-03-08 01:26:09', 'ORD4272', 'N'),
(210, 23, '28', 1, '2021-03-08 01:26:09', 'ORD4272', 'N'),
(211, 23, '30', 2, '2021-03-08 01:26:09', 'ORD4272', 'N'),
(212, 23, '27', 3, '2021-03-08 19:26:10', 'ORD2153', 'Delivered Process'),
(213, 23, '40', 5, '2021-03-08 19:26:10', 'ORD2153', 'Delivered Process'),
(214, 23, '27', 1, '2021-03-14 09:42:39', 'ORD5349', 'In Process'),
(215, 23, '55', 1, '2021-03-14 09:42:39', 'ORD5349', 'In Process'),
(216, 23, '36', 2, '2021-03-15 10:05:29', 'ORD3147', 'Completed'),
(217, 23, '55', 1, '2021-03-15 10:05:29', 'ORD3147', 'Completed'),
(218, 23, '30', 1, '2021-03-18 10:04:14', 'ORD7738', 'Completed'),
(219, 23, '40', 1, '2021-03-18 10:04:14', 'ORD7738', 'Completed'),
(220, 23, '55', 3, '2021-03-18 10:04:14', 'ORD7738', 'Completed'),
(221, 23, '61', 1, '2021-03-31 22:52:38', 'ORD5799', 'In Process'),
(222, 23, '64', 1, '2021-03-31 22:52:38', 'ORD5799', 'In Process'),
(223, 26, '58', 2, '2021-04-03 23:02:19', 'ORD2624', 'N'),
(224, 26, '77', 1, '2021-04-03 23:02:19', 'ORD2624', 'N'),
(225, 23, '61', 1, '2021-04-08 21:59:46', 'ORD9803', 'In Process'),
(226, 23, '62', 1, '2021-04-08 21:59:46', 'ORD9803', 'In Process'),
(227, 23, '116', 1, '2021-04-08 21:59:46', 'ORD9803', 'In Process'),
(228, 23, '83', 1, '2021-04-14 22:36:54', 'ORD1388', 'N'),
(229, 23, '61', 1, '2021-04-14 22:38:10', 'ORD9457', 'N'),
(230, 23, '55', 1, '2021-04-14 22:41:49', 'ORD8549', 'In Process'),
(231, 23, '84', 1, '2021-04-14 22:41:49', 'ORD8549', 'In Process'),
(232, 23, '56', 1, '2021-04-16 04:23:39', 'ORD1319', 'In Process'),
(233, 23, '69', 1, '2021-04-16 04:23:39', 'ORD1319', 'In Process'),
(234, 4, '32', 2, '2021-04-17 21:29:36', 'ORD9974', 'N'),
(235, 23, '89', 1, '2021-04-23 07:40:17', 'ORD8378', 'N'),
(236, 23, '69', 1, '2021-05-22 06:04:14', 'ORD5880', 'N');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ordertrackhistory`
--

INSERT INTO `ordertrackhistory` (`id`, `orderId`, `status`, `remark`, `postingDate`) VALUES
(29, 'ORD8626', 'in Process', 'hi', '2021-01-27 10:30:42'),
(30, 'ORD8626', 'Delivered', 'Deliver within 24 hours.', '2021-01-27 11:07:00'),
(31, 'ORD9806', 'in Process', 'In Process', '2021-01-27 11:20:44'),
(32, 'ORD9806', 'Delivered', 'Delivered within 24 hours.', '2021-01-27 11:21:37'),
(33, 'ORD8626', 'Completed', 'Complete for Voucher', '2021-01-28 11:10:56'),
(34, 'ORD8626', 'Print', 'Product Delivered Within 24 Hours.', '2021-01-28 13:18:43'),
(35, 'ORD9806', 'Completed', 'hi', '2021-01-28 13:22:19'),
(36, 'ORD4714', 'In Process', 'hi', '2021-01-30 21:06:03'),
(37, 'ORD9806', 'Print', 'Product Delivered Within 24 Hours.', '2021-01-30 21:08:22'),
(38, 'ORD8019', 'On The Way', 'j', '2021-02-12 04:27:56'),
(39, 'ORD4649', 'In Process', 'kj', '2021-02-12 04:35:07'),
(40, 'ORD7208', 'Completed', 'j', '2021-02-12 04:35:23'),
(41, 'ORD4064', 'In Process', 'jghg', '2021-02-12 04:37:27'),
(42, 'ORD4064', 'Delivered Process', 'jhjj', '2021-02-12 04:38:24'),
(43, 'ORD4714', 'Completed', 'hlo', '2021-02-12 10:53:58'),
(44, 'ORD4714', 'Print', 'Product Delivered Within 24 Hours.', '2021-02-13 08:37:40'),
(45, 'ORD6656', 'In Process', 'hi', '2021-02-13 11:41:48'),
(46, 'ORD6656', 'Delivered Process', 'Hello', '2021-02-13 12:05:00'),
(47, 'ORD4714', 'Completed', 'hlo', '2021-02-17 10:30:38'),
(48, 'ORD7497', 'In Process', '10', '2021-02-17 10:36:13'),
(49, 'ORD7497', 'Completed', 'gh', '2021-02-17 10:38:48'),
(50, 'ORD4649', 'Completed', 'j', '2021-02-19 03:05:05'),
(51, 'ORD9574', 'Completed', '1', '2021-02-19 04:04:47'),
(52, 'ORD1418', 'Completed', 'jewel', '2021-02-19 04:13:53'),
(53, 'ORD1418', 'In Process', 'bnjm', '2021-02-19 04:14:59'),
(54, 'ORD1418', 'Completed', 'hgj', '2021-02-19 04:16:08'),
(55, 'ORD6402', 'In Process', 'ghf', '2021-02-19 05:16:18'),
(56, 'ORD6402', 'Delivered Process', 'rt', '2021-02-19 05:17:13'),
(57, 'ORD6402', 'Completed', 'dg', '2021-02-19 05:17:44'),
(58, 'ORD4345', 'In Process', 'fg', '2021-02-19 12:41:47'),
(59, 'ORD4345', 'Completed', 'à¦†à¦¸à¦¦', '2021-02-20 05:48:34'),
(60, 'ORD8766', 'Completed', 'f', '2021-02-21 00:17:50'),
(61, 'ORD7620', 'Delivered Process', 'fg', '2021-02-21 00:29:33'),
(62, 'ORD784', 'Completed', 'vcb', '2021-02-21 00:30:23'),
(63, 'ORD1231', 'In Process', 'hi', '2021-02-21 03:40:43'),
(64, 'ORD1898', 'In Process', 'g', '2021-02-22 11:10:53'),
(65, 'ORD6891', 'In Process', 'hello', '2021-02-23 08:47:26'),
(66, 'ORD1231', 'Completed', 'f', '2021-02-28 10:08:22'),
(67, 'ORD4711', 'Delivered Process', 'hfdgh', '2021-02-28 10:18:47'),
(68, 'ORD7050', 'Delivered Process', 'hgj', '2021-03-02 11:02:01'),
(69, 'ORD2153', 'In Process', 'dfg', '2021-03-08 19:28:11'),
(70, 'ORD2153', 'Delivered Process', 'let me know all', '2021-03-08 19:31:14'),
(71, 'ORD5349', 'In Process', 'for any requirment plz call', '2021-03-14 09:43:53'),
(72, 'ORD3147', 'Completed', 'ok', '2021-03-15 10:27:42'),
(73, 'ORD1898', 'Completed', 'ok', '2021-03-15 10:46:22'),
(74, 'ORD6891', 'Completed', 'k', '2021-03-15 10:46:47'),
(75, 'ORD7738', 'In Process', '5654', '2021-03-18 10:07:30'),
(76, 'ORD7738', 'Completed', '2545', '2021-03-18 10:08:23'),
(77, 'ORD5799', 'In Process', 'v', '2021-03-31 22:52:59'),
(78, 'ORD9803', 'In Process', 'x', '2021-04-08 22:00:12'),
(79, 'ORD8549', 'In Process', 'sdfg', '2021-04-14 22:44:22'),
(80, 'ORD1319', 'In Process', '12:30 del', '2021-04-16 04:24:33'),
(81, 'ORD1418', 'Print', 'Product Delivered Within 24 Hours.', '2021-04-17 23:43:21');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `policy`
--

CREATE TABLE `policy` (
  `id` int(11) NOT NULL,
  `policyName` varchar(30) NOT NULL,
  `dataToggle` varchar(50) NOT NULL,
  `description` varchar(1024) NOT NULL,
  `icon` varchar(30) DEFAULT NULL,
  `updationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `policy`
--

INSERT INTO `policy` (`id`, `policyName`, `dataToggle`, `description`, `icon`, `updationDate`) VALUES
(1, 'Seller Policy - বিক্রয় নীতি', 'selPolicy', 'Hello', 'fa-file-text', '2025-03-26 15:25:47'),
(2, 'Return Policy - রিটার্ন পলিসি', 'retPolicy', 'Hi', 'fa-mail-reply', '2025-03-07 11:54:33'),
(3, 'Support Policy - সমর্থন নীতি', 'supPolicy', 'Bangladesh is our mother land.', 'fa-support', '2025-03-26 15:23:47'),
(4, 'Coder Profile - কোডার প্রোফাইল', 'codProfile', 'Bangladesh is our Favorite Country.', 'fa-dashboard', '2025-03-26 15:25:59');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productreviews`
--

INSERT INTO `productreviews` (`id`, `productId`, `quality`, `price`, `value`, `name`, `summary`, `review`, `reviewDate`) VALUES
(5, 27, 1, 2, 4, 'saifur', 'hello', 'hi', '2021-01-18 11:16:57'),
(6, 27, 1, 2, 4, 'saifur', 'hello', 'hi', '2021-01-18 11:20:13'),
(7, 27, 1, 2, 4, 'saifur', 'hello', 'hi', '2021-01-18 11:20:58'),
(8, 27, 1, 2, 4, 'saifur', 'hello', 'hi', '2021-01-18 11:22:04'),
(9, 27, 1, 2, 4, 'saifur', 'hello', 'hi', '2021-01-18 11:22:52'),
(10, 27, 1, 2, 4, 'saifur', 'hello', 'hi', '2021-01-18 11:23:34'),
(11, 27, 1, 2, 4, 'saifur', 'hello', 'hi', '2021-01-18 11:25:14'),
(12, 27, 1, 2, 4, 'saifur', 'hello', 'hi', '2021-01-18 11:38:03'),
(13, 27, 1, 2, 4, 'saifur', 'hello', 'hi', '2021-01-18 11:40:55'),
(14, 27, 1, 2, 4, 'saifur', 'hello', 'hi', '2021-01-18 11:43:59'),
(15, 27, 1, 2, 4, 'saifur', 'hello', 'hi', '2021-01-18 11:44:32'),
(16, 33, 1, 2, 3, 'Mosharof', 'hello', 'hi', '2021-01-19 00:22:02');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `proCode` varchar(255) NOT NULL,
  `brSuId` int(11) NOT NULL,
  `catId` int(11) NOT NULL,
  `subCatId` int(11) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `productName_bn` varchar(255) NOT NULL,
  `productionProcess` varchar(255) NOT NULL,
  `whereFrom` int(11) NOT NULL,
  `size` varchar(10) NOT NULL,
  `color` varchar(10) NOT NULL,
  `discription` longtext DEFAULT NULL,
  `frontImg` varchar(255) DEFAULT NULL,
  `backImg` varchar(255) DEFAULT NULL,
  `leftImg` varchar(255) DEFAULT NULL,
  `rightImg` varchar(255) DEFAULT NULL,
  `status` varchar(5) DEFAULT NULL,
  `postingDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `proCode`, `brSuId`, `catId`, `subCatId`, `productName`, `productName_bn`, `productionProcess`, `whereFrom`, `size`, `color`, `discription`, `frontImg`, `backImg`, `leftImg`, `rightImg`, `status`, `postingDate`) VALUES
(2, 'PRO-143461475311112', 14, 3, 46, 'Turmeric Powder', 'হলুদ গুঁড়া', 'Hand Made', 13, 'ALL', 'ALL', 'hello', 'pro_67ec22b032e766.86979441.jpg', 'pro_67ec22b03335c0.53383620.jpg', 'pro_67ec22b03367c6.54358525.jpeg', 'pro_67ec22b0338b60.03119103.jpg', 'A', '2025-04-01 17:30:24');

-- --------------------------------------------------------

--
-- Table structure for table `size`
--

CREATE TABLE `size` (
  `id` int(11) NOT NULL,
  `sizeName` varchar(255) NOT NULL,
  `sizeType` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `size`
--

INSERT INTO `size` (`id`, `sizeName`, `sizeType`) VALUES
(1, 'All Size - সমস্ত আকার', 'ALL'),
(2, 'Small - ছোট', 'S'),
(3, 'Medium - মাঝারি', 'M'),
(4, 'Large - বড়', 'L'),
(5, 'X-Large - এক্সএল', 'XL'),
(6, 'XX-Large - ডাবল এক্সএল', 'XXL'),
(7, 'XXX-Large - ট্রিপল এক্সএল', 'XXXL');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `brSuId` int(11) NOT NULL,
  `catId` int(11) NOT NULL,
  `subCatId` int(11) NOT NULL,
  `proId` varchar(50) NOT NULL,
  `proCode` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `pack` varchar(100) NOT NULL,
  `buyingPri` decimal(10,2) NOT NULL,
  `sellingPri` decimal(10,2) NOT NULL,
  `couponCode` varchar(50) DEFAULT NULL,
  `startDate` date NOT NULL,
  `endDate` date DEFAULT NULL,
  `afterDisPri` decimal(10,2) DEFAULT NULL,
  `status` enum('A','I') DEFAULT NULL,
  `postingDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE `subcategory` (
  `id` int(11) NOT NULL,
  `catId` int(11) DEFAULT NULL,
  `subCatName` varchar(255) DEFAULT NULL,
  `subCatName_en` varchar(255) DEFAULT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`id`, `catId`, `subCatName`, `subCatName_en`, `creationDate`) VALUES
(46, 3, 'হলুদ', 'Turmeric', '2025-03-29 18:47:53'),
(47, 3, 'মরিচ', 'Pepper', '2025-03-29 18:48:23'),
(48, 3, 'ধনিয়া', 'Coriander', '2025-03-29 18:48:46'),
(49, 3, 'জিরা', 'Cereal', '2025-03-29 18:49:17'),
(50, 3, 'মসলা', 'Spices', '2025-03-29 18:50:05'),
(51, 7, 'তেল', 'oil', '2025-03-29 18:51:37'),
(52, 7, 'সেমাই', 'Vermicelli', '2025-03-29 18:52:17'),
(53, 7, 'চাল', 'Rice', '2025-03-29 18:53:09'),
(54, 5, 'চানাচুর', 'Chanachur', '2025-03-29 18:54:30'),
(55, 5, 'ভাজা', 'Fried', '2025-03-29 18:55:29'),
(56, 5, 'চিপস', 'Chips', '2025-03-29 18:56:13'),
(57, 5, 'চাটনী', 'Chutney', '2025-03-29 18:57:05'),
(58, 5, 'নুডলস', 'Noodles', '2025-03-29 18:57:59'),
(59, 5, 'মিক্সড', 'Mixed', '2025-03-29 18:58:24'),
(60, 5, 'ড্রিংক', 'Drink', '2025-03-29 18:59:05');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `supId` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name_bn` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `compName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `address` text DEFAULT NULL,
  `contactNo` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `totalBuy` float(15,2) NOT NULL DEFAULT 0.00,
  `totalPaid` float(15,2) NOT NULL DEFAULT 0.00,
  `totalDue` float(15,2) NOT NULL DEFAULT 0.00,
  `regDate` timestamp NULL DEFAULT current_timestamp(),
  `suppImg` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `updateDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `supId`, `name`, `name_bn`, `compName`, `address`, `contactNo`, `email`, `totalBuy`, `totalPaid`, `totalDue`, `regDate`, `suppImg`, `status`, `updateDate`) VALUES
(8, 'SU-11111', 'saifur', 'সাইফুর', 'era', 'rtedff', '01829041699', 'addsds', 0.00, 0.00, 0.00, '2025-03-29 04:29:22', 'user_67e77722044956.84442745.jpg', 'A', '2025-03-29 04:29:22');

-- --------------------------------------------------------

--
-- Table structure for table `userlog`
--

CREATE TABLE `userlog` (
  `id` int(11) NOT NULL,
  `userName` varchar(255) DEFAULT NULL,
  `userEmail` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `contactNo` varchar(11) DEFAULT NULL,
  `userIp` binary(16) DEFAULT NULL,
  `logonTime` timestamp NULL DEFAULT current_timestamp(),
  `logoutTime` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `userlog`
--

INSERT INTO `userlog` (`id`, `userName`, `userEmail`, `password`, `contactNo`, `userIp`, `logonTime`, `logoutTime`, `status`) VALUES
(22, 'admin', NULL, '9ea986c4fa3eb4b4a4d7430db8734468', '1540505646', 0x3132372e302e302e3100000000000000, '2025-03-26 17:45:13', '2025-03-27 04:45:29', 0),
(23, 'admin', NULL, '9ea986c4fa3eb4b4a4d7430db8734468', '1540505646', 0x3132372e302e302e3100000000000000, '2025-03-26 17:46:53', '2025-03-27 15:45:37', 0),
(25, 'admin', NULL, '9ea986c4fa3eb4b4a4d7430db8734468', '1540505646', 0x3132372e302e302e3100000000000000, '2025-03-29 04:04:31', '2025-03-29 16:38:20', 0),
(26, 'saifur', 'saifur@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '01829041699', 0x3132372e302e302e3100000000000000, '2025-03-29 05:38:42', '2025-03-29 16:39:42', 0),
(27, 'admin', NULL, '9ea986c4fa3eb4b4a4d7430db8734468', '1540505646', 0x3132372e302e302e3100000000000000, '2025-03-29 05:40:01', NULL, 1),
(28, 'admin', NULL, '9ea986c4fa3eb4b4a4d7430db8734468', '1540505646', 0x3132372e302e302e3100000000000000, '2025-03-29 07:38:40', '2025-03-29 23:48:26', 0),
(29, 'sumaiya', 'sumaiya@gmail.com', '1a100d2c0dab19c4430e7d73762b3423', '01810547599', 0x3132372e302e302e3100000000000000, '2025-03-29 12:48:36', NULL, 1),
(30, 'admin', NULL, '9ea986c4fa3eb4b4a4d7430db8734468', '1540505646', 0x3132372e302e302e3100000000000000, '2025-03-31 09:55:31', NULL, 1),
(31, 'admin', NULL, '9ea986c4fa3eb4b4a4d7430db8734468', '1540505646', 0x3a3a3100000000000000000000000000, '2025-04-01 13:01:07', NULL, 1),
(32, 'admin', NULL, '9ea986c4fa3eb4b4a4d7430db8734468', '1540505646', 0x3a3a3100000000000000000000000000, '2025-04-02 12:34:27', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `name_bn` varchar(255) DEFAULT NULL,
  `status` varchar(3) DEFAULT NULL,
  `return` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `name_bn`, `status`, `return`) VALUES
(1, 'User', 'ব্যবহারকারী', 'A', 'usr'),
(2, 'Supplier', 'সরবরাহকারী', 'A', 'sup'),
(3, 'Customer', 'গ্রাহক', 'A', 'cus'),
(4, 'Delivery Man', 'ডেলিভারি ম্যান', 'A', 'dem');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `productId` int(11) DEFAULT NULL,
  `postingDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `userId`, `productId`, `postingDate`) VALUES
(4, 7, 27, '2021-01-11 06:34:28');

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
-- Indexes for table `brands`
--
ALTER TABLE `brands`
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
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cusupdeli`
--
ALTER TABLE `cusupdeli`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
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
-- Indexes for table `policy`
--
ALTER TABLE `policy`
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
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `color`
--
ALTER TABLE `color`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `coupon`
--
ALTER TABLE `coupon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cusupdeli`
--
ALTER TABLE `cusupdeli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=237;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `policy`
--
ALTER TABLE `policy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `productreviews`
--
ALTER TABLE `productreviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `size`
--
ALTER TABLE `size`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `userlog`
--
ALTER TABLE `userlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
