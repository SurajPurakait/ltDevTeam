-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 13, 2018 at 05:57 PM
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
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `country_code` varchar(45) DEFAULT NULL,
  `country_name` varchar(45) DEFAULT NULL,
  `sort_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country_code`, `country_name`, `sort_order`) VALUES
(0, 'UN', 'Unknow', 1),
(1, 'AF', 'Afghanistan', 2),
(2, 'AL', 'Albania', 3),
(3, 'DZ', 'Algeria', 4),
(4, 'DS', 'American Samoa', 5),
(5, 'AD', 'Andorra', 6),
(6, 'AO', 'Angola', 7),
(7, 'AI', 'Anguilla', 8),
(8, 'AQ', 'Antarctica', 9),
(9, 'AG', 'Antigua and Barbuda', 10),
(10, 'AR', 'Argentina', 11),
(11, 'AM', 'Armenia', 12),
(12, 'AW', 'Aruba', 13),
(13, 'AU', 'Australia', 14),
(14, 'AT', 'Austria', 15),
(15, 'AZ', 'Azerbaijan', 16),
(16, 'BS', 'Bahamas', 17),
(17, 'BH', 'Bahrain', 18),
(18, 'BD', 'Bangladesh', 19),
(19, 'BB', 'Barbados', 20),
(20, 'BY', 'Belarus', 21),
(21, 'BE', 'Belgium', 22),
(22, 'BZ', 'Belize', 23),
(23, 'BJ', 'Benin', 24),
(24, 'BM', 'Bermuda', 25),
(25, 'BT', 'Bhutan', 26),
(26, 'BO', 'Bolivia', 27),
(27, 'BA', 'Bosnia and Herzegovina', 28),
(28, 'BW', 'Botswana', 29),
(29, 'BV', 'Bouvet Island', 30),
(30, 'BR', 'Brazil', 31),
(31, 'IO', 'British Indian Ocean Territory', 32),
(32, 'BN', 'Brunei Darussalam', 33),
(33, 'BG', 'Bulgaria', 34),
(34, 'BF', 'Burkina Faso', 35),
(35, 'BI', 'Burundi', 36),
(36, 'KH', 'Cambodia', 37),
(37, 'CM', 'Cameroon', 38),
(38, 'CA', 'Canada', 39),
(39, 'CV', 'Cape Verde', 40),
(40, 'KY', 'Cayman Islands', 41),
(41, 'CF', 'Central African Republic', 42),
(42, 'TD', 'Chad', 43),
(43, 'CL', 'Chile', 44),
(44, 'CN', 'China', 45),
(45, 'CX', 'Christmas Island', 46),
(46, 'CC', 'Cocos (Keeling) Islands', 47),
(47, 'CO', 'Colombia', 48),
(48, 'KM', 'Comoros', 49),
(49, 'CG', 'Congo', 50),
(50, 'CK', 'Cook Islands', 51),
(51, 'CR', 'Costa Rica', 52),
(52, 'HR', 'Croatia (Hrvatska)', 53),
(53, 'CU', 'Cuba', 54),
(54, 'CY', 'Cyprus', 55),
(55, 'CZ', 'Czech Republic', 56),
(56, 'DK', 'Denmark', 57),
(57, 'DJ', 'Djibouti', 58),
(58, 'DM', 'Dominica', 59),
(59, 'DO', 'Dominican Republic', 60),
(60, 'TP', 'East Timor', 61),
(61, 'EC', 'Ecuador', 62),
(62, 'EG', 'Egypt', 63),
(63, 'SV', 'El Salvador', 64),
(64, 'GQ', 'Equatorial Guinea', 65),
(65, 'ER', 'Eritrea', 66),
(66, 'EE', 'Estonia', 67),
(67, 'ET', 'Ethiopia', 68),
(68, 'FK', 'Falkland Islands (Malvinas)', 69),
(69, 'FO', 'Faroe Islands', 70),
(70, 'FJ', 'Fiji', 71),
(71, 'FI', 'Finland', 72),
(72, 'FR', 'France', 73),
(73, 'FX', 'France, Metropolitan', 74),
(74, 'GF', 'French Guiana', 75),
(75, 'PF', 'French Polynesia', 76),
(76, 'TF', 'French Southern Territories', 77),
(77, 'GA', 'Gabon', 78),
(78, 'GM', 'Gambia', 79),
(79, 'GE', 'Georgia', 80),
(80, 'DE', 'Germany', 81),
(81, 'GH', 'Ghana', 82),
(82, 'GI', 'Gibraltar', 83),
(83, 'GK', 'Guernsey', 84),
(84, 'GR', 'Greece', 85),
(85, 'GL', 'Greenland', 86),
(86, 'GD', 'Grenada', 87),
(87, 'GP', 'Guadeloupe', 88),
(88, 'GU', 'Guam', 89),
(89, 'GT', 'Guatemala', 90),
(90, 'GN', 'Guinea', 91),
(91, 'GW', 'Guinea-Bissau', 92),
(92, 'GY', 'Guyana', 93),
(93, 'HT', 'Haiti', 94),
(94, 'HM', 'Heard and Mc Donald Islands', 95),
(95, 'HN', 'Honduras', 96),
(96, 'HK', 'Hong Kong', 97),
(97, 'HU', 'Hungary', 98),
(98, 'IS', 'Iceland', 99),
(99, 'IN', 'India', 100),
(100, 'IM', 'Isle of Man', 101),
(101, 'ID', 'Indonesia', 102),
(102, 'IR', 'Iran (Islamic Republic of)', 103),
(103, 'IQ', 'Iraq', 104),
(104, 'IE', 'Ireland', 105),
(105, 'IL', 'Israel', 106),
(106, 'IT', 'Italy', 107),
(107, 'CI', 'Ivory Coast', 108),
(108, 'JE', 'Jersey', 109),
(109, 'JM', 'Jamaica', 110),
(110, 'JP', 'Japan', 111),
(111, 'JO', 'Jordan', 112),
(112, 'KZ', 'Kazakhstan', 113),
(113, 'KE', 'Kenya', 114),
(114, 'KI', 'Kiribati', 115),
(115, 'KP', 'Korea, Democratic Peoples Republic of', 116),
(116, 'KR', 'Korea, Republic of', 117),
(117, 'XK', 'Kosovo', 118),
(118, 'KW', 'Kuwait', 119),
(119, 'KG', 'Kyrgyzstan', 120),
(120, 'LA', 'Lao Peoples Democratic Republic', 121),
(121, 'LV', 'Latvia', 122),
(122, 'LB', 'Lebanon', 123),
(123, 'LS', 'Lesotho', 124),
(124, 'LR', 'Liberia', 125),
(125, 'LY', 'Libyan Arab Jamahiriya', 126),
(126, 'LI', 'Liechtenstein', 127),
(127, 'LT', 'Lithuania', 128),
(128, 'LU', 'Luxembourg', 129),
(129, 'MO', 'Macau', 130),
(130, 'MK', 'Macedonia', 131),
(131, 'MG', 'Madagascar', 132),
(132, 'MW', 'Malawi', 133),
(133, 'MY', 'Malaysia', 134),
(134, 'MV', 'Maldives', 135),
(135, 'ML', 'Mali', 136),
(136, 'MT', 'Malta', 137),
(137, 'MH', 'Marshall Islands', 138),
(138, 'MQ', 'Martinique', 139),
(139, 'MR', 'Mauritania', 140),
(140, 'MU', 'Mauritius', 141),
(141, 'TY', 'Mayotte', 142),
(142, 'MX', 'Mexico', 143),
(143, 'FM', 'Micronesia, Federated States of', 144),
(144, 'MD', 'Moldova, Republic of', 145),
(145, 'MC', 'Monaco', 146),
(146, 'MN', 'Mongolia', 147),
(147, 'ME', 'Montenegro', 148),
(148, 'MS', 'Montserrat', 149),
(149, 'MA', 'Morocco', 150),
(150, 'MZ', 'Mozambique', 151),
(151, 'MM', 'Myanmar', 152),
(152, 'NA', 'Namibia', 153),
(153, 'NR', 'Nauru', 154),
(154, 'NP', 'Nepal', 155),
(155, 'NL', 'Netherlands', 156),
(156, 'AN', 'Netherlands Antilles', 157),
(157, 'NC', 'New Caledonia', 158),
(158, 'NZ', 'New Zealand', 159),
(159, 'NI', 'Nicaragua', 160),
(160, 'NE', 'Niger', 161),
(161, 'NG', 'Nigeria', 162),
(162, 'NU', 'Niue', 163),
(163, 'NF', 'Norfolk Island', 164),
(164, 'MP', 'Northern Mariana Islands', 165),
(165, 'NO', 'Norway', 166),
(166, 'OM', 'Oman', 167),
(167, 'PK', 'Pakistan', 168),
(168, 'PW', 'Palau', 169),
(169, 'PS', 'Palestine', 170),
(170, 'PA', 'Panama', 171),
(171, 'PG', 'Papua New Guinea', 172),
(172, 'PY', 'Paraguay', 173),
(173, 'PE', 'Peru', 174),
(174, 'PH', 'Philippines', 175),
(175, 'PN', 'Pitcairn', 176),
(176, 'PL', 'Poland', 177),
(177, 'PT', 'Portugal', 178),
(178, 'PR', 'Puerto Rico', 179),
(179, 'QA', 'Qatar', 180),
(180, 'RE', 'Reunion', 181),
(181, 'RO', 'Romania', 182),
(182, 'RU', 'Russian Federation', 183),
(183, 'RW', 'Rwanda', 184),
(184, 'KN', 'Saint Kitts and Nevis', 185),
(185, 'LC', 'Saint Lucia', 186),
(186, 'VC', 'Saint Vincent and the Grenadines', 187),
(187, 'WS', 'Samoa', 188),
(188, 'SM', 'San Marino', 189),
(189, 'ST', 'Sao Tome and Principe', 190),
(190, 'SA', 'Saudi Arabia', 191),
(191, 'SN', 'Senegal', 192),
(192, 'RS', 'Serbia', 193),
(193, 'SC', 'Seychelles', 194),
(194, 'SL', 'Sierra Leone', 195),
(195, 'SG', 'Singapore', 196),
(196, 'SK', 'Slovakia', 197),
(197, 'SI', 'Slovenia', 198),
(198, 'SB', 'Solomon Islands', 199),
(199, 'SO', 'Somalia', 200),
(200, 'ZA', 'South Africa', 201),
(201, 'GS', 'South Georgia South Sandwich Islands', 202),
(202, 'ES', 'Spain', 203),
(203, 'LK', 'Sri Lanka', 204),
(204, 'SH', 'St. Helena', 205),
(205, 'PM', 'St. Pierre and Miquelon', 206),
(206, 'SD', 'Sudan', 207),
(207, 'SR', 'Suriname', 208),
(208, 'SJ', 'Svalbard and Jan Mayen Islands', 209),
(209, 'SZ', 'Swaziland', 210),
(210, 'SE', 'Sweden', 211),
(211, 'CH', 'Switzerland', 212),
(212, 'SY', 'Syrian Arab Republic', 213),
(213, 'TW', 'Taiwan', 214),
(214, 'TJ', 'Tajikistan', 215),
(215, 'TZ', 'Tanzania, United Republic of', 216),
(216, 'TH', 'Thailand', 217),
(217, 'TG', 'Togo', 218),
(218, 'TK', 'Tokelau', 219),
(219, 'TO', 'Tonga', 220),
(220, 'TT', 'Trinidad and Tobago', 221),
(221, 'TN', 'Tunisia', 222),
(222, 'TR', 'Turkey', 223),
(223, 'TM', 'Turkmenistan', 224),
(224, 'TC', 'Turks and Caicos Islands', 225),
(225, 'TV', 'Tuvalu', 226),
(226, 'UG', 'Uganda', 227),
(227, 'UA', 'Ukraine', 228),
(228, 'AE', 'United Arab Emirates', 229),
(229, 'GB', 'United Kingdom', 230),
(230, 'US', 'United States', 0),
(231, 'UM', 'United States minor outlying islands', 232),
(232, 'UY', 'Uruguay', 233),
(233, 'UZ', 'Uzbekistan', 234),
(234, 'VU', 'Vanuatu', 235),
(235, 'VA', 'Vatican City State', 236),
(236, 'VE', 'Venezuela', 237),
(237, 'VN', 'Vietnam', 238),
(238, 'VG', 'Virgin Islands (British)', 239),
(239, 'VI', 'Virgin Islands (U.S.)', 240),
(240, 'WF', 'Wallis and Futuna Islands', 241),
(241, 'EH', 'Western Sahara', 242),
(242, 'YE', 'Yemen', 243),
(243, 'ZR', 'Zaire', 244),
(244, 'ZM', 'Zambia', 245),
(245, 'ZW', 'Zimbabwe', 246);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=246;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
