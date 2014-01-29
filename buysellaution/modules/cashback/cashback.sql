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

--
-- Database: `nauction_script_development`
--

-- --------------------------------------------------------

--
-- Table structure for table `auction_cashback`
--

CREATE TABLE IF NOT EXISTS `TABLE_PREFIX.cashback` (
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


--
-- Dumping data for table `auction_email_template`
--

INSERT INTO `TABLE_PREFIX.email_template` (`id`, `email_from`, `email_to`, `email_subject`, `email_content`, `template_name`, `template_code`) VALUES
(NULL, '##FROM_EMAIL##', '##TO_MAIL##', 'Cashback Notification - ##AUCTIONID##', 0x3c646976207374796c653d226d617267696e3a203070783b206261636b67726f756e643a20236635663566353b20666f6e742d66616d696c793a20417269616c2c48656c7665746963612c73616e732d73657269663b20666f6e742d73697a653a20313170743b2077696474683a20313030253b223e0a3c646976207374796c653d2277696474683a2036313070783b206d617267696e3a2030206175746f3b2070616464696e673a2030203770783b206261636b67726f756e643a20236666663b20666f6e742d66616d696c793a20417269616c2c48656c7665746963612c73616e732d73657269663b223e0a3c7461626c65207374796c653d2277696474683a20313030253b2220626f726465723d2230222063656c6c73706163696e673d2230222063656c6c70616464696e673d2230223e0a3c74626f64793e0a3c74723e0a3c74643e0a3c646976207374796c653d226d696e2d6865696768743a2031303070783b223e0a3c646976207374796c653d226261636b67726f756e643a20233030303b206d696e2d6865696768743a20393070783b20626f726465722d626f74746f6d3a20357078202366666137313020736f6c69643b206d617267696e2d626f74746f6d3a203570783b223e0a3c646976207374796c653d22666c6f61743a206c6566743b2077696474683a2031383270783b206d696e2d6865696768743a20353770783b206d617267696e3a203135707820323070783b223e23234c4f474f23233c2f6469763e0a3c2f6469763e0a3c2f6469763e0a3c646976207374796c653d2270616464696e673a20323070782032307078203130707820323070783b206261636b67726f756e643a20236662666266623b223e0a3c646976207374796c653d22666f6e742d73697a653a20313170743b20636f6c6f723a20233636363b206d617267696e2d626f74746f6d3a20313570783b223e3c7370616e207374796c653d22666f6e742d73697a653a20313670743b20636f6c6f723a20233030303b223e4869202323555345524e414d4523232c3c2f7370616e3e3c2f6469763e0a3c646976207374796c653d226d617267696e2d746f703a203570783b223e0a3c646976207374796c653d22666f6e742d73697a653a20313170743b20636f6c6f723a20233636363b206d617267696e2d626f74746f6d3a20323070783b223e23234e4f54494649434154494f4e23230a3c646976207374796c653d22666f6e742d73697a653a20313070743b20636f6c6f723a20233636363b206d617267696e3a203135707820302035707820303b2070616464696e672d746f703a20313570783b20666f6e742d7765696768743a20626f6c643b223e496e206f7264657220746f2061636365737320796f7572206163636f756e7420616e64206d6f7265206665617475726573206f66206f757220776562736974652c20706c6561736520666f6c6c6f7720746865206c696e6b2062656c6f7720746f20616374697661746520796f7572206163636f756e743a3c2f6469763e0a3c646976207374796c653d22666f6e742d73697a653a20313170743b20636f6c6f723a20236633303b206d617267696e3a203130707820303b20626f726465723a2031707820736f6c696420236565653b2070616464696e673a20313570783b206261636b67726f756e643a20236666663b223e3c7370616e207374796c653d22636f6c6f723a20233030303066663b223e232350524f445543545f55524c23233c2f7370616e3e3c2f6469763e0a3c2f6469763e0a3c646976207374796c653d22666f6e742d73697a653a20313070743b20636f6c6f723a20233636363b206d617267696e3a203130707820302035707820303b2070616464696e672d746f703a203570783b20666f6e742d7765696768743a20626f6c643b223e496e666f726d6174696f6e3a3c2f6469763e0a3c646976207374796c653d22666f6e742d73697a653a20313070743b20636f6c6f723a20236633303b206d617267696e3a203130707820303b20626f726465723a2031707820736f6c696420236565653b2070616464696e673a20313070783b206261636b67726f756e643a20236666663b223e0a3c646976207374796c653d22636f6c6f723a20236630303b223e3c7370616e207374796c653d22636f6c6f723a20233333333333333b223e23234d45535341474523233c2f7370616e3e3c2f6469763e0a3c2f6469763e0a3c646976207374796c653d22666f6e742d73697a653a20313070743b20636f6c6f723a20233636363b206d617267696e3a203130707820303b223e456e6a6f7920746865207365727669636573212e3c2f6469763e0a3c646976207374796c653d22666f6e742d73697a653a20313070743b20636f6c6f723a20233636363b206d617267696e2d626f74746f6d3a20313570783b2070616464696e672d746f703a20313070783b223e5468616e6b20596f753c6272202f3e202323534954455f4e414d452323203c6272202f3e2323534954455f55524c23233c2f6469763e0a3c646976207374796c653d22666f6e742d73697a653a203970743b20636f6c6f723a20233636363b206d617267696e3a203135707820302035707820303b2070616464696e672d746f703a20313070783b20666f6e742d7374796c653a206974616c69633b20626f726465722d746f703a2031707820736f6c696420236565653b223e496620796f7520616e792071756572696573206174206f757220776562736974652c20706c6561736520636f6e74616374207468652061646d696e6973747261746f72206279207375626d697474696e672074686520666f726d206f6e206f757220636f6e7461637420706167652e3c2f6469763e0a3c2f6469763e0a3c2f6469763e0a3c646976207374796c653d2270616464696e673a20303b223e0a3c646976207374796c653d226261636b67726f756e643a20233030303b20636f6c6f723a20233636363b2070616464696e673a203130707820323070783b20666f6e742d73697a653a20313070743b223e26636f70793b20436f707972696768742032303133202323534954455f4e414d4523232e20416c6c207269676874732072657365727665643c2f6469763e0a3c2f6469763e0a3c2f74643e0a3c2f74723e0a3c2f74626f64793e0a3c2f7461626c653e0a3c64697620636c6173733d22796a36716f223e266e6273703b3c2f6469763e0a3c64697620636c6173733d2261644c223e266e6273703b3c2f6469763e0a3c2f6469763e0a3c64697620636c6173733d2261644c223e266e6273703b3c2f6469763e0a3c2f6469763e, 'Cashback Auction', 'cashback-auction');
);

--
-- Dumping data for table `auction_types`
--

INSERT INTO `TABLE_PREFIX.types` (`typeid`, `typename`, `settings`, `pack_type`, `status`) VALUES (NULL, 'cashback', 'a:4:{s:7:"adminjs";b:1;s:7:"autobid";b:0;s:6:"buynow";b:1;s:5:"bonus";b:1;}', 'M', 'I'); 

 

