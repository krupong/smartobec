<?php
	if($_SESSION['user_os']=='mobile'){
	include("modules/car/main/car_request_mobile.php");
	}
	else{
	echo "<br />";
	echo "<br />";
	echo "<br />";
	echo "<div align='center'><img src='modules/car/images/logo.png' border='0' width='30%'></div>";
	}
?>
