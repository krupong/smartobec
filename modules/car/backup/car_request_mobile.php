<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
require_once "modules/car/time_inc.php";

?>
<script type="text/javascript" src="./css/js/calendarDateInput.js"></script>
<?php

$user=$_SESSION['login_user_id'];
//กรณีเลือกแสดงเฉพาะคัน
if(isset($_REQUEST['car_index'])){
$car_index=$_REQUEST['car_index'];
}
else{
$car_index="";
}

if(!isset($_POST['self_driver'])){
$_POST['self_driver']="";
}

if(!isset($_POST['private_car'])){
$_POST['private_car']="";
}

$sql_name = "select * from person_main ";
$dbquery_name = mysqli_query($connect,$sql_name);
while($result_name = mysqli_fetch_array($dbquery_name)){;
		$person_id = $result_name['person_id'];
		$prename=$result_name['prename'];
		$name= $result_name['name'];
		$surname = $result_name['surname'];
$full_name_ar[$person_id]="$prename$name&nbsp;&nbsp;$surname";
}
//ส่วนหัว
echo "<br />";
if(!(($index==1)  or ($index==2) or ($index==5) or ($index==7))){
echo "<table width='100%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666'><strong>ทะเบียนการขออนุญาตใช้รถราชการ</strong></font></td></tr>";
echo "</table>";
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5) or ($index==7))){

//ส่วนของการแยกหน้า
if($car_index>=1){
$sql="select id from car_main where car='$car_index' ";
}
else{
$sql="select id from car_main";
}
$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery);

$pagelen=20;  // 1_กำหนดแถวต่อหน้า
$url_link="option=car&task=main/car_request_mobile&car_index=$car_index";  // 2_กำหนดลิงค์ฺ
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

if(($totalpages>1) and ($totalpages<6)){
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
if($totalpages>5){
			if($page <=3){
			$e_page=5;
			$s_page=1;
			}
			if($page>3){
					if($totalpages-$page>=2){
					$e_page=$page+2;
					$s_page=$page-2;
					}
					else{
					$e_page=$totalpages;
					$s_page=$totalpages-5;
					}
			}
			echo "<div align=center>";
			if($page!=1){
			$f_page1=$page-1;
			echo "<<a href=$PHP_SELF?$url_link&page=1>แรก </a>";
			echo "<<<a href=$PHP_SELF?$url_link&page=$f_page1>ก่อน </a>";
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
			echo "<a href=$PHP_SELF?$url_link&page=$f_page2> ถัด</a>>>";
			echo "<a href=$PHP_SELF?$url_link&page=$totalpages> ท้าย</a>>";
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
$sql="select car_main.id, car_main.person_id, car_main.car_start, car_main.car_finish, car_main.rec_date, car_main.officer_sign, car_main.group_sign, car_main.commander_sign, car_main.commander_grant, car_car.name from car_main left join car_car on  car_main.car=car_car.car_code  where car_main.car='$car_index' order by car_start, car_car.car_code limit $start,$pagelen";
}
else{
$sql="select car_main.id, car_main.person_id, car_main.car_start, car_main.car_finish, car_main.rec_date, car_main.officer_sign, car_main.group_sign, car_main.commander_sign, car_main.commander_grant, car_car.name from car_main left join car_car on  car_main.car=car_car.car_code order by car_start, car_car.car_code limit $start,$pagelen";
}
$dbquery = mysqli_query($connect,$sql);

echo  "<table width='100%' border='0' align='center'>";
echo "<Tr>";
echo "<Td colspan='7' align='right'>";
echo "<form  name='frm1'>";
echo "&nbsp;<Select  name='car_index' size='1' onchange='goto_url2(1)'>";
echo  '<option value ="" >รถทุกคัน</option>' ;
		$sql_car = "SELECT *  FROM car_car where status='2' ";
		$dbquery_car = mysqli_query($connect,$sql_car);
				While ($result_car = mysqli_fetch_array($dbquery_car ))
				{
						if ($car_index==$result_car ['car_code']){
						echo "<option value=$result_car[car_code]  selected>$result_car[car_number] $result_car[name]</option>";
						}
						else{
						echo "<option value=$result_car[car_code]>$result_car[car_number] $result_car[name]</option>";
						}
				}
					echo "</select>";
echo "</form>";

echo "</Td>";
echo "</Tr>";

echo "<Tr bgcolor='#FFCCCC' align='center'><Td>ที่</Td><Td>วันเริ่มใช้รถ</Td><Td>วันสิ้นสุดการใช้</Td><Td>รถ</Td><Td>ผู้ขอใช้</Td><Td>วดป ขออนุญาต</Td><Td>อนุมัติ/คำสั่ง</Td></Tr>";

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
		$grant = $result['commander_grant'];
		$commander_sign = $result['commander_sign'];
			if(($M%2) == 0)
			$color="#FFFFB";
			else  	$color="#FFFFFF";
echo "<Tr bgcolor='$color'><Td valign='top' align='center'>$N</Td><Td valign='top' align='left'>";
echo thai_date_3($car_start);
echo "</Td><Td align='left'>";
echo thai_date_3($car_finish);
echo "</Td>";
echo "<Td valign='top' align='left' >$result[name]</Td>";
echo "<Td valign='top' align='left' >";
echo $full_name_ar[$person_id];
echo "</Td>";
echo "<Td valign='top' align='left' >";
echo thai_date_3($rec_date);
echo "</Td>";

echo "<Td valign='top' align='center'>";
if($grant==1){
echo "<img src=images/yes.png border='0'>";
}
else if($grant==2){
echo "<img src=images/no.png border='0'>";
}
else{
echo "รออนุมัติ";
}
echo "</Td>";
echo "</Tr>";

$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
}
echo "</Table>";
}

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=car&task=main/car_request_mobile");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.car.value == ""){
		alert("กรุณาเลือกรถยนต์");
		}else if(frm1.place.value == ""){
		alert("กรุณากรอกสถานไปราชการ");
		}else if(frm1.because.value == ""){
		alert("กรุณากรอกวัตถุประสงค์");
		}else if(frm1.control_person.value == ""){
		alert("กรุณากรอกผู้ควบคุมรถ");
		}else{
			callfrm("?option=car&task=main/car_request_mobile&index=4");   //page ประมวลผล
		}
	}
}


function goto_url_update(val){
	if(val==0){
		callfrm("?option=car&task=main/car_request_mobile");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.car.value == ""){
		alert("กรุณาเลือกรถยนต์");
		}else if(frm1.place.value == ""){
		alert("กรุณากรอกสถานไปราชการ");
		}else if(frm1.because.value == ""){
		alert("กรุณากรอกวัตถุประสงค์");
		}else if(frm1.control_person.value == ""){
		alert("กรุณากรอกผู้ควบคุมรถ");
		}else{
			callfrm("?option=car&task=main/car_request_mobile&index=6");   //page ประมวลผล
		}
	}
}

function goto_url2(val){
callfrm("?option=car&task=main/car_request_mobile");
}

</script>
