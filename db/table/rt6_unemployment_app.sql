-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 05, 2018 at 03:28 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `taxleaf`
--

-- --------------------------------------------------------

--
-- Table structure for table `rt6_unemployment_app`
--

CREATE TABLE `rt6_unemployment_app` (
  `id` int(11) NOT NULL,
  `new_existing` varchar(100) NOT NULL,
  `existing_ref_id` varchar(100) NOT NULL,
  `existing_practice_id` varchar(100) NOT NULL,
  `reference_id` int(100) NOT NULL,
  `order_id` int(100) NOT NULL,
  `start_month_year` varchar(100) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `bank_account_number` varchar(100) NOT NULL,
  `bank_routing_number` varchar(100) NOT NULL,
  `acc_type1` int(10) NOT NULL,
  `acc_type2` int(10) NOT NULL,
  `salestax_availability` varchar(100) NOT NULL,
  `salestax_number` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `void_cheque` varchar(100) NOT NULL,
  `resident_type` varchar(100) NOT NULL,
  `drivers_license` varchar(100) NOT NULL,
  `passport` varchar(100) NOT NULL,
  `lease` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rt6_unemployment_app`
--
ALTER TABLE `rt6_unemployment_app`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rt6_unemployment_app`
--
ALTER TABLE `rt6_unemployment_app`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
