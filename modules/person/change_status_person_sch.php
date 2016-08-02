<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
if(!(($_SESSION['admin_person']=="person") or ($_SESSION['login_status']<=4 and $result_permission['p1']==1))){	
exit();
}

$officer=$_SESSION['login_user_id'];

if(!isset($_REQUEST['school_code'])){
$_REQUEST['school_code']="";
}

if(!isset($_REQUEST['page_var1'])){
$_REQUEST['page_var1']="";
}

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
if(!(($index==1) or ($index==5) or ($index==9))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>อดีตครูและบุคลากรในสถานศึกษา</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไขสถานะครูและบุคลากร</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
$sql = "select * from  person_sch_main where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
echo "<Table   width='70%' Border='0'>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>เลขประจำตัวประชาชน&nbsp;</Td><Td>$result[person_id]</Td></Tr>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>คำนำหน้าชื่อ&nbsp;</Td><Td>$result[prename]</Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>ชื่อ&nbsp;</Td><Td>$result[name]</Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>นามสกุล&nbsp;</Td><Td>$result[surname]</Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>สถานะภาพ&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td>";
echo "<Select  name='status' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
if($result['status']==0){
echo  "<option value ='0' selected>ปฏิบัติงานในสถานศึกษาปัจจุบัน</option>" ;
echo  "<option value ='1'>เคยปฏิบัติงานในสถานศึกษา</option>" ;
}
else{
echo  "<option value ='0'>ปฏิบัติงานในสถานศึกษาปัจจุบัน</option>" ;
echo  "<option value ='1' selected>เคยปฏิบัติงานในสถานศึกษา</option>" ;
}
echo "</select>";
echo "</Td></Tr>";

echo "</Table>";
echo "<Br />";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "<Input Type=Hidden Name='page' Value='$_GET[page]'>";
echo "<Input Type=Hidden Name='school_code' Value='$_REQUEST[school_code]'>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)' class=entrybutton>
		&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)' class=entrybutton'>";
echo "</form>";
}
//ส่วนปรับปรุงข้อมูล
if($index==6){
$sql = "update person_sch_main set status='$_POST[status]' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}

if($index==9){
	//เกี่ยวการส่งค่ารหัสโรงเรียนตอนเลือกหน้า
	if(($_REQUEST['school_code']=="") and ($_REQUEST['page_var1']!="")){ 
	$_REQUEST['school_code']=$_REQUEST['page_var1'];
	}

//ส่วนของการแยกหน้า
if($_REQUEST['school_code']==""){
$sql_page = "select id from person_sch_main where status='0'";
}
else{
$sql_page = "select id from person_sch_main where  status='0' and school_code='$_REQUEST[school_code]'";
}
$dbquery_page = mysqli_query($connect,$sql_page);
$num_rows=mysqli_num_rows($dbquery_page);

$pagelen=20; // กำหนดแถวต่อหน้า
$url_link="option=person&task=change_status_person_sch&index=$index&page_var1=$_REQUEST[school_code]";
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
echo "<table width='95%' align='center'><tr><td align='right'>";

echo "เลือกสถานศึกษา&nbsp";
echo "<Select  name='school_code' size='1'>";
echo  '<option value ="" >ทั้งหมด</option>' ;
$sql = "select * from  system_school";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)){
			if($_REQUEST['school_code']==""){
			echo "<option value=$result[school_code]>$result[school_code] $result[school_name]</option>"; 
			}
			else{
					if($_REQUEST['school_code']==$result['school_code']){
					echo "<option value=$result[school_code] selected>$result[school_code] $result[school_name]</option>"; 
					}
					else{
					echo "<option value=$result[school_code]>$result[school_code] $result[school_name]</option>"; 
					}
			}		
}
	echo "</select>";
	echo "&nbsp;<INPUT TYPE='button' name='smb' value='เลือก' onclick='goto_display(2)' class='entrybutton'>";
echo "</td></tr></table>";

if($_REQUEST['school_code']==""){
$sql = "select * from person_sch_main where status='0' order by position_code,person_order limit $start,$pagelen";
}
else{
$sql = "select * from person_sch_main where status='0' and school_code='$_REQUEST[school_code]' order by school_code, position_code,person_order limit $start,$pagelen";
}
$dbquery = mysqli_query($connect,$sql);

echo  "<table width='95%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='70'>ที่</Td><Td width='150'>เลขประชาชน</Td><Td>ชื่อ</Td><Td width='300'>ตำแหน่ง</Td><Td width='300'>สถานศึกษา</Td><Td width='60'>รูปภาพ</Td><Td  width='60'>สถานะ</Td><Td  width='60'>แก้ไข</Td></Tr>";
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

		echo "<Tr  bgcolor=$color align=center class=style1><Td>$N</Td><Td align='left'>$person_id</Td><Td align='left'>$prename&nbsp;$name&nbsp;$surname</Td><Td align='left'>";
		
if(isset($position_ar[$position_code])){		
echo $position_ar[$position_code];
}
echo "</Td>";
echo "<Td align='left'>";

if(isset($school_ar[$school_code])){
echo $school_ar[$school_code];
}
echo "</Td>";

if($result['pic']!=""){
echo "<Td align='center'><a href='modules/person/pic_show_2.php?&person_id=$person_id' target='_blank'><img src=images/admin/user.gif border='0' alt='รูปภาพ'></a></Td>";
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

echo "<Td><a href=?option=person&task=change_status_person_sch&index=5&id=$id&page=$page&school_code=$_REQUEST[school_code]><img src=images/edit.png border='0' alt='แก้ไข'></a></div></Td>
	</Tr>";
$M++;
$N++;
	}
echo "</Table>";
echo "</form>";
}


////////////////////////////////////////////////////////////////////
//ส่วนการแสดงผล
if(!(($index==1) or ($index==5) or ($index==9))){
	
	//เกี่ยวการส่งค่ารหัสโรงเรียนตอนเลือกหน้า
	if(($_REQUEST['school_code']=="") and ($_REQUEST['page_var1']!="")){ 
	$_REQUEST['school_code']=$_REQUEST['page_var1'];
	}

//ส่วนของการแยกหน้า
if($_REQUEST['school_code']==""){
$sql_page = "select id from person_sch_main where status='1'";
}
else{
$sql_page = "select id from person_sch_main where  status='1' and school_code='$_REQUEST[school_code]'";
}
$dbquery_page = mysqli_query($connect,$sql_page);
$num_rows=mysqli_num_rows($dbquery_page);

$pagelen=20; // กำหนดแถวต่อหน้า
$url_link="option=person&task=change_status_person_sch&page_var1=$_REQUEST[school_code]";
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
echo "<table width='95%' align='center'><tr><td align='right'>";
echo "เลือกสถานศึกษา&nbsp";
echo "<Select  name='school_code' size='1'>";
echo  '<option value ="" >ทั้งหมด</option>' ;
$sql = "select * from  system_school";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)){
			if($_REQUEST['school_code']==""){
			echo "<option value=$result[school_code]>$result[school_code] $result[school_name]</option>"; 
			}
			else{
					if($_REQUEST['school_code']==$result['school_code']){
					echo "<option value=$result[school_code] selected>$result[school_code] $result[school_name]</option>"; 
					}
					else{
					echo "<option value=$result[school_code]>$result[school_code] $result[school_name]</option>"; 
					}
			}		
}
	echo "</select>";
	echo "&nbsp;<INPUT TYPE='button' name='smb' value='เลือก' onclick='goto_display(1)' class='entrybutton'>";
echo "</td></tr></table>";

if($_REQUEST['school_code']==""){
$sql = "select * from person_sch_main where status='1' order by position_code,person_order limit $start,$pagelen";
}
else{
$sql = "select * from person_sch_main where status='1' and school_code='$_REQUEST[school_code]' order by school_code, position_code,person_order limit $start,$pagelen";
}
$dbquery = mysqli_query($connect,$sql);

		//link เพิ่มข้อมูล
		echo  "<table width='95%' border='0' align='center'>";
		echo "<Tr><td align='left'>";
		echo "<INPUT TYPE='button' name='smb' value='เปลี่ยนแปลงครูและบุคลากรปัจจุบันมาเป็มอดีต' onclick='location.href=\"?option=person&task=change_status_person_sch&index=9&school_code=$_REQUEST[school_code]\"'>";
		echo "</td>";
		echo "</Table>";

echo  "<table width='95%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='70'>ที่</Td><Td width='150'>เลขประชาชน</Td><Td>ชื่อ</Td><Td width='300'>ตำแหน่ง</Td><Td width='300'>สถานศึกษา</Td><Td width='60'>รูปภาพ</Td><Td  width='60'>สถานะ</Td><Td  width='60'>แก้ไข</Td></Tr>";
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

		echo "<Tr  bgcolor='$color' align='center'><Td>$N</Td><Td align='left'>$person_id</Td><Td align='left'>$prename&nbsp;$name&nbsp;$surname</Td><Td align='left'>";
		if(isset($position_ar[$position_code])){
		echo $position_ar[$position_code];
		}
		echo "</Td>";
echo "<Td align='left'>$school_ar[$school_code]</Td>";

if($result['pic']!=""){
echo "<Td align='center'><a href='modules/person/pic_show_2.php?&person_id=$person_id' target='_blank'><img src=images/admin/user.gif border='0' alt='รูปภาพ'></a></Td>";
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

echo "<Td><a href=?option=person&task=change_status_person_sch&index=5&id=$id&page=$page&school_code=$_REQUEST[school_code]><img src=images/edit.png border='0' alt='แก้ไข'></a></div></Td>
	</Tr>";
$M++;
$N++;
	}
echo "</Table>";
echo "</form>";
}

?>
<script>
function goto_url_update(val){
	if(val==0){
		callfrm("?option=person&task=change_status_person_sch&index=9");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.status.value == ""){
			alert("กรุณาเลือกสถานภาพ");
		}else{
			callfrm("?option=person&task=change_status_person_sch&index=6");   //page ประมวลผล
		}
	}
}

function goto_display(val){
		if(val==1){
		callfrm("?option=person&task=change_status_person_sch"); 
		}
		if(val==2){
		callfrm("?option=person&task=change_status_person_sch&index=9"); 
		}
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
