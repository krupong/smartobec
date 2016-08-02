<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Bootstrap Include -->
<link rel="stylesheet" type="text/css" href="../../bootstrap-3.3.5-dist/css/bootstrap.min.css">
</head>
<body>
<?php
require_once "../../database_connect.php";
if(is_numeric($_GET['id'])){
$sql = "
select a.*,b.*,c.*,d.*,e.*,
CONCAT(b.prename,b.name,'  ',b.surname) as car_user,
CONCAT(bb.prename,bb.name,'  ',bb.surname) as car_user_header,
CONCAT(g.prename,g.name,'  ',g.surname) as car_driver,
CONCAT(h.prename,h.name,'  ',h.surname) as car_officer,
f.name as car_tname
from car_main a 
left outer join person_main b on a.person_id=b.person_id 
left outer join system_department c on c.department=b.department 
left outer join person_position d on d.position_code=b.position_code 
left outer join car_car e on e.car_code=a.car 
left outer join car_type f on f.code=e.car_type 
left outer join person_main g on g.person_id=a.driver 
left outer join person_main h on h.person_id=a.officer_sign 
left outer join person_main bb on bb.person_id = a.officer_sign
 where a.id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
?>
<br>
    
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">ใบอนุญาตใช้รถส่วนกลาง สำนักงานคณะกรรมการการศึกษาขั้นพื้นฐาน</h4>
            </div>
            <div class="panel-body">
                <p class="text-left">เฉพาะกรุงเทพมหานคร นนทบุรี ปทุมธานี สมุทรปราการ สมุทรสาคร นครปฐม</p>
                <p class="text-right">วันที่ <ins><?=$result['rec_date']?></ins></p>
                <p class="text-left">เรียน   เลขาธิการคณะกรรมการการศึกษาขั้นพื้นฐาน</p>
                <p class="text-left">ข้าพเจ้า <ins><?=$result['car_user']?></ins> ตำแหน่ง <ins><?=$result['position_name']?></ins> <br>
                    สำนัก/กลุ่ม <ins><?=$result['department_name']?></ins> เบอร์ติดต่อ <ins><?=$result['control_phone']?></ins> <br>
                    ขออนุญาตใช้รถไปราชการ <ins><?=$result['place']?></ins> เพื่อ <ins><?=$result['because']?></ins><br>
                    มีผู้ไปราชการ <ins><?=$result['person_num']?></ins> ในวันที่ <ins><?=$result['car_start']?></ins> เวลา <ins><?=$result['time_start']?>.00</ins> น. ถึง <ins><?=$result['time_finish']?>.00</ins> น.<br><br>
                    <b>ผู้ขออนุญาต : <ins>  <?=$result['car_user']?>  </ins>&nbsp;&nbsp;[<?=$result['rec_date']?>]</b><br>
                    <b>หัวหน้างานหรือผู้ที่ได้รับมอบหมาย : <ins>  <?=$result['car_user_header']?>  </ins>&nbsp;&nbsp;[<?=$result['officer_date']?>]</b>
                </p>
                <hr>
                <h4>สำหรับเจ้าหน้าที่</h4>                
                <p class="text-left">เห็นควรให้ใช้รถส่วนกลาง <ins><?=$result['car_tname']?></ins>  หมายเลขทะเบียน  <ins><?=$result['car_number']?></ins><br>
                    พนักงานขับรถ : <ins><?=$result['car_driver']?></ins><br>
                    <b>ผู้จัดรถ : <ins><?=$result['car_officer']?></ins> วันที่จัด [<?=$result['commander_date']?>]</b> 
                </p>
                <hr>
                <h4>สำหรับพนักงานขับรถ</h4>                
                <div class="form-group">
                    <label class="col-sm-3 control-label text-right">ออกจาก สพฐ. เวลา......................น.</label>
                    <label class="control-label">เลข กม. ..................</label>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label text-right">กลับถึงเวลา...........................น.</label>
                    <label class="control-label">เลข กม. ..................</label>
                </div>
                <p class="text-center">(ลงชื่อ).......................................ผู้ไปราชการ  (ลงชื่อ)........................................พนักงานขับรถ</p>                
                <hr>
                <p class="text-center">อนุญาตให้ใช้รถส่วนกลางหมายเลข</p>                
                <p class="text-center">ทะเบียน</p>                
                <p class="text-center">(ลงชื่อ)......................................</p>
                <p class="text-center">(......................................)</p>    
                <p class="text-center">(ผู้อำนวยการสำนักอำนวยการ)</p>
                <p class="text-center">ผู้อนุญาต</p>
                <hr>
                <p class="text-left">*หมายเหตุ  ถึงกำหนดเวลาที่ขอไปราชการแล้ว ยังไม่พร้อมจะเดินทางโปรดแจ้ง ภายใน 15 นาที</p>
                <p class="text-left">ถ้าพ้นกำหนดเวลาแล้ว จะยกเลิกการใช้รถ โทรศัพท์ห้องยานพาหนะ 0-2628-8888 ต่อ 1107 , 0-2282-9872</p>
            </div>
        </div>
    </div>
    
    
    
    
    
<?php
}
?>
</body>
</html>
<script>
//window.print(); 
</script>