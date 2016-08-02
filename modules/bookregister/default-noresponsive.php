<?php
	if($_SESSION['user_os']=='mobile'){
			if($_SESSION['login_status']<=4){
			include("modules/bookregister/main/receive_mobile.php");	
			}
			else if(($_SESSION['login_status']>10) and ($_SESSION['login_status']<=15)){
			include("modules/bookregister/main/receive_sch_mobile.php");	
			}
	}
	else{
	echo "<br />";
	echo "<br />";
	echo "<div align='center'><img src='modules/bookregister/images/register.jpg' border='0' width='20%'></div>";
	}
?>

