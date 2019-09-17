-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 12, 2018 at 05:27 PM
-- Server version: 5.7.22-0ubuntu0.16.04.1
-- PHP Version: 7.0.30-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Table structure for table `sales_tax_process`
--

CREATE TABLE `sales_tax_process` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `county_id` int(11) NOT NULL,
  `added_by_user` int(11) NOT NULL,
  `user_type` int(11) NOT NULL,
  `rate` varchar(255) NOT NULL,
  `exempt_sales` varchar(255) NOT NULL,
  `taxable_sales` varchar(255) NOT NULL,
  `gross_sales` varchar(255) NOT NULL,
  `sales_tax_collect` varchar(255) NOT NULL,
  `collect_allowance` varchar(255) NOT NULL,
  `total_due` varchar(255) NOT NULL,
  `period_of_time` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `complete_date` date NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sales_tax_process`
--
ALTER TABLE `sales_tax_process`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sales_tax_process`
--
ALTER TABLE `sales_tax_process`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
