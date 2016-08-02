<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SmartObec</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="../../../css/mm_training.css" type="text/css" />
</head>

<?php
require_once "../../../database_connect.php";	
///////////////////////////////
if(isset($_GET['sync_code'])){
			//ตรวจสอบการ Sync
			$sql = "select * from  system_sync where office_code='$_GET[office_code]' and sync_code='$_GET[sync_code]'";
			$dbquery = mysqli_query($connect,$sql);
			$result = mysqli_fetch_array($dbquery);
			if($result){
			$_SESSION['bookobec_user_office']=$_GET['office_code'];
			}
			else{
			echo "<br />";
			echo "<div align='center'>รหัสเชื่อมระบบไม่ถูกต้อง โปรดแจ้งผู้ดูและระบบ</div>";
			exit();
			}
			//ตรวจสอบการเป็นบุคลากร สพท.
			$sql_person = "select * from person_khet_main where khet_code='$_GET[office_code]' and person_id='$_GET[person]' and status='0'";
			$dbquery_person = mysqli_query($connect,$sql_person);
			$result_person = mysqli_fetch_array($dbquery_person);
			if($result_person){
			$_SESSION['bookobec_user_id']=$_GET['person'];
			$_SESSION['bookobec_user_group']=2;
			}
			else{
			$sql_person = "select * from person_special_main where unit_code='$_GET[office_code]' and person_id='$_GET[person]' and status='0'";
			$dbquery_person = mysqli_query($connect,$sql_person);
			$result_person = mysqli_fetch_array($dbquery_person);
					if($result_person){
					$_SESSION['bookobec_user_id']=$_GET['person'];
					$_SESSION['bookobec_user_group']=4;
					}
					else{
					$sql_person = "select * from person_sch_main where school_code='$_GET[office_code]' and person_id='$_GET[person]' and status='0'";
					$dbquery_person = mysqli_query($connect,$sql_person);
					$result_person = mysqli_fetch_array($dbquery_person);
							if($result_person){
							$_SESSION['bookobec_user_id']=$_GET['person'];
							$_SESSION['bookobec_user_group']=3;
							}
							else{
							echo "<div align='center'><br>";
							echo "คุณไม่มีชื่อในระบบ SmartObec โปรดตรวจสอบกับเจ้าหน้าที่";
							echo "</div>";
							exit();
							}
					}
			}
}
else{
			if($_SESSION['bookobec_user_id']!=$_REQUEST['person']){
			echo "คุณไม่ได้รับสิทธิ์";
			exit();
			}
}	
$_SESSION['bookobec_user_office']=trim($_SESSION['bookobec_user_office']);	
//////////////////////////////////

require_once "time_inc.php";	
$user=$_SESSION['login_user_id'];

//ส่วนหัว
echo "<br />";
echo "<table width='100%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>หนังสือส่ง</strong></font></td></tr>";
echo "</table>";

//ลบหนังสือ
if(isset($_GET['del'])){
		//ตรวจว่ามีผู้รับหนังสือหรือยัง
		$sql_check="select * from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id and book_sendto_answer.answer='1' and book_main.ms_id='$_GET[ms_id]'";
		$dbquery_check = mysqli_query($connect,$sql_check);
		$num_rows_check = mysqli_num_rows($dbquery_check);
		if($num_rows_check>=1){ 
		echo "<br>";
		echo "<div align='center'><font color='ff0000'>มีผู้รับหนังสือแล้ว ไม่อนุญาตให้ลบ</font></div>";
		echo "<br>";
		}
		else{
		mysqli_query($connect,"DELETE FROM book_main WHERE ms_id='$_GET[ms_id]' ") ;
		}
}

//ส่วนแสดงผล
if(!isset($_REQUEST['search_index'])){
$_REQUEST['search_index']="";
}
if(!isset($_REQUEST['field'])){
$_REQUEST['field']="";
}
if(!isset($_REQUEST['search'])){
$_REQUEST['search']="";
}

// อาเรย์บุคลากร
$sql_person = mysqli_query($connect,"SELECT * FROM  person_khet_main where khet_code='$_SESSION[bookobec_user_office]' ") ;
while ($row_person= mysqli_fetch_array($sql_person)){
$person_ar[$row_person['person_id']]=$row_person['prename'].$row_person['name']." ".$row_person['surname'];
}

//ส่วนของการแยกหน้า
if($_REQUEST['search_index']==1){	
$sql="select * from book_main where book_type='2' and $_REQUEST[field] like '%$_REQUEST[search]%' and office='$_SESSION[bookobec_user_office]' ";
}
else{
$sql="select * from book_main where book_type='2' and office='$_SESSION[bookobec_user_office]' ";
}
$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery);

$pagelen=20;  // 1_กำหนดแถวต่อหน้า
$url_link="option=book&task=main/send&search_index=$_REQUEST[search_index]&field=$_REQUEST[field]&search=$_REQUEST[search]&person=$_REQUEST[person]";  // 2_กำหนดลิงค์ฺ

$totalpages=ceil($num_rows/$pagelen);

if(!isset($_REQUEST['page'])){
$_REQUEST['page']="";
}

if(!(isset($_REQUEST['page']))){
$_REQUEST['page']=="";
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
					echo "<a href=$_SERVER[PHP_SELF]?$url_link&page=$i>[$i]</a>";
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
			echo "<<a href=$_SERVER[PHP_SELF]?$url_link&page=1>หน้าแรก </a>";
			echo "<<<a href=$_SERVER[PHP_SELF]?$url_link&page=$f_page1>หน้าก่อน </a>";
			}
			else {
			echo "หน้า	";
			}					
			for($i=$s_page; $i<=$e_page; $i++){
					if($i==$page){
					echo "[<b><font size=+1 color=#990000>$i</font></b>]";
					}
					else {
					echo "<a href=$_SERVER[PHP_SELF]?$url_link&page=$i>[$i]</a>";
					}
			}
			if($page<$totalpages)	{
			$f_page2=$page+1;
			echo "<a href=$_SERVER[PHP_SELF]?$url_link&page=$f_page2> หน้าถัดไป</a>>>";
			echo "<a href=$_SERVER[PHP_SELF]?$url_link&page=$totalpages> หน้าสุดท้าย</a>>";
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

?>
<table border="0" width="98%" id="table1" style="border-collapse: collapse" cellspacing="2" cellpadding="2" align="center">
<tr><td><FONT SIZE="2" COLOR="">ระดับความสำคัญ <IMG SRC="../images/level1.gif" WIDTH="20" HEIGHT="11" BORDER="0" ALT="ปกติ">ปกติ&nbsp;<IMG SRC="../images/level2.gif" WIDTH="20" HEIGHT="11" BORDER="0" ALT="ด่วน">ด่วน&nbsp;<IMG SRC="../images/level3.gif" WIDTH="20" HEIGHT="11" BORDER="0" ALT="ด่วนมาก">ด่วนมาก&nbsp;<IMG SRC="../images/level4.gif" WIDTH="20" HEIGHT="11" BORDER="0" ALT="ด่วนที่สุด">ด่วนที่สุด</FONT></td>
	<form method="POST" action="?option=book&task=main/send">
<td align="right">
				<p align="right"><font size="2">ค้นหาหนังสือ จาก 
				</font><select size="1" name="field">
				<?php
				if($_REQUEST['field']=='subject'){
				echo "<option value='subject' selected>เรื่อง</option>";
				}
				else{
				echo "<option value='subject'>เรื่อง</option>";
				}
				if($_REQUEST['field']=='book_no'){
				echo "<option value='book_no' selected>เลขหนังสือ</option>";
				}
				else{
				echo "<option value='book_no'>เลขหนังสือ</option>";
				}
				echo "</select>";
				
				echo "<font size='2'> ด้วยคำว่า </font>";
				echo "<input type='text' name='search' size='20' value='$_REQUEST[search]'>"; 
				echo "<input type='hidden' name='search_index' value='1'>";
				echo "<input type='hidden' name='person' value='$_SESSION[bookobec_user_id]'>";
				echo " <input type='submit' value='ค้นหา'>";
				
/////////////////////
/////////////////				
?>				
				</p>
			</td></form>
		</tr>
</table>


<table border="1" width="98%" id="table2" style="border-collapse: collapse" align="center">
				<tr bgcolor=#003399>
					<td width="70" align="center">
					<font size="2" face="Tahoma" color=#FFFFFF>ที่</font></td>
					<td align="center" width="200">
					<font face="Tahoma" size="2" color=#FFFFFF>เลขหนังสือ</font></td>
					<td align="center"><font face="Tahoma" size="2" color=#FFFFFF>เรื่อง</font></td>
					<td align="center" width="50">
					<font face="Tahoma" size="2" color=#FFFFFF>ราย<br />ละเอียด</font></td>
					<td align="center" width="120">
					<font face="Tahoma" size="2" color=#FFFFFF>ลงวันที่</font></td>
					<td align="center" width="160">
					<font face="Tahoma" size="2" color=#FFFFFF>วันเวลาที่ส่ง</font></td>
					<td align="center" width="150">
					<font face="Tahoma" size="2" color=#FFFFFF>ผู้ส่ง</font></td>
					<td align="center" width="40">
					<font face="Tahoma" size="2" color=#FFFFFF>ลบ</font></td>
				</tr>
</form>

<?php
if($_REQUEST['search_index']==1){	
$sql="select * from book_main where book_type='2' and $_REQUEST[field] like '%$_REQUEST[search]%' and office='$_SESSION[bookobec_user_office]'  order by ms_id limit $start,$pagelen";
}
else{
$sql="select * from book_main where book_type='2' and office='$_SESSION[bookobec_user_office]' order by ms_id limit $start,$pagelen";
}

$dbquery = mysqli_query($connect,$sql);

$N=(($page-1)*$pagelen)+1; //*เกี่ยวข้องกับการแยกหน้า
$M=1;

While ($result = mysqli_fetch_array($dbquery)){
		$id = $result['ms_id'];
		$sender = $result['sender'];
		$office = $result['office']; 
		$ref_id = $result['ref_id'];
		$level = $result['level'];
		$book_no = $result['book_no'];
		$signdate = $result['signdate'];
		$subject = $result['subject'];
		$ref_id = $result['ref_id'];
		$rec_date = $result['send_date'];
			if(($M%2) == 0)
			$color="#ffffff";
			else $color="#E5E5FF";
$send_date=thai_date_4($rec_date);
$signdate=thai_date_3($signdate);
// ระดับความสำคัญ
if ($level==1) {
	$img_level = "<IMG SRC=\"../images/level1.gif\" WIDTH=\"20\" HEIGHT=\"11\" BORDER=\"0\" ALT=\"ปกติ\">" ;
}else if ($level==2) {
	$img_level = "<IMG SRC=\"../images/level2.gif\" WIDTH=\"20\" HEIGHT=\"11\" BORDER=\"0\" ALT=\"ด่วน\">" ;
}else if ($level==3) {
	$img_level = "<IMG SRC=\"../images/level3.gif\" WIDTH=\"20\" HEIGHT=\"11\" BORDER=\"0\" ALT=\"ด่วนมาก\">" ;
}else if ($level==4) {
	$img_level = "<IMG SRC=\"../images/level4.gif\" WIDTH=\"20\" HEIGHT=\"11\" BORDER=\"0\" ALT=\"ด่วนที่สุด\">" ;
}

?>
			<tr bgcolor="<?php echo $color;?>">
					<td align="center"><?php echo $N;?></td>
					<td align="left">&nbsp;<?php echo $book_no;?>&nbsp;<?php echo $img_level;?></td>
					<td align="left">&nbsp;<?php echo $subject;?></td>
					<td align="center"><A HREF="javascript:void(0)"
onclick="window.open('send_detail.php?b_id=<?php echo $id;?>',
'bookdetail','width=500,height=500,scrollbars')" title="คลิกเพื่อดูรายละเอียด"><span style="text-decoration: none">คลิก</span></A></td>
					<td><?php echo $signdate;?></td>
					<td><?php echo $send_date;?></td>
					<?php
					if(isset($person_ar[$sender])){
					echo "<td>$person_ar[$sender]</td>";
					}
					else{
					echo "<td></td>";
					}
					echo "<td align='center'>";
					if($sender==$_SESSION['bookobec_user_id']){
									//ตั้งเวลาอนุญาตให้ลบ
									$now=time();
									$timestamp_recdate=make_time_2($rec_date);
									$timestamp_recdate_2=$timestamp_recdate+600;  //หน่วยวินาที
									if($now<=$timestamp_recdate_2){
									$delete=1;		//yes			
									}
									else {
									$delete=2;    //no
									}					
									//
							if($delete==1){
							echo "<a href='send_report_bookobec.php?person=$_REQUEST[person]&del=1&ms_id=$id'><IMG SRC='../../../images/b_drop.png'><a>";
							}
					}
					echo "</td>";
					?>
			  </tr>
					<?php
		
	$M++;
	$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}  // end while	
echo "</table>";

?>
