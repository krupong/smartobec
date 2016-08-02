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
<script type="text/javascript" src="../../../css/js/calendarDateInput2.js"></script> 
<?php
require_once "../../../database_connect.php";	
require_once("../../../mainfile.php");
date_default_timezone_set('Asia/Bangkok');
///////////////////////////////
$sync_ok=0;
$person_ok=0;
if(isset($_GET['sync_code'])){
			//ตรวจสอบการ Sync
			$sql = "select * from  system_sync where office_code='$_GET[office_code]' and sync_code='$_GET[sync_code]'";
			$dbquery = mysqli_query($connect,$sql);
			$result = mysqli_fetch_array($dbquery);
			if($result){
			$sync_ok=1;
			$_SESSION['bookobec_user_id']=$_GET['person'];
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
			$person_ok==1;
			}
			else{
			$sql_person = "select * from person_special_main where unit_code='$_GET[office_code]' and person_id='$_GET[person]' and status='0'";
			$dbquery_person = mysqli_query($connect,$sql_person);
			$result_person = mysqli_fetch_array($dbquery_person);
					if($result_person){
					$person_ok==1;
					}
					else{
					$sql_person = "select * from person_sch_main where school_code='$_GET[office_code]' and person_id='$_GET[person]' and status='0'";
					$dbquery_person = mysqli_query($connect,$sql_person);
					$result_person = mysqli_fetch_array($dbquery_person);
							if($result_person){
							$person_ok==1;
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

if(!isset($_REQUEST['index'])){
$index=1;
}
else{
$index=$_REQUEST['index'];
}

//ส่วนฟอร์มรับข้อมูล
if($index==1){
$timestamp = mktime(date("H"), date("i"),date("s"), date("m") ,date("d"), date("Y"))  ;	
//timestamp เวลาปัจจุบัน 
$rand_number=rand();
$ref_id = $timestamp."x".$rand_number;
$_SESSION ['ref_id'] = $ref_id ;

//////////////
$book_no="";
$subject="";
$sign_date="";
if(isset($_GET['book_no'])){
$book_no=$_GET['book_no'];
}
if(isset($_GET['subject'])){
$subject=$_GET['subject'];
}
if(isset($_GET['sign_date'])){
$sign_date=$_GET['sign_date'];
}
else{
$sign_date=date("Y-m-d");
}
/////////////

echo "<table width='900' border='0' align='center'><tr><td>";
echo "<form Enctype = multipart/form-data id='frm1' name='frm1'>";
echo "<Center>";
echo "<br>";
echo "<Font color='#006666' Size=3><B>ส่งหนังสือราชการ</b></font>";
echo "</Center>";
echo "<Br>";
echo "<table border='1' width='700' id='table1' style='border-collapse: collapse' bordercolor='#C0C0C0' align='center'>";
echo "<tr bgcolor='#003399'>";
echo "<td colspan='4' height='23' align='left'><font size='2' color='#FFFFFF'>&nbsp;กรุณาระบุรายละเอียด</font></td>";
echo "</tr>";

// **ผู้ส่งเป็นสพท
echo "<tr>";
echo "<td  align='right'><span lang='th'>จาก&nbsp;</span></td>";
echo "<td  colspan='3' align='left'>";
	$sql_school= "SELECT * FROM  system_khet where khet_code='$_SESSION[bookobec_user_office]'";
	$dbquery_school = mysqli_query($connect,$sql_school);
	$result_school = mysqli_fetch_array($dbquery_school);
	echo  "&nbsp;&nbsp;<input type='radio' name='department' value='$result_school[khet_code]' checked>&nbsp;$result_school[khet_precis]";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td  align='right'>ถึง&nbsp;</td>";
echo "<td colspan='3' align='left'>&nbsp;&nbsp;<input type='radio' value='saraban' name='sendto' checked>&nbsp;สารบรรณกลางสพฐ.";
echo "<br>&nbsp;&nbsp;<input type='radio' value='some' name='sendto' required onClick=\"window.open('select_send_5.php?sd_index=all','PopUp','width=700,height=600,scrollbars,status'); \">&nbsp;สำนักใน สพฐ.";
echo "<br>&nbsp;&nbsp;<input type='radio' value='some' name='sendto' required onClick=\"window.open('select_send.php?sd_index=some','PopUp','width=700,height=600,scrollbars,status'); \">&nbsp;สพท.บางแห่ง";
echo "</td></tr>";

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
echo "<td align='right'><span lang='th'>เลขที่หนังสือ&nbsp;</span></td><td colspan='2'>&nbsp;<input type='text' name='book_no' size='15' value='$book_no'  style='background-color: #99ccff'></td></tr><tr>";
echo "<td  align='right'>ลงวันที่</td><td colspan='2'>";
?>
<script>
DateInput('signdate', true, 'YYYY-MM-DD','<?php echo $sign_date ?>')
</script>
<?php
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td align='right'><span lang='th'>เรื่อง&nbsp;</span></td>";
echo "<td colspan='3' align='left'>&nbsp;<input type='text' name='subject' size='76'  style='background-color: #99ccff' value='$subject'></td>";
echo "</tr>";

echo "<tr>";
echo "<td width='94' align='right' height='47'><span lang='th'><font size='2' color='#0000FF'>เนื้อหาโดยสรุป&nbsp;</font></span></td>";
echo "<td height='47' width='514' colspan='3'  align='left'>&nbsp;<textarea rows='5' name='detail' cols='55'  style='background-color: #99ccff' ></textarea></td>";
echo "</tr>";

echo "<tr>";
echo "<td  align='center' colspan='3'><b> แนบไฟล์ (ถ้ามี) </b> </td>";
echo "</tr>";

echo "<tr>";
echo "<td align='right'>ไฟล์แนบ 1&nbsp;</td>";
echo "<td ><input type='file' name='myfile1' size='26' style='background-color: #99ccff'></td>";
echo "<td  align='center' colspan='2'><input type='text' name='dfile1' size='31'  style='background-color: #E5E5FF'></td>";
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
echo "<input name='person' type='hidden' value='$_SESSION[bookobec_user_id]'>";
echo "<tr>";
echo "<td align='center' colspan='4'><BR><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)'>&nbsp;&nbsp;<input type='reset' value='Reset' name='reset'></td>";
echo "</tr>";
echo "</Table>";
echo "</form>";
echo "</td></td></table>";
}

//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง<br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=book&task=xml/send_bookobec&index=3&id=$_GET[id]&page=$_REQUEST[page]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=book&task=xml/send_bookobec&page=$_REQUEST[page]\"'";
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
	$path_file="modules/book/upload_files/".$file;
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

if($_POST['sendto']=="" || $_POST['subject']=="" ||$_POST['detail'] ==""){
	echo "<CENTER><font size=\"2\" color=\"#008000\">กรอกข้อมูลไม่ครบ<br><br>";
	echo "<input type=\"button\" value=\"แก้ไขข้อมูล\" onClick=\"javascript:history.go(-1)\" ></CENTER>" ;
	exit(); 
} #จบ

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

//ตรวจสอบว่ามีผู้รับหรือยัง 
// ***
$sql_send_num = mysqli_query($connect,"SELECT * FROM book_sendto_answer WHERE ref_id='$_POST[ref_id]' ") ;
$send_num = mysqli_num_rows ($sql_send_num) ;
if($send_num==0 and $_POST['sendto']=='some') {
echo "<div align='center'>";
echo "<B><FONT SIZE=2 COLOR=#990000>ยังไม่ได้ระบุผู้รับหนังสือ</B><BR><BR>" ;
 echo "&nbsp;&nbsp;&nbsp;<input type=\"button\" value=\"&nbsp;&nbsp;แก้ไข&nbsp;&nbsp;\" onClick=\"javascript:history.go(-1)\" ></CENTER>" ;
echo "</div>";
exit() ;
}

//ส่วนการบันทึก
$day_now=date("Y-m-d H:i:s");
$book_type=2;  //ผู้ส่งคือสพท

//ตรวจสอบ ref_id
if($_POST['ref_id']==""){
echo "<script>alert('มีข้อผิดพลาดเกี่ยวกับเลขอ้างอิงในระบบ ยกเลิกการส่งหนังสือในครั้งนี้ กรุณาส่งใหม่อีกครั้ง'); document.location.href='?option=book&task=xml/send_bookobec&index=1';</script>";
exit();
} 

$sql = "insert into book_main (book_type, office, sender, level, secret, book_no, signdate, subject, detail, ref_id, send_date) values ('$book_type', $_POST[department], '$_SESSION[bookobec_user_id]', '$_POST[level]', '$_POST[secret]', '$_POST[book_no]', '$_POST[signdate]','$_POST[subject]','$_POST[detail]','$_POST[ref_id]','$day_now')";
$dbquery = mysqli_query($connect,$sql);

if ($myfile1<>"" ) {
$myfile1name=$_POST['ref_id']."_1.".$lastname1 ; 
copy ($myfile1, "../../../upload/book/upload_files/".$myfile1name)  ; 

$sql = "insert into book_filebook (ref_id, file_name, file_des) values ('$_POST[ref_id]','$myfile1name','$dfile1')";
$dbquery = mysqli_query($connect,$sql);

unlink ($myfile1) ;
}

if ($myfile2<>"") {
$myfile2name=$_POST['ref_id']."_2.".$lastname2 ; 
copy ($myfile2, "../../../upload/book/upload_files/".$myfile2name)  ; 
$sql = "insert into book_filebook (ref_id, file_name, file_des) values ('$_POST[ref_id]','$myfile2name','$dfile2')";
$dbquery = mysqli_query($connect,$sql);
unlink ($myfile2) ;
}

if ($myfile3<>"") {
$myfile3name=$_POST['ref_id']."_3.".$lastname3 ; 
copy ($myfile3, "../../../upload/book/upload_files/".$myfile3name)  ; 
$sql = "insert into book_filebook (ref_id, file_name, file_des) values ('$_POST[ref_id]','$myfile3name','$dfile3')";
$dbquery = mysqli_query($connect,$sql);
unlink ($myfile3) ;
}

if ($myfile4<>"") {
$myfile4name=$_POST['ref_id']."_4.".$lastname4 ; 
copy ($myfile4, "../../../upload/book/upload_files/".$myfile4name)  ; 
$sql = "insert into book_filebook (ref_id, file_name, file_des) values ('$_POST[ref_id]','$myfile4name','$dfile4')";
$dbquery = mysqli_query($connect,$sql);
unlink ($myfile4) ;
}

if ($myfile5<>"") {
$myfile5name=$_POST['ref_id']."_5.".$lastname5 ; 
copy ($myfile5, "../../../upload/book/upload_files/".$myfile5name)  ; 
$sql = "insert into book_filebook (ref_id, file_name, file_des) values ('$_POST[ref_id]','$myfile5name','$dfile5')";
$dbquery = mysqli_query($connect,$sql);
unlink ($myfile5) ;
}

			//สำหรับส่งสารบรรณสพฐ.
			if($_POST['sendto']!='some'){
			$sql=	"insert into book_sendto_answer (send_level, ref_id, send_to) values ('2', '$_POST[ref_id]','$_POST[sendto]')";
			$dbquery = mysqli_query($connect,$sql);
			}
			//
echo "<br><br>";			
echo "<div align='center'>ส่งหนังสือเรียบร้อยแล้ว</div>";
} //end index4
?>

<script>
function callfrm(dest)
	{
		frm1.target = "_self"
		frm1.action = dest
		frm1.method = "POST"
		frm1.submit()
	}	

function goto_url(val){
	if(val==0){
		callfrm("?option=book&task=xml/send_bookobec");   // page ย้อนกลับ 
	}else if(val==1){
	var v2 = document.frm1.subject.value;
	var v3 = document.frm1.detail.value;
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

		   else if (v3.length==0)
           {
          alert("กรุณากรอกเนื้อหาโดยสรุป");
         	document.frm1.detail.focus();    
           }	   
		   
		   else if (file1=="") 
           {
          alert("กรุณาเลือกไฟล์");
        	document.frm1.myfile1.focus();    
           }
		   
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
			callfrm("?option=book&task=xml/send_bookobec&index=4");   //page ประมวลผล
			}
	}
}

</script>
