<?php	
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//sd page 

$sql_permission = "select * from  bookregister_permission where person_id='$_SESSION[login_user_id]'";
$dbquery_permission = mysqli_query($connect,$sql_permission);
$result_permission = mysqli_fetch_array($dbquery_permission);

if(!isset($_SESSION['admin_bookregister'])){
$_SESSION['admin_bookregister']="";
}

echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>"; 
echo "<tr bgcolor='#FFCC00'><td>";
echo "<ul id='nav' class='dropdown dropdown-horizontal'>";
	echo "<li><a href='./'>รายการหลัก</a></li>";
        //เมนูตัวอย่าง
	echo "<li><a href='#' class='dir'>ทดสอบใช้งาน</a>";
		echo "<ul>";
			echo "<li><a href='?option=book2&task=main/receive_newbook'>หนังสือเข้าใหม่</a></li>";
			echo "<li><a href='?option=book2&task=main/receive_newbook_wait'>เรื่องรอดำเนินการ</a></li>";
			echo "<li><a href='?option=book2&task=main/receive_paper'>รับหนังสือจากกระดาษ</a></li>";
			echo "<li><a href='?option=book2&task=main/setting_role_person'>กำหนดบทบาทให้บุคคล</a></li>";
			echo "<li><a href='?option=book2&task=main/show_role_person'>บทบาทบุคคล</a></li>";
			echo "<li><a href='?option=book2&task=main/send_addbook'>ออกเลขหนังสือส่ง</a></li>";
		echo "</ul>";
	echo "</li>";
/*
        //if($_SESSION['admin_bookregister']=="bookregister" or $result_permission['p1']==1){
	echo "<li><a href='?option=bookregister' class='dir'>ตั้งค่าระบบ</a>";
		echo "<ul>";
			echo "<li><a href='?option=bookregister&task=permission'>กำหนดเจ้าหน้าที่</a></li>";
			echo "<li><a href='?option=bookregister&task=year'>กำหนดปีปฏิทิน</a></li>";
			echo "<li><a href='?option=bookregister&task=main/office_no'>กำหนดเลขที่หนังสือ</a></li>";
			echo "<li><a href='?option=bookregister&task=main/cer_sign'>กำหนดผู้ลงนามเกียรติบัตร</a></li>";
			echo "<li><a href='?option=bookregister&task=cer_officer'>กำหนดผู้ตรวจสอบการลงทะเบียนเกียรติบัตร</a></li>";
		echo "</ul>";
	echo "</li>";
	//}
	/*
	if($result_permission['p2']==1 or $_SESSION['login_status']==12 or $_SESSION['login_status']==13){
	echo "<li><a href='?option=bookregister' class='dir'>ตั้งค่าระบบ(ร.ร.)</a>";
		echo "<ul>";
			if($_SESSION['login_status']==12 or $_SESSION['login_status']==13){
			echo "<li><a href='?option=bookregister&task=permission_sch'>กำหนดเจ้าหน้าที่</a></li>";
			}
			echo "<li><a href='?option=bookregister&task=year_sch'>กำหนดปีปฏิทิน</a></li>";
			echo "<li><a href='?option=bookregister&task=main/office_no_sch'>กำหนดเลขที่หนังสือ</a></li>";
		echo "</ul>";
	echo "</li>";
	}
	
if($_SESSION['login_status']<=4){
	echo "<li><a href='?option=bookregister&task=main/receive' class='dir'>ทะเบียนหนังสือรับ</a>";
		echo "<ul>";
			echo "<li><a href='?option=bookregister&task=main/receive'>ทะเบียนหนังสือรับ</a></li>";
		echo "</ul>";
	echo "</li>";

	echo "<li><a href='?option=bookregister&task=main/send' class='dir'>ทะเบียนหนังสือส่ง</a>";
		echo "<ul>";
			echo "<li><a href='?option=bookregister&task=main/send'>ทะเบียนหนังสือส่ง</a></li>";
		echo "</ul>";
	echo "</li>";
	echo "<li><a href='?option=bookregister&task=main/command' class='dir'>ทะเบียนคำสั่ง</a>";
		echo "<ul>";
			echo "<li><a href='?option=bookregister&task=main/command'>ทะเบียนคำสั่ง</a></li>";
		echo "</ul>";
	echo "</li>";
	echo "<li><a href='?option=bookregister&task=main/certificate' class='dir'>ทะเบียนเกียรติบัตร</a>";
		echo "<ul>";
			echo "<li><a href='?option=bookregister&task=main/certificate'>ทะเบียนเกียรติบัตร</a></li>";
			echo "<li><a href='?option=bookregister&task=main/certificate_officer'>เจ้าหน้าที่ทะเบียนเกียรติบัตร</a></li>";
		echo "</ul>";
	echo "</li>";
}	

if(($_SESSION['login_status']>10) and ($_SESSION['login_status']<=15)){
	echo "<li><a href='?option=bookregister&task=main/receive_sch' class='dir'>ทะเบียนหนังสือรับ</a>";
		echo "<ul>";
			echo "<li><a href='?option=bookregister&task=main/receive_sch'>ทะเบียนหนังสือรับ</a></li>";
		echo "</ul>";
	echo "</li>";

	echo "<li><a href='?option=bookregister&task=main/send_sch' class='dir'>ทะเบียนหนังสือส่ง</a>";
		echo "<ul>";
			echo "<li><a href='?option=bookregister&task=main/send_sch'>ทะเบียนหนังสือส่ง</a></li>";
		echo "</ul>";
	echo "</li>";
	echo "<li><a href='?option=bookregister&task=main/command_sch' class='dir'>ทะเบียนคำสั่ง</a>";
		echo "<ul>";
			echo "<li><a href='?option=bookregister&task=main/command_sch'>ทะเบียนคำสั่ง</a></li>";
		echo "</ul>";
	echo "</li>";
	echo "<li><a href='?option=bookregister&task=main/certificate_sch' class='dir'>ทะเบียนเกียรติบัตร</a>";
		echo "<ul>";
			echo "<li><a href='?option=bookregister&task=main/certificate_sch'>ทะเบียนเกียรติบัตร</a></li>";
			echo "<li><a href='?option=bookregister&task=main/certificate_school_print'>เกียรติบัตรสพท.</a></li>";
		echo "</ul>";
	echo "</li>";
}	*/

	echo "<li><a href='?option=bookregister' class='dir'>คู่มือ</a>";
		echo "<ul>";
				echo "<li><a href='modules/bookregister/manual/bookregister.pdf' target='_blank'>คู่มือ</a></li>";
		echo "</ul>";
	echo "</li>";
echo "</ul>";
echo "</td></tr>";
echo "</table>";
?>
