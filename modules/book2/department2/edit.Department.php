<?php
include_once('class.department.php');
$gen = new department();
$gen->select($_GET['id']);
?>
<!--- แก้ไข path ของ assets ให้ถูกต้อง -->
<link rel="stylesheet" href="assets/css/styles.css" />
<div id="wrapper">
        <div class="col-md-12">
                <h1>แก้ไขข้อมูล</h1>
                <form method="POST" action="update.Department.php" accept-charset="UTF-8" class="form-horizontal">
                            
                        <div class="form-group ">
                            <label for="name" class="col-sm-3 control-label">Name</label>
                        <div class="col-sm-6">
                            <input class="form-control" required="required" name="name" type="text" id="name" value="<?=$gen->getName();?>">
                        </div>
                    </div>
                        <div class="form-group ">
                            <label for="nameprecis" class="col-sm-3 control-label">Nameprecis</label>
                        <div class="col-sm-6">
                            <input class="form-control" required="required" name="nameprecis" type="text" id="nameprecis" value="<?=$gen->getNameprecis();?>">
                        </div>
                    </div>
                        <div class="form-group ">
                            <label for="namelongprecis" class="col-sm-3 control-label">Namelongprecis</label>
                        <div class="col-sm-6">
                            <input class="form-control" required="required" name="namelongprecis" type="text" id="namelongprecis" value="<?=$gen->getNamelongprecis();?>">
                        </div>
                    </div>
                        <div class="form-group ">
                            <label for="look" class="col-sm-3 control-label">Look</label>
                        <div class="col-sm-6">
                            <input class="form-control" required="required" name="look" type="text" id="look" value="<?=$gen->getLook();?>">
                        </div>
                    </div>
                        <div class="form-group ">
                            <label for="sendlook" class="col-sm-3 control-label">Sendlook</label>
                        <div class="col-sm-6">
                            <input class="form-control" required="required" name="sendlook" type="text" id="sendlook" value="<?=$gen->getSendlook();?>">
                        </div>
                    </div>
                        <div class="form-group ">
                            <label for="receivelook" class="col-sm-3 control-label">Receivelook</label>
                        <div class="col-sm-6">
                            <input class="form-control" required="required" name="receivelook" type="text" id="receivelook" value="<?=$gen->getReceivelook();?>">
                        </div>
                    </div>
                        <div class="form-group ">
                            <label for="sendmain" class="col-sm-3 control-label">Sendmain</label>
                        <div class="col-sm-6">
                            <input class="form-control" required="required" name="sendmain" type="text" id="sendmain" value="<?=$gen->getSendmain();?>">
                        </div>
                    </div>
                        <div class="form-group ">
                            <label for="receivemain" class="col-sm-3 control-label">Receivemain</label>
                        <div class="col-sm-6">
                            <input class="form-control" required="required" name="receivemain" type="text" id="receivemain" value="<?=$gen->getReceivemain();?>">
                        </div>
                    </div>
                        <div class="form-group ">
                            <label for="send" class="col-sm-3 control-label">Send</label>
                        <div class="col-sm-6">
                            <input class="form-control" required="required" name="send" type="text" id="send" value="<?=$gen->getSend();?>">
                        </div>
                    </div>
                        <div class="form-group ">
                            <label for="receive" class="col-sm-3 control-label">Receive</label>
                        <div class="col-sm-6">
                            <input class="form-control" required="required" name="receive" type="text" id="receive" value="<?=$gen->getReceive();?>">
                        </div>
                    </div>
                        <div class="form-group ">
                            <label for="status" class="col-sm-3 control-label">Status</label>
                        <div class="col-sm-6">
                            <input class="form-control" required="required" name="status" type="text" id="status" value="<?=$gen->getStatus();?>">
                        </div>
                    </div>
                        <div class="form-group ">
                            <label for="officer" class="col-sm-3 control-label">Officer</label>
                        <div class="col-sm-6">
                            <input class="form-control" required="required" name="officer" type="text" id="officer" value="<?=$gen->getOfficer();?>">
                        </div>
                    </div>
                        <div class="form-group ">
                            <label for="officer_date" class="col-sm-3 control-label">Officer_date</label>
                        <div class="col-sm-6">
                            <input class="form-control" required="required" name="officer_date" type="text" id="officer_date" value="<?=$gen->getOfficer_date();?>">
                        </div>
                    </div>
        <input type="hidden" name="id" value="<?=$_GET['id']?>" />
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-3">
                <input class="btn btn-primary form-control" type="submit" value="แก้ไข">
            </div>
        </div>
        </form>
        </div>

</div>

