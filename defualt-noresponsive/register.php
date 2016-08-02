<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

if(!isset($_POST['index'])){
echo "<br />";
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>ลงทะเบียนผู้ใช้</B></Font>";
echo "</Cener>";
echo "<Br>";
echo "<Table   width=40% Border=0 Bgcolor=#Fcf9d8>";
echo "<Tr><Td width=20></Td><Td align='right'>User Name&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='username' Size='20'></Td></Tr>";
echo "<Tr><Td ></Td><Td align='right'>Password&nbsp;&nbsp;</Td><Td align='left'><Input Type='password' Name='passname' Size='20'></Td></Tr>";
echo "<Tr><Td ></Td><Td align='right'>ยืนยัน Password&nbsp;&nbsp;</Td><Td align='left'><Input Type='password' Name='passname2' Size='20'></Td></Tr>";
echo "<Br>";
echo "</Table>";
echo "<Br>";
echo "<Input Type=Hidden Name='index' Value='4'>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)' class=entrybutton>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)' class=entrybutton'>";
echo "</form>";		
}

//ส่วนเพิ่มข้อมูล
if(isset($_POST['index'])){
if($_POST['index']==4){
$username 	= trim($_POST['username']);
$passname= md5(trim($_POST['passname']));

$sql = "select * from system_user where person_id='$_SESSION[login_user_id]' ";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
		if($result){
		echo "<script>alert('คุณได้เคยลงทะเบียนไว้แล้ว ระบบไม่บันทึกข้อมูลซ้ำ หากลืม Username Password ควรติดต่อผู้ดูแลระบบ'); document.location.href='index.php';</script>";
		exit();
		}
		$sql2 = "select * from system_user where username='$username' ";
		$dbquery2 = mysqli_query($connect,$sql2);
		$result2 = mysqli_fetch_array($dbquery2);
		if($result2){
		echo "<script>alert('ระบบไม่อนุญาตให้ใช้ Username นี้ เนื่องจากมีผู้ลงทะเบียนไว้แล้ว กรุณาใช้ Username อื่น'); document.location.href='index.php';</script>";
		exit();
		}
$rec_date = date("Y-m-d");		
if($_SESSION['login_status'] >10){
$sql = "insert into system_user (person_id, username, userpass,status,school_user,officer,rec_date) values ( '$_SESSION[login_user_id]','$username','$passname','1','1','$_SESSION[login_user_id]','$rec_date')";
}
else{
$sql = "insert into system_user (person_id, username, userpass,status,officer,rec_date) values ( '$_SESSION[login_user_id]','$username','$passname','1','$_SESSION[login_user_id]','$rec_date')";
}
$dbquery = mysqli_query($connect,$sql);
	if($dbquery){
		echo "<script>alert('ลงทะเบียนผู้ใช้เรียบร้อยแล้ว กรุณาออกจากระบบ แล้ว Login ด้วย Username และ Password'); document.location.href='index.php';</script>";
		exit();
	}
}
}

echo "<div align='left'><br><br>";
echo "<table align='center' width='75%'><tr><td>";
echo "<b>คำอธิบาย</b>&nbsp;การลงทะเบียนผู้ใช้เป็นการสร้างรายชื่อผู้ใช้งาน (Username และ Password) ซึ่งจะทำให้เกิดการระบุตัวตนผู้ใช้เฉพาะเจาะจงมากกว่าการ Login ด้วยเลขประจำตัวประชาชน  เมื่อลงทะเบียนสร้างรายชื่อผู้ใช้งานเรียบร้อยแล้ว และ Login ด้วยรายชื่อผู้ใช้งาน (Username และ Password) จะเกิดสิทธิ์การใช้งานมากขึ้น";
echo "</td></tr></table>";
echo "</div>";

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("./");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.username.value == ""){
			alert("กรุณากรอก Username");
		}else if(frm1.passname.value==""){
			alert("กรุณากรอก Password");
		}else if(frm1.passname2.value == ""){
			alert("กรุณายืนย้น Password");
		}else if(frm1.passname.value!=frm1.passname2.value){
			alert("Password สองครั้งไม่ตรงกัน");
		}else{
			callfrm("?file=register&index=4");   //page ประมวลผล
		}
	}
}

</script>
