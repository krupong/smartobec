<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
if($_SESSION['admin_meeting']!="meeting"){
exit();
}
//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>กำหนดยานพาหนะ</strong></font></td></tr>";
echo "</table>";
echo "<br>";
}

//ฟังชั่นupload
function file_upload() {
		$uploaddir = 'modules/car/picture/';      //ที่เก็บไไฟล์
		$uploadfile = $uploaddir.basename($_FILES['userfile']['name']);
		$basename = basename($_FILES['userfile']['name']);

		$pic_code=$_POST[person_id];
		//ลบไฟล์เดิม
		$exists_file=$uploaddir.$pic_code.substr($basename,-4);
		if(file_exists($exists_file)){
		unlink($exists_file);
		}

		if (move_uploaded_file($_FILES['userfile']['tmp_name'],  $uploadfile))
			{
				$before_name  = $uploaddir.$basename;
				$changed_name = $uploaddir.$pic_code.substr($basename,-4) ;
				rename("$before_name" , "$changed_name");

		//ลดขนาดภาพ
				if(substr($basename,-3)=="jpg"){
				$ori_file=$changed_name;
				$ori_size=getimagesize($ori_file);
				$ori_w=$ori_size[0];
				$ori_h=$ori_size[1];
					if($ori_w>500){
					$new_w=500;
					$new_h=round(($new_w/$ori_w)*$ori_h);
					$ori_img=imagecreatefromjpeg($ori_file);
					$new_img=imagecreatetruecolor($new_w, $new_h);
					imagecopyresized($new_img, $ori_img,0,0, 0,0, $new_w, $new_h, $ori_w, $ori_h);
					$new_file=$ori_file;
					imagejpeg($new_img, $new_file);
					imagedestroy($ori_img);
					imagedestroy($new_img);
					}
				}

			return  $changed_name;
			}
}

//ส่วนเพิ่มข้อมูล
if($index==1){
echo "<form Enctype = multipart/form-data id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มยานพาหนะ</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='60%' Border='0' >";
echo "<Tr align='left'><Td width='4'></Td><Td align='right'>รหัส&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='car_code' Size='4' maxlenght='4' onkeydown='integerOnly()'></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>ชื่อยานพาหนะ&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='name'  Size='60'></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>ประเภท&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='car_type'  Size='20'></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>ทะเบียน&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='car_number'  Size='20'></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>เรียงลำดับ&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='car_order'  Size='4'></Td></Tr>";

echo  "<tr align='left'>";
echo  "<Td ></Td><td align='right'>ไฟล์รูปภาพ&nbsp;&nbsp;</td>";
echo  "<td align='left'><input name = 'userfile' type = 'file'></td>";
echo  "</tr>";

echo "<Br>";
echo "</Table>";
echo "<Br>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)' class=entrybutton>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)' class=entrybutton'>";

echo "</form>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from person_main where id=$_GET[id]";
$dbquery = mysqli_query($connect, $sql);
}

if($index==3.1){
	foreach ($_POST as $person_id =>$person_value){
$sql = "delete from person_main where person_id='$person_id'";
$dbquery = mysqli_query($connect, $sql);
	}
}
//ส่วนเพิ่มข้อมูล
if($index==4){
$rec_date = date("Y-m-d");

$sql = "select * from person_main where  person_id='$_POST[person_id]' ";
$dbquery = mysqli_query($connect, $sql);
if(mysqli_num_rows($dbquery)>=1){
echo "<br /><div align='center'>มีเลขประจำตัวประชาชนซ้ำกับรายการที่มีอยู่แล้ว ตรวจสอบอีกครั้ง</div>";
exit();
}

$basename = basename($_FILES['userfile']['name']);
if ($basename!="")
{
$changed_name = file_upload();
}

$sql = "insert into person_main (person_id,prename,name,surname,position_code,pic,department,status,person_order,officer,rec_date) values ( '$_POST[person_id]','$_POST[prename]','$_POST[name]','$_POST[surname]','$_POST[position_code]','$changed_name','$_POST[department]','0','$_POST[person_order]','$officer','$rec_date')";
$dbquery = mysqli_query($connect, $sql);
}
//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไข การกำหนดห้องประชุม</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border= '0' Bgcolor='#Fcf9d8'>";
$sql = "select * from meeting_room where id='$_GET[id]'";
$dbquery = mysqli_query($connect, $sql);
$ref_result = mysqli_fetch_array($dbquery);
			if($ref_result['active']==1){
			$active_check1="checked";
			$active_check2="";
			}
			else{
			$active_check1="";
			$active_check2="checked";
			}
echo "<Tr align='left'><Td align='right'>ชื่อห้องประชุม&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='room_name' Size='30' value='$ref_result[room_name]'></Td></Tr>";
echo   "<tr><td align='right'>เปิด/ปิด การใช้ห้องประชุม&nbsp;&nbsp;</td>";
echo   "<td align='left'><input  type=radio name='active' value='1' $active_check1>เปิดใช้งาน&nbsp;&nbsp;<input  type=radio name='active' value='0' $active_check2>ปิดใช้งาน</td></tr>";

echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td align='right'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)' class=entrybutton>&nbsp;&nbsp;</td>";
echo "<td align='left'><INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)' class=entrybutton'></td></tr>";
echo "</Table>";
echo "<Br>";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "</form>";
}
//ส่วนปรับปรุงข้อมูล
if ($index==6){
$sql = "update meeting_room  set  room_name='$_POST[room_name]', active='$_POST[active]' where id='$_POST[id]'";
$dbquery = mysqli_query($connect, $sql);
}
//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){

$sql= "select * from meeting_room order by id";
$dbquery = mysqli_query($connect, $sql);
echo  "<table width=50% border=0 align=center>";
echo "<Tr><Td colspan='4' align='left'><INPUT TYPE='button' name='smb' value='เพิ่มข้อมูล' onclick='location.href=\"?option=car&task=main/set_car&index=1\"'></Td>";
echo "</Tr>";
echo "<Tr bgcolor='#FFCCCC'><Td  align='center'>ที่</Td><Td  align='center' >ยานพาหนะ</Td><td align='center'>สถานะ</td><Td align='center' width='50'>แก้ไข</Td></Tr>";
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$room_code = $result['room_code'];
		$room_name = $result['room_name'];
		$active = $result['active'];
			if($active==1){
			$active_text="<font color='#0033FF'>เปิดใช้งาน</font>";
			}
			else{
			$active_text="<font color='#FF0033'>ปิดใช้งาน</font>";
			}

			if(($M%2) == 0)
			$color="#FFFFC";
			else $color="#FFFFFF";
		echo "<Tr bgcolor=$color><Td align='center' width='50'>$M</Td><Td  align='left'>$room_name </Td><Td align='center'>$active_text</Td>

		<Td align='center' width='50'><a href=?option=meeting&task=main/set_room&index=5&id=$id><img src=images/edit.png border='0' alt='แก้ไข'></a></Td>
	</Tr>";
$M++;
	}
echo "</Table>";
}
?>
<script>

function goto_url(val){
	if(val==0){
		callfrm("?option=set_car&task=car");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณากรอกเลขประจำตัวประชาชน");
		}else if(frm1.prename.value==""){
			alert("กรุณากรอกคำนำหน้าชื่อ");
		}else if(frm1.name.value==""){
			alert("กรุณากรอกชื่อ");
		}else if(frm1.surname.value==""){
			alert("กรุณากรอกนามสกุล");
		}else if(frm1.position_code.value==""){
			alert("กรุณาเลือกตำแหน่ง");
		}else{
			callfrm("?option=set_car&task=car&index=4");   //page ประมวลผล
		}
	}
}



function goto_url_update(val){
	if(val==0){
		callfrm("?option=meeting&task=main/set_room");   // page ย้อนกลับ
	}else if(val==1){
		callfrm("?option=meeting&task=main/set_room&index=6");   //page ประมวลผล
	}
}
</script>
