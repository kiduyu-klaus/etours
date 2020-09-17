-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2019 at 12:13 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `place_finder`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `username`, `password`, `email`, `image`) VALUES
(1, 'admin', 'admin', 'cate@gmail.com', 'profile.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `cid` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_image` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`cid`, `category_name`, `category_image`, `path`) VALUES
(1, 'BAR', '42267_bar.png', ''),
(2, 'HOTELS', '24772_restaurant.png', ''),
(3, 'ATM', '2796_banks.png', ''),
(4, 'BANKS', '71030_banks.png', ''),
(5, 'BEACH', '45092_beach.png', ''),
(6, 'TEMPLE', '55166_temple.png', ''),
(7, 'CINEMA', '48990_cinema.png', ''),
(8, 'ZOO', '6549_zoo.png', ''),
(9, 'MALL', '29712_mall.png', ''),
(10, 'RESTAURANT ', '61465_24772_restaurant.png', ''),
(11, 'EDUCATION', '41543_education.png', ''),
(12, 'COFFEE', '84580_coffee.png', ''),
(13, 'CASINO', '34748_casino.png', ''),
(14, 'MEDICAL', '2170_medical.png', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_places`
--

CREATE TABLE `tbl_places` (
  `p_id` int(11) NOT NULL,
  `p_cat_id` int(11) NOT NULL,
  `place_name` varchar(255) NOT NULL,
  `place_image` varchar(255) NOT NULL,
  `place_video` text NOT NULL,
  `place_description` text NOT NULL,
  `place_address` text NOT NULL,
  `place_email` varchar(255) NOT NULL,
  `place_phone` varchar(255) NOT NULL,
  `place_website` varchar(255) NOT NULL,
  `place_map_latitude` varchar(255) NOT NULL,
  `place_map_longitude` varchar(255) NOT NULL,
  `place_status` int(1) NOT NULL DEFAULT '1',
  `place_rate_avg` varchar(255) NOT NULL,
  `place_total_rate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_places`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_place_gallery`
--

CREATE TABLE `tbl_place_gallery` (
  `id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `image_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_place_gallery`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_rating`
--

CREATE TABLE `tbl_rating` (
  `id` int(11) NOT NULL,
  `post_id` int(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `rate` int(11) NOT NULL,
  `dt_rate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_rating`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

CREATE TABLE `tbl_settings` (
  `id` int(11) NOT NULL,
  `envato_buyer_name` varchar(255) NOT NULL,
  `envato_purchase_code` varchar(255) NOT NULL,
  `envato_purchased_status` int(1) NOT NULL DEFAULT '0',
  `package_name` varchar(255) NOT NULL,
  `ios_bundle_identifier` varchar(255) NOT NULL,
  `onesignal_app_id` varchar(500) NOT NULL,
  `onesignal_rest_key` varchar(500) NOT NULL,
  `app_name` varchar(255) NOT NULL,
  `app_logo` varchar(255) NOT NULL,
  `app_email` varchar(255) NOT NULL,
  `app_version` varchar(255) NOT NULL,
  `app_author` varchar(255) NOT NULL,
  `app_contact` varchar(255) NOT NULL,
  `app_website` varchar(255) NOT NULL,
  `app_description` text NOT NULL,
  `app_developed_by` varchar(255) NOT NULL,
  `app_privacy_policy` text NOT NULL,
  `api_cat_order_by` varchar(255) NOT NULL,
  `api_cat_post_order_by` varchar(255) NOT NULL,
  `app_from_email` varchar(255) NOT NULL,
  `publisher_id` text NOT NULL,
  `interstital_ad` text NOT NULL,
  `interstital_ad_id` text NOT NULL,
  `interstital_ad_click` int(3) NOT NULL,
  `banner_ad` text NOT NULL,
  `banner_ad_id` text NOT NULL,
  `publisher_id_ios` varchar(500) NOT NULL,
  `app_id_ios` varchar(500) NOT NULL,
  `interstital_ad_ios` varchar(500) NOT NULL,
  `interstital_ad_id_ios` varchar(500) NOT NULL,
  `interstital_ad_click_ios` varchar(500) NOT NULL,
  `banner_ad_ios` varchar(500) NOT NULL,
  `banner_ad_id_ios` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_settings`
--

INSERT INTO `tbl_settings` (`id`, `envato_buyer_name`, `envato_purchase_code`, `envato_purchased_status`, `package_name`, `ios_bundle_identifier`, `onesignal_app_id`, `onesignal_rest_key`, `app_name`, `app_logo`, `app_email`, `app_version`, `app_author`, `app_contact`, `app_website`, `app_description`, `app_developed_by`, `app_privacy_policy`, `api_cat_order_by`, `api_cat_post_order_by`, `app_from_email`, `publisher_id`, `interstital_ad`, `interstital_ad_id`, `interstital_ad_click`, `banner_ad`, `banner_ad_id`, `publisher_id_ios`, `app_id_ios`, `interstital_ad_ios`, `interstital_ad_id_ios`, `interstital_ad_click_ios`, `banner_ad_ios`, `banner_ad_id_ios`) VALUES
(1, 'buyer', 'buyer', 1, 'com.app.placefinderapp', 'com.placefinder', '5a701f93-a95c-4586-a0e4-6a1a87bc2a62', 'NTQ4MGI1YzYtY2QwYy00YmY5LWI0MmQtYzU0MTk4N2UzMDRh', 'etours', 'admin_ic100.png', 'info@viaviweb.com', '1.0.1', '', '+254716541458', 'http://the-bookhub.co.ke/', '', 'Viavi Webtech', '', 'category_name', 'DESC', '', '', 'true', '', 5, '', '', '', '', 'true', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `confirm_code` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `tbl_places`
--
ALTER TABLE `tbl_places`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `tbl_place_gallery`
--
ALTER TABLE `tbl_place_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_rating`
--
ALTER TABLE `tbl_rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_places`
--
ALTER TABLE `tbl_places`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_place_gallery`
--
ALTER TABLE `tbl_place_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tbl_rating`
--
ALTER TABLE `tbl_rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=347;

--
-- AUTO_INCREMENT for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
