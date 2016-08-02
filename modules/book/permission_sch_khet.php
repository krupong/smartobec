<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

?>
<script type="text/javascript" src="jquery/jquery-1.5.1.js"></script> 
<script type="text/javascript">

$(function(){
	$("select#khet_code").change(function(){
		var datalist2 = $.ajax({	// รับค่าจาก ajax เก็บไว้ที่ตัวแปร datalist2
			  url: "modules/book/return_permission_sch_khet.php", // ไฟล์สำหรับการกำหนดเงื่อนไข
			  data:"khet_code="+$(this).val(), // ส่งตัวแปร GET ชื่อ khet_code ให้มีค่าเท่ากับ ค่าของ khet_code
			  async: false
		}).responseText;		
		$("select#person_id").html(datalist2); // นำค่า datalist2 มาแสดงใน listbox ที่ 2 ที่ชื่อ person_id
		// ชื่อตัวแปร และ element ต่างๆ สามารถเปลี่ยนไปตามการกำหนด
	});
});
</script>

<?php

//อาเรย์ชื่อเขต
$sql = "select  * from  system_khet ";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$khet_code = $result['khet_code'];
		$khet_ar[$khet_code]= $result['khet_precis'];
	}

//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>สารบรรณ  สพท.</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มเจ้าหน้าที่งานสารบรรณ  สพท.</Font>";
echo "</Cener>";
echo "<Br><Br>";
//echo "<Table width='80%' Border='0'>";
echo "<div align='center'><table width='50%'><tr><td>";
echo "<table class='table table-bordered' width='100%' style='background-color:rgba(255,255,255,0.9)'>";

echo "<Tr align='left'><Td align='right'>  สพท.&nbsp;</Td><Td>";
echo "<Select  name='khet_code'  id='khet_code' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;

$sql = "select * from  system_khet  order by khet_type,khet_code";
$dbquery = mysqli_query($connect,$sql);
While ($khet_result = mysqli_fetch_array($dbquery)){
echo  "<option  value ='$khet_result[khet_code]'>$khet_result[khet_code] $khet_result[khet_precis]</option>" ;
}	
echo "</select>";
echo "</Td></Tr>";

echo "<Tr align='left'><Td align='right'>บุคลากร&nbsp;&nbsp;</Td><td align='left'>";
echo "<Select  name='person_id'  id='person_id' size='1' >";
echo  "<option  value = ''>เลือก  สพท.ก่อน</option>" ;
echo "</select>";
echo "</td></tr>";

//echo "<tr><td></td><td></td></tr>";
echo "<tr><td align='center' colspan='2'><INPUT TYPE='button' class='btn btn-primary' name='smb' value='ตกลง' onclick='goto_url(1)' class=entrybutton>
	&nbsp;&nbsp;";
echo "<INPUT TYPE='button' class='btn btn-danger' name='back' value='ย้อนกลับ' onclick='goto_url(0)' class=entrybutton'></td></tr>";
echo "</Table>";
echo "</td></tr></table>";

echo "</form>";
}

//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=book&task=permission_sch_khet&index=3&id=$_GET[id]&page=$_REQUEST[page]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=book&task=permission_sch_khet&page=$_REQUEST[page]\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from book_permission where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนบันทึกข้อมูล
if($index==4){
$rec_date = date("Y-m-d");
$sql = "insert into book_permission (person_id, p4, grp_status, officer,rec_date) values ('$_POST[person_id]', '$_POST[khet_code]', '2', '$_SESSION[login_user_id]','$rec_date')";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไข เจ้าหน้าที่</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<div align='center'><table width='50%'><tr><td>";
echo "<table class='table table-bordered' width='100%' style='background-color:rgba(255,255,255,0.9)'>";


$sql = "select * from book_permission where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);
echo "<Tr align='left'><Td align='right'>  สพท.&nbsp;</Td><Td>";
echo "<Select  name='khet_code'  id='khet_code' size='1'>";
echo  "<option  value = ''>- - - - เลือก - - - -</option>" ;
$sql = "select * from  system_khet  order by khet_type,khet_code";
$dbquery = mysqli_query($connect,$sql);
While ($khet_result = mysqli_fetch_array($dbquery)){
			if($khet_result['khet_code']==$ref_result['p4']){
			echo  "<option  value ='$khet_result[khet_code]' selected>$khet_result[khet_code] $khet_result[khet_precis]</option>" ;
			}
			else{
			echo  "<option  value ='$khet_result[khet_code]'>$khet_result[khet_code] $khet_result[khet_precis]</option>" ;
			}
}	
echo "</select>";
echo "</Td></Tr>";
echo "<Tr><Td align='right'>บุคลากร&nbsp;&nbsp;</Td>";
echo "<td align='left'><Select  name='person_id'  id='person_id'  size='1'>";
echo  "<option  value = ''>- - - - เลือก - - - -</option>" ;
$khet_id=$khet_result[khet_code];
$sql = "select  * from person_khet_main where status='0'  and khet_code='$ref_result[p4]' order by position_code,name";
$dbquery = mysqli_query($connect,$sql);
while($result = mysqli_fetch_array($dbquery)){
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
$sql = "select * from  person_sch_other left join person_sch_main on person_sch_other.person_id=person_sch_main.person_id where person_sch_main.status='0' and person_sch_other.status='0' and person_sch_other.khet_code='$ref_result[p4]' order by position_code,name";
$query = mysqli_query($connect,$sql);
while($result = mysqli_fetch_array($query)){
	$person_id = $result['person_id'];
	$prename = $result['prename'];
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
echo "</td></tr>";

echo "<tr><td align='center' colspan='2'><INPUT TYPE='button' class='btn btn-primary' name='smb' value='ตกลง' onclick='goto_url_update(1)' class=entrybutton>&nbsp;&nbsp;";
echo "<INPUT TYPE='button' class='btn btn-danger' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)' class=entrybutton'></td></tr>";
echo "</Table>";
echo "</td></tr></table>";

echo "<Br>";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "<Input Type=Hidden Name='page' Value='$_GET[page]'>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
$rec_date = date("Y-m-d");
$sql = "update book_permission set  person_id='$_POST[person_id]', p4='$_POST[khet_code]',  officer='$_SESSION[login_user_id]', rec_date='$rec_date' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){


$sql = "select book_permission.id,  book_permission.officer, person_khet_main.prename, person_khet_main.name, person_khet_main.surname, book_permission.p4 from book_permission left join person_khet_main on book_permission.person_id=person_khet_main.person_id  where book_permission.p4!='' order by book_permission.id ";
$dbquery = mysqli_query($connect,$sql);
echo "<div align='center'><table width='90%'><tr><td>";

echo "<div class='row'>
                <div class='col-md-12'>";
echo "<div class='panel panel-default'>
                        <div class='panel-heading'>";
echo "<b>กำหนดเจ้าหน้าที่สารบรรณ สพท.</b>
                        </div>";
echo "<br><div class='col-md-12' align='left'><p><INPUT TYPE='button' class='btn btn-primary' name='smb' value='เพิ่มเจ้าหน้าที่' onclick='location.href=\"?option=book&task=permission_sch_khet&index=1\"'></p></div>";
echo "<div class='panel-body'>";
echo "<table class='table table-striped table-bordered table-hover' id='dataTables-example'>";




//echo "<table class='table table-bordered' width='100%' style='background-color:rgba(255,255,255,0.9)'>";
//echo "<Tr><Td colspan='6' align='left'><INPUT TYPE='button' class='btn btn-primary' name='smb' value='เพิ่มเจ้าหน้าที่' onclick='location.href=\"?option=book&task=permission_sch_khet&index=1\"'</Td></Tr>";

echo "<thead><Tr><Td  align='center'>ที่</Td><Td  align='center'>สพท.</Td><Td  align='center'>ชื่อเจ้าหน้าที่</Td><Td align='center'>ผู้กำหนดเจ้าหน้าที่</Td><Td align='center' >ลบ</Td><Td align='center'  >แก้ไข</Td></Tr></thead><tbody>";
$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$p4 = $result['p4'];
		$prename = $result['prename'];
		$name = $result['name'];
		$surname = $result['surname'];
		$rec_person = $result['officer'];
					///////////////////
					$person_level=0;
					$sql_person = "select  * from person_main  where person_id='$rec_person'";
					$dbquery_person = mysqli_query($connect,$sql_person);
					if($result_person = mysqli_fetch_array($dbquery_person)){
					$person_level=1;  //สพฐ.
					}
					else{
					$sql_person = "select  * from person_khet_main  where person_id='$rec_person'";
					$dbquery_person = mysqli_query($connect,$sql_person);		
					$result_person = mysqli_fetch_array($dbquery_person);		
					$person_level=2;   //สพท.
					}
					////////////////////
		
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
		echo "<tr class='odd gradeX'><Td align='center' width='50'>$N</Td><Td  align='left'> $khet_ar[$p4]</Td><Td  align='left'>$prename$name $surname</Td><td>$result_person[prename]$result_person[name] $result_person[surname]</td>";
		if($person_level==1){
		echo "<Td align='center' width='50' ><a href=?option=book&task=permission_sch_khet&index=2&id=$id&page=$page><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a></Td>
		<Td align='center' width='50'><a href=?option=book&task=permission_sch_khet&index=5&id=$id&page=$page><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a></Td>";
		}
		else{
		echo "<td></td><td></td>";
		}
		echo "</Tr>";
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}
echo "</tbody></Table>";
echo "</td></tr></table>";

}

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=book&task=permission_sch_khet");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.khet_code.value == ""){
			alert("กรุณาเลือก  สพท.");
		}else if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
		}else{
			callfrm("?option=book&task=permission_sch_khet&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=book&task=permission_sch_khet");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.khet_code.value == ""){
			alert("กรุณาเลือก  สพท.");
		}else if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
		}else{
			callfrm("?option=book&task=permission_sch_khet&index=6");   //page ประมวลผล
		}
	}
}
</script>
