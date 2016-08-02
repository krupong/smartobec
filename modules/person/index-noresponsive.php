<?php
if(isset($_REQUEST['index'])){
$index=$_REQUEST['index'];
}
else{
$index="";
}

if($_SESSION['user_os']=='mobile'){
include("./modules/person/menu_mobile.php");
}
else{
include("./modules/person/menu.php");
}
//ผนวกไฟล์
if($task!=""){
include("$task");
}
else {
include("default.php");
}
?>

