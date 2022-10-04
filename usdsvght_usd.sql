-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 11, 2022 at 11:36 AM
-- Server version: 10.3.35-MariaDB-log-cll-lve
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `usdsvght_usd`
--

-- --------------------------------------------------------

--
-- Table structure for table `bit_exchanges`
--

CREATE TABLE `bit_exchanges` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `wid` int(11) DEFAULT NULL,
  `gateway_send` int(11) DEFAULT NULL,
  `gateway_receive` int(11) DEFAULT NULL,
  `amount_send` varchar(255) DEFAULT NULL,
  `amount_receive` varchar(255) DEFAULT NULL,
  `rate_from` varchar(255) DEFAULT NULL,
  `rate_to` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created` int(11) NOT NULL DEFAULT 0,
  `updated` int(11) NOT NULL DEFAULT 0,
  `expired` int(11) NOT NULL DEFAULT 0,
  `u_field_1` varchar(255) DEFAULT NULL,
  `u_field_2` varchar(255) DEFAULT NULL,
  `u_field_3` varchar(255) DEFAULT NULL,
  `u_field_4` varchar(255) DEFAULT NULL,
  `u_field_5` varchar(255) DEFAULT NULL,
  `u_field_6` varchar(255) DEFAULT NULL,
  `u_field_7` varchar(255) DEFAULT NULL,
  `u_field_8` varchar(255) DEFAULT NULL,
  `u_field_9` varchar(255) DEFAULT NULL,
  `u_field_10` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `transaction_id` text DEFAULT NULL,
  `exchange_id` varchar(255) DEFAULT NULL,
  `referral_id` varchar(255) NOT NULL DEFAULT '0',
  `referral_amount` varchar(255) DEFAULT NULL,
  `referral_currency` varchar(255) DEFAULT NULL,
  `referral_status` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bit_exchanges`
--

INSERT INTO `bit_exchanges` (`id`, `uid`, `wid`, `gateway_send`, `gateway_receive`, `amount_send`, `amount_receive`, `rate_from`, `rate_to`, `status`, `created`, `updated`, `expired`, `u_field_1`, `u_field_2`, `u_field_3`, `u_field_4`, `u_field_5`, `u_field_6`, `u_field_7`, `u_field_8`, `u_field_9`, `u_field_10`, `ip`, `transaction_id`, `exchange_id`, `referral_id`, `referral_amount`, `referral_currency`, `referral_status`) VALUES
(35, 0, NULL, 13, 12, '1', '89', '1', '89', 5, 1640197144, 0, 1640283777, 'shahinekbal@hotmail.com', '00', '', '', '', '', '', '', '', '', '103.114.98.7', NULL, '8A56B60E1A744F1CFF23', '0', NULL, NULL, 0),
(24, 0, NULL, 13, 12, '100', '8900.00', '1', '89', 5, 1640195411, 0, 1640281949, 'shahinekbal@hotmail.com', '01856773129', '', '', '', '', '', '', '', '', '103.114.98.7', NULL, '9B1375918E880D917F8F', '0', NULL, NULL, 0),
(25, 0, NULL, 12, 13, '96', '1', '96', '1', 5, 1640195916, 1640369594, 0, 'shahinekbal@hotmail.com', '01856773129', '', '', '', '', '', '', '', '', '103.114.98.7', '999999', '86F329425DFFDEB6D3A1', '0', NULL, NULL, 0),
(26, 0, NULL, 13, 12, '1', '89', '1', '89', 5, 1640196102, 0, 1640282522, 'shahinekbal@hotmail.com', '01856773129', '', '', '', '', '', '', '', '', '103.114.98.7', NULL, 'A5BACA179EC20F0EA854', '0', NULL, NULL, 0),
(27, 0, NULL, 12, 13, '96', '1', '96', '1', 5, 1640196178, 0, 1640282583, 'shahinekbal@hotmail.com', '01856773129', '', '', '', '', '', '', '', '', '103.114.98.7', NULL, '9431878AD29682A7ADB1', '0', NULL, NULL, 0),
(28, 0, NULL, 13, 12, '1', '89', '1', '89', 5, 1640196226, 0, 1640282672, 'shahinekbal@hotmail.com', '01856773129', '', '', '', '', '', '', '', '', '103.114.98.7', NULL, '467D2881D324839C9E5B', '0', NULL, NULL, 0),
(29, 0, NULL, 13, 12, '1', '89', '1', '89', 7, 1640196277, 1641275936, 0, 'shahinekbal@hotmail.com', '01856773129', '', '', '', '', '', '', '', '', '103.114.98.7', NULL, '6D015CFFE0FEF6806893', '0', NULL, NULL, 0),
(30, 0, NULL, 12, 13, '96', '1', '96', '1', 5, 1640196314, 0, 1640283246, 'shahinekbal@hotmail.com', '01856773129', '', '', '', '', '', '', '', '', '103.114.98.7', NULL, '44C5983CADF490547478', '0', NULL, NULL, 0),
(31, 0, NULL, 13, 12, '12', '1068.00', '1', '89', 5, 1640196434, 1640941399, 0, 'Reza@gmail.com', '01771238133', '', '', '', '', '', '', '', '', '37.111.210.161', 'Ahdjwjzbwjsjjs', '486A2443E8C62C60C617', '0', NULL, NULL, 0),
(32, 0, NULL, 13, 12, '10', '890.00', '1', '89', 5, 1640196627, 0, 1640283246, 'Reza@gmail.com', '01771238133', '', '', '', '', '', '', '', '', '37.111.210.161', NULL, 'C574CF7229C8EA6E20BA', '0', NULL, NULL, 0),
(33, 0, NULL, 12, 13, '500', '5.21', '96', '1', 5, 1640196952, 0, 1640283777, 'shahinekbal@hotmail.com', 'Shahin', 'Shahin', '', '', '', '', '', '', '', '103.114.98.7', NULL, '089935BC6D2A5351D1D1', '0', NULL, NULL, 0),
(34, 0, NULL, 13, 12, '10', '890.00', '1', '89', 5, 1640196960, 0, 1640283777, 'Reza@gmail.com', 'Reza@gmail.com', '', '', '', '', '', '', '', '', '37.111.210.161', NULL, 'A6D27673FF7F5F6347FD', '0', NULL, NULL, 0),
(36, 0, NULL, 13, 12, '1', '89', '1', '89', 7, 1640197298, 1640369570, 0, 'mahmodulh2@gmail.com', '01309546454', '', '', '', '', '', '', '', '', '37.111.200.39', 'Nsoaknwosnwivsmaoa', '28CD8771A2E4D124FB7E', '0', NULL, NULL, 0),
(37, 0, NULL, 13, 12, '1', '89', '1', '89', 5, 1640197510, 0, 1640283981, 'shahinekbal@hotmail.com', '01856773129', '', '', '', '', '', '', '', '', '103.114.98.7', NULL, 'ECB63E8C88ABB92771AF', '0', NULL, NULL, 0),
(38, 0, NULL, 13, 12, '1', '89', '1', '89', 4, 1640197616, 1640279096, 0, 'shahinekbal@hotmail.com', '01856773129', '', '', '', '', '', '', '', '', '103.114.98.7', '999999', '64FF48934899FE9391A6', '0', NULL, NULL, 0),
(39, 0, NULL, 13, 12, '1', '89', '1', '89', 5, 1640197942, 0, 1640284631, 'shahinekbal@hotmail.com', '01856773129', '', '', '', '', '', '', '', '', '103.114.98.7', NULL, 'D804FAB0D5929FCDC1D5', '0', NULL, NULL, 0),
(47, 5, NULL, 13, 12, '100', '8900.00', '1', '89', 5, 1640369451, 0, 1640461635, 'mahmodulh2@gmail.com', '01309546454', '', '', '', '', '', '', '', '', '37.111.211.191', NULL, '8F7F8423BA65C9F4790E', '0', NULL, NULL, 0),
(43, 0, NULL, 12, 13, '96', '1', '96', '1', 4, 1640199786, 1640279087, 0, 'shahinekbal@hotmail.com', 'Hshsjsgakzbs', 'shahinekbal@hotmail.com', '', '', '', '', '', '', '', '103.114.98.7', '999999', '850A9A3DA3FFF254CDD3', '0', NULL, NULL, 0),
(45, 2, NULL, 12, 13, '657', '6.84', '96', '1', 5, 1640279044, 1640941432, 0, 'shahinekbal@hotmail.com', 'nai', 'nai', '', '', '', '', '', '', '', '103.114.98.7', 'test', '83F47886CCCA2FC5795D', '0', NULL, NULL, 0),
(55, 2, NULL, 12, 13, '500', '5.21', '96', '1', 4, 1662743774, 1662749256, 0, 'shahinekbal@hotmail.com', 'shahinekbal@hotmail.com', 'shahinekbal@hotmail.com', '', '', '', '', '', '', '', '103.114.98.7', 'test', 'BD0E420F6641258F3571', '0', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `bit_faq`
--

CREATE TABLE `bit_faq` (
  `id` int(11) NOT NULL,
  `question` varchar(255) DEFAULT NULL,
  `answer` text DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bit_faq`
--

INSERT INTO `bit_faq` (`id`, `question`, `answer`, `created`, `updated`) VALUES
(2, 'Buy Sell Rate', '<table>\r\n  <tr>\r\n    <th>Gateways</th>\r\n    <th>Sell </th>\r\n    <th>Buy </th>\r\n  </tr>\r\n  <tr style=\"font-size: 15px\">\r\n    <td><img src=\"https://usdshops.com/uploads/1640195299_icon.png\" width=\"30px\" height=\"30px\" class=\"img-circle pull-left\"> &nbsp;<b style=\"font-size: 12px; padding: 0px 5px 0px 5px\">Bitcoin</b></td>\r\n    <td><b>89</b> TK</td>\r\n    <td><b>96</b> TK</td>\r\n  </tr><tr style=\"font-size: 15px\">\r\n    <td><img src=\"https://usdshops.com/uploads/1641301552_icon.png\" width=\"30px\" height=\"30px\" class=\"img-circle pull-left\"> &nbsp;<b style=\"font-size: 12px; padding: 0px 5px 0px 5px\">Tether (TRC20)</b></td>\r\n    <td><b>89</b> TK</td>\r\n    <td><b>94</b> TK</td>\r\n  </tr><tr style=\"font-size: 15px\">\r\n    <td><img src=\"https://usdshops.com/assets/icons/Litecoin.png\" width=\"30px\" height=\"30px\" class=\"img-circle pull-left\"> &nbsp;<b style=\"font-size: 12px; padding: 0px 5px 0px 5px\">Litecoin</b></td>\r\n    <td><b>88</b> TK</td>\r\n    <td><b>94</b> TK</td>\r\n  </tr><tr style=\"font-size: 15px\">\r\n    <td><img src=\"https://www.ipsewallet.com/uploads/1650330717_icon.png\" width=\"30px\" height=\"30px\" class=\"img-circle pull-left\"> &nbsp;<b style=\"font-size: 12px; padding: 0px 5px 0px 5px\">Ethereum</b></td>\r\n    <td><b>86</b> TK</td>\r\n    <td><b>94</b> TK</td>\r\n  </tr><tr style=\"font-size: 15px\">\r\n    <td><img src=\"https://usdshops.com/assets/icons/PerfectMoney.png\" width=\"30px\" height=\"30px\" class=\"img-circle pull-left\"> &nbsp;<b style=\"font-size: 12px; padding: 0px 5px 0px 5px\">Perfect Money</b></td>\r\n    <td><b>87</b> TK</td>\r\n    <td><b>92</b> TK</td>\r\n  </tr><tr style=\"font-size: 15px\">\r\n    <td><img src=\"https://usdshops.com/uploads/1641302544_icon.png\" width=\"30px\" height=\"30px\" class=\"img-circle pull-left\"> &nbsp;<b style=\"font-size: 12px; padding: 0px 5px 0px 5px\">TRX Tron</b></td>\r\n    <td><b>88</b> TK</td>\r\n    <td><b>94</b> TK</td>\r\n  </tr><tr style=\"font-size: 15px\">\r\n    <td><img src=\"https://usdshops.com/uploads/1641302380_icon.png\" width=\"30px\" height=\"30px\" class=\"img-circle pull-left\"> &nbsp;<b style=\"font-size: 12px; padding: 0px 5px 0px 5px\">Smartchain (BNB)</b></td>\r\n    <td><b>88</b> TK</td>\r\n    <td><b>94</b> TK</td>\r\n  </tr><tr style=\"font-size: 15px\">\r\n    <td><img src=\"https://www.ipsewallet.com/uploads/1650333211_icon.png\" width=\"30px\" height=\"30px\" class=\"img-circle pull-left\"> &nbsp;<b style=\"font-size: 12px; padding: 0px 5px 0px 5px\">Dogecoin</b></td>\r\n    <td><b>87</b> TK</td>\r\n    <td><b>94</b> TK</td>\r\n  </tr><tr style=\"font-size: 15px\">\r\n    <td><img src=\"https://usdshops.com/uploads/1641302059_icon.png\" width=\"30px\" height=\"30px\" class=\"img-circle pull-left\"> &nbsp;<b style=\"font-size: 12px; padding: 0px 5px 0px 5px\">BUSD</b></td>\r\n    <td><b>88</b> TK</td>\r\n    <td><b>94</b> TK</td>\r\n  </tr>  \r\n</table>', 1662878923, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bit_gateways`
--

CREATE TABLE `bit_gateways` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `reserve` varchar(255) DEFAULT NULL,
  `min_amount` varchar(255) DEFAULT NULL,
  `max_amount` varchar(255) DEFAULT NULL,
  `exchange_type` int(11) DEFAULT NULL,
  `include_fee` int(11) DEFAULT NULL,
  `extra_fee` varchar(255) DEFAULT NULL,
  `fee` varchar(255) DEFAULT NULL,
  `allow_send` int(11) DEFAULT NULL,
  `allow_receive` int(11) DEFAULT NULL,
  `default_send` int(11) DEFAULT NULL,
  `default_receive` int(11) DEFAULT NULL,
  `allow_payouts` int(11) DEFAULT NULL,
  `a_field_1` varchar(255) DEFAULT NULL,
  `a_field_2` varchar(255) DEFAULT NULL,
  `a_field_3` varchar(255) DEFAULT NULL,
  `a_field_4` varchar(255) DEFAULT NULL,
  `a_field_5` varchar(255) DEFAULT NULL,
  `a_field_6` varchar(255) DEFAULT NULL,
  `a_field_7` varchar(255) DEFAULT NULL,
  `a_field_8` varchar(255) DEFAULT NULL,
  `a_field_9` varchar(255) DEFAULT NULL,
  `a_field_10` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `external_gateway` int(11) NOT NULL DEFAULT 0,
  `external_icon` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bit_gateways`
--

INSERT INTO `bit_gateways` (`id`, `name`, `currency`, `reserve`, `min_amount`, `max_amount`, `exchange_type`, `include_fee`, `extra_fee`, `fee`, `allow_send`, `allow_receive`, `default_send`, `default_receive`, `allow_payouts`, `a_field_1`, `a_field_2`, `a_field_3`, `a_field_4`, `a_field_5`, `a_field_6`, `a_field_7`, `a_field_8`, `a_field_9`, `a_field_10`, `status`, `external_gateway`, `external_icon`) VALUES
(13, 'Bitcon', 'USD', '49937.12', '5', '1000', 3, 0, '', '00', 1, 1, 0, 0, NULL, '3GfCZTSJRjmkXGWndLTEVGr5cgE68QBhLe', 'usdshops@gmail.com', '', '', '', '', '', '', '', '', 1, 1, 'uploads/1640195299_icon.png'),
(15, 'Rocket', 'BDT', '100000', '500', '50000', 3, 0, '', '00', 1, 1, 0, 0, NULL, '01309546454', '', '', '', '', '', '', '', '', '', 1, 1, 'uploads/1640345526_icon.png'),
(12, 'bkash', 'BDT', '8042', '500', '100000', 3, 0, '', '00', 1, 1, 0, 0, NULL, '01713252221 ( এজেন্ট নাম্বার ) টাকা ক্যাশআউট করার পর Transaction Id দিয়ে Confirm Transaction এ Click করুন ।', '', '', '', '', '', '', '', '', '', 1, 1, 'uploads/1640195176_icon.png'),
(16, 'Nagad', 'BDT', '100000', '500', '50000', 3, 0, '', '00', 1, 1, 0, 0, NULL, '01309546454', '', '', '', '', '', '', '', '', '', 1, 1, 'uploads/1640349195_icon.png'),
(18, 'Tether (TRC20)', 'USDT', '10000', '5', '500', 3, 1, '0', '1', 1, 1, 0, 0, NULL, 'youe_address', '', '', '', '', '', '', '', '', '', 1, 1, 'uploads/1641301552_icon.png'),
(19, 'Litecoin', 'USD', '10000', '5', '500', 3, 1, '', '1', 1, 1, 0, 0, NULL, 'youe_address', '', '', '', '', '', '', '', '', '', 1, 1, 'uploads/1641301801_icon.png'),
(20, 'BUSD', 'USD', '10000', '5', '500', 3, 1, '0', '1', 1, 1, 0, 0, NULL, 'youe_address', '', '', '', '', '', '', '', '', '', 1, 1, 'uploads/1641302059_icon.png'),
(21, 'Smartchain (BNB)', 'USD', '10000', '5', '500', 3, 1, '0', '1', 1, 1, 0, 0, NULL, 'youe_address', '', '', '', '', '', '', '', '', '', 1, 1, 'uploads/1641302380_icon.png'),
(22, 'TRX Tron', 'USD', '10000', '5', '500', 3, 1, '0', '1', 1, 1, 0, 0, NULL, 'youe_address', '', '', '', '', '', '', '', '', '', 1, 1, 'uploads/1641302544_icon.png'),
(23, 'Perfect Money', 'USD', '10000', '5', '500', 3, 1, '0', '1', 1, 1, 0, 0, NULL, 'youe_address', '', '', '', '', '', '', '', '', '', 1, 1, 'uploads/1641302726_icon.png');

-- --------------------------------------------------------

--
-- Table structure for table `bit_gateways_fields`
--

CREATE TABLE `bit_gateways_fields` (
  `id` int(11) NOT NULL,
  `gateway_id` int(11) DEFAULT NULL,
  `field_name` varchar(255) DEFAULT NULL,
  `field_number` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bit_gateways_fields`
--

INSERT INTO `bit_gateways_fields` (`id`, `gateway_id`, `field_name`, `field_number`) VALUES
(1, 9, 'Your Bkash Number', 1),
(2, 10, 'bkash', 1),
(3, 10, 'bKash Transaction ID', 2),
(4, 11, '3GfCZTSJRjmkXGWndLTEVGr5cgE68QBhLe', 1),
(5, 11, 'Your Bitcoin address3', 2),
(6, 12, 'bkash Number', 1),
(7, 13, 'Bitcoin address:', 1),
(10, 15, 'Rocket Number', 1),
(8, 13, 'Bitcoin Email:', 2),
(9, 14, 'Dogicoin account', 1),
(11, 16, 'Nagad Number', 1),
(12, 18, 'Tether Address', 1),
(13, 19, 'Litecoin Address', 1),
(14, 20, 'BUSD Address', 1),
(15, 21, 'Smartchain Address', 1),
(16, 22, 'TRX Tron Address', 1),
(17, 23, 'Perfect Money Address', 1),
(18, 24, 'XRP Ripple Address', 1),
(19, 25, 'Dogecoin Address', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bit_pages`
--

CREATE TABLE `bit_pages` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `prefix` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bit_pages`
--

INSERT INTO `bit_pages` (`id`, `title`, `prefix`, `content`, `created`, `updated`) VALUES
(1, 'Terms of service', 'terms-of-services', '<p style=\"box-sizing: inherit; outline: 0px; margin-top: 0px; margin-bottom: 1rem; padding: 0px; color: rgb(41, 43, 44); font-family: roboto, Helvetica, Arial, sans-serif; font-size: 12px;\">১.Document Verification ছাড়া প্রতিদিন সর্বোচ্চ 100 ডলার বিক্রি করতে পারবেন। আনলিমিটেড ডলার ক্রয় এবং বিক্রি করার জন্য অবশ্যই আপনাকে Document Verification করতে হবে ।&nbsp;</p><p style=\"box-sizing: inherit; outline: 0px; margin-top: 0px; margin-bottom: 1rem; padding: 0px; color: rgb(41, 43, 44); font-family: roboto, Helvetica, Arial, sans-serif; font-size: 12px;\">২. আমাদের ওয়েবসাইটে সর্বনিম্ন&nbsp; 5 ডলার বিক্রি করতে পারবেন এবং সর্বনিম্ন 1000 টাকার ডলার ক্রয় করতে পারবেন ।</p><p style=\"box-sizing: inherit; outline: 0px; margin-top: 0px; margin-bottom: 1rem; padding: 0px; color: rgb(41, 43, 44); font-family: roboto, Helvetica, Arial, sans-serif; font-size: 12px;\">৩. আমরা সকাল&nbsp; 9 AM থেকে রাত 10:00 PM পর্যন্ত ডলার এক্সচেঞ্জ করি। রাত 10:00 PM এর পর কেউ ডলার ক্রয় করার জন্য অথবা বিক্রয় করার জন্য অর্ডার করলে সকাল 9:00 AM পর কমপ্লিট করা হবে ।</p><p style=\"box-sizing: inherit; outline: 0px; margin-top: 0px; margin-bottom: 1rem; padding: 0px; color: rgb(41, 43, 44); font-family: roboto, Helvetica, Arial, sans-serif; font-size: 12px; text-align: justify;\">৪. আমাদের সাইট এ অর্ডার করার পর সর্বোচ্চ&nbsp; 30 মিনিটের মধ্যে অর্ডার কমপ্লিট করা হবে। 30 মিনিটের মধ্যে অর্ডার কমপ্লিট না হলে হেল্পলাইন এ যোগাযোগ করুন।</p><p style=\"box-sizing: inherit; outline: 0px; margin-top: 0px; margin-bottom: 1rem; padding: 0px; color: rgb(41, 43, 44); font-family: roboto, Helvetica, Arial, sans-serif; font-size: 12px;\">৫. একচেঞ্জ করার সময় আপনার Coinbase অথবা Binance&nbsp; ইমেইল অথবা ডলার রিসিভ করার অ্যাড্রেস&nbsp; এবং&nbsp; বিকাশ অথবা রকেট অথবা নগদ অথবা ব্যাংক একাউন্ট নাম্বার ভালো করে চেক করে নিবেন। আপনাদের পেমেন্ট রিসিভ করার ডিটেলস ভুল দিলে সে জন্য আমরা দায়ী থাকবো না।</p><p style=\"box-sizing: inherit; outline: 0px; margin-top: 0px; margin-bottom: 1rem; padding: 0px; color: rgb(41, 43, 44); font-family: roboto, Helvetica, Arial, sans-serif; font-size: 12px;\">৬. আপনি যদি ডলার এক্সচেঞ্জ করা না বোঝেন তাহলে আমাদের&nbsp;<a title=\"YouTube\" href=\"https://www.youtube.com/c/paysawallet\" style=\"box-sizing: inherit; outline: 0px; color: rgb(22, 160, 133); text-decoration-line: none; transition: all 0.2s linear 0s, letter-spacing 0s linear 0s; touch-action: manipulation; cursor: pointer;\">YouTube</a>&nbsp; এ ভিডিও দেখেন।</p><p style=\"box-sizing: inherit; outline: 0px; margin-top: 0px; margin-bottom: 1rem; padding: 0px; color: rgb(41, 43, 44); font-family: roboto, Helvetica, Arial, sans-serif; font-size: 12px;\">৭. আমরা usdshops<a href=\"https://www.paysawallet.com/\" style=\"box-sizing: inherit; outline: 0px; color: rgb(22, 160, 133); text-decoration-line: none; transition: all 0.2s linear 0s, letter-spacing 0s linear 0s; touch-action: manipulation; cursor: pointer;\">.com</a>&nbsp;ওয়েবসাইট ব্যতীত অন্য কোন মাধ্যমে লেনদেন করি না।&nbsp;</p>', NULL, 1662751316),
(2, 'Privacy Policy', 'privacy-policy', '<p style=\"box-sizing: inherit; outline: 0px; margin-top: 0px; margin-bottom: 1rem; padding: 0px; color: rgb(41, 43, 44); font-family: roboto, Helvetica, Arial, sans-serif; font-size: 12px;\"><span style=\"box-sizing: inherit; outline: 0px; font-weight: bolder;\">Our office hours?</span></p><p style=\"box-sizing: inherit; outline: 0px; margin-top: 0px; margin-bottom: 1rem; padding: 0px; color: rgb(41, 43, 44); font-family: roboto, Helvetica, Arial, sans-serif; font-size: 12px;\">We exchange dollars from 9AM To 10 PM</p><p style=\"box-sizing: inherit; outline: 0px; margin-top: 0px; margin-bottom: 1rem; padding: 0px; color: rgb(41, 43, 44); font-family: roboto, Helvetica, Arial, sans-serif; font-size: 12px;\"><span style=\"box-sizing: inherit; outline: 0px; font-weight: bolder;\">How long do we complete the order?</span></p><p style=\"box-sizing: inherit; outline: 0px; margin-top: 0px; margin-bottom: 1rem; padding: 0px; color: rgb(41, 43, 44); font-family: roboto, Helvetica, Arial, sans-serif; font-size: 12px;\">We complete orders within a maximum of 30 minutes.</p><p style=\"box-sizing: inherit; outline: 0px; margin-top: 0px; margin-bottom: 1rem; padding: 0px; color: rgb(41, 43, 44); font-family: roboto, Helvetica, Arial, sans-serif; font-size: 12px;\"><span style=\"box-sizing: inherit; outline: 0px; font-weight: bolder;\">The minimum number of dollars we exchange?</span></p><p style=\"box-sizing: inherit; outline: 0px; margin-top: 0px; margin-bottom: 1rem; padding: 0px; color: rgb(41, 43, 44); font-family: roboto, Helvetica, Arial, sans-serif; font-size: 12px;\">You can buy from us for a minimum of 500 BDT and sell for a minimum of 5 USD.</p><p style=\"box-sizing: inherit; outline: 0px; margin-top: 0px; margin-bottom: 1rem; padding: 0px; color: rgb(41, 43, 44); font-family: roboto, Helvetica, Arial, sans-serif; font-size: 12px;\"><span style=\"box-sizing: inherit; outline: 0px; font-weight: bolder;\">What you need to do to buy and sell dollars from us?</span></p><p style=\"box-sizing: inherit; outline: 0px; margin-top: 0px; margin-bottom: 1rem; padding: 0px; color: rgb(41, 43, 44); font-family: roboto, Helvetica, Arial, sans-serif; font-size: 12px;\">You need an account to buy and sell dollars from us and you need to verify the account.</p><p style=\"box-sizing: inherit; outline: 0px; margin-top: 0px; margin-bottom: 1rem; padding: 0px; color: rgb(41, 43, 44); font-family: roboto, Helvetica, Arial, sans-serif; font-size: 12px;\"><span style=\"box-sizing: inherit; outline: 0px; font-weight: bolder;\">What may be required to verify the account?</span></p><p style=\"box-sizing: inherit; outline: 0px; margin-top: 0px; margin-bottom: 1rem; padding: 0px; color: rgb(41, 43, 44); font-family: roboto, Helvetica, Arial, sans-serif; font-size: 12px;\">You can use your National ID Card or Driving License or Passport to verify the account on our website.</p><p style=\"box-sizing: inherit; outline: 0px; margin-top: 0px; margin-bottom: 1rem; padding: 0px; color: rgb(41, 43, 44); font-family: roboto, Helvetica, Arial, sans-serif; font-size: 12px;\"><span style=\"box-sizing: inherit; outline: 0px; font-weight: bolder;\">If there is any problem in selling dollars?</span></p><p style=\"box-sizing: inherit; outline: 0px; margin-top: 0px; margin-bottom: 1rem; padding: 0px; color: rgb(41, 43, 44); font-family: roboto, Helvetica, Arial, sans-serif; font-size: 12px;\">If you don\'t understand how to sell dollars on our website, then watch the video on&nbsp;<a title=\"YouTube\" href=\"https://www.youtube.com/c/paysawallet\" style=\"box-sizing: inherit; outline: 0px; color: rgb(22, 160, 133); text-decoration-line: none; transition: all 0.2s linear 0s, letter-spacing 0s linear 0s; touch-action: manipulation; cursor: pointer;\">YouTube</a></p><p style=\"box-sizing: inherit; outline: 0px; margin-top: 0px; margin-bottom: 1rem; padding: 0px; color: rgb(41, 43, 44); font-family: roboto, Helvetica, Arial, sans-serif; font-size: 12px;\"><span style=\"box-sizing: inherit; outline: 0px; font-weight: bolder;\"><em style=\"box-sizing: inherit; outline: 0px;\">How to contact you?</em></span></p><p style=\"box-sizing: inherit; outline: 0px; margin-top: 0px; margin-bottom: 1rem; padding: 0px; color: rgb(41, 43, 44); font-family: roboto, Helvetica, Arial, sans-serif; font-size: 12px;\">If you want you can mail us directly or call our contact number and we have WhatsApp for live chat.</p>', NULL, 1662751446),
(3, 'About', 'about', 'Dollar Buy Sell Exchange Bangladesh, Dollar Buy Sell Ex Bd, Bollar Buy Sell And Exchange, Btc To Bkash, Bkash to btc, rocket to btc, btc to rocket, bch to bkash, bkash to bch, bch to rocket, rocket to bch, eth to bkash, bkash to eth, rocket to eth, eth to rocket, etc to bkash, bkash to etc, rocket to etc, etc to rocket, ltc to bkash, bkash to ltc, rocket to ltc, ltc to rocket, paypal to bitcoin, bitcoin to paypal, perfact money to bitcoin, bitcoin to perfact money, etc to btc, btc to etc, btc to etc exchange, etc to btc exchange, paypel to btc exchange, btc to rocket, btc to bkash, btc to bdt,bdt to btc,etc to bdt, ltc to bdt, pm to bkash, bkash to pm, rocket to pm, pm to rocket, coinbase to bkash, bitcoin to bkash, bitcoin cash to bkash, ethereum to bkash,litecoin to bkash, dogecoin to bkash, dollar buy sell exchange instant payment, bkash to coinbase, bkash to bitcoin, bkash to bitcoin cash, bkash to ethereum, bkash to litecoin, bkash to dogecoin, dollar to tkak, taka to dollar, dbbl rocket to coinbase, dbbl rocket to bitcoin, dbbl rocket to bitcoin cash, dbbl rocket to ethereum, dbbl rocket to litecoin, dbbl rocket to dogecoin, dollar business in bangladesh, coinbase to dbbl rocket, bitcoin to dbbl rocket, bitcoin cash to dbbl rocket, ethereum to dbbl rocket, Skrill To dbbl rocket, dbbl rocket to skrill, Skrill To bKash, bKash To Skrill, litecoin to dbbl rocket, dogecoin to dbbl rocket, coinbase to nagad, bitcoin to nagad, ethereum to nagad, litecoin to nagad, nagad to coinbase, nagad to bitcoin, nagad to ethereum, nagad to litecoin, buy bitcoin dollar in bangladesh, how to withdraw money from coinbase to bkash, exchange bitcoin to bkash, bitcoin to bkash transfer, coinbase to bkash 2018, how to buy bitcoin, how to get a bitcoin wallet, everything you need to know about bitcoin 2018, bitcoin transfer to bkash, bkash transfer to bkash, bitcoin wallet bangladesh, sell bitcoin in bangladesh, btc to bdt, Get live exchange rates for BTC to Bangladesh Taka, dollar buy sell bangladesh, dollar buy sell site in bangladesh, dollar buy sell site bd,dollar buy sell exchange site in bangladesh, dollar buy sell exchange bd, dbbl rocket to paypal, paypal to dbbl rocket, bkaah to paypal, paypal to bkaah, paypal dollar buy sell bangladesh, how to cashout from paypal to bkash, paypal to bkash exchange, paypal exchange bd, paypal exchange bd price, paypal to bkash transfer, paypal to bkash money transfer, perfect money to bkash, bkash to perfect money, dbbl rocket to perfect money, perfect money to dbbl rocket, payeer to bkash, bkash to payeer, dbbl rocket to payeer, payeer to dbbl rocket, skrill to bkash bkash to skrill, dbbl rocket to skrill, skrill to dbbl rocket, Ethereum Classic to bkash, bkash to Ethereum Classic,dbbl rocket to Ethereum Classic, Ethereum Classic to dbbl rocket, Ethereum Classic buy sell bangladesh, Ethereum Classic ex bd, Ethereum Classic to bitcoin, Ethereum Classic buy sell site in bangladesh, etc to bkash, bkash to etc, dbbl rocket to etc, etc to dbbl rocket, etc dollar buy sell bangladesh, etc dollar buy sell ex bd, etc to btc, etc to btc exchange, etc to bdt,coinbase dollar buy sell bangladesh,coinbase dollar buy sell bd, 0x to bkash, ox to bkash, bkash to 0x, bkash to ox, DBBL Rocket to 0x, DBBL Rocket to ox, 0x to dbbl rocket, ox to dbbl rocket, zrx to bkash, bkash to zrx, rocket to zrx, zrx to rocket, dbbl rocket to zrx, zrx to dbbl rocket, usdc to bkash, usdc to dbbl rocket, bkash to usdc, dbbl rocket to usdc, usdc to btc, btc to usdc, zrx to btc, btc to zrx, Dai To bKash, bKash To Dai, Dai Coin Exchange Bangladesh, Dai Coin To btc, btc to dai, zrx buy sell bangladesh, Usdc buy sell bangladesh,&nbsp;usdshops.com,&nbsp;usdshops.com,&nbsp;usdshops.com.', NULL, 1662751564),
(5, 'Service', 'service', '<p style=\"box-sizing: inherit; outline: 0px; margin-top: 0px; margin-bottom: 1rem; padding: 0px; color: rgb(41, 43, 44); font-family: roboto, Helvetica, Arial, sans-serif; font-size: 13.6px;\">১. ডকুমেন্ট ভেরিফিকেশন ছাড়া প্রতিদিন সর্বোচ্চ 100 ডলার বিক্রি করতে পারবেন। আনলিমিটেড ডলার ক্রয় এবং বিক্রি করার জন্য অবশ্যই আপনাকে ডকুমেন্ট ভেরিফাই করতে হবে ।&nbsp;</p><p style=\"box-sizing: inherit; outline: 0px; margin-top: 0px; margin-bottom: 1rem; padding: 0px; color: rgb(41, 43, 44); font-family: roboto, Helvetica, Arial, sans-serif; font-size: 13.6px;\">২. আমাদের সাইটে সর্বনিম্ন&nbsp; 5 ডলার বিক্রি করতে পারবেন এবং সর্বনিম্ন&nbsp; 500 টাকার ডলার&nbsp; কিনতে পারবেন ।</p><p style=\"box-sizing: inherit; outline: 0px; margin-top: 0px; margin-bottom: 1rem; padding: 0px; color: rgb(41, 43, 44); font-family: roboto, Helvetica, Arial, sans-serif; font-size: 13.6px;\">৩. আমরা সকাল 9 AM থেকে রাত 10:00 PM পর্যন্ত ডলার এক্সচেঞ্জ করি। রাত 11:00 PM এর পর কেউ ডলার ক্রয় করার জন্য অথবা বিক্রয় করার জন্য অর্ডার করলে সকাল 8:00 AM পর কমপ্লিট করা হবে ।</p><p style=\"box-sizing: inherit; outline: 0px; margin-top: 0px; margin-bottom: 1rem; padding: 0px; color: rgb(41, 43, 44); font-family: roboto, Helvetica, Arial, sans-serif; font-size: 13.6px; text-align: justify;\">৪. আমাদের সাইট এ অর্ডার করার পর সর্বোচ্চ 30 মিনিটের মধ্যে অর্ডার কমপ্লিট করা হবে। 30 মিনিটের মধ্যে অর্ডার কমপ্লিট না হলে হেল্পলাইন এ যোগাযোগ করুন।</p><p style=\"box-sizing: inherit; outline: 0px; margin-top: 0px; margin-bottom: 1rem; padding: 0px; color: rgb(41, 43, 44); font-family: roboto, Helvetica, Arial, sans-serif; font-size: 13.6px;\">৫. একচেঞ্জ করার সময় আপনার Coinbase অথবা Binance&nbsp; ইমেইল অথবা ডলার রিসিভ করার অ্যাড্রেস&nbsp; এবং&nbsp; বিকাশ অথবা রকেট অথবা নগদ অথবা ব্যাংক একাউন্ট নাম্বার ভালো করে চেক করে নিবেন। আপনাদের পেমেন্ট রিসিভ করার ডিটেলস ভুল দিলে সে জন্য আমরা দায়ী থাকবো না।</p><p style=\"box-sizing: inherit; outline: 0px; margin-top: 0px; margin-bottom: 1rem; padding: 0px; color: rgb(41, 43, 44); font-family: roboto, Helvetica, Arial, sans-serif; font-size: 13.6px;\">৬. আপনি যদি ডলার এক্সচেঞ্জ করা না বোঝেন তাহলে আমাদের YouTubue&nbsp;এ ভিডিও দেখেন।</p><p style=\"box-sizing: inherit; outline: 0px; margin-top: 0px; margin-bottom: 1rem; padding: 0px; color: rgb(41, 43, 44); font-family: roboto, Helvetica, Arial, sans-serif; font-size: 13.6px;\">৭. আমরা usdshops.com ওয়েবসাইট ব্যতীত অন্য কোন মাধ্যমে লেনদেন করি না।&nbsp;</p>', 1639939504, 1662751709),
(6, 'FAQ', 'faq', 'dollar buy sell exchange bangladesh, dollar buy sell ex bd, dollar buy sell and exchange, btc to bkash,bkash to btc, rocket to btc, btc to rocket, bch to bkash, bkash to bch, bch to rocket, rocket to bch, eth to bkash, bkash to eth, rocket to eth, eth to rocket, etc to bkash, bkash to etc, rocket to etc, etc to rocket, ltc to bkash, bkash to ltc, rocket to ltc, ltc to rocket, paypal to bitcoin, bitcoin to paypal, perfact money to bitcoin, bitcoin to perfact money, etc to btc, btc to etc, btc to etc exchange, etc to btc exchange, paypel to btc exchange, btc to rocket, btc to bkash, btc to bdt,bdt to btc,etc to bdt, ltc to bdt, pm to bkash, bkash to pm, rocket to pm, pm to rocket, coinbase to bkash, bitcoin to bkash, bitcoin cash to bkash, ethereum to bkash,litecoin to bkash, dogecoin to bkash, dollar buy sell exchange instant payment, bkash to coinbase, bkash to bitcoin, bkash to bitcoin cash, bkash to ethereum, bkash to litecoin, bkash to dogecoin, dollar to tkak, taka to dollar, dbbl rocket to coinbase, dbbl rocket to bitcoin, dbbl rocket to bitcoin cash, dbbl rocket to ethereum, dbbl rocket to litecoin, dbbl rocket to dogecoin, dollar business in bangladesh, coinbase to dbbl rocket, bitcoin to dbbl rocket, bitcoin cash to dbbl rocket, ethereum to dbbl rocket, Skrill To dbbl rocket, dbbl rocket to skrill, Skrill To bKash, bKash To Skrill, litecoin to dbbl rocket, dogecoin to dbbl rocket, coinbase to nagad, bitcoin to nagad, ethereum to nagad, litecoin to nagad, nagad to coinbase, nagad to bitcoin, nagad to ethereum, nagad to litecoin, buy bitcoin dollar in bangladesh, how to withdraw money from coinbase to bkash, exchange bitcoin to bkash, bitcoin to bkash transfer, coinbase to bkash 2018, how to buy bitcoin, how to get a bitcoin wallet, everything you need to know about bitcoin 2018, bitcoin transfer to bkash, bkash transfer to bkash, bitcoin wallet bangladesh, sell bitcoin in bangladesh, btc to bdt, Get live exchange rates for BTC to Bangladesh Taka, dollar buy sell bangladesh, dollar buy sell site in bangladesh, dollar buy sell site bd,dollar buy sell exchange site in bangladesh, dollar buy sell exchange bd, dbbl rocket to paypal, paypal to dbbl rocket, bkaah to paypal, paypal to bkaah, paypal dollar buy sell bangladesh,', 1640369685, NULL),
(7, 'ডলার ক্রয়-বিক্রয় লিমিট', 'News', 'আমাদের ওয়েবসাইটে সর্বনিম্ন ৫ ডলার বিক্রি করতে পারবেন এবং সর্বনিম্ন ৫০০ টাকার ডলার ক্রয় পারবেন। আমাদের সাইটে ডকুমেন্ট ভেরিফাই করা থাকলে আপনি আনলিমিটেড ডলার ক্রয়-বিক্রি করতে পারবেন।', 1641303398, 1662751130);

-- --------------------------------------------------------

--
-- Table structure for table `bit_rates`
--

CREATE TABLE `bit_rates` (
  `id` int(11) NOT NULL,
  `gateway_from` int(11) DEFAULT NULL,
  `gateway_to` int(11) DEFAULT NULL,
  `rate_from` varchar(255) DEFAULT NULL,
  `rate_to` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bit_rates`
--

INSERT INTO `bit_rates` (`id`, `gateway_from`, `gateway_to`, `rate_from`, `rate_to`) VALUES
(8, 13, 12, '1', '89'),
(7, 12, 13, '96', '1'),
(11, 15, 13, '96', '1'),
(12, 13, 15, '1', '89');

-- --------------------------------------------------------

--
-- Table structure for table `bit_settings`
--

CREATE TABLE `bit_settings` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `infoemail` varchar(255) DEFAULT NULL,
  `supportemail` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `skype` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `referral_comission` varchar(255) DEFAULT NULL,
  `wallet_comission` varchar(255) DEFAULT NULL,
  `login_to_exchange` int(11) DEFAULT NULL,
  `document_verification` int(11) DEFAULT NULL,
  `email_verification` int(11) DEFAULT NULL,
  `phone_verification` int(11) DEFAULT NULL,
  `recaptcha_verification` int(11) DEFAULT NULL,
  `recaptcha_publickey` varchar(255) DEFAULT NULL,
  `recaptcha_privatekey` varchar(255) DEFAULT NULL,
  `nexmo_api_key` varchar(255) DEFAULT NULL,
  `nexmo_api_secret` varchar(255) DEFAULT NULL,
  `worktime_from` varchar(255) DEFAULT NULL,
  `worktime_to` varchar(255) DEFAULT NULL,
  `worktime_gmt` varchar(255) DEFAULT NULL,
  `default_language` varchar(255) DEFAULT NULL,
  `default_template` varchar(255) DEFAULT NULL,
  `operator_status` int(11) DEFAULT NULL,
  `footer_information` text DEFAULT NULL,
  `license_key` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bit_settings`
--

INSERT INTO `bit_settings` (`id`, `title`, `description`, `keywords`, `name`, `infoemail`, `supportemail`, `whatsapp`, `skype`, `url`, `referral_comission`, `wallet_comission`, `login_to_exchange`, `document_verification`, `email_verification`, `phone_verification`, `recaptcha_verification`, `recaptcha_publickey`, `recaptcha_privatekey`, `nexmo_api_key`, `nexmo_api_secret`, `worktime_from`, `worktime_to`, `worktime_gmt`, `default_language`, `default_template`, `operator_status`, `footer_information`, `license_key`) VALUES
(1, 'UsdShops.Com - Coinbase To bKash, Bitcoin To bKash, USDT To bKash, ETC - Xchanger site', 'Comming Soon', 'UsdShops.Com', 'UsdShops.Com', 'Support@usdshops.com', 'Support@usdshops.com', '01735846478', '', 'https://usdshops.com/', '00', '00', 1, 0, 1, 0, NULL, NULL, NULL, '', '', '9AM', '10 PM', 'GMT', NULL, NULL, 1, 'Dollar Buy Sell Bangladesh', 'wpmethods');

-- --------------------------------------------------------

--
-- Table structure for table `bit_sms_codes`
--

CREATE TABLE `bit_sms_codes` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `sms_code` varchar(255) DEFAULT NULL,
  `verified` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bit_testimonials`
--

CREATE TABLE `bit_testimonials` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `exchange_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bit_testimonials`
--

INSERT INTO `bit_testimonials` (`id`, `uid`, `type`, `exchange_id`, `status`, `time`, `content`) VALUES
(11, 4, 1, 46, 1, 1640346380, 'Nice site'),
(10, 2, 1, 0, 1, 1640281702, 'ভালো একটা ওয়েবসাইট আমি 5 মিনিটে পেমেন্ট পেয়েছে'),
(9, 2, 1, 0, 1, 1640281353, 'ভালো একটা ওয়েবসাইট আমি 5 মিনিটে পেমেন্ট পেয়েছে'),
(12, 9, 1, 48, 1, 1662718784, '100% trusted');

-- --------------------------------------------------------

--
-- Table structure for table `bit_transactions`
--

CREATE TABLE `bit_transactions` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `transaction_id` text DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `gateway` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `time` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bit_users`
--

CREATE TABLE `bit_users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `password_recovery` text DEFAULT NULL,
  `email_verified` int(11) DEFAULT NULL,
  `email_hash` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `last_login` int(11) DEFAULT NULL,
  `signup_time` int(11) DEFAULT NULL,
  `document_verified` int(11) DEFAULT NULL,
  `document_1` text DEFAULT NULL,
  `document_2` text DEFAULT NULL,
  `mobile_verified` int(11) DEFAULT NULL,
  `mobile_number` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bit_users`
--

INSERT INTO `bit_users` (`id`, `username`, `password`, `password_recovery`, `email_verified`, `email_hash`, `email`, `status`, `ip`, `last_login`, `signup_time`, `document_verified`, `document_1`, `document_2`, `mobile_verified`, `mobile_number`) VALUES
(1, 'admin', '5f866f7997b29a7de25cce860db35af6', NULL, 0, NULL, 'paysawallet@gmail.com', 666, NULL, NULL, NULL, 0, NULL, NULL, 0, ''),
(2, 'shahinekbal', '5f866f7997b29a7de25cce860db35af6', NULL, 0, NULL, 'shahinekbal@hotmail.com', 3, '103.114.98.7', 1662743433, 1639763098, 0, NULL, NULL, 0, ''),
(3, 'Ebrahim', '5efb52b1496488d9104064934a869f4a', NULL, 0, NULL, 'ebrahimbd90@gmail.com', 3, '119.30.38.52', 1642771934, 1640017019, 0, NULL, NULL, 0, NULL),
(12, 'Jahangir2', 'e10adc3949ba59abbe56e057f20f883e', NULL, 1, '', 'jahangirreza902@gmail.com', 3, '37.111.207.211', 1662784583, 1662784271, 1, '8a82ac82bd15593356e0d09bbf41564b/user_12/IMG20220909011510.jpg', '8a82ac82bd15593356e0d09bbf41564b/user_12/GOrWMQlJHoEwIEBRzbpFEzwhPRZ.jpg', 0, ''),
(5, 'MAHMUDUL24', '26b30896d756096302fa3a7f8ab03047', NULL, 0, NULL, 'chingam24@gmail.com', 3, '42.0.7.252', 1640348553, 1640159623, 0, NULL, NULL, 0, ''),
(6, 'safaisal19', '271da7fbf6af247b935888b8ecf87bb8', NULL, 0, NULL, 'safaisal0007@gmail.com', 3, '103.171.143.20', NULL, 1640855633, 0, NULL, NULL, 0, NULL),
(7, 'Raj', 'c2c7ee7c107677f82c69b47c090ae47e', NULL, 0, NULL, 'Rajuahmed99990@gmail.com', 3, '103.135.135.146', NULL, 1641136451, 0, NULL, NULL, 0, NULL),
(8, 'Ador944', 'e84ef40241b173497817a35cbd20ba97', NULL, 0, NULL, 'radiyanahamedshohag@gmail.com', 3, '42.0.7.243', NULL, 1641185070, 0, NULL, NULL, 0, NULL),
(10, 'Aa', '4fbfcae4bc05a8378df6816af41c76c2', NULL, 0, NULL, 'aa1891141@gmail.com', 3, '42.0.4.225', NULL, 1662303494, 0, NULL, NULL, 0, NULL),
(13, 'Shamim007', '7c47844507d2499b8f217528be11712a', NULL, 1, '', 'Smwallet24@gmail.com', 3, '37.111.213.167', 1662875050, 1662791195, 0, NULL, NULL, 0, NULL),
(11, 'Rashidul', '0aaddaf5c4363d990c2bd881278ed178', NULL, 0, NULL, 'rashidul.islam0097@gmail.com', 1, '37.111.210.247', NULL, 1662727462, 0, NULL, NULL, 0, NULL),
(14, 'Test', 'e10adc3949ba59abbe56e057f20f883e', NULL, 0, 'b6ad96af21d8737fdc001b679f7d61ba', 'bucii1537@gmail.com', 1, '37.111.207.211', NULL, 1662791521, 1, '8a82ac82bd15593356e0d09bbf41564b/user_14/IMG20220909011510.jpg', '8a82ac82bd15593356e0d09bbf41564b/user_14/IMG20220909011459.jpg', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `bit_users_deposits`
--

CREATE TABLE `bit_users_deposits` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `gateway_id` varchar(255) DEFAULT NULL,
  `payment_hash` varchar(255) DEFAULT NULL,
  `txid` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `reason` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bit_users_deposits`
--

INSERT INTO `bit_users_deposits` (`id`, `uid`, `amount`, `currency`, `gateway_id`, `payment_hash`, `txid`, `status`, `time`, `reason`) VALUES
(1, 7, '500', 'BDT', '12', '26236D100E', '8LA17TKLLX', 3, 1641136518, NULL),
(2, 8, '50', 'USD', '13', '803DA8BF60', NULL, 1, 1641185159, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bit_users_earnings`
--

CREATE TABLE `bit_users_earnings` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bit_users_earnings`
--

INSERT INTO `bit_users_earnings` (`id`, `uid`, `amount`, `currency`, `created`, `updated`) VALUES
(1, 7, '500', 'BDT', 1662730764, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bit_users_transactions`
--

CREATE TABLE `bit_users_transactions` (
  `id` int(11) NOT NULL,
  `sender` int(11) DEFAULT NULL,
  `recipient` int(11) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bit_users_withdrawals`
--

CREATE TABLE `bit_users_withdrawals` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `eid` int(11) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `requested_on` int(11) DEFAULT NULL,
  `processed_on` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `u_field_1` varchar(255) DEFAULT NULL,
  `u_field_2` varchar(255) DEFAULT NULL,
  `u_field_3` varchar(255) DEFAULT NULL,
  `u_field_4` varchar(255) DEFAULT NULL,
  `u_field_5` varchar(255) DEFAULT NULL,
  `u_field_6` varchar(255) DEFAULT NULL,
  `u_field_7` varchar(255) DEFAULT NULL,
  `u_field_8` varchar(255) DEFAULT NULL,
  `u_field_9` varchar(255) DEFAULT NULL,
  `u_field_10` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bit_exchanges`
--
ALTER TABLE `bit_exchanges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bit_faq`
--
ALTER TABLE `bit_faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bit_gateways`
--
ALTER TABLE `bit_gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bit_gateways_fields`
--
ALTER TABLE `bit_gateways_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bit_pages`
--
ALTER TABLE `bit_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bit_rates`
--
ALTER TABLE `bit_rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bit_settings`
--
ALTER TABLE `bit_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bit_sms_codes`
--
ALTER TABLE `bit_sms_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bit_testimonials`
--
ALTER TABLE `bit_testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bit_transactions`
--
ALTER TABLE `bit_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bit_users`
--
ALTER TABLE `bit_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bit_users_deposits`
--
ALTER TABLE `bit_users_deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bit_users_earnings`
--
ALTER TABLE `bit_users_earnings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bit_users_transactions`
--
ALTER TABLE `bit_users_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bit_users_withdrawals`
--
ALTER TABLE `bit_users_withdrawals`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bit_exchanges`
--
ALTER TABLE `bit_exchanges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `bit_faq`
--
ALTER TABLE `bit_faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bit_gateways`
--
ALTER TABLE `bit_gateways`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `bit_gateways_fields`
--
ALTER TABLE `bit_gateways_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `bit_pages`
--
ALTER TABLE `bit_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bit_rates`
--
ALTER TABLE `bit_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `bit_settings`
--
ALTER TABLE `bit_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bit_sms_codes`
--
ALTER TABLE `bit_sms_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bit_testimonials`
--
ALTER TABLE `bit_testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `bit_transactions`
--
ALTER TABLE `bit_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bit_users`
--
ALTER TABLE `bit_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `bit_users_deposits`
--
ALTER TABLE `bit_users_deposits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bit_users_earnings`
--
ALTER TABLE `bit_users_earnings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bit_users_transactions`
--
ALTER TABLE `bit_users_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bit_users_withdrawals`
--
ALTER TABLE `bit_users_withdrawals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
