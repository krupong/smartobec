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

	if($_SESSION['admin_bookregister']=="bookregister" or $result_permission['saraban_status']==1){		//กำหนดสิทธิ์ให้เห็นเมนู  admin และ สารบรรณกลาง สพฐ. ?>
	<li class='dropdown'>
		<a href='?option=bookregister' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>
			<span class='glyphicon glyphicon-cog' aria-hidden='true'></span>
			&nbsp;ตั้งค่าระบบ <span class='caret'></span>
		</a>
		<ul class='dropdown-menu' role='menu'>
			<li><a href='?option=bookregister&task=permission'>กำหนดเจ้าหน้าที่</a></li>
			<li><a href='?option=bookregister&task=year'>กำหนดปีปฏิทิน สพฐ.</a></li>
			<li><a href='?option=bookregister&task=main/office_no'>กำหนดเลขที่หนังสือ</a></li>
			<!--//			echo "<li><a href='?option=bookregister&task=main/cer_sign'>กำหนดผู้ลงนามเกียรติบัตร</a></li>";-->
			<!--//			echo "<li><a href='?option=bookregister&task=cer_officer'>กำหนดผู้ตรวจสอบการลงทะเบียนเกียรติบัตร</a></li>";-->
		</ul>
	</li>
	<?php }
	//เมนูสารบรรณสำนัก
	if($result_permission['saraban_status']==2){ 	//กำหนดสิทธิ์ให้เห็นเมนู  สารบรรณสำนัก ?>
		<li class='dropdown'>
			<a href='?option=bookregister' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>
				<span class='glyphicon glyphicon-cog' aria-hidden='true'></span>
				&nbsp;ตั้งค่าระบบสำนัก <span class='caret'></span>
			</a>
			<ul class='dropdown-menu' role='menu'>
				<li><a href='?option=bookregister&task=permission_de'>กำหนดเจ้าหน้าที่</a></li>
				<li><a href='?option=bookregister&task=year_de'>กำหนดปีปฏิทิน สำนัก</a></li>
				<li><a href='?option=bookregister&task=main/office_no'>กำหนดเลขที่หนังสือ</a></li>
				<li>-----บทบาทกลุ่ม-------</li>
				<li><a href='?option=bookregister&task=year_g'>กำหนดปีปฏิทิน กลุ่ม</a></li>
				<!--	//		echo "<li><a href='?option=bookregister&task=main/cer_sign'>กำหนดผู้ลงนามเกียรติบัตร</a></li>";-->
				<!--	//		echo "<li><a href='?option=bookregister&task=cer_officer'>กำหนดผู้ตรวจสอบการลงทะเบียนเกียรติบัตร</a></li>";-->
			</ul>
		</li>
		<?php }
	//เมนูสารบรรณกลุ่ม
	if($result_permission['saraban_status']==3){ 	//กำหนดสิทธิ์ให้เห็นเมนู  สารบรรณกลุ่ม ?>
			<li class='dropdown'>
				<a href='?option=bookregister' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>
					<span class='glyphicon glyphicon-cog' aria-hidden='true'></span>
					&nbsp;ตั้งค่าระบบกลุ่ม <span class='caret'></span>
				</a>
				<ul class='dropdown-menu' role='menu'>
					<!--	<li><a href='?option=bookregister&task=permission'>กำหนดเจ้าหน้าที่</a></li>-->
					<li><a href='?option=bookregister&task=year_g'>กำหนดปีปฏิทิน กลุ่ม</a></li>
					<!--	<li><a href='?option=bookregister&task=main/office_no'>กำหนดเลขที่หนังสือ</a></li>-->
					<!--	<li><a href='?option=bookregister&task=main/cer_sign'>กำหนดผู้ลงนามเกียรติบัตร</a></li>-->
					<!--	<li><a href='?option=bookregister&task=cer_officer'>กำหนดผู้ตรวจสอบการลงทะเบียนเกียรติบัตร</a></li>-->
				</ul>
			</li>
			<?php }


	//เมนูทะเบียนหนังสือ สารบรรณกลุ่ม
	if($result_permission['saraban_status']==3){	//กำหนดสิทธิ์ให้เห็นเมนู  สารบรรณกลุ่ม ?>
				<li class='dropdown'>
					<a href='?option=bookregister&task=main/receive_g' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'><span class='glyphicon glyphicon-copy' aria-hidden='true'></span>
						&nbsp;ทะเบียนหนังสือรับ/ส่ง กลุ่ม <span class='caret'></span>
					</a>
					<ul class='dropdown-menu' role='menu'>
						<li><a href='?option=bookregister&task=main/receive_g'>ทะเบียนหนังสือรับกลุ่ม</a></li>
						<li><a href='?option=bookregister&task=main/send_g'>ทะเบียนหนังสือส่งกลุ่ม</a></li>
					</ul>
				</li>
	<?php }

//เมนูทะเบียนหนังสือ สารบรรณสำนัก
	if($result_permission['saraban_status']==2){	//กำหนดสิทธิ์ให้เห็นเมนู  สารบรรณสำนัก ?>
				<li class='dropdown'>
					<a href='?option=bookregister&task=main/receive_de' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>
					<span class='glyphicon glyphicon-copy' aria-hidden='true'></span>
						&nbsp;ทะเบียนหนังสือรับ/ส่ง สำนัก <span class='caret'></span>
					</a>
					<ul class='dropdown-menu' role='menu'>
						<li><a href='?option=bookregister&task=main/receive_de'>ทะเบียนหนังสือรับสำนัก</a></li>
						<li><a href='?option=bookregister&task=main/send_de'>ทะเบียนหนังสือส่งสำนัก</a></li>
						<li>-----บทบาทกลุ่ม-------</li>
						<li><a href='?option=bookregister&task=main/receive_g'>ทะเบียนหนังสือรับกลุ่ม</a></li>
						<li><a href='?option=bookregister&task=main/send_g'>ทะเบียนหนังสือส่งกลุ่ม</a></li>
						</ul>
					</li>
	<?php }

	if($_SESSION['admin_bookregister']=="bookregister" or $result_permission['saraban_status']==1){	 //กำหนดสิทธิ์ให้เห็นเมนู  admin และ สารบรรณกลาง สพฐ. ?>
		<li class='dropdown'>
			<a href='?option=bookregister&task=main/receive' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>
				<span class='glyphicon glyphicon-copy' aria-hidden='true'></span>&nbsp;ทะเบียนหนังสือรับ/ส่ง สพฐ. <span class='caret'></span>
			</a>
				<ul class='dropdown-menu' role='menu'>
					<li><a href='?option=bookregister&task=main/receive'>ทะเบียนหนังสือรับ สพฐ.</a></li>
					<li><a href='?option=bookregister&task=main/send'>ทะเบียนหนังสือส่ง สพฐ.</a></li>
				</ul>
			</li>
			<li class='dropdown'>
				<a href='?option=bookregister&task=main/command' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>
					<span class='glyphicon glyphicon-tasks' aria-hidden='true'></span>
					&nbsp;ทะเบียนคำสั่ง สพฐ. <span class='caret'></span>
				</a>
				<ul class='dropdown-menu' role='menu'>
					<li><a href='?option=bookregister&task=main/command'>ทะเบียนคำสั่ง สพฐ.</a></li>
				</ul>
				<!--</li>-->
				<!--<li><a href='?option=bookregister&task=main/certificate' class='dir'>ทะเบียนเกียรติบัตร</a>-->
				<!--<ul>-->
				<!--<li><a href='?option=bookregister&task=main/certificate'>ทะเบียนเกียรติบัตร</a></li>-->
				<!--<li><a href='?option=bookregister&task=main/certificate_officer'>เจ้าหน้าที่ทะเบียนเกียรติบัตร</a></li>-->
				<!--</ul>-->
				<!--</li>-->
				<?php }?>

				<li class='dropdown'><a href='?option=bookregister' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'><span class='glyphicon glyphicon-book' aria-hidden='true'></span>&nbsp;คู่มือ <span class='caret'></span></a>
					<ul class='dropdown-menu' role='menu'>
						<li><a href='modules/bookregister/manual/bookregister.pdf' target='_blank'>คู่มือ</a></li>
					</ul>
				</li>
