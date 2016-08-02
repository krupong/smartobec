<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
$admin_mail=mysqli_real_escape_string($connect,$_SESSION['admin_mail']);
if($admin_mail!='mail'){
exit();
}
$login_group=mysqli_real_escape_string($connect,$_SESSION['login_group']);
if(!($login_group<=1)){
exit();
}

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


//ตรวจสอบ POST
if(isset($_POST['index'])){
$postindex=mysqli_real_escape_string($connect,$_POST['index']);
}else {$postindex="";}

if(isset($_GET['index'])){
$getindex=mysqli_real_escape_string($connect,$_GET['index']);
}else {$getindex="";}


//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center' >";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>เจ้าหน้าที่</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($postindex==1){
echo "<form id='frm1' name='frm1' action='?option=mail&task=main/permission' method='POST' onSubmit='JavaScript:return goto_url(1);'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มเจ้าหน้าที่</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border='0' Bgcolor='#Fcf9d8' class='table table-hover table-bordered table-striped table-condensed'>";
echo "<Tr><Td align='right'>สำนัก&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left' class='form-group'> $user_department_name";
echo "</div></td></tr>";
echo "<Tr><Td align='right'>บุคลากร&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left' class='form-group'><Select name='person_id' class='selectpicker show-tick' title='เลือกบุคลากร' data-live-search='true'>";
//echo  "<option  value = ''>เลือกบุคลากร</option>" ;
    $sql = "select  * from person_main where department = ? and status=0 order by name";
    $dbquery_person = $connect->prepare($sql);
    $dbquery_person->bind_param("i", $user_departid);
    $dbquery_person->execute();
    $result_person=$dbquery_person->get_result();
    while($result_personname = $result_person->fetch_array())
   {
     $personname = $result_personname['prename'].$result_personname['name']." ".$result_personname['surname'];
     $personid = $result_personname['person_id'];

    $sql = "select  * from mail_permission where person_id=?";
    $dbquery_permiss = $connect->prepare($sql);
    $dbquery_permiss->bind_param("i", $personid);
    $dbquery_permiss->execute();
    $result_permiss=$dbquery_permiss->get_result();
     while($result_permissuser = $result_permiss->fetch_array())
    {
         $permissid = $result_permissuser["person_id"];
     }

        if($permissid!=$personid){
        echo "<option  value ='$personid'> $personname</option>" ;
        }
    }

echo "</select>";
echo "</div></td></tr>";
echo   "<tr><td align='right' >อนุญาตให้เป็นเจ้าหน้าที่&nbsp;&nbsp;</td>";
echo   "<td align='left'>&nbsp;&nbsp;ใช่&nbsp;&nbsp;<input  type=radio name='mail_permission1' value='1'>&nbsp;&nbsp;ไม่ใช่&nbsp;&nbsp;<input  type=radio name='mail_permission1' value='0'  checked></td></tr>";

echo "<input type='hidden' name='index' value='4'>";
echo "<tr><td align='center' colspan='2'>";
echo "<tr><td align='center' colspan='2'><INPUT TYPE='submit' name='smb' class='btn btn-primary' value='ตกลง' >
	&nbsp;&nbsp;&nbsp;";
echo "<INPUT TYPE='button' name='back' class='btn btn-default' value='ย้อนกลับ' onclick='location.href=\"?option=mail&task=main/permission\"' ></td></tr>";
echo "</Table>";
echo "</form>";
}

//ส่วนยืนยันการลบข้อมูล
if($getindex==2) {
echo "<form id='frmdel' name='frmdel' action='?option=mail&task=main/permission' method='post'>";
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<input type='hidden' name='index' value='3'>";
echo "<input type='hidden' name='userid' value='$_GET[id]'>";
echo "<INPUT TYPE='submit' name='smb' value='ยืนยัน' class='btn btn-primary'>";
echo "&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' class='btn btn-default' onclick='location.href=\"?option=mail&task=main/permission\"'";
echo "</td></tr></table></form>";
}

//ส่วนลบข้อมูล
if($getindex==3){
if(isset($_GET['aid'])){
$getid=mysqli_real_escape_string($connect,$_GET['aid']);
}else {$getid="";}
$sql = "delete from mail_permission where id=?";
    $dbquery_permiss = $connect->prepare($sql);
    $dbquery_permiss->bind_param("i", $getid);
    $dbquery_permiss->execute();
    $result_permiss=$dbquery_permiss->get_result();
    echo "<script>document.location.href='?option=mail&task=main/permission'; </script>\n";
}

//ส่วนบันทึกข้อมูล
if($postindex==4){
$personid=mysqli_real_escape_string($connect,$_POST['person_id']);
$mail_permission1=mysqli_real_escape_string($connect,$_POST['mail_permission1']);

$rec_date = date("Y-m-d");
$sql = "insert into mail_permission (person_id, p1, officer,rec_date) values (?,?,?,?)";
    $dbquery_addmail = $connect->prepare($sql);
    $dbquery_addmail->bind_param("iiss", $personid,$mail_permission1,$login_user_id,$rec_date);
    $dbquery_addmail->execute();
    $result_addmail=$dbquery_addmail->get_result();
    echo "<script>document.location.href='?option=mail&task=main/permission'; </script>\n";
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($getindex==5){
if(isset($_GET['id'])){
$getuserid=mysqli_real_escape_string($connect,$_GET['id']);
}else {$getuserid="";}

echo "<form id='frm1' name='frm1' action='?option=mail&task=main/permission' method='POST' onSubmit='JavaScript:return goto_url_update(1);'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไข เจ้าหน้าที่</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border= '0' Bgcolor='#Fcf9d8' class='table table-hover table-bordered table-striped table-condensed'>";
echo "<Tr><Td align='right'>สำนัก&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left' class='form-group'> $user_department_name";
echo "</div></td></tr>";
    $sql_mailper = "select * from mail_permission where id=? ";
    $dbquery_mailper = $connect->prepare($sql_mailper);
    $dbquery_mailper->bind_param("i", $getuserid);
    $dbquery_mailper->execute();
    $result_mailper=$dbquery_mailper->get_result();
   while($result_mailpermission = $result_mailper->fetch_array())
    {
      $ref_result = $result_mailpermission['p1'];
      $ref_personid = $result_mailpermission['person_id'];
    }
    $sql_person = "select  * from person_main where person_id=? and status=0 order by name";
    $dbquery_person = $connect->prepare($sql_person);
    $dbquery_person->bind_param("i",$ref_personid);
    $dbquery_person->execute();
    $result_showperson=$dbquery_person->get_result();
     while($result_person = $result_showperson->fetch_array())
    {
        $personname = $result_person['prename'].$result_person['name']." ".$result_person['surname'];
		$personuser_id = $result_person['person_id'];
   }
echo "<Tr><Td align='right'>บุคลากร&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'>$personname";
echo "</div></td></tr>";

			if($ref_result==1){
			$p1_check1="checked";
			$p1_check2="";
			}
			else{
			$p1_check1="";
			$p1_check2="checked";
			}
echo   "<tr><td align='right'>อนุญาตให้เป็นเจ้าหน้าที่ได้&nbsp;&nbsp;</td>";
echo   "<td align='left'>&nbsp;&nbsp;ใช่&nbsp;&nbsp;<input  type=radio name='mail_permission1' value='1' $p1_check1>&nbsp;&nbsp;ไม่ใช่&nbsp;&nbsp;<input  type=radio name='mail_permission1' value='0' $p1_check2></td></tr>";

echo "<Input Type=Hidden Name='index' Value='6'>";
echo "<Input Type=Hidden Name='person_id' Value='$personuser_id'>";
echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td align='center' colspan='2'><INPUT TYPE='submit' name='smb' class='btn btn-primary' value='ตกลง'>&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<INPUT TYPE='button' name='back' value='ย้อนกลับ' class='btn btn-default' onclick='location.href=\"?option=mail&task=main/permission\"'></td></tr>";
echo "</Table>";
echo "<Br>";
echo "<Input Type=Hidden Name='idpermis' Value='$getuserid'>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($postindex==6){

$person_id=mysqli_real_escape_string($connect,$_POST['person_id']);
$mail_permission1=mysqli_real_escape_string($connect,$_POST['mail_permission1']);
$idpermis=mysqli_real_escape_string($connect,$_POST['idpermis']);

$rec_date = date("Y-m-d");
$sql_update = "update mail_permission set  person_id=?, p1=?, officer=?, rec_date=? where id=?";
                    $dbquery_update = $connect->prepare($sql_update);
                    $dbquery_update->bind_param("iissi", $person_id,$mail_permission1,$login_user_id,$rec_date,$idpermis);
                    $dbquery_update->execute();
                    $result_update = $dbquery_update->get_result();
echo "<script>document.location.href='?option=mail&task=main/permission'; </script>\n";
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){

$sql_show = "select mail_permission.id, mail_permission.p1, person_main.name, person_main.surname from mail_permission left join person_main on mail_permission.person_id=person_main.person_id where person_main.department=? order by mail_permission.id";
    $dbquery_show = $connect->prepare($sql_show);
    $dbquery_show->bind_param("i", $user_departid);
    $dbquery_show->execute();
    $result_show = $dbquery_show->get_result();

echo "<form id='frm1' name='frm1' action='?option=mail&task=main/permission' method='post'>";
echo  "<table width=50% border=0 align=center class='table table-hover table-bordered table-striped table-condensed'>";
echo "<Input Type=Hidden Name='index' Value='1'>";
echo "<Tr><Td colspan='5' align='left'><INPUT TYPE='submit' name='smb' class='btn btn-success' value='เพิ่มเจ้าหน้าที่'></Td></Tr>";

echo "<Tr bgcolor='#FFCCCC'><Td  align='center' rowspan='2' >ที่</Td><Td  align='center' rowspan='2' >ชื่อเจ้าหน้าที่</Td><td  align='center'>สิทธื์</td><Td align='center' rowspan='2' width='50'>ลบ</Td><Td align='center' rowspan='2' width='50'>แก้ไข</Td></Tr>";
echo "<tr bgcolor='#CC9900'><Td  align='center' width='80'>เจ้าหน้าที่</Td></tr>";
$M=1;
While ($result = mysqli_fetch_array($result_show))
	{
		$id = $result['id'];
		$name = $result['name'];
		$surname = $result['surname'];
			if($result['p1']==1){
			$p1_pic="<img src=images/yes.png border='0' alt='มีสิทธิ์'>";			}
			else{
			$p1_pic="<img src=images/no.png border='0' alt='ไม่มีสิทธิ์'>";
			}
$color="";

		echo "<Tr bgcolor=$color><Td align='center' width='50'>$M</Td><Td  align='left'>$name $surname</Td><Td align='center'>$p1_pic</Td>";
        echo "<Td align='center' width='50' ><a href='?option=mail&task=main/permission&index=3&aid=$id' class='btn btn-danger' data-toggle='confirmation'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a></Td>";
        echo "<Td align='center' width='50'><a href=?option=mail&task=main/permission&index=5&id=$id><img src=images/edit.png border='0' alt='แก้ไข'></a></Td>
	</Tr>";
$M++;
	}
echo "</Table></form>";
}

?>
<script>
function goto_url(val){
	if(val==0){
            return false;   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
            return false;
        }
	}
}

function goto_url_update(val){
	if(val==0){
		      return false;   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
             return false;
		}
	}
}
</script>
