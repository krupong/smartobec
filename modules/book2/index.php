<?php
if(isset($_GET['index'])){
$index=$_GET['index'];
}
else{
$index="";
}

//ผนวกเมนู
if($_SESSION['user_os']=='mobile'){
$module_menu_path="./modules/book2/menu_mobile.php";
}
else{
$module_menu_path="./modules/book2/menu.php";
}
if(file_exists($module_menu_path)){
require_once("$module_menu_path");
}
else{
die ("No MenuPage");
}

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

  <head>
    <!-- รวมสคริปหัวเว็บ -->
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="./modules/book2/bootstrap/css/bootstrap.min.css">
    <!--  JQuery UI 1.11.4 -->
    <link rel="stylesheet" href="./modules/book2/plugins/jQueryUI/jquery-ui.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="./modules/book2/dist/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="./modules/book2/dist/css/ionicons.min.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="./modules/book2/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="./modules/book2/dist/css/AdminLTE.min.css">
    <!-- Theme style -->
    <!--<link rel="stylesheet" href="modules/book2/dist/css/AdminLTE.css">-->
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="./modules/book2/dist/css/skins/_all-skins.min.css">
    <!-- Table Style -->
    <link rel="stylesheet" href="./modules/book2/plugins/datatables/dataTables.bootstrap.css">
    <!-- Selection Style -->
    <link rel="stylesheet" href="./modules/book2/plugins/selection/bootstrap-select.min.css"> 
    <!-- Select2 Style -->
    <link rel="stylesheet" href="./modules/book2/plugins/select2/select2.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- End Head Script -->
    
    <!-- daterange picker -->
    <link rel="stylesheet" href="./modules/book2/plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="./modules/book2/plugins/iCheck/all.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="./modules/book2/plugins/colorpicker/bootstrap-colorpicker.min.css">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="./modules/book2/plugins/timepicker/bootstrap-timepicker.min.css">

    <!-- Bootstrap Date Picker -->
    <!--<link rel="stylesheet" href="modules/book2/plugins/datepicker/datepicker3.css">-->
    <link rel="stylesheet" href="./modules/book2/plugins/datepicker/dist/css/bootstrap-datepicker.standalone.css">
    
    <!-- Bootstrap Input file -->
    <link rel="stylesheet" href="./modules/book2/plugins/inputfile/fileinput.min.css">

    <!-- Bootstrap Tree View -->
    <link rel="stylesheet" href="./modules/book2/plugins/treeview/bootstrap-treeview.css">

    <!-- Bootstrap Fancy Tree -->
    <link rel="stylesheet" href="./modules/book2/plugins/fancytree/ui.fancytree.css">

     <link href="./modules/book2/plugins/toggle/css/bootstrap-toggle.min.css" rel="stylesheet">

    
  </head>
  
  
