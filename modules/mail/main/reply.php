<?php 
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );


if(isset($_REQUEST['person_id'])){
	$person_id=$_REQUEST['person_id'];
}else{
	$person_id="";
}

if(isset($_REQUEST['switch_index'])){
	$switch_index=$_REQUEST['switch_index'];
}else{
	$switch_index="";
}


if(!isset($_POST['sendto'])){
$_POST['sendto']="";
}

if(!isset($_POST['subject'])){
$_POST['subject']="";
}

if(!isset($_POST['detail'])){
$_POST['detail']="";
}

$upfile1 ="";
$sizelimit1 ="";
$upfile2 ="";
$sizelimit2 ="";
$upfile3 ="";
$sizelimit3 ="";
$upfile4 ="";
$sizelimit4 ="";
$upfile5 ="";
$sizelimit5 ="";

if(!($_SESSION['login_group']==1)){
exit();
}
require_once "modules/mail/time_inc.php";	
$user=$_SESSION['login_user_id'];

//ส่วนหัว
echo "<br />";
echo "<div class='container padding'>";
if(!(($index==1) or ($index==2) or ($index==7))){

}

//ส่วนฟอร์มรับข้อมูล
if($index==1){

if(isset($_POST['resender'])){
$postresender=mysqli_real_escape_string($connect,$_POST['resender']);
}else {$postresender="";}
    
if(isset($_POST['redetail'])){
$postredetail=mysqli_real_escape_string($connect,$_POST['redetail']);
}else {$postredetail="";}
    
if(isset($_POST['rerec_date'])){
$postrerec_date=mysqli_real_escape_string($connect,$_POST['rerec_date']);
}else {$postrerec_date="";}
$postrerec_date=ThaiTimeConvert(strtotime($postrerec_date),"","2");    
        
if(isset($_POST['resubject'])){
$postresubject=mysqli_real_escape_string($connect,$_POST['resubject']);
}else {$postresubject="";}
    
		$query_person=mysqli_query($connect,"SELECT * FROM  person_main WHERE person_id='$postresender' ") ;
		$result_person=mysqli_fetch_array($query_person);
		$prename=$result_person['prename'];
		$name= $result_person['name'];
		$surname = $result_person['surname'];
    
  		$full_name="$prename$name&nbsp;&nbsp;$surname";
    
    $postredetail="[ตอบกลับ:".$full_name." เรื่อง:".$postresubject." ข้อความ:".$postredetail." เมื่อ:".$postrerec_date."] &#10;";    
  
    
$timestamp = mktime(date("H"), date("i"),date("s"), date("m") ,date("d"), date("Y"))  ;	
//timestamp เวลาปัจจุบัน 
$ref_id = $user.$timestamp ;
$_SESSION ['ref_id'] = $ref_id ;

echo "<form Enctype = multipart/form-data id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>ตอบกลับจดหมาย</Font>";
echo "</Cener>";
echo "<Br>";
echo "<table border='1' width='700' id='table1' class='table table-striped table-bordered table-hover' style='border-collapse: collapse' bordercolor='#C0C0C0'>";
echo "<tr bgcolor='#FFFFCC'>";
echo "<td colspan='4' height='23' align='left'><font size='2' color='#0000FF'>&nbsp;กรุณาระบุรายละเอียด</font></td>";
echo "</tr>";
echo "<tr>";
echo "<td class='col-sm' align='right'><font size='2' color='#0000FF'>ถึง&nbsp;</font></span></td>";
echo "<td colspan='3' align='left'>&nbsp;&nbsp;$full_name";
echo "</td></tr>";

echo "<tr>";
echo "<td class='col-sm' align='right'><span lang='th'><font size='2' color='#0000FF'>เรื่อง&nbsp;</font></span></td>";
echo "<td width='514' colspan='3' align='left'>&nbsp;<input type='text' name='subject' size='76'  style='background-color: #FFFFCC' value='[ตอบกลับ]$postresubject'></td>";
echo "</tr>";

echo "<tr>";
echo "<td class='col-sm' align='right' height='47'><span lang='th'><font size='2' color='#0000FF'>ข้อความ&nbsp;</font></span></td>";
echo "<td height='47' width='514' colspan='3'  align='left'>&nbsp;<textarea rows='10' name='detail' cols='55'  style='background-color: #FFFFCC'>$postredetail</textarea></td>";
echo "</tr>";

echo "<tr>";
echo "<td class='col-sm' align='right' colspan='2'><p align='center'><font size='2' color='#800000'>แนบไฟล์(ถ้ามี)</font></td>";
echo "<td class='col-sm' align='center' colspan='2'><p align='center'><font size='2' color='#800000'>คำอธิบายไฟล์</font></td>";
echo "</tr>";

echo "<tr>";
echo "<td class='col-sm' align='right'><font size='2' color='#0000FF'>ไฟล์แนบ 1&nbsp;</font></td>";
echo "<td class='col-xs ' ><input type='file' name='myfile1' size='26' style='background-color: #99ccff'></td>";
echo "<td class='col-sm' align='left' colspan='2'><input type='text' name='dfile1' size='31' style='background-color: #BBD1FF'></td>";
echo "</tr>";

echo "<tr>";
echo "<td class='col-sm' align='right'><font size='2' color='#0000FF'>ไฟล์แนบ 2&nbsp;</font></td>";
echo "<td class='col-xs'><input type='file' name='myfile2' size='26' style='background-color: #99ccff'> </td>";
echo "<td class='col-sm' align='left' colspan='2'><input type='text' name='dfile2' size='31' style='background-color: #BBD1FF'></td>";
echo "</tr>";

echo "<tr>";
echo "<td class='col-sm' align='right'><font size='2' color='#0000FF'>ไฟล์แนบ 3&nbsp;</font></td>";
echo "<td class='col-xs'><input type='file' name='myfile3' size='26' style='background-color: #99ccff'> </td>";
echo "<td class='col-sm' align='left' colspan='2'><input type='text' name='dfile3' size='31' style='background-color: #BBD1FF'></td>";
echo "</tr>";

echo "<tr>";
echo "<td class='col-sm' align='right'><font size='2' color='#0000FF'>ไฟล์แนบ 4&nbsp;</font></td>";
echo "<td class='col-xs'><input type='file' name='myfile4' size='26' style='background-color: #99ccff'> </td>";
echo "<td class='col-sm' align='left' colspan='2'><input type='text' name='dfile4' size='31' style='background-color: #BBD1FF'></td>";
echo "</tr>";

echo "<tr>";
echo "<td class='col-sm' align='right'><font size='2' color='#0000FF'>ไฟล์แนบ 5&nbsp;</font></td>";
echo "<td class='col-xs'><input type='file' name='myfile5' size='26' style='background-color: #99ccff'> </td>";
echo "<td class='col-sm' align='left' colspan='2'><input type='text' name='dfile5' size='31' style='background-color: #BBD1FF'></td>";
echo "</tr>";

echo "<tr>";
echo "<td align='center' colspan='4'><FONT SIZE='2' COLOR='#CC9900'>เฉพาะไฟล์ doc, pdf, xls, gif, jpg, zip, rar เท่านั้น</FONT></td>";
echo "</tr>";
echo "<input name='ref_id' type='hidden' value='$ref_id'>";
echo "<input name='sendto' type='hidden' value='$postresender'>";
echo "<tr>";
echo "<td align='center' colspan='4'><BR><INPUT TYPE='button' class='btn btn-primary' name='smb' value='ตกลง' onclick='goto_url(1)'>&nbsp;&nbsp;<input type='reset' class='btn btn-default' value='Reset' name='reset'></td>";
echo "</tr>";
echo "</Table>";
echo "</form>";
}


//ส่วนบันทึกข้อมูล
if($index==4){
$sizelimit = 20000*1024 ;  //ขนาดไฟล์ที่ให้แนบ 9 Mb.
$subject = $_POST ['subject'] ;
$detail = $_POST ['detail'] ;
$dfile1 = $_POST ['dfile1'] ;
$dfile2 = $_POST ['dfile2'] ;
$dfile3 = $_POST ['dfile3'] ;
$dfile4 = $_POST ['dfile4'] ;
$dfile5 = $_POST ['dfile5'] ;

$dfile5 = $_POST ['dfile5'] ;
    
if(isset($_POST['ref_id'])){
$postref_id=mysqli_real_escape_string($connect,$_POST['ref_id']);
}else {$postref_id="";}
if(isset($_POST['sendto'])){
$postsendto=mysqli_real_escape_string($connect,$_POST['sendto']);
}else {$postsendto="";}

/// file
$myfile1 = $_FILES ['myfile1'] ['tmp_name'] ;
$myfile1_name = $_FILES ['myfile1'] ['name'] ;
$myfile1_size = $_FILES ['myfile1'] ['size'] ;
$myfile1_type = $_FILES ['myfile1'] ['type'] ;

 $array_last1 = explode("." ,$myfile1_name) ;
 $c1 =count ($array_last1) - 1 ;
 $lastname1 = strtolower ($array_last1 [$c1] ) ;

 if  ($myfile1<>"") {
 if ($lastname1 =="doc" or $lastname1 =="docx" or $lastname1 =="rar" or $lastname1 =="pdf" or $lastname1 =="xls" or $lastname1 =="xlsx" or $lastname1 =="zip" or $lastname1 =="jpg" or $lastname1 =="gif"  or $lastname1 =="png" ) { 
	 $upfile1 = "" ; 
  }else {
	 $upfile1 = "-ไม่อนุญาตให้ทำการแนบไฟล์ $myfile1_name<BR> " ;
  } 

  If ($myfile1_size>$sizelimit) {
	  $sizelimit1 = "-ไฟล์ $myfile1_name มีขนาดใหญ่กว่าที่กำหนด<BR>" ;
  }else {
		$sizelimit1 = "" ;
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
 if ($lastname2 =="doc" or $lastname2 =="docx" or $lastname2 =="rar" or $lastname2 =="pdf" or $lastname2 =="xls" or $lastname2 =="xlsx" or $lastname2 =="zip" or $lastname2 =="jpg" or $lastname2 =="gif" or $lastname2 =="png") { 
	 $upfile2 = "" ; 
  }else {
	 $upfile2 = "-ไม่อนุญาตให้ทำการแนบไฟล์ $myfile2_name<BR> " ;
  } 

  If ($myfile2_size>$sizelimit) {
	  $sizelimit2 = "-ไฟล์ $myfile2_name มีขนาดใหญ่กว่าที่กำหนด<BR>" ;
  }else {
		$sizelimit2 = "" ;
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
 if ($lastname3 =="doc" or $lastname3 =="docx" or $lastname3 =="rar" or $lastname3 =="pdf" or $lastname3 =="xls" or $lastname3 =="xlsx" or $lastname3 =="zip" or $lastname3 =="jpg" or $lastname3 =="gif" or $lastname3 =="png") { 
	 $upfile3 = "" ; 
  }else {
	 $upfile3 = "-ไม่อนุญาตให้ทำการแนบไฟล์ $myfile3_name <BR>" ;
  } 

  If ($myfile3_size>$sizelimit) {
	  $sizelimit3 = "-ไฟล์ $myfile3_name มีขนาดใหญ่กว่าที่กำหนด<BR>" ;
  }else {
		$sizelimit3 = "" ;
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
 if ($lastname4 =="doc" or $lastname4 =="docx" or $lastname4 =="rar" or $lastname4 =="pdf" or $lastname4 =="xls" or $lastname4 =="xlsx" or $lastname4 =="zip" or $lastname4 =="jpg" or $lastname4 =="gif" or $lastname4 =="png") { 
	 $upfile4 = "" ; 
  }else {
	 $upfile4 = "-ไม่อนุญาตให้ทำการแนบไฟล์ $myfile4_name<BR> " ;
  } 

  If ($myfile4_size>$sizelimit) {
	  $sizelimit4 = "-ไฟล์ $myfile4_name มีขนาดใหญ่กว่าที่กำหนด<BR>" ;
  }else {
		$sizelimit4 = "" ;
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
 if ($lastname5 =="doc" or $lastname5 =="docx" or $lastname5 =="rar" or $lastname5 =="pdf" or $lastname5 =="xls" or $lastname5 =="xlsx" or $lastname5 =="zip" or $lastname5 =="jpg" or $lastname5 =="gif"  or $lastname5 =="png") { 
	 $upfile5 = "" ; 
  }else {
	 $upfile5 = "-ไม่อนุญาตให้ทำการแนบไฟล์ $myfile5_name<BR> " ;
  } 

  If ($myfile5_size>$sizelimit) {
	  $sizelimit5 = "-ไฟล์ $myfile5_name มีขนาดใหญ่กว่าที่กำหนด<BR>" ;
  }else {
		$sizelimit5 = "" ;
  }
  }
  ####
////


if($_POST['sendto']=="" || $_POST['subject']=="" ||$_POST['detail'] ==""){
	echo "<CENTER><font size=\"2\" color=\"#008000\">กรุณากรอกข้อมูลให้ครบ<br><br>";
	echo "<input type=\"button\" value=\"แก้ไขข้อมูล\" onClick=\"javascript:history.go(-1)\" ></CENTER>" ;
	exit(); 
} #จบ


// check file size  file name
if ($upfile1<> "" || $sizelimit1<> "" ||  $upfile2<> "" || $sizelimit2<> "" || $upfile3<> "" || $sizelimit3<> "" || $upfile4<> "" || $sizelimit4<> "" || $upfile5<> "" || $sizelimit5<> "") {

echo "<B><FONT SIZE=2 COLOR=#990000>มีข้อผิดพลาดเกี่ยวกับไฟล์ของคุณ ดังรายละเอียด</FONT></B><BR>" ;
echo "<FONT SIZE=2 COLOR=#990099>" ;
 echo  $upfile1 ;
 echo  $sizelimit1 ;
 echo  $upfile2 ;
 echo  $sizelimit2 ;
 echo  $upfile3 ;
 echo  $sizelimit3 ;
 echo  $upfile4 ;
 echo  $sizelimit4 ;
 echo  $upfile5 ;
 echo  $sizelimit5 ;
 echo "</FONT>" ;
 echo "&nbsp;&nbsp;&nbsp;<input type=\"button\" value=\"&nbsp;&nbsp;แก้ไข&nbsp;&nbsp;\" onClick=\"javascript:history.go(-1)\" ></CENTER>" ;
exit () ;
}

mysqli_query($connect,"INSERT INTO mail_sendto_answer (send_to,ref_id) Values('$postsendto','$postref_id') ") ;
    
//ตรวจสอบว่ามีผู้รับหรือยัง
$sql_send_num = mysqli_query($connect,"SELECT * FROM mail_sendto_answer WHERE ref_id='$_POST[ref_id]' ") ;
$send_num = mysqli_num_rows ($sql_send_num) ;
if ($send_num==0 and $_POST['sendto']!='all') {
echo "<br><br>";
echo "<div align='center'>";
echo "<B><FONT SIZE=2 COLOR=#990000>ยังไม่ได้ระบุผู้รับจดหมาย</FONT></B><BR><BR>" ;
 echo "&nbsp;&nbsp;&nbsp;<input type=\"button\" value=\"&nbsp;&nbsp;แก้ไข&nbsp;&nbsp;\" onClick=\"javascript:history.go(-1)\" ></CENTER>" ;
echo "</div>";
exit () ;
}

$day_now=date("Y-m-d H:i:s");

//ตรวจสอบ ref_id
if(!isset($_POST['ref_id'])){
echo "<script>alert('มีข้อผิดพลาดเกี่ยวกับเลขอ้างอิงในระบบ ยกเลิกการเขียนจดหมายในครั้งนี้ กรุณาเขียนใหม่อีกครั้ง'); document.location.href='?option=mail&task=main/send&index=1';</script>";
exit();
} 
if($_POST['ref_id']==""){
echo "<script>alert('มีข้อผิดพลาดเกี่ยวกับเลขอ้างอิงในระบบ ยกเลิกการเขียนจดหมายในครั้งนี้ กรุณาเขียนใหม่อีกครั้ง'); document.location.href='?option=mail&task=main/send&index=1';</script>";
exit();
} 

$sql = "insert into mail_main (sender, subject, detail, ref_id, send_date) values ('$user', '$_POST[subject]','$_POST[detail]','$_POST[ref_id]','$day_now')";
$dbquery = mysqli_query($connect,$sql);

if ($myfile1<>"" ) {
$myfile1name=$_POST['ref_id']."_1.".$lastname1 ; 
copy ($myfile1, "upload/mail/upload_files/".$myfile1name)  ; 

$sql = "insert into mail_filebook (ref_id, file_name, file_des) values ('$_POST[ref_id]','$myfile1name','$dfile1')";
$dbquery = mysqli_query($connect,$sql);

unlink ($myfile1) ;
}

if ($myfile2<>"") {
$myfile2name=$_POST['ref_id']."_2.".$lastname2 ; 
copy ($myfile2, "upload/mail/upload_files/".$myfile2name)  ; 
$sql = "insert into mail_filebook (ref_id, file_name, file_des) values ('$_POST[ref_id]','$myfile2name','$dfile2')";
$dbquery = mysqli_query($connect,$sql);
unlink ($myfile2) ;
}

if ($myfile3<>"") {
$myfile3name=$_POST['ref_id']."_3.".$lastname3 ; 
copy ($myfile3, "upload/mail/upload_files/".$myfile3name)  ; 
$sql = "insert into mail_filebook (ref_id, file_name, file_des) values ('$_POST[ref_id]','$myfile3name','$dfile3')";
$dbquery = mysqli_query($connect,$sql);
unlink ($myfile3) ;
}

if ($myfile4<>"") {
$myfile4name=$_POST['ref_id']."_4.".$lastname4 ; 
copy ($myfile4, "upload/mail/upload_files/".$myfile4name)  ; 
$sql = "insert into mail_filebook (ref_id, file_name, file_des) values ('$_POST[ref_id]','$myfile4name','$dfile4')";
$dbquery = mysqli_query($connect,$sql);
unlink ($myfile4) ;
}

if ($myfile5<>"") {
$myfile5name=$_POST['ref_id']."_5.".$lastname5 ; 
copy ($myfile5, "upload/mail/upload_files/".$myfile5name)  ; 
$sql = "insert into mail_filebook (ref_id, file_name, file_des) values ('$_POST[ref_id]','$myfile5name','$dfile5')";
$dbquery = mysqli_query($connect,$sql);
unlink ($myfile5) ;
}
	// Select send name for Smart Push
	$sqlsendname = "SELECT * FROM person_main WHERE person_id = '".$user."'";
	$resultsendname = mysqli_query($connect, $sqlsendname);
	$rowsendname = $resultsendname->fetch_assoc();
	$sendname = $rowsendname["prename"].$rowsendname["name"]." ".$rowsendname["surname"]; 
	if($_POST['sendto']=='all') { 
	$sql_sendto = "select person_id from person_main where status='0' and person_id!='$user' ";
	$dbquery_sendto = mysqli_query($connect,$sql_sendto);
			While ($result_sendto = mysqli_fetch_array($dbquery_sendto)){
			$sql=	"insert into mail_sendto_answer (ref_id, send_to) values ('$_POST[ref_id]','$result_sendto[person_id]')";
			$dbquery = mysqli_query($connect,$sql);
			// Smart Push
			$message = "มีจดหมายจาก ".$sendname." : เรื่อง".$detail;
            $mytitle = "จดหมายจาก ".$sendname;
            $mymessage = "เรื่อง".$subject." : ".$detail;   
			//smartpush($result_sendto['person_id'],'mail',$message,"ไปรษณีย์");
              smartpush($result_sendto['person_id'],'mail',$mymessage,$mytitle);  
			}
	}
	$sqlsendto = "select * from mail_sendto_answer where ref_id = '".$_POST['ref_id']."'";
	//echo "select * from mail_sendto_answer where ref_id = '".$_POST['ref_id']."'";	
	if($resultsendto = mysqli_query($connect, $sqlsendto)){
		while ($rowsendto = $resultsendto->fetch_assoc()) {
			// Smart Push
			$message = "มีจดหมายจาก ".$sendname." : เรื่อง".$detail;
			//echo "to:".$rowsendto['send_to']." message:".$message;
			//smartpush($rowsendto['send_to'],'mail',$message,"ไปรษณีย์");
            $mytitle = "จดหมายจาก ".$sendname;
             $mymessage = "เรื่อง".$subject." : ".$detail;   
			smartpush($rowsendto['send_to'],'mail',$mymessage,$mytitle);
		}
	}
    echo "<script>document.location.href='?option=mail&task=main/send'; </script>\n";

} //end index4

?>
</div>
<script>
function goto_url(val){
    if(val==1){
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

          if (v2.length==0)
           {
          alert("กรุณากรอกชื่อเรื่อง");
         	document.frm1.subject.focus();    
           }

		   else if (v3.length==0)
           {
          alert("กรุณากรอกรายละเอียด");
         	document.frm1.detail.focus();    
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
		callfrm("?option=mail&task=main/reply&index=4");   //page ประมวลผล
		}
	}
}
</script>
