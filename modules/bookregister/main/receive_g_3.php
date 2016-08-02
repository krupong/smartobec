<?php
		date_default_timezone_set('Asia/Bangkok');
		require_once "../../../database_connect.php";	
		require_once("../../../mainfile.php");

//นำเข้าข้อมูลบุคลากร
require_once("person_chk.php");	

//เลขทะเบียน  กลุ่ม
$sql_start_g="select * from bookregister_year where year_active='1' and sub_department = '$sub_department' ";
//$sql_start="select * from bookregister_year where year_active='1' and school_code is null";
$query_start_g=mysqli_query($connect,$sql_start_g);
$result_start_g=mysqli_fetch_array($query_start_g);

$sql_number_g="select  max(register_number_g) as number_max from bookregister_receive where year='$result_start_g[year]' and sub_department = '$sub_department' ";
$query_number_g=mysqli_query($connect,$sql_number_g);
$result_number_g=mysqli_fetch_array($query_number_g);

if($result_number_g['number_max']<$result_start_g['start_receive_num']){
$register_number_g=$result_start_g['start_receive_num'];
}
else{
$register_number_g=$result_number_g['number_max']+1;
}

		$sql = "update bookregister_receive set register_number_g=$register_number_g, book_no='$_POST[book_no]', signdate='$_POST[signdate]', book_from='$_POST[book_from]', book_to='$_POST[book_to]', subject='$_POST[subject]', sub_department='$_POST[group]', operation='$_POST[operation]', comment='$_POST[comment]' where ms_id='$_POST[id]' ";
		$dbquery = mysqli_query($connect,$sql);
		
		echo $sql;

		echo" <center><h2>บันทึกข้อมูลเรียบร้อย</h2> <br> <input type=\"button\" value=\"กลับหน้าหลัก\" onClick=\"window.location='?option=bookregister&task=main/receive_g&page=$_REQUEST[page]'\"></center> ";
	 mysql_close ( );
	

?>