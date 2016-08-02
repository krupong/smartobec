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

require_once "modules/work/time_inc.php";
//แปลงรูปแบบ date
if(isset($_GET['datepicker'])){
$f1_date=explode("-", $_GET['datepicker']);
$f2_date=$f1_date[2]."-".$f1_date[1]."-".$f1_date[0];  //ปี เดือน วัน
$f3_date=$_GET['datepicker'];
}
else{
$f2_date=date("Y-m-d");
$f3_date=date("d-m-Y");
}

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
        <button type="button" class="btn btn-warning" onclick="window.location.href='?option=work&task=report_4_print'">
        <span class="glyphicon glyphicon-print" aria-hidden="true"></span> จัดพิมพ์รายงานทุกสำนักวันนี้
     </button>
	</td>
	<td align=right  id=no_print>
<FORM name=frmSearchDate METHOD=GET>
<INPUT TYPE="hidden" name=option value="work">
<INPUT TYPE="hidden" name=task value="report_4">
เลือกเดือนปี <input type="text" id="datepicker" name=datepicker value=<?php echo (isset($_GET['datepicker']))? $_GET['datepicker']:date("d-m-Y");?>  readonly Size="12">
</FORM>
	</td>
</tr>

<?php
echo "</table>";

//ส่วนรายละเอียด
echo  "<table width='98%' border='0' align='center' class='table table-hover table-bordered table-striped table-condensed'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='50'>ที่</Td>";
echo "<Td>สำนัก</Td><Td>จำนวนทั้งหมด</Td><Td width='40' bgcolor='#CCFFFF'>มา</Td><Td width='40'>ไปราชการ</Td><Td width='40' bgcolor='#CCFFFF'>ลาป่วย</Td><Td width='40'>ลากิจ</Td><Td width='40' bgcolor='#CCFFFF'>ลาพักผ่อน</Td><Td width='40'>ลาคลอด</Td><Td width='40' bgcolor='#CCFFFF'>ลาอื่นๆ</Td><Td width='40'>มาสาย</Td><Td width='40' bgcolor='#CCFFFF'>ไม่มา</Td></Tr>";
$N=1;
//เลือกหน่วยงาน
    $sql_department = "select department,department_name from system_department order by department";
    $dbquery_department = $connect->prepare($sql_department);
    //$dbquery_department->bind_param();
    $dbquery_department->execute();
    $result_showdepartment=$dbquery_department->get_result();
    while($result_department = $result_showdepartment->fetch_array())
	   {
$work_1_sum=0; $work_2_sum=0; $work_3_sum=0;	$work_4_sum=0;	$work_5_sum=0;	$work_6_sum=0;	$work_7_sum=0;	$work_8_sum=0;	$work_9_sum=0;

$department = $result_department["department"];
$department_name = $result_department['department_name'];
//echo "de ".$department." pt<BR>";

//แสดงทุกคนและหน่วยงานในวันนั้นๆ
$sql_work = "select person_main.department as department,work_main.person_id,work_main.work from person_main,work_main where (work_main.work_date=?) and (work_main.person_id=person_main.person_id) and (person_main.department=?) order by person_main.person_order , person_main.department,person_main.sub_department ";

    $dbquery_work = $connect->prepare($sql_work);
    $dbquery_work->bind_param("si",$f2_date,$department);
    $dbquery_work->execute();
    $result_numwork=$dbquery_work->get_result();
    $num_rows=mysqli_num_rows($result_numwork);

 						if(($N%2) == 0)
						$color="#FFFFC";
						else  	$color="#FFFFFF";


echo "<tr bgcolor='$color'>";
echo "<td align='center'>$N</td>";
echo "<td><a href='?option=work&task=report_5&department=$department&datepicker=$f3_date' target='_blank'>$department_name</a></td>";
echo "<td align='center'>";
	echo $num_rows;
echo "</td>";

While ($result_work = $result_numwork->fetch_array()){


            //นับการมา ไม่มา
            if($result_work['work']==1){
			$work_1_sum=$work_1_sum+1;
			}
			else if($result_work['work']==2){
			$work_2_sum=$work_2_sum+1;
			}
			else if($result_work['work']==3){
			$work_3_sum=$work_3_sum+1;
			}
			else if($result_work['work']==4){
			$work_4_sum=$work_4_sum+1;
			}
			else if($result_work['work']==5){
			$work_5_sum=$work_5_sum+1;
			}
			else if($result_work['work']==6){
			$work_6_sum=$work_6_sum+1;
			}
			else if($result_work['work']==7){
			$work_7_sum=$work_7_sum+1;
			}
			else if($result_work['work']==8){
			$work_8_sum=$work_8_sum+1;
			}
			else if($result_work['work']==9){
			$work_9_sum=$work_9_sum+1;
            }

}

echo "<td align='center' bgcolor='#CCFFFF'>$work_1_sum</td><td align='center'>$work_2_sum</td><td align='center' bgcolor='#CCFFFF'>$work_3_sum</td><td align='center'>$work_4_sum</td><td align='center' bgcolor='#CCFFFF'>$work_5_sum</td><td align='center'>$work_6_sum</td><td align='center' bgcolor='#CCFFFF'>$work_7_sum</td><td align='center'>$work_8_sum</td><td align='center' bgcolor='#CCFFFF'>$work_9_sum</td>";


 $N++;
        }
echo "</table>";
?>

</div>
<br />
<a href="javascript:printContentDiv('lblPrint');"><img src="images/b_print.png" border=0> พิมพ์หน้านี้</a>
