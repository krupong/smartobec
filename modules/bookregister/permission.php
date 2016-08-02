<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>เจ้าหน้าที่</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มเจ้าหน้าที่</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<div align='center'><table width='50%'><tr><td>";
echo "<table class='table table-bordered' width='100%' style='background-color:rgba(255,255,255,0.9)'>";
echo "<Tr><Td align='right'>บุคลากร&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='person_id'  class='selectpicker show-tick' title='เลือกบุคลากร' data-live-search='true'>";
//echo  "<option  value = ''>เลือก</option>" ;

//นำเข้าข้อมูลบุคลากร
//require_once("person_chk.php");	

$sql = "select  * from person_main where status='0' order by name";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$person_id = $result['person_id'];
		$name = $result['name'];
		$surname = $result['surname'];
		$department = $result['department'];
		$sub_department = $result['sub_department'];
		echo  "<option value = $person_id>$name $surname</option>" ;
	}
echo "</select>";
echo "</div></td></tr>";

//เลือกสำนัก
echo "<Tr><Td align='right'>สำนัก&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='department'  class='selectpicker show-tick' title='เลือกสำนัก' data-live-search='true'>";
//echo  "<option  value = ''>เลือก</option>" ;
$sql = "select  * from system_department  order by department ASC";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$department = $result['department'];
		$department_name = $result['department_name'];
		if($department==$ref_result['department']){
		echo  "<option value = $department selected>$department_name</option>";
		}
		else{
		echo  "<option value = $department>$department_name</option>";
		}
	}
echo "</select>";

echo "</div></td></tr>";

echo   "<tr><td align='right'>อนุญาตให้เป็นเจ้าหน้าที่&nbsp;&nbsp;</td>";
echo   "<td align='left'><input  type=radio name='bookregister_permission1' value='1' checked> ใช่&nbsp;&nbsp;<input  type=radio name='bookregister_permission1' value='0'> ไม่ใช่</td></tr>";

echo   "<tr><td align='right'>กำหนดบทบาทหน้าที่&nbsp;&nbsp;</td>";
echo   "<td align='left'><input  type=radio name='saraban_status' value='1' > สารบรรณกลาง สพฐ.&nbsp;&nbsp;<input  type=radio name='saraban_status' value='2'> สารบรรณสำนัก&nbsp;&nbsp;<input  type=radio name='saraban_status' value='3'> สารบรรณกลุ่ม</td></tr>";

//echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td align='center' colspan='2'><INPUT TYPE='button' class='btn btn-primary' name='smb' value='ตกลง' onclick='goto_url(1)' class=entrybutton>
	&nbsp;&nbsp;&nbsp;";
echo "<INPUT TYPE='button' name='back' class='btn btn-danger' value='ย้อนกลับ' onclick='goto_url(0)' class=entrybutton'></td></tr>";
echo "</Table>";
echo "</td></tr></table>";
echo "</form>";
}

//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=bookregister&task=permission&index=3&id=$_GET[id]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=bookregister&task=permission\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from bookregister_permission where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
echo "<script>document.location.href='?option=bookregister&task=permission'; </script>\n";
}

//ส่วนบันทึกข้อมูล
if($index==4){
$rec_date = date("Y-m-d");
$sql = "insert into bookregister_permission (person_id, p1, officer, department, sub_department, saraban_status, rec_date) values ('$_POST[person_id]', '$_POST[bookregister_permission1]', '$_SESSION[login_user_id]','$_POST[department]', '$_POST[sub_department]','$_POST[saraban_status]','$rec_date')";
$dbquery = mysqli_query($connect,$sql);
echo "<script>document.location.href='?option=bookregister&task=permission'; </script>\n";
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไข เจ้าหน้าที่</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border= '0' Bgcolor='#Fcf9d8'>";
$sql = "select * from bookregister_permission where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);
echo "<Tr><Td align='right'>บุคลากร&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='person_id'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select  * from person_main where status='0' order by name";
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
//เลือกสำนัก
echo "<Tr><Td align='right'>สำนัก&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='department_id'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select  * from system_department  order by department ASC";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$department = $result['department'];
		$department_name = $result['department_name'];
		if($department==$ref_result['department']){
		echo  "<option value = $department selected>$department_name</option>";
		}
		else{
		echo  "<option value = $department>$department_name</option>";
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
		if($ref_result['saraban_status']==1){
			$s1_check1="checked";
			$s1_check2="";
			}
		if($ref_result['saraban_status']==2){
			$s2_check1="checked";
			$s2_check2="";
			}
		if($ref_result['saraban_status']==3){
			$s3_check1="checked";
			$s3_check2="";
			}


echo   "<tr><td align='right'>อนุญาตให้เป็นเจ้าหน้าที่ได้&nbsp;&nbsp;</td>";
echo   "<td align='left'><input  type=radio name='bookregister_permission1' value='1' $p1_check1>ใช่&nbsp;&nbsp;<input  type=radio name='bookregister_permission1' value='0' $p1_check2>ไม่ใช่</td></tr>";

echo   "<tr><td align='right'>กำหนดบทบาทหน้าที่&nbsp;&nbsp;</td>";
echo   "<td align='left'><input  type=radio name='saraban_status' value='1' $s1_check1>สารบรรณกลาง สพฐ.&nbsp;&nbsp;<input  type=radio name='saraban_status' value='2' $s2_check1>สารบรรณสำนัก&nbsp;&nbsp;<input  type=radio name='saraban_status' value='3' $s3_check1>สารบรรณกลุ่ม</td></tr>";


echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td align='right'><INPUT TYPE='button' name='smb' class='btn btn-primary' value='ตกลง' onclick='goto_url_update(1)' class=entrybutton>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
echo "<td align='left'><INPUT TYPE='button' name='back' class='btn btn-danger' value='ย้อนกลับ' onclick='goto_url_update(0)' class=entrybutton'></td></tr>";
echo "</Table>";
echo "<Br>";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
$rec_date = date("Y-m-d");
$sql = "update bookregister_permission set  person_id='$_POST[person_id]', p1='$_POST[bookregister_permission1]', officer='$_SESSION[login_user_id]', department='$_POST[department_id]', sub_department='$sub_department', saraban_status='$_POST[saraban_status]', rec_date='$rec_date' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
echo "<script>document.location.href='?option=bookregister&task=permission'; </script>\n";
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){
//echo "<br><br><br><br>";
$sql = "select bookregister_permission.id, bookregister_permission.person_id, bookregister_permission.p1, bookregister_permission.department, bookregister_permission.saraban_status, person_main.name, person_main.surname from bookregister_permission left join person_main on bookregister_permission.person_id=person_main.person_id where bookregister_permission.school_code is null order by bookregister_permission.id";
$dbquery = mysqli_query($connect,$sql);
//echo "<div align='center'><table width='80%'><tr><td>";

echo "<br><div align='center'><table width='90%'><tr><td>";

echo "<div class='row'>
                <div class='col-md-12'>";
echo "<div class='panel panel-default'>
                        <div class='panel-heading'>";
echo "<b>กำหนดเจ้าหน้าที่สารบรรณ</b>
                        </div>";
echo "<br><div class='col-md-12' align='left'><p><INPUT TYPE='button' class='btn btn-primary' name='smb' value='เพิ่มเจ้าหน้าที่' onclick='location.href=\"?option=bookregister&task=permission&index=1\"'></p></div>";
echo "<div class='panel-body'>";
echo "<table class='table table-striped table-bordered table-hover' id='dataTables-example'>";
//echo  "<table class='table table-bordered' width='100%' style='background-color:rgba(255,255,255,0.9)'>";
//echo "<Tr><Td colspan='8' align='left'><INPUT TYPE='button' class='btn btn-primary' name='smb' value='เพิ่มเจ้าหน้าที่' onclick='location.href=\"?option=bookregister&task=permission&index=1\"'</Td></Tr>";

echo "<thead><tr><th rowspan='2'><center>ที่</center></th><th rowspan='2'><center>ชื่อเจ้าหน้าที่</center></th>
  <th colspan='3'><center>บทบาท</center></th>
  <th>สิทธิ์</th><th rowspan='2'>ลบ</th><th rowspan='2'><center>แก้ไข</center></th></tr>";
echo "'<tr>
  <th><center>สารบรรณกลาง สพฐ.</center></th>
  <th><center>สารบรรณสำนัก</center></th>
  <th><center>สารบรรณกลุ่ม</center></th>
  <th><center>เจ้าหน้าที่</center></th></tr></thead><tbody>";
//echo "<tr bgcolor='#CC9900'><Td  align='center' width='80'>เจ้าหน้าที่</Td></tr>";
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$name = $result['name'];
		$surname = $result['surname'];
		$department_id = $result['department'];
		$saraban_status = $result['saraban_status'];
		$person_id2 = $result['person_id'];
		
			if($result['p1']==1){
			$p1_pic="<span class='glyphicon glyphicon-ok' aria-hidden='true'></span>";			}
			else{
			$p1_pic="<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>";
			}

			//แสดงบทบาท
			if($result['saraban_status']==1){
			$s1_pic="<span class='glyphicon glyphicon-ok' aria-hidden='true'></span>";			}
			else{
			$s1_pic="<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>";
			}
			if($result['saraban_status']==2){
			$s2_pic="<span class='glyphicon glyphicon-ok' aria-hidden='true'></span>";			}
			else{
			$s2_pic="<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>";
			}
			if($result['saraban_status']==3){
			$s3_pic="<span class='glyphicon glyphicon-ok' aria-hidden='true'></span>";			}
			else{
			$s3_pic="<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>";
			}

			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
			//เรียกชื่อสำนัก
	$sql_d="select * from system_department where department = '$department_id' ";		 //รหัสสำนัก 
	$dbquery_d = mysqli_query($connect,$sql_d);
	$result_d = mysqli_fetch_array($dbquery_d);
	$department_name = $result_d['department_name'];
	//หาข้อมูลบุคลากรว่าอยู่กลุ่มไหน
	$sql_p="select * from person_main where person_id = '$person_id2'";		 //หาข้อมูลบุคลากร
	$dbquery_p = mysqli_query($connect,$sql_p);
	$result_p = mysqli_fetch_array($dbquery_p);
	$sub_department_id = $result_p['sub_department'];
	//เรียกชื่อกลุ่ม
	$sql_g="select * from system_subdepartment where sub_department = '$sub_department_id' ";		 //รหัสกลุ่ม
	$dbquery_g = mysqli_query($connect,$sql_g);
	$result_g = mysqli_fetch_array($dbquery_g);
	$sub_department_name = $result_g['sub_department_name'];

		echo "<Tr><Td align='center'>$M</Td><Td  align='left'>$name $surname <br>$sub_department_name  $department_name</Td>
  <Td  align='center'>$s1_pic</Td>
  <Td  align='center'>$s2_pic</Td>
  <Td  align='center'>$s3_pic</Td>
  <Td align='center'>$p1_pic</Td>
		<Td align='center'  ><a href=?option=bookregister&task=permission&index=2&id=$id><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a></Td>
		<Td align='center' ><a href=?option=bookregister&task=permission&index=5&id=$id><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a></Td>
	</Tr>";
$M++;
	}
echo "</tbody></Table>";
}
?>
</div>
			</div>
            </div>
            </div>
            </div>
</td></tr></table></div>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=bookregister&task=permission");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
		}else{
			callfrm("?option=bookregister&task=permission&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=bookregister&task=permission");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
		}else{
			callfrm("?option=bookregister&task=permission&index=6");   //page ประมวลผล
		}
	}
}
</script>
