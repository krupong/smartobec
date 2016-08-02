<?php	
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//sd page 

$sql_permission = "select * from  mail_permission where person_id='$_SESSION[login_user_id]'";
$dbquery_permission = mysqli_query($connect,$sql_permission);
$result_permission = mysqli_fetch_array($dbquery_permission);

if(!isset($_SESSION['admin_mail'])){
$_SESSION['admin_mail']="";
}

echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>"; 
echo "<tr bgcolor='#FFCC00'><td>";
echo "<ul id='nav' class='dropdown dropdown-horizontal'>";
	echo "<li><a href='./'>รายการหลัก</a></li>";
	if($_SESSION['login_status']<=500){	
	echo "<li><a href='?option=mail&task=main/receive_mobile' class='dir'>รับจดหมาย</a></li>";
	echo "<li><a href='?option=mail&task=main/send_mobile' class='dir'>จดหมายส่ง</a></li>";
	echo "<li><a href='?option=mail&task=main/send_mobile&index=1' class='dir'>เขียน</a>";
	echo "</li>";
	}
echo "</ul>";
echo "</td></tr>";
echo "</table>";
?>
