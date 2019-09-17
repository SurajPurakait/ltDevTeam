-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 12, 2018 at 06:02 PM
-- Server version: 5.5.60-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `taxleaf`
--

-- --------------------------------------------------------

--
-- Table structure for table `sales_tax_processing`
--

CREATE TABLE IF NOT EXISTS `sales_tax_processing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_of_client` int(2) NOT NULL,
  `new_existing` int(11) NOT NULL,
  `start_year` varchar(200) NOT NULL,
  `frequeny_of_salestax` varchar(100) NOT NULL,
  `frequency_of_salestax_month` int(11) NOT NULL,
  `frequency_of_salestax_querter` int(11) NOT NULL,
  `frequency_of_salestax_years` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  `county` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `existing_practice_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `sales_tax_processing`
--

INSERT INTO `sales_tax_processing` (`id`, `type_of_client`, `new_existing`, `start_year`, `frequeny_of_salestax`, `frequency_of_salestax_month`, `frequency_of_salestax_querter`, `frequency_of_salestax_years`, `state`, `county`, `order_id`, `service_id`, `existing_practice_id`) VALUES
(1, 1, 0, '0000-00-00', 'm', 1, 0, 4, 1, 1, 314, 13, 1211212),
(2, 0, 434, '0000-00-00', 'm', 4, 0, 4, 1, 1, 315, 13, 12222),
(3, 0, 434, '0000-00-00', 'm', 4, 0, 0, 1, 1, 316, 13, 12222),
(4, 0, 434, '10/2018', 'm', 7, 0, 0, 1, 1, 317, 13, 11111),
(5, 0, 434, '10/2018', 'm', 2, 0, 0, 1, 1, 318, 13, 11111),
(6, 0, 434, '10/2018', 'm', 2, 0, 0, 1, 1, 320, 13, 11111),
(7, 0, 434, '10/2018', 'm', 2, 0, 0, 1, 1, 322, 13, 11111),
(8, 0, 434, '10/2018', 'm', 2, 0, 0, 1, 1, 324, 13, 11111),
(9, 0, 434, '10/2018', 'm', 2, 0, 0, 1, 1, 326, 13, 11111),
(10, 1, 0, '10/2018', 'm', 1, 0, 0, 1, 1, 328, 13, 0),
(11, 1, 0, '10/2018', 'm', 1, 0, 0, 1, 1, 330, 13, 0),
(12, 0, 434, '10/2018', 'm', 1, 0, 0, 1, 1, 332, 13, 123456789),
(13, 0, 434, '10/2018', 'y', 0, 0, 1, 1, 1, 334, 13, 121212),
(14, 0, 434, '10/2018', 'y', 0, 0, 1, 1, 1, 336, 13, 121212),
(15, 1, 0, '03/2018', 'q', 8, 2, 0, 1, 1, 338, 13, 213213),
(16, 0, 360, '03/2018', 'm', 11, 0, 0, 1, 1, 340, 13, 213213),
(17, 0, 165, '10/2018', 'm', 9, 0, 0, 1, 1, 344, 13, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
