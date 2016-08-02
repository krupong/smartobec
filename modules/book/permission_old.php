<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

?>
<script type="text/javascript" src="jquery/jquery-1.5.1.js"></script> 
<script type="text/javascript">
$(function(){
	$("select#department").change(function(){
		var datalist2 = $.ajax({	// รับค่าจาก ajax เก็บไว้ที่ตัวแปร datalist2
			  url: "modules/book/return_ajax_sub_department.php", // ไฟล์สำหรับการกำหนดเงื่อนไข
			  data:"department="+$(this).val(), // ส่งตัวแปร GET ชื่อ department ให้มีค่าเท่ากับ ค่าของ department
			  async: false
		}).responseText;		
		$("select#sub_department").html(datalist2); // นำค่า datalist2 มาแสดงใน listbox ที่ 2 
		// ชื่อตัวแปร และ element ต่างๆ สามารถเปลี่ยนไปตามการกำหนด
	});
});

$(function(){
	$("select#sub_department").change(function(){
		var datalist2 = $.ajax({	
			  url: "modules/book/return_ajax_person.php", 
			  data:"sub_department="+$(this).val(),
			  async: false
		}).responseText;		
		$("select#person_id").html(datalist2); 
	});
});

</script>
<?php

//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>เจ้าหน้าสารบรรณ</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มเจ้าหน้าที่งานสารบรรณ</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<div align='center'><table width='60%'><tr><td>";
echo "<table class='table table-bordered' width='100%' style='background-color:rgba(255,255,255,0.9)'>";

echo "<Tr><Td align='right' >สำนัก&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select name='department' id='department' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select  * from system_department order by department";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
	echo  "<option value = $result[department]>$result[department_name]</option>" ;
	}
echo "</select>";
echo "</div></td></tr>";

echo "<Tr><Td align='right'>กลุ่ม&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='sub_department' id='sub_department' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo "</select>";
echo "</div></td></tr>";

echo "<Tr><Td align='right'>บุคลากร&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select name='person_id' id='person_id' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo "</select>";
echo "</div></td></tr>";

echo "<Tr><Td align='right'>เจ้าหน้าที่สารบรรณกลาง สพฐ.&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><input type='radio' name='ctr_saraban' value='0' checked> ไม่ใช่&nbsp;<input type='radio' name='ctr_saraban' value='1'> ใช่ </div></td></tr>";
echo "<Tr><Td align='right'>เจ้าหน้าที่สารบรรณสำนัก&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><input type='radio' name='department_saraban' value='0' checked> ไม่ใช่&nbsp;<input type='radio' name='department_saraban' value='1'> ใช่ </div></td></tr>";
echo "<Tr><Td align='right'>เจ้าหน้าที่สารบรรณกลุ่ม&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><input type='radio' name='subdepartment_saraban' value='0' checked> ไม่ใช่&nbsp;<input type='radio' name='subdepartment_saraban' value='1'> ใช่ </div></td></tr> ";

echo "<tr><td align='center' colspan='2'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)'>
	&nbsp;&nbsp;&nbsp;";
echo "<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)'></td></tr>";
echo "</Table>";
echo "</td></tr></table>";

echo "<br>";
echo "&nbsp;&nbsp;&nbsp;<center><b>หมายเหตุ</b>&nbsp;บุคลากรในสำนักงานให้สามารถเป็นเจ้าหน้าที่สารบรรณ สำนักได้เพียงสำนักเดียวเท่านั้น</center>";
}

//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=book&task=permission&index=3&id=$_GET[id]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=book&task=permission\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from book_permission where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
echo "<script>document.location.href='?option=book&task=permission'; </script>\n";
}

//ส่วนบันทึกข้อมูล
if($index==4){
$rec_date = date("Y-m-d");
		if($_POST['department_saraban']==1){
		$department_saraban=$_POST['department'];
		}
		else{
		$department_saraban="";
		}
		if($_POST['subdepartment_saraban']==1){
		$subdepartment_saraban=$_POST['sub_department'];
		}
		else{
		$subdepartment_saraban="";
		}
$sql = "insert into book_permission (person_id, p1, p2, p3, grp_status, officer,rec_date) values ('$_POST[person_id]', '$_POST[ctr_saraban]', '$department_saraban', '$subdepartment_saraban', '1', '$_SESSION[login_user_id]', '$rec_date')";
$dbquery = mysqli_query($connect,$sql);
echo "<script>document.location.href='?option=book&task=permission'; </script>\n";
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไข เจ้าหน้าที่งานสารบรรณ</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<div align='center'><table width='50%'><tr><td>";
echo "<table class='table table-bordered' width='100%' style='background-color:rgba(255,255,255,0.9)'>";

$sql = "select * from book_permission where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);

echo "<Tr><Td align='right' width='50%'>บุคลากร&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='person_id' id='person_id' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select  * from  person_main where person_id='$ref_result[person_id]' ";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
		$person_id = $result['person_id'];
		$prename = $result['prename'];
		$name = $result['name'];
		$surname = $result['surname'];
		echo  "<option value = $person_id selected>$prename$name $surname</option>";
echo "</select>";
echo "</div></td></tr>";

if($ref_result['p1']==1){
$ctr_saraban_check1="checked";
$ctr_saraban_check0="";
}
else{
$ctr_saraban_check0="checked";
$ctr_saraban_check1="";
}

if($ref_result['p2']!=""){
$department_saraban_check1="checked";
$department_saraban_check0="";
}
else{
$department_saraban_check0="checked";
$department_saraban_check1="";
}

if($ref_result['p3']!=""){
$subdepartment_saraban_check1="checked";
$subdepartment_saraban_check0="";
}
else{
$subdepartment_saraban_check0="checked";
$subdepartment_saraban_check1="";
}

echo "<Tr><Td align='right' width='50%'>เจ้าหน้าที่สารบรรณกลาง สพฐ.&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><input type='radio' name='ctr_saraban' value='0' $ctr_saraban_check0> ไม่ใช่&nbsp;<input type='radio' name='ctr_saraban' value='1' $ctr_saraban_check1> ใช่ ";

echo "<Tr><Td align='right'>เจ้าหน้าที่สารบรรณสำนัก&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><input type='radio' name='department_saraban' value='0' $department_saraban_check0> ไม่ใช่&nbsp;<input type='radio' name='department_saraban' value='1' $department_saraban_check1> ใช่ </div></td></tr>";
echo "<Tr><Td align='right'>เจ้าหน้าที่สารบรรณกลุ่ม&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><input type='radio' name='subdepartment_saraban' value='0' $subdepartment_saraban_check0> ไม่ใช่&nbsp;<input type='radio' name='subdepartment_saraban' value='1' $subdepartment_saraban_check1> ใช่ </div></td></tr> ";

echo "<tr><td align='center' colspan='2'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)' class=entrybutton>&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)'></td></tr>";
echo "</Table>";
echo "</td></tr></table>";

echo "<Br>";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "<Input Type=Hidden Name='department' Value='$result[department]'>";
echo "<Input Type=Hidden Name='sub_department' Value='$result[sub_department]'>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
$rec_date = date("Y-m-d");

		if($_POST['department_saraban']==1){
		$department_saraban=$_POST['department'];
		}
		else{
		$department_saraban="";
		}
		if($_POST['subdepartment_saraban']==1){
		$subdepartment_saraban=$_POST['sub_department'];
		}
		else{
		$subdepartment_saraban="";
		}

$sql = "update book_permission set p1='$_POST[ctr_saraban]', p2='$department_saraban', p3='$subdepartment_saraban', officer='$_SESSION[login_user_id]', rec_date='$rec_date' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
echo "<script>document.location.href='?option=book&task=permission'; </script>\n";
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){

// อาเรย์ชื่อหน่วยงาาน
$office_name_ar['saraban']="สาราบรรณกลาง";
$sql_work_group = mysqli_query($connect,"SELECT * FROM  system_department") ;
while ($row_work_group= mysqli_fetch_array($sql_work_group)){
$office_name_ar[$row_work_group['department']]=$row_work_group['department_precis'];
}
$sql_sub_department = mysqli_query($connect,"SELECT * FROM  system_subdepartment left join system_department on system_subdepartment.department=system_department.department ") ;
while ($row_sub_department= mysqli_fetch_array($sql_sub_department)){
$sub_department_ar[$row_sub_department['sub_department']]=$row_sub_department['sub_department_name'].'('.$row_sub_department['department_precis'].')';
}

$sql = "select book_permission.id, book_permission.p1, book_permission.p2, book_permission.p3, person_main.prename, person_main.name, person_main.surname from book_permission left join person_main on book_permission.person_id=person_main.person_id where person_main.status>='0' and book_permission.grp_status='1' order by person_main.department";
$dbquery = mysqli_query($connect,$sql);
$total = mysqli_num_rows($dbquery);
echo "<div align='center'><table width='85%'><tr><td>";
echo "<table class='table table-bordered' width='100%' style='background-color:rgba(255,255,255,0.9)'>";


echo "<Tr><Td colspan='7' align='left'><INPUT TYPE='button' name='smb' value='เพิ่มเจ้าหน้าที่' onclick='location.href=\"?option=book&task=permission&index=1\"'</Td></Tr>";

echo "<Tr bgcolor='#FFCCCC'><Td  align='center'>ที่</Td><Td  align='center'>ชื่อเจ้าหน้าที่</Td><td  align='center'>สารบรรณกลางสพฐ.</td></Td><td  align='center'>สารบรรณสำนัก</td><td  align='center'>สารบรรณกลุ่ม</td><Td align='center' width='50'>ลบ</Td><Td align='center' width='50'>แก้ไข</Td></Tr>";
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$prename = $result['prename'];
		$name = $result['name'];
		$surname = $result['surname'];
		$p2 = $result['p2'];
		$p3 = $result['p3'];
			if($result['p1']==1){
			$p1_pic="<img src=images/yes.png border='0'>";			}
			else{
			$p1_pic="";
			}
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
		echo "<Tr bgcolor=$color><Td align='center' width='50'>$M</Td><Td  align='left' width='200'>$prename$name $surname</Td><Td align='center' width='100'>$p1_pic</Td><td>";
		if(isset($office_name_ar[$p2])){
		echo $office_name_ar[$p2];
		}
		echo "</td><td>";
		if(isset($sub_department_ar[$p3])){
		echo $sub_department_ar[$p3];
		}
echo "</td><Td align='center' width='50' ><a href=?option=book&task=permission&index=2&id=$id><img src=images/drop.png border='0' alt='ลบ'></a></Td>
		<Td align='center' width='50'><a href=?option=book&task=permission&index=5&id=$id><img src=images/edit.png border='0' alt='แก้ไข'></a></Td>
	</Tr>";
$M++;
	}
echo "</Table>";
echo "</td></tr></table>";

}

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=book&task=permission");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
		}else{
			callfrm("?option=book&task=permission&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=book&task=permission");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
		}else{
			callfrm("?option=book&task=permission&index=6");   //page ประมวลผล
		}
	}
}
</script>
