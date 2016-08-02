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
require_once "../../../amssplus_connect.php";	
require_once("../../../mainfile.php");
require_once("../time_inc.php");

echo "<table width='100%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>รายชื่อสถานศึกษา (หน่วยรับหนังสือราชการ)</strong></font></td></tr>";
echo "</table>";


echo  "<table width='700' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center' class='style1'><Td width='60'>ที่</Td><Td width='150'>รหัสสถานศึกษา</Td><Td width='300'>ชื่อ</Td><Td width='100'>รับ<Td width='200'>วดป. รับหนังสือ</Td></Tr>";
$sql_name = "select * from book_sendto_answer left join system_school on book_sendto_answer.send_to=system_school.school_code where book_sendto_answer.ref_id='$_GET[ref_id]' order by system_school.school_type, system_school.school_code";
$dbquery_name = mysqli_query($connect,$sql_name);
$M=1;
while ($result_name=mysqli_fetch_array($dbquery_name)) {
		$school_code= $result_name['school_code'];
		$school_name= $result_name['school_name'];
		$answer=$result_name['answer'];
		$answer_time=$result_name['answer_time'];
			if(($M%2) == 0)
			$color="#FFFFB";
			else  	$color="#FFFFFF";
			
echo "<Tr bgcolor='$color' class='style1'><Td align='center'>$M</Td><Td align='center'>$school_code</Td><Td>$school_name</Td><Td align='center'>";
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

