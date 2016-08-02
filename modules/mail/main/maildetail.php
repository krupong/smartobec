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

$sql = "select * from  mail_main left join person_main on mail_main.sender=person_main.person_id where mail_main.ms_id='$_GET[id]' ";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
$sender=$result['sender'];
$ref_id=$result['ref_id'];
$detail=$result['detail'];
$send_date=$result['send_date'];
		$prename=$result['prename'];
		$name= $result['name'];
		$surname = $result['surname'];
		$full_name="$prename$name&nbsp;&nbsp;$surname";
$thai_send_date=thai_date_4($send_date);

//บันทึกรับ
$day_now=date("Y-m-d H:i:s");
$query_receive =mysqli_query($connect,"select * from mail_sendto_answer where ref_id='$ref_id' and send_to='$user' and answer='0' ");
$receive_num=mysqli_num_rows($query_receive);
		
		if($receive_num>=1){
		$sql = "update mail_sendto_answer set answer='1', 
		answer_time='$day_now'
		where ref_id='$ref_id' and send_to='$user' ";
		mysqli_query($connect,$sql);
		}


?>

	<div align="center">
	<table border="0" width="100%" id="table1" style="border-collapse: collapse; border: 1px dotted #FF00FF; ; padding-left:4px; padding-right:4px; padding-top:1px; padding-bottom:1px" cellpadding="2" >
		<tr>
			<td bgcolor="#003399" colspan="2" style="border: 1px dotted #808000"><font color="#FFFFFF">
			<span lang="en-us"><font size="2">&nbsp;</font></span><font size="2">รายละเอียดของจดหมาย 
		     </font></font></td>
		</tr>
		<tr>
			<td width="449" align="left" colspan="2" style="border: 1px dotted #808000">
			<font size="2" >&nbsp;จาก : </font> <FONT SIZE="2" COLOR="#CC3300"><?php echo $full_name;?></font></td>
		</tr>
		<tr>
			<td width="449" align="right" colspan="2" style="border: 1px dotted #808000">
			<p align="left"><font size="2" >&nbsp;เรื่อง : </font><FONT SIZE="2" COLOR="#CC3300"><?php echo $result['subject'];?></FONT>
			</td>
		</tr>
		
		<tr>
			<td width="85" align="left" style="border: 1px dotted #808000"><font size="2" >&nbsp;ข้อความ</font></td>
			<td width="377" align="left" style="border: 1px dotted #808000">
			<div align="center">
				<table border="1" width="95%" id="table2" style="border-collapse: collapse" bordercolor="#808000" cellspacing="2" cellpadding="2">
					<tr>
						<td align="left"><FONT SIZE="2" align="left"><?php echo $result['detail'];?></FONT></td>
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
$sql_file = mysqli_query($connect,"SELECT * FROM  mail_filebook WHERE  ref_id = '$ref_id' ") ;
$file_num = mysqli_num_rows ($sql_file) ;

if ($file_num<> 0) {
$list = 1 ;
while ($list<= $file_num&&$row= mysqli_fetch_array($sql_file)) {
$file_name = $row['file_name'] ;
$file_des = $row['file_des'] ;
?>
					<tr>
						<td align="left">&nbsp;<FONT SIZE="2"><?php echo $list;?>. </FONT><A HREF="../upload_files/<?php echo $file_name;?>" title="คลิกเพื่อเปิดไฟล์แนบลำดับที่ <?php echo $list;?>" target="_BLANK"><FONT SIZE="2"><span style="text-decoration: none"><?php echo $file_des;?></span></FONT></A></td>
					</tr>

<?php
	$list ++ ;
	}

}else {
?>
<tr>
						<td align="left">&nbsp;<FONT SIZE="2" COLOR="#CC3300"> ไม่มีไฟล์แนบ</FONT></td>
</tr>

<?php
}

?>

				</table>
			</div>
			</td>
		</tr>
		<tr>
			<td align="left" colspan="2" style="border: 1px dotted #808000">
			<font size="2">&nbsp;วันที่ส่ง : </font> <FONT SIZE="2" COLOR="#CC3300"><?php echo $thai_send_date;?></font></td>
		</tr>

	</table><BR>
</div>

<CENTER><input border="0" src="../images/button95.jpg" name="I1" width="100" height="20" type="image" onClick="javascript:window.opener.location.reload();window.close();"></CENTER>

</body>
</html>




