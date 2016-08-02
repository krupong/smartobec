<script type="text/javascript" src="./css/js/calendarDateInput2.js"></script> 

<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
require_once "person_chk.php";	
require_once "modules/book/time_inc.php";	
$user=$_SESSION['login_user_id'];


			$sql_sendto = "select khet_code from system_khet where khet_code != '$khet_code'    order by khet_code";
			$dbquery_sendto = mysqli_query($connect,$sql_sendto);
					While ($result_sendto = mysqli_fetch_array($dbquery_sendto)){
					//$sql=	"insert into book_sendto_answer (send_level, ref_id, send_to) values ('3', '$_POST[ref_id]','$result_sendto[khet_code]')";

					$dbquery = mysqli_query($connect,$sql);

echo  "<br><br><br><br><br>$result_sendto[khet_code]";
?>