<?php
//ข้อมูลบุคลากรที่เข้าระบบ
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

include './modules/book2/main/function.php'; 

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
        <style type="text/css">
            /*  ด่วนที่สุด */
        .ems4 { 
          color: #ff0000 ;
        }
           /*  ด่วนมาก */
        .ems3 { 
          color: #ff4444 ;
        }
        /*  ด่วน */
        .ems2 { 
          color: #ff9900 ;
        }
        /*  ปกติ */
        .ems1 { 
          color: #000099 ;
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
                  <h3 class="box-title">รายการหนังสือเข้า</h3>
                        <div class="box-tools pull-right">
                        <!--    <a class="btn btn-box-tool" href="#" style="color:green"><i class="glyphicon glyphicon-plus"></i> เพิ่มข้อมูลใหม่</a>-->
                            <a href="?option=book2&task=main/receive_paper" class="btn btn-success btn-sm" role="button"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> ลงทะเบียนรับหนังสือจากกระดาษ</a>
 
                        </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="listroletable1" class="table table-bordered table-hover">
                      <thead >
                      <tr>
                        <th style="width:10px"><input type="checkbox" id="allcheckbook" name="allcheckbook"  value="1" ></th>
                        <th  style="width:10px">ที่</th>
                        <th>เลขที่หนังสือส่ง</th>
                        <th>ลงวันที่</th>
                        <th>เรื่อง</th>
                        <th>จาก</th>
                        <th>ส่งเมื่อ</th>
                        <th>รายละเอียด</th>
                      </tr>
                    </thead>
                    <tbody>
<?php
//สถานะหนังสือ  0=ยังไม่รับ 1=ลงรับแล้ว 2=ส่งต่อ 3=ส่งผ่าน 4=ส่งกลับ 5=ยุติเรื่อง
    $receive_status_no="0";

//หาหนังสือรับใหม่
    $sql_booksystem="select * from book2_system where receiver_department=? and receiver_status=? order by  sender_date DESC ";
    $query_booksystem = $connect->prepare($sql_booksystem);
    $query_booksystem->bind_param("si", $look_dep_subdep,$receive_status_no);
    $query_booksystem->execute();
    $result_qbooksystem=$query_booksystem->get_result();
    
    $i=1;
    While ($result_booksystem = mysqli_fetch_array($result_qbooksystem))
   {
        $book2system_id=$result_booksystem['id']; 
        $book2system_book_refid=$result_booksystem['book_refid']; 
        $book2system_send_year=$result_booksystem['send_year']; 
        $book2system_sender_department=$result_booksystem['sender_department']; 
        $book2system_sender_role=$result_booksystem['sender_role']; 
        $book2system_sender_officer=$result_booksystem['sender_officer']; 
        $book2system_sender_date=$result_booksystem['sender_date']; 
        $book2system_sender_department=$result_booksystem['sender_department']; 
        $book2system_book_type=$result_booksystem['book_type']; 

        
        //แสดงหนังสือรอส่ง
            $sql_booksend="select * from book2_send where book_refid=? ";
            $query_booksend = $connect->prepare($sql_booksend);
            $query_booksend->bind_param("s", $book2system_book_refid);
            $query_booksend->execute();
            $result_qbooksend=$query_booksend->get_result();

         While ($result_booksend = mysqli_fetch_array($result_qbooksend))
           {
                $booksend_num=$result_booksend['book_num'];
                $booksend_date=$result_booksend['book_date'];
                $booksend_subject=$result_booksend['book_subject'];
                $booksend_for=$result_booksend['book_for'];
                $booksend_detail=$result_booksend['book_detail'];
                $booksend_comment=$result_booksend['book_comment'];
                $booksend_fromdepartment=$result_booksend['book_fromdepartment'];
                $booksend_level=$result_booksend['book_level'];
                $booksend_secret=$result_booksend['book_secret'];

            }

    //หาชื่อหน่วยงานจากโหนด
        $sql_sanodefrom="select * from book2_department where id=?";
        $query_sanodefrom = $connect->prepare($sql_sanodefrom);
        $query_sanodefrom->bind_param("s", $booksend_fromdepartment);
        $query_sanodefrom->execute();
        $result_qsanodefrom=$query_sanodefrom->get_result();
        While ($result_sanodefrom = mysqli_fetch_array($result_qsanodefrom))
       {    
            $sanodefrom_name=$result_sanodefrom['name'];
            $sanodefrom_nameprecis=$result_sanodefrom['nameprecis'];
        }
   
  //หาชื่อบุคลากร
            $sql_person="select * from person_main where person_id=?";
            $query_person = $connect->prepare($sql_person);
            $query_person->bind_param("i", $login_person_id);
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
  
        if($booksend_level==4){
            $classcolor="ems4";
        }else if($booksend_level==3){
            $classcolor="ems3";
        }else if($booksend_level==2){
            $classcolor="ems2";
        }else{
            $classcolor="ems1";
        }

        ?>
                      <tr>
                          <td><input type="checkbox"  name="checkgroupreceive[]" class="checkbox1"  value="<?php echo $book2system_book_refid;?>" onclick="check(this)"></td>
                        <td><?php echo $i;?></td>
                        <td><?php echo $booksend_num; ?></td>
                        <td><?php echo $booksend_date; ?></td>
                        <td> <?php echo $booksend_subject; ?></td>
                        <td> <?php echo $sanodefrom_nameprecis; ?></td>
                        <td> <?php echo $book2system_sender_date; ?></td>
                        <td> 
                            <a href="#detailbook<?php echo $book2system_book_refid; ?>" data-toggle="modal" onclick="detailbook('<?php echo $book2system_book_refid;?>');" ><span class="glyphicon glyphicon-list-alt <?php echo $classcolor;?>" style="font-size: 1.2em;" ></span></a>
                        </td>
                      </tr>

<?php
$i++;
?>
                <!-- Modal for Read -->
                        <div class="modal fade bs-example-modal-lg" id="detailbook<?php echo $book2system_book_refid; ?>"  data-backdrop="true"  aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-body" align="left">
                                <div class="gallery result"></div>
                                
                            </div>
                        	<div class="modal-footer">
                                    <button class="btn btn-sm" data-dismiss="modal"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> ปิดหน้าต่างนี้</button>
                                </div>
      
                      </div>
                    </div>
                  </div>

                <!-- จบ Modal -->
<?php

    }
?>
                    
                    </tbody>
<!--                    <tfoot>
                      <tr>
                        <th style="width:10px"><input type="checkbox" id="membookno" name="membookno" class="flat-red " value="1" ></th>
                        <th  style="width:10px">ที่</th>
                        <th>เลขที่หนังสือส่ง</th>
                        <th>ลงวันที่</th>
                        <th>เรื่อง</th>
                        <th>จาก</th>
                        <th>ส่งเมื่อ</th>
                        <th>รายละเอียด</th>
                      </tr>
                    </tfoot>
-->
                  </table>
                </div><!-- /.box-body -->
<?php                
//เพิ่มปุ่มลงรับทั้งกลุ่ม
?>
                
                  <div class="row text-center" style="padding-bottom: 5px;padding-top: 15px;">
                        <div class="form-group">
                            <button type="button" id="receivebuttongroup" class="btn btn-info" style="margin: 8px;" data-toggle="modal" data-target="#receivecheckgroup" onclick="groupcheckreceive();" disabled><span class="glyphicon glyphicon-saved" ></span> ลงทะเบียนรับแบบกลุ่ม</button>
                            <button type="button"  id="forwardbuttongroup"  class="btn btn-success" style="margin: 8px;"  data-toggle="modal" data-target="#forwardsendgroup" disabled><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span> ลงทะเบียนรับและส่งต่อแบบกลุ่ม</button>
                            <button type="button"  id="returnbuttongroup"  class="btn btn-warning" style="margin: 8px;" data-toggle="modal" data-target="#returncheckgroup" disabled><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> ส่งคืนแบบกลุ่ม</button>
                           <button type="button"  id="finishbuttongroup"  class="btn btn-danger" style="margin: 8px;" data-toggle="modal" data-target="#finishcheckgroup" disabled><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> ยุติเรื่อง</button>
                       </div>
                      
                <!-- Modal for Read -->
                        <div class="modal fade bs-example-modal-lg" id="receivecheckgroup"  data-backdrop="false"  aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <div class="row container">
                                  <h4 align="left">  ลงทะเบียนรับหนังสือแบบกลุ่ม</h4>
                              </div>
                            </div>
                            <div class="modal-body" align="left">

                                <div class="gallery result"></div>
                                
                            </div>
                        	<div class="modal-footer">
                                    <button class="btn btn-sm" data-dismiss="modal"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> ปิดหน้าต่างนี้</button>
                                </div>
      
                      </div>
                    </div>
                  </div>

                <!-- จบ Modal -->
                <!-- Modal for Read -->
                        <div class="modal fade bs-example-modal-lg" id="forwardsendgroup"  data-backdrop="true"  aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <div class="row container">
                                  <h4 align="left">  เลือกหน่วยงานลงทะเบียนรับแบบกลุ่ม</h4>
                              </div>
                            </div>
                            <div class="modal-body" align="left">

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
                                    
                                
                                
                                
                                
                            </div>
                        	<div class="modal-footer">
                                    <button class="btn btn-sm" data-dismiss="modal"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> ปิดหน้าต่างนี้</button>
                                </div>
      
                      </div>
                    </div>
                  </div>

                <!-- จบ Modal -->
                <!-- Modal for Read -->
                        <div class="modal fade bs-example-modal-lg" id="returncheckgroup"  data-backdrop="false"  aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <div class="row container">
                                  <h4 align="left">  เหตุผลการส่งคืน</h4>
                              </div>
                            </div>
                            <div class="modal-body" align="left">

                                <div class="gallery" id="images_preview"></div>
                                
                            </div>
                        	<div class="modal-footer">
                                    <button class="btn btn-sm" data-dismiss="modal"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> ปิดหน้าต่างนี้</button>
                                </div>
      
                      </div>
                    </div>
                  </div>

                <!-- จบ Modal -->
                      
                      
                      
                </div>


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
    <!--<script src="modules/book2/plugins/datepicker/bootstrap-datepicker.js"></script>-->
    <!-- Date Picker Thai -->
    <!--<script src="modules/book2/plugins/datepicker/locales/bootstrap-datepicker.th.js" charset="UTF-8"></script>-->
    <!-- Date Picker New Dist -->
    <script src="modules/book2/plugins/datepicker/dist/js/bootstrap-datepicker.js"></script>
    <!-- Date Picker Thai  New Dist -->
    <script src="modules/book2/plugins/datepicker/dist/locales/bootstrap-datepicker.th.min.js" charset="UTF-8"></script>
    <!-- DataTables -->
    <script src="modules/book2/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="modules/book2/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="modules/book2/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="modules/book2/plugins/fastclick/fastclick.min.js"></script>
    <!-- Chosen -->
    <script src="modules/book2/plugins/chosen/chosen.jquery.js"></script>
     <!-- My Script -->
     <script src="modules/book2/main/function.js"></script>
       
        <script type="text/javascript">
            
            
            
                    function check(e){
                        var idArray = [];
                                  $("input[name='checkgroupreceive[]']").each( function () {
                            if($(this).prop('checked') == true){
                                idArray.push($(this).val());
                                console.log(idArray.length);
                            }
                    });
                        
                        
                        if(idArray.length !=0){
                            document.getElementById('receivebuttongroup').disabled=false;
                            document.getElementById('forwardbuttongroup').disabled=false;
                            document.getElementById('returnbuttongroup').disabled=false;
                            document.getElementById('finishbuttongroup').disabled=false;
                        }else{
                             document.getElementById('receivebuttongroup').disabled=true;
                             document.getElementById('forwardbuttongroup').disabled=true;
                             document.getElementById('returnbuttongroup').disabled=true;
                             document.getElementById('finishbuttongroup').disabled=true;
                            $("#allcheckbook").prop('checked', false);    
                             
                        }
                    }
                    
                $(document).ready(function(){ 
                $("#allcheckbook").change(function(){
                  $(".checkbox1").prop('checked', $(this).prop("checked"));

                    var idArray = [];
                                  $("input[name='checkgroupreceive[]']").each( function () {
                            if($(this).prop('checked') == true){
                                idArray.push($(this).val());
                                console.log(idArray.length);
                            }
                    });
                         if(idArray.length !=0){
                            document.getElementById('receivebuttongroup').disabled=false;
                            document.getElementById('forwardbuttongroup').disabled=false;
                            document.getElementById('returnbuttongroup').disabled=false;
                            document.getElementById('finishbuttongroup').disabled=false;
                        }else{
                             document.getElementById('receivebuttongroup').disabled=true;
                              document.getElementById('forwardbuttongroup').disabled=true;
                              document.getElementById('returnbuttongroup').disabled=true;
                              document.getElementById('finishbuttongroup').disabled=true;
                            $("#allcheckbook").prop('checked', false);    
                             
                        }

                  });
});




                    </script>
     <!-- Page script -->
        <!--  refresh เมื่อปิด Modal -->
        <script type="text/javascript">

       
        $('#receivecheckgroup').on('hidden.bs.modal', function () {
          document.location.reload();
        })     
        </script>
     
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
        "order": [[ 6, "desc" ]]        
    });

      });
      
               
    </script>
  </body>
</html>