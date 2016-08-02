<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//sd page 

//นำเข้าข้อมูลบุคลากร
require_once("person_chk.php");	

//เรียกชื่อสำนักงานเขต
	$sql_k = "select * from system_khet where khet_code = '$khet_code'";		 //รหัสเขต
	$dbquery_k = mysqli_query($connect,$sql_k);
	$result_k = mysqli_fetch_array($dbquery_k);
	$khet_name = $result_k['khet_name'];

//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>เลขที่หนังสือของหน่วยงาน ($khet_name)</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($index==5){
$sql= "select * from bookregister_office_no_area where khet_code='$khet_code' ";
$query= mysqli_query($connect,$sql);
$result= mysqli_fetch_array($query);

echo "<center><font color='#006666' size='3'><strong>เลขที่หนังสือของหน่วยงาน ($khet_name)</strong></font></center>";
echo "<form id='frm1' name='frm1'>";
echo "<Br><Br>";
echo "<div align='center'><table width='50%'><tr><td>";
echo "<table class='table table-bordered' width='100%' style='background-color:rgba(255,255,255,0.9)'>";

//echo "<Table width='40%' Border='0' align='center'>";
echo "<Tr><Td align='right'>เลขที่หนังสือของหน่วยงาน&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='office_no' Size='20' maxlength='70' value='$result[office_no]'>    ตัวอย่าง เช่น  <b>ที่ ศธ 04710/</b></Td></Tr>";
//echo "ตัวอย่าง เช่น  ที่ ศธ 04710/";
echo "<Input Type=Hidden Name='khet_code' Value='$_GET[khet_code]'>";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
//echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
//echo "<tr><td>&nbsp;</td>";
echo "<td align='center' colspan='2'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)'>&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)'></td></tr>";
echo "</Table>";
echo "</td></tr></table>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
$sql = "update bookregister_office_no_area set office_no='$_POST[office_no]' where id= '$_POST[id]' ";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนแสดงผล
if(!($index==5)){
$rec_date=date("Y-m-d");
$sql="select * from bookregister_office_no_area where khet_code = '$khet_code' ";    //รหัสเขต
//$sql= "select * from bookregister_office_no_area where school_code is null";
//$sql= "select * from bookregister_office_no_area where department='1' ";  //รหัสสำนัก
$query= mysqli_query($connect,$sql);
$result= mysqli_fetch_array($query);
//	if(!($result)){
//	mysqli_query($connect,"insert into bookregister_office_no_area (office_no, officer, rec_date) values ('ที่ ศธ xxx/','$_SESSION[login_user_id]', '$rec_date')");
	
//	$sql= "select * from bookregister_office_no_area where school_code is null";
//	$query= mysqli_query($connect,$sql);
//	$result= mysqli_fetch_array($query);
//	}

echo "<br />";
//echo "<center>$department_name</center>";
echo "<div align='center'><table width='30%'><tr><td>";
echo "<table class='table table-bordered' width='100%' style='background-color:rgba(255,255,255,0.9)'>";

//echo  "<table width='30%' border='0' align='center'>";
//echo "<Tr bgcolor='#FFFFFF'><Td align='left'>$department_name</Td></Tr>";
echo "<Tr bgcolor='#FFCCCC'><Td align='center'>เลขที่หนังสือ</Td><Td align='center' width='70'>แก้ไข</Td></Tr>";
echo "<Tr><Td align='center'>$result[office_no]</Td>
		<Td align='center'><a href=?option=book&task=main/office_no&index=5&id=$result[id]><img src=images/edit.png border='0' alt='แก้ไข'></a></Td>
	</Tr>";
echo "</Table>";
echo "</td></tr></table>";
}

	?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=book&task=main/office_no");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.office_no.value == ""){
			alert("กรุณากรอกเลขที่หนังสือของหน่วยงาน");
		}else{
			callfrm("?option=book&task=main/office_no&index=6");   //page ประมวลผล
		}
	}
}

</script>
