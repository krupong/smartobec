<?php
include_once('./modules/book2/department/class.department.php');
$gen = new department();
$gen->setName($_POST['name']);
                $gen->setNameprecis($_POST['nameprecis']);
                $gen->setNamelongprecis($_POST['namelongprecis']);
                $gen->setLook($_POST['look']);
                $gen->setSendlook($_POST['sendlook']);
                $gen->setReceivelook($_POST['receivelook']);
                $gen->setSendmain($_POST['sendmain']);
                $gen->setReceivemain($_POST['receivemain']);
                $gen->setSend($_POST['send']);
                $gen->setReceive($_POST['receive']);
                $gen->setStatus($_POST['status']);
                $gen->setOfficer($_POST['officer']);
                $gen->setOfficer_date(date('Y-m-d H:i:s'));
                
$gen->insert();
?>
<!--- แก้ไข path ของ assets ให้ถูกต้อง -->
<link rel="stylesheet" href="assets/css/styles.css" />
<div id="wrapper">
        <div class="col-md-6">
        <h3>บันทึกเรียบร้อย</h3>
        <a href="?option=book2&task=department/index.Department" class="btn btn-primary">รายการ</a>
        </div>
</div>
<?php $gen->redirect("?option=book2&task=department/index.Department"); ?>
