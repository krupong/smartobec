<?php
//บุคลากร
	$user=$_SESSION['login_user_id'];
	$sql_user="select * from person_main where person_id = '$user' ";		 //รหัสสำนัก 
	$dbquery_user = mysqli_query($connect,$sql_user);
	$ref_result_user = mysqli_fetch_array($dbquery_user);
 $department = $ref_result_user['department'];			//รหัสสำนัก
 $department_id = $ref_result_user['department'];			//รหัสสำนัก
 $sub_department = $ref_result_user['sub_department'];	  //รหัสกลุ่ม
 $sub_department_id = $ref_result_user['sub_department'];	  //รหัสกลุ่ม

?>