<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

echo "<form id='frm1' name='frm1'>";
echo "<br/>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>กลุ่มสถานศึกษา และสมาชิกกลุ่ม (Read only)</Font>";
echo "</Cener>";
echo "<br><br>";
echo "<div align='center'><table width='50%'><tr><td>";
echo "<table class='table table-bordered' width='100%' style='background-color:rgba(255,255,255,0.9)'>";

//echo "<TABLE width='100%'  boder='0' Bgcolor='#Fcf9d8'>";
echo "<Tr align='center'><Td align='center' >กลุ่มสถานศึกษา&nbsp;&nbsp;<select name='grp_id' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql= "select * from book_group order by grp_id desc";
	$dbquery=mysqli_query($connect,$sql);
	While ($result = mysql_fetch_array($dbquery)){
	
	if($_POST['grp_id']==$result['grp_id'])
		$select="selected";
		else
		$select="";
		
	echo "<option value=$result[grp_id] $select>$result[grp_name]</option>";
	}
	echo "</select>" ;
echo "&nbsp;&nbsp;<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)' class=entrybutton></Td></Tr>";
echo "</TABLE>";
echo "</td></tr></table>";



if($index==1){
echo "<br/>";	
echo "<div align='center'><table width='50%'><tr><td>";
echo "<table class='table table-bordered' width='100%' style='background-color:rgba(255,255,255,0.9)'>";

//echo "<table width='55%' CELLSPACING=1 CELLPADDING=2>";
	echo "<tr bgcolor='#000000' height='30'>";
	echo "<td align='center' width='10%'><b><font color='#FFFFFF'>ที่</td>";
	echo "<td align='center' width='25%'><b><font color='#FFFFFF'>รหัสสถานศึกษา</td>";
	echo "<td align='center'><b><font color='#FFFFFF'>ชื่อสถานศึกษา</td>";
	echo "</tr>";
$sql = "select * from book_group_member left join system_school on book_group_member.school_id=system_school.school_code where book_group_member.grp_id='$_POST[grp_id]' order by system_school.school_type,system_school.school_code";

	$dbquery = mysqli_query($connect,$sql);
	$n=1;
	While ($result = mysql_fetch_array($dbquery)){
	$school_code= $result['school_code'];
	$school_name = $result['school_name'];
					if(($n%2)==0){
						$bgcolor="#e8e8e8";
					}else{
						$bgcolor="#F5F5F5";
					}
		echo "<tr bgcolor=$bgcolor>";
		echo "<td align=center>$n</td>";
		echo "<td align='center'>$school_code</td>";
		echo "<td align='left'>$school_name</td>";
		echo "</tr>";
	$n++;	
	}	
echo "</table>";
echo "</td></tr></table>";

}  //End index1
echo "</form>";
?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=book&task=main/group_member_report");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.grp_id.value == ""){
			alert("กรุณาเลือกกลุ่มบุคลากร");
		}else{
			callfrm("?option=book&task=main/group_member_report&index=1");   //page ประมวลผล
		}
	}
}

</script>
