<?php

// ส่วนป้องกันไม่ให้เรียกไฟล์ตรงๆ
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

// ส่วนในการตรวจสอบงานค้ง
if(!isset($_SESSION['login_user_id'])) { $_SESSION['login_user_id']=''; }
$sqluser = "SELECT * FROM person_main WHERE person_id = '$_SESSION[login_user_id]'";
if($resultuser = mysqli_query($connect, $sqluser)) {
  $rowuser = $resultuser->fetch_assoc();
  $user_positionid = $rowuser["position_code"];
  $user_position_other_code = $rowuser["position_other_code"];
  $user_subdepartment = $rowuser["sub_department"];
  $user_department = $rowuser["department"];
}else{
  $user_positionid = "";
  $user_position_other_code = "";
  $user_subdepartment = "";
  $user_department = "";
}
// เจ้าหน้าที่
$sqlpass = "consult_personid = '".$_SESSION['login_user_id']."' ";
$receive_booklevelid = 1;
// หัวหน้ากลุ่มงาน
if($user_position_other_code>0){
  $sqlpass = "((ioffice_book.booklevelid = 1) or (ioffice_book.booktypeid = 2)) and post_subdepartmentid = ".$user_subdepartment." and receive_booklevelid >= 2 ";
  $receive_booklevelid = 2;
}
// ผอ.สำนัก
if($user_positionid==9){
  $sqlpass = "((ioffice_book.booklevelid = 2) or (ioffice_book.booktypeid = 2)) and post_departmentid = ".$user_department." and  receive_booklevelid >= 3 ";
  $receive_booklevelid = 3;
}
// รองเลขา
if($user_positionid==2){ 
  $receive_booklevelid = 4;
  if(!isset($_SESSION["system_delegate"])){ $_SESSION["system_delegate"]=""; }
  if($_SESSION["system_delegate"]==1) { 
    // กรณีรักษาราชการแทน
    $sqlpass = "((ioffice_book.booklevelid = 3) or (ioffice_book.booklevelid = 4) or (ioffice_book.booktypeid = 2)) and post_departmentid IN(SELECT departmentid FROM ioffice_bookpass WHERE personid = '".$_SESSION['login_user_id']."') and  receive_booklevelid >= 4 ";
  }else{
    // กรณีปกติ
    $sqlpass = "((ioffice_book.booklevelid = 3) or (ioffice_book.booktypeid = 2)) and post_departmentid IN(SELECT departmentid FROM ioffice_bookpass WHERE personid = '".$_SESSION['login_user_id']."') and  receive_booklevelid >= 4 ";
  }
}
// เลขา
if($user_positionid==1){
  $receive_booklevelid = 5;
  $sqlpass = "((ioffice_book.booklevelid = 4) or (ioffice_book.booktypeid = 2)) and  receive_booklevelid >= 5 ";
}
// Select Book
$sql_alert = "  SELECT 
            		count(*) as count  
          		FROM
            		ioffice_book
            		LEFT JOIN ioffice_bookstatus ON ioffice_book.bookstatusid = ioffice_bookstatus.bookstatusid
            		LEFT JOIN ioffice_booktype ON ioffice_book.booktypeid = ioffice_booktype.booktypeid
            		LEFT JOIN person_main pm1 ON ioffice_book.post_personid = pm1.person_id 
            		LEFT JOIN system_department sd1 ON sd1.department = ioffice_book.post_departmentid 
            		LEFT JOIN system_subdepartment ON system_subdepartment.sub_department = ioffice_book.post_subdepartmentid 
            		LEFT JOIN ioffice_booklevel ibl ON ioffice_book.receive_booklevelid = ibl.booklevelid 
          		WHERE 
          			((ioffice_book.bookstatusid = 2) or (ioffice_book.bookstatusid = 4)) and
                	$sqlpass";
//echo $sql_alert;
$result_alert = mysqli_query($connect, $sql_alert);
$row_alert = $result_alert->fetch_assoc();

// ข้อความที่ต้องการแจ้งเตือน
$message = "";
$count = "";
$alertmessage = "";
if($row_alert["count"]>0){
	$message = "บันทึกเสนอรอลงความเห็น/สั่งการ ";
	$count = $row_alert["count"];
	$alertmessage = "<li><a href='?option=ioffice&task=book_pass'>".$message." <span class='badge progress-bar-danger'>".$row_alert["count"]."</span></a></li>";
}

?>