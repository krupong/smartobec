<?php

//ตรวจสอบว่ามีโมดูลหรือไม่ (โมดูล User)
function GETMODULE($option,$file){
	global $MODPATH, $MODPATHFILE ;
	if(!$option){$option = "default";}
	if(!$file){$file = "index";}
$modpathfile="section/".$option."/".$file.".php";
if (file_exists($modpathfile)) {
	$MODPATHFILE = $modpathfile;
	$MODPATH = "section/".$option."/";
	}else{
	die ("No Page");
	}
}

// รับตัวแปรผนวกไฟล์ในโมดูล
if(isset($_REQUEST['task'])){
$task=$_REQUEST['task'];
$task="$task.php";
}
else {
$task="";
}

?>
