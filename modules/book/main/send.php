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
echo "<table width='70%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>หนังสือส่ง</strong></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($index==1){

$timestamp = mktime(date("H"), date("i"),date("s"), date("m") ,date("d"), date("Y"))  ;	
//timestamp เวลาปัจจุบัน 
$rand_number=rand();
$ref_id = $timestamp."x".$rand_number;
$_SESSION ['ref_id'] = $ref_id ;

//เลขที่หนังสือหน่วยงาน
	$sql="select * from bookregister_office_no where department = '$_SESSION[system_user_department]' ";    //รหัสสำนัก 
	$dbquery = mysqli_query($connect,$sql);
	$ref_result = mysqli_fetch_array($dbquery);
echo "<table width='900' border='0' align='center'><tr><td>";
echo "<form Enctype = multipart/form-data id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>ส่งหนังสือราชการ</b></font>";
echo "</Center>";
echo "<Br>";
echo " <table width='100%' class='table table-striped table-bordered table-hover' id='dataTables-example'>";
echo "<tr bgcolor='#003399'>";
echo "<td colspan='4' height='23' align='left'>&nbsp;กรุณาระบุรายละเอียด</td>";
echo "</tr>";

// *ผู้ส่งเป็น สพฐ.
if($_SESSION['login_group']==1){
echo "<tr>";
echo "<td width='200' align='right'><span lang='th'>จาก&nbsp;</span></td>";
echo "<td width='700' colspan='3' align='left'>";

	$sql_department= "select * from system_department where department='$_SESSION[system_user_department]'";
	$dbquery_department = mysqli_query($connect,$sql_department);
	While ($result_department = mysqli_fetch_array($dbquery_department)){
	echo  "&nbsp;&nbsp;<input type='radio'  name='department' value='$result_department[department]' checked>&nbsp;$result_department[department_name]<br>";
	}
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right'>ถึง&nbsp;</span></td>";
echo "<td colspan='3' align='left'>&nbsp;&nbsp;<input type='radio' value='all' name='sendto' required>&nbsp;สพท.ทุกแห่ง";
echo "<br>&nbsp;&nbsp;<input type='radio' value='some' name='sendto' required onClick=\"window.open('modules/book/main/select_send.php?sd_index=some','PopUp','width=700,height=600,scrollbars,status'); \">&nbsp;สพท.บางแห่ง";
echo "<br>&nbsp;&nbsp;<input type='radio' value='some' name='sendto' required onClick=\"window.open('modules/book/main/select_send_3.php?sd_index=some','PopUp','width=700,height=600,scrollbars,status'); \">&nbsp;หน่วยงาน/รร.สังกัด สำนักบริหารงานการศึกษาพิเศษ";
echo "<br>&nbsp;&nbsp;<input type='radio' value='some' name='sendto' required onClick=\"window.open('modules/book/main/select_send_5.php?sd_index=all','PopUp','width=700,height=600,scrollbars,status'); \">&nbsp;สำนักใน สพฐ.";

	$sql_group= "select * from book_group";
	$dbquery_group = mysqli_query($connect,$sql_group);
	While ($result_group = mysqli_fetch_array($dbquery_group)){
	echo  "<br>&nbsp;&nbsp;<input type='radio'  name='sendto' value='$result_group[grp_id]' onClick=\"window.open('modules/book/main/select_send_sch.php?sd_index=$result_group[grp_id]','PopUp','width=700,height=600,scrollbars,status'); \">&nbsp;$result_group[grp_name]";
	}
echo "</td></tr>";
}  //end *

// **ผู้ส่งเป็นสพท
if($_SESSION['login_group']>=2){

$khet_code1 = $_SESSION[system_user_khet];
$sql= "select * from bookregister_office_no_area where khet_code='$khet_code1' ";		//หาเลขที่หนังสือ สพท.
$query= mysqli_query($connect,$sql);
$result= mysqli_fetch_array($query);
$office_no_area = $result['office_no'];

echo "<tr>";
echo "<td  align='right'><span lang='th'>จาก&nbsp;</span></td>";
echo "<td  colspan='3' align='left'>";
	$sql_school= "SELECT * FROM  system_khet where khet_code = '$_SESSION[system_user_khet]'";
	$dbquery_school = mysqli_query($connect,$sql_school);
	$result_school = mysqli_fetch_array($dbquery_school);
	echo  "&nbsp;&nbsp;<input type='radio' name='department' value='$result_school[khet_code]' checked>&nbsp;$result_school[khet_precis]";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td  align='right'>ถึง&nbsp;</td>";
echo "<td colspan='3' align='left'>&nbsp;&nbsp;<input type='radio' value='saraban' name='sendto'>&nbsp;สารบรรณกลาง$_SESSION[office_name]";

	echo "<br>&nbsp;&nbsp;<input type='radio' value='some' name='sendto' required onClick=\"window.open('modules/book/main/select_send_5.php?sd_index=all','PopUp','width=700,height=600,scrollbars,status'); \">&nbsp;สำนักใน สพฐ.";
echo "<br>&nbsp;&nbsp;<input type='radio' value='all' name='sendto' required>&nbsp;สพท.ทุกแห่ง";
echo "<br>&nbsp;&nbsp;<input type='radio' value='some' name='sendto' required onClick=\"window.open('modules/book/main/select_send.php?sd_index=some','PopUp','width=700,height=600,scrollbars,status'); \">&nbsp;สพท.บางแห่ง";

echo "</td></tr>";
}  //end **

echo "<tr>";
echo "<td align='right'><span lang='th'>ระดับความสำคัญ&nbsp;</span></td>";
echo "<td colspan='3' align='left'>&nbsp;<input type='radio' name='level' value='1' checked>&nbsp;ปกติ&nbsp;
			<input type='radio' name='level' value='2'>&nbsp;ด่วน&nbsp;
			<input type='radio' name='level' value='3'>&nbsp;ด่วนมาก&nbsp;
			<input type='radio' name='level' value='4'>&nbsp;ด่วนที่สุด</td>";
echo "</tr>";

echo "<tr>";
echo "<td align='right'><span lang='th'>ความลับ&nbsp;</span></td>";
echo "<td colspan='3' align='left'>&nbsp;<input type='radio' name='secret' value='0' checked>&nbsp;ไม่ลับ&nbsp;
		<input type='radio' name='secret' value='1'>&nbsp;ลับ</td>";
echo "</tr>";

echo "<tr>";
echo "<td align='right'><span lang='th'>เลขที่หนังสือ&nbsp;</span></td><td colspan='2'>&nbsp;<input type='text' name='book_no' size='15' value='$ref_result[office_no]$office_no_area'   style='background-color: #99ccff' required></td></tr><tr>";
echo "<td  align='right'>ลงวันที่</td><td colspan='2'>";
?><script>DateInput('signdate', true, 'YYYY-MM-DD')</script>
<?php
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right'><span lang='th'>เรื่อง&nbsp;</span></td>";
echo "<td colspan='3' align='left'>&nbsp;<input type='text' name='subject' size='76'  style='background-color: #99ccff' required></td>";
echo "</tr>";
echo "<tr>";
echo "<td  align='right' height='47'><span lang='th'>เนื้อหาโดยสรุป&nbsp;</span></td>";
echo "<td height='47' width='514' colspan='3'  align='left'>&nbsp;
            <textarea class='form-control' rows='25' name='detail' id='detail' placeholder='ส่วนสำหรับพิมพ์เนื้อหา'></textarea>
            <script>
                CKEDITOR.replace ( 'detail');
            </script>
</td>";
echo "</tr>";

echo "<tr>";
echo "<td  align='right' colspan='2'><p align='center'>แนบไฟล์(ถ้ามี)</td>";
echo "<td  align='center' colspan='2'><p align='center'>คำอธิบายไฟล์</td>";
echo "</tr>";

echo "<tr>";
echo "<td align='right'>ไฟล์แนบ 1&nbsp;</td>";
echo "<td ><input type='file' name='myfile1' size='26' style='background-color: #99ccff'></td>";
echo "<td  align='center' colspan='2'><input type='text' name='dfile1' size='31' style='background-color: #E5E5FF'></td>";
echo "</tr>";

echo "<tr>";
echo "<td align='right'>ไฟล์แนบ 2&nbsp;</td>";
echo "<td><input type='file' name='myfile2' size='26' style='background-color: #99ccff'> </td>";
echo "<td  align='center' colspan='2'><input type='text' name='dfile2' size='31' style='background-color: #E5E5FF'></td>";
echo "</tr>";

echo "<tr>";
echo "<td align='right'>ไฟล์แนบ 3&nbsp;</td>";
echo "<td><input type='file' name='myfile3' size='26' style='background-color: #99ccff'> </td>";
echo "<td align='center' colspan='2'><input type='text' name='dfile3' size='31' style='background-color: #E5E5FF'></td>";
echo "</tr>";

echo "<tr>";
echo "<td align='right'>ไฟล์แนบ 4&nbsp;</td>";
echo "<td><input type='file' name='myfile4' size='26' style='background-color: #99ccff'> </td>";
echo "<td align='center' colspan='2'><input type='text' name='dfile4' size='31' style='background-color: #E5E5FF'></td>";
echo "</tr>";

echo "<tr>";
echo "<td align='right'>ไฟล์แนบ 5&nbsp;</td>";
echo "<td><input type='file' name='myfile5' size='26' style='background-color: #99ccff'> </td>";
echo "<td  align='center' colspan='2'><input type='text' name='dfile5' size='31' style='background-color: #E5E5FF'></td>";
echo "</tr>";

echo "<tr>";
echo "<td align='center' colspan='4'><FONT SIZE='2' COLOR='#CC9900'>เฉพาะไฟล์ doc, docx, pdf, xls, xlsx, gif, jpg, zip, rar เท่านั้น</td>";
echo "</tr>";
echo "<input name='ref_id' type='hidden' value='$ref_id'>";
echo "<tr>";
//echo "<td align='center' colspan='4'> <button type='submit' class='btn btn-primary'><span class='glyphicon glyphicon-ok' name='sbm'></span>&nbsp;บันทึก</button>&nbsp;<button type='submit' class='btn btn-default' onClick='history.go(-1);return true;'><span class='glyphicon glyphicon-remove'></span>&nbsp;ยกเลิก</button></td>";
echo "<td align='center' colspan='4'><BR><INPUT class='btn btn-primary  TYPE='button' name='smb' value='บันทึก' onclick='goto_url(1)'>&nbsp;&nbsp;<input class='btn btn-danger  type='button' value='ยกเลิก' onClick='history.go(-1);return true;'></td>";
echo "</tr>";
echo "</Table>";
echo "</form>";
}
echo "</td></td></table>";
//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='3'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง<br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT class='btn btn-primary' TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=book&task=main/send&index=3&id=$_GET[id]&page=$_REQUEST[page]\"'>
		&nbsp;&nbsp;<INPUT class='btn btn-danger' TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=book&task=main/send&page=$_REQUEST[page]\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
	$sql="select * from book_main  where ms_id='$_GET[id]'";
	$dbquery = mysqli_query($connect,$sql);
	$ref_result = mysqli_fetch_array($dbquery);
	$ref_id=$ref_result['ref_id'];

	$sql="select * from book_filebook where ref_id='$ref_id'";
	$dbquery_file = mysqli_query($connect,$sql);
	While ($result_file = mysqli_fetch_array($dbquery_file)){
	$file=	$result_file['file_name'];
	$path_file="upload/book/upload_files/".$file;
			if(file_exists($path_file)){
			unlink($path_file);	
			}
	}

$sql = "delete from book_filebook where ref_id='$ref_id'";
$dbquery = mysqli_query($connect,$sql);

$sql = "delete from book_sendto_answer where ref_id='$ref_id'";
$dbquery = mysqli_query($connect,$sql);

$sql = "delete from book_main where ms_id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนบันทึกข้อมูล

if($index==4){
$sizelimit = 20000*1024 ;  //ขนาดไฟล์
$subject = $_POST ['subject'] ;
$detail = $_POST ['detail'] ;
$dfile1 = $_POST ['dfile1'] ;
$dfile2 = $_POST ['dfile2'] ;
$dfile3 = $_POST ['dfile3'] ;
$dfile4 = $_POST ['dfile4'] ;
$dfile5 = $_POST ['dfile5'] ;

/// file
$myfile1 = $_FILES ['myfile1'] ['tmp_name'] ;
$myfile1_name = $_FILES ['myfile1'] ['name'] ;
$myfile1_size = $_FILES ['myfile1'] ['size'] ;
$myfile1_type = $_FILES ['myfile1'] ['type'] ;

 $array_last1 = explode("." ,$myfile1_name) ;
 $c1 =count ($array_last1) - 1 ;
 $lastname1 = strtolower ($array_last1 [$c1] ) ;

$alert_files="";
$alert_filesize="";

 if  ($myfile1<>"") {
		 if ($lastname1 =="doc" or $lastname1 =="docx" or $lastname1 =="rar" or $lastname1 =="pdf" or $lastname1 =="xls" or $lastname1 =="xlsx" or $lastname1 =="zip" or $lastname1 =="jpg" or $lastname1 =="gif" ) { 
		  }else {
			 $alert_files.= "-ไม่อนุญาตให้ทำการแนบไฟล์ $myfile1_name " ;
		  } 

		  If ($myfile1_size>$sizelimit) {
			  $alert_filesize.= "-ไฟล์ $myfile1_name มีขนาดใหญ่กว่าที่กำหนด " ;
		  }
 }
  ####

$myfile2 = $_FILES ['myfile2'] ['tmp_name'] ;
$myfile2_name = $_FILES ['myfile2'] ['name'] ;
$myfile2_size = $_FILES ['myfile2'] ['size'] ;
$myfile2_type = $_FILES ['myfile2'] ['type'] ;

$array_last2 = explode("." ,$myfile2_name) ;
 $c2 =count ($array_last2) - 1 ;
 $lastname2 = strtolower ($array_last2 [$c2] ) ;

  if  ($myfile2<>"") {
		 if ($lastname2 =="doc" or $lastname2 =="docx" or $lastname2 =="rar" or $lastname2 =="pdf" or $lastname2 =="xls" or $lastname2 =="xlsx" or $lastname2 =="zip" or $lastname2 =="jpg" or $lastname2 =="gif") { 
		  }else {
			$alert_files.= "-ไม่อนุญาตให้ทำการแนบไฟล์ $myfile2_name " ;
		  } 

		  If ($myfile2_size>$sizelimit) {
			  $alert_filesize.= "-ไฟล์ $myfile2_name มีขนาดใหญ่กว่าที่กำหนด" ;
		  }
  }
  ####
$myfile3 = $_FILES ['myfile3'] ['tmp_name'] ;
$myfile3_name = $_FILES ['myfile3'] ['name'] ;
$myfile3_size = $_FILES ['myfile3'] ['size'] ;
$myfile3_type = $_FILES ['myfile3'] ['type'] ;
$array_last3 = explode("." ,$myfile3_name) ;
 $c3 =count ($array_last3) - 1 ;
 $lastname3 = strtolower ($array_last3 [$c3] ) ;

  if  ($myfile3<>"") {
		 if ($lastname3 =="doc" or $lastname3 =="docx" or $lastname3 =="rar" or $lastname3 =="pdf" or $lastname3 =="xls" or $lastname3 =="xlsx" or $lastname3 =="zip" or $lastname3 =="jpg" or $lastname3 =="gif") { 
		  }else {
			 $alert_files.= "-ไม่อนุญาตให้ทำการแนบไฟล์ $myfile3_name " ;
		  } 

		  If ($myfile3_size>$sizelimit) {
			  $alert_filesize.= "-ไฟล์ $myfile3_name มีขนาดใหญ่กว่าที่กำหนด " ;
		  }
  }
  ####
$myfile4 = $_FILES ['myfile4'] ['tmp_name'] ;
$myfile4_name = $_FILES ['myfile4'] ['name'] ;
$myfile4_size = $_FILES ['myfile4'] ['size'] ;
$myfile4_type = $_FILES ['myfile4'] ['type'] ;
$array_last4 = explode("." ,$myfile4_name) ;
 $c4 =count ($array_last4) - 1 ;
 $lastname4 = strtolower ($array_last4 [$c4] ) ;

  if  ($myfile4<>"") {
		 if ($lastname4 =="doc" or $lastname4 =="docx" or $lastname4 =="rar" or $lastname4 =="pdf" or $lastname4 =="xls" or $lastname4 =="xlsx" or $lastname4 =="zip" or $lastname4 =="jpg" or $lastname4 =="gif") { 
		  }else {
			 $alert_files.= "-ไม่อนุญาตให้ทำการแนบไฟล์ $myfile4_name " ;
		  } 

		  If ($myfile4_size>$sizelimit) {
			  $alert_filesize.= "-ไฟล์ $myfile4_name มีขนาดใหญ่กว่าที่กำหนด" ;
		  }
  }
  ####
$myfile5 = $_FILES ['myfile5'] ['tmp_name'] ;
$myfile5_name = $_FILES ['myfile5'] ['name'] ;
$myfile5_size = $_FILES ['myfile5'] ['size'] ;
$myfile5_type = $_FILES ['myfile5'] ['type'] ;
$array_last5 = explode("." ,$myfile5_name) ;
 $c5 =count ($array_last5) - 1 ;
 $lastname5 = strtolower ($array_last5 [$c5] ) ;

  if  ($myfile5<>"") {
		 if ($lastname5 =="doc" or $lastname5 =="docx" or $lastname5 =="rar" or $lastname5 =="pdf" or $lastname5 =="xls" or $lastname5 =="xlsx" or $lastname5 =="zip" or $lastname5 =="jpg" or $lastname5 =="gif") { 
		  }else {
			 $alert_files.= "-ไม่อนุญาตให้ทำการแนบไฟล์ $myfile5_name " ;
		  } 

		  If ($myfile5_size>$sizelimit) {
			  $alert_filesize.= "-ไฟล์ $myfile5_name มีขนาดใหญ่กว่าที่กำหนด " ;
		  }
  }
  ####
////

if(!isset($_POST['sendto'])){
$_POST['sendto']="";
}

if($_POST['sendto']=="" ){
	echo "<br><br><CENTER><font size=\"2\" color=\"#008000\">กรอกข้อมูลไม่ครบ กรุณาเลือกผู้รับ<br><br>";
	echo "<input type=\"button\" value=\"แก้ไขข้อมูล\" onClick=\"javascript:history.go(-1)\" ></CENTER>" ;
	exit(); 
}
if($_POST['subject']=="" ){
	echo "<br><br><CENTER><font size=\"2\" color=\"#008000\">กรอกข้อมูลไม่ครบ กรุณากรอกชื่อเรื่อง<br><br>";
	echo "<input type=\"button\" value=\"แก้ไขข้อมูล\" onClick=\"javascript:history.go(-1)\" ></CENTER>" ;
	exit(); 
}
if($_POST['detail'] ==""){
	echo "<br><br><CENTER><font size=\"2\" color=\"#008000\">กรอกข้อมูลไม่ครบ กรุณากรอกเนื้อหาโดยสรุป<br><br>";
	echo "<input type=\"button\" value=\"แก้ไขข้อมูล\" onClick=\"javascript:history.go(-1)\" ></CENTER>" ;
	exit(); 
}
//if($_POST['myfile1_name'] ==""){
//	echo "<br><br><CENTER><font size=\"2\" color=\"#008000\">กรอกข้อมูลไม่ครบ กรุณาแนบไฟล์<br><br>";
//	echo "<input type=\"button\" value=\"แก้ไขข้อมูล\" onClick=\"javascript:history.go(-1)\" ></CENTER>" ;
//	exit(); 
//} #จบ


// check file size  file name
if ($alert_files<> "" || $alert_filesize<> "" ) {

echo "<B><FONT SIZE=2 COLOR=#990000>มีข้อผิดพลาดเกี่ยวกับไฟล์ของคุณ ดังรายละเอียด</B><BR>" ;
echo "<FONT SIZE=2 COLOR=#990099>" ;
 echo  $alert_files ;
 echo  $alert_filesize ;
 echo "" ;
 echo "&nbsp;&nbsp;&nbsp;<input type=\"button\" value=\"&nbsp;&nbsp;แก้ไข&nbsp;&nbsp;\" onClick=\"javascript:history.go(-1)\" ></CENTER>" ;
exit () ;
}

//ตรวจสอบว่ามีผู้รับหรือยัง สำหรับสพท.ส่ง
// ***
if($_SESSION['login_group']==1){
$sql_send_num = mysqli_query($connect,"SELECT * FROM book_sendto_answer WHERE ref_id='$_POST[ref_id]' ") ;
$send_num = mysqli_num_rows ($sql_send_num) ;
if ($send_num==0 and $_POST['sendto']!='all') {
echo "<div align='center'>";
echo "<B><FONT SIZE=2 COLOR=#990000>ยังไม่ได้ระบุผู้รับหนังสือ</B><BR><BR>" ;
 echo "&nbsp;&nbsp;&nbsp;<input type=\"button\" value=\"&nbsp;&nbsp;แก้ไข&nbsp;&nbsp;\" onClick=\"javascript:history.go(-1)\" ></CENTER>" ;
echo "</div>";
exit () ;
}
} //end ***

//ตรวจสอบว่ามีผู้รับหรือยัง สำหรับโรงเรียน.ส่ง
// ***
if($_SESSION['login_group']>=2){	
$sql_send_num = mysqli_query($connect,"SELECT * FROM book_sendto_answer WHERE ref_id='$_POST[ref_id]' ") ;
$send_num = mysqli_num_rows ($sql_send_num) ;
if ($send_num==0 and $_POST['sendto']=='some') {
echo "<div align='center'>";
echo "<B><FONT SIZE=2 COLOR=#990000>ยังไม่ได้ระบุผู้รับหนังสือ</B><BR><BR>" ;
 echo "&nbsp;&nbsp;&nbsp;<input type=\"button\" value=\"&nbsp;&nbsp;แก้ไข&nbsp;&nbsp;\" onClick=\"javascript:history.go(-1)\" ></CENTER>" ;
echo "</div>";
exit () ;
}
} //end ***

//ส่วนการบันทึก
$day_now=date("Y-m-d H:i:s");
	if($_SESSION['login_group']==1){
	$book_type=1;  //ผู้ส่งคือสพท
	}
	else{
	$book_type=2;  //ผู้ส่งคือโรงเรียน
	}

//ตรวจสอบ ref_id
if(!isset($_POST['ref_id'])){
echo "<script>alert('มีข้อผิดพลาดเกี่ยวกับเลขอ้างอิงในระบบ ยกเลิกการส่งหนังสือในครั้งนี้ กรุณาส่งใหม่อีกครั้ง'); document.location.href='?option=book&task=main/send&index=1';</script>";
exit();
} 
if($_POST['ref_id']==""){
echo "<script>alert('มีข้อผิดพลาดเกี่ยวกับเลขอ้างอิงในระบบ ยกเลิกการส่งหนังสือในครั้งนี้ กรุณาส่งใหม่อีกครั้ง'); document.location.href='?option=book&task=main/send&index=1';</script>";
exit();
} 

$sql = "insert into book_main (book_type, office, sender, level, secret, book_no, signdate, subject, detail, ref_id, send_date) values ('$book_type', $_POST[department], '$user', '$_POST[level]', '$_POST[secret]', '$_POST[book_no]', '$_POST[signdate]','$_POST[subject]','$_POST[detail]','$_POST[ref_id]','$day_now')";
$dbquery = mysqli_query($connect,$sql);

// ส่งแจ้งเตือนไปโทรศัพท์ 
$date = ThaiTimeConvert(time(),"","2"); 

//$date = time();
switch($book_type) {
    case 1:
        // แจ้งเตือนเขต
    	$sqlsendby="select * from system_department sd where department='".$_POST[department]."'";
        $resutlsendby=mysqli_query($connect,$sqlsendby);
        $rowsendby=$resutlsendby->fetch_assoc();
        $sendby=$rowsendby["department_precis"];
        $sql_answer = "select * from book_sendto_answer bsa left join book_permission bp on(bsa.send_to=bp.p4) where bsa.ref_id = '".$_POST[ref_id]."'";
        $result_answer = mysqli_query($connect, $sql_answer);
        while($row_answer = $result_answer->fetch_assoc()) {
            $person_id = $row_answer["person_id"];
            smartpush($person_id,"book"," เลขที่ ".$_POST[book_no]." : ".$_POST[subject],"มีหนังสือเข้าเมื่อ ".$date." จาก ".$sendby);
        }
        // แจ้งเตือนสารบัญสำนัก

        $sql_answer = "select * from book_sendto_answer bsa left join book_permission bp on(bsa.send_to=bp.p2) where  send_to != 'saraban' and bsa.ref_id = '".$_POST[ref_id]."'";
        $result_answer = mysqli_query($connect, $sql_answer);
        while($row_answer = $result_answer->fetch_assoc()) {
            $person_id = $row_answer["person_id"];
            smartpush($person_id,"book"," เลขที่ ".$_POST[book_no]." : ".$_POST[subject],"มีหนังสือเข้าเมื่อ ".$date." จาก ".$sendby);
        }
    break;
    
    case 2:
    	$sqlsendby="select * from system_khet sk where khet_code='".$_POST[department]."'";
        $resutlsendby=mysqli_query($connect,$sqlsendby);
        $rowsendby=$resutlsendby->fetch_assoc();
        $sendby=$rowsendby["khet_precis"];
        // แจ้งเตือนสารบัญกลาง
        //$sql_answer = "select * from book_sendto_answer bsa left join book_permission bp on(bsa.send_to=bp.p1) where  send_to = 'saraban' and bsa.ref_id = '".$_POST[ref_id]."'";
        $sql_answer = "select * from book_permission where p1 = '1'";
        $result_answer = mysqli_query($connect, $sql_answer);
        while($row_answer = $result_answer->fetch_assoc()) {
            $person_id = $row_answer["person_id"];
            smartpush($person_id,"book"," เลขที่ ".$_POST[book_no]." : ".$_POST[subject],"มีหนังสือเข้าเมื่อ ".$date." จาก ".$sendby);
        }
        // แจ้งเตือนสารบัญสำนัก
        $sql_answer = "select * from book_sendto_answer bsa left join book_permission bp on(bsa.send_to=bp.p2) where  send_to != 'saraban' and bsa.ref_id = '".$_POST[ref_id]."'";
        $result_answer = mysqli_query($connect, $sql_answer);
        while($row_answer = $result_answer->fetch_assoc()) {
            $person_id = $row_answer["person_id"];
            smartpush($person_id,"book"," เลขที่ ".$_POST[book_no]." : ".$_POST[subject],"มีหนังสือเข้าเมื่อ ".$date." จาก ".$sendby);
        }
        // แจ้งเตือนเขต
        $sql_answer = "select * from book_sendto_answer bsa left join book_permission bp on(bsa.send_to=bp.p4) where bsa.ref_id = '".$_POST[ref_id]."'";
        $result_answer = mysqli_query($connect, $sql_answer);
        while($row_answer = $result_answer->fetch_assoc()) {
            $person_id = $row_answer["person_id"];
            smartpush($person_id,"book"," เลขที่ ".$_POST[book_no]." : ".$_POST[subject],"มีหนังสือเข้าเมื่อ ".$date." จาก ".$sendby);
        }
    break;
        
    default:
        
    break;
}

// จบการแจ้งเตือน

if ($myfile1<>"" ) {
$myfile1name=$_POST['ref_id']."_1.".$lastname1 ; 
copy ($myfile1, "upload/book/upload_files/".$myfile1name)  ; 

$sql = "insert into book_filebook (ref_id, file_name, file_des) values ('$_POST[ref_id]','$myfile1name','$dfile1')";
$dbquery = mysqli_query($connect,$sql);

unlink ($myfile1) ;
}

if ($myfile2<>"") {
$myfile2name=$_POST['ref_id']."_2.".$lastname2 ; 
copy ($myfile2, "upload/book/upload_files/".$myfile2name)  ; 
$sql = "insert into book_filebook (ref_id, file_name, file_des) values ('$_POST[ref_id]','$myfile2name','$dfile2')";
$dbquery = mysqli_query($connect,$sql);
unlink ($myfile2) ;
}

if ($myfile3<>"") {
$myfile3name=$_POST['ref_id']."_3.".$lastname3 ; 
copy ($myfile3, "upload/book/upload_files/".$myfile3name)  ; 
$sql = "insert into book_filebook (ref_id, file_name, file_des) values ('$_POST[ref_id]','$myfile3name','$dfile3')";
$dbquery = mysqli_query($connect,$sql);
unlink ($myfile3) ;
}

if ($myfile4<>"") {
$myfile4name=$_POST['ref_id']."_4.".$lastname4 ; 
copy ($myfile4, "upload/book/upload_files/".$myfile4name)  ; 
$sql = "insert into book_filebook (ref_id, file_name, file_des) values ('$_POST[ref_id]','$myfile4name','$dfile4')";
$dbquery = mysqli_query($connect,$sql);
unlink ($myfile4) ;
}

if ($myfile5<>"") {
$myfile5name=$_POST['ref_id']."_5.".$lastname5 ; 
copy ($myfile5, "upload/book/upload_files/".$myfile5name)  ; 
$sql = "insert into book_filebook (ref_id, file_name, file_des) values ('$_POST[ref_id]','$myfile5name','$dfile5')";
$dbquery = mysqli_query($connect,$sql);
unlink ($myfile5) ;
}
	
//สำหรับสพท	
if($_SESSION['login_group']==1){
			if($_POST['sendto']=='all') { 
			$sql_sendto = "select khet_code from system_khet  order by khet_code";
			$dbquery_sendto = mysqli_query($connect,$sql_sendto);
					While ($result_sendto = mysqli_fetch_array($dbquery_sendto)){
					$sql=	"insert into book_sendto_answer (send_level, ref_id, send_to) values ('1', '$_POST[ref_id]','$result_sendto[khet_code]')";
					$dbquery = mysqli_query($connect,$sql);
					}
			}
}	

if($_SESSION['login_group']>=2){		
			if($_POST['sendto']=='all') { 
        $khet_code2 = $_SESSION[system_user_khet];
			$sql_sendto = "select khet_code from system_khet where khet_code!='$khet_code2'";

			//$sql_sendto = "select khet_code from system_khet where khet_code != '$_SESSION[user_khet]'   order by khet_code";
			$dbquery_sendto = mysqli_query($connect,$sql_sendto);
					While ($result_sendto = mysqli_fetch_array($dbquery_sendto)){
					$sql=	"insert into book_sendto_answer (send_level, ref_id, send_to) values ('3', '$_POST[ref_id]','$result_sendto[khet_code]')";
					$dbquery = mysqli_query($connect,$sql);

					}
			}
			else if($_POST['sendto']!='some'){
					$sql=	"insert into book_sendto_answer (send_level, ref_id, send_to) values ('2', '$_POST[ref_id]','$_POST[sendto]')";
					$dbquery = mysqli_query($connect,$sql);
			}
}			
} //end index4


//ส่วนแสดงผล
//if(!(($index==1) or ($index==2))){
if(!(($index==1) or ($index==2) or ($index==5))){

// อาเรย์ชื่อหน่วยงาาน
$office_name_ar['saraban']="สารบรรณกลาง";
$sql_work_group = mysqli_query($connect,"SELECT * FROM  system_department") ;
while ($row_work_group= mysqli_fetch_array($sql_work_group)){
$office_name_ar[$row_work_group['department']]=$row_work_group['department_name'];
}

$sql_work_group = mysqli_query($connect,"SELECT * FROM  system_department") ;
while ($row_work_group= mysqli_fetch_array($sql_work_group)){
$office_name_ar[$row_work_group['department']]=$row_work_group['department_name'];
}


$sql_sch = mysqli_query($connect,"SELECT * FROM  system_khet") ;
while ($row_sch= mysqli_fetch_array($sql_sch)){
$office_name_ar[$row_sch['khet_code']]=$row_sch['khet_precis'];
}

//อาเรย์กลุ่ม
$sql_subdepartment = "select  * from system_subdepartment ";
$dbquery_subdepartment = mysqli_query($connect,$sql_subdepartment);
While ($result_subdepartment = mysqli_fetch_array($dbquery_subdepartment))
   {
		$sub_department = $result_subdepartment['sub_department'];
		$sub_department_name = $result_subdepartment['sub_department_name'];
		$sub_department_ar[$sub_department]=$sub_department_name;
	}

//อาเรย์บุคลากรกลุ่ม
$sql_person= "select  * from person_main";
$dbquery_person= mysqli_query($connect,$sql_person);
While ($result_person = mysqli_fetch_array($dbquery_person))
   {
		$person_id = $result_person['person_id'];
		$person_prename = $result_person['prename'];
		$person_name = $result_person['name'];
		$person_surname = $result_person['surname'];
		$pname = "$person_prename$person_name  $person_surname";
		$personname_ar[$person_id]=$pname;
		
	}


$sql_person= "select  * from person_khet_main";
$dbquery_person= mysqli_query($connect,$sql_person);
While ($result_person = mysqli_fetch_array($dbquery_person))
   {
		$person_id = $result_person['person_id'];
		$person_prename = $result_person['prename'];
		$person_name = $result_person['name'];
		$person_surname = $result_person['surname'];
		$pname = "$person_prename$person_name  $person_surname";
		$personname_ar[$person_id]=$pname;
		
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

if(!isset($_REQUEST['department'])){
$_REQUEST['department']="";
}
if(!isset($_REQUEST['sub_department'])){
$_REQUEST['sub_department']="";
}
if(!isset($_REQUEST['khet_code'])){
$_REQUEST['khet_code']="";
}

//ส่วนของการแยกหน้า
 $perpage =15;
 if (isset($_GET['page'])) {
 $page = $_GET['page'];
 } else {
 $page = 1;
 }
 $start = ($page - 1) * $perpage;

	if($_SESSION['login_group']==1){
			if($_REQUEST['search_index']==1){	
					if($_REQUEST['sub_department']!=""){
					$sql="select * from book_main where book_type='1' and  $_REQUEST[field] like '%$_REQUEST[search]%' and office='$_REQUEST[sub_department]' order by ms_id DESC";
					}
					else{
					$sql="select * from book_main where book_type='1' and $_REQUEST[field] like '%$_REQUEST[search]%' order by ms_id DESC";
					}
			}
			else{
			$sql="select * from book_main where book_type='1' and office='$department' order by ms_id DESC";
			}
	$dbquery = mysqli_query($connect,$sql);
	$num_rows = mysqli_num_rows($dbquery);
	 $total_page = ceil($num_rows / $perpage);

	}
	else if($_SESSION['login_group']>=2){
			if($_REQUEST['search_index']==1){
			      if($_REQUEST['system_user_khet']!=""){

			       $sql="select * from book_main where book_type='2' and office='$khet_code' and  $_REQUEST[field] like '%$_REQUEST[search]%' order by ms_id DESC";
				  }else{
			$sql="select * from book_main where book_type='2' and office='$_SESSION[system_user_khet]' order by ms_id DESC";
			}
			}
			else{
			$sql="select * from book_main where book_type='2' and office='$_SESSION[system_user_khet]' order by ms_id DESC ";
			}
			$dbquery = mysqli_query($connect,$sql);
			$num_rows = mysqli_num_rows($dbquery);
 $total_page = ceil($num_rows / $perpage);
//echo $total_page;
	}
$url_link="index.php?option=book&task=main/send&search_index=$_REQUEST[search_index]&field=$_REQUEST[field]&search=$_REQUEST[search]&department=$_REQUEST[department]";  // 2_กำหนดลิงค์ฺ

?>
<div align="center">
  <nav>
 <ul class="pagination">
 <li>
<a href="<?php echo $url_link?>&page=1" aria-label="Previous">
 <span aria-hidden="true">&laquo;</span>
 </a>
 </li>
 <?php for($i=1;$i<=$total_page;$i++){ ?>
 <li><a href="<?php echo $url_link?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
 <?php } ?>
 <li>
 <a href="<?php echo $url_link?>&page=<?php echo $total_page;?>" aria-label="Next">
 <span aria-hidden="true">&raquo;</span>
 </a>
 </li>
 </ul>
 </nav>

<table border="0" width="98%" id="table1" style="border-collapse: collapse" cellspacing="2" cellpadding="2" align="center">
<tr><td><p><a href='?option=book&task=main/send&index=1' class='btn btn-primary'><span class='glyphicon glyphicon-plus'></span>&nbsp;ส่งหนังสือ</a>&nbsp;<font color='#ffff66'><span class='glyphicon glyphicon-envelope' aria-hidden='true'></span></font> ด่วน&nbsp;<font color='#ff9900'><span class='glyphicon glyphicon-envelope' aria-hidden='true'></span></font> ด่วนมาก&nbsp;<font color='#ff0000'><span class='glyphicon glyphicon-envelope' aria-hidden='true'></span></font> ด่วนที่สุด</p></td>

	<form method="POST" action="?option=book&task=main/send">
<td align="right">
				<p align="right"><font size="2">ค้นหาหนังสือ จาก 
				<select size="1" name="field">
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
				if($_REQUEST['field']=='signdate'){
				echo "<option value='signdate' selected>ลงวันที่</option>";
				}
				else{
				echo "<option value='signdate'>ลงวันที่</option>";
				}
				echo "</select>";
				
				echo "<font size='2'> ด้วยคำว่า ";
				echo "<input type='text' name='search' size='20' value='$_REQUEST[search]'>"; 
				echo "<input type='hidden' name='search_index' value='1'>";
				echo " <input type='submit' value='ค้นหา'>";
				
/////////////////////
if($_SESSION['login_group']==1){
echo "<td align='right'>";
	echo "<Select  name='department' size='1'>";
	echo  '<option value ="" >ทุกกลุ่ม(งาน)</option>' ;
						$sql = "SELECT *  FROM  system_department";
						$dbquery =mysqli_query($connect,$sql);
						While ($result = mysqli_fetch_array($dbquery))
							{ 
								if($_REQUEST['department']==$result['department']){
								echo "<option value='$result[department]' selected>$result[department_name]</option>"; 
								}
								else{
								echo "<option value='$result[department]'>$result[department_name]</option>"; 
								}
							}
	echo "</select>";
	echo " <input type='submit' value='เลือก'>";
echo "</td>";		
}			
/////////////////				
?>				
				</p>
			</td></form>
		</tr>
</table>


<div align='center'><table width='98%'><tr><td>
<table class="table table-striped table-bordered table-hover table-condensed">
<tr>
					<td align="center">
					<strong>ที่</strong></td>
					<td align="center">
					<strong>เลขหนังสือ</strong></td>
					<td align="center"><strong>เรื่อง</strong></td>
					<td align="center">
					<strong>รายละเอียด</strong></td>
					<td align="center">
					<strong>ลงวันที่</strong></td>
					<td align="center">
					<strong>วันเวลาที่ส่ง</strong></td>
					<td align="center">
					<strong>ผู้ส่ง</strong></td>
					<td align="center">
					<strong>ลบ</strong></td>
				</tr>
</form>

<?php
	if($_SESSION['login_group']==1){
			if($_REQUEST['search_index']==1){	
					if($_REQUEST['sub_department']!=""){
					$sql="select * from book_main where book_type='1'  and $_REQUEST[field] like '%$_REQUEST[search]%' and office='$_REQUEST[sub_department]' order by ms_id DESC   limit {$start} , {$perpage}";
					}
					else{
					$sql="select * from book_main where book_type='1'  and $_REQUEST[field] like '%$_REQUEST[search]%' order by ms_id  DESC   limit {$start} , {$perpage}";
					}
			}
			else{
			$sql="select * from book_main where book_type='1' and office='$department' order by ms_id  DESC  limit {$start} , {$perpage}";
			}
$dbquery = mysqli_query($connect,$sql);
			$num_rows = mysqli_num_rows($dbquery);
 $total_page = ceil($num_rows / $perpage);



	}
	else if($_SESSION['login_group']>=2){
			if($_REQUEST['search_index']==1){
					if($_REQUEST['system_user_khet']!=""){

			$sql="select * from book_main where book_type='2' and office='$_SESSION[system_user_khet]' and $_REQUEST[field] like '%$_REQUEST[search]%' order by ms_id DESC  limit {$start} , {$perpage}";
			}
			else{
			$sql="select * from book_main where book_type='2' and office='$_SESSION[system_user_khet]' order by ms_id  DESC limit {$start} , {$perpage}";
			}
			}
$dbquery = mysqli_query($connect,$sql);
		$num_rows = mysqli_num_rows($dbquery);
 $total_page = ceil($num_rows / $perpage);


	}

$N=(($page-1)*$perpage)+1; //*เกี่ยวข้องกับการแยกหน้า
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
			$color="#FFFFFF";
			else $color="#E5E5FF";
$send_date=thai_date_4($rec_date);
$signdate=thai_date_3($signdate);
// ระดับความสำคัญ
if ($level==1) {
	$img_level = "" ;
}else if ($level==2) {
	$img_level = "<font color='#ffff66'><span class='glyphicon glyphicon-envelope' aria-hidden='true'></span></font>" ;
}else if ($level==3) {
	$img_level = "<font color='#ff9900'><span class='glyphicon glyphicon-envelope' aria-hidden='true'></span></font>" ;
}else if ($level==4) {
	$img_level = "<font color='#ff0000'><span class='glyphicon glyphicon-envelope' aria-hidden='true'></span></font>" ;
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
	$file_img = "<FONT  color='#3399ff'><span class='glyphicon glyphicon-file' aria-hidden='true'></span></FONT>" ;
}

if($result['secret']==1){
$secret_txt="<font color='#FF0000'>[ลับ]";
}
else{
$secret_txt="";
}

?>
			<tr>
					<td align="center"><FONT size="2" ><?php echo $N;?></font></td>
					<td align="left">&nbsp;<FONT size="2" ><?php echo $book_no;?>&nbsp;<?php echo $img_level;?></font></td>
					<td align="left">&nbsp;<FONT size="2" ><?php echo $subject;?>&nbsp;<?php echo $file_img;?>&nbsp;<?php echo $secret_txt;?></font></td>
					<td align="center"><A HREF="javascript:void(0)"
onclick="window.open('modules/book/main/booksenddetail.php?b_id=<?php echo $id;?>',
'bookdetail','width=500,height=500,scrollbars')" title="คลิกเพื่อดูรายละเอียด"><span class='glyphicon glyphicon-list-alt' aria-hidden='true'></span></A></td>
					<td><FONT size="2" ><?php echo $signdate;?></font></td>
					<td><FONT size="2" ><?php echo $send_date;?></font></td>
					<td><FONT size="2" ><?php echo $office_name_ar[$office];?></font></td>
					<td width="27" align="center">
					<?php
					
//ตั้งค่าเวลาให้ลบได้					
$now=time();
$timestamp_recdate=make_time_2($rec_date);
$timestamp_recdate_2=$timestamp_recdate+86400;  //เพิ่มเวลา 24 ชั่วโมง
if($now<=$timestamp_recdate_2){
$delete=1;		//yes			
}
else {
$delete=2;    //no
}					
					if (($sender==$user) and ($delete==1)){
					echo "<a href=?option=book&task=main/send&index=2&id=$id&page=$page><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a></td>";
					}
					else{
					echo "</td>";
					}
					?>
			  </tr>
					<?php
	$M++;
	$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}  // end while	
echo "<tr><td colspan='8'>&nbsp;&nbsp;<FONT  color='#3399ff'><span class='glyphicon glyphicon-file' aria-hidden='true'></span></FONT> มีไฟล์เอกสาร</td></tr>";
echo "</table>";
echo "</td></tr></table></div>";

}  //end index

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=book&task=main/send");   // page ย้อนกลับ 
	}else if(val==1){
	var v2 = document.frm1.subject.value;
	var file1 = document.frm1.myfile1.value;
	var file2 = document.frm1.myfile2.value;
	var file3 = document.frm1.myfile3.value;
	var file4 = document.frm1.myfile4.value;
	var file5 = document.frm1.myfile5.value;
		
	var vdfile1 = document.frm1.dfile1.value;
	var vdfile2 = document.frm1.dfile2.value;
	var vdfile3 = document.frm1.dfile3.value;
	var vdfile4 = document.frm1.dfile4.value;
	var vdfile5 = document.frm1.dfile5.value;
	
		   if (document.frm1.book_no.value=="")
           {
          alert("กรุณากรอกเลขที่หนังสือ");
         	document.frm1.book_no.focus();    
           }	   
		   else if (v2.length==0)
           {
          alert("กรุณากรอกชื่อเรื่อง");
         	document.frm1.subject.focus();    
           }	   

		  //  else if ((file1!="") && (file1=="")) 
          // {
       //   alert("กรุณาเลือกไฟล์");
        //	document.frm1.myfile1.focus();    
      //     }
		   
		   else if ((file1!="") && (vdfile1=="")) 
           {
          alert("กรุณากรอก คำอธิบายไฟล์");
        	document.frm1.dfile1.focus();    
           }

		   else if ((file2 !="") && (vdfile2=="")) 
           {
          alert("กรุณากรอก คำอธิบายไฟล์");
      		 document.frm1.dfile2.focus();    
           }
		   
		   else if ((file3!="") && (vdfile3=="")) 
           {
          alert("กรุณากรอก คำอธิบายไฟล์");
       	   document.frm1.dfile3.focus();    
           }
		   
		   else if ((file4 !="") && (vdfile4=="")) 
           {
          alert("กรุณากรอก คำอธิบายไฟล์");
           document.frm1.dfile4.focus();    
           }
		   
		   else if ((file5!="") && (vdfile5=="")) 
           {
          alert("กรุณากรอก คำอธิบายไฟล์");
           document.frm1.dfile5.focus();    
           }
		   else{
			callfrm("?option=book&task=main/send&index=4");   //page ประมวลผล
			}
	}
}

</script>
