<?php
//ｺﾘ､ﾅﾒ｡ﾃ
	$user=$_SESSION['login_user_id'];
	$sql_user="select * from person_main where person_id = '$user' ";		 //ﾃﾋﾑﾊﾊﾓｹﾑ｡ 
	$dbquery_user = mysqli_query($connect,$sql_user);
	$ref_result_user = mysqli_fetch_array($dbquery_user);
 $department = $ref_result_user['department'];			//ﾃﾋﾑﾊﾊﾓｹﾑ｡
 $department_id = $ref_result_user['department'];			//ﾃﾋﾑﾊﾊﾓｹﾑ｡
 $sub_department = $ref_result_user['sub_department'];	  //ﾃﾋﾑﾊ｡ﾅﾘ霖
 $sub_department_id = $ref_result_user['sub_department'];	  //ﾃﾋﾑﾊ｡ﾅﾘ霖

	$user=$_SESSION['login_user_id'];
	$sql_user="select * from person_khet_main where person_id = '$user' ";		 //ﾃﾋﾑﾊﾊﾓｹﾑ｡ 
	$dbquery_user = mysqli_query($connect,$sql_user);
	$ref_result_user = mysqli_fetch_array($dbquery_user);
 $khet_code = $ref_result_user['khet_code'];			//ﾃﾋﾑﾊﾊﾓｹﾑ｡

?>