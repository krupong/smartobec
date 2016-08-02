<?php
header("Content-Type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="receive.xls"');# ชื่อไฟล์ 
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</HEAD>

<BODY>
<?php
require_once "../../amssplus_connect.php";	
require_once "time_inc.php";	

?>
<table border="1" width="99%" id="table2" style="border-collapse: collapse" align="center">
				<tr bgcolor="#FFCCCC">
					<td align="center" width="50">
					<font size="2" face="Tahoma">เลขทะเบียนรับ</font></td>
					<td align="center" width="50">
					<font size="2" face="Tahoma">ปี</font></td>
					<td align="center" width="120">
					<font face="Tahoma" size="2">ที่</font></td>
					<td align="center" width="80">
					<font face="Tahoma" size="2">ลงวันที่</font></td>
					<td align="center" width="100">
					<font face="Tahoma" size="2">จาก</font></td>
					<td align="center" width="120">
					<font face="Tahoma" size="2">ถึง</font></td>
					<td align="center">
					<font face="Tahoma" size="2">เรื่อง</font></td>
					<td align="center" width="100">
					<font face="Tahoma" size="2">การปฏิบัติ</font></td>
					<td align="center" width="60">
					<font face="Tahoma" size="2">หมายเหตุ</font></td>
					<td align="center" width="80">
					<font face="Tahoma" size="2">วันลงทะเบียน</font></td>
				</tr>

<?php
$sql="select * from bookregister_receive_sch where year='$_GET[year_index]' and school_code='$_GET[school]' order by year,register_number"; 
$dbquery = mysqli_query($connect,$sql);

$M=1;
While ($result = mysqli_fetch_array($dbquery)){
		$id = $result['ms_id'];
		$register_number = $result['register_number'];
		$year = $result['year'];
		$book_no = $result['book_no'];
		$signdate = $result['signdate'];
		$book_from = $result['book_from'];
		$book_to = $result['book_to'];
		$subject = $result['subject'];
		$operation = $result['operation'];
		$comment = $result['comment'];
		$register_date = $result['register_date'];
		$ref_id = $result['ref_id'];
			if(($M%2) == 0)
			$color="#ffffff";
			else $color="#FFFFC";
$signdate=thai_date_3($signdate);
$register_date=thai_date_3($register_date);

			
if($result['secret']==1){
$secret_txt="<font color='#FF0000'>[ลับ]</font>";
}
else{
$secret_txt="";
}

?>
			<tr bgcolor="<?php echo $color;?>">
					<td align="center"><?php echo $register_number;?></td>
					<td align="center"><?php echo $year;?></td>
					<td align="left">&nbsp;<?php echo $book_no;?></td>
					<td align="center">&nbsp;<?php echo $signdate;?></td>
					<td align="left"><?php echo $book_from;?></td>
					<td align="left"><?php echo $book_to;?></td>
					<td align="left"><?php echo $subject;?>&nbsp;<?php echo $secret_txt;?></td>
					<td align="left"><?php echo $operation;?></td>
					<td align="left"><?php echo $comment;?></td>
					<td align='center'><?php echo $register_date;?></td>
<?php
echo "</tr>";
}
echo "</table>";
?>
</BODY>
</HTML>
