<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>สถานศึกษา</strong></font></td></tr>";
echo "</table>";
}
//ส่วนเพิ่มข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มสถานศึกษา</B></Font>";
echo "</Cener>";
echo "<Br>";
echo "<Table   width=60% Border='0'>";
echo "<Tr align='left'><Td width=20></Td><Td align='right'>รหัสสถานศึกษา&nbsp;</Td><Td><Input Type='Text' Name='school_code' Size='5' onkeydown='integerOnly()'>&nbsp;*ใช้รหัส smiss 8 หลัก</Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ชื่อสถานศึกษา&nbsp;</Td><Td><Input Type='Text' Name='school_name' Size='40'></Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ประเภทสถานศึกษา&nbsp;</Td><Td>";
echo "<Select  name='school_type' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo  "<option  value = '1'>การศึกษาพิเศษ</option>" ;
echo  "<option  value = '2'>ประถมศึกษา</option>" ;
echo  "<option  value = '3'>มัธยมศึกษา</option>" ;
echo "</select>";
echo "</Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>สพท.&nbsp;</Td><Td>";
echo "<Select  name='khet' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;

$sql = "select * from system_khet order by khet_type,khet_code";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)) {
echo  "<option  value = '$result[khet_code]'>$result[khet_code] $result[khet_name]</option>" ;
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
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?file=school&task=school&index=3&id=$_GET[id]&page=$_REQUEST[page]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?file=school&task=school&page=$_REQUEST[page]\"'";
echo "</td></tr></table>";
}
//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from system_school where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนเพิ่มข้อมูล
if($index==4){
$sql = "insert into system_school (school_code, school_name, school_type, khet_code) values ( '$_POST[school_code]','$_POST[school_name]','$_POST[school_type]', '$_POST[khet]')";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไขสถานศึกษา</B></Font>";
echo "</Cener>";
echo "<Br>";
$sql = "select * from  system_school where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);

echo "<Table width='50%' Border='0'>";
echo "<Tr align='left'><Td width=20></Td><Td align='right'>รหัสสถานศึกษา&nbsp;</Td><Td><Input Type='Text' Name='school_code' Size='5' value='$ref_result[school_code]' onkeydown='integerOnly()'></Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ชื่อสถานศึกษา&nbsp;</Td><Td><Input Type='Text' Name='school_name' Size='60' value='$ref_result[school_name]'></Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ประเภทสถานศึกษา&nbsp;</Td><Td>";
if($ref_result['school_type']==1){
$seclect1="selected";
$seclect2="";
$seclect3="";
}
else if($ref_result['school_type']==2){
$seclect1="";
$seclect2="selected";
$seclect3="";
}
else if($ref_result['school_type']==2){
$seclect1="";
$seclect2="selected";
$seclect3="";
}
else if($ref_result['school_type']==3){
$seclect1="";
$seclect2="";
$seclect3="selected";
}
else{
$seclect1='';
$seclect2='';
$seclect3="";
}

echo "<Select  name='school_type' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo  "<option  value = '1' $seclect1>การศึกษาพิเศษ</option>" ;
echo  "<option  value = '2' $seclect2>ประถมศึกษา</option>" ;
echo  "<option  value = '3' $seclect3>มัธยมศึกษา</option>" ;
echo "</select>";
echo "</Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>สพท.&nbsp;</Td><Td>";
echo "<Select  name='khet' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;

$sql = "select * from system_khet order by khet_type,khet_code";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)) {
		if($ref_result['khet_code']==$result['khet_code']){
		echo  "<option  value = '$result[khet_code]' selected>$result[khet_code] $result[khet_name]</option>" ;
		}
		else{
		echo  "<option  value = '$result[khet_code]'>$result[khet_code] $result[khet_name]</option>" ;
		}
}

echo "</select>";
echo "</Td></Tr>";

echo "<Br>";
echo "</Table>";
echo "<Br>";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "<Input Type=Hidden Name='page' Value='$_GET[page]'>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)'>";

echo "</form>";
}
//ส่วนปรับปรุงข้อมูล
if ($index==6){
$sql = "update system_school set school_code='$_POST[school_code]',school_name='$_POST[school_name]',school_type='$_POST[school_type]',khet_code='$_POST[khet]' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนการแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){
//ส่วนของการแยกหน้า
$pagelen=50;  // 1_กำหนดแถวต่อหน้า
$url_link="file=school";  // 2_กำหนดลิงค์ฺ
$sql = "select * from system_school"; // 3_กำหนด sql
$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery );  
$totalpages=ceil($num_rows/$pagelen);
if(!isset($_REQUEST['page'])){
$_REQUEST['page']="";
}
if($_REQUEST['page']==""){
$page=$totalpages;
		if($page<2){
		$page=1;
		}
}
else{
		if($totalpages<$_REQUEST['page']){
		$page=$totalpages;
					if($page<1){
					$page=1;
					}
		}
		else{
		$page=$_REQUEST['page'];
		}
}

$start=($page-1)*$pagelen;

if(($totalpages>1) and ($totalpages<16)){
echo "<div align=center>";
echo "หน้า	";
			for($i=1; $i<=$totalpages; $i++)	{
					if($i==$page){
					echo "[<b><font size=+1 color=#990000>$i</font></b>]";
					}
					else {
					echo "<a href=$PHP_SELF?$url_link&page=$i>[$i]</a>";
					}
			}
echo "</div>";
}			
if($totalpages>15){
			if($page <=8){
			$e_page=15;
			$s_page=1;
			}
			if($page>8){
					if($totalpages-$page>=7){
					$e_page=$page+7;
					$s_page=$page-7;
					}
					else{
					$e_page=$totalpages;
					$s_page=$totalpages-15;
					}
			}
			echo "<div align=center>";
			if($page!=1){
			$f_page1=$page-1;
			echo "<<a href=$PHP_SELF?$url_link&page=1>หน้าแรก </a>";
			echo "<<<a href=$PHP_SELF?$url_link&page=$f_page1>หน้าก่อน </a>";
			}
			else {
			echo "หน้า	";
			}					
			for($i=$s_page; $i<=$e_page; $i++){
					if($i==$page){
					echo "[<b><font size=+1 color=#990000>$i</font></b>]";
					}
					else {
					echo "<a href=$PHP_SELF?$url_link&page=$i>[$i]</a>";
					}
			}
			if($page<$totalpages)	{
			$f_page2=$page+1;
			echo "<a href=$PHP_SELF?$url_link&page=$f_page2> หน้าถัดไป</a>>>";
			echo "<a href=$PHP_SELF?$url_link&page=$totalpages> หน้าสุดท้าย</a>>";
			}
			echo " <select onchange=\"location.href=this.options[this.selectedIndex].value;\" size=\"1\" name=\"select\">";
			echo "<option  value=\"\">หน้า</option>";
				for($p=1;$p<=$totalpages;$p++){
				echo "<option  value=\"?$url_link&page=$p\">$p</option>";
				}
			echo "</select>";
echo "</div>";  
}					
//จบแยกหน้า

$sql = "select system_school.id, system_school.school_code, system_school.school_name, system_school.school_type, system_khet.khet_name from system_school left join system_khet on system_school.khet_code=system_khet.khet_code order by system_khet.khet_type,system_school.school_code limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);

echo  "<table width='75%' border='0' align='center'>";
echo "<Tr><Td colspan='6' align='left'><INPUT TYPE='button' name='smb' value='เพิ่มข้อมูล' onclick='location.href=\"?file=school&task=school&index=1\"'></Td></Tr>";

echo "<Tr bgcolor=#FFCCCC align='center'><Td width='50'>ที่</Td><Td width='120'>รหัสสถานศึกษา</Td><Td>ชื่อสถานศึกษา</Td><Td>ประเภท</Td><Td>สพท.</Td><Td   width='50'>ลบ</Td><Td width='50'>แก้ไข</Td></Tr>";
$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$school_code= $result['school_code'];
		$school_name= $result['school_name'];
		$school_type= $result['school_type'];
		$khet_name= $result['khet_name'];
			if($school_type==1){
			$school_type_text="<font color='#FF0000'>การศึกษาพิเศษ</font>";
			}
			else if($school_type==2){
			$school_type_text="ประถมศึกษา";
			}
			else if($school_type==3){
			$school_type_text="มัธยมศึกษา";
			}
			else{
			$school_type_text="";
			}
		
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";

		echo "<Tr  bgcolor=$color align='center'><Td>$N</Td> <Td>$school_code</Td><Td align='left'>$school_name</Td><Td align='left'>$school_type_text</Td><Td align='left'>$khet_name</Td><Td><div align='center'><a href=?file=school&task=school&index=2&id=$id&page=$page><img src=../images/drop.png border='0' alt='ลบ'></a></div></Td><Td><a href=?file=school&task=school&index=5&id=$id&page=$page><img src=../images/edit.png border='0' alt='แก้ไข'></a></div></Td>
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
		callfrm("?file=school");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.school_code.value == ""){
			alert("กรุณากรอกรหัสตำแหน่ง");
		}else if(frm1.school_name.value==""){
			alert("กรุณากรอกชื่อตำแหน่ง");
		}else if(frm1.school_type.value==""){
			alert("กรุณาเลือกประเภทสถานศึกษา");
		}else{
			callfrm("?file=school&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?file=school");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.school_code.value == ""){
			alert("กรุณากรอกรหัสตำแหน่ง");
		}else if(frm1.school_name.value==""){
			alert("กรุณากรอกชื่อตำแหน่ง");
		}else if(frm1.school_type.value==""){
			alert("กรุณาเลือกประเภทสถานศึกษา");
		}else{
			callfrm("?file=school&index=6");   //page ประมวลผล
		}
	}
}
</script>
