<?php
//echo $_SESSION["login_group"];
// ส่วนป้องกันไม่ให้เรียกไฟล์ตรงๆ
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
if(!isset($_SESSION['login_user_id'])){ $_SESSION['login_user_id']=""; exit();
}else{
// กรณีเป็นผู้ใช้งานระดับ สพฐ.
if($_SESSION["login_group"]==1){

$login_user_id=mysqli_real_escape_string($connect,$_SESSION['login_user_id']);

//หาสิทธิ์
    $sql_user_permis="select * from book_permission where person_id=? ";
    $query_user_permis = $connect->prepare($sql_user_permis);
    $query_user_permis->bind_param("i", $login_user_id);
    $query_user_permis->execute();
    $result_quser_permis=$query_user_permis->get_result();
While ($result_user_permis = mysqli_fetch_array($result_quser_permis))
   {
    $user_permission_p1=$result_user_permis['p1'];
    $user_permission_p2=$result_user_permis['p2'];
    $user_permission_p3=$result_user_permis['p3'];
    $user_permission_p4=$result_user_permis['p4'];
    }
 if(!isset($user_permission_p1)){
$user_permission_p1="";
}
 if(!isset($user_permission_p2)){
$user_permission_p2="";
}
 if(!isset($user_permission_p3)){
$user_permission_p3="";
}
 if(!isset($user_permission_p4)){
$user_permission_p4="";
}
//echo " 555 ".$user_permission;
    
$message = "";
$count = "";
$alertmessage = "";
    
//เช็คสิทธิ์ก่อน สารบรรณกลาง สพฐ    
if($user_permission_p1 == 1){    
    $sql_saraban_index1="select count(book_main.ms_id) as count from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id and  book_sendto_answer.send_to='saraban' and book_sendto_answer.answer IS NULL";   

    $result_alert1 = mysqli_query($connect, $sql_saraban_index1);
    $row_alert1 = $result_alert1->fetch_assoc();

// ข้อความที่ต้องการแจ้งเตือน
if($row_alert1["count"]>0){
	$message = "หนังสือราชการไม่ได้ลงรับ(สพฐ.)";
	$count = $row_alert1["count"]+$count;
	$alertmessage = "<li><a href='?option=book&task=main/receive&saraban_index=1'><span class='glyphicon glyphicon-cloud-download' aria-hidden='true'></span>&nbsp;:&nbsp;".$message." <span class='badge progress-bar-danger'>".$row_alert1['count']."</span></a></li>";    
}
}

//เช็คสิทธิ์ก่อน สารบรรณสำนัก    
if($user_permission_p2 != 0 || $user_permission_p2 !="" ){    
    $sql_saraban_index2="select count(book_main.ms_id) as count from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id and  book_sendto_answer.send_to='$user_permission_p2' and book_sendto_answer.answer IS NULL  ";   

    $result_alert2 = mysqli_query($connect, $sql_saraban_index2);
    $row_alert2 = $result_alert2->fetch_assoc();

// ข้อความที่ต้องการแจ้งเตือน
if($row_alert2["count"]>0){
	$message = "หนังสือราชการไม่ได้ลงรับ(สำนัก)";
	$count = $row_alert2["count"]+$count;
    //$countshow = $count-$countshow ;
    //$countget = $count;
    $alertmessage .= "<li><a href='?option=book&task=main/receive&saraban_index=2'><span class='glyphicon glyphicon-cloud-download' aria-hidden='true'></span>&nbsp;:&nbsp;".$message." <span class='badge progress-bar-danger'>".$row_alert2['count']."</span></a></li>";    
}    
}

//เช็คสิทธิ์ก่อน สารบรรณกลุ่ม    
if($user_permission_p3 != 0 || $user_permission_p3 !="" ){    
    $sql_saraban_index3="select count(book_main.ms_id) as count from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id and  book_sendto_answer.send_to='$user_permission_p3' and book_sendto_answer.answer IS NULL  ";   

    $result_alert3 = mysqli_query($connect, $sql_saraban_index3);
    $row_alert3 = $result_alert3->fetch_assoc();

// ข้อความที่ต้องการแจ้งเตือน
if($row_alert3["count"]>0){
	$message = "หนังสือราชการไม่ได้ลงรับ(กลุ่ม)";
	$count = $row_alert3["count"]+$count;
    //$countshow = $count-$countshow ;
    $alertmessage .= "<li><a href='?option=book&task=main/receive&saraban_index=3'><span class='glyphicon glyphicon-cloud-download' aria-hidden='true'></span>&nbsp;:&nbsp;".$message." <span class='badge progress-bar-danger'>".$row_alert3['count']."</span></a></li>";    
}    
}

//เช็คสิทธิ์ก่อน สารบรรณบุคคล    
if($login_user_id != 0 || $login_user_id  !=""  ){    
    $sql_saraban_index4="select count(book_main.ms_id) as count from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id and  book_sendto_answer.send_to='$login_user_id' and book_sendto_answer.answer IS NULL  ";   

    $result_alert4 = mysqli_query($connect, $sql_saraban_index4);
    $row_alert4 = $result_alert4->fetch_assoc();

// ข้อความที่ต้องการแจ้งเตือน
if($row_alert4["count"]>0){
	$message = "หนังสือราชการไม่ได้ลงรับ(บุคคล)";
	$count = $row_alert4["count"]+$count;
    $alertmessage .= "<li><a href='?option=book&task=main/receive&saraban_index=4'><span class='glyphicon glyphicon-cloud-download' aria-hidden='true'></span>&nbsp;:&nbsp;".$message." <span class='badge progress-bar-danger'>".$row_alert4['count']."</span></a></li>";    
}    
}

}//ตรวจสอบ สพฐ.
    // กรณีเป็นผู้ใช้งานระดับ เขตพื้นที่
if($_SESSION["login_group"]==2){

$login_user_id=mysqli_real_escape_string($connect,$_SESSION['login_user_id']);

//หาสิทธิ์
    $sql_user_permis="select * from book_permission where person_id=? ";
    $query_user_permis = $connect->prepare($sql_user_permis);
    $query_user_permis->bind_param("i", $login_user_id);
    $query_user_permis->execute();
    $result_quser_permis=$query_user_permis->get_result();
While ($result_user_permis = mysqli_fetch_array($result_quser_permis))
   {
    $user_permission_p4=$result_user_permis['p4'];
    }
 if(!isset($user_permission_p4)){
$user_permission_p4="";
}
    
$message = "";
$count = "";
$alertmessage = "";
    
//เช็คสิทธิ์ก่อน สารบรรณกลาง เขตพื้นที่    
if($user_permission_p4 != 0 || $user_permission_p4 !="" ){    
    $sql_saraban_index4="select count(book_main.ms_id) as count from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id and  book_sendto_answer.send_to='$user_permission_p4' and book_sendto_answer.answer IS NULL";   

    $result_alert4 = mysqli_query($connect, $sql_saraban_index4);
    $row_alert4 = $result_alert4->fetch_assoc();

// ข้อความที่ต้องการแจ้งเตือน
if($row_alert4["count"]>0){
	$message = "หนังสือราชการไม่ได้ลงรับ";
	$count = $row_alert4["count"];
	$alertmessage = "<li><a href='?option=book&task=main/receive_in'><span class='glyphicon glyphicon-cloud-download' aria-hidden='true'></span>&nbsp;:&nbsp;".$message." <span class='badge progress-bar-danger'>".$row_alert4['count']."</span></a></li>";    
}
}
    
}//ตรวจสอบเขต
}//ตรวจสอบ Login
?>
