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
require_once "../../../database_connect.php";	
require_once("../../../mainfile.php");
require_once("../time_inc.php");

$user=$_SESSION['login_user_id'];

//สิทธิ์
$sql_permission = "select * from  book_permission where person_id='$_SESSION[login_user_id]' ";
$dbquery_permission = mysqli_query($connect,$sql_permission);
$result_permission = mysqli_fetch_array($dbquery_permission);

if(!isset($_POST['index'])){
$_POST['index']="";
}
if(!isset($_GET['index'])){
$_GET['index']="";
}

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

////////////หาหน่วยงานผู้ส่ง
$sql_sender = mysqli_query($connect,"SELECT * FROM  system_department where department='$row2[office]' ") ;
$row_sender= mysqli_fetch_array($sql_sender) ;
if($row_sender){ 
$sender=$row_sender['department_name'];
}
else {
		$sql_sender = mysqli_query($connect,"SELECT * FROM system_khet WHERE khet_code='$row2[office]' ") ;
		$row_sender= mysqli_fetch_array($sql_sender) ;
		if($row_sender){ 
		$sender=$row_sender['khet_name'];
		}
		else{
		$sql_sender = mysqli_query($connect,"SELECT * FROM system_school WHERE school_code='$row2[office]' ") ;
		$row_sender= mysqli_fetch_array($sql_sender) ;
				if($row_sender){ 
				$sender=$row_sender['school_name'];
				}
				else{
				$sql_sender = mysqli_query($connect,"SELECT * FROM system_special_unit WHERE unit_code='$row2[office]' ") ;
				$row_sender= mysqli_fetch_array($sql_sender) ;
						if($row_sender){ 
						$sender=$row_sender['unit_name'];			
						}
						else{
						$sender="";
						}
				}
		}
}
/////////////

// saraban answer
$sql_answer = mysqli_query($connect,"SELECT id FROM  book_sendto_answer WHERE ref_id ='$ref_id' and send_to='$result_permission[p4]' and answer is null") ;
$ans_num = mysqli_num_rows ($sql_answer) ;

if ($ans_num>0) {
$day_now=date("Y-m-d H:i:s");
$sql_answer = mysqli_query($connect,"update book_sendto_answer set answer='1',	answer_time='$day_now'	where ref_id='$ref_id' and send_to='$result_permission[p4]'") ;
}

// img of level
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
			<font size="2">&nbsp;ส่งโดย : </font><FONT SIZE="2" COLOR="#CC3300"><?php echo $sender;?></font></td>
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

$file_num = mysqli_num_rows ($sql_file) ;

if ($file_num<> 0) {
$list = 1 ;
while ($list<= $file_num&&$row= mysqli_fetch_array($sql_file)) {
$file_name = $row ['file_name'] ;
$file_des = $row ['file_des'] ;

//xx
if($row2['secret']==1){
				?>
									<tr>
										<td align="left">&nbsp;<FONT SIZE="2"><?php echo $list;?>. </FONT><FONT SIZE="2"><span style="text-decoration: none"><?php echo $file_des;?></span></FONT></td>
									</tr>
				<?php 
}
else{
				?>
									<tr>
										<td align="left">&nbsp;<FONT SIZE="2"><?php echo $list;?>. </FONT><A HREF="../../../upload/book/upload_files/<?php echo $road.$file_name;?>" title="คลิกเพื่อเปิดไฟล์แนบลำดับที่ <?php echo $list;?>" target="_BLANK"><FONT SIZE="2"><span style="text-decoration: none"><?php echo $file_des;?></span></FONT></A></td>
									</tr>
				<?php 
}
//endxx			
	
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
			<td  align="center" colspan="2"><BR><b>
			<font size="2" color="#6600CC">ส่งถึง</font></b></td>
		</tr>
		
		<tr>
		<td colspan="2">
			<table border="1" width="98%" id="table3" style="border-collapse: collapse" bordercolor=#669999 cellpadding="2">
		<?php
		
// อาเรย์ชื่อหน่วยงาาน
$office_name_ar['saraban']="สาราบรรณกลาง สพฐ.";
$sql_department = mysqli_query($connect,"SELECT * FROM  system_department") ;
while ($row_array= mysqli_fetch_array($sql_department)){
$office_name_ar[$row_array['department']]=$row_array['department_name'];
}
$sql_khet = mysqli_query($connect,"SELECT * FROM  system_khet") ;
while ($row_array= mysqli_fetch_array($sql_khet)){
$office_name_ar[$row_array['khet_code']]=$row_array['khet_precis'];
}
$sql_sch = mysqli_query($connect,"SELECT * FROM  system_school") ;
while ($row_array= mysqli_fetch_array($sql_sch)){
$office_name_ar[$row_array['school_code']]=$row_array['school_name'];
}
$sql_unit = mysqli_query($connect,"SELECT * FROM system_special_unit") ;
while ($row_array= mysqli_fetch_array($sql_unit)){
$office_name_ar[$row_array['unit_code']]=$row_array['unit_name'];
}

$sql_name = "select * from book_sendto_answer where ref_id='$ref_id' and send_to='$result_permission[p4]' order by id ";
$dbquery_name = mysqli_query($connect,$sql_name);
$M=1;
while ($result_name=mysqli_fetch_array($dbquery_name)) {
		$send_to= $result_name['send_to'];
		$answer=$result_name['answer'];
		$answer_time=$result_name['answer_time'];
		$answer_time=thai_date_4($answer_time);

echo "<tr><td width='40%' align='left'>&nbsp;<FONT SIZE='2'>$M.</FONT><FONT SIZE='2'>$office_name_ar[$send_to]</FONT></td><td align='left'>";

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
	<BR>
	<CENTER><FONT SIZE="2" COLOR="#0000FF">ข้อมูล ณ <?php echo $date_now;?></FONT><BR><FONT SIZE="2" COLOR="#999933">************************************</FONT></CENTER>
</div>
<CENTER><input border="0" src="../images/button95.jpg" name="I1" width="100" height="20" type="image" onClick="javascript:window.close()"></CENTER>
</td></tr>
</table>

</body>
</html>




