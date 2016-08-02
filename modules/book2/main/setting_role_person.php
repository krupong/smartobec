<html>
    <head>
     <style>
        #exTab2 .nav-pills > li > a {
          border-radius: 4px 4px 0 0 ;
        }

        #exTab2 .tab-content {
          color : #000000;
          background-color: #E5FAFA;
          padding : 5px 15px;
        }


    </style>
    </head>
 
   <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

<!-- Your Page Content Here -->

    <!-- ใส่เนื้อหาตรงนี้ -->
        <!-- Main content -->
        
        <section class="content">

            <div class="box container">
                <div class="box-header">
                  <h3 class="box-title">กำหนดบทบาทหน้าที่ของบุคลากร</h3>
                  <div class="box-tools pull-right">
                      
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body container">

                <!-- เลือกบุคลากร -->    
                    <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="select2person" class="col-sm-2" style="width: 140px" >
                                เลือกบุคลากร</label>
                            <div  class="col-sm-5 text-left">
<?php
//หาชื่อบุคลากร
    $sql_person_name="select * from person_main where status=0 ";
    $query_person_name = $connect->prepare($sql_person_name);
    //$query_person_name->bind_param("i", $user_departid);
    $query_person_name->execute();
    $result_qperson_name=$query_person_name->get_result();
?>
                                <select class="select2person form-control" multiple="yes"data-placeholder="กรุณาเลือกบุคลากร" style="width: 100%;" >
<?php
    While ($result_person_name = mysqli_fetch_array($result_qperson_name))
   {
    echo "<option value=".$result_person_name['person_id']." >".$result_person_name['name']." ".$result_person_name['surname']."</option>";
    }
?>
                                  </select>
                            </div>
                       </div>
                    </div>
                <!--จบ เลือกบุคลากร -->    

                <!-- เลือกบทบาท -->    
                    <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="role_id" class="col-sm-2" style="width: 140px" >
                                เลือกบทบาท</label>
                            <div  class="col-sm-5 text-left">
<?php
//หาชื่อบทบาท
    $sql_role="select * from book2_etcdepartment  where status=1 ";
    $query_role = $connect->prepare($sql_role);
    //$query_person_name->bind_param("i", $user_departid);
    $query_role->execute();
    $result_qrole=$query_role->get_result();
?>
                                <select class="select2person form-control" multiple="multiple" data-placeholder="กรุณาเลือกบทบาท" style="width: 100%;" >
<?php
    While ($result_role = mysqli_fetch_array($result_qrole))
   {
    echo "<option value=".$result_role['id']." >".$result_role['etcdepartmentname']."</option>";
    }
?>
                                  </select>
                            </div>
                       </div>
                    </div>
                <!--จบ เลือกบุคลากร -->    

                    <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                             <div  class="col-sm-7  text-center" >
                                 <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> เพิ่มบทบาทให้บุคลากร</button>
                            </div>
                       </div>
                    </div>

                    
                    
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->

        </section><!-- /.content -->


    
    <!-- จบ ใส่เนื้อหาตรงนี้ -->
 
<!-- END Your Page Content Here -->

    </div><!-- ./wrapper -->
    <!-- jQuery 2.1.4 -->
    <script src="modules/book2/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="modules/book2/bootstrap/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="modules/book2/dist/js/app.min.js"></script>
    <!-- Selection -->
    <script src="modules/book2/plugins/selection/bootstrap-select.min.js"></script>
    <!-- iCheck 1.0.1 -->
    <script src="modules/book2/plugins/iCheck/icheck.min.js"></script>
    <!-- Select2 -->
    <script src="modules/book2/plugins/select2/select2.full.min.js"></script>
    <!-- Validator -->
    <script src="modules/book2/plugins/validator/validator.min.js"></script>
    <!-- Date Input file -->
    <script src="modules/book2/plugins/inputfile/fileinput.min.js"></script>
    <!-- Date Input file Thai-->
    <script src="modules/book2/plugins/inputfile/fileinput_locale_th.js"></script>
    <!-- Date Input file plugins-->
    <script src="modules/book2/plugins/inputfile/plugins/canvas-to-blob.min.js"></script>
    <!-- Date Input file Thai-->
    <script src="modules/book2/plugins/confirmation/bootstrap-confirmation.min.js"></script>
    <!-- Date Picker -->
    <!--<script src="modules/book2/plugins/datepicker/bootstrap-datepicker.js"></script>-->
    <!-- Date Picker Thai -->
    <!--<script src="modules/book2/plugins/datepicker/locales/bootstrap-datepicker.th.js" charset="UTF-8"></script>-->
    <!-- Date Picker New Dist -->
    <script src="modules/book2/plugins/datepicker/dist/js/bootstrap-datepicker.js"></script>
    <!-- Date Picker Thai  New Dist -->
    <script src="modules/book2/plugins/datepicker/dist/locales/bootstrap-datepicker.th.min.js" charset="UTF-8"></script>
   
    
     <!-- Page script -->
    <script>
      $(function () {
        //Initialize Select2 Elements
        //$(".select2up").select2();
        var $select2person = $(".select2person").select2({
                                        placeholder: "กรุณาเลือกบุคลากร",
                                        allowClear: true,
                                        maximumSelectionLength: 1
                                        });
        var $select2up = $(".select2up").select2({
                                        allowClear: true
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
          //Date Picker
        $('#datepicker2').datepicker({
                 autoclose: 'yes',
                 format:'dd-mm-yyyy',
                 orientation:'auto',
                 language:'th',
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