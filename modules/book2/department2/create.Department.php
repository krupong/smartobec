<?php
include_once('class.department.php');
$gen = new department();
?>
<!--- แก้ไข path ของ assets ให้ถูกต้อง -->
<link rel="stylesheet" href="assets/css/styles.css" />
<link href="./modules/book2/plugins/toggle/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="./modules/book2/plugins/toggle/js/bootstrap-toggle.min.js"></script>
<div id="wrapper">
        <div class="col-md-12">
                <h1>เพิ่มข้อมูล</h1>
                <form method="POST" action="?option=book2&task=department/save.Department" accept-charset="UTF-8" class="form-horizontal">
                            
                        <div class="form-group ">
                            <label for="name" class="col-sm-3 control-label">ชื่อหน่วยงาน :*</label>
                        <div class="col-sm-6">
                            <input class="form-control" required="required" name="name" type="text" id="name" placeholder="สำนักงานเขตพื้นที่การศึกษาประถมศึกษาลำพูน เขต 1">

                        </div>
                    </div>
                        <div class="form-group ">
                            <label for="nameprecis" class="col-sm-3 control-label">ชื่อย่อหน่วยงาน(แบบสั้น) :*</label>
                        <div class="col-sm-6">
                            <input class="form-control" required="required" name="nameprecis" type="text" id="nameprecis" placeholder="สพป.ลพ.1">

                        </div>
                    </div>
                        <div class="form-group ">
                            <label for="namelongprecis" class="col-sm-3 control-label">ชื่อย่อหน่วยงาน(แบบยาว) :*</label>
                        <div class="col-sm-6">
                            <input class="form-control" required="required" name="namelongprecis" type="text" id="namelongprecis" placeholder="สพป.ลำพูน เขต 1">

                        </div>
                    </div>
                        <div class="form-group ">
                            <label for="look" class="col-sm-3 control-label">เป็นหน่วยงาน/กลุ่มของ :</label>
                        <div class="col-sm-6">
<?php
    $sql_countdepartment="SELECT COUNT(id) as cid FROM book2_department";
    $query_countdepartment = $connect->prepare($sql_countdepartment);
    $query_countdepartment->execute();
    $result_qcountdepartment=$query_countdepartment->get_result();
        While ($result_countdepartment = mysqli_fetch_array($result_qcountdepartment))
       {             $countdepart=$result_countdepartment['cid'];  
       }
       if($countdepart>0){ //นับจำนวนหน่วยงาน
?>
       
<?php                            
    $sql_department="select * from book2_department";
    $query_department = $connect->prepare($sql_department);
    $query_department->execute();
    $result_qdepartment=$query_department->get_result();
        While ($result_department = mysqli_fetch_array($result_qdepartment))
       {
           
            $department_id=$result_department['id'];  
            $department_name=$result_department['name'];  
           echo  $department_name;
            ?>
<?php
       }    //จบ แสดงชื่อหน่วยงาน
       ?>

  <?php
       }    //จบ นับจำนวน
?>                            

                        </div>
                    </div>
                        <div class="form-group ">
                            <label for="sendlook" class="col-sm-3 control-label">ใช้เลขส่งของหน่วยงานอื่น :</label>
                        <div class="col-sm-6">
                            <input class="form-control"  name="sendlook" type="text" id="sendlook">

                        </div>
                    </div>
                        <div class="form-group ">
                            <label for="receivelook" class="col-sm-3 control-label">ใช้เลขรับของหน่วยงานอื่น :</label>
                        <div class="col-sm-6">
                            <input class="form-control"  name="receivelook" type="text" id="receivelook">
                            
                        </div>
                    </div>
                        <div class="form-group ">
                            <label for="sendmain" class="col-sm-3 control-label">ใช้เป็นเลขส่งหลัก :</label>
                        <div class="col-sm-6">
                            <input class="form-control"  name="sendmain" type="checkbox" id="sendmain" data-toggle="toggle" value="1">

                        </div>
                    </div>
                        <div class="form-group ">
                            <label for="receivemain" class="col-sm-3 control-label">ใช้เป็นเลขรับหลัก :</label>
                        <div class="col-sm-6">
                            <input class="form-control"  name="receivemain" type="checkbox" id="receivemain" data-toggle="toggle" value="1">

                        </div>
                    </div>
                        <div class="form-group ">
                            <label for="send" class="col-sm-3 control-label">มีเลขส่งของตนเอง :</label>
                        <div class="col-sm-6">
                            <input class="form-control"  name="send" type="checkbox" id="send" data-toggle="toggle" value="1">

                        </div>
                    </div>
                        <div class="form-group ">
                            <label for="receive" class="col-sm-3 control-label">มีเลขรับของตนเอง :</label>
                        <div class="col-sm-6">
                            <input class="form-control" name="receive" type="checkbox" id="receive" data-toggle="toggle" value="1">

                        </div>
                    </div>
                        <div class="form-group ">
                            <label for="status" class="col-sm-3 control-label">เป็นหน่วยงาน :</label>
                        <div class="col-sm-6">
                            <input class="form-control" name="status" type="checkbox" id="status" data-toggle="toggle" value="1">

                        </div>
                    </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-3">
                <input class="btn btn-primary form-control" type="submit" value="เพิ่มหน่วยงาน">
            </div>
        </div>
        </form>
        </div>

</div>
