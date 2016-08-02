<?php
if(!isset($_SESSION['login_user_id'])){ $_SESSION['login_user_id']=""; exit();
}else{
//หาหน่วยงาน
$login_user_id=mysqli_real_escape_string($connect,$_SESSION['login_user_id']);
    $sql_user_depart="select * from person_main where person_id=? ";
    $query_user_depart = $connect->prepare($sql_user_depart);
    $query_user_depart->bind_param("i", $login_user_id);
    $query_user_depart->execute();
    $result_quser_depart=$query_user_depart->get_result();
While ($result_user_depart = mysqli_fetch_array($result_quser_depart))
   {
    $user_departid=$result_user_depart['department'];
    }
//หาชื่อหน่วยงาน
    $sql_depart_name="select * from system_department where department=? ";
    $query_depart_name = $connect->prepare($sql_depart_name);
    $query_depart_name->bind_param("i", $user_departid);
    $query_depart_name->execute();
    $result_qdepart_name=$query_depart_name->get_result();
While ($result_depart_name = mysqli_fetch_array($result_qdepart_name))
   {
    $user_department_name=$result_depart_name['department_name'];
    $user_department_precisname=$result_depart_name['department_precis'];
	}
}

/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
$login_group=mysqli_real_escape_string($connect,$_SESSION['login_group']);
if(!($login_group<=1)){
exit();
}
    //ตรวจสอบสิทธิ์ผู้ใช้
    $sql_permis = "select * from  meeting_permission where person_id=? ";
    $dbquery_permis = $connect->prepare($sql_permis);
    $dbquery_permis->bind_param("i", $login_user_id);
    $dbquery_permis->execute();
    $result_qpermis=$dbquery_permis->get_result();
    While ($result_permis = mysqli_fetch_array($result_qpermis))
    {
        $user_permis=$result_permis['p1'];
    }
  if(!isset($user_permis)){
$user_permis="";
}
  // if($user_permis!=1){
    //    exit();
    //}

require_once "modules/meeting/time_inc.php";
?>
<?php


//กรณีเลือกแสดงเฉพาะห้องประชุม

if(isset($_GET['room_index'])){
$getroom_index=mysqli_real_escape_string($connect,$_GET['room_index']);
    if($getroom_index!=""){
    $showroom=" and meeting_main.room=$getroom_index ";
    $sql_room="select * from meeting_room where room_code=? and active='1'  order by id";
    $dbquery_room = $connect->prepare($sql_room);
    $dbquery_room->bind_param("i", $getroom_index);
    $dbquery_room->execute();
    $result_qroom=$dbquery_room->get_result();
        While ($result_room = mysqli_fetch_array($result_qroom)){
 $room_name=$result_room['room_name'] ;
}
    }else{$showroom="";$room_name="ทุกห้องประชุม"; $get_room="";}
}else {$getroom_index=""; $showroom=""; $room_name="ทุกห้องประชุม"; $get_room=""; }


//ส่วนหัว
echo "<br />";
//รับค่าวันเริ่มต้น
if(isset($_GET['start_date'])){
$getdatestart=mysqli_real_escape_string($connect,$_GET['start_date']);
    $month_name=explode("-", $getdatestart);
    $month_name=$month_name[1];  //เดือน
if($month_name=='01'){$month_name="มกราคม";
}else if($month_name=='02'){$month_name="กุมภาพันธ์";
}else if($month_name=='03'){$month_name="มีนาคม";
}else if($month_name=='04'){$month_name="เมษายน";
}else if($month_name=='05'){$month_name="พฤษภาคม";
}else if($month_name=='06'){$month_name="มิถุนายน";
}else if($month_name=='07'){$month_name="กรกฎาคม";
}else if($month_name=='08'){$month_name="สิงหาคม";
}else if($month_name=='09'){$month_name="กันยายน";
}else if($month_name=='10'){$month_name="ตุลาคม";
}else if($month_name=='11'){$month_name="พฤศจิกายน";
}else if($month_name=='12'){$month_name="ธันวาคม";
}else{$month_name="";}

}else {$getdatestart="";}
//รับค่าวันสิ้นสุด
if(isset($_GET['end_date'])){
$getdateend=mysqli_real_escape_string($connect,$_GET['end_date']);
}else {$getdateend="";}


if(isset($_GET['index'])){
$getindex=mysqli_real_escape_string($connect,$_GET['index']);
}else {$getindex="";}

if(isset($_POST['index'])){
$postindex=mysqli_real_escape_string($connect,$_POST['index']);
}else {$postindex="";}

if(!(($getindex==1) or ($getindex==2) or ($getindex==11))){

echo "<table width='100%' border='0' align='center' >";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>รายการใช้งาน $room_name ของ $user_department_name<BR>ประจำเดือน $month_name </strong></font><br><br></td></tr>";
echo "</table>";
}

//ส่วนแสดงผล
if(!(($getindex==1) or ($getindex==2) or ($getindex==11))){



//ส่วนของการแยกหน้า
//$sql_meeting="select id from meeting_main where user_book=? ";
$sql_joinroom="select meeting_main.*, meeting_room.* ,meeting_main.id as id ,meeting_main.rec_date as rec_date from meeting_main left join meeting_room on meeting_main.room = meeting_room.room_code where meeting_room.department=? $showroom and ((meeting_main.book_date_start between ? and ?) or (meeting_main.book_date_end between ? and ? )) and meeting_main.approve=1 order by meeting_main.book_date_start desc,meeting_main.room,meeting_main.start_time ";

    $dbquery_joinroom = $connect->prepare($sql_joinroom);
    $dbquery_joinroom->bind_param("issss", $user_departid,$getdatestart,$getdateend,$getdatestart,$getdateend);
    $dbquery_joinroom->execute();
    $result_joinroomnum=$dbquery_joinroom->get_result();

$num_rows = mysqli_num_rows($result_joinroomnum);

$pagelen=40;  // 1_กำหนดแถวต่อหน้า
$url_link="option=meeting&task=main/report2";  // 2_กำหนดลิงค์ฺ
$totalpages=ceil($num_rows/$pagelen);

if(!isset($_REQUEST['page'])){
$_REQUEST['page']="";
}

if($_REQUEST['page']==""){
$page=$totalpages;
		if($page<2){
		$page=1;
		}
$start=0;

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
    $start=($page-1)*$pagelen;
}

//$start=($page-1)*$pagelen;

if(($totalpages>1) and ($totalpages<16)){
echo "<div align=center>";
echo "หน้า	";
			for($i=1; $i<=$totalpages; $i++)	{
                if($start==0){$page=1;}
					if($i==$page){
					echo "[<b><font size=+1 color=#990000>$i</font></b>]";
					}
					else {
					echo "<a href=$PHP_SELF?$url_link&start_date=$getdatestart&end_date=$getdateend&page=$i>[$i]</a>";
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
			echo "<<a href=$PHP_SELF?$url_link&start_date=$getdatestart&end_date=$getdateend&page=1>หน้าแรก </a>";
			echo "<<<a href=$PHP_SELF?$url_link&start_date=$getdatestart&end_date=$getdateend&page=$f_page1>หน้าก่อน </a>";
			}
			else {
			echo "หน้า	";
			}
			for($i=$s_page; $i<=$e_page; $i++){
					if($i==$page){
					echo "[<b><font size=+1 color=#990000>$i</font></b>]";
					}
					else {
					echo "<a href=$PHP_SELF?$url_link&start_date=$getdatestart&end_date=$getdateend&page=$i>[$i]</a>";
					}
			}
			if($page<$totalpages)	{
			$f_page2=$page+1;
			echo "<a href=$PHP_SELF?$url_link&start_date=$getdatestart&end_date=$getdateend&page=$f_page2> หน้าถัดไป</a>>>";
			echo "<a href=$PHP_SELF?$url_link&start_date=$getdatestart&end_date=$getdateend&page=$totalpages> หน้าสุดท้าย</a>>";
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

$sql_join="select meeting_main.*, meeting_room.* ,meeting_main.id as id ,meeting_main.rec_date as rec_date from meeting_main left join meeting_room on meeting_main.room = meeting_room.room_code where meeting_room.department=? $showroom and ((meeting_main.book_date_start between ? and ?) or (meeting_main.book_date_end between ? and ? )) and meeting_main.approve=1 order by meeting_main.book_date_start desc,meeting_main.room,meeting_main.start_time limit $start,$pagelen";

    $dbquery_join = $connect->prepare($sql_join);
    $dbquery_join->bind_param("issss", $user_departid,$getdatestart,$getdateend,$getdatestart,$getdateend);
    $dbquery_join->execute();
    $result_joinroom=$dbquery_join->get_result();

//$dbquery = mysqli_query($connect,$sql);

echo  "<table width=95% border=0 align=center class='table table-hover table-bordered table-striped table-condensed'>";
//echo "<Tr><Td colspan='13' align='left'><table width='100%'><tr><td align='left'><INPUT TYPE='button' name='smb' class='btn btn-success' value='จองห้องประชุมในสำนัก' onclick='location.href=\"?option=meeting&task=main/meeting&index=1\"'>";
//echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//echo "<INPUT TYPE='button' name='smb' class='btn btn-danger' value='จองห้องประชุมต่างสำนัก' onclick='location.href=\"?option=meeting&task=main/meeting&index=11\"'>";



echo "<Tr class='success' align='center'><Td width='80'>วันที่เริ่ม</Td><Td width='80'>วันที่สิ้นสุด</Td><Td width='200'>ห้องประชุม</Td><Td  width='70'>ตั้งแต่เวลา</Td><Td width='70'>ถึงเวลา</Td><Td>ประธานการประชุม/วัตถุประสงค์</Td><Td width='150'>อื่น ๆ/ผู้ประสานงาน</Td><Td width='150'>ผู้จอง(วันเวลา)</Td><Td>หมายเหตุ</Td></Tr>";

$N=(($page-1)*$pagelen)+1; //*เกี่ยวข้องกับการแยกหน้า
$M=1;

While ($result = mysqli_fetch_array($result_joinroom)){
 		$id= $result['id'];
		$room= $result['room'];
		$start_time=$result['start_time'];
		$start_time=number_format($start_time,2);
		$finish_time=$result['finish_time'];
		$finish_time=number_format($finish_time,2);
		$book_date_start = $result['book_date_start'];
		$book_date_end = $result['book_date_end'];
		$rec_date = $result['rec_date'];
        $coordinator = $result['coordinator'];
		$chairman = $result['chairman'];
		$person_num = $result['person_num'];
		$book_person = $result['book_person'];
		$user_book = $result['user_book'];
		$other = $result['other'];
		$rec_date = $result['rec_date'];

    $sql_room = "select * from meeting_room where room_code=? ";
    $dbquery_room = $connect->prepare($sql_room);
    $dbquery_room->bind_param("i", $room);
    $dbquery_room->execute();
    $result_meetroom=$dbquery_room->get_result();
    While ($result_room = mysqli_fetch_array($result_meetroom))
    {
        $room_name=$result_room['room_name'];
    }

    //หาชื่อผู้จอง
    $sql_person="select * from person_main where  status='0' and person_id=? ";

    $dbquery_person = $connect->prepare($sql_person);
    $dbquery_person->bind_param("i", $user_book);
    $dbquery_person->execute();
    $result_qperson=$dbquery_person->get_result();
 While ($result_person = mysqli_fetch_array($result_qperson))
{
     $name=$result_person['name'];
     $surname=$result_person['surname'];
     $department=$result_person['department'];
}

if($department!=$user_departid){
    //หาชื่อหน่วยงาน
    $sql_depart_name="select * from system_department where department=? ";
    $query_depart_name = $connect->prepare($sql_depart_name);
    $query_depart_name->bind_param("i", $department);
    $query_depart_name->execute();
    $result_qdepart_name=$query_depart_name->get_result();
While ($result_depart_name = mysqli_fetch_array($result_qdepart_name))
   {
    $book_department_name=$result_depart_name['department_name'];
    $book_department_precisname=$result_depart_name['department_precis'];
	}
     $showdepartmybook = " <a tabindex='0' class='btn btn-warning btn-xs' role='button' data-toggle='popover' data-placement='top' data-trigger='focus' title='สำนัก' data-content=$book_department_name>$book_department_precisname</a>";
        }else{$showdepartmybook="";}



    //if(($M%2) == 0)
			$color="";
			//else  	$color="#FFFFFF";
echo "<Tr bgcolor='$color'>";
echo "<Td align='left'>";
echo thai_date_3($book_date_start);
echo "</Td>";
echo "<Td align='left'>";
echo thai_date_3($book_date_end);
echo "</Td>";
echo "<Td align='left'>";
echo $room_name;
echo "</Td>";
echo "<Td align='center'>$start_time น.</Td><Td align='center' >$finish_time น.</Td>";
echo "<td>$result[chairman]/$result[objective]</td>";

echo "<td>$result[other]/$result[coordinator]</td>";
echo "<Td>$name $surname(<font size='1px'>";
echo thai_date_4($rec_date);
//echo $rec_date;

    echo "</font>) $showdepartmybook</Td>";


if($result['reason']!=""){
echo "<Td align='left'>$result[reason]</Td>";
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
