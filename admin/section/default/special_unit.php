<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>หน่วยงานพิเศษ สพฐ.</strong></font></td></tr>";
echo "</table>";
}
//ส่วนเพิ่มข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มหน่วยงานพิเศษ สพฐ.</B></Font>";
echo "</Cener>";
echo "<Br>";
echo "<Table   width=60% Border='0'>";
echo "<Tr align='left'><Td width=20></Td><Td align='right'>รหัส&nbsp;</Td><Td><Input Type='Text' Name='unit_code' Size='5' onkeydown='integerOnly()'></Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ชื่อหน่วยงาน&nbsp;</Td><Td><Input Type='Text' Name='unit_name' Size='60'></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>ชื่อย่อหน่วยงาน&nbsp;</Td><Td><Input Type='Text' Name='unit_precis' Size='40'></Td></Tr>";


echo "<Tr align='left'><Td ></Td><Td align='right'>ประเภทหน่วยงาน&nbsp;</Td><Td>";
echo "<Select  name='unit_type' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;

$sql = "select * from system_specialunit_group order by code";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)) {
echo  "<option  value = '$result[code]'>$result[code] $result[name]</option>" ;
}

echo "</select>";
echo "</Td></Tr>";

echo "<Br>";
echo "</Table>";
echo "<Br>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)'>";

echo "</form>";
}
//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?file=special_unit&index=3&id=$_GET[id]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?file=special_unit\"'";
echo "</td></tr></table>";
}
//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from system_special_unit where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนเพิ่มข้อมูล
if($index==4){
$sql = "insert into system_special_unit (unit_code,unit_name,unit_precis,unit_type) values ( '$_POST[unit_code]','$_POST[unit_name]','$_POST[unit_precis]','$_POST[unit_type]')";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไข</B></Font>";
echo "</Cener>";
echo "<Br>";
$sql = "select * from  system_special_unit where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);

echo "<Table width='70%' Border='0'>";
echo "<Tr align='left'><Td width=20></Td><Td align='right'>รหัสหน่วยงาน&nbsp;</Td><Td><Input Type='Text' Name='unit_code' Size='5' value='$ref_result[unit_code]' onkeydown='integerOnly()'></Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ชื่อหน่วยงาน&nbsp;</Td><Td><Input Type='Text' Name='unit_name' Size='60' value='$ref_result[unit_name]'></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>ชื่อย่อหน่วยงาน&nbsp;</Td><Td><Input Type='Text' Name='unit_precis' Size='60' value='$ref_result[unit_precis]'></Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ประเภทหน่วยงาน&nbsp;</Td><Td>";
echo "<Select  name='unit_type' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;

$sql = "select * from system_specialunit_group order by code";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)) {
		if($ref_result['unit_type']==$result['code']){
		echo  "<option  value = '$result[code]' selected>$result[code] $result[name]</option>" ;
		}
		else{
		echo  "<option  value = '$result[code]'>$result[code] $result[name]</option>" ;
		}
}

echo "</select>";
echo "</Td></Tr>";

echo "<Br>";
echo "</Table>";
echo "<Br>";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)'>";

echo "</form>";
}
//ส่วนปรับปรุงข้อมูล
if ($index==6){
$sql = "update system_special_unit set unit_code='$_POST[unit_code]',unit_name='$_POST[unit_name]',unit_precis='$_POST[unit_precis]',unit_type='$_POST[unit_type]' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนการแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){
$sql = "select system_special_unit.id, system_special_unit.unit_code, system_special_unit.unit_type, system_special_unit.unit_name,system_special_unit.unit_precis,system_specialunit_group.name from system_special_unit left join system_specialunit_group on system_special_unit.unit_type=system_specialunit_group.code order by system_special_unit.unit_type,system_special_unit.unit_code";
$dbquery = mysqli_query($connect,$sql);

echo  "<table width='95%' border='0' align='center'>";
echo "<Tr><Td colspan='6' align='left'><INPUT TYPE='button' name='smb' value='เพิ่มข้อมูล' onclick='location.href=\"?file=special_unit&index=1\"'></Td></Tr>";

echo "<Tr bgcolor=#FFCCCC align='center'><Td width='50'>ที่</Td><Td width='100'>รหัส</Td><Td>ชื่อหน่วยงาน</Td><Td>ชื่อย่อหน่วยงาน</Td><Td>ประเภท</Td><Td width='50'>ลบ</Td><Td width='50'>แก้ไข</Td></Tr>";
$N=1; 
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$unit_code= $result['unit_code'];
		$unit_name= $result['unit_name'];
		$unit_precis= $result['unit_precis'];
		$unit_type= $result['unit_type'];
		$unit_type= $result['name'];
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
		echo "<Tr  bgcolor=$color align='center'><Td>$N</Td> <Td>$unit_code</Td><Td align='left'>$unit_name</Td><Td align='left'>$unit_precis</Td><Td align='left'>$unit_type</Td><Td align='center'><a href=?file=special_unit&index=2&id=$id><img src=../images/drop.png border='0' alt='ลบ'></a></Td><Td><a href=?file=special_unit&index=5&id=$id><img src=../images/edit.png border='0' alt='แก้ไข'></a></Td>
	</Tr>";
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}
echo "</Table>";
}

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?file=special_unit");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.unit_code.value == ""){
			alert("กรุณากรอกรหัสหน่วยงาน");
		}else if(frm1.unit_name.value==""){
			alert("กรุณากรอกชื่อหน่วยงาน");
		}else if(frm1.unit_type.value==""){
			alert("กรุณาเลือกประเภทหน่วยงาน");
		}else{
			callfrm("?file=special_unit&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?file=special_unit");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.unit_code.value == ""){
			alert("กรุณากรอกรหัสหน่วยงาน");
		}else if(frm1.unit_name.value==""){
			alert("กรุณากรอกชื่อหน่วยงาน");
		}else if(frm1.unit_type.value==""){
			alert("กรุณาเลือกประเภทหน่วยงาน");
		}else{
			callfrm("?file=special_unit&index=6");   //page ประมวลผล
		}
	}
}
</script>
