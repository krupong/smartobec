<?php
//2.91
$sql="ALTER TABLE  `system_school` ADD  `school_group` INT NULL AFTER  `school_name` ";
$query = mysqli_query($connect,$sql);

$sql="CREATE TABLE `system_school_group` (
  `id` int(11) NOT NULL auto_increment,
  `code` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `budget_deega` CHANGE  `deega_num`  `deega_num` FLOAT NULL DEFAULT NULL";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `budget_withdraw` CHANGE  `deega`  `deega` FLOAT NULL DEFAULT NULL";
$query = mysqli_query($connect,$sql);

//2.92
$sql="ALTER TABLE  `person_sch_main` ADD  `other` TINYINT NULL AFTER  `rec_date` ";
$query = mysqli_query($connect,$sql);

$sql="CREATE TABLE `person_sch_other` (
  `id` int(11) NOT NULL auto_increment,
  `person_id` varchar(13) NOT NULL,
  `school_code` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL default '0',
  `officer` varchar(13) default NULL,
  `rec_date` date default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
$query = mysqli_query($connect,$sql);

//2.93
$sql="ALTER TABLE  `system_module` ADD  `where_work` TINYINT NOT NULL DEFAULT  '0' AFTER  `url`";
$query = mysqli_query($connect,$sql);

//mail
$sql="ALTER TABLE  `mail_main` ADD INDEX (  `ref_id` )";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `mail_sendto_answer` ADD INDEX (  `ref_id` )";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `mail_sendto_answer` ADD INDEX (  `send_to` )";
$query = mysqli_query($connect,$sql);

//book
$sql="ALTER TABLE  `book_main` ADD UNIQUE (`ref_id`)";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `book_main` ADD INDEX (  `ref_id` )";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `book_main` ADD INDEX (  `book_type` )";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `book_main` ADD INDEX (  `office` )";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `book_sendto_answer` ADD INDEX (  `ref_id` )";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `book_sendto_answer` ADD INDEX (  `school` )";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `book_sendto_answer` ADD INDEX (  `send_to` )";
$query = mysqli_query($connect,$sql);

//student_main
$sql="CREATE TABLE IF NOT EXISTS `student_main_main` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ed_year` int(11) NOT NULL,
  `ref_id` varchar(20) NOT NULL,
  `school_code` varchar(15) NOT NULL,
  `student_id` varchar(15) NOT NULL,
  `person_id` varchar(13) NOT NULL,
  `prename` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `sex` varchar(5) NOT NULL,
  `school_name` varchar(150) NOT NULL,
  `classlevel` tinyint(4) NOT NULL,
  `classroom` tinyint(4) NOT NULL DEFAULT '1',
  `disable` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `rec_date` date NOT NULL,
  `officer` varchar(13) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
$query = mysqli_query($connect,$sql);

//permission
$sql="ALTER TABLE  `permission_main` ADD  `report_read` VARCHAR( 13 ) NOT NULL AFTER  `report_date` ,ADD  `report_read_date` DATETIME NOT NULL AFTER  `report_read`";
$query = mysqli_query($connect,$sql);

?>
