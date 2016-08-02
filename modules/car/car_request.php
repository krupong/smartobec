<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

$user=$_SESSION['login_user_id'];
//กรณีเลือกแสดงเฉพาะคัน
if(isset($_REQUEST['car_index'])){
    $car_index=$_REQUEST['car_index'];
}
else{
    $car_index="0";
}
if(!isset($_POST['private_car'])){
    $_POST['private_car']="";
}
?>
    <!--<BR>-->
    <!--<div class="container">-->
        <div class="panel panel-default">
            <?php 
//ส่วนหัว
if(!(($index==1)  or ($index==2) or ($index==5) or ($index==7))){
?>
                <div class="panel-heading">
                    <h3 class="panel-title">ทะเบียนการขออนุญาตใช้รถราชการ</h3></div>
                <?php 
}
//ส่วนฟอร์มรับข้อมูล  //ส่วนฟอร์มแก้ไขข้อมูล ed=1
if($index==1){
    $header="บันทึกขออนุญาตใช้รถราชการ";
    $code="";
    $name="";
    $disabled="";
    $car = "";
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
    $private_car="";
    $chk0="checked";
    $chk1="";
    $chk2="";
    $private_car_number="";
    $private_driver="";

    if(!empty($_GET['id'])) $id=$_GET['id'];
    else $id=0;
    if(!empty($_GET['page'])) $page=$_GET['page'];
    else $page=1;
    if(!empty($_GET['ed'])) $ed=$_GET['ed'];
    else $ed=0;

    if($ed!=0){
        $header="แก้ไขการขออนุญาตใช้รถราชการ";
        if($ed==2){
            $header="รายละเอียดการขออนุญาตใช้รถราชการ";
            $disabled="disabled";
        }
        $sql = "select a.*,c.name as car_type_name,b.car_number,b.name as car_name from  car_main a
        left outer join car_car b on a.car=b.car_code
        left outer join car_type c on c.code=b.car_type
        where a.id='$_GET[id]'";
        
        $dbquery = mysqli_query($connect,$sql);
        $result = mysqli_fetch_array($dbquery);
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
        $commander_grant=$result['commander_grant'];
        if($commander_grant==1){
            echo "เอกสารนี้ได้รับการอนุมัติเรียบร้อยแล้วไม่สามารถแก้ไขได้ ท่านกำลังทำผิดระเบียบของระบบ</div></div>";
            exit();
        }
    }
?>
                    <div class="panel-heading">
                        <h3 class="panel-title"><?=$header?></h3></div>
                    <div class="panel-body">
                        <form id='frm1' name='frm1' class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">เรื่อง</label>
                                <div class="col-sm-4 input-group">
                                    <label class="col-md control-label">ขออนุญาตใช้รถราชการ</label>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">เรียน</label>
                                <div class="col-sm-4 input-group">
                                    <label class="col-md control-label">ผู้อำนวยการสำนักอำนวยการ
                                    </label>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">ข้าพเจ้า</label>
                                <div class="col-sm-4 input-group">
                                    <label class="col-md control-label">
                                        <?php echo $_SESSION['login_prename'].$_SESSION['login_name']."&nbsp;&nbsp;".$_SESSION['login_surname']."&nbsp;&nbsp;ตำแหน่ง ".$_SESSION['login_userposition'];?>
                                    </label>
                                </div>
                            </div>
                            <hr>
<?php if($ed==2){
        $disabled_car="disabled";
?>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label text-right">รถที่ได้รับอนุญาต</label>
                                    <div class="col-sm-6 input-group">
                                        <label class="control-label">
                                            <?php echo $car_type_name." : ".$car_number." : ".$car_name;?>
                                        </label>
                                    </div>
                                </div>
                                <hr>
<?php 
    }
    ?>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label text-right">สถานที่ไปราชการ</label>
                                        <div class="col-sm-5 input-group">
                                            <Input Type='Text' Name='place' class="form-control" value="<?=$place?>" <?=$disabled?> >
                                        </div>
                                    </div><hr>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label text-right">เพื่อวัตถุประสงค์</label>
                                        <div class="col-sm-8 input-group">
                                            <Input Type='Text' Name='because' class="form-control" value="<?=$because?>" <?=$disabled?> >
                                        </div>
                                    </div><hr>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label text-right">ตั้งแต่วันที่</label>
                                        <div class="col-sm-4">
                                            <label>
                                                <div class="input-daterange input-group" id="datepicker">
                                                    <input type="text" class="input-xs form-control" name="car_start" id="car_start" placeholder="วันที่เริ่มต้น" value="<?=$car_start?>" />
                                                    <span class="input-group-addon">ถึงวันที่</span>
                                                    <input type="text" class="input-xs form-control" name="car_finish" id="car_finish" placeholder="วันที่สิ้นสุด" value="<?=$car_finish?>" />
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label text-right">ตั้งแต่เวลา*</label>
                                        <div class="col-sm-2">
                                            <label>
                                                <Select name="time_start" id="time_start" class="form-control" data-width="120px">
                                                    <?php
        for($i=1;$i<24;$i++){
            if($i==$time_start) $selected="selected";
            else if($i==5 && $time_start=="") $selected="selected";
            else $selected="";
            echo "<option value ='$i' $selected>".substr("0$i",-2).".00 น.</option>";
    }    
        ?>
                                                </Select>
                                            </label>
                                        </div>
                                        <div class="col-sm-1">
                                            <label class="control-label text-center">ถึงเวลา*</label>
                                        </div>
                                        <div class="col-sm-2">
                                            <label>
                                                <Select name="time_finish" id="time_finish" class="form-control" data-width="120px">
                                                    <?php
        for($i=1;$i<24;$i++){
            if($i==$time_finish) $selected="selected";
            else if($i==20 && $time_finish=="") $selected="selected";
            else $selected="";
            echo "<option value ='$i' $selected>".substr("0$i",-2).".00 น.</option>";
    }    
        ?>
                                                </Select>
                                            </label>
                                        </div>
                                    </div><hr>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label text-right">รวม</label>
                                        <div class="col-sm-2 input-group">
                                            <Input Type='number' Name='day_total' min=0 class="form-control" value="<?=$day_total?>" <?=$disabled?> ><span class="input-group-addon">&nbspวัน</span>
                                        </div>
                                    </div><hr>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label text-right">มีผู้โดยสารทั้งหมด</label>
                                        <div class="col-sm-2 input-group">
                                            <Input Type='number' Name='person_num' min=0 class="form-control" value="<?=$person_num?>" <?=$disabled?> ><span class="input-group-addon">คน</span>
                                        </div>
                                    </div><hr>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label text-right">ผู้ควบคุมรถคือ</label>
                                        <div class="col-sm-4 input-group">
                                            <Input Type='Text' Name='control_person' class="form-control" value="<?=$control_person?>" <?=$disabled?> >
                                        </div>
                                    </div><hr>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label text-right">เบอร์ติดต่อผู้ควบคุมรถคือ</label>
                                        <div class="col-sm-4 input-group">
                                            <Input Type='Text' Name='control_phone' class="form-control" value="<?=$control_phone?>" <?=$disabled?> >
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
                                                <select name="activity" title='เลือกจังหวัด' class='selectpicker show-tick' data-live-search='true'>
<?php
            for($ap=0; $ap<count($arr_province); $ap++){?>
            <option  value="<?php echo $arr_province[$ap];?>" <?php if('$activity'=='$arr_province[$ap]') echo 'selected';?> ><?php echo $arr_province[$ap];?></option>		
<?php } ?>	
                                                </select>
                                            </div>
                                            <!-- /input-group -->
                                        </div>
                                    </div><hr>
                                    
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label text-right"></label>
                                        <div class="col-sm-4">
                                            <INPUT TYPE='hidden' name='car_index' value=<?=$car_index?>>
                                            <label>
                                                <?php  if($ed!=2){?>
                                                    <button type="button" name="smb" class="btn btn-primary" onclick='goto_url_ed(<?=$ed?>,1)'>
                                                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>ตกลง
                                                    </button>&nbsp;
                                                    <?php }?>
                                                        <button type="button" name="back" class="btn btn-default" onclick='goto_url_ed(<?=$ed?>,0)'>
                                                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>ย้อนกลับ
                                                        </button>
                                            </label>
                                        </div>
                                    </div>
                                    <input type="hidden" name="id" value="<?=$id?>">
                        </form>
                    </div>
                    <?php
}
//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from car_main where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
}
//ส่วนบันทึกข้อมูล
if($index==4){
$rec_date = date("Y-m-d");
	if($_POST['fuel']==0){
	$_POST['money']=0;
	}
	if($_POST['fuel']!=2){
	$_POST['project']="";
	$_POST['activity']="";
	}
    $car_start = enyear_aclub($_POST['car_start']);
    $car_finish = enyear_aclub($_POST['car_finish']);
echo $sql = "insert into car_main ( person_id, rec_date, place, because, car_start, time_start, car_finish, time_finish, day_total, person_num, control_person,control_phone, fuel, activity,commander_grant) values ('$user', '$rec_date',  '$_POST[place]', '$_POST[because]', '$car_start', '$_POST[time_start]','$car_finish','$_POST[time_finish]','$_POST[day_total]', '$_POST[person_num]','$_POST[control_person]','$_POST[control_phone]', '$_POST[fuel]',   '$_POST[activity]',0)";
$dbquery = mysqli_query($connect,$sql);
    
    
//หาสิทธิ์  ส่งไปยัง ผอ กลุ่ม
    $sql_user_permis = "select b.person_id from  person_main a left outer join person_main b on a.sub_department=b.sub_department and b.position_other_code<>0 where  a.person_id='$_SESSION[login_user_id]'";
    $dbquery2 = mysqli_query($connect,$sql_user_permis);
    While ($result2 = mysqli_fetch_array($dbquery2)){
        $user_push=$result2['person_id'];
        $message="ประสงค์เดินทางวันที่ ".$_POST['car_start']." สถานที่ ".$_POST['place'];
        //smartpush($user_push,car,$message,"มีผู้ขอใช้ยานพาหนะ"); 
    }
    
}
//ส่วนปรับปรุงข้อมูล
if ($index==6){
	if($_POST['fuel']==0){
	$_POST['money']=0;
	}
	if($_POST['fuel']!=2){
	$_POST['project']="";
	$_POST['activity']="";
	}
    
    $car_start = enyear_aclub($_POST['car_start']);
    $car_finish = enyear_aclub($_POST['car_finish']);
    
		 $sql = "update car_main set 
		place='$_POST[place]',
		because='$_POST[because]',
		car_start='$car_start',
		time_start='$_POST[time_start]',
		car_finish='$car_finish',
		time_finish='$_POST[time_finish]',
		day_total='$_POST[day_total]',
		person_num='$_POST[person_num]',
		control_person='$_POST[control_person]',
		control_phone='$_POST[control_phone]',
		fuel='$_POST[fuel]',
		activity='$_POST[activity]'
		where id='$_POST[id]'";
		$dbquery = mysqli_query($connect,$sql);
    
    //หาสิทธิ์
    $sql_user_permis = "select b.person_id from  person_main a left outer join person_main b on a.sub_department=b.sub_department and b.position_other_code<>0 where  a.person_id='$_SESSION[login_user_id]'";
    $dbquery2 = mysqli_query($connect,$sql_user_permis);
    While ($result2 = mysqli_fetch_array($dbquery2)){
        $user_push=$result2['person_id'];
        $message="ประสงค์เดินทางวันที่ ".$_POST['car_start']." สถานที่ ".$_POST['place'];
        //smartpush($user_push,car,$message,"แก้ไขการขอใช้ยานพาหนะ"); 
    }
}
//ส่วนแสดงผล
if(!(($index==1) or ($index==5) or ($index==7))){
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

$sql="select a.*, b.name ,a.place,c.name as car_type_name,b.car_number,b.name as car_name
,CONCAT(d.prename,d.name,'  ',d.surname) as person_name
,CONCAT(e.prename,e.name,'  ',e.surname) as officer_name
,CONCAT(e2.prename,e2.name,'  ',e2.surname) as commander_name
from car_main a
left join car_car b on  a.car=b.car_code 
left join car_type c on c.code=b.car_type
left outer join person_main d on d.person_id=a.person_id
left outer join person_main e on e.person_id=a.officer_sign
left outer join person_main e2 on e2.person_id=a.commander_sign
where a.person_id = $user 
and ( b.car_number like '%$searchtext%' or b.name like '%$searchtext%' or a.place like '%$searchtext%' or a.because like '%$searchtext%' or '$searchtext'='')
and ( IFNULL(a.commander_grant,0)=$searchstatusid or $searchstatusid='999')
order by a.id desc";
?>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3 text-left">
                                    <a href="?option=car&task=car_request&index=1&car_index=<?=$car_index?>" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>ขออนุญาตใช้รถราชการ</a>
                                </div>
                                <div class="col-md-9 text-right">
                                    <form class="form-inline" action="#" enctype="multipart/form-data" method="POST">
                                        <div class="form-group">
                                            <label for="searchtext"></label>
                                            <input type="text" class="form-control" id="searchtext" name="searchtext" placeholder="พิมพ์คำค้นหา" value="<?php echo $searchtext; ?>">
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control" name="searchstatusid">
                                                <option value="999" <?php if($searchstatusid==999){ echo "selected"; } ?>>ทุกสถานะ</option>
                                                <option value="0" <?php if($searchstatusid==0){ echo "selected"; } ?>>รอ ผอ. กลุ่ม</option>
                                                <option value="1" <?php if($searchstatusid==1){ echo "selected"; } ?>>รอจัดรถ</option>
                                                <option value="2" <?php if($searchstatusid==2){ echo "selected"; } ?>>อนุมัติแล้ว</option>
                                                <option value="3" <?php if($searchstatusid==3){ echo "selected"; } ?>>ไม่อนุมัติ</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> ค้นหา</button>
                                        <a href="?option=car&task=car_request&action=select_clearsearchtext" class="btn btn-default"><span class="glyphicon glyphicon-list"></span> แสดงทั้งหมด</a>
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
                                    <th>สถานะ</th>
                                    <th>ลบ</th>
                                    <th>แก้ไข</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
$N=(($page-1)*$pagelen)+1; //*เกี่ยวข้องกับการแยกหน้า
$M=1;

 $sql = $sql." limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)){
		$id = $result['id'];
		$person_id = $result['person_id'];
		$car_start = $result['car_start'];
		$car_finish = $result['car_finish'];
		$time_start = $result['time_start'];
		$time_finish = $result['time_finish'];
		$rec_date = $result['rec_date'];
		$officer_sign = $result['officer_sign'];
		$officer_date = $result['officer_date'];
		$officer_comment = $result['officer_comment'];
		$grant_comment = $result['grant_comment'];
		$group_sign = $result['group_sign'];
		$grant = $result['commander_grant'];
		$commander_sign = $result['commander_sign'];
		$commander_date = $result['commander_date'];
		$commander_grant = $result['commander_grant'];
		$place = $result['place'];
        $driver = $result['driver'];
        $self_driver = $result['self_driver'];
        $car_type_name = $result['car_type_name'];
        $car_name = $result['car_name'];
        $car_number = $result['car_number'];
        $because = $result['because'];
        $day_total = $result['day_total'];
        $person_num=$result['person_num'];
        $control_person=$result['control_person'];
        $control_phone=$result['control_phone'];
        $project=$result['project'];
        $activity=$result['activity'];
        $money=$result['money'];
        $fuel=$result['fuel'];
        $private_car=$result['private_car'];
        $private_car_number=$result['private_car_number'];
        $private_driver=$result['private_driver'];
        $officer_name=$result['officer_name'];
        $commander_name=$result['commander_name'];
    ?>
        <Tr>
            <Td>
                <?=$N?>
            </Td>
            <Td>
                <?php echo thai_date_3($car_start);?>
            </Td>
            <Td>
                <?php echo thai_date_3($car_finish);?>
            </Td>
            <Td>
                <?php echo $result['car_name']." ".$result['car_number'];?>
            </Td>
            <Td>
                <?php echo $result['person_name'];?>
            </Td>
            <Td>
                <?php echo thai_date_3($rec_date);?>
            </Td>
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
                                                        <h3 class="panel-title">ลงชื่อ <?=$commander_name?> วดป <?php echo thai_date_4($commander_date);?> </h3></div>
                                                </div>
                                                <?php } ?>
                                    <?php
if($commander_grant>1){
?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">ส่วนเจ้าหน้าที่</h3></div>
                                            <div class="panel-body">
                                                <div class="form-group" <?php if($commander_grant==3) echo " style='display:none;'"; ?> >
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

                                                <div class="form-group" <?php if($commander_grant==3) echo " style='display:none;'"; ?>>
                                                    <label class="col-md control-label">
                                                        <?php echo "รถที่ได้รับอนุญาต " .$car_type_name." : ".$car_number." : ".$car_name;?>
                                                    </label>
                                                </div>
                                                <div class="form-group"  >
                                                    <label class="col-md control-label">ความคิดเห็น :
                                                        <?=$officer_comment?>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="panel-footer">
                                                <h3 class="panel-title">ลงชื่อ <?=$officer_name?> วดป <?=thai_date_4($officer_date)?></h3></div>
                                        </div>
                                        <?php } ?>

                                </div>
                                <!--       -->
                            </div>
                        </div>
                    </div>
                </div>
            </Td>
<?php  if($commander_grant==0 and ($person_id==$user)){?>
                <Td>
                    <a href=?option=car&task=car_request&index=3&id=<?=$id?>&page=<?=$page?>&car_index=<?=$car_index?> data-toggle='confirmation' class='btn btn-danger' data-title="คุณต้องการลบข้อมูลนี้ใช่หรือไม่" data-btn-ok-label="ใช่" data-btn-ok-icon="glyphicon glyphicon-share-alt" data-btn-ok-class="btn-success" data-btn-cancel-label="ไม่ใช่!" data-btn-cancel-icon="glyphicon glyphicon-ban-circle" data-btn-cancel-class="btn-danger">
<span class='glyphicon glyphicon-trash'></span>  ลบ
</a>
                </Td>
                <Td>
                    <a href=?option=car&task=car_request&index=1&id=<?=$id?>&page=<?=$page?>&car_index=<?=$car_index?>&ed=1 class='btn btn-warning'><span class='glyphicon glyphicon-pencil' ></span> แก้ไข</a>
                </Td>
<?php }else if($commander_grant==2){
?>
                <Td colspan=2>
                    <a href='modules/car/car_print.php?id=<?=$id?>' target='_blank' class='btn btn-primary'><span class='glyphicon glyphicon-print' ></span> พิมพ์เอกสาร</a>
                </Td>
<?php }else{
?>
                    <td colspan=2></td>
                    <?php }?>
        </Tr>
                                    <?php 
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
}
?>
                            </tbody>
                        </table>
                        <?php
}
?>
                                        </div>
    <!--</div>-->
<script>
    function goto_url_ed(ed, val) {
        if (val == 0) {
            callfrm("?option=car&task=car_request"); // page ย้อนกลับ
        } else if (val == 1) {
            if (frm1.place.value == "") {
                alert("กรุณากรอกสถานไปราชการ");
            } else if (frm1.because.value == "") {
                alert("กรุณากรอกวัตถุประสงค์");
            } else if (frm1.control_person.value == "") {
                alert("กรุณากรอกผู้ควบคุมรถ");
            } else if (frm1.control_phone.value == "") {
                alert("กรุณากรอกเบอร์ติดต่อ");
            } else {
                if (ed == 0) {
                    callfrm("?option=car&task=car_request&index=4"); //page ประมวลผล
                } else {
                    callfrm("?option=car&task=car_request&index=6"); //page ประมวลผล
                }
            }
        }
    }
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
