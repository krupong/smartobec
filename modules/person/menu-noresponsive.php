<?php	
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//sd page 

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
	if(($_SESSION['admin_person']=="person") or ($_SESSION['login_status']==999) or ($_SESSION['login_group']==1 and $result_permission['p1']==1)){	
	echo "<li><a href='?option=person' class='dir'>ตั้งค่าระบบ</a>";
		echo "<ul>";
			echo "<li><a href='?option=person&task=permission'>เจ้าหน้าที่ระบบข้อมูลบุคลากร</a></li>";
			echo "<li><a href='?option=person&task=position'>ตำแหน่งบุคลากร สพฐ.</a></li>";
		//	if(($_SESSION['admin_person']=="person") or ($_SESSION['login_status']<=4 and $result_permission['p1']==1)){
			echo "<li><a href='?option=person&task=khet_position'>ตำแหน่งบุคลากร สพท.</a></li>";
			echo "<li><a href='?option=person&task=sch_position'>ตำแหน่งบุคลากร สถานศึกษา</a></li>";
			echo "<li><a href='?option=person&task=special_position'>ตำแหน่งบุคลากรหน่วยงานพิเศษ สพฐ.</a></li>";
		//	}
			//echo "<li><a href='?option=person&task=person_import'>นำเข้าข้อมูลบุคลากร สพฐ.</a></li>";
			//echo "<li><a href='?option=person&task=person_special_import'>นำเข้าข้อมูลบุคลากรหน่วยงานพิเศษ สพฐ.</a></li>";
			//echo "<li><a href='?option=person&task=person_khet_import'>นำเข้าข้อมูลบุคลากร สพท.</a></li>";
			//echo "<li><a href='?option=person&task=person_sch_import'>นำเข้าข้อมูลบุคลากร สถานศึกษา</a></li>";
			//echo "<li><a href='?option=person&task=update_picture1'>ปรับปรุงข้อมูลรูปภาพบุคลากร สพฐ.</a></li>";
			//echo "<li><a href='?option=person&task=update_picture2'>ปรับปรุงข้อมูลรูปภาพบุคลากร สพท.</a></li>";
		echo "</ul>";
	echo "</li>";
	}
	
	if(($_SESSION['admin_person']=="person") or ($result_permission['p1']==1)){	
	echo "<li><a href='?option=person' class='dir'>บุคลากรปัจจุบัน</a>";
		echo "<ul>";
			echo "<li><a href='?option=person&task=person'>สพฐ.</a></li>";
			//if(($_SESSION['admin_person']=="person") or ($_SESSION['login_status']<=4 and $result_permission['p1']==1)){
			echo "<li><a href='?option=person&task=person_khet'>สำนักงานเขตพื้นที่การศึกษา</a></li>";
			echo "<li><a href='?option=person&task=person_sch'>สถานศึกษา</a></li>";
			echo "<li><a href='?option=person&task=person_special'>หน่วยงานพิเศษ สพฐ</a></li>";
			//}
	echo "</ul>";
	echo "</li>";
	}	
	
	if($_SESSION['login_group']==1){	
	echo "<li><a href='?option=person' class='dir'>รักษาราชการแทน</a>";
		echo "<ul>";
			if($result_permission['p2']==1){
			echo "<li><a href='?option=person&task=delegate'>เจ้าหน้าที่บันทึกข้อมูล</a></li>";
			}
			if(!($result_permission['p2']==1)){
			echo "<li><a href='?option=person&task=report_delegate'>ผู้รักษาราชการแทน</a></li>";
			}
	echo "</ul>";
	echo "</li>";
	}	
	
	if(($_SESSION['admin_person']=="person") or ($result_permission['p1']==1)){	
	echo "<li><a href='?option=person' class='dir'>บุคลากรในอดีต</a>";
		echo "<ul>";
			//echo "<li><a href='?option=person&task=change_status_person'>สพฐ.</a></li>";
			//echo "<li><a href='?option=person&task=change_status_person_special'>หน่วยงานพิเศษ สพฐ.</a></li>";
			//echo "<li><a href='?option=person&task=change_status_person_khet'>สำนักงานเขตพื้นที่การศึกษา</a></li>";
			//echo "<li><a href='?option=person&task=change_status_person_sch'>สถานศึกษา</a></li>";
	echo "</ul>";
	echo "</li>";
	}	
	
	echo "<li><a href='?option=person' class='dir'>รายงาน</a>";
		echo "<ul>";
			echo "<li><a href='?option=person&task=person_report1'>บุคลากร สพฐ.</a></li>";
			echo "<li><a href='?option=person&task=person_special_report1'>บุคลากร หน่วยงานพิเศษ สพฐ.</a></li>";
			echo "<li><a href='?option=person&task=person_khet_report1'>บุคลากร สพท.</a></li>";
			echo "<li><a href='?option=person&task=person_sch_report1'>บุคลากร สถานศึกษา</a></li>";
		echo "</ul>";
	echo "</li>";
	echo "<li><a href='?option=person' class='dir'>คู่มือ</a>";
		echo "<ul>";
		echo "<li><a href='modules/person/manual/person.pdf' target='_blank'>คู่มือข้อมูลพื้นฐานบุคลากร</a></li>";
		echo "</ul>";
	echo "</li>";
echo "</ul>";
echo "</td></tr>";
echo "</table>";
?>
