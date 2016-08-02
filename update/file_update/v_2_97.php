<?php

$sql="ALTER TABLE  `bookregister_receive` ADD  `workgroup` TINYINT NOT NULL DEFAULT  '0' AFTER  `operation` ,
ADD  `record_type` TINYINT NOT NULL DEFAULT  '0' AFTER  `workgroup`";
$query = mysqli_query($connect,$sql);

?>
