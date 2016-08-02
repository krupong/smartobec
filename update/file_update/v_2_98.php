<?php
$sql="ALTER TABLE  `bookregister_certificate` ADD  `subject2` VARCHAR( 250 ) NOT NULL AFTER  `subject`";
$query = mysqli_query($connect,$sql);

$sql="CREATE TABLE IF NOT EXISTS `bookregister_cer_sign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(13) NOT NULL,
  `name` varchar(200) NOT NULL,
  `position1` varchar(200) NOT NULL,
  `position2` varchar(200) NOT NULL,
  `sign_pic` varchar(150) NOT NULL,
  `sign_now` tinyint(4) NOT NULL DEFAULT '0',
  `officer` varchar(13) NOT NULL,
  `rec_date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `bookregister_certificate` ADD  `sign_person` VARCHAR( 4 ) NOT NULL AFTER  `comment`";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `bookregister_certificate` ADD  `khet_print` TINYINT NOT NULL DEFAULT  '0' AFTER  `file_name`";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `bookregister_certificate` ADD  `check_status` TINYINT NOT NULL DEFAULT  '0' AFTER  `khet_print`";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `bookregister_send` ADD  `workgroup` TINYINT NOT NULL DEFAULT  '0' AFTER  `operation`";
$query = mysqli_query($connect,$sql);

$sql="CREATE TABLE IF NOT EXISTS `bookregister_cer_officer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` varchar(13) NOT NULL,
  `p1` tinyint(4) NOT NULL,
  `officer` varchar(13) NOT NULL,
  `rec_date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `person_id` (`person_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `bookregister_certificate` ADD  `quarantee` TINYINT NOT NULL DEFAULT  '0' AFTER  `check_status` ";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `bookregister_certificate` ADD  `quarantee_person` VARCHAR( 13 ) NOT NULL AFTER  `quarantee`";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `bookregister_certificate` ADD  `quarantee_date` DATE NOT NULL AFTER  `quarantee_person`";
$query = mysqli_query($connect,$sql);

?>
