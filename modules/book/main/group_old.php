<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>กลุ่มผู้รับ</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มกลุ่มผู้รับ</Font>";
echo "</Cener>";
echo "<Br><Br>";
//echo "<Table width='40%' Border='0' Bgcolor='#Fcf9d8'>";
echo "<div align='center'><table width='30%'><tr><td>";
echo "<table class='table table-bordered' width='100%' style='background-color:rgba(255,255,255,0.9)'>";

echo   "<tr><td align='right'>ชื่อกลุ่มผู้รับ&nbsp;&nbsp;</td>";
echo   "<td align='left'><INPUT TYPE='text' class='form-control' NAME='grp_name'></td></tr>";
//echo "<tr><td align='right'></td>";
echo "<td align='center' colspan='2'><INPUT TYPE='button' name='smb' class='btn btn-primary' value='ตกลง' onclick='goto_url(1)' class=entrybutton>
	&nbsp;&nbsp;<INPUT TYPE='button' name='back' class='btn btn-danger' value='ย้อนกลับ' onclick='goto_url(0)' class=entrybutton'></td></tr>";
echo "</Table>";
echo "</td></tr></table>";

echo "</form>";
}

//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=book&task=main/group&index=3&id=$_GET[id]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=book&task=main/group\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from book_group where grp_id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนบันทึกข้อมูล
if($index==4){
$sql = "insert into book_group (grp_name) values ('$_POST[grp_name]')";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไข กลุ่มผู้รับบุคลากร</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
//echo "<Table width='40%' Border= '0' Bgcolor='#Fcf9d8'>";
echo "<div align='center'><table width='40%'><tr><td>";
echo "<table class='table table-bordered' width='100%' style='background-color:rgba(255,255,255,0.9)'>";

$sql = "select * from book_group where grp_id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);
echo   "<tr><td align='right'>ชื่อกลุ่มผู้รับ&nbsp;&nbsp;</td>";
echo   "<td align='left'><INPUT TYPE='text' class='form-control' NAME='grp_name' value='$ref_result[grp_name]' size='30'></td></tr>";

//echo "<tr><td align='right'></td>";
echo "<td align='center' colspan='2'><INPUT TYPE='button' name='smb' class='btn btn-primary' value='ตกลง' onclick='goto_url_update(1)' class=entrybutton>&nbsp;&nbsp;&nbsp;<INPUT TYPE='button' class='btn btn-danger' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)' class=entrybutton'></td></tr>";
echo "</Table>";
echo "</td></tr></table>";

echo "<Br>";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
$rec_date = date("Y-m-d");
$sql = "update book_group set  grp_name='$_POST[grp_name]' where grp_id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
echo "<script>document.location.href='?option=book&task=main/group'; </script>\n";
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){

$sql = "select * from book_group";
$dbquery = mysqli_query($connect,$sql);
//echo  "<table width='50%' border='0' align='center'>";
echo "<div align='center'><table width='50%'><tr><td>";
echo "<table class='table table-bordered' width='100%' style='background-color:rgba(255,255,255,0.9)'>";

echo "<Tr><Td colspan='4' align='left'><INPUT TYPE='button' class='btn btn-primary' name='smb' value='เพิ่มกลุ่มผู้รับ' onclick='location.href=\"?option=book&task=main/group&index=1\"'</Td></Tr>";

echo "<Tr bgcolor='#FFCCCC'><Td  align='center'>ที่</Td><Td  align='center'>ชื่อกลุ่มผู้รับ</Td><Td align='center' width='50'>ลบ</Td><Td align='center' width='50'>แก้ไข</Td></Tr>";
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['grp_id'];
		$grp_name = $result['grp_name'];
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
		
		echo "<Tr bgcolor=$color><Td align='center' width='50'>$M</Td><Td  align='left'>$grp_name</Td>
		<Td align='center' width='50' ><a href=?option=book&task=main/group&index=2&id=$id><img src=images/drop.png border='0' alt='ลบ'></a></Td>
		<Td align='center' width='50'><a href=?option=book&task=main/group&index=5&id=$id><img src=images/edit.png border='0' alt='แก้ไข'></a></Td>
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
		callfrm("?option=book&task=main/group");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.grp_name.value == ""){
			alert("กรุณาพิมพ์ชื่อกลุ่มผู้รับบุคลากร");
		}else{
			callfrm("?option=book&task=main/group&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=book&task=main/group");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.grp_name.value == ""){
			alert("กรุณาพิมพ์ชื่อกลุ่มผู้รับบุคลากร");
		}else{
			callfrm("?option=book&task=main/group&index=6");   //page ประมวลผล
		}
	}
}
</script>
