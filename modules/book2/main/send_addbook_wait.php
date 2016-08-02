<?php

//header("content-type:text/javascript;charset=utf-8");   
//เช็ค SESSION ผู้เข้าระบบ
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

//บทบาทที่เข้ามาด้วย
//หาสิทธิ์ของผู้ใช้งาน
/*    $sql_roleuser="select * from book2_roleperson where person_id=? order by sa_node_id ASC";
    $query_roleuser = $connect->prepare($sql_roleuser);
    $query_roleuser->bind_param("s", $userlogin);
    $query_roleuser->execute();
    $result_qroleuser=$query_roleuser->get_result();
        While ($result_roleuser = mysqli_fetch_array($result_qroleuser))
       {
            $roleuser_sa_node_id=$result_roleuser['sa_node_id'];
       }
*/
//ตรวจสอบการ นำเข้าข้อมูล
if(isset($_GET['id'])){
$getref_id=mysqli_real_escape_string($connect,$_GET['id']);
}else {$getref_id=""; header("location:../../../index.php");}

include 'database_connect.php'; 
include './modules/book2/main/function.php'; 

//$book_status="6";    //กรณีออกเลยแล้วรอส่ง 

//แสดงหนังสือรอส่ง
    $sql_booksend="select * from book2_send where book_refid=? ";
    $query_booksend = $connect->prepare($sql_booksend);
    $query_booksend->bind_param("s", $getref_id);
    $query_booksend->execute();
    $result_qbooksend=$query_booksend->get_result();

 While ($result_booksend = mysqli_fetch_array($result_qbooksend))
   {
        $booksend_no=$result_booksend['book_num'];
        $booksend_date=  datesql2show($result_booksend['book_date']);
        $booksend_subject=$result_booksend['book_subject'];
        $booksend_for=$result_booksend['book_for'];
        $booksend_detail=$result_booksend['book_detail'];
        $booksend_comment=$result_booksend['book_comment'];
        $booksend_level=$result_booksend['book_level'];
        $booksend_from=$result_booksend['book_fromdepartment'];
        $sendtoorg=$result_booksend['book_to_department'];
        $book2other=$result_booksend['book_to_other'];
        $booksend_comment=$result_booksend['book_comment'];
        $booksend_secret=$result_booksend['book_secret'];
        $booksend_fromorgtb=$result_booksend['book_fromorgtb'];
        
        //เช็คหน่วยงานจากตาราง
        if($booksend_fromorg='D' ){
            $searchorg="book2_department";
        }else{
            $searchorg="book2_subdepartment";            
        }
        
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
                    
                    <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="bookno" class="col-sm-2" style="width: 120px" > เลขที่หนังสือ</label>
                            <div  class="col-sm-3 text-left" >
                                <?php echo $booksend_no;?>
                            </div>
                             <label for="bookdate" class="col-sm-2" style="width: 80px" > ลงวันที่</label>
                              <div  class="col-sm-3 text-left" >
                              <?php echo $booksend_date;?>
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
    $query_booklevel->bind_param("i", $booksend_level);
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
    $query_booksecret->bind_param("i", $booksend_secret);
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
                                <?php echo $booksend_subject;?>
                            </div>
                       </div>
                </div>

                <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="bookfor" class="col-sm-2" style="width: 120px" >
                                 เรียน</label>
                            <div  class="col-sm-6 text-left" >
                                <?php echo $booksend_for;?>
                            </div>
                       </div>
                </div>

                  <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="bookdetail" class="col-sm-2" style="width: 120px" >
                                 รายละเอียด</label>
                            <div  class="col-sm-6 text-left" >
                             <?php echo $booksend_detail;?>
                            </div>
                       </div>
                </div>
                    
                <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="membookto" class="col-sm-1" style="width: 120px" >
                                 ถึง</label>

                                <div  class="col-sm-6 text-left  fom-control" >

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

                if($count_showorg!=0){
?>
              	<p>                
		<label>หน่วยงานที่ส่ง(ในระบบ) : </label>
                <?php
                echo $countsendorg;
                ?>
                หน่วยงาน 

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
                $sql_sanode="select * from book2_department where id=? ";
                $query_sanode = $connect->prepare($sql_sanode);
                $query_sanode->bind_param("s", $sendidorg);
                $query_sanode->execute();
                $result_qsanode=$query_sanode->get_result();
                    While ($result_sanode = mysqli_fetch_array($result_qsanode))
                   {
                            $namedepartment=$result_sanode['nameprecis'];
                   }
                     
                 $j=$i+1;    
                 echo "<p>".$j.".".$namedepartment."</p>";  
                     
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
                $sql_sanode="select * from book2_department where id=? ";
                $query_sanode = $connect->prepare($sql_sanode);
                $query_sanode->bind_param("s", $sendidorg);
                $query_sanode->execute();
                $result_qsanode=$query_sanode->get_result();
                    While ($result_sanode = mysqli_fetch_array($result_qsanode))
                   {
                            $namedepartment=$result_sanode['nameprecis'];
                   }                     
                 $h=$k+1;    
                 echo "<p>".$h.".".$namedepartment."</p>";  
                     
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
 	</p>
<?php
                }
?>
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

               if($count_book2other!=0){
                    ?>
                
        	<p>

		<label>หน่วยงานที่ส่ง(ภายนอกระบบ) : </label>
                <?php
                echo $countbook2other;
                ?>
                หน่วยงาน

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
                 echo "<p>".$h.".".$f_book2other[$k]."</p>";                       
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
        </p>
<?php
                }
?> 
        
        
        

                                </div>

                        </div>
                </div>
                    
<?php

            //หาสิทธิ์ของผู้ใช้งาน
                $sql_sanode="select * from $searchorg where id=?  ";
                $query_sanode = $connect->prepare($sql_sanode);
                $query_sanode->bind_param("s", $booksend_from);
                $query_sanode->execute();
                $result_qsanode=$query_sanode->get_result();
                    While ($result_sanode = mysqli_fetch_array($result_qsanode))
                   {
                            $fromdepartname=$result_sanode['name'];
                   }
?>
                    
                    
                 <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="membookfrom" class="col-sm-2" style="width: 120px" >
                                 จาก</label>
                            <div  class="col-sm-6 text-left" >
                                <?php echo $fromdepartname;?>
                            </div>
                       </div>
                </div>
                   
                  <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="bookcomment" class="col-sm-2" style="width: 120px" >
                                 หมายเหตุ</label>
                            <div  class="col-sm-6 text-left" >
                                <?php echo $booksend_comment;?>
                            </div>
                       </div>
                </div>
              
                  <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="bookcomment" class="col-sm-2" style="width: 120px" >
                                 ไฟล์แนบ</label>
                            <div  class="col-sm-6 text-left" ><b>(แสดงเฉพาะไฟล์แนบที่ส่งเหมือนกันทุกหน่วยงาน)</b><BR>

<?php
//echo  $count.". ".$image_src[$count]."<br>";

    $sql_bookfile="SELECT * FROM book2_file where book_refid=? ";
    $query_bookfile = $connect->prepare($sql_bookfile);
    $query_bookfile->bind_param("s", $getref_id);
    $query_bookfile->execute();
    $result_qbookfile=$query_bookfile->get_result();

    $j=1;
    $myupload="uploadsmy";
    While ($result_bookfile = mysqli_fetch_array($result_qbookfile))
   {
        //echo $j.". ";
        //echo $result_booklevel["file_name"];   
        ?>
        <div  class="row container table-hover" style='margin-top:10px; '>
        <button class="btn btn-danger btn-xs" onclick="return delete_fileupload(<?php echo $result_bookfile["id"];?>);"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <label><a href="<?php echo $myupload;?>/<?php echo $result_bookfile["file_path"];?>" target="_blank">
                <?php echo $j; ?>. <?php   echo $result_bookfile["file_name"];?>
                </a></label>
        
        </div>                       
        <?php
        $j++;
   }
 
?>




                            </div>
                       </div>
                </div>
                
                
                
                  <div class="row text-center" style="padding-bottom: 5px;padding-top: 15px;">
                        <div class="form-group">
                            <button type="submit" class="btn btn-github" style="margin: 8px;" data-toggle="modal" data-target="#editbooksend"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> แก้ไขรายการส่งหนังสือ</button>


                            <button type="button" class="btn btn-success" style="margin: 8px;"  data-toggle="modal" data-target="#uploadfileall" ><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> แนบไฟล์เหมือนกันทุกหน่วยงาน</button>
                                      <!-- Modal for Read -->
                        <div class="modal fade bs-example-modal-lg" id="uploadfileall"  data-backdrop="false"  aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <div class="row container">
                                  <h4 align="left">  แนบไฟล์ให้ทุกหน่วยงานที่ส่ง</h4>
                              </div>
                            </div>
                            <div class="modal-body" align="left">


 <!--                                     
                <div class="row" style="padding-bottom: 5px;padding-top: 10px;">
                        <div class="form-group">
                            <label for="file-0" class="col-sm-2" style="width: 100px" >
                                ไฟล์แนบ</label>
                            <div  class="col-sm-9 text-left" >
                                   <input id="fileup" class="file" type="file" name="fileup[]"  multiple>
                            </div>
                       </div>
                </div>
-->

    <form method="post" name="multiple_upload_form" id="multiple_upload_form" enctype="multipart/form-data" action="./modules/book2/main/uploadfiles.php" />
    	<input type="hidden" name="image_form_submit" value="1">
    	<input type="hidden" name="fileref_id" value="<?php echo $getref_id;?>">
    	<input type="hidden" name="filesendtoorg" value="<?php echo $sendtoorg;?>">
 <?php
 $max_size = ini_get('upload_max_filesize');
 ?>
            
            <label>ไฟล์แนบ</label>  <label style="color:blue;">(แนบไฟล์ได้สูงสุดไฟล์ละไม่เกิน <?php echo $max_size; ?>)</label>
            <input type="file" name="fileup[]" id="fileup" class='input' multiple >
            <div class="uploading none">
            <label>&nbsp;</label>
            <img src="./modules/book2/plugins/jqueryform/img/uploading.gif">
        </div>
    </form>

<div class="showoldfile">
<?php
/*
    $sql_booklevel="SELECT * FROM book2_file where book_refid=? ";
    $query_booklevel = $connect->prepare($sql_booklevel);
    $query_booklevel->bind_param("s", $getref_id);
    $query_booklevel->execute();
    $result_qbooklevel=$query_booklevel->get_result();
 
    While ($result_booklevel = mysqli_fetch_array($result_qbooklevel))
   {
     echo $result_booklevel["file_name"];
     ?>
<a href='?option=book2&task=main/deletefile&fid=' class='btn btn-danger btn-xs' data-toggle='comfirmation1'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span>&nbsp;ลบ</a>
<BR>
    <?php    
  }
*/
 ?>
 
</div>	
    <div class="gallery" id="images_preview"></div>

                        
                                
                                
                                
                                
                            </div>
                        	<div class="modal-footer">
                                    <button class="btn btn-sm" data-dismiss="modal"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> ปิดหน้าต่างนี้</button>
                                </div>
      
                      </div>
                    </div>
                  </div>

                <!-- จบ Modal -->
                            
                            
                            
                           <button type="submit" class="btn btn-warning" style="margin: 8px;"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> แนบไฟล์ต่างกัน</button>
                           <button type="button" class="btn btn-primary" style="margin: 8px;" onclick="return sendtrue_addbook('<?php echo $getref_id;?>','<?php echo $_SESSION["roleid_person"];?>','<?php echo $userlogin;?>');">
                           <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> ส่งหนังสือราชการ</button>
                       </div>
                </div>
 <!--	<div>Selected keys: <span id="echoSelection3">-</span></div>
	<div>Selected root keys: <span id="echoSelectionRootKeys3">-</span></div>
	<div>Selected root nodes: <span id="echoSelectionRoots3">-</span></div>
-->
        
                 <!-- Modal for Edit Book -->
                        <div class="modal fade bs-example-modal-lg" id="editbooksend"  data-backdrop="true"  aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <div class="row container">
                                  <h4 align="left">  แก้ไขรายการส่งหนังสือราชการ</h4>
                              </div>
                            </div>
                            <div class="modal-body" align="left">

                    <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="bookno" class="col-sm-2" style="width: 140px" > เลขที่หนังสือ</label>
                            <div  class="col-sm-3 text-left" >
                                <?php echo $booksend_no;?>
                            </div>
                             <label for="bookdate" class="col-sm-2" style="width: 80px" > ลงวันที่</label>
                              <div  class="col-sm-3 text-left" >
                              <?php echo $booksend_date;?>
                            </div>
                       </div>
                </div>
                                
                 <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="membooklevel" class="col-sm-2" style="width: 140px" >
                                 ชั้นความเร็ว</label>
                            <div  class="col-sm-6 text-left">
<?php
//หาชื่อหน่วยงาน
    $sql_booklevel="select * from book2_level where status=1   ";
    $query_booklevel = $connect->prepare($sql_booklevel);
    //$query_booklevel->bind_param("i", $user_departid);
    $query_booklevel->execute();
    $result_qbooklevel=$query_booklevel->get_result();

    
    While ($result_booklevel = mysqli_fetch_array($result_qbooklevel))
   {
        if($result_booklevel['id']==$booksend_level){$showselected="checked";}else{$showselected="";}
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
                                 ชั้นความลับ</label>
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
        if($result_booksecret['id']==$booksend_secret){$showchecked="checked";}else{$showchecked="";}
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
                                 เรื่อง</label>
                            <div  class="col-sm-6 text-left" >
                                <input type="text" class="form-control" id="booksubject" placeholder="กรุณากรอกเรื่อง" name="booksubject" required value="<?php echo $booksend_subject;?>">
                            </div>
                       </div>
                </div>

                <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="bookfor" class="col-sm-2" style="width: 140px" >
                                 เรียน</label>
                            <div  class="col-sm-6 text-left" >
                                <input type="text" class="form-control" id="bookfor" placeholder="กรุณาระบุข้อมูล" name="bookfor" required value="<?php echo $booksend_for;?>">
                            </div>
                       </div>
                </div>

                  <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="bookdetail" class="col-sm-2" style="width: 140px" >
                                 รายละเอียด</label>
                            <div  class="col-sm-6 text-left" >
                                <textarea class="form-control" id="bookdetail" placeholder="ระบุรายละเอียด" name="bookdetail"  rows="2"><?php echo $booksend_detail;?></textarea>
                            </div>
                       </div>
                </div>
                    
                <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="membookto" class="col-sm-1" style="width: 140px" >
                                 ถึง</label>

<!--                                <div  class="col-sm-6 text-left " >



<?php
//กำหนดเงื่อนไขการค้นหา
$select_rule="  and (leveldepartment='4' or leveldepartment='6' or leveldepartment='7'  or leveldepartment='8'  )  ";
$select_lvrule="  and (id='4' or id='6' or id='7'  or id='8'  )  ";
$work="SELECT id,leveldepart_name FROM book2_leveldepartment where status='1' $select_lvrule  order by id";
$workSQY=mysqli_query($connect,$work);
$consoles = array();
echo $work;
$i=-1;
//ลำดับที่ 1
while($workRS = mysqli_fetch_array($workSQY)){
	$i++;
//	$consoles[$i]['title'] = $workRS['name'].$workRS['id'];
	$consoles[$i]['title'] = $workRS['leveldepart_name'];
                $consoles[$i]['children'] = showmydepart($workRS['id'],$sendtoorg);
//                $consoles[$i]['children'] = getNode($workRS['id']);
//	$consoles[$i]['children'] = getChild($workRS['id']);
	//echo $consoles;
	//$consoles[$i]['children'] = array();
}
//ลำดับที่ 2
function getNode($t_id,$select_rule)
{               $consoles = array();
	include('database_connect.php');
	$qlook ="SELECT id,name,nameprecis FROM book2_department WHERE look=".$t_id." ".$select_rule." order by name";
	//echo $qlook;
	$qlookSQY=mysqli_query($connect,$qlook);
		$p=-1;
		while($s = mysqli_fetch_array($qlookSQY)){
                    
         //เช็คหน่วยงานที่เลือก
        for($i=0;$i<=$countsendorg;$i++)
                {
                     $sendidorg=$f_sendtoorg[$i];
                     if($sendidorg==$s['id']){
                         $showsendiddepart=" , selected: true";
                     }
                }
                    
                    
			$p++;
			if(hasChild($t_id,$select_rule)){
				$consoles[$p] = array(
//                     'title'      => $s['name'].$s['id'],
                        'title'      => $s['nameprecis'],
                        'key'       => $s['id'],
                        'children' => getChild($s['id'],$select_rule)
               );
                        } else{
			$consoles[$p]['children'][] = array(
//                     'title'      => $s['name'].$s['id'],
                                    'title'  => $s['nameprecis'],
                                    'key'   => $s['id'],
                                    'children' => getChild($s['id'],$select_rule)
               );
                        }
			$mChild = getChild($s['id'],$select_rule);
	}
	//print_r ($consoles);
	return $consoles;
}
//ลำดับที่ 3
function getChild($t_id,$select_rule)
{               $consoles = array();

	include('database_connect.php');
	$rlook ="SELECT name,id FROM book2_department WHERE look='".$t_id."' ".$select_rule." order by name";
	$rlookSQY=mysqli_query($connect,$rlook);
		$a=-1;
			while($r = mysqli_fetch_array($rlookSQY)){
			$a++;
			if(hasChild($t_id,$select_rule)){
			$consoles[$a]=array(
//			'title'=>$r['name'].$r['id'],
			'title'=>$r['nameprecis'],
			'key'=>$r['id'],
			'children'=> getNode($r['id'],$select_rule)
			);
			}else{
			$consoles[$a]=array(
//			'title'=>$r['name'].$r['id'],
			'title'=>$r['nameprecis'],
			'key'=>$r['id'],
			'children'=> getLook($r['id'],$select_rule)
			);
			}
			$mlook = getLook($r['id'],$select_rule);
			}
		//print_r($consoles);
	return $consoles;
}
function hasChild($t_id,$select_rule)
{               $num=0;
	include('database_connect.php');
	$rlook ="SELECT count(id) as countid FROM book2_department WHERE look='".$t_id."' ".$select_rule." order by name";
	$rlookSQY=mysqli_query($connect,$rlook);
	//$num=mysqli_num_rows($rlookSQY);
                while($r = mysqli_fetch_array($rlookSQY)){
                $num=$r['countid'];
                }
	if($num>0){
	return true;
	}else{
	return false;
	}
}
//ลำดับที่ 4
function getLook($t_id,$select_rule)
{               $consoles = array();
	include('database_connect.php');
	$rlookt ="SELECT id,name,nameprecis FROM book2_department WHERE look='".$t_id."' ".$select_rule." order by name";
	$rlooktSQY=mysqli_query($connect,$rlookt);
		$g=-1;
			while($tt = mysqli_fetch_array($rlooktSQY)){
			$g++;
			$consoles[$g]=array(
//			'title'=>$tt['name'].$tt['id'],
			'title'=>$tt['nameprecis'],
			'key'=>$tt['id']
			);
			}
			//console.log($tt['sl_id']);
		//print_r($conslok);
	return $consoles;
}
function hasLook($t_id,$select_rule)
{               $num=0;
	include('database_connect.php');
	$rlooktt ="SELECT count(id) as countid FROM book2_department WHERE look='".$t_id."' ".$select_rule." order by name";
	$rlookttSQY=mysqli_query($connect,$rlooktt);
//	$num=mysqli_num_rows($rlookttSQY);
                while($r = mysqli_fetch_array($rlookSQY)){
                $num=$r['countid'];
                }
	//echo $num;
	if($num>0){
	return true;
	}else{
	return false;
	}
}

function showmydepart($t_id,$dep_default)
{               $consoles = array();
	include('database_connect.php');
	$rlookt ="SELECT id,name,nameprecis FROM book2_department WHERE leveldepartment='".$t_id."'  order by name";
	$rlooktSQY=mysqli_query($connect,$rlookt);
		$g=-1;
			while($tt = mysqli_fetch_array($rlooktSQY)){
			$g++;
			if (in_array($tt['id'], explode(',',$dep_default))) {
				$s = true;
			} else {
				$s =false;
			}
			$consoles[$g]=array(
//			'title'=>$tt['name'].$tt['id'],
			'title'=>$tt['nameprecis'],
			'key'=>$tt['id'],
			'selected'=>$s,
			'preselected'=>$s
			);
			}
			//console.log($tt['sl_id']);
		//print_r($conslok);
	return $consoles;
}

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
	<?php




	?>
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
 //   $sql_sanode="select * from book2_sa_node_id ";
 //   $query_sanode = $connect->prepare($sql_sanode);
    //$query_person_name->bind_param("i", $user_departid);
//    $query_sanode->execute();
//    $result_qsanode=$query_sanode->get_result();
?>
                                    <select class="select2uptag form-control" multiple="multiple" data-placeholder="ส่งถึง หน่วยงานอื่นๆ" name="book2other[]" style="width: 100%;" >
<?php
                  for($i=0;$i<=$count_book2other;$i++)
                {                     
 //                }

 //   While ($result_sanode = mysqli_fetch_array($result_qsanode))
 //  {
        echo "<option value=".$f_book2other[$i]." selected='selected'>".$f_book2other[$i]."</option>";
    }
?>
</select>
                            </div>
 
                        </div>
                </div>

<?php

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

/*    $sql_roleuser="select * from book2_roleuser where person_id=? order by sa_node_id ASC";
    $query_roleuser = $connect->prepare($sql_roleuser);
    $query_roleuser->bind_param("s", $userlogin);
    $query_roleuser->execute();
    $result_qroleuser=$query_roleuser->get_result();
 * 
 */
   }
?>
                    
                    
                 <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="membookfrom" class="col-sm-2" style="width: 140px" >
                                 จาก</label>
                            <div  class="col-sm-6 text-left" >
                                <?php echo $name_predepart;?>

                                <!--<input type="text" class="form-control" id="bookfrom" placeholder="กรุณาระบุหน่วยงานที่ส่งมา" name="bookfrom" required>-->
                            </div>
                       </div>
                </div>
                   
                  <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="bookcomment" class="col-sm-2" style="width: 140px" >
                                 หมายเหตุ</label>
                            <div  class="col-sm-6 text-left" >
                                <textarea class="form-control" id="bookcomment" placeholder="ระบุหมายเหตุ" name="bookcomment"  rows="2"><?php echo $booksend_comment;?></textarea>
                            </div>
                       </div>
                </div>
                   
                  <div class="row text-center" style="padding-bottom: 5px;padding-top: 15px;">
                        <div class="form-group">
                            <button type="button" class="btn btn-facebook" onclick="" ><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> แก้ไขรายการหนังสือส่ง</button>
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

                <!-- Get Process -->
                <input type="hidden" name="inputpermistype" value="addbook" />
                <input type="hidden" name="inputprocess" value="inputprocess" />
                <input type="hidden" name="inputsender" value="<?php echo $userlogin;?>" />
                <input type="hidden" name="inputtoorganize" id="inputtoorganize" value="">
               
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
    <script src="./modules/book2/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- JQuery UI 1.11.4 -->
     <script src="./modules/book2/plugins/jQueryUI/jquery-ui.min.js" type="text/javascript"></script>
     
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
    <script src="./modules/book2/plugins/inputfile/th.js"></script>
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
     <!-- My Script -->
     <script src="./modules/book2/main/function.js"></script>
     <!--  jquery Form -->
     <script src="./modules/book2/plugins/jqueryform/jquery.form.js"></script>
         <!-- jquery Form Style -->
    <link rel="stylesheet" href="./modules/book2/plugins/jqueryform/style.css">

<script type="text/javascript">
$(document).ready(function(){
	$('#fileup').on('change',function(){            
                     //alert("I am an alert box!");
  
                                            $('#multiple_upload_form').ajaxForm({
			target:'#images_preview',
			beforeSubmit:function(e){
				$('.uploading').show();
			},
			success:function(e){
				$('.uploading').hide();
                                                                //$('.showoldfile').hide();
			},
			error:function(e){
			}
		}).submit();
                console.log();

	});
});
</script>
<script type="text/javascript">
  
$('#uploadfileall').on('hidden.bs.modal', function () {
  document.location.reload();
})     
</script>
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
        $('.comfirmation1').confirmation({
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
   <!--- <script>
    $("#file-0").fileinput({
        uploadUrl: '?option=book2&task=main/uploadfile_addbook',
        allowedFileExtensions : ['jpg', 'png','gif','pdf'],
        maxFileSize: 1000,
        maxFilesNum: 10,
        dropZoneEnabled:false,
        showPreview:true,
        language : 'th',
        elErrorContainer : '#errorBlock',
        uploadAsync: false,
        slugCallback: function(filename) {
            return filename.replace('(', '_').replace(']', '_');
        }

    });
    </script>
-->
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
			init: function (event, data) {
		        data.tree.getRootNode().visit(function (node) {
		            if (node.data.preselected) node.setSelected(true);
		        });
		    },
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
