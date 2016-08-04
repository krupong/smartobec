<?php
include '../../include/logUtil.php';

// เพิ่ม log ใหม่
//saveBookLog('12345', "sssssss", "ssssss",'ssssssssss');

// เพิ่ม log ใน ref_id เดิม
//addBookLog('12345', "aaaaaaaaaaa", "aaaaaaaaaa",'aaaaaaaaaaaaaaaa');

// แสดง log
$jsons = json_decode(getBooklog('12345'));
foreach ($jsons as $json) {
	echo "ค่า user = ".$json->user. " ค่า level = ".$json->level." ค่า date = ".$json->date."<br />";
}
?>
