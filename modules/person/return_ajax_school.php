<?php
header("Content-type: application/xhtml+xml; charset=utf-8"); 
header("Cache-Control: no-cache, must-revalidate"); 

require_once("../../database_connect.php");
$sql = "select * from  system_school where khet_code='".$_GET['khet_code']."' order by school_type,school_code";
$query = mysqli_query($connect,$sql);
echo "<option value=''>ทั้งหมด</option>";
while($result = mysqli_fetch_array($query)){
	$school_code = $result['school_code'];
	$school_name = $result['school_name'];
echo "<option value='$school_code'>$school_code $school_name</option>";
}
?>
