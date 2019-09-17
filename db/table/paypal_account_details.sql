-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2019 at 06:42 PM
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
-- Database: `leafnet_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `paypal_account_details`
--

CREATE TABLE `paypal_account_details` (
  `id` int(11) NOT NULL,
  `sandbox_or_live` int(10) NOT NULL,
  `paypal_username` varchar(255) NOT NULL,
  `paypal_password` varchar(255) NOT NULL,
  `paypal_signature` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paypal_account_details`
--

INSERT INTO `paypal_account_details` (`id`, `sandbox_or_live`, `paypal_username`, `paypal_password`, `paypal_signature`) VALUES
(1, 2, 'debdas.suvo_api1.gmail.com', 'UNA8LZU9EW96MHRB', 'ANtG8-CdvvhFe76LetpkoG2UJpOfABZgpXmsnL2tbJLaajp6E0ijq-UM');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `paypal_account_details`
--
ALTER TABLE `paypal_account_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `paypal_account_details`
--
ALTER TABLE `paypal_account_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
