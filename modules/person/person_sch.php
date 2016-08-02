<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
if(!(($_SESSION['admin_person']=="person") or ($_SESSION['login_status']<=4 and $result_permission['p1']==1))){	
exit();
}

?>
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

//ฟังชั่นupload
function file_upload() {
		$uploaddir = 'modules/person/picture/';      //ที่เก็บไไฟล์
		$uploadfile = $uploaddir.basename($_FILES['userfile']['name']);
		$basename = basename($_FILES['userfile']['name']);
		
		$pic_code=$_POST['person_id'];
		//ลบไฟล์เดิม
		$exists_file=$uploaddir.$pic_code.substr($basename,-4);
		if(file_exists($exists_file)){
		unlink($exists_file);
		}
			
		if (move_uploaded_file($_FILES['userfile']['tmp_name'],  $uploadfile))
			{
				$before_name  = $uploaddir.$basename;
				$changed_name = $uploaddir.$pic_code.substr($basename,-4) ;
				rename("$before_name" , "$changed_name");
		
		//ลดขนาดภาพ
			if(substr($basename,-3)=="JPG" or substr($basename,-3)=="jpg"){		
				$ori_file=$changed_name;
				$ori_size=getimagesize($ori_file);
				$ori_w=$ori_size[0];
				$ori_h=$ori_size[1];
					if($ori_w>500){
					$new_w=500;
					$new_h=round(($new_w/$ori_w)*$ori_h);
					$ori_img=imagecreatefromjpeg($ori_file);
					$new_img=imagecreatetruecolor($new_w, $new_h);
					imagecopyresized($new_img, $ori_img,0,0, 0,0, $new_w, $new_h, $ori_w, $ori_h);
					$new_file=$ori_file;
					imagejpeg($new_img, $new_file);
					imagedestroy($ori_img);
					imagedestroy($new_img);
					}	
				}						
				
			return  $changed_name;
			}
}

//ส่วนเพิ่มข้อมูล
if($index==1){
echo "<form Enctype = multipart/form-data id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มข้อมูลครูและบุคลากร</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='60%' Border='0'>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>เลขประจำตัวประชาชน&nbsp;</Td><Td><Input Type='Text' Name='person_id' Size='13' maxlenght='13' onkeydown='integerOnly()'></Td></Tr>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>คำนำหน้าชื่อ&nbsp;</Td><Td><Input Type='Text' Name='prename' Size='15'></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>ชื่อ&nbsp;</Td><Td><Input Type='Text' Name='name'  Size='40'></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>นามสกุล&nbsp;</Td><Td><Input Type='Text' Name='surname'  Size='40'></Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ตำแหน่ง&nbsp;</Td><Td>";
echo "<Select  name='position_code' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;

$sql = "select * from  person_sch_position order by position_code";
$dbquery = mysqli_query($connect,$sql);
While ($person_result = mysqli_fetch_array($dbquery)){
echo  "<option  value ='$person_result[position_code]'>$person_result[position_code] $person_result[position_name]</option>" ;
}	
echo "</select>";
echo "</Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>สพท&nbsp;</Td><Td>";
echo "<Select  name='khet_code' id='khet_code' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
 
$sql = "select * from  system_khet order by khet_type,khet_code";
$dbquery = mysqli_query($connect,$sql);
While ($result_khet = mysqli_fetch_array($dbquery)){
echo  "<option  value ='$result_khet[khet_code]'>$result_khet[khet_code] $result_khet[khet_name]</option>" ;
}	
echo "</select>";
echo "</Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>สถานศึกษา&nbsp;</Td><Td>";
echo "<Select  name='school' id='school' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo "</select>";
echo "</Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ลำดับบุคคลในตำแหน่ง&nbsp;</Td><Td><Input Type='Text' Name='person_order'  Size='4'>&nbsp;(หากประสงค์เรียงลำดับ)</Td></Tr>";

echo  "<tr align='left'>";
echo  "<Td ></Td><td align='right'>ไฟล์รูปภาพ&nbsp;</td>";
echo  "<td align='left'><input name = 'userfile' type = 'file'></td>";
echo  "</tr>";

echo "<Br>";
echo "</Table>";
echo "<Br>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)'>
		&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)'>";

echo "</form>";
}
//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=person&task=person_sch&index=3&id=$_GET[id]&page=$_REQUEST[page]&school_code=$_REQUEST[school_code]\"'>
		&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=person&task=person_sch&page=$_REQUEST[page]&school_code=$_REQUEST[school_code]\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from person_sch_main where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}

if($index==3.1){
	foreach ($_POST as $person_id =>$person_value){
$sql = "delete from person_sch_main where person_id='$person_id'";
$dbquery = mysqli_query($connect,$sql);
	}
}

//ส่วนเพิ่มข้อมูล
if($index==4){
$rec_date = date("Y-m-d");
$sql = "select * from person_sch_main where  person_id='$_POST[person_id]' ";
$dbquery = mysqli_query($connect,$sql);
if(mysqli_num_rows($dbquery)>=1){
echo "<br /><div align='center'>มีเลขประจำตัวประชาชนซ้ำกับรายการที่มีอยู่แล้ว ตรวจสอบอีกครั้ง</div>";
exit();  
}

$basename = basename($_FILES['userfile']['name']);
if ($basename!="")
{
$changed_name = file_upload();
}
if(!isset($changed_name)){
$changed_name="";
}
if(!isset($_POST['other'])){
$_POST['other']="";
}

$sql = "insert into person_sch_main (person_id,prename,name,surname,position_code,school_code,pic,status,person_order,officer,rec_date) values ( '$_POST[person_id]','$_POST[prename]','$_POST[name]','$_POST[surname]','$_POST[position_code]','$_POST[school]','$changed_name','0','$_POST[person_order]','$officer','$rec_date')";
$dbquery = mysqli_query($connect,$sql);
}
//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form Enctype = multipart/form-data id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไขข้อมูลครูและบุคลากร</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
$sql = "select * from  person_sch_main left join system_school on person_sch_main.school_code=system_school.school_code  where person_sch_main.id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
echo "<Table width='70%' Border='0'>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>เลขประจำตัวประชาชน&nbsp;</Td><Td><Input Type='Text' Name='person_id' Size='13' maxlenght='13' onkeydown='integerOnly()' value='$result[person_id]'></Td></Tr>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>คำนำหน้าชื่อ&nbsp;</Td><Td><Input Type='Text' Name='prename' Size='15' value='$result[prename]'></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>ชื่อ&nbsp;</Td><Td><Input Type='Text' Name='name'  Size='40' value='$result[name]'></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>นามสกุล&nbsp;</Td><Td><Input Type='Text' Name='surname'  Size='40' value='$result[surname]'></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>ตำแหน่ง&nbsp;</Td><Td>";
echo "<Select  name='position_code' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select * from  person_sch_position order by position_code";
$dbquery = mysqli_query($connect,$sql);
While ($person_result = mysqli_fetch_array($dbquery)){
	if($person_result['position_code']==$result['position_code']){
	echo  "<option  value ='$person_result[position_code]' selected>$person_result[position_name]</option>" ;
	}	
	else {
	echo  "<option  value ='$person_result[position_code]'>$person_result[position_name]</option>" ;
	}
}	
echo "</select>";
echo "</Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>สพท&nbsp;</Td><Td>";
echo "<Select  name='khet_code' id='khet_code' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
 
$sql = "select * from  system_khet order by khet_type,khet_code";
$dbquery = mysqli_query($connect,$sql);
While ($result_khet = mysqli_fetch_array($dbquery)){
		if($result_khet['khet_code']==$result['khet_code']){
		echo  "<option value='$result_khet[khet_code]' selected>$result_khet[khet_code] $result_khet[khet_name]</option>" ;
		}
		else{
		echo  "<option value='$result_khet[khet_code]'>$result_khet[khet_code] $result_khet[khet_name]</option>" ;
	}
}	
echo "</select>";
echo "</Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>สถานศึกษา&nbsp;</Td><Td>";
echo "<Select  name='school' id='school' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;

$sql = "select * from  system_school order by school_type,school_code";
$dbquery = mysqli_query($connect,$sql);
While ($school_result = mysqli_fetch_array($dbquery)){
		if($result['school_code']==$school_result['school_code']){
		echo  "<option  value ='$school_result[school_code]' selected>$school_result[school_code] $school_result[school_name]</option>" ;
		}
		else{
		echo  "<option  value ='$school_result[school_code]'>$school_result[school_code] $school_result[school_name]</option>" ;
		}
}	
echo "</select>";
echo "</Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ลำดับบุคคลในตำแหน่ง&nbsp;</Td><Td><Input Type='Text' Name='person_order'  Size='4' value='$result[person_order]'></Td></Tr>";

echo  "<tr align='left'>";
echo  "<Td ></Td><td align='right'>ไฟล์รูปภาพ&nbsp;</td>";
echo  "<td align='left'><input name = 'userfile' type = 'file'></td>";
echo  "</tr>";

echo "</Table>";
echo "<Br />";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "<Input Type=Hidden Name='page' Value='$_GET[page]'>";
echo "<Input Type=Hidden Name='school_code' Value='$_REQUEST[school_code]'>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)'>
		&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)'>";
echo "</form>";
}
//ส่วนปรับปรุงข้อมูล
if ($index==6){
$sql = "select * from person_sch_main where person_id='$_POST[person_id]' and id!='$_POST[id]' ";
$dbquery = mysqli_query($connect,$sql);
if(mysqli_num_rows($dbquery)>=1){
echo "<br /><div align='center'>มีเลขประจำตัวประชาชนซ้ำกับรายการที่มีอยู่แล้ว ตรวจสอบอีกครั้ง</div>";
exit();  
}

		$basename = basename($_FILES['userfile']['name']);
		if ($basename!=""){
		$changed_name = file_upload();
		$sql = "update person_sch_main set person_id='$_POST[person_id]', prename='$_POST[prename]', name='$_POST[name]', surname='$_POST[surname]', pic='$changed_name', position_code='$_POST[position_code]', school_code='$_POST[school]', person_order='$_POST[person_order]',officer='$officer' where id='$_POST[id]'";
		}
		else{
		$sql = "update person_sch_main set person_id='$_POST[person_id]', prename='$_POST[prename]', name='$_POST[name]', surname='$_POST[surname]', position_code='$_POST[position_code]', school_code='$_POST[school]', person_order='$_POST[person_order]',officer='$officer' where id='$_POST[id]'";
		}
$dbquery = mysqli_query($connect,$sql);
$index="";
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
echo "<table width='95%' align='center'><tr><Td align='left'></Td><td align='right'>";
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
echo "<tr><Td align='left'><INPUT TYPE='button' name='smb' value='เพิ่มข้อมูล' onclick='location.href=\"?option=person&task=person_sch&index=1\"'></Td><td align='right'>";
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
echo  "<table width='95%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='100'>ที่</Td><Td width='150'>เลขประจำตัวประชาชน</Td><Td width='150'>ชื่อ</Td><Td width='200'>ตำแหน่ง</Td><Td width='50'>ลำดับ</Td><Td width='250'>สถานศึกษา</Td><Td width='50'>รูปภาพ</Td><Td  width='60'>ลบ</Td><Td  width='60'>แก้ไข</Td></Tr>";
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

		echo "<Tr  bgcolor=$color align='center'><Td><input type='checkbox' name='$person_id' value='1'>$N</Td><Td align='left'>$person_id</Td><Td align='left'>$prename&nbsp;$name&nbsp;$surname</Td><Td align='left'>";
if(isset($position_ar[$position_code])){
echo $position_ar[$position_code];
}
echo "</Td>";
if($person_order!=0){		
echo "<Td align='center'>$person_order</Td>";
}
else{
echo "<Td align='center'></Td>";
}
echo "<Td align='left'>$result[school_name]</Td>";
if($result['pic']!=""){
echo "<Td align='center'><a href='modules/person/pic_show_2.php?&person_id=$person_id' target='_blank'><img src=images/admin/user.gif border='0' alt='รูปภาพ'></a></Td>";
}
else{
echo "<Td align='center'>&nbsp;</Td>";
}
echo "<Td><div align='center'><a href=?option=person&task=person_sch&index=2&id=$id&page=$page&school_code=$school_code><img src=images/drop.png border='0' alt='ลบ'></a></div></Td>
		<Td><a href=?option=person&task=person_sch&index=5&id=$id&page=$page&school_code=$school_code><img src=images/edit.png border='0' alt='แก้ไข'></a></div></Td>
	</Tr>";
$M++;
$N++;
	}
echo "<Tr bgcolor='#FFCCCC'><Td colspan='9'><input type='checkbox' name='allchk' id='allchk' onclick='CheckAll()'>เลือก/ไม่เลือกทั้งหมด &nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE='button' name='smb' value='ลบทั้งหมดที่เลือก' onclick='goto_delete_all()'></Td></Tr>";

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
