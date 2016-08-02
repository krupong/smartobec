<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
?>
<script type="text/javascript">
    $(function(){
        $("select#car_type").change(function(){
            var datalist2 = $.ajax({	// รับค่าจาก ajax เก็บไว้ที่ตัวแปร datalist2
                  url: "modules/car/ajax/return_ajax_car.php", // ไฟล์สำหรับการกำหนดเงื่อนไข
                  data:"car_type="+$(this).val(), // ส่งตัวแปร GET ชื่อ car_type ให้มีค่าเท่ากับ ค่าของ department
                  async: false
            }).responseText;
            $("select#car").html(datalist2); // นำค่า datalist2 มาแสดงใน listbox ที่ 2
            // ชื่อตัวแปร และ element ต่างๆ สามารถเปลี่ยนไปตามการกำหนด
        });
    });
</script>
<?php
$user=$_SESSION['login_user_id'];
//กรณีเลือกแสดงเฉพาะคัน
if(isset($_REQUEST['car_index'])){
$car_index=$_REQUEST['car_index'];
}
else{
$car_index="0";
}

//ส่วนหัว
?>
<BR>
<div class="container">
  <div class="panel panel-default">
<?php 
$from="";
if(isset($_GET['from']))$from=$_GET['from'];
$subm="";
if(isset($_GET['subm']))$subm=$_GET['subm'];

if(!(($index==1)  or ($index==2) or ($index==5) or ($index==7))){
    $header = "ทะเบียนการขออนุญาตใช้รถราชการ";
    if($subm=="car_driverjob"){
        $header="ภาระกิจที่ได้รับมอบหมาย";
    }
    ?><div class="panel-heading"><h3 class="panel-title"><?=$header?></h3></div><?php 
}
//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
    $header="บันทึกขออนุญาตใช้รถราชการ";
    $code="";
    $name="";
    $disabled="";
    $disabled_car="";
    $disabled2="";
    $car = "";
    $car_type = "";
    $place="";
    $because="";
    $car_start="";
    $time_start="";
    $car_finish="";
    $time_finish="";
    $day_total="";
    $person_num="";
    $control_person="";
    $control_phone="";
    $project="";
    $activity="";
    $money="";
    $self_driver="";
    $private_car="";
    $chk0="checked";
    $chk1="";
    $chk2="";
    $private_car_number="";
    $private_driver="";
    $officer_comment="";
    $driver="";
    $officer_sign="";
    $group_comment="";
    $group_sign="";
    $group_date="";
    $grant_comment="";
    $cG1="";
    $cG2="";
    $commander_sign="";
    $commander_date="";

    if(!empty($_GET['id'])) $id=$_GET['id'];
    else $id=0;
    if(!empty($_GET['page'])) $page=$_GET['page'];
    else $page=1;
    if(!empty($_GET['ed'])) $ed=$_GET['ed'];
    else $ed=0;

    if($ed!=0){
        $disabled="disabled";
        $header="แก้ไขการขออนุญาตใช้รถราชการ";
        if($ed==1 || $subm=="car_group" || $subm=="car_commander"){
            $disabled2="disabled";
        }else if($ed==2){
            $header="ความเห็นเจ้าหน้าที่";
        }
        if($from=="oil_withdraw")$header="รายละเอียดการขออนุญาตใช้รถราชการ";
        if($subm=="car_group")$header="ความเห็นชอบ";
        else if($subm=="car_commander")$header="อนุมัติการขอใช้ยานพาหนะ";
         $sql = "select a.*
        ,b.prename,b.name,b.surname
        ,CONCAT(aa.prename,aa.name,' ',aa.surname) as person_name
        ,c.prename as prename_gs,c.name as name_gs,c.surname as surname_gs 
        ,d.prename as prename_cs,d.name as name_cs,d.surname as surname_cs 
        ,e.car_type,a3.position_name 
        from  car_main a 
        left outer join person_main aa on aa.person_id=a.person_id  
        left outer join person_position a3 on a3.position_code=aa.position_code 
        left outer join person_main b on a.officer_sign=b.person_id  
        left outer join person_main c on a.group_sign=c.person_id 
        left outer join person_main d on a.commander_sign=d.person_id
        left outer join car_car e on a.car=e.car_code
        where a.id='$id'";
        $dbquery = mysqli_query($connect,$sql);
        $result = mysqli_fetch_array($dbquery);
        $car = $result['car'];
        $car_type = $result['car_type'];
        $place=$result['place'];
        $because=$result['because'];
        $car_start=$result['car_start'];
        $time_start=number_format($result['time_start'],2);
        $car_finish=$result['car_finish'];
        $time_finish=number_format($result['time_finish'],2);
        $day_total=$result['day_total'];
        $person_num=$result['person_num'];
        $control_person=$result['control_person'];
        $control_phone=$result['control_phone'];
        $project=$result['project'];
        $activity=$result['activity'];
        $money=$result['money'];
        $self_driver="";
        if($result['self_driver']==1) $self_driver="checked";
        $private_car="";
        if($result['private_car']==1) $private_car="checked";
        $chk0="";
        $chk1="";
        $chk2="";
        if($result['fuel']==0){
            $chk0="checked";
        }else if($result['fuel']==1){
            $chk1="checked";
        }else{
            $chk2="checked";
        }
        $private_car_number=$result['private_car_number'];
        $private_driver=$result['private_driver'];
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
        $person_name=$result['person_name'];
        $position_name=$result['position_name'];
        $cG1="";
        $cG2="";
        if($commander_grant==1)$cG1="checked";
        else if($commander_grant==3)$cG1="checked";
        
        $color="";
        if($officer_sign != ""){
            if($subm=="car_commander" || $ed==1){
                $disabled_car="disabled";
            }
        }

    }
?>
<div class="panel-heading"><h3 class="panel-title"><?=$header?></h3></div>
<div class="panel-body">
    <form id='frm1' name='frm1' class="form-horizontal">
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">เรื่อง</label>
          <div class="col-sm-4 input-group">
            <label class="col-md control-label">ขออนุญาตใช้รถราชการ</label>
          </div>
        </div><hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">เรียน</label>
          <div class="col-sm-4 input-group">
            <label class="col-md control-label">ผู้อำนวยการสำนักอำนวยการ</label>
          </div>
        </div><hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">ข้าพเจ้า</label>
          <div class="col-sm-4 input-group">
            <label class="col-md control-label"><?php echo $person_name."&nbsp;&nbsp;ตำแหน่ง ".$position_name;?></label>
          </div>
        </div><hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">สถานที่ไปราชการ</label>
          <div class="col-sm-5 input-group"><Input Type='Text' Name='place' class="form-control" value="<?=$place?>" <?=$disabled?> >
          </div>
        </div><hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">เพื่อวัตถุประสงค์</label>
          <div class="col-sm-8 input-group"><Input Type='Text' Name='because' class="form-control" value="<?=$because?>" <?=$disabled?> >
          </div>
        </div><hr>
      <div class="form-group">
            <label class="col-sm-3 control-label text-right">ตั้งแต่วันที่</label>
            <div class="col-sm-2 input-group">
                <div class="input-group">
                    <input type="text" class="form-control" name="car_start" value="<?=thyear_aclub($car_start)?>" <?=$disabled?> >
                    <span class="input-group-addon" <?php if($disabled!=""){?>style="display:none;"<?php }?> >
                        <i class="glyphicon glyphicon-th"></i>
                    </span>
                </div>
            </div>
            </div><hr>          
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">เวลา</label>
          <div class="col-sm-2 input-group"><Input Type='Text' Name='time_start' class="form-control" value="<?=$time_start?>"  <?=$disabled?>  ><span class="input-group-addon">&nbspน.</span>
          </div>
        </div><hr>
      <div class="form-group">
            <label class="col-sm-3 control-label text-right">ถึงวันที่</label>
            <div class="col-sm-2 input-group">
                <div class="input-group">
                    <input type="text" class="form-control" name=car_finish value="<?=thyear_aclub($car_finish)?>"  <?=$disabled?>  >
                    <span class="input-group-addon" <?php if($disabled!=""){?>style="display:none;"<?php }?> >
                        <i class="glyphicon glyphicon-th"></i>
                    </span>
                </div>
            </div>
            </div><hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">เวลา</label>
          <div class="col-sm-2 input-group"><Input Type='Text' Name='time_finish' class="form-control" value="<?=$time_finish?>"  <?=$disabled?>  ><span class="input-group-addon">&nbspน.</span>
          </div>
        </div><hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">รวม</label>
          <div class="col-sm-2 input-group"><Input Type='Text' Name='day_total' class="form-control" value="<?=$day_total?>"  <?=$disabled?>  ><span class="input-group-addon">&nbspวัน</span>
          </div>
        </div><hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">มีผู้โดยสารทั้งหมด</label>
          <div class="col-sm-2 input-group"><Input Type='Text' Name='person_num' class="form-control" value="<?=$person_num?>"  <?=$disabled?>  ><span class="input-group-addon">&nbsp;&nbsp;คน</span>
          </div>
        </div><hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">ผู้ควบคุมรถคือ</label>
          <div class="col-sm-4 input-group"><Input Type='Text' Name='control_person' class="form-control" value="<?=$control_person?>"  <?=$disabled?>  >
          </div>
        </div><hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">เบอร์ติดต่อผู้ควบคุมรถคือ</label>
          <div class="col-sm-4 input-group"><Input Type='Text' Name='control_phone' class="form-control" value="<?=$control_phone?>"  <?=$disabled?>  >
          </div>
        </div><hr>
          
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label text-right">เชื้อเพลิง</label>
                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                <input type="radio" aria-label="..." name='fuel' value='0' <?=$chk0?> <?=$disabled?>></input>
            </span>
                                                <input type="text" class="form-control" value="ไม่ขอใช้งบประมาณ" readonly>
                                            </div>
                                            <!-- /input-group -->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label text-right"></label>
                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                <input type="radio" aria-label="..." name='fuel' value='1' <?=$chk1?> <?=$disabled?>>
            </span>
                                                <input type="text" class="form-control" value="โครงการในเขต กทม/ปริมณฑล" readonly>
                                            </div>
                                            <!-- /input-group -->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label text-right"></label>
                                        <div class="col-sm-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                <input type="radio" aria-label="..." name='fuel' value='2' <?=$chk2?> <?=$disabled?>>
            </span>
                                                <input type="text" class="form-control" value="โครงการนอกเขต กทม/ปริมณฑล" readonly>
                                                <select name="activity" title='เลือกจังหวัด' class='selectpicker show-tick' data-live-search='true' disabled>
<?php
            for($ap=0; $ap<count($arr_province); $ap++){?>
            <option  value="<?=$arr_province[$ap]?>" <?php if($activity==$arr_province[$ap])echo 'selected';?> ><?=$arr_province[$ap]?></option>		
<?php } ?>	
                                                </select>
                                            </div>
                                            <!-- /input-group -->
                                        </div>
                                    </div><hr>
      <?php 
        $disabled="";
        if($commander_grant==1) $disabled="disabled";
      ?>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">ส่วนการอนุมัติ:</label>
          <div class="col-sm-5 input-group"><span class="input-group-addon">คำสั่ง(ถ้ามี)</span><Input Type='Text' Name='grant_comment' class="form-control" value="<?=$grant_comment?>"  <?=$disabled?>  >
          </div>
        </div>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right"></label>
          <div class="col-sm-2 input-group">
            <span class="input-group-addon">
                <input type="radio" aria-label="..." name='commander_grant' value='1' <?=$disabled?> <?=$cG1?> ></input>
            </span>
            <input type="text" class="form-control" value="อนุมัติ" readonly  >
          </div>
        </div>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right"></label>
          <div class="col-sm-2 input-group">
            <span class="input-group-addon">
                <input type="radio" aria-label="..." name='commander_grant' value='3' <?=$disabled?>  <?=$cG2?> ></input>
            </span>
            <input type="text" class="form-control" value="ไม่อนุมัติ" readonly>
          </div>
        </div>
      <div class="form-group">
        <?php if($commander_grant==1){?>
          <label class="col-sm-3 control-label text-right"></label>
          <div class="col-sm-4 input-group"><span class="input-group-addon">ลงชื่อ</span><Input Type='Text' Name='commander_sign' class="form-control" value="<?=$commander_sign?>" disabled >
          </div>
        </div>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right"></label>
          <div class="input-group col-sm-4"><span class="input-group-addon" id="basic-addon2">วดป</span><Input Type='Text' Name='commander_date' class="form-control" value="<?=thai_date_4($commander_date)?>" disabled>
          </div>
        </div><hr>
          <?php }?>
    

<?php
        if($commander_grant==1){
?>
          <div class="form-group">
          <label class="col-sm-3 control-label text-right">ส่วนเจ้าหน้าที่</label>
          <div class="col-sm-3 input-group">
            <span class="input-group-addon">
                <input type="radio" aria-label="..." name='commander_grant2' value='2'></input>
            </span>
            <input type="text" class="form-control" value="อนุมัติ" readonly>              
            <span class="input-group-addon">
                <input type="radio" aria-label="..." name='commander_grant2' value='3' ></input>
            </span>
            <input type="text" class="form-control" value="ไม่อนุมัติ" readonly>
          </div>
          <div class="col-sm-2 input-group">
          </div>
        </div>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right"></label>
          <div class="col-sm-6 input-group"><span class="input-group-addon">เห็นควรให้</span>
              <Select  name='driver' title='เลือกพนักงานขับรถ' class='selectpicker show-tick' data-live-search='true'>
                    <option  value = ''>เลือกพนักงานขับรถ</option>
<?php 
                    $sql_driver= "select  car_driver.person_id, person_main.prename, person_main.name, person_main.surname from car_driver left join person_main  on car_driver.person_id=person_main.person_id ";
    $dbquery_driver = mysqli_query($connect,$sql_driver);
    While ($result_driver = mysqli_fetch_array($dbquery_driver)){
		$person_id = $result_driver['person_id'];
		$prename = $result_driver['prename'];
		$name = $result_driver['name'];
		$surname = $result_driver['surname'];
        $selected="";
		if($person_id==$driver) $selected="selected";
        /*
        $sql_ajax2 = "select * from car_main 
    where driver='$person_id' and ('$car_start' between car_start and car_finish)";
        $dbquery_ajax2 = mysqli_query($connect,$sql_ajax2);
        $num_rows = mysqli_num_rows($dbquery_ajax2);
        */
        $num_rows=0;
        if($num_rows==0){
		  echo  "<option value ='$person_id' $selected>$prename$name $surname</option>";
        }
	}
    ?>
</select><span class="input-group-addon"> เป็นพนักงานขับรถในราชการนี้</span>
          </div>
        </div>  <!-- ส่วนของเจ้าหน้าที่  -->
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">อนุญาตให้ใช้รถ</label>
          <div class="col-sm-6 input-group">
              <div style="display:inline-block">
                <Select  name='car' id='car' title='เลือกรถ' class='selectpicker show-tick' data-live-search='true'>
                    <option  value = ''>เลือกรถ</option>
                    <?php
$sql_ajax = "select a.*,b.name as car_type_name from  car_car a left outer join car_type b on a.car_type=b.code order by b.name,a.car_number";
$query_ajax = mysqli_query($connect,$sql_ajax);

while($result_ajax = mysqli_fetch_array($query_ajax)){
	$car_number = $result_ajax['car_number'];
    $car_code = $result_ajax['car_code'];
	$name = $result_ajax['name'];
    $car_type_name = $result_ajax['car_type_name'];
    /*
    $sql_ajax2 = "select id from car_main 
    where car='$car_code' and ('$car_start' between car_start and car_finish)";
    $dbquery_ajax2 = mysqli_query($connect,$sql_ajax2);
    $num_rows = mysqli_num_rows($dbquery_ajax2);
    */
    $num_rows=0;
    if($num_rows==0){
        echo "<option value='$car_code'>$car_type_name $name ทะเบียน $car_number</option>";
    }
}
                    ?>
                    </select></div>
          </div>
        </div>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right"></label>
          <div class="col-sm-8 input-group"><span class="input-group-addon">ความคิดเห็น</span><Input Type='Text' Name='officer_comment' class="form-control" value="<?=$officer_comment?>"  <?=$disabled2?>  >
          </div>
        </div>
        
<?php
}
?>

        <div class="form-group">
          <label class="col-sm-3 control-label text-right"></label>
          <div class="col-sm-4">
            <INPUT TYPE='hidden' name='car_index' value=<?=$car_index?>>
            <label >
                <?php 
    if($ed==2){
        $pic="remove";
    }else{
        $pic="repeat";
        if($from != "") $ed=3;
    }
                ?>
                <?php  if($ed==2){?>
                <button type="button" name="smb" class="btn btn-primary" onclick='goto_url_ed(<?=$ed?>,1)'>
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> ตกลง
                </button>&nbsp;
                <?php }?>
                <button type="button" name="back" class="btn btn-default" onclick='goto_url_ed(<?=$ed?>,0)'>
                    <span class="glyphicon glyphicon-<?=$pic?>" aria-hidden="true"></span> ย้อนกลับ  
                </button>
            </label>
          </div>
        </div> <!-- from OK and BACK -->
            <input type="hidden" name="id" value="<?=$id?>">
    </form>
</div>
<?php 
}
//ส่วนปรับปรุงข้อมูล
if ($index==6){
    $date_time_now = date("Y-m-d H:i:s");
    if($subm=="car_commander"){
        $date_time_now = date("Y-m-d H:i:s");
		$sql = "update car_main set commander_sign='$user',
		commander_grant='$_POST[commander_grant]',
		commander_date='$date_time_now',
		grant_comment='$_POST[grant_comment]'
		where id='$_POST[id]'";
		$dbquery = mysqli_query($connect,$sql);
        
        //หาสิทธิ์
        $sql_user_permis="select person_id from car_permission where p1=1 ";
        $dbquery2 = mysqli_query($connect,$sql_user_permis);
        While ($result2 = mysqli_fetch_array($dbquery2)){
            $user_push=$result2['person_id'];
            if($_POST['commander_grant']==1){
                $message="มีเอกสารขอใช้รถอนุมัติเรียบร้อยแล้วมารอเพื่อดำเนินการจัดรถ";
            }else{
                $message="เอกสารไม่ได้รับการอนุมัติ";
            }
            //smartpush($user_push,car,$message,"สถานะการขอใช้ยานพาหนะ"); 
        }
    }else{
        if($_POST['commander_grant2']<>3){
            $sql = "update car_main set driver='$_POST[driver]',
            officer_comment='$_POST[officer_comment]',
            car='$_POST[car]',
            officer_sign='$user',
            officer_date='$date_time_now',
            commander_grant='$_POST[commander_grant2]'
            where id='$_POST[id]'";
            $dbquery = mysqli_query($connect,$sql);
        }else{
            $sql = "update car_main set driver='',
            officer_comment='$_POST[officer_comment]',
            car='',
            officer_sign='$user',
            officer_date='$date_time_now',
            commander_grant='$_POST[commander_grant2]'
            where id='$_POST[id]'";
            $dbquery = mysqli_query($connect,$sql);
        }
        
        //หาสิทธิ์
         $sql_user_permis="select person_id,b.name,b.car_number,a.car_start,a.place,a.driver,a.commander_grant from car_main a left outer join car_car b on a.car=b.car_code where a.id='$_POST[id]'";
        $dbquery2 = mysqli_query($connect,$sql_user_permis);
        While ($result2 = mysqli_fetch_array($dbquery2)){
            $user_push=$result2['person_id'];
            $car_start=$result2['car_start'];
            $place=$result2['place'];
            $driver = $result2['driver'];
            $name = $result2['name'];
            $car_number = $result2['car_number'];
            
            $commander_grant = $result2['commander_grant'];
            if($commander_grant==2){
                $message="อนุมัติเรียบร้อยแล้ว รถที่ถูกจัดให้คือ ".$result2['name']." ทะเบียนคือ ".$result2['car_number'];
            }else{
                $message="เอกสารไม่ได้รับการอนุมัติ";
            }
            //smartpush($user_push,car,$message,"สถานะการขอใช้ยานพาหนะ"); 
        }
        if($driver != ""){
             $message="อนุมัติเรียบร้อยแล้ว รถที่ถูกจัดให้คือ ".$name." ทะเบียนคือ ".$car_number;
            //smartpush($driver,car,$message,"อนุมัติการขอใช้ยานพาหนะมาถึงคุณ"); 
        }
        
    }
}
//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5) or ($index==7))){
//ส่วนของการแยกหน้า

$car_start="";
$car_finish="";
$car_start2="";
$car_finish2="";
$action="";
$dep_search="999";
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
    if($from=="altclk") $searchstatusid=1;
    if(isset($_POST['car_start'])!=""){
        if($_POST['car_start'] !="") $car_start = enyear_aclub($_POST['car_start']);
        if($car_start !="") $car_start2 = thyear_aclub($car_start);
    
    }
    if(isset($_POST['car_finish'])!=""){
        if($_POST['car_finish'] !="") $car_finish = enyear_aclub($_POST['car_finish']);
        if($car_finish !="") $car_finish2 = thyear_aclub($car_finish);
        
    }
    if(isset($_POST['dep_search'])!=""){
        $dep_search=$_POST['dep_search'];
        if($dep_search=="") $dep_search="999";
    }
}
       $sql = "select a.*,IFNULL(a.commander_grant,0) as commander_grant2
        ,b.prename,b.name,b.surname
        ,c.prename as prename_gs,c.name as name_gs,c.surname as surname_gs 
        ,d.prename as prename_cs,d.name as name_cs,d.surname as surname_cs 
        ,e.car_type,f.name as car_type_name,e.car_number,e.name as car_name
        ,CONCAT(aa.prename,aa.name,'  ',aa.surname) as person_name
        ,g.position_name,h.department_name,h.department_precis 
        from  car_main a 
        left outer join person_main aa on a.person_id=aa.person_id
        left outer join person_main b on a.officer_sign=b.person_id  
        left outer join person_main c on a.group_sign=c.person_id 
        left outer join person_main d on a.commander_sign=d.person_id
        left outer join car_car e on a.car=e.car_code
        left outer join car_type f on f.code=e.car_type
        left outer join person_position g on g.position_code=aa.position_code
        left outer join system_department h on h.department=aa.department  
        where ( e.car_number like '%$searchtext%' or e.name like '%$searchtext%' or a.place like '%$searchtext%' or a.because like '%$searchtext%' or '$searchtext'='') 
        and (h.department='$dep_search' or '$dep_search'='999')  
        and ( (a.car_start between '$car_start' and '$car_finish' ) or '$car_start'='')
        and ( (a.car_finish between '$car_start' and '$car_finish' ) or '$car_finish'='')
        
        ";       
        if($subm=="car_commander"){
            if ($_SESSION['login_group']<=4 and $result_permission['p1']==1)
            $sql = $sql. " and a.commander_grant=0 
            order by a.commander_grant ,a.car_start ";
            else
            $sql = $sql. " and a.commander_grant=0
            and aa.sub_department = $login_dep 
            order by a.commander_grant ,a.car_start ";
        }
        else if($subm=="")        
            $sql = $sql. "and ( IFNULL(a.commander_grant,0)=$searchstatusid or '$searchstatusid'='999')  order by a.commander_grant ,a.car_start,a.car_finish ";

    ?>
      <div class="panel-body">
        <div class="row">
            <div class="text-center">
               <form class="form-inline" action="?option=car&task=car_officer<?php echo "&subm=".$subm;?>" enctype="multipart/form-data" method="POST">
    <div class="form-group">
        <label for="searchtext"></label>
        <input type="text" class="form-control" id="searchtext" name="searchtext" placeholder="พิมพ์คำค้นหา" value="<?php echo $searchtext; ?>">
    </div>
    <div class="form-group">
        <div class="input-daterange input-group" id="datepicker">
            <input type="text" class="input-xs form-control" name="car_start" id="car_start" placeholder="วันที่เริ่มต้น" value="<?=$car_start2?>" />
            <span class="input-group-addon">ถึงวันที่</span>
            <input type="text" class="input-xs form-control" name="car_finish" id="car_finish" placeholder="วันที่สิ้นสุด" value="<?=$car_finish2?>" />
        </div>
    </div>
 <Select  name='dep_search' title='เลือกสำนัก' class='selectpicker show-tick' data-live-search='true'>
     <option value="999">เลือกสำนัก</option>
<?php 
                    $sql_dep= "select  * from system_department order by department_name";
    $dbquery_dep = mysqli_query($connect,$sql_dep);
    While ($result_dep = mysqli_fetch_array($dbquery_dep)){
        $selected="";
        if($dep_search==$result_dep['department']) $selected="selected";
        echo "<option value='".$result_dep['department']."' $selected>".$result_dep['department_name']."</option>";
	}
    ?>
</select>
    <?php if($subm==""){?>
        <div class="form-group">
            <select class="form-control" name="searchstatusid">
                <option value="999" <?php if($searchstatusid==999){ echo "selected"; } ?>>ทุกสถานะ</option>
                <option value="0" <?php if($searchstatusid==0){ echo "selected"; } ?>>รอ ผอ. กลุ่ม</option>
                <option value="1" <?php if($searchstatusid==1){ echo "selected"; } ?>>รอจัดรถ</option>
                <option value="2" <?php if($searchstatusid==2){ echo "selected"; } ?>>อนุมัติแล้ว</option>
                <option value="3" <?php if($searchstatusid==3){ echo "selected"; } ?>>ไม่อนุมัติ</option>
            </select>
        </div>
        <?php }?>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> ค้นหา</button>
            <?php if($subm==""){?>
                <a href="?option=car&task=car_officer&action=select_clearsearchtext" class="btn btn-default"><span class="glyphicon glyphicon-list"></span> แสดงทั้งหมด</a>
                <?php }?>
                    <div class="form-group">
                        <!--   SPLITER PAGES    -->
                        <?php 
// split page
    $page="";
    $pagelen=20;
    if(!isset($_REQUEST['page']))   $page=1;
    else    $page=$_REQUEST['page'];
    $url_link="option=car&task=car_officer&searchtext=$searchtext&searchstatusid=$searchstatusid";  
    PAGESPLIT($sql,$connect,$page,$PHP_SELF,$url_link,$pagelen);
    $start=PAGESPLIT_START($sql,$connect,$page,$pagelen);
// split page    
?>
                    </div>
                    <!--SPLITER PAGES-->
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
              <th>เบอร์ติดต่อ</th>
              <th>สำนัก</th>
              <th>วดป ขออนุญาต</th>
              <th>สถานะ</th>
                <?php 
                if($subm=="car_commander"){
                    echo "<th>บันทึก</th>";
                }else{
                    echo "<th>เจ้าหน้าที่</th>";
                }
                ?>
            </tr>
          </thead>
          <tbody>
        <?php 

$sql = $sql." limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);
$N=(($page-1)*$pagelen)+1; //*เกี่ยวข้องกับการแยกหน้า
$M=1;

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
        $control_phone=$result['control_phone'];
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
        $depname=$result['department_name'];
        $depprecis=$result['department_precis'];
    
?>

<Tr>
    <Td><?=$N?></Td>
    <Td><?php  echo thai_date_3($car_start);?></Td>
    <Td><?php  echo thai_date_3($car_finish);?></Td>
    <Td><?php  echo $car_name." ".$car_number;?></Td>
    <Td><?php  echo $result['person_name'];?></Td>
    <Td><?php  echo $control_phone;?></Td>
    <Td><a tabindex='0' class='btn' role='button' data-toggle='popover' data-placement='top' data-trigger='focus' title='หน่วยงาน' data-content='<?php echo $depname;?>'><?php echo $depprecis;?></a></Td>
    <Td><?php  echo thai_date_3($rec_date);?></Td>
    <Td>
                <?php 
if($commander_grant==0){
$value_cm = 40;
$txt_progress = "รอ ผอ. กลุ่ม";
$txtbtn = "default";
$txtspan = "star";
$txt = $txt_progress;
}
    else if($commander_grant==1){
$value_cm=80;  
$txt_progress = "รอจัดรถ";          
$txtbtn = "info";
$txtspan = "edit";
$txt = $txt_progress;
}
    else if($commander_grant==2){
$value_cm=100;
$txt_progress = "การขอใช้ยานพาหนะของท่านเสร็จสมบูรณ์";
$txtbtn = "success";
$txtspan = "ok";
$txt = "อนุมัติแล้ว";
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
                                                    <?php echo $result['person_name']."&nbsp;&nbsp;ตำแหน่ง ".$result['position_name'];?>
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
                                                    <?=thai_date_3($car_start)?> เวลา :
                                                        <?php echo number_format($time_start,2)?> น. </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md control-label">ถึงวันที่ :
                                                    <?=thai_date_3($car_finish)?> เวลา :
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
                                                <label class="col-md control-label ">เบอร์ติดต่อผู้ควบคุมรถคือ
                                                    <?=$control_phone?>
                                                </label>
                                            </div>
                                            
                                            <div class="form-group">
                                                <?php if($fuel==0){?>
                                                    <label class="col-md control-label ">เชื้อเพลิง : ไม่ขอใช้งบประมาณ</label>
                                                    <?php }else if($fuel==1){?>
                                                        <label class="col-md control-label ">เชื้อเพลิง : โครงการในเขต กทม/ปริมณฑล</label>
                                                        <?php }else if($fuel==2){?>
                                                            <label class="col-md control-label ">
                                                                <?php echo "เชื้อเพลิง : โครงการนอกเขต กทม/ปริมณฑล จังหวัด $activity";?></label>
                                                            <?php }?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
if($commander_grant>0){
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
                                                                <?php if($grant>0 && $grant<3){echo "อนุมัติแล้ว";}else{echo "ไม่อนุมัติ";}?>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="panel-footer">
                                                        <h3 class="panel-title">ลงชื่อ <?=$commander_sign?> วดป <?php echo thai_date_4($commander_date);?> </h3></div>
                                                </div>
                                                <?php } ?>
                                    <?php
if($commander_grant>1){
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
                                            
                                </div>
                                <!--       -->
                            </div>
                        </div>
                    </div>
                </div>
            </Td>

<?php
if( ($commander_grant==0 and $subm=="car_commander") or $commander_grant==1){
    ?>
    <Td><a href=?option=car&task=car_officer&car_index=<?=$car_index?>&page=<?=$page?>&index=5&id=<?=$id?>&ed=2&subm=<?=$subm?> class='btn btn-warning'><span class='glyphicon glyphicon-pencil' ></span> อนุมัติเอกสาร</a></Td>
        <?php 
}else if($commander_grant==2){
?>
                <Td colspan=2>
                    <a href='modules/car/car_print.php?id=<?=$id?>' target='_blank' class='btn btn-primary'><span class='glyphicon glyphicon-print' ></span> พิมพ์เอกสาร</a>
                </Td>
<?php }
else{
echo "<td></td>";
}
?></Tr>
<?php 
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
}
?>

          </tbody>
    </Table>
<?php }?>
    </div>
    </div>
<script>
function goto_url_ed(ed,val){
	if(val==0){
        if(ed==3){
            callfrm("?option=car&task=<?=$from?>");
        }else{
            callfrm("?option=car&task=car_officer&subm=<?=$subm?>");   // page ย้อนกลับ
        }
	}else if(val==1){
        if("<?=$subm?>"=="car_commander"){
            if(frm1.commander_grant.value==""){
                alert("กรุณาระบุเลือก อนุมัติหรือไม่อนุมัติ");
            }else{
                callfrm("?option=car&task=car_officer&index=6&subm=<?=$subm?>");
            }
        }else if(frm1.commander_grant2.value==""){
            alert("กรุณาระบุเลือก อนุมัติหรือไม่อนุมัติ");
        }else if(frm1.driver.value == "" && frm1.commander_grant2.value=="2"){
            alert("กรุณาเลือกพนักงานขับรถ");
        }else if(frm1.car.value == "" && frm1.commander_grant2.value=="2"){
            alert("กรุณาเลือกยานพาหนะ");
        }else{
            if(ed==2){
                if("<?=$subm?>"=="car_commander"){
                    if(frm1.commander_grant.value==""){
                        alert("กรุณาระบุเลือก อนุมัติหรือไม่อนุมัติ");
                    }else{
                        callfrm("?option=car&task=car_officer&index=6&subm=<?=$subm?>");
                    }
                }else{
                    callfrm("?option=car&task=car_officer&index=6&subm=<?=$subm?>");   
                }
            }else{
            }
        }
	}
}
</script>
<script type="text/javascript">
    $(function () {
        $('.input-group.date').datepicker({
            format: "yyyy-mm-dd",
            language: "th"
        });

    });
</script>
            
<script type="text/javascript">
        $(function() {
            $('.input-daterange').datepicker({
                orientation: "bottom auto",
                format: 'dd/mm/yyyy',
                autoclose: true,
                language: "th-th"
            });

        });
    </script>
