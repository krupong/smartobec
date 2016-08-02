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
require_once "../../../database_connect.php";	
require_once("../../../mainfile.php");
require_once("../time_inc.php");

echo "<table width='100%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>รายชื่อผู้รับจดหมาย</strong></font></td></tr>";
echo "</table>";

echo  "<table width='600' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center' class='style1'><Td width='60'>ที่</Td><Td width='300'>ชื่อ</Td><Td width='100'>รับ<Td width='200'>วดป. รับจดหมาย</Td></Tr>";
$sql_name = "select * from mail_sendto_answer left join person_main on mail_sendto_answer.send_to=person_main.person_id where mail_sendto_answer.ref_id='$_GET[ref_id]' ";
$dbquery_name = mysqli_query($connect,$sql_name);
$M=1;
while ($result_name=mysqli_fetch_array($dbquery_name)) {
		$send_to=$result_name['send_to'];
		$prename=$result_name['prename'];
		$name= $result_name['name'];
		$surname = $result_name['surname'];
		$send_to=$result_name['send_to'];
		$answer=$result_name['answer'];
		$answer_time=$result_name['answer_time'];
		$full_name="$prename$name&nbsp;&nbsp;$surname";
			if(($M%2) == 0)
			$color="#FFFFB";
			else  	$color="#FFFFFF";
			
echo "<Tr bgcolor='$color'  class='style1'><Td width='60' align='center'>$M</Td><Td>$full_name</Td><Td align='center'>";
if($answer==1){
echo "<img src=../../../images/yes.png border='0' alt='รับแล้ว'>";
}
else{
echo "<img src=../../../images/no.png border='0' alt='ยังไม่รับ'>";
}
echo "</Td><Td>";
if($answer_time>0){
echo thai_date_4($answer_time);
}
echo "</Td></Tr>";
$M++;
}
echo "</Table>";
?>
<br />
<div align="center">
<input type="submit" value="  ปิดหน้าต่างนี้  " name="submit1" onClick="javascript:window.close()">
</div>

</body>
</html>

