<?php
//header("content-type:text/javascript;charset=utf-8");   
//โชว์วันที่วันนี้
$today=date("d-m-Y");
//Session Login
$userlogin=$_SESSION['login_user_id'];

?>

<html>
    <head>
        
    </head>
 
   <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

<!-- Your Page Content Here -->

    <!-- ใส่เนื้อหาตรงนี้ -->
        <!-- Main content -->
        <section class="content">

            <div class="box container">
                <div class="box-header">
                  <h3 class="box-title">ออกเลขส่งหนังสือราชการ</h3>
                  <div class="box-tools pull-right">
                      
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body  container">
                
                <!-- Form รับค่า หนังสือ -->    
                <form data-toggle="validator" role="form" method="POST" action="?option=book2&task=main/send_processbook">
                    
                    <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="bookno" class="col-sm-2" style="width: 140px" > เลขที่หนังสือ</label>
                            <div  class="col-sm-3 text-left" >
                                <input type="text" class="form-control" id="bookno" placeholder="ระบบจะกำหนดให้อัตโนมัติ" name="bookno" readonly >
                            </div>
                            <div  class="col-sm-1 text-left form-group" style="width: 70px" >
                                <label for="bookwo" class="" >
                                <input type="checkbox" id="bookwo" name="bookwo" class="flat-red " value="1" > ว</label>
                            </div>
                             <div  class="col-sm-3 text-left" >
                                    <div class="input-group date" id="datepicker2" >
                                        <input type="text" class="form-control" name="bookdate" id="bookdate" value="<?php echo $today;?>" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                            </div>
                       </div>
                </div>
    
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
        <input type="radio" id="booklevel" name="booklevel" class="flat-blue " value="<?php echo  $result_booklevel['id']?>" <?php echo $showselected; ?>> <?php echo $result_booklevel['book_level']; ?> 
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
        <input type="radio" id="booksecret" name="booksecret" class="flat-blue " value="<?php echo  $result_booksecret['id']?>" <?php echo $showchecked; ?>> <?php echo $result_booksecret['book_secret']; ?>  
   <?php
    }
?>

                                  </select>
                            </div>
                       </div>
                </div>

                <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="booksubject" class="col-sm-2" style="width: 140px" >
                                <input type="checkbox" id="membooksubject" name="membooksubject" class="flat-green " value="1"  > เรื่อง</label>
                            <div  class="col-sm-6 text-left" >
                                <input type="text" class="form-control" id="booksubject" placeholder="กรุณากรอกเรื่อง" name="booksubject" required >
                            </div>
                       </div>
                </div>

                <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="bookfor" class="col-sm-2" style="width: 140px" >
                                <input type="checkbox" id="membookfor" name="membookfor" class="flat-green " value="1" > เรียน</label>
                            <div  class="col-sm-6 text-left" >
                                <input type="text" class="form-control" id="bookfor" placeholder="กรุณาระบุข้อมูล" name="bookfor" required>
                            </div>
                       </div>
                </div>

                  <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="bookdetail" class="col-sm-2" style="width: 140px" >
                                <input type="checkbox" id="membookdetail" name="membookdetail" class="flat-green " value="1" > รายละเอียด</label>
                            <div  class="col-sm-6 text-left" >
                                <textarea class="form-control" id="bookdetail" placeholder="ระบุรายละเอียด" name="bookdetail"  rows="2"></textarea>
                            </div>
                       </div>
                </div>
                    
                <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="membookto" class="col-sm-1" style="width: 140px" >
                                <input type="checkbox" id="membookto" name="membookto" class="flat-green " value="1" > ถึง</label>

<!--                                <div  class="col-sm-6 text-left " >
<?php
/*
//หาชื่อหน่วยงาน
    $sql_sanode="select * from book2_sa_node_id ";
    $query_sanode = $connect->prepare($sql_sanode);
    //$query_person_name->bind_param("i", $user_departid);
    $query_sanode->execute();
    $result_qsanode=$query_sanode->get_result();
?>
<select class="select2up form-control" multiple="multiple" data-placeholder="ส่งถึง สพฐ./สำนัก" style="width: 100%;" >
<?php
    While ($result_sanode = mysqli_fetch_array($result_qsanode))
   {
    echo "<option value=".$result_sanode['sa_node_id'].">".$result_sanode['sa_node_name']."</option>";
    }
 
 */
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
                            <div class="col-sm-1" style="width: 140px" >
                            </div>

                                <div  class="col-sm-6 text-left " >
 -->
<?php
/*
//หาชื่อหน่วยงาน
    $sql_sanode="select * from book2_sa_node_id ";
    $query_sanode = $connect->prepare($sql_sanode);
    //$query_person_name->bind_param("i", $user_departid);
    $query_sanode->execute();
    $result_qsanode=$query_sanode->get_result();
?>
<select class="select2up form-control" multiple="multiple" data-placeholder="ส่งถึง สพป./สพม." style="width: 100%;" >
<?php
    While ($result_sanode = mysqli_fetch_array($result_qsanode))
   {
    echo "<option value=".$result_sanode['sa_node_id'].">".$result_sanode['sa_node_name']."</option>";
    }
 
 */
?>
 <!--
</select>
                            </div>
                             <div  class="col-sm-1 text-left" >
                                 <button type="button" class="btn btn-danger clearselect2up"  ><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                            </div>

                        </div>
                </div>
                <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <div class="col-sm-1" style="width: 140px" >
                            </div>

                                <div  class="col-sm-6 text-left " >
 -->
<?php
/*
//หาชื่อหน่วยงาน
    $sql_sanode="select * from book2_sa_node_id ";
    $query_sanode = $connect->prepare($sql_sanode);
    //$query_person_name->bind_param("i", $user_departid);
    $query_sanode->execute();
    $result_qsanode=$query_sanode->get_result();
?>
<select class="select2up form-control" multiple="multiple" data-placeholder="ส่งถึง โรงเรียนหน่วยเบิก/การศึกษาพิเศษ" style="width: 100%;" >
<?php
    While ($result_sanode = mysqli_fetch_array($result_qsanode))
   {
    echo "<option value=".$result_sanode['sa_node_id'].">".$result_sanode['sa_node_name']."</option>";
    }
 
 */
?>
 <!--
</select>
                            </div>

                        </div>
                </div>
 
                <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <div class="col-sm-1" style="width: 140px" >
                            </div>

                                <div  class="col-sm-6 text-left " >
 -->                                   
<?php

//กำหนดเงื่อนไข
$shownodegroup2="SA";
$shownodegroup3="AG";
$shownodegroup4="AA";

//หาชื่อหน่วยงาน
    $sql_sanode2="select * from book2_sa_node_id where  (sa_node_group=? or sa_node_group=? or sa_node_group=?) order by organize,sa_node_thgroup ASC,CONVERT(sa_node_name USING tis620)  ";
    $query_sanode2 = $connect->prepare($sql_sanode2);
    $query_sanode2->bind_param("sss", $shownodegroup2, $shownodegroup3, $shownodegroup4);
    $query_sanode2->execute();
    $result_qsanode2=$query_sanode2->get_result();
    
    
//setup array to hold information
$consoles = array();

//setup holders for the different types so that we can filter out the data
$organizeId = 0;
$thgroupId = 0;
$nodeId = 0;

//setup to hold our current index
$organizeIndex = -1;
$thgroupIndex = -1;
$nodeIndex = -1;
//$thgroupname="";
//go through the rows
while($row = mysqli_fetch_assoc($result_qsanode2)){
        $sa_node_thgroup=$row['sa_node_thgroup'];
        $saorganize=$row['organize'];
    
    if($organizeId != $row['organize']){
        $organizeIndex++;
        $thgroupIndex = -1;
        $organizeId = $row['organize'];
        
        //หาชื่อหน่วยงาน
            $sql_b2organize="select * from book2_organize where id=? ";
            $query_b2organize = $connect->prepare($sql_b2organize);
            $query_b2organize->bind_param("s", $saorganize);
            $query_b2organize->execute();
            $result_qb2organize=$query_b2organize->get_result();
                While ($result_b2organize = mysqli_fetch_array($result_qb2organize))
                    {
                        $b2organize=$result_b2organize['book_organize'];
                    }

        //add the console
        $consoles[$organizeIndex]['title'] = $b2organize;

        //setup the information array
        $consoles[$organizeIndex]['children'] = array();
    }

    if($thgroupId != $row['sa_node_thgroup']){
        $thgroupIndex++;
        $nodeIndex = -1;        
        $thgroupId = $row['sa_node_thgroup'];

        if($saorganize==1){
            
            
        //หาชื่อกลุ่ม
            $sql_sanodethgroup="select * from system_workgroup where workgroup=? ";
            $query_sanodethgroup = $connect->prepare($sql_sanodethgroup);
            $query_sanodethgroup->bind_param("s", $sa_node_thgroup);
            $query_sanodethgroup->execute();
            $result_qsanodethgroup=$query_sanodethgroup->get_result();
                While ($result_sanodethgroup = mysqli_fetch_array($result_qsanodethgroup))
                    {   
                        $thgroupname=$result_sanodethgroup['workgroup_desc'];
                    }
                $consoles[$organizeIndex]['children'][] = array(
                     'title'      => $thgroupname,
                     'key'       => $row['sa_node_id']
               );
    
        }else if($saorganize==2){
        //หาชื่อกลุ่ม
            $sql_sanodethgroup="select * from system_school_group where code=? ";
            $query_sanodethgroup = $connect->prepare($sql_sanodethgroup);
            $query_sanodethgroup->bind_param("s", $sa_node_thgroup);
            $query_sanodethgroup->execute();
            $result_qsanodethgroup=$query_sanodethgroup->get_result();
                While ($result_sanodethgroup = mysqli_fetch_array($result_qsanodethgroup))
                    {
                        $thgroupname=$result_sanodethgroup['name'];
                    }
        $consoles[$organizeIndex]['children'][$thgroupIndex]['title'] = $thgroupname;
            
                    
        }
        
        //add the model to the console
        //$consoles[$organizeIndex]['children'][$thgroupIndex]['title'] = $thgroupname;

        //setup the title array
       $consoles[$organizeIndex]['children'][$thgroupIndex]['children'] = array();
    }else{
        //กรณีไม่รู้ส่งกลุ่มไหน ส่ง สารบรรณกลางไว้ก่อน
            $showsaraban="สารบรรณกลางเขตพื้นที่";
            if($row['sa_node_group']=='AA'){
                $consoles[$organizeIndex]['children'][] = array(
                     'title'      => $showsaraban,
                     'key'       => $row['sa_node_id']
               );
            }
    }

    if($saorganize==2){
       $consoles[$organizeIndex]['children'][$thgroupIndex]['children'][] = array(
            'title'      => $row['sa_node_name'],
            'key'       => $row['sa_node_id']
               );
    }
}

echo json_encode($consoles,JSON_UNESCAPED_UNICODE);


/*    
    $resultArray = array();
    
    While ($result_sanode2 = mysqli_fetch_array($result_qsanode2,MYSQLI_ASSOC))
   {
      	array_push($resultArray,$result_sanode2);  
   }

    //$resultArray = iconv("utf-8",$resultArray);
   echo json_encode($resultArray,JSON_UNESCAPED_UNICODE );
   print_r($resultArray);
 
 */
/*
//กำหนดเงื่อนไข
$shownodegroup="SA";
//หาชื่อหน่วยงาน
    $sql_sanode="select * from book2_sa_node_id where sa_node_group=? order by sa_node_thgroup ASC,CONVERT(sa_node_name USING tis620)  ";
    $query_sanode = $connect->prepare($sql_sanode);
    $query_sanode->bind_param("s", $shownodegroup);
    $query_sanode->execute();
    $result_qsanode=$query_sanode->get_result();
?>
                                    <select class="select2up form-control" multiple="multiple" name="inputschool[]" data-placeholder="ส่งถึง โรงเรียนในสังกัด" style="width: 100%;" >
<?php
    //ตั้งค่าเริ่มต้น
    $sa_node_thgroup_old=0;
    While ($result_sanode = mysqli_fetch_array($result_qsanode))
   {
        //
        $sa_node_thgroup=$result_sanode['sa_node_thgroup'];
        
        //หาชื่อกลุ่ม
            $sql_sanodethgroup="select * from system_school_group where code=? ";
            $query_sanodethgroup = $connect->prepare($sql_sanodethgroup);
            $query_sanodethgroup->bind_param("s", $sa_node_thgroup);
            $query_sanodethgroup->execute();
            $result_qsanodethgroup=$query_sanodethgroup->get_result();
                While ($result_sanodethgroup = mysqli_fetch_array($result_qsanodethgroup))
                    {
                        $thgroupname=$result_sanodethgroup['name'];
                    }
                    
   if($sa_node_thgroup_old == 0){
         echo "<optgroup label=".$thgroupname.">";
     }else if($sa_node_thgroup_old != $sa_node_thgroup){
        echo "</optgroup>";
        echo "<optgroup label=".$thgroupname.">"; 
     }

    echo "<option value=".$result_sanode['sa_node_id'].">".$result_sanode['sa_node_name']."(".$thgroupname.")</option>";
   
        //จำค่ากลุ่มเดิม
        $sa_node_thgroup_old=$sa_node_thgroup;     
    }
 
 */
?>
<!--                                        
</select>
                            </div>

                        </div>
                </div>
 
                <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <div class="col-sm-1" style="width: 140px" >
                            </div>
-->
                                <div  class="col-sm-6 text-left  fom-control" >
                                    <!-- แสดงรายการแบบ tree -->
	<p>
		<label>ค้นหาหน่วยงาน:</label>
                <input name="search"  placeholder="ระบุคำค้นหา..." autocomplete="off">
                <!--<button id="btnResetSearch" >&times;</button>-->
		<!--<span id="matches"></span>-->
	</p>
                                    <div id="treeorganize"></div>
                                </div>

                        </div>
                </div>
                    
                    
                    <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <div class="col-sm-1" style="width: 140px" >
                            </div>

                                <div  class="col-sm-6 text-left " >
<?php
//หาชื่อหน่วยงาน
    $sql_sanode="select * from book2_sa_node_id ";
    $query_sanode = $connect->prepare($sql_sanode);
    //$query_person_name->bind_param("i", $user_departid);
    $query_sanode->execute();
    $result_qsanode=$query_sanode->get_result();
?>
                                    <select class="select2uptag form-control" multiple="multiple" data-placeholder="ส่งถึง หน่วยงานอื่นๆ" name="book2other[]" style="width: 100%;" >
<?php
    While ($result_sanode = mysqli_fetch_array($result_qsanode))
   {
    echo "<option value=".$result_sanode['sa_node_id'].">".$result_sanode['sa_node_name']."</option>";
    }
?>
</select>
                            </div>
 
                        </div>
                </div>

<?php

//หาสิทธิ์ของผู้ใช้งาน
    $sql_roleuser="select * from book2_roleuser where person_id=? order by sa_node_id ASC";
    $query_roleuser = $connect->prepare($sql_roleuser);
    $query_roleuser->bind_param("s", $userlogin);
    $query_roleuser->execute();
    $result_qroleuser=$query_roleuser->get_result();
?>
                    
                    
                 <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="membookfrom" class="col-sm-2" style="width: 140px" >
                                <input type="checkbox" id="membookfrom" name="membookfrom" class="flat-green " value="1" > จาก</label>
                            <div  class="col-sm-6 text-left" >
                                <select class="form-control" id="bookfrom"  data-placeholder="กรุณาระบุหน่วยงานที่จะส่ง" style="width: 100%;" name="bookfrom" >
                                <?php
                                    While ($result_roleuser = mysqli_fetch_array($result_qroleuser))
                                   {
                                        $roleuser_sa_node_id=$result_roleuser['sa_node_id'];
                                        //หาสิทธิ์ของผู้ใช้งาน
                                            $sql_sanode="select * from book2_sa_node_id where sa_node_id=? ";
                                            $query_sanode = $connect->prepare($sql_sanode);
                                            $query_sanode->bind_param("s", $roleuser_sa_node_id);
                                            $query_sanode->execute();
                                            $result_qsanode=$query_sanode->get_result();
                                                While ($result_sanode = mysqli_fetch_array($result_qsanode))
                                               {
                                                        $sa_node_name=$result_sanode['sa_node_name'];
                                                        $sa_node_id=$result_sanode['sa_node_id'];                        
                                               }

                                    echo "<option value=".$sa_node_id.">".$sa_node_name."</option>";
                                    }
                                ?>
                                </select>               

                                <!--<input type="text" class="form-control" id="bookfrom" placeholder="กรุณาระบุหน่วยงานที่ส่งมา" name="bookfrom" required>-->
                            </div>
                       </div>
                </div>
                   
                  <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="bookcomment" class="col-sm-2" style="width: 140px" >
                                <input type="checkbox" id="membookcomment" name="membookcomment" class="flat-green " value="1" > หมายเหตุ</label>
                            <div  class="col-sm-6 text-left" >
                                <textarea class="form-control" id="bookcomment" placeholder="ระบุหมายเหตุ" name="bookcomment"  rows="2"></textarea>
                            </div>
                       </div>
                </div>
                   
                  <div class="row text-center" style="padding-bottom: 5px;padding-top: 15px;">
                        <div class="form-group">
                                <button type="submit" class="btn btn-facebook" ><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> ออกเลขหนังสือส่ง</button>
                       </div>
                </div>
	<div>Selected keys: <span id="echoSelection3">-</span></div>
	<div>Selected root keys: <span id="echoSelectionRootKeys3">-</span></div>
	<div>Selected root nodes: <span id="echoSelectionRoots3">-</span></div>

        
        
                <!-- Get Process -->
                <?php
                $timestamp = mktime(date("H"), date("i"),date("s"), date("m") ,date("d"), date("Y"))  ;	
                //timestamp เวลาปัจจุบัน 
                $rand_number=rand();
                $ref_id = $timestamp."x".$rand_number;
                ?>
                
                
                <input type="hidden" name="bookrefid" value="<?php echo $ref_id;?>" />
                <input type="hidden" name="bookstatus" value="6" />
                <input type="hidden" name="inputpermistype" value="addbook" />
                <input type="hidden" name="inputprocess" value="inputprocess" />
                <input type="hidden" name="inputsender" value="<?php echo $userlogin;?>" />
                <input type="hidden" name="inputtoorganize" id="inputtoorganize" value="">

                </form>
                <!-- จบ Form รับค่าหนังสือ -->
        
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
    <!-- JQuery UI 1.11.4 -->
     <script src="modules/book2/plugins/jQueryUI/jquery-ui.min.js" type="text/javascript"></script>
     
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
    <!-- Tree View -->
    <script src="modules/book2/plugins/treeview/bootstrap-treeview.js"></script>
     <!-- Fancy  Tree View -->
    <script src="modules/book2/plugins/fancytree/jquery.fancytree.js"></script>
     <script src="modules/book2/plugins/fancytree/jquery.fancytree.filter.js"></script>
  
     
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

<script type="text/javascript">
    
    var consoles = <?php echo json_encode($consoles); ?>;

	$(function(){

		// --- Initialize sample trees
		$("#treeorganize").fancytree({
			checkbox: true,
			selectMode: 3,
			source: consoles,
			extensions: ["filter"],
			quicksearch: true,
			filter: {
                                                                autoApply: true,  // Re-apply last filter if lazy data is loaded
				counter: true,  // Show a badge with number of matching child nodes near parent icons
				fuzzy: false,  // Match single characters in order, e.g. 'fb' will match 'FooBar'
				hideExpandedCounter: true,  // Hide counter badge, when parent is expanded
				highlight: true,  // Highlight matches by wrapping inside <mark> tags
				mode: "dimm"  // Grayout unmatched nodes (pass "hide" to remove unmatched node instead)
			},
			activate: function(event, data) {
//				alert("activate " + data.node);
			},
                        
			lazyLoad: function(event, ctx) {
				ctx.result = {url: "ajax-sub2.json", debugDelay: 1000};
			},
			loadChildren: function(event, ctx) {
				ctx.node.fixSelection3AfterClick();
			},
			select: function(event, data) {
				// Get a list of all selected nodes, and convert to a key array:
				//var selKeys = $.map(data.tree.getSelectedNodes(), function(node){
				//	return node.key;
				//});
				var selKeys = $.map(data.tree.getSelectedNodes({ stopOnParents: true }), function(node){
					return node.key;
				});
				$("#echoSelection3").text(selKeys.join(", "));
				$("#inputtoorganize").val(selKeys.join(","));

				// Get a list of all selected TOP nodes
				var selRootNodes = data.tree.getSelectedNodes(true);
				// ... and convert to a key array:
				var selRootKeys = $.map(selRootNodes, function(node){
					return node.key;
				});
				$("#echoSelectionRootKeys3").text(selRootKeys.join(","));
				$("#echoSelectionRoots3").text(selRootNodes.join(","));
			},
			dblclick: function(event, data) {
				data.node.toggleSelected();
			},
			keydown: function(event, data) {
				if( event.which === 32 ) {
					data.node.toggleSelected();
					return false;
				}
			},
			// The following options are only required, if we have more than one tree on one page:
//				initId: "treeData",
			cookieId: "fancytree-Cb3",
			idPrefix: "fancytree-Cb3-",
 		});
		var tree = $("#treeorganize").fancytree("getTree");
		/*
		 * Event handlers for our little demo interface
		 */
		$("input[name=search]").keyup(function(e){
			var n,
				opts = {
					autoExpand: $("#autoExpand").is(":checked"),
					leavesOnly: $("#leavesOnly").is(":checked")
				},
				match = $(this).val();

			if(e && e.which === $.ui.keyCode.ESCAPE || $.trim(match) === ""){
                                                                    $("input[name=search]").val("");
                                                                $("span#matches").text("");
                                                                tree.clearFilter();
				$("button#btnResetSearch").click();
				return;
			}
			if($("#regex").is(":checked")) {
				// Pass function to perform match
				n = tree.filterNodes(function(node) {
					return new RegExp(match, "i").test(node.title);
				}, opts);
			} else {
				// Pass a string to perform case insensitive matching
				n = tree.filterNodes(match, opts);
			}
			$("button#btnResetSearch").attr("disabled", false);
			$("span#matches").text("(" + n + " หน่วยงาน)");
		//}).focus();  //ให้ Cursor ไปอยู่ช่องค้นหารอเลย
                                   });

                                $("button#btnResetSearch").click(function(e){
			$("input[name=search]").val("");
			$("span#matches").text("");
			tree.clearFilter();
		}).attr("disabled", true);

		$("fieldset input:checkbox").change(function(e){
			var id = $(this).attr("id"),
				flag = $(this).is(":checked");

			switch( id ) {
			case "autoExpand":
			case "regex":
			case "leavesOnly":
				// Re-apply filter only
				break;
			case "hideMode":
				tree.options.filter.mode = flag ? "hide" : "dimm";
				break;
			case "counter":
			case "fuzzy":
			case "hideExpandedCounter":
			case "highlight":
				tree.options.filter[id] = flag;
				break;
			}
			tree.clearFilter();
			$("input[name=search]").keyup();
		});

		$("#counter,#hideExpandedCounter,#highlight").prop("checked", true);

    //$("form").submit(function() {
      // Render hidden <input> elements for active and selected nodes

   // $("#treeorganize").fancytree("getTree").generateFormElements("selectedVar", "activeVar",{ stopOnParents: false });
        //$(this).serializeArray();
        //        var formData = $form.serializeArray();
      //alert(console.log(serializeArray()));
      //$("#treeorganize").fancytree("getTree").generateFormElements();
      //alert("POST data:\n" + jQuery.param($(this).serializeArray()));
      // return false to prevent submission of this sample
     // return false;
    //});
   
    
    });
        
</script>
                            
  </body>
</html>