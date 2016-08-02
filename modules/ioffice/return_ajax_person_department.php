<?php
header("Content-type: application/xhtml+xml; charset=utf-8"); 
header("Cache-Control: no-cache, must-revalidate"); 

require_once("../../database_connect.php");
if($_GET['department']==-1){
	$sql = "select pm.*,pp.position_name from person_main pm left join person_position pp on(pm.position_code=pp.position_code) where pm.position_code<=30 and pm.status=0 order by pm.position_code ASC";
}else{
	$sql = "select pm.*,pp.position_name from person_main pm left join person_position pp on(pm.position_code=pp.position_code) where pm.department ='".$_GET['department']."' and pm.status=0 order by pm.sub_department ASC,pm.position_other_code DESC";
}

$query = mysqli_query($connect,$sql);
echo "<option value=''>เลือกบุคลากร</option>";
while($result = mysqli_fetch_array($query)){
	$person_id = $result['person_id'];
	$prename = $result['prename'];
	$name = $result['name'];
	$surname = $result['surname'];
	$position_code = $result['position_code'];
	$department = $result['department'];
	$position_other_code = $result['position_other_code'];
	$position_name = "";
	if($position_code<=30){
		$position_name = ": ".$result['position_name'];
	}
	if($position_code==9){
		$sql_department = "select * from system_department sd where sd.department='$department'";
		$resutl_department = mysqli_query($connect,$sql_department);
		$row_department = $resutl_department->fetch_assoc();
		$department_name = $row_department['department_name'];
		$position_name = ": ผู้อำนวยการ".$department_name;
	}
	if($position_other_code>0){
		$sql_other = "select * from system_subdepartment ss where ss.sub_department='$position_other_code'";
		$resutl_other = mysqli_query($connect,$sql_other);
		$row_other = $resutl_other->fetch_assoc();
		$position_other_name = $row_other['sub_department_name'];
		if($position_name==''){
			$position_name = ': ผู้อำนวยการ'.$position_other_name; 
		}else{
			$position_name = $position_name.', ผู้อำนวยการ'.$position_other_name; 
		}
	}
echo "<option value='$person_id'>$prename$name&nbsp;$surname $position_name</option>";
}
?>
