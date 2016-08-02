<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style type="text/css">
td {
  border-collapse: collapse;
  border: 1px black solid;
}   
span {
  display: inline-block;
  width: 220px;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Bootstrap Include -->
<link rel="stylesheet" type="text/css" href="../../bootstrap-3.3.5-dist/css/bootstrap.min.css">
    </head>
<body>
<?php

$th_month[1]="มกราคม";
$th_month[2]="กุมภาพันธ์";
$th_month[3]="มีนาคม";
$th_month[4]="เมษายน";
$th_month[5]="พฤษภาคม";
$th_month[6]="มิถุนายน";
$th_month[7]="กรกฎาคม";
$th_month[8]="สิงหาคม";
$th_month[9]="กันยายน";
$th_month[10]="ตุลาคม";
$th_month[11]="พฤศจิกายน";
$th_month[12]="ธันวาคม";

require_once "../../database_connect.php";
if(is_numeric($_GET['id'])){
 $sql = "
select a.*,b.*,c.*,d.*,e.*,
CONCAT(b.prename,b.name,'  ',b.surname) as car_user,
CONCAT(bb.prename,bb.name,'  ',bb.surname) as car_user_header,
CONCAT(g.prename,g.name,'  ',g.surname) as car_driver,
CONCAT(h.prename,h.name,'  ',h.surname) as car_officer,
f.name as car_tname,dd.dtel 
from car_main a 
left outer join car_driver dd on dd.person_id = a.driver 
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
    $date = date_create($result['rec_date']);
    $car_st = date_create($result['car_start']);
    $car_en = date_create($result['car_finish']);
    $officer_date = date_create($result['officer_date']);
?>
<br>
    <center>
    <table width=100% height=100% cellpadding="10" cellspacing="10">
        <tr>
            <td rowspan="2" align=center><img src="images/1.png" ></td>
            <td align=center><b>ใบขออนุญาตใช้รถส่วนกลาง สำนักงานคณะกรรมการการศึกษาขั้นพื้นฐาน<br>&nbsp;</b></td>
        </tr>
        <tr>
            <td valign=top>
                <p class="text-right">วันที่ <?=date_format($officer_date,'d')?>  เดือน  <?=$th_month[intval(date_format($officer_date,'m'))]?>  พ.ศ.  <?=date_format($officer_date,'Y')+543?>&nbsp;&nbsp;</p>
                <p class="text-right">เลขที่ใบจอง : <?=$result['id']?>/<?=date_format($date,'Y')+543?>&nbsp;&nbsp;</p>
                <p class="text-left">&nbsp;&nbsp;เรียน   เลขาธิการคณะกรรมการการศึกษาขั้นพื้นฐาน</p>
                <p class="text-left">&nbsp;&nbsp;ข้าพเจ้า <?=$result['car_user']?> ตำแหน่ง <?=$result['position_name']?></p>
                <p class="text-left">&nbsp;&nbsp;หน่วยงาน  <?=$result['department_name']?> เบอร์โทรติดต่อ <?=$result['control_phone']?></p>
                <p class="text-left">&nbsp;&nbsp;ขออนุญาตใช้รถไปราชการ <?=$result['place']?></p>
                <p class="text-left">&nbsp;&nbsp;เพื่อ <?=$result['because']?>   มีผู้ไปราชการ <?=$result['person_num']?> คน</p>
                <p class="text-left">&nbsp;&nbsp;ในวันที่ <?=date_format($car_st,'d')?>  <?=$th_month[intval(date_format($car_st,'m'))]?>  <?=date_format($car_st,'Y')+543?> เวลา <?=$result['time_start']?>.00 น. ถึง <?=date_format($car_en,'d')?>  <?=$th_month[intval(date_format($car_en,'m'))]?>  <?=date_format($car_en,'Y')+543?> เวลา <?=$result['time_finish']?>.00 น.</p>
                <p class="text-right">ลงชื่อ <?=$result['car_user']?>     ผู้ขออนุญาต&nbsp;&nbsp;</p>
                <p class="text-right">ลงชื่อ<?=$result['car_user_header']?> หัวหน้างานหรือผู้ที่ได้รับมอบหมาย&nbsp;&nbsp;</p>
                <p class="text-right"><?=date_format($officer_date,'d')?> / <?=$th_month[intval(date_format($officer_date,'m'))]?> / <?=date_format($officer_date,'Y')+543?>&nbsp;&nbsp;</p>
            </td>
        </tr>
        <tr>
            <td align=center ><img src="images/2.png"></td>
            <td valign=top height=150>
                <p class="text-left">&nbsp;&nbsp;เห็นควรให้ใช้รถส่วนกลาง <?=$result['car_tname']?> &ensp;&ensp;&ensp;&ensp;  หมายเลขทะเบียน  <?=$result['car_number']?></p>
                <p class="text-left">&nbsp;&nbsp;พนักงานขับรถ : <?=$result['car_driver']?>  &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp; โทรศัพท์มือถือ : <?=$result['dtel']?></p>
                <p class="text-center">&nbsp;&nbsp;(ลงชื่อ)&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</p>
                <p class="text-center">&nbsp;&nbsp;(  <?=$result['car_officer']?>  )</p>
                <p class="text-center">&nbsp;&nbsp;ผู้จัดรถ</p>
            </td>
        </tr>
        <tr>
            <td align=center><img src="images/3.png" ></td>
            <td>
                <span align=right>&nbsp;&nbsp;ออกจากหน่วยงานในวันที่</span>
                <span ><?=date_format($car_st,'d')?>  <?=$th_month[intval(date_format($car_st,'m'))]?>  <?=date_format($car_st,'Y')+543?> เวลา <?=$result['time_start']?>.00 น.</span>
                <span>เลขไมล์ (กม.)</span><br>
                <span align=right>&nbsp;&nbsp;กลับถึง</span>
                <span><?=date_format($car_en,'d')?>  <?=$th_month[intval(date_format($car_en,'m'))]?>  <?=date_format($car_en,'Y')+543?> เวลา <?=$result['time_finish']?>.00 น.</span>
                <span>เลขไมล์ (กม.)</span><br><br>
                <center>&nbsp;&nbsp;ลงชื่อ&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;พนักงานขับรถ    รวมระยะทาง (กม.)</center>
            </td>
        </tr>
        <tr>
            <td colspan=2><br>
            <p class="text-center">อนุญาตให้ใช้รถส่วนกลาง</p>
                <p class="text-center">(ลงชื่อ)......................................</p>
                <p class="text-center">(......................................)</p>    
                <p class="text-center">ผู้อำนวยการสำนักอำนวยการ</p>
            </td>
        </tr>
        <tr>
            <td colspan=2>
                <p class="text-left">*หมายเหตุ  ถึงกำหนดเวลาที่ขอไปราชการแล้ว ยังไม่พร้อมจะเดินทางโปรดแจ้ง ภายใน 15 นาที</p>
                <p class="text-left">ถ้าพ้นกำหนดเวลาแล้ว จะยกเลิกการใช้รถ โทรศัพท์ห้องยานพาหนะ 02-288-5796-7 ,Fax 02-282-9872</p>
            </td>
        </tr>
    </table><BR><BR>
</center>
<?php
}
?>
</body>
</html>
<script>
window.print(); 
</script>