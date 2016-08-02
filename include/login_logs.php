<?php
$sqlloginlog = "insert into login_logs(personid) values(".$_SESSION["login_user_id"].")";
mysqli_query($connect, $sqlloginlog);
?>