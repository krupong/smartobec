<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
?>
<script type="text/javascript">
$(function(){
	$("select#department").change(function(){
		var datalist2 = $.ajax({	// รับค่าจาก ajax เก็บไว้ที่ตัวแปร datalist2
			  url: "modules/car/ajax/return_ajax_subdep.php", // ไฟล์สำหรับการกำหนดเงื่อนไข
			  data:"department="+$(this).val(), // ส่งตัวแปร GET ชื่อ department ให้มีค่าเท่ากับ ค่าของ department
			  async: false
		}).responseText;
		$("select#subdep").html(datalist2); // นำค่า datalist2 มาแสดงใน listbox ที่ 2
		// ชื่อตัวแปร และ element ต่างๆ สามารถเปลี่ยนไปตามการกำหนด
        removeOptions(document.getElementById("person_id")); // clear dropdrowlist person_id when click department
	});
});
$(function(){
	$("select#subdep").change(function(){
		var datalist2 = $.ajax({	// รับค่าจาก ajax เก็บไว้ที่ตัวแปร datalist2
			  url: "modules/car/ajax/return_ajax_person.php", // ไฟล์สำหรับการกำหนดเงื่อนไข
			  data:"subdep="+$(this).val(), // ส่งตัวแปร GET ชื่อ subdep ให้มีค่าเท่ากับ ค่าของ subdepartment
			  async: false
		}).responseText;
		$("select#person_id").html(datalist2); // นำค่า datalist2 มาแสดงใน listbox ที่ 2
		// ชื่อตัวแปร และ element ต่างๆ สามารถเปลี่ยนไปตามการกำหนด
	});
});
function removeOptions(selectbox){
    var i;
    for(i=selectbox.options.length-1;i>=1;i--){
        selectbox.remove(i);
    }
}
</script>
<BR>
<div class="container">
  <div class="panel panel-default">
<?php 
if(!(($index==1) or ($index==2) or ($index==5))){
    ?><div class="panel-heading"><h3 class="panel-title">พนักงานขับรถ</h3></div><?php }
//ส่วนฟอร์มรับข้อมูล
if($index==1){
    $header="เพิ่มพนักงานขับรถ";
    $car_type = "";
    $car_code = "";
    $car_number = "";
    $car_name = "";
    $status = "";
    $dtel="";
    $chk1="checked";
    $chk2="";

    if(!empty($_GET['id'])) $id=$_GET['id'];
    else $id=0;
    if(!empty($_GET['page'])) $page=$_GET['page'];
    else $page=1;
    if(!empty($_GET['ed'])) $ed=$_GET['ed'];
    else $ed=0;

    if($ed==1){
        $header="แก้ไขพนักงานขับรถ";

        $sql = "select a.*,b.department,b.sub_department,b.position_code from  car_driver a left outer join person_main b on a.person_id=b.person_id where a.id='$_GET[id]'";
        $dbquery = mysqli_query($connect,$sql);
        $result = mysqli_fetch_array($dbquery);
        $department = $result['department'];
        $sub_department = $result['sub_department'];
        $person_id = $result['person_id'];
        $status = $result['status'];
        $dtel = $result['dtel'];
        $chk1="";
        $chk2="";
        if($status==1) $chk1="checked";
        else $chk2="checked";
        
    }
?>
<div class="panel-heading"><h3 class="panel-title"><?=$header;?></h3></div>
<div class="panel-body">
    <form id='frm1' name='frm1' class="form-horizontal">
        <div class="form-group">
          <label class="col-sm-3 control-label text-right" >เลือกสำนัก</label>
          <div class="col-sm-4 input-group">
              <Select name='department' id='department' class="form-control">
                  <?php 
                    $sql = "select * from  system_department where department=4 order by department";
                    $dbquery = mysqli_query($connect,$sql);
                    While ($result_department = mysqli_fetch_array($dbquery)){
                        $selected="";
                        if($result_department['department']==$department) $selected="selected";
                    echo  "<option  value ='$result_department[department]'  $selected >$result_department[department] $result_department[department_name]</option>";
                    }
                    ?>
                    </select></div>
        </div><hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right" >เลือกกลุ่ม</label>
          <div class="col-sm-4 input-group">
              <Select name='subdep' id='subdep' class="form-control">
                  <option  value = ''>เลือกกลุ่ม</option>
                   <?php 
    
                    $sql = "select * from  system_subdepartment where department=4 order by sub_department";
                    $dbquery = mysqli_query($connect,$sql);
                    While ($result_department = mysqli_fetch_array($dbquery)){
                        $selected="";
                        if($result_department['sub_department']==$sub_department) $selected="selected";
                    echo  "<option  value ='$result_department[sub_department]'  $selected > $result_department[sub_department_name]</option>";
                    }
    
                    ?>
                  </select>
            </div>
        </div><hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right" >เลือกบุคลากร</label>
          <div class="col-sm-2 input-group">
              <Select name='person_id' id='person_id' class="form-control">
                  <option  value = ''>เลือกบุคลากร</option>
                   <?php 
    if($ed==1){
                    $sql = "select * from  person_main where department=$department and sub_department=$sub_department order by name";
                    $dbquery = mysqli_query($connect,$sql);
                    While ($result_department = mysqli_fetch_array($dbquery)){
                        $selected="";
                        if($result_department['person_id']==$person_id) $selected="selected";
                    echo  "<option  value ='$result_department[person_id]'  $selected >$result_department[prename]$result_department[name] $result_department[surname]</option>";
                    }
    }
                    ?>
                  </select>
            </div>
        </div><hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right">ปฏิบัติหน้าที่</label>
            <div class="col-sm-4">
            <div class="input-group">
            <span class="input-group-addon">
                <input type="radio" aria-label="..." name='status' value='1' <?=$chk1?> >
            </span>
            <input type="text" class="form-control" value="ใช่" readonly>
            </div><!-- /input-group -->
            </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right"></label>
            <div class="col-sm-4">
            <div class="input-group">
            <span class="input-group-addon">
                <input type="radio" aria-label="..." name='status' value='0' <?=$chk2?> >
            </span>
            <input type="text" class="form-control" value="ไม่ใช่" readonly>
            </div><!-- /input-group -->
            </div>
        </div><hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right" >เบอร์ติดต่อ</label>
          <div class="col-sm-3   input-group"><Input Type='Text' Name='dtel' class="form-control" value="<?=$dtel?>">
          </div>
        </div>
        <hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right"></label>
          <div class="col-sm-4">
            <label >
                <button type="button" name="smb" class="btn btn-primary" onclick='goto_url_ed(<?=$ed?>,1)'>
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>ตกลง
                </button>&nbsp;
                <button type="button" name="back" class="btn btn-default" onclick='goto_url_ed(<?=$ed?>,0)'>
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>ย้อนกลับ
                </button>
            </label>
          </div>
        </div>
        <hr>
        <input type="hidden" name="id" value="<?=$id?>">
    </form>
      </div>
<?php 
}
//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from car_driver where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}
//ส่วนบันทึกข้อมูล
if($index==4){
$rec_date = date("Y-m-d");
 $sql = "insert into car_driver (person_id, status, officer,rec_date,dtel) values ('$_POST[person_id]', '$_POST[status]','$_SESSION[login_user_id]','$rec_date','$_POST[dtel]')";
$dbquery = mysqli_query($connect,$sql);
}
//ส่วนปรับปรุงข้อมูล
if ($index==6){
$rec_date = date("Y-m-d");
$sql = "update car_driver set  person_id='$_POST[person_id]', status='$_POST[status]', officer='$_SESSION[login_user_id]', rec_date='$rec_date',dtel='$_POST[dtel]' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}
//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){
$sql = "select car_driver.id, car_driver.status, person_main.prename, person_main.name, person_main.surname from car_driver left join person_main on car_driver.person_id=person_main.person_id order by car_driver.id";
$dbquery = mysqli_query($connect,$sql);
      ?>
  <div class="panel-body">
        <div class="row">
            <div class="col-md-3 text-left">
                <a href="?option=car&task=set_driver&index=1" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>&nbsp;เพิ่มข้อมูล</a>
            </div>
        </div>
    </div>
      <table class="table table-hover table-striped table-condensed table-responsive">
    <thead>
        <tr>
          <th>ที่</th>
          <th>ชื่อพนักงานขับรถ</th>
          <th>สถานะปฏิบัติงาน</th>
          <th>ลบ</th>
          <th>แก้ไข</th>
        </tr>
          </thead>
          <tbody><?php 
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$prename = $result['prename'];
		$name = $result['name'];
		$surname = $result['surname'];
			if($result['status']==1){
                $p1_pic="<span class='glyphicon glyphicon-ok' ></span>";
            }
			else{
                $p1_pic="<span class='glyphicon glyphicon-remove' ></span>";
            }
			?>
		<Tr>
              <Td><?=$M?></Td>
              <Td><?php  echo $prename.$name." ".$surname;?></Td>
              <Td><?=$p1_pic?></Td>
                <Td>
                    <a href=?option=car&task=set_driver&index=3&id=<?=$id?> data-toggle='confirmation' class='btn btn-danger' data-title="คุณต้องการลบข้อมูลนี้ใช่หรือไม่" data-btn-ok-label="ใช่" data-btn-ok-icon="glyphicon glyphicon-share-alt" data-btn-ok-class="btn-success" data-btn-cancel-label="ไม่ใช่!" data-btn-cancel-icon="glyphicon glyphicon-ban-circle" data-btn-cancel-class="btn-danger">
                    <span class='glyphicon glyphicon-trash'></span>
                    </a>
                </Td>
                <Td>
                    <a href=?option=car&task=set_driver&index=1&id=<?=$id?>&ed=1 class='btn btn-warning'><span class='glyphicon glyphicon-pencil' ></span></a>
                </Td>
	</Tr>
              <?php 
$M++;
	}
              ?></tbody>
    </Table>
<?php }?>
    </div>
    </div>
<script>
function goto_url_ed(ed,val){
	if(val==0){
		callfrm("?option=car&task=set_driver");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
		}else{
            if(ed==0){
                callfrm("?option=car&task=set_driver&index=4");   //page ประมวลผล
            }else{
                callfrm("?option=car&task=set_driver&index=6");   //page ประมวลผล
            }
		}
	}
}
</script>
