-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 29, 2024 at 05:38 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kilimokedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `phone`) VALUES
(6, 'Musyoki Benjamin', 'benjaminmusyoki064@gmail.com', '$2y$10$GCP0VsqG0vtZfguPLO0kcuMYMUDOXe9eNQGc8FvsgaQC0xmsuslJC', '0741672106');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `stock_status` enum('in_stock','out_of_stock') DEFAULT 'in_stock',
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `quantity`, `created_at`, `stock_status`, `image`) VALUES
(3, 'Multi-disc plough', 'This is your machinery to till your land while preparing for the rainy season!', '200000.00', 5, '2024-08-25 11:43:34', 'in_stock', 'farm-machinery.png'),
(2, 'Tractor', 'Very effective machinery for your land preparation during planting season.', '100000.00', 10, '2024-08-25 11:34:48', 'in_stock', 'e4f5e44062f41e94bd44c19bb4469414.jpg'),
(5, 'Mega Harvester ', 'This is your go-to harvester after your big harvest in your shamba!', '249999.99', 5, '2024-08-25 12:01:19', 'in_stock', 'yellow-harvester-work-260nw-140484307.jpg'),
(7, 'Fertilizer Spreaders', 'Can also be used to haul equipment or your harvest, depending on the scope of your applications. ', '199999.00', 2, '2024-08-25 18:01:51', 'in_stock', 'MF-6700R-homepage.jpg'),
(8, 'Harrows', 'These attachments break down clumps of soil, make the soil surface level and redistribute crop and weed residue to make it easier for new plants to grow.', '299999.00', 3, '2024-08-25 18:03:38', 'in_stock', 'farm-machines-and-their-uses.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `registration_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `address`, `avatar`, `registration_date`) VALUES
(33, 'Benjamin Musyoki', 'benjaminmusyoki064@gmail.com', '$2y$10$oWSKeF1Ef6InvJpc47NEM.vLwpufMTZd7gaWz3jxPOcVq1LmplKeC', '+2540741672106', 'Kitui', NULL, '2024-08-25 17:44:52'),
(34, 'Benjamin Musyoki', 'musyokivundibenjamin@gmail.com', '$2y$10$FZwI4oYTiYY.7Z5bjE8cF.g9A7vVHtfOKnwCwvOxtHqjchNtWH3DK', '+2540741672106', 'Thika', NULL, '2024-08-25 17:44:52'),
(35, 'Chebet Janet', 'benjaminmusyoki@gmail.com', '$2y$10$Xw5KtuqiHeiwM4athaupMemr5ZwjiomnfRHTLojtmP447KN2I1zE6', '+2540741672106', 'Thika', NULL, '2024-08-25 17:44:52'),
(37, 'Edith Kimani', 'edithkimani@gmail.com', '$2y$10$TFCDZEZW/IWUmhKbauL4DeXlJqmw5nwjzlFKMG11oTVvCufA5BWZy', '+2540741672106', 'Thika', NULL, '2024-08-25 17:44:52'),
(38, 'Tom Anjeche', 'anjechetom@gmail.com', '$2y$10$8AwlCxzaK0TWv4uvnO//seHdq2sbzGEHFjh70O73HOnDYly2zflsq', '+2540741672106', 'Thika', NULL, '2024-08-26 09:21:24');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
