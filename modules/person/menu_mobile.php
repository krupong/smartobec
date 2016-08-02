<?php	
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

$sql_permission = "select * from person_permission where person_id='$_SESSION[login_user_id]'";
$dbquery_permission = mysqli_query($connect,$sql_permission);
$result_permission = mysqli_fetch_array($dbquery_permission);

if(!isset($_SESSION['admin_person'])){
$_SESSION['admin_person']="";
}

echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>"; 
echo "<tr bgcolor='#FFCC00'><td>";
echo "<ul id='nav' class='dropdown dropdown-horizontal'>";
echo "<li><a href='./'>รายการหลัก</a></li>";
//echo "<li><a href='?option=person&task=person_report1_mobile'' class='dir'>สำนักงานฯ</a></li>";
//echo "<li><a href='?option=person&task=person_sch_report1_mobile'' class='dir'>สถานศึกษา</a></li>";
echo "</ul>";
echo "</td></tr>";
echo "</table>";
?>
