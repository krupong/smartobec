<link href='./modules/car/fullcalendar-2.4.0/fullcalendar.css' rel='stylesheet' />
<link href='./modules/car/fullcalendar-2.4.0/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='./modules/car/fullcalendar-2.4.0/lib/moment.min.js'></script>
<script src='./modules/car/fullcalendar-2.4.0/fullcalendar.js'></script>
<script src='./modules/car/fullcalendar-2.4.0/lang/th.js'></script>

<?php

$searchtext="";
$action="";
$rdsearch="";
$chk1="";
$chk2="";
$chk3="";
$comG="";
if(isset($_POST['chk1'])!=""){ 
    $chk1 = $_POST['chk1'];
    $comG=$comG."0,";
}
if(isset($_POST['chk2'])!=""){
    $chk2 = $_POST['chk2'];
    $comG=$comG."1,";
}
if(isset($_POST['chk3'])!=""){
    $chk3 = $_POST['chk3'];
    $comG=$comG."2,";
}
$comG = substr($comG,0,strlen($comG)-1);
if($comG=="") $comG="0,1,2";
if(isset($_POST['rdsearch'])!="") $rdsearch = $_POST['rdsearch'];


if(isset($_POST['action'])!=""){
    $action = $_POST['action'];
}
if(isset($_POST['searchtext'])!=""){
    $searchtext = $_POST['searchtext'];
}else if(isset($_GET['searchtext'])!=""){
    $searchtext = $_GET['searchtext'];
}

//Database
$data = array();
$link = mysqli_connect($hostname, $user, $password, $dbname);
mysqli_set_charset($link, 'utf8');
if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
 $sql = "SELECT a.id,a.car_start as start,a.car_finish as end,
 CASE
 WHEN time_start<13 and time_finish<13 THEN CONCAT(a.place,' เวลา ',time_start,'.00 AM - ',time_finish,'.00 AM')
 WHEN time_start<13 and time_finish>=13 THEN CONCAT(a.place,' เวลา ',time_start,'.00 AM - ',time_finish,'.00 PM')
 WHEN time_start>=13 and time_finish>=13 THEN CONCAT(a.place,' เวลา ',time_start,'.00 PM - ',time_finish,'.00 PM')
 WHEN time_start>=13 and time_finish<13 THEN CONCAT(a.place,' เวลา ',time_start,'.00 PM - ',time_finish,'.00 AM')
 ELSE ''
 END as title,
 CONCAT('index.php?option=car&task=car_detail&id=',a.id) as url,
  CASE 
  WHEN commander_grant=0 THEN '#FF0000'
  WHEN commander_grant=1 THEN '#00FE00'
  WHEN commander_grant=2 THEN '#0000FF'
  ELSE ''
  END as color
FROM car_main a
left outer join car_car b on a.car=b.car_code
left outer join person_main aa on a.person_id=aa.person_id
left outer join person_main driver on a.driver=driver.person_id
where  (
    b.name like '%$searchtext%' 
    or aa.name like '%$searchtext%' 
    or aa.surname like '%$searchtext%' 
";
if($rdsearch =="1") $sql=$sql ."or b.car_number like '%$searchtext%' ";
if($rdsearch =="2") $sql=$sql ."
    or a.driver like '%$searchtext%' 
    or driver.name like '%$searchtext%' 
    or driver.surname like '%$searchtext%' ";
if($rdsearch =="3") $sql=$sql ."or a.place like '%$searchtext%' ";
if($rdsearch =="4") $sql=$sql ."or a.because like '%$searchtext%' ";

$sql = $sql."  ) and a.commander_grant in ($comG) ";


$sql = $sql." order by car_start,time_start ";

if ($result = $link->query($sql)) {
    /* fetch object array */
    while ($obj = $result->fetch_object()) {
       $data[] = array(
                    'id' => $obj->id,
                    'title'=> $obj->title,
                    'start'=> $obj->start,
                    'end'=> $obj->end,
                    'url'=> $obj->url,
                    'color'=>$obj->color
                    );
    }
    /* free result set */
    $result->close();
}
mysqli_close($link);


?>
<script>
    $(document).ready(function() {
        
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,basicWeek,basicDay'
            },
            defaultDate: '<?php echo date("Y-m-d");?>',
            editable: false,
            displayEventEnd:true,
            displayEventTime:true,
            lang : 'th',            
            eventLimit: true, // allow "more" link when too many events
            events : <?php echo json_encode($data);?>
        });
        
    });
</script>

  <div class="panel panel-default">
      <div class="panel-heading"><h3 class="panel-title">รายงานสถิติปฏิทินการใช้ยานพาหนะ</h3></div>
      <div class="panel-body">
                <form class="form-inline" action="#" enctype="multipart/form-data" method="POST">
                    <label>เงื่อนไข&nbsp;&nbsp;:&nbsp;&nbsp;</label>
                    
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="chk1" <?php if($chk1 != "") echo "checked"; ?>> รอ ผอ. กลุ่ม
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="chk2" <?php if($chk2 != "") echo "checked"; ?>> รออนุมัติรถ
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="chk3" <?php if($chk3 != "") echo "checked"; ?>> อนุมัติแล้ว
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="rdsearch" value="1" <?php if($rdsearch == "1") echo "checked"; ?>> ยานพาหนะ
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="rdsearch" value="2" <?php if($rdsearch == "2") echo "checked "; ?>> คนขับรถ
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="rdsearch" value="3" <?php if($rdsearch == "3") echo " checked "; ?> > สถานที่
                        </label>
                    </div>
                        <label for="searchtext"></label>
                        <input type="text" class="form-control" id="searchtext" name="searchtext" placeholder="พิมพ์คำค้นหา" value="<?php echo $searchtext; ?>">
                        
                    <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> ค้นหา</button>
                    <a href="?option=car&task=car_calendar&action=select_clearsearchtext" class="btn btn-default"><span class="glyphicon glyphicon-list"></span> แสดงทั้งหมด</a>
                        
                </form>
       
          </div>
<div class="panel-body" id='calendar'></div>
    </div>
