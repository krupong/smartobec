<?php
$sql="ALTER TABLE `system_school` CHANGE `school_code` `school_code` VARCHAR( 11 ) NOT NULL ";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE `meeting_main` ADD `person_num` INT NULL AFTER `reason` ,
ADD `other` VARCHAR( 250 ) NULL AFTER `person_num` ";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE `budget_withdraw` ADD `deega` INT NULL AFTER `withdraw_status`" ;
$query = mysqli_query($connect,$sql);

$sql="CREATE TABLE `budget_po` (
  `id` int(11) NOT NULL auto_increment,
  `budget_year` int(11) NOT NULL,
  `deega_num` int(11) default NULL,
  `doc` varchar(20) NOT NULL,
  `plan` varchar(5) NOT NULL,
  `project` varchar(20) NOT NULL,
  `activity` varchar(20) NOT NULL,
  `pay_group` int(4) default NULL,
  `item` varchar(50) NOT NULL default '',
  `withdraw` double NOT NULL default '0',
  `tax` double NOT NULL default '0',
  `pay` double NOT NULL default '0',
  `officer` varchar(13) default NULL,
  `rec_date` date default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 " ;
$query = mysqli_query($connect,$sql);

?>
