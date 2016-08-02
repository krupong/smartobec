<?php
include_once('class.department.php');
$gen = new department();
$gen->delete($_POST['id']);
?>
<!--- แก้ไข path ของ assets ให้ถูกต้อง -->
<link rel="stylesheet" href="assets/css/styles.css" />
<div id="wrapper">
        <div class="col-md-6">
        <h1>ลบข้อมูลเรียบร้อย</h1>
        <a href="index.Department.php" class="btn btn-primary">รายการ</a>
        </div>
</div>
<?php $gen->redirect("index.Department.php"); ?>
