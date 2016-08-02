<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
if(!($_SESSION['login_status']<=5)){
exit();
}

require_once "modules/work/time_inc.php";

//แปลงรูปแบบ date
if(isset($_GET['datepicker'])){
$f1_date=explode("-", $_GET['datepicker']);
$f2_date=$f1_date[2]."-".$f1_date[1]."-".$f1_date[0];  //ปี เดือน วัน
}
else{
$f2_date=date("Y-m-d");
}

$thai_date=thai_date($f2_date);
echo "<br />";
echo "<table width='100%' border='0' align='center'>";
echo "<tr align='center'><td colspan=2><font color='#006666'><strong>$thai_date</strong></font></td></tr>";
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
			changeMonth: true,
			changeYear: true,
			monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
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
<INPUT TYPE="hidden" name=task value="report_1_mobile">
วันที่ <input type="text" id="datepicker" name=datepicker value=<?php echo (isset($_GET['datepicker']))? $_GET['datepicker']:date("d-m-Y");?>  readonly Size=10>
</FORM>
	</td>
</tr>

<?php
echo "</table>";
$sql_name = "select * from person_main order by department,position_code,person_order";
$dbquery_name = mysqli_query($connect,$sql_name);
While ($result_name = mysqli_fetch_array($dbquery_name)){
		$person_id = $result_name['person_id'];
		$prename=$result_name['prename'];
		$name= $result_name['name'];
		$surname = $result_name['surname'];
$full_name_ar[$person_id]="$prename$name&nbsp;&nbsp;$surname";
}

$sql_work = "select work_main.person_id, work_main.work from work_main left join person_main on work_main.person_id=person_main.person_id where work_main.work_date='$f2_date' order by person_main.department, person_main.position_code, person_main.person_order";

$dbquery_work = mysqli_query($connect,$sql_work);
$num_rows=mysqli_num_rows($dbquery_work);

if($num_rows<1){
echo "<div align='center'><font color='#CC0000' size='3'>ไม่มีรายการ</font></div>";
echo exit();
}
echo  "<table width='100%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='30'>ที่</Td>";
echo "<Td>ชื่อ</Td><Td width='10%'>มา</Td><Td width='18%'>ไปราชการ</Td><Td width='10%'>ลา</Td></Tr>";
$N=1;
$work_1_sum=0; $work_2_sum=0; $work_3_sum=0;	$work_4_sum=0;	$work_5_sum=0;	$work_6_sum=0;	$work_7_sum=0;	$work_8_sum=0;	$work_9_sum=0;

While ($result_work = mysqli_fetch_array($dbquery_work)){
		$person_id = $result_work['person_id'];

						if(($N%2) == 0)
						$color="#FFFFC";
						else  	$color="#FFFFFF";

$work_1=""; $work_2=""; $work_3="";	$work_4="";	$work_5="";	$work_6="";	$work_7="";	$work_8="";	$work_9="";

if($result_work['work']==1){
$work_1="/";
$work_1_sum=$work_1_sum+1;
}
else if($result_work['work']==2){
$work_2="<font color='#006666'>/</font>";
$work_2_sum=$work_2_sum+1;

}
//ลาทุกประเภท*
else if($result_work['work']==3){
$work_3="<font color='#FF0000'>/</font>";
$work_3_sum=$work_3_sum+1;
}
else if($result_work['work']==4){
$work_3="<font color='#FF0000'>/</font>";
$work_3_sum=$work_3_sum+1;
}
else if($result_work['work']==5){
$work_3="<font color='#FF0000'>/</font>";
$work_3_sum=$work_3_sum+1;
}
else if($result_work['work']==6){
$work_3="<font color='#FF0000'>/</font>";
$work_3_sum=$work_3_sum+1;
}
else if($result_work['work']==7){
$work_3="<font color='#FF0000'>/</font>";
$work_3_sum=$work_3_sum+1;
}
//*
else if($result_work['work']==8){
$work_8="มาสาย";
$work_8_sum=$work_8_sum+1;
}
else if($result_work['work']==9){
$work_9="ไม่มา";
$work_9_sum=$work_9_sum+1;
}

echo "<tr bgcolor='$color'>";

echo "<td align='center'>$N</td><td>";
	if(isset($full_name_ar[$person_id])){
	echo $full_name_ar[$person_id];
	}
else{
echo "ไมมีรายชื่อ($person_id)";
}
echo"</td>";
echo "<td align='center'>$work_1</td><td align='center'>$work_2</td><td align='center'>$work_3</td></tr>";
$N++;
}
echo "<tr bgcolor='#FFCCCC' align='center'>";
echo "<td colspan='2'>รวม</td><td>$work_1_sum</td><td>$work_2_sum</td><td>$work_3_sum</td>";
echo "</tr>";
echo "</table>";
?>

