<?php
header("Content-type: application/xhtml+xml; charset=utf-8"); 
header("Cache-Control: no-cache, must-revalidate"); 

require_once("../../database_connect.php");
$sql = "select * from  person_main where sub_department ='".$_GET['sub_department']."' order by position_other_code DESC";
$query = mysqli_query($connect,$sql);
echo "<option value=''></option>";
while($result = mysqli_fetch_array($query)){
	$person_id = $result['person_id'];
	$prename = $result['prename'];
	$name = $result['name'];
	$surname = $result['surname'];
echo "<option value='$person_id'>$prename$name&nbsp;$surname</option>";
}
?>
