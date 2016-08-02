<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
$alert=0;
$alert_content="";

///////////////////////////////////////////////////////////
//เตือนmail
$sql_mail_alert = "select  mail_main.ms_id from mail_main left join mail_sendto_answer on mail_main.ref_id=mail_sendto_answer.ref_id where mail_sendto_answer.send_to='$_SESSION[login_user_id]' and mail_sendto_answer.answer<'1' ";
$dbquery_mail_alert = mysqli_query($connect,$sql_mail_alert );
if($dbquery_mail_alert){
		$mail_num=mysqli_num_rows($dbquery_mail_alert);	
		if($mail_num>=1){
		$alert=1;
		$alert_content=$alert_content."มีจดหมายยังไม่ได้รับ  ";
		}
}

/////////////////////////////////////
?>