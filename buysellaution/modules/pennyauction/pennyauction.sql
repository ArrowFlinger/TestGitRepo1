-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 05, 2012 at 10:29 AM
-- Server version: 5.1.61
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `nauction_script_development`
--

-- --------------------------------------------------------

--
-- Table structure for table `auction_pennyauction`
--

CREATE TABLE IF NOT EXISTS `auction_pennyauction` (
  `product_id` int(11) NOT NULL,
  `startdate` datetime NOT NULL,
  `enddate` datetime NOT NULL,
  `product_cost` float NOT NULL,
  `current_price` varchar(25) NOT NULL,
  `starting_current_price` varchar(20) NOT NULL,
  `max_countdown` int(11) NOT NULL,
  `bidding_countdown` int(11) NOT NULL,
  `bidamount` varchar(12) NOT NULL,
  `product_status` varchar(1) NOT NULL COMMENT 'A- Active, I- Inactive, D=Deleted',
  `product_process` varchar(1) NOT NULL DEFAULT 'L' COMMENT 'C- Closed, L- Live,F- Future',
  `auction_process` varchar(1) NOT NULL DEFAULT 'R' COMMENT 'R-Resumes,H-Hold',
  `dedicated_auction` char(2) NOT NULL COMMENT 'E->Enable,D->Disable',
  `autobid` varchar(1) NOT NULL DEFAULT 'D' COMMENT 'E - Enable, D - Disable',
  `timediff` int(11) NOT NULL,
  `lastbidder_userid` int(11) NOT NULL,
  `increment_timestamp` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`product_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
