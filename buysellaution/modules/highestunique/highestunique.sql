-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 13, 2013 at 01:02 PM
-- Server version: 5.1.61
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `platinum-bestauction`
--


-- --------------------------------------------------------

--
-- Table structure for table `auction_highestunique`
--

CREATE TABLE IF NOT EXISTS `TABLE_PREFIX.highestunique` (
  `product_id` int(11) NOT NULL,
  `startdate` datetime NOT NULL,
  `enddate` datetime NOT NULL,
  `product_cost` float NOT NULL,
  `current_price` varchar(25) NOT NULL,
  `bidamount` varchar(15) NOT NULL,
  `starting_current_price` varchar(20) NOT NULL,
  `max_countdown` int(11) NOT NULL,
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
--
-- Dumping data for table `auction_highestunique`
--

--
-- Dumping data for table `auction_types`
--

INSERT INTO `TABLE_PREFIX.types` (`typeid`, `typename`, `settings`, `pack_type`, `status`) VALUES (NULL, 'highestunique', 'a:1:{s:7:"adminjs";b:1;}', 'M', 'I'); 
