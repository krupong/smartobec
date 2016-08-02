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
if(!isset($_SESSION['admin_book'])){
$_SESSION['admin_book']="";
}
echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>"; 
echo "<tr bgcolor='#FFCC00'><td>";
echo "<ul id='nav' class='dropdown dropdown-horizontal'>";
	echo "<li><a href='./'>รายการหลัก</a></li>";
	if($_SESSION['admin_book']=="book"){
	echo "<li><a href='?option=book' class='dir'>ตั้งค่าระบบ</a>";
		echo "<ul>";
			echo "<li><a href='?option=book&task=permission'>กำหนดสารบรรณ สพฐ,</a></li>";
			echo "<li><a href='?option=book&task=permission_sch_khet'>กำหนดสารบรรณ สถานศึกษา</a></li>";
			echo "<li><a href='?option=book&task=main/group'>กำหนดกลุ่มสถานศึกษา</a></li>";
			echo "<li><a href='?option=book&task=main/group_member'>กำหนดสมาชิกกลุ่มสถานศึกษา</a></li>";
			echo "<li><a href='?option=book&task=main/group_member_report'>รายงานกลุ่มและสมาชิก</a></li>";
		echo "</ul>";
	echo "</li>";
	}
	
	if ($_SESSION['login_status']==12 or $_SESSION['login_status']==13){
	echo "<li><a href='?option=book&task=permission_sch' class='dir'>กำหนดเจ้าหน้าที่</a>";
		echo "<ul>";
			echo "<li><a href='?option=book&task=permission_sch'>กำหนดเจ้าหน้าที่</a></li>";
		echo "</ul>";
	echo "</li>";
	}
	
	if(!($_SESSION['login_status']==99)){
	echo "<li><a href='?option=book&task=main/receive' class='dir'>หนังสือรับ</a>";
		echo "<ul>";
			echo "<li><a href='?option=book&task=main/receive'>หนังสือรับมา</a></li>";
	echo "</ul>";
	echo "</li>";

	echo "<li><a href='?option=book&task=main/send' class='dir'>หนังสือส่ง</a>";
		echo "<ul>";
			echo "<li><a href='?option=book&task=main/send'>หนังสือส่งไป</a></li>";
		echo "</ul>";
	echo "</li>";
	}
	
	if (!($_SESSION['login_status']==5 or $_SESSION['login_status']==15 or $_SESSION['login_status']==99) ){
	echo "<li><a href='?option=book&task=main/send&index=1' class='dir'>ส่งหนังสือราชการ</a>";
		echo "<ul>";
			echo "<li><a href='?option=book&task=main/send&index=1'>ส่งหนังสือราชการ</a></li>";
		echo "</ul>";
	echo "</li>";
	}
	
	echo "<li><a href='?option=book' class='dir'>คู่มือ</a>";
		echo "<ul>";
				echo "<li><a href='modules/book/manual/book.pdf' target='_blank'>คู่มือ</a></li>";
		echo "</ul>";
	echo "</li>";
echo "</ul>";
echo "</td></tr>";
echo "</table>";
?>
