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

              <div class="box  container">
                <div class="box-header">
                  <h3 class="box-title">รายการบทบาทหน้าที่ของบุคลากร</h3>
                        <div class="box-tools pull-right">
                        <!--    <a class="btn btn-box-tool" href="#" style="color:green"><i class="glyphicon glyphicon-plus"></i> เพิ่มข้อมูลใหม่</a>-->
                            <a href="?option=book2&task=main/setting_role_person" class="btn btn-success btn-sm" role="button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> เพิ่มบทบาทของบุคลากร</a>
 
                        </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="listroletable1" class="table table-bordered table-hover">
                      <thead >
                      <tr>
                        <th style="width:10px"><input type="checkbox" id="membookno" name="membookno" class="flat-red " value="1" ></th>
                        <th  style="width:10px">ที่</th>
                        <th>บทบาท</th>
                        <th>บุคลากร</th>
                        <th>หน่วยงาน</th>
                        <th>ดำเนินการ</th>
                      </tr>
                    </thead>
                    <tbody>
<?php
//หาชื่อบุคลากรในตารางบทบาท
    $sql_role_person="select * from book2_roleuser  ";
    $query_role_person = $connect->prepare($sql_role_person);
    //$query_person_name->bind_param("i", $user_departid);
    $query_role_person->execute();
    $result_qrole_person=$query_role_person->get_result();
    
    $i=1;
    While ($result_role_person = mysqli_fetch_array($result_qrole_person))
   {
        $etcdepart_id=$result_role_person['etcdepart_id']; 
        $person_id=$result_role_person['person_id'];  
        
            //หาชื่อบทบาท
                $sql_etcdepart="select * from book2_etcdepartment where id=?";
                $query_etcdepart = $connect->prepare($sql_etcdepart);
                $query_etcdepart->bind_param("i", $etcdepart_id);
                $query_etcdepart->execute();
                $result_qetcdepart=$query_etcdepart->get_result();
                While ($result_etcdepart = mysqli_fetch_array($result_qetcdepart))
               {    
                    $etcdepartmentname=$result_etcdepart['etcdepartmentname'];
                    $workgroup_id=$result_etcdepart['workgroup_id'];
                    $etcdepart_groupcode=$result_etcdepart['groupcode'];  
                    $etcdepart_important=$result_etcdepart['important'];  
                if($workgroup_id!=0){    
                    //หาชื่อกลุ่มงาน
                        $sql_workgroup="select * from system_workgroup where workgroup=?";
                        $query_workgroup = $connect->prepare($sql_workgroup);
                        $query_workgroup->bind_param("i", $workgroup_id);
                        $query_workgroup->execute();
                        $result_qworkgroup=$query_workgroup->get_result();
                        While ($result_workgroup = mysqli_fetch_array($result_qworkgroup))
                       {    
                            $workgroup_name=$result_workgroup['workgroup_desc'];
                       }  
                }else{
                    $workgroup_name="";
                }

                }
               
         //หาชื่อบุคลากร
            $sql_person="select * from person_main where person_id=?";
            $query_person = $connect->prepare($sql_person);
            $query_person->bind_param("s", $person_id);
            $query_person->execute();
            $result_qperson=$query_person->get_result();
            While ($result_person = mysqli_fetch_array($result_qperson))
           {    
                $person_prename=$result_person['prename'];
                $person_name=$result_person['name'];
                $person_surname=$result_person['surname'];
                $person_position_code=$result_person['position_code'];
                $person_department=$result_person['department'];
           }
  
        

        ?>
                      <tr>
                        <td><input type="checkbox" id="checklist<?php echo $i;?>" name="checklist<?php echo $i;?>" class="flat-red " value="1" ></td>
                        <td><?php echo $i;?></td>
                        <td><?php echo $etcdepartmentname; ?></td>
                        <td><?php echo $person_prename.$person_name." ".$person_surname; ?></td>
                        <td> <?php echo $workgroup_name; ?></td>
                        <td>
                            <a href="#"><span class="glyphicon glyphicon-pencil" style="color:blue"></span></a>
                            <a href="#"><span class="glyphicon glyphicon-trash" style="color:black"></span></a>
                            <a href="#"><span class="glyphicon glyphicon-minus-sign" style="color:#FF0000"></span></a>
                            <a href="#"><span class="glyphicon glyphicon-ok-sign" style="color:#50c606"></span></a>
                            
                        </td>
                      </tr>

<?php        
    }
?>
                    
                    </tbody>
                    <tfoot>
                      <tr>
                        <th style="width:10px"><input type="checkbox" id="membookno" name="membookno" class="flat-red " value="1" ></th>
                        <th  style="width:10px">ที่</th>
                        <th>บทบาท</th>
                        <th>บุคลากร</th>
                        <th>หน่วยงาน</th>
                        <th>ดำเนินการ</th>
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            
            

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
    <script src="modules/book2/plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Date Picker Thai -->
    <script src="modules/book2/plugins/datepicker/locales/bootstrap-datepicker.th.js" charset="UTF-8"></script>
    <!-- DataTables -->
    <script src="modules/book2/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="modules/book2/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="modules/book2/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="modules/book2/plugins/fastclick/fastclick.min.js"></script>
   
    
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
    <!-- page script -->
    <script>
      $(function () {
        $("#listroletable1").DataTable({
            "language": {
            "lengthMenu": "แสดง _MENU_ ต่อหน้า",
            "zeroRecords": "ไม่พบข้อมูล",
            "info": "แสดง _PAGE_ จาก _PAGES_",
            "infoEmpty": "ไม่มีข้อมูล",
            "infoFiltered": "(กรองจากทั้งหมด _MAX_ total)",
            "search": "ค้นหา",
            "paginate": {
                        "previous": "ย้อนกลับ",
                        "next": "ถัดไป"
            },
        },
        "order": [[ 2, "asc" ]]        
    });

      });
    </script>

  </body>
</html>