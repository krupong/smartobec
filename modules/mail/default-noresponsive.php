<?php
	if($_SESSION['user_os']=='mobile'){
	include("modules/mail/main/receive_mobile.php");	
	}
	else{
	echo "<br />";
	echo "<br />";
	echo "<br />";
	echo "<div align='center'><img src='modules/mail/images/message.png' border='0' width='30%'></div>";
	}
?>
