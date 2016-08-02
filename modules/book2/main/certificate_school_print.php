<script type="text/javascript" src="./css/js/calendarDateInput2.js"></script> 

<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

require_once "modules/bookregister/time_inc.php";	
$user2=$user;
$user=$_SESSION['login_user_id'];

if(!isset($_REQUEST['search_index'])){
$_REQUEST['search_index']="";
}

if(!isset($_REQUEST['search'])){
$_REQUEST['search']="";
}

if(!isset($_REQUEST['field'])){
$_REQUEST['field']="";
}

//ส่วนหัว
echo "<br>";
echo "<table width='100%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>เกียรติบัตรสำนักงานเขตพื้นที่การศึกษา (เพื่อผู้รับพิมพ์)</strong></font></td></tr>";
echo "</table>";

//ส่วนของการแยกหน้า
if($_REQUEST['search_index']==1){
$sql="select * from bookregister_certificate where $_REQUEST[field] like '%$_REQUEST[search]%' and khet_print='2' and quarantee='1' ";
}
else{
$sql="select * from bookregister_certificate where khet_print='2' and quarantee='1' "; 
}
$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery );

$pagelen=20;  // 1_กำหนดแถวต่อหน้า
$url_link="option=bookregister&task=main/certificate_school_print&search_index=$_REQUEST[search_index]&field=$_REQUEST[field]&search=$_REQUEST[search]";  // 2_กำหนดลิงค์ฺ
$totalpages=ceil($num_rows/$pagelen);

//
if(!isset($_REQUEST['page'])){
$_REQUEST['page']="";
}
//

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

echo "<table border='0' width='95%' id='table1' style='border-collapse: collapse' cellspacing='2' cellpadding='2' align='center'>
";
echo "<tr>";
?>
	<form method="POST" action="?option=bookregister&task=main/certificate_school_print">
<td align="right">
				<p align="right"><font size="2">ค้นหาจาก 
				</font><select size="1" name="field">
				<?php
				if($_REQUEST['field']=='name_cer'){
				echo "<option value='name_cer' selected>ชื่อ</option>";
				}
				else{
				echo "<option value='name_cer'>ชื่อ</option>";
				}
				if($_REQUEST['field']=='subject'){
				echo "<option value='subject' selected>เรื่อง</option>";
				}
				else{
				echo "<option value='subject'>เรื่อง</option>";
				}
				if($_REQUEST['field']=='book_no'){
				echo "<option value='book_no' selected>ที่</option>";
				}
				else{
				echo "<option value='book_no'>ที่</option>";
				}
				echo "</select>";
				
				echo "<font size='2'> ด้วยคำว่า </font>";
				echo "<input type='text' name='search' size='20' value='$_REQUEST[search]'>"; 
				echo "<input type='hidden' name='search_index' value='1'>";
				echo " <input type='submit' value='ค้นหา'>";
				?>
				</p>
			</td></form>
		</tr>
</table>


<table border="1" width="95%" id="table2" style="border-collapse: collapse" align="center">
				<tr bgcolor="#CCCCCC">
					<td align="center" width="70">
					<font size="2" face="Tahoma">เลขทะเบียน</font></td>
					<td align="center" width="70">
					<font size="2" face="Tahoma">ปี</font></td>
					<td align="center" width="100">
					<font face="Tahoma" size="2">ที่เกียรติบัตร</font></td>
					<td align="center" width="160">
					<font face="Tahoma" size="2">ชื่อ</font></td>
					<td align="center">
					<font face="Tahoma" size="2">เรื่อง/รายการ</font></td>
					<td align="center" width="120">
					<font face="Tahoma" size="2">วันที่ออก</font></td>
					<td align="center" width="160">
					<font face="Tahoma" size="2">ผู้ลงทะเบียน</font></td>
					<td align="center" width="100">
					<font face="Tahoma" size="2">วันลงทะเบียน</font></td>
					<td align="center" width="60">
					<font face="Tahoma" size="2">ตรวจสอบ</font></td>
					<td align="center" width="60">
					<font face="Tahoma" size="2">พิมพ์</font></td>
				</tr>

<?php
if($_REQUEST['search_index']==1){
$sql="select * from bookregister_certificate left join person_main on bookregister_certificate.officer=person_main.person_id where  $_REQUEST[field] like '%$_REQUEST[search]%' and khet_print='2' and quarantee='1' order by year,register_number  limit $start,$pagelen "; 
}
else{
$sql="select * from bookregister_certificate left join person_main on bookregister_certificate.officer=person_main.person_id where khet_print='2' and quarantee='1' order by year,register_number limit $start,$pagelen "; 
}
$dbquery = mysqli_query($connect,$sql);

$N=(($page-1)*$pagelen)+1; //*เกี่ยวข้องกับการแยกหน้า
$M=1;

While ($result = mysqli_fetch_array($dbquery)){
		$id = $result['ms_id'];
		$register_number = $result['register_number'];
		$year = $result['year'];
		$book_no = $result['book_no'];
		$signdate = $result['signdate'];
		$subject = $result['subject'];
		$subject2 = $result['subject2'];
		$register_date = $result['register_date'];
		$sign_person=$result['sign_person'];
		$khet_print=$result['khet_print'];
			if(($M%2) == 0)
			$color="#ffffff";
			else $color="#FFFFC";
$signdate=thai_date_3($signdate);
$register_date=thai_date_3($register_date);

?>
			<tr bgcolor="<?php echo $color;?>">
					<td align="center"><?php echo $register_number;?></td>
					<td align="center"><?php echo $year;?></td>
					<td align="left">&nbsp;<?php echo $book_no;?></td>
					<td align="left">&nbsp;<?php echo $result['name_cer'];?></td>
					<td align="center"><?php echo $subject;?><br /><?php echo $subject2;?></td>
					<td align="center">&nbsp;<?php echo $signdate;?></td>
					<td align='left'><?php echo $result['prename'].$result['name']." ".$result['surname'];?></td>
					<td align='center'><?php echo $register_date;?></td>
<?php			

if($result['quarantee']==1){
echo "<td align='center'><img src=images/yes.png border='0' alt='รับรอง'></td>";
}
else if($result['quarantee']==2){
echo "<td align='center'><img src=images/no.png border='0' alt='ไม่รับรอง'></td>";
}
else{
echo "<td align='center'></td>";
}
if($sign_person!="" and $khet_print>=1 and $result['quarantee']!=2){
echo "<td align='center'><a href='modules/bookregister/pdf/display.php?ms_id=$id' target='_blank'><img src=images/b_print.png border='0'></a></td>";
}
else{
echo "<td></td>";
}
echo "</tr>";

	$M++;
	$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}  // end while	
echo "</table>";
		$_SESSION['certificate_host']=$hostname;
		$_SESSION['certificate_user']=$user2;
		$_SESSION['certificate_pass']=$password;
		$_SESSION['certificate_db']=$dbname;
?>
