<?php

$id="";
if(isset($_GET['id'])!=""){
    $id = $_GET['id'];
}
$sql = "select a.*,IFNULL(a.commander_grant,0) as commander_grant2
        ,b.prename,b.name,b.surname
        ,c.prename as prename_gs,c.name as name_gs,c.surname as surname_gs 
        ,d.prename as prename_cs,d.name as name_cs,d.surname as surname_cs 
        ,e.car_type,f.name as car_type_name,e.car_number,e.name as car_name
        ,CONCAT(aa.prename,aa.name,'  ',aa.surname) as person_name
        ,g.position_name
        from  car_main a 
        left outer join person_main aa on a.person_id=aa.person_id
        left outer join person_main b on a.officer_sign=b.person_id  
        left outer join person_main c on a.group_sign=c.person_id 
        left outer join person_main d on a.commander_sign=d.person_id
        left outer join car_car e on a.car=e.car_code
        left outer join car_type f on f.code=e.car_type
        left outer join person_position g on g.position_code=aa.position_code
        where a.id=$id ";
        
        $dbquery = mysqli_query($connect,$sql);
  
While ($result = mysqli_fetch_array($dbquery)){
		$id = $result['id'];
		$person_id = $result['person_id'];
		$car_start = $result['car_start'];
		$car_finish = $result['car_finish'];
		$rec_date = $result['rec_date'];
		$officer_sign = $result['officer_sign'];
		$group_sign = $result['group_sign'];
		$grant = $result['commander_grant2'];
		$commander_sign = $result['commander_sign'];
        $car = $result['car'];
        $car_type_name = $result['car_type_name'];
        $car_number = $result['car_number'];
        $car_name= $result['car_name'];
        $place=$result['place'];
        $because=$result['because'];
        $car_start=$result['car_start'];
        $time_start=$result['time_start'];
        $car_finish=$result['car_finish'];
        $time_finish=$result['time_finish'];
        $day_total=$result['day_total'];
        $person_num=$result['person_num'];
        $control_person=$result['control_person'];
        $project=$result['project'];
        $activity=$result['activity'];
        $money=$result['money'];
        $private_car=$result['private_car'];
        $fuel = $result['fuel'];
        $self_driver=$result['self_driver'];
        $private_car_number=$result['private_car_number'];
        $private_driver=$result['private_driver'];
        $officer_comment=$result['officer_comment'];
        $driver=$result['driver'];
        $officer_comment=$result['officer_comment'];
        $officer_date=$result['officer_date'];
        $officer_sign=$result['prename'].$result['name']."  ".$result['surname'];
        $group_comment=$result['group_comment'];
        $group_sign=$result['prename_gs'].$result['name_gs']."  ".$result['surname_gs'];
        $group_date=$result['group_date'];
        $commander_sign=$result['prename_cs'].$result['name_cs']."  ".$result['surname_cs'];
        $commander_date=$result['commander_date'];
        $commander_grant=$result['commander_grant'];
        $grant_comment=$result['grant_comment'];
        $person_name=$result['person_name'];
?>

<div class="container"><BR><a href="index.php?option=car&task=car_calendar">
    <button type="button" class="btn btn-default btn-lg">
        <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> รายงานสถิติปฏิทินการการใช้ยานพาหนะ
    </button></a><BR><BR>
  <div class="panel panel-default">
      <div class="panel-heading"><h3 class="panel-title">รายละเอียดการขออนุญาตใช้รถราชการ</h3></div>
      <div class="panel-body">
        <div class="form-group">
          </div>
      <div class="form-group">
          <label class="col-md control-label">ผู้ขอใช้พาหนะไปราชการ : <?php echo $result['person_name']."&nbsp;&nbsp;ตำแหน่ง ".$result['position_name'];?></label>          
        </div>
      <div class="form-group">
          <label class="col-md control-label">สถานที่ไปราชการ <?php echo $result['place'];?></label>
        </div>
      <div class="form-group">
          <label class="col-md control-label">เพื่อวัตถุประสงค์ : <?php echo $result['because'];?></label>
        </div>
      <div class="form-group">
            <label class="col-md control-label">ตั้งแต่วันที่ : <?=$car_start?> เวลา : <?php echo number_format($time_start,2)?> น. </label>
        </div>
      <div class="form-group">
            <label class="col-md control-label">ถึงวันที่ : <?=$car_finish?> เวลา : <?php echo number_format($time_finish,2)?> น. รวม  <?=$day_total?> วัน</label>
        </div>
      <div class="form-group">
            <label class="col-md control-label">รวม  <?=$day_total?> วัน</label>
        </div>
      <div class="form-group">
          <label class="col-md control-label ">มีผู้โดยสารทั้งหมด <?=$person_num?> คน</label>
        </div>
      <div class="form-group">
          <label class="col-md control-label ">ผู้ควบคุมรถคือ <?=$control_person?></label>
        </div>
        <div class="form-group">
            <?php if($fuel==0){?>
          <label class="col-md control-label ">เชื้อเพลิง : ไม่ขอใช้งบประมาณ</label>
            <?php }else if($fuel==1){?>
          <label class="col-md control-label ">เชื้อเพลิง : ขอใช้จากงบเชื้อเพลิงกลาง</label>
            <?php }else if($fuel==2){?>
          <label class="col-md control-label "><?php echo "เชื้อเพลิง : ขอใช้จากงบเชื้อเพลิงจากโครงการ $project : กิจกรรม $activity จำนวนเงิน ".number_format($money,2);?> บาท</label>
            <?php }?>            
        </div>
      <div class="form-group" <?php if($self_driver!=1){echo "style='display:none;'";}?>>
          <label class="col-md control-label ">กรณีไม่มีพนักงานขับรถ ขออนุญาตเป็นผู้ขับรถคันดังกล่าวซึ่งได้รับใบอนุญาตในการขับขี่รถจากทางราชการประเภทนี้</label>
        </div>
      <div class="form-group" <?php if($private_car!=1){echo "style='display:none;'";}?>>
          <label class="col-md control-label ">กรณีรถราชการไม่ว่าง ขออนุญาตใช้ส่วนส่วนตัวหมายเลขทะเบียน <?=$private_car_number?> ผู้ขับขี่ชื่อ<?=$private_driver?> </label>    
        </div>
</div>
    </div>
    <?php 
    if($grant>0){
?>
  <div class="panel panel-default">
      <div class="panel-heading"><h3 class="panel-title">ส่วนการอนุมัติ</h3></div>
      <div class="panel-body">
      <div class="form-group">
          <label class="col-md control-label">ส่วนการอนุมัติ: คำสั่ง(ถ้ามี) <?=$grant_comment?></label>
        </div>
      <div class="form-group">
          <label class="col-md control-label">สถานะ <?php if($grant>0 && $grant<3){echo "อนุมัติ";}else{echo "ไม่อนุมัติ";}?></label>
        </div>
      </div>
      <div class="panel-footer"><h3 class="panel-title">ลงชื่อ <?=$commander_sign?> วดป <?php echo thai_date_4($commander_date);?> </h3></div>
    </div>
<?php } ?>
<?php
    if($grant>1){
?>    
  <div class="panel panel-default">
      <div class="panel-heading"><h3 class="panel-title">ส่วนเจ้าหน้าที่</h3></div>
      
      <div class="panel-body">    
      <div class="form-group">
          <label class="col-md control-label">สถานะ <?php if($grant==2){echo "อนุมัติ";}else{echo "ไม่อนุมัติ";}?></label>
        </div>
          
      <?php if($grant==2){?>
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
    ?>  เป็นพนักงานขับรถในราชการนี้</label>    
        </div>  <!-- ส่วนของเจ้าหน้าที่  -->
          
      <div class="form-group">
          <label class="col-md control-label">รถที่ได้รับอนุญาต <?php  echo $car_type_name." $car_name  ทะเบียน ".$car_number;?>
              </label>
        </div>
      <div class="form-group">
          <label class="col-md control-label">ความคิดเห็น : <?=$officer_comment?></label>
        </div>
          
      <?php }?>
      </div>
      <div class="panel-footer"><h3 class="panel-title">ลงชื่อ <?=$officer_sign?> วดป <?=thai_date_4($officer_date)?></h3></div>
    </div>
<?php } ?>
</div>
<?php }?>