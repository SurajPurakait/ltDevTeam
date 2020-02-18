-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 18, 2020 at 04:31 PM
-- Server version: 5.7.29-0ubuntu0.16.04.1
-- PHP Version: 7.0.33-0ubuntu0.16.04.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `leafnet_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `project_task_bookkeeping_input_form2`
--

CREATE TABLE `project_task_bookkeeping_input_form2` (
  `id` int(4) NOT NULL,
  `task_id` int(4) NOT NULL,
  `project_id` int(4) NOT NULL,
  `client_id` int(8) NOT NULL,
  `bank_name` varchar(200) NOT NULL,
  `account_number` varchar(100) NOT NULL,
  `total_transaction` varchar(50) NOT NULL,
  `uncategorized_item` varchar(50) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `project_task_bookkeeping_input_form2`
--
ALTER TABLE `project_task_bookkeeping_input_form2`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `project_task_bookkeeping_input_form2`
--
ALTER TABLE `project_task_bookkeeping_input_form2`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
