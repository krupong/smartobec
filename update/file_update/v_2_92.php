<?php

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

?>
