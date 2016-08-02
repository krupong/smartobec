-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 15, 2015 at 04:49 AM
-- Server version: 5.6.25
-- PHP Version: 5.6.11

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `amss`
--

-- --------------------------------------------------------

--
-- Table structure for table `meeting_main`
--

CREATE TABLE IF NOT EXISTS `meeting_main` (
  `id` int(11) NOT NULL,
  `room` tinyint(4) NOT NULL,
  `book_date_start` date NOT NULL,
  `book_date_end` date NOT NULL,
  `start_time` tinyint(4) NOT NULL,
  `finish_time` tinyint(4) NOT NULL,
  `chairman` varchar(100) NOT NULL,
  `objective` varchar(250) NOT NULL,
  `person_num` int(5) NOT NULL,
  `book_person` varchar(100) NOT NULL,
  `user_book` varchar(13) NOT NULL,
  `department_book` tinyint(4) NOT NULL,
  `rec_date` datetime NOT NULL,
  `approve` int(11) DEFAULT NULL,
  `reason` varchar(200) DEFAULT NULL,
  `coordinator` varchar(200) NOT NULL,
  `other` varchar(250) NOT NULL,
  `officer` varchar(13) DEFAULT NULL,
  `officer_date` datetime DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `meeting_main`
--


--
-- Table structure for table `meeting_permission`
--

CREATE TABLE IF NOT EXISTS `meeting_permission` (
  `id` int(11) NOT NULL,
  `person_id` varchar(13) NOT NULL,
  `p1` tinyint(4) NOT NULL,
  `officer` varchar(13) NOT NULL,
  `rec_date` date NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `meeting_permission`
--

-- --------------------------------------------------------

--
-- Table structure for table `meeting_room`
--

CREATE TABLE IF NOT EXISTS `meeting_room` (
  `id` int(11) NOT NULL,
  `room_code` tinyint(4) NOT NULL,
  `room_name` varchar(100) NOT NULL,
  `department` tinyint(4) NOT NULL,
  `person_max` tinyint(4) NOT NULL,
  `room_detail` varchar(255) NOT NULL,
  `room_image` varchar(255) NOT NULL,
  `room_controller` varchar(255) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `meeting_room`
--

