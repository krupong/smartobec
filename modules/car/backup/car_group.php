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

$sql_name = "select * from person_main ";
$dbquery_name = mysqli_query($connect,$sql_name);
while($result_name = mysqli_fetch_array($dbquery_name)){;
		$person_id = $result_name['person_id'];
		$prename=$result_name['prename'];
		$name= $result_name['name'];
		$surname = $result_name['surname'];
$full_name_ar[$person_id]="$prename$name&nbsp;&nbsp;$surname";
}

//อาเรย์ตำแหน่ง
$sql = "select * from  person_position order by position_code";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)){
$position_ar[$result['position_code']]=$result['position_name'];
}

//ส่วนหัว
echo "<br />";
if(!(($index==1)  or ($index==2) or ($index==5) or ($index==7))){
echo "<table width='100%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>ทะเบียนการขออนุญาตใช้รถราชการ</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form  id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>ความเห็นชอบ</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='90%' Border='0'>";
$sql = "select * from car_main where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);
$id=$ref_result['id'];
$person_id=$ref_result['person_id'];

$sql_person = "select * from  person_main where person_id='$ref_result[person_id]' ";
$dbquery_person = mysqli_query($connect,$sql_person);
$result_person = mysqli_fetch_array($dbquery_person);
$position=$result_person['position_code'];

echo "<Tr align='left'><Td align='right'>เรื่อง&nbsp;&nbsp;</Td><Td>ขออนุญาตใช้รถราชการ</Td></Tr>";
echo "<Tr align='left'><Td align='right'>เรียน&nbsp;&nbsp;</Td><Td>ผู้อำนวยการ$_SESSION[office_name]</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ข้าพเจ้า&nbsp;&nbsp;</Td><Td>$full_name_ar[$person_id]&nbsp;&nbsp;ตำแหน่ง&nbsp;&nbsp;$position_ar[$position]</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ขออนุญาตใช้รถราชการ&nbsp;&nbsp;</Td><Td><Select  name='car'  size='1'>";
echo  "<option  value = ''>เลือกรถ</option>" ;
$sql = "select * from  car_car where status='2' ";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$car_code = $result['car_code'];
		$car_number= $result['car_number'];
		$name = $result['name'];
				if($car_code==$ref_result['car']){
				echo  "<option value = $car_code selected>$car_number $name</option>";
				}
				else{
				echo  "<option value = $car_code>$car_number $name</option>";
				}
	}
echo "</select>";
echo "</Td></Tr>";
////ภาพ
$sql_pic = "select * from  car_car where car_code='$ref_result[car]' ";
$dbquery_pic = mysqli_query($connect,$sql_pic);
$result_pic = mysqli_fetch_array($dbquery_pic);
echo "<tr><td></td><td align='left'><img src='$result_pic[pic]' width='150'></td></tr>";
////
echo "<Tr align='left'><Td align='right'>สถานที่ไปราชการ&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='place' Size='60' value='$ref_result[place]'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>วัตถุประสงค์&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='because' Size='60' value='$ref_result[because]'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>ตั้งแต่วันที่&nbsp;&nbsp;</Td>";
echo "<Td align='left'>";
		$car_start=explode("-", $ref_result['car_start']);
		?>
		<script>
										var Y_date=<?php echo $car_start[0]?>
										var m_date=<?php echo $car_start[1]?>
										var d_date=<?php echo $car_start[2]?>
										Y_date= Y_date+'/'+m_date+'/'+d_date
										DateInput('car_start', true, 'YYYY-MM-DD', Y_date)</script>
		<?php
echo "</Td></Tr>";
$time_start=number_format($ref_result['time_start'],2);
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;เวลา</Td><Td><Input Type='Text' Name='time_start' Size='5' value='$time_start'>&nbspน.</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ถึงวันที่&nbsp;&nbsp;</Td>";
echo "<Td align='left'>";
		$car_finish=explode("-", $ref_result['car_finish']);
		?>
		<script>
										var Y_date=<?php echo $car_finish[0]?>
										var m_date=<?php echo $car_finish[1]?>
										var d_date=<?php echo $car_finish[2]?>
										Y_date= Y_date+'/'+m_date+'/'+d_date
										DateInput('car_finish', true, 'YYYY-MM-DD', Y_date)</script>
		<?php
echo "</Td></Tr>";
$time_finish=number_format($ref_result['time_finish'],2);
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;เวลา</Td><Td><Input Type='Text' Name='time_finish' Size='5' value='$time_finish'>&nbspน.</Td></Tr>";
echo "<Tr align='left'><Td align='right'>รวม&nbsp;&nbsp;</Td>";
echo "<Td><Input Type='Text' Name='day_total' Size='5' value='$ref_result[day_total]'>&nbsp;&nbsp;วัน";
echo "<Tr align='left'><Td align='right'>มีผู้โดยสารทั้งหมด&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='person_num' Size='5'  value='$ref_result[person_num]'>&nbsp;&nbsp;คน</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ผู้ควบคุมรถคือ&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='control_person' Size='60'  value='$ref_result[control_person]'></Td></Tr>";
$fuel_check_1="";
$fuel_check_2="";
$fuel_check_3="";
if( $ref_result['fuel']==1){
$fuel_check_2="checked";
}
else if ( $ref_result['fuel']==2){
$fuel_check_3="checked";
}
else {
$fuel_check_1="checked";
}
echo "<Tr align='left'><Td align='right'>เชื้อเพลิง&nbsp;&nbsp;</Td><Td><Input Type='radio' Name='fuel'  value='0' $fuel_check_1>ไม่ขอใช้จากงบเชื้อเพลิงกลาง สพท.</Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;</Td><Td><Input Type='radio' Name='fuel'  value='1' $fuel_check_2>ขอใช้จากงบเชื้อเพลิงกลางของ สพท.</Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;</Td><Td><Input Type='radio' Name='fuel'  value='2' $fuel_check_3>ขอใช้จากงบเชื้อเพลิงจากโครงการ&nbsp;<Input Type='Text' Name='project' Size='40' value='$ref_result[project]'>&nbsp;&nbsp;กิจกรรม&nbsp;<Input Type='Text' Name='activity' Size='40' value='$ref_result[activity]'></Td></Tr>";
echo "<Tr align='left'><Td></Td><Td>&nbsp;&nbsp;&nbsp;&nbsp;จำนวนเงิน&nbsp;<Input Type='Text' Name='money' Size='10'  value='$ref_result[money]'>&nbsp;บาท .</Td></Tr>";

if( $ref_result['self_driver']==1){
$self_driver_check="checked";
}
else{
$self_driver_check="";
}
echo "<Tr align='left'><Td align='right'>กรณีไม่มีพนักงานขับรถ&nbsp;&nbsp;</Td><Td><Input Type='checkbox' Name='self_driver'  value='1' $self_driver_check>ขออนุญาตเป็นผู้ขับรถคันดังกล่าว  ซึ่งได้รับใบอนุญาตในการขับขี่รถจากทางราชการประเภทนี้</Td></Tr>";
if( $ref_result['private_car']==1){
$private_car_check="checked";
}
else{
$private_car_check="";
}
echo "<Tr align='left'><Td align='right'>กรณีรถราชการไม่ว่าง&nbsp;&nbsp;</Td><Td><Input Type='checkbox' Name='private_car'  value='1' $private_car_check>ขออนุญาตใช้ส่วนส่วนตัวของ&nbsp<Input Type='Text' Name='car_owner' Size='40'  value='$ref_result[car_owner]'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;</Td><Td>หมายเลขทะเบียน&nbsp<Input Type='Text' Name='private_car_number' Size='40'  value='$ref_result[private_car_number]'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;</Td><Td>ผู้ขับขี่&nbsp<Input Type='Text' Name='private_driver' Size='40'  value='$ref_result[private_driver]'></Td></Tr>";

///////
echo "<tr><td colspan='2'>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>ส่วนเจ้าหน้าที่</B>: &nbsp;</legend>";
echo "<table>";
echo "<Tr align='left'><Td align='right'>เห็นควรให้&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='driver'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql_driver= "select  car_driver.person_id, person_main.prename, person_main.name, person_main.surname from car_driver left join person_main  on car_driver.person_id=person_main.person_id ";
$dbquery_driver = mysqli_query($connect,$sql_driver);
While ($result_driver = mysqli_fetch_array($dbquery_driver))
   {
		$person_id = $result_driver['person_id'];
		$prename = $result_driver['prename'];
		$name = $result_driver['name'];
		$surname = $result_driver['surname'];
		if($person_id==$ref_result['driver']){
		echo  "<option value = $person_id selected>$prename$name $surname</option>" ;
		}
		else{
		echo  "<option value = $person_id>$prename$name $surname</option>" ;
		}
	}
echo "</select>";
echo "&nbsp;เป็นพนักงานขับรถในราชการนี้</div></td></tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='officer_comment' Size='80' value='$ref_result[officer_comment]'></Td></Tr>";
$officer_sign=$ref_result['officer_sign'];
echo "<Tr align='left'><Td align='right'>ลงชื่อ&nbsp;&nbsp;</Td><Td>$full_name_ar[$officer_sign]</Td></Tr>";
echo "<Tr align='left'><Td align='right'>วดป&nbsp;&nbsp;</Td><Td>";
echo  thai_date_4($ref_result['officer_date']);
echo "</Td></Tr>";
echo "</table></fieldset>";
echo "</tr>";
///////
///////
echo "<tr><td colspan='2'>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>ส่วนให้ความเห็นชอบ</B>: &nbsp;</legend>";
echo "<table>";
echo "<Tr align='left'><Td align='right'>ความเห็น&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='group_comment' Size='80' value='$ref_result[group_comment]'></Td></Tr>";
echo "</table></fieldset>";
echo "</tr>";
///////

echo "</Table>";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "<Input Type=Hidden Name='page' Value='$_GET[page]'>";
echo "<Input Type=Hidden Name='car_index' Value='$car_index'>";
echo "<Br>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)' class=entrybutton>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)' class=entrybutton'>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
$date_time_now = date("Y-m-d H:i:s");
		$sql = "update car_main set group_comment='$_POST[group_comment]',
		group_sign='$user',
		group_date='$date_time_now'
		where id='$_POST[id]'";
		$dbquery = mysqli_query($connect,$sql);
}

if ($index==7){
echo "<Center>";
echo "<Font color='#006666' Size=3><B>รายละเอียด</B></Font>";
echo "</Cener>";
echo "<Br>";
echo "<Br>";
echo "<Table  align='center' width='80%' Border='0'>";
echo "<Tr ><Td colspan='2' align='right'><INPUT TYPE='button' name='smb' value='<<กลับหน้าก่อน' onclick='location.href=\"?option=car&task=main/car_group&page=$_GET[page]&car_index=$car_index\"'></Td></Tr>";
$sql = "select * from car_main where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);
$id=$ref_result['id'];
$person_id=$ref_result['person_id'];
$rec_date=$ref_result['rec_date'];

// ชื่อและตำแหน่ง
$sql_name = "select * from person_main  left join  person_position  on  person_main.position_code=person_position.position_code  where  person_main.person_id='$person_id'";
$dbquery_name = mysqli_query($connect,$sql_name);
$result_name = mysqli_fetch_array($dbquery_name);
		$person_id = $result_name['person_id'];
		$prename=$result_name['prename'];
		$name= $result_name['name'];
		$surname = $result_name['surname'];
		$position_name = $result_name['position_name'];
		$full_name="$prename$name&nbsp;&nbsp;$surname";

echo "<Tr align='left'><Td align='right'>วันที่&nbsp;&nbsp;</Td><Td>";
echo thai_date_3($rec_date);
echo "</Td></Tr>";
echo "<Tr align='left'><Td align='right'>เรื่อง&nbsp;&nbsp;</Td><Td>ขออนุญาตใช้รถราชการ</Td></Tr>";
echo "<Tr align='left'><Td align='right'>เรียน&nbsp;&nbsp;</Td><Td>ผู้อำนวยการ$_SESSION[office_name]</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ข้าพเจ้า&nbsp;&nbsp;</Td><Td>$full_name&nbsp;&nbsp;ตำแหน่ง&nbsp;&nbsp;$position_name</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ขออนุญาตใช้รถราชการ&nbsp;&nbsp;</Td><Td><Select  name='car'  size='1'>";
echo  "<option  value = ''>เลือกรถ</option>" ;
$sql = "select * from  car_car where status='2' ";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$car_code = $result['car_code'];
		$car_number= $result['car_number'];
		$name = $result['name'];
				if($car_code==$ref_result['car']){
				echo  "<option value = $car_code selected>$car_number $name</option>";
				}
				else{
				echo  "<option value = $car_code>$car_number $name</option>";
				}
	}
echo "</select>";
echo "</Td></Tr>";
////ภาพ
$sql_pic = "select * from  car_car where car_code='$ref_result[car]' ";
$dbquery_pic = mysqli_query($connect,$sql_pic);
$result_pic = mysqli_fetch_array($dbquery_pic);
echo "<tr><td></td><td align='left'><img src='$result_pic[pic]' width='150'></td></tr>";
////
echo "<Tr align='left'><Td align='right'>สถานที่ไปราชการ&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='place' Size='60' value='$ref_result[place]'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>วัตถุประสงค์&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='because' Size='60' value='$ref_result[because]'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>ตั้งแต่วันที่&nbsp;&nbsp;</Td>";
echo "<Td align='left'>";
		$car_start=explode("-", $ref_result['car_start']);
		?>
		<script>
										var Y_date=<?php echo $car_start[0]?>
										var m_date=<?php echo $car_start[1]?>
										var d_date=<?php echo $car_start[2]?>
										Y_date= Y_date+'/'+m_date+'/'+d_date
										DateInput('car_start', true, 'YYYY-MM-DD', Y_date)</script>
		<?php
echo "</Td></Tr>";
$time_start=number_format($ref_result['time_start'],2);
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;เวลา</Td><Td><Input Type='Text' Name='time_start' Size='5' value='$time_start'>&nbspน.</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ถึงวันที่&nbsp;&nbsp;</Td>";
echo "<Td align='left'>";
		$car_finish=explode("-", $ref_result['car_finish']);
		?>
		<script>
										var Y_date=<?php echo $car_finish[0]?>
										var m_date=<?php echo $car_finish[1]?>
										var d_date=<?php echo $car_finish[2]?>
										Y_date= Y_date+'/'+m_date+'/'+d_date
										DateInput('car_finish', true, 'YYYY-MM-DD', Y_date)</script>
		<?php
echo "</Td></Tr>";
$time_finish=number_format($ref_result['time_finish'],2);
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;เวลา</Td><Td><Input Type='Text' Name='time_finish' Size='5' value='$time_finish'>&nbspน.</Td></Tr>";
echo "<Tr align='left'><Td align='right'>รวม&nbsp;&nbsp;</Td>";
echo "<Td><Input Type='Text' Name='day_total' Size='5' value='$ref_result[day_total]'>&nbsp;&nbsp;วัน";
echo "<Tr align='left'><Td align='right'>มีผู้โดยสารทั้งหมด&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='person_num' Size='5'  value='$ref_result[person_num]'>&nbsp;&nbsp;คน</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ผู้ควบคุมรถคือ&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='control_person' Size='60'  value='$ref_result[control_person]'></Td></Tr>";
$fuel_check_1="";
$fuel_check_2="";
$fuel_check_3="";
if( $ref_result['fuel']==1){
$fuel_check_2="checked";
}
else if ( $ref_result['fuel']==2){
$fuel_check_3="checked";
}
else {
$fuel_check_1="checked";
}
echo "<Tr align='left'><Td align='right'>เชื้อเพลิง&nbsp;&nbsp;</Td><Td><Input Type='radio' Name='fuel'  value='0' $fuel_check_1>ไม่ขอใช้จากงบเชื้อเพลิงกลาง สพท.</Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;</Td><Td><Input Type='radio' Name='fuel'  value='1' $fuel_check_2>ขอใช้จากงบเชื้อเพลิงกลางของ สพท.</Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;</Td><Td><Input Type='radio' Name='fuel'  value='2' $fuel_check_3>ขอใช้จากงบเชื้อเพลิงจากโครงการ&nbsp;<Input Type='Text' Name='project' Size='40' value='$ref_result[project]'>&nbsp;&nbsp;กิจกรรม&nbsp;<Input Type='Text' Name='activity' Size='40' value='$ref_result[activity]'></Td></Tr>";
echo "<Tr align='left'><Td></Td><Td>&nbsp;&nbsp;&nbsp;&nbsp;จำนวนเงิน&nbsp;<Input Type='Text' Name='money' Size='10'  value='$ref_result[money]'>&nbsp;บาท .</Td></Tr>";

if( $ref_result['self_driver']==1){
$self_driver_check="checked";
}
else{
$self_driver_check="";
}
echo "<Tr align='left'><Td align='right'>กรณีไม่มีพนักงานขับรถ&nbsp;&nbsp;</Td><Td><Input Type='checkbox' Name='self_driver'  value='1' $self_driver_check>ขออนุญาตเป็นผู้ขับรถคันดังกล่าว  ซึ่งได้รับใบอนุญาตในการขับขี่รถจากทางราชการประเภทนี้</Td></Tr>";
if( $ref_result['private_car']==1){
$private_car_check="checked";
}
else{
$private_car_check="";
}
echo "<Tr align='left'><Td align='right'>กรณีรถราชการไม่ว่าง&nbsp;&nbsp;</Td><Td><Input Type='checkbox' Name='private_car'  value='1' $private_car_check>ขออนุญาตใช้ส่วนส่วนตัวของ&nbsp<Input Type='Text' Name='car_owner' Size='40'  value='$ref_result[car_owner]'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;</Td><Td>หมายเลขทะเบียน&nbsp<Input Type='Text' Name='private_car_number' Size='40'  value='$ref_result[private_car_number]'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;</Td><Td>ผู้ขับขี่&nbsp<Input Type='Text' Name='private_driver' Size='40'  value='$ref_result[private_driver]'></Td></Tr>";
///////
echo "<tr><td colspan='2'>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>ส่วนเจ้าหน้าที่</B>: &nbsp;</legend>";
echo "<table>";
echo "<Tr align='left'><Td align='right'>เห็นควรให้&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='driver'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql_driver= "select  car_driver.person_id, person_main.prename, person_main.name, person_main.surname from car_driver left join person_main  on car_driver.person_id=person_main.person_id ";
$dbquery_driver = mysqli_query($connect,$sql_driver);
While ($result_driver = mysqli_fetch_array($dbquery_driver))
   {
		$person_id = $result_driver['person_id'];
		$prename = $result_driver['prename'];
		$name = $result_driver['name'];
		$surname = $result_driver['surname'];
		if($person_id==$ref_result['driver']){
		echo  "<option value = $person_id selected>$prename$name $surname</option>" ;
		}
		else{
		echo  "<option value = $person_id>$prename$name $surname</option>" ;
		}
	}
echo "</select>";
echo "&nbsp;เป็นพนักงานขับรถในราชการนี้</div></td></tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='officer_comment' Size='80' value='$ref_result[officer_comment]'></Td></Tr>";
$officer_sign=$ref_result['officer_sign'];
echo "<Tr align='left'><Td align='right'>ลงชื่อ&nbsp;&nbsp;</Td><Td>";
if(isset($full_name_ar[$officer_sign])){
echo $full_name_ar[$officer_sign];
}
echo "</Td></Tr>";
echo "<Tr align='left'><Td align='right'>วดป&nbsp;&nbsp;</Td><Td>";
echo  thai_date_4($ref_result['officer_date']);
echo "</Td></Tr>";
echo "</table></fieldset>";
echo "</tr>";
///////
///////
echo "<tr><td colspan='2'>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>ส่วนความเห็นชอบ</B>: &nbsp;</legend>";
echo "<table>";
echo "<Tr align='left'><Td align='right'>ความเห็น&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='group_comment' Size='80' value='$ref_result[group_comment]'></Td></Tr>";
$group_sign=$ref_result['group_sign'];
echo "<Tr align='left'><Td align='right'>ลงชื่อ&nbsp;&nbsp;</Td><Td>";
if(isset($full_name_ar[$group_sign])){
echo $full_name_ar[$group_sign];
}
echo "</Td></Tr>";
echo "<Tr align='left'><Td align='right'>วดป&nbsp;&nbsp;</Td><Td>";
echo  thai_date_4($ref_result['group_date']);
echo "</Td></Tr>";
echo "</table></fieldset>";
echo "</tr>";
///////
///////
echo "<tr><td colspan='2'>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>ส่วนการอนุมัติ</B>: &nbsp;</legend>";
echo "<table>";
echo "<Tr align='left'><Td align='right'>คำสั่ง(ถ้ามี)&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='grant_comment' Size='80' value='$ref_result[grant_comment]'></Td></Tr>";
		$commander_grant_check1=""; $commander_grant_check2="";
		if($ref_result['commander_grant']==1){
		$commander_grant_check1="checked";
		}
		else if($ref_result['commander_grant']==2){
		$commander_grant_check2="checked";
		}
echo "<Tr align='left'><Td align='right'>อนุมัติ/ไม่อนุมัติ&nbsp;&nbsp;</Td><Td><Input Type='radio' Name='commander_grant' value='1' $commander_grant_check1>อนุมัติ&nbsp;&nbsp;<Input Type='radio' Name='commander_grant' value='2' $commander_grant_check2>ไม่อนุมัติ&nbsp;&nbsp;</Td></Tr>";
$commander_sign=$ref_result['commander_sign'];
echo "<Tr align='left'><Td align='right'>ลงชื่อ&nbsp;&nbsp;</Td><Td>";
if(isset($full_name_ar[$commander_sign])){
echo $full_name_ar[$commander_sign];
}
echo "</Td></Tr>";
echo "<Tr align='left'><Td align='right'>วดป&nbsp;&nbsp;</Td><Td>";
echo  thai_date_4($ref_result['commander_date']);
echo "</Td></Tr>";
echo "</table></fieldset>";
echo "</tr>";

///////

echo "</table>";
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5) or ($index==7))){

//ส่วนของการแยกหน้า
if($car_index>=1){
$sql="select id from car_main where car='$car_index' and  officer_sign is not null ";
}
else{
$sql="select id from car_main where  officer_sign is not null";
}
$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery);

$pagelen=20;  // 1_กำหนดแถวต่อหน้า
$url_link="option=car&task=main/car_group&car_index=$car_index";  // 2_กำหนดลิงค์ฺ
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
$sql="select car_main.id, car_main.person_id, car_main.car_start, car_main.car_finish, car_main.rec_date, car_main.officer_sign, car_main.group_sign, car_main.commander_sign, car_main.commander_grant, car_car.name  from car_main left join car_car on  car_main.car=car_car.car_code  where car_main.car='$car_index'  and  car_main.officer_sign is not null order by car_start, car_car.car_code limit $start,$pagelen";
}
else{
$sql="select car_main.id, car_main.person_id, car_main.car_start, car_main.car_finish, car_main.rec_date,  car_main.officer_sign, car_main.group_sign, car_main.commander_sign, car_main.commander_grant, car_car.name  from car_main left join car_car on  car_main.car=car_car.car_code where  car_main.officer_sign is not null order by car_start, car_car.car_code limit $start,$pagelen";
}
$dbquery = mysqli_query($connect,$sql);

echo  "<table width='95%' border='0' align='center'>";
echo "<Tr>";
echo "<Td colspan='11' align='right'>";
echo "<form  name='frm1'>";
echo "&nbsp;<Select  name='car_index' size='1'>";
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
echo "&nbsp;<INPUT TYPE='button' name='smb' value='เลือก' onclick='goto_url2(1)'>";
echo "</form>";

echo "</Td>";
echo "</Tr>";

echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='60'>เลขที่</Td><Td width='120'>วันเริ่มใช้รถ</Td><Td width='120'>วันสิ้นสุดการใช้</Td><Td>รถ</Td><Td>ผู้ขอใช้</Td><Td width='120'>วดป ขออนุญาต</Td><Td  width='120'>อนุมัติ/คำสั่ง</Td><Td width='70'>รายละเอียด</Td><Td width='40' colspan='2'>ผู้เห็นชอบ</Td></Tr>";

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
echo "<Td valign='top' align='center'><a href=?option=car&task=main/car_officer&index=5&ed=1&from=car_group&id=$id&page=$page&car_index=$car_index><img src=images/browse.png border='0' alt='รายละเอียด'></Td>";

if($result['group_sign']!=""){
echo "<Td align='center'><img src=images/yes.png border='0'></Td>";
}
else{
echo "<Td align='center'><img src=images/no.png border='0' ></Td>";
}

if($commander_sign==""){
echo "<Td align='center'><a href=?option=car&task=main/car_group&index=5&id=$id&page=$page&car_index=$car_index><img src=images/b_edit.png border='0'></Td>";
}
else{
echo "<td></td>";
}
echo "</Tr>";

$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
}
echo "</Table>";
}

?>
<script>
function goto_url_update(val){
	if(val==0){
		callfrm("?option=car&task=main/car_group");   // page ย้อนกลับ
	}else if(val==1){
			callfrm("?option=car&task=main/car_group&index=6");   //page ประมวลผล
	}
}

function goto_url2(val){
callfrm("?option=car&task=main/car_group");
}

</script>
