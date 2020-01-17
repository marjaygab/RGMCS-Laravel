-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 15, 2020 at 03:17 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rgmcs_redor_encoder_db`
--
DROP DATABASE IF EXISTS `rgmcs_redor_encoder_db`;
CREATE DATABASE IF NOT EXISTS `rgmcs_redor_encoder_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `rgmcs_redor_encoder_db`;
--
-- Database: `rgmcs_references_db`
--
DROP DATABASE IF EXISTS `rgmcs_references_db`;
CREATE DATABASE IF NOT EXISTS `rgmcs_references_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `rgmcs_references_db`;
--
-- Database: `rgmcs_renes_admin_db`
--
DROP DATABASE IF EXISTS `rgmcs_renes_admin_db`;
CREATE DATABASE IF NOT EXISTS `rgmcs_renes_admin_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `rgmcs_renes_admin_db`;
--
-- Database: `rgmcs_renes_cashier_db`
--
DROP DATABASE IF EXISTS `rgmcs_renes_cashier_db`;
CREATE DATABASE IF NOT EXISTS `rgmcs_renes_cashier_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `rgmcs_renes_cashier_db`;
--
-- Database: `rgmcs_renes_encoder_db`
--
DROP DATABASE IF EXISTS `rgmcs_renes_encoder_db`;
CREATE DATABASE IF NOT EXISTS `rgmcs_renes_encoder_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `rgmcs_renes_encoder_db`;
--
-- Database: `rgmcs_warehouse_encoder`
--
DROP DATABASE IF EXISTS `rgmcs_warehouse_encoder_db`;
CREATE DATABASE IF NOT EXISTS `rgmcs_warehouse_encoder_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `rgmcs_warehouse_encoder_db`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
