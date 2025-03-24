-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 22, 2025 at 08:05 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
  `updationDate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `creationDate`, `updationDate`) VALUES
(1, 'admin', '9ea986c4fa3eb4b4a4d7430db8734468', '2017-01-24 10:21:18', '02-04-2021 04:12:23 PM');

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `bannerName` varchar(100) NOT NULL,
  `bannerType` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `bannerName`, `bannerType`) VALUES
(1, 'Slider', 'SL'),
(2, 'After Slider', 'AS'),
(3, 'After Product', 'AP'),
(4, 'Others', 'OT');

-- --------------------------------------------------------

--
-- Table structure for table `basic`
--

CREATE TABLE `basic` (
  `id` int(11) NOT NULL,
  `compName` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `compDescription` longtext CHARACTER SET utf8mb4 NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `phone1` varchar(25) CHARACTER SET utf8mb4 NOT NULL,
  `phone2` varchar(25) CHARACTER SET utf8mb4 NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `currency` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `facebook` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `twitter` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `linkedin` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `updationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `basic`
--

INSERT INTO `basic` (`id`, `compName`, `compDescription`, `address`, `phone1`, `phone2`, `email`, `logo`, `currency`, `facebook`, `twitter`, `linkedin`, `updationDate`) VALUES
(1, 'Coder Mart Ltd', '<br>', '10/A-3, Bardhan Bari, Darus Salam, Mirpur-1, Dhaka.', '01540505646', '', 'info@ecodermart.com', 'logo.png', 'tk.png', '', '', '', '2020-12-16 10:13:36');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `brandsName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brandsName_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brandsImage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `cashoffpayment`
--

CREATE TABLE `cashoffpayment` (
  `id` int(11) NOT NULL,
  `cashoff` int(11) NOT NULL,
  `status` varchar(30) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `value` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cashoffpayment`
--

INSERT INTO `cashoffpayment` (`id`, `cashoff`, `status`, `creation_date`, `value`) VALUES
(1, 50, 'Active', '2021-01-20 19:59:49', 0.5);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `catName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catName_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catImage` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `catName`, `catName_en`, `catImage`, `creationDate`) VALUES
(2, 'ফল এবং হিমায়িত', 'Fruits & Frozen', 'category_67cdbeb3089d99.55568847.jpg', '2025-03-09 16:15:47'),
(3, 'রান্নার উপকরণ', 'Cooking Ingredients', 'category_67cdc41c8ec2b2.30608349.jpg', '2025-03-09 16:38:52'),
(4, 'চকোলেট এবং ক্যান্ডি', 'Chocolates & Candy', 'category_67cdc43acdded7.36163599.jpg', '2025-03-09 16:39:22'),
(5, 'স্ন্যাকস এবং পানীয়', 'Snacks & Beverages', 'category_67cdc4535c4a08.08438858.JPG', '2025-03-09 16:39:47');

-- --------------------------------------------------------

--
-- Table structure for table `color`
--

CREATE TABLE `color` (
  `id` int(11) NOT NULL,
  `colorName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `colorType` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `shortCurrency` varchar(10) NOT NULL,
  `curName_bn` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `curName`, `shortCurrency`, `curName_bn`) VALUES
(1, 'BDT', 'Tk', ''),
(2, 'Rupee', 'Rs', '');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `imagesName` varchar(255) NOT NULL,
  `images` varchar(255) NOT NULL,
  `buttonName` varchar(50) NOT NULL,
  `imageSelect` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `modal`
--

CREATE TABLE `modal` (
  `id` int(11) NOT NULL,
  `modalName` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dataToggle` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `icon` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modal`
--

INSERT INTO `modal` (`id`, `modalName`, `dataToggle`, `description`, `creationDate`, `icon`) VALUES
(1, 'Seller Policy - বিক্রয় নীতি', 'sellPolicy', 'Hello', '2025-03-07 17:54:33', 'fa-file-text'),
(2, 'Return Policy - রিটার্ন পলিসি', 'retPolicy', 'Hi', '2025-03-07 17:16:08', 'fa-mail-reply'),
(3, 'Support Policy - সমর্থন নীতি', 'supPolicy', 'Bangladesh', '2025-03-07 17:15:49', 'fa-support'),
(4, 'Coder Profile - কোডার প্রোফাইল', 'myProfile', 'Country', '2025-03-07 17:16:20', 'fa-dashboard');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `orderId` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `brand` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `subCategory` int(11) NOT NULL,
  `productName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `productionProcess` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `whereFrom` int(11) NOT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `productPrice` int(11) NOT NULL,
  `priceOffPercent` int(11) NOT NULL,
  `priceAfterDiscount` int(11) NOT NULL,
  `cashback` int(11) NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shippingCharge` int(11) DEFAULT NULL,
  `availability` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `productImage1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `productImage2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `productImage3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postingDate` timestamp NULL DEFAULT current_timestamp(),
  `updationDate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `brand`, `category`, `subCategory`, `productName`, `productionProcess`, `whereFrom`, `size`, `color`, `productPrice`, `priceOffPercent`, `priceAfterDiscount`, `cashback`, `description`, `shippingCharge`, `availability`, `productImage1`, `productImage2`, `productImage3`, `postingDate`, `updationDate`) VALUES
(1, 16, 1, 40, 'স্পেশাল চানাচুর', 'SAWDA', 3, '220gm - ২২০গ্রাম', '11', 30, 5, 29, 2, 'dddd', 3, 'in', '1231.jpg', 'chef.jpg', 'dates.png', '2025-03-07 19:17:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `size`
--

CREATE TABLE `size` (
  `id` int(11) NOT NULL,
  `sizeName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sizeType` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `size`
--

INSERT INTO `size` (`id`, `sizeName`, `sizeType`) VALUES
(1, 'All Size - সমস্ত আকার', 'A'),
(2, 'Small - ছোট', 'S'),
(3, 'Medium - মাঝারি', 'M'),
(4, 'Large - বড়', 'L'),
(5, 'X-Large - এক্সএল', 'XL'),
(6, 'XX-Large - ডাবল এক্সএল', 'XXL'),
(7, 'XXX-Large - ট্রিপল এক্সএল', 'XXXL'),
(8, '50gm - ৫০গ্রাম', '50'),
(9, '100g - ১০০গ্রাম', '100'),
(10, '200g - ২০০গ্রাম', '200');

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE `subcategory` (
  `id` int(11) NOT NULL,
  `catId` int(11) DEFAULT NULL,
  `subCatName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subCatName_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`id`, `catId`, `subCatName`, `subCatName_en`, `creationDate`) VALUES
(40, 2, 'শুদ্ধ চানাচুর', 'Pure Chanachur', '2025-03-22 18:37:35'),
(41, 2, 'শুদ্ধ অ্যাংরি বাইট', 'Pure Angry Byte', '2025-03-22 18:37:39'),
(42, 2, 'শুদ্ধ কুড়মুড়ে', 'Pure kurmuru', '2025-03-22 18:37:42'),
(43, 2, 'শুদ্ধ পটেটো চিপস', 'Pure Potato Chips', '2025-03-22 18:37:45'),
(44, 2, 'শুদ্ধ ঝাল মুড়ি', 'Pure Jhal Muri', '2025-03-22 18:37:48'),
(45, 2, 'শুদ্ধ গ্রিন চিপস', 'Pure Green Chips', '2025-03-22 18:37:51');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `id` int(11) NOT NULL,
  `ticketName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ticketImg` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `userEmail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `userip` binary(16) DEFAULT NULL,
  `loginTime` timestamp NULL DEFAULT current_timestamp(),
  `logout` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `contactno` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `userlog`
--

INSERT INTO `userlog` (`id`, `userEmail`, `userip`, `loginTime`, `logout`, `status`, `contactno`) VALUES
(34, 'saifur1985bd@gmail.com', 0x3230332e37362e3135302e3133300000, '2021-01-10 19:37:10', NULL, 1, NULL),
(35, 'saifur1985bd@gmail.com', 0x3230332e37362e3135302e3133300000, '2021-01-11 01:22:06', '11-01-2021 12:53:14 PM', 1, NULL),
(36, 'jewel44250@hotmail.com', 0x3230332e37382e3134362e3235000000, '2021-01-11 05:53:08', NULL, 1, NULL),
(37, 'jewel44250@hotmail.com', 0x3130332e3233372e37362e3137300000, '2021-01-11 06:12:13', NULL, 0, NULL),
(38, 'jewel44250@hotmail.com', 0x3130332e3233372e37362e3137300000, '2021-01-11 06:13:28', NULL, 1, NULL),
(39, 'mithumosharof@hmail.com', 0x3139322e3134302e3235332e32330000, '2021-01-11 06:31:18', NULL, 0, NULL),
(40, 'mithumosharof@gmail.com', 0x3139322e3134302e3235332e32330000, '2021-01-11 06:31:49', NULL, 0, NULL),
(41, 'mithumosharof@gmail.com', 0x3139322e3134302e3235332e32330000, '2021-01-11 06:32:47', NULL, 1, NULL),
(42, 'jewel44250@hotmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-11 09:35:19', NULL, 0, NULL),
(43, 'jewel44250@hotmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-11 09:35:35', '11-01-2021 09:12:43 PM', 1, NULL),
(44, 'Khsazzad012@gmail.com', 0x34352e3131342e38362e323032000000, '2021-01-11 09:46:01', NULL, 1, NULL),
(45, 'jewel44250@hotmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-11 09:47:29', NULL, 1, NULL),
(46, 'jewel44250@hotmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-12 09:06:50', NULL, 1, NULL),
(47, 'mithumosharof@gmail.com', 0x3139322e3134302e3235332e32320000, '2021-01-12 09:27:35', NULL, 0, NULL),
(48, 'mithumosharof@gmail.com', 0x3139322e3134302e3235332e32320000, '2021-01-12 09:28:58', NULL, 0, NULL),
(49, 'mithumosharof@gmail.com', 0x3139322e3134302e3235332e32320000, '2021-01-12 09:33:33', '12-01-2021 09:07:36 PM', 1, NULL),
(50, 'mithumosharof@gmail.com', 0x3139322e3134302e3235332e32320000, '2021-01-12 09:47:04', NULL, 1, NULL),
(51, 'jewel44250@hotmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-12 09:48:18', '12-01-2021 09:38:29 PM', 1, NULL),
(52, 'hossain@gmail.com', 0x3139322e3134302e3235332e32320000, '2021-01-12 10:54:07', NULL, 1, NULL),
(53, 'sudiptonandi09@gmail.com', 0x3230332e37382e3134372e3900000000, '2021-01-13 04:17:09', NULL, 1, NULL),
(54, 'jewel44250@hotmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-13 09:26:32', '13-01-2021 09:14:56 PM', 1, NULL),
(55, '01825133397', 0x3130332e3231302e31382e3537000000, '2021-01-13 11:07:58', '13-01-2021 10:42:29 PM', 1, NULL),
(56, 'saifurman018290@gmail.com', 0x3130332e3231302e31382e3537000000, '2021-01-13 11:12:46', '13-01-2021 10:53:00 PM', 1, NULL),
(57, '01825133397', 0x3130332e3231302e31382e3537000000, '2021-01-13 11:23:17', NULL, 1, NULL),
(58, '01825133397', 0x3230332e37362e3135302e3133300000, '2021-01-13 20:16:28', '14-01-2021 07:52:22 AM', 1, NULL),
(59, '01825133397', 0x3230332e37362e3135302e3133300000, '2021-01-13 20:25:59', '14-01-2021 07:56:58 AM', 1, NULL),
(60, '01912488994', 0x3130332e39352e3230382e3130000000, '2021-01-14 10:04:21', NULL, 0, NULL),
(61, '01912488994', 0x3130332e39352e3230382e3130000000, '2021-01-14 10:08:27', NULL, 1, NULL),
(62, 'jewel44250@hotmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-14 10:10:18', NULL, 0, NULL),
(63, 'jewel44250@hotmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-14 10:10:32', NULL, 0, NULL),
(64, 'jewel44250@hotmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-14 10:10:41', NULL, 0, NULL),
(65, 'engr.jewel55@gmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-14 10:17:55', NULL, 0, NULL),
(66, 'engr.jewel55@gmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-14 10:18:44', NULL, 0, NULL),
(67, 'engr.jewel55@gmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-14 10:19:33', NULL, 0, NULL),
(68, 'engr.jewel55@gmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-14 10:19:55', NULL, 0, NULL),
(69, 'engr.jewel55@gmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-14 10:20:41', NULL, 0, NULL),
(70, 'momo@gmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-14 10:23:04', NULL, 0, NULL),
(71, 'momo@gmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-14 10:23:56', NULL, 0, NULL),
(72, 'jewel44250@hotmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-14 10:30:29', NULL, 0, NULL),
(73, 'jewel44250@hotmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-14 10:30:43', NULL, 0, NULL),
(74, 'jewel44250@hotmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-14 10:30:53', NULL, 0, NULL),
(75, 'jewel44250@hotmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-14 11:28:44', NULL, 0, NULL),
(76, 'engrmisharof.cse@gnail.com', 0x3230332e37382e3134352e3700000000, '2021-01-14 11:29:17', NULL, 0, NULL),
(77, 'engrmisharof.cse@gnail.com', 0x3230332e37382e3134362e3235000000, '2021-01-14 21:39:15', NULL, 0, NULL),
(78, 'engrmosharof.cse@gmail.com', 0x3230332e37382e3134362e3235000000, '2021-01-15 01:55:18', NULL, 0, NULL),
(79, 'jewel44250@hotmail.com', 0x3230332e37382e3134362e3235000000, '2021-01-15 01:55:29', NULL, 0, NULL),
(80, 'engrmisharof.cse@gnail.com', 0x3230332e37382e3134362e3136000000, '2021-01-15 07:18:27', NULL, 0, NULL),
(81, '01719619800', 0x3230332e37382e3134362e3136000000, '2021-01-15 07:25:57', NULL, 1, NULL),
(82, 'jewel44250@hotmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-15 11:15:03', NULL, 0, NULL),
(83, 'engrmosharof.cse@gmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-15 11:15:18', NULL, 0, NULL),
(84, 'jewel44250@hotmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-15 11:17:01', NULL, 0, NULL),
(85, 'engrmosharof.cse@gmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-15 11:17:38', NULL, 0, NULL),
(86, 'engrmosharof.cse@gmail.com', 0x3230332e37382e3134352e3700000000, '2021-01-15 11:17:49', NULL, 0, NULL),
(87, 'engrmisharof.cse@gnail.com', 0x3230332e37382e3134352e3700000000, '2021-01-15 11:21:59', NULL, 0, NULL),
(88, 'mithu', 0x3139322e3134302e3235332e32310000, '2021-01-15 11:24:26', NULL, 0, NULL),
(89, '01722276090', 0x3139322e3134302e3235332e32310000, '2021-01-15 11:24:41', NULL, 0, NULL),
(90, '01722276090', 0x3139322e3134302e3235332e32310000, '2021-01-15 11:25:26', '15-01-2021 11:16:11 PM', 1, NULL),
(91, '01712446623', 0x3230332e37382e3134352e3700000000, '2021-01-15 11:36:59', NULL, 1, NULL),
(92, 'admin', 0x3139322e3134302e3235332e32310000, '2021-01-15 11:46:29', NULL, 0, NULL),
(93, 'admin', 0x3139322e3134302e3235332e32310000, '2021-01-15 11:47:13', NULL, 0, NULL),
(94, 'admin', 0x3139322e3134302e3235332e32310000, '2021-01-15 11:47:46', NULL, 0, NULL),
(95, '01712446623', 0x3130332e37382e3232352e3600000000, '2021-01-16 00:14:56', NULL, 1, NULL),
(96, '01712446623', 0x33372e3131312e3139392e3739000000, '2021-01-16 06:10:41', NULL, 0, NULL),
(97, '01712446623', 0x33372e3131312e3139392e3739000000, '2021-01-16 06:11:08', '16-01-2021 05:55:57 PM', 1, NULL),
(98, '01712446623', 0x33372e3131312e3139392e3739000000, '2021-01-16 06:26:20', NULL, 0, NULL),
(99, '01712446623', 0x33372e3131312e3139392e3739000000, '2021-01-16 06:26:35', NULL, 0, NULL),
(100, '01712446623', 0x33372e3131312e3139392e3739000000, '2021-01-16 06:26:48', '16-01-2021 05:57:43 PM', 1, NULL),
(101, '01712446623', 0x33372e3131312e3139392e3739000000, '2021-01-16 06:28:03', NULL, 0, NULL),
(102, '01712446623', 0x33372e3131312e3139392e3739000000, '2021-01-16 06:28:19', NULL, 1, NULL),
(103, '01825133397', 0x3130332e3231302e31382e3537000000, '2021-01-16 08:43:05', '16-01-2021 08:14:51 PM', 1, NULL),
(104, '01979041699', 0x3130332e3231302e31382e3537000000, '2021-01-16 08:45:12', NULL, 1, NULL),
(105, '01979041699', 0x3130332e3231302e31382e3537000000, '2021-01-16 10:23:37', '16-01-2021 10:04:05 PM', 1, NULL),
(106, '01979041699', 0x3130332e3231302e31382e3537000000, '2021-01-16 10:37:31', '16-01-2021 10:18:28 PM', 1, NULL),
(107, '01825133397', 0x3230332e37362e3135302e3133300000, '2021-01-17 20:33:23', '18-01-2021 08:10:52 AM', 1, NULL),
(108, '01825133397', 0x3230332e37362e3135302e3133300000, '2021-01-17 20:48:56', '18-01-2021 08:18:59 AM', 1, NULL),
(109, '01712446623', 0x3230332e37382e3134362e3235000000, '2021-01-18 01:51:29', NULL, 1, NULL),
(110, '01712446623', 0x3230332e37382e3134352e3700000000, '2021-01-18 09:46:31', NULL, 1, NULL),
(111, '', 0x3230332e37382e3134352e3600000000, '2021-01-18 11:12:29', '18-04-2021 05:11:59 PM', 0, NULL),
(112, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-20 10:32:17', NULL, 0, NULL),
(113, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-20 10:32:41', NULL, 0, NULL),
(114, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-20 10:39:08', NULL, 0, NULL),
(115, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-21 03:58:45', NULL, 0, NULL),
(116, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-21 03:58:58', NULL, 1, NULL),
(117, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-21 10:07:34', NULL, 1, NULL),
(118, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-21 12:36:33', NULL, 1, NULL),
(119, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-23 21:07:24', NULL, 1, NULL),
(120, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-24 01:21:38', NULL, 1, NULL),
(121, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-24 08:36:12', '24-01-2021 09:24:09 PM', 1, NULL),
(122, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-24 09:55:19', '24-01-2021 09:26:23 PM', 1, NULL),
(123, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-24 09:58:33', '24-01-2021 09:32:19 PM', 1, NULL),
(124, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-24 10:02:44', '24-01-2021 09:37:00 PM', 1, NULL),
(125, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-24 10:07:23', '24-01-2021 09:41:13 PM', 1, NULL),
(126, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-24 10:12:59', '24-01-2021 11:19:33 PM', 1, NULL),
(127, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-24 11:50:20', NULL, 1, NULL),
(128, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-24 12:07:30', NULL, 1, NULL),
(129, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-24 23:19:47', NULL, 1, NULL),
(130, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-25 08:51:45', '25-01-2021 08:24:15 PM', 1, NULL),
(131, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-25 08:59:01', '25-01-2021 08:36:17 PM', 1, NULL),
(132, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-25 09:06:35', NULL, 1, NULL),
(133, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-25 20:47:37', NULL, 1, NULL),
(134, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-26 02:10:03', '26-01-2021 01:48:03 PM', 1, NULL),
(135, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-26 02:29:48', '26-01-2021 03:08:13 PM', 1, NULL),
(136, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-26 03:38:28', NULL, 1, NULL),
(137, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-26 07:13:48', NULL, 1, NULL),
(138, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-26 08:18:56', '26-01-2021 08:25:23 PM', 1, NULL),
(139, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-26 08:58:11', '26-01-2021 09:06:09 PM', 1, NULL),
(140, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-26 09:37:59', '26-01-2021 09:44:04 PM', 1, NULL),
(141, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-26 21:28:18', NULL, 1, NULL),
(142, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-26 22:58:13', '27-01-2021 12:32:12 PM', 1, NULL),
(143, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-27 01:02:44', '27-01-2021 01:03:13 PM', 1, NULL),
(144, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-27 01:33:29', '27-01-2021 01:46:53 PM', 1, NULL),
(145, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-27 04:32:53', '27-01-2021 04:24:26 PM', 1, NULL),
(146, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-27 10:15:44', '27-01-2021 09:56:14 PM', 1, NULL),
(147, '01825133397', 0x3130332e3231302e31382e3136000000, '2021-01-27 11:14:09', NULL, 1, NULL),
(148, '01825133397', 0x3130332e3231302e31382e3630000000, '2021-01-28 11:04:05', '28-01-2021 10:41:57 PM', 1, NULL),
(149, '01825133397', 0x3130332e3231302e31382e3630000000, '2021-01-28 13:49:02', NULL, 1, NULL),
(150, '01825133397', 0x3230332e37362e3135302e3133300000, '2021-01-30 21:04:57', '31-01-2021 08:35:28 AM', 1, NULL),
(151, '01712446623', 0x3230332e37382e3134362e3138000000, '2021-01-31 01:04:34', NULL, 1, NULL),
(152, '01712446623', 0x3230332e37382e3134362e3138000000, '2021-02-01 23:31:28', NULL, 1, NULL),
(153, '01825133397', 0x3230332e37362e3135302e3133300000, '2021-02-02 00:53:49', NULL, 1, NULL),
(154, '01825133397', 0x3230332e37362e3135302e3133300000, '2021-02-02 02:31:50', '02-02-2021 02:02:20 PM', 1, NULL),
(155, '01825133397', 0x3230332e37362e3135302e3133300000, '2021-02-03 23:52:45', NULL, 1, NULL),
(156, '01716714663', 0x3130332e3134372e3136332e31343900, '2021-02-06 03:55:24', NULL, 1, NULL),
(157, '01716714663', 0x3230332e37382e3134362e3138000000, '2021-02-12 04:15:41', NULL, 0, NULL),
(158, '01712446623', 0x3230332e37382e3134362e3138000000, '2021-02-12 04:16:03', NULL, 1, NULL),
(159, '01712446623', 0x3230332e37382e3134362e3138000000, '2021-02-12 04:24:08', NULL, 1, NULL),
(160, '01712446623', 0x3230332e37382e3134352e3137000000, '2021-02-12 11:02:30', NULL, 1, NULL),
(161, '01825133397', 0x3130332e3231302e31382e3933000000, '2021-02-13 10:12:27', NULL, 0, NULL),
(162, '01825133397', 0x3130332e3231302e31382e3933000000, '2021-02-13 10:12:41', NULL, 0, NULL),
(163, '01825133397', 0x3130332e3231302e31382e3933000000, '2021-02-13 10:22:36', NULL, 0, NULL),
(164, '01825133397', 0x3130332e3231302e31382e3933000000, '2021-02-13 10:22:45', NULL, 0, NULL),
(165, '01825133397', 0x3130332e3231302e31382e3933000000, '2021-02-13 10:22:53', NULL, 1, NULL),
(166, '01712446623', 0x3230332e37382e3134352e3137000000, '2021-02-17 10:33:00', NULL, 1, NULL),
(167, '01712446623', 0x3230332e37382e3134362e3138000000, '2021-02-19 02:57:47', '19-02-2021 02:42:23 PM', 1, NULL),
(168, '01712446623', 0x3230332e37382e3134362e3138000000, '2021-02-19 03:12:41', NULL, 0, NULL),
(169, '01712446623', 0x3230332e37382e3134362e3138000000, '2021-02-19 04:01:56', NULL, 0, NULL),
(170, '01712446623', 0x3230332e37382e3134362e3138000000, '2021-02-19 04:02:40', '19-02-2021 03:39:42 PM', 1, NULL),
(171, '01712446623', 0x3230332e37382e3134362e3138000000, '2021-02-19 04:09:52', NULL, 0, NULL),
(172, '01712446623', 0x3230332e37382e3134362e3138000000, '2021-02-19 04:10:33', NULL, 1, NULL),
(173, '01716714663', 0x3230332e37382e3134362e3138000000, '2021-02-19 05:14:41', NULL, 1, NULL),
(174, '01716714663', 0x3230332e37382e3134352e3137000000, '2021-02-19 10:45:45', '19-02-2021 10:38:22 PM', 1, NULL),
(175, '01716714663', 0x3230332e37382e3134352e3137000000, '2021-02-19 11:08:46', NULL, 1, NULL),
(176, '01716714663', 0x3230332e37382e3134352e3137000000, '2021-02-19 11:22:34', NULL, 1, NULL),
(177, '01716714663', 0x3230332e37382e3134352e3137000000, '2021-02-19 12:41:00', NULL, 1, NULL),
(178, '01716714663', 0x3230332e37382e3134362e3138000000, '2021-02-20 05:08:18', NULL, 1, NULL),
(179, '01714928863', 0x3230332e37382e3134362e3138000000, '2021-02-21 00:09:05', '21-02-2021 11:46:02 AM', 1, NULL),
(180, '01714928863', 0x3230332e37382e3134362e3138000000, '2021-02-21 00:24:46', '21-02-2021 11:55:21 AM', 1, NULL),
(181, '01712446623', 0x3230332e37382e3134362e3138000000, '2021-02-21 00:25:35', NULL, 0, NULL),
(182, '01716714663', 0x3230332e37382e3134362e3138000000, '2021-02-21 00:25:51', '21-02-2021 12:03:26 PM', 1, NULL),
(183, '01714928863', 0x3230332e37382e3134362e3138000000, '2021-02-21 00:33:42', NULL, 1, NULL),
(184, '01825133397', 0x3130332e3231302e31382e3900000000, '2021-02-21 03:20:31', '21-02-2021 02:52:45 PM', 1, NULL),
(185, '01825133397', 0x3130332e3231302e31382e3900000000, '2021-02-21 03:24:50', '21-02-2021 03:03:33 PM', 1, NULL),
(186, '01825133397', 0x3130332e3231302e31382e3900000000, '2021-02-21 03:39:08', NULL, 1, NULL),
(187, '01825133397', 0x3230332e37362e3135302e3133300000, '2021-02-21 19:57:08', NULL, 1, NULL),
(188, '01716714663', 0x3230332e37382e3134352e3137000000, '2021-02-22 11:07:22', NULL, 1, NULL),
(189, '01825133397', 0x3230332e37362e3135302e3133300000, '2021-02-22 20:43:01', '23-02-2021 08:14:45 AM', 1, NULL),
(190, '01825133397', 0x3130332e3231302e31382e3833000000, '2021-02-23 08:08:59', '23-02-2021 07:40:06 PM', 1, NULL),
(191, '01825133397', 0x3130332e3231302e31382e3833000000, '2021-02-23 08:37:50', '23-02-2021 08:09:06 PM', 1, NULL),
(192, '01716714663', 0x3130332e37382e3232352e3600000000, '2021-02-24 05:08:09', '24-02-2021 04:41:32 PM', 1, NULL),
(193, '01825133397', 0x3130332e3231302e31382e3839000000, '2021-02-27 07:29:56', NULL, 1, NULL),
(194, '01825133397', 0x3130332e3231302e31382e3839000000, '2021-02-27 07:51:28', '27-02-2021 08:16:23 PM', 1, NULL),
(195, '01825133397', 0x3130332e3231302e31382e3839000000, '2021-02-27 09:05:49', NULL, 1, NULL),
(196, '01825133397', 0x3230332e37362e3135302e3133300000, '2021-02-27 19:45:58', '28-02-2021 07:18:53 AM', 1, NULL),
(197, '01825133397', 0x3230332e37362e3135302e3133300000, '2021-02-27 19:49:40', '28-02-2021 07:22:07 AM', 1, NULL),
(198, '01716714663', 0x3230332e37382e3134352e3137000000, '2021-02-28 10:09:20', NULL, 1, NULL),
(199, '01716714663', 0x3230332e37382e3134352e3137000000, '2021-02-28 10:11:36', NULL, 0, NULL),
(200, '01716714663', 0x3230332e37382e3134352e3137000000, '2021-02-28 10:11:52', NULL, 1, NULL),
(201, '01716714663', 0x3230332e37382e3134352e3137000000, '2021-03-02 10:59:17', NULL, 1, NULL),
(202, '01716714663', 0x3130332e3132302e3230322e39380000, '2021-03-08 01:23:35', NULL, 1, NULL),
(203, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-03-08 19:24:33', NULL, 1, NULL),
(204, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-03-14 09:06:40', NULL, 1, NULL),
(205, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-03-14 09:07:33', NULL, 1, NULL),
(206, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-03-14 09:08:10', NULL, 1, NULL),
(207, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-03-14 09:08:45', NULL, 1, NULL),
(208, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-03-14 09:09:23', NULL, 1, NULL),
(209, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-03-14 09:52:01', NULL, 1, NULL),
(210, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-03-15 10:01:32', NULL, 1, NULL),
(211, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-03-15 10:28:02', NULL, 1, NULL),
(212, '01825133397', 0x3130332e3231302e31382e3134000000, '2021-03-15 11:13:35', '15-03-2021 10:43:52 PM', 1, NULL),
(213, '01825133397', 0x3230332e37362e3135302e3133300000, '2021-03-15 19:46:05', '16-03-2021 07:16:59 AM', 1, NULL),
(214, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-03-18 10:02:13', NULL, 1, NULL),
(215, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-03-31 22:51:34', NULL, 1, NULL),
(216, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-03-31 22:53:22', '01-04-2021 10:44:52 AM', 1, NULL),
(217, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-03-31 23:15:08', '01-04-2021 10:45:42 AM', 1, NULL),
(218, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-03-31 23:15:55', NULL, 0, NULL),
(219, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-03-31 23:16:10', NULL, 0, NULL),
(220, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-03-31 23:16:23', NULL, 1, NULL),
(221, '01825133397', 0x3130332e3231302e31382e3130300000, '2021-04-02 04:04:31', '02-04-2021 03:35:31 PM', 1, NULL),
(222, '01825133397', 0x3130332e3231302e31382e3130300000, '2021-04-02 04:05:40', NULL, 0, NULL),
(223, '01825133397', 0x3130332e3231302e31382e3130300000, '2021-04-02 04:05:50', NULL, 1, NULL),
(224, '01825133397', 0x3130332e3231302e31382e3130300000, '2021-04-02 09:56:46', '02-04-2021 09:30:43 PM', 1, NULL),
(225, '01825133397', 0x3130332e3231302e31382e3130300000, '2021-04-02 10:00:55', '02-04-2021 09:32:04 PM', 1, NULL),
(226, '01825133397', 0x3130332e3231302e31382e3130300000, '2021-04-02 10:02:14', '02-04-2021 09:36:39 PM', 1, NULL),
(227, '01825133397', 0x3130332e3231302e31382e3130300000, '2021-04-02 10:06:53', '02-04-2021 10:41:43 PM', 1, NULL),
(228, '01938242406', 0x3130332e37382e3232352e3600000000, '2021-04-03 22:59:47', NULL, 1, NULL),
(229, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-04-06 11:04:44', NULL, 1, NULL),
(230, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-04-08 21:58:37', NULL, 1, NULL),
(231, 'admin', 0x3131392e33302e33322e393000000000, '2021-04-11 01:09:15', NULL, 0, NULL),
(232, '01716714663', 0x3131392e33302e33322e393000000000, '2021-04-11 01:09:46', NULL, 0, NULL),
(233, '01716714663', 0x3131392e33302e33322e393000000000, '2021-04-11 01:10:17', NULL, 1, NULL),
(234, '1825133397', 0x3130332e3231302e31382e3636000000, '2021-04-11 11:31:58', NULL, 0, NULL),
(235, '1825133397', 0x3130332e3231302e31382e3636000000, '2021-04-11 11:32:08', NULL, 0, NULL),
(236, '1825133397', 0x3130332e3231302e31382e3636000000, '2021-04-11 11:32:22', NULL, 0, NULL),
(237, '01825133397', 0x3130332e3231302e31382e3636000000, '2021-04-11 11:33:07', NULL, 0, NULL),
(238, 'admin', 0x3130332e3233372e37362e3137310000, '2021-04-13 23:57:34', NULL, 0, NULL),
(239, 'admin', 0x3130332e3233372e37362e3137310000, '2021-04-13 23:58:35', NULL, 0, NULL),
(240, '01716714663', 0x3130332e3233372e37362e3137310000, '2021-04-13 23:59:08', NULL, 1, NULL),
(241, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-04-14 22:33:25', NULL, 1, NULL),
(242, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-04-14 22:35:23', NULL, 1, NULL),
(243, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-04-16 04:22:51', NULL, 1, NULL),
(244, '01825133397', 0x3130332e3231302e31382e3330000000, '2021-04-17 21:21:11', NULL, 0, NULL),
(245, '01825133397', 0x3130332e3231302e31382e3330000000, '2021-04-17 21:21:24', NULL, 0, NULL),
(246, '01979041699', 0x3130332e3231302e31382e3330000000, '2021-04-17 21:28:56', '18-04-2021 11:15:35 AM', 1, NULL),
(247, '01979041699', 0x3130332e3231302e31382e3330000000, '2021-04-17 23:45:53', '18-04-2021 11:38:45 AM', 1, NULL),
(248, '01979041699', 0x3130332e3231302e31382e3330000000, '2021-04-18 03:50:12', NULL, 1, NULL),
(249, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-04-23 07:34:46', NULL, 1, NULL),
(250, '01992347656', 0x34332e3235302e38312e313537000000, '2021-04-26 02:12:32', NULL, 1, NULL),
(251, '01716714663', 0x34352e3132372e3234352e3135380000, '2021-05-22 06:03:03', NULL, 1, NULL),
(252, '', 0x3130332e3136372e31362e3236000000, '2021-05-29 09:54:13', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contactno` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billingAddress` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `regDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `updationDate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cashback` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `contactno`, `password`, `billingAddress`, `regDate`, `updationDate`, `cashback`) VALUES
(4, 'Saifur', 'saifur1985bd@gmail.com', '01979041699', '1b4801cd6c4e9ea787ce79e13c55684b', '10/A/3, Bardhan Bari, Ward-09, Mirpur-1', '2020-11-06 03:21:06', NULL, '500'),
(7, 'Mithu', 'mithumosharof@gmail.com', '172227609', 'e10adc3949ba59abbe56e057f20f883e', '144/B, Lake Circus, Kalabagan,Dhaka-1205', '2021-01-11 06:32:21', NULL, '300'),
(8, 'KH. Sazzad Hossain', 'Khsazzad012@gmail.com', '181760616', 'cdd8e7b06e3bcd38537a68606599c536', NULL, '2021-01-11 09:45:48', NULL, NULL),
(9, 'Hossain', 'hossain@gmail.com', '172227609', 'e10adc3949ba59abbe56e057f20f883e', '28, Bengal Center,Top Khana Road,Paltan, Dhaka-1000', '2021-01-12 10:53:50', NULL, NULL),
(10, 'sumaiya akter', 'saifurman018290@gmail.com', '01825133397', 'fcea920f7412b5da7be0cf42b8c93759', '10/A-3, Bardhan Bari, Darus Salam, Mirpur-1.Dhaka-1216.', '2021-01-12 21:00:12', '02-04-2021 09:36:05 PM', '30480.5'),
(11, 'Arif Hoque', 'saifur@erainfotechbd.com', '01671829050', '9ea986c4fa3eb4b4a4d7430db8734468', NULL, '2021-01-12 21:04:45', NULL, NULL),
(12, 'Sudipto Nandi(TTH)', 'sudiptonandi09@gmail.com', '01992347656', '0a958631e7fcbf81211df1b311143570', NULL, '2021-01-13 04:16:29', NULL, NULL),
(13, 'Tania Wadud', 'lubaba126619@gmail.com', '01912488994', '19637a4a43e3978a377a14e7c158ac51', NULL, '2021-01-14 10:05:24', NULL, NULL),
(17, 'Abesh ', 'muminulabesh505@gmail.com', '01719619800', '6ddb8d10f28f7c57357adc8ba4028f38', '508/3a , west shewrapara ,  mirpur , dhaka-1216', '2021-01-15 07:25:33', NULL, NULL),
(19, 'Ami juel sir er baba discount dao(TTH)ðŸ˜‚ðŸ˜‚  ', 'sudiptonandi2@gmail.com', '01992347656', '0a958631e7fcbf81211df1b311143570', NULL, '2021-01-16 03:09:40', NULL, NULL),
(22, 'jewel', 'jewel44250@hotmail.com', '01712446623', 'd34d6e3ecd92481080925d6048c65462', '532 mirpur1, dhaka', '2021-02-19 04:10:17', NULL, '9930'),
(23, 'jewel 12', 'engr.jewel55@gmail.com', '01716714663', 'b449d0e137c7a9e45dd9cf9aa52c6273', '12/v, mirpur dhaka', '2021-02-19 05:14:26', NULL, '2500'),
(24, 'jewel3', 'jewel442510@hotmail.com', '01714928863', 'e10adc3949ba59abbe56e057f20f883e', NULL, '2021-02-21 00:08:47', NULL, '500'),
(25, 'Md.Ashraful Islam', 'mdashrafulislam767@gmail.com', '01762969575', '955791b962fd277952309626ac1d3fdc', NULL, '2021-02-24 05:16:10', NULL, NULL),
(26, 'Bristi', '146.saimaislam@gmail.com', '01938242406', '965ec99b2844393316ea545b75f8dfbc', 'Tolarbag, mirpur1. 2/1/a/3', '2021-04-03 22:59:13', NULL, '0'),
(27, 'Md. Saifur Rahman', 'saifur1985bd@gmail.com', '01979041699', '1b4801cd6c4e9ea787ce79e13c55684b', NULL, '2021-04-17 21:28:38', NULL, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `basic`
--
ALTER TABLE `basic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `cashoffpayment`
--
ALTER TABLE `cashoffpayment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `productreviews`
--
ALTER TABLE `productreviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `size`
--
ALTER TABLE `size`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
