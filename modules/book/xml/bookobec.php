<?php
header("Cache-Control: no-store, no-cache, must-revalidate");             
header("Cache-Control: post-check=0, pre-check=0", false);   
echo '<?xml version="1.0" encoding="utf-8"?>';

require_once "../../../database_connect.php";	

/////////////////////////
$sync_ok=0;
$person_ok=0;
$date = date("Y-m-d");
			//ตรวจสอบการ Sync
			$sql = "select * from  system_sync where office_code='$_GET[office_code]'";
			$dbquery = mysqli_query($connect,$sql);
			$result = mysqli_fetch_array($dbquery);
			$sync=md5($date.$result['sync_code']);
			if($sync==$_GET['sync_code']){
			$sync_ok=1;
			}

			//ตรวจสอบการเป็นบุคลากร สพท.
			$sql_person = "select * from person_khet_main where khet_code='$_GET[office_code]' and person_id='$_GET[person]' and status='0'";
			$dbquery_person = mysqli_query($connect,$sql_person);
			$result_person = mysqli_fetch_array($dbquery_person);
			if($result_person){
			$person_ok=1;
			}
			else{
			$sql_person = "select * from person_special_main where unit_code='$_GET[office_code]' and person_id='$_GET[person]' and status='0'";
			$dbquery_person = mysqli_query($connect,$sql_person);
			$result_person = mysqli_fetch_array($dbquery_person);
					if($result_person){
					$person_ok=1;
					}
					else{
					$sql_person = "select * from person_sch_main where school_code='$_GET[office_code]' and person_id='$_GET[person]' and status='0'";
					$dbquery_person = mysqli_query($connect,$sql_person);
					$result_person = mysqli_fetch_array($dbquery_person);
							if($result_person){
							$person_ok=1;
							}
					}
			}
$_GET['office_code']=trim($_GET['office_code']);			
//////////////////////////////////
if($sync_ok==1 and $person_ok==1){
$sql="select * from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id and  book_sendto_answer.send_to='$_GET[office_code]' and book_sendto_answer.status is null and answer is null order by book_main.ms_id";
$objQuery = mysqli_query($connect,$sql);
$num_row=mysqli_num_rows($objQuery);
		if($num_row<1){
		$text="ไม่มีหนังสือราชการใหม่ที่ยังไม่ได้รับ";
		$book_actice=0;
		}
		else{
		$text="";
		$book_actice=1;
		}
$day_now=date("Y-m-d H:i:s");
?>
<info>
	<office_code><?php echo base64_encode($text);?></office_code>
	<book_active><?php echo base64_encode($book_actice);?></book_active>
	<bookobec>
			<?php
			while($obResult=mysqli_fetch_array($objQuery))
			{
			//ลงทะเบียนหนังสือรับ
			$sql_answer = mysqli_query($connect,"update book_sendto_answer set answer='1', answer_time='$day_now' where ref_id='$obResult[ref_id]' and send_to='$_GET[office_code]'") ;
			?>
			<item>
				<ms_id><?php echo base64_encode($obResult['ms_id']);?></ms_id>
				<bookno><?php echo base64_encode($obResult['book_no']);?></bookno>
				<ref_id><?php echo base64_encode($obResult['ref_id']);?></ref_id>
				<level><?php echo base64_encode($obResult['level']);?></level>
				<signdate><?php echo base64_encode($obResult['signdate']);?></signdate>
				<subject><?php echo base64_encode($obResult['subject']);?></subject>
				<detail><?php echo base64_encode($obResult['detail']);?></detail>
				<send_date><?php echo base64_encode($obResult['send_date']);?></send_date>
			</item>
		<?php
		}
		?>
	</bookobec>
</info>
<?php
}
else if($sync_ok==0){
?>
<info>
	<office_code><?php echo base64_encode('รหัสเชื่อมระบบกับ Smart Obec ไม่ถูกต้อง กรุณาแจ้งผู้ดูแลระบบ');?></office_code>
	<book_active><?php echo base64_encode('0');?></book_active>
</info>	
<?php
}
else if($person_ok==0){
?>
<info>
	<office_code><?php echo base64_encode('คุณไม่มีชื่ออยู่ในระบบ Smart Obec กรุณาแจ้งผู้ดูแลระบบ');?></office_code>
	<book_active><?php echo base64_encode('0');?></book_active>
</info>	
<?php
}
?>