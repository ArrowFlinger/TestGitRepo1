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

INSERT INTO `TABLE_PREFIX.payment_gateways` (`id`, `payment_gatway`, `controller_name`, `paygate_code`, `description`, `currency_code`, `payment_method`, `paypal_api_username`, `paypal_api_password`, `paypal_api_signature`, `status`, `transaction_table`, `customfunction`) VALUES
(NULL, 'Authorize', 'authorize', 'authorize', 0x41756374696f6e2073637269707420417574686f72697a65207061796d656e74206761746577617920, 'USD', 'T', '86jrDx8naX49', '8x88td44D8PFgeS5', '5WEra3rc649CY57M', 'A', NULL, 'a:1:{s:4:"name";s:23:"Authorize::showlinkdata";}');
