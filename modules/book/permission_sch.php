<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>เจ้าหน้าที่สารบรรณโรงเรียน</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>กำหนดเจ้าหน้าที่สารบรรณโรงเรียน</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border='0' Bgcolor='#E5E5FF'>";
echo "<Tr><Td align='right'  width='50%'>บุคลากร&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='person_id'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select  * from person_sch_main  where status='0'  and school_code='$_SESSION[user_school]' order by position_code,name";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$person_id = $result['person_id'];
		$name = $result['name'];
		$surname = $result['surname'];
		echo  "<option value = $person_id>$name $surname</option>" ;
	}
$sql = "select * from  person_sch_other left join person_sch_main on person_sch_other.person_id=person_sch_main.person_id where person_sch_main.status='0' and person_sch_other.school_code='$_SESSION[user_school]' order by position_code,name";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$person_id = $result['person_id'];
		$name = $result['name'];
		$surname = $result['surname'];
		echo  "<option value = $person_id>$name $surname</option>" ;
	}
	
echo "</select>";
echo "</div></td></tr>";

echo "<tr><td></td><td></td></tr>";
echo "<tr><td align='right'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)' >
	&nbsp;&nbsp;</td>";
echo "<td align='left'><INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)' ></td></tr>";
echo "</Table>";
echo "</form>";
}

//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=book&task=permission_sch&index=3&id=$_GET[id]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=book&task=permission_sch\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from book_permission where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
echo "<script>document.location.href='?option=book&task=permission_sch'; </script>\n";
}

//ส่วนบันทึกข้อมูล
if($index==4){
$rec_date = date("Y-m-d");
$sql = "insert into book_permission (person_id, p3, officer,rec_date) values ('$_POST[person_id]', $_SESSION[user_school], '$_SESSION[login_user_id]','$rec_date')";
$dbquery = mysqli_query($connect,$sql);
echo "<script>document.location.href='?option=book&task=permission_sch'; </script>\n";
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไข เจ้าหน้าที่</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border= '0' Bgcolor='#Fcf9d8'>";
$sql = "select * from book_permission where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);
echo "<Tr><Td align='right' width='50%'>บุคลากร&nbsp;&nbsp;</Td>";
echo "<td><div align='left' ><Select  name='person_id'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select  * from person_sch_main  where status='0'  and school_code='$_SESSION[user_school]' order by position_code,name";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$person_id = $result['person_id'];
		$name = $result['name'];
		$surname = $result['surname'];
		if($person_id==$ref_result['person_id']){
		echo  "<option value = $person_id selected>$name $surname</option>";
		}
		else{
		echo  "<option value = $person_id>$name $surname</option>";
		}
	}
$sql = "select * from  person_sch_other left join person_sch_main on person_sch_other.person_id=person_sch_main.person_id where person_sch_main.status='0' and person_sch_other.status='0' and person_sch_other.school_code='$_SESSION[user_school]' order by position_code,name";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$person_id = $result['person_id'];
		$name = $result['name'];
		$surname = $result['surname'];
		if($person_id==$ref_result['person_id']){
		echo  "<option value = $person_id selected>$name $surname</option>";
		}
		else{
		echo  "<option value = $person_id>$name $surname</option>";
		}
	}
echo "</select>";
echo "</div></td></tr>";

echo "<tr><td></td><td></td></tr>";
echo "<tr><td align='right'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)' class=entrybutton>&nbsp;&nbsp;</td>";
echo "<td align='left'><INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)' class=entrybutton'></td></tr>";
echo "</Table>";
echo "<Br>";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
$rec_date = date("Y-m-d");
$sql = "update book_permission set  person_id='$_POST[person_id]', officer='$_SESSION[login_user_id]', rec_date='$rec_date' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
echo "<script>document.location.href='?option=book&task=permission_sch'; </script>\n";
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){

$sql = "select book_permission.id, book_permission.p3, book_permission.officer, person_sch_main.name, person_sch_main.surname from book_permission left join person_sch_main on book_permission.person_id=person_sch_main.person_id  where  book_permission.p3='$_SESSION[user_school]' and p3!='' order by book_permission.id";
$dbquery = mysqli_query($connect,$sql);
echo  "<table width=50% border=0 align=center>";
echo "<Tr><Td colspan='5' align='left'><INPUT TYPE='button' name='smb' value='กำหนดเจ้าหน้าที่' onclick='location.href=\"?option=book&task=permission_sch&index=1\"'</Td></Tr>";

echo "<Tr bgcolor='#99ccff'><Td  align='center' >ที่</Td><Td  align='center' width='40%'>ชื่อเจ้าหน้าที่</Td><Td  align='center'>ผู้กำหนดเจ้าหน้าที่</Td><Td align='center'  width='50'>ลบ</Td><Td align='center' width='50'>แก้ไข</Td></Tr>";
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$p3 = $result['p3'];
		$name = $result['name'];
		$surname = $result['surname'];
		$rec_person = $result['officer'];
		
					///////////////////
					$person_level=0;
					$sql_person = "select  * from person_main  where person_id='$rec_person'";
					$dbquery_person = mysqli_query($connect,$sql_person);
					if($result_person = mysqli_fetch_array($dbquery_person)){
					$person_level=1;  //สพท.
					}
					else{
					$sql_person = "select  * from person_sch_main  where person_id='$rec_person'";
					$dbquery_person = mysqli_query($connect,$sql_person);		
					$result_person = mysqli_fetch_array($dbquery_person);		
					$person_level=2;   //โรงเรียน
					}
					////////////////////

			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
		echo "<Tr bgcolor=$color><Td align='center' width='50'>$M</Td><Td  align='left'>$name $surname</Td>";
		if ($person_level==1){
		echo "<td>เจ้าหน้าที่ สพท.</td>";
		}
		else {
		echo "<td>$result_person[prename]$result_person[name] $result_person[surname]</td>";
		}
		echo "<Td align='center'><a href=?option=book&task=permission_sch&index=2&id=$id><img src=images/drop.png border='0' alt='ลบ'></a></Td>";
		if ($person_level==1){
		echo "<Td ></Td>";
		}
		else {
		echo "<Td align='center'><a href=?option=book&task=permission_sch&index=5&id=$id><img src=images/edit.png border='0' alt='แก้ไข'></a></Td>";
		}
	echo "</Tr>";
$M++;
	}
echo "</Table>";
}

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=book&task=permission_sch");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
		}else{
			callfrm("?option=book&task=permission_sch&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=book&task=permission_sch");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
		}else{
			callfrm("?option=book&task=permission_sch&index=6");   //page ประมวลผล
		}
	}
}
</script>
