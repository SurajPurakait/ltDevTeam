-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2018 at 02:06 PM
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
-- Table structure for table `referral_partner`
--

CREATE TABLE `referral_partner` (
  `id` int(11) NOT NULL,
  `partner_id` int(10) NOT NULL,
  `assigned_by_usertype` int(10) NOT NULL COMMENT 'logged in usertype',
  `assisned_by_userid` int(10) NOT NULL COMMENT 'logged in userid',
  `assigned_clienttype` int(10) NOT NULL COMMENT '1 for business 2 for individual',
  `assigned_clientid` int(10) NOT NULL COMMENT 'business or individual''s id',
  `assigned_to_clienttype` int(11) NOT NULL COMMENT 'referral partner usertype i.e. 4',
  `assigned_to_clientid` int(10) NOT NULL COMMENT 'referral partner''s id from staff table',
  `assigned_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `referral_partner`
--
ALTER TABLE `referral_partner`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `referral_partner`
--
ALTER TABLE `referral_partner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
