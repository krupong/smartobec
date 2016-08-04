<?php
include '../../include/logUtil.php';

// เพิ่ม log ใหม่
//saveBookLog('1113', "ssssss",'ssssssssss','พพพพพพพพพพพพพพ','ดดดดดดดดดดดดดด','allllllllllllllllสสสสสสสสสสสสสส');

// เพิ่ม log ใน ref_id เดิม
addBookLog('1113', "ssssss",'ssssssssss','พพพพพพพพพพพพพพ','ดดดดดดดดดดดดดด','dddddddd','หหหหหหหหหหหหหหหห');

// แสดง log
$jsons = json_decode(getBooklog('1111'));
foreach ($jsons as $json) {
	echo "ค่า book_table = ".$json->book_table. "<br />ค่า book_idsystem = ".$json->book_idsystem."<br /> ค่า book_num = ".$json->book_num
	."<br />ค่า book_processdate = ".$json->book_processdate."<br />ค่า book_refid = ".$json->book_refid."<br />==========<br />";
}
?>
