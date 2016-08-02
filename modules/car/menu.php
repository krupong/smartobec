<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

$sql_permission = "select * from  car_permission where person_id='$_SESSION[login_user_id]'";
$dbquery_permission = mysqli_query($connect,$sql_permission);
$result_permission = mysqli_fetch_array($dbquery_permission);
$user_permission=$result_permission['p1'];
if(!isset($user_permission))   $user_permission="";

// Car Driver
$sql_driver = "select * from  car_driver where person_id='$_SESSION[login_user_id]'";
$dbquery_driver = mysqli_query($connect,$sql_driver);
$result_driver = mysqli_fetch_array($dbquery_driver);
$isdriver="";
$isdriver=$result_driver['status'];

// ผู้อำนวยกลุ่ม สำหรับ อนุมัติรถ หามาจาก position other code ผอ กลุ่มจะมีรหัส subdepartment มาใส่
$sql_commander = "select * from  person_main where person_id='$_SESSION[login_user_id]'";
$dbquery_commander = mysqli_query($connect,$sql_commander);
$result_commander = mysqli_fetch_array($dbquery_commander);
$iscommander="";
$iscommander=$result_commander['position_other_code'];
$login_dep=$result_commander['sub_department'];



if(!isset($_SESSION['admin_car'])){
$_SESSION['admin_car']="";
}

	if(($_SESSION['admin_car']=="car")  or ($result_permission['p1']==1)){ ?>
	<li class='dropdown'>
		<a href='?option=car' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>
			<span class='glyphicon glyphicon-cog' aria-hidden='true'></span>
			&nbsp;ตั้งค่าระบบ <span class='caret'></span></a>
		<ul class='dropdown-menu' role='menu'>
			<li><a href='?option=car&task=permission'>กำหนดเจ้าหน้าที่</a></li>
			<?php if($result_permission['p1']==1){ ?>
			<li><a href='?option=car&task=car_type'>กำหนดประเภท</a></li>
			<li><a href='?option=car&task=car_list'>กำหนดยานพาหนะ</a></li>
			<li><a href='?option=car&task=set_driver'>กำหนดพนักงานขับรถ</a></li>
			<?php } ?>
		</ul>
	</li>
	<?php }

	if($_SESSION['login_group']<=4){ ?>
	<li class='dropdown'>
		<a href='?option=car&task=car_request'>
			<span class='glyphicon glyphicon-road' aria-hidden='true'></span>
			&nbsp;ขอใช้ยานพาหนะ
		</a>
	</li>
	<?php }
	if(($iscommander != 0) or ($_SESSION['login_group']<=4 and $result_permission['p1']==1)){ // สำหรับ ผอ สำนัก อนุมัติรถ?> 
	<li>
		<a href='?option=car&task=car_officer&subm=car_commander'>
			<span class='glyphicon glyphicon-check' aria-hidden='true'></span>
			&nbsp;รอ ผอ. กลุ่ม
		</a>
	</li>
	<?php }
	if($_SESSION['login_group']<=4 and $result_permission['p1']==1){ ?>
	<li class='dropdown'>
		<a href='?option=car' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>
			<span class='glyphicon glyphicon-stats' aria-hidden='true'></span>
			&nbsp;รอจัดรถ <span class='caret'></span>
		</a>
		<ul class='dropdown-menu' role='menu'>
            <li><a href='?option=car&task=car_officer&from=altclk'>
			<span class='glyphicon glyphicon-user' aria-hidden='true'></span>
			&nbsp;รอจัดรถ</a></li>
            <li><a href='?option=car&task=car_officer_chgDC&subm=car_commander'>
			<span class='glyphicon glyphicon-scale' aria-hidden='true'></span>
			&nbsp;แก้ไขคนขับรถใหม่</a></li>
        </ul>
	</li>
	<?php }
	if($isdriver==1){ ?>
	<li>
		<a href='?option=car&task=car_driverjob'>
			<span class='glyphicon glyphicon-copy' aria-hidden='true'></span>
			&nbsp;ภาระกิจที่ได้รับมอบหมาย
		</a>
	</li>
	<?php }

	if($_SESSION['login_group']<=4){ ?>
	<li class='dropdown'>
		<a href='?option=car' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>
			<span class='glyphicon glyphicon-stats' aria-hidden='true'></span>
			&nbsp;รายงาน <span class='caret'></span>
		</a>
		<ul class='dropdown-menu' role='menu'>
			<li><a href='?option=car&task=car_report1'>รายงานสถิติการใช้ยานพาหนะรายสำนัก</a></li>
			<li><a href='?option=car&task=car_reportcar1'>รายงานสถิติการใช้ยานพาหนะ</a></li>
			<li><a href='?option=car&task=car_calendar'>รายงานสถิติปฏิทินการใช้ยานพาหนะ</a></li>
            <li><a href='?option=car&task=car_info1'>รายงานสารสนเทศจำนวนรถ</a></li>
		</ul>
	</li>
	<?php } ?>

	<li class='dropdown'>
		<a href='?option=car' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>
			<span class='glyphicon glyphicon-book' aria-hidden='true'></span>
			&nbsp;คู่มือ <span class='caret'></span>
		</a>
		<ul class='dropdown-menu' role='menu'>
			<li><a href='modules/car/manual/car.pdf' target='_blank'>คู่มือ</a></li>
		</ul>
	</li>