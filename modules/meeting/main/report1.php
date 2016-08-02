<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
$login_group=mysqli_real_escape_string($connect,$_SESSION['login_group']);
if(!($login_group<=1)){
exit();
}

require_once "modules/meeting/time_inc.php";
?>
<script type="text/javascript" src="./css/js/calendarDateInput.js"></script>
<?php

if(!isset($_SESSION['login_user_id'])){ $_SESSION['login_user_id']=""; exit();
}else{
//หาหน่วยงาน
$login_user_id=mysqli_real_escape_string($connect,$_SESSION['login_user_id']);
    $sql_user_depart="select * from person_main where person_id=? ";
    $query_user_depart = $connect->prepare($sql_user_depart);
    $query_user_depart->bind_param("i", $login_user_id);
    $query_user_depart->execute();
    $result_quser_depart=$query_user_depart->get_result();
While ($result_user_depart = mysqli_fetch_array($result_quser_depart))
   {
    $user_departid=$result_user_depart['department'];
    }
//หาชื่อหน่วยงาน
    $sql_depart_name="select * from system_department where department=? ";
    $query_depart_name = $connect->prepare($sql_depart_name);
    $query_depart_name->bind_param("i", $user_departid);
    $query_depart_name->execute();
    $result_qdepart_name=$query_depart_name->get_result();
While ($result_depart_name = mysqli_fetch_array($result_qdepart_name))
   {
    $user_department_name=$result_depart_name['department_name'];
    $user_department_precisname=$result_depart_name['department_precis'];
	}
}

//กรณีเลือกแสดงเฉพาะห้องประชุม
if(isset($_REQUEST['room_index'])){
$room_index=$_REQUEST['room_index'];
}else{
	$room_index = "";
	}
//ส่วนหัว
echo "<br />";

if(isset($_GET['index'])){
$getindex=mysqli_real_escape_string($connect,$_GET['index']);
}else {$getindex="";}

if(isset($_POST['index'])){
$postindex=mysqli_real_escape_string($connect,$_POST['index']);
}else {$postindex="";}

if(!(($getindex==1) or ($getindex==2) or ($getindex==11))){


if(isset($_POST['room_index'])){
$postroom_index=mysqli_real_escape_string($connect,$_POST['room_index']);
    if($postroom_index!=""){
    $showroom=" and meeting_main.room=$postroom_index ";
    $sql_room="select * from meeting_room where department=? and active='1'  order by id";
    $dbquery_room = $connect->prepare($sql_room);
    $dbquery_room->bind_param("i", $user_departid);
    $dbquery_room->execute();
    $result_qroom=$dbquery_room->get_result();
        While ($result_room = mysqli_fetch_array($result_qroom)){
 $room_name=$result_room['room_name'] ;
}
    $get_room="&room_index=$postroom_index";
    }else{$showroom="";$room_name="ทุกห้องประชุม"; $get_room="";}
}else {$postroom_index=""; $showroom=""; $room_name="ทุกห้องประชุม"; $get_room=""; }

echo "<table width='100%' border='0' align='center' >";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>รายงานสรุปผลการใช้งานห้องประชุมภายในสำนัก $room_name</strong></font><br><br></td></tr>";
echo "</table>";


$sql_join="select meeting_main.*, meeting_room.* ,meeting_main.id as id ,meeting_main.rec_date as rec_date from meeting_main left join meeting_room on meeting_main.room = meeting_room.room_code where meeting_room.department=? and meeting_main.approve='1' $showroom order by meeting_main.book_date_start desc,meeting_main.room,meeting_main.start_time ";

    $dbquery_join = $connect->prepare($sql_join);
    $dbquery_join->bind_param("i", $user_departid);
    $dbquery_join->execute();
    $result_joinroom=$dbquery_join->get_result();

//$dbquery = mysqli_query($connect,$sql);

echo  "<table width=95% border=0 align=center class='table table-hover table-bordered table-striped table-condensed'>";
echo "<tr><td>";
echo "<table width='100%'><tr><td align='right'>";

$sql_room="select * from meeting_room where department=? and active='1'  order by id";

    $dbquery_room = $connect->prepare($sql_room);
    $dbquery_room->bind_param("i", $user_departid);
    $dbquery_room->execute();
    $result_qroom=$dbquery_room->get_result();

//เพิ่มการเลือกสถานะ
echo "<form  name='frm1'>";

echo "&nbsp;<Select  name='room_index' size='1' class='selectpicker'>";
echo "<option value ='' >ทุกห้องประชุม</option>" ;
While ($result_room = mysqli_fetch_array($result_qroom)){
 echo "<option value =$result_room[room_code] >$result_room[room_name]</option>" ;
}
echo "</select>";
echo "&nbsp;<INPUT TYPE='button' name='smb' class='btn btn-info' value='เลือก'  onclick='goto_url2(1)'>";
echo "</form>";


echo "</td></tr></table>";

echo "</td></Tr>";



//ตารางเดือน
    $year=date('Y');
    $month = array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
    $iCount = count($month);
    for($i = 0; $i<$iCount; $i++) {
      $count_month[$i]="";
    }
While ($result = mysqli_fetch_array($result_joinroom)){
 		$book_date_start = $result['book_date_start'];
		$book_date_end = $result['book_date_end'];

//คำนวณวันที่จอง
     $k=1;
    $j=1;
    $iCount = count($month);
    for($i = 0; $i<$iCount; $i++) {

        $monthstart[$i]=$year."-".sprintf('%02d', $k)."-01";
        $monthend[$i]=$year."-".sprintf('%02d', $k)."-31";


        //นับสถิติรายเดือน
        if(($book_date_start >= $monthstart[$i] and $book_date_start <= $monthend[$i]) and ($book_date_end >= $monthstart[$i] and $book_date_end <= $monthend[$i])  ){
        $count_month[$i]=$count_month[$i]+1;   }

        $k++;
        if($j==1){$j=31;}else{$j=1;}



    }


}
echo "<Tr><Td align='center'>";
echo "<table width=100% border=0 align=center class='table table-hover table-bordered table-striped table-condensed'>";
//แสดงผลรายเดือน
//foreach ($month AS $monthshow)
    for($i = 0; $i<$iCount; $i++) {
//   {
    echo "<tr><td width='40%' align='right'>$month[$i] : </td><td align='left'>".$count_month[$i];
    if($count_month[$i]=="" or $count_month[$i]==0){ echo "";
                                                    } else{
    echo " ครั้ง [<a href='?option=meeting&task=main/report2$get_room&start_date=$monthstart[$i]&end_date=$monthend[$i]' target='_blank'>รายละเอียดการใช้งาน</a>]  ";
    }
    echo "</td></tr>";
     }

echo "</table></td></tr>";

echo "</Table>";
}

?>
<script>
function goto_url2(val){
callfrm("?option=meeting&task=main/report1");
}
</script>

<SCRIPT language=JavaScript>
function check_number() {
e_k=event.keyCode
//if (((e_k < 48) || (e_k > 57)) && e_k != 46 ) {
if (e_k != 13 && (e_k < 48) || (e_k > 57)) {
event.returnValue = false;
alert("ต้องเป็นตัวเลขเท่านั้น... \nกรุณาตรวจสอบข้อมูลของท่านอีกครั้ง...");
}
}
</script>
