<?php
include_once('./modules/book2/department/class.department.php');
$gen = new department();
$gen->delete($_POST['id']);
?>
<!--- แก้ไข path ของ assets ให้ถูกต้อง -->
<link rel="stylesheet" href="assets/css/styles.css" />
<div id="wrapper">
        <div class="col-md-6">
        <h3>ลบข้อมูลเรียบร้อย</h3>
        <a href="?option=book2&task=department/index.Department" class="btn btn-primary">รายการ</a>
        </div>
</div>
<?php $gen->redirect("?option=book2&task=department/index.Department"); ?>
