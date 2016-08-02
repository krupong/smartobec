<?php

$sql="ALTER TABLE `bookregister_receive` ADD `book_link` TINYINT NOT NULL DEFAULT '0' AFTER `officer`";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE `book_main` ADD `bookregis_link` TINYINT NOT NULL DEFAULT '0' AFTER `send_date`";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `system_module` ADD  `where_work` TINYINT NOT NULL DEFAULT  '0' AFTER  `url`";
$query = mysqli_query($connect,$sql);

?>
