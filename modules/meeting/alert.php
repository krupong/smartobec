<?php

// ส่วนป้องกันไม่ให้เรียกไฟล์ตรงๆ
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
if(!isset($_SESSION['login_user_id'])){ $_SESSION['login_user_id']=""; exit();
}else{
// กรณีเป็นผู้ใช้งานระดับ สพฐ.
if($_SESSION["login_group"]==1){

$login_user_id=mysqli_real_escape_string($connect,$_SESSION['login_user_id']);

//หาสิทธิ์
    $sql_user_permis="select * from meeting_permission where person_id=? ";
    $query_user_permis = $connect->prepare($sql_user_permis);
    $query_user_permis->bind_param("i", $login_user_id);
    $query_user_permis->execute();
    $result_quser_permis=$query_user_permis->get_result();
While ($result_user_permis = mysqli_fetch_array($result_quser_permis))
   {
    $user_permission=$result_user_permis['p1'];
    }
 if(!isset($user_permission)){
$user_permission="";
}
//echo " 555 ".$user_permission;
if($user_permission==1){

//หาหน่วยงาน
    $sql_user_depart="select * from person_main where person_id=? ";
    $query_user_depart = $connect->prepare($sql_user_depart);
    $query_user_depart->bind_param("i", $login_user_id);
    $query_user_depart->execute();
    $result_quser_depart=$query_user_depart->get_result();
While ($result_user_depart = mysqli_fetch_array($result_quser_depart))
   {
    $user_departid=$result_user_depart['department'];
    }

// ส่วนในการตรวจสอบงานค้าง
$sql_alert = "  SELECT
            		count(*) as count
          		from meeting_main left join meeting_room on meeting_main.room = meeting_room.room_code where meeting_room.department=$user_departid and meeting_main.approve=0
                    ";
//echo $sql_alert;
$result_alert = mysqli_query($connect, $sql_alert);
$row_alert = $result_alert->fetch_assoc();

// ข้อความที่ต้องการแจ้งเตือน
$message = "";
$count = "";
$alertmessage = "";
if($row_alert["count"]>0){
	$message = "รายการจองห้องประชุม ";
	$count = $row_alert["count"];
	$alertmessage = "<li><a href='?option=meeting&task=main/officer'><span class='glyphicon glyphicon-lamp' aria-hidden='true'></span>&nbsp;:&nbsp;".$message." <span class='badge progress-bar-danger'>".$count."</span></a></li>";
}//แสดงผลการนับ

}else{ //ตรวจสอบมีสิทธิ์
    $message="";
    $count="";
    $alertmessage="";
     }

}//ตรวจสอบ สพฐ.
}//ตรวจสอบ Login
?>
