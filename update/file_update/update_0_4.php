<?php
$sql="ALTER TABLE  `person_permission` ADD  `p2` TINYINT NOT NULL AFTER  `p1`" ;
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `system_department` ADD  `department_precis` VARCHAR( 30 ) NOT NULL AFTER  `department_name` " ;
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `system_khet` ADD  `khet_precis` VARCHAR( 50 ) NOT NULL AFTER  `khet_name` " ;
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `system_special_unit` ADD  `unit_presis` VARCHAR( 50 ) NOT NULL AFTER  `unit_name` " ;
$query = mysqli_query($connect,$sql);

$sql="CREATE TABLE `system_sync` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `office_code` int(11) NOT NULL,
  `system_name` varchar(50) NOT NULL,
  `url` varchar(50) NOT NULL,
  `server_ip` varchar(50) NOT NULL,
  `sync_code` varchar(50) NOT NULL,
  `officer` varchar(13) NOT NULL,
  `rec_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1" ;
$query = mysqli_query($connect,$sql);

$sql="CREATE TABLE `person_delegate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` varchar(13) NOT NULL,
  `start` date NOT NULL,
  `finish` date NOT NULL,
  `officer` varchar(13) NOT NULL,
  `rec_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1" ;
$query = mysqli_query($connect,$sql);

?>
