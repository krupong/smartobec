<?php
header("Content-Type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="receive_all.xls"');# ชื่อไฟล์ 
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
require_once "../../../database_connect.php";	
require_once "../time_inc.php";	

//อาเรย์กลุ่ม
$sql_department = "select  * from system_department  order by department_order";
$dbquery_department = mysqli_query($connect,$sql_department);
While ($result_department = mysqli_fetch_array($dbquery_department))
   {
		$department = $result_department['department'];
		$department_name = $result_department['department_name'];
		$department_ar[$department]=$department_name;
	}

//อาเรย์บุคลากรกลุ่ม
$sql_person= "select  * from person_main";
$dbquery_person= mysqli_query($connect,$sql_person);
While ($result_person = mysqli_fetch_array($dbquery_person))
   {
		$person_id = $result_person['person_id'];
		$person_prename = $result_person['prename'];
		$person_name = $result_person['name'];
		$person_surname = $result_person['surname'];
		$pname = "$person_prename$person_name  $person_surname";
		$personname_ar[$person_id]=$pname;
		
	}

//การเปิดใช้งานทะเบียน
$sql_start="select * from bookregister_year where year_active='1' and school_code is null ";
$query_start=mysqli_query($connect,$sql_start);
$result_start=mysqli_fetch_array($query_start);

$sql = "select * from  system_department order by department_order";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)){
$department_ar[$result['department']]=$result['department_name'];
}

$register_date = $_POST['date_value'];  //วันที่ 
$register_date2 = $_POST['date_value2'];  //วันที่ 
$department_id = $_GET['department'];  //สำนัก
$sub_department_id = $_GET['sub_department'];  //กลุ่ม

//$register_date = "2016-01-05";
if ($department_id == '' and $sub_department_id == ''){  //สารบรรณกลาง
$sql="select * from bookregister_receive where register_date BETWEEN '$register_date'  and '$register_date2' order by ms_id ";
}
if ($department_id > '' and $sub_department_id == ''){  //สารบรรณสำนัก
$sql="select * from bookregister_receive where register_date BETWEEN '$register_date'  and '$register_date2' and department='$department_id' order by ms_id ";
}
if ($department_id == '' and $sub_department_id > ''){  //สารบรรณกลุ่ม
$sql="select * from bookregister_receive where register_date BETWEEN '$register_date'  and '$register_date2' and sub_department='$sub_department_id' order by ms_id ";
}


$dbquery = mysqli_query($connect,$sql);
echo "<table border='1'>";
?>
				<tr bgcolor="#FFCCCC">
					<td align="center">
					<font size="2" face="Tahoma">ลำดับที่</font></td>
					<td align="center">
					<font size="2" face="Tahoma">เลขทะเบียนรับ</font></td>
					<td align="center">
					<font size="2" face="Tahoma">ปี</font></td>
					<td align="center">
					<font face="Tahoma" size="2">ที่</font></td>
					<td align="center">
					<font face="Tahoma" size="2">ลงวันที่</font></td>
					<td align="center">
					<font face="Tahoma" size="2">จาก</font></td>
					<td align="center">
					<font face="Tahoma" size="2">ถึง</font></td>
					<td align="center">
					<font face="Tahoma" size="2">เรื่อง</font></td>
					<td align="center">
					<font face="Tahoma" size="2">วันลงทะเบียน</font></td>
					<td align="center">
					<font face="Tahoma" size="2">หมายเหตุ</font></td>
					<td align="center">
					<font face="Tahoma" size="2">สำนัก</font></td>
					<td align="center">
					<font face="Tahoma" size="2">ผู้ปฏิบัติ</font></td>
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
		$book_from = $result['book_from'];
		$book_to = $result['book_to'];
		$subject = $result['subject'];
		$comment = $result['comment'];
		$group = $result['department'];
		$register_date = $result['register_date'];
		
$signdate=thai_date_3($signdate);
$register_date=thai_date_3($register_date);
		
		echo "<Tr><Td align='center'>$N</Td><Td align='center'>$register_number</Td><Td align='center'>$year</Td><Td align='left'>$book_no</Td><Td align='left'>$signdate</Td><Td align='left'>$book_from</Td>";
		echo "<Td align='left'>";
		if(isset($department_ar[$book_to])){
					echo $department_ar[$book_to];
					}
					//$book_to
		echo "</Td><Td align='left'>$subject</Td><Td align='left'>$register_date</Td><Td align='left'>$comment </Td>";
echo "<Td align='left'>";
if(isset($department_ar[$group])){
echo $department_ar[$group];
}
echo "</Td>";
echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></Tr>";
$N++;
	}
echo "</Table>";
?>
</BODY>
</HTML>
