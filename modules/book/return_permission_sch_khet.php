<?php
header("Content-type: application/xhtml+xml; charset=utf-8"); 
header("Cache-Control: no-cache, must-revalidate"); 

require_once("../../database_connect.php");
$sql = "select * from  person_khet_main  where status='0' and khet_code='".$_GET['khet_code']."' order by position_code,name";
$query = mysqli_query($connect,$sql);
echo "<option value=''>เลือกบุคลากร</option>";
while($result = mysqli_fetch_array($query)){
	$person_id = $result['person_id'];
	$prename = $result['prename'];
	$name = $result['name'];
	$surname = $result['surname'];
echo "<option value='$person_id'>$prename$name $surname</option>";
}
/*
$sql = "select * from  person_khet_other left join person_khet_main on person_khet_other.person_id=person_khet_main.person_id where person_khet_main.status='0' and person_khet_other.status='0' and person_khet_other.khet_code='".$_GET['khet_code']."' order by position_code,name";
$query = mysqli_query($connect,$sql);
while($result = mysqli_fetch_array($query)){
	$person_id = $result['person_id'];
	$prename = $result['prename'];
	$name = $result['name'];
	$surname = $result['surname'];
echo "<option value='$person_id'>$prename$name $surname</option>";
}
*/
?>
