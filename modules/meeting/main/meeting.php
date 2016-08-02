<?php
//กำหนดค่าสูงสุดในรายการแสดงผล
$showmaxlist=40;

/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
$login_group=mysqli_real_escape_string($connect,$_SESSION['login_group']);
if(!($login_group<=1)){
exit();
}
if(!isset($_SESSION['login_user_id'])){ $_SESSION['login_user_id']=""; exit();
}else{
//หาหน่วยงาน
$user_id=mysqli_real_escape_string($connect,$_SESSION['login_user_id']);
    $sql_user_depart="select * from person_main where person_id=? ";
    $query_user_depart = $connect->prepare($sql_user_depart);
    $query_user_depart->bind_param("i", $user_id);
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

require_once "modules/meeting/time_inc.php";
?>
<script type="text/javascript" src="./css/js/calendarDateInput.js"></script>
<?php

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


//เริ่มใหม่

  // Search Condition
  if(isset($_POST["searchtext"])){
    $searchtext = $_POST["searchtext"];
    $_SESSION["searchtext"] = $_POST["searchtext"];
  }else{
    $searchtext = "";
  }


  if(isset($_POST["status_index"])){
    switch ($_POST["status_index"]) {
      case '999':
        $poststatus_index = 999;
        unset($_SESSION["status_index"]);
        break;
      default:
        $poststatus_index = $_POST["status_index"];
        $_SESSION["status_index"] = $_POST["status_index"];
        break;
    }
  }else{
    $poststatus_index = "";
  }
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<div class="container">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">รายการจองห้องประชุม</h3>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-md-2 text-left form-group">
          <a href="?option=meeting&task=main/meeting&index=1" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>&nbsp;จองห้องในสำนัก</a>
        </div>
        <div class="col-md-1 text-left form-group">
          <a href="?option=meeting&task=main/meeting&index=11" class="btn btn-danger"><span class="glyphicon glyphicon-plus"></span>&nbsp;จองห้องต่างสำนัก</a>
        </div>
        <div class="col-md-8 text-right">
          <form class="form-inline" action="#" enctype="multipart/form-data" method="POST" >
            <div class="form-group">
              <label for="searchtext"></label>
              <input type="text" class="form-control" id="searchtext" name="searchtext" placeholder="พิมพ์คำค้นหา" value="<?php echo $searchtext; ?>">
            </div>
            <div class="form-group">
              <select class="form-control" name="status_index" >
                <option value="999" <?php if($poststatus_index==""){ echo "selected"; } ?>>ทุกสถานะ</option>
               <option value="0" <?php if($poststatus_index=="0"){ echo "selected"; } ?>>รอการอนุญาต</option>
               <option value="1" <?php if($poststatus_index=="1"){ echo "selected"; } ?>>อนุญาตแล้ว</option>
               <option value="2" <?php if($poststatus_index=="2"){ echo "selected"; } ?>>ไม่อนุญาต</option>
              </select>
            </div>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> ค้นหา</button>
            <a href="?option=meeting&task=main/meeting" class="btn btn-default"><span class="glyphicon glyphicon-list"></span> แสดงทั้งหมด</a>
          </form>
        </div>
      </div>
      <hr>
      <table class="table table-hover table-striped table-condensed table-responsive">
        <thead>
          <tr>
          	<th>วันที่เริ่ม</th>
            <th>วันที่สิ้นสุด</th>
          	<th>ห้องประชุม</th>
            <th>เวลา</th>
            <th>ประธาน/วัตถุประสงค์</th>
            <th>อื่นๆ/ผู้ประสานงาน</th>
            <th>จองเมื่อ</th>
            <th>ลบ</th>
            <th>อนุญาต</th>
            <th>หมายเหตุ</th>
       	  </tr>
        </thead>
        <tbody>

          <?php
            // Select Book
            if(($poststatus_index==999) or ($poststatus_index=="")){
              $sqlroomstatus = "";
            }else{
              $sqlroomstatus = " and approve=".$poststatus_index." ";
            }
            $sql = " SELECT
                  meeting_main.*,
                  meeting_room.room_name,
                  meeting_room.department as roomdepart,
                  system_department.department_name,
                  system_department.department_precis,
                  person_main.prename,
                  person_main.name,
                  person_main.surname
                FROM
                  meeting_main
                  LEFT JOIN meeting_room ON meeting_main.room = meeting_room.room_code
                  LEFT JOIN system_department ON meeting_main.department_book = system_department.department
                  LEFT JOIN person_main ON meeting_main.user_book = person_main.person_id
                WHERE user_book = '$_SESSION[login_user_id]' ".$sqlroomstatus." and
                      objective like '%$searchtext%'
                ORDER BY book_date_start desc,room,start_time LIMIT 0,$showmaxlist";


            if ($result = mysqli_query($connect, $sql)) {
              while ($row = $result->fetch_assoc()) {
                switch ($row["approve"]) {
                  case '1':
                    $tr_class = "class='success'";
                    break;
                  case '2':
                    $tr_class = "class='warning'";
                    break;
                  default:
                    $tr_class = "";
                    break;
                }

        if($row['roomdepart']!=$user_departid){
    //หาชื่อหน่วยงาน
    $sql_depart_name="select * from system_department where department=? ";
    $query_depart_name = $connect->prepare($sql_depart_name);
    $query_depart_name->bind_param("i", $row['roomdepart']);
    $query_depart_name->execute();
    $result_qdepart_name=$query_depart_name->get_result();
While ($result_depart_name = mysqli_fetch_array($result_qdepart_name))
   {
    $book_department_name=$result_depart_name['department_name'];
    $book_department_precisname=$result_depart_name['department_precis'];
	}

        $showdepartmybook = " <a tabindex='0' class='btn btn-warning btn-xs' role='button' data-toggle='popover' data-placement='top' data-trigger='focus' title='ห้องประชุมสำนัก' data-content=$book_department_name>$book_department_precisname</a>";
        }else{$showdepartmybook="";}

                ?>

                  <tr <?php echo $tr_class; ?>>
                    <td><?php echo thai_date_3($row['book_date_start']); ?></td>
                    <td><?php echo thai_date_3($row['book_date_end']); ?></td>
                    <td><?php echo $row['room_name'].$showdepartmybook ;?></td>
                    <td><?php echo number_format($row['start_time'],2)."-".number_format($row['finish_time'],2)."น."; ?></td>
                    <td><?php echo $row['chairman']."/".$row['objective']; ?></td>
                    <td><?php echo $row['other']."/".$row['coordinator']; ?></td>
                    <td><?php echo thai_date_4($row['rec_date']); ?></td>
                    <td class="text-center">
                    <?php if($row['book_person']==$user_id){
                     echo   "<a href='?option=meeting&task=main/meeting&index=3&aid=$row[id]' data-toggle='confirmation' data-placement='top'><span class='glyphicon glyphicon-remove icon-danger icon-size1'></span></a>";
                     }else{ echo ""; } ?>
                    </Td>
                    <td class="text-center">
                   <?php if($row['approve']==2){ echo "<span class='glyphicon glyphicon-ban-circle icon-danger icon-size1'></span>";}
                            else if($row['approve']==1){ echo "<span class='glyphicon glyphicon-ok-circle icon-success icon-size2'></span>";}
                            else { echo "<span class='glyphicon glyphicon-hourglass icon-info'></span>";}

                        ?>
                    </td>
                    <td><?php echo $row['reason'];?></td>
                  </tr>
                <?php
              }
              // free result set
              mysqli_free_result($result);
            }
          ?>

        </tbody>
			</table>
    </div>
  </div>
</div>
</body>
</html>

<?php
}
?>

<?php
//ส่วนฟอร์มรับข้อมูล จองห้องในสำนัก
if($getindex==1){
?>
      <div class="panel-heading"><h3 class="panel-title">การจองห้องประชุมภายในสำนัก</h3></div>
      <div class="panel-body">
        <form id='frm1' name='frm1' class="form-horizontal" action="?option=meeting&task=main/meeting" method="POST" onSubmit="JavaScript:return goto_url(1);">
        <div class="form-group">
          <label class="col-sm-3 control-label text-right">ห้องประชุม*</label>
          <div class="col-sm-4">
            <label >
                <Select name='room' id='room' class="selectpicker show-tick" data-style="btn-primary">
                    <option  value = ''>เลือกห้องประชุม</option>
<?php
                    $sql = "select * from meeting_room where department=? and active='1'  order by id";
                    $dbquery = $connect->prepare($sql);
                    $dbquery->bind_param("i", $user_departid);
                    $dbquery->execute();
                    $result_room=$dbquery->get_result();
                    While ($result = mysqli_fetch_array($result_room))
                    {
		              $room_code = $result['room_code'];
		              $room_name = $result['room_name'];
		              echo  "<option value = $room_code>$room_name</option>";
	               }
                    ?>
                </select>
            </label>
          </div>
        </div>
        <hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right">วันที่ใช้งาน*</label>
          <div class="col-sm-4">
            <label>
                <div class="input-daterange input-group" id="datepicker">
                <input type="text" class="input-xs form-control" name="book_date_start" id="book_date_start" placeholder="วันที่เริ่มต้น" />
                <span class="input-group-addon"> ถึงวันที่ </span>
                <input type="text" class="input-xs form-control" name="book_date_end" id="book_date_end" placeholder="วันที่สิ้นสุด" />
                </div>             
<!--               
                <input class="form-control" type="text" name="book_date_start" id="book_date_start" placeholder="วันที่เริ่มต้น" data-provide="datepicker"  data-date-language="th"  >
             </label>
          </div>
           <div class="col-sm-1">

            <label class="control-label text-right">ถึงวันที่*</label>

            </div>
           <div class="col-sm-2">
            <label >
                <input class="form-control" type="text" name="book_date_end" id="book_date_end" placeholder="วันที่สิ้นสุด" data-provide="datepicker"  data-date-language="th"  >
-->                
            </label>
          </div>
       </div>
        <hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right">ตั้งแต่เวลา*</label>
          <div class="col-sm-2">
            <label >
                <Select  name="start_time" id="start_time"   class="selectpicker show-tick" data-width="120px" >
                    <option value = 1>01.00 น.</option>
                    <option value = 2>02.00 น.</option>
                    <option value = 3>03.00 น.</option>
                    <option value = 4>04.00 น.</option>
                    <option value = 5>05.00 น.</option>
                    <option value = 6>06.00 น.</option>
                    <option value = 7>07.00 น.</option>
                    <option value = 8 selected>08.00 น.</option>
                    <option value = 9>09.00 น.</option>
                    <option value = 10>10.00 น.</option>
                    <option value = 11>11.00 น.</option>
                    <option value = 12>12.00 น.</option>
                    <option value = 13>13.00 น.</option>
                    <option value = 14>14.00 น.</option>
                    <option value = 15>15.00 น.</option>
                    <option value = 16>16.00 น.</option>
                    <option value = 17>17.00 น.</option>
                    <option value = 18>18.00 น.</option>
                    <option value = 19>19.00 น.</option>
                    <option value = 20>20.00 น.</option>
                    <option value = 21>21.00 น.</option>
                    <option value = 22>22.00 น.</option>
                    <option value = 23>23.00 น.</option>
                </Select>
             </label>
          </div>
           <div class="col-sm-1">

            <label class="control-label text-center">ถึงเวลา*</label>

            </div>
           <div class="col-sm-2">
            <label >
                 <Select  name="finish_time" id="finish_time"  class="selectpicker show-tick" data-width="120px">
                    <option value = 1>01.00 น.</option>
                    <option value = 2>02.00 น.</option>
                    <option value = 3>03.00 น.</option>
                    <option value = 4>04.00 น.</option>
                    <option value = 5>05.00 น.</option>
                    <option value = 6>06.00 น.</option>
                    <option value = 7>07.00 น.</option>
                    <option value = 8>08.00 น.</option>
                    <option value = 9>09.00 น.</option>
                    <option value = 10>10.00 น.</option>
                    <option value = 11>11.00 น.</option>
                    <option value = 12>12.00 น.</option>
                    <option value = 13>13.00 น.</option>
                    <option value = 14>14.00 น.</option>
                    <option value = 15>15.00 น.</option>
                    <option value = 16 selected>16.00 น.</option>
                    <option value = 17>17.00 น.</option>
                    <option value = 18>18.00 น.</option>
                    <option value = 19>19.00 น.</option>
                    <option value = 20>20.00 น.</option>
                    <option value = 21>21.00 น.</option>
                    <option value = 22>22.00 น.</option>
                    <option value = 23>23.00 น.</option>
                </Select>
           </label>
          </div>
       </div>
        <hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right">ประธานการประชุม*</label>
          <div class="col-sm-4">
            <label >
                <Input class="form-control" Type="Text"  Name="chairman" id="chairman" size="30px" >
            </label>
          </div>
        </div>
        <hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right">วัตถุประสงค์*</label>
          <div class="col-sm-4">
            <label >
                <Input class="form-control" Type="Text" Name="objective" id="objective"  size="60px"  >
            </label>
          </div>
        </div>
        <hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right">จำนวนผู้เข้าประชุม*</label>
          <div class="col-sm-4">
            <label >
                <Input Type="Text" class="form-control" Name="person_num" id="person_num"  size="10px" onkeypress=check_number()>
            </label>
            <label > คน</label>
          </div>
        </div>
        <hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right">ผู้ประสานงาน/เบอร์โทรศัพท์*</label>
          <div class="col-sm-4">
            <label >
               <Input class="form-control" Type="Text" Name="coordinator" id="coordinator" size="30px" >
           </label>
          </div>
        </div>
        <hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right">อื่นๆ(ถ้ามี)</label>
          <div class="col-sm-4">
            <label >
               <Input class="form-control" Type="Text" Name="other" id="other" size="60px" >
            </label>
          </div>
        </div>
        <hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right"></label>
          <div class="col-sm-4">
            <label >
                <INPUT TYPE="hidden" name="index" value="4">
                <button type="submit" name="smb" class="btn btn-primary"  class="entrybutton" >
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> ตกลง
                </button>&nbsp;

                <button type="button" name="back" class="btn btn-default" onclick="location.href='?option=meeting&task=main/meeting'">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> ย้อนกลับ
                </button>
            </label>
          </div>
        </div>
        <hr>
      </div>
</form>

<?php
}
?>

<?php
//เพิ่มจองห้องต่างสำนัก
if($getindex==11){
?>
      <div class="panel-heading"><h3 class="panel-title">การจองห้องประชุมต่างสำนัก</h3></div>
      <div class="panel-body">
        <form id='frm1' name='frm1' class="form-horizontal" action="?option=meeting&task=main/meeting" method="POST" onSubmit="JavaScript:return goto_url(1);">
        <div class="form-group">
          <label class="col-sm-3 control-label text-right">ห้องประชุม*</label>
          <div class="col-sm-4">
            <label >
                <Select name='room' id='room' class="selectpicker show-tick" data-style="btn-danger">
                    <option  value = ''>เลือกห้องประชุม</option>
<?php
                    $sql = "select * from meeting_room where department!=? and active='1'  order by department,id";
                    $dbquery = $connect->prepare($sql);
                    $dbquery->bind_param("i", $user_departid);
                    $dbquery->execute();
                    $result_room=$dbquery->get_result();
                    While ($result = mysqli_fetch_array($result_room))
                    {
		              $room_code = $result['room_code'];
		              $room_name = $result['room_name'];
     //หาชื่อหน่วยงาน
    $sql_depart_name="select * from system_department where department=? ";
    $query_depart_name = $connect->prepare($sql_depart_name);
    $query_depart_name->bind_param("i", $result['department']);
    $query_depart_name->execute();
    $result_qdepart_name=$query_depart_name->get_result();
While ($result_depart_name = mysqli_fetch_array($result_qdepart_name))
   {
    $book_department_name=$result_depart_name['department_name'];
    $book_department_precisname=$result_depart_name['department_precis'];
	}

 		              echo  "<option value = $room_code>$room_name ($book_department_precisname)</option>";
	               }
                    ?>
                </select>
            </label>
          </div>
        </div>
        <hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right">วันที่ใช้งาน*</label>
          <div class="col-sm-4">
            <label >
                <div class="input-daterange input-group" id="datepicker">
                <input type="text" class="input-xs form-control" name="book_date_start" id="book_date_start" placeholder="วันที่เริ่มต้น" />
                <span class="input-group-addon"> ถึงวันที่ </span>
                <input type="text" class="input-xs form-control" name="book_date_end" id="book_date_end" placeholder="วันที่สิ้นสุด" />
                </div>             
<!--
                <input class="form-control" type="text" name="book_date_start" id="book_date_start" placeholder="วันที่เริ่มต้น" data-provide="datepicker"  data-date-language="th"  >
             </label>
          </div>
           <div class="col-sm-1">

            <label class="control-label text-right">ถึงวันที่*</label>

            </div>
           <div class="col-sm-2">
            <label >
                <input class="form-control" type="text" name="book_date_end" id="book_date_end" placeholder="วันที่สิ้นสุด" data-provide="datepicker"  data-date-language="th"  >
-->
            </label>
          </div>
       </div>
        <hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right">ตั้งแต่เวลา*</label>
          <div class="col-sm-2">
            <label >
                <Select  name="start_time" id="start_time"   class="selectpicker show-tick" data-width="120px" >
                    <option value = 1>01.00 น.</option>
                    <option value = 2>02.00 น.</option>
                    <option value = 3>03.00 น.</option>
                    <option value = 4>04.00 น.</option>
                    <option value = 5>05.00 น.</option>
                    <option value = 6>06.00 น.</option>
                    <option value = 7>07.00 น.</option>
                    <option value = 8 selected>08.00 น.</option>
                    <option value = 9>09.00 น.</option>
                    <option value = 10>10.00 น.</option>
                    <option value = 11>11.00 น.</option>
                    <option value = 12>12.00 น.</option>
                    <option value = 13>13.00 น.</option>
                    <option value = 14>14.00 น.</option>
                    <option value = 15>15.00 น.</option>
                    <option value = 16>16.00 น.</option>
                    <option value = 17>17.00 น.</option>
                    <option value = 18>18.00 น.</option>
                    <option value = 19>19.00 น.</option>
                    <option value = 20>20.00 น.</option>
                    <option value = 21>21.00 น.</option>
                    <option value = 22>22.00 น.</option>
                    <option value = 23>23.00 น.</option>
                </Select>
             </label>
          </div>
           <div class="col-sm-1">

            <label class="control-label text-center">ถึงเวลา*</label>

            </div>
           <div class="col-sm-2">
            <label >
                 <Select  name="finish_time" id="finish_time"  class="selectpicker show-tick" data-width="120px">
                    <option value = 1>01.00 น.</option>
                    <option value = 2>02.00 น.</option>
                    <option value = 3>03.00 น.</option>
                    <option value = 4>04.00 น.</option>
                    <option value = 5>05.00 น.</option>
                    <option value = 6>06.00 น.</option>
                    <option value = 7>07.00 น.</option>
                    <option value = 8>08.00 น.</option>
                    <option value = 9>09.00 น.</option>
                    <option value = 10>10.00 น.</option>
                    <option value = 11>11.00 น.</option>
                    <option value = 12>12.00 น.</option>
                    <option value = 13>13.00 น.</option>
                    <option value = 14>14.00 น.</option>
                    <option value = 15>15.00 น.</option>
                    <option value = 16 selected>16.00 น.</option>
                    <option value = 17>17.00 น.</option>
                    <option value = 18>18.00 น.</option>
                    <option value = 19>19.00 น.</option>
                    <option value = 20>20.00 น.</option>
                    <option value = 21>21.00 น.</option>
                    <option value = 22>22.00 น.</option>
                    <option value = 23>23.00 น.</option>
                </Select>
           </label>
          </div>
       </div>
        <hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right">ประธานการประชุม*</label>
          <div class="col-sm-4">
            <label >
                <Input class="form-control" Type="Text"  Name="chairman" id="chairman" size="30px" >
            </label>
          </div>
        </div>
        <hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right">วัตถุประสงค์*</label>
          <div class="col-sm-4">
            <label >
                <Input class="form-control" Type="Text" Name="objective" id="objective"  size="60px"  >
            </label>
          </div>
        </div>
        <hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right">จำนวนผู้เข้าประชุม*</label>
          <div class="col-sm-4">
            <label >
                <Input Type="Text" class="form-control" Name="person_num" id="person_num"  size="10px" onkeypress=check_number()>
            </label>
            <label > คน</label>
          </div>
        </div>
        <hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right">ผู้ประสานงาน/เบอร์โทรศัพท์*</label>
          <div class="col-sm-4">
            <label >
               <Input class="form-control" Type="Text" Name="coordinator" id="coordinator" size="30px" >
           </label>
          </div>
        </div>
        <hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right">อื่นๆ(ถ้ามี)</label>
          <div class="col-sm-4">
            <label >
               <Input class="form-control" Type="Text" Name="other" id="other" size="60px" >
            </label>
          </div>
        </div>
        <hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right"></label>
          <div class="col-sm-4">
            <label >
                <INPUT TYPE="hidden" name="index" value="4">
                <button type="submit" name="smb" class="btn btn-primary"  class="entrybutton" >
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> ตกลง
                </button>&nbsp;

                <button type="button" name="back" class="btn btn-default" onclick="location.href='?option=meeting&task=main/meeting'">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> ย้อนกลับ
                </button>
            </label>
          </div>
        </div>
        <hr>
      </div>
</form>

<?php
}

//ส่วนยืนยันการลบข้อมูล

if(isset($_GET['id'])){
$getid=mysqli_real_escape_string($connect,$_GET['id']);
}else {$getid="";}

if($getindex==2) {
?>
<div class="container">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</h3>
    </div>
    <div class="panel-body">
      <div class="row text-center">
        <div class="col-xs text-center form-group">
            <INPUT TYPE="button" class="btn btn-danger" name="smb" value="ยืนยัน" onclick="location.href='?option=meeting&task=main/meeting&index=3&id=$getid'"> &nbsp; &nbsp; &nbsp;
             <INPUT TYPE="button" class="btn btn-info" name="back" value="ยกเลิก" onclick="location.href='?option=meeting&task=main/meeting'">
        </div>
      </div>
    </div>
  </div>
</div>
<?php
}

//ส่วนลบข้อมูล
if($getindex==3){
if(isset($_GET['aid'])){
$getid=mysqli_real_escape_string($connect,$_GET['aid']);
}else {$getid="";}
$sql = "delete from meeting_main where id=?";
    $dbquery = $connect->prepare($sql);
    $dbquery->bind_param("i", $getid);
    $dbquery->execute();
    $result=$dbquery->get_result();
    echo "<script>document.location.href='?option=meeting&task=main/meeting'; </script>\n";

}

//ส่วนบันทึกข้อมูล
if($postindex==4){
$date_time_now = date("Y-m-d H:i:s");

//ตรวจสอบ
if(isset($_POST['room'])){
$room=mysqli_real_escape_string($connect,$_POST['room']);
}else {$room=""; exit; }
if(isset($_POST['book_date_start'])){
$book_date_start=mysqli_real_escape_string($connect,$_POST['book_date_start']);
    $book_date_start=explode("/", $book_date_start);
    $book_date_start=$book_date_start[2]."-".$book_date_start[1]."-".$book_date_start[0];  //ปี เดือน วัน
}else {$book_date_start=""; exit; }
if(isset($_POST['book_date_end'])){
$book_date_end=mysqli_real_escape_string($connect,$_POST['book_date_end']);
    $book_date_end=explode("/", $book_date_end);
    $book_date_end=$book_date_end[2]."-".$book_date_end[1]."-".$book_date_end[0];  //ปี เดือน วัน
}else {$book_date_end=""; exit;}
if(isset($_POST['start_time'])){
$start_time=mysqli_real_escape_string($connect,$_POST['start_time']);
}else {$start_time=""; exit;}
if(isset($_POST['finish_time'])){
$finish_time=mysqli_real_escape_string($connect,$_POST['finish_time']);
}else {$finish_time=""; exit;}
if(isset($_POST['chairman'])){
$chairman=mysqli_real_escape_string($connect,$_POST['chairman']);
}else {$chairman=""; exit;}
if(isset($_POST['objective'])){
$objective=mysqli_real_escape_string($connect,$_POST['objective']);
}else {$objective=""; exit;}
if(isset($_POST['person_num'])){
$person_num=mysqli_real_escape_string($connect,$_POST['person_num']);
}else {$person_num=""; }
if(isset($_POST['coordinator'])){
$coordinator=mysqli_real_escape_string($connect,$_POST['coordinator']);
}else {$coordinator=""; exit;}
if(isset($_POST['other'])){
$other=mysqli_real_escape_string($connect,$_POST['other']);
}else {$other=""; }


$sql_insert = "insert into meeting_main (id , room , book_date_start , book_date_end , start_time, finish_time , chairman , objective , person_num , book_person , user_book , department_book , rec_date , approve , reason , coordinator, other , officer , officer_date) values ('',?,?,?,?,?,?,?,?,?,?,?,?,'','',?,?,'','')";


if ($dbquery_insert = $connect->prepare($sql_insert)) {

    $dbquery_insert->bind_param("issiississssss", $room , $book_date_start , $book_date_end , $start_time , $finish_time , $chairman , $objective , $person_num , $user_id , $user_id , $user_departid , $date_time_now , $coordinator , $other);
     $dbquery_insert->execute();
    $result_insert=$dbquery_insert->get_result();
    
    echo $room;
    
    // Push notification service edit by Krupong    
    $sql = "select department,room_name from meeting_room where room_code=?";
     if ($dbquery = $connect->prepare($sql)) {
    $dbquery->bind_param("i", $room);
    $dbquery->execute();
    $results=$dbquery->get_result();
        While ($result = mysqli_fetch_array($results)){
                $roomdepart = $result['department'];
                $roomname = $result['room_name'];
        }
     }
     $book_start=thai_date_3($book_date_start);
     $book_end=thai_date_3($book_date_end);
         
     $sql = "select meeting_permission.person_id as roomofficer  
     from meeting_permission
     LEFT JOIN person_main ON meeting_permission.person_id = person_main.person_id
     where person_main.department=? and meeting_permission.p1=1";
    
    if ($dbquery = $connect->prepare($sql)) {
    $dbquery->bind_param("i", $roomdepart);
    $dbquery->execute();
    $results=$dbquery->get_result();
        While ($result = mysqli_fetch_array($results)){
                $roomofficer = $result['roomofficer'];
                $message = $roomname." ".$book_start."-".$book_end;
                smartpush("$roomofficer",'meeting',$message,"มีผู้จองห้องประชุม"); 
  
        }
     }
    // end Push notification //
        
} else {
    die("Errormessage: ". $connect->error);
}
    
    echo "<script>document.location.href='?option=meeting&task=main/meeting'; </script>\n";

}

if(!(($getindex==1) or ($getindex==2) or ($getindex==3) or ($getindex==11))) {
echo "<div align='center'>";
echo "<div class='col-sm-3 col-md-offset-1 text-center'><span class='glyphicon glyphicon-ban-circle icon-danger icon-size1'></span> หมายถึง ไม่อนุญาตให้ใช้ห้องประชุม</div>";
echo "<div class='col-sm-3 text-center'><span class='glyphicon glyphicon-ok-circle icon-success icon-size1'></span> หมายถึง อนุญาตให้ใช้ห้องประชุม</div>";
echo "<div class='col-sm-3 text-center'><span class='glyphicon glyphicon-hourglass icon-info icon-size1'></span> หมายถึง รอการอนุญาตให้ใช้งาน</div>";
echo "</div><br><br>";}
?>


<script>
function goto_url(val){
	if(val==0){
            return false;
	}else if(val==1){
		if(frm1.room.value == ""){
			alert("กรุณาเลือกห้องประชุม");
            return false;
		}
	}
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
<script type="text/javascript">
    $(function () {
        $('.input-daterange').datepicker({
            language: "th",
            orientation: "bottom auto",
            format: 'dd/mm/yyyy',
            autoclose: true,
            startDate: '$today',
        });

    });
</script>
