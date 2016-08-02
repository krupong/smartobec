<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
?>

<tr bgcolor="#FFCC00">
<td colspan="6">
<ul id="nav" class="dropdown dropdown-horizontal">
	<li><a href="./" class="dir">ตั้งค่าระบบ</a>
		<ul>
			<li><a href="?file=office_name">ชื่อหน่วยงาน</a></li>
			<li><a href="?file=menugroup">เมนูหลัก(Main Menu)</a></li>
			<li><a href="?file=department">สำนักในสพฐ.</a></li>
			<li><a href="?file=subdepartment">กลุ่มงานในสำนักสพฐ.</a></li>
			<li><a href="?file=specialunit_group">ประเภทหน่วยงานพิเศษ สพฐ.</a></li>
			<li><a href="?file=special_unit">หน่วยงานพิเศษ สพฐ.</a></li>
			<li><a href="?file=khet_group">กลุ่ม สพท.</a></li>
			<li><a href="?file=khet">สำนักงานเขตพื้นที่การศึกษา</a></li>
			<li><a href="?file=school">สถานศึกษา</a></li>
		</ul>
	</li>
	<li><a href="./" class="dir">ระบบงานย่อย</a>
		<ul>
			<li><a href="?file=module">ระบบงานย่อย(Module)</a></li>
			<li><a href="?file=module_admin">ผู้ดูแล(Admin)ระบบงานย่อย</a></li>
		</ul>
	</li>
	<li><a href="./" class="dir">การเชื่อมระบบ(Sync)</a>
		<ul>
			<li><a href="?file=sync">การเชื่อมระบบ AMSS++</a></li>
		</ul>
	</li>
	<li><a href="./" class="dir">ผู้ใช้ (User)</a>
		<ul>
			<li><a href="?file=reset_pwd">คืนค่า(reset)รหัสผ่านผู้ใช้ระดับ สพฐ.</a></li>
			<li><a href="?file=reset_pwd_khet">คืนค่า(reset)รหัสผ่านผู้ใช้ระดับ สพท.</a></li>
		</ul>
	</li>
	<li><a href="./" class="dir">คู่มือ</a>
		<ul>
		</ul>
	</li>
</ul>
</td>
</tr>
