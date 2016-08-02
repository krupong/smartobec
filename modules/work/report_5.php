<script language='javascript'>
//<!–
function printContentDiv(content){
var printReady = document.getElementById(content);
//var txt= 'nn';
var txt= '';

if (document.getElementsByTagName != null){
var txtheadTags = document.getElementsByTagName('head');
if (txtheadTags.length > 0){
var str=txtheadTags[0].innerHTML;
txt += str; // str.replace(/funChkLoad();/ig, ” “);
}
}
//txt += 'nn';
if (printReady != null){
txt += printReady.innerHTML;
}
//txt +='nn';
var printWin = window.open();
printWin.document.open();
printWin.document.write(txt);
printWin.document.close();
printWin.print();
}
// –>
</script>

<div id="lblPrint">

<?php
$login_group=mysqli_real_escape_string($connect,$_SESSION['login_group']);
if(!($login_group<=1)){
exit();
}/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//if(!($_SESSION['login_status']<=5)){
$login_status=mysqli_real_escape_string($connect,$_SESSION['login_status']);
//if($login_status>=105){
//exit();
//}

require_once "modules/work/time_inc.php";

$department=mysqli_real_escape_string($connect,$_GET['department']);
//แปลงรูปแบบ date
if(isset($_GET['datepicker'])){
$f1_date=explode("-", $_GET['datepicker']);
$f2_date=$f1_date[2]."-".$f1_date[1]."-".$f1_date[0];  //ปี เดือน วัน
}
else{
$f2_date=date("Y-m-d");
}

$thai_date=thai_date($f2_date);
$sql_depatname= "select department_name from system_department where department=? ";
    $dbquery_depatname = $connect->prepare($sql_depatname);
    $dbquery_depatname->bind_param("i", $department);
    $dbquery_depatname->execute();
    $result_depatname=$dbquery_depatname->get_result();
    while($result_namedepartment = $result_depatname->fetch_array())
    {
		$department_name = $result_namedepartment['department_name'];
}

echo "<br />";
echo "<table width='99%' border='0' align='center'>";
echo "<tr align='center'><td colspan=2><font color='#006666' size='3'><strong>การปฏิบัติราชการ $thai_date</strong></font></td></tr>";
echo "<tr align='center'><td colspan=2><font color='#006666' size='3'><strong>ของ $department_name</strong></font></td></tr>";




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
			dateFormat: 'dd-mm-yy',
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
<INPUT TYPE="hidden" name=task value="report_5">
<INPUT TYPE="hidden" name=department value=<?=$department;?>>
เลือกวันที่ <input type="text" id="datepicker" name=datepicker value=<?php echo (isset($_GET['datepicker']))? $_GET['datepicker']:date("d-m-Y");?>  readonly Size=10>
</FORM>
	</td>
</tr>

<?php
echo "</table>";
echo  "<table width='98%' border='0' align='center' class='table table-hover table-bordered table-striped table-condensed'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='50'>ที่</Td>";
echo "<Td>ชื่อ</Td><Td>ตำแหน่ง</Td><Td>มา</Td><Td>ไปราชการ</Td><Td>ลาป่วย</Td><Td>ลากิจ</Td><Td>ลาพักผ่อน</Td><Td>ลาคลอด</Td><Td>ลาอื่นๆ</Td><Td>มาสาย</Td><Td>ไม่มา</Td></Tr>";
$N=1;
$work_1_sum=0; $work_2_sum=0; $work_3_sum=0;	$work_4_sum=0;	$work_5_sum=0;	$work_6_sum=0;	$work_7_sum=0;	$work_8_sum=0;	$work_9_sum=0;$work_sum_total=0;
//เพิ่มลาครื่งวัน
$work2_opt_sum=0; $work3_opt_sum=0; $work4_opt_sum=0; $work5_opt_sum=0; $work6_opt_sum=0; $work7_opt_sum=0; $work8_opt_sum=0; $work9_opt_sum=0; $workopt_sumdtotal=0; 

//ส่วนรายละเอียด

$sql_post = "select * from  person_position";
    $dbquery_post = $connect->prepare($sql_post);
    //$dbquery_post->bind_param();
    $dbquery_post->execute();
    $result_personpost = $dbquery_post->get_result();
    while($result_post = $result_personpost->fetch_array())
	   {
        $position_ar[$result_post['position_code']]=$result_post['position_name'];
    }

$sql_name = "select * from person_main  order by person_order,department,position_code";
    $dbquery_name = $connect->prepare($sql_name);
    //$dbquery_name->bind_param();
    $dbquery_name->execute();
    $result_personname = $dbquery_name->get_result();
    while($result_name = $result_personname->fetch_array())
	   {
        $person_id = $result_name['person_id'];
		$prename=$result_name['prename'];
		$name= $result_name['name'];
		$surname = $result_name['surname'];
		$position_code = $result_name['position_code'];
        $full_name_ar[$person_id]="$prename$name&nbsp;&nbsp;$surname";
        $position_code_ar[$person_id]=$position_code;
     }

$sql_work = "select work_main.person_id as person_id, work_main.work as work,person_main.prename as prename,person_main.name as name,person_main.surname as surname,person_main.position_code as position_code,person_main.department as department ,work_main.work_opt as work_opt  from work_main left join person_main on work_main.person_id=person_main.person_id where (work_main.work_date=?) and (person_main.department=?) order by person_main.person_order , person_main.department,person_main.sub_department";

    $dbquery_work = $connect->prepare($sql_work);
    $dbquery_work->bind_param("si",$f2_date,$department);
    $dbquery_work->execute();
    $result_daywork = $dbquery_work->get_result();
    while($result_work = $result_daywork->fetch_array())
	   {

if($result_work['work']!=""){

$prename=$result_work['prename'];
$name= $result_work['name'];
$surname = $result_work['surname'];
$position_code = $result_work['position_code'];
$full_name="$prename$name&nbsp;&nbsp;$surname";

$sql_post= "select position_name from person_position where position_code=? ";
    $dbquery_post = $connect->prepare($sql_post);
    $dbquery_post->bind_param("i",$position_code);
    $dbquery_post->execute();
    $result_personpost = $dbquery_post->get_result();
    while($result_post = $result_personpost->fetch_array())
	   {
        $position_name=$result_post['position_name'];
    }

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


echo "<tr bgcolor='$color'>";
echo "<td align='center'>$N</td><td>";
	if(isset($full_name)){
	echo $full_name;
	}
else{
echo "ไมมีรายชื่อ($person_id)";
}
echo"</td>";
echo "<td>";
	if(isset($position_name)){
	echo $position_name;
	}
echo "</td>";
echo "<td align='center'>$work_1</td><td align='center'>$work_2</td><td align='center'>$work_3</td><td align='center'>$work_4</td><td align='center'>$work_5</td><td align='center'>$work_6</td><td align='center'>$work_7</td><td align='center'>$work_8</td><td align='center'>$work_9</td>";
echo "</tr>";
$N++;

}

}

$work_sum_total=$work_1_sum+$work_2_sum+$work_3_sum+$work_4_sum+$work_5_sum+$work_6_sum+$work_7_sum+$work_8_sum+$work_9_sum;

$workopt_sumdtotal=$work2_opt_sum+$work3_opt_sum+$work4_opt_sum+$work5_opt_sum+$work7_opt_sum+$work8_opt_sum+$work9_opt_sum;
$showwork2_opt=""; $showwork3_opt=""; $showwork4_opt=""; $showwork5_opt=""; $showwork7_opt=""; $showwork8_opt=""; $showwork9_opt=""; 
if($work2_opt_sum!=0){$showwork2_opt="(".$work2_opt_sum.")";}
if($work3_opt_sum!=0){$showwork3_opt="(".$work3_opt_sum.")";}
if($work4_opt_sum!=0){$showwork4_opt="(".$work4_opt_sum.")";}
if($work5_opt_sum!=0){$showwork5_opt="(".$work5_opt_sum.")";}
if($work7_opt_sum!=0){$showwork7_opt="(".$work7_opt_sum.")";}
if($work8_opt_sum!=0){$showwork8_opt="(".$work8_opt_sum.")";}
if($work9_opt_sum!=0){$showwork9_opt="(".$work9_opt_sum.")";}

if($work_sum_total!=0){
echo "<tr bgcolor='#FFCCCC' align='center'>";
echo "<td colspan='3'>รวม</td><td>$work_1_sum</td><td>$work_2_sum$showwork2_opt</td><td>$work_3_sum$showwork3_opt</td><td>$work_4_sum$showwork4_opt</td><td>$work_5_sum$showwork5_opt</td><td>$work_6_sum</td><td>$work_7_sum$showwork7_opt</td><td>$work_8_sum$showwork8_opt</td><td>$work_9_sum$showwork9_opt</td>";
echo "</tr>";
if($work_sum_total==0){$work_sum_total=1;}
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

echo "<tr bgcolor='#FFCCCC' align='center'>";
echo "<td colspan='3'>%</td><td>$percent_work_1%</td><td>$percent_work_2%</td><td>$percent_work_3%</td><td>$percent_work_4%</td><td>$percent_work_5%</td><td>$percent_work_6%</td><td>$percent_work_7%</td><td>$percent_work_8%</td><td>$percent_work_9%</td>";
echo "</tr>";

}else{
echo "<tr bgcolor='#FFFFFF' align='center'><td colspan='12'><B>ไม่มีรายการที่บันทึกการมาปฏิบัติราชการ</b></td></tr>";
}

echo "</table>";
?>

</div>

<a href="javascript:printContentDiv('lblPrint');"><img src="images/b_print.png" border=0> พิมพ์หน้านี้</a>
<?php
echo "<br><b>&nbsp;&nbsp;หมายเหตุ</b><br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;ในวงเล็บหมายถึงจำนวนที่ลาครึ่งวัน เช่น ลากิจ 5(2) หมายถึง ลากิจทั้งหมด 5 วัน เป็นการลาครึ่งวัน 2 วัน<br>";
?>    
