-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2020 at 04:04 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `leafnet`
--

-- --------------------------------------------------------

--
-- Table structure for table `partner_services_data`
--

CREATE TABLE `partner_services_data` (
  `id` int(11) NOT NULL,
  `mortgage_status` enum('foreign','domestic') NOT NULL,
  `type_of_mortgage` int(2) NOT NULL,
  `purchase_price` varchar(50) NOT NULL,
  `what_is_property_for` varchar(255) NOT NULL,
  `realtor` varchar(50) NOT NULL,
  `realtor_name` varchar(50) NOT NULL,
  `realtor_email` varchar(30) NOT NULL,
  `realtor_phone` varchar(20) NOT NULL,
  `reference` enum('individual','company') DEFAULT NULL,
  `reference_id` int(11) NOT NULL,
  `practice_id` varchar(20) NOT NULL,
  `created_by` int(4) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `partner_services_data`
--
ALTER TABLE `partner_services_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `partner_services_data`
--
ALTER TABLE `partner_services_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
