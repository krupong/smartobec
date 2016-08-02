<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
?>
<script type="text/javascript" src="jquery/jquery-1.5.1.js"></script> 
<script type="text/javascript">
$(function(){
	$("select#khet_code").change(function(){
		var datalist2 = $.ajax({	// รับค่าจาก ajax เก็บไว้ที่ตัวแปร datalist2
			  url: "modules/person/return_ajax_school.php", // ไฟล์สำหรับการกำหนดเงื่อนไข
			  data:"khet_code="+$(this).val(), // ส่งตัวแปร GET ชื่อ khet_code ให้มีค่าเท่ากับ ค่าของ khet_code
			  async: false
		}).responseText;		
		$("select#school").html(datalist2); // นำค่า datalist2 มาแสดงใน listbox ที่ 2 
		// ชื่อตัวแปร และ element ต่างๆ สามารถเปลี่ยนไปตามการกำหนด
	});
});

$(function(){
	$("select#khet_code").change(function(){
		var datalist2 = $.ajax({	// รับค่าจาก ajax เก็บไว้ที่ตัวแปร datalist2
			  url: "modules/person/return_ajax_school.php", // ไฟล์สำหรับการกำหนดเงื่อนไข
			  data:"khet_code="+$(this).val(), // ส่งตัวแปร GET ชื่อ khet_code ให้มีค่าเท่ากับ ค่าของ khet_code
			  async: false
		}).responseText;		
		$("select#school_code").html(datalist2); // นำค่า datalist2 มาแสดงใน listbox ที่ 2 
		// ชื่อตัวแปร และ element ต่างๆ สามารถเปลี่ยนไปตามการกำหนด
	});
});
</script>

<?php
$officer=$_SESSION['login_user_id'];

if(!isset($_REQUEST['school_code'])){
$_REQUEST['school_code']="";
}
if(!isset($_REQUEST['khet_code'])){
$_REQUEST['khet_code']="";
}

if(!isset($_REQUEST['page_var1'])){
$_REQUEST['page_var1']="";
}

if(!isset($_REQUEST['name_search'])){
$_REQUEST['name_search']="";
}

$sql = "select * from  person_sch_position order by position_code";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)){
$position_ar[$result['position_code']]=$result['position_name'];
}

echo "<br />";
if(!(($index==1) or ($index==2) or ($index==2.1) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>ข้อมูลครูและบุคลากรสถานศึกษา (ปัจจุบัน)</strong></font></td></tr>";
echo "</table>";
}

//ส่วนการแสดงผล
if(!(($index==1) or ($index==2) or ($index==2.1) or ($index==5))){
	
	//เกี่ยวการส่งค่ารหัสโรงเรียนตอนเลือกหน้า
	if(($_REQUEST['school_code']=="") and ($_REQUEST['page_var1']!="")){ 
	$_REQUEST['school_code']=$_REQUEST['page_var1'];
	}

//ส่วนของการแยกหน้า
if($index==8 and ($_REQUEST['name_search']!="")){
$sql_page=  "select * from  person_sch_main  left join system_school on person_sch_main.school_code=system_school.school_code  where person_sch_main.name like '%$_REQUEST[name_search]%' or person_sch_main.surname like '%$_REQUEST[name_search]%' or  system_school.school_name like '%$_REQUEST[name_search]%' and person_sch_main.status='0' ";
$_REQUEST['school_code']="";
}
else if($_REQUEST['school_code']=="" and $_REQUEST['khet_code']==""){
$sql_page = "select *,person_sch_main.id from person_sch_main left join system_school on person_sch_main.school_code=system_school.school_code where status='0' ";
}
else if($_REQUEST['school_code']=="" and $_REQUEST['khet_code']!=""){
$sql_page = "select *,person_sch_main.id from person_sch_main left join system_school on person_sch_main.school_code=system_school.school_code where status='0' and system_school.khet_code='$_REQUEST[khet_code]' ";
}
else if($_REQUEST['school_code']!=""){
$sql_page = "select *,person_sch_main.id from person_sch_main left join system_school on person_sch_main.school_code=system_school.school_code where status='0' and person_sch_main.school_code='$_REQUEST[school_code]' ";
}
$dbquery_page = mysqli_query($connect,$sql_page);
$num_rows=mysqli_num_rows($dbquery_page);

$pagelen=50; // กำหนดแถวต่อหน้า
$url_link="option=person&task=person_sch&page_var1=$_REQUEST[school_code]&index=$index&name_search=$_REQUEST[name_search]";
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
echo "<table width='90%' align='center'><tr><Td align='left'></Td><td align='right'>";
//ค้นหาบุคคล
echo "ค้นหาด้วยชื่อ หรือนามสกุล หรือชื่อสถานศึกษา&nbsp;";
		if($index==8){
		echo "<Input Type='Text' Name='name_search' value='$_REQUEST[name_search]'>";
		}
		else{
		echo "<Input Type='Text' Name='name_search'>";
		}
echo "&nbsp;<INPUT TYPE='button' name='smb'  value='ค้น' onclick='goto_display(2)'>";

echo "</td></tr>";
echo "<tr><Td align='left'></Td><td align='right'>";
echo "เลือกสพท.&nbsp";
echo "<Select  name='khet_code' id='khet_code' size='1'>";
echo  '<option value ="" >ทั้งหมด</option>' ;
$sql = "select * from  system_khet order by khet_type,khet_code";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)){
			if($_REQUEST['khet_code']==""){
			echo "<option value=$result[khet_code]>$result[khet_code] $result[khet_name]</option>"; 
			}
			else{
					if($_REQUEST['khet_code']==$result['khet_code']){
					echo "<option value=$result[khet_code] selected>$result[khet_code] $result[khet_name]</option>"; 
					}
					else{
					echo "<option value=$result[khet_code]>$result[khet_code] $result[khet_name]</option>"; 
					}
			}		
}
	echo "</select>";


echo "&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;";
echo "เลือกสถานศึกษา&nbsp";
echo "<Select  name='school_code' id='school_code' size='1'>";
echo  '<option value ="" >ทั้งหมด</option>' ;

if($_REQUEST['khet_code']!=""){
$sql = "select * from  system_school where khet_code='$_REQUEST[khet_code]'";
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
}
	echo "</select>";
	echo "&nbsp;<INPUT TYPE='button' name='smb' value='เลือก' onclick='goto_display(1)'>";
echo "</td></tr></table>";

if($index==8 and ($_REQUEST['name_search']!="")){
$sql =  "select person_sch_main.id, person_sch_main.person_id, person_sch_main.prename, person_sch_main.name, person_sch_main.surname, person_sch_main.position_code, person_sch_main.school_code, person_sch_main.pic, person_sch_main.person_order,system_school.school_name from person_sch_main left join system_school on person_sch_main.school_code=system_school.school_code where person_sch_main.name like '%$_REQUEST[name_search]%' or  person_sch_main.surname like '%$_REQUEST[name_search]%' or system_school.school_name like '%$_REQUEST[name_search]%' and person_sch_main.status='0' order by person_sch_main.position_code limit $start,$pagelen";
$_REQUEST['school_code']="";
}
else if($_REQUEST['school_code']=="" and $_REQUEST['khet_code']==""){
$sql = "select *,person_sch_main.id from person_sch_main left join system_school on person_sch_main.school_code=system_school.school_code where status='0' order by position_code,person_order limit $start,$pagelen";
}
else if($_REQUEST['school_code']=="" and $_REQUEST['khet_code']!=""){
$sql = "select *,person_sch_main.id from person_sch_main left join system_school on person_sch_main.school_code=system_school.school_code where status='0' and system_school.khet_code='$_REQUEST[khet_code]' order by position_code,person_order limit $start,$pagelen";
}
else if($_REQUEST['school_code']!="" ){
$sql = "select *,person_sch_main.id from person_sch_main left join system_school on person_sch_main.school_code=system_school.school_code where status='0' and person_sch_main.school_code='$_REQUEST[school_code]' order by position_code,person_order limit $start,$pagelen";
}

$dbquery = mysqli_query($connect,$sql);
echo  "<table width='90%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='50'>ที่</Td><Td>ชื่อ</Td><Td>ตำแหน่ง</Td><Td>สถานศึกษา</Td><Td width='50'>รูปภาพ</Td></Tr>";
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

		echo "<Tr  bgcolor=$color align='center'><Td>$N</Td><Td align='left'>$prename&nbsp;$name&nbsp;$surname</Td><Td align='left'>";
if(isset($position_ar[$position_code])){
echo $position_ar[$position_code];
}
echo "</Td>";
echo "<Td align='left'>$result[school_name]</Td>";
if($result['pic']!=""){
echo "<Td align='center'><a href='modules/person/pic_show_2.php?&person_id=$person_id' target='_blank'><img src=images/admin/user.gif border='0' alt='รูปภาพ'></a></Td>";
}
else{
echo "<Td align='center'>&nbsp;</Td>";
}
echo "	</Tr>";
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
		callfrm("?option=person&task=person_sch");   // page ย้อนกลับ 
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
		}else if(frm1.school.value==""){
			alert("กรุณาเลือกสถานศึกษา");
		}else{
			callfrm("?option=person&task=person_sch&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=person&task=person_sch");   // page ย้อนกลับ 
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
		}else if(frm1.school.value==""){
			alert("กรุณาเลือกสถานศึกษา");
		}else{
			callfrm("?option=person&task=person_sch&index=6");   //page ประมวลผล
		}
	}
}

function goto_display(val){
	if(val==1){
		callfrm("?option=person&task=person_sch"); 
		}
	else if(val==2){
		callfrm("?option=person&task=person_sch&index=8"); 
		}
}

function goto_delete_all(){
			callfrm("?option=person&task=person_sch&index=3.1"); 
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
