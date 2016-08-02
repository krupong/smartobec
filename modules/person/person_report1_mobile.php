<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

$sql = "select * from  person_position order by position_code";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)){
$position_ar[$result['position_code']]=$result['position_name'];
}

echo "<br />";
echo "<table width='100%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666'><strong>ครูและบุคลากรในสำนักงานเขตพื้นที่การศึกษา</strong></font></td></tr>";
echo "</table>";
echo "<br />";

$sql = "select * from person_main where status='0' order by department,position_code,person_order";
$dbquery = mysqli_query($connect,$sql);
echo  "<table width='100%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td>ที่</Td><Td>ชื่อ</Td><Td>ตำแหน่ง</Td><Td>รูป</Td></Tr>";
$N=1;
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$person_id = $result['person_id'];
		$prename=$result['prename'];
		$name= $result['name'];
		$surname = $result['surname'];
		$position_code= $result['position_code'];
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";

		echo "<Tr bgcolor=$color align='center'><Td>$N</Td><Td align='left'>$prename&nbsp;$name&nbsp;$surname</Td><Td align='left'>";
if(isset($position_ar[$position_code])){		
echo $position_ar[$position_code];
}
echo "</Td>";
if($result['pic']!=""){
echo "<Td align='center'><a href='modules/person/pic_show.php?person_id=$person_id' target='_blank'><img src=images/admin/user.gif border='0' alt='รูปภาพ'></a></Td>";
}
else{
echo "<Td align='center'>&nbsp;</Td>";
}		
echo "</Tr>";
$M++;
$N++;
	}
echo "</Table>";
echo "<br /><br />";
?>
