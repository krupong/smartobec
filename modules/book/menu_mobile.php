<?php	
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//sd page 

if($_SESSION['login_status']<=5){
$sql_permission = "select * from  book_permission where person_id='$_SESSION[login_user_id]'";
$dbquery_permission = mysqli_query($connect,$sql_permission);
$result_permission = mysqli_fetch_array($dbquery_permission);
}
if(($_SESSION['login_status']>10) and ($_SESSION['login_status']<=15)){
$sql_permission = "select * from  book_permission where person_id='$_SESSION[login_user_id]' and p3='$_SESSION[user_school]' ";
$dbquery_permission = mysqli_query($connect,$sql_permission);
$result_permission = mysqli_fetch_array($dbquery_permission);
}
echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>"; 
echo "<tr bgcolor='#FFCC00'><td>";
echo "<ul id='nav' class='dropdown dropdown-horizontal'>";
	echo "<li><a href='./'>รายการหลัก</a></li>";
	
if(!($_SESSION['login_status']==99)){
	echo "<li><a href='?option=book&task=main/receive_mobile' class='dir'>หนังสือรับ</a></li>";
	echo "<li><a href='?option=book&task=main/send_mobile' class='dir'>หนังสือส่ง</a></li>";
}
	
echo "</ul>";
echo "</td></tr>";
echo "</table>";
?>
