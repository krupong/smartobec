<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
$login_group=mysqli_real_escape_string($connect,$_SESSION['login_group']);
if(!($login_group<=1)){
exit();
}

require_once "modules/meeting/time_inc.php";
?>
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

//ส่วนหัว

if(isset($_GET['index'])){
$getindex=mysqli_real_escape_string($connect,$_GET['index']);
}else {$getindex="";}

if(isset($_POST['index'])){
$postindex=mysqli_real_escape_string($connect,$_POST['index']);
}else {$postindex="";}

if(!($getindex==1)){

echo "<table width='100%' border='0' align='center' >";
echo "<tr align='center'><td><font color='#006666'><h2><strong>ค้นหาห้องประชุมว่าง</strong></h2></font></td></tr>";
echo "</table>";
}

//แสดงผลวันที่
$today = date("d/m/Y");
if(isset($_POST['search_date_start'])){
$search_date_starto=mysqli_real_escape_string($connect,$_POST['search_date_start']);
    $search_date_start=explode("/", $search_date_starto);
    $search_date_start=$search_date_start[2]."-".$search_date_start[1]."-".$search_date_start[0];  //ปี เดือน วัน
}else {$search_date_start="";
      $search_date_starto=$today;
      }
if(isset($_POST['search_date_end'])){
$search_date_endo=mysqli_real_escape_string($connect,$_POST['search_date_end']);
    $search_date_end=explode("/", $search_date_endo);
    $search_date_end=$search_date_end[2]."-".$search_date_end[1]."-".$search_date_end[0];  //ปี เดือน วัน
}else {$search_date_end="";
      $search_date_endo=$today;
      }


//ส่วนแสดงผล
if(!($getindex==1)){
echo "<form id='frm1' name='frm1' action='?option=meeting&task=main/search' method='POST' onSubmit='JavaScript:return goto_url(1);'>";

echo "<table width=95% border=0 align=center class='table table-hover table-bordered table-striped table-condensed'>";
echo "<Tr><Td align='center'><table ><tr><td>เลือกวันที่ที่ต้องการค้นหา &nbsp;&nbsp;</td><td>";
?>
<div class="input-daterange input-group" id="datepicker">
    <input type="text" class="input-sm form-control" name="search_date_start" id="search_date_start" placeholder="วันที่เริ่มต้น" />
    <span class="input-group-addon"> ถึงวันที่ </span>
    <input type="text" class="input-sm form-control" name="search_date_end" id="search_date_end" placeholder="วันที่สิ้นสุด" />
</div>
<?php    
//echo "<input class='form-control' type='text' name='search_date_start' id='search_date_start' data-provide='datepicker' data-date-language='th' value='$search_date_starto'  Size='10'>";
//echo "</td><td>&nbsp;&nbsp;&nbsp; ถึงวันที่ &nbsp;&nbsp;&nbsp;</td><td>";
//echo "<input class='form-control' type='text' name='search_date_end' id='search_date_end' data-provide='datepicker' data-date-language='th' value='$search_date_endo' Size='10'>";
echo "</td>";
echo "<Input Type=Hidden Name='index' Value='1'>";
   
echo "<td> &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<INPUT TYPE='submit' class='btn btn-primary' name='smb' value='ค้นหา' ></td>";
echo "</tr></table></Td></tr>";


echo "</Table></form>";
}


//ส่วนฟอร์มรับข้อมูล
if($postindex==1){
    
//แสดงห้องประชุมในสำนัก
echo "<table width='100%' border='0' align='center' >";
echo "<tr><td align='left'><H3><strong>ห้องประชุมในสำนัก</strong></H3></td></tr><tr><td>";
    $sql_roomdepart="select * from meeting_room where department=? and active=1 order by room_code";
    $dbquery_roomdepart = $connect->prepare($sql_roomdepart);
    $dbquery_roomdepart->bind_param("i", $user_departid);
    $dbquery_roomdepart->execute();
    $result_meetroomdepart=$dbquery_roomdepart->get_result();
 While ($result_roomdepart = mysqli_fetch_array($result_meetroomdepart))
{
    $room_code=$result_roomdepart["room_code"];
    $room_name=$result_roomdepart["room_name"];
    $room_depart=$result_roomdepart["department"];

    //แสดงห้องประชุมที่มีการใช้งาน
    echo "<table class='table table-hover table-bordered table-striped table-condensed'>";
    echo "<tr><td align='left' width='100'>"
    ?>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal<?php echo $result_roomdepart["room_code"]; ?>">รายละเอียด</button>
    <?php
    echo    "</td><td align='left'><h4><strong>ห้องประชุม $room_name</strong></h4></td>";

 //หาชื่อหน่วยงาน
    $sql_depart_name="select * from system_department where department=? ";
    $query_depart_name = $connect->prepare($sql_depart_name);
    $query_depart_name->bind_param("i", $room_depart);
    $query_depart_name->execute();
    $result_qdepart_name=$query_depart_name->get_result();
While ($result_depart_name = mysqli_fetch_array($result_qdepart_name))
   {
    $user_department_name=$result_depart_name['department_name'];
    $user_department_precisname=$result_depart_name['department_precis'];
	}

?>


                      <div class="modal fade bs-example-modal-lg" id="myModal<?php echo $result_roomdepart["room_code"]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title" id="myModalLabel">ห้องประชุม <?php echo $room_name." (".$user_department_precisname.")"; ?></h4>
                            </div>
                            <div class="modal-body">
                              <a href="#" class="btn btn-warning">จำนวนที่นั่ง&nbsp;:&nbsp;<?php echo $result_roomdepart["person_max"]; ?> คน</a>
                            <h4>รายละเอียดอื่นๆ :</h4>
                              <?php echo $result_roomdepart["room_detail"]; ?>

                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span>&nbsp;ปิด</button>
                            </div>
                          </div>
                        </div>
                      </div>

 <?php
    echo "</td></tr>";
    echo "<tr><td colspan='2'><table class='table table-hover table-bordered table-striped table-condensed'>";

    //แสดงรายการที่มีการจอง
    $sql_roombook="select * from meeting_main where room=?  and ((book_date_start between ? and ?) or (book_date_end between ? and ? )) and (approve=1 or approve=0) order by room,book_date_start,start_time,rec_date";
    $dbquery_roombook = $connect->prepare($sql_roombook);
    $dbquery_roombook->bind_param("issss", $room_code,$search_date_start,$search_date_end,$search_date_start,$search_date_end);
    $dbquery_roombook->execute();
    $result_qroombook=$dbquery_roombook->get_result();
    $numroombook = mysqli_num_rows($result_qroombook);
     if($numroombook>0){
     While ($result_roombook = mysqli_fetch_array($result_qroombook))
     {
        if($result_roombook["id"]!=""){

		$start_time=$result_roombook['start_time'];
		$start_time=number_format($start_time,2);
		$finish_time=$result_roombook['finish_time'];
		$finish_time=number_format($finish_time,2);
		$book_date_start = $result_roombook['book_date_start'];
		$book_date_end = $result_roombook['book_date_end'];
		$rec_date = $result_roombook['rec_date'];
        $coordinator = $result_roombook['coordinator'];
		$chairman = $result_roombook['chairman'];
		$person_num = $result_roombook['person_num'];
		$book_person = $result_roombook['book_person'];
		$user_book = $result_roombook['user_book'];
		$other = $result_roombook['other'];
		$rec_date = $result_roombook['rec_date'];
        $approve = $result_roombook['approve'];
        $officer = $result_roombook['officer'];
        $officer_date = $result_roombook['officer_date'];
        $reason = $result_roombook['reason'];
        $objective = $result_roombook['objective'];

    //หาชื่อผู้จอง
    $sql_person="select * from person_main where  status='0' and person_id=? ";

    $dbquery_person = $connect->prepare($sql_person);
    $dbquery_person->bind_param("i", $user_book);
    $dbquery_person->execute();
    $result_qperson=$dbquery_person->get_result();
 While ($result_person = mysqli_fetch_array($result_qperson))
{
     $name=$result_person['name'];
     $surname=$result_person['surname'];
     $department=$result_person['department'];
}
    //แสดงชื่อหน่วยงาน
    $sql_depart="select * from system_department where department=? ";
    $dbquery_depart = $connect->prepare($sql_depart);
    $dbquery_depart->bind_param("i", $department);
    $dbquery_depart->execute();
    $result_qdepart=$dbquery_depart->get_result();
 While ($result_depart = mysqli_fetch_array($result_qdepart))
{
     $department_name=$result_depart['department_name'];
     $department_precis=$result_depart['department_precis'];
 }

     if($approve==1){
         $showstatus="อนุญาตแล้ว";
     }else if($approve==2){
        $showstatus="<font color='red'>ไม่อนุญาต</font>";
     }else{
        $showstatus="<font color='blue'>รอการอนุญาต</font>";
     }

    echo "<tr><td>วันที่ ".thai_date_3($book_date_start)." ถึง ".thai_date_3($book_date_end)."</td>";
    echo "<td>เวลา : $start_time น. - $finish_time น.</td>";
    echo "<td>ผู้จอง : $name $surname($department_precis)</td>";
    echo "<td>สถานะ : $showstatus</td>";
   echo "<td>ผู้เข้าประชุม : $person_num คน</td>";
    echo "</tr>";
    echo "<tr><td align='left' colspan='5'>เรื่อง : ($chairman)$objective</td></tr>";
    echo "<tr><td align='left' colspan='5' height='1px' ></td></tr>";
    echo "<tr><td align='left' colspan='5' height='1px' ></td></tr>";
     }//แสดงรายการที่มีการจอง
    }
     }else{ //ตรวจสอบมีการจองห้องหรือไม่
            echo " - ว่าง - ";
        }

    echo "</table></td></tr></table>";


 }//ห้องประชุมของสำนัก

echo "<br><br><br>";
//แสดงห้องประชุมต่างสำนัก
echo "<table width='100%' border='0' align='center' >";
echo "<tr><td align='left'><H3><strong>ห้องประชุมต่างสำนัก</strong></H3></td></tr><tr><td>";
    $sql_roomdepart="select * from meeting_room where department!=? and active=1 order by room_code";
    $dbquery_roomdepart = $connect->prepare($sql_roomdepart);
    $dbquery_roomdepart->bind_param("i", $user_departid);
    $dbquery_roomdepart->execute();
    $result_meetroomdepart=$dbquery_roomdepart->get_result();
 While ($result_roomdepart = mysqli_fetch_array($result_meetroomdepart))
{
    $room_code=$result_roomdepart["room_code"];
    $room_name=$result_roomdepart["room_name"];
    $room_depart=$result_roomdepart["department"];

    //แสดงห้องประชุมที่มีการใช้งาน
    echo "<table class='table table-hover table-bordered table-striped table-condensed'>";
    echo "<tr><td align='left' width='100'>"
    ?>
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal<?php echo $result_roomdepart["room_code"]; ?>">รายละเอียด</button>
    <?php
    echo    "</td><td align='left'><h4><strong>ห้องประชุม $room_name</strong></h4></td>";

 //หาชื่อหน่วยงาน
    $sql_depart_name="select * from system_department where department=? ";
    $query_depart_name = $connect->prepare($sql_depart_name);
    $query_depart_name->bind_param("i", $room_depart);
    $query_depart_name->execute();
    $result_qdepart_name=$query_depart_name->get_result();
While ($result_depart_name = mysqli_fetch_array($result_qdepart_name))
   {
    $user_department_name=$result_depart_name['department_name'];
    $user_department_precisname=$result_depart_name['department_precis'];
	}

?>
                      <div class="modal fade bs-example-modal-lg" id="myModal<?php echo $result_roomdepart["room_code"]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title" id="myModalLabel">ห้องประชุม <?php echo $room_name." (".$user_department_precisname.")"; ?></h4>
                            </div>
                            <div class="modal-body">
                              <a href="#" class="btn btn-warning">จำนวนที่นั่ง&nbsp;:&nbsp;<?php echo $result_roomdepart["person_max"]; ?> คน</a>
                            <h4>รายละเอียดอื่นๆ :</h4>
                              <?php echo $result_roomdepart["room_detail"]; ?>

                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span>&nbsp;ปิด</button>
                            </div>
                          </div>
                        </div>
                      </div>

<?php
    //แสดงห้องประชุมที่มีการใช้งาน
     echo "</td></tr>";
     echo "<tr><td colspan='2'><table class='table table-hover table-bordered table-striped table-condensed'>";

    //แสดงรายการที่มีการจอง
    $sql_roombook="select * from meeting_main where room=?  and ((book_date_start between ? and ?) or (book_date_end between ? and ? )) and (approve=1 or approve=0) order by room,book_date_start,start_time,rec_date";
    $dbquery_roombook = $connect->prepare($sql_roombook);
    $dbquery_roombook->bind_param("issss", $room_code,$search_date_start,$search_date_end,$search_date_start,$search_date_end);
    $dbquery_roombook->execute();
    $result_qroombook=$dbquery_roombook->get_result();
    $numroombook = mysqli_num_rows($result_qroombook);
     if($numroombook>0){
     While ($result_roombook = mysqli_fetch_array($result_qroombook))
     {
        if($result_roombook["id"]!=""){

		$start_time=$result_roombook['start_time'];
		$start_time=number_format($start_time,2);
		$finish_time=$result_roombook['finish_time'];
		$finish_time=number_format($finish_time,2);
		$book_date_start = $result_roombook['book_date_start'];
		$book_date_end = $result_roombook['book_date_end'];
		$rec_date = $result_roombook['rec_date'];
        $coordinator = $result_roombook['coordinator'];
		$chairman = $result_roombook['chairman'];
		$person_num = $result_roombook['person_num'];
		$book_person = $result_roombook['book_person'];
		$user_book = $result_roombook['user_book'];
		$other = $result_roombook['other'];
		$rec_date = $result_roombook['rec_date'];
        $approve = $result_roombook['approve'];
        $officer = $result_roombook['officer'];
        $officer_date = $result_roombook['officer_date'];
        $reason = $result_roombook['reason'];
        $objective = $result_roombook['objective'];

    //หาชื่อผู้จอง
    $sql_person="select * from person_main where  status='0' and person_id=? ";

    $dbquery_person = $connect->prepare($sql_person);
    $dbquery_person->bind_param("i", $user_book);
    $dbquery_person->execute();
    $result_qperson=$dbquery_person->get_result();
 While ($result_person = mysqli_fetch_array($result_qperson))
{
     $name=$result_person['name'];
     $surname=$result_person['surname'];
     $department=$result_person['department'];
}
    //แสดงชื่อหน่วยงาน
    $sql_depart="select * from system_department where department=? ";
    $dbquery_depart = $connect->prepare($sql_depart);
    $dbquery_depart->bind_param("i", $department);
    $dbquery_depart->execute();
    $result_qdepart=$dbquery_depart->get_result();
 While ($result_depart = mysqli_fetch_array($result_qdepart))
{
     $department_name=$result_depart['department_name'];
      $department_precis=$result_depart['department_precis'];
}

     if($approve==1){
         $showstatus="อนุญาตแล้ว";
     }else if($approve==2){
        $showstatus="<font color='red'>ไม่อนุญาต</font>";
     }else{
        $showstatus="<font color='blue'>รอการอนุญาต</font>";
     }

    echo "<tr><td>วันที่ ".thai_date_3($book_date_start)." ถึง ".thai_date_3($book_date_end)."</td>";
    echo "<td>เวลา : $start_time น. - $finish_time น.</td>";
    echo "<td>ผู้จอง : $name $surname($department_precis)</td>";
    echo "<td>สถานะ : $showstatus</td>";
    echo "<td>ผู้เข้าประชุม : $person_num คน</td>";
    echo "</tr>";
    echo "<tr><td align='left' colspan='5'>เรื่อง : ($chairman)$objective</td></tr>";
    echo "<tr><td align='left' colspan='5' height='1px'></td></tr>";
    echo "<tr><td align='left' colspan='5' height='1px'></td></tr>";
     }//แสดงรายการที่มีการจอง
    }
     }else{ //ตรวจสอบมีการจองห้องหรือไม่
            echo " - ว่าง - ";
        }

    echo "</table></td></tr></table>";


 }//ห้องประชุมของสำนัก

}

?>
<script>
function goto_url(val){
	if(val==0){
            return false;    // page ย้อนกลับ
	}else if(val==1){
		if(frm1.search_date_start.value == ""){
			alert("กรุณาเลือกวันที่เริ่ม");
            return false;
        }else if(frm1.search_date_end.value == ""){
			alert("กรุณาระบุวันที่สิ้นสุด");
            return false;
        }
	}
}

</script>

<script type="text/javascript">
    $(function () {
        $('.input-daterange').datepicker({
            orientation: "bottom auto",
            format: 'dd/mm/yyyy',
            autoclose: true,
            language: "th",
        });

    });
</script>