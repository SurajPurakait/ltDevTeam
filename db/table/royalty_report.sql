-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2019 at 01:23 PM
-- Server version: 10.3.15-MariaDB
-- PHP Version: 7.3.6

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
-- Table structure for table `royalty_report`
--

CREATE TABLE `royalty_report` (
  `id` int(100) NOT NULL,
  `date` date NOT NULL,
  `client_id` varchar(100) NOT NULL,
  `invoice_id` int(100) NOT NULL,
  `service_id` varchar(100) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `retail_price` varchar(50) NOT NULL,
  `override_price` varchar(50) NOT NULL,
  `cost` varchar(50) NOT NULL,
  `payment_status` varchar(100) NOT NULL,
  `collected` varchar(50) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `authorization_id` varchar(255) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `total_net` varchar(50) NOT NULL,
  `office_fee` int(100) NOT NULL,
  `fee_with_cost` varchar(50) NOT NULL,
  `fee_without_cost` varchar(50) NOT NULL,
  `office_id` int(100) NOT NULL,
  `created_by` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `royalty_report`
--
ALTER TABLE `royalty_report`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `royalty_report`
--
ALTER TABLE `royalty_report`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
