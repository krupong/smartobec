<?php

$sql="ALTER TABLE  `bookregister_year` ADD  `school_code` VARCHAR( 15 ) NULL AFTER  `start_cer_num` ,
ADD  `officer` VARCHAR( 13 ) NULL AFTER  `school_code` ,
ADD  `rec_date` DATE NOT NULL AFTER  `officer`";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE `bookregister_year` DROP INDEX `year`";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `bookregister_permission` ADD  `p2` TINYINT NULL AFTER  `p1` ,
ADD  `school_code` VARCHAR( 15 ) NULL AFTER  `p2`
 ";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `bookregister_office_no` ADD  `office_type` TINYINT NOT NULL DEFAULT  '1' AFTER  `office_no` ,
ADD  `officer` VARCHAR( 13 ) NULL AFTER  `office_type` ,
ADD  `rec_date` DATE NULL AFTER  `officer`
";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `bookregister_office_no` CHANGE  `office_type`  `school_code` VARCHAR( 15 ) NULL";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `bookregister_send` ADD  `office_type` TINYINT NOT NULL DEFAULT  '1' AFTER  `secret`";
$query = mysqli_query($connect,$sql);

$sql="CREATE TABLE `bookregister_receive_sch` (
  `ms_id` int(11) NOT NULL auto_increment,
  `school_code` varchar(15) NOT NULL,
  `year` int(11) NOT NULL,
  `register_number` int(11) NOT NULL,
  `book_no` varchar(50) NOT NULL,
  `signdate` date NOT NULL,
  `book_from` varchar(200) NOT NULL,
  `book_to` varchar(200) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `operation` varchar(150) default NULL,
  `comment` varchar(100) default NULL,
  `register_date` date NOT NULL,
  `ref_id` varchar(50) NOT NULL,
  `officer` varchar(13) default NULL,
  `book_link` tinyint(4) NOT NULL default '0',
  `secret` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`ms_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1
";
$query = mysqli_query($connect,$sql);

$sql="CREATE TABLE `bookregister_receive_filebook_sch` (
  `id` int(11) NOT NULL auto_increment,
  `school_code` varchar(15) NOT NULL,
  `ref_id` varchar(50) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `file_des` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1
";
$query = mysqli_query($connect,$sql);

$sql="CREATE TABLE `bookregister_send_sch` (
  `ms_id` int(11) NOT NULL auto_increment,
  `school_code` varchar(15) NOT NULL,
  `year` int(11) NOT NULL,
  `register_number` int(11) NOT NULL,
  `book_no` varchar(50) NOT NULL,
  `signdate` date NOT NULL,
  `book_from` varchar(200) NOT NULL,
  `book_to` varchar(200) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `operation` varchar(150) default NULL,
  `comment` varchar(100) default NULL,
  `register_date` date NOT NULL,
  `ref_id` varchar(50) NOT NULL,
  `officer` varchar(13) default NULL,
  `secret` tinyint(4) NOT NULL default '0',
  `office_type` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`ms_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1
";
$query = mysqli_query($connect,$sql);

$sql="CREATE TABLE `bookregister_send_filebook_sch` (
  `id` int(11) NOT NULL auto_increment,
  `ref_id` varchar(50) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `file_des` varchar(100) NOT NULL,
  `school_code` varchar(15) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1
";
$query = mysqli_query($connect,$sql);

$sql="CREATE TABLE `bookregister_command_sch` (
  `ms_id` int(11) NOT NULL auto_increment,
  `school_code` varchar(15) NOT NULL,
  `year` int(11) NOT NULL,
  `register_number` int(11) NOT NULL,
  `book_no` varchar(50) NOT NULL,
  `signdate` date NOT NULL,
  `subject` varchar(150) NOT NULL,
  `comment` varchar(100) default NULL,
  `register_date` date NOT NULL,
  `officer` varchar(13) default NULL,
  `file_name` varchar(100) default NULL,
  `file_des` varchar(100) default NULL,
  PRIMARY KEY  (`ms_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1
";
$query = mysqli_query($connect,$sql);

$sql="CREATE TABLE `bookregister_certificate_sch` (
  `ms_id` int(11) NOT NULL auto_increment,
  `school_code` varchar(15) NOT NULL,
  `year` int(11) NOT NULL,
  `register_number` int(11) NOT NULL,
  `book_no` varchar(50) NOT NULL,
  `signdate` date NOT NULL,
  `name_cer` varchar(150) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `comment` varchar(100) default NULL,
  `register_date` date NOT NULL,
  `officer` varchar(13) default NULL,
  `file_name` varchar(50) default NULL,
  PRIMARY KEY  (`ms_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1
";
$query = mysqli_query($connect,$sql);

?>
