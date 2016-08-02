<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//sd page 

echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>สำนักงานเขตพื้นที่การศึกษา</strong></font></td></tr>";
echo "</table>";
}
//ส่วนเพิ่มข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มสำนักงานเขตพื้นที่การศึกษา</B></Font>";
echo "</Cener>";
echo "<Br>";
echo "<Table   width=60% Border='0'>";
echo "<Tr align='left'><Td width=20></Td><Td align='right'>รหัส สพท.&nbsp;</Td><Td><Input Type='Text' Name='khet_code' Size='5' onkeydown='integerOnly()'></Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ชื่อ สพท.&nbsp;</Td><Td><Input Type='Text' Name='khet_name' Size='60'></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>ชื่อย่อ สพท.&nbsp;</Td><Td><Input Type='Text' Name='khet_precis' Size='40'></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>ประเภท สพท.&nbsp;</Td><Td>";
echo "<Select  name='khet_type' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo  "<option  value = '1'>ประถมศึกษา</option>" ;
echo  "<option  value = '2'>มัธยมศึกษา</option>" ;
echo "</select>";
echo "</Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>กลุ่ม สพท.&nbsp;</Td><Td>";
echo "<Select  name='khet_group' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;

$sql = "select * from system_khet_group order by code";
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
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?file=khet&index=3&id=$_GET[id]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?file=khet\"'";
echo "</td></tr></table>";
}
//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from system_khet where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนเพิ่มข้อมูล
if($index==4){
$sql = "insert into system_khet (khet_code,khet_name,khet_precis,khet_type, khet_group) values ( '$_POST[khet_code]','$_POST[khet_name]','$_POST[khet_precis]','$_POST[khet_type]', '$_POST[khet_group]')";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไขสำนักงานเขตพื้นที่การศึกษา</B></Font>";
echo "</Cener>";
echo "<Br>";
$sql = "select * from  system_khet where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);

echo "<Table width='70%' Border='0'>";
echo "<Tr align='left'><Td width=20></Td><Td align='right'>รหัส สพท.&nbsp;</Td><Td><Input Type='Text' Name='khet_code' Size='5' value='$ref_result[khet_code]' onkeydown='integerOnly()'></Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ชื่อ สพท.&nbsp;</Td><Td><Input Type='Text' Name='khet_name' Size='60' value='$ref_result[khet_name]'></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>ชื่อย่อ สพท.&nbsp;</Td><Td><Input Type='Text' Name='khet_precis' Size='40' value='$ref_result[khet_precis]'></Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ประเภท สพท.&nbsp;</Td><Td>";
if($ref_result['khet_type']==1){
$seclect1="selected";
$seclect2="";
}
else if($ref_result['khet_type']==2){
$seclect1="";
$seclect2="selected";
}
else{
$seclect1='';
$seclect2='';
}

echo "<Select  name='khet_type' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo  "<option  value = '1' $seclect1>ประถมศึกษา</option>" ;
echo  "<option  value = '2' $seclect2>มัธยมศึกษา</option>" ;

echo "</select>";
echo "</Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>กลุ่ม สพท.&nbsp;</Td><Td>";
echo "<Select  name='khet_group' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;

$sql = "select * from system_khet_group order by code";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)) {
		if($ref_result['khet_group']==$result['code']){
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
$sql = "update system_khet set khet_code='$_POST[khet_code]',khet_name='$_POST[khet_name]',khet_precis='$_POST[khet_precis]',khet_type='$_POST[khet_type]',khet_group='$_POST[khet_group]' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนการแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){

$sql = "select system_khet.id, system_khet.khet_code, system_khet.khet_type, system_khet.khet_name, system_khet.khet_precis,system_khet_group.name from system_khet left join system_khet_group on system_khet.khet_group=system_khet_group.code order by system_khet.khet_type,system_khet.khet_code";
$dbquery = mysqli_query($connect,$sql);

echo  "<table width='95%' border='0' align='center'>";
echo "<Tr><Td colspan='6' align='left'><INPUT TYPE='button' name='smb' value='เพิ่มข้อมูล' onclick='location.href=\"?file=khet&index=1\"'></Td></Tr>";

echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='50'>ที่</Td><Td>รหัสสพท.</Td><Td>ชื่อสพท.</Td><Td>ชื่อย่อสพท.</Td><Td>ประเภท</Td><Td>กลุ่มสพท.</Td><Td   width='50'>ลบ</Td><Td width='50'>แก้ไข</Td></Tr>";
$N=1; 
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$khet_code= $result['khet_code'];
		$khet_name= $result['khet_name'];
		$khet_precis= $result['khet_precis'];
		$khet_type= $result['khet_type'];
		$khet_group= $result['name'];
			if($khet_type==1){
			$khet_type_text="ประถมศึกษา";
			}
			else if($khet_type==2){
			$khet_type_text="มัธยมศึกษา";
			}
			else{
			$khet_type_text="";
			}
		
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";

		echo "<Tr  bgcolor=$color align='center'><Td>$N</Td><Td>$khet_code</Td><Td align='left'>$khet_name</Td><Td align='left'>$khet_precis</Td><Td align='left'>$khet_type_text</Td><Td align='left'>$khet_group</Td><Td align='center'><a href=?file=khet&index=2&id=$id><img src=../images/drop.png border='0' alt='ลบ'></a></Td><Td><a href=?file=khet&index=5&id=$id><img src=../images/edit.png border='0' alt='แก้ไข'></a></Td>
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
		callfrm("?file=khet");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.khet_code.value == ""){
			alert("กรุณากรอกรหัสตำแหน่ง");
		}else if(frm1.khet_name.value==""){
			alert("กรุณากรอกชื่อตำแหน่ง");
		}else if(frm1.khet_type.value==""){
			alert("กรุณาเลือกประเภทสถานศึกษา");
		}else{
			callfrm("?file=khet&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?file=khet");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.khet_code.value == ""){
			alert("กรุณากรอกรหัสตำแหน่ง");
		}else if(frm1.khet_name.value==""){
			alert("กรุณากรอกชื่อตำแหน่ง");
		}else if(frm1.khet_type.value==""){
			alert("กรุณาเลือกประเภทสถานศึกษา");
		}else{
			callfrm("?file=khet&index=6");   //page ประมวลผล
		}
	}
}
</script>
