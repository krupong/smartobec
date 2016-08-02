<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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

$sql = mysqli_query($connect,"SELECT * FROM  bookregister_receive WHERE  ms_id='$_REQUEST[id]' ") ;
$result= mysqli_fetch_array($sql) ;
		$id = $result['ms_id'];
		$year = $result['year'];
		$register_number = $result['register_number'];
		$register_number_de = $result['register_number_de'];
		$register_number_g = $result['register_number_g'];
		$book_no = $result['book_no'];
		$signdate = $result['signdate'];
		$book_from = $result['book_from'];
		$book_to = $result['book_to'];
		$subject = $result['subject'];
		$operation = $result['operation'];
		$department_id = $result['department'];
		$sub_department_id = $result['sub_department'];
		$comment = $result['comment'];
		$register_date = $result['register_date'];
		$ref_id = $result['ref_id'];

$signdate=thai_date_3($signdate);
$register_date=thai_date_3($register_date);

//สำนัก
$sql_department=mysqli_query($connect,"SELECT * FROM  system_department WHERE  department='$department_id' ") ;
$result_department= mysqli_fetch_array($sql_department) ;
$department_name=$result_department['department_name'];
//กลุ่ม
$sql_subdepartment=mysqli_query($connect,"SELECT * FROM  system_subdepartment WHERE  sub_department='$sub_department_id' ") ;
$result_subdepartment= mysqli_fetch_array($sql_subdepartment) ;
$sub_department_name= $result_subdepartment['sub_department_name'];

//อาเรย์บุคลากรกลุ่ม
$sql_person= "select  * from person_main where person_id = $operation";
$dbquery_person= mysqli_query($connect,$sql_person);
While ($result_person = mysqli_fetch_array($dbquery_person))
   {
		$person_id = $result_person['person_id'];
		$person_prename = $result_person['prename'];
		$person_name = $result_person['name'];
		$person_surname = $result_person['surname'];
		$pname = "$person_prename$person_name  $person_surname";
	//	$personname_ar[$person_id]=$pname;
		
	}

//ผู้ลงทะเบียนรับ
$sql_person=mysqli_query($connect,"SELECT * FROM  person_main WHERE  person_id='$result[officer]' ") ;
$result_person= mysqli_fetch_array($sql_person) ;

//แสดงสอบแหน่ง

	$sql33="select * from person_position  where position_code =$book_to";    //
	$dbquery33 = mysqli_query($connect,$sql33);
	$ref_result33 = mysqli_fetch_array($dbquery33);
	$position_name = $ref_result33['position_name'];
//

	?>

	<div align="center">
	<table border="0" width="480" id="table1" style="border-collapse: collapse; border: 1px dotted #FF00FF; ; padding-left:4px; padding-right:4px; padding-top:1px; padding-bottom:1px" cellpadding="2" >
		<tr>
			<td bgcolor="#0000FF" colspan="2" style="border: 1px dotted #808000" align='center'><font color="#FFFFFF">
			<span lang="en-us"><font size="2">&nbsp;</font></span><font size="2">รายละเอียดหนังสือรับ 
			</font></font></td>
		</tr>
		<tr>
			<td width="449" align="left" colspan="2" style="border: 1px dotted #808000">
			<font size="2" color="#993366">&nbsp;เลขทะเบียนรับ สพฐ. : </font> <FONT SIZE="2" COLOR="#9900CC"><?php echo $register_number;?></font></td>
		</tr>
		<tr>
			<td width="449" align="left" colspan="2" style="border: 1px dotted #808000">
			<font size="2" color="#993366">&nbsp;เลขทะเบียนรับ สำนัก : </font> <FONT SIZE="2" COLOR="#9900CC"><?php echo $register_number_de;?></font></td>
		</tr>
		<tr>
			<td width="449" align="left" colspan="2" style="border: 1px dotted #808000">
			<font size="2" color="#993366">&nbsp;เลขทะเบียนรับ กลุ่ม. : </font> <FONT SIZE="2" COLOR="#9900CC"><?php echo $register_number_g;?></font></td>
		</tr>
		<tr>
		<tr>
			<td width="449" align="left" colspan="2" style="border: 1px dotted #808000">
			<font size="2" color="#993366">&nbsp;ปี : </font><FONT SIZE="2" COLOR="#9900CC"><?php echo $year;?></font> </td>
		</tr>
		<tr>
		</tr>
		<tr>
			<td width="449" align="left" colspan="2" style="border: 1px dotted #808000">
			<font size="2" color="#993366">&nbsp;วันลงทะเบียน : </font><FONT SIZE="2" COLOR="#9900CC"><?php echo $register_date;?></font> </td>
		</tr>
			<td width="449" align="left" colspan="2" style="border: 1px dotted #808000">
			<font size="2" color="#993366">&nbsp;ที่ : </font> <FONT SIZE="2" COLOR="#9900CC"><?php echo $book_no;?></font></td>
		</tr>
		<tr>
			<td width="449" align="left" colspan="2" style="border: 1px dotted #808000">
			<font size="2" color="#993366">&nbsp;ลงวันที่ : </font> <FONT SIZE="2" COLOR="#9900CC"><?php echo $signdate;?></font></td>
		</tr>
			<td width="449" align="left" colspan="2" style="border: 1px dotted #808000">
			<font size="2" color="#993366">&nbsp;จาก : </font> <FONT SIZE="2" COLOR="#9900CC"><?php echo $book_from;?></font></td>
		</tr>
			<td width="449" align="left" colspan="2" style="border: 1px dotted #808000">
			<font size="2" color="#993366">&nbsp;ถึง : </font> <FONT SIZE="2" COLOR="#9900CC"><?php echo $position_name;?></font></td>
		</tr>
		</tr>
			<td width="449" align="left" colspan="2" style="border: 1px dotted #808000">
			<font size="2" color="#993366">&nbsp;สำนัก : </font> <FONT SIZE="2" COLOR="#9900CC"><?php echo $department_name;?></font></td>
		</tr>
		</tr>
			<td width="449" align="left" colspan="2" style="border: 1px dotted #808000">
			<font size="2" color="#993366">&nbsp;กลุ่ม : </font> <FONT SIZE="2" COLOR="#9900CC"><?php echo $sub_department_name;?></font></td>
		</tr>
		<tr>
			<td width="449" align="right" colspan="2" style="border: 1px dotted #808000">
			<p align="left"><font size="2" color="#993366">&nbsp;เรื่อง : </font><FONT SIZE="2" COLOR="#9900CC"><?php echo $subject;?></FONT></td>
		</tr>
		<tr>
			<td width="449" align="left" colspan="2" style="border: 1px dotted #808000">
			<font size="2" color="#993366">&nbsp;การปฏิบัติ : </font> <FONT SIZE="2" COLOR="#9900CC"><?php echo $pname;?></font></td>
		</tr>
		<tr>
			<td width="449" align="left" colspan="2" style="border: 1px dotted #808000">
			<font size="2" color="#993366">&nbsp;หมายเหตุ : </font> <FONT SIZE="2" COLOR="#9900CC"><?php echo $comment;?></font></td>
		</tr>
		
	<tr>
			<td align="left" style="border: 1px dotted #808000"><font size="2" color="#993366">&nbsp;ไฟล์แนบ&nbsp;</font></td>
			<td  width="377" align="left" style="border: 1px dotted #808000">
			<div align="center">
				<table border="1" width="95%" id="table3" style="border-collapse: collapse" bordercolor=#669999 cellspacing="2" cellpadding="2">
<?php

// check file attach
if($result['book_link']==0){
$sql_file = mysqli_query($connect,"SELECT * FROM bookregister_receive_filebook WHERE  ref_id = '$ref_id' order by id ") ;
$road="../../../upload/bookregister/upload_files2/";
//$road="../../../upload/bookregister/upload_files1/";
}
else if($result['book_link']==1){
$sql_file = mysqli_query($connect,"SELECT * FROM  book_filebook WHERE ref_id='$ref_id' order by id") ;
$road="../../../upload/book/upload_files/";
}
else if($result['book_link']==2){
$sql_file = mysqli_query($connect,"SELECT * FROM  bookregister_send_filebook_sch WHERE ref_id='$ref_id' order by id") ;
$road="../../../upload/bookregister/upload_files2/";
}
$file_num = mysqli_num_rows ($sql_file) ;
			if ($file_num<> 0) {
			$list = 1 ;
			while ($list<= $file_num&&$row= mysqli_fetch_array($sql_file)) {
			$file_name = $row ['file_name'] ;
			$file_des = $row ['file_des'] ;

//xx
if($result['secret']==1){
				?>
									<tr>
										<td align="left">&nbsp;<FONT SIZE="2"><?php echo $list;?>. </FONT><FONT SIZE="2" COLOR="#CC0099"><span style="text-decoration: none"><?php echo $file_des;?></span></FONT></td>
									</tr>
				<?php 
}
else{
				?>
									<tr>
										<td align="left">&nbsp;<FONT SIZE="2"><?php echo $list;?>. </FONT><A HREF="../../../upload/bookregister/upload_files/<?php echo $road.$file_name;?>" title="คลิกเพื่อเปิดไฟล์แนบลำดับที่ <?php echo $list;?>" target="_BLANK"><FONT SIZE="2" COLOR="#CC0099"><span style="text-decoration: none"><?php echo $file_des;?></span></FONT></A></td>
									</tr>
				<?php
}
//endxx		
		
	$list ++ ;
	}

}else {
?>
<tr>
						<td>&nbsp;<FONT SIZE="2" COLOR="#FF0099"> ไม่มีไฟล์แนบ</FONT></td>
</tr>

<?php
}

?>

				</table>
			</div>
			</td>
		</tr>
		
		<tr>
			<td width="449" align="left" colspan="2" style="border: 1px dotted #808000">
			<font size="2" color="#993366">&nbsp;เจ้าหน้าที่ผู้ลงทะเบียน : </font><FONT SIZE="2" COLOR="#9900CC">&nbsp;<?php echo $result_person['prename'].$result_person['name'];?>&nbsp;<?php echo $result_person['surname'];?></font></td>
</tr>
	</table><BR>
</div>
<CENTER><input border="0" src="../images/button95.jpg" name="I1" width="100" height="20" type="image" onClick="javascript:window.close()">&nbsp;&nbsp;&nbsp;<A HREF="javascript:window.print()" title="พิมหน้านี้"><img border="0" src="../images/print.gif" width="25" height="25"></A></CENTER>

</body>
</html>




