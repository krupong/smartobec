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

	if($_SESSION['admin_book']=="book"){?>
	<li class='dropdown'><a href='?option=book' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'><span class='glyphicon glyphicon-cog' aria-hidden='true'></span>&nbsp;ตั้งค่าระบบ <span class='caret'></span></a>
		<ul class='dropdown-menu' role='menu'>
			<li><a href='?option=book&task=permission'>กำหนดสารบรรณ สพฐ,</a></li>
			<li><a href='?option=book&task=permission_sch_khet'>กำหนดสารบรรณ สพท.</a></li>
			<li><a href='?option=book&task=main/group'>กำหนดกลุ่มผู้รับ</a></li>
			<li><a href='?option=book&task=main/group_member'>กำหนดสมาชิกกลุ่มผู้รับ</a></li>
			<li><a href='?option=book&task=main/group_member_report'>รายงานกลุ่มและสมาชิก</a></li>
		</ul>
	</li>
	<?php }

	if ($_SESSION['login_status']==12 or $_SESSION['login_status']==13){ ?>
		<li class='dropdown'><a href='?option=book&task=permission_sch' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'><span class='glyphicon glyphicon-user' aria-hidden='true'></span>&nbsp;กำหนดเจ้าหน้าที่ <span class='caret'></span></a>
			<ul class='dropdown-menu' role='menu'>
				<li><a href='?option=book&task=permission_sch'>กำหนดเจ้าหน้าที่</a></li>
			</ul>
		</li>
		<?php }

	if(!($_SESSION['login_status']==99)){ ?>
			<li class='dropdown'><a href='?option=book&task=main/receive' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'><span class='glyphicon glyphicon-copy' aria-hidden='true'></span>&nbsp;หนังสือรับ <span class='caret'></span></a>
				<ul class='dropdown-menu' role='menu'>
					<li><a href='?option=book&task=main/receive'>หนังสือรับมา</a></li>
				</ul>
			</li>

			<li class='dropdown'><a href='?option=book&task=main/send' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'><span class='glyphicon glyphicon-paste' aria-hidden='true'></span>&nbsp;หนังสือส่ง <span class='caret'></span></a>
				<ul class='dropdown-menu' role='menu'>
					<li><a href='?option=book&task=main/send'>หนังสือส่งไป</a></li>
				</ul>
			</li>
			<?php }

	if (!($_SESSION['login_status']==5 or $_SESSION['login_status']==15 or $_SESSION['login_status']==99) ){ ?>
			<li class='dropdown'><a href='?option=book&task=main/send&index=1' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'><span class='glyphicon glyphicon-envelope' aria-hidden='true'></span>&nbsp;ส่งหนังสือราชการ <span class='caret'></span></a>
				<ul class='dropdown-menu' role='menu'>
					<li><a href='?option=book&task=main/send&index=1'>ส่งหนังสือราชการ</a></li>
				</ul>
			</li>
			<?php } ?>

				<li class='dropdown'><a href='?option=book' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'><span class='glyphicon glyphicon-book' aria-hidden='true'></span>&nbsp;คู่มือ <span class='caret'></span></a>
					<ul class='dropdown-menu' role='menu'>
						<li><a href='modules/book/manual/book.pdf' target='_blank'>คู่มือ</a></li>
					</ul>
				</li>