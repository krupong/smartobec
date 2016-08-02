<?php
header("Content-type: application/xhtml+xml; charset=utf-8");
header("Cache-Control: no-cache, must-revalidate");

require_once("../../../database_connect.php");
$sql = "select * from  system_subdepartment where department='".$_GET['department']."' order by department";
$query = mysqli_query($connect,$sql);
echo "<option value=''>เลือก</option>";
while($result = mysqli_fetch_array($query)){
	$sub_department = $result['sub_department'];
	$sub_department_name = $result['sub_department_name'];
echo "<option value='$sub_department'>$sub_department_name</option>";
}
?>