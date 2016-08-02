<?php
header("Content-type: application/xhtml+xml; charset=utf-8");
header("Cache-Control: no-cache, must-revalidate");

require_once("../../../database_connect.php");
$value=$_GET['car_type'];
$tmp = explode(":", $value);
$sql_ajax = "select * from  car_car a left outer join car_main b on a.car_code=b.car where a.car_type='$tmp[0]' order by a.car_number";
$query_ajax = mysqli_query($connect,$sql_ajax);
echo "<option value=''>เลือก</option>";
while($result_ajax = mysqli_fetch_array($query_ajax)){
	$car_number = $result_ajax['car_number'];
    $car_code = $result_ajax['car_code'];
	$name = $result_ajax['name'];
    $id = $result_ajax['id'];
    
    $sql_ajax2 = "select * from car_main 
    where car='$result_ajax[car_code]' and ('$tmp[1]' between car_start and car_finish)";
    $dbquery_ajax2 = mysqli_query($connect,$sql_ajax2);
    $num_rows = mysqli_num_rows($dbquery_ajax2);
    if($num_rows==0){
        echo "<option value='$car_code'>$car_number $name</option>";
    }
}
?>