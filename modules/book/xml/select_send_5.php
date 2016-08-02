<?php
session_start();
$ref_id= $_SESSION ['ref_id'] ;

if(isset($_REQUEST['sd_index'])){
$sd_index=$_REQUEST['sd_index'];
}

date_default_timezone_set('Asia/Bangkok');
require_once "../../../database_connect.php";	
require_once("../../../mainfile.php");
?>

<html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<title>Smart OBEC</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/mm_training.css" type="text/css" />
</head>

<body topmargin="0" leftmargin="0" >

<div align="center">
<table border="0" width="100%" style="border-collapse: collapse">
		<tr>
			<td bgcolor="#800000"><font face="Tahoma"><font size="2">&nbsp;</font><span lang="th"><font size="2" color="#FFFFFF"><B>กรุณาคลิกเลือกผู้รับ</B></font></span></font> </td>
		</tr>
		</table>
		
<?php
if($sd_index=='some'){
$result=mysqli_query($connect,"SELECT * FROM system_department") ;
$num = mysqli_num_rows ($result) ;
$list=1;
echo "<FONT SIZE='3' color='#800080'><b>เลือกกลุ่ม</b></font><br>";
while ($r=mysqli_fetch_array($result)) {
	$department = $r['code'] ;
	$department_name = $r['name'] ;
	if ($list!=$num){$divition="||";}else{$divition="";}

echo "<FONT SIZE=2 COLOR=''><A HREF=\"?department=$department&sd_index=$sd_index\"><span style=\"text-decoration: none\">";

//กำหนดตัวแปร
if(!isset($_REQUEST['department'])){
$_REQUEST['department']="";
}
		if($_REQUEST['department']==$department){
		echo "<b><font color='#FF3300'>$department_name</font></b>";
		}
		else{
		echo $department_name;
		}
echo "</span></A> $divition </FONT>  " ;


$list ++ ;
} // จบ while result
} //จบ sd_index=some

?>
		
<br /><br />
  <form method="POST" action="select_send_5.php" name="form1" >
  <TABLE border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width=95% bordercolor="#808000" bgcolor="#FFFBEA">
     <TR >   
	 <td colspan=4>&nbsp;<input name="allbox" onClick="selectall();" type="checkbox"><FONT SIZE="2" COLOR="#990033">เลือก/ไม่เลือก ทั้งหมด</FONT><HR></td>
	 </tr>
	 <tr>

	   
<?php
//กำหนดตัวแปร
if(!isset($_POST['index'])){
$_POST['index']="";
}

if($_POST['index']==1){
$s_id=$_POST['s_id'];
	for ($i=1;$i<=$_POST['boxchecked'];$i++){
		if(isset($_POST['s_id'][$i])){	
			if ($_POST['s_id'][$i]!="") // Check Select Topic
				{ 
				mysqli_query($connect,"INSERT INTO book_sendto_answer (send_level, send_to,ref_id) Values('2', '$s_id[$i]','$ref_id') ") ;
				}
			}
		}	
}

if(isset($_GET['index'])){
		if($_GET['index']==2){
		mysqli_query($connect,"DELETE FROM book_sendto_answer WHERE send_to='$_GET[sendtoname]' and ref_id='$ref_id' ") ;
		}
}

if($sd_index=='some'){
$result1=mysqli_query($connect,"SELECT * FROM  system_department where department='$_REQUEST[department]' order by department") ;
}
else{
$result1=mysqli_query($connect,"SELECT * FROM system_department order by system_department.department") ;
}
$num1 = mysqli_num_rows ($result1) ;

$list1=1;
while ($r1=mysqli_fetch_array($result1)) {
	$department = $r1['department'] ;
	$department_name = $r1['department_name'] ;
	
$result_select=mysqli_query($connect,"SELECT * FROM book_sendto_answer WHERE send_to='$department' and ref_id='$ref_id'") ;
$num_select = mysqli_num_rows ($result_select) ;
	if ($num_select==0) {
	   ?>
		  <TD  width="25%">&nbsp;&nbsp;&nbsp;<input type="checkbox" name="s_id[<?php echo $list1?>]" value="<?php echo $department?>"><FONT SIZE="2" COLOR="#660099"><?php echo $department." ".$department_name?></FONT></TD>
	
	<?php
	}
		if($list1%2==0){
		echo "</tr><tr>";}
$list1 ++ ;
} 
?>
 </TR>
  	 </table>
<BR><input name="boxchecked" type="hidden" id="boxchecked" value="<?php echo $list1?>"> <input name="sd_index" type="hidden"  value="<?php echo $sd_index?>"><input name="index" type="hidden"  value="1"><input name="department" type="hidden"  value="<?php echo $_REQUEST['department']?>"> <input type="submit" value="  เลือก  " name="submit" onClick="return checkform();">
<HR>	</form>
<!--Userที่เลือกแล้ว -->
<?php
$result2=mysqli_query($connect,"SELECT * FROM book_sendto_answer WHERE send_level='2' and ref_id='$ref_id' ") ;
$num2 = mysqli_num_rows ($result2) ;

// อาเรย์ชื่อหน่วยงาาน
$office_name_ar['saraban']="สารบรรณกลาง";
$sql_work_group = mysqli_query($connect,"SELECT * FROM system_department") ;
while ($row_work_group= mysqli_fetch_array($sql_work_group)){
$office_name_ar[$row_work_group['department']]=$row_work_group['department_name'];
}
// สพท.
$sql_sch = mysqli_query($connect,"SELECT * FROM  system_khet") ;
while ($row_sch= mysqli_fetch_array($sql_sch)){
$office_name_ar[$row_sch['khet_code']]=$row_sch['khet_precis'];
}

?>
	<table border="0" width="400"  style="border-collapse: collapse" bgcolor="#EAFFF0">
		<form method="POST" action="select_send_5.php" name="form2" >
			<tr>
				<td>&nbsp;<b><font size="2" color="#800080">รายชื่อที่เลือกไว้ 
				จำนวน <FONT SIZE="2" COLOR="#FF0066"><?php echo $num2 ?></FONT> แห่ง</font></b></td>
			</tr>
			<tr>
				<td>
<?php
$list2=1;
while ($r2=mysqli_fetch_array($result2)) {
	$sendtoname  = $r2['send_to'] ;

?>&nbsp;<FONT SIZE="2" COLOR=""><A HREF="select_send_5.php?sendtoname=<?php echo $sendtoname?>&index=2&sd_index=<?php echo $sd_index?>"><IMG SRC="../../../images/b_drop.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT="ลบออก"></A>&nbsp; <?php echo $list2?>. <?php echo $office_name_ar[$sendtoname] ;?></FONT><BR>
				
<?php
$list2 ++ ;
} 
?>			
				</td>
			</tr>
			<tr>
				<td>
				<input type="submit" value="  เสร็จ  " name="submit1" onClick="return checkform2();">
				</td>
			</tr>
		</form>
	</table>
</div><HR>
</body>
<script language="JavaScript">
<!--
function selectall(){
	for (var i=0;i<document.form1.elements.length;i++)
	{
		var e = document.form1.elements[i];
		if (e.name != 'allbox')
			e.checked = document.form1.allbox.checked;
	}
}

function checkform() {
var checkvar = document.all;
var check = "";
  for (i = 0; i < checkvar.length; i++) {
    if (checkvar[i].checked){
      check = "Y";
      break;
    }
  }
  if (check==""){
    alert("กรุณาเลือกอย่างน้อย 1 รายการค่ะ");
    return false;
  }else{
	 return confirm ("คุณต้องการส่งหนังสือตามรายชื่อที่ได้เลือกไว้ ?");
    return true;
  }
}

function checkform2() {
var num_item=<?php echo $num2?>;
  if (num_item==0){
    alert("กรุณาเลือกอย่างน้อย 1 รายการค่ะ");
    return false;
  }else{
	window.close() 
 }
}

</script>

</html>