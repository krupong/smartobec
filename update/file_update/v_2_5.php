<?php
$sql="ALTER TABLE `la_main` ADD `because` varchar(250) default NULL AFTER `write_at`" ;
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE `la_main` ADD `no_comment` tinyint(4) NOT NULL default '0'  AFTER `document`" ;
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE `la_main` ADD `job_person` varchar(13) default NULL AFTER `relax_this_year`" ;
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE `la_main` ADD `job_person_sign` tinyint(4) NOT NULL default '0'  AFTER `job_person` " ;
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE `la_cancel` ADD `no_comment` int(11) NOT NULL default '0'  AFTER `cancel_la_total`" ;
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE `permission_main` ADD `no_comment` tinyint(4) NOT NULL default '0' AFTER `document` " ;
$query = mysqli_query($connect,$sql);

$sql="CREATE TABLE `la_collect` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`year` INT NOT NULL ,
`person_id` VARCHAR( 13 ) NOT NULL ,
`collect_day` TINYINT NOT NULL DEFAULT '0',
`this_year_day` TINYINT NOT NULL DEFAULT '0',
`officer` VARCHAR( 13 ) NULL ,
`rec_date` DATE NULL )" ;
$query = mysqli_query($connect,$sql);

?>
