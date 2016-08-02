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
$index="";
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

require_once "../time_inc.php";	
$user=$_SESSION['login_user_id'];

if(!isset($_REQUEST['search_index'])){
$_REQUEST['search_index']="";
}
if(!isset($_REQUEST['field'])){
$_REQUEST['field']="";
}
if(!isset($_REQUEST['search'])){
$_REQUEST['search']="";
}

if(!isset($_GET['saraban_index'])){
$_GET['saraban_index']="";
}

if(isset($_GET['saraban_index'])){
$saraban_index=$_GET['saraban_index'];
}
else{
$saraban_index="";
}

// อาเรย์ชื่อหน่วยงาาน
$office_name_ar['saraban']="สาราบรรณกลาง สพฐ.";
$sql_department = mysqli_query($connect,"SELECT * FROM  system_department") ;
while ($row_array= mysqli_fetch_array($sql_department)){
$office_name_ar[$row_array['department']]=$row_array['department_precis'];
}
$sql_khet = mysqli_query($connect,"SELECT * FROM  system_khet") ;
while ($row_array= mysqli_fetch_array($sql_khet)){
$office_name_ar[$row_array['khet_code']]=$row_array['khet_precis'];
}
$sql_unit = mysqli_query($connect,"SELECT * FROM system_special_unit") ;
while ($row_array= mysqli_fetch_array($sql_unit)){
$office_name_ar[$row_array['unit_code']]=$row_array['unit_name'];
}
$sql_subdepartment = mysqli_query($connect,"SELECT * FROM  system_subdepartment") ;
while ($row_array= mysqli_fetch_array($sql_subdepartment)){
$office_name_ar[$row_array['sub_department']]=$row_array['sub_department_name'];
}

//ส่วนหัว
echo "<br />";
echo "<table width='100%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>หนังสือรับ</strong></font></td></tr>";
echo "</table>";

//ส่วนแสดงผล
//ส่วนของการแยกหน้า

			if($_REQUEST['search_index']==1){
			$sql="select book_main.ms_id,book_sendto_answer.id from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id  and book_sendto_answer.send_to='$_SESSION[bookobec_user_office]' and  book_sendto_answer.school is null and $_REQUEST[field] like '%$_REQUEST[search]%' order by book_main.ms_id";
			}
			else {
			$sql="select book_main.ms_id from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id and  book_sendto_answer.send_to='$_SESSION[bookobec_user_office]' and book_sendto_answer.status is null order by book_main.ms_id";
			}

$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery );

$pagelen=20;  // 1_กำหนดแถวต่อหน้า
$url_link="option=book&task=main/receive_bookobec&search_index=$_REQUEST[search_index]&field=$_REQUEST[field]&search=$_REQUEST[search]&person=$_REQUEST[person]";  // 2_กำหนดลิงค์ฺ
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
<tr><form method="POST" action="?option=book&task=main/receive">
<td align="left"><FONT SIZE="2" COLOR="">ระดับความสำคัญ <IMG SRC="../images/level1.gif" WIDTH="20" HEIGHT="11" BORDER="0" ALT="ปกติ">ปกติ&nbsp;<IMG SRC="../images/level2.gif" WIDTH="20" HEIGHT="11" BORDER="0" ALT="ด่วน">ด่วน&nbsp;<IMG SRC="../images/level3.gif" WIDTH="20" HEIGHT="11" BORDER="0" ALT="ด่วนมาก">ด่วนมาก&nbsp;<IMG SRC="../images/level4.gif" WIDTH="20" HEIGHT="11" BORDER="0" ALT="ด่วนที่สุด">ด่วนที่สุด</FONT></td>
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
				echo "<input type='hidden' name='person' value='$_REQUEST[person]'>";
				echo " <input type='submit' value='ค้นหา'>";
				?>
				</p>
			</td></form>
		</tr>
</table>
<table width='98%' align="center"><tr><td>
<table class='table table-bordered' width='100%' style='background-color:rgba(255,255,255,0.9)'>
				<tr bgcolor=#330033>
					<td align="center" width="5%">
					<font  color=#FFFFFF>ที่</font></td>
					<td align="center" width="15%">
					<font color=#FFFFFF>เลขหนังสือ</font></td>
					<td align="center" width="30%"><font color=#FFFFFF>เรื่อง</font></td>
					<td align="center" width="5%">
					<font  color=#FFFFFF>ราย<br />ละเอียด</font></td>					
					<td align="center" width="10%">
					<font  color=#FFFFFF>ลงวันที่</font></td>
					<td align="center" width="15%">
					<font  color=#FFFFFF>จาก</font></td>
					<td align="center" width="15%">
					<font  color=#FFFFFF>วันเวลาที่ส่ง</font></td>
				</tr>

<?php
					if($_REQUEST['search_index']==1){
					$sql="select book_main.ms_id, book_main.ref_id, book_main.book_no, book_main.level, book_main.subject, book_main.signdate, book_main.office, book_main.send_date, book_sendto_answer.answer, book_sendto_answer.status, book_sendto_answer.forward_from, book_sendto_answer.rec_forward_date, book_sendto_answer.school, book_main.secret,book_main.bookregis_link,book_main.book_type from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id and  book_sendto_answer.send_to='$_SESSION[bookobec_user_office]' and book_sendto_answer.school is null and $_REQUEST[field] like '%$_REQUEST[search]%' order by book_main.ms_id limit $start,$pagelen";
					}
				else {
				$sql="select book_main.ms_id, book_main.ref_id, book_main.book_no, book_main.level, book_main.subject, book_main.signdate, book_main.office, book_main.send_date, book_sendto_answer.answer, book_sendto_answer.status, book_sendto_answer.forward_from, book_sendto_answer.rec_forward_date, book_sendto_answer.school, book_main.secret,book_main.bookregis_link,book_main.book_type from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id and  book_sendto_answer.send_to='$_SESSION[bookobec_user_office]' and book_sendto_answer.status is null order by book_main.ms_id limit $start,$pagelen";
				}

$dbquery = mysqli_query($connect,$sql);
$N=(($page-1)*$pagelen)+1; //*เกี่ยวข้องกับการแยกหน้า
$M=1;

While ($result = mysqli_fetch_array($dbquery)){
		$id = $result['ms_id'];
		$ref_id = $result['ref_id'];
		$level = $result['level'];
		$book_no = $result['book_no'];
		$signdate = $result['signdate'];
		$subject = $result['subject'];
		$status = $result['status'];		
		$ref_id = $result['ref_id'];
		$rec_date = $result['send_date'];
		$school = $result['school'];
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

// ตรวจสอบไฟล์แนบ
if($result['bookregis_link']==0){
$file = mysqli_query($connect,"SELECT id FROM  book_filebook WHERE ref_id='$ref_id' ") ;
}
else if($result['bookregis_link']==1){
$file = mysqli_query($connect,"SELECT * FROM  bookregister_send_filebook WHERE ref_id='$ref_id' ") ;
}
$file_num = mysqli_num_rows($file) ;
if ($file_num==0) {
	$file_img = "" ;
}else{
	$file_img = "<IMG SRC=\"../images/file1.gif\" WIDTH=\"13\" HEIGHT=\"10\" BORDER=\"0\" ALT=\"มีไฟล์แนบ\">" ;
}

if($result['secret']==1){
$secret_txt="<font color='#FF0000'>[ลับ]</font>";
}
else{
$secret_txt="";
}

//link ดูรายละเอียด
$saraban_text="bookobec_detail3.php";

//ตรวจสอบการรับหนังสือ
if($result['answer']==1){
$answer_pic="<IMG SRC='../images/b_usrcheck.png' WIDTH='16' HEIGHT='16' BORDER='0'> ";
}
else{
$answer_pic="<IMG SRC='../images/b_usrdrop.png' WIDTH='16' HEIGHT='16' BORDER='0' > ";
}

//ถ้าเขตเป็นผู้ส่งให้เรียกชื่อเขตมาแสดง
$office = $result['office'];
$office_name = $office_name_ar[$result['office']];
if($result['book_type']==2){
	$sql_khet="select * from system_khet where khet_code ='$office'";		 //รหัสสำนัก 
	$dbquery_khet = mysqli_query($connect,$sql_khet);
	$ref_result_khet = mysqli_fetch_array($dbquery_khet);
$office_name = $ref_result_khet['khet_precis'];
}
//จบเรียกชื่อเขต

?>
			<tr bgcolor="<?php echo $color;?>">
					<td  align="center"><?php echo $result['ms_id'];?></td>
					<td  align="left">&nbsp;<?php echo $book_no;?>&nbsp;<?php echo $img_level;?></td>
					<td align="left">&nbsp;<?php echo $answer_pic.$subject;?>&nbsp;<?php echo $file_img;?>&nbsp;<?php echo $secret_txt;?></td>
					<td  align="center"><A HREF="javascript:void(0)"
onclick="window.open('<?php echo $saraban_text?>?b_id=<?php echo $result['ms_id'];?>&khet=<?php echo $_SESSION['bookobec_user_office'];?>', 'bookdetail','width=500,height=500,scrollbars')" title="คลิกเพื่อดูรายละเอียด"><span style="text-decoration: none">คลิก</span></A></td>
					<td align="left"><?php echo $signdate;?></td>
					<td ><?php echo $office_name;?></td>
					<td align="left"><?php echo $send_date;?></td>
			  </tr>
					<?php
		
	$M++;
	$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}  // end while	
echo "<tr><td colspan='7'>&nbsp;<FONT COLOR='#009933'><IMG SRC='../images/b_usrcheck.png' WIDTH='16' HEIGHT='16' BORDER='0'>รับหนังสือแล้ว&nbsp;&nbsp;&nbsp;<IMG SRC='../images/b_usrdrop.png' WIDTH='16' HEIGHT='16' BORDER='0' >ยังไม่ได้รับหนังสือ&nbsp;&nbsp;&nbsp;<FONT COLOR='#009933'><IMG SRC='../images/file1.gif' WIDTH='16' HEIGHT='16' BORDER='0'>มีไฟล์เอกสาร</FONT></td></tr>";
echo "</table>";
echo "</td></tr></table>";

?>
