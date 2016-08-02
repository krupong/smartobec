<?php	
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
?>
<!-- เมนู -->
<?php
//book_permission  ตรวจสอบสารบรรณ รร. จากระบบรับ - ส่ง
$sql_permission_sch = "select person_id from  book_permission where person_id='$_SESSION[login_user_id]' and p4 > '0' ";
$dbquery_permission_sch = mysqli_query($connect,$sql_permission_sch);
$result_permission_sch = mysqli_fetch_array($dbquery_permission_sch);	
$total_permission_sch = mysqli_num_rows($dbquery_permission_sch);

// เมนูสำหรับผู้ดูแล Module
$sql_permission = "select * from person_permission where person_id='$_SESSION[login_user_id]'";
$dbquery_permission = mysqli_query($connect,$sql_permission);
$result_permission = mysqli_fetch_array($dbquery_permission);
// เปลี่ยนจาก ioffice เป็นชื่อ Module
if(!isset($_SESSION['admin_ioffice'])){ $_SESSION['admin_ioffice']=""; }
if(!isset($_SESSION['admin_person'])){ $_SESSION['admin_person']=""; }
if(($_SESSION['admin_person']=="person") or ($_SESSION['login_status']==999) or ($_SESSION['login_group']==1 and $result_permission['p1']==1)) {
	?>
	<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">ตั้งค่าระบบ <span class="caret"></span></a>
		<ul class="dropdown-menu" role="menu">
        	<li><a href="?option=person&task=permission">เจ้าหน้าที่ระบบข้อมูลบุคลากร</a></li> <!-- เมนูย่อยใน Dropdown -->
            <li class="divider"></li> <!-- ขีดเส้นขั้นระหว่างเมนูย่อยใน Dropdown -->
        	<li><a href="?option=person&task=position">ตำแหน่งบุคลากร สพฐ.</a></li> <!-- เมนูย่อยใน Dropdown -->
        	<li><a href="?option=person&task=khet_position">ตำแหน่งบุคลากร สพท.</a></li> <!-- เมนูย่อยใน Dropdown -->
        	<li><a href="?option=person&task=sch_position">ตำแหน่งบุคลากร สถานศึกษา</a></li> <!-- เมนูย่อยใน Dropdown -->
        	<li><a href="?option=person&task=special_position">ตำแหน่งบุคลากรหน่วยงานพิเศษ สพฐ.</a></li> <!-- เมนูย่อยใน Dropdown -->
        	<li><a href="?option=person&task=position">ตำแหน่งบุคลากร สพฐ.</a></li> <!-- เมนูย่อยใน Dropdown -->
		</ul>
	</li>
<?php 
}
if(($_SESSION['admin_person']=="person") or ($result_permission['p1']==1)) {
?>
	<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">ข้อมูลบุคลากร<span class="caret"></span></a>
		<ul class="dropdown-menu" role="menu">
        	<li><a href="?option=person&task=person">สพฐ.</a></li> <!-- เมนูย่อยใน Dropdown -->
        	<li><a href="?option=person&task=person_khet">สำนักงานเขตพื้นที่การศึกษา</a></li> <!-- เมนูย่อยใน Dropdown -->
        	<li><a href="?option=person&task=person_sch">สถานศึกษา</a></li> <!-- เมนูย่อยใน Dropdown -->
        	<li><a href="?option=person&task=person_special">หน่วยงานพิเศษ สพฐ</a></li> <!-- เมนูย่อยใน Dropdown -->
		
		</ul>
	</li>
<?php 
}	
if(($_SESSION['login_group']==1) and (($_SESSION['admin_person']=="person") or ($result_permission['p2']==1))) {
?>
	<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">การปฏิบัติราชการ<span class="caret"></span></a>
		<ul class="dropdown-menu" role="menu">
			<li><a href="?option=person&task=book_bookpass">กำหนดรองเลขาฯ / ผู้ช่วยเลขาฯ ประจำสำนัก</a></li>
        	<li><a href="?option=person&task=delegate">บันทึกข้อมูลการรักษาราชการแทน</a></li> <!-- เมนูย่อยใน Dropdown -->
        	<li><a href="?option=person&task=report_delegate">รายการผู้รักษาราชการแทน</a></li> <!-- เมนูย่อยใน Dropdown -->
		</ul>
	</li>
<?php 
}
?>
<?php
if($total_permission_sch == 1){
	echo "<li><a href='?option=person&task=person_khet2' class='dir'>ข้อมูลบุคลากร</a>";
	}
	?>
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">รายงาน <span class="caret"></span></a>
	<ul class="dropdown-menu" role="menu">
       	<li><a href="?option=person&task=person_report1">บุคลากร สพฐ.</a></li> <!-- เมนูย่อยใน Dropdown -->
       	<li><a href="?option=person&task=person_special_report1">บุคลากร หน่วยงานพิเศษ สพฐ.</a></li> <!-- เมนูย่อยใน Dropdown -->
       	<li><a href="?option=person&task=person_khet_report1">บุคลากร สพท.</a></li> <!-- เมนูย่อยใน Dropdown -->
       	<li><a href="?option=person&task=person_sch_report1">บุคลากร สถานศึกษา</a></li> <!-- เมนูย่อยใน Dropdown -->
	</ul>
</li>
<li><a href="/modules/person/manual/manual.pdf">คู่มือ</a></li> <!-- เมนูไม่ Dropdown -->