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


//แสดงวันนี้
$today_date = date("Y-m-d");

// ส่วนในการตรวจสอบงานค้ง
$sql_alert = "  SELECT
            		count(work_main.id) as countid
          		from person_main left join work_main on person_main.person_id = work_main.person_id where work_main.work_date='$today_date' and person_main.department=$user_departid ";
//echo $sql_alert;
$result_alert = mysqli_query($connect, $sql_alert);
$row_alert = $result_alert->fetch_assoc();

// ข้อความที่ต้องการแจ้งเตือน
$message = "";
$count = "";
$alertmessage = "";
if($row_alert["countid"]==0){
	$message = "บันทึกการมาปฏิบัติราชการวันนี้";
	$count = 1;

	$alertmessage = "<li><a href='?option=work&task=check'><span class='glyphicon glyphicon-time' aria-hidden='true'></span>&nbsp;:&nbsp;".$message." <span class='badge progress-bar-danger'>".$count."</span></a></li>";
}//แสดงผลการนับ

}else{ //ตรวจสอบมีสิทธิ์
    $message="";
    $count="";
    $alertmessage="";
     }

}//ตรวจสอบ สพฐ.
}//ตรวจสอบ Login
?>
