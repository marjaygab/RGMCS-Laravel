-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 17, 2021 at 11:04 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rgmcs_renes_admin_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `id` int(10) UNSIGNED NOT NULL,
  `deviceName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deviceDescription` varchar(99) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deviceCode` varchar(99) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`id`, `deviceName`, `deviceDescription`, `deviceCode`) VALUES
(1, 'Rene\'s Encoder', 'Aiza PC', 'RENES_ENCODER'),
(2, 'Rene\'s Cashier', 'Cashier PC', 'RENES_CASHIER'),
(3, 'Redor Encoder', 'Encoder for Redor', 'REDOR_ENCODER'),
(4, 'Warehouse Encoder', 'Encoder in Warehouse', 'WAREHOUSE_ENCODER');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2020_01_13_140201_create_devices', 1),
(2, '2020_01_13_140210_create_users', 1),
(3, '2020_01_30_211400_create_notebook_receipt', 1),
(4, '2020_01_30_211419_create_notebook_receipt_items', 1),
(5, '2020_01_30_213916_create_notebook_receipt_items_overview', 2),
(6, '2020_05_16_111240_create_notebook_receipt_items_view', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notebook_receipt`
--

CREATE TABLE `notebook_receipt` (
  `id` int(10) UNSIGNED NOT NULL,
  `vid` int(10) UNSIGNED NOT NULL,
  `vendor` varchar(99) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tdate` date NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notebook_receipt`
--

INSERT INTO `notebook_receipt` (`id`, `vid`, `vendor`, `tdate`, `total`, `created_at`, `updated_at`) VALUES
(1, 96, '3 Gold Marketing Corp.', '2020-01-20', '300.00', '2020-06-20 02:25:22', '2020-06-20 02:25:22'),
(2, 153, '366 Merchandising', '2020-01-20', '112.00', '2020-11-02 06:13:35', '2020-11-02 06:13:35'),
(3, 153, '366 Merchandising', '2020-01-20', '512.00', '2020-11-22 02:16:48', '2020-11-22 02:16:48'),
(4, 217, '1225 Trading', '2020-01-20', '595.66', '2021-05-30 14:41:54', '2021-05-30 14:41:54');

-- --------------------------------------------------------

--
-- Table structure for table `notebook_receipt_items`
--

CREATE TABLE `notebook_receipt_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `receipt_id` int(10) UNSIGNED NOT NULL,
  `itemno` int(10) UNSIGNED NOT NULL,
  `itemdesc` varchar(99) COLLATE utf8mb4_unicode_ci NOT NULL,
  `baseprice` decimal(10,2) NOT NULL,
  `d1` int(11) NOT NULL,
  `d2` int(11) NOT NULL,
  `d3` int(11) NOT NULL,
  `d4` int(11) NOT NULL,
  `netprice` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notebook_receipt_items`
--

INSERT INTO `notebook_receipt_items` (`id`, `receipt_id`, `itemno`, `itemdesc`, `baseprice`, `d1`, `d2`, `d3`, `d4`, `netprice`, `created_at`, `updated_at`) VALUES
(1, 1, 1871, 'Acri-color, Black 60 ml 1', '100.00', 0, 0, 0, 0, '100.00', '2020-06-20 02:25:23', '2020-06-20 02:25:23'),
(2, 1, 1878, 'Acri-color, Chrome Oxide Green 60ml', '100.00', 0, 0, 0, 0, '100.00', '2020-06-20 02:25:23', '2020-06-20 02:25:23'),
(3, 1, 42, 'Ballast Firefly Ecolum 10w', '100.00', 0, 0, 0, 0, '100.00', '2020-06-20 02:25:23', '2020-06-20 02:25:23'),
(4, 2, 1871, 'Acri-color, Black 60 ml', '100.00', 12, 0, 0, 0, '112.00', '2020-11-02 06:13:35', '2020-11-02 06:13:35'),
(5, 3, 1871, 'Acri-color, Black 60 ml', '100.00', 12, 0, 0, 0, '112.00', '2020-11-22 02:16:48', '2020-11-22 02:16:48'),
(6, 3, 42, 'Ballast Firefly Ecolum 10w', '500.00', -20, 0, 0, 0, '400.00', '2020-11-22 02:16:48', '2020-11-22 02:16:48'),
(7, 4, 1867, 'Acid, Muriatic 1-Ltr', '100.00', -5, -5, 10, 0, '99.28', '2021-05-30 14:41:54', '2021-05-30 14:41:54'),
(8, 4, 27, 'Antenna, Pinoy', '500.00', -5, -5, 10, 0, '496.38', '2021-05-30 14:41:54', '2021-05-30 14:41:54');

-- --------------------------------------------------------

--
-- Stand-in structure for view `notebook_receipt_items_aggregated`
-- (See below for the actual view)
--
CREATE TABLE `notebook_receipt_items_aggregated` (
`itemno` int(10) unsigned
,`itemdesc` varchar(99)
,`latest_submission_date` date
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `notebook_receipt_items_overview`
-- (See below for the actual view)
--
CREATE TABLE `notebook_receipt_items_overview` (
`receipt_no` int(10) unsigned
,`receipt_item_no` int(10) unsigned
,`vendor` varchar(99)
,`tdate` date
,`itemno` int(10) unsigned
,`itemdesc` varchar(99)
,`baseprice` decimal(10,2)
,`d1` int(11)
,`d2` int(11)
,`d3` int(11)
,`d4` int(11)
,`netprice` decimal(10,2)
,`created_at` timestamp
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `accessLevelId` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `accessLevelId`, `name`, `email`, `username`, `password`, `remember_token`) VALUES
(1, 1, 'Rea Coronel', 'reacoronel@gmail.com', 'Rea', 'yellow68', '');

-- --------------------------------------------------------

--
-- Structure for view `notebook_receipt_items_aggregated`
--
DROP TABLE IF EXISTS `notebook_receipt_items_aggregated`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `notebook_receipt_items_aggregated`  AS  select `a`.`itemno` AS `itemno`,`a`.`itemdesc` AS `itemdesc`,`a`.`tdate` AS `latest_submission_date` from (select `b`.`itemno` AS `itemno`,`b`.`itemdesc` AS `itemdesc`,`b`.`tdate` AS `tdate`,max(`b`.`created_at`) AS `MAX(b.created_at)` from (select `i`.`itemno` AS `itemno`,`i`.`itemdesc` AS `itemdesc`,`r`.`tdate` AS `tdate`,`r`.`created_at` AS `created_at` from (`notebook_receipt` `r` join `notebook_receipt_items` `i` on((`i`.`receipt_id` = `r`.`id`)))) `b` group by `b`.`itemno`,`b`.`itemdesc`,`b`.`tdate`) `a` ;

-- --------------------------------------------------------

--
-- Structure for view `notebook_receipt_items_overview`
--
DROP TABLE IF EXISTS `notebook_receipt_items_overview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `notebook_receipt_items_overview`  AS  select `r`.`id` AS `receipt_no`,`i`.`id` AS `receipt_item_no`,`r`.`vendor` AS `vendor`,`r`.`tdate` AS `tdate`,`i`.`itemno` AS `itemno`,`i`.`itemdesc` AS `itemdesc`,`i`.`baseprice` AS `baseprice`,`i`.`d1` AS `d1`,`i`.`d2` AS `d2`,`i`.`d3` AS `d3`,`i`.`d4` AS `d4`,`i`.`netprice` AS `netprice`,`i`.`created_at` AS `created_at` from (`notebook_receipt` `r` join `notebook_receipt_items` `i` on((`i`.`receipt_id` = `r`.`id`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notebook_receipt`
--
ALTER TABLE `notebook_receipt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notebook_receipt_items`
--
ALTER TABLE `notebook_receipt_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notebook_receipt`
--
ALTER TABLE `notebook_receipt`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notebook_receipt_items`
--
ALTER TABLE `notebook_receipt_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
