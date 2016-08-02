<?php
include_once('class.department.php');
$id = $_GET['id'];
$gen = new department();
$gen->select($id);
?>
<!--- แก้ไข path ของ assets ให้ถูกต้อง -->
<link rel="stylesheet" href="assets/css/styles.css" />
<div id="wrapper">
        <div class="col-md-6">
                <h1>รายละเอียด
                <a href="edit.Department.php?id=<?=$id?>" class="btn btn-primary btn-xs" title="Edit Amphor"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                <form method="POST" action="delete.Department.php" accept-charset="UTF-8" style="display:inline"><input name="id" type="hidden" value="<?=$id?>">
                <button type="submit" class="btn btn-danger btn-xs" title="ลบอำเภอ" onclick="return confirm(&quot;ต้องการลบจริงๆ หรือไม่?&quot;)"><span class="glyphicon glyphicon-trash" aria-hidden="true"/></button>
                </form>
                </h1>
                <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                                <tbody>
                                       <tr><th> Id</th><td><?=$gen->getId();?></td></tr>
                                       <tr><th> Name</th><td><?=$gen->getName();?></td></tr>
                                       <tr><th> Nameprecis</th><td><?=$gen->getNameprecis();?></td></tr>
                                       <tr><th> Namelongprecis</th><td><?=$gen->getNamelongprecis();?></td></tr>
                                       <tr><th> Look</th><td><?=$gen->getLook();?></td></tr>
                                       <tr><th> Sendlook</th><td><?=$gen->getSendlook();?></td></tr>
                                       <tr><th> Receivelook</th><td><?=$gen->getReceivelook();?></td></tr>
                                       <tr><th> Sendmain</th><td><?=$gen->getSendmain();?></td></tr>
                                       <tr><th> Receivemain</th><td><?=$gen->getReceivemain();?></td></tr>
                                       <tr><th> Send</th><td><?=$gen->getSend();?></td></tr>
                                       <tr><th> Receive</th><td><?=$gen->getReceive();?></td></tr>
                                       <tr><th> Status</th><td><?=$gen->getStatus();?></td></tr>
                                       <tr><th> Officer</th><td><?=$gen->getOfficer();?></td></tr>
                                       <tr><th> Officer_date</th><td><?=$gen->getOfficer_date();?></td></tr>
                               </tbody>
                        </table>
                </div>
                <a href="index.Department.php" class="btn btn-primary">รายการ</a>
        </div>

</div>

