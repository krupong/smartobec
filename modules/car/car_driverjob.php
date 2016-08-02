<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

$user=$_SESSION['login_user_id'];
//กรณีเลือกแสดงเฉพาะคัน
?><BR>
<div class="container">
  <div class="panel panel-default">
      <div class="panel-heading"><h3 class="panel-title">ภาระกิจที่ได้รับมอบหมาย</h3></div>
<?php 
//ส่วนของการแยกหน้า

$action="";
if(isset($_POST['action'])!=""){
    $action = $_POST['action'];
}
if($action=""){
    $searchtext="";
    $searchstatusid="999";
}else{ 
    $searchtext="";
    if(isset($_POST['searchtext'])!=""){
        $searchtext = $_POST['searchtext'];
    }else if(isset($_GET['searchtext'])!=""){
        $searchtext = $_GET['searchtext'];
    }
    $searchstatusid="999";
    if(isset($_POST['searchstatusid'])!=""){
        $searchstatusid = $_POST['searchstatusid'];
    }else if(isset($_GET['searchstatusid'])!=""){
        $searchstatusid = $_GET['searchstatusid'];
    }
}

$sql="select a.*, b.name as car_name,c.prename,c.name as person_name,c.surname as person_surname
,d.name as car_type_name,b.car_number
from car_main a
left join car_car b on  a.car=b.car_code 
left outer join person_main c on c.person_id=a.person_id
left outer join car_type d on d.code=b.car_type
where a.driver=$user and a.commander_grant=2
and ( b.car_number like '%$searchtext%' or b.name like '%$searchtext%' or a.place like '%$searchtext%' or a.because like '%$searchtext%' or '$searchtext'='')
";
?>
      <div class="panel-body">
        <div class="row">
            <div class="col-md-3 text-left">
            </div>
            <div class="col-md-9 text-right">
                <form class="form-inline" action="#" enctype="multipart/form-data" method="POST" >
            <div class="form-group">
              <label for="searchtext"></label>
              <input type="text" class="form-control" id="searchtext" name="searchtext" placeholder="พิมพ์คำค้นหา" value="<?php echo $searchtext; ?>">
            </div>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> ค้นหา</button>
            <a href="?option=car&task=car_driverjob&action=select_clearsearchtext" class="btn btn-default"><span class="glyphicon glyphicon-list"></span> แสดงทั้งหมด</a>
            <div class="form-group"><!--   SPLITER PAGES    -->
<?php 
// split page
    $page="";
    $pagelen=20;
    if(!isset($_REQUEST['page']))   $page=1;
    else    $page=$_REQUEST['page'];
    $url_link="option=car&task=car_request&searchtext=$searchtext&searchstatusid=$searchstatusid";  
    PAGESPLIT($sql,$connect,$page,$PHP_SELF,$url_link,$pagelen);
    $start=PAGESPLIT_START($sql,$connect,$page,$pagelen);
// split page    
?>
                                        </div><!--SPLITER PAGES-->
                </form>
        </div>
       </div>
          </div>
      <table class="table table-hover table-striped table-condensed table-responsive">
          <thead>
            <tr>
              <th>เลขที่</th>
              <th>วันเริ่มใช้รถ</th>
              <th>วันสิ้นสุดการใช้</th>
              <th>รถ</th>
              <th>ผู้ขอใช้</th>
              <th>วดป ขออนุญาต</th>
              <th>ภารกิจ</th>
            </tr>
          </thead>
          <tbody>
        <?php 
$sql = $sql." order by a.car_start, b.car_code limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);
$N=(($page-1)*$pagelen)+1; //*เกี่ยวข้องกับการแยกหน้า
$M=1;

While ($result = mysqli_fetch_array($dbquery)){
		$id = $result['id'];
		$person_id = $result['person_id'];
		$car_start = $result['car_start'];
		$car_finish = $result['car_finish'];
		$time_start = $result['time_start'];
		$time_finish = $result['time_finish'];
		$rec_date = $result['rec_date'];
		$officer_sign = $result['officer_sign'];
		$group_sign = $result['group_sign'];
		$grant = $result['commander_grant'];
		$commander_sign = $result['commander_sign'];
		$commander_grant = $result['commander_grant'];
		$officer_date = $result['officer_date'];
        $commander_date = $result['commander_date'];
		$officer_comment = $result['officer_comment'];
		$grant_comment = $result['grant_comment'];
        $driver = $result['driver'];
        $self_driver = $result['self_driver'];
		$place = $result['place'];
        $car_type_name = $result['car_type_name'];
        $car_name = $result['car_name'];
        $car_number = $result['car_number'];
        $because = $result['because'];
        $day_total = $result['day_total'];
        $person_num=$result['person_num'];
        $control_person=$result['control_person'];
        $project=$result['project'];
        $activity=$result['activity'];
        $money=$result['money'];
        $fuel=$result['fuel'];
        $self_driver=$result['self_driver'];
        $private_car=$result['private_car'];
        $private_car_number=$result['private_car_number'];
        $private_driver=$result['private_driver'];
    $full_name = $result['prename'].$result['person_name']."  ".$result['person_surname'];
			if(($M%2) == 0)$color="#FFFFB";
			else  	$color="#FFFFFF";
    ?>
<Tr>
    <Td ><?=$N?></Td>
    <Td ><?php echo thai_date_3($car_start);?></Td>
    <Td ><?php echo thai_date_3($car_finish);?></Td>
    <Td><?php echo $result['car_name'];?></Td>
    <Td><?php echo $full_name;?></Td>
    <Td ><?php echo thai_date_3($rec_date);?></Td>
    
    <Td>
                <?php 
if($commander_grant==0){
$value_cm = 40;
$txt_progress = "รอเจ้าหน้าที่";  
$txtbtn = "default";
$txtspan = "star";
$txt = "รอเจ้าหน้าที่";
}
    else if($commander_grant==1){
$value_cm=80;
$txt_progress = "รอผู้อนุมัติ";  
$txtbtn = "info";
$txtspan = "edit";
$txt = "รอผู้อนุมัติ";
}
    else if($commander_grant==2){
$value_cm=100;
$txt_progress = "การขอใช้ยานพาหนะของท่านเสร็จสมบูรณ์";
$txtbtn = "success";
$txtspan = "ok";
$txt = "อนุมัติ";
}
    else if($commander_grant==3){
$value_cm=100;
$txt_progress = "การขอใช้ยานพาหนะของท่านไม่ได้รับการอนุมัติ";      
$txtbtn = "danger";
$txtspan = "ban-circle";
$txt = "ไม่อนุมัติ";
}
                ?>
                <button type="button" class="btn btn-<?=$txtbtn?>"data-toggle="modal" data-target="#myModal<?=$N?>">
                    <span class="glyphicon glyphicon-<?=$txtspan?>" aria-hidden="true"></span> <?=$txt?>
                </button>
                <!-- Modal -->
                <div class="modal fade" id="myModal<?=$N?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">รายละเอียดการขออนุญาตใช้รถราชการ</h4>
                            </div>

                            <div class="modal-body">
                                <!--  Detail     -->
                                <!--       -->
                                <div class="progress">
                                        <div class="progress-bar progress-bar-<?=$txtbtn?> progress-bar-striped" role="progressbar" aria-valuenow="<?=$value_cm?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$value_cm?>%">
                                            <span><?=$value_cm?>% Complete (<?=$txt_progress?>)</span>
                                        </div>
                                </div>
                                <div class="container-md">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">รายละเอียดการขออนุญาตใช้รถราชการ</h3></div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label class="col-md control-label">ผู้ขอใช้พาหนะไปราชการ :
                                                    <?php echo $_SESSION['login_prename'].$_SESSION['login_name']."&nbsp;&nbsp;".$_SESSION['login_surname']."&nbsp;&nbsp;ตำแหน่ง ".$_SESSION['login_userposition'];?>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md control-label">สถานที่ไปราชการ
                                                    <?=$place?>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md control-label">เพื่อวัตถุประสงค์ :
                                                    <?=$because?>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md control-label">ตั้งแต่วันที่ :
                                                    <?=$car_start?> เวลา :
                                                        <?php echo number_format($time_start,2)?> น. </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md control-label">ถึงวันที่ :
                                                    <?=$car_finish?> เวลา :
                                                        <?php echo number_format($time_finish,2)?> น.</label>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md control-label">รวม
                                                    <?=$day_total?> วัน</label>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md control-label ">มีผู้โดยสารทั้งหมด
                                                    <?=$person_num?> คน</label>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md control-label ">ผู้ควบคุมรถคือ
                                                    <?=$control_person?>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <?php if($fuel==0){?>
                                                    <label class="col-md control-label ">เชื้อเพลิง : ไม่ขอใช้งบประมาณ</label>
                                                    <?php }else if($fuel==1){?>
                                                        <label class="col-md control-label ">เชื้อเพลิง : ขอใช้จากงบเชื้อเพลิงกลาง</label>
                                                        <?php }else if($fuel==2){?>
                                                            <label class="col-md control-label ">
                                                                <?php echo "เชื้อเพลิง : ขอใช้จากงบเชื้อเพลิงจากโครงการ $project : กิจกรรม $activity จำนวนเงิน ".number_format($money,2);?> บาท</label>
                                                            <?php }?>
                                            </div>
                                            <div class="form-group" <?php if($self_driver!=1){echo "style='display:none;'";}?>>
                                                <label class="col-md control-label ">กรณีไม่มีพนักงานขับรถ ขออนุญาตเป็นผู้ขับรถคันดังกล่าวซึ่งได้รับใบอนุญาตในการขับขี่รถจากทางราชการประเภทนี้</label>
                                            </div>
                                            <div class="form-group" <?php if($private_car!=1){echo "style='display:none;'";}?>>
                                                <label class="col-md control-label ">กรณีรถราชการไม่ว่าง ขออนุญาตใช้ส่วนส่วนตัวหมายเลขทะเบียน
                                                    <?=$private_car_number?> ผู้ขับขี่ชื่อ
                                                        <?=$private_driver?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
if(!is_null($officer_date)){
?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">ส่วนเจ้าหน้าที่</h3></div>
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-md control-label ">เห็นควรให้
                                                        <?php
if($driver!=""){
$sql_driver= "select  a.person_id, b.prename, b.name, b.surname 
from car_driver a
left join person_main b on a.person_id=b.person_id where a.person_id=$driver ";
$dbquery_driver = mysqli_query($connect,$sql_driver);
$result_driver = mysqli_fetch_array($dbquery_driver);
$prename = $result_driver['prename'];
$name = $result_driver['name'];
$surname = $result_driver['surname'];
echo $prename.$name."  ".$surname;
}
?> เป็นพนักงานขับรถในราชการนี้</label>
                                                </div>
                                                <!-- ส่วนของเจ้าหน้าที่  -->

                                                <div class="form-group">
                                                    <label class="col-md control-label">รถที่ได้รับอนุญาต
                                                        <?php  echo $car_type_name." : ".$car_number." : ".$car_name;?>
                                                    </label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md control-label">ความคิดเห็น :
                                                        <?=$officer_comment?>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="panel-footer">
                                                <h3 class="panel-title">ลงชื่อ <?=$officer_sign?> วดป <?=thai_date_4($officer_date)?></h3></div>
                                        </div>
                                        <?php } ?>
                                            <?php 
if(!is_null($commander_date)){
?>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title">ส่วนการอนุมัติ</h3></div>
                                                    <div class="panel-body">
                                                        <div class="form-group">
                                                            <label class="col-md control-label">ส่วนการอนุมัติ: คำสั่ง(ถ้ามี)
                                                                <?=$grant_comment?>
                                                            </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md control-label">สถานะ
                                                                <?php if($grant==1){echo "อนุมัติ";}else{echo "ไม่อนุมัติ";}?>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="panel-footer">
                                                        <h3 class="panel-title">ลงชื่อ <?=$commander_sign?> วดป <?php echo thai_date_4($commander_date);?> </h3></div>
                                                </div>
                                                <?php } ?>
                                </div>
                                <!--       -->
                            </div>
                        </div>
                    </div>
                </div>
            </Td>
    
    
</Tr>
<?php 
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
}
?>
          </tbody>
          </table>

</div>
    </div>