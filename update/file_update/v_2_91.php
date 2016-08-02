<?php
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

?>
