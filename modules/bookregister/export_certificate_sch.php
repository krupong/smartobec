<?php
header("Content-Type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="certificate.xls"');# ชื่อไฟล์ 
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</HEAD>

<BODY>
<?php
require_once "../../amssplus_connect.php";	
require_once "time_inc.php";	

echo "<table border='1' width='99%' id='table1' style='border-collapse: collapse' cellspacing='2' cellpadding='2' align='center'>
";
?>
				<tr bgcolor="#FFFF66">
					<td align="center" width="50">
					<font size="2" face="Tahoma">เลขทะเบียน</font></td>
					<td align="center" width="50">
					<font size="2" face="Tahoma">ปี</font></td>
					<td align="center" width="120">
					<font face="Tahoma" size="2">ที่เกียรติบัตร</font></td>
					<td align="center" width="160">
					<font face="Tahoma" size="2">ชื่อ</font></td>
					<td align="center">
					<font face="Tahoma" size="2">เรื่อง/รายการ</font></td>
					<td align="center" width="80">
					<font face="Tahoma" size="2">วันที่ออก</font></td>
					<td align="center" width="160">
					<font face="Tahoma" size="2">หมายเหตุ</font></td>
					<td align="center" width="80">
					<font face="Tahoma" size="2">วันลงทะเบียน</font></td>
				</tr>

<?php
$sql="select * from bookregister_certificate_sch where year='$_GET[year_index]' and school_code='$_GET[school]' order by year,register_number"; 
$dbquery = mysqli_query($connect,$sql);

$M=1;

While ($result = mysqli_fetch_array($dbquery)){
		$id = $result['ms_id'];
		$register_number = $result['register_number'];
		$year = $result['year'];
		$book_no = $result['book_no'];
		$signdate = $result['signdate'];
		$subject = $result['subject'];
		$comment = $result['comment'];
		$register_date = $result['register_date'];
			if(($M%2) == 0)
			$color="#ffffff";
			else $color="#FFFFC";
$signdate=thai_date_3($signdate);
$register_date=thai_date_3($register_date);

?>
			<tr bgcolor="<?php echo $color;?>">
					<td align="center"><?php echo $register_number;?></td>
					<td align="center"><?php echo $year;?></td>
					<td align="left">&nbsp;<?php echo $book_no;?></td>
					<td align="left">&nbsp;<?php echo $result['name_cer'];?></td>
					<td align="left"><?php echo $subject;?></td>
					<td align="center">&nbsp;<?php echo $signdate;?></td>
					<td align="left"><?php echo $comment;?></td>
					<td align='center'><?php echo $register_date;?></td>
<?php
echo "</tr>";
$M++;
}
echo "</table>";
?>
</BODY>
</HTML>
