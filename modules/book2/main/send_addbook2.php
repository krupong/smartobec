<?php
//header("content-type:text/javascript;charset=utf-8");   
//โชว์วันที่วันนี้
$today=date("d-m-Y");
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
?>
<html>
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
                                <input type="checkbox" id="membooklevel" name="membooklevel" class="flat-green " value="1" <?php if(isset($_SESSION['sbook_membooklevel'])){echo "checked";}?> > ชั้นความเร็ว</label>
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
          if(isset($_SESSION['sbook_membooklevel'])){
            if($result_booklevel['id']==$_SESSION['sbook_membooklevel']){
                     $showselected="checked";   
            }else{     $showselected="";      }
        
        }else{
        if($result_booklevel['id']==1){        $showselected="checked";
        }else{ $showselected="";   }
        }
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
                                <input type="checkbox" id="membooksecret" name="membooksecret" class="flat-green " value="1" <?php if(isset($_SESSION['sbook_membooksecret'])){echo "checked";}?>> ชั้นความลับ</label>
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
        if(isset($_SESSION['sbook_membooksecret'])){
            if($result_booksecret['id']==$_SESSION['sbook_membooksecret']){
                     $showchecked="checked";   
            }else{     $showchecked="";      }
        }else{
        if($result_booksecret['id']==1){        $showchecked="checked";
        }else{ $showchecked="";   }
        }
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
                                <input type="checkbox" id="membooksubject" name="membooksubject" class="flat-green " value="1"  <?php if(isset($_SESSION['sbook_membooksubject'])){echo "checked";}?>> เรื่อง</label>
                            <div  class="col-sm-6 text-left" >
                                <input type="text" class="form-control" id="booksubject" placeholder="กรุณากรอกเรื่อง" name="booksubject" required value="<?php if(isset($_SESSION['sbook_membooksubject'])){echo $_SESSION['sbook_membooksubject'];}else{echo "";}?>">
                            </div>
                       </div>
                </div>

                <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="bookfor" class="col-sm-2" style="width: 140px" >
                                <input type="checkbox" id="membookfor" name="membookfor" class="flat-green " value="1" <?php if(isset($_SESSION['sbook_membookfor'])){echo "checked";}?>> เรียน</label>
                            <div  class="col-sm-6 text-left" >
                                <input type="text" class="form-control" id="bookfor" placeholder="กรุณาระบุข้อมูล" name="bookfor" required value="<?php if(isset($_SESSION['sbook_membookfor'])){echo $_SESSION['sbook_membookfor'];}else{echo "";}?>">
                            </div>
                       </div>
                </div>

                  <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="bookdetail" class="col-sm-2" style="width: 140px" >
                                <input type="checkbox" id="membookdetail" name="membookdetail" class="flat-green " value="1" <?php if(isset($_SESSION['sbook_membookdetail'])){echo "checked";}?>> รายละเอียด</label>
                            <div  class="col-sm-6 text-left" >
                                <textarea class="form-control" id="bookdetail" placeholder="ระบุรายละเอียด" name="bookdetail"  rows="2"><?php if(isset($_SESSION['sbook_membookdetail'])){echo $_SESSION['sbook_membookdetail'];}else{echo "";}?></textarea>
                            </div>
                       </div>
                </div>
                    
                <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="membookto" class="col-sm-1" style="width: 140px" >
                                <input type="checkbox" id="membookto" name="membookto" class="flat-green " value="1" <?php if(isset($_SESSION['sbook_membookto'])){echo "checked";}?>> ถึง</label>

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
                $consoles[$i]['children'] = showmydepart($workRS['id']);
//                $consoles[$i]['children'] = getNode($workRS['id']);
//	$consoles[$i]['children'] = getChild($workRS['id']);
	//echo $consoles;
	//$consoles[$i]['children'] = array();
}
//ลำดับที่ 2
function getNode($t_id,$select_rule)
{               $consoles = array();
	include('database_connect.php');
	$qlook ="SELECT id,name FROM book2_department WHERE look=".$t_id." ".$select_rule." order by name";
	//echo $qlook;
	$qlookSQY=mysqli_query($connect,$qlook);
		$p=-1;
		while($s = mysqli_fetch_array($qlookSQY)){
			$p++;
			if(hasChild($t_id,$select_rule)){
				$consoles[$p] = array(
//                     'title'      => $s['name'].$s['id'],
                        'title'      => $s['name'],
                        'key'       => $s['id'],
                        'children' => getChild($s['id'],$select_rule)
               );
                        } else{
			$consoles[$p]['children'][] = array(
//                     'title'      => $s['name'].$s['id'],
                                    'title'  => $s['name'],
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
			'title'=>$r['name'],
			'key'=>$r['id'],
			'children'=> getNode($r['id'],$select_rule)
			);
			}else{
			$consoles[$a]=array(
//			'title'=>$r['name'].$r['id'],
			'title'=>$r['name'],
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
	$rlookt ="SELECT id,name FROM book2_department WHERE look='".$t_id."' ".$select_rule." order by name";
	$rlooktSQY=mysqli_query($connect,$rlookt);
		$g=-1;
			while($tt = mysqli_fetch_array($rlooktSQY)){
			$g++;
			$consoles[$g]=array(
//			'title'=>$tt['name'].$tt['id'],
			'title'=>$tt['name'],
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

function showmydepart($t_id)
{               $consoles = array();
	include('database_connect.php');
	$rlookt ="SELECT id,name FROM book2_department WHERE leveldepartment='".$t_id."'  order by name";
	$rlooktSQY=mysqli_query($connect,$rlookt);
		$g=-1;
			while($tt = mysqli_fetch_array($rlooktSQY)){
			$g++;
			$consoles[$g]=array(
//			'title'=>$tt['name'].$tt['id'],
			'title'=>$tt['name'],
			'key'=>$tt['id']	
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
 //   While ($result_sanode = mysqli_fetch_array($result_qsanode))
 //  {
//    echo "<option value=".$result_sanode['sa_node_id'].">".$result_sanode['sa_node_name']."</option>";
 //   }
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
                                <input type="checkbox" id="membookfrom" name="membookfrom" class="flat-green " value="1" <?php if(isset($_SESSION['sbook_membookfrom'])){echo "checked";}?>> จาก</label>
                            <div  class="col-sm-6 text-left" >
                                <select class="form-control" id="bookfrom"  data-placeholder="กรุณาระบุหน่วยงานที่ส่ง" style="width: 100%;" name="bookfrom" >
                                <?php 
                                    echo "<option value=".$look_dep_subdep." >".$name_predepart."</option>";
                                ?>
                                </select>               

                            </div>
                       </div>
                </div>                                <!--<input type="text" class="form-control" id="bookfrom" placeholder="กรุณาระบุหน่วยงานที่ส่งมา" name="bookfrom" required>-->

                   
                  <div class="row" style="padding-bottom: 5px;">
                        <div class="form-group">
                            <label for="bookcomment" class="col-sm-2" style="width: 140px" >
                                <input type="checkbox" id="membookcomment" name="membookcomment" class="flat-green " value="1" <?php if(isset($_SESSION['sbook_membookcomment'])){echo "checked";}?>> หมายเหตุ</label>
                            <div  class="col-sm-6 text-left" >
                                <textarea class="form-control" id="bookcomment" placeholder="ระบุหมายเหตุ" name="bookcomment"  rows="2"><?php if(isset($_SESSION['sbook_membookcomment'])){echo $_SESSION['sbook_membookcomment'];}else{echo "";}?></textarea>
                            </div>
                       </div>
                </div>
                   
                  <div class="row text-center" style="padding-bottom: 5px;padding-top: 15px;">
                        <div class="form-group">
                                <button type="submit" class="btn btn-facebook" ><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> ออกเลขหนังสือส่ง</button>
                       </div>
                </div>
                <!--
                <div>Selected keys: <span id="echoSelection3">-</span></div>
	<div>Selected root keys: <span id="echoSelectionRootKeys3">-</span></div>
	<div>Selected root nodes: <span id="echoSelectionRoots3">-</span></div>
                -->
 <!-- ทดสอบเพิ่มจร้าาา -->
                    <div class="row" style="padding-bottom: 5px;padding-top: 20px;">
                        <div class="form-group">
                            <label for="memsenddirector" class="col-sm-1 text-right"  >
                                <input type="checkbox" id="memsenddirector" name="memsenddirector" class="flat-green " value="1" ></label>
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
 
 
 
 
 <!-- จบทดสอบจร้าาา -->
                
               
                <input type="hidden" name="bookrefid" value="" />
                <input type="hidden" name="bookstatus" value="6" />
                <input type="hidden" name="inputpermistype" value="addbook" />
                <input type="hidden" name="inputprocess" value="inputprocess" />
                <input type="hidden" name="inputsender" value="<?php echo $userlogin;?>" />
                <input type="hidden" name="bookfromrole" value="<?php echo $user_role_id;?>" />
                <input type="hidden" name="bookfromorgtb" value="<?php echo $orgtb;?>" />
                <input type="hidden" name="booktype" value="2" />
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
    <script src="./modules/book2/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- JQuery UI 1.11.4 -->
     <script src="./modules/book2/plugins/jQueryUI/jquery-ui.min.js" type="text/javascript"></script>
     
 <!-- Bootstrap 3.3.5 -->
    <script src="./modules/book2/bootstrap/js/bootstrap.min.js"></script>
    <!-- Select2 -->
    <script src="./modules/book2/plugins/select2/select2.full.min.js"></script>
    <!-- AdminLTE App -->
    <script src="./modules/book2/dist/js/app.min.js"></script>
    <!-- Selection -->
    <script src="./modules/book2/plugins/selection/bootstrap-select.min.js"></script>
    <!-- iCheck 1.0.1 -->
    <script src="./modules/book2/plugins/iCheck/icheck.min.js"></script>
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
          radioClass: 'class="flat-green "'
        });
		//iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="checkbox"].minimal').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          checkboxClass: 'class="flat-green "'
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