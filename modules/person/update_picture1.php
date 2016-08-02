<?php
/** ensure this file is being included by a parent file */

defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
if(!(($_SESSION['admin_person']=="person") or ($_SESSION['login_status']==99) or ($_SESSION['login_status']<=4 and $result_permission['p1']==1))){	
exit();
}

if($index==1) {
$sql = "select * from person_main where status='0'";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)){

		$id = $result['id'];
		$person_id = $result['person_id'];
		$pic = $result['pic'];
		
		$str_imgfullpath="modules/person/picture/".$person_id.".jpg";
		if($pic==""){
			if (file_exists($str_imgfullpath)){
			$sql2 = "update person_main set pic='$str_imgfullpath' where id='$id'";
			$dbquery2 = mysqli_query($connect,$sql2);
			}
		}	
}
echo "<script>document.location.href='?option=person&task=person';</script>\n";
}

echo "<br>";
echo "<table width='70%' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='3'>การปรับปรุงไฟล์รูปภาพ จะต้องนำไฟล์รูปภาพประเภท jpg ชื่อตามเลขประจำตัวประชนของบุคลากร<br>ไปเก็บไว้ในโฟลเดอร์ picture ของโมดูลบุคลากรก่อน</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<br>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=person&task=	update_picture1&index=1\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=person\"'";

echo "</td></tr></table>";

