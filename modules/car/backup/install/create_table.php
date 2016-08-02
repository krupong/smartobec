<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

//ส่วนการสร้างตารางระบบย่อย
$sql_create="CREATE TABLE `car_car` (
  `id` int(11) NOT NULL auto_increment,
  `car_code` int(11) NOT NULL,
  `car_type` int(11) NOT NULL,
  `car_number` varchar(100) NOT NULL,
  `name` varchar(150) NOT NULL,
  `pic` varchar(150) NOT NULL,
  `status` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `car_code` (`car_code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
$query = mysqli_query($connect,$sql_create);

$sql_create="CREATE TABLE `car_driver` (
  `id` int(11) NOT NULL auto_increment,
  `person_id` varchar(13) NOT NULL,
  `status` tinyint(4) NOT NULL default '0',
  `officer` varchar(13) default NULL,
  `rec_date` date default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1" ;
$query = mysqli_query($connect,$sql_create);

$sql_create="CREATE TABLE `car_main` (
  `id` int(11) NOT NULL auto_increment,
  `person_id` varchar(13) NOT NULL,
  `rec_date` date NOT NULL,
  `car` int(11) NOT NULL,
  `place` varchar(200) NOT NULL,
  `because` varchar(200) NOT NULL,
  `car_start` date NOT NULL,
  `time_start` float default NULL,
  `car_finish` date NOT NULL,
  `time_finish` float default NULL,
  `day_total` int(11) default NULL,
  `person_num` int(11) default NULL,
  `control_person` varchar(100) default NULL,
  `fuel` tinyint(4) NOT NULL,
  `project` varchar(100) default NULL,
  `activity` varchar(100) default NULL,
  `money` double default NULL,
  `self_driver` tinyint(4) default NULL,
  `private_car` tinyint(4) default NULL,
  `car_owner` varchar(100) default NULL,
  `private_car_number` varchar(100) default NULL,
  `private_driver` varchar(100) default NULL,
  `driver` varchar(13) default NULL,
  `officer_comment` varchar(150) default NULL,
  `officer_sign` varchar(13) default NULL,
  `officer_date` datetime default NULL,
  `group_comment` varchar(150) default NULL,
  `group_sign` varchar(13) default NULL,
  `group_date` datetime default NULL,
  `grant_comment` varchar(150) default NULL,
  `commander_grant` tinyint(4) default NULL,
  `commander_sign` varchar(13) default NULL,
  `commander_date` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1" ;
$query = mysqli_query($connect,$sql_create);

$sql_create="CREATE TABLE `car_permission` (
  `id` int(11) NOT NULL auto_increment,
  `person_id` varchar(13) NOT NULL,
  `p1` tinyint(4) default NULL,
  `officer` varchar(13) NOT NULL,
  `rec_date` date NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `person_id` (`person_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1" ;
$query = mysqli_query($connect,$sql_create);

$sql_create="CREATE TABLE `car_type` (
  `id` int(11) NOT NULL auto_increment,
  `code` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1" ;
$query = mysqli_query($connect,$sql_create);

$sql_create="CREATE TABLE `car_report` (
  `id` int(11) NOT NULL auto_increment,
  `person_id` varchar(13) NOT NULL,
  `rec_date` datetime NOT NULL,
  `car` int(11) NOT NULL,
  `place` varchar(200) NOT NULL,
  `because` varchar(200) default NULL,
  `car_start` date default NULL,
  `time_start` float default NULL,
  `car_finish` date default NULL,
  `time_finish` float default NULL,
  `day_total` int(11) default NULL,
  `person_num` int(11) default NULL,
  `control_person` varchar(100) default NULL,
  `start_mile` varchar(10) default NULL,
  `finish_mile` varchar(10) NOT NULL,
  `fuel` int(11) NOT NULL,
  `detail` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1" ;
$query = mysqli_query($connect,$sql_create);

?>
