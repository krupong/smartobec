<?php
header("Content-Type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="command_de.xls"');# ชื่อไฟล์ 
require_once "../../database_connect.php";
require_once "time_inc.php";	
?>
<html xmlns="http://www.w3.org/TR/REC-html40">
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</HEAD>

<BODY>
<?php
echo "<table border='1' width='99%' id='table1' style='border-collapse: collapse' cellspacing='2' cellpadding='2' align='center'>
";
?>
				<tr bgcolor="#FFFF66">
					<td align="center" width="50">
					<font size="2" face="Tahoma">เลขทะเบียน</font></td>
					<td align="center" width="50">
					<font size="2" face="Tahoma">ปี</font></td>
					<td align="center" width="120">
					<font face="Tahoma" size="2">ที่คำสั่ง</font></td>
					<td align="center">
					<font face="Tahoma" size="2">เรื่อง</font></td>
					<td align="center" width="80">
					<font face="Tahoma" size="2">สั่ง ณ วันที่</font></td>
					<td align="center" width="160">
					<font face="Tahoma" size="2">หมายเหตุ</font></td>
					<td align="center" width="160">
					<font face="Tahoma" size="2">ผู้ลงทะเบียน</font></td>
					<td align="center" width="80">
					<font face="Tahoma" size="2">วันลงทะเบียน</font></td>
				</tr>

<?php
$sql="select *,bookregister_command_sch.officer from bookregister_command_sch left join person_main on bookregister_command_sch.officer=person_main.person_id where bookregister_command_sch.year='$_GET[year_index]' and bookregister_command_sch.department='$_GET[department]'  order by year,register_number"; 
//$sql="select * from bookregister_command_sch where year=2559 and department=14 order by year,register_number"; 
$dbquery = mysqli_query($connect,$sql);

$M=1;

While ($result = mysqli_fetch_array($dbquery)){
		$ms_id = $result['ms_id'];
		$register_number = $result['register_number'];
		$year = $result['year'];
		$book_no = $result['book_no'];
		$signdate = $result['signdate'];
		$subject = $result['subject'];
		$comment = $result['comment'];
		$department2 = $result['department'];
		$register_date = $result['register_date'];
			if(($M%2) == 0)
			$color="#ffffff";
			else $color="#FFFFC";
$signdate=thai_date_3($signdate);
$register_date=thai_date_3($register_date);

//เรียกชื่อสำนัก
	$sql_d="select * from system_department where department = '$department2' ";		 //รหัสสำนัก 
	$dbquery_d = mysqli_query($connect,$sql_d);
	$result_d = mysqli_fetch_array($dbquery_d);
	$department_name = $result_d['department_name'];

?>
<?php echo "<center><b>ทะเบียนคำสั่ง  $department_name</b></center>" ?>
			<tr bgcolor="<?php echo $color;?>">
					<td align="center"><?php echo $register_number;?></td>
					<td align="center"><?php echo $year;?></td>
					<td align="left">&nbsp;<?php echo $book_no;?></td>
					<td align="left"><?php echo $subject;?></td>
					<td align="center">&nbsp;<?php echo $signdate;?></td>
					<td align="left"><?php echo $comment;?></td>
					<td align="left"><?php echo $result['prename'].$result['name']." ".$result['surname'];?></td>
					<td align='center'><?php echo $register_date;?></td>
<?php
echo "</tr>";
$M++;
}
echo "</table>";
?>
</BODY>
</HTML>
