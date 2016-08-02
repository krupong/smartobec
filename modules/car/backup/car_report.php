<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
require_once "modules/car/time_inc.php";

$user=$_SESSION['login_user_id'];
//กรณีเลือกแสดงเฉพาะคัน
if(isset($_REQUEST['car_index'])){
$car_index=$_REQUEST['car_index'];
}
else{
$car_index="";
}
$sql_name = "select * from person_main ";
$query_name = mysqli_query($connect,$sql_name);
while($result_name = mysqli_fetch_array($query_name)){;
		$person_id = $result_name['person_id'];
		$prename=$result_name['prename'];
		$name= $result_name['name'];
		$surname = $result_name['surname'];
$full_name_ar[$person_id]="$prename$name&nbsp;&nbsp;$surname";
}
//ส่วนหัว
?>
<BR>
<div class="container">
  <div class="panel panel-default">
<?php 
if(!(($index==1)  or ($index==2) or ($index==5) or ($index==7))){
?>
      <div class="panel-heading"><h3 class="panel-title">รายงานการใช้ยานพาหนะ</h3></div>
<?php
}
//ส่วนฟอร์มรับข้อมูล
if($index==1){
    if(!empty($_GET['id'])) $id=$_GET['id'];
    else $id=0;
    if(!empty($_GET['page'])) $page=$_GET['page'];
    else $page=1;
    if(!empty($_GET['ed'])) $ed=$_GET['ed'];
    else $ed=0;
    
    
    $disabled="";
    $header="บันทึกรายงานการใช้ยานพาหนะ";
    if($ed==1){
        $header="แก้ไขการรายงานการใช้ยานพาหนะ";
    }else if($ed==2){
        $header="รายละเอียดการรายงานการใช้ยานพาหนะ";
        $disabled="disabled";
    }
    $place="";
    $because="";
    $car_start="";
    $time_start="";
    $car_finish="";
    $time_finish="";
    $day_total="";
    $person_num="";
    $control_person="";
    $start_mile="";
    $finish_mile="";
    $fuel="";
    $detail="";

    if($ed!=0){
        $sql = "select * from  car_report where id='$_GET[id]'";
        $dbquery = mysqli_query($connect,$sql);
        $result = mysqli_fetch_array($dbquery);
        $car=$result['car'];
        $place=$result['place'];
        $because=$result['because'];
        $car_start=$result['car_start'];
        $time_start=$result['time_start'];
        $car_finish=$result['car_finish'];
        $time_finish=$result['time_finish'];
        $day_total=$result['day_total'];
        $person_num=$result['person_num'];
        $control_person=$result['control_person'];
        $start_mile=$result['start_mile'];
        $finish_mile=$result['finish_mile'];
        $fuel=$result['fuel'];
        $detail=$result['detail'];
    }
?>
      
<div class="panel-heading"><h3 class="panel-title"><?=$header;?></h3></div>
      <div class="panel-body">
          <form id='frm1' name='frm1' class="form-horizontal">
            <div class="form-group">
            <label class="col-sm-3 control-label text-right">ข้าพเจ้า</label>
            <div class="col-sm-4 input-group">
            <label class="col-md control-label"><?php echo $_SESSION['login_prename'].$_SESSION['login_name']."&nbsp;&nbsp;".$_SESSION['login_surname']."&nbsp;&nbsp;ตำแหน่ง ".$_SESSION['login_userposition'];?></label>
            </div>
            </div><hr>
            <div class="form-group">
            <label class="col-sm-3 control-label text-right">ได้ทำหน้าที่ขับรถ</label>
            <div class="col-sm-3 input-group">
                <Select  name='car' class="form-control" <?=$disabled?> >
                    <option  value = ''>เลือกรถ</option>
            <?php $sql = "select car_code,car_number,name from  car_car where status<='2' ";
              $dbquery = mysqli_query($connect,$sql);
                While ($result = mysqli_fetch_array($dbquery)){
                    $car_code = $result['car_code'];
                    $car_number= $result['car_number'];
                    $name = $result['name'];
                    $selected="";
                    if($car_code==$car) $selected="selected";
                    echo  "<option value = $car_code $selected>$car_number $name</option>";
               }?>
                </select>
            </div>
            </div><hr>
            <div class="form-group">
            <label class="col-sm-3 control-label text-right">ไปราชการ(สถานที่)</label>
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
                <div class="input-group date">
                    <input type="text" class="form-control" name="car_start" value="<?=$car_start?>" <?=$disabled?> >
                    <span class="input-group-addon">
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
                <div class="input-group date">
                    <input type="text" class="form-control" name=car_finish value="<?=$car_finish?>"  <?=$disabled?>  >
                    <span class="input-group-addon">
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
            <label class="col-sm-3 control-label text-right">เลขเข็มไมล์เมื่อเริ่มเดินทาง</label>
            <div class="col-sm-4 input-group"><Input Type='Text' Name='start_mile' class="form-control" value="<?=$start_mile?>"  <?=$disabled?>  >
            </div>
            </div><hr>
            <div class="form-group">
            <label class="col-sm-3 control-label text-right">เลขเข็มไมล์เมื่อสิ้นสุดการเดินทาง</label>
            <div class="col-sm-4 input-group"><Input Type='Text' Name='finish_mile' class="form-control" value="<?=$finish_mile?>"  <?=$disabled?>  >
            </div>
            </div><hr>
            <div class="form-group">
            <label class="col-sm-3 control-label text-right">น้ำมันเชื้อเพลิงคงเหลือในถังเมื่อสิ้นสุดการเดินทาง</label>
            <div class="col-sm-3 input-group"><Input Type='Text' Name='fuel' class="form-control" value="<?=$fuel?>"  <?=$disabled?>  ><span class="input-group-addon">  ลิตร (ประมาณ)</span>
            </div>
            </div><hr>    
            <div class="form-group">
            <label class="col-sm-3 control-label text-right">สภาพการณ์</label>
                <div class="col-sm-4 input-group"><textarea rows="5" cols="55" Name='detail' class="form-control"  <?=$disabled?>  ><?=$detail?></textarea>
            </div>
            </div><hr>
            <div class="form-group">
          <label class="col-sm-3 control-label text-right"></label>
          <div class="col-sm-4">
            <INPUT TYPE='hidden' name='car_index' value=<?=$car_index?>>
            <label >
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
$sql = "delete from car_report where id='$_GET[id]'";
$query = mysqli_query($connect,$sql);
}
//ส่วนบันทึกข้อมูล
if($index==4){
$rec_date = date("Y-m-d H:i:s");
$sql = "insert into car_report ( person_id, rec_date, car, place, because, car_start, time_start, car_finish, time_finish, day_total,  person_num, control_person, start_mile, finish_mile, fuel, detail) values ('$user', '$rec_date',  '$_POST[car]', '$_POST[place]', '$_POST[because]', '$_POST[car_start]', '$_POST[time_start]','$_POST[car_finish]','$_POST[time_finish]','$_POST[day_total]', '$_POST[person_num]','$_POST[control_person]', '$_POST[start_mile]', '$_POST[finish_mile]',  '$_POST[fuel]',   '$_POST[detail]')";
$query = mysqli_query($connect,$sql);
}
//ส่วนปรับปรุงข้อมูล
if ($index==6){
		$sql = "update car_report set car='$_POST[car]',
		place='$_POST[place]',
		because='$_POST[because]',
		car_start='$_POST[car_start]',
		time_start='$_POST[time_start]',
		car_finish='$_POST[car_finish]',
		time_finish='$_POST[time_finish]',
		day_total='$_POST[day_total]',
		person_num='$_POST[person_num]',
		control_person='$_POST[control_person]',
		start_mile='$_POST[start_mile]',
		finish_mile='$_POST[finish_mile]',
		fuel='$_POST[fuel]',
		detail='$_POST[detail]'
		where id='$_POST[id]'";
		$query = mysqli_query($connect,$sql);
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5) or ($index==7))){

//ส่วนของการแยกหน้า
if($car_index>=1){
$sql="select id from car_report where car='$car_index' ";
}
else{
$sql="select id from car_report";
}
$query = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($query);

$pagelen=20;  // 1_กำหนดแถวต่อหน้า
$url_link="option=car&task=car_report&car_index=$car_index";  // 2_กำหนดลิงค์ฺ
$totalpages=ceil($num_rows/$pagelen);

if(!isset($_REQUEST['page'])){
$_REQUEST['page']="";
}
if($_REQUEST['page']==""){
$page=$totalpages;
		if($page<2){
		$page=1;
		}
}
else{
		if($totalpages<$_REQUEST['page']){
		$page=$totalpages;
					if($page<1){
					$page=1;
					}
		}
		else{
		$page=$_REQUEST['page'];
		}
}
$start=($page-1)*$pagelen;
if(($totalpages>1) and ($totalpages<16)){
echo "<div align=center>";
echo "หน้า	";
			for($i=1; $i<=$totalpages; $i++)	{
					if($i==$page){
					echo "[<b><font size=+1 color=#990000>$i</font></b>]";
					}
					else {
					echo "<a href=$PHP_SELF?$url_link&page=$i>[$i]</a>";
					}
			}
echo "</div>";
}
if($totalpages>15){
			if($page <=8){
			$e_page=15;
			$s_page=1;
			}
			if($page>8){
					if($totalpages-$page>=7){
					$e_page=$page+7;
					$s_page=$page-7;
					}
					else{
					$e_page=$totalpages;
					$s_page=$totalpages-15;
					}
			}
			echo "<div align=center>";
			if($page!=1){
			$f_page1=$page-1;
			echo "<<a href=$PHP_SELF?$url_link&page=1>หน้าแรก </a>";
			echo "<<<a href=$PHP_SELF?$url_link&page=$f_page1>หน้าก่อน </a>";
			}
			else {
			echo "หน้า	";
			}
			for($i=$s_page; $i<=$e_page; $i++){
					if($i==$page){
					echo "[<b><font size=+1 color=#990000>$i</font></b>]";
					}
					else {
					echo "<a href=$PHP_SELF?$url_link&page=$i>[$i]</a>";
					}
			}
			if($page<$totalpages)	{
			$f_page2=$page+1;
			echo "<a href=$PHP_SELF?$url_link&page=$f_page2> หน้าถัดไป</a>>>";
			echo "<a href=$PHP_SELF?$url_link&page=$totalpages> หน้าสุดท้าย</a>>";
			}
			echo " <select onchange=\"location.href=this.options[this.selectedIndex].value;\" size=\"1\" name=\"select\">";
			echo "<option  value=\"\">หน้า</option>";
				for($p=1;$p<=$totalpages;$p++){
				echo "<option  value=\"?$url_link&page=$p\">$p</option>";
				}
			echo "</select>";
echo "</div>";
}
//จบแยกหน้า
if($car_index>=1){
$sql="select car_report.id, car_report.person_id, car_report.rec_date, car_report.place, car_report.finish_mile, car_report.fuel, car_car.car_number from car_report left join car_car on  car_report.car=car_car.car_code  where car_report.car='$car_index' order by car_report.rec_date  limit $start,$pagelen";
}
else{
$sql="select car_report.id, car_report.person_id, car_report.rec_date, car_report.place, car_report.finish_mile, car_report.fuel, car_car.car_number from car_report left join car_car on  car_report.car=car_car.car_code order by car_report.rec_date  limit $start,$pagelen";
}
$query = mysqli_query($connect,$sql);
    ?>
      <div class="panel-body">
        <form id='frm1' name='frm1' class="form-horizontal">
        <div class="row">
            <div class="col-md-10 text-left">
                <a href="?option=car&task=car_report&index=1" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>&nbsp;บันทึกรายงานการใช้ยานพาหนะ</a>
            </div>
            <div class="col-md-2 text-right">
                <Select  name='car_index' class="form-control" onchange="goto_url2(1)">
                    <option value ="" >รถทุกคัน</option>
                    <?php 
    $sql_car = "SELECT car_code,name,car_number  FROM car_car where status<='2' ";
    $dbquery_car = mysqli_query($connect,$sql_car);
    While ($result_car = mysqli_fetch_array($dbquery_car )){
        $selected="";
        if ($car_index==$result_car ['car_code']) $selected="selected";
            echo "<option value=$result_car[car_code]  $selected>$result_car[car_number] $result_car[name]</option>";
    }
    ?>
    </select>
            </div>
       </div>
        </form>
          </div>
      <table class="table table-hover table-striped table-condensed table-responsive">
          <thead>
            <tr>
              <th>เลขที่</th>
              <th>วันรายงาน</th>
              <th>ผู้รายงาน</th>
              <th>รถ</th>
              <th>สถานที่ไปราชการ</th>
              <th>เข็มไมล์สุดท้าย(ก.ม.)</th>
              <th>น้ำมันคงเหลือ(ลิตร)</th>
              <th>รายละเอียด</th>
              <th>ลบ</th>
              <th>แก้ไข</th>
            </tr>
          </thead>
          <tbody>
        <?php 

$N=(($page-1)*$pagelen)+1; //*เกี่ยวข้องกับการแยกหน้า
$M=1;

While ($result = mysqli_fetch_array($query)){
		$id = $result['id'];
		$rec_date = $result['rec_date'];
		$finish_mile= $result['finish_mile'];
		$fuel = $result['fuel'];
?>
              <Tr>
                  <Td><?=$N?></Td>
                  <Td><?php  echo thai_date_3($rec_date);?></Td>
                  <Td>
                      <?php 
			$sql_person = "select * from person_main where  person_id='$result[person_id]' ";
			$query_person  = mysqli_query($connect,$sql_person);
			$result_person = mysqli_fetch_array($query_person);
			echo "$result_person[prename]$result_person[name]&nbsp;&nbsp;$result_person[surname]";
?>
</Td>
                  <Td><?=$result['car_number']?></Td>
                  <Td><?=$result['place']?></Td>
                  <Td><?=$result['finish_mile']?></Td>
                  <Td><?=$result['fuel']?></Td>
                  <Td>
        <a href=?option=car&task=car_report&index=1&id=<?=$id?>&page=<?=$page?>&car_index=<?=$car_index?>&ed=2 class='btn btn-primary'><span class='glyphicon glyphicon-file' ></span></a>
    </Td>
<?php 
//กำหนดเวลาให้แก้ไขได้
$now=time();
$timestamp_recdate=make_time_2($rec_date);
$timestamp_recdate2=$timestamp_recdate+3600;
//////////////////////
if( $result['person_id']==$user and $now<$timestamp_recdate2){
?>
 <Td>
        <a href=?option=car&task=car_report&index=3&id=<?=$id?>&page=<?=$page?>&car_index=<?=$car_index?> data-toggle='confirmation' class='btn btn-danger' data-title="คุณต้องการลบข้อมูลนี้ใช่หรือไม่" data-btn-ok-label="ใช่" data-btn-ok-icon="glyphicon glyphicon-share-alt" data-btn-ok-class="btn-success" data-btn-cancel-label="ไม่ใช่!" data-btn-cancel-icon="glyphicon glyphicon-ban-circle" data-btn-cancel-class="btn-danger">
        <span class='glyphicon glyphicon-trash'></span>
        </a>
    </Td>
    <Td>
        <a href=?option=car&task=car_report&index=1&id=<?=$id?>&page=<?=$page?>&car_index=<?=$car_index?>&ed=1 class='btn btn-warning'><span class='glyphicon glyphicon-pencil' ></span></a>
    </Td>
<?php
}
else{
echo "<td></td><td></td>";
}
?></Tr>
<?php 
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
}
?>
    </tbody>
</Table>
<?php 
}

?>
    </div>
    </div>
<script>
function goto_url_ed(ed,val){
	if(val==0){
		callfrm("?option=car&task=car_report");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.car.value == ""){
		alert("กรุณาเลือกรถยนต์");
		}else if(frm1.place.value == ""){
		alert("กรุณากรอกสถานไปราชการ");
		}else if(frm1.finish_mile.value == ""){
		alert("กรุณากรอกเลขไมล์สิ้นสุดการเดินทาง");
		}else if(frm1.fuel.value == ""){
		alert("กรุณากรอกเชื้อเพลิงคงเหลือ");
		}else{
            if(ed==0){
                callfrm("?option=car&task=car_report&index=4");   //page ประมวลผล
            }else{
                callfrm("?option=car&task=car_report&index=6");   //page ประมวลผล
            }
		}
	}
}
function goto_url2(val){
callfrm("?option=car&task=car_report");
}

</script>
<script type="text/javascript">
    $(function () {
        $('.input-group.date').datepicker({
            format: "yyyy-mm-dd"
        });

    });
</script>
                