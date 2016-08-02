<?php
if(isset($_SESSION['role_id'])){
$user_role_id=mysqli_real_escape_string($connect,$_SESSION['role_id']);
}else {$user_role_id=""; 
?>
<script langquage='javascript'>
window.location="?option=book2&task=main/roleperson";
</script>
<?php
}
?>

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
                  <h3 class="box-title">ลงทะเบียนรับหนังสือราชการจากกระดาษ</h3>
                  <div class="box-tools pull-right">
                      
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body  container">
                    <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="bookno" class="col-sm-2" style="width: 140px" >
                                <input type="checkbox" id="membookno" name="membookno" class="flat-green " value="1" > เลขที่หนังสือ</label>
                            <div  class="col-sm-3 text-left" >
                                <input type="text" class="form-control" id="bookno" placeholder="กรุณากรอกเลขที่หนังสือ" name="bookno" required>
                            </div>
                             <div  class="col-sm-2 text-left" >
                                 <button type="submit" class="btn btn-success"  data-toggle="modal" data-target="#checknumreceive" onclick="checknumreceive();" ><span class="glyphicon glyphicon-check" aria-hidden="true"></span> ตรวจสอบเลขที่หนังสือ</button>
                            </div>
                       </div>
                </div>
                    
                <!-- Modal for Read -->
                        <div class="modal fade bs-example-modal-lg" id="checknumreceive"  data-backdrop="true"  aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <div class="row container">
                                  <h4 align="left">  ตรวจสอบหนังสือที่เคยลงรับ</h4>
                              </div>
                            </div>
                            <div class="modal-body" align="left">

                                <div class="col-md-4 result"></div>
                                
                                <div class="col-md-8 detail"></div>
                            </div>
                        	<div class="modal-footer">
                                    
                                </div>
      
                      </div>
                    </div>
                  </div>

                <!-- จบ Modal -->
                    
                 <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="membooklevel" class="col-sm-2" style="width: 140px" >
                                <input type="checkbox" id="membooklevel" name="membooklevel" class="flat-green " value="1" > ชั้นความเร็ว</label>
                            <div  class="col-sm-6 text-left">
<?php
//หาชื่อหน่วยงาน
    $sql_booklevel="select * from book2_level where status=1 ";
    $query_booklevel = $connect->prepare($sql_booklevel);
    //$query_booklevel->bind_param("i", $user_departid);
    $query_booklevel->execute();
    $result_qbooklevel=$query_booklevel->get_result();

    
    While ($result_booklevel = mysqli_fetch_array($result_qbooklevel))
   {
        if($result_booklevel['id']==1){$showselected="checked";}else{$showselected="";}
        ?>
        <input type="radio" id="booklevel" name="booklevel" class="flat-red" value="<?php echo  $result_booklevel['id']?>" <?php echo $showselected; ?>> <?php echo $result_booklevel['book_level']; ?> 
   <?php
    }
?>
                                  </select>
                            </div>
                       </div>
                </div>
                 <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="membooksecret" class="col-sm-2" style="width: 140px" >
                                <input type="checkbox" id="membooksecret" name="membooksecret" class="flat-green " value="1" > ชั้นความลับ</label>
                            <div  class="col-sm-6 text-left">
<?php
//หาชื่อหน่วยงาน
    $sql_booksecret="select * from book2_secret where status=1 ";
    $query_booksecret = $connect->prepare($sql_booksecret);
    //$query_booklevel->bind_param("i", $user_departid);
    $query_booksecret->execute();
    $result_qbooksecret=$query_booksecret->get_result();
    While ($result_booksecret = mysqli_fetch_array($result_qbooksecret))
   {
        if($result_booksecret['id']==1){$showchecked="checked";}else{$showchecked="";}
        ?>
        <input type="radio" id="booksecret" name="booksecret" class="flat-red" value="<?php echo  $result_booksecret['id']?>" <?php echo $showchecked; ?>> <?php echo $result_booksecret['book_secret']; ?>  
   <?php
    }
?>

                                  </select>
                            </div>
                       </div>
                </div>

<?php
//โชว์วันที่วันนี้
$today=date("d-m-Y");
?>
                 <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="bookdate" class="col-sm-2" style="width: 140px" >
                                <input type="checkbox" id="membookdate" name="membookdate" class="flat-green " value="1" > ลงวันที่</label>
                             <div  class="col-sm-3 text-left" >
                                    <div class="input-group date" id="datepicker2" >
                                        <input type="text" class="form-control" name="bookdate" id="bookdate" value="<?php echo $today;?>"   required/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                            </div>
                        </div>
                </div>

                <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="booksubject" class="col-sm-2" style="width: 140px" >
                                <input type="checkbox" id="membooksubject" name="membooksubject" class="flat-green " value="1" > เรื่อง</label>
                            <div  class="col-sm-6 text-left" >
                                <input type="text" class="form-control" id="booksubject" placeholder="กรุณากรอกเรื่อง" name="booksubject" required>
                            </div>
                       </div>
                </div>

                <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="bookfor" class="col-sm-2" style="width: 140px" >
                                <input type="checkbox" id="membookfor" name="membookfor" class="flat-green " value="1" > เรียน</label>
                            <div  class="col-sm-5 text-left" >
                                <input type="text" class="form-control" id="bookfor" placeholder="กรุณาระบุข้อมูล" name="bookfor" required>
                            </div>
                       </div>
                </div>

                 <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="bookfrom" class="col-sm-2" style="width: 140px" >
                                <input type="checkbox" id="membookfrom" name="membookfrom" class="flat-green " value="1" > จาก</label>
                            <div  class="col-sm-5 text-left" >
                                <input type="text" class="form-control" id="bookfrom" placeholder="กรุณาระบุหน่วยงานที่ส่งมา" name="bookfrom" required>
                            </div>
                       </div>
                </div>
                   
                  <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="bookcomment" class="col-sm-2" style="width: 140px" >
                                <input type="checkbox" id="membookcomment" name="membookcomment" class="flat-green " value="1" > หมายเหตุ</label>
                            <div  class="col-sm-5 text-left" >
                                <textarea class="form-control" id="bookcomment" placeholder="ระบุหมายเหตุ" name="bookcomment"  rows="3"></textarea>
                            </div>
                       </div>
                </div>
                   
                <div class="row" style="padding-bottom: 5px;padding-top: 10px;">
                        <div class="form-group">
                            <label for="file-0" class="col-sm-2" style="width: 100px" >
                                ไฟล์แนบ</label>
                            <div  class="col-sm-6 text-left" >
<!--                                   <input id="file-0" class="file" type="file" name="file-0" multiple data-min-file-count="1">
-->

                            </div>
                       </div>
                </div>

                <div class="row" style="padding-bottom: 5px;padding-top: 10px;">
                    <div class="col-sm-8">
                        <div class="form-group">
                                    <div class="container"><h4>การดำเนินการ</h4></div>

                                    <div id="exTab2" class="" >	
                                    <ul class="nav nav-pills">
                                        <li class="active"><a  href="#1" data-toggle="tab">ลงทะเบียนรับและส่ง</a>
                                        </li>
                                        <li><a href="#2" data-toggle="tab">ลงทะเบียนรับ</a>
                                        </li>
                                    </ul>

                                        <div class="tab-content">
                                                                <div class=" tab-pane active" id="1">
                                                                    
                    <div class="row" style="padding-bottom: 5px;padding-top: 20px;">
                        <div class="form-group">
                            <label for="bookno" class="col-sm-1 text-right"  >
                                <input type="checkbox" id="membookcomment" name="membookcomment" class="flat-green " value="1" ></label>
                            <div  class="col-sm-9 text-left" >
<?php
//หาชื่อหน่วยงาน
    $sql_person_name="select * from person_main where status=0 ";
    $query_person_name = $connect->prepare($sql_person_name);
    //$query_person_name->bind_param("i", $user_departid);
    $query_person_name->execute();
    $result_qperson_name=$query_person_name->get_result();
?>
<select class="select2up form-control" multiple="multiple" data-placeholder="กรุณาเลือกเพื่อส่งผู้บริหาร" style="width: 100%;" >
<?php
    While ($result_person_name = mysqli_fetch_array($result_qperson_name))
   {
    echo "<option value=".$result_person_name['person_id'].">".$result_person_name['name']." ".$result_person_name['surname']."</option>";
    }
?>
</select>
                            </div>
                             <div  class="col-sm-1 text-left" >
                                 <button type="button" class="btn btn-danger clearselect2up"  ><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                            </div>
                       </div>
                </div>
                                                                    
                    <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="bookno" class="col-sm-1 text-right"  >
                                <input type="checkbox" id="membookcomment" name="membookcomment" class="flat-green " value="1" ></label>
                            <div  class="col-sm-9 text-left" >
<?php
//หาชื่อหน่วยงาน
    $sql_person_name="select * from person_main where status=0 ";
    $query_person_name = $connect->prepare($sql_person_name);
    //$query_person_name->bind_param("i", $user_departid);
    $query_person_name->execute();
    $result_qperson_name=$query_person_name->get_result();
?>
<select class="select2up form-control" multiple="multiple" data-placeholder="กรุณาเลือกเพื่อส่งกลุ่มภารกิจ" style="width: 100%;" >
<?php
    While ($result_person_name = mysqli_fetch_array($result_qperson_name))
   {
    echo "<option value=".$result_person_name['person_id'].">".$result_person_name['name']." ".$result_person_name['surname']."</option>";
    }
?>
</select>
                            </div>
                             <div  class="col-sm-1 text-left" >
                                 <button type="button" class="btn btn-danger clearselect2up"  ><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                            </div>
                       </div>
                </div>
                                                                    
                    <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="bookno" class="col-sm-1 text-right"  >
                                <input type="checkbox" id="membookcomment" name="membookcomment" class="flat-green " value="1" ></label>
                            <div  class="col-sm-9 text-left" >
<?php
//หาชื่อหน่วยงาน
    $sql_person_name="select * from person_main where status=0 ";
    $query_person_name = $connect->prepare($sql_person_name);
    //$query_person_name->bind_param("i", $user_departid);
    $query_person_name->execute();
    $result_qperson_name=$query_person_name->get_result();
?>
<select class="select2up form-control" multiple="multiple" data-placeholder="กรุณาเลือกเพื่อส่งบุคคล" style="width: 100%;" >
<?php
    While ($result_person_name = mysqli_fetch_array($result_qperson_name))
   {
    echo "<option value=".$result_person_name['person_id'].">".$result_person_name['name']." ".$result_person_name['surname']."</option>";
    }
?>
</select>
                            </div>
                             <div  class="col-sm-1 text-left" >
                                 <button type="button" class="btn btn-danger clearselect2up"  ><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                            </div>
                       </div>
                </div>
                                                                    
               <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group text-center">
                                    <button type="button" class="btn btn-success" ><span class="glyphicon glyphicon-forward" aria-hidden="true"></span>ลงทะเบียนรับและส่ง</button>  
                        </div>
                </div>
                                                                </div><!-- div tab-pane active id=1 -->
                                            
                                                                    <div class="tab-pane" id="2">
                                                                        <div class="row" style="padding-bottom: 5px;padding-top: 20px;">
                                                                                <div class="form-group">
                                                                                    <label for="bookreceiveno" class="col-sm-2" style="width: 140px;color:#000000" > เลขหนังสือรับ</label>
                                                                                    <div  class="col-sm-5 text-left" >
                                                                                        <input type="text" class="form-control" id="bookreceiveno" placeholder="ข้อมูลเลขหนังสือรับ" name="bookreceiveno" required>
                                                                                    </div>
                                                                               </div>
                                                                        </div>
                                                                        <div class="row" style="padding-bottom: 5px;">
                                                                                <div class="form-group">
                                                                                    <label for="bookreceivedate" class="col-sm-2" style="width: 140px;color:#000000" > วันที่รับ</label>
                                                                                    <div  class="col-sm-5 text-left" >
                                                                                        <input type="text" class="form-control" id="bookreceivedate" placeholder="ข้อมูลวันที่รับหนังสือ" name="bookreceivedate" required>
                                                                                    </div>
                                                                               </div>
                                                                        </div>
                                                                    <div align="center"><button type="button" class="btn btn-warning" ><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> ลงทะเบียนรับ</button></div>   
                                                                    </div><!-- div tab-pane active id=2 -->

                                                            </div>
                                      </div>


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
    <script src="./modules/book2/plugins/jQuery/jQuery-2.1.4.min.js"></script>
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
    <!-- Chosen -->
    <script src="./modules/book2/plugins/chosen/chosen.jquery.js"></script>
   
      <!-- My Script -->
     <script src="./modules/book2/main/function.js"></script>
   
     <!-- Page script -->
    <script>
      $(function () {
        //Initialize Select2 Elements
        //$(".select2up").select2();
        var $select2up = $(".select2up").select2();

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
                 language:'th-th',
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