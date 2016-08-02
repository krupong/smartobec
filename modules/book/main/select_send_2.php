<!-- Bootstrap Include -->
<link rel="stylesheet" type="text/css" href="../../../bootstrap-3.3.5-dist/css/bootstrap.min.css">
<script src="../../../bootstrap-3.3.5-dist/js/jquery-1.11.3.min.js"></script>
<script src="../../../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<script src="../../../bootstrap-3.3.5-dist/js/bootstrap-confirmation.min.js"></script>
<script src="../../../ckeditor_4.5.2_full/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="../../../css/style.css">

<?php
session_start();
$ref_id= $_SESSION ['ref_id'] ;
//$sd_index=$_REQUEST['sd_index'];

if(isset($_REQUEST['sd_index'])){
$sd_index=$_REQUEST['sd_index'];
}

if(!isset($_GET['index'])){
$_GET['index']="";
}

date_default_timezone_set('Asia/Bangkok');
require_once "../../../database_connect.php";	
require_once("../../../mainfile.php");



?>
<html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
$result=mysqli_query($connect,"SELECT * FROM system_khet_group") ;
$num = mysqli_num_rows ($result) ;
$list=1;
echo "<FONT SIZE='3' color='#800080'><b>เลือกกลุ่ม สพท.</b></font><br>";
while ($r=mysqli_fetch_array($result)) {
	$group_code = $r['code'] ;
	$group_name = $r['name'] ;
	if ($list!=$num){$divition="||";}else{$divition="";}

echo "<FONT SIZE=2 COLOR=''><A HREF=\"?group=$group_code&sd_index=$sd_index\"><span style=\"text-decoration: none\">";

//กำหนดตัวแปร
if(!isset($_REQUEST['group'])){
$_REQUEST['group']="";
}

		if($_REQUEST['group']==$group_code){
		echo "<b><font color='#FF3300'>$group_name</font></b>";
		}
		else{
		echo $group_name;
		}
echo "</span></A> $divition </FONT>  " ;


$list ++ ;
} // จบ while result
} //จบ sd_index=some

?>
		
<br /><br />
  <form method="POST" action="select_send_2.php" name="form1" >
  <TABLE border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width=95% bordercolor="#808000" bgcolor="#FFFBEA">
     <TR >   
	 <td colspan=4>&nbsp;<input name="allbox" onClick="selectall();" type="checkbox"><FONT SIZE="2" COLOR="#990033">เลือก/ไม่เลือกทั้งหมด</FONT><HR></td>
	 </tr>
	 <tr>
         <td>
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
					if($_SESSION['login_group']==1){
					mysqli_query($connect,"INSERT INTO book_sendto_answer (send_level, send_to,ref_id) Values('1', '$s_id[$i]','$ref_id') ") ;
					}
					//else if(($_SESSION['login_status']>10) and ($_SESSION['login_status']<=15)){
					//mysqli_query($connect,"INSERT INTO book_sendto_answer (send_level, send_to,ref_id) Values('3', '$s_id[$i]','$ref_id') ") ;
					//}
				}
			}
		}	
}

if(isset($_GET['index'])){
		if($_GET['index']==2){
		mysqli_query($connect,"DELETE FROM book_sendto_answer WHERE send_to='$_GET[sendtoname]' and ref_id='$ref_id' ") ;
		}
}

if(!isset($_SESSION['user_khet'])){
$_SESSION['user_khet']="";
}

if($sd_index=='some'){
if($_REQUEST[group]==1){ //สพป.
    $result1=mysqli_query($connect,"SELECT * FROM  system_khet  where  khet_group='$_REQUEST[group]' and khet_code != '$_SESSION[user_khet]' order by CONVERT(khet_precis USING tis620)") ;
}else if($_REQUEST[group]==2){ //สพม.
    $result1=mysqli_query($connect,"SELECT * FROM  system_khet  where  khet_group='$_REQUEST[group]' and khet_code != '$_SESSION[user_khet]' order by khet_code ") ;
}
}
else{
$result1=mysqli_query($connect,"SELECT * FROM  book_group_member left join system_khet on book_group_member.khet_id=system_khet.khet_code WHERE  book_group_member.grp_id= '$sd_index' order by system_khet.khet_type, system_khet.khet_code") ;
}
$num1 = mysqli_num_rows ($result1) ;
$num1divide2 = ceil($num1/2);

echo "<div class='container'>";
echo "<div class='row'>";
echo "<div class='col-xs-6' align='left'>";
$list1=1;
while ($r1=mysqli_fetch_array($result1)) {
	$khet_code = $r1['khet_code'] ;
	$khet_precis = $r1['khet_precis'] ;
	
$result_select=mysqli_query($connect,"SELECT * FROM book_sendto_answer WHERE send_to='$khet_code' and ref_id='$ref_id'") ;
$num_select = mysqli_num_rows ($result_select) ;
	if ($num_select==0) {

         ?>
         <input type="checkbox" name="s_id[<?php echo $list1?>]" value="<?php echo $khet_code?>"><FONT SIZE="2" COLOR="#660099"><?php echo $khet_precis?></FONT><br>

         <?php
        if($list1 == $num1divide2){  
             echo "</div><div class='col-xs-6' align='left'>";
         }
	}

$list1 ++ ;
} 
?>
      </div>
      </div>
  </div>

</TD>    
 </TR>
  	 </table>
<BR><input name="boxchecked" type="hidden" id="boxchecked" value="<?php echo $list1?>"> <input name="sd_index" type="hidden"  value="<?php echo $sd_index?>"><input name="index" type="hidden"  value="1"><input name="group" type="hidden"  value="<?php echo $_GET['group']?>">
	 <CENTER><input type="submit" value="  เลือก  " name="submit" onClick="return checkform();">
<HR>	</form>
<!--Userที่เลือกแล้ว -->
<?php
/*
$result2=mysqli_query($connect,"SELECT * FROM book_sendto_answer left join system_khet on book_sendto_answer.send_to=system_khet.khet_code WHERE book_sendto_answer.ref_id='$ref_id' ") ;
$num2 = mysqli_num_rows ($result2) ;

$result2=mysqli_query($connect,"SELECT * FROM book_sendto_answer left join system_special_unit on book_sendto_answer.send_to=system_special_unit.unit_code WHERE book_sendto_answer.ref_id='$ref_id' ") ;
$num2 = mysqli_num_rows ($result2) ;

$result2=mysqli_query($connect,"SELECT * FROM book_sendto_answer left join system_department on book_sendto_answer.send_to=system_department.department WHERE book_sendto_answer.ref_id='$ref_id' ") ;
$num2 = mysqli_num_rows ($result2) ;

$result2=mysqli_query($connect,"SELECT * FROM book_sendto_answer left join system_school on book_sendto_answer.send_to=system_school.school_code WHERE book_sendto_answer.ref_id='$ref_id' ") ;
$num2 = mysqli_num_rows ($result2) ;
*/
// อาเรย์ชื่อหน่วยงาาน
$office_name_ar['saraban']="สารบรรณกลาง";
$sql_work_group = mysqli_query($connect,"SELECT * FROM  system_department") ;
while ($row_work_group= mysqli_fetch_array($sql_work_group)){
$office_name_ar[$row_work_group['department']]=$row_work_group['department_name'];
}
// สพท.
$sql_sch = mysqli_query($connect,"SELECT * FROM  system_khet") ;
while ($row_sch= mysqli_fetch_array($sql_sch)){
$office_name_ar[$row_sch['khet_code']]=$row_sch['khet_precis'];
}
// สศค.
$sql_sch = mysqli_query($connect,"SELECT * FROM  system_special_unit") ;
while ($row_sch= mysqli_fetch_array($sql_sch)){
$office_name_ar[$row_sch['unit_code']]=$row_sch['unit_name'];
}
// รร.
$sql_sch2 = mysqli_query($connect,"SELECT * FROM  system_school") ;
while ($row_sch2= mysqli_fetch_array($sql_sch2)){
$office_name_ar[$row_sch2['school_code']]=$row_sch2['school_name'];
}

$sql_name = "select * from book_sendto_answer where ref_id='$ref_id' and (send_level='1' or send_level='2' or send_level='3') order by id";
$dbquery_name = mysqli_query($connect,$sql_name);
$num2 = mysqli_num_rows ($dbquery_name) ;
$M=1;


?>
  <div align="center">
	<table border="0" width="400"  style="border-collapse: collapse" bgcolor="#EAFFF0">
		<form method="POST" action="" name="form2" >
			<tr>
				<td>&nbsp;<b><font size="2" color="#800080">รายชื่อที่เลือกไว้ 
				จำนวน <FONT SIZE="2" COLOR="#FF0066"><?php echo $num2 ?></FONT> แห่ง</font></b></td>
			</tr>
			<tr>
				<td>
<?php
$list2=1;
while ($result_name=mysqli_fetch_array($dbquery_name)) {
		$send_to= $result_name['send_to'];
//while ($r2=mysqli_fetch_array($result2)) {
//	$sendtoname  = $r2['send_to'] ;
//	$khet_precis = $r2['khet_precis'] ;

?>&nbsp;<FONT SIZE="2" COLOR=""><A HREF="select_send_2.php?sendtoname=<?php echo $send_to;?>&index=2&sd_index=<?php echo $sd_index?>"><IMG SRC="../../../images/b_drop.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT="ลบออก"></A>&nbsp; <?php echo $list2?>. <?php echo $office_name_ar[$send_to]?></FONT><BR>
				
<?php
$list2 ++ ;
} 
?>			
				</td>
			</tr>
			<tr>
				<td>
				<p align="center">
				<input type="submit" value="เสร็จ" name="submit1" onClick="return checkform2();">
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