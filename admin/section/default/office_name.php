<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//sd page 

//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>ชื่อหน่วยงาน</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($index==5){

echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size='3'>ชื่อหน่วยงาน</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border='0'>";
$sql = "select  * from system_office_name";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
echo "<Tr><Td align='right'><b>ชื่อหน่วยงาน</b>&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='office_name' Size='50' maxlength='70' value='$result[office_name]'></Td></Tr>";
echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td>&nbsp;</td>";
echo "<td align='left'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)'>&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)'></td></tr>";
echo "</Table>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
$sql = "update system_office_name set office_name='$_POST[office_name]'";
$dbquery = mysqli_query($connect,$sql);
		
		$sql_office_name = "select * from system_office_name";
		$dbquery_office_name = mysqli_query($connect,$sql_office_name);
		$result_office_name = mysqli_fetch_array($dbquery_office_name);
		$_SESSION['office_name'] =$result_office_name['office_name'];		
		echo "<script>document.location.href='index.php?file=office_name';</script>\n";

}

//ส่วนแสดงผล
if(!($index==5)){
echo "<br />";
echo  "<table width='50%' cellpadding='0' cellspacing='0' border='1' align='center'>";
$sql = "select  * from system_office_name";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);

echo "<Tr bgcolor='#FFCCCC'><Td align='center'>ชื่อหน่วยงาน</Td><Td align='center' width='50'>แก้ไข</Td></Tr>";
echo "<Tr><Td align='center'>$result[office_name]</Td>
		<Td align='center'><a href=?file=office_name&index=5><img src=../images/edit.png border='0' alt='แก้ไข'></a></Td>
	</Tr>";
echo "</Table>";
}

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?file=office_name");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.office_name.value == ""){
			alert("กรุณากรอกชื่อหน่วยงาน");
		}else{
			callfrm("?file=office_name&index=6");   //page ประมวลผล
		}
	}
}
</script>
