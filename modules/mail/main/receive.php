<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

if(isset($_REQUEST['switch_index'])){
	$switch_index=$_REQUEST['switch_index'];
}else{
	$switch_index="";
}

if(isset($_REQUEST['name_search'])){
	$name_search=$_REQUEST['name_search'];
}else{
	$name_search="";
}

if(!($_SESSION['login_group']==1)){
exit();
}
require_once "modules/mail/time_inc.php";	
$user=$_SESSION['login_user_id'];

//ส่วนหัว
//echo "<br />";
//echo "<div class='container padding'>";
?>
<div class="box box-success">
	<div class="box-header">
        <i class="fa fa-sign-in"></i>
		<h3 class="box-title">กล่องจดหมายเข้า</h3>
	</div>
	<div class="box-body">
		<!-- ส่วนแสดงผล -->
<?php
if(!($index==4)){
echo "<table width='100%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong></strong></font></td></tr>";
echo "</table>";
}

//ส่วนบันทึกข้อมูลการลงรับจดหมาย
if(isset($_GET['index'])){
$getindex=mysqli_real_escape_string($connect,$_GET['index']);
}else {$getindex="";}
if(isset($_GET['id'])){
$getid=mysqli_real_escape_string($connect,$_GET['id']);
}else {$getid="";}
if($getindex==2 && $getid!=""){
$sql = "select * from  mail_main left join person_main on mail_main.sender=person_main.person_id where mail_main.ms_id='$getid' ";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
$sender=$result['sender'];
$ref_id=$result['ref_id'];
$detail=$result['detail'];
$send_date=$result['send_date'];
		$prename=$result['prename'];
		$name= $result['name'];
		$surname = $result['surname'];
		$full_name="$prename$name&nbsp;&nbsp;$surname";
$thai_send_date=thai_date_4($send_date);

    
//บันทึกรับ
$day_now=date("Y-m-d H:i:s");
$query_receive =mysqli_query($connect,"select * from mail_sendto_answer where ref_id='$ref_id' and send_to='$user' and answer='0' ");
$receive_num=mysqli_num_rows($query_receive);
		
		if($receive_num>=1){
		$sql = "update mail_sendto_answer set answer='1', 
		answer_time='$day_now'
		where ref_id='$ref_id' and send_to='$user' ";
		mysqli_query($connect,$sql);
		}


    echo "<script>document.location.href='?option=mail&task=main/receive'; </script>\n";
}



//ส่วนแสดงผล
if(!($index==4)){
			if(isset($_REQUEST['return_index'])==8){
			$index=8;
			}
//ส่วนของการแยกหน้า
if($index==8 and ($_REQUEST['name_search']!="")){
$sql="select * from mail_main left join mail_sendto_answer on mail_main.ref_id=mail_sendto_answer.ref_id where mail_sendto_answer.send_to='$user'  and mail_main.subject like '%$_REQUEST[name_search]%' ";
}
else{
$sql="select mail_main.ms_id from mail_main left join mail_sendto_answer on mail_main.ref_id=mail_sendto_answer.ref_id where mail_sendto_answer.send_to='$user' ";
}
$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery );

$pagelen=20;  // 1_กำหนดแถวต่อหน้า
$url_link="option=mail&task=main/receive&index=$index&name_search=$name_search";  // 2_กำหนดลิงค์
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

////////////////////ค้นหาบุคคล

echo "<p><form id='frm1' name='frm1'>";
echo "<table width='95%' align='center'><tr><td align='right'>";

echo "ค้นหาด้วยชื่อเรื่อง&nbsp;";
		if($index==8){
		echo "<Input Type='Text' Name='name_search' value='$_REQUEST[name_search]' >";
		}
		else{
		echo "<Input Type='Text' Name='name_search' Size='30'>";
		}
echo "&nbsp;<INPUT TYPE='button' name='smb'  value='ค้น' onclick='goto_display(1)'>";
echo "";
echo "</td></tr></table>";
echo "</form></p>";

//////////////////////////////////////////

if($index==8 and ($_REQUEST['name_search']!="")){
$sql="select * from mail_main left join mail_sendto_answer on mail_main.ref_id=mail_sendto_answer.ref_id where mail_sendto_answer.send_to='$user'  and  mail_main.subject like '%$_REQUEST[name_search]%' order by mail_main.ms_id desc limit $start,$pagelen";
}
else{
$sql="select * from mail_main left join mail_sendto_answer on mail_main.ref_id=mail_sendto_answer.ref_id where mail_sendto_answer.send_to='$user' order by mail_main.ms_id desc limit $start,$pagelen";
}
$dbquery = mysqli_query($connect,$sql);
echo  "<table width='90%' border='1' style='border-collapse: collapse' class='table table-striped table-bordered table-hover' align='center'>";

echo "<Tr bgcolor='#99ccff' class='info' align='center'><Td class='col-sm'>เลขที่</Td><Td class='col-sm'>จดหมายจาก</Td><Td class='col-sm'>วันที่ส่ง</Td><Td class='col-sm'>เรื่อง</Td><Td width='20'>รับ</Td><Td width='20'>รายละเอียด</Td></Tr>";

$N=(($page-1)*$pagelen)+1; //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery)){
$sch_person_index=0;
		$id = $result['ms_id'];
		$subject = $result['subject'];
		$sender = $result['sender'];
        $detail = $result['detail'];
		$ref_id = $result['ref_id'];
		$rec_date = $result['send_date'];
		$answer_time=$result['answer_time'];
			if(($M%2) == 0)
			$color="#E5E5FF";
			else  	$color="#FFFFFF";
			
		$query_person=mysqli_query($connect,"SELECT * FROM  person_main WHERE person_id='$sender' ") ;
		$result_person=mysqli_fetch_array($query_person);
		$prename=$result_person['prename'];
		$name= $result_person['name'];
		$surname = $result_person['surname'];
		
										//กรณีโรงเรียน
					if($name==""){
					$sql_sch= "select * from person_sch_main, system_school where person_sch_main.school_code=system_school.school_code and person_id='$sender' ";
					$dbquery_sch= mysqli_query($connect,$sql_sch);
					$result_sch=mysqli_fetch_array($dbquery_sch);
					$prename=$result_sch['prename'];
					$name= $result_sch['name'];
					$surname = $result_sch['surname'];
					$sch_person_index=1;
					}

		$full_name="$prename$name&nbsp;&nbsp;$surname";
			
echo "<Tr bgcolor='$color'><Td align='center'>$id</Td><Td align='left'>$full_name</Td><Td align='left'>";
echo thai_date_4($rec_date);
echo "</Td><Td align='left'>";
?>

                      <!-- Modal for Read -->
                        <A class="default" data-toggle="modal" data-target="#myModal<?php echo $id; ?>"><span style="text-decoration: none"><?php echo $subject; ?></span></A>
                      
                      <div class="modal fade bs-example-modal-lg" id="myModal<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <div class="row">
                                <div class="col-md-12 text-left">
                                    <h3>รายละเอียดของจดหมาย</h3>
                                </div>
                              </div>
                            </div>
                            <div class="modal-body">
                              <div class="well">
                                <h4 class="modal-title" id="myModalLabel">เรื่อง : <?php echo $subject; ?></h4>
                              </div>
                              <h4>รายละเอียด : </h4>
                              <?php echo $detail; ?>
                              <hr>

                              <?php
                              $sqlfile = "SELECT * FROM  mail_filebook WHERE  ref_id = '$ref_id'";
                              $resultfile = mysqli_query($connect,$sqlfile);
                              $fnum = 0;
                              $row_cnt = mysqli_num_rows($resultfile);
                                if($row_cnt>0){
                              echo "<h4>เอกสารแนบ : </h4>";
                              while ($rowfile = $resultfile->fetch_assoc()) {
                                echo "<p><a href='./upload/mail/upload_files/".$rowfile["file_name"]."' class='btn btn-default' target='_blank'><span class='badge badge-sm'>".++$fnum."</span>&nbsp;".$rowfile["file_des"]."</a></p>";
                              }
                            echo "<hr>";
                                      }
                              ?>
                                                              
                              <h5>โดย : <?php echo $full_name; ?></h5>
                              <h5>เมื่อ : <?php echo ThaiTimeConvert(strtotime($rec_date),"","2");?></h5>
                              <hr>
                            </div>
                            <div class="modal-footer">
<form Enctype = multipart/form-data id='frm1' name='frm1' action="?option=mail&task=main/reply&index=1" method="post"  target="_blank" >

<!-- Bootstrap Confirmation -->
<script>
	$('[data-toggle="confirmation"]').confirmation({
    title: "<B>กรุณายืนยัน</B>",
    btnOkLabel: "<i class='icon-ok-sign icon-white'></i> ยืนยัน",
    btnCancelLabel: "<i class='icon-remove-sign'></i> ยกเลิก",   
    singleton: "true",
    popout: "true"
    })
</script>

<!-- Bootstrap Confirmation -->
<script>
	$('[data-toggle="validator"]').validator()
</script>
    
    
                              <button type="button" class="btn btn-warning" onclick="window.location.href='?option=mail&task=main/receive&index=2&id=<?php echo $id;?>'"><span class='glyphicon glyphicon-ok' aria-hidden='true'></span>&nbsp;รับจดหมาย</button>

                            <input name='resender' type='hidden' value='<?php echo $sender;?>'>
                            <input name='redetail' type='hidden' value='<?php echo $detail;?>'>
                            <input name='rerec_date' type='hidden' value='<?php echo $rec_date;?>'>
                            <input name='resubject' type='hidden' value='<?php echo $subject;?>'>
                            <input name='reid' type='hidden' value='<?php echo $id;?>'>
    
                              <button type="submit" class="btn btn-success" ><span class='glyphicon glyphicon-repeat' aria-hidden='true'></span>&nbsp;ตอบกลับจดหมาย</button>
     

                            <button type="button" class="btn btn-default" data-dismiss="modal"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span>&nbsp;ปิด</button>
    </form>  
                            </div>
                          </div>
                        </div>
                      </div>




<?php
if(($sch_person_index==1) and ($_SESSION['login_status']<=4)){
echo " [$result_sch[school_name]]";
}
echo "</Td>";

            if($result['answer']==1){
			echo "<td align='center'><img src=images/yes.png border='0' alt='รับแล้ว'></td>";
			}
			else{
			echo "<td align='center'><img src=images/no.png border='0' alt='ยังไม่ได้รับ'></td>";
			}

    
echo "<td align='left'>";
?>
    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal<?php echo $id; ?>"><span style="text-decoration: none">รายละเอียด</span></button>

<?php
echo "</td>";
echo "</Tr>";

$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
}	
echo "</Table>";
}

?>
	<!-- จบ ส่วนแสดงเนื้อหา -->
	</div>
</div>
<!--</div>-->
<script>
function goto_display(val){
	if(val==1){
		callfrm("?option=mail&task=main/receive&index=8&switch_index=1"); 
		}
}
</script>

