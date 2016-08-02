<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

?>
<script type="text/javascript" src="./css/js/calendarDateInput.js"></script> 
<?php

if(!($result_permission['p2']==1)){	
exit();
}

function thai_date_3($date){
		if(!isset($date)){
		return;
		}
$thai_month_arr=array(
	"01"=>"ม.ค.",
	"02"=>"ก.พ.",
	"03"=>"มี.ค.",
	"04"=>"เม.ย.",
	"05"=>"พ.ค.",
	"06"=>"มิ.ย.",	
	"07"=>"ก.ค.",
	"08"=>"ส.ค.",
	"09"=>"ก.ย.",
	"10"=>"ต.ค.",
	"11"=>"พ.ย.",
	"12"=>"ธ.ค."					
);
	$f_date_2=explode(" ", $date);
	$f_date=explode("-", $f_date_2[0]);
	$f_date[2]=intval($f_date[2]);
	$thai_date_return="";
	$thai_date_return.=	$f_date[2];
	$thai_date_return.= " ".$thai_month_arr[$f_date[1]]." ";
	$thai_date_return.=	$f_date[0]+543;
	if($date!=""){
	return $thai_date_return;
	}
	else{
	$thai_date_return="";
	return $thai_date_return;
	}
}

//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='100%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>ผู้รักษาราชการแทนเลขาธิการคณะกรรมการการศึกษาขั้นพื้นฐาน</strong></font></td></tr>";
echo "</table>";
echo "<br />";
}

//ส่วนฟอร์มรับข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มการรักษาราชการแทน</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border='0'>";

echo "<Tr><Td align='right'>ผู้มอบ&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select name='from_person_id' size='1' class='form-control selectpicker show-tick' title='' data-live-search='true'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select * from  person_main order by position_code,person_order";
$dbquery = mysqli_query($connect,$sql);
While ($result_person = mysqli_fetch_array($dbquery)){
echo  "<option  value ='$result_person[person_id]'>$result_person[prename]$result_person[name] $result_person[surname]</option>" ;
}	
echo "</select>"; 
echo "</div></td></tr>";

echo "<tr><td>&nbsp;</td></tr>";

echo "<Tr><Td align='right'>ผู้รับมอบ&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select name='person_id' size='1' class='form-control selectpicker show-tick' title='' data-live-search='true'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select * from  person_main order by position_code,person_order";
$dbquery = mysqli_query($connect,$sql);
While ($result_person = mysqli_fetch_array($dbquery)){
echo  "<option  value ='$result_person[person_id]'>$result_person[prename]$result_person[name] $result_person[surname]</option>" ;
}	
echo "</select>"; 
echo "</div></td></tr>";

echo "<tr><td>&nbsp;</td></tr>";

echo "<Tr align='left'><Td align='right'>รักษาราชการแทนตั้งแต่&nbsp;&nbsp;</Td>";
echo "<Td align='left'>";
?>
<script>
								var Y_date=<?php echo date("Y")?>  
								var m_date=<?php echo date("m")?>  
								var d_date=<?php echo date("d")?>  
								Y_date= Y_date+'/'+m_date+'/'+d_date
								DateInput('start', true, 'YYYY-MM-DD', Y_date)</script> 
<?php
echo "</Td></Tr>";

echo "<Tr align='left'><Td align='right'>ถึง&nbsp;&nbsp;</Td>";
echo "<Td align='left'>";
?>
<script>
								var Y_date=<?php echo date("Y")?>  
								var m_date=<?php echo date("m")?>  
								var d_date=<?php echo date("d")?>  
								Y_date= Y_date+'/'+m_date+'/'+d_date
								DateInput('finish', true, 'YYYY-MM-DD', Y_date)</script> 
<?php
echo "</Td></Tr>";

echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td align='right'><INPUT class='btn btn-primary' TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)'>&nbsp;&nbsp;</td>";
echo "<td align='left'><INPUT class='btn btn-default' TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)'></td></tr>";
echo "</Table>";
echo "</form>";
}

//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=person&task=delegate&index=3&id=$_GET[id]&page=$_REQUEST[page]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=person&task=delegate&page=$_REQUEST[page]\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from person_delegate where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนบันทึกข้อมูล
if($index==4){
$rec_date = date("Y-m-d");
$sql = "insert into person_delegate (from_person_id, person_id, start, finish, officer,rec_date) values ('$_POST[from_person_id]', '$_POST[person_id]', '$_POST[start]','$_POST[finish]','$_SESSION[login_user_id]','$rec_date')";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไข ผู้รักษาราชการแทน</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border= '0'>";
$sql = "select * from person_delegate left join person_main on person_delegate.person_id=person_main.person_id where person_delegate.id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);

echo "<Tr><Td align='right'>ผู้มอบ&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select name='from_person_id' size='1' class='form-control selectpicker show-tick' title='' data-live-search='true'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select * from  person_main where person_id = '".$ref_result['from_person_id']."'";
$dbquery = mysqli_query($connect,$sql);
While ($result_person = mysqli_fetch_array($dbquery)){
		if($result_person['person_id']==$ref_result['from_person_id']){
echo  "<option  value ='$result_person[from_person_id]' selected>$result_person[prename]$result_person[name] $result_person[surname]</option>" ;
		}
		else{
echo  "<option  value ='$result_person[from_person_id]'>$result_person[prename]$result_person[name] $result_person[surname]</option>" ;
		}
}	
echo "</select>"; 
echo "</div></td></tr>";

echo "<tr><td>&nbsp;</td></tr>";

echo "<Tr><Td align='right'>ผู้รับมอบ&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select name='person_id' size='1' class='form-control selectpicker show-tick' title='' data-live-search='true'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select * from  person_main order by position_code,person_order";
$dbquery = mysqli_query($connect,$sql);
While ($result_person = mysqli_fetch_array($dbquery)){
		if($result_person['person_id']==$ref_result['person_id']){
echo  "<option  value ='$result_person[person_id]' selected>$result_person[prename]$result_person[name] $result_person[surname]</option>" ;
		}
		else{
echo  "<option  value ='$result_person[person_id]'>$result_person[prename]$result_person[name] $result_person[surname]</option>" ;
		}
}	
echo "</select>"; 
echo "</div></td></tr>";

echo "<tr><td>&nbsp;</td></tr>";

echo "<Tr align='left'><Td align='right'>รักษาราชการแทนตั้งแต่&nbsp;&nbsp;</Td>";
echo "<Td align='left'>";
$start=explode("-", $ref_result['start']);
?>
<script>
										var Y_date=<?php echo $start[0]?>  
										var m_date=<?php echo $start[1]?>  
										var d_date=<?php echo $start[2]?>  
								Y_date= Y_date+'/'+m_date+'/'+d_date
								DateInput('start', true, 'YYYY-MM-DD', Y_date)</script> 
<?php
echo "</Td></Tr>";

echo "<Tr align='left'><Td align='right'>ถึง&nbsp;&nbsp;</Td>";
echo "<Td align='left'>";
$finish=explode("-", $ref_result['finish']);
?>
<script>
										var Y_date=<?php echo $finish[0]?>  
										var m_date=<?php echo $finish[1]?>  
										var d_date=<?php echo $finish[2]?>  
								Y_date= Y_date+'/'+m_date+'/'+d_date
								DateInput('finish', true, 'YYYY-MM-DD', Y_date)</script> 
<?php
echo "</Td></Tr>";
echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td align='right'><INPUT class='btn btn-primary' TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)'>&nbsp;&nbsp;</td>";
echo "<td align='left'><INPUT class'btn btn-default' TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)'></td></tr>";
echo "</Table>";
echo "<Br>";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "<Input Type=Hidden Name='page' Value='$_GET[page]'>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
$rec_date = date("Y-m-d");
$sql = "update person_delegate set  person_id='$_POST[person_id]', start='$_POST[start]', finish='$_POST[finish]', officer='$_SESSION[login_user_id]', rec_date='$rec_date' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){
//ส่วนของการแยกหน้า
$pagelen=25;  // 1_กำหนดแถวต่อหน้า
$url_link="option=person&task=delegate";
$sql = "select id from person_delegate";
$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery );  
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

$sql = "select person_delegate.id, person_delegate.start, person_delegate.finish, person_main.prename, person_main.name, person_main.surname,person_main.position_code, fpm.prename as fromprename, fpm.name as fromname, fpm.surname as fromsurname, fpm.position_code as from_position_code from person_delegate left join person_main on person_delegate.person_id=person_main.person_id left join person_main fpm on person_delegate.from_person_id=fpm.person_id order by fpm.position_code, person_delegate.start limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);
echo  "<table width='65%' border='0' align='center'>";
echo "<Tr><Td colspan='5' align='left'><INPUT TYPE='button' name='smb' value='เพิ่มผู้รักษาราชการแทน' onclick='location.href=\"?option=person&task=delegate&index=1\"'</Td></Tr>";

echo "<Tr bgcolor='#FFCCCC'><Td align='center' rowspan='2' width='50'>ที่</Td><td align='center' colspan='2'>วันรักษาราชการแทน</td><Td align='center' rowspan='2'>ผู้มอบ</Td><Td align='center' rowspan='2'>ผู้รักษาราชการแทน</Td><Td align='center' rowspan='2' width='50' >ลบ</Td><Td align='center' width='50' rowspan='2'>แก้ไข</Td></Tr>";
echo "<tr bgcolor='#CC9900'><Td align='center' width='110'>เริ่ม</Td><Td align='center' width='110'>สิ้นสุด</Td></tr>";
$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$prename = $result['prename'];
		$name = $result['name'];
		$surname = $result['surname'];
		$fromprename = $result['fromprename'];
		$fromname = $result['fromname'];
		$fromsurname = $result['fromsurname'];
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
		echo "<Tr bgcolor=$color><Td align='center'>$M</Td>";
		echo "<Td align='center'>".thai_date_3($result['start'])."</Td>";
		echo "<Td align='center'>".thai_date_3($result['finish'])."</Td>";
		$sql_position = "select position_name from person_position where position_code='$result[from_position_code]'";
		$dbquery_position = mysqli_query($connect,$sql_position);
		$result_position = mysqli_fetch_array($dbquery_position);
		echo "<Td align='left'>$fromprename$fromname $fromsurname<br>(".$result_position['position_name'].")</Td>";
		$sql_position = "select position_name from person_position where position_code='$result[position_code]'";
		$dbquery_position = mysqli_query($connect,$sql_position);
		$result_position = mysqli_fetch_array($dbquery_position);
		echo "<Td align='left'>$prename$name $surname<br>(".$result_position['position_name'].")</Td>";
		echo "
		<Td align='center'><a href=?option=person&task=delegate&index=2&id=$id&page=$page><img src=images/drop.png border='0' alt='ลบ'></a></Td>
		<Td align='center'><a href=?option=person&task=delegate&index=5&id=$id&page=$page><img src=images/edit.png border='0' alt='แก้ไข'></a></Td>
	</Tr>";
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}
echo "</Table>";
}

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=person&task=delegate");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
		}else{
			callfrm("?option=person&task=delegate&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=person&task=delegate");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
		}else{
			callfrm("?option=person&task=delegate&index=6");   //page ประมวลผล
		}
	}
}
</script>
