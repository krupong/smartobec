<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php
require_once "../../../database_connect.php";
if(is_numeric($_GET['id'])){
$sql = "select * from car_car where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
		$pic = $result['pic'];
		$name= $result['name'];
echo "<br>";
echo "<div align='center'><img src='../../../$pic' border='0' width='400'></div>";
echo "<br>";
echo "<div align='center'>";
echo $name;
echo "</div>";
}
?>
</body>
</html>

