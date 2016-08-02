<?php

//header("content-type:text/javascript;charset=utf-8");   

include 'amssplus_connect.php'; 
include 'modules/book2/main/function.php'; 

//โชว์วันที่วันนี้
$today=date("d-m-Y");
$todaydatetime=date("Y-m-d H:i:s");

//$inputusername=$_SESSION['login_user_id'];;
        
//ตรวจสอบการ นำเข้าข้อมูล
if(isset($_POST['inputprocess'])){
$inputprocess=mysqli_real_escape_string($connect,$_POST['inputprocess']);
}else {$inputprocess=""; header("location:../../../index.php");}

//ประเภทของการ query
if(isset($_POST['inputpermistype'])){
$inputpermistype=mysqli_real_escape_string($connect,$_POST['inputpermistype']);
}else {$inputpermistype=""; echo "ท่านไม่มีสิทธิ์การเข้าใช้งานในส่วนนี้";}


//คำนวณ
    if($inputpermistype=="addbook"){

        
        //นำเข้าหน่วยงาน ที่จะส่ง
if(isset($_POST['booklevel'])){
$inputbooklevel=mysqli_real_escape_string($connect,$_POST['booklevel']);
}else {$inputbooklevel=""; }
//echo $inputbooklevel;
//นำเข้าผู้ส่ง
if(isset($_POST['inputsender'])){
$inputsender=mysqli_real_escape_string($connect,$_POST['inputsender']);
}else {$inputsender=""; }
//echo $inputsender;
//นำเข้าหน่วยงาน ที่จะส่ง
if(isset($_POST['booksecret'])){
$inputbooksecret=mysqli_real_escape_string($connect,$_POST['booksecret']);
}else {$inputbooksecret=""; }
//echo $inputbooksecret;
//นำเข้าหน่วยงาน ที่จะส่ง
if(isset($_POST['booksubject'])){
$inputbooksubject=mysqli_real_escape_string($connect,$_POST['booksubject']);
}else {$inputbooksubject=""; }
//echo $inputbooksubject;
//นำเข้ารายละเอียด
if(isset($_POST['bookdetail'])){
$inputbookdetail=mysqli_real_escape_string($connect,$_POST['bookdetail']);
}else {$inputbookdetail=""; }
//echo $inputbookdetail;
//นำเข้าหน่วยงาน ที่จะส่ง
if(isset($_POST['bookfor'])){
$inputbookfor=mysqli_real_escape_string($connect,$_POST['bookfor']);
}else {$inputbookfor=""; }
//echo $inputbookfor;
//นำเข้าหน่วยงาน ที่จะส่ง ภายนอก
if(isset($_POST['book2other'])){
foreach ($_POST['book2other'] as $book2others){
    $arr_book2other[]=mysqli_real_escape_string($connect,$book2others);
}
$book2other=  implode(",", $arr_book2other);    
}else {$book2other=""; }
//echo $book2other;
//เลข ว
if(isset($_POST['bookwo'])){
$inputbookwo=mysqli_real_escape_string($connect,$_POST['bookwo']);
}else {$inputbookwo=""; }
//echo $inputbookwo;
//นำเข้าหน่วยงานที่ส่ง
if(isset($_POST['bookfrom'])){
$inputbookfrom=mysqli_real_escape_string($connect,$_POST['bookfrom']);
}else {$inputbookfrom=""; }
//echo $inputbookfrom;
//นำเข้าบทบาทผู้ส่ง
if(isset($_POST['bookfromrole'])){
$inputbookfromrole=mysqli_real_escape_string($connect,$_POST['bookfromrole']);
}else {$inputbookfromrole=""; }
//echo $inputbookfromrole;
//นำเข้าประเภท
if(isset($_POST['booktype'])){
$inputbooktype=mysqli_real_escape_string($connect,$_POST['booktype']);
}else {$inputbooktype=""; }
//echo $inputbooktype;
//นำเข้ารหัสอ้างอิง
if(isset($_POST['bookcomment'])){
$inputbookcomment=mysqli_real_escape_string($connect,$_POST['bookcomment']);
}else {$inputbookcomment=""; }
//echo $inputbookcomment;
//นำเข้าสถานะ
if(isset($_POST['bookstatus'])){
$inputbookstatus=mysqli_real_escape_string($connect,$_POST['bookstatus']);
}else {$inputbookstatus=""; }
//echo $inputbookstatus;
//นำเข้ารหัสอ้างอิง
if(isset($_POST['bookrefid'])){
$inputbookrefid=mysqli_real_escape_string($connect,$_POST['bookrefid']);
}else {$inputbookrefid=""; }
//echo $inputbookrefid;
        
        //$inputbookno        = $_POST['bookno'];       //
        $inputbookdate      = dateinput2db($_POST['bookdate']);   //
        echo $inputbookdate;
        //$inputofficer           = $_POST['inputofficer'];   //
        $date_time_now = date("Y-m-d H:i:s");
//        $password_real  = sha1($password); // เป็นการเข้ารหัส password แบบ sha1

        if($_POST['inputtoorganize']!=""){
        $inputtoorganize        = $_POST['inputtoorganize'];      //
        //แยกเอาหน่วยงาน
        	$f_inputtoorganize=explode(",", $inputtoorganize);
                        $arr_inputtoorganize=array();
                
                for($i=0;$i<count($f_inputtoorganize);$i++)
                {
                    if(!ereg("^_", $f_inputtoorganize[$i])){
                        $arr_inputtoorganize[]=$f_inputtoorganize[$i];
                    }
                    
                }
                        //print_r($arr_inputmyorganize);
                        $sendtoorg=  implode(",", $arr_inputtoorganize);
        }else{
            $sendtoorg="ไม่มีประโยชน์"; 
            //ออกไปเลย แจ้งเตือนไม่เลือกหน่วยงาน
        }        

    $todayyear=date("Y");
    //echo    $todayyear;
    //echo $inputbookfrom;
      //ประมวลผลเพื่อออกเลข
//    $sql_bookno="select * from book2_no where sa_node_id=? and no_year=? ";
//    $query_bookno = $connect->prepare($sql_bookno);
//    $query_bookno->bind_param("ss", $inputbookfrom,$todayyear);
    $sql_bookno="select * from book2_no where sa_node_id=? and no_year=? ";
    $query_bookno = $connect->prepare($sql_bookno);
    $query_bookno->bind_param("ss", $inputbookfrom,$todayyear);
    $query_bookno->execute();
    $result_qbookno=$query_bookno->get_result();

 While ($result_bookno = mysqli_fetch_array($result_qbookno))
   {
     $bookno=$result_bookno['no_present']+1;
    //echo $bookno;
    //echo $result_bookno['no_present'];
     
   }

    if($inputbookwo==1){
        $inputbookwoshow="ว";
    }
    //นำเข้า เลข ศธ
    $sql_bookcode="select sa_node_code from book2_department_code where sa_node_id=?  and status=1 ";
    $query_bookcode = $connect->prepare($sql_bookcode);
    $query_bookcode->bind_param("s", $inputbookfrom);
    $query_bookcode->execute();
    $result_qbookcode=$query_bookcode->get_result();

 While ($result_bookcode = mysqli_fetch_array($result_qbookcode))
   {
     $inputbookno=$result_bookcode['sa_node_code'].$inputbookwoshow.$bookno;
    }
        
     //นำเข้าฐานข้อมูล book2_send   
     $sql_insert = "insert into book2_send (id,sender_id,sender_date,editor_id,editor_date,book_to_nodeid,book_to,book_level,book_secret,book_no,book_v,book_date,book_subject,book_detail,book_for,book_comment,book_from,book_fromrole,book_type,book_status,book_refid) values ('',?,?,'','',?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

    if ($dbquery_insert = $connect->prepare($sql_insert)) {
    $dbquery_insert->bind_param("ssssssssssssssssss",$inputsender,$todaydatetime,$sendtoorg,$book2other,$inputbooklevel,$inputbooksecret,$inputbookno,$inputbookwo,$inputbookdate,$inputbooksubject,$inputbookdetail,$inputbookfor,$inputbookcomment,$inputbookfrom,$inputbookfromrole,$inputbooktype,$inputbookstatus,$inputbookrefid);
    $dbquery_insert->execute();
    $result_insert=$dbquery_insert->get_result();
    }
     // อัพเดต เลขล่าสุด
    
     $sql_noupdate = "update book2_no set no_present=?";
    if ($dbquery_noupdate = $connect->prepare($sql_noupdate)) {
    $dbquery_noupdate->bind_param("s",$bookno);
    $dbquery_noupdate->execute();
    $result_noupdate=$dbquery_noupdate->get_result();
    }

?>
<?php
//$book_status="6";    //กรณีออกเลยแล้วรอส่ง 

//แสดงหนังสือรอส่ง
    $sql_booksend="select * from book2_send where book_refid=? ";
    $query_booksend = $connect->prepare($sql_booksend);
    $query_booksend->bind_param("s", $inputbookrefid);
    $query_booksend->execute();
    $result_qbooksend=$query_booksend->get_result();

 While ($result_booksend = mysqli_fetch_array($result_qbooksend))
   {
        $booksend_no=$result_booksend['book_no'];
        $booksend_date=$result_booksend['book_date'];
        $booksend_subject=$result_booksend['book_subject'];
        $booksend_for=$result_booksend['book_for'];
        $booksend_detail=$result_booksend['book_detail'];
        $booksend_comment=$result_booksend['book_comment'];
        $booksend_from=$result_booksend['book_from'];
    }
     

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
                  <h3 class="box-title">แนบไฟล์/รอส่งหนังสือราชการ</h3>
                  <div class="box-tools pull-right">
                      
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body  container">
                
                <!-- Form รับค่า หนังสือ -->    
                <form data-toggle="validator" role="form" method="POST" action="?option=book2&task=main/send_querybook">
                    
                    <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="bookno" class="col-sm-2" style="width: 120px" > เลขที่หนังสือ</label>
                            <div  class="col-sm-3 text-left" >
                                <?php echo $inputbookno;?>
                            </div>
                             <label for="bookdate" class="col-sm-2" style="width: 80px" > ลงวันที่</label>
                              <div  class="col-sm-3 text-left" >
                              <?php echo $inputbookdate;?>
                            </div>
                       </div>
                </div>
    
                 <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="membooklevel" class="col-sm-2" style="width: 120px" >
                                ชั้นความเร็ว</label>
                            <div  class="col-sm-6 text-left">
<?php
//หาชื่อหน่วยงาน
    $sql_booklevel="select * from book2_level where id=? and status=1 ";
    $query_booklevel = $connect->prepare($sql_booklevel);
    $query_booklevel->bind_param("i", $inputbooklevel);
    $query_booklevel->execute();
    $result_qbooklevel=$query_booklevel->get_result();
   
    While ($result_booklevel = mysqli_fetch_array($result_qbooklevel))
   {
         echo $result_booklevel['book_level']; 
    }
?>
                                  </select>
                            </div>
                       </div>
                </div>
                 <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="membooksecret" class="col-sm-2" style="width: 120px" >
                                 ชั้นความลับ</label>
                            <div  class="col-sm-6 text-left">
<?php
//หาชื่อหน่วยงาน
    $sql_booksecret="select * from book2_secret where id=? and status=1 ";
    $query_booksecret = $connect->prepare($sql_booksecret);
    $query_booksecret->bind_param("i", $inputbooksecret);
    $query_booksecret->execute();
    $result_qbooksecret=$query_booksecret->get_result();
    While ($result_booksecret = mysqli_fetch_array($result_qbooksecret))
   {
            echo $result_booksecret['book_secret'];
    }
?>

                                  </select>
                            </div>
                       </div>
                </div>

                <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="booksubject" class="col-sm-2" style="width: 120px" >
                                 เรื่อง</label>
                            <div  class="col-sm-6 text-left" >
                                <?php echo $inputbooksubject;?>
                            </div>
                       </div>
                </div>

                <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="bookfor" class="col-sm-2" style="width: 120px" >
                                 เรียน</label>
                            <div  class="col-sm-6 text-left" >
                                <?php echo $inputbookfor;?>
                            </div>
                       </div>
                </div>

                  <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="bookdetail" class="col-sm-2" style="width: 120px" >
                                 รายละเอียด</label>
                            <div  class="col-sm-6 text-left" >
                             <?php echo $inputbookdetail;?>
                            </div>
                       </div>
                </div>
                    
                <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="membookto" class="col-sm-1" style="width: 120px" >
                                 ถึง</label>

                                <div  class="col-sm-6 text-left  fom-control" >
	<p>
                <?php
                
                  $f_sendtoorg=explode(",", $sendtoorg);
                  $countsendorg=  count($f_sendtoorg);
                  $count_showorg = $countsendorg;
                if ($sendtoorg=="" || $countsendorg==0){$countsendorg="-"; $count_showorg=0;}
                
/*
                if ($sendtoorg!=''){
                //จำนวนหน่วยงานในระบบ
                $countsendorg =  substr_count($sendtoorg,",")+1;
                }else{
                 $countsendorg ="-";   
                }
 */
                ?>
		<label>หน่วยงานที่ส่ง(ในระบบ) : </label>
                <?php
                echo $countsendorg;
                ?>
                หน่วยงาน 

<?php
                if($count_showorg!=0){
?>
                <!--//เพิ่ม MoDal -->
                                      <!-- Modal for Read -->
                      <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal1">รายชื่อหน่วยงาน</button>
                      <div class="modal fade bs-example-modal-lg" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <div class="row container">
                                  <h4>  รายชื่อหน่วยงานที่ส่ง(ส่งภายในระบบ)</h4>
                              </div>
                            </div>
                            <div class="modal-body">
                              <div class="well">
                               <div class="row">
                                <div class="col-md-6 text-left">
                                  <h4>
                                  <?php
                $showorg_1=  ceil($count_showorg/2)-1;
                
//ค้นหารายชื่อหน่วยงานที่ส่ง
                $j=0;
                 for($i=0;$i<=$showorg_1;$i++)
                {
                     $sendidorg=$f_sendtoorg[$i];
                     //หารายชื่อแต่ละหน่วยงาน
                $sql_sanode="select * from book2_sa_node_id where sa_node_id=? ";
                $query_sanode = $connect->prepare($sql_sanode);
                $query_sanode->bind_param("s", $sendidorg);
                $query_sanode->execute();
                $result_qsanode=$query_sanode->get_result();
                    While ($result_sanode = mysqli_fetch_array($result_qsanode))
                   {
                            $sa_node_name=$result_sanode['sa_node_name'];
                   }
                     
                 $j=$i+1;    
                 echo "<p>".$j.".".$sa_node_name."</p>";  
                     
                }
?>
                                  </h4>
                                </div>
                                <div class="col-md-6 text-left">
                                    <h4>
 <?php
            //ค้นหารายชื่อหน่วยงานที่ส่ง
                $h=0;
                $showorg_2=$showorg_1+1;
                 for($k=$showorg_2;$k<$count_showorg;$k++)
                {
                     $sendidorg=$f_sendtoorg[$k];
                     //หารายชื่อแต่ละหน่วยงาน
                $sql_sanode="select * from book2_sa_node_id where sa_node_id=? ";
                $query_sanode = $connect->prepare($sql_sanode);
                $query_sanode->bind_param("s", $sendidorg);
                $query_sanode->execute();
                $result_qsanode=$query_sanode->get_result();
                    While ($result_sanode = mysqli_fetch_array($result_qsanode))
                   {
                            $sa_node_name=$result_sanode['sa_node_name'];
                   }                     
                 $h=$k+1;    
                 echo "<p>".$h.".".$sa_node_name."</p>";  
                     
                }
?>
                                    </h4>
                                </div>
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                <!-- จบ Modal -->
<?php
                }
?>
 	</p>
	<p>
                <?php
                
                $f_book2other=explode(",", $book2other);
                  $countbook2other=  count($f_book2other);
                   $count_book2other = $countbook2other;
               if ($book2other=="" || $countbook2other==0){$countbook2other="-"; $count_book2other=0; }

/*
                if ($countbook2other!=''){
                //จำนวนหน่วยงานนอกระบบ
                $countbook2other =  substr_count($book2other,",")+1;
                }else{
                 $countbook2other ="-";   
                }
 * 
 */
                ?>
		<label>หน่วยงานที่ส่ง(ภายนอกระบบ) : </label>
                <?php
                echo $countbook2other;
                ?>
                หน่วยงาน
                <!--<button id="btnResetSearch" >&times;</button>-->
		<!--<span id="matches"></span>-->
                <?php
                if($count_book2other!=0){
                    ?>
                <!--//เพิ่ม MoDal -->
                                      <!-- Modal for Read -->
                      <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal2">รายชื่อหน่วยงาน</button>
                      <div class="modal fade bs-example-modal-lg" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <div class="row container">
                                  <h4>  รายชื่อหน่วยงานที่ส่ง(ส่งออกไปภายนอกระบบ)</h4>
                              </div>
                            </div>
                            <div class="modal-body">
                              <div class="well">
                               <div class="row">
                                <div class="col-md-6 text-left">
                                  <h4>
                                  <?php
                $showbook2other_1=  ceil($count_book2other/2)-1;                        
//ค้นหารายชื่อหน่วยงานที่ส่ง
                $j=0;
                 for($i=0;$i<=$showbook2other_1;$i++)
                {                     
                 $j=$i+1;                 
                 echo "<p>".$j.".".$f_book2other[$i]."</p>";                       
                }
?>
                                  </h4>
                                </div>
                                <div class="col-md-6 text-left">
                                    <h4>
 <?php
            //ค้นหารายชื่อหน่วยงานที่ส่ง
                $h=0;
                $showbook2other_2=$showbook2other_1+1;
                 for($k=$showbook2other_2;$k<$count_book2other;$k++)
                { 
                     $h=$k+1;    
                 echo "<p>".$h.".".$f_sendtoorg[$k]."</p>";                       
                }
?>
                                    </h4>
                                </div>
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                <!-- จบ Modal -->
<?php
                }
?> 
        
        
        
        </p>
                                </div>

                        </div>
                </div>
                    
<?php

            //หาสิทธิ์ของผู้ใช้งาน
                $sql_sanode="select * from book2_sa_node_id where sa_node_id=? ";
                $query_sanode = $connect->prepare($sql_sanode);
                $query_sanode->bind_param("s", $inputbookfrom);
                $query_sanode->execute();
                $result_qsanode=$query_sanode->get_result();
                    While ($result_sanode = mysqli_fetch_array($result_qsanode))
                   {
                            $sa_node_name=$result_sanode['sa_node_name'];
                   }
?>
                    
                    
                 <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="membookfrom" class="col-sm-2" style="width: 120px" >
                                 จาก</label>
                            <div  class="col-sm-6 text-left" >
                                <?php echo $sa_node_name;?>
                            </div>
                       </div>
                </div>
                   
                  <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="bookcomment" class="col-sm-2" style="width: 120px" >
                                 หมายเหตุ</label>
                            <div  class="col-sm-6 text-left" >
                                <?php echo $inputbookcomment;?>
                            </div>
                       </div>
                </div>
                   
                  <div class="row text-center" style="padding-bottom: 5px;padding-top: 15px;">
                        <div class="form-group">
                            <button type="submit" class="btn btn-github" style="margin: 8px;"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> แก้ไขรายการส่งหนังสือ</button>
                            <button type="submit" class="btn btn-success" style="margin: 8px;"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> แนบไฟล์เหมือนกันทุกหน่วยงาน</button>
                           <button type="submit" class="btn btn-warning" style="margin: 8px;"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> แนบไฟล์ต่างกัน</button>
                           <button type="submit" class="btn btn-primary" style="margin: 8px;"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> ส่งหนังสือราชการ</button>
                       </div>
                </div>
 <!--	<div>Selected keys: <span id="echoSelection3">-</span></div>
	<div>Selected root keys: <span id="echoSelectionRootKeys3">-</span></div>
	<div>Selected root nodes: <span id="echoSelectionRoots3">-</span></div>
-->
        
        
                <!-- Get Process -->
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
<?php
    }
?>