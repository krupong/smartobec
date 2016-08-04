<?php
// Class เก็บล็อกของ book
include ("class.smartLog.php");

function saveBookLog($id,$data1,$data2,$data3,$data4,$data5) {
	$gen =new smartLog();

	// key ที่ต้องการ ในที่นี้คือ user,level,date
	$jsonString = '{"book_table":"'.$data1.'","book_idsystem":"'.$data2.'","book_num":"'.$data3.'","book_processdate":"'.$data4.'","book_refid":"'.$data5.'"}';
	$gen = new smartLog();
	$gen->setRef_id($id);
	$gen->setLogdata($jsonString);
	$gen->insert();
}

function addBookLog($id,$data1,$data2,$data3,$data4,$data5) {
	$gen = new smartLog();
	$gen->selectWhere('ref_id',$id);

	// key ที่ต้องการ ในที่นี้คือ user,level,date
	$jsonString = $gen->getLogdata().',{"book_table":"'.$data1.'","book_idsystem":"'.$data2.'","book_num":"'.$data3.'","book_processdate":"'.$data4.'","book_refid":"'.$data5.'"}';
	$gen->setRef_id($id);
	$gen->setLogdata($jsonString);
	$gen->update($gen->getId());
}

function getBooklog($id) {
	$gen = new smartLog();
	$gen->selectWhere('ref_id',$id);
	return '['.$gen->getLogdata().']';
}
?>
