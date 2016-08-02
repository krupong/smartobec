<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

?>
<script type="text/javascript" src="./css/js/calendarDateInput.js"></script> 
<?php

function thai_date_3($date){
		if(!isset($date)){
		return;
		}
$thai_month_arr=array(
	"01"=>"ม.ค.",
	"02"=>"ก.พ.",
	"03"=>"มี.ค.",
	"04"=>"เม.ย.",
	"05"=>"พ.ค.",
	"06"=>"มิ.ย.",	
	"07"=>"ก.ค.",
	"08"=>"ส.ค.",
	"09"=>"ก.ย.",
	"10"=>"ต.ค.",
	"11"=>"พ.ย.",
	"12"=>"ธ.ค."					
);
	$f_date_2=explode(" ", $date);
	$f_date=explode("-", $f_date_2[0]);
	$f_date[2]=intval($f_date[2]);
	$thai_date_return="";
	$thai_date_return.=	$f_date[2];
	$thai_date_return.= " ".$thai_month_arr[$f_date[1]]." ";
	$thai_date_return.=	$f_date[0]+543;
	if($date!=""){
	return $thai_date_return;
	}
	else{
	$thai_date_return="";
	return $thai_date_return;
	}
}

//ส่วนหัว
echo "<br />";
echo "<table width='100%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>ผู้รักษาราชการแทนเลขาธิการคณะกรรมการการศึกษาขั้นพื้นฐาน</strong></font></td></tr>";
echo "</table>";
echo "<br />";

//ส่วนแสดงผล
//ส่วนของการแยกหน้า
$pagelen=25;  // 1_กำหนดแถวต่อหน้า
$url_link="option=person&task=delegate";
$sql = "select id from person_delegate";
$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery );  
$totalpages=ceil($num_rows/$pagelen);

if(!isset($_REQUEST['page'])){
$_REQUEST['page']="";
}

if($_REQUEST['page']==""){
$page=$totalpages;
		if($page<2){
		$page=1;
		}
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
}

$start=($page-1)*$pagelen;

if(($totalpages>1) and ($totalpages<16)){
echo "<div align=center>";
echo "หน้า	";
			for($i=1; $i<=$totalpages; $i++)	{
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

$sql = "select person_delegate.id, person_delegate.start, person_delegate.finish, person_main.prename, person_main.name, person_main.surname,person_main.position_code from person_delegate left join person_main on person_delegate.person_id=person_main.person_id order by person_delegate.start limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);
echo  "<table width='65%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC'><Td align='center' rowspan='2' width='50'>ที่</Td><td align='center' colspan='2'>วันรักษาราชการแทน</td><Td align='center' rowspan='2'>ผู้รักษาราชการแทน</Td><Td align='center' rowspan='2'>ตำแหน่ง</Td></Tr>";
echo "<tr bgcolor='#CC9900'><Td align='center' width='110'>เริ่ม</Td><Td align='center' width='110'>สิ้นสุด</Td></tr>";
$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$prename = $result['prename'];
		$name = $result['name'];
		$surname = $result['surname'];
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
		echo "<Tr bgcolor=$color><Td align='center'>$M</Td><Td align='center'>";
		echo thai_date_3($result['start']);
		echo "</Td><Td align='center'>";
		echo thai_date_3($result['finish']);
		echo "</Td><Td align='left'>$prename$name $surname</Td><td>";
		$sql_position = "select position_name from person_position where position_code='$result[position_code]'";
		$dbquery_position = mysqli_query($connect,$sql_position);
		$result_position = mysqli_fetch_array($dbquery_position);
		echo $result_position['position_name'];
		echo "</td></Tr>";
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}
echo "</Table>";

?>
