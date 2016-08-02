<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr bgcolor="#26354A"><td height="40" colspan="6" class="logo" nowrap="nowrap">&nbsp;AMSS++</td></tr>
	<tr bgcolor="#26354A"><td colspan="6" align="right" class="user"><font color="#FFFFFF">
<?php 
if(isset($_SESSION['login_user_id'])){
echo "$_SESSION[login_name]&nbsp;";
		if(isset($_SESSION['login_surname'])){
		echo $_SESSION['login_surname'];
		}
		if($_SESSION['login_status']==5 or $_SESSION['login_status']==15){
		echo "<script>alert('การ Login ด้วยเลขประจำตัวประชาชน เพื่อไปกำหนด Username และ Password กรุณาไปที่หน้าเว็บปกติ [AMSS++ for Desktop]');</script>\n";
		}
		if(isset($_SESSION['system_school_name'])){
		echo "&nbsp;[";
		echo $_SESSION['system_school_name'];
		echo "]&nbsp";
		}
echo "&nbsp;";
echo "<a href=logout.php>[ออก]</a>";
}
?>
 	</font></td></tr>
	
<?php 	
if(isset($alert)){	
		if($alert==1){
		echo "<script>alert('$alert_content');</script>\n";
		}
}

	if($_GET['option']!=""){
	echo "<tr bgcolor='#FFCC00'>";
	echo "<td colspan='6'>";
	echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
	echo "<tr bgcolor='#6699FF'>";
	echo "<td align='left' nowrap='nowrap' class=stylemenu height='14'>&nbsp;&nbsp;&nbsp;";
	echo $_SESSION['module_name_'.$_GET['option']];
	echo "</td><td align='right'>";
	echo "<span id='Aclock' ></span>";
	echo "&nbsp;&nbsp;&nbsp;";
date_default_timezone_set('Asia/Bangkok');
	echo "</td></tr>";
	echo "</tr>";
	echo "</table>";
	echo "</td></tr>";
	}
	else{
	require_once("menu_mobile.php");
	}
	  ?>
	<tr>
	<td colspan="6">
	<!-- Content -->
	
		<?php require_once("".$MODPATHFILE."") ?>
	<!-- End Content -->
	</td>
	</tr>
</table>
