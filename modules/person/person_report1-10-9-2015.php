<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
$officer=$_SESSION['login_user_id'];

if(!isset($_REQUEST['department'])){
$_REQUEST['department']="";
}

if(!isset($_REQUEST['page_var1'])){
$_REQUEST['page_var1']="";
}

if(!isset($_REQUEST['name_search'])){
$_REQUEST['name_search']="";
}


$sql = "select * from  person_position order by position_code";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)){
$position_ar[$result['position_code']]=$result['position_name'];
}

$sql = "select * from  system_department order by department_order";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)){
$department_ar[$result['department']]=$result['department_name'];
}

$sql = "select * from  system_subdepartment order by sub_department";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)){
$sub_department_ar[$result['sub_department']]=$result['sub_department_name'];
}

echo "<br />";
if(!(($index==1) or ($index==2) or ($index==2.1) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>ข้อมูลบุคลากรใน สพฐ. (ปัจจุบัน)</strong></font></td></tr>";
echo "</table>";
}

//ส่วนการแสดงผล
if(!(($index==1) or ($index==2) or ($index==2.1) or ($index==5))){

	//เกี่ยวการส่งค่ารหัสโรงเรียนตอนเลือกหน้า
	if(($_REQUEST['department']=="") and ($_REQUEST['page_var1']!="")){ 
	$_REQUEST['department']=$_REQUEST['page_var1'];
	}

//ส่วนของการแยกหน้า
$pagelen=50;  // 1_กำหนดแถวต่อหน้า
$url_link="option=person&task=person_report1&page_var1=$_REQUEST[department]&index=$index&name_search=$_REQUEST[name_search]";

if($index==8 and ($_REQUEST['name_search']!="")){
$sql_page =  "select person_main.id, person_main.person_id, person_main.prename, person_main.name, person_main.surname, person_main.position_code, person_main.department, person_main.sub_department,person_main.pic, person_main.person_order,person_main.position_other_code from  person_main  left join system_department on person_main.department=system_department.department  where person_main.name like '%$_REQUEST[name_search]%'  or person_main.surname like '%$_REQUEST[name_search]%'  and person_main.status='0' ";
$_REQUEST['department']="";
}
else if($_REQUEST['department']==""){
$sql_page = "select id from person_main where status='0' ";
}
else{
$sql_page = "select id from person_main where status='0' and department='$_REQUEST[department]'";
}

$dbquery = mysqli_query($connect,$sql_page);
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

echo "<form id='frm1' name='frm1'>";
echo  "<table width='90%' border='0' align='center'>";
echo "<Tr><Td colspan='9' align='left'></Td><td align='right'>";

//ค้นหาบุคคล
echo "ค้นหาด้วยชื่อ หรือนามสกุล&nbsp;";
		if($index==8){
		echo "<Input Type='Text' Name='name_search' value='$_REQUEST[name_search]'>";
		}
		else{
		echo "<Input Type='Text' Name='name_search'>";
		}
echo "&nbsp;<INPUT TYPE='button' name='smb'  value='ค้น' onclick='goto_display(2)'>";
echo "&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;";

echo "เลือกสำนัก&nbsp";
echo "<Select  name='department' size='1'>";
echo  '<option value ="" >ทั้งหมด</option>' ;
$sql = "select * from  system_department order by department_order,department";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)){
			if($_REQUEST['department']==""){
			echo "<option value=$result[department]>$result[department] $result[department_name]</option>"; 
			}
			else{
					if($_REQUEST['department']==$result['department']){
					echo "<option value=$result[department] selected>$result[department] $result[department_name]</option>"; 
					}
					else{
					echo "<option value=$result[department]>$result[department] $result[department_name]</option>"; 
					}
			}		
}
	echo "</select>";
	echo "&nbsp;<INPUT TYPE='button' name='smb' value='เลือก' onclick='goto_display(1)' class='entrybutton'>";
echo "</td></tr></table>";

if($index==8 and ($_REQUEST['name_search']!="")){
$sql =  "select person_main.id, person_main.person_id, person_main.prename, person_main.name, person_main.surname, person_main.position_code, person_main.department, person_main.sub_department, person_main.pic, person_main.person_order,person_main.position_other_code from  person_main  left join system_department on person_main.department=system_department.department where person_main.name like '%$_REQUEST[name_search]%'  or person_main.surname like '%$_REQUEST[name_search]%'  and person_main.status='0'  order by person_main.position_code limit $start,$pagelen";
$_REQUEST['department']="";
}
else if($_REQUEST['department']==""){
$sql = "select * from person_main where status='0' order by position_code,person_order limit $start,$pagelen";
}
else{
$sql = "select * from person_main where status='0' and department='$_REQUEST[department]' order by department, position_code,person_order limit $start,$pagelen";
}
$dbquery = mysqli_query($connect,$sql);
echo  "<table width='90%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='70'>ที่</Td><Td>ชื่อ</Td><Td>ตำแหน่ง</Td><Td>กลุ่ม</Td><Td>สำนัก</Td><Td width='50'>รูปภาพ</Td></Tr>";
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
		$person_order= $result['person_order'];
		$department= $result['department'];
		$sub_department= $result['sub_department'];
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";

		echo "<Tr  bgcolor='$color' align='center'><Td>$N</Td><Td align='left'>$prename&nbsp;$name&nbsp;&nbsp;$surname</Td><Td align='left'>";
		if(isset($position_ar[$position_code])){
		echo $position_ar[$position_code];
		}
		
if($result['position_other_code']==9999){
echo " (รองผู้อำนวยการสำนัก)";
}
$sql = "select * from system_subdepartment where sub_department='$result[position_other_code]'";
$query_sub = mysqli_query($connect,$sql);
while($result_sub = mysqli_fetch_array($query_sub)){
	$sub_department_name = $result_sub['sub_department_name'];
	echo " (ผอ.$sub_department_name)";
}
		
echo "</Td>";
if(isset($department_ar[$department])){
echo "<Td align='left'>$department_ar[$department]</Td>";
}
else{
echo "<Td align='left'></Td>";
}

if(isset($sub_department_ar[$sub_department])){
echo "<Td align='left'>$sub_department_ar[$sub_department]</Td>";
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
$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}
echo "</Table>";
echo "</form>";
}

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=person&task=person_report1");   // page ย้อนกลับ 
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
			callfrm("?option=person&task=person_report1&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=person&task=person_report1");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณากรอกเลขประจำตัวประชาชน");
		}else if(frm1.prename.value==""){
			alert("กรุณากรอกคำนำหน้าชื่อ");
		}else if(frm1.name.value==""){
			alert("กรุณากรอกชื่อ");
		}else if(frm1.surname.value==""){
			alert("กรุณากรอกนามสกุล");
		}else{
			callfrm("?option=person&task=person_report1&index=6");   //page ประมวลผล
		}
	}
}

function goto_display(val){
	if(val==1){
		callfrm("?option=person&task=person_report1"); 
		}
	else if(val==2){
		callfrm("?option=person&task=person_report1&index=8"); 
		}
}

function goto_delete_all(){
			callfrm("?option=person&task=person_report1&index=3.1"); 
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
