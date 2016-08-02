<script type="text/javascript" src="./css/js/calendarDateInput2.js"></script> 

<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

require_once "modules/book/time_inc.php";	
$user=$_SESSION['login_user_id'];

if(isset($_GET['saraban_index'])){
$saraban_index=$_GET['saraban_index'];
}
else{
$saraban_index="";
}

if(!isset($_REQUEST['search_index'])){
$_REQUEST['search_index']="";
}
if(!isset($_REQUEST['field'])){
$_REQUEST['field']="";
}
if(!isset($_REQUEST['search'])){
$_REQUEST['search']="";
}

if(!isset($saraban_index)){
$saraban_index="";
}

if(!isset($_GET['saraban_index'])){
$_GET['saraban_index']="";
}

//ส่วนหัว
echo "<br />";
echo "<table width='100%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666'><strong>หนังสือรับ</strong></font></td></tr>";
echo "</table>";

//ส่วนแสดงผล

//ส่วนของการแยกหน้า
if($_SESSION['login_status']<=5){
		if($_REQUEST['search_index']==1){
		$saraban_index=9;
					$sql="select book_main.ms_id from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id  and  book_main.book_type='2' and book_sendto_answer.send_level='2' and $_REQUEST[field] like '%$_REQUEST[search]%' ";
		}
		else if($saraban_index==''){
					if($result_permission['p1']==1){
					$sql="select book_main.ms_id from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id  and book_sendto_answer.send_to='saraban' ";
					$saraban_index=1;
					}
					else if($result_permission['p2']!=''){
					$sql="select book_main.ms_id from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id  and  book_sendto_answer.send_to='$result_permission[p2]' ";
					$saraban_index=2;
					}
					else{
					$sql="select book_main.ms_id from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id  and  book_sendto_answer.send_to='$user' ";
					$saraban_index=3;
					}
			}
			else{
					if($saraban_index==1){
					$sql="select book_main.ms_id from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id  and book_sendto_answer.send_to='saraban' ";
					$saraban_index=1;
					}
					if($saraban_index==2){
					$sql="select book_main.ms_id from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id  and  book_sendto_answer.send_to='$result_permission[p2]' ";
					$saraban_index=2;
					}
					if($saraban_index==3){
					$sql="select book_main.ms_id from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id  and  book_sendto_answer.send_to='$user'  ";
					$saraban_index=3;
					}
					else if($saraban_index==9){
					$sql="select book_main.ms_id from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id  and  book_main.book_type='2' and book_sendto_answer.send_level='2' ";
					$saraban_index=9;
					}
			}	
}

if(($_SESSION['login_status']>10) and ($_SESSION['login_status']<=15)){
		if($_REQUEST['search_index']==1){
		$saraban_index=19;		
		$sql="select book_main.ms_id from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id  and book_sendto_answer.send_to='$_SESSION[user_school]' and  book_sendto_answer.school is null and $_REQUEST[field] like '%$_REQUEST[search]%' ";
		}
		else if($saraban_index==''){
					if($result_permission['p3']==$_SESSION['user_school']){
					$sql="select book_main.ms_id from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id and  book_sendto_answer.send_to='$result_permission[p3]' and  (book_sendto_answer.status is null or book_sendto_answer.status=6) ";
					$saraban_index=11;
					}
					else{
					$sql="select book_main.ms_id from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id  and  book_sendto_answer.send_to='$user' and book_sendto_answer.school='$_SESSION[user_school]' ";
					$saraban_index=12;
					}
		}
		
		else{
					if($saraban_index==11){
					$sql="select book_main.ms_id from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id  and  book_sendto_answer.send_to='$result_permission[p3]' and  (book_sendto_answer.status is null or book_sendto_answer.status=6)";
					$saraban_index=11;
					}
					else if($saraban_index==12){
					$sql="select book_main.ms_id from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id  and  book_sendto_answer.send_to='$user' and book_sendto_answer.school='$_SESSION[user_school]' ";
					$saraban_index=12;
					}
					else if($saraban_index==19){
					$sql="select book_main.ms_id from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id  and book_sendto_answer.send_to='$_SESSION[user_school]' and  book_sendto_answer.school is null ";
					$saraban_index=19;
					}
		}
}

$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery );

$pagelen=20;  // 1_กำหนดแถวต่อหน้า
$url_link="option=book&task=main/receive_mobile&saraban_index=$_GET[saraban_index]&search_index=$_REQUEST[search_index]&field=$_REQUEST[field]&search=$_REQUEST[search]";  // 2_กำหนดลิงค์ฺ
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

if(($totalpages>1) and ($totalpages<6)){
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
if($totalpages>5){
			if($page <=3){
			$e_page=5;
			$s_page=1;
			}
			if($page>3){
					if($totalpages-$page>=2){
					$e_page=$page+2;
					$s_page=$page-2;
					}
					else{
					$e_page=$totalpages;
					$s_page=$totalpages-5;
					}
			}
			echo "<div align=center>";
			if($page!=1){
			$f_page1=$page-1;
			echo "<<a href=$PHP_SELF?$url_link&page=1>แรก </a>";
			echo "<<<a href=$PHP_SELF?$url_link&page=$f_page1>ก่อน </a>";
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
			echo "<a href=$PHP_SELF?$url_link&page=$f_page2> ถัด</a>>>";
			echo "<a href=$PHP_SELF?$url_link&page=$totalpages> ท้าย</a>>";
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
<tr>
<?php
echo "<td align='center'>";
		//สำหรับเขต  
$a0_1="";  $a0_2=""; $a1_1=""; $a1_2="";  $a2_1="";  $a2_2="";  $a3_1="";  $a3_2="";  
		
		if($_SESSION['login_status']<=5){
				if($saraban_index==9){
				$a0_1="<font  size='3'>";
				$a0_2="</font>";
				}
				else if($saraban_index==1){
				$a1_1="<font size='3'>";
				$a1_2="</font>";
				}
				else if($saraban_index==2){
				$a2_1="<font  size='3'>";
				$a2_2="</font>";
				}
				else if($saraban_index==3){
				$a3_1="<font  size='3'>";
				$a3_2="</font>";
				}
				
				echo "$a0_1<b><a href=?option=book&task=main/receive_mobile&saraban_index=9>[ทั้งหมด]</a></b>$a0_2";
				
				if($result_permission['p1']==1){
				echo "&nbsp;$a1_1<b><a href=?option=book&task=main/receive_mobile&saraban_index=1>[สารบรรณกลาง]</a></b>$a1_2";
				}
				if($result_permission['p2']!=''){
				echo "&nbsp;$a2_1<b><a href=?option=book&task=main/receive_mobile&saraban_index=2>[กลุ่ม]</a></b>$a2_2";
				}
				echo "&nbsp;$a3_1<b><a href=?option=book&task=main/receive_mobile&saraban_index=3>[ส่วนบุคคล]</a></b>$a3_2";
		}
		
		//สำหรับสถานศึกษา
		if(($_SESSION['login_status']>10) and ($_SESSION['login_status']<=15)){
				if($saraban_index==19){
				$a0_1="<font  size='3'>";
				$a0_2="</font>";
				}
				else if($saraban_index==11){
				$a1_1="<font size='3'>";
				$a1_2="</font>";
				}
				else if($saraban_index==12){
				$a2_1="<font  size='3'>";
				$a2_2="</font>";
				}
		
				echo "$a0_1<b><a href=?option=book&task=main/receive_mobile&saraban_index=19>[ทั้งหมด]</a></b>$a0_2";
				if(isset($_SESSION['user_school'])){
						if($result_permission){
						echo "&nbsp;$a1_1<b><a href=?option=book&task=main/receive_mobile&saraban_index=11>[สารบรรณสถานศึกษา]</a></b>$a1_2";
						}
				}		
				echo "&nbsp;$a2_1<b><a href=?option=book&task=main/receive_mobile&saraban_index=12>[ส่วนบุคคล]</a></b>$a2_2";
		
		}
echo "</td>";

?>
		</tr>
</table>

<table border="1" width="98%" id="table2" style="border-collapse: collapse" align="center">
				<tr bgcolor=#99ccff>
					<td align="center">
					<font face="Tahoma" color=#FFFFFF>ที่</font></td>
					<td align="center">
					<font face="Tahoma" color=#FFFFFF>เลขหนังสือ</font></td>
					<td align="center"><font face="Tahoma" color=#FFFFFF>เรื่อง</font></td>
					<td align="center">
					<font face="Tahoma" color=#FFFFFF>ราย<br />ละเอียด</font></td>					
					<td align="center">
					<font face="Tahoma" color=#FFFFFF>ลงวันที่</font></td>
					<td align="center">
					<font face="Tahoma" color=#FFFFFF>จาก</font></td>
					<td align="center">
					<font face="Tahoma" color=#FFFFFF>วันเวลาที่ส่ง</font></td>
				</tr>

<?php
if($_SESSION['login_status']<=5){
					if($_REQUEST['search_index']==1){
					$sql="select book_main.ms_id, book_main.ref_id, book_main.book_no ,book_main.level, book_main.subject, book_main.signdate, book_main.office, book_main.send_date, book_sendto_answer.answer, book_sendto_answer.status, book_sendto_answer.forward_from, book_sendto_answer.rec_forward_date, book_sendto_answer.school, book_main.secret,book_main.bookregis_link,book_main.book_type from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id and  book_main.book_type='2' and book_sendto_answer.send_level='2' and $_REQUEST[field] like '%$_REQUEST[search]%' order by book_main.ms_id, book_sendto_answer.id limit $start,$pagelen ";
					}
					else if($saraban_index==1){
					$sql="select book_main.ms_id, book_main.ref_id, book_main.book_no ,book_main.level, book_main.subject, book_main.signdate, book_main.office, book_main.send_date, book_sendto_answer.answer, book_sendto_answer.status, book_sendto_answer.forward_from, book_sendto_answer.rec_forward_date, book_sendto_answer.school, book_main.secret,book_main.bookregis_link,book_main.book_type from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id and  book_sendto_answer.send_to='saraban' order by book_main.ms_id, book_sendto_answer.id limit $start,$pagelen ";
					}
					else if($saraban_index==2){
					$sql="select book_main.ms_id, book_main.ref_id, book_main.book_no ,book_main.level, book_main.subject, book_main.signdate, book_main.office, book_main.send_date, book_sendto_answer.answer, book_sendto_answer.status, book_sendto_answer.forward_from, book_sendto_answer.rec_forward_date, book_sendto_answer.school, book_main.secret,book_main.bookregis_link,book_main.book_type from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id and  book_sendto_answer.send_to='$result_permission[p2]'  order by book_main.ms_id, book_sendto_answer.id limit $start,$pagelen ";
					}
					else if($saraban_index==3){
					$sql="select book_main.ms_id, book_main.ref_id, book_main.book_no ,book_main.level, book_main.subject, book_main.signdate, book_main.office, book_main.send_date, book_sendto_answer.answer, book_sendto_answer.status, book_sendto_answer.forward_from, book_sendto_answer.rec_forward_date, book_sendto_answer.school, book_main.secret,book_main.bookregis_link,book_main.book_type from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id and  book_sendto_answer.send_to='$user' order by book_main.ms_id, book_sendto_answer.id limit $start,$pagelen ";
					}
					else if($saraban_index==9){
					$sql="select book_main.ms_id, book_main.ref_id, book_main.book_no ,book_main.level, book_main.subject, book_main.signdate, book_main.office, book_main.send_date, book_sendto_answer.answer, book_sendto_answer.status, book_sendto_answer.forward_from, book_sendto_answer.rec_forward_date, book_sendto_answer.school, book_main.secret,book_main.bookregis_link,book_main.book_type from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id and  book_main.book_type='2' and book_sendto_answer.send_level='2' order by book_main.ms_id, book_sendto_answer.id limit $start,$pagelen ";
					}
}

if(($_SESSION['login_status']>10) and ($_SESSION['login_status']<=15)){
					if($_REQUEST['search_index']==1){
					$sql="select book_main.ms_id, book_main.ref_id, book_main.book_no, book_main.level, book_main.subject, book_main.signdate, book_main.office, book_main.send_date, book_sendto_answer.answer, book_sendto_answer.status, book_sendto_answer.forward_from, book_sendto_answer.rec_forward_date, book_sendto_answer.school, book_main.secret,book_main.bookregis_link,book_main.book_type from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id and  book_sendto_answer.send_to='$_SESSION[user_school]' and book_sendto_answer.school is null and $_REQUEST[field] like '%$_REQUEST[search]%' order by book_main.ms_id, book_sendto_answer.id limit $start,$pagelen";
					}
					else if($saraban_index==11){
				$sql="select book_main.ms_id, book_main.ref_id, book_main.book_no, book_main.level, book_main.subject, book_main.signdate, book_main.office, book_main.send_date, book_sendto_answer.answer, book_sendto_answer.status, book_sendto_answer.forward_from, book_sendto_answer.rec_forward_date, book_sendto_answer.school, book_main.secret,book_main.bookregis_link,book_main.book_type from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id and  book_sendto_answer.send_to='$result_permission[p3]' and (book_sendto_answer.status is null or book_sendto_answer.status=6) order by book_main.ms_id, book_sendto_answer.id limit $start,$pagelen";
					}
					else if($saraban_index==12){
					$sql="select book_main.ms_id, book_main.ref_id, book_main.book_no, book_main.level, book_main.subject, book_main.signdate, book_main.office, book_main.send_date, book_sendto_answer.answer, book_sendto_answer.status, book_sendto_answer.forward_from, book_sendto_answer.rec_forward_date, book_sendto_answer.school, book_main.secret,book_main.bookregis_link,book_main.book_type from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id and  book_sendto_answer.send_to='$user' and  book_sendto_answer.school='$_SESSION[user_school]' order by book_main.ms_id, book_sendto_answer.id limit $start,$pagelen";
					}
					else if($saraban_index==19){
					$sql="select book_main.ms_id, book_main.ref_id, book_main.book_no, book_main.level, book_main.subject, book_main.signdate, book_main.office, book_main.send_date, book_sendto_answer.answer, book_sendto_answer.status, book_sendto_answer.forward_from, book_sendto_answer.rec_forward_date, book_sendto_answer.school, book_main.secret,book_main.bookregis_link,book_main.book_type from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id and  book_sendto_answer.send_to='$_SESSION[user_school]' and book_sendto_answer.school is null order by book_main.ms_id, book_sendto_answer.id limit $start,$pagelen";
					}

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
	$img_level = "<IMG SRC=\"modules/book/images/level1.gif\" WIDTH=\"20\" HEIGHT=\"11\" BORDER=\"0\" ALT=\"ปกติ\">" ;
}else if ($level==2) {
	$img_level = "<IMG SRC=\"modules/book/images/level2.gif\" WIDTH=\"20\" HEIGHT=\"11\" BORDER=\"0\" ALT=\"ด่วน\">" ;
}else if ($level==3) {
	$img_level = "<IMG SRC=\"modules/book/images/level3.gif\" WIDTH=\"20\" HEIGHT=\"11\" BORDER=\"0\" ALT=\"ด่วนมาก\">" ;
}else if ($level==4) {
	$img_level = "<IMG SRC=\"modules/book/images/level4.gif\" WIDTH=\"20\" HEIGHT=\"11\" BORDER=\"0\" ALT=\"ด่วนที่สุด\">" ;
}

// ตรวจสอบไฟล์แนบ
if($result['bookregis_link']==0){
$file = mysqli_query($connect,"SELECT id FROM  book_filebook WHERE ref_id='$ref_id' ") ;
}
else if($result['bookregis_link']==1 and $result['book_type']==1){
$file = mysqli_query($connect,"SELECT * FROM  bookregister_send_filebook WHERE ref_id='$ref_id' ") ;
}
else if($result['bookregis_link']==1 and $result['book_type']==2){
$file = mysqli_query($connect,"SELECT * FROM  bookregister_send_filebook_sch WHERE ref_id='$ref_id' ") ;
}
$file_num = mysqli_num_rows($file) ;
if ($file_num==0) {
	$file_img = "" ;
}else{
	$file_img = "<IMG SRC=\"modules/book/images/file1.gif\" WIDTH=\"13\" HEIGHT=\"10\" BORDER=\"0\" ALT=\"มีไฟล์แนบ\">" ;
}

if($result['secret']==1){
$secret_txt="<font color='#FF0000'>[ลับ]</font>";
}
else{
$secret_txt="";
}

// อาเรย์ชื่อหน่วยงาาน
$office_name_ar['saraban']="สาราบรรณกลาง";
$sql_work_group = mysqli_query($connect,"SELECT * FROM  system_workgroup") ;
while ($row_work_group= mysqli_fetch_array($sql_work_group)){
$office_name_ar[$row_work_group['workgroup']]=$row_work_group['workgroup_desc'];
}
$sql_sch = mysqli_query($connect,"SELECT * FROM  system_school") ;
while ($row_sch= mysqli_fetch_array($sql_sch)){
$office_name_ar[$row_sch['school_code']]=$row_sch['school_name'];
}

//link ดูรายละเอียด
if($saraban_index==1){
$saraban_text="bookdetail_saraban.php";
}
else if($saraban_index==2){
$saraban_text="bookdetail_group.php";
}
else if($saraban_index==3){
$saraban_text="bookdetail_khet_person.php";
}
else if($saraban_index==9){
$saraban_text="bookdetail_khet_total.php";
}
else if($saraban_index==11){
$saraban_text="bookdetail_school_saraban.php";
}
else if($saraban_index==12){
$saraban_text="bookdetail_school_person.php";
}
else if($saraban_index==19){
$saraban_text="bookdetail_school_total.php";
}

//ตรวจสอบการรับหนังสือ
if($result['answer']==1){
$answer_pic="<IMG SRC='modules/book/images/b_usrcheck.png' WIDTH='16' HEIGHT='16' BORDER='0'> ";
}
else{
$answer_pic="<IMG SRC='modules/book/images/b_usrdrop.png' WIDTH='16' HEIGHT='16' BORDER='0' > ";
}

//ตรวจว่าสารบรรณได้สงหนังสือให้กลุ่มแล้วหรือยัง
if($saraban_index==1){
$result_select_forward=mysqli_query($connect,"SELECT id FROM book_sendto_answer WHERE  ref_id='$ref_id' and status='1'") ;
$num_select_forward = mysqli_num_rows ($result_select_forward) ;
}
else if($saraban_index==2){
$result_select_forward=mysqli_query($connect,"SELECT id FROM book_sendto_answer WHERE  ref_id='$ref_id' and status='2'") ;
$num_select_forward = mysqli_num_rows ($result_select_forward) ;
}
else if($saraban_index==11){
$result_select_forward=mysqli_query($connect,"SELECT id FROM book_sendto_answer WHERE  school='$_SESSION[user_school]' and ref_id='$ref_id' and status='5'") ;
$num_select_forward = mysqli_num_rows ($result_select_forward) ;
}
else{
$num_select_forward=1;
}

		if($num_select_forward==0){
		$img_forward="<IMG SRC='modules/book/images/next.gif' WIDTH='16' HEIGHT='16' BORDER='0' > ";
		}
		else{
		$img_forward="";
		}

//กรณัเรื่องส่งคืน
// 3 ส่งมาจากเจ้าหน้าที่เขตถึงสารบรรณกลุ่ม  4 จากกลุ่มถึงสารบรรณเขต  6 มาจากครูถึงสารบรรณโรงเรียน 
if(($status==3) or ($status==6)){
		//หาชื่อผู้ส่ง	
		$sql_name = mysqli_query($connect,"SELECT * FROM  person_main WHERE person_id='$result[forward_from]' ");
		$row_name= mysqli_fetch_array($sql_name) ;
			if($row_name){
			$forward_name=$row_name['name']." ".$row_name['surname'];
			}
			else{
			$sql_name = mysqli_query($connect,"SELECT * FROM  person_sch_main WHERE person_id='$result[forward_from]'");
			$row_name= mysqli_fetch_array($sql_name) ;
			$forward_name=$row_name['name']." ".$row_name['surname'];
			}
$forward_date=thai_date_4($result['rec_forward_date']);			
$return=" <font color='#FF0000'>[ส่งคืนจาก$forward_name]</font>&nbsp;$forward_date";
}
else if($status==4){
$forward_date=thai_date_4($result['rec_forward_date']);			
		if(isset($office_name_ar[$school])){
		$return=" <font color='#FF0000'>[ส่งคืนจาก$office_name_ar[$school]]</font>&nbsp;$forward_date";
		}
}
else{
$return="";
}

?>
			<tr bgcolor="<?php echo $color;?>">
					<td  align="center"><?php echo $result['ms_id'];?></td>
					<td  align="left">&nbsp;<?php echo $book_no;?>&nbsp;<?php echo $img_level;?></td>
					<td align="left">&nbsp;<?php echo $img_forward.$answer_pic.$subject.$return ;?>&nbsp;<?php echo $file_img;?>&nbsp;<?php echo $secret_txt;?></td>
					<td  align="center"><A HREF="javascript:void(0)"
onclick="window.open('modules/book/main/<?php echo $saraban_text?>?b_id=<?php echo $result['ms_id'];?>', 'bookdetail','width=500,height=500,scrollbars')" title="คลิกเพื่อดูรายละเอียด"><span style="text-decoration: none">คลิก</span></A></td>
					<td align="left"><?php echo $signdate;?></td>
					<td ><?php echo $office_name_ar[$result['office']];?></td>
					<td align="left"><?php echo $send_date;?></td>
			  </tr>
					<?php
		
	$M++;
	$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}  // end while	
echo "<tr><td colspan='7'>&nbsp;<FONT COLOR='#009933'><IMG SRC='modules/book/images/b_usrcheck.png' WIDTH='16' HEIGHT='16' BORDER='0'>ลงทะเบียนรับแล้ว&nbsp;&nbsp;&nbsp;<IMG SRC='modules/book/images/b_usrdrop.png' WIDTH='16' HEIGHT='16' BORDER='0' >ยังไม่ได้ลงทะเบียนรับ&nbsp;&nbsp;&nbsp;<IMG SRC='modules/book/images/next.gif' WIDTH='16' HEIGHT='16' BORDER='0' >ยังไม่ได้ส่งต่อ</FONT>&nbsp;&nbsp;&nbsp;<FONT COLOR='#009933'><IMG SRC='modules/book/images/file1.gif' WIDTH='16' HEIGHT='16' BORDER='0'>มีไฟล์เอกสาร</FONT></td></tr>";
echo "</table>";
?>
