<script type="text/javascript" src="./css/js/calendarDateInput2.js"></script> 

<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

require_once "modules/book/time_inc.php";	
$user=$_SESSION['login_user_id'];

$sql="select * from bookregister_send_sch where ms_id='$_GET[id]' "; 
$dbquery = mysqli_query($connect,$sql);
$result_ref = mysqli_fetch_array($dbquery);

$_SESSION ['ref_id_2'] = $result_ref['ref_id'];

echo "<br />";
//ส่วนฟอร์มรับข้อมูล
if($index==1){

echo "<form Enctype = multipart/form-data id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>ส่งหนังสือราชการ</Font>";
echo "</Cener>";
echo "<Br>";
echo "<table border='1' width='700' id='table1' style='border-collapse: collapse' bordercolor='#C0C0C0'>";
echo "<tr bgcolor='#003399'>";
echo "<td colspan='4' height='23' align='left'><font size='2' color='#FFFFFF'>&nbsp;กรุณาระบุรายละเอียด</font></td>";
echo "</tr>";

// **ผู้ส่งเป็นสถานศึกษา
if(($_SESSION['login_status']>10) and ($_SESSION['login_status']<=14)){
echo "<tr>";
echo "<td width='94' align='right'><span lang='th'><font size='2' color='#0000FF'>จาก&nbsp;</font></span></td>";
echo "<td width='514' colspan='3' align='left'>";

	$sql_school= "select * from system_school where school_code='$_SESSION[user_school]' ";
	$dbquery_school = mysqli_query($connect,$sql_school);
	$result_school = mysqli_fetch_array($dbquery_school);
	echo  "&nbsp;&nbsp;<input type='radio' name='workgroup' value='$result_school[school_code]' checked>&nbsp;$result_school[school_name]";
	
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td width='94' align='right'><font size='2' color='#0000FF'>ถึง&nbsp;</font></span></td>";
echo "<td colspan='3' align='left'>&nbsp;&nbsp;<input type='radio' value='saraban' name='sendto'>&nbsp;สารบรรณกลาง$_SESSION[office_name]";

	$sql_workgroup= "select * from system_workgroup";
	$dbquery_workgroup = mysqli_query($connect,$sql_workgroup);
	While ($result_workgroup = mysqli_fetch_array($dbquery_workgroup)){
	echo  "<br>&nbsp;&nbsp;<input type='radio'  name='sendto' value='$result_workgroup[workgroup]'>&nbsp;$result_workgroup[workgroup_desc]";
	}

echo "<br>&nbsp;&nbsp;<input type='radio' value='all' name='sendto'>&nbsp;สถานศึกษารัฐบาลทุกแห่ง";

echo "<br>&nbsp;&nbsp;<input type='radio' value='some' name='sendto' onClick=\"window.open('modules/book/main/select_send_2.php?sd_index=some','PopUp','width=700,height=600,scrollbars,status'); \">&nbsp;สถานศึกษาบางแห่ง";
echo "</td></tr>";
}  //end **


echo "<tr>";
echo "<td align='right'><span lang='th'><font size='2' color='#0000FF'>ระดับความสำคัญ&nbsp;</font></span></td>";
echo "<td colspan='3' align='left'>&nbsp;<input type='radio' name='level' value='1' checked><font size='2' color='#006600'>ปกติ</font><span lang='en-us'><font size='2'>&nbsp;
			</font><input type='radio' name='level' value='2'></span><font size='2'><font color='#780634'>ด่วน</font>&nbsp;
			</font><input type='radio' name='level' value='3'><font size='2'><font color='#993300'>ด่วนมาก</font>&nbsp;
			</font><input type='radio' name='level' value='4'><font size='2' color='#FF0000'>ด่วนที่สุด</font></td>";
echo "</tr>";

if($result_ref['secret']==1){
$check_0="";
$check_1="checked";
}
else{
$check_0="checked";
$check_1="";
}

echo "<tr>";
echo "<td align='right'><span lang='th'><font size='2' color='#0000FF'>ความลับ&nbsp;</font></span></td>";
echo "<td colspan='3' align='left'>&nbsp;<input type='radio' name='secret' value='0' $check_0><font size='2' color='#006600'>ไม่ลับ</font><span lang='en-us'><font size='2'>&nbsp;
			</font><input type='radio' name='secret' value='1' $check_1><font size='2' color='#FF0000'>ลับ</font></td>";
echo "</tr>";

echo "<tr>";
echo "<td align='right'><span lang='th'><font size='2' color='#0000FF'>เลขที่หนังสือ&nbsp;</font></span></td><td>&nbsp;<FONT SIZE='2' COLOR=''></FONT><input type='text' name='book_no' size='20' value='$result_ref[book_no]'  style='background-color: #99ccff'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ลงวันที่</td>";
echo "<td colspan='2' align='left'>";

$f_date=explode("-", $result_ref['signdate']);
$y_year=$f_date[0];
$m_year=$f_date[1];
$d_year=$f_date[2];
?>
<script>
var Y_date 
var y_year=<?php echo $y_year;?> 
var m_year=<?php echo $m_year;?> 
var d_year=<?php echo $d_year;?> 
Y_date= y_year+'/'+m_year+'/'+d_year
DateInput('signdate', true, 'YYYY-MM-DD' ,Y_date)
</script>

<?php
echo "</td>";
echo "</tr>";


echo "<tr>";
echo "<td align='right'><span lang='th'><font size='2' color='#0000FF'>เรื่อง&nbsp;</font></span></td>";
echo "<td colspan='3' align='left'>&nbsp;<input type='text' name='subject' size='76'  style='background-color: #99ccff' value='$result_ref[subject]'></td>";
echo "</tr>";

echo "<tr>";
echo "<td width='94' align='right' height='47'><span lang='th'><font size='2' color='#0000FF'>เนื้อหาโดยสรุป&nbsp;</font></span></td>";
echo "<td height='47' width='514' colspan='3'  align='left'>&nbsp;<textarea rows='5' name='detail' cols='55'  style='background-color: #99ccff' ></textarea></td>";
echo "</tr>";

$sql = "select * from  bookregister_send_filebook_sch where  ref_id='$result_ref[ref_id]' order by id";
$dbquery = mysqli_query($connect,$sql);
$file_name[1]=""; $file_name[2]=""; $file_name[3]=""; $file_name[4]=""; $file_name[5]=""; 
$file_number[1]=""; $file_number[2]=""; $file_number[3]=""; $file_number[4]=""; $file_number[5]=""; 
while($result_file = mysqli_fetch_array($dbquery)){
$file=$result_file['file_name'];
$file1=explode("_", $file);
$file2=explode(".", $file1[1]);
$file3=$file2[0];
		if($file3==1){
		$file_name[1]=$file;
		$file_number[1]=$result_file['file_des'];
		}
		else if($file3==2){
		$file_name[2]=$file;
		$file_number[2]=$result_file['file_des'];
		}
		else if($file3==3){
		$file_name[3]=$file;
		$file_number[3]=$result_file['file_des'];
		}
		else if($file3==4){
		$file_name[4]=$file;
		$file_number[4]=$result_file['file_des'];
		}
		else if($file3==5){
		$file_name[5]=$file;
		$file_number[5]=$result_file['file_des'];
		}
}

echo "<tr>";
echo "<td width='378' align='right' colspan='2'><p align='center'><font size='2' color='#800000'>ไฟล์แนบ</font></td>";
echo "<td width='238' align='center' colspan='2'><p align='center'><font size='2' color='#800000'>คำอธิบายไฟล์</font></td>";
echo "</tr>";

echo "<tr>";
echo "<td width='94' align='right'><font size='2' color='#0000FF'>ไฟล์แนบ 1&nbsp;</font></td>";
echo "<td width='274' align='left' bgcolor='#E5E5FF'>&nbsp;$file_name[1]</td>";
echo "<td width='238'  align='left' colspan='2' bgcolor='#E5E5FF'>$file_number[1]</td>";
echo "</tr>";

echo "<tr>";
echo "<td width='94' align='right'><font size='2' color='#0000FF'>ไฟล์แนบ 2&nbsp;</font></td>";
echo "<td width='274' align='left' bgcolor='#E5E5FF'>&nbsp;$file_name[2]</td>";
echo "<td width='238'  align='left' colspan='2' bgcolor='#E5E5FF'>$file_number[2]</td>";
echo "</tr>";

echo "<tr>";
echo "<td width='94' align='right'><font size='2' color='#0000FF'>ไฟล์แนบ 3&nbsp;</font></td>";
echo "<td width='274' align='left' bgcolor='#E5E5FF'>&nbsp;$file_name[3]</td>";
echo "<td width='238'  align='left' colspan='2' bgcolor='#E5E5FF'>$file_number[3]</td>";
echo "</tr>";

echo "<tr>";
echo "<td width='94' align='right'><font size='2' color='#0000FF'>ไฟล์แนบ 4&nbsp;</font></td>";
echo "<td width='274' align='left' bgcolor='#E5E5FF'>&nbsp;$file_name[4]</td>";
echo "<td width='238'  align='left' colspan='2' bgcolor='#E5E5FF'>$file_number[4]</td>";
echo "</tr>";

echo "<tr>";
echo "<td width='94' align='right'><font size='2' color='#0000FF'>ไฟล์แนบ 5&nbsp;</font></td>";
echo "<td width='274' align='left' bgcolor='#E5E5FF'>&nbsp;$file_name[5]</td>";
echo "<td width='238'  align='left' colspan='2' bgcolor='#E5E5FF'>$file_number[5]</td>";
echo "</tr>";

echo "<input name='ref_id' type='hidden' value='$result_ref[ref_id]'>";
echo "<tr>";
echo "<td align='center' colspan='4'><BR><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)' class=entrybutton>&nbsp;&nbsp;<input type='button' value='กลับไปทะเบียนหนังสือส่ง' name='smb' onclick='goto_url(0)'></td>";
echo "</tr>";
echo "</Table>";
echo "</form>";
}


//ส่วนบันทึกข้อมูล
if($index==4){

//ตรวจสอบว่ามีผู้รับหรือยัง สำหรับโรงเรียน.ส่ง
// ***
if(($_SESSION['login_status']>10) and ($_SESSION['login_status']<=14)){	
$sql_send_num = mysqli_query($connect,"SELECT * FROM book_sendto_answer WHERE ref_id='$_POST[ref_id]' ") ;
$send_num = mysqli_num_rows ($sql_send_num) ;
if ($send_num==0 and $_POST['sendto']=='some') {
echo "<div align='center'>";
echo "<B><FONT SIZE=2 COLOR=#990000>ยังไม่ได้ระบุผู้รับหนังสือ</FONT></B><BR><BR>" ;
 echo "&nbsp;&nbsp;&nbsp;<input type=\"button\" value=\"&nbsp;&nbsp;แก้ไข&nbsp;&nbsp;\" onClick=\"javascript:history.go(-1)\" ></CENTER>" ;
echo "</div>";
exit () ;
}
} //end ***


//ส่วนการบันทึก
$day_now=date("Y-m-d H:i:s");
$book_type=2;  //ผู้ส่งคือโรงเรียน

$sql = "insert into book_main (book_type, office, sender, level, secret, book_no, signdate, subject, detail, ref_id, send_date, bookregis_link) values ('$book_type', $_POST[workgroup], '$user', '$_POST[level]', '$_POST[secret]', '$_POST[book_no]', '$_POST[signdate]','$_POST[subject]','$_POST[detail]','$_POST[ref_id]','$day_now', '1')";
$dbquery = mysqli_query($connect,$sql);


	
if(($_SESSION['login_status']>10) and ($_SESSION['login_status']<=14)){		
			if($_POST['sendto']=='all') { 
			$sql_sendto = "select school_code from system_school where school_code != '$_SESSION[user_school]' and school_type='1' order by school_code";
			$dbquery_sendto = mysqli_query($connect,$sql_sendto);
					While ($result_sendto = mysqli_fetch_array($dbquery_sendto)){
					$sql=	"insert into book_sendto_answer (send_level, ref_id, send_to) values ('3', '$_POST[ref_id]','$result_sendto[school_code]')";
					$dbquery = mysqli_query($connect,$sql);
					}
			}
			else if($_POST['sendto']!='some'){
					$sql=	"insert into book_sendto_answer (send_level, ref_id, send_to) values ('2', '$_POST[ref_id]','$_POST[sendto]')";
					$dbquery = mysqli_query($connect,$sql);
			}
}			
echo "<script>document.location.href='?option=book&task=main/send'</script>\n";
} //end index4

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=bookregister&task=main/send_sch");   // page ย้อนกลับ 
	}else if(val==1){
	var v2 = document.frm1.subject.value;
	var v3 = document.frm1.detail.value;
	
	var w_group=document.getElementsByName("workgroup");
	var wg=0;
	for(i=0;i<w_group.length;i++){
			if(w_group[i].checked==true){
			wg=1;
			}
	}

          if (wg==0)
           {
          alert("กรุณาเลือกผู้ส่ง (จาก)");
           }
		   else if (document.frm1.book_no.value=="")
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
		   

        else{
		callfrm("?option=book&task=main/send_sch_2&index=4");   //page ประมวลผล
		}
	}
}

</script>
