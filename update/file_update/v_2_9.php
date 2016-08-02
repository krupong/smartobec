<?php
$sql="ALTER TABLE  `la_main` CHANGE  `la_total`  `la_total` FLOAT( 11 ) NOT NULL ";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `la_main` CHANGE  `last_la_total`  `last_la_total` FLOAT( 11 ) NULL DEFAULT NULL ";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `la_main` CHANGE  `sick_ago`  `sick_ago` FLOAT( 11 ) NULL DEFAULT NULL ";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `la_main` CHANGE  `sick_this`  `sick_this` FLOAT( 11 ) NULL DEFAULT NULL ";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `la_main` CHANGE  `sick_total`  `sick_total` FLOAT( 11 ) NULL DEFAULT NULL ";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `la_main` CHANGE  `privacy_ago`  `privacy_ago` FLOAT( 11 ) NULL DEFAULT NULL ";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `la_main` CHANGE  `privacy_this`  `privacy_this` FLOAT( 11 ) NULL DEFAULT NULL ";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `la_main` CHANGE  `privacy_total`  `privacy_total` FLOAT( 11 ) NULL DEFAULT NULL ";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `la_main` CHANGE  `birth_ago`  `birth_ago` FLOAT( 11 ) NULL DEFAULT NULL ";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `la_main` CHANGE  `birth_this`  `birth_this` FLOAT( 11 ) NULL DEFAULT NULL ";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `la_main` CHANGE  `birth_total`  `birth_total` FLOAT( 11 ) NULL DEFAULT NULL ";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `la_main` CHANGE  `relax_ago`  `relax_ago` FLOAT( 11 ) NULL DEFAULT NULL ";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `la_main` CHANGE  `relax_this`  `relax_this` FLOAT( 11 ) NULL DEFAULT NULL ";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `la_main` CHANGE  `relax_total`  `relax_total` FLOAT( 11 ) NULL DEFAULT NULL ";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `la_main` CHANGE  `relax_collect`  `relax_collect` FLOAT( 11 ) NULL DEFAULT NULL ";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `la_main` CHANGE  `relax_this_year`  `relax_this_year` FLOAT( 11 ) NULL DEFAULT NULL";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `la_collect` CHANGE  `collect_day`  `collect_day` FLOAT( 4 ) NOT NULL DEFAULT  '0' ";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `la_cancel` CHANGE  `permission_total`  `permission_total` FLOAT( 11 ) NOT NULL ";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `la_cancel` CHANGE  `cancel_la_total`  `cancel_la_total` FLOAT( 11 ) NOT NULL ";
$query = mysqli_query($connect,$sql);

//plan
$sql="ALTER TABLE  `plan_acti` CHANGE  `budget_acti`  `budget_acti` DOUBLE NOT NULL DEFAULT  '0.00' ";
$query = mysqli_query($connect,$sql);

$sql="ALTER TABLE  `plan_acti` CHANGE  `budget_approve`  `budget_approve` DOUBLE NOT NULL DEFAULT  '0.00' ";
$query = mysqli_query($connect,$sql);

?>
