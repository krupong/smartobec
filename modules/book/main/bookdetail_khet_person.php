<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
if(isset($_SESSION['user_os'])){
	if($_SESSION['user_os']=='mobile'){
	echo "<meta name = 'viewport' content = 'width = device-width'>";
	}
}
?>
<style type="text/css">
<!--
.style1 {
	font-size: 12px;
}
-->
</style>
</head>
<body>

<?php
date_default_timezone_set('Asia/Bangkok');
require_once "../../../amssplus_connect.php";	
require_once("../../../mainfile.php");
require_once("../time_inc.php");

$user=$_SESSION['login_user_id'];

//ส่งคืน สถานะ 3 
if(isset($_POST['return'])){
		if (isset($_POST['s_id'])) 
			{ 
				$day_now=date("Y-m-d H:i:s");
				mysqli_query($connect,"INSERT INTO book_sendto_answer (send_to, ref_id, school, status, forward_from, rec_forward_date) Values('$_POST[s_id]','$_POST[ref_id]', '$_POST[office_from]','3','$_POST[forward_name]','$day_now') ") ;
			}
}


if(!isset($_POST['index'])){
$_POST['index']="";
}
if(!isset($_GET['index'])){
$_GET['index']="";
}

if($_GET['index']==2){
mysqli_query($connect,"DELETE FROM book_sendto_answer WHERE id='$_GET[sd_index]' ") ;
}

$sql_permission = "select * from  book_permission where person_id='$_SESSION[login_user_id]'";
$dbquery_permission = mysqli_query($connect,$sql_permission);
$result_permission = mysqli_fetch_array($dbquery_permission);

$sql = mysqli_query($connect,"SELECT * FROM  book_main WHERE  ms_id  ='$_REQUEST[b_id]' ") ;
$row2= mysqli_fetch_array($sql) ;
		$id = $row2['ms_id'];
		$ref_id = $row2['ref_id'];
		$level = $row2['level'];
		$book_no = $row2['book_no'];
		$signdate = $row2['signdate'];
		$subject = $row2['subject'];
		$ref_id = $row2['ref_id'];
		$rec_date = $row2['send_date'];
		$detail = $row2['detail'];  $detail = nl2br($detail) ;

$send_date=thai_date_4($rec_date);
$signdate=thai_date_3($signdate);

//หาหน่วยงานผู้ส่ง
$sql_sender = mysqli_query($connect,"SELECT * FROM  system_workgroup  WHERE  workgroup='$row2[office]' ") ;
$row_sender= mysqli_fetch_array($sql_sender) ;
if($row_sender){
$sender=$row_sender['workgroup_desc'];
		//หาชือผู้ส่ง	
		$sql_name = mysqli_query($connect,"SELECT * FROM  person_main WHERE person_id='$row2[sender]'");
		$row_name= mysqli_fetch_array($sql_name) ;
}
else {
$sql_sender = mysqli_query($connect,"SELECT * FROM  system_school WHERE  school_code='$row2[office]' ") ;
$row_sender= mysqli_fetch_array($sql_sender) ;
$sender=$row_sender['school_name'];
		//หาชื่อผู้ส่ง	
		$sql_name = mysqli_query($connect,"SELECT * FROM  person_sch_main WHERE person_id='$row2[sender]'");
		$row_name= mysqli_fetch_array($sql_name) ;
}

//select เลขทะเบียนหนังสือรับ
				$query_register_num=mysqli_query($connect,"select  register_number from bookregister_receive where ref_id='$ref_id' ");
				$result_register_num= mysqli_fetch_array($query_register_num) ;

// person answer
$sql_answer = mysqli_query($connect,"SELECT id FROM  book_sendto_answer WHERE ref_id ='$ref_id' and send_to='$user' and  answer='1' ") ;
$ans_num = mysqli_num_rows
 ($sql_answer) ;

if ($ans_num == 0) {
$day_now=date("Y-m-d H:i:s");
$sql_answer = mysqli_query($connect,"update book_sendto_answer set answer='1', 
		answer_time='$day_now'
		where ref_id='$ref_id' and send_to='$user'") ;
}

// img of level
$img_level="";
if ($level==1) {
	$img_level = "<IMG SRC=\"../images/level1.gif\" WIDTH=\"20\" HEIGHT=\"11\" BORDER=\"0\" ALT=\"ปกติ\">&nbsp;<FONT SIZE=\"2\" COLOR=>ปกติ</FONT>" ;
}else if ($level==2) {
	$img_level = "<IMG SRC=\"../images/level2.gif\" WIDTH=\"20\" HEIGHT=\"11\" BORDER=\"0\" ALT=\"ด่วน\">&nbsp;<FONT SIZE=\"2\" COLOR=>ด่วน</FONT>" ;
}else if ($level==3) {
	$img_level = "<IMG SRC=\"../images/level3.gif\" WIDTH=\"20\" HEIGHT=\"11\" BORDER=\"0\" ALT=\"ด่วนมาก\">&nbsp;<FONT SIZE=\"2\" COLOR=>ด่วนมาก</FONT>" ;
}else if ($level==4) {
	$img_level = "<IMG SRC=\"../images/level4.gif\" WIDTH=\"20\" HEIGHT=\"11\" BORDER=\"0\" ALT=\"ด่วนที่สุด\">&nbsp;<FONT SIZE=\"2\" COLOR=>ด่วนที่สุด</FONT>" ;
}

	?>

	<div align="center">
	<table border="0" width="480" id="table1" style="border-collapse: collapse; border: 1px dotted #FF00FF; ; padding-left:4px; padding-right:4px; padding-top:1px; padding-bottom:1px" cellpadding="2" >
		<tr>
			<td bgcolor="#003399" colspan="2" style="border: 1px dotted #808000"><font color="#FFFFFF">
			<span lang="en-us"><font size="2">&nbsp;</font></span><font size="2">รายละเอียดหนังสือ
			<?php echo $book_no;?></font></font></td>
		</tr>
		<tr>
			<td width="449" align="right" colspan="2" style="border: 1px dotted #808000">
			<p align="left"><font size="2">&nbsp;เรื่อง : </font><FONT SIZE="2" COLOR="#CC3300"><?php echo $subject;?></FONT> [<?php echo $img_level;?>]
			</td>
		</tr>
		<tr>
			<td width="449" align="left" colspan="2" style="border: 1px dotted #808000">
			<font size="2">&nbsp;เลขทะเบียนหนังสือรับ : </font> <FONT SIZE="2" COLOR="#CC3300"><?php echo $result_register_num['register_number']; ?></font></td>
		</tr>
		<tr>
			<td width="449" align="left" colspan="2" style="border: 1px dotted #808000">
			<font size="2">&nbsp;หนังสือลงวันที่ : </font> <FONT SIZE="2" COLOR="#CC3300"><?php echo $signdate;?></font></td>
		</tr>
		<tr>
			<td width="449" align="left" colspan="2" style="border: 1px dotted #808000">
			<font size="2">&nbsp;ส่งโดย : </font><FONT SIZE="2" COLOR="#CC3300"><?php echo $sender;?>&nbsp;[<?php echo $row_name['name'];?>&nbsp;<?php echo $row_name['surname'];?>]</font></td>
		</tr>
		<tr>
			<td width="449" align="left" colspan="2" style="border: 1px dotted #808000">
			<font size="2">&nbsp;วันเวลาที่ส่ง : </font><FONT SIZE="2" COLOR="#CC3300"><?php echo $send_date;?></font> </td>
		</tr>
		<tr>
			<td width="85" align="left" style="border: 1px dotted #808000"><font size="2">&nbsp;เนื้อหาโดยสรุป</font></td>
			<td width="377" align="left" style="border: 1px dotted #808000">
			<div align="center">
				<table border="1" width="95%" id="table2" style="border-collapse: collapse" bordercolor="#808000" cellspacing="2" cellpadding="2">
					<tr>
						<td align="left"><FONT SIZE="2" align="left"><?php echo $detail;?></FONT></td>
					</tr>
				</table>
			</div>
			</td>
		</tr>
		
	<tr>
			<td align="left" style="border: 1px dotted #808000"><font size="2">&nbsp;ไฟล์แนบ&nbsp;</font></td>
			<td  width="377" align="left" style="border: 1px dotted #808000">
			<div align="center">
				<table border="1" width="95%" id="table3" style="border-collapse: collapse" bordercolor=#669999 cellspacing="2" cellpadding="2">
<?php

// check file attach
if($row2['bookregis_link']==0){
$sql_file = mysqli_query($connect,"SELECT * FROM book_filebook WHERE  ref_id = '$ref_id' ") ;
$road="../../../upload/book/upload_files/";
}
else if($row2['bookregis_link']==1 and $row2['book_type']==1){
$sql_file = mysqli_query($connect,"SELECT * FROM  bookregister_send_filebook WHERE ref_id='$ref_id' ") ;
$road="../../../upload/bookregister/upload_files2/";
}
else if($row2['bookregis_link']==1 and $row2['book_type']==2){
$sql_file = mysqli_query($connect,"SELECT * FROM  bookregister_send_filebook_sch WHERE ref_id='$ref_id' ") ;
$road="../../../upload/bookregister/upload_files2/";
}
$file_num = mysqli_num_rows
 ($sql_file) ;

if ($file_num<> 0) {
$list = 1 ;
while ($list<= $file_num&&$row= mysqli_fetch_array($sql_file)) {
$file_name = $row ['file_name'] ;
$file_des = $row ['file_des'] ;
?>
					<tr>
						<td align="left">&nbsp;<FONT SIZE="2"><?php echo $list;?>. </FONT><A HREF="../../../upload/book/upload_files/<?php echo $road.$file_name;?>" title="คลิกเพื่อเปิดไฟล์แนบลำดับที่ <?php echo $list;?>" target="_BLANK"><FONT SIZE="2"><span style="text-decoration: none"><?php echo $file_des;?></span></FONT></A></td>
					</tr>

<?php
	$list ++ ;
	}

}else {
?>
<tr>
						<td>&nbsp;<FONT SIZE="2" COLOR="#CC3300"> ไม่มีไฟล์แนบ</FONT></td>
</tr>

<?php
}

?>

				</table>
			</div>
			</td>
		</tr>
		
		<tr>
			<td align="center" colspan="2"><BR><b>
			<font size="2" color="#6600CC">ส่งถึง</font></b></td>
		</tr>
		
		<tr>
		<td colspan="2">
			<table border="1" width="98%" id="table3" style="border-collapse: collapse" bordercolor=#669999 cellpadding="2">
		<?php
		
// อาเรย์ชื่อหน่วยงาาน
$office_name_ar['saraban']="สาราบรรณกลาง";
$sql_work_group = mysqli_query($connect,"SELECT * FROM  system_workgroup") ;
while ($row_work_group= mysqli_fetch_array($sql_work_group)){
$office_name_ar[$row_work_group['workgroup']]=$row_work_group['workgroup_desc'];
}
$sql_sch = mysqli_query($connect,"SELECT * FROM  system_school") ;
while ($row_sch= mysqli_fetch_array($sql_sch)){
$office_name_ar[$row_sch['school_code']]=$row_sch['school_name'];
}
$sql_person = mysqli_query($connect,"SELECT * FROM  person_main") ;
while ($row_person = mysqli_fetch_array($sql_person)){
$office_name_ar[$row_person['person_id']]=$row_person['prename'].$row_person['name']." ".$row_person['surname'];
}

$sql_name = "select * from book_sendto_answer where ref_id='$ref_id' order by id";
$dbquery_name = mysqli_query($connect,$sql_name);
$M=1;
while ($result_name=mysqli_fetch_array($dbquery_name)) {
		$send_to= $result_name['send_to'];
		$office_from=$result_name['school'];
		$answer=$result_name['answer'];
		$answer_time=$result_name['answer_time'];
		$answer_time=thai_date_4($answer_time);

echo "<tr><td width='40%' align='left'>&nbsp;<FONT SIZE='2'>$M.</FONT><FONT SIZE='2' COLOR='#CC0099'>$office_name_ar[$send_to]</FONT></td><td align='left'>";

		if ($answer==0) {
		$ans_img = "<IMG SRC=\"../images/b_usrdrop.png\" WIDTH=\"16\" HEIGHT=\"16\" BORDER=\"0\" ALT=\"ยังไม่ลงทะเบียนรับ \"><FONT SIZE=\"2\" COLOR=\"\">ยังไม่ลงทะเบียนรับ</FONT>" ;
		} 
		else if($answer==1) {
		$ans_img = "<IMG SRC=\"../images/b_usrcheck.png\" WIDTH=\"16\" HEIGHT=\"16\" BORDER=\"0\" ALT=\"ลงทะเบียนรับแล้ว\"><FONT SIZE=\"2\" COLOR=\"\">ลงทะเบียนรับแล้วเมื่อ $answer_time</FONT>" ;
		}
echo $ans_img; 

echo "</td></tr>";
$M++;
}

$date=date("Y-m-d H:i:s");
$date_now=thai_date_4($date);		
?>
	</table>
</td>	
</tr>

<tr><td colspan="2">
	<CENTER><FONT SIZE="2" COLOR="#0000FF">ข้อมูล ณ <?php echo $date_now;?></FONT><BR><FONT SIZE="2" COLOR="#999933">************************************</FONT></CENTER>
</td></tr>	
</div>

<!--ส่วนของการส่งหนังสือให้บุคลากรในกลุ่ม-->	
<br />	
<div align="center">
<tr><td colspan="2">
<table border="0" width="100%" style="border-collapse: collapse">
		<tr>
			<td bgcolor="#800000"><font face="Tahoma"><font size="2">&nbsp;</font><span lang="th"><font size="2" color="#FFFFFF"><B>ส่งหนังสือคืนให้สารบรรณกลุ่ม</B></font></span></font> </td>
		</tr>
		</table>

  <form method="POST" action="bookdetail_khet_person.php" name="form1" onSubmit="return checkform();">
  <TABLE border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width=95% bordercolor="#808000">

<?php
echo "<tr><td colspan='2' align='left'><br><input type='checkbox' name='return' value='1'><FONT SIZE='2' COLOR='#660099'>ส่งหนังสือคืนสารบรรณ</FONT></td></tr>";
?>
  	 </table>
<BR><input name="boxchecked" type="hidden" id="boxchecked" value="<?php echo $list1;?>"><input name="ref_id" type="hidden"  value="<?php echo $ref_id;?>"><input name="forward_name" type="hidden"  value="<?php echo $user;?>"><input name="index" type="hidden"  value="1"><input name="b_id" type="hidden"  value="<?php echo $_REQUEST['b_id'];?>"><input type="hidden" name="s_id" value="<?php echo $office_from;?>"><input name="office_from" type="hidden"  value="<?php echo $office_from;?>">
	 <CENTER><input type="submit" value="  เลือก  " name="submit">
<HR>	</form>


<!--แสดงกลุ่มที่เคยส่งหนังสือให้ -->
<?php
$result2=mysqli_query($connect,"SELECT * FROM book_sendto_answer WHERE ref_id='$ref_id' and status='3' ");
$num2 = mysqli_num_rows
 ($result2) ;

?>
  <div align="center">
	<table border="0" width="400"  style="border-collapse: collapse">
		<form method="POST" action="" name="form2" >
			<tr>
				<td>&nbsp;<b><font size="2" color="#003399">รายชื่อบุคคลที่ส่งหนังสือให้แล้ว
				จำนวน <FONT SIZE="2" COLOR="#FF0066"><?php echo $num2;?></FONT> ราย</font></b></td>
			</tr>
			<tr>
				<td>
<?php
$list2=1;
while ($r2=mysqli_fetch_array($result2)) {
	$send_to = $r2['send_to'] ;
?>&nbsp;<FONT SIZE="2" COLOR="">&nbsp;<FONT SIZE="2" COLOR=""><A HREF="bookdetail_khet_person.php?index=2&sd_index=<?php echo $r2['id'];?>&b_id=<?php echo $_REQUEST['b_id'];?> "><IMG SRC="../../../images/b_drop.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT="ลบออก"></A>&nbsp; <?php echo $list2;?>. <?php echo $office_name_ar[$send_to]; ?>&nbsp; 
<?php $send_date=thai_date_4($r2['rec_forward_date']);
 echo $send_date; 
 ?></FONT><BR>
				
<?php
$list2 ++ ;
} 
?>			
				</td>
			</tr>
		</form>
	</table>
</td></tr>

<tr><td colspan="2">
<br />	
<CENTER><input border="0" src="../images/button95.jpg" name="I1" width="100" height="20" type="image" onClick="javascript:window.close()"></CENTER>
</td></tr>
</table>

<script language="JavaScript">
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
    alert("กรุณาเลือกรายการค่ะ");
    return false;
  }else{
	 return confirm ("คุณต้องการส่งไปรายการที่ได้เลือกไว้ ?");
    return true;
  }
}
</script>



</body>
</html>




