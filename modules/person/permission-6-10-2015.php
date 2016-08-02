<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

?>

<script type="text/javascript">
$(function(){
	$("select#department").change(function(){
		var datalist2 = $.ajax({	// รับค่าจาก ajax เก็บไว้ที่ตัวแปร datalist2
			  url: "modules/person/return_ajax_person.php", // ไฟล์สำหรับการกำหนดเงื่อนไข
			  data:"department="+$(this).val(), // ส่งตัวแปร GET ชื่อ department ให้มีค่าเท่ากับ ค่าของ department
			  async: false
		}).responseText;		
		$("select#person_id").html(datalist2); // นำค่า datalist2 มาแสดงใน listbox ที่ 2 
		// ชื่อตัวแปร และ element ต่างๆ สามารถเปลี่ยนไปตามการกำหนด
	});
});

</script>
<?php

if(!(($_SESSION['admin_person']=="person") or ($_SESSION['login_status']==99) or ($_SESSION['login_group']==1 and $result_permission['p1']==1))){	
exit();
}

//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>เจ้าหน้าที่ระบบข้อมูลบุคลากร</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มเจ้าหน้าที่</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border='0' Bgcolor='#Fcf9d8'>";

echo "<Tr><Td align='right'>สำนัก&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select name='department' id='department' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select * from  system_department order by department";
$dbquery = mysqli_query($connect,$sql);
While ($result_department = mysqli_fetch_array($dbquery)){
echo  "<option  value ='$result_department[department]'>$result_department[department] $result_department[department_name]</option>" ;
}	
echo "</select>";
echo "</div></td></tr>";

echo "<Tr><Td align='right'>บุคลากร&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select name='person_id' id='person_id' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo "</select>";
echo "</div></td></tr>";

echo   "<tr><td align='right'>เพิ่ม ลบแก้ไขข้อมูลบุคลากร&nbsp;&nbsp;</td>";
echo   "<td align='left'>ใช่<input  type=radio name='person_permission1' value='1' checked>&nbsp;&nbsp;ไม่ใช่<input  type=radio name='person_permission1' value='0'></td></tr>";
echo   "<tr><td align='right'>การรักษาราชการแทน&nbsp;&nbsp;</td>";
echo   "<td align='left'>ใช่<input  type=radio name='person_permission2' value='1'>&nbsp;&nbsp;ไม่ใช่<input  type=radio name='person_permission2' value='0' checked></td></tr>";

echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td align='right'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)'>&nbsp;&nbsp;</td>";
echo "<td align='left'><INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)'></td></tr>";
echo "</Table>";
echo "</form>";
}

//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=person&task=permission&index=3&id=$_GET[id]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=person&task=permission\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from person_permission where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนบันทึกข้อมูล
if($index==4){
$rec_date = date("Y-m-d");
$sql = "insert into person_permission (person_id, p1, p2, officer,rec_date) values ('$_POST[person_id]', '$_POST[person_permission1]','$_POST[person_permission2]','$_SESSION[login_user_id]','$rec_date')";
//echo "<div class='well'>".$sql."</div>";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไข เจ้าหน้าที่</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border= '0' Bgcolor='#Fcf9d8'>";
$sql = "select * from person_permission left join person_main on person_permission.person_id=person_main.person_id where person_permission.id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);

echo "<Tr><Td align='right'>สำนัก&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select name='department' id='department' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select * from  system_department order by department";
$dbquery = mysqli_query($connect,$sql);
While ($result_department = mysqli_fetch_array($dbquery)){
		if($result_department['department']==$ref_result['department']){
		echo  "<option  value ='$result_department[department]' selected>$result_department[department] $result_department[department_name]</option>" ;
		}
		else{
		echo  "<option  value ='$result_department[department]'>$result_department[department] $result_department[department_name]</option>" ;
		}
}	
echo "</select>";
echo "</div></td></tr>";

echo "<Tr><Td align='right'>บุคลากร&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='person_id' id='person_id' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select  * from person_main where department='$ref_result[department]' and status='0' order by name";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$person_id = $result['person_id'];
		$name = $result['name'];
		$surname = $result['surname'];
		if($person_id==$ref_result['person_id']){
		echo  "<option value = $person_id selected>$name $surname</option>";
		}
		else{
		echo  "<option value = $person_id>$name $surname</option>";
		}
	}
echo "</select>";
echo "</div></td></tr>";
			if($ref_result['p1']==1){
			$p1_check1="checked";
			$p1_check2="";
			}
			else{
			$p1_check1="";
			$p1_check2="checked";
			}
			
			if($ref_result['p2']==1){
			$p2_check1="checked";
			$p2_check2="";
			}
			else{
			$p2_check1="";
			$p2_check2="checked";
			}
echo   "<tr><td align='right'>เพิ่ม ลบแก้ไขข้อมูลบุคลากร&nbsp;&nbsp;</td>";
echo   "<td align='left'>ใช่<input  type=radio name='person_permission1' value='1' $p1_check1>&nbsp;&nbsp;ไม่ใช่<input  type=radio name='person_permission1' value='0' $p1_check2></td></tr>";

echo   "<tr><td align='right'>การรักษาราชการแทน&nbsp;&nbsp;</td>";
echo   "<td align='left'>ใช่<input  type=radio name='person_permission2' value='1' $p2_check1>&nbsp;&nbsp;ไม่ใช่<input  type=radio name='person_permission2' value='0' $p2_check2></td></tr>";

echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td align='right'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)'>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
echo "<td align='left'><INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)'></td></tr>";
echo "</Table>";
echo "<Br>";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
$rec_date = date("Y-m-d");
$sql = "update person_permission set  person_id='$_POST[person_id]', p1='$_POST[person_permission1]',  p2='$_POST[person_permission2]', officer='$_SESSION[login_user_id]', rec_date='$rec_date' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){
$sql = "select person_permission.id, person_permission.p1, person_permission.p2, person_main.name, person_main.surname from person_permission left join person_main on person_permission.person_id=person_main.person_id order by person_permission.id";
$dbquery = mysqli_query($connect,$sql);
echo  "<table width='55%' border='0' align='center'>";
echo "<Tr><Td colspan='5' align='left'><INPUT TYPE='button' name='smb' value='เพิ่มเจ้าหน้าที่' onclick='location.href=\"?option=person&task=permission&index=1\"'</Td></Tr>";

echo "<Tr bgcolor='#FFCCCC'><Td align='center' rowspan='2'>ที่</Td><Td  align='center' rowspan='2'>ชื่อเจ้าหน้าที่</Td><td  align='center' colspan='2'>สิทธื์</td><Td align='center' rowspan='2' width='50'>ลบ</Td><Td align='center' rowspan='2' width='50'>แก้ไข</Td></Tr>";
echo "<tr bgcolor='#CC9900'><Td align='center' width='110'>เจ้าหน้าที่บุคลากร</Td><Td align='center' width='110'>รักษาราชการแทน</Td></tr>";
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$name = $result['name'];
		$surname = $result['surname'];
			if($result['p1']==1){
			$p1_pic="<img src=images/yes.png border='0' alt='มีสิทธิ์'>";			}
			else{
			$p1_pic="<img src=images/no.png border='0' alt='ไม่มีสิทธิ์'>";
			}
			if($result['p2']==1){
			$p2_pic="<img src=images/yes.png border='0' alt='มีสิทธิ์'>";			}
			else{
			$p2_pic="<img src=images/no.png border='0' alt='ไม่มีสิทธิ์'>";
			}
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
		echo "<Tr bgcolor=$color><Td align='center' width='50'>$M</Td><Td  align='left'>$name $surname</Td><Td align='center'>$p1_pic</Td><Td align='center'>$p2_pic</Td>
		<Td align='center' width='50' ><a href=?option=person&task=permission&index=2&id=$id><img src=images/drop.png border='0' alt='ลบ'></a></Td>
		<Td align='center' width='50'><a href=?option=person&task=permission&index=5&id=$id><img src=images/edit.png border='0' alt='แก้ไข'></a></Td>
	</Tr>";
$M++;
	}
echo "</Table>";
}

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=person&task=permission");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
		}else{
			callfrm("?option=person&task=permission&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=person&task=permission");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
		}else{
			callfrm("?option=person&task=permission&index=6");   //page ประมวลผล
		}
	}
}
</script>
