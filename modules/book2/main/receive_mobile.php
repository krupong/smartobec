<script type="text/javascript" src="./css/js/calendarDateInput2.js"></script> 

<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

require_once "modules/bookregister/time_inc.php";	

//ส่วนหัว
if(!(($index==1) or ($index==2) or ($index==5))){

echo "<table width='100%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666'><strong>ทะเบียนหนังสือรับ</strong></font></td></tr>";
echo "</table>";
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){

//ส่วนของการแยกหน้า
$sql="select * from bookregister_receive"; 
$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery );

$pagelen=15;  // 1_กำหนดแถวต่อหน้า
$url_link="option=bookregister&task=main/receive_mobile";  // 2_กำหนดลิงค์ฺ
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

echo "<table border='0' width='100%' id='table1' style='border-collapse: collapse' cellspacing='2' cellpadding='2' align='center'>
";
echo "<tr><td align='left'>";
?>
<table border="1" width="100%" id="table2" style="border-collapse: collapse" align="center">
				<tr bgcolor="#FFCCCC">
					<td align="center">
					<font face="Tahoma">เลขทะเบียน</font></td>
					<td align="center">
					<font face="Tahoma">จาก</font></td>
					<td align="center">
					<font face="Tahoma">ถึง</font></td>
					<td align="center">
					<font face="Tahoma">เรื่อง</font></td>
					<td align="center">
					<font face="Tahoma">วันลงทะเบียน</font></td>
				</tr>
<?php
$sql="select * from bookregister_receive order by year,register_number limit $start,$pagelen "; 
$dbquery = mysqli_query($connect,$sql);

$N=(($page-1)*$pagelen)+1; //*เกี่ยวข้องกับการแยกหน้า
$M=1;

While ($result = mysqli_fetch_array($dbquery)){
		$id = $result['ms_id'];
		$register_number = $result['register_number'];
		$year = $result['year'];
		$book_no = $result['book_no'];
		$signdate = $result['signdate'];
		$book_from = $result['book_from'];
		$book_to = $result['book_to'];
		$subject = $result['subject'];
		$group = $result['workgroup'];
		$operation = $result['operation'];
		$comment = $result['comment'];
		$register_date = $result['register_date'];
		$ref_id = $result['ref_id'];
			if(($M%2) == 0)
			$color="#ffffff";
			else $color="#FFFFC";
$signdate=thai_date_3($signdate);
$register_date=thai_date_3($register_date);

// ตรวจสอบไฟล์แนบ
if($result['book_link']==0){
$file = mysqli_query($connect,"SELECT id  FROM  bookregister_receive_filebook WHERE ref_id='$ref_id' ") ;
}
else if($result['book_link']==1){
$file = mysqli_query($connect,"SELECT * FROM  book_filebook WHERE ref_id='$ref_id' ") ;
}
else if($result['book_link']==2){
$file = mysqli_query($connect,"SELECT * FROM  bookregister_send_filebook_sch WHERE ref_id='$ref_id' ") ;
}
			$file_num = mysqli_num_rows($file) ;
			if ($file_num==0) {
				$file_img = "" ;
			}else{
				$file_img = "<IMG SRC=\"modules/bookregister/images/file1.gif\" WIDTH=\"13\" HEIGHT=\"10\" BORDER=\"0\" ALT=\"มีไฟล์แนบ\">" ;
			}
			
if($result['secret']==1){
$secret_txt="<font color='#FF0000'>[ลับ]</font>";
}
else{
$secret_txt="";
}

?>
			<tr bgcolor="<?php echo $color;?>">
					<td align="center"><?php echo $register_number;?></td>
					<td align="left"><?php echo $book_from;?></td>
					<td align="left"><?php echo $book_to;?></td>
					<td align="left"><?php echo $subject;?>&nbsp;<?php echo $file_img;?>&nbsp;<?php echo $secret_txt;?></td>
					<td align='center'><?php echo $register_date;?></td>
					
<?php
echo "</tr>";
	$M++;
	$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}  // end while	
echo "</table>";
}  //end index

?>
