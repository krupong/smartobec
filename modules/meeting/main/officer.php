<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
$admin_meeting=mysqli_real_escape_string($connect,$_SESSION['admin_meeting']);
if($admin_meeting!="meeting"){
exit();
}
$login_group=mysqli_real_escape_string($connect,$_SESSION['login_group']);
if(!($login_group<=1)){
exit();
}

require_once "modules/meeting/time_inc.php";
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


if(isset($_GET['index'])){
$getindex=mysqli_real_escape_string($connect,$_GET['index']);
}else {$getindex="";}

if(isset($_POST['index'])){
$postindex=mysqli_real_escape_string($connect,$_POST['index']);
}else {$postindex="";}

if(isset($_GET['id'])){
$getid=mysqli_real_escape_string($connect,$_GET['id']);
}else {$getid="";}

if(isset($_GET['page'])){
$getpage=mysqli_real_escape_string($connect,$_GET['page']);
}else {$getpage="";}


//ส่วนหัว
echo "<br />";
if(!(($getindex==1) or ($getindex==2) or ($getindex==5))){

echo "<table width='100%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>การอนุญาตใช้ห้องประชุม $user_department_name</strong></font><br><br></td></tr>";
echo "</table>";
}

//ส่วนยืนยันการลบข้อมูล
if($getindex==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=meeting&task=main/officer&index=3&id=$_GET[id]&page=$_REQUEST[page]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=meeting&task=main/officer&page=$_REQUEST[page]\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($getindex==3){
$sql = "delete from meeting_main where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
    echo "<script>document.location.href='?option=meeting&task=main/officer'; </script>\n";  

}

//ส่วนบันทึกข้อมูล
if($getindex==4){
$date_time_now = date("Y-m-d H:i:s");

//if(isset($_POST['allchk'])){
//$postallchk=mysqli_real_escape_string($connect,$_POST['allchk']);
//}else {$postallchk="";}

if(!isset($_POST['allchk'])){
$_POST['allchk']="";
}

	foreach($_POST as $key => $value){
		if($key!=$_POST['allchk']){
		$sql = "update meeting_main set approve=?, officer=?, officer_date=? where id=?";
        $dbquery = $connect->prepare($sql);
        $dbquery->bind_param("issi", $value,$login_user_id,$date_time_now,$key);
        $dbquery->execute();
        $result=$dbquery->get_result();

    // Push notification service edit by Krupong    
    $sql = "select book_person,book_date_start,book_date_end,room from meeting_main where id=?";
    if ($dbquery = $connect->prepare($sql)) {
    $dbquery->bind_param("i", $key);
    $dbquery->execute();
    $results=$dbquery->get_result();
        While ($result = mysqli_fetch_array($results)){
                $booker= $result['book_person'];
                $book_date_start = $result['book_date_start'];
                $book_date_end = $result['book_date_end'];
                $room= $result['room'];
        }
    }
     $book_start=thai_date_3($book_date_start);
     $book_end=thai_date_3($book_date_end);            
    $sql = "select room_name from meeting_room where room_code=?";
     if ($dbquery = $connect->prepare($sql)) {
    $dbquery->bind_param("i", $room);
    $dbquery->execute();
    $results=$dbquery->get_result();
        While ($result = mysqli_fetch_array($results)){
                $roomname = $result['room_name'];
        }
     }        
            
    if ($value==1) {  // คำขอได้รับการอนุญาต
       $message = $roomname." ".$book_start."-".$book_end;
       smartpush("$booker",'meeting',"$message","อนุญาตใช้ห้องประชุม");
//        smartpush("$booker","อนุญาตให้ใช้ห้องประชุม$roomname $book_start-$book_end","คำขอใช้ห้องประชุม");
    } 
    // end Push notification //        
        
         }
	}
    echo "<script>document.location.href='?option=meeting&task=main/officer'; </script>\n";  
    
}

//ใส่เหตุผลการไม่อนุญาต หรือแก้ไขเป็นอนุญาต
if ($getindex==5){

echo "<form id='frm1' name='frm1'  >";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>ส่วนของการอนุญาต $user_department_name</Font>";
echo "</Cener>";
echo "<Br><Br>";

    $sql_room = "select * from meeting_room where department=? and active='1'  order by id";
    $dbquery_room = $connect->prepare($sql_room);
    $dbquery_room->bind_param("i", $user_departid);
    $dbquery_room->execute();
    $result_qroom=$dbquery_room->get_result();
While ($result_room = mysqli_fetch_array($result_qroom))
{
$room_ar[$result_room['room_code']]=$result_room['room_name'];
}

$sql_join="select meeting_main.*, person_main.* ,meeting_main.id as id ,meeting_main.rec_date as rec_date from meeting_main left join person_main on meeting_main.book_person = person_main.person_id where  meeting_main.id=? ";

    if ($dbquery_join = $connect->prepare($sql_join)) {

    $dbquery_join->bind_param("i", $getid);
   $dbquery_join->execute();
    $result_joinroom=$dbquery_join->get_result();
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
		$objective = $result['objective'];
		$other = $result['other'];
		$rec_date = $result['rec_date'];
        $approve = $result['approve'];
        $officer = $result['officer'];
        $officer_date = $result['officer_date'];
        $reason = $result['reason'];
}
    // execute it and all...
} else {
    die("Errormessage: ". $connect->error);
}

echo "<Table width='60%' class='table table-hover table-bordered table-striped table-condensed'><tr><td>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>ข้อมูลผู้ขอใช้ห้องประชุม</B>: &nbsp;</legend></fieldset>";
echo "<table class='table table-hover table-bordered table-striped table-condensed'>";
echo "<Tr align='left'><Td align='right'>ห้องประชุม&nbsp;&nbsp;</Td><Td>$room_ar[$room]</Td></Tr>";

echo "<Tr align='left'><Td align='right'>วันทีเริ่มใช้ห้อง&nbsp;&nbsp;</Td>";
echo "<Td align='left'>";
echo thai_date_3($book_date_start);
echo "&nbsp;&nbsp;&nbsp;&nbsp;ถึงวันที่&nbsp;&nbsp;&nbsp;&nbsp;";
echo thai_date_3($book_date_end);
echo "</Td></Tr>";

echo "<Tr align='left'><Td align='right'>ตั้งแต่เวลา&nbsp;&nbsp;</Td>";
echo "<td align='left'>$start_time น.";
echo "&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp; $finish_time น.";
echo "</td></tr>";
echo "<Tr align='left'><Td align='right'>ประธานการประชุม&nbsp;&nbsp;</Td><Td>$chairman</Td></Tr>";
echo "<Tr align='left'><Td align='right'>วัตถุประสงค์&nbsp;&nbsp;</Td><Td>$objective</Td></Tr>";
echo "<Tr align='left'><Td align='right'>จำนวนผู้เข้าประชุม&nbsp;&nbsp;</Td><Td>$person_num &nbsp;คน</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ผู้ประสานงาน/เบอร์โทร&nbsp;&nbsp;</Td><Td>$coordinator</Td></Tr>";
echo "<Tr align='left'><Td align='right'>อื่น ๆ (ถ้ามี)&nbsp;&nbsp;</Td><Td>$other</Td></Tr>";
echo "</Table>";

echo "<fieldset>";
echo "<legend>&nbsp;<B>ส่วนเจ้าหน้าที่</B>: &nbsp;</legend></fieldset>";
echo "<table class='table table-hover table-bordered table-striped table-condensed'>";
$approve_check1="";  $approve_check2="";
		if($approve==1){
		$approve_check1="checked";
		}
		else if($approve==2){
		$approve_check2="checked";
		}
echo "<Tr align='left'><Td align='right'>อนุญาต/ไม่อนุญาตการใช้ห้องประชุม&nbsp;&nbsp;</Td><Td><Input Type='radio' Name='approve' value='1' $approve_check1>อนุญาต&nbsp;&nbsp;<Input Type='radio' Name='approve' value='2' $approve_check2>ไม่อนุญาต&nbsp;&nbsp;</Td></Tr>";
echo "<Tr align='left'><Td align='right'>หมายเหตุ(ถ้ามี)&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='reason' Size='50' value='$reason'></Td></Tr>";
echo "</table>";
echo "</td></tr></Table>";
echo "<Input Type=Hidden Name='id' Value='$getid'>";
echo "<Input Type=Hidden Name='page' Value='$getpage'>";
echo "<INPUT TYPE='button' name='smb' class='btn btn-primary' value='ตกลง' onclick='goto_url_update(1)' class=entrybutton>";

echo "</form>";

}

if ($getindex==6){

if(isset($_POST['approve'])){
$postapprove=mysqli_real_escape_string($connect,$_POST['approve']);
}else {$postapprove="";}
if(isset($_POST['id'])){
$postid=mysqli_real_escape_string($connect,$_POST['id']);
}else {$postid="";}
if(isset($_POST['reason'])){
$postreason=mysqli_real_escape_string($connect,$_POST['reason']);
}else {$postreason="";}


$date_time_now = date("Y-m-d H:i:s");

		$sql = "update meeting_main set approve=?, reason=? , officer=?, officer_date=? where id=?";
        $dbquery = $connect->prepare($sql);
        $dbquery->bind_param("isssi", $postapprove,$postreason,$login_user_id,$date_time_now,$postid);
        $dbquery->execute();
        $result=$dbquery->get_result();
    
    // Push notification service edit by Krupong    
    $sql = "select book_person,book_date_start,book_date_end,room from meeting_main where id=?";
    if ($dbquery = $connect->prepare($sql)) {
    $dbquery->bind_param("i", $postid);
    $dbquery->execute();
    $results=$dbquery->get_result();
        While ($result = mysqli_fetch_array($results)){
                $booker= $result['book_person'];
                $book_date_start = $result['book_date_start'];
                $book_date_end = $result['book_date_end'];
                $room= $result['room'];
        }
    }
     $book_start=thai_date_3($book_date_start);
     $book_end=thai_date_3($book_date_end);            
    $sql = "select room_name from meeting_room where room_code=?";
     if ($dbquery = $connect->prepare($sql)) {
    $dbquery->bind_param("i", $room);
    $dbquery->execute();
    $results=$dbquery->get_result();
        While ($result = mysqli_fetch_array($results)){
                $roomname = $result['room_name'];
        }
     }        
    if ($_POST['approve']==1) {  // คำขอได้รับการอนุญาต
       $message = $roomname." ".$book_start."-".$book_end;
       smartpush("$booker",'meeting',$message,"อนุญาตใช้ห้องประชุม");
       //smartpush("$booker","คำขอใช้ห้องประชุมของท่านได้รับการอนุญาตแล้ว");
    } else { // คำขอไม่ได้รับการอนุญาต
        $message = $roomname." ".$book_start."-".$book_end;
        if (isset($_POST['reason'])) {
            $message.="เนื่องจาก".$_POST['reason'];
        }
        //smartpush("$booker",$message);
        smartpush("$booker",'meeting',$message,"ไม่อนุญาตให้ใช้ห้องประชุม");
    }
    // end Push notification //
      
   // echo "<script>document.location.href='?option=meeting&task=main/officer'; </script>\n";  
}

//ส่วนแสดงผล
if(!(($getindex==1) or ($getindex==2) or ($getindex==11) or ($getindex==5))){

//ส่วนของการแยกหน้า
if(isset($_POST['status_index'])){
$poststatus_index=mysqli_real_escape_string($connect,$_POST['status_index']);
    if($poststatus_index!=""){
    $showstatus=" and meeting_main.approve=$poststatus_index ";
    }else{$showstatus="";}
}else {$poststatus_index=""; $showstatus="";}

//$sql_meeting="select id from meeting_main where user_book=? ";
$sql_meeting="select meeting_main.*, meeting_room.* ,meeting_main.id as id ,meeting_main.rec_date as rec_date from meeting_main left join meeting_room on meeting_main.room = meeting_room.room_code where meeting_room.department=? $showstatus ";
    $dbquery_meeting = $connect->prepare($sql_meeting);
    $dbquery_meeting->bind_param("i", $user_departid);
    $dbquery_meeting->execute();
    $result_meeting=$dbquery_meeting->get_result();

$num_rows = mysqli_num_rows($result_meeting);

$pagelen=20;  // 1_กำหนดแถวต่อหน้า
$url_link="option=meeting&task=main/officer";  // 2_กำหนดลิงค์ฺ
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


$sql_room = "select * from meeting_room where (active='1' or active='0' or active='99')  order by id";
    $dbquery_room = $connect->prepare($sql_room);
    //$dbquery_room->bind_param("i", $system_user_department);
    $dbquery_room->execute();
    $result_meetroom=$dbquery_room->get_result();
While ($result_room = mysqli_fetch_array($result_meetroom))
{
$room_ar[$result_room['room_code']]=$result_room['room_name'];
$room_at[$result_room['room_code']]=$result_room['active'];
}
$sql_join="select meeting_main.*, meeting_room.* ,meeting_main.id as id ,meeting_main.rec_date as rec_date from meeting_main left join meeting_room on meeting_main.room = meeting_room.room_code where meeting_room.department=? $showstatus order by  meeting_main.book_date_start desc,meeting_main.room,meeting_main.start_time,meeting_main.rec_date desc limit $start,$pagelen";

    $dbquery_join = $connect->prepare($sql_join);
    $dbquery_join->bind_param("i", $user_departid);
    $dbquery_join->execute();
    $result_joinroom=$dbquery_join->get_result();

//$dbquery = mysqli_query($connect,$sql);
echo "<form id='frm1' name='frm1'>";
echo  "<table width=95% border=0 align=center class='table table-hover table-bordered table-striped table-condensed'>";
echo "<Tr><td colspan='15'><table width='100%'><tr><td align='left'>";

//เพิ่มการเลือกสถานะ
echo "<form  name='frm1'>";

echo "&nbsp;<Select  name='status_index' size='1' class='selectpicker'>";
echo "<option value ='' >ทุกสถานะ</option>" ;
echo "<option value ='0' >รอการอนุญาต</option>" ;
echo "<option value ='1' >อนุญาตแล้ว</option>" ;
echo "<option value ='2' >ไม่อนุญาต</option>" ;
echo "</select>";
echo "&nbsp;<INPUT TYPE='button' name='smb' class='btn btn-info' value='เลือก'  onclick='goto_url2(1)'>";
echo "</form>";


echo "</td><td align='right'><INPUT TYPE='checkbox' name='allchk'  id='allckk' onclick='CheckAll()'> เลือก/ไม่เลือกทั้งหมด</Td></table></td></Tr>";


echo "<Tr class='info' align='center'><Td width='80'>วันที่เริ่ม</Td><Td width='80'>วันที่สิ้นสุด</Td><Td width='200'>ห้องประชุม</Td><Td  width='70'>ตั้งแต่เวลา</Td><Td width='70'>ถึงเวลา</Td><Td>ประธานการประชุม/วัตถุประสงค์</Td><Td width='150'>อื่น ๆ/ผู้ประสานงาน</Td><Td width='120'>ผู้จอง(วันเวลา)</Td><td><INPUT TYPE='button' name='smb'  value='อนุญาต' onclick='goto_url_update2(1)'></Td><Td>ผู้อนุญาต</Td><Td width='90'>หมายเหตุ</Td><Td width='40'>เจ้าหน้าที่</Td></Tr>";

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
		//$name= $result['name'];
		//$surname = $result['surname'];
        $coordinator = $result['coordinator'];
		$chairman = $result['chairman'];
		$person_num = $result['person_num'];
		$book_person = $result['book_person'];
		$user_book = $result['user_book'];
		$other = $result['other'];
		$rec_date = $result['rec_date'];
        $approve = $result['approve'];
        $officer = $result['officer'];
        $officer_date = $result['officer_date'];
        $reason = $result['reason'];
        $department_book = $result['department_book'];

		if(isset($user_book)){
    $sql_person="select * from person_main where  status='0' and person_id=? ";

    $dbquery_person = $connect->prepare($sql_person);
    $dbquery_person->bind_param("i", $user_book);
    $dbquery_person->execute();
    $result_qperson=$dbquery_person->get_result();
 While ($result_person = mysqli_fetch_array($result_qperson))
{
     $name=$result_person['name'];
     $surname=$result_person['surname'];
}


if($department_book!=$user_departid){
    //หาชื่อหน่วยงาน
    $sql_depart_name="select * from system_department where department=? ";
    $query_depart_name = $connect->prepare($sql_depart_name);
    $query_depart_name->bind_param("i", $department_book);
    $query_depart_name->execute();
    $result_qdepart_name=$query_depart_name->get_result();
While ($result_depart_name = mysqli_fetch_array($result_qdepart_name))
   {
    $book_department_name=$result_depart_name['department_name'];
    $book_department_precisname=$result_depart_name['department_precis'];
	}
     $showdepartmybook = " <a tabindex='0' class='btn btn-warning btn-xs' role='button' data-toggle='popover' data-placement='top' data-trigger='focus' title='สำนัก' data-content=$book_department_name>$book_department_precisname</a>";
        }else{$showdepartmybook="";}

        }

            //if(($M%2) == 0)
			$color="";
	//		else  	$color="#FFFFFF";
echo "<Tr bgcolor='$color'>";
echo "<Td align='left'>";
echo thai_date_3($book_date_start);
echo "</Td>";
echo "<Td align='left'>";
echo thai_date_3($book_date_end);
echo "</Td>";
echo "<Td align='left'>";
if(isset($room_ar[$room])){
echo $room_ar[$room];

if($room_at[$room]==1){
    echo "";
}else if($room_at[$room]=='99'){
    echo "<button type='button' name='showatroom' class='btn btn-danger btn-xs'  class='entrybutton' >ยกเลิกใช้ห้อง</button>";
}else{
    echo "<button type='button' name='showatroom' class='btn btn-warning btn-xs'  class='entrybutton' >ไม่อนุญาตให้จอง</button>";
}
}
echo "</Td>";
echo "<Td align='center'>$start_time น.</Td><Td align='center' >$finish_time น.</Td>";
echo "<td>$result[chairman]/$result[objective]</td>";

echo "<td>$result[other]/$result[coordinator]</td>";
echo "<Td>$name $surname(<font size='1px'>";
echo thai_date_4($rec_date);
//echo $rec_date;

    echo "</font>) $showdepartmybook</Td>";

if($result['approve']==1){
echo "<Td align='center'><img src=images/yes.png border='0' alt='อนุญาต'></Td>";
}
else if($result['approve']==2){
echo "<Td align='center'><img src=images/no.png border='0' alt='ไม่อนุญาต'></Td>";
}
else{
echo "<Td align='center'><input type='checkbox' name='$id' id='$id' value='1'></Td>";
}

if($approve>=1){
		if(isset($officer)){
    $sql_person="select * from person_main where  status='0' and person_id=? ";

    $dbquery_person = $connect->prepare($sql_person);
    $dbquery_person->bind_param("i", $officer);
    $dbquery_person->execute();
    $result_qperson=$dbquery_person->get_result();
 While ($result_person = mysqli_fetch_array($result_qperson))
{
     $name=$result_person['name'];
     $surname=$result_person['surname'];
}
		echo "<td>$name $surname(<font size='1px'>";
        echo thai_date_4($officer_date);
        echo "</font>)</td>";
		}
		else{
		echo "<td></td>";
		}
}
else{
echo "<td></td>";
}

if($reason!=""){
echo "<Td align='left'>$reason</Td>";
}
else{
echo "<td></td>";
}

echo "<Td align='center'><a href=?option=meeting&task=main/officer&index=5&id=$id&page=$page><img src=images/b_edit.png border='0' alt='เจ้าหน้าที่'></Td>";

echo "</Tr>";

$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
}
echo "</form></Table>";
}

if(!(($getindex==1) or ($getindex==2) or ($getindex==3) or ($getindex==11) or ($getindex==5))) {
echo "<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src=images/yes.png border='0'> หมายถึง อนุญาตให้ใช้ห้องประชุม&nbsp;&nbsp;<img src=images/no.png border='0'> หมายถึง ไม่อนุญาตให้ใช้ห้องประชุม";
}
?>

<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=meeting&task=main/officer");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.room.value == ""){
			alert("กรุณาเลือกห้องประชุม");
		}else if(frm1.objective == ""){
			alert("กรุณาระบุวัตถุประสงค์ของการใช้");
		}else{
			callfrm("?option=meeting&task=main/officer&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=meeting&task=main/officer");   // page ย้อนกลับ
	}else if(val==1){
		if(!(frm1.approve[0].checked || frm1.approve[1].checked)){
			alert("กรุณาเลือกการอนุญาต");
		}else{
			callfrm("?option=meeting&task=main/officer&index=6");   //page ประมวลผล
		}
	}
}

function goto_url_update2(val){
	if(val==0){
		callfrm("?option=meeting&task=main/officer");   // page ย้อนกลับ
	}else if(val==1){
		callfrm("?option=meeting&task=main/officer&index=4");   //page ประมวลผล
	}
}

function goto_url2(val){
callfrm("?option=meeting&task=main/officer");
}

function CheckAll() {
	for (var i = 0; i < document.frm1.elements.length; i++)
	{
	var e = document.frm1.elements[i];
	if (e.name != "allchk")
		e.checked = document.frm1.allchk.checked;
	}
}

</script>
