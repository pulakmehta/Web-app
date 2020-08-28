-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3305
-- Generation Time: May 13, 2020 at 03:09 AM
-- Server version: 8.0.18
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_proj_final`
--
CREATE DATABASE IF NOT EXISTS `db_proj_final` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `db_proj_final`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `super_admin` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `email`, `password`, `name`, `super_admin`) VALUES
(1, 'ninawekunal@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Kunal Ninawe', 1),
(2, 'pulakmehta@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Pulak Mehta', 1),
(3, 'kvn238@nyu.edu', 'e10adc3949ba59abbe56e057f20f883e', 'Kunal', 0),
(4, 'a@a.a', 'e10adc3949ba59abbe56e057f20f883e', 'Kunal', 0),
(5, 'xyz@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'hhh', 0);

-- --------------------------------------------------------

--
-- Table structure for table `auto_ins`
--

DROP TABLE IF EXISTS `auto_ins`;
CREATE TABLE IF NOT EXISTS `auto_ins` (
  `ainsid` int(11) NOT NULL AUTO_INCREMENT,
  `cust_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_amount` bigint(13) NOT NULL,
  `status` varchar(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'C',
  PRIMARY KEY (`ainsid`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auto_ins`
--

INSERT INTO `auto_ins` (`ainsid`, `cust_id`, `start_date`, `end_date`, `total_amount`, `status`) VALUES
(9, 1, '2020-05-13', '2021-05-13', 1442, 'C'),
(8, 11, '2020-05-09', '2021-05-09', 907, 'C'),
(7, 1, '2020-05-09', '2021-05-09', 839, 'C'),
(16, 20, '2020-05-13', '2021-05-13', 661, 'C'),
(15, 18, '2020-05-13', '2022-05-13', 691, 'C');

-- --------------------------------------------------------

--
-- Table structure for table `auto_ins_payments`
--

DROP TABLE IF EXISTS `auto_ins_payments`;
CREATE TABLE IF NOT EXISTS `auto_ins_payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `due_date` date NOT NULL,
  `amount` bigint(13) NOT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_type` varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Check',
  `ainsid` int(11) NOT NULL COMMENT 'Foreign key giving all info about the insurance',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '0 means payment not done',
  PRIMARY KEY (`payment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auto_ins_payments`
--

INSERT INTO `auto_ins_payments` (`payment_id`, `due_date`, `amount`, `payment_date`, `payment_type`, `ainsid`, `status`) VALUES
(19, '2021-05-13', 661, '2020-05-12', 'Credit', 16, 1),
(18, '2022-05-13', 346, NULL, 'Check', 15, 0),
(17, '2021-05-13', 346, NULL, 'Check', 15, 0),
(14, '2021-05-13', 1442, NULL, 'Check', 9, 0),
(13, '2021-05-09', 907, NULL, 'Check', 8, 0),
(12, '2021-05-09', 839, NULL, 'Check', 7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cust_details`
--

DROP TABLE IF EXISTS `cust_details`;
CREATE TABLE IF NOT EXISTS `cust_details` (
  `cust_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `middle_name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(1) COLLATE utf8_unicode_ci DEFAULT 'M',
  `marital_status` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'S',
  `cust_type` varchar(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`cust_id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cust_details`
--

INSERT INTO `cust_details` (`cust_id`, `email`, `first_name`, `middle_name`, `last_name`, `password`, `address`, `gender`, `marital_status`, `cust_type`) VALUES
(1, 'ninawekunal@gmail.com', 'Kunal', 'V', 'Ninawe', 'e10adc3949ba59abbe56e057f20f883e', 'New York', 'M', 'S', 'B'),
(19, 'ninawekunal3@gmail.com', 'Kunal', NULL, 'Ninawe', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'M', 'S', NULL),
(6, 'kvn238@nyu.edu', 'Kunal', 'Vijay', 'Ninawe', 'e10adc3949ba59abbe56e057f20f883e', 'CA', 'M', 'S', 'H'),
(8, 'xyz@gmail.com', 'XYZ', 'ABC', 'EFG', 'e10adc3949ba59abbe56e057f20f883e', 'TX', 'M', 'W', 'H'),
(9, 'cmorebutts@xmail.com', 'Seymore', NULL, 'Butz', '0b9a54438fba2dc0d39be8f7c6c71a58', NULL, 'M', 'S', NULL),
(15, 'test@t.com', 'xyz', NULL, 'abc', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'M', 'S', 'H'),
(11, 'a@a.com', 'Kunal', NULL, 'Ninawe', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'M', 'S', 'B'),
(18, 'pulakmehta@gmail.com', 'Pulak', '', 'Mehta', 'e10adc3949ba59abbe56e057f20f883e', 'Bay Ridge', 'F', 'W', 'A'),
(16, 'test@test.com', 'Test', NULL, 'Testing', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'M', 'S', 'H'),
(20, 'sanjana@moonju.com', 'MoonJu', 'Bavlat', 'Santana', 'e10adc3949ba59abbe56e057f20f883e', 'Idiot', 'F', 'S', 'B');

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

DROP TABLE IF EXISTS `drivers`;
CREATE TABLE IF NOT EXISTS `drivers` (
  `license_no` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `vin` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `birth_date` date NOT NULL,
  PRIMARY KEY (`license_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`license_no`, `vin`, `name`, `birth_date`) VALUES
('66555', '5566', 'Paji', '2015-12-31'),
('6698', '6672', 'Pulak Mehta', '2015-12-24'),
('999', '556', 'Sanju', '1997-01-15'),
('6666', '2651', 'Harrison Ford', '2012-05-19'),
('2201', '1234', 'Ross Geller', '2020-05-08'),
('2222', '12334', 'Kunal', '2020-05-08');

-- --------------------------------------------------------

--
-- Table structure for table `home_details`
--

DROP TABLE IF EXISTS `home_details`;
CREATE TABLE IF NOT EXISTS `home_details` (
  `home_id` int(11) NOT NULL AUTO_INCREMENT,
  `cust_id` int(11) NOT NULL,
  `hinsid` int(11) NOT NULL DEFAULT '0',
  `location` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `purchase_date` date NOT NULL,
  `purchase_value` bigint(13) NOT NULL,
  `area_sq_feet` float NOT NULL,
  `home_type` varchar(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'S',
  `auto_fire_noti` int(1) NOT NULL DEFAULT '0',
  `home_security` int(1) NOT NULL DEFAULT '0',
  `swimming_pool` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `basement` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`home_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `home_details`
--

INSERT INTO `home_details` (`home_id`, `cust_id`, `hinsid`, `location`, `purchase_date`, `purchase_value`, `area_sq_feet`, `home_type`, `auto_fire_noti`, `home_security`, `swimming_pool`, `basement`) VALUES
(7, 11, 6, 'New Jersey', '2020-05-13', 120000, 1200, 'S', 1, 1, 'U', 1),
(6, 6, 5, 'New York', '2020-05-13', 200000, 1200, 'S', 1, 1, 'U', 1),
(5, 1, 4, 'New York', '2020-05-08', 200000, 1200, 'S', 1, 1, 'null', 1),
(8, 11, 7, 'Indiana', '2020-04-08', 300000, 1000, 'S', 1, 1, 'M', 1),
(9, 15, 8, 'Texas', '2020-05-13', 80000, 800, 'S', 1, 1, 'null', 1),
(10, 8, 9, 'California', '2020-05-13', 200000, 1200, 'S', 1, 1, 'null', 0),
(11, 1, 10, 'Delaware', '2000-01-01', 100000, 1000, 'S', 1, 1, 'U', 1),
(12, 1, 11, 'Florida', '2000-01-01', 100000, 1200, 'S', 1, 1, 'U', 1),
(13, 1, 11, 'District of Columbia', '2000-01-01', 500000, 1210, 'S', 1, 1, 'U', 1),
(14, 16, 12, 'Iowa', '2000-01-01', 120000, 2000, 'S', 1, 1, 'U', 1),
(16, 20, 13, 'Utah', '2000-01-01', 200000, 2500, 'S', 1, 1, 'null', 1);

-- --------------------------------------------------------

--
-- Table structure for table `home_ins`
--

DROP TABLE IF EXISTS `home_ins`;
CREATE TABLE IF NOT EXISTS `home_ins` (
  `hinsid` int(11) NOT NULL AUTO_INCREMENT,
  `cust_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_amount` bigint(13) NOT NULL,
  `status` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'C',
  PRIMARY KEY (`hinsid`),
  KEY `fk_cust_id` (`cust_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `home_ins`
--

INSERT INTO `home_ins` (`hinsid`, `cust_id`, `start_date`, `end_date`, `total_amount`, `status`) VALUES
(6, 11, '2020-05-09', '2021-05-09', 1475, 'C'),
(5, 6, '2020-05-09', '2021-05-09', 2368, 'C'),
(4, 1, '2020-05-09', '2021-05-09', 2346, 'C'),
(7, 11, '2020-05-09', '2021-05-09', 3464, 'C'),
(8, 15, '2020-05-09', '2021-05-09', 974, 'C'),
(9, 8, '2020-05-09', '2021-05-09', 2368, 'C'),
(10, 1, '2020-05-09', '2021-05-09', 1229, 'C'),
(11, 1, '2020-05-13', '2022-05-13', 6972, 'C'),
(12, 16, '2020-05-13', '2021-05-13', 1564, 'C'),
(13, 20, '2020-05-13', '2022-05-13', 2490, 'C');

-- --------------------------------------------------------

--
-- Table structure for table `home_ins_payments`
--

DROP TABLE IF EXISTS `home_ins_payments`;
CREATE TABLE IF NOT EXISTS `home_ins_payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_date` date DEFAULT NULL,
  `due_date` date NOT NULL,
  `amount` bigint(20) DEFAULT NULL,
  `payment_type` varchar(6) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT 'Check',
  `hinsid` int(11) NOT NULL COMMENT 'Foreign key giving all info about the insurance',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '0 means payment not done',
  PRIMARY KEY (`payment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `home_ins_payments`
--

INSERT INTO `home_ins_payments` (`payment_id`, `payment_date`, `due_date`, `amount`, `payment_type`, `hinsid`, `status`) VALUES
(10, NULL, '2021-05-09', 974, 'Check', 8, 0),
(9, NULL, '2021-05-09', 3464, 'Check', 7, 0),
(8, NULL, '2021-05-09', 1475, 'Check', 6, 0),
(7, NULL, '2021-05-09', 2368, 'Check', 5, 0),
(6, '2020-05-10', '2021-05-09', 2346, 'Paypal', 4, 1),
(11, NULL, '2021-05-09', 2368, 'Check', 9, 0),
(12, '2020-05-12', '2021-05-09', 1229, 'Paypal', 10, 1),
(13, '2020-05-12', '2021-05-13', 3486, 'Paypal', 11, 1),
(14, '2020-05-12', '2022-05-13', 3486, 'Paypal', 11, 1),
(15, NULL, '2021-05-13', 1564, 'Check', 12, 0),
(16, '2020-05-12', '2021-05-13', 1245, 'Paypal', 13, 1),
(17, NULL, '2022-05-13', 1245, 'Check', 13, 0);

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

DROP TABLE IF EXISTS `vehicles`;
CREATE TABLE IF NOT EXISTS `vehicles` (
  `vin` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cust_id` int(11) NOT NULL,
  `ainsid` int(11) NOT NULL DEFAULT '0',
  `vehicle_type` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'CAR' COMMENT 'Car, Truck, Bike',
  `make` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Name of the company',
  `model` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Model of the vehicle',
  `year` int(4) NOT NULL,
  `status` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'O' COMMENT 'L, F, O possible options',
  PRIMARY KEY (`vin`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`vin`, `cust_id`, `ainsid`, `vehicle_type`, `make`, `model`, `year`, `status`) VALUES
('556', 20, 16, 'Bike', 'Bajaj', 'Splendor', 2014, 'O'),
('6672', 18, 15, 'Bike', 'Bajaj', 'Splendor', 2015, 'L'),
('5566', 1, 9, 'Truck', 'Tototya', 'hhh', 2015, 'F'),
('2651', 11, 8, 'Car', 'Ford', 'Fiesta', 2012, 'O'),
('1234', 1, 7, 'Car', 'Toyota', 'Supra', 2019, 'O');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
