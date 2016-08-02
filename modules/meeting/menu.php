<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

//$sql_permission = "select * from  meeting_permission where person_id='$_SESSION[login_user_id]'";
//$dbquery_permission = mysqli_query($connect,$sql_permission);
//$result_permission = mysqli_fetch_array($dbquery_permission);
$login_group=mysqli_real_escape_string($connect,$_SESSION['login_group']);
if(!($login_group<=1)){
exit(); 
}

if(!isset($_SESSION['login_user_id'])){ $_SESSION['login_user_id']=""; exit();
}else{
//หาสิทธิ์
$login_user_id=mysqli_real_escape_string($connect,$_SESSION['login_user_id']);
    $sql_user_permission="select * from system_module_admin where person_id=? and module='meeting' ";
    $query_user_permission = $connect->prepare($sql_user_permission);
    $query_user_permission->bind_param("i", $login_user_id);
    $query_user_permission->execute();
    $result_quser_permission=$query_user_permission->get_result();
While ($result_user_permission = mysqli_fetch_array($result_quser_permission))
   {
    $user_adminmodule=$result_user_permission['module'];
    }
if(!isset($user_adminmodule)){
$user_adminmodule="";
}

//หาสิทธิ์ใน meeting
    $sql_user_meeting="select * from meeting_permission where person_id=? ";
    $query_user_meeting = $connect->prepare($sql_user_meeting);
    $query_user_meeting->bind_param("i", $login_user_id);
    $query_user_meeting->execute();
    $query_quser_meeting=$query_user_meeting->get_result();
While ($result_user_meeting = mysqli_fetch_array($query_quser_meeting))
   {
    $user_permismeeting=$result_user_meeting['p1'];
    }
 if(!isset($user_permismeeting)){
$user_permismeeting="";
}
}

	if($user_adminmodule=="meeting" or $user_permismeeting==1){ ?>
	<li class='dropdown'>
		<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>
			<span class='glyphicon glyphicon-cog' aria-hidden='true'></span>
			&nbsp;ตั้งค่าระบบ <span class='caret'></span>
		</a>
		<ul class='dropdown-menu' role='menu'>
			<li><a href='?option=meeting&task=main/permission'>กำหนดเจ้าหน้าที่</a></li>
			<li><a href='?option=meeting&task=main/set_room'>กำหนดห้องประชุม</a></li>
		</ul>
	</li>
	<?php }
	if($login_group<=1){ ?>
	<li class='dropdown'>
		<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>
			<span class='glyphicon glyphicon-edit' aria-hidden='true'></span>
			&nbsp;จองห้องประชุม <span class='caret'></span>
		</a>
		<ul class='dropdown-menu' role='menu'>
			<li><a href='?option=meeting&task=main/meeting'>จองห้องประชุม</a></li>
			<li><a href='?option=meeting&task=main/search'>ค้นหาห้องประชุมว่าง</a></li>
		<?php if(($user_permismeeting==1)){ ?>
			<li><a href='?option=meeting&task=main/officer'>อนุญาตให้ใช้ห้องประชุม</a></li>
			<li><a href='?option=meeting&task=main/meeting_dep'>รายการจองของคนในสำนัก</a></li>
		<?php } ?>
		</ul>
	</li>
	<?php }
	if($login_group<=1){ ?>
	<li class='dropdown'>
		<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>
			<span class='glyphicon glyphicon-stats' aria-hidden='true'></span>
			&nbsp;รายงาน <span class='caret'></span>
		</a>
		<ul class='dropdown-menu' role='menu'>
			<?php // if(($user_permismeeting==1) or ($user_adminmodule=="meeting")){ ?>
			<li><a href='?option=meeting&task=main/report1'>สรุปการใช้ห้องประชุมในสำนัก</a></li>
			<?php// } ?>
		</ul>
	</li>
	<?php } ?>
	<li class='dropdown'>
		<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>
			<span class='glyphicon glyphicon-book' aria-hidden='true'></span>
			&nbsp;คู่มือ <span class='caret'></span>
		</a>
		<ul class='dropdown-menu' role='menu'>
			<li><a href='modules/meeting/manual/meeting.pdf' target='_blank'>คู่มือจองห้องประชุม</a></li>
		</ul>
	</li>

