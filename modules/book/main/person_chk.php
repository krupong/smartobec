<?php
//�ؤ�ҡ�
	$user=$_SESSION['login_user_id'];
	$sql_user="select * from person_main where person_id = '$user' ";		 //�����ӹѡ 
	$dbquery_user = mysqli_query($connect,$sql_user);
	$ref_result_user = mysqli_fetch_array($dbquery_user);
 $department = $ref_result_user['department'];			//�����ӹѡ
 $department_id = $ref_result_user['department'];			//�����ӹѡ
 $sub_department = $ref_result_user['sub_department'];	  //���ʡ����
 $sub_department_id = $ref_result_user['sub_department'];	  //���ʡ����

	$user=$_SESSION['login_user_id'];
	$sql_user="select * from person_khet_main where person_id = '$user' ";		 //�����ӹѡ 
	$dbquery_user = mysqli_query($connect,$sql_user);
	$ref_result_user = mysqli_fetch_array($dbquery_user);
 $khet_code = $ref_result_user['khet_code'];			//�����ӹѡ

?>