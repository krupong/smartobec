<?php

$sql="ALTER TABLE  `book_main` ADD  `secret` TINYINT NOT NULL DEFAULT  '0' AFTER  `level` ";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `bookregister_send` ADD  `secret` TINYINT NOT NULL DEFAULT  '0' AFTER  `officer`";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `bookregister_receive` ADD  `secret` TINYINT NOT NULL DEFAULT  '0' AFTER  `book_link` ";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `bookregister_year` ADD  `start_command_num` INT NOT NULL DEFAULT  '1' AFTER  `start_send_num` ,
ADD  `start_cer_num` INT NOT NULL DEFAULT  '1' AFTER  `start_command_num` ";
$query = mysqli_query($connect,$sql);

$sql="CREATE TABLE `bookregister_command` (
  `ms_id` int(11) NOT NULL auto_increment,
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ";
$query = mysqli_query($connect,$sql);

$sql="CREATE TABLE `bookregister_certificate` (
  `ms_id` int(11) NOT NULL auto_increment,
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
$query = mysqli_query($connect,$sql);


?>
