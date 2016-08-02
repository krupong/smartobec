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
    if($user_permis!=1){
        exit();
    }

require_once "modules/meeting/time_inc.php";

//กรณีเลือกแสดงเฉพาะห้องประชุม
if(isset($_REQUEST['room_index'])){
$room_index=$_REQUEST['room_index'];
}else{
	$room_index = "";
	}
//ส่วนหัว
echo "<br />";

if(isset($_GET['index'])){
$getindex=mysqli_real_escape_string($connect,$_GET['index']);
}else {$getindex="";}

if(isset($_POST['index'])){
$postindex=mysqli_real_escape_string($connect,$_POST['index']);
}else {$postindex="";}

if(!(($getindex==1) or ($getindex==2) or ($getindex==11))){

echo "<table width='100%' border='0' align='center' >";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>รายการจองห้องประชุมของบุคลากรในสำนัก $user_department_name</strong></font><br><br></td></tr>";
echo "</table>";
}


//ส่วนยืนยันการลบข้อมูล

if(isset($_GET['id'])){
$getid=mysqli_real_escape_string($connect,$_GET['id']);
}else {$getid="";}


if($getindex==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=meeting&task=main/meeting_dep&index=3&id=$getid&page=$_REQUEST[page]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=meeting&task=main/meeting_dep&page=$_REQUEST[page]\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($getindex==3){
if(isset($_GET['aid'])){
$getid=mysqli_real_escape_string($connect,$_GET['aid']);
}else {$getid="";}
$sql = "delete from meeting_main where id=?";
    $dbquery = $connect->prepare($sql);
    $dbquery->bind_param("i", $getid);
    $dbquery->execute();
    $result=$dbquery->get_result();
    echo "<script>document.location.href='?option=meeting&task=main/meeting_dep&page=$_REQUEST[page]'; </script>\n";
 }


//ส่วนแสดงผล
if(!(($getindex==1) or ($getindex==2) or ($getindex==11))){

if(isset($_POST['status_index'])){
$poststatus_index=mysqli_real_escape_string($connect,$_POST['status_index']);
    if($poststatus_index!=""){
    $showstatus=" and meeting_main.approve=$poststatus_index ";
    }else{$showstatus="";}
}else {$poststatus_index=""; $showstatus="";}


//ส่วนของการแยกหน้า
//$sql_meeting="select id from meeting_main where user_book=? ";
$sql_joinroom="select meeting_main.*, person_main.* ,meeting_main.id as id ,meeting_main.rec_date as rec_date from meeting_main left join person_main on meeting_main.book_person = person_main.person_id where person_main.department=? $showstatus order by meeting_main.book_date_start desc,meeting_main.room,meeting_main.start_time ";

    $dbquery_joinroom = $connect->prepare($sql_joinroom);
    $dbquery_joinroom->bind_param("i", $user_departid);
    $dbquery_joinroom->execute();
    $result_joinroomnum=$dbquery_joinroom->get_result();

$num_rows = mysqli_num_rows($result_joinroomnum);

$pagelen=20;  // 1_กำหนดแถวต่อหน้า
$url_link="option=meeting&task=main/meeting_dep";  // 2_กำหนดลิงค์ฺ
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

$sql_join="select meeting_main.*, person_main.* ,meeting_main.id as id ,meeting_main.rec_date as rec_date from meeting_main left join person_main on meeting_main.book_person = person_main.person_id where person_main.department=? $showstatus order by meeting_main.book_date_start desc,meeting_main.room,meeting_main.start_time limit $start,$pagelen";

    $dbquery_join = $connect->prepare($sql_join);
    $dbquery_join->bind_param("i", $user_departid);
    $dbquery_join->execute();
    $result_joinroom=$dbquery_join->get_result();



echo  "<table width=95% border=0 align=center class='table table-hover table-bordered table-striped table-condensed'>";

echo "<Tr><Td colspan='13' align='left'><table width='100%'><tr><td align='left'>";
echo "</Td><td align='right'>";

//เพิ่มการเลือกสถานะ
echo "<form  name='frm1' action='?option=meeting&task=main/meeting_dep' method='POST'>";

echo "&nbsp;<Select  name='status_index' class='selectpicker'>";
echo "<option value ='' >ทุกสถานะ</option>" ;
echo "<option value ='0' >รอการอนุญาต</option>" ;
echo "<option value ='1' >อนุญาตแล้ว</option>" ;
echo "<option value ='2' >ไม่อนุญาต</option>" ;
echo "</select>";
echo "&nbsp;<INPUT TYPE='submit' name='smb' class='btn btn-info' value='เลือก' >";
echo "</form>";


echo "</td></tr></table>";

echo "</td></Tr>";

echo "<Tr class='success' align='center'><Td width='80'>วันที่เริ่ม</Td><Td width='80'>วันที่สิ้นสุด</Td><Td width='200'>ห้องประชุม</Td><Td  width='70'>ตั้งแต่เวลา</Td><Td width='70'>ถึงเวลา</Td><Td>ประธานการประชุม/วัตถุประสงค์</Td><Td width='200'>อื่น ๆ/ผู้ประสานงาน</Td><Td>ผู้จอง(วันเวลา)</Td><Td width='40'>ลบ</Td><Td width='40'>อนุญาต</Td><Td>หมายเหตุ</Td></Tr>";

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
		$name= $result['name'];
		$surname = $result['surname'];
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

  if($result_room['department']!=$user_departid){
    //หาชื่อหน่วยงาน
    $sql_depart_name="select * from system_department where department=? ";
    $query_depart_name = $connect->prepare($sql_depart_name);
    $query_depart_name->bind_param("i", $result_room['department']);
    $query_depart_name->execute();
    $result_qdepart_name=$query_depart_name->get_result();
While ($result_depart_name = mysqli_fetch_array($result_qdepart_name))
   {
    $book_department_name=$result_depart_name['department_name'];
    $book_department_precisname=$result_depart_name['department_precis'];
	}

        $showdepartmybook = " <a tabindex='0' class='btn btn-warning btn-xs' role='button' data-toggle='popover' data-placement='top' data-trigger='focus' title='ห้องประชุมสำนัก' data-content=$book_department_name>$book_department_precisname</a>";
        }else{$showdepartmybook="";}
    }
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
echo $room_name.$showdepartmybook;
echo "</Td>";
echo "<Td align='center'>$start_time น.</Td><Td align='center' >$finish_time น.</Td>";
echo "<td>$result[chairman]/$result[objective]</td>";

echo "<td>$result[other]/$result[coordinator]</td>";
echo "<Td>$name $surname (";
echo thai_date_4($rec_date);
//echo $rec_date;

    echo ")</Td>";

    
if($user_permis==1){
echo   "<Td align='center'><a href='?option=meeting&task=main/meeting_dep&index=3&aid=$id&page=$page' data-toggle='confirmation' data-placement='top'><img src=images/drop.png border='0' alt='ลบ'></a></td>";
}
else{
echo "<td></td>";
}

if($result['approve']==1){
echo "<Td align='center'><img src=images/yes.png border='0' alt='อนุญาต'></Td>";
}
else if($result['approve']==2){
echo "<Td align='center'><img src=images/no.png border='0' alt='ไม่อนุญาต'></Td>";
}
else {
echo "<td></td>";
}

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

if(!(($getindex==1) or ($getindex==2) or ($getindex==3) or ($getindex==11))) {
echo "<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src=images/yes.png border='0'> หมายถึง อนุญาตให้ใช้ห้องประชุม&nbsp;&nbsp;<img src=images/no.png border='0'> หมายถึง ไม่อนุญาตให้ใช้ห้องประชุม";
}
?>
