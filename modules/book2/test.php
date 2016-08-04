<?php
include '../../include/logUtil.php';

// เพิ่ม log ใหม่
saveBookLog('1113', "ssssss",'ssssssssss','พพพพพพพพพพพพพพ','ดดดดดดดดดดดดดด','allllllllllllllllสสสสสสสสสสสสสส');

// เพิ่ม log ใน ref_id เดิม
//addBookLog('1113', "ssssss",'ssssssssss','พพพพพพพพพพพพพพ','ดดดดดดดดดดดดดด','dddddddd');

// แสดง log
$jsons = json_decode(getBooklog('1111'));
foreach ($jsons as $json) {
	echo "ค่า book_table = ".$json->book_table. " ค่า book_idsystem = ".$json->book_idsystem." ค่า book_num = ".$json->book_num
	." ค่า book_processdate = ".$json->book_processdate." ค่า book_refid = ".$json->book_refid."<br />";
}
?>
