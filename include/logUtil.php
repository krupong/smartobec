<?php
// Class เก็บล็อกของ book
include ("class.smartLog.php");

function saveBookLog($id,$data1,$data2,$data3) {
	$gen =new smartLog();
	
	// key ที่ต้องการ ในที่นี้คือ user,level,date
	$jsonString = '{"user":"'.$data1.'","level":"'.$data2.'","date":"'.$data2.'"}';
	$gen = new smartLog();
	$gen->setRef_id($id);
	$gen->setLogdata($jsonString);
	$gen->insert();
}

function addBookLog($id,$data1,$data2,$data3) {
	$gen = new smartLog();
	$gen->selectWhere('ref_id',$id);
	
	// key ที่ต้องการ ในที่นี้คือ user,level,date
	$jsonString = $gen->getLogdata().',{"user":"'.$data1.'","level":"'.$data2.'","date":"'.$data2.'"}';
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