<?php
$login_group=mysqli_real_escape_string($connect,$_SESSION['login_group']);
if(!($login_group<=1)){
exit();
}/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
if(!isset($_SESSION['login_user_id'])){ $_SESSION['login_user_id']=""; exit();
}else{
//หาหน่วยงาน
$user_id=mysqli_real_escape_string($connect,$_SESSION['login_user_id']);
    $sql_user_depart="select * from person_main where person_id=? ";
    $query_user_depart = $connect->prepare($sql_user_depart);
    $query_user_depart->bind_param("i", $user_id);
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
    $sql_permis = "select * from  work_permission where person_id=? ";
    $dbquery_permis = $connect->prepare($sql_permis);
    $dbquery_permis->bind_param("i", $user_id);
    $dbquery_permis->execute();
    $result_qpermis=$dbquery_permis->get_result();
    While ($result_permis = mysqli_fetch_array($result_qpermis))
    {
        $user_permis=$result_permis['p1'];
        //echo $user_permis;
    }

    if(isset($user_permis)){
    if($user_permis!=1){
        echo "<div align='center'><h2> เฉพาะผู้ดูแลการลงเวลาปฏิบัติราชการเท่านั้น </h2></div>";
        exit();
    }
    }else{
        $user_permis="";
        exit();
    }

require_once "modules/work/time_inc.php";

$officer=$user_id;

    $sql_user = "select department from person_main where person_id=? ";
    $dbquery_user = $connect->prepare($sql_user);
    $dbquery_user->bind_param("i", $officer);
    $dbquery_user->execute();
    $result_userdepart = $dbquery_user->get_result();
    while($result_user = $result_userdepart->fetch_array())
	   {
        $department = $result_user['department'];
    }

//แปลงรูปแบบ date
//$send_date = $_GET['datepicker'];
if(!isset($_POST['send_date'])){
$postsend_date="";
}else{
    $postsend_date=mysqli_real_escape_string($connect,$_POST['send_date']);
    $_GET['datepicker']=$postsend_date;
}
//$datepicker = $_GET['datepicker'];
if(!isset($_GET['datepicker'])){
    $getdatepicker=date("Y-m-d");
    $f2_date=date("Y-m-d");
}else{
    $getdatepicker=mysqli_real_escape_string($connect,$_GET['datepicker']);
    //$f1_date=explode("-", $getdatepicker);
    //$f2_date=$f1_date[2]."-".$f1_date[1]."-".$f1_date[0];  //ปี เดือน วัน
    $f2_date=$getdatepicker;
}

//$thai_date=thai_date(make_time($f2_date));
$thai_date=thai_date($f2_date);

echo "<br />";
echo "<table width='99%' border='0' align='center'>";
echo "<tr align='center'><td colspan=2><font color='#006666' size='3'><strong>การปฏิบัติราชการ $thai_date</strong></font></td></tr>";
?>
	<link rel="stylesheet" type="text/css" media="all" href="./modules/work/css.css">
	<link rel="stylesheet" href="./jquery/themes/ui-lightness/jquery.ui.all.css">
	<script src="./jquery/jquery-1.5.1.js"></script>
	<script src="./jquery/ui/jquery.ui.core.js"></script>
	<script src="./jquery/ui/jquery.ui.widget.js"></script>
	<script src="./jquery/ui/jquery.ui.datepicker.js"></script>
	<script>
	$(function() {
		$( "#datepicker" ).datepicker({
			showButtonPanel: true,
			dateFormat: 'yy-mm-dd',
            monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน',
			'กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'], // Names of months for drop-down and formatting
			dayNamesMin: ['อา','จ','อ','พ','พฤ','ศ','ส'],
			onSelect:function(dateText){  document.frmSearchDate.submit();}
		});
	});
	</script>
<tr align='center'>
	<td  align=left>
	</td>
	<td align=right  id=no_print>
<FORM name=frmSearchDate METHOD=GET>
<INPUT TYPE="hidden" name=option value="work">
<INPUT TYPE="hidden" name=task value="check_2">
เลือกวันที่ <input type="text" id="datepicker" name=datepicker value=<?php echo (isset($getdatepicker))? $getdatepicker:date("d-m-Y");?>  readonly Size=10>
</FORM>
	</td>
</tr>

<?php
echo "</table>";


//เพิ่มใหม่
       $sql_post = "select * from  person_position order by position_code ";
    $dbquery_post = $connect->prepare($sql_post);
    $dbquery_post->execute();
    $result_allpost = $dbquery_post->get_result();
    while($result = $result_allpost->fetch_array())
	   {
        $position_ar[$result['position_code']]=$result['position_name'];
    }

//ส่วนบันทึกข้อมูล
if(isset($_POST['index'])){
$postindex=mysqli_real_escape_string($connect,$_POST['index']);
}else {$postindex="";}
if($postindex==4){
$rec_date=date("Y-m-d H:i:s");

    $sql = "select person_id from person_main where department = ? and status='0' order by department,sub_department,position_other_code desc,person_order ";
    $dbquery_personid = $connect->prepare($sql);
    $dbquery_personid->bind_param("i", $department);
    $dbquery_personid->execute();
    $result_personid = $dbquery_personid->get_result();
    while($result = $result_personid->fetch_array())
	   {
            $person_id = $result['person_id'];
			$sql_select = "select person_id from  work_main  where work_date=? and person_id=? ";
            $dbquery_select = $connect->prepare($sql_select);
            $dbquery_select->bind_param("si", $f2_date,$person_id);
            $dbquery_select->execute();
            $result_showselect = $dbquery_select->get_result();
            $data_num=mysqli_num_rows($result_showselect);
            //while($result_show = $result_showselect->fetch_array())
	       //    {
//echo $_POST[$person_id];


if(!isset($_POST[$person_id])){
//$_POST[$person_id]="";
$postperson_id="";
}else{
    $postperson_id=mysqli_real_escape_string($connect,$_POST[$person_id]);
}

    $delete = "delete_chk".$person_id;
    //echo $delete;
    //$deletework = $_POST[$delete];
    //echo $deletework;
if(!isset($_POST[$delete])){
//$_POST[$delete]="";
$postdelete="";
}else{$postdelete=mysqli_real_escape_string($connect,$_POST[$delete]);
}
//เพิ่มลาครึ่งวัน
$work_opt = "work_opt".$person_id;

if(!isset($_POST[$work_opt])){
$postwork_opt="0.0";
}else{$postwork_opt=mysqli_real_escape_string($connect,$_POST[$work_opt]);
      if($postperson_id==1 || $postperson_id==6 ){$postwork_opt="0.0";}   
}
        //echo "555 ".$postperson_id;
			if(($postperson_id>0) and ($postdelete!=1)){
					if($data_num>0){
					$sql_update = "update work_main set work=? , work_opt=? , rec_date=?, officer=? where work_date=? and person_id=?";
                    $dbquery_update = $connect->prepare($sql_update);
                    $dbquery_update->bind_param("sssiss", $postperson_id,$postwork_opt,$rec_date,$officer,$f2_date,$person_id);
                    $dbquery_update->execute();
                    $result_update = $dbquery_update->get_result();
 					}
					else {
					$sql_insert = "insert into work_main (work_date, person_id, work,work_opt, rec_date, officer) values (?,?,?,?,?,?)";
                    $dbquery_insert = $connect->prepare($sql_insert);
                    $dbquery_insert->bind_param("ssisss", $f2_date,$person_id,$postperson_id,$postwork_opt,$rec_date,$officer);
                    $dbquery_insert->execute();
                    $result_insert = $dbquery_insert->get_result();
                    }
			}
			if(($postperson_id>0) and ($postdelete==1)){
			$sql_delete = "delete from work_main where work_date=? and person_id=?";
            $dbquery_delete = $connect->prepare($sql_delete);
            $dbquery_delete->bind_param("ss", $f2_date,$person_id);
            $dbquery_delete->execute();
            $result_delete = $dbquery_delete->get_result();
             }
	}

    echo "<script>document.location.href='?option=work&task=check_2&datepicker=$f2_date'; </script>\n";
}

//ส่วนแสดงหลัก
$sql_person = "select * from person_main where status='0'and department = ?";
            $dbquery_person = $connect->prepare($sql_person);
            $dbquery_person->bind_param("i",$department);
            $dbquery_person->execute();
            $result_allperson = $dbquery_person->get_result();
    while($result_person = $result_allperson->fetch_array())
        {
        $person_id = $result_person['person_id'];
        $sql_work = "select * from  work_main  where work_date=? and person_id=? ";
            $dbquery_work = $connect->prepare($sql_work);
            $dbquery_work->bind_param("ss",$f2_date,$person_id);
            $dbquery_work->execute();
            $result_personwork = $dbquery_work->get_result();
    while($result_work = $result_personwork->fetch_array())
        {
         $work_ar[$person_id]=$result_work['work'];
         $workopt_ar[$person_id]=$result_work['work_opt'];
        }

        }

echo "<form id='frm1' name='frm1'>";
$sql_show = "select * from person_main where status='0' and department = ? order by person_order,department,sub_department ";
            $dbquery_show = $connect->prepare($sql_show);
            $dbquery_show->bind_param("i",$department);
            $dbquery_show->execute();
            $result_personshow = $dbquery_show->get_result();

echo  "<table width='98%' border='0' align='center' class='table table-hover table-bordered table-condensed'>";
echo "<tr><Td colspan='15' align='center'><input type='checkbox' name='allchk' id='allchk' onclick='CheckAll()'>เลือก/ไม่เลือก มาปฏิบัติราชการทั้งหมด</Td></tr>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='50'>ที่</Td>";
echo "<Td>ลบ</Td>";
echo "<Td>ชื่อ</Td><Td>ตำแหน่ง</Td><Td>มา</Td><Td>ไปราชการ</Td><Td>ลาป่วย</Td><Td>ลากิจ</Td><Td>ลาพักผ่อน</Td><Td>ลาคลอด</Td><Td>ลาอื่นๆ</Td><Td>มาสาย</Td><Td>ไม่มา</Td><Td>*ครึ่งวัน</Td><Td></Td></Tr>";
$N=1;
$M=1;
while($result = $result_personshow->fetch_array())
    {

		$person_id = $result['person_id'];
		$prename=$result['prename'];
		$name= $result['name'];
		$surname = $result['surname'];
		$position_code= $result['position_code'];
		$department= $result['department'];

        $color="#FFFFFF";
        $color2="#FFFFFF";
        //	if(($M%2) == 0){
		//	$color="#FFFFC";
        // $color2="#FFFFC";
		//	}
		//	else {
        //$color="#FFFFFF";
        //$color2="#FFFFFF";
		//	}

//check การลา  --->ยังไม่ได้เชื่อมกับระบบลา
/*	$sql_la="select * from la_main where (la_start<='$today_date' and '$today_date'<=la_finish) and person_id='$person_id' ";
	$dbquery_la = mysqli_query($connect,$sql_la);
		if($dbquery_la){
		$la_num=mysqli_num_rows($dbquery_la);
				if($la_num>=1){
						$result_la = mysqli_fetch_array($dbquery_la);
						if($result_la['la_type']==1){
						$color="#FF3366";
						}
						else if($result_la['la_type']==2){
						$color="#FFFF00";
						}
						else if($result_la['la_type']==3){
						$color="#FF00FF";
						}
						else if($result_la['la_type']==4){
						$color="#0099FF";
						}
				$sql_cancel="select * from la_cancel where (cancel_la_start<='$today_date' and '$today_date'<=cancel_la_finish) and person_id='$person_id' ";
				$dbquery_cancel = mysqli_query($connect,$sql_cancel);
						if($dbquery_cancel){
						$la_num_cancel=mysqli_num_rows($dbquery_cancel);
								if($la_num_cancel>=1){
								$color=$color2;
								}
						}

				}
		}

//check การไปราชการ  -->ยังไม่ได้เชื่อมกับระบบไปราชการ
	$sql_date="select * from permission_date where person_id='$person_id' and date='$today_date' ";
	$dbquery_date = mysqli_query($connect,$sql_date);
		if($dbquery_date){
		$date_num=mysqli_num_rows($dbquery_date);
				if($date_num>=1){
				$color="#00FFFF";
				}
		}
*/

//เพิ่มในส่วนของงานแสดงผลในเฟส 1
$check_index1="";
$check_index2="";
$check_index3="";
$check_index4="";
$check_index5="";
$check_index6="";
$check_index7="";
$check_index8="";
$check_index9="";

if(!isset($postindex)){
$postindex="";
}

if($postindex==2){
$check_index1="checked";
}
if(isset($work_ar[$person_id])){
if($work_ar[$person_id]==1){
$check_index1="checked";
}
else if($work_ar[$person_id]==2){
$color="#00FFFF";
$check_index2="checked";
}
else if($work_ar[$person_id]==3){
$color="#FF3366";
$check_index3="checked";
}
else if($work_ar[$person_id]==4){
$color="#FFFF00";
$check_index4="checked";
}
else if($work_ar[$person_id]==5){
$color="#0099FF";
$check_index5="checked";
}
else if($work_ar[$person_id]==6){
$color="#FF00FF";
$check_index6="checked";
}
else if($work_ar[$person_id]==7){
$color="#FFFF00";
$check_index7="checked";
}
else if($work_ar[$person_id]==8){
$color="#FF0000";
$check_index8="checked";
}
else if($work_ar[$person_id]==9){
$color="#FF0000";
$check_index9="checked";
}
}

 //เพิ่มลาครึ่งวัน   
if(isset($workopt_ar[$person_id])){
if($workopt_ar[$person_id]=="0.5"){    
$check_workopt="checked"; $showworkopt="0.5";}else{$check_workopt="";$showworkopt="";}
}else{$check_workopt="";$showworkopt="";}  
    
echo "<Tr  bgcolor=$color align=center class=style1><Td>$N</Td>";
echo "<Td><input type='checkbox' name='delete_chk$person_id' id='delete_chk$person_id'  value='1'>";
echo "</Td><Td align='left'>$prename&nbsp;$name&nbsp;&nbsp;$surname</Td><Td align='left'>";
if(isset($position_ar[$position_code])){
echo $position_ar[$position_code];
}
echo "</Td>";

echo "<Td><input type='radio' name='$person_id' id='$person_id' value='1' $check_index1>มา</Td>";
echo "<Td><input type='radio' name='$person_id' id='$person_id' value='2' $check_index2>ร</Td>";
echo "<Td><input type='radio' name='$person_id' id='$person_id' value='3' $check_index3>ป</Td>";
echo "<Td><input type='radio' name='$person_id' id='$person_id' value='4' $check_index4>ก</Td>";
echo "<Td><input type='radio' name='$person_id' id='$person_id' value='5' $check_index5>พ</Td>";
echo "<Td><input type='radio' name='$person_id' id='$person_id' value='6' $check_index6>ค</Td>";
echo "<Td><input type='radio' name='$person_id' id='$person_id' value='7' $check_index7>อ</Td>";
echo "<Td><input type='radio' name='$person_id' id='$person_id' value='8' $check_index8>ส</Td>";
echo "<Td><input type='radio' name='$person_id' id='$person_id' value='9' $check_index9>มม</Td>";
echo "<Td><input type='checkbox' name='work_opt$person_id' id='work_opt$person_id'  value='0.5' $check_workopt></Td>";

if(isset($work_ar[$person_id])){
if($work_ar[$person_id]<1){
echo "<Td align='center'><img src=images/dangerous.png border='0' alt='ไม่มีข้อมูล'></Td>";
}
}
else{
echo "<Td align='center'><img src=images/dangerous.png border='0' alt='ไม่มีข้อมูล'></Td>";
}
echo "";
$M++;
$N++;
	}

/*
$sql_check = "select * from work_main where work_date=?";
            $dbquery_check = $connect->prepare($sql_check);
            $dbquery_check->bind_param("s",$f2_date);
            $dbquery_check->execute();
            $result_checkperson = $dbquery_check->get_result();
$record_num=mysqli_num_rows($result_checkperson);
if(($record_num<=0) and ($index!=2)){
*/
echo "</Table>";
if(isset($getdatepicker)){
echo "<INPUT TYPE='hidden' name='send_date' value='$getdatepicker'>";
}
else{
$today=date("Y-m-d");
echo "<INPUT TYPE='hidden' name='send_date' value='$today'>";
}
echo "<br><input type='hidden' name='index' value='4'>";
echo "<div align='center'><INPUT TYPE='button' class='btn btn-primary' name='smb' value='บันทึกข้อมูลการปฏิบัติราชการ' onclick='goto_url(1)' class=entrybutton></div>";
echo "</form>";
?>

<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=work&task=check_2");   // page ย้อนกลับ
	}else if(val==1){
	   callfrm("?option=work&task=check_2");   //page ประมวลผล
	}
}
</script>

<script>
function CheckAll() {
	for (var i = 0; i < document.frm1.elements.length; i++)
	{
	var e = document.frm1.elements[i];
	if (e.name != "allchk")
		if(e.value==1 && e.type!="checkbox"){
		e.checked = document.frm1.allchk.checked;
		}
	}
}

</script>

<?php
echo "<b>&nbsp;&nbsp;หมายเหตุ</b><br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;1.<img src=images/dangerous.png border='0'> หมายถึง ยังไม่มีข้อมูล<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;2.พื้นแถว<font color='#00FFFF'>สีเขียว</font> หมายถึง ขออนุญาตไปราชการ<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;3.พื้นแถว<font color='#FF3366'>สีแดง</font> หมายถึง ลาป่วย<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;4.พื้นแถว<font color='#FFFF00'>สีเหลือง</font> หมายถึง ลากิจ<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;5.พื้นแถว<font color='#0099FF'>สีฟ้า</font> หมายถึง ลาพักผ่อน<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;6.พื้นแถว<font color='#FF00FF'>สีชมพู</font> หมายถึง ลาคลอด<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;7.ลบ หมายถึง ลบการบันทึกข้อมูล<br>";

?>

