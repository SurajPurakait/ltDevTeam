-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 19, 2019 at 06:31 PM
-- Server version: 5.7.28-0ubuntu0.16.04.2
-- PHP Version: 7.0.33-0ubuntu0.16.04.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Table structure for table `project_periodic_pattern`
--

CREATE TABLE `project_periodic_pattern` (
  `id` int(4) NOT NULL,
  `template_id` int(4) NOT NULL,
  `due_type` int(4) DEFAULT NULL,
  `due_day` int(4) DEFAULT NULL,
  `due_month` int(4) DEFAULT NULL,
  `actual_due_day` int(4) DEFAULT NULL,
  `actual_due_month` int(4) DEFAULT NULL,
  `actual_due_year` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `project_periodic_pattern`
--
ALTER TABLE `project_periodic_pattern`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `project_periodic_pattern`
--
ALTER TABLE `project_periodic_pattern`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
