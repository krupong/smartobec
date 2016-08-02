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
//echo        " 555 ". $user_permis;

require_once "modules/work/time_inc.php";

$officer=$user_id;

$today_date = date("Y-m-d");
    $sql_user = "select department from person_main where person_id=? ";
    $dbquery_user = $connect->prepare($sql_user);
    $dbquery_user->bind_param("i", $officer);
    $dbquery_user->execute();
    $result_userdepart = $dbquery_user->get_result();
    while($result_user = $result_userdepart->fetch_array())
	   {
        $department = $result_user['department'];
    }

//ส่วนหัว
echo "<br />";
echo "<table width='99%' border='0' align='center'>";
echo "<tr align='center'>
	<td align=center><font color='#990000' size='3'><strong>เรียงลำดับรายชื่อบุคลากรในสำนัก</strong></font>
</td></tr>";
echo "</table>";
echo "<br />";

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
//print_r($_POST['person_order']);
//print_r($_POST['person_id']);
foreach($_POST['person_order'] as $row=>$personorder){

$person_order = mysqli_real_escape_string($connect,$_POST['person_order'][$row]);

if(!isset($_POST['person_id'])){
//$_POST[$person_id]="";
$postperson_id="";
}else{
    $postperson_id=mysqli_real_escape_string($connect,$_POST['person_id'][$row]);
}
    $sql_update = "update person_main set person_order=? where person_id=?";
    $dbquery_update = $connect->prepare($sql_update);
    $dbquery_update->bind_param("is", $person_order,$postperson_id);
    $dbquery_update->execute();
    $result_update = $dbquery_update->get_result();

}
    
    
    echo "<script>document.location.href='?option=work&task=sortable_person'; </script>\n";
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
            $dbquery_work->bind_param("ss",$today_date,$person_id);
            $dbquery_work->execute();
            $result_personwork = $dbquery_work->get_result();
    while($result_work = $result_personwork->fetch_array())
        {
         $work_ar[$person_id]=$result_work['work'];
         }

        }

echo "<form id='frm1' name='frm1'>";
$sql_show = "select * from person_main where status='0' and department = ? order by person_order,department,sub_department ";
            $dbquery_show = $connect->prepare($sql_show);
            $dbquery_show->bind_param("i",$department);
            $dbquery_show->execute();
            $result_personshow = $dbquery_show->get_result();

echo  "<table width='98%' border='0' align='center' class='table table-hover table-bordered table-condensed'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='50'>ที่</Td>";
echo "<Td>ชื่อ</Td><Td>ตำแหน่ง</Td><Td width=90'>เรียงลำดับ</Td></Tr>";
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
		$person_order= $result['person_order'];
        $color="#FFFFFF";
        $color2="#FFFFFF";




echo "<Tr  bgcolor=$color align=center class=style1><Td>$N</Td>";
echo "<Td align='left'>$prename&nbsp;$name&nbsp;&nbsp;$surname</Td><Td align='left'>";
if(isset($position_ar[$position_code])){
echo $position_ar[$position_code];
}
echo "</Td>";

echo "<Td><input type='number' class='form-control text-center' name='person_order[]' id='person_order' value='$person_order'></Td>";
echo "<input type='hidden'  name='person_id[]'  value='$person_id'>";
echo "</tr>";
$M++;
$N++;
	}


echo "</Table>";
echo "<br><input type='hidden' name='index' value='4'>";
echo "<div align='center'><INPUT TYPE='button' class='btn btn-primary'  name='smb' value='บันทึกข้อมูลการเรียงลำดับบุคลากร' onclick='goto_url(1)' class=entrybutton></div>";
echo "</form>";
?>

<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=work&task=sortable_person");   // page ย้อนกลับ
	}else if(val==1){
	callfrm("?option=work&task=sortable_person");   //page ประมวลผล
	}
}


</script>

<br>
<br>
