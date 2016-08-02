
<script type="text/javascript" src="./css/js/calendarDateInput2.js"></script> 

<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
require_once "person_chk.php";	
require_once "modules/book/time_inc.php";	
$user=$_SESSION['login_user_id'];

//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5) )){
echo "<table width='70%' border='1' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>หนังสือส่ง</strong></td></tr>";
echo "</table>";
}

//date_default_timezone_set('Asia/Bangkok');
//require_once "../../../database_connect.php";	
//require_once("../../../mainfile.php");
//require_once("../time_inc.php");

//$user=$_SESSION['login_user_id'];

//สิทธิ์
$sql_permission = "select * from  book_permission where person_id='$_SESSION[login_user_id]' ";
$dbquery_permission = mysqli_query($connect,$sql_permission);
$result_permission = mysqli_fetch_array($dbquery_permission);


$_id=$_GET['b_id'];
if (isset($_POST['submit']))
{
 $chkbox = $_POST['chk'];
$sql_answer = mysqli_query($connect,"update book_sendto_answer set answer='1',	answer_time='$day_now'	where ref_id='".$ref_id."' and send_to='".$result_permission[p4]."'") ;
// echo '<meta http-equiv="refresh" content="0;URL=#">';
}

if(!isset($_POST['index'])){
$_POST['index']="";
}
if(!isset($_GET['index'])){
$_GET['index']="";
}
$_REQUEST['b_id']=$_GET['b_id'];
$sql = mysqli_query($connect,"SELECT * FROM  book_main WHERE  ms_id  ='$_REQUEST[b_id]' ") ;
$row2= mysqli_fetch_array($sql) ;
		$id = $row2['ms_id'];
		$ref_id = $row2['ref_id'];
		$level = $row2['level'];
		$book_no = $row2['book_no'];
		$signdate = $row2['signdate'];
		$subject = $row2['subject'];
		$ref_id = $row2['ref_id'];
		$rec_date = $row2['send_date'];
		$detail = $row2['detail'];  $detail = nl2br($detail) ;

$send_date=thai_date_4($rec_date);
$signdate=thai_date_3($signdate);

////////////หาหน่วยงานผู้ส่ง
$sql_sender = mysqli_query($connect,"SELECT * FROM  system_department where department='$row2[office]' ") ;
$row_sender= mysqli_fetch_array($sql_sender) ;
if($row_sender){ 
$sender=$row_sender['department_name'];
}
else {
		$sql_sender = mysqli_query($connect,"SELECT * FROM system_khet WHERE khet_code='$row2[office]' ") ;
		$row_sender= mysqli_fetch_array($sql_sender) ;
		if($row_sender){ 
		$sender=$row_sender['khet_name'];
		}
		else{
		$sql_sender = mysqli_query($connect,"SELECT * FROM system_school WHERE school_code='$row2[office]' ") ;
		$row_sender= mysqli_fetch_array($sql_sender) ;
				if($row_sender){ 
				$sender=$row_sender['school_name'];
				}
				else{
				$sql_sender = mysqli_query($connect,"SELECT * FROM system_special_unit WHERE unit_code='$row2[office]' ") ;
				$row_sender= mysqli_fetch_array($sql_sender) ;
						if($row_sender){ 
						$sender=$row_sender['unit_name'];			
						}
						else{
						$sender="";
						}
				}
		}
}
/////////////

// saraban answer
$sql_answer = mysqli_query($connect,"SELECT id FROM  book_sendto_answer WHERE ref_id ='$ref_id' and send_to='$result_permission[p4]' and answer is null") ;
$ans_num = mysqli_num_rows ($sql_answer) ;

if ($ans_num>0) {
$day_now=date("Y-m-d H:i:s");

//$sql_answer = mysqli_query($connect,"update book_sendto_answer set answer='1',	answer_time='$day_now'	where ref_id='$ref_id' and send_to='$result_permission[p4]'") ;
}

// img of level
if ($level==1) {
	$img_level = "<IMG SRC=\"images/level1.gif\" WIDTH=\"20\" HEIGHT=\"11\" BORDER=\"0\" ALT=\"ปกติ\">&nbsp;<FONT SIZE=\"2\" COLOR=>ปกติ</FONT>" ;
}else if ($level==2) {
	$img_level = "<IMG SRC=\"../images/level2.gif\" WIDTH=\"20\" HEIGHT=\"11\" BORDER=\"0\" ALT=\"ด่วน\">&nbsp;<FONT SIZE=\"2\" COLOR=>ด่วน</FONT>" ;
}else if ($level==3) {
	$img_level = "<IMG SRC=\"../images/level3.gif\" WIDTH=\"20\" HEIGHT=\"11\" BORDER=\"0\" ALT=\"ด่วนมาก\">&nbsp;<FONT SIZE=\"2\" COLOR=>ด่วนมาก</FONT>" ;
}else if ($level==4) {
	$img_level = "<IMG SRC=\"../images/level4.gif\" WIDTH=\"20\" HEIGHT=\"11\" BORDER=\"0\" ALT=\"ด่วนที่สุด\">&nbsp;<FONT SIZE=\"2\" COLOR=>ด่วนที่สุด</FONT>" ;
}

	?>

	<div align="center"><br><br><table width="80%"><tr><td>
<table class='table table-striped table-bordered table-hover' id='dataTables-example'>		<tr>
			<td>
			<span lang="en-us">&nbsp;รายละเอียดหนังสือ :</td><td>
			<?php echo $book_no;?></td>
		</tr>
		<tr>
			<td>
			<p align="left">&nbsp;เรื่อง : </td><td><?php echo $subject;?> [<?php echo $img_level;?>]
			</td>
		</tr>
		<tr>
			<td>
			&nbsp;เลขทะเบียนหนังสือรับ : </td><td><?php echo $result_register_num['register_number']; ?></td>
		</tr>
		<tr>
			<td>
			&nbsp;หนังสือลงวันที่ : </td><td><?php echo $signdate;?></td>
		</tr>
		<tr>
			<td>
			&nbsp;ส่งโดย : </td><td><?php echo $sender;?></td>
		</tr>
		<tr>
			<td>
			&nbsp;วันเวลาที่ส่ง : </td><td><?php echo $send_date;?> </td>
		</tr>
		<tr>
			<td>&nbsp;เนื้อหาโดยสรุป : </td>


						<td align="left"><?php echo $detail;?></td>


		</tr>
		
	<tr>
			<td align="left">&nbsp;ไฟล์แนบ&nbsp;</td>
			<td>
				<table border="0">
<?php

// check file attach
if($row2['bookregis_link']==0){
$sql_file = mysqli_query($connect,"SELECT * FROM book_filebook WHERE  ref_id = '$ref_id' ") ;
$road="../../../upload/book/upload_files/";
}
else if($row2['bookregis_link']==1 and $row2['book_type']==1){
$sql_file = mysqli_query($connect,"SELECT * FROM  bookregister_send_filebook WHERE ref_id='$ref_id' ") ;
$road="../../bookregister/upload_files2/";
}
else if($row2['bookregis_link']==1 and $row2['book_type']==2){
$sql_file = mysqli_query($connect,"SELECT * FROM  bookregister_send_filebook_sch WHERE ref_id='$ref_id' ") ;
$road="../../bookregister/upload_files2/";
}

$file_num = mysqli_num_rows ($sql_file) ;

if ($file_num<> 0) {
$list = 1 ;
while ($list<= $file_num&&$row= mysqli_fetch_array($sql_file)) {
$file_name = $row ['file_name'] ;
$file_des = $row ['file_des'] ;

//xx
if($row2['secret']==1){
				?>
									<tr>
										<td align="left">&nbsp;ฃ<?php echo $list;?>. <span style="text-decoration: none"><?php echo $file_des;?></span></td>
									</tr>
				<?php 
}
else{
				?>
									<tr>
										<td align="left">&nbsp;<?php echo $list;?>. <A HREF="../upload_files/<?php echo $road.$file_name;?>" title="คลิกเพื่อเปิดไฟล์แนบลำดับที่ <?php echo $list;?>" target="_BLANK"><span style="text-decoration: none"><?php echo $file_des;?></span></A></td>
									</tr>
				<?php 
}
//endxx			
	
	$list ++ ;
	}

}else {
?>
<tr>
						<td>&nbsp;ไม่มีไฟล์แนบ</td>
</tr>

<?php
}

?>

				</table>
			</div>
			</td>
		</tr>
		
		<tr>
			<td  align="center" colspan="2"><b>
			ส่งถึง</b></td>
		</tr>
		
		<?php
		
// อาเรย์ชื่อหน่วยงาาน
$office_name_ar['saraban']="สารบรรณกลาง สพฐ.";
$sql_department = mysqli_query($connect,"SELECT * FROM  system_department") ;
while ($row_array= mysqli_fetch_array($sql_department)){
$office_name_ar[$row_array['department']]=$row_array['department_name'];
}
$sql_khet = mysqli_query($connect,"SELECT * FROM  system_khet") ;
while ($row_array= mysqli_fetch_array($sql_khet)){
$office_name_ar[$row_array['khet_code']]=$row_array['khet_precis'];
}
$sql_sch = mysqli_query($connect,"SELECT * FROM  system_school") ;
while ($row_array= mysqli_fetch_array($sql_sch)){
$office_name_ar[$row_array['school_code']]=$row_array['school_name'];
}
$sql_unit = mysqli_query($connect,"SELECT * FROM system_special_unit") ;
while ($row_array= mysqli_fetch_array($sql_unit)){
$office_name_ar[$row_array['unit_code']]=$row_array['unit_name'];
}

$sql_name = "select * from book_sendto_answer where ref_id='$ref_id' and send_to='$result_permission[p4]' order by id ";
$dbquery_name = mysqli_query($connect,$sql_name);
$M=1;
while ($result_name=mysqli_fetch_array($dbquery_name)) {
		$send_to= $result_name['send_to'];
		$answer=$result_name['answer'];
		$answer_time=$result_name['answer_time'];
		$answer_time=thai_date_4($answer_time);
echo "<tr><td align='left'>&nbsp;$M.$office_name_ar[$send_to]</td><td align='left'>";

		if ($answer==0) {
		$ans_img = "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span> ยังไม่ลงทะเบียนรับ" ;
		} 
		else if($answer==1) {
		$ans_img = "<span class='glyphicon glyphicon-ok' aria-hidden='true'></span> ลงทะเบียนรับแล้วเมื่อ $answer_time" ;
		}
echo $ans_img; 

//echo "</td></tr>";
$M++;
}

$date=date("Y-m-d H:i:s");
$date_now=thai_date_4($date);		
?>



 <form method="post" action="">
<!-- <div align="center"><button type="submit" class='btn btn-info' name="submit"><span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span> ลงทะเบียนรับ</button>
</div>-->
<?php
	echo '<input type="hidden" name="ref_id" value="'.$ref_id.'">';
	echo '<input type="hidden" name="send_to" value="'.$result_permission[p4].'">';
?>
<div align="center"><input type="submit" value="ลงทะเบียนรับ" class='btn btn-info' name="submit">
</div>
</form>

<?php

?>

</td></tr>
	</table>
</td>	
</tr>

<tr><td colspan="2">
	<BR>
	<CENTER>ข้อมูล ณ <?php echo $date_now;?><BR>************************************</CENTER>
</div>
<CENTER><a href="index.php?option=book&task=main/receive_in1"><div class="btn btn-default"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> ปิด </a></CENTER>
</td></tr>
</table>
</td></tr></table>
</body>
</html>




