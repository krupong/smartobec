<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

echo "<form id='frm1' name='frm1'>";
echo "<br/>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่ม แก้ไข สมาชิกกลุ่มสถานศึกษา</Font>";
echo "</Cener>";
echo "<br><br>";
echo "<TABLE width='100%'  boder='0' Bgcolor='#Fcf9d8'>";
echo "<div align='center'><table width='50%'><tr><td>";
echo "<table class='table table-bordered' width='100%' style='background-color:rgba(255,255,255,0.9)'>";

echo "<Tr align='center'><Td align='center' >กลุ่มสถานศึกษา&nbsp;&nbsp;<select name='grp_id' class='form-control' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql= "select * from book_group order by grp_id desc";
	$dbquery=mysqli_query($connect,$sql);
	While ($result = mysqli_fetch_array($dbquery)){
	
	if($_POST['grp_id']==$result['grp_id'])
		$select="selected";
		else
		$select="";
		
	echo "<option value=$result[grp_id] $select>$result[grp_name]</option>";
	}
	echo "</select>" ;
	echo "<br>";
echo "&nbsp;&nbsp;<INPUT TYPE='button' class='btn btn-primary' name='smb' value='ตกลง' onclick='goto_url(1)' class=entrybutton></Td></Tr>";
echo "</TABLE>";
echo "</td></tr></table>";


if($index==2){
	
	$sql= "select * from  system_school ";
	$dbquery = mysqli_query($connect,$sql);
	While ($result = mysqli_fetch_array($dbquery)){
	$school_code=$result['school_code'];
	$member_num=0;
		$sql2= "select * from book_group_member where (grp_id = '$_POST[grp_id]') and (school_id = '$school_code')"; 
		$dbquery2=mysqli_query($connect,$sql2);
		$member_num = mysqli_num_rows($dbquery2);
		
		if(!isset($_POST[$school_code])){
		$_POST[$school_code]="";
		}
		
		if($member_num<1){
					if($_POST[$school_code]==1){
					$sql3="insert into book_group_member(grp_id, school_id) values('$_POST[grp_id]','$school_code')";	
					mysqli_query($connect,$sql3);
					}
		}
		if($member_num>=1){
					if($_POST[$school_code]!=1){
					$sql4="delete from book_group_member where (grp_id='$_POST[grp_id]') and (school_id = '$school_code')"; 
					mysqli_query($connect,$sql4);
					}	
		}
	} //loop while
} //loopindex2

if($index==1 or $index==2){

	$sql= "select * from book_group_member where grp_id = '$_POST[grp_id]'";
	$dbquery=mysqli_query($connect,$sql);
	$i=1;
	While ($result = mysqli_fetch_array($dbquery)){
	$sch_id=$result['school_id'];
	$sch_in_grp[$i]=$sch_id;
	$i++;
	}
echo "<br/>";	
echo "<div align='center'><table width='50%'><tr><td>";
echo "<table class='table table-bordered' width='100%' style='background-color:rgba(255,255,255,0.9)'>";

//echo "<table width='65%' CELLSPACING=1 CELLPADDING=2>";
	echo "<tr bgcolor='#000000' height='30'>";
	echo "<td align='center' width='5%'><b><font color='#FFFFFF'>ที่</td>";
	echo "<td align='center' width='20%'><b><font color='#FFFFFF'>รหัสสถานศึกษา</td>";
	echo "<td align='center'><b><font color='#FFFFFF'>ชื่อสถานศึกษา</td>";
	echo "<td align='center'><b><font color=#FFFFFF>เลือก</td>";
	echo "</tr>";
$sql = "select * from system_school order by school_type,school_code";

	$dbquery = mysqli_query($connect,$sql);
	$n=1;
	While ($result = mysqli_fetch_array($dbquery)){
	$school_code= $result['school_code'];
	$school_name = $result['school_name'];
					if(($n%2)==0){
							if($index==2){
							$bgcolor="#FFFFB";
							}
							else{
							$bgcolor="#e8e8e8";
							}
					}else{
					$bgcolor="#F5F5F5";
					}
		echo "<tr bgcolor=$bgcolor>";
		echo "<td align=center>$n</td>";
		echo "<td align='center'>$school_code</td>";
		echo "<td align='left'>$school_name</td>";
		$check="";
		for($x=1;$x<$i;$x++){
			if($school_code==$sch_in_grp[$x]){
			$check="checked";
			break;
			}
		}
		echo "<td><INPUT TYPE='checkbox' NAME='$school_code' $check value='1' ></td>";
		echo "</tr>";
	$n++;	
	}	
echo "</table>";
echo "</td></tr></table>";

echo "<br/>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(2)'>";
echo "<br/>";
echo "<br/>";
}  //End index1
echo "<br/>";
echo "<br/>";
echo "</form>";
?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=book&task=main/group_member");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.grp_id.value == ""){
			alert("กรุณาเลือกกลุ่มสถานศึกษา");
		}else{
			callfrm("?option=book&task=main/group_member&index=1");   //page ประมวลผล
		}
	}else if(val==2){
		callfrm("?option=book&task=main/group_member&index=2");   //page ประมวลผล
	}
}

</script>
