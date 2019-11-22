-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 22, 2019 at 05:56 AM
-- Server version: 5.7.28-0ubuntu0.16.04.2
-- PHP Version: 7.2.22-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `DFrexa`
--

-- --------------------------------------------------------

--
-- Table structure for table `all_asset_transactions`
--

CREATE TABLE `all_asset_transactions` (
  `id` int(11) NOT NULL,
  `asset_name` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `admin_token_role` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `all_asset_transactions`
--

INSERT INTO `all_asset_transactions` (`id`, `asset_name`, `amount`, `admin_token_role`, `owner`) VALUES
(1, 'MYSECOND_ASSET', '2', '2', 'wottox hekig rog lomo gax dik sij lich nagich quayel shishi dero'),
(3, 'MYSECOND_ASSET', '922', '1', 'jaquo rek weyu wixi pittiv wutte deka chif jachi tekej nine xem'),
(4, 'MYASSETERERER', '5', '1', 'jaquo rek weyu wixi pittiv wutte deka chif jachi tekej nine xem');

-- --------------------------------------------------------

--
-- Table structure for table `asset_list`
--

CREATE TABLE `asset_list` (
  `id` int(11) NOT NULL,
  `asset_name` varchar(255) DEFAULT '',
  `amount` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `avatar_url` varchar(255) DEFAULT NULL,
  `full_asset_name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `issuer` varchar(255) DEFAULT NULL,
  `website_url` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `contact_name` varchar(255) DEFAULT NULL,
  `contact_address` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `restricted` varchar(255) DEFAULT NULL,
  `reissuable` varchar(255) DEFAULT NULL,
  `ipfs` varchar(255) DEFAULT NULL,
  `contact_url` varchar(255) DEFAULT NULL,
  `sale_price` varchar(255) DEFAULT NULL,
  `admin` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `asset_list`
--

INSERT INTO `asset_list` (`id`, `asset_name`, `amount`, `unit`, `avatar_url`, `full_asset_name`, `description`, `issuer`, `website_url`, `image_url`, `contact_name`, `contact_address`, `contact_email`, `contact_phone`, `type`, `restricted`, `reissuable`, `ipfs`, `contact_url`, `sale_price`, `admin`) VALUES
(3, 'MYSECOND_ASSET', '924', '8', '11-21-2019_0309pm1282364528', NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, '1', 'QmewD5yLK19XV6N62zY7T6YJsrY9JhG8pZF9gdAe7tmVQF', '', '', 'jaquo rek weyu wixi pittiv wutte deka chif jachi tekej nine xem'),
(4, 'MYASSETERERER', '5', '1', '11-21-2019_0309pm1282364528', NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, '1', '', '', '', 'jaquo rek weyu wixi pittiv wutte deka chif jachi tekej nine xem');

-- --------------------------------------------------------

--
-- Table structure for table `site_users`
--

CREATE TABLE `site_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pin_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seed` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wallet_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asset_name_list` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asset_amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_users`
--

INSERT INTO `site_users` (`id`, `email`, `password`, `pin_code`, `seed`, `wallet_address`, `asset_name_list`, `asset_amount`, `created_at`, `updated_at`) VALUES
(13, 'hi327@ymail.com', 'Steeltits6^', '1234', 'wottox hekig rog lomo gax dik sij lich nagich quayel shishi dero', 'RCAHGRZCs4w15fC9oZJEArGtzQYrzSp2MK', '', '', NULL, NULL),
(16, 'wallet1@email.com', 'wallet1', '1234', 'jaquo rek weyu wixi pittiv wutte deka chif jachi tekej nine xem', 'RFwn4MJiSgqt39TXrcT9xmPohUxkadZjTM', '', '', NULL, NULL),
(17, 'wallet3@email.com', 'wallet4', '1223', 'chehab chowih mettud jif home rettuk bizij lih gohut lir gen mem', 'RDbRp9qiDctE1QFgg8cg5uZ9JFSgCiXHj8', '', '', NULL, NULL),
(18, 'wallet2@email.com', 'wallet2', '1111', 'lifa queta xich ttox quattep borir ziquer guxe hichej jijon mac ttom', 'REBFESSskpxpmj5a9WPxBwnQsHag1Shuw5', '', '', NULL, NULL),
(19, 'ruporodaxixa@gmail.com', 'qwer1234', '1111', 'dide dov dosi niquoqu dos dequ jil waqu zec ttokich quevo shot', 'RKwPmk1EMR3gqQdvbtcxoumFA3QQv2GjLX', '', '', NULL, NULL),
(20, 'high327@knightsaucf.edu', 'steelers60', '1111', 'jeyi leshu mach nuyett gijiqu fel lir sach nott jafif chexi chezur', 'RK1niWNtrj1y9ex427avw8x4D4T6HK2KUC', '', '', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `all_asset_transactions`
--
ALTER TABLE `all_asset_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asset_list`
--
ALTER TABLE `asset_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_users`
--
ALTER TABLE `site_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `all_asset_transactions`
--
ALTER TABLE `all_asset_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `asset_list`
--
ALTER TABLE `asset_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `site_users`
--
ALTER TABLE `site_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
