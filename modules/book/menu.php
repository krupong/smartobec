<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

if($_SESSION['login_group']==1){
$sql_permission = "select * from  book_permission where person_id='$_SESSION[login_user_id]'";
$dbquery_permission = mysqli_query($connect,$sql_permission);
$result_permission = mysqli_fetch_array($dbquery_permission);
}
if($_SESSION['login_group']==2){
$sql_permission = "select * from  book_permission where person_id='$_SESSION[login_user_id]' and p4='$_SESSION[system_user_khet]' ";
$dbquery_permission = mysqli_query($connect,$sql_permission);
$result_permission = mysqli_fetch_array($dbquery_permission);
}
if($_SESSION['login_group']==3){
$sql_permission = "select * from  book_permission where person_id='$_SESSION[login_user_id]' and p4='$_SESSION[system_user_school]' ";
$dbquery_permission = mysqli_query($connect,$sql_permission);
$result_permission = mysqli_fetch_array($dbquery_permission);
}
if($_SESSION['login_group']==4){
$sql_permission = "select * from  book_permission where person_id='$_SESSION[login_user_id]' and p4='$_SESSION[system_user_specialunit]' ";
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

if($_SESSION['login_group']==1){ ?>

			<li class='dropdown'><a href='' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'><span class='glyphicon glyphicon-copy' aria-hidden='true'></span>&nbsp;หนังสือรับ / หนังสือส่ง<span class='caret'></span></a>
				<ul class='dropdown-menu' role='menu'>
									<li><a href='?option=book&task=main/receive_obec_new'>หนังสือเข้าใหม่</a></li>

					<li><a href='?option=book&task=main/receive'>หนังสือรับ</a></li>
					<li><a href='?option=book&task=main/send'>หนังสือส่ง</a></li>
				</ul>
			</li>
			<li class='dropdown'><a href='?option=book&task=main/send&index=1' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'><span class='glyphicon glyphicon-envelope' aria-hidden='true'></span>&nbsp;ส่งหนังสือราชการ <span class='caret'></span></a>
				<ul class='dropdown-menu' role='menu'>
					<li><a href='?option=book&task=main/send&index=1'>ส่งหนังสือราชการ</a></li>
				</ul>
			</li>
<?php } 

if($_SESSION['login_group']>=2 and $result_permission['p4']){ ?>
	
			<li class='dropdown'><a href='' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'><span class='glyphicon glyphicon-paste' aria-hidden='true'></span>&nbsp;ตั้งค่าระบบ<span class='caret'></span></a>
				<ul class='dropdown-menu' role='menu'>					
					<li><a href='?option=book&task=main/office_no'>กำหนดเลขที่หนังสือ</a></li>
					<li><a href='?option=book&task=permission_sch_khet_person'>กำหนดสารบรรณ สพท.</a></li>
				</ul>
			</li>
<?php } 

if($_SESSION['login_group']>=2 and $result_permission['p4']){ ?>
			<li class='dropdown'><a href='?option=book&task=main/receive' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'><span class='glyphicon glyphicon-copy' aria-hidden='true'></span>&nbsp;หนังสือรับ / หนังสือส่ง<span class='caret'></span></a>
				<ul class='dropdown-menu' role='menu'>		
									<li><a href='?option=book&task=main/receive_in'>หนังสือเข้าใหม่</a></li>
					<li><a href='?option=book&task=main/receive'>หนังสือรับ</a></li>
					<li><a href='?option=book&task=main/send'>หนังสือส่ง</a></li>
				</ul>
			</li>
<?php } 

if($_SESSION['login_group']>=2 and $result_permission['p4']){ ?>						
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