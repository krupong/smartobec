<!--Bootstrap datepicker -->
    <script src="./modules/meeting/dist/js/bootstrap-datepicker.js"></script>
    <script src="./modules/meeting/dist/locales/bootstrap-datepicker.th.min.js"></script>
    <link href="./modules/meeting/dist/css/bootstrap-datepicker3.css" rel="stylesheet" media="screen">

<?php
/** ensure this file is being included by a parent file */
$login_group=mysqli_real_escape_string($connect,$_SESSION['login_group']);
if(!($login_group<=1)){
exit();
}
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
        $result_position_id = $result_user_depart['position_code'];
		$result_person_id = $result_user_depart['person_id'];
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
require_once "modules/work/time_inc.php";

//ส่วนหัว
if(isset($_GET['index'])){
$getindex=mysqli_real_escape_string($connect,$_GET['index']);
}else {$getindex="";}

if(isset($_POST['index'])){
$postindex=mysqli_real_escape_string($connect,$_POST['index']);
}else {$postindex="";}




//แสดงผลวันที่
$today = date("d/m/Y");
if(isset($_POST['search_date_start'])){
$search_date_starto=mysqli_real_escape_string($connect,$_POST['search_date_start']);
    $search_date_start=explode("/", $search_date_starto);
    $search_date_start=$search_date_start[2]."-".$search_date_start[1]."-".$search_date_start[0];  //ปี เดือน วัน
}else {$search_date_start="";
      $search_date_starto=$today;
      }
if(isset($_POST['search_date_end'])){
$search_date_endo=mysqli_real_escape_string($connect,$_POST['search_date_end']);
    $search_date_end=explode("/", $search_date_endo);
    $search_date_end=$search_date_end[2]."-".$search_date_end[1]."-".$search_date_end[0];  //ปี เดือน วัน
}else {$search_date_end="";
      $search_date_endo=$today;
      }


//ส่วนแสดงผล
echo "<table width='100%' border='0' align='center' >";
echo "<tr align='center'><td><font color='#006666'><h3><strong>รายงานสถิติการปฏิบัติราชการของสำนัก</strong></h3></font></td></tr>";
if($search_date_start !="" && $search_date_end !=""){
    $thaidate_start=thai_date_2($search_date_start);
    $thaidate_end=thai_date_2($search_date_end);
echo "<tr align='center'><td><font color='#006666'><h4><strong>ระหว่าง $thaidate_start ถึง $thaidate_end </strong></h4></font></td></tr>";
}
echo "</table>";


echo "<form id='frm1' name='frm1' action='?option=work&task=report_date' method='POST' onSubmit='JavaScript:return goto_url(1);'>";

echo "<table width=95% border=0 align=center class='table table-hover table-bordered table-striped table-condensed' id=no_print>";
echo "<Tr><Td align='center'><table ><tr><td>เลือกวันที่ที่ต้องการสร้างรายงาน &nbsp;&nbsp;</td><td>";
?>
<div class="input-daterange input-group" id="datepicker">
    <input type="text" class="input-sm form-control" name="search_date_start" id="search_date_start" placeholder="วันที่เริ่มต้น" />
    <span class="input-group-addon"> ถึงวันที่ </span>
    <input type="text" class="input-sm form-control" name="search_date_end" id="search_date_end" placeholder="วันที่สิ้นสุด" />
</div>
<?php    
//echo "<input class='form-control' type='text' name='search_date_start' id='search_date_start' data-provide='datepicker' data-date-language='th' value='$search_date_starto'  Size='10'>";
//echo "</td><td>&nbsp;&nbsp;&nbsp; ถึงวันที่ &nbsp;&nbsp;&nbsp;</td><td>";
//echo "<input class='form-control' type='text' name='search_date_end' id='search_date_end' data-provide='datepicker' data-date-language='th' value='$search_date_endo' Size='10'>";
echo "</td>";
echo "<Input Type=Hidden Name='index' Value='1'>";
   
echo "<td> &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<INPUT TYPE='submit' class='btn btn-primary' name='smb' value='ค้นหา' ></td>";
echo "</tr></table></Td></tr>";


echo "</Table></form>";

//ส่วนฟอร์มรับข้อมูล
if($postindex==1){

//ส่วนรายละเอียด
echo  "<table width='98%' border='0' align='center' class='table table-hover table-bordered table-striped table-condensed'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='50'>ที่</Td>";
echo "<Td>ชื่อ</Td><Td>ตำแหน่ง</Td><Td>มา</Td><Td>ไปราชการ</Td><Td>ลาป่วย</Td><Td>ลากิจ</Td><Td>ลาพักผ่อน</Td><Td>ลาคลอด</Td><Td>ลาอื่นๆ</Td><Td>มาสาย</Td><Td>ไม่มา</Td></Tr>";
//ถ้าเป็นผู้บริหารให้แสดงผลเฉพาะส่วนผู้บริหาร
//แสดงชื่อหน่วยงาน

    if(($result_position_id>0) and ($result_position_id<=11) and ($result_position_id!=9) ){
      $showwhereposit=" and ((position_code>0) and (position_code<=11) ) ";
    }else{$showwhereposit="";}
    //echo $result_position_id;
	//$connect->close();
$N=1;
    $sql_sumworkperson= "select * from person_main where department = ? $showwhereposit   order by person_order,sub_department ";
    $dbquery_sumwork = $connect->prepare($sql_sumworkperson);
    $dbquery_sumwork->bind_param("i", $user_departid);
    $dbquery_sumwork->execute();
    $result_shownallperson = $dbquery_sumwork->get_result();
    while($result_allperson = $result_shownallperson->fetch_array())
	   {

$work_1_sum=0; $work_2_sum=0; $work_3_sum=0;	$work_4_sum=0;	$work_5_sum=0;	$work_6_sum=0;	$work_7_sum=0;	$work_8_sum=0;	$work_9_sum=0;$work_sum_total=0;
//เพิ่มลาครื่งวัน
$work2_opt_sum=0; $work3_opt_sum=0; $work4_opt_sum=0; $work5_opt_sum=0; $work6_opt_sum=0; $work7_opt_sum=0; $work8_opt_sum=0; $work9_opt_sum=0; $workopt_sumdtotal=0; 
$work_opt="";        
            $person_id = $result_allperson['person_id'];
            $prename=$result_allperson['prename'];
            $name= $result_allperson['name'];
            $surname = $result_allperson['surname'];
            $position_code = $result_allperson['position_code'];
            //$work = $result_allperson['work'];
            $full_name="$prename$name&nbsp;&nbsp;$surname";

            $sql_work = "select work,work_opt from work_main  where (work_date between ? and ?) and (person_id=?) ";
            $dbquery_work = $connect->prepare($sql_work);
            $dbquery_work->bind_param("sss",$search_date_start,$search_date_end,$person_id);
            $dbquery_work->execute();
            $result_daywork = $dbquery_work->get_result();

            while($result_work = $result_daywork->fetch_array())
	           {
             $work = $result_work['work'];

			if($work==1){
			$work_1_sum=$work_1_sum+1;
			}
			else if($work==2){ 
                if($result_work['work_opt']==0.5){$work_opt="(0.5)"; $work2_opt_sum=$work2_opt_sum+1; } //เพิ่มครึ่งวัน    
			$work_2_sum=$work_2_sum+1;
			}
			else if($work==3){
                if($result_work['work_opt']==0.5){$work_opt="(0.5)"; $work3_opt_sum=$work3_opt_sum+1; } //เพิ่มครึ่งวัน    
			$work_3_sum=$work_3_sum+1;
			}
			else if($work==4){
                if($result_work['work_opt']==0.5){$work_opt="(0.5)"; $work4_opt_sum=$work4_opt_sum+1; } //เพิ่มครึ่งวัน    
			$work_4_sum=$work_4_sum+1;
			}
			else if($work==5){
                if($result_work['work_opt']==0.5){$work_opt="(0.5)"; $work5_opt_sum=$work5_opt_sum+1; } //เพิ่มครึ่งวัน    
			$work_5_sum=$work_5_sum+1;
			}
			else if($work==6){
			$work_6_sum=$work_6_sum+1;
			}
			else if($work==7){
                if($result_work['work_opt']==0.5){$work_opt="(0.5)"; $work7_opt_sum=$work7_opt_sum+1; } //เพิ่มครึ่งวัน    
			$work_7_sum=$work_7_sum+1;
			}
			else if($work==8){
                if($result_work['work_opt']==0.5){$work_opt="(0.5)"; $work8_opt_sum=$work8_opt_sum+1; } //เพิ่มครึ่งวัน    
			$work_8_sum=$work_8_sum+1;
			}
			else if($work==9){
                if($result_work['work_opt']==0.5){$work_opt="(0.5)"; $work9_opt_sum=$work9_opt_sum+1; } //เพิ่มครึ่งวัน    
			$work_9_sum=$work_9_sum+1;
			}
        }

            if(($N%2) == 0)
			$color="#FFFFC";
			else  $color="#FFFFFF";


            $sql_post= "select position_name from person_position where position_code=? ";
            $dbquery_post = $connect->prepare($sql_post);
            $dbquery_post->bind_param("i",$position_code);
            $dbquery_post->execute();
            $result_personpost = $dbquery_post->get_result();
            while($result_post = $result_personpost->fetch_array())
	        {
            $position_name=$result_post['position_name'];
            }


echo "<tr bgcolor='$color'>";
echo "<td align='center'>$N</td><td>";
if(isset($full_name)){
echo "$full_name";
}
else{
echo "ไม่มีรายชื่อ($person_id)";
}
echo"</td>";
echo "<td>";
	if(isset($position_name)){
	echo $position_name;
	}
echo "</td>";
if($work_1_sum==0){
$work_1_sum="";
}
if($work_2_sum==0){
$work_2_sum="";
}
if($work_3_sum==0){
$work_3_sum="";
}
if($work_4_sum==0){
$work_4_sum="";
}
if($work_5_sum==0){
$work_5_sum="";
}
if($work_6_sum==0){
$work_6_sum="";
}
if($work_7_sum==0){
$work_7_sum="";
}
if($work_8_sum==0){
$work_8_sum="";
}
if($work_9_sum==0){
$work_9_sum="";
}
//เพิ่มลาครึ่งวัน        
$showwork2_opt=""; $showwork3_opt=""; $showwork4_opt=""; $showwork5_opt=""; $showwork7_opt=""; $showwork8_opt=""; $showwork9_opt=""; 
if($work2_opt_sum!=0){$showwork2_opt="(".$work2_opt_sum.")";}
if($work3_opt_sum!=0){$showwork3_opt="(".$work3_opt_sum.")";}
if($work4_opt_sum!=0){$showwork4_opt="(".$work4_opt_sum.")";}
if($work5_opt_sum!=0){$showwork5_opt="(".$work5_opt_sum.")";}
if($work7_opt_sum!=0){$showwork7_opt="(".$work7_opt_sum.")";}
if($work8_opt_sum!=0){$showwork8_opt="(".$work8_opt_sum.")";}
if($work9_opt_sum!=0){$showwork9_opt="(".$work9_opt_sum.")";}

echo "<td align='center' bgcolor='#CCFFFF'>$work_1_sum</td><td align='center'>$work_2_sum$showwork2_opt</td><td align='center' bgcolor='#CCFFFF'>$work_3_sum$showwork2_opt</td><td align='center'>$work_4_sum$showwork4_opt</td><td align='center' bgcolor='#CCFFFF'>$work_5_sum$showwork5_opt</td><td align='center'>$work_6_sum</td><td align='center' bgcolor='#CCFFFF'>$work_7_sum$showwork7_opt</td><td align='center'>$work_8_sum$showwork8_opt</td><td align='center' bgcolor='#CCFFFF'>$work_9_sum$showwork9_opt</td>";
echo "</tr>";
$N++;

    }

echo "</table>";
?>
    
<?php
echo "<b>&nbsp;&nbsp;หมายเหตุ</b><br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;ในวงเล็บหมายถึงจำนวนที่ลาครึ่งวัน เช่น ลากิจ 5(2) หมายถึง ลากิจทั้งหมด 5 วัน เป็นการลาครึ่งวัน 2 วัน<br><br>";
?>  

<?php

}

?>
<script>
function goto_url(val){
	if(val==0){
            return false;    // page ย้อนกลับ
	}else if(val==1){
		if(frm1.search_date_start.value == ""){
			alert("กรุณาเลือกวันที่เริ่ม");
            return false;
        }else if(frm1.search_date_end.value == ""){
			alert("กรุณาระบุวันที่สิ้นสุด");
            return false;
        }
	}
}

</script>

<script type="text/javascript">
    $(function () {
        $('.input-daterange').datepicker({
            orientation: "bottom auto",
            format: 'dd/mm/yyyy',
            autoclose: true,
            language: "th",
        });

    });
</script>