<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

//ส่วนการสร้างตารางระบบย่อย
$sql_create="CREATE TABLE `meeting_main` (
  `id` int(11) NOT NULL auto_increment,
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
  `officer_date` datetime DEFAULT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1" ;
$query = mysqli_query($connect,$sql_create);

$sql_create="CREATE TABLE `meeting_permission` (
  `id` int(11) NOT NULL auto_increment,
  `person_id` varchar(13) NOT NULL,
  `p1` tinyint(4) NOT NULL,
  `officer` varchar(13) NOT NULL,
  `rec_date` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1" ;
$query = mysqli_query($connect,$sql_create);

$sql_create="CREATE TABLE `meeting_room` (
  `id` int(11) NOT NULL auto_increment,
  `room_code` tinyint(4) NOT NULL,
  `room_name` varchar(100) NOT NULL,
  `department` tinyint(4) NOT NULL,
  `person_max` tinyint(4) NOT NULL,
  `room_detail` varchar(255) NOT NULL,
  `room_image` varchar(255) NOT NULL,
  `room_controller` varchar(255) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1" ;
$query = mysqli_query($connect,$sql_create);

?>
