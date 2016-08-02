<?php

//header("content-type:text/javascript;charset=utf-8");   

include 'database_connect.php'; 
include './modules/book2/main/function.php'; 


//โชว์วันที่วันนี้
$today=date("d-m-Y");
$todaydatetime=date("Y-m-d H:i:s");

//$inputusername=$_SESSION['login_user_id'];;
 ?>

<div id="wrapper">
        <div class="col-md-12">
                <h3>เพิ่มข้อมูลหน่วยงาน</h3>
                <form method="POST" action="" accept-charset="UTF-8" name="add_department_form" id="add_department_form"  class="form-horizontal">
                            
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
                <input class="btn btn-primary form-control" type="button" value="เพิ่มหน่วยงาน" onclick="return add_department_form();">
            </div>
        </div>
                    
        <input type="hidden" name="officer" value="<?php echo $userlogin;?>" />    
                    
                    
        </form>
        </div>

</div>



<!-- jQuery 2.1.4 -->
    <script src="modules/book2/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- JQuery UI 1.11.4 -->
     <script src="modules/book2/plugins/jQueryUI/jquery-ui.min.js" type="text/javascript"></script>
     
 <!-- Bootstrap 3.3.5 -->
    <script src="./modules/book2/bootstrap/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="./modules/book2/dist/js/app.min.js"></script>
    <!-- Selection -->
    <script src="./modules/book2/plugins/selection/bootstrap-select.min.js"></script>
    <!-- iCheck 1.0.1 -->
    <script src="./modules/book2/plugins/iCheck/icheck.min.js"></script>
    <!-- Select2 -->
    <script src="./modules/book2/plugins/select2/select2.full.min.js"></script>
    <!-- Validator -->
    <script src="./modules/book2/plugins/validator/validator.min.js"></script>
    <!-- Date Input file -->
    <script src="./modules/book2/plugins/inputfile/fileinput.min.js"></script>
    <!-- Date Input file Thai-->
    <script src="./modules/book2/plugins/inputfile/fileinput_locale_th.js"></script>
    <!-- Date Input file plugins-->
    <script src="./modules/book2/plugins/inputfile/plugins/canvas-to-blob.min.js"></script>
    <!-- Date Input file Thai-->
    <script src="./modules/book2/plugins/confirmation/bootstrap-confirmation.min.js"></script>
    <!-- Date Picker -->
    <!--<script src="modules/book2/plugins/datepicker/bootstrap-datepicker.js"></script>-->
    <!-- Date Picker Thai -->
    <!--<script src="modules/book2/plugins/datepicker/locales/bootstrap-datepicker.th.js" charset="UTF-8"></script>-->
    <!-- Date Picker New Dist -->
    <script src="./modules/book2/plugins/datepicker/dist/js/bootstrap-datepicker.js"></script>
    <!-- Date Picker Thai  New Dist -->
    <script src="./modules/book2/plugins/datepicker/dist/locales/bootstrap-datepicker.th.min.js" charset="UTF-8"></script>
    <!-- Tree View -->
    <script src="./modules/book2/plugins/treeview/bootstrap-treeview.js"></script>
     <!-- Fancy  Tree View -->
    <script src="./modules/book2/plugins/fancytree/jquery.fancytree.js"></script>
     <script src="./modules/book2/plugins/fancytree/jquery.fancytree.filter.js"></script>
<script src="./modules/book2/plugins/toggle/js/bootstrap-toggle.min.js"></script>
      <!-- My Script -->
     <script src="./modules/book2/main/function.js"></script>
 
     
     <!-- Page script -->
    <script>
      $(function () {
        //Initialize Select2 Elements
        //$(".select2up").select2();
        var $select2up = $(".select2up").select2({
                  allowClear: true
        });
        var $select2uptag = $(".select2uptag").select2({
                  allowClear: true,
                  tags: true,
                  tokenSeparators: [',']
        });

        $(".clearselect2up").on("click", function () { $select2up.val(null).trigger("change"); });
        

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
        $('input[type="checkbox"].flat-green, input[type="radio"].flat-green').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass: 'iradio_square-green'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-red',
          radioClass: 'iradio_square-red'
        });
        //Flat Blue color scheme for iCheck
        $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
          checkboxClass: 'icheckbox_flat-blue',
          radioClass: 'iradio_square-blue'
        });
          //Date Picker
        $('#datepicker2').datepicker({
                 autoclose: 'yes',
                 format:'dd-mm-yyyy',
                 orientation:'auto',
                 language:'th',
                 todayBtn: "linked",
                 todayHighlight: true,
                 disableTouchKeyboard:'true'
          });
        //Confirmation
        $('#comfirmation1').confirmation({
            title:'ยืนยัน',
            btnOkLabel:'<i class="icon-ok-sign icon-white"></i> ใช่',
            btnCancelLabel:'<i class="icon-remove-sign"></i> ยกเลิก',
            popout:'true',
            singleton:'true'
        });
        //Confirmation
        $('#comfirmation2').confirmation({
            title:'ยืนยัน',
            btnOkLabel:'<i class="icon-ok-sign icon-white"></i> ใช่',
            btnCancelLabel:'<i class="icon-remove-sign"></i> ยกเลิก',
            popout:'true',
            singleton:'true'
        });
        //Confirmation
        $('#comfirmation3').confirmation({
            title:'ยืนยัน',
            btnOkLabel:'<i class="icon-ok-sign icon-white"></i> ใช่',
            btnCancelLabel:'<i class="icon-remove-sign"></i> ยกเลิก',
            popout:'true',
            singleton:'true'
        });
        
    });      
    </script>
    <!-- อัพโหลดไฟล์ -->
    <script>
    $("#file-0").fileinput({
        uploadUrl: '#',
        allowedFileExtensions : ['jpg', 'png','gif','pdf'],
        maxFileSize: 1000,
        maxFilesNum: 10,
        dropZoneEnabled:false,
        'elErrorContainer': '#errorBlock'
    });
    </script>

                            
  </body>
</html>
