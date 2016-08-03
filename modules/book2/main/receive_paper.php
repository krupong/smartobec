<?php
//Session Login
$userlogin=$_SESSION['login_user_id'];
if(isset($_SESSION['role_id'])){
$user_role_id=mysqli_real_escape_string($connect,$_SESSION['role_id']);
}else {$user_role_id=""; 
?>
<script langquage='javascript'>
window.location="?option=book2&task=main/roleperson";
</script>
<?php
}

//หาสิทธิ์ของผู้ใช้งาน
$roleid_person=$_SESSION["roleid_person"];
//หาชื่อบทบาทของบุคลากร
    $sql_role_person="select * from book2_roleperson where id=?  ";
    $query_role_person = $connect->prepare($sql_role_person);
    $query_role_person->bind_param("i", $roleid_person);
    $query_role_person->execute();
    $result_qrole_person=$query_role_person->get_result();

    While ($result_role_person = mysqli_fetch_array($result_qrole_person))
   {
        $role_id=$result_role_person['role_id']; 
        $level_dep=$result_role_person['level_dep'];  
        $look_dep_subdep=$result_role_person['look_dep_subdep'];  
        $orgtb=$result_role_person['orgtb']; 
   }
        if($level_dep=='2' || $level_dep=='4' || $level_dep>='6' && $level_dep<='12' ){
            $searchorg="book2_department";
        }else{
            $searchorg="book2_subdepartment";            
        }
//หาชื่อบทบาท
    $sql_role="select * from book2_role  where id=?  ";
    $query_role = $connect->prepare($sql_role);
    $query_role->bind_param("i", $role_id);
    $query_role->execute();
    $result_qrole=$query_role->get_result();
    
    While ($result_role = mysqli_fetch_array($result_qrole))
   {
        $role_id=$result_role['id'];
        $name_role=$result_role['name'];
   }
        
//หาชื่อหน่วยงาน
    $sql_dep="select * from $searchorg  where id=?  ";
    $query_dep = $connect->prepare($sql_dep);
    $query_dep->bind_param("i", $look_dep_subdep);
    $query_dep->execute();
    $result_qdep=$query_dep->get_result();
    
    While ($result_dep = mysqli_fetch_array($result_qdep))
   {
        $name_predepart=$result_dep['nameprecis'];
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
                    <form name="receive_frompaper" data-toggle="validator" role="form" method="POST" action="?option=book2&task=main/receive_paper_process">
                    <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="bookno" class="col-sm-2" style="width: 140px" >
                                <input type="checkbox" id="membookno" name="membookno" class="flat-green " value="1" > เลขที่หนังสือ</label>
                            <div  class="col-sm-3 text-left" >
                                <input type="text" class="form-control" id="bookno" placeholder="กรุณากรอกเลขที่หนังสือ" name="bookno" required>
                            </div>
                             <div  class="col-sm-2 text-left" >
                                 <button type="button" class="btn btn-success"  data-toggle="modal" data-target="#checknumreceive" onclick="checknumreceive();" ><span class="glyphicon glyphicon-check" aria-hidden="true"></span> ตรวจสอบเลขที่หนังสือ</button>
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

                  <div class="row text-center" style="padding-bottom: 5px;padding-top: 15px;">
                        <div class="form-group">
                            <button type="submit" id="receivebuttongroup" class="btn btn-info" style="margin: 8px;"  ><span class="glyphicon glyphicon-saved" ></span> ลงทะเบียนรับหนังสือราชการ</button>
                       </div>
                  </div> 

                <!-- Get Process -->
                <?php
                $timestamp = mktime(date("H"), date("i"),date("s"), date("m") ,date("d"), date("Y"))  ;	
                //timestamp เวลาปัจจุบัน 
                $rand_number=rand();
                $ref_id = $timestamp."x".$rand_number;
                ?>
                
                <input type="hidden" name="bookrefid" value="<?php echo $ref_id;?>" />
                <input type="hidden" name="bookstatus" value="1" />
                <input type="hidden" name="inputpermistype" value="rcpaperbook" />
                <input type="hidden" name="inputprocess" value="inputprocess" />
                <input type="hidden" name="inputsender" value="<?php echo $userlogin;?>" />
                <input type="hidden" name="bookfromrole" value="<?php echo $user_role_id;?>" />
                <input type="hidden" name="bookfromorgtb" value="<?php echo $orgtb;?>" />
                <input type="hidden" name="booktype" value="1" />
                
                    </form>
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