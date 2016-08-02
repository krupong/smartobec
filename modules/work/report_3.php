<?php
$login_group=mysqli_real_escape_string($connect,$_SESSION['login_group']);
if(!($login_group<=1)){
exit();
}/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//if(!($_SESSION['login_status']<=5)){
$login_status=mysqli_real_escape_string($connect,$_SESSION['login_status']);
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
/*    $sql_permis = "select * from  meeting_permission where person_id=? ";
    $dbquery_permis = $connect->prepare($sql_permis);
    $dbquery_permis->bind_param("i", $user_id);
    $dbquery_permis->execute();
    $result_qpermis=$dbquery_permis->get_result();
    While ($result_permis = mysqli_fetch_array($result_qpermis))
    {
        $user_permis=$result_permis['p1'];
    }
    if(isset($user_permis)){
    if($user_permis!=1){
        echo "<div align='center'><h2> เฉพาะผู้ดูแลการลงเวลาปฏิบัติราชการเท่านั้น </h2></div>";
        exit();
    }
    }else{
        $user_permis="";
    }
*/
//    if($user_permis!=1){
//    echo "<div align='center'><h2> เฉพาะผู้ดูแลการลงเวลาปฏิบัติราชการเท่านั้น </h2></div>";
//        exit();
//    }


require_once "modules/work/time_inc.php";

$thai_month_arr=array(
	"01"=>"มกราคม",
	"02"=>"กุมภาพันธ์",
	"03"=>"มีนาคม",
	"04"=>"เมษายน",
	"05"=>"พฤษภาคม",
	"06"=>"มิถุนายน",
	"07"=>"กรกฎาคม",
	"08"=>"สิงหาคม",
	"09"=>"กันยายน",
	"10"=>"ตุลาคม",
	"11"=>"พฤศจิกายน",
	"12"=>"ธันวาคม"
);

//แปลงรูปแบบ date
$f1_date=explode("-", $_GET['start_date']);
$thai_month=$thai_month_arr[$f1_date[1]];
$thai_year=$f1_date[0]+543;

$person_id=mysqli_real_escape_string($connect,$_GET['person_id']);

//ส่วนรายละเอียด
    $sql_name= "select * from person_main where person_id=? ";
    $dbquery_name = $connect->prepare($sql_name);
    $dbquery_name->bind_param("s", $person_id);
    $dbquery_name->execute();
    $result_nameperson = $dbquery_name->get_result();
    while($result_name = $result_nameperson->fetch_array())
	   {
		$person_id = $result_name['person_id'];
		$prename=$result_name['prename'];
		$name= $result_name['name'];
		$surname = $result_name['surname'];
		$position_code = $result_name['position_code'];
        $full_name="$prename$name&nbsp;&nbsp;$surname";
    }
    $sql_post = "select * from  person_position where position_code=? ";
    $dbquery_post = $connect->prepare($sql_post);
    $dbquery_post->bind_param("i", $position_code);
    $dbquery_post->execute();
    $result_position = $dbquery_post->get_result();
    while($result_post = $result_position->fetch_array())
	   {
        $position_name=$result_post['position_name'];
    }

echo "<br />";
echo "<table width='99%' border='0' align='center'>";
echo "<tr align='center'><td colspan=2><font color='#006666' size='3'><strong>การปฏิบัติราชการเดือน$thai_month พ.ศ.$thai_year</strong></font></td></tr>";
echo "<tr align='center'><td colspan=2><font color='#006666' size='3'><strong>";
if($name!=""){
echo $full_name;
}
else{
echo $person_id;
}
echo " $position_name</strong></font></td></tr>";
echo "</table>";
echo "<br />";

$sql_work = "select work_date, work,work_opt from work_main where person_id=? and work_date between ? and ? order by work_date";
    $dbquery_work = $connect->prepare($sql_work);
    $dbquery_work->bind_param("sss", $person_id,$_GET['start_date'],$_GET['end_date']);
    $dbquery_work->execute();
    $result_mywork = $dbquery_work->get_result();

        $num_rows=mysqli_num_rows($result_mywork);

if($num_rows<1){
echo "<div align='center'><font color='#CC0000' size='3'>ไม่มีรายการ</font></div>";
echo exit();
}
echo  "<table width='95%' border='0' align='center' class='table table-hover table-bordered table-striped table-condensed'>";
echo "<Tr bgcolor='#FFCCCC' align='center' class='style1'><Td width='50'>ที่</Td>";
echo "<Td>วัน เดือน ปี</Td><Td>มา</Td><Td>ไปราชการ</Td><Td>ลาป่วย</Td><Td>ลากิจ</Td><Td>ลาพักผ่อน</Td><Td>ลาคลอด</Td><Td>ลาอื่นๆ</Td><Td>มาสาย</Td><Td>ไม่มา</Td></Tr>";
$N=1;
$work_1_sum=0; $work_2_sum=0; $work_3_sum=0;	$work_4_sum=0;	$work_5_sum=0;	$work_6_sum=0;	$work_7_sum=0;	$work_8_sum=0;	$work_9_sum=0;
//เพิ่มลาครื่งวัน
$work2_opt_sum=0; $work3_opt_sum=0; $work4_opt_sum=0; $work5_opt_sum=0; $work6_opt_sum=0; $work7_opt_sum=0; $work8_opt_sum=0; $work9_opt_sum=0; $workopt_sumdtotal=0; 

While ($result_work = $result_mywork->fetch_array()){

						if(($N%2) == 0)
						$color="#FFFFC";
						else  	$color="#FFFFFF";

$work_1=""; $work_2=""; $work_3="";	$work_4="";	$work_5="";	$work_6="";	$work_7="";	$work_8="";	$work_9="";
$work_opt="";
    
if($result_work['work']==1){
$work_1="มา";
$work_1_sum=$work_1_sum+1;
}
else if($result_work['work']==2){
if($result_work['work_opt']==0.5){$work_opt="(0.5)"; $work2_opt_sum=$work2_opt_sum+1; } //เพิ่มครึ่งวัน    
$work_2="ไปราชการ".$work_opt;
$work_2_sum=$work_2_sum+1;

}
else if($result_work['work']==3){
if($result_work['work_opt']==0.5){$work_opt="(0.5)"; $work3_opt_sum=$work3_opt_sum+1; } //เพิ่มครึ่งวัน    
$work_3="ลาป่วย".$work_opt;
$work_3_sum=$work_3_sum+1;
}
else if($result_work['work']==4){
if($result_work['work_opt']==0.5){$work_opt="(0.5)"; $work4_opt_sum=$work4_opt_sum+1; } //เพิ่มครึ่งวัน    
$work_4="ลากิจ".$work_opt;
$work_4_sum=$work_4_sum+1;
}
else if($result_work['work']==5){
if($result_work['work_opt']==0.5){$work_opt="(0.5)"; $work5_opt_sum=$work5_opt_sum+1; } //เพิ่มครึ่งวัน    
$work_5="ลาพักผ่อน".$work_opt;
$work_5_sum=$work_5_sum+1;
}
else if($result_work['work']==6){
if($result_work['work_opt']==0.5){$work_opt="(0.5)";} //เพิ่มครึ่งวัน    
$work_6="ลาคลอด";
$work_6_sum=$work_6_sum+1;
}
else if($result_work['work']==7){
if($result_work['work_opt']==0.5){$work_opt="(0.5)"; $work7_opt_sum=$work7_opt_sum+1; } //เพิ่มครึ่งวัน    
$work_7="ลาอื่นๆ".$work_opt;
$work_7_sum=$work_7_sum+1;
}
else if($result_work['work']==8){
if($result_work['work_opt']==0.5){$work_opt="(0.5)"; $work8_opt_sum=$work8_opt_sum+1; } //เพิ่มครึ่งวัน    
$work_8="มาสาย".$work_opt;
$work_8_sum=$work_8_sum+1;
}
else if($result_work['work']==9){
if($result_work['work_opt']==0.5){$work_opt="(0.5)"; $work9_opt_sum=$work9_opt_sum+1; } //เพิ่มครึ่งวัน    
$work_9="ไม่มา".$work_opt;
$work_9_sum=$work_9_sum+1;
}

    
    
echo "<tr bgcolor='$color' class='style1'>";
echo "<td align='center'>$N</td><td>";
$date=thai_date_2($result_work['work_date']);
echo $date;
echo"</td>";
echo "<td align='center'>$work_1</td><td align='center'>$work_2</td><td align='center'>$work_3</td><td align='center'>$work_4</td><td align='center'>$work_5</td><td align='center'>$work_6</td><td align='center'>$work_7</td><td align='center'>$work_8</td><td align='center'>$work_9</td>";
echo "</tr>";
$N++;
}
//เพิ่มลาครึ่งวัน    
$workopt_sumdtotal=$work2_opt_sum+$work3_opt_sum+$work4_opt_sum+$work5_opt_sum+$work7_opt_sum+$work8_opt_sum+$work9_opt_sum;
$showwork2_opt=""; $showwork3_opt=""; $showwork4_opt=""; $showwork5_opt=""; $showwork7_opt=""; $showwork8_opt=""; $showwork9_opt=""; 
if($work2_opt_sum!=0){$showwork2_opt="(".$work2_opt_sum.")";}
if($work3_opt_sum!=0){$showwork3_opt="(".$work3_opt_sum.")";}
if($work4_opt_sum!=0){$showwork4_opt="(".$work4_opt_sum.")";}
if($work5_opt_sum!=0){$showwork5_opt="(".$work5_opt_sum.")";}
if($work7_opt_sum!=0){$showwork7_opt="(".$work7_opt_sum.")";}
if($work8_opt_sum!=0){$showwork8_opt="(".$work8_opt_sum.")";}
if($work9_opt_sum!=0){$showwork9_opt="(".$work9_opt_sum.")";}


echo "<tr bgcolor='#FFCCCC' align='center' class='style1'>";
echo "<td colspan='2'>รวม</td><td>$work_1_sum</td><td>$work_2_sum$showwork2_opt</td><td>$work_3_sum$showwork3_opt</td><td>$work_4_sum$showwork4_opt</td><td>$work_5_sum$showwork5_opt</td><td>$work_6_sum</td><td>$work_7_sum$showwork7_opt</td><td>$work_8_sum$showwork8_opt</td><td>$work_9_sum$showwork9_opt</td>";
echo "</tr>";
$work_sum_total=$work_1_sum+$work_2_sum+$work_3_sum+$work_4_sum+$work_5_sum+$work_6_sum+$work_7_sum+$work_8_sum+$work_9_sum;
$percent_work_1=($work_1_sum/$work_sum_total)*100;
$percent_work_1=number_format($percent_work_1,2);
$percent_work_2=($work_2_sum/$work_sum_total)*100;
$percent_work_2=number_format($percent_work_2,2);
$percent_work_3=($work_3_sum/$work_sum_total)*100;
$percent_work_3=number_format($percent_work_3,2);
$percent_work_4=($work_4_sum/$work_sum_total)*100;
$percent_work_4=number_format($percent_work_4,2);
$percent_work_5=($work_5_sum/$work_sum_total)*100;
$percent_work_5=number_format($percent_work_5,2);
$percent_work_6=($work_6_sum/$work_sum_total)*100;
$percent_work_6=number_format($percent_work_6,2);
$percent_work_7=($work_7_sum/$work_sum_total)*100;
$percent_work_7=number_format($percent_work_7,2);
$percent_work_8=($work_8_sum/$work_sum_total)*100;
$percent_work_8=number_format($percent_work_8,2);
$percent_work_9=($work_9_sum/$work_sum_total)*100;
$percent_work_9=number_format($percent_work_9,2);

echo "<tr bgcolor='#FFCCCC' align='center' class='style1'>";
echo "<td colspan='2'>%</td><td>$percent_work_1%</td><td>$percent_work_2%</td><td>$percent_work_3%</td><td>$percent_work_4%</td><td>$percent_work_5%</td><td>$percent_work_6%</td><td>$percent_work_7%</td><td>$percent_work_8%</td><td>$percent_work_9%</td>";
echo "</tr>";

echo "</table>";
?>
<?php
echo "<b>&nbsp;&nbsp;หมายเหตุ</b><br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;ในวงเล็บหมายถึงจำนวนที่ลาครึ่งวัน เช่น ลากิจ 5(2) หมายถึง ลากิจทั้งหมด 5 วัน เป็นการลาครึ่งวัน 2 วัน<br><br>";
?>    
