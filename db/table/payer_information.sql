-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2020 at 04:26 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

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
-- Table structure for table `payer_information`
--

CREATE TABLE `payer_information` (
  `id` int(100) NOT NULL,
  `reference_id` int(100) NOT NULL,
  `order_id` int(100) NOT NULL,
  `payer_first_name` varchar(255) NOT NULL,
  `payer_last_name` varchar(255) NOT NULL,
  `payer_phone_number` varchar(100) NOT NULL,
  `payer_address` varchar(255) NOT NULL,
  `payer_city` varchar(100) NOT NULL,
  `payer_state` int(11) NOT NULL,
  `payer_country` int(11) NOT NULL,
  `payer_zip` varchar(100) NOT NULL,
  `payer_tin` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `payer_information`
--
ALTER TABLE `payer_information`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `payer_information`
--
ALTER TABLE `payer_information`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
