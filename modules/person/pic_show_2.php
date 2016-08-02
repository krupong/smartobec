<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
if(isset($_SESSION['user_os'])){
	if($_SESSION['user_os']=='mobile'){
	echo "<meta name = 'viewport' content = 'width = device-width'>";
	}
}
?>
</head>
<body>
<?php
require_once "../../database_connect.php";	

$sql_name = "select * from person_khet_main where person_id='$_GET[person_id]'";
$dbquery_name = mysqli_query($connect,$sql_name);
$result_name = mysqli_fetch_array($dbquery_name);
		$prename=$result_name['prename'];
		$name= $result_name['name'];
		$surname = $result_name['surname'];
		$pic = $result_name['pic'];
$full_name="$prename$name&nbsp;&nbsp;$surname";

echo "<div align='center'><img src='picture/$pic' border='0' width='400'></div>";
echo "<br>";
echo "<div align='center'>";
echo $full_name;
echo "</div>";
?>
</body>
</html>

