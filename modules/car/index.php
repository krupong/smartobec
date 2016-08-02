<?php
/*
error_reporting(E_ALL);
ini_set("display_errors", 1);
*/
require_once "modules/car/time_inc.php";
require_once "modules/car/functions.php";

//ผนวกเมนู
if($_SESSION['user_os']=='mobile'){
$module_menu_path="./modules/$_REQUEST[option]/menu_mobile.php";
}
else{
$module_menu_path="./modules/$_REQUEST[option]/menu.php";
}


if(file_exists($module_menu_path)){
require_once("$module_menu_path");
}
else{
die ("No MenuPage");
}



?>
    <link href="./bootstrap-3.3.5-dist/css/bootstrap.css" rel="stylesheet" media="screen">

<!--Bootstrap datepicker -->
    
    <link href="./modules/car/datepicker/css/datepicker.css" rel="stylesheet" media="screen">
    <script src="./modules/car/datepicker/js/bootstrap-datepicker.js"></script>
    <script src="./modules/car/datepicker/js/bootstrap-datepicker-thai.js"></script>
    <script src="./modules/car/datepicker/js/locales/bootstrap-datepicker.th.js"></script>

<!--Bootstrap selectpicker -->
<script src="./modules/car/js/bootstrap-select.min.js"></script>
<link href="./modules/car/css/bootstrap-select.min.css" rel="stylesheet" media="screen">
<!-- Bootstrap Select Picker -->

<?php 
//ผนวกไฟล์
if($task!=""){
			$module_file_path="modules/$_REQUEST[option]/".$task;
			if(file_exists($module_file_path)){
			require_once("$module_file_path");
			}else{
			die ("No Page");
			}
}
else {
			$module_file_path="modules/$_REQUEST[option]/"."default.php";
			if(file_exists($module_file_path)){
			require_once("$module_file_path");
			}else{
			die ("No DefaultPage");
			}
}

?>
<!-- Bootstrap Popover -->
<script>
$(function () {
 		$('[data-toggle="popover"]').popover()
})
</script>
<!-- Bootstrap Confirmation -->
<script>
	$('[data-toggle="confirmation"]').confirmation()
</script>
