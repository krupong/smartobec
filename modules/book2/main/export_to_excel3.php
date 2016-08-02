<?php
header("Content-Type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="command_3.xls"');# ชื่อไฟล์ 
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</HEAD>

<BODY>
<?php
require_once "../../../amssplus_connect.php";	
require_once "../time_inc.php";	

$sql="select *,bookregister_command.officer from bookregister_command left join person_main on bookregister_command.officer=person_main.person_id where year='$_GET[year_index]' order by year,register_number"; 
$dbquery = mysqli_query($connect,$sql);
echo "<table border='1'>";
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
					<td align="center" width="250">
					<font face="Tahoma" size="2">ผู้ลงทะเบียน</font></td>
					<td align="center" width="100">
					<font face="Tahoma" size="2">วันลงทะเบียน</font></td>
				</tr>
<?php				
$N=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['ms_id'];
		$register_number = $result['register_number'];
		$year = $result['year'];
		$book_no = $result['book_no'];
		$signdate = $result['signdate'];
		$subject = $result['subject'];
		$comment = $result['comment'];
		$register_date = $result['register_date'];
		
$signdate=thai_date_3($signdate);
$register_date=thai_date_3($register_date);
		
		echo "<Tr><Td align='center'>$register_number</Td><Td align='center'>$year</Td><Td align='left'>$book_no</Td><Td align='left'>$subject</Td><Td align='left'>$signdate</Td><Td align='left'>$comment </Td>";
echo "<Td align='left'>";
echo $result['prename'].$result['name']." ".$result['surname'];
echo "</Td>";
echo "<td>$register_date</td></Tr>";
$N++;
	}
echo "</Table>";
?>
</BODY>
</HTML>
