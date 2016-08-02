<script type="text/javascript" src="./css/js/calendarDateInput2.js"></script> 

<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

require_once "modules/book/time_inc.php";	
$user=$_SESSION['login_user_id'];

if(!isset($_GET['id'])){
$_GET['id']="";
}

$sql="select * from bookregister_send where ms_id='$_GET[id]' "; 
$dbquery = mysqli_query($connect,$sql);
$result_ref = mysqli_fetch_array($dbquery);

$_SESSION ['ref_id'] = $result_ref['ref_id'];

echo "<br />";
//ส่วนฟอร์มรับข้อมูล
if($index==1){

//echo "<form Enctype = multipart/form-data id='frm1' name='frm1'>";
echo "<table width='800' border='0' align='center'><tr><td>";
echo "<form Enctype = 'multipart/form-data' method='POST'  action='?option=book&task=main/send_2&index=4'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>ส่งหนังสือราชการ</b></font>";
echo "</Cener>";
echo "<Br>";
//echo "<table border='1' width='700' id='table1' style='border-collapse: collapse' bordercolor='#C0C0C0'>";
echo " <table width='100%' class='table table-striped table-bordered table-hover' id='dataTables-example'>";

echo "<tr bgcolor='#003399'>";
echo "<td colspan='4' height='23' align='left'>&nbsp;กรุณาระบุรายละเอียด</td>";
echo "</tr>";

// *ผู้ส่งเป็น สพท.
if($_SESSION['login_group']==1){
echo "<tr>";
echo "<td width='94' align='right'><span lang='th'>จาก&nbsp;</span></td>";
echo "<td width='514' colspan='3' align='left'>";

	$sql_department= "select * from system_department";
	$dbquery_department = mysqli_query($connect,$sql_department);
	While ($result_department = mysqli_fetch_array($dbquery_department)){
			if($result_department['department']==$result_ref['department']){
			echo  "&nbsp;&nbsp;<input type='radio'  name='department' value='$result_department[department]' checked>&nbsp;$result_department[department_name]<br>";
			}
			//else{
			//echo  "&nbsp;&nbsp;<input type='radio'  name='department' value='$result_department[department]'>&nbsp;$result_department[department_name]<br>";
			//}
	}
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td width='94' align='right'>ถึง&nbsp;</span></td>";
echo "<td colspan='3' align='left'>&nbsp;&nbsp;<input type='radio' value='all' name='sendto'>&nbsp;สพท.ทุกแห่ง";
echo "<br>&nbsp;&nbsp;<input type='radio' value='some' name='sendto' required onClick=\"window.open('modules/book/main/select_send_2.php?sd_index=some','PopUp','width=700,height=600,scrollbars,status'); \">&nbsp;สพท.บางแห่ง";
echo "<br>&nbsp;&nbsp;<input type='radio' value='some' name='sendto' required onClick=\"window.open('modules/book/main/select_send_3.php?sd_index=some','PopUp','width=700,height=600,scrollbars,status'); \">&nbsp;หน่วยงาน / รร.สังกัด สำนักบริหารงานการศึกษาพิเศษ";
echo "<br>&nbsp;&nbsp;<input type='radio' value='some' name='sendto' required onClick=\"window.open('modules/book/main/select_send_5.php?sd_index=2','PopUp','width=700,height=600,scrollbars,status'); \">&nbsp;สำนักใน สพฐ.";

	$sql_group= "select * from book_group";
	$dbquery_group = mysqli_query($connect,$sql_group);
	While ($result_group = mysqli_fetch_array($dbquery_group)){
	echo  "<br>&nbsp;&nbsp;<input type='radio'  name='sendto' value='$result_group[grp_id]' onClick=\"window.open('modules/book/main/select_send_sch.php?sd_index=$result_group[grp_id]','PopUp','width=700,height=600,scrollbars,status'); \">&nbsp;$result_group[grp_name]";
	}
echo "</td></tr>";
}  //end *

echo "<tr>";
echo "<td align='right'><span lang='th'>ระดับความสำคัญ&nbsp;</span></td>";
echo "<td colspan='3' align='left'>&nbsp;<input type='radio' name='level' value='1' checked>ปกติ<span lang='en-us'>&nbsp;
			<input type='radio' name='level' value='2'></span>ด่วน&nbsp;
			<input type='radio' name='level' value='3'>ด่วนมาก&nbsp;
			<input type='radio' name='level' value='4'>ด่วนที่สุด</td>";
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
echo "<td align='right'><span lang='th'>ความลับ&nbsp;</span></td>";
echo "<td colspan='3' align='left'>&nbsp;<input type='radio' name='secret' value='0' $check_0>ไม่ลับ<span lang='en-us'>&nbsp;
			<input type='radio' name='secret' value='1' $check_1>ลับ</td>";
echo "</tr>";

echo "<tr>";
echo "<td align='right'><span lang='th'>เลขที่หนังสือ&nbsp;</span></td><td>&nbsp;<FONT SIZE='2' COLOR=''><input type='text' name='book_no' size='20' value='$result_ref[book_no]'  style='background-color: #99ccff'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ลงวันที่</td>";
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
echo "<td align='right'><span lang='th'>เรื่อง&nbsp;</span></td>";
echo "<td colspan='3' align='left'>&nbsp;<input type='text' name='subject' size='76'  style='background-color: #99ccff' value='$result_ref[subject]'></td>";
echo "</tr>";

echo "<tr>";
echo "<td width='94' align='right' height='47'><span lang='th'>เนื้อหาโดยสรุป&nbsp;</span></td>";
echo "<td height='47' width='514' colspan='3'  align='left'>&nbsp;<textarea rows='5' name='detail' cols='55'  style='background-color: #99ccff'  required ></textarea></td>";
echo "</tr>";

$sql = "select * from  bookregister_send_filebook where  ref_id='$result_ref[ref_id]' order by id";
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
echo "<td width='371' align='right' colspan='2'><p align='center'>ไฟล์แนบ</td>";
echo "<td width='238' align='center' colspan='2'><p align='center'>คำอธิบายไฟล์</td>";
echo "</tr>";

echo "<tr>";
echo "<td width='94' align='right'>ไฟล์แนบ 1&nbsp;</td>";
echo "<td width='274' align='left' bgcolor='#E5E5FF'>&nbsp;$file_name[1]</td>";
echo "<td width='238'  align='left' colspan='2' bgcolor='#E5E5FF'>$file_number[1]</td>";
echo "</tr>";

echo "<tr>";
echo "<td width='94' align='right'>ไฟล์แนบ 2&nbsp;</td>";
echo "<td width='274' align='left' bgcolor='#E5E5FF'>&nbsp;$file_name[2]</td>";
echo "<td width='238'  align='left' colspan='2' bgcolor='#E5E5FF'>$file_number[2]</td>";
echo "</tr>";

echo "<tr>";
echo "<td width='94' align='right'>ไฟล์แนบ 3&nbsp;</td>";
echo "<td width='274' align='left' bgcolor='#E5E5FF'>&nbsp;$file_name[3]</td>";
echo "<td width='238'  align='left' colspan='2' bgcolor='#E5E5FF'>$file_number[3]</td>";
echo "</tr>";

echo "<tr>";
echo "<td width='94' align='right'>ไฟล์แนบ 4&nbsp;</td>";
echo "<td width='274' align='left' bgcolor='#E5E5FF'>&nbsp;$file_name[4]</td>";
echo "<td width='238'  align='left' colspan='2' bgcolor='#E5E5FF'>$file_number[4]</td>";
echo "</tr>";

echo "<tr>";
echo "<td width='94' align='right'>ไฟล์แนบ 5&nbsp;</td>";
echo "<td width='274' align='left' bgcolor='#E5E5FF'>&nbsp;$file_name[5]</td>";
echo "<td width='238'  align='left' colspan='2' bgcolor='#E5E5FF'>$file_number[5]</td>";
echo "</tr>";

echo "<input name='ref_id' type='hidden' value='$result_ref[ref_id]'>";
echo "<tr>";
echo "<td align='center' colspan='4'><BR><INPUT TYPE='submit' name='smb' value='ตกลง'>&nbsp;&nbsp;<input type='button' value='กลับไปทะเบียนหนังสือส่ง' name='smb' onclick='goto_url(0)'></td>";
echo "</tr>";
echo "</Table>";
echo "</form>";
echo "</td></td></table>";

}


//ส่วนบันทึกข้อมูล
if($index==4){

if(!isset($_POST['sendto'])){
$_POST['sendto']="";
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


//ส่วนการบันทึก
$day_now=date("Y-m-d H:i:s");
$book_type=1;  //ผู้ส่งคือสพท

//ตรวจสอบ ref_id
if(!isset($_POST['ref_id'])){
echo "<script>alert('มีข้อผิดพลาดเกี่ยวกับเลขอ้างอิงในระบบ ยกเลิกการส่งหนังสือในครั้งนี้ กรุณาส่งใหม่อีกครั้ง'); document.location.href='?option=book&task=main/send&index=1';</script>";
exit();
} 
if($_POST['ref_id']==""){
echo "<script>alert('มีข้อผิดพลาดเกี่ยวกับเลขอ้างอิงในระบบ ยกเลิกการส่งหนังสือในครั้งนี้ กรุณาส่งใหม่อีกครั้ง'); document.location.href='?option=book&task=main/send&index=1';</script>";
exit();
} 

$sql = "insert into book_main (book_type, office, sender, level, secret, book_no, signdate, subject, detail, ref_id, send_date, bookregis_link) values ('$book_type', $_POST[department], '$user', '$_POST[level]', '$_POST[secret]', '$_POST[book_no]', '$_POST[signdate]','$_POST[subject]','$_POST[detail]','$_POST[ref_id]','$day_now', '1')";
$dbquery = mysqli_query($connect,$sql);
  
    // ส่งแจ้งเตือนไปโทรศัพท์   
switch($book_type) {
    case 1:
        // แจ้งเตือนเขต
        $sql_answer = "select * from book_sendto_answer bsa left join book_permission bp on(bsa.send_to=bp.p4) where bsa.ref_id = '".$_POST[ref_id]."'";
        $result_answer = mysqli_query($connect, $sql_answer);
        while($row_answer = $result_answer->fetch_assoc()) {
            $person_id = $row_answer["person_id"];
            smartpush($person_id,"book"," เลขที่ ".$_POST[book_no]." : ".$_POST[subject],"มีหนังสือเข้า");
        }
        
        // แจ้งเตือนสารบัญสำนัก
        $sql_answer = "select * from book_sendto_answer bsa left join book_permission bp on(bsa.send_to=bp.p2) where  send_to != 'saraban' and bsa.ref_id = '".$_POST[ref_id]."'";
        $result_answer = mysqli_query($connect, $sql_answer);
        while($row_answer = $result_answer->fetch_assoc()) {
            $person_id = $row_answer["person_id"];
            smartpush($person_id,"book"," เลขที่ ".$_POST[book_no]." : ".$_POST[subject],"มีหนังสือเข้า");
        }
    break;
    
    case 2:
        // แจ้งเตือนสารบัญกลาง
        //$sql_answer = "select * from book_sendto_answer bsa left join book_permission bp on(bsa.send_to=bp.p1) where  send_to = 'saraban' and bsa.ref_id = '".$_POST[ref_id]."'";
        $sql_answer = "select * from book_permission where p1 = '1'";
        $result_answer = mysqli_query($connect, $sql_answer);
        while($row_answer = $result_answer->fetch_assoc()) {
            $person_id = $row_answer["person_id"];
            smartpush($person_id,"book"," เลขที่ ".$_POST[book_no]." : ".$_POST[subject],"มีหนังสือเข้า");
        }
        // แจ้งเตือนสารบัญสำนัก
        $sql_answer = "select * from book_sendto_answer bsa left join book_permission bp on(bsa.send_to=bp.p2) where  send_to != 'saraban' and bsa.ref_id = '".$_POST[ref_id]."'";
        $result_answer = mysqli_query($connect, $sql_answer);
        while($row_answer = $result_answer->fetch_assoc()) {
            $person_id = $row_answer["person_id"];
            smartpush($person_id,"book"," เลขที่ ".$_POST[book_no]." : ".$_POST[subject],"มีหนังสือเข้า");
        }
    break;
        
    default:
        
    break;
}

// จบการแจ้งเตือน


//สำหรับสพท	
if($_SESSION['login_group']==1){
			if($_POST['sendto']=='all') { 
			$sql_sendto = "select khet_code from system_khet  where  khet_type='1' or khet_type='2' or khet_type='3' order by khet_type,khet_code";
			$dbquery_sendto = mysqli_query($connect,$sql_sendto);
					While ($result_sendto = mysqli_fetch_array($dbquery_sendto)){
					$sql=	"insert into book_sendto_answer (send_level, ref_id, send_to) values ('1', '$_POST[ref_id]','$result_sendto[khet_code]')";
					$dbquery = mysqli_query($connect,$sql);
					}
			}
}	
echo "<script>document.location.href='?option=book&task=main/send'</script>\n";
} //end index4

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=bookregister&task=main/send");   // page ย้อนกลับ 
	}else if(val==1){
	var v2 = document.frm1.subject.value;
	var v3 = document.frm1.detail.value;
	
	var w_group=document.getElementsByName("department");
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
		callfrm("?option=book&task=main/send_2&index=4");   //page ประมวลผล
		}
	}
}

</script>
