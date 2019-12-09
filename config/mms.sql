-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 18, 2019 at 10:26 AM
-- Server version: 5.7.26
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mms`
--

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

DROP TABLE IF EXISTS `agents`;
CREATE TABLE IF NOT EXISTS `agents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`id`, `name`, `email`, `phone`, `status`, `reg_date`) VALUES
(1, 'Agent Zero', 'azero@gmail.com', '07000000001', 1, '2019-08-22 07:02:05'),
(5, 'bablo escobar', 'psmith@example.com', '0774044263', 1, '2019-10-02 10:23:26');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `contact_name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `contact_name`, `phone`, `email`, `address`, `status`, `date`) VALUES
(1, 'Dennoh', 'Dennis Githinji', '0758500200', 'dgithinji@gmail.com', 'muranga', 0, '2019-11-13 09:46:15'),
(2, 'juja-qshule', 'Hannington Chumo', '0758500200', 'hchumo@mail.com', 'juja', 0, '2019-11-13 09:59:35');

-- --------------------------------------------------------

--
-- Table structure for table `competitors`
--

DROP TABLE IF EXISTS `competitors`;
CREATE TABLE IF NOT EXISTS `competitors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `threat_level` varchar(255) NOT NULL,
  `strength` varchar(255) NOT NULL,
  `weakness` varchar(255) NOT NULL,
  `won` varchar(255) NOT NULL DEFAULT 'no',
  `timeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `opportunity_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `competitors`
--

INSERT INTO `competitors` (`id`, `name`, `threat_level`, `strength`, `weakness`, `won`, `timeStamp`, `opportunity_id`) VALUES
(1, 'smart-tech', 'MEDIUM', 'popular', 'product is poor quality', '0', '2019-08-30 10:58:47', 1),
(2, 'lkll;', 'LOW', 'lkopkop', 'lkl;k;', '1', '2019-09-01 08:52:34', 0),
(3, 'jonas ', 'LOW', 'kkk', 'kkk', '1', '2019-10-09 08:59:57', 2),
(4, 'austin jordan', 'HIGH', 'puttin', 'jjfjf', '1', '2019-10-09 09:15:11', 2),
(5, 'austin jordan', 'HIGH', 'puttin', 'jjfjf', '1', '2019-10-09 09:19:55', 2),
(6, 'newak ', 'HIGH', 'collaborator', 'unknown', '1', '2019-10-14 07:34:44', 4),
(8, 'james', 'MEDIUM', 'unknown', 'unknown', '1', '2019-10-14 08:25:00', 2),
(9, 'chris mbooni', 'LOW', 'undetermined', 'not known', 'no', '2019-10-14 08:30:08', 2),
(10, 'TAPS Communication', 'MEDIUM', 'Current Supplier', 'Frustrates client', 'no', '2019-10-15 05:51:27', 5),
(12, 'call', 'LOW', 'unknown', 'unknown', 'yes', '2019-11-04 09:26:18', 6),
(13, 'mayo', 'LOW', 'sweet talker', 'braggeer', 'no', '2019-11-11 12:18:01', 4);

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

DROP TABLE IF EXISTS `history`;
CREATE TABLE IF NOT EXISTS `history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clientId` int(11) NOT NULL,
  `solution` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `manager` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `date` varchar(255) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `clientId`, `solution`, `description`, `amount`, `manager`, `status`, `date`, `time`) VALUES
(2, 1, 'q-afya', 'dgfh', '400000', 'dff fdff', 'unsatisfied', NULL, '2019-11-17 19:00:06'),
(3, 2, 'jjjj', 'mm', '55', 'kmkk', 'satisfied', NULL, '2019-11-17 19:01:52'),
(5, 1, 'q-bizz', 'bii', '444', 'jjuu', 'satisfied', NULL, '2019-11-18 06:55:30');

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

DROP TABLE IF EXISTS `leads`;
CREATE TABLE IF NOT EXISTS `leads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `invoice` varchar(255) DEFAULT '0.00',
  `date` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`id`, `name`, `contact_person`, `phone`, `email`, `address`, `invoice`, `date`, `status`, `reg_date`) VALUES
(1, 'kenol', 'john doe', '0722000111', 'psmith@gmail.com', 'kenol town ', '9', '08/30/2019', 1, '2019-08-30 11:06:40'),
(2, 'tornado', 'crimeson', '0709000001', 'psmith@gmail.com', 'orlando', '9', '2019-10-10', 0, '2019-09-01 08:51:24'),
(3, 'jonte wines', 'toni', '01889938399', 'mkimu@gmail.com', '0774044263', '10', '2019-10-03', 1, '2019-10-02 11:17:11'),
(4, 'Equinox Horticulture Limited', 'Loise Ratemo', '0758500200', 'loise@eqinox.com', 'Nanyuki', '0', '2019-10-14', 1, '2019-10-15 05:47:08'),
(6, 'st patricks', 'mr kingicha', '07-00999898', 'stp2mail.com@mzil.com', 'iten', '0', '2019-11-13', 1, '2019-11-04 08:31:42');

-- --------------------------------------------------------

--
-- Table structure for table `opportunities`
--

DROP TABLE IF EXISTS `opportunities`;
CREATE TABLE IF NOT EXISTS `opportunities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `potential_amount` decimal(10,0) NOT NULL,
  `projected_margin` varchar(255) NOT NULL,
  `interest_level` varchar(255) NOT NULL,
  `sales_agent` varchar(255) NOT NULL,
  `engagement_protocol` varchar(255) NOT NULL,
  `predicted_sales_period` varchar(255) NOT NULL,
  `predicted_close_date` varchar(255) NOT NULL,
  `information_source` varchar(255) NOT NULL,
  `industry_selector` varchar(255) NOT NULL,
  `leadId` int(11) NOT NULL,
  `status` varchar(255) DEFAULT '1',
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `opportunities`
--

INSERT INTO `opportunities` (`id`, `name`, `description`, `potential_amount`, `projected_margin`, `interest_level`, `sales_agent`, `engagement_protocol`, `predicted_sales_period`, `predicted_close_date`, `information_source`, `industry_selector`, `leadId`, `status`, `reg_date`) VALUES
(4, 'wines', 'point of sale information system', '6000000', '32', 'MEDIUM', '5', 'Call', '4', '11/08/2019', 'Advertisement', 'sales', 3, '1', '2019-10-03 09:26:46'),
(5, 'Biometric Time & Attenandance and Canteen POS', 'As above', '400000', '50', 'HIGH', '1', 'liason', '30', '11/15/2019', 'Referral', 'Floriculture', 4, '1', '2019-10-15 05:49:17');

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

DROP TABLE IF EXISTS `partners`;
CREATE TABLE IF NOT EXISTS `partners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `opportunity_id` int(11) NOT NULL DEFAULT '0',
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`id`, `name`, `category`, `role`, `opportunity_id`, `reg_date`) VALUES
(1, 'kevin', 'Agent', 'unknown', 1, '2019-08-30 10:56:21'),
(2, 'ghjj', 'Supplier', 'jkllll', 0, '2019-09-01 08:51:48'),
(3, 'jammy janson', 'Agent', 'crank', 3, '2019-10-07 10:21:30'),
(4, 'jammy janson', 'Agent', 'crank', 3, '2019-10-07 10:22:23'),
(5, 'michita', 'Agent', 'crank', 3, '2019-10-07 10:41:51'),
(6, 'james sin', 'Associate', 'crank', 3, '2019-10-07 10:44:57'),
(7, 'ramon ', 'Other', 'we', 2, '2019-10-07 11:22:05'),
(8, 'logic ', 'Referee', 'jsk', 3, '2019-10-08 09:08:29'),
(9, 'jason deril', 'Agent', 'onge', 2, '2019-10-08 11:35:02'),
(10, 'mocha mocha', 'Associate', 'onre', 2, '2019-10-08 11:35:39'),
(11, 'michael joseph', 'Supplier', 'net', 3, '2019-10-08 11:42:00'),
(12, 'james bower', 'Agent', 'ffff', 3, '2019-10-09 06:51:02'),
(13, 'ramon ', 'Other', 'we', 2, '2019-10-09 08:05:49'),
(14, 'charmaneus', 'Agent', 'poke', 2, '2019-10-14 06:40:06'),
(15, 'arkut', 'Associate', 'meyo', 4, '2019-10-14 07:28:51'),
(17, 'Ratemo Obare', 'Referee', 'Engagement with client on budgets', 5, '2019-10-15 05:50:24'),
(18, 'Boniface Ongera', 'Agent', 'Follow Up on the deal', 5, '2019-10-15 05:50:47'),
(19, 'alex mbaka', 'Other', 'developer', 5, '2019-11-04 06:35:03'),
(20, 'philip murgor', 'Other', 'endorsement', 6, '2019-11-04 08:36:08'),
(21, 'philip murgor', 'Other', 'endorsement', 6, '2019-11-04 08:36:08'),
(22, 'hannington', 'Agent', 'sales', 4, '2019-11-04 08:45:15');

-- --------------------------------------------------------

--
-- Table structure for table `progress`
--

DROP TABLE IF EXISTS `progress`;
CREATE TABLE IF NOT EXISTS `progress` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task` varchar(255) NOT NULL,
  `party` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `outcome` varchar(255) NOT NULL DEFAULT '0',
  `opportunity_id` int(11) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `progress`
--

INSERT INTO `progress` (`id`, `task`, `party`, `date`, `remarks`, `outcome`, `opportunity_id`, `timestamp`) VALUES
(1, 'call liason', 'marketing', '08/30/2019', 'meh', 'on', 1, '2019-08-30 11:06:35'),
(2, 'ijiojoi', 'ttftfr', '09/01/2019', 'frdeses', 'on', 0, '2019-09-01 08:52:56'),
(7, 'call client', 'kfkfkmf', '11/27/2019', 'kkk', '', 4, '2019-11-07 07:44:54'),
(8, 'lklll', 'njfnjf', '11/26/2019', 'mkflf', '', 4, '2019-11-07 07:45:14'),
(10, 'kkkk', 'ff', '11/26/2019', 'ggg', '', 4, '2019-11-11 12:18:46');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `access_level` varchar(255) NOT NULL DEFAULT 'member',
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email`, `role`, `password`, `access_level`, `reg_date`) VALUES
(1, 'admin', 'system adiministrator', 'super@user.mail', 'admin', '$2y$10$ywAb6i6JzfA8GfNOTfLWc.Tgnph9WKm3hPvwZZ3D38fi1gzZ4J.du', 'member', '2019-08-20 11:56:53'),
(2, 'clerk', 'Isaac Kipngeno', 'isaac2ngeno5@gmail.com', 'member', '$2y$10$6ugLG/DbKw693iOp3RBmtu.wXiinIxhNVdJwejCX/cPdEzCfY7di6', 'member', '2019-10-01 08:03:26'),
(3, 'hilder', 'hilder', 'bdose@gmail.com', 'member', '$2y$10$gfroXTMbKP3CXOoq1CHY.u.6FQmc/1SN4vB2R8maTjg.l6yNNFjMa', 'member', '2019-10-14 13:37:48');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
