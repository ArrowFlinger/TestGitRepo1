-- phpMyAdmin SQL Dump
-- version 3.3.7deb5build0.10.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 25, 2013 at 01:17 PM
-- Server version: 5.1.49
-- PHP Version: 5.3.3-1ubuntu9.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `platinum-bestauction`
--

-- --------------------------------------------------------

--
-- Table structure for table `auction_clock`
--

CREATE TABLE IF NOT EXISTS `TABLE_PREFIX.clock` (
  `product_id` int(11) NOT NULL,
  `startdate` datetime NOT NULL,
  `enddate` datetime NOT NULL,
  `product_cost` float NOT NULL,
  `current_price` varchar(25) NOT NULL,
  `starting_current_price` varchar(20) NOT NULL,
  `min_limit_price` int(100) NOT NULL,
  `max_countdown` int(11) NOT NULL,
  `bidding_countdown` int(11) NOT NULL,
  `bidamount` varchar(12) NOT NULL,
  `reduction` int(11) NOT NULL,
  `product_status` varchar(1) NOT NULL COMMENT 'A- Active, I- Inactive, D=Deleted',
  `product_process` varchar(1) NOT NULL DEFAULT 'L' COMMENT 'C- Closed, L- Live,F- Future',
  `auction_process` varchar(1) NOT NULL DEFAULT 'R' COMMENT 'R-Resumes,H-Hold',
  `dedicated_auction` char(2) NOT NULL COMMENT 'E->Enable,D->Disable',
  `autobid` varchar(1) NOT NULL DEFAULT 'D' COMMENT 'E - Enable, D - Disable',
  `timediff` int(100) NOT NULL,
  `lastbidder_userid` int(11) NOT NULL,
  `increment_timestamp` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `clock_buynow_status` varchar(10) NOT NULL COMMENT 'P-Process,NP-Not process',
  `clock_buynow_status_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`product_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


--
-- Dumping data for table `seat_types`
--

INSERT INTO `TABLE_PREFIX.types` (`typeid`, `typename`, `settings`, `pack_type`, `status`) VALUES (NULL, 'clock', 'a:4:{s:7:"adminjs";b:1;s:7:"autobid";b:0;s:6:"buynow";b:0;s:5:"bonus";b:0;}', 'M', 'I');  


