<?php
session_start();
/** Set flag that this is a parent file */
define( "_VALID_", 1 );
require_once "database_connect.php";

date_default_timezone_set('Asia/Bangkok');

if(isset($_POST['login_submit'])){
  require_once "include/login_chk.php";
}

// Define Variable
if(!isset($_SESSION['login_user_id'])){ $_SESSION['login_user_id']=""; }
if(!isset($_SESSION['login_name'])){ $_SESSION['login_name']=""; }
if(!isset($_SESSION['login_surname'])){ $_SESSION['login_surname']=""; }
if(!isset($_SESSION['login_group'])){ $_SESSION['login_group']=""; }
if(!isset($_SESSION['office_code'])){ $_SESSION['office_code']=""; }
if(!isset($_GET['option'])){ $_GET['option']=""; }
if(!isset($_GET['task'])){ $_GET['task']=""; }
$module_desc="";

if($_GET["option"]!=""){
  $option = $_GET["option"]; 
}else{
  $option = "";
}
if($_GET["task"]!=""){
  $task = $_GET["task"]; 
}else{
  $task = "";
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SmartOBEC</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
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
  include("include/lib.php");
  ?>

  <!-- AdminLTE template -->
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="adminlte233/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="adminlte233/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="adminlte233/dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="adminlte233/plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="adminlte233/plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="adminlte233/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="adminlte233/plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="adminlte233/plugins/daterangepicker/daterangepicker-bs3.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="adminlte233/dist/css/skins/_all-skins.min.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="adminlte233/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!-- CK Editor -->
  <script src="./ckeditor_4.5.2_full/ckeditor.js"></script>
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="adminlte233/plugins/iCheck/all.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="adminlte233/plugins/colorpicker/bootstrap-colorpicker.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="adminlte233/plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="adminlte233/plugins/select2/select2.min.css">
  <!--<script src="adminlte233/plugins/select2/select2.full.min.js"></script>-->
  <!-- End AdminLTE template -->  

</head>
<body class="hold-transition skin-green-light sidebar-mini">

<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>S</b>O</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Smart</b>OBEC</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <?php if($_SESSION['login_user_id']!="") { ?>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-info">4</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">จดหมายใหม่ 4 ฉบับ</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <img src="adminlte233/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Support Team
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <!-- end message -->
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="adminlte233/dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        AdminLTE Design Team
                        <small><i class="fa fa-clock-o"></i> 2 hours</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="adminlte233/dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Developers
                        <small><i class="fa fa-clock-o"></i> Today</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="adminlte233/dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Sales Department
                        <small><i class="fa fa-clock-o"></i> Yesterday</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="adminlte233/dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Reviewers
                        <small><i class="fa fa-clock-o"></i> 2 days</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">ดูจดหมายทั้งหมด</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-danger">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">คุณมี 10 แจ้งเตือน</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                      page and may cause design problems
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-red"></i> 5 new members joined
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-user text-red"></i> You changed your username
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <?php
          $dep_precis = "";
          switch ($_SESSION["login_group"]) {
            case '1':
              $sqlprecis = "SELECT * FROM person_main pm LEFT JOIN system_department sd ON(pm.department=sd.department) LEFT JOIN person_position pp ON(pm.position_code = pp.position_code) WHERE pm.person_id = '".$_SESSION["login_user_id"]."'";
              $resultprecis = mysqli_query($connect, $sqlprecis);
              $rowprecis = $resultprecis->fetch_assoc();
              if($rowprecis["department_precis"]!=""){
                $dep_precis = " | ".$rowprecis["department_precis"];
              }else{
                $dep_precis = " | ".$rowprecis["position_name"];
              }
              break;
            
            case '2':
              $sqlprecis = "SELECT * FROM person_khet_main pkm LEFT JOIN system_khet sk ON(pkm.khet_code=sk.khet_code) WHERE pkm.person_id = '".$_SESSION["login_user_id"]."'";
              $resultprecis = mysqli_query($connect, $sqlprecis);
              $rowprecis = $resultprecis->fetch_assoc();
              if($rowprecis["khet_precis"]!=""){
                $dep_precis = " | ".$rowprecis["khet_precis"];
              }
              break;            
            default:
              $dep_precis = "";
              break;
          }
          if(file_exists("modules/person/picture/".$_SESSION['login_user_id'].".jpg")){
              $image = "modules/person/picture/".$_SESSION['login_user_id'].".jpg";
           }else{
              $image = "modules/person/noimage.jpg";
           }
          
          ?>
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo $image; ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $_SESSION['login_name'].' '.$_SESSION['login_surname'].$dep_precis; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo $image; ?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo $_SESSION['login_name'].' '.$_SESSION['login_surname']; ?>
                  <small><?php if($rowprecis["position_name"]){ echo $rowprecis["position_name"]; }?></small>
                </p>
              </li>
              <!-- Menu Body -->
              <!--<li class="user-body">
                <div class="row">
                  <div class="col-xs-6 text-center">
                    <a href="#">ข้อมูลส่วนบุคคล</a>
                  </div>
                  <div class="col-xs-6 text-center">
                    <a href="?file=user_change_pwd">เปลี่ยนรหัสผ่าน</a>
                  </div>
                </div>-->
                <!-- /.row -->
              <!--</li>-->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="?file=user_change_pwd" class="btn btn-default btn-flat">ข้อมูลส่วนตัว</a>
                </div>
                <div class="pull-right">
                  <a href="logout.php" class="btn btn-default btn-flat">ออกจากระบบ</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
      <?php } ?>
    </nav>
  </header>


  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <?php
        if($_SESSION['login_user_id']!="") { 
          // check option
          if($option=="") {
            // no option
            ?>
            <li class="header"><h4>เมนูหลัก</h4></li>
            <?php
            $sqlmenugroup = "SELECT * FROM system_menugroup ORDER BY menugroup_order";
            if($resultmenugroup = mysqli_query($connect, $sqlmenugroup)) {
              while ($rowmenugroup = $resultmenugroup->fetch_assoc()) { 
                $sql_firstmodule = "select * from system_module where workgroup=".$rowmenugroup['menugroup']." order by module_order limit 1";
                if($result_firstmodule = mysqli_query($connect, $sql_firstmodule)) {
                  $row_firstmodule = $result_firstmodule->fetch_assoc();
                  $firstmodule = $row_firstmodule["module"];
                }else{
                  $firstmodule = "";
                }  
                ?> 
                <li><a href="index.php?option=<?php echo $firstmodule; ?>"><i class="fa fa-th"></i> <span><?php echo $rowmenugroup['menugroup_desc']?></span></a></li>
                <?php
              }
            }
            ?>
            
            <?php
          }else{
            // option exist
            $sql_option = "select * from system_module sm left join system_menugroup smg on(sm.workgroup=smg.menugroup) where module='".$option."'";
            $result_option = mysqli_query($connect, $sql_option);
            $row_option = $result_option->fetch_assoc();
            $workgroup = $row_option["workgroup"];
            $module_desc = $row_option["module_desc"];
            $menugroup_desc = $row_option["menugroup_desc"];
            ?>
            <li class="header"><h4><?php echo $menugroup_desc; ?></h4></li>
            <!-- show module menu -->
            <?php
            $sqlmodule = "SELECT * FROM system_module WHERE workgroup=$workgroup and module_active=1 ORDER BY module_order";
            if($resultmodule = mysqli_query($connect, $sqlmodule))
            {
              $allcount = 0;
              $allalertmessage = "";
              while ($rowmodule = $resultmodule->fetch_assoc()) 
              { 
                if($rowmodule["module"]==$option){ $active="active"; }else{ $active=""; }
              ?>
                <li class="<?php echo $active; ?> treeview">
                  <a href='#'>
                    <i class="fa fa-sign-in"></i> <span><?php echo $rowmodule["module_desc"]; ?></span> <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                    <?php // ดึงเมนูในแต่ละโมดูล
                      if(file_exists("modules/".$rowmodule["module"]."/menu.php"))
                      {
                        require_once("modules/".$rowmodule["module"]."/menu.php");
                      }
                    ?>
                  </ul>
                </li>
              <?php 
              } 
            }
          } // end check option
        }else{ 
          // Side menu if no login
          ?>
          <li class="header"><h4>เมนูหลัก</h4></li>
          <li><a href="index.php"><i class="fa fa-user"></i> <span>เข้าสู่ระบบ</span></a></li>
          <li><a href="mailto:smart@obecmail.obec.go.th"><i class="fa fa-envelope-o"></i> <span>ติดต่อผู้ดูแลระบบ</span></a></li>
          <?php
        }
        ?>
        <!-- end show module menu -->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h4>
        <?php echo $module_desc; ?>
        <small><?php //echo $module_desc; ?></small>
      </h4>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-sitemap"></i> เมนูหลัก</a></li>
        <?php if(!isset($menugroup_desc)){ $menugroup_desc=""; } if(!isset($module_desc)){ $module_desc=""; } ?>
        <?php if($menugroup_desc!="") { ?>
          <li class="active"><?php echo $menugroup_desc; ?></li>
        <?php } ?>
        <?php if($module_desc!="") { ?>
          <li class="active"><?php echo $module_desc; ?></li>
        <?php } ?>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <?php
      if($_SESSION['login_user_id']==""){
        // if no login show login page
        require_once('login.php');

      }else{    
        // if login pass
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

      }

      mysqli_close($connect);

      ?>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>เวอร์ชั่น</b> 2.0
    </div>
    <strong>Copyright &copy; 2015-2016.</strong> สำนักงานคณะกรรมการการศึกษาขั้นพื้นฐาน
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- AdminLTE template -->
<!-- jQuery 2.2.0 -->
<script src="adminlte233/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="adminlte233/bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="adminlte233/plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="adminlte233/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="adminlte233/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="adminlte233/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="adminlte233/plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="adminlte233/plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="adminlte233/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="adminlte233/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="adminlte233/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="adminlte233/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="adminlte233/dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="adminlte233/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="adminlte233/dist/js/demo.js"></script>
<!-- CK Editor -->
<!--<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>-->
<!-- Bootstrap WYSIHTML5 -->
<script src="adminlte233/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1');
    //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();
  });
</script>
<!-- Advance form -->
<!-- Select2 -->
<script src="adminlte233/plugins/select2/select2.full.min.js"></script>
<!-- InputMask -->
<script src="adminlte233/plugins/input-mask/jquery.inputmask.js"></script>
<script src="adminlte233/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="adminlte233/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- bootstrap color picker -->
<script src="adminlte233/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="adminlte233/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="adminlte233/plugins/iCheck/icheck.min.js"></script>
<!-- Page script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();

    //Datemask dd/mm/yyyy
    $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    //Datemask2 mm/dd/yyyy
    $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
    //Money Euro
    $("[data-mask]").inputmask();

    //Date range picker
    $('#reservation').daterangepicker();
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
    //Date range as a button
    $('#daterange-btn').daterangepicker(
        {
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function (start, end) {
          $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
    );

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });

    //Colorpicker
    $(".my-colorpicker1").colorpicker();
    //color picker with addon
    $(".my-colorpicker2").colorpicker();

    //Timepicker
    $(".timepicker").timepicker({
      showInputs: false
    });
  });
</script>
<!-- End Advance form -->
<!-- End AdminLTE template -->

</body>
</html>