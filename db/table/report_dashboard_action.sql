-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2020 at 11:49 AM
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
-- Table structure for table `report_dashboard_action`
--

CREATE TABLE `report_dashboard_action` (
  `id` int(11) NOT NULL,
  `action_id` int(11) NOT NULL,
  `by_office` int(4) DEFAULT NULL,
  `by_office_name` varchar(100) DEFAULT NULL,
  `to_office` int(4) DEFAULT NULL,
  `to_office_name` varchar(100) DEFAULT NULL,
  `by_department` int(4) DEFAULT NULL,
  `by_department_name` varchar(50) DEFAULT NULL,
  `to_department` int(4) DEFAULT NULL,
  `to_department_name` varchar(50) DEFAULT NULL,
  `status` int(3) NOT NULL COMMENT '0:New , 1:Started , 2: Completed, 6:Resolved , 7:Cancelled',
  `due_date` date NOT NULL,
  `sos` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `report_dashboard_action`
--
ALTER TABLE `report_dashboard_action`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `report_dashboard_action`
--
ALTER TABLE `report_dashboard_action`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
