<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
if(!(($_SESSION['admin_person']=="person") or ($_SESSION['login_status']<=4 and $result_permission['p1']==1))){	
exit();
}

$officer=$_SESSION['login_user_id'];

$sql = "select * from  person_sch_position order by position_code";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)){
$position_ar[$result['position_code']]=$result['position_name'];
}

$sql = "select * from  system_school";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)){
$school_ar[$result['school_code']]=$result['school_name'];
}

echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>บุคลากรในสถานศึกษา ปฏิบัติงานมากกว่า 1 แห่ง</strong></font></td></tr>";
echo "</table>";
}


//ส่วนเพิ่มข้อมูล
if($index==1){
echo "<form Enctype = multipart/form-data id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มข้อมูลสถานศึกษาที่ปฏิบัติงาน</B></Font>";
echo "</Cener>";
echo "<Br><Br>";

$sql_ref = "select * from  person_sch_main where person_id='$_GET[person_id]'";
$dbquery_ref = mysqli_query($connect,$sql_ref);
$result_ref = mysqli_fetch_array($dbquery_ref);

echo "<Table width='60%' Border='0'>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>เลขประจำตัวประชาชน&nbsp;</Td><Td>$result_ref[person_id] </Td></Tr>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>ชื่อ&nbsp;</Td><Td>$result_ref[prename]$result_ref[name]&nbsp;$result_ref[surname]</Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>สถานศึกษา&nbsp;</Td><Td>";
echo "<Select  name='school_code' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;

$sql = "select * from  system_school order by school_type,school_code";
$dbquery = mysqli_query($connect,$sql);
While ($school_result = mysqli_fetch_array($dbquery)){
echo  "<option  value ='$school_result[school_code]'>$school_result[school_code] $school_result[school_name]</option>" ;
}	
echo "</select>";
echo "</Td></Tr>";

echo "<Br>";
echo "</Table>";
echo "<Br>";
echo "<Input Type=Hidden Name='person_id' Value='$result_ref[person_id]'>";
echo "<Input Type=Hidden Name='page' Value='$_REQUEST[page]'>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)'>
		&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)'>";

echo "</form>";
}

//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=person&task=person_sch_other&index=3&id=$_GET[id]&page=$_REQUEST[page]\"'>
		&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=person&task=person_sch_other&page=$_REQUEST[page]\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from person_sch_other where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนเพิ่มข้อมูล
if($index==4){
$rec_date = date("Y-m-d");
$sql = "insert into person_sch_other (person_id,school_code,status,officer,rec_date) values ( '$_POST[person_id]','$_POST[school_code]','0','$officer','$rec_date')";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form Enctype = multipart/form-data id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไขข้อมูลสถานศึกษาที่ปฏิบัติงาน</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
$sql = "select * from  person_sch_main where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);

echo "<Table width='70%' Border='0'>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>เลขประจำตัวประชาชน&nbsp;</Td><Td>$result[person_id] </Td></Tr>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>ชื่อ&nbsp;</Td><Td>$result[prename]$result[name]&nbsp;$result[surname]</Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>สถานศึกษา&nbsp;</Td><Td>";
echo "<Select  name='school' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;

$sql = "select * from  system_school order by school_type,school_code";
$dbquery = mysqli_query($connect,$sql);
While ($school_result = mysqli_fetch_array($dbquery)){
		if($_GET['school_code']==$school_result['school_code']){
		echo  "<option  value ='$school_result[school_code]' selected>$school_result[school_code] $school_result[school_name]</option>" ;
		}
		else{
		echo  "<option  value ='$school_result[school_code]'>$school_result[school_code] $school_result[school_name]</option>" ;
		}
}	
echo "</select>";
echo "</Td></Tr>";

echo "</Table>";
echo "<Br />";
echo "<Input Type=Hidden Name='id' Value='$_GET[id_other]'>";
echo "<Input Type=Hidden Name='page' Value='$_GET[page]'>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)' class=entrybutton>
		&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)' class=entrybutton'>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
$rec_date = date("Y-m-d");
$sql = "update person_sch_other set  school_code='$_POST[school]', officer='$officer', rec_date='$rec_date' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนการแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){
	
//ส่วนของการแยกหน้า
$sql = "select * from person_sch_main where status='0' and other='1' ";
$dbquery_page = mysqli_query($connect,$sql);
$num_rows=mysqli_num_rows($dbquery_page);

$pagelen=20; // กำหนดแถวต่อหน้า
$url_link="option=person&task=person_sch_other";
$totalpages=ceil($num_rows/$pagelen);
//
if(!isset($_REQUEST['page'])){
$_REQUEST['page']="";
}
//
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

echo "<form id='frm1' name='frm1'>";

$sql = "select * from person_sch_main where status='0' and other='1' order by name limit $start,$pagelen";

$dbquery = mysqli_query($connect,$sql);
echo  "<table width='95%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='70'>ที่</Td><Td width='120'>เลขประชาชน</Td><Td>ชื่อ</Td><Td width='300'>ตำแหน่ง</Td><Td width='300'>สถานศึกษา</Td><Td width='50'>รูปภาพ</Td><Td  width='70'>เพิ่มข้อมูล</Td><Td  width='60'>ลบ</Td><Td  width='60'>แก้ไข</Td></Tr>";
$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$person_id = $result['person_id'];
		$prename=$result['prename'];
		$name= $result['name'];
		$surname = $result['surname'];
		$position_code= $result['position_code'];
		$school_code= $result['school_code'];
		$person_order= $result['person_order'];
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";

		echo "<Tr bgcolor=$color valign='top'><Td align='center'>$N</Td><Td valign='top'>$person_id</Td><Td valign='top'>$prename&nbsp;$name&nbsp;$surname</Td><Td valign='top'>$position_ar[$position_code]</Td>";

echo "<Td align='left'>$school_ar[$school_code]";
echo "  <font color='#FF0000'>(สถานศึกษาหลัก)</font>";
echo "</td>";

if($result['pic']!=""){
echo "<Td align='center'><a href='modules/person/pic_show_2.php?&person_id=$person_id' target='_blank'><img src=images/admin/user.gif border='0' alt='รูปภาพ'></a></Td>";
}
else{
echo "<Td align='center'>&nbsp;</Td>";
}
echo "<td align='center'><a href=?option=person&task=person_sch_other&index=1&person_id=$person_id&page=$page><img src=images/browse.png border='0' alt='เพิ่มข้อมูล'></a></td><Td></Td>
		<Td></Td></Tr>";
	
//หาโรงเรียนอื่น ๆ 
			$sql_other = "select * from person_sch_other where person_id='$person_id' ";
			$dbquery_other = mysqli_query($connect,$sql_other);
			While ($result_other = mysqli_fetch_array($dbquery_other)){
			echo "<tr><td colspan='4'></td><td>";
			echo $school_ar[$result_other['school_code']];
			echo "</td><td></td><td></td>";
			echo "<td align='center'><a href=?option=person&task=person_sch_other&index=2&id=$result_other[id]&page=$page><img src=images/drop.png border='0' alt='ลบ'></a></td>";
			echo "<td align='center'><a href=?option=person&task=person_sch_other&index=5&id=$id&id_other=$result_other[id]&page=$page&school_code=$result_other[school_code]><img src=images/edit.png border='0' alt='แก้ไข'></a></td></tr>";
			}
$M++;
$N++;
	}

echo "</Table>";
echo "</form>";

}

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=person&task=person_sch_other");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณากรอกเลขประจำตัวประชาชน");
		}else if(frm1.school_code.value==""){
			alert("กรุณาเลือกสถานศึกษา");
		}else{
			callfrm("?option=person&task=person_sch_other&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=person&task=person_sch_other");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.school.value == ""){
			alert("กรุณาเลือกสถานศึกษา");
		}else{
			callfrm("?option=person&task=person_sch_other&index=6");   //page ประมวลผล
		}
	}
}

</script>
