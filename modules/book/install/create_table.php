<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

//ส่วนการสร้างตารางระบบย่อย
$sql_create="CREATE TABLE IF NOT EXISTS `book_filebook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_id` varchar(50) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `file_des` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1" ;
$query = mysqli_query($connect,$sql_create);

$sql_create="CREATE TABLE IF NOT EXISTS `book_group` (
  `grp_id` int(11) NOT NULL AUTO_INCREMENT,
  `grp_name` varchar(50) NOT NULL,
  PRIMARY KEY (`grp_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
$query = mysqli_query($connect,$sql_create);

$sql_create="CREATE TABLE IF NOT EXISTS `book_group_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grp_id` int(11) NOT NULL,
  `school_id` varchar(13) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1" ;
$query = mysqli_query($connect,$sql_create);

$sql_create="CREATE TABLE IF NOT EXISTS `book_main` (
  `ms_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_type` tinyint(4) NOT NULL,
  `sender` varchar(13) NOT NULL,
  `office` varchar(13) NOT NULL,
  `level` tinyint(4) NOT NULL,
  `secret` tinyint(4) NOT NULL DEFAULT '0',
  `bookno` varchar(50) NOT NULL,
  `signdate` date NOT NULL,
  `subject` varchar(150) NOT NULL,
  `detail` text,
  `ref_id` varchar(50) NOT NULL,
  `send_date` datetime NOT NULL,
  `bookregis_link` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ms_id`),
  UNIQUE KEY `ref_id` (`ref_id`),
  KEY `ref_id_2` (`ref_id`),
  KEY `book_type` (`book_type`),
  KEY `office` (`office`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1" ;
$query = mysqli_query($connect,$sql_create);

$sql_create="CREATE TABLE IF NOT EXISTS `book_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` varchar(13) NOT NULL,
  `p1` tinyint(4) DEFAULT NULL,
  `p2` varchar(15) DEFAULT NULL,
  `p3` varchar(15) DEFAULT NULL,
  `officer` varchar(13) NOT NULL,
  `rec_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1" ;
$query = mysqli_query($connect,$sql_create);

$sql_create="CREATE TABLE IF NOT EXISTS `book_sendto_answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `send_level` tinyint(4) DEFAULT NULL,
  `ref_id` varchar(50) NOT NULL,
  `send_to` varchar(13) NOT NULL,
  `school` varchar(15) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `answer` tinyint(4) DEFAULT NULL,
  `answer_time` datetime DEFAULT NULL,
  `forward_from` varchar(15) DEFAULT NULL,
  `rec_forward_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ref_id` (`ref_id`),
  KEY `school` (`school`),
  KEY `send_to` (`send_to`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1" ;
$query = mysqli_query($connect,$sql_create);

?>