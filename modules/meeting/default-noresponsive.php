<?php
	if($_SESSION['user_os']=='mobile'){
	include("modules/meeting/main/meeting_mobile.php");
	}
	else{
	echo "<br />";
	echo "<br />";
	echo "<br />";
	echo "<div align='center'><img src='modules/meeting/images/meeting.bmp' border='0' width='30%'></div>";
	}
?>

