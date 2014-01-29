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

--
-- Database: `platinum-bestauction`
--

-- --------------------------------------------------------

--
-- Table structure for table `auction_gc_transactions`
--

CREATE TABLE IF NOT EXISTS `TABLE_PREFIX.gc_transactions` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Order id from auction_orders table',
  `gc_orderno` bigint(20) NOT NULL,
  `gc_buyerid` bigint(20) NOT NULL,
  `buyer_email` varchar(200) NOT NULL,
  `buyer_name` varchar(250) NOT NULL,
  `billingaddress` text,
  `shippingaddress` text,
  `serial_number` varchar(200) NOT NULL,
  `order_total` decimal(15,3) NOT NULL,
  `order_currency` varchar(4) NOT NULL,
  `financial_orderstate` varchar(150) NOT NULL COMMENT 'REVIEWING, CHARGEABLE, CHARGING, CHARGED, PAYMENT_DECLINED, CANCELLED, CANCELLED_BY_GOOGLE',
  `fulfillment_orderstate` varchar(150) NOT NULL COMMENT 'NEW, PROCESSING, DELIVERED, WILL_NOT_DELIVER',
  `gc_timestamp` varchar(150) NOT NULL,
  `custom_data` text NOT NULL,
  `item_id` int(20) NOT NULL,
  `shipping_amount` float(10,2) NOT NULL,
  `item_unit-price` float(10,2) NOT NULL,
  `item_quantity` int(20) NOT NULL,
  `item_item-name` varchar(100) NOT NULL,
  `buyer_id` int(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;


--
-- Dumping data for table `payment_gateways`
--

INSERT INTO `TABLE_PREFIX.payment_gateways` (`id`, `payment_gatway`, `controller_name`, `paygate_code`, `description`, `currency_code`, `payment_method`, `paypal_api_username`, `paypal_api_password`, `paypal_api_signature`, `status`, `transaction_table`, `customfunction`) VALUES (NULL, 'Google Checkout', 'googlecheckout', 'gc', 0x736420666173672061736467207364662067736466206773646620677364662067736466206773646620677364662067736466206773646667, 'USD', 'T', '223229946054379', 'q96nmIagFU0-2KP7kYasjg', 'AfEKQGiLDA8BPQdrOChM-whpTBSoANpJJRtDdNtYmo2dxz3VIWy3whMj', 'A', 'gc_transactions', 'a:1:{s:4:"name";s:16:"Gc::showlinkdata";}'); 


