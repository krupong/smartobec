<?php

// ส่วนป้องกันไม่ให้เรียกไฟล์ตรงๆ
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
if(!isset($_SESSION['login_user_id'])){ $_SESSION['login_user_id']=""; exit();
}else{
// กรณีเป็นผู้ใช้งานระดับ สพฐ.
if($_SESSION["login_group"]==1){

$login_user_id=mysqli_real_escape_string($connect,$_SESSION['login_user_id']);
//หาสิทธิ์
    $sql_user_permis="select * from car_permission where person_id=? ";
    $query_user_permis = $connect->prepare($sql_user_permis);
    $query_user_permis->bind_param("i", $login_user_id);
    $query_user_permis->execute();
    $result_quser_permis=$query_user_permis->get_result();
    While ($result_user_permis = mysqli_fetch_array($result_quser_permis)){
        $user_permission=$result_user_permis['p1'];
    }
 if(!isset($user_permission))   $user_permission="";


if($user_permission==1 or $user_permission==3 or $iscommander==$login_dep){
// ส่วนในการตรวจสอบงานค้าง
$sql_alert = "  SELECT
            		count(a.id) as count
          		from car_main a left outer join person_main b on a.person_id=b.person_id";
    if($user_permission==1){
        $sql_alert=$sql_alert." where commander_grant=1";
        $subm="&from=altclk";
    }else if($iscommander==$login_dep){  // ผอ กลุ่ม
        $sql_alert=$sql_alert." where b.sub_department=$login_dep and a.commander_grant=0";
        $subm="&subm=car_commander";
    }
$result_alert = mysqli_query($connect, $sql_alert);
$row_alert = $result_alert->fetch_assoc();

// ข้อความที่ต้องการแจ้งเตือน
$message = "";
$count = "";
$alertmessage = "";
if($row_alert["count"]>0){
	$message = "ยานพาหนะรอการอนุมัติ ";
	$count = $row_alert["count"];
	$alertmessage = "<li><a href='?option=car&task=car_officer$subm'><span class='glyphicon glyphicon-road' aria-hidden='true'></span>&nbsp;:&nbsp;".$message." <span class='badge progress-bar-danger'>".$count."</span></a></li>";
}//แสดงผลการนับ

}
else{ //ตรวจสอบมีสิทธิ์
    $message="";
    $count="";
    $alertmessage="";
     }

}//ตรวจสอบ สพฐ.
}//ตรวจสอบ Login
?>
