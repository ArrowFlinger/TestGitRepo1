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
-- Table structure for table `scratch`
--

CREATE TABLE IF NOT EXISTS `TABLE_PREFIX.scratch` (
   `product_id` int(11) NOT NULL,
  `startdate` datetime NOT NULL,
  `enddate` datetime NOT NULL,
  `product_cost` varchar(25) NOT NULL,
  `current_price` varchar(25) NOT NULL,
  `starting_current_price` varchar(20) NOT NULL,
  `max_countdown` int(11) NOT NULL,
  `bidding_countdown` int(11) NOT NULL,
  `bidamount` varchar(12) NOT NULL,
  `bids` varchar(15) NOT NULL,
  `product_stock` int(11) NOT NULL,
  `timetobuy` varchar(15) NOT NULL,
  `user_bid_active` int(11) NOT NULL,
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
-- Table structure for table `auction_scratch_products`
--

CREATE TABLE IF NOT EXISTS `TABLE_PREFIX.scratch_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `product_name` varchar(250) NOT NULL,
  `product_image` varchar(250) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `total_amt` varchar(50) NOT NULL,
  `shipping_cost` varchar(15) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '0' COMMENT '0 - yet to buy, 1- already bought',
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;


--
-- Table structure for table `auction_scratch_bidhistory`
--

CREATE TABLE IF NOT EXISTS `TABLE_PREFIX.scratch_bidhistory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `price` varchar(20) NOT NULL,
  `bids` varchar(15) NOT NULL,
  `bid_type` varchar(5) NOT NULL DEFAULT 'SB' COMMENT 'SB - Single bid, AB- Autobid',
  `timetobuy` int(11) NOT NULL,
  `user_bid_active` int(11) NOT NULL,
  `product_stock` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;

--
-- Table structure for table `auction_scratch_bidsettings`
--

CREATE TABLE IF NOT EXISTS `auction_scratch_bidsettings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_verification_reg` char(1) NOT NULL COMMENT 'Y = Yes, N = No',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `auction_scratch_bidsettings`
--

INSERT INTO `auction_scratch_bidsettings` (`id`, `email_verification_reg`) VALUES
(1, 'Y');

--
-- Dumping data for table `auction_types`
--

INSERT INTO `TABLE_PREFIX.types` (`typeid`, `typename`, `settings`, `pack_type`, `status`) VALUES (NULL, 'scratch', 'a:1:{s:7:"adminjs";b:1;}', 'M', 'I'); 

