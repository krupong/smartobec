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

	if($_SESSION['admin_mail']=="mail"){ ?>
	<li class='dropdown'>
		<a href='?option=mail' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>
			<span class='glyphicon glyphicon-cog' aria-hidden='true'></span>
			&nbsp;ตั้งค่าระบบ <span class='caret'></span>
		</a>
		<ul class='dropdown-menu' role='menu'>
			<li><a href='?option=mail&task=main/permission'>กำหนดเจ้าหน้าที่</a></li>
			<li><a href='?option=mail&task=main/group'>กำหนดกลุ่มบุคลากร</a></li>
			<li><a href='?option=mail&task=main/group_member'>กำหนดสมาชิกกลุ่มบุคลากร</a></li>
			<li><a href='?option=mail&task=main/group_member_report'>รายงานกลุ่มและสมาชิก</a></li>
		</ul>
	</li>
	<?php }
	if($_SESSION['login_group']==1){ ?>
	<li>
		<a href='?option=mail&task=main/send&index=1'><span class='glyphicon glyphicon-envelope' aria-hidden='true'></span>&nbsp;เขียนจดหมาย</a>
	</li>
	<li>
		<a href='?option=mail&task=main/receive'><span class='glyphicon glyphicon-copy' aria-hidden='true'></span>&nbsp;กล่องจดหมายเข้า</a>
	</li>

	<li>
		<a href='?option=mail&task=main/send'><span class='glyphicon glyphicon-paste' aria-hidden='true'></span>&nbsp;จดหมายที่ส่งแล้ว</a>
	</li>
	<?php } ?>

	<li>
		<a href='modules/mail/manual/mail.pdf' target='_blank'><span class='glyphicon glyphicon-book' aria-hidden='true'></span>&nbsp;คู่มือ</a>
	</li>
