-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2019 at 05:33 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

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
-- Table structure for table `project_template_recurrence_main`
--

CREATE TABLE `project_template_recurrence_main` (
  `id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `pattern` varchar(255) NOT NULL,
  `due_type` varchar(255) NOT NULL,
  `due_day` varchar(255) DEFAULT NULL,
  `due_month_1` varchar(255) DEFAULT NULL,
  `due_day_position` varchar(255) DEFAULT NULL,
  `due_day_type` varchar(255) DEFAULT NULL,
  `due_month_2` varchar(255) DEFAULT NULL,
  `target_start_day` varchar(255) NOT NULL,
  `target_end_day` varchar(255) NOT NULL,
  `expiration_type` varchar(255) NOT NULL,
  `end_occurrence` varchar(255) DEFAULT NULL,
  `generation_type` varchar(255) NOT NULL,
  `generation_day` varchar(255) NOT NULL,
  `generation_month` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `project_template_recurrence_main`
--
ALTER TABLE `project_template_recurrence_main`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `project_template_recurrence_main`
--
ALTER TABLE `project_template_recurrence_main`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
