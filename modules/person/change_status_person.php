<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
if(!(($_SESSION['admin_person']=="person") or ($_SESSION['login_status']<=4 and $result_permission['p1']==1))){	
exit();
}

$officer=$_SESSION['login_user_id'];

$sql = "select * from  person_position order by position_code";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)){
$position_ar[$result['position_code']]=$result['position_name'];
}

$sql = "select * from  system_workgroup order by workgroup_order";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)){
$department_ar[$result['workgroup']]=$result['workgroup_desc'];
}

echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5) or ($index==9))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>อดีตครูและบุคลากรในสำนักงานเขตพื้นที่การศึกษา</strong></font></td></tr>";
echo "</table>";
echo "<br>";
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไขสถานะครูและบุคลากร</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
$sql = "select * from  person_main where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
echo "<Table   width='70%' Border='0'>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>เลขประจำตัวประชาชน&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td>$result[person_id]</Td></Tr>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>คำนำหน้าชื่อ&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td>$result[prename]</Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>ชื่อ&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td>$result[name]</Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>นามสกุล&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td>$result[surname]</Td></Tr>";
if(isset($result['position_code'])){
$post=$position_ar[$result['position_code']];
}
else{
$post="";
}
echo "<Tr align='left'><Td ></Td><Td align='right'>ตำแหน่ง&nbsp;</Td><Td>$post</Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>สถานะภาพ&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td>";
echo "<Select  name='status' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
if($result['status']==0){
echo  "<option value ='0' selected>ปฏิบัติงานในสพท.ปัจจุบัน</option>" ;
echo  "<option value ='1'>เคยปฏิบัติงานใน สพท.</option>" ;
}
else{
echo  "<option value ='0'>ปฏิบัติงานในสพท.ปัจจุบัน</option>" ;
echo  "<option value ='1' selected>เคยปฏิบัติงานใน สพท.</option>" ;
}
echo "</select>";
echo "</Td></Tr>";

echo "</Table>";
echo "<Br />";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "<Input Type=Hidden Name='page' Value='$_GET[page]'>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)' class=entrybutton>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)' class=entrybutton'>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
$sql = "update person_main set status='$_POST[status]' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}

///////////////////////////////////////////////////
if ($index==9){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>ครูและบุคลากรในสำนักงานเขตพื้นที่การศึกษา(ปัจจุบัน)</strong></font></td></tr>";
echo "</table>";
echo "<br>";

echo "<form id='frm1' name='frm1'>";
$sql = "select * from person_main  where status='0' order by department, position_code,person_order";
$dbquery = mysqli_query($connect,$sql);
echo  "<table width='95%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><td>เลือก</td><Td width='50'>ที่</Td><Td width='130'>เลขประชาชน</Td><Td>ชื่อ</Td><Td width='300'>ตำแหน่ง</Td><Td width='300'>กลุ่ม</Td><Td width='50'>รูปภาพ</Td></Tr>";
$N=1;
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$person_id = $result['person_id'];
		$prename=$result['prename'];
		$name= $result['name'];
		$surname = $result['surname'];
		$position_code= $result['position_code'];
		$person_order= $result['person_order'];
		$department= $result['department'];
			if(($M%2) == 0)
			$color="#FFFFC";
			else $color="#FFFFFF";

		echo "<Tr bgcolor='$color' align='center'><td><input type='checkbox' name='$person_id' value='1'><Td>$N</Td><Td align='left'>$person_id</Td><Td align='left'>$prename&nbsp;$name&nbsp;&nbsp;$surname</Td>";
		
if(isset($position_ar[$position_code])){		
echo "<Td align='left'>$position_ar[$position_code]</Td>";
}
else{
echo "<Td align='left'></Td>";

}

if(isset($department_ar[$department])){		
echo "<Td align='left'>$department_ar[$department]</Td>";
}
else{
echo "<Td align='left'></Td>";
}
if($result['pic']!=""){
echo "<Td align='center'><a href='modules/person/pic_show.php?&person_id=$person_id' target='_blank'><img src=images/admin/user.gif border='0' alt='รูปภาพ'></a></Td>";
}
else{
echo "<Td align='center'>&nbsp;</Td>";
}
echo "</Tr>";
$M++;
$N++;
	}
echo "<Tr bgcolor='#FFCCCC'><Td colspan='7'><input type='checkbox' name='allchk' id='allchk' onclick='CheckAll()'>เลือก/ไม่เลือกทั้งหมด &nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE='button' name='smb' value='ครูและบุคลากร(ที่เลือก)ให้เป็นอดีต' onclick='goto_index10()'></Td></Tr>";
echo "</Table>";
echo "</form>";
}

if($index==10){
	foreach ($_POST as $person_id =>$person_value){
	$sql = "update person_main set status='1' where person_id='$person_id'";
	$dbquery = mysqli_query($connect,$sql);
	}
}


//ส่วนการแสดงผล
if(!(($index==1) or ($index==5) or ($index==9))){

//ส่วนของการแยกหน้า
$sql_page = "select id from person_main where status='1'";
$dbquery_page = mysqli_query($connect,$sql_page);
$num_rows=mysqli_num_rows($dbquery_page);

$pagelen=20; // กำหนดแถวต่อหน้า
$url_link="option=person&task=change_status_person";
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

		//link เพิ่มข้อมูล
		echo  "<table width='85%' border='0' align='center'>";
		echo "<Tr><td align='left'>";
		echo "<INPUT TYPE='button' name='smb' value='เปลี่ยนแปลงครูและบุคลากรปัจจุบันมาเป็มอดีต' onclick='location.href=\"?option=person&task=change_status_person&index=9\"'>";
		echo "</td>";
		echo "</Table>";

$sql = "select * from person_main where status='1' order by department, position_code,person_order limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);
echo  "<table width='85%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='50'>ที่</Td><Td width='150'>เลขประชาชน</Td><Td>ชื่อ</Td><Td width='300'>ตำแหน่ง</Td><Td width='50'>รูปภาพ</Td><Td  width='60'>สถานะ</Td><Td  width='60'>แก้ไข</Td></Tr>";
$N=1;
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$person_id = $result['person_id'];
		$prename=$result['prename'];
		$name= $result['name'];
		$surname = $result['surname'];
		$position_code= $result['position_code'];
		$person_order= $result['person_order'];
		$department= $result['department'];
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";

		echo "<Tr  bgcolor=$color align=center class=style1><Td>$N</Td><Td align='left'>$person_id</Td><Td align='left'>$prename&nbsp;$name&nbsp;&nbsp;$surname</Td><Td align='left'>";
		if(isset($position_ar[$position_code])){
		echo $position_ar[$position_code];
		}
echo "</Td>";
if($result['pic']!=""){
echo "<Td align='center'><a href='modules/person/pic_show.php?&person_id=$person_id' target='_blank'><img src=images/admin/user.gif border='0' alt='รูปภาพ'></a></Td>";
}
else{
echo "<Td align='center'>&nbsp;</Td>";
}

if($result['status']==0){
echo "<Td>ปัจจุบัน</Td>";
}
else{
echo "<Td><font color='#FF0000'>อดีต</font></Td>";
}
echo "<Td><a href=?option=person&task=change_status_person&index=5&id=$id&page=$page><img src=images/edit.png border='0' alt='แก้ไข'></a></div></Td>	</Tr>";
$M++;
$N++;
	}
echo "</Table>";
}

?>
<script>
function goto_url_update(val){
	if(val==0){
		callfrm("?option=person&task=change_status_person");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.status.value == ""){
			alert("กรุณาเลือกสถานภาพ");
		}else{
			callfrm("?option=person&task=change_status_person&index=6");   //page ประมวลผล
		}
	}
}

function goto_index10(){
			callfrm("?option=person&task=change_status_person&index=10"); 
}

function CheckAll() {
	for (var i = 0; i < document.frm1.elements.length; i++)
	{
	var e = document.frm1.elements[i];
	if (e.name != "allchk")
		if(e.value==1 && e.type=="checkbox"){
		e.checked = document.frm1.allchk.checked;
		}
	}
}

</script>
