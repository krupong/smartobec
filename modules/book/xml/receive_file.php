<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SmartObec</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="../../../css/mm_training.css" type="text/css" />
</head>

<?php
require_once "../../../database_connect.php";	
$sql = "select * from book_filebook where ref_id='$_GET[ref_id]' ";
$dbquery = mysqli_query($connect,$sql);
$file_num = mysqli_num_rows($dbquery);
if($file_num<>0){
$list = 1 ;
echo "<table>";
		while ($list<= $file_num&&$row= mysqli_fetch_array($dbquery)){
		$file_name = $row ['file_name'] ;
		$file_des = $row ['file_des'] ;
		echo "<tr><td align='left'>&nbsp;<FONT SIZE='2'>$list. </FONT><A HREF='../../../upload/book/upload_files/$file_name' title='คลิกเพื่อเปิดไฟล์แนบลำดับที่ $list' target='_BLANK'><FONT SIZE='2' COLOR='#CC0099'><span style='text-decoration: none'>$file_des</span></FONT></A></td></tr>";
		$list ++ ;
		}
echo "</table>";
}
?>