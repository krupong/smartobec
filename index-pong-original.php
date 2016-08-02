<?php
session_start();
/** Set flag that this is a parent file */
define( "_VALID_", 1 );
require_once "database_connect.php";

if(isset($_POST['login_submit'])){
  require_once "include/login_chk.php";
}

// Define Variable
if(!isset($_SESSION['login_user_id'])){ $_SESSION['login_user_id']=""; }
if(!isset($_SESSION['login_name'])){ $_SESSION['login_name']=""; }
if(!isset($_SESSION['login_surname'])){ $_SESSION['login_surname']=""; }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SMART-OBEC</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
if(isset($_SESSION['user_os'])){
	if($_SESSION['user_os']=='mobile'){
	echo "<meta name = 'viewport' content = 'width = device-width'>";
	}
}
if(isset($_POST['user_os'])){
	if($_POST['user_os']=='mobile'){
	echo "<meta name = 'viewport' content = 'width = device-width'>";
	}
}

?>
<!-- <link rel="stylesheet" href="css/mm_training.css" type="text/css" /> -->

<!-- Beginning of compulsory code below -->

<!-- <link href="css/dropdown/dropdown.css" media="all" rel="stylesheet" type="text/css" /> -->
<!-- <link href="css/dropdown/themes/adobe.com/default.advanced.css" media="all" rel="stylesheet" type="text/css" /> -->
<!-- <script type="text/javascript" src="main_js.js"></script> -->

<!-- Bootstrap Include -->
<link rel="stylesheet" type="text/css" href="./bootstrap-3.3.5-dist/css/bootstrap.min.css">
<script src="./bootstrap-3.3.5-dist/js/jquery-1.11.3.min.js"></script>
<script src="./bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<script src="./bootstrap-3.3.5-dist/js/bootstrap-confirmation.min.js"></script>
<script src="./ckeditor_4.5.2_full/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">
        <!-- <img src="images/logo-small.png" class="img-responsive" alt="Responsive image"> -->
        SMART-OBEC
      </a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
            <li><a href="index.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;หน้าหลัก <span class="sr-only">(current)</span></a></li>
        <?php
        if($_SESSION['login_user_id']!=""){
          if(!isset($_GET["option"])){ $_GET["option"]=""; }
          if($_GET["option"]==""){
            ?>
            <?php
              $sql = "SELECT * FROM system_menugroup ORDER BY menugroup_order";
              if($result = mysqli_query($connect, $sql)){
                while ($row = $result->fetch_assoc()) {
                  echo "<li class='dropdown'>";
                  echo "<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>".$row["menugroup_desc"]."<span class='caret'></span></a>";
                  echo    "<ul class='dropdown-menu' role='menu'>";
                  $sqlmodule = "SELECT * FROM system_module WHERE workgroup=".$row["menugroup"]." and module_active=1 ORDER BY module_order";
                  if($resultmodule = mysqli_query($connect, $sqlmodule)){
                    while ($rowmodule = $resultmodule->fetch_assoc()) {
                      echo "<li><a href='index.php?option=".$rowmodule["module"]."'>".$rowmodule["module_desc"]."</a></li>";
                    }
                  }
                  echo    "</ul>";
                  echo "</li>";
                }
              }
          }else{
            require_once("modules/".$_GET["option"]."/menu.php");
          }
        }
        ?>
      </ul>
      <form class="navbar-form navbar-right" role="search" action="index.php" method="POST">
          <?php
          if($_SESSION['login_user_id']==""){
          ?>
            <div class="form-group">
              <span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;
              <input id="username" name="username"type="text" class="form-control" placeholder="ชื่อผู้ใช้งาน">
              <input id="pass" name="pass"type="password" class="form-control" placeholder="รหัสผ่าน">
            </div>
            <button id="login_submit" name="login_submit" type="submit" class="btn btn-primary">เข้าสู่ระบบ</button>
          <?php
          }else{
          ?>
            <div class="form-group">
              <span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;
              <input id="username" name="username"type="text" class="form-control" value="ผู้ใช้ : <?php echo $_SESSION['login_name'].' '.$_SESSION['login_surname']; ?>" disabled>
            </div>
            <a href="logout.php" class="btn btn-primary">ออกจากระบบ</a>
          <?php
          }
          ?>
      </form>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<!-- End Navvar -->
<br><br><br>
<?php

if(!isset($_SESSION['AMSSPLUS'])){
	require_once('login.php');
	exit();
}

if((!isset($_SESSION['login_user_id'])) and (!isset($_POST['system_multi_school']))){
	require_once('login.php');
	exit();
}

if(isset($system_office_code)){
		if($_SESSION['office_code']!=$system_office_code){
			require_once('login.php');
			exit();
		}
}

require_once("mainfile.php");
$PHP_SELF = "index.php";

if(!isset($_REQUEST['option'])){
  $_REQUEST['option']="";
}
if(!isset($_GET['option'])){
  $_GET['option']="";
}
if(!isset($_REQUEST['file'])){
  $_REQUEST['file']="";
}
if(isset($_REQUEST['index'])){
  $index=$_REQUEST['index'];
}
else{
  $index="";
}

GETMODULE($_REQUEST['option'],$_REQUEST['file']);

if($_SESSION['user_os']=='mobile'){
  //require_once "index_mobile.php";
  require_once "index_desktop.php";
}
else{
  require_once "index_desktop.php";
}
mysqli_close($connect);
?>
<noscript>
!Warning! Javascript must be enabled for proper operation of the Administrator
</noscript>
</body>
</html>
