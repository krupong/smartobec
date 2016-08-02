<?php
	if($_SESSION['user_os']=='mobile'){
	include("modules/book/main/receive_mobile.php");	
	}
	else{
	echo "<br />";
	echo "<br />";
	echo "<br />";
	echo "<div align='center'><img src='modules/book/images/book.png' border='0' width='20%'></div>";
	}
?>
