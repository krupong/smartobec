<?php
  // Search Condition
  if($_POST["searchtext"]){
    $searchtext = $_POST["searchtext"];
    $_SESSION["searchtext"] = $_POST["searchtext"];
  }else{
    $searchtext = $_SESSION["searchtext"];
  }
?>

  <div class="box box-primary">
    <div class="box-header with-border">
      <p><h4 class="box-title">ตรวจแฟ้มใหม่ (รายการบันทึกรอตรวจ)</h4></p>
      <div class="row">
          <div class="col-md-6 text-left">
            <a href="?option=ioffice&task=book_pass" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="รีเฟรช"><span class="glyphicon glyphicon-refresh"></span></a>
          </div>
          <div class="col-md-6 text-right">
            <form class="form-inline" action="#" enctype="multipart/form-data" method="POST" >
              <div class="form-group">
                <label for="searchtext"></label>
                <input type="text" class="form-control" id="searchtext" name="searchtext" placeholder="พิมพ์คำค้นหา" value="<?php echo $searchtext; ?>">
              </div>
              <button type="submit" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="ค้นหา"><span class="glyphicon glyphicon-search"></span></button>
              <a href="?option=ioffice&task=book_manage&action=pass_clearsearchtext" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="แสดงทั้งหมด"><span class="glyphicon glyphicon-list"></span></a>
            </form>
          </div>
      </div>
    </div>
    <div class="box-body">
      <?php 
      // Check User
      if(!isset($_SESSION['login_user_id'])) { $_SESSION['login_user_id']=''; }
      // Select Book
      $sql_search='';
      if($searchtext!=''){
        $sql_search = " and ((bookid = '$searchtext') or (department_bookid like '%$searchtext%') or (bookheader like '%$searchtext%') or (sd1.department_precis like '%$searchtext%'))";
      }
      $sql = "  SELECT 
                  ioffice_book.*,
                  ioffice_booktype.booktypename,
                  ioffice_bookstatus.bookstatusname,
                  pm1.prename as post_prename,
                  pm1.name as post_name,
                  pm1.surname as post_surname,
                  sd1.department_name as post_department_name,
                  sd1.department_precis as post_department_precis,
                  system_subdepartment.sub_department_name,
                  pm2.prename as receive_prename,
                  pm2.name as receive_name,
                  pm2.surname as receive_surname,
                  pp2.position_name as receive_position_name  
                FROM
                  ioffice_book
                  LEFT JOIN ioffice_bookstatus ON ioffice_book.bookstatusid = ioffice_bookstatus.bookstatusid
                  LEFT JOIN ioffice_booktype ON ioffice_book.booktypeid = ioffice_booktype.booktypeid
                  LEFT JOIN person_main pm1 ON ioffice_book.post_personid = pm1.person_id 
                  LEFT JOIN system_department sd1 ON sd1.department = ioffice_book.post_departmentid 
                  LEFT JOIN system_subdepartment ON system_subdepartment.sub_department = ioffice_book.post_subdepartmentid 
                  LEFT JOIN person_main pm2 ON ioffice_book.receive_personid = pm2.person_id 
                  LEFT JOIN person_position pp2 ON pp2.position_code = pm2.position_code
                WHERE ioffice_book.bookstatusid = 2 and 
                      bookid IN(select bookid from ioffice_bookcomment where comment_personid=".$_SESSION['login_user_id']." and bookstatusid=2) 
                      $sql_search  
                ORDER BY postdate DESC";
      //echo "<div class='well well-sm'>$sql</div>";
      $result = mysqli_query($connect, $sql);
      $count = mysqli_num_rows($result);    
      $list = 50;  // row per page
      $limit = "LIMIT 0,$list";
      // Calculate Pagination
      $page = ceil($count/$list);
      if(!isset($_GET["page"])){ $_GET["page"]=1; } // ถ้าค่า page ไม่มี ให้เปลี่ยนไปหน้า 1
      if($_GET["page"]>$page){ $_GET["page"]=1; } // ถ้าค่า page มากกว่าหน้าที่มี ให้เปลี่ยนไปหน้า 1
      if($count>$list){     
        if($_GET["page"]){
          if($_GET["page"])
          $limit = "LIMIT ".($_GET["page"]-1)*$list.",$list";
        }
      ?>
      <div class="row">
        <div class="col-md-12 text-right">
          <nav>
            <ul class="pagination">
              <?php 
                for($x=1;$x<=$page;$x++){
                  if($x==$_GET["page"]){ $active="class='active'"; }else{ $active=""; }
                  echo "<li $active><a href='?option=ioffice&task=book_pass&page=$x'>$x <span class='sr-only'></span></a></li>"; 
                }
              ?>
            </ul>
          </nav>
        </div>
      </div>
      <?php 
      } 
      ?>
      <table class="table table-hover table-striped table-condensed table-responsive">
        <thead>
          <tr>
            <th>#</th>
          	<th width=60>เลขที่</th>
            <th width=190>เลขที่สำนัก</th>
          	<th>เรื่อง</th>
            <th width=200>เรียน</th>
            <th width=240>โดย</th> 
            <th width=90>สถานะ</th>       
            <th>จัดการ</th>
       	  </tr>
        </thead>
        <tbody>
          
          <?php 
            // Check User
            if(!isset($_SESSION['login_user_id'])) { $_SESSION['login_user_id']=''; }
            // Select Book
            $sql_search='';
            if($searchtext!=''){
              $sql_search = " and ((bookid = '$searchtext') or (department_bookid like '%$searchtext%') or (bookheader like '%$searchtext%') or (sd1.department_precis like '%$searchtext%'))";
            }
            $sql = $sql.' '.$limit;
            //echo "<div class='well well-sm'>$sql</div>";
            if ($result = mysqli_query($connect, $sql)) {
              $no=0;
              while ($row = $result->fetch_assoc()) {
                switch ($row["bookstatusid"]) {
                  case '1':
                    $tr_class = "class='active'";
                    break;
                  case '2':
                    $tr_class = "class = 'warning'";
                    break;
                  case '3':
                    $tr_class = "class = 'danger'";
                    break;
                  case '4':
                    $tr_class = "class = 'warning'";
                    break;
                  case '20':
                    $tr_class = "class = 'success'";
                    break;
                  case '21':
                    $tr_class = "class = 'success'";
                    break;
                  case '22':
                    $tr_class = "class = 'success'";
                    break;
                  case '30':
                    $tr_class = "class = 'danger'";
                    break;
                  case '40':
                    $tr_class = "class = 'info'";
                    break;
                  default:
                    $tr_class = "";
                    break;
                }
                switch ($row["booktypeid"]) {
                  case '1':
                    $booktype_show = "ปกติ";
                    break;
                  case '2':
                    $booktype_show = "<span class='glyphicon glyphicon-star' aria-hidden='true'></span> ด่วน";
                    break;
                  case '3':
                    $booktype_show = "<span class='glyphicon glyphicon-star' aria-hidden='true'></span><span class='glyphicon glyphicon-star' aria-hidden='true'></span> ด่วนมาก";
                    break;
                  case '4':
                    $booktype_show = "<span class='glyphicon glyphicon-star' aria-hidden='true'></span><span class='glyphicon glyphicon-star' aria-hidden='true'></span><span class='glyphicon glyphicon-star' aria-hidden='true'></span> ด่วนที่สุด";
                    break;
                  default:
                    $booktype_show = "&nbsp;";
                    break;
                }
                ?>
                  <tr <?php echo $tr_class; ?>>
                    <td><?php $no=++$no; echo '#'; echo $count-($no+($list*($_GET["page"]-1)))+1; ?></td>
                    <td><?php echo $row['bookid']; ?></td>
                    <td><?php echo $row['department_bookid'].'<br>ชั้นความเร็ว : '.$booktype_show.'<br>เมื่อ '; if($row['updatedate']){echo ThaiTimeConvert(strtotime($row['updatedate']),"","2");}else{echo ThaiTimeConvert(strtotime($row['postdate']),"","2");} ?></td>
                    <td><?php echo $row['bookheader']; ?></td>
                    <td><?php echo $row['receive_position_name'].'<br>'.$row['receive_prename'].$row['receive_name'].' '.$row['receive_surname']; ?></td>
                    <td><?php echo $row['post_prename'].$row['post_name']." ".$row['post_surname'].'<br>'.$row["sub_department_name"].'<br>'.$row["post_department_precis"]; ?></td>
                    <?php
                      $sqllastcomment = " SELECT * FROM ioffice_bookcomment b  
                                          LEFT JOIN person_main pm ON(b.comment_personid=pm.person_id) 
                                          WHERE bookid = ".$row["bookid"]." ORDER BY commentid DESC LIMIT 0,1";
                      //echo "<div class='well well-sm'>$sqllastcomment</div>";
                      $resultlastcomment = mysqli_query($connect, $sqllastcomment);
                      $rowlastcomment = mysqli_fetch_assoc($resultlastcomment);
                      switch ($row["bookstatusid"]) {
                          case '1':
                            $bookstatusclass = "default";
                            break;
                          case '2':
                            $bookstatusclass = "warning";
                            break;  
                          case '3':
                            $bookstatusclass = "danger";
                            break;
                          case '4':
                            $bookstatusclass = "warning";
                            break;  
                          case '20':
                            $bookstatusclass = "success";
                            break;
                          case '21':
                            $bookstatusclass = "success";
                            break;
                          case '22':
                            $bookstatusclass = "success";
                            break;
                          case '30':
                            $bookstatusclass = "danger";
                            break;
                          case '40':
                            $bookstatusclass = "info";
                            break;
                        default:
                          # code...
                          break;
                      }
                    ?>
                    <td><?php echo $row['bookstatusname']; ?></td>                    
                    <td>
                      <!-- Modal for Read -->
                      <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal<?php echo $row['bookid']; ?>">เปิด&nbsp;/&nbsp;ลงความเห็น</button>
                      <div class="modal fade bs-example-modal-lg" id="myModal<?php echo $row['bookid']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <div class="row">
                                <div class="col-md-6 text-left">
                                  <h4><?php echo "เลขที่ ".$row["bookid"]; ?></h4>
                                  <h4><?php echo "เลขที่ สำนัก ".$row["department_bookid"]; ?></h4>
                                </div>
                                <div class="col-md-6 text-right">
                                  <a href="#" class="btn btn-default">ชั้นความเร็ว&nbsp;:&nbsp;<?php echo $booktype_show; ?></a>
                                  <a href="#" class="btn btn-default">สถานะ&nbsp;:&nbsp;<?php echo $row["bookstatusname"]; ?></a>
                                </div>
                              </div>                          
                            </div>                              
                            <!-- Comment Form -->
                            <form enctype="multipart/form-data" class="form-horizontal" method="POST" action="?option=ioffice&task=book_manage&action=comment">
                            <div class="modal-body">
                              <div class="well">
                                <h4 class="modal-title" id="myModalLabel">เรื่อง <?php echo $row["bookheader"]; ?></h4>
                                <h4 class="modal-title" id="myModalLabel">เรียน <?php echo $row['receive_position_name'].' : '.$row['receive_prename'].$row['receive_name'].' '.$row['receive_surname']; ?></h4>
                              </div>
                              <?php echo $row["bookdetail"]; ?>
                              <hr>
                              <h4>เอกสารแนบ</h4>
                              <?php
                              $sqlfile = "SELECT * FROM ioffice_bookfile WHERE bookid=".$row["bookid"];
                              $resultfile = mysqli_query($connect,$sqlfile);
                              $fnum = 0;
                              while ($rowfile = $resultfile->fetch_assoc()) {
                                echo "<p><a href='".$rowfile["filename"]."' class='btn btn-default' target='_blank'><span class='badge badge-sm'>".++$fnum."</span>&nbsp;".$rowfile["filedesc"]."</a></p>";
                              }
                              ?>
                              <hr>
                              <h5>โดย&nbsp;<?php echo $row['post_prename'].$row['post_name']." ".$row['post_surname']; ?></h5>
                              <h5>เมื่อ&nbsp;<?php if($row['updatedate']){echo ThaiTimeConvert(strtotime($row['updatedate']),"","2");}else{echo ThaiTimeConvert(strtotime($row['postdate']),"","2");} ?></h5>
                              <hr>
                              <h4>รายการความเห็น</h4>
                              <table class="table table-hover table-striped table-condensed table-responsive">
                                <thead>                                  
                                  <th>ลำดับที่</th>
                                  <th>สถานะ</th>
                                  <th>ชื่อ-สกุล</th>
                                  <th>ตำแหน่ง</th>
                                  <th>สำนัก</th>
                                  <th>เมื่อ</th>
                                  <th>ความเห็น</th>
                                </thead> 
                                <tbody>
                                  <?php
                                    $sqlcomment = " SELECT * FROM ioffice_bookcomment bc   
                                                    LEFT JOIN ioffice_bookstatus bs ON(bc.bookstatusid=bs.bookstatusid) 
                                                    LEFT JOIN person_main pm ON(bc.comment_personid=pm.person_id) 
                                                    LEFT JOIN person_position pp ON(bc.comment_positionid=pp.position_code) 
                                                    LEFT JOIN system_department sd ON(bc.comment_departmentid=sd.department) 
                                                    WHERE bookid=".$row['bookid'];
                                    //echo "<div class='well'>".$sqlcomment."</div>";
                                    $resultcomment = mysqli_query($connect, $sqlcomment);
                                    $commentnum = 0;
                                    while ($rowcomment = $resultcomment->fetch_assoc()) {
                                      echo "<tr>";
                                      echo "<td>".++$commentnum."</td>";
                                      echo "<td>".$rowcomment["bookstatusname"]."</td>";
                                      echo "<td>".$rowcomment["prename"].$rowcomment["name"]." ".$rowcomment["surname"]."</td>";
                                      echo "<td>".$rowcomment["position_name"]."</td>";
                                      echo "<td>".$rowcomment["department_precis"]."</td>";
                                      echo "<td>".ThaiTimeConvert(strtotime($rowcomment['commentdate']),"","2")."</td>";
                                      echo "<td>".$rowcomment["commentdetail"]."</td>";
                                      echo "</tr>";
                                    }
                                  ?>
                                  
                                </tbody>                                 
                              </table>
                              <input type="hidden" id="bookid" name="bookid" value="<?php echo $row['bookid']; ?>">
                              <input type="hidden" id="post_personid" name="post_personid" value="<?php echo $row['post_personid']; ?>">
                              <input type="hidden" id="bookheader" name="bookheader" value="<?php echo $row['bookheader']; ?>">
                              <input type="hidden" id="department_bookid" name="department_bookid" value="<?php echo $row['department_bookid']; ?>">
                              <input type="hidden" id="post_departmentid" name="post_departmentid" value="<?php echo $row['post_departmentid']; ?>">
                              <input type="hidden" id="post_subdepartmentid" name="post_subdepartmentid" value="<?php echo $row['post_subdepartmentid']; ?>">
                              <hr>
                              <h4>ลงความเห็น/สั่งการ</h4>
                              <?php //if($user_positionid!=1) and ($receive_booklevelid!=$row["receive_booklevelid"])){ ?>
                              <textarea class="form-control" rows="4" name="commentdetail" id="commentdetail" placeholder="ส่วนสำหรับลงความเห็น"></textarea>
                              <p>
                              <label class="radio-inline">
                                <input type="radio" name="bookstatusid" id="bookstatusid1" value="2" onclick="javascript:showDiv('myContent<?php echo $row['bookid']?>');"><span class='glyphicon glyphicon-share-alt' aria-hidden='true'></span> เสนอ
                              </label>
                              </p>
                              <div id='myContent<?php echo $row['bookid']?>' style="display:none">
                              <p>
                                <span class="badge">1</span> กรณีต้องการผ่านเรื่องไปที่ ผอ.กลุ่ม หรือบุคลากรในกลุ่ม เลือกสำนัก -> เลือกกลุ่ม -> และเลือกบุคลากร<br/><span class="badge">2</span> กรณีต้องการผ่านเรื่องไปที่ ผอ.สำนัก เลือกสำนัก -> และเลือกบุคลากร (เรื่องจะไม่ผ่าน ผอ.กลุ่ม)<br/><span class="badge">3</span> กรณีต้องการผ่านเรื่องไปที่ ผู้บริหาร(เลขาฯ/รองเลขาฯ/ผู้ช่วยเลขาฯ/ที่ปรึกษา/ผู้เชี่ยวชาญ) เลือกสำนักผู้บริหารระดับสูง -> และเลือกบุคลากร</p>
                              <p>
                                <select  name='department' id='department' class="form-control">
                                  <option  value = ''>เลือกสำนัก</option>"
                                  <?php
                                  $sqldepartment = "select * from  system_department order by department_name";
                                  $resultdepartment = mysqli_query($connect, $sqldepartment);
                                  echo  "<option  value ='-1'>ผู้บริหารระดับสูง</option>" ; 
                                  echo  "<option  value ='0'>ไม่สังกัดสำนัก</option>" ; 
                                  while ($rowdepartment = $resultdepartment->fetch_assoc()){
                                    echo  "<option  value ='$rowdepartment[department]'>$rowdepartment[department_name]</option>" ;
                                  } 
                                  ?>
                                </select>
                              </p>
                              <p>
                                <select  name='sub_department' id='sub_department' class="form-control">
                                  <option  value = ''>เลือกกลุ่ม</option>"
                                  <?php
                                  //$sql_comm = "select ibc.comment_personid,pm.prename,pm.`name`,pm.surname,ibc.post_personid from ioffice_bookcomment ibc left join person_main pm on(ibc.comment_personid=pm.person_id) where ibc.post_personid='".$_SESSION['login_user_id']."' order by ibc.commentdate DESC limit 1";
                                  //$resultsubdepartment = mysqli_query($connect, $sqlsubdepartment);
                                  //while ($rowsubdepartment = $resultsubdepartment->fetch_assoc()){
                                  //  echo  "<option  value ='$rowsubdepartment[sub_department]'>$rowsubdepartment[sub_department_name]</option>" ;
                                  //} 
                                  ?>
                                </select>
                              </p>  
                              <p>
                                <select  name='person' id='person' class="form-control">
                                  <option  value = ''>เลือกบุคลากร</option>"
                                  <?php
                                  $sql_comment_personid = "select ibc.comment_personid,pm.prename,pm.`name`,pm.surname,ibc.post_personid from ioffice_bookcomment ibc left join person_main pm on(ibc.comment_personid=pm.person_id) where ibc.post_personid='".$_SESSION['login_user_id']."' order by ibc.commentdate DESC limit 1";
                                  $result_comment_personid = mysqli_query($connect, $sql_comment_personid);
                                  while ($row_comment_personid = $result_comment_personid->fetch_assoc()){
                                    echo  "<option  value ='$row_comment_personid[comment_personid]' selected>".$row_comment_personid[prename].$row_comment_personid[name]." ".$row_comment_personid[surname]."</option>" ;
                                  } 
                                  ?>
                                </select>
                              </p>
                            </div>
                            <p>
                              <label class="radio-inline">
                                <input type="radio" name="bookstatusid" id="bookstatusid20" value="20" onclick="javascript:hideDiv('myContent<?php echo $row['bookid']?>');"><span class='glyphicon glyphicon-ok' aria-hidden='true'></span> ทราบ/อนุมัติ
                              </label>
                              <?php //if(($user_positionid!=1) and ($receive_booklevelid!=$row["receive_booklevelid"])){ ?>
                              <label class="radio-inline">
                                <input type="radio" name="bookstatusid" id="bookstatusid21" value="21" onclick="javascript:hideDiv('myContent<?php echo $row['bookid']?>');"><span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span> ทราบ/อนุมัติ(ปฏิบัติราชการแทน)
                              </label>
                              <?php 
                              if(!isset($_SESSION["system_delegate"])){ $_SESSION["system_delegate"]=""; }
                              if($_SESSION["system_delegate"]==1) {
                              ?>
                              <label class="radio-inline">
                                <input type="radio" name="bookstatusid" id="bookstatusid22" value="22" onclick="javascript:hideDiv('myContent<?php echo $row['bookid']?>');"><span class='glyphicon glyphicon-check' aria-hidden='true'></span> ทราบ/อนุมัติ(รักษาราชการแทน)
                              </label>
                              <?php } ?>
                            </p>
                            <p>
                            <label class="radio-inline">
                              <input type="radio" name="bookstatusid" id="bookstatusid30" value="30" onclick="javascript:hideDiv('myContent<?php echo $row['bookid']?>');"><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> ยุติเรื่อง
                            </label>
                            <label class="radio-inline">
                              <input type="radio" name="bookstatusid" id="bookstatusid40" value="40" onclick="javascript:hideDiv('myContent<?php echo $row['bookid']?>');"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span> คืนเรื่อง/แก้ไข
                            </label>
                            </p>
                            <?php //} ?>
                          
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span>&nbsp;ปิด</button>
                              <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span>&nbsp;บันทึก</button>
                            </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                <?php
              }
              // free result set
              mysqli_free_result($result);
            }
          ?>
       	  
        </tbody>              
			</table>
      <?php
      if($count>$list){
      ?>
      <div class="row">
        <div class="col-md-12 text-right">
          <nav>
            <ul class="pagination">
              <?php 
                for($x=1;$x<=$page;$x++){
                  if($x==$_GET["page"]){ $active="class='active'"; }else{ $active=""; }
                  echo "<li $active><a href='?option=ioffice&task=book_pass&page=$x'>$x <span class='sr-only'></span></a></li>"; 
                }
              ?>
            </ul>
          </nav>
        </div>
      </div>
      <?php 
      }
      ?>
    </div>
  </div>

<!-- Auto Select SubDepartment by Department -->
<script type="text/javascript">
  $(function(){
    $("select#department").change(function(){
      var datalist2 = $.ajax({  
        url: "modules/ioffice/return_ajax_sub_department.php", 
        data:"department="+$(this).val(),
        async: false
      }).responseText;    
      $("select#sub_department").html(datalist2);
      var datalist2 = $.ajax({  
        url: "modules/ioffice/return_ajax_person_department.php", 
        data:"department="+$(this).val(),
        async: false
      }).responseText;    
      $("select#person").html(datalist2);
    });
  });
</script>
<!-- Auto Select Person by Subdepartment -->
<script type="text/javascript">
  $(function(){
    $("select#sub_department").change(function(){
      var datalist2 = $.ajax({  
        url: "modules/ioffice/return_ajax_person_subdepartment.php", 
        data:"sub_department="+$(this).val(),
        async: false
      }).responseText;    
      $("select#person").html(datalist2); 
    });
  });
</script>
<!-- Validate Form-->

</body>
</html>