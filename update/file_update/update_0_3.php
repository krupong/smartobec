<?php
$sql="ALTER TABLE  `person_main` ADD  `sub_department` INT NOT NULL AFTER  `department`" ;
$query = mysqli_query($connect,$sql);

?>
