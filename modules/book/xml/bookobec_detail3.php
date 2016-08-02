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

// อาเรย์ชื่อหน่วยงาาน
$office_name_ar['saraban']="สาราบรรณกลาง สพฐ.";
$sql_department = mysqli_query($connect,"SELECT * FROM  system_department") ;
while ($row_array= mysqli_fetch_array($sql_department)){
$office_name_ar[$row_array['department']]=$row_array['department_precis'];
}
$sql_khet = mysqli_query($connect,"SELECT * FROM  system_khet") ;
while ($row_array= mysqli_fetch_array($sql_khet)){
$office_name_ar[$row_array['khet_code']]=$row_array['khet_precis'];
}
$sql_unit = mysqli_query($connect,"SELECT * FROM system_special_unit") ;
while ($row_array= mysqli_fetch_array($sql_unit)){
$office_name_ar[$row_array['unit_code']]=$row_array['unit_name'];
}
$sql_subdepartment = mysqli_query($connect,"SELECT * FROM  system_subdepartment") ;
while ($row_array= mysqli_fetch_array($sql_subdepartment)){
$office_name_ar[$row_array['sub_department']]=$row_array['sub_department_name'];
}

$sql_book = "select * from book_main where ms_id='$_GET[b_id]' ";
$dbquery_book = mysqli_query($connect,$sql_book);
$row2= mysqli_fetch_array($dbquery_book);
		$id = $row2['ms_id'];
		$ref_id = $row2['ref_id'];
		$office = $row2['office']; 
		$sender = $row2['sender']; 
		$level = $row2['level'];
		$book_no = $row2['book_no'];
		$signdate = $row2['signdate'];
		$subject = $row2['subject'];
		$ref_id = $row2['ref_id'];
		$rec_date = $row2['send_date'];
		$detail = $row2['detail'];  $detail = nl2br($detail) ;
$send_date=thai_date_4($rec_date);
$signdate=thai_date_3($signdate);

//ผู้ส่งหนังสือ
$sql_person = "select * from person_main where person_id='$sender' ";
$dbquery_person = mysqli_query($connect,$sql_person);
$row_name= mysqli_fetch_array($dbquery_person);

//ถ้าเขตเป็นผู้ส่งให้เรียกชื่อเขตมาแสดง
//$office = $result['office'];
$office_name = $office_name_ar[$row2['office']];
if($row2['book_type']==2){
	$sql_khet="select * from system_khet where khet_code ='$office'";		 //รหัสสำนัก 
	$dbquery_khet = mysqli_query($connect,$sql_khet);
	$ref_result_khet = mysqli_fetch_array($dbquery_khet);
$office_name = $ref_result_khet['khet_precis'];
}
//จบเรียกชื่อเขต

//ไม่มีการลงทะเบียนรับหนังสือ
?>
	<div align="center">
<table border="1" width="480" id="table1" style="border-collapse: collapse; border: 1px dotted #FF00FF; ; padding-left:4px; padding-right:4px; padding-top:1px; padding-bottom:1px" cellpadding="2" >
<tr><td bgcolor="#003399" colspan="2" style="border: 1px dotted #808000"><font color="#FFFFFF">
			<span lang="en-us"><font size="2">&nbsp;</font></span><font size="2">รายละเอียดหนังสือ
			<?php echo $book_no;?></font></font></td></tr>
<tr><td width="449" align="right" colspan="2" style="border: 1px dotted #808000">
			<p align="left"><font size="2">&nbsp;เรื่อง : </font><FONT SIZE="2" COLOR="#CC3300"><?php echo $subject;?></FONT></td>	</tr>
<tr><td width="449" align="left" colspan="2" style="border: 1px dotted #808000">
			<font size="2">&nbsp;หนังสือลงวันที่ : </font> <FONT SIZE="2" COLOR="#CC3300"><?php echo $signdate;?></font></td></tr>
<tr><td width="449" align="left" colspan="2" style="border: 1px dotted #808000">
			<font size="2">&nbsp;ส่งโดย : </font><FONT SIZE="2" COLOR="#CC3300"><?php echo $office_name;?>&nbsp;[<?php echo $row_name['name'];?>&nbsp;<?php echo $row_name['surname'];?>]</font></td>	</tr>
<tr><td width="449" align="left" colspan="2" style="border: 1px dotted #808000">
			<font size="2">&nbsp;วันเวลาที่ส่ง : </font><FONT SIZE="2" COLOR="#CC3300"><?php echo $send_date;?></font> </td>	</tr>
<tr><td width="85" align="left" style="border: 1px dotted #808000"><font size="2">&nbsp;เนื้อหาโดยสรุป</font></td>
			<td width="377" align="left" style="border: 1px dotted #808000">
			<div align="center">
				<table border="1" width="95%" id="table2" style="border-collapse: collapse" bordercolor="#808000" cellspacing="2" cellpadding="2">
					<tr><td align="left"><FONT SIZE="2" align="left"><?php echo $detail;?></FONT></td></tr>
				</table>
			</div>
			</td>
		</tr>
<tr><td align="left" style="border: 1px dotted #808000"><font size="2">&nbsp;ไฟล์แนบ&nbsp;</font></td>
			<td  width="377" align="left" style="border: 1px dotted #808000">
			<div align="center">
				<table border="1" width="95%" id="table3" style="border-collapse: collapse" bordercolor=#669999 cellspacing="2" cellpadding="2">
<?php

// check file attach
if($row2['bookregis_link']==0){
$sql_file = mysqli_query($connect,"SELECT * FROM book_filebook WHERE  ref_id = '$ref_id' ") ;
$road="../../../upload/book/upload_files/";
}
else if($row2['bookregis_link']==1){
$sql_file = mysqli_query($connect,"SELECT * FROM  bookregister_send_filebook WHERE ref_id='$ref_id' ") ;
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
<tr><td align="left">&nbsp;<FONT SIZE="2"><?php echo $list;?>. </FONT><FONT SIZE="2"><span style="text-decoration: none"><?php echo $file_des;?></span></FONT></td></tr>
<?php 
}
else{
?>
<tr><td align="left">&nbsp;<FONT SIZE="2"><?php echo $list;?>. </FONT><A HREF="../../../upload/book/upload_files/<?php echo $road.$file_name;?>" title="คลิกเพื่อเปิดไฟล์แนบลำดับที่ <?php echo $list;?>" target="_BLANK"><FONT SIZE="2" COLOR="#CC0099"><span style="text-decoration: none"><?php echo $file_des;?></span></FONT></A></td></tr>
<?php
}
//endxx				
	$list ++ ;
	}
}else {
?>
<tr><td>&nbsp;<FONT SIZE="2" COLOR="#CC3300"> ไม่มีไฟล์แนบ</FONT></td></tr>
<?php
}
?>
</table>
</div>
</td></tr>
</table>
</div>
<br />	
<CENTER><input border="0" src="../images/button95.jpg" name="I1" width="100" height="20" type="image" onClick="javascript:window.close()"></CENTER>
</body>
</html>




