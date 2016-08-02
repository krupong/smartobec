<?php	
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
?>
<!-- เมนู -->
<?php
// เมนูสำหรับผู้ดูแล Module
$sqladmin = "SELECT * FROM system_module_admin WHERE module='ioffice' and person_id='".$_SESSION["login_user_id"]."'";
$resultadmin = mysqli_query($connect, $sqladmin);
$numadmin = mysqli_num_rows($resultadmin);
// เปลี่ยนจาก ioffice เป็นชื่อ Module
if($numadmin>0){
?>
	<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class='glyphicon glyphicon-cog' aria-hidden='true'></span>&nbsp;ตั้งค่าระบบ <span class="caret"></span></a>
		<ul class="dropdown-menu" role="menu">
			<li><a href="?option=<?php echo $_GET['option']; ?>&task=book_bookpass">กำหนดรองเลขาฯ ประจำสำนัก</a></li>
		</ul>
	</li>
<?php 
}
// จบส่วนเมนูผู้ดูแล Module
?>
<!-- เมนูผู้ใช้งานทั่วไป -->
<li class="dropdown"> <!-- เมนู Dropdown -->
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class='glyphicon glyphicon-file' aria-hidden='true'></span>&nbsp;บันทึกเสนอ <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li><a href="?option=<?php echo $_GET['option']; ?>&task=book_insert">เพิ่มบันทึกเสนอใหม่</a></li> <!-- เมนูย่อยใน Dropdown -->
        <li><a href="?option=<?php echo $_GET['option']; ?>&task=book_select">รายการบันทึกเสนอ</a></li> <!-- เมนูย่อยใน Dropdown -->
    </ul>
</li>
<li><a href="?option=<?php echo $_GET['option']; ?>&task=book_pass"><span class='glyphicon glyphicon-check' aria-hidden='true'></span>&nbsp;ลงความเห็น/สั่งการ<!-- &nbsp;<span class='badge'>3</span> --></a></li> <!-- เมนูไม่ Dropdown -->
<li><a href="?option=<?php echo $_GET['option']; ?>&task=book_search"><span class='glyphicon glyphicon-search' aria-hidden='true'></span>&nbsp;ค้นหา</a></li> <!-- เมนูไม่ Dropdown -->
<li><a href="/modules/<?php echo $_GET['option']; ?>/manual/manual.pdf"><span class='glyphicon glyphicon-paperclip' aria-hidden='true'></span>&nbsp;คู่มือ</a></li> <!-- เมนูไม่ Dropdown -->
