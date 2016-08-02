<?php
  // Search Condition
  if($_POST["searchtext"]){
    $searchtext = $_POST["searchtext"];
    $_SESSION["searchtext"] = $_POST["searchtext"];
  }else{
    $searchtext = $_SESSION["searchtext"];
  }
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<br>
<div class="container">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">รายการบันทึกรอลงความเห็น/สั่งการ</h3>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-md-6 text-left">
          <a href="?option=ioffice&task=book_pass" class="btn btn-primary"><span class="glyphicon glyphicon-refresh"></span>&nbsp;ค้นหาใหม่</a>
        </div>
        <div class="col-md-6 text-right">
          <form class="form-inline" action="#" enctype="multipart/form-data" method="POST" >
            <div class="form-group">
              <label for="searchtext"></label>
              <input type="text" class="form-control" id="searchtext" name="searchtext" placeholder="พิมพ์คำค้นหา" value="<?php echo $searchtext; ?>">
            </div>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> ค้นหา</button>
            <a href="?option=ioffice&task=book_manage&action=pass_clearsearchtext" class="btn btn-default"><span class="glyphicon glyphicon-list"></span> แสดงทั้งหมด</a>
          </form>
        </div>
      </div>
      <hr>
      <table class="table table-hover table-striped table-condensed table-responsive">
        <thead>
          <tr>
          	<th>เลขที่</th>
            <th>เลขที่สำนัก</th>
            <th>ประเภท</th>
          	<th>เรื่อง</th>
            <th>เรียน</th>
            <th>เมื่อ</th>
            <th>โดย</th> 
            <th>กลุ่มงาน</th>
            <th>สำนัก</th>
            <th>สถานะ</th>       
            <th>จัดการ</th>
       	  </tr>
        </thead>
        <tbody>
          
          <?php 
            // Check User
            if(!isset($_SESSION['login_user_id'])) { $_SESSION['login_user_id']=''; }
            // ตรวจสอบหน้าที่หลัก
            $sqluser = "SELECT * FROM person_main WHERE person_id = '$_SESSION[login_user_id]'";
            //echo "<div class='well well-sm'>$sqluser</div>";
            if($resultuser = mysqli_query($connect, $sqluser)) {
              $rowuser = $resultuser->fetch_assoc();
              $user_positionid = $rowuser["position_code"];
              $user_position_other_code = $rowuser["position_other_code"];
              $user_subdepartment = $rowuser["sub_department"];
              $user_department = $rowuser["department"];
            }else{
              $user_positionid = "";
              $user_position_other_code = "";
              $user_subdepartment = "";
              $user_department = "";
            }
            // เจ้าหน้าที่
            $sqlpass = "consult_personid = '".$_SESSION['login_user_id']."' ";
            $receive_booklevelid = 1;
            $booklevelid = 1;
            // หัวหน้ากลุ่มงาน
            if($user_position_other_code>0){
              //$sqlpass = "((ioffice_book.booklevelid = 1) or (ioffice_book.booktypeid = 4)) and post_subdepartmentid = ".$user_subdepartment." and receive_booklevelid >= 2 and ";
              $sqlpass = "(ioffice_book.booklevelid = 1) and post_subdepartmentid = ".$user_subdepartment." and receive_booklevelid >= 2 ";
              $receive_booklevelid = 2;
              $booklevelid = 2;
            }
            // ผอ.สำนัก
            if($user_positionid==9){
              $sqlpass = " ioffice_book.booklevelid = 2 and post_departmentid = ".$user_department." and receive_booklevelid >= 3 ";
              $receive_booklevelid = 3;
              $booklevelid = 3;
            }
            // รองเลขา และผู้ช่วยเลขา
            if($user_positionid==2 or $user_positionid==3){ 
              $receive_booklevelid = 4;
              $booklevelid = 4;
              if(!isset($_SESSION["system_delegate"])){ $_SESSION["system_delegate"]=""; }
              if($_SESSION["system_delegate"]==1) { 
                // กรณีรักษาราชการแทน
                $sqlpass = " ioffice_book.booklevelid IN(3,4) and post_departmentid IN(SELECT departmentid FROM ioffice_bookpass WHERE personid = '".$_SESSION['login_user_id']."') and receive_booklevelid >= 4 ";
              }else{
                // กรณีปกติ
                $sqlpass = " ioffice_book.booklevelid = 3 and post_departmentid IN(SELECT departmentid FROM ioffice_bookpass WHERE personid = '".$_SESSION['login_user_id']."') and receive_booklevelid >= 4 ";
              }
            }
            // เลขา
            if($user_positionid==1){
              $receive_booklevelid = 5;
              $booklevelid = 5;
              $sqlpass = " ioffice_book.booklevelid = 4 and receive_booklevelid >= 5 ";
            }

            // Select Book
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
                        ibl.booklevelname   
                      FROM
                        ioffice_book
                        LEFT JOIN ioffice_bookstatus ON ioffice_book.bookstatusid = ioffice_bookstatus.bookstatusid
                        LEFT JOIN ioffice_booktype ON ioffice_book.booktypeid = ioffice_booktype.booktypeid
                        LEFT JOIN person_main pm1 ON ioffice_book.post_personid = pm1.person_id 
                        LEFT JOIN system_department sd1 ON sd1.department = ioffice_book.post_departmentid 
                        LEFT JOIN system_subdepartment ON system_subdepartment.sub_department = ioffice_book.post_subdepartmentid 
                        LEFT JOIN ioffice_booklevel ibl ON ioffice_book.receive_booklevelid = ibl.booklevelid 
                      WHERE ((ioffice_book.bookstatusid = 2) or (ioffice_book.bookstatusid = 4)) and
                            $sqlpass and     
                            (
                              (bookid = '$searchtext') or
                              (department_bookid like '%$searchtext%') or
                              (bookheader like '%$searchtext%')
                            )    
                      ORDER BY booktypeid DESC, bookid ASC";
              //echo "<div class='well well-sm'>$sql</div>";
            if ($result = mysqli_query($connect, $sql)) {
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
                    <td><?php echo $row['bookid']; ?></td>
                    <td><?php echo $row['department_bookid']; ?></td>
                    <td><?php echo $booktype_show; ?></td>
                    <td><?php echo $row['bookheader']; ?></td>
                    <td><?php echo $row['booklevelname']; ?></td>
                    <td><?php if($row['updatedate']){echo ThaiTimeConvert(strtotime($row['updatedate']),"","2");}else{echo ThaiTimeConvert(strtotime($row['postdate']),"","2");} ?></td>
                    <td><?php echo $row['post_prename'].$row['post_name']." ".$row['post_surname']; ?></td>
                    <td><?php echo $row["sub_department_name"]; ?></td>
                    <td><?php echo $row["post_department_precis"]; ?></td>
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
                    <td><a tabindex="0" class="btn btn-<?php echo $bookstatusclass; ?>" role="button" data-toggle="popover" data-placement="top" data-trigger="focus" title="ความเห็นล่าสุด" data-content="<?php echo $rowlastcomment["prename"].$rowlastcomment["name"]." ".$rowlastcomment["surname"]." : ".$rowlastcomment["commentdetail"]; ?>"><?php echo $row['bookstatusname']; ?></a></td>                    
                    <td>
                      <!-- Modal for Read -->
                      <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal<?php echo $row['bookid']; ?>">อ่าน&nbsp;/&nbsp;สั่งการ</button>
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
                                  <a href="#" class="btn btn-default">ประเภท&nbsp;:&nbsp;<?php echo $booktype_show; ?></a>
                                  <a href="#" class="btn btn-default">สถานะ&nbsp;:&nbsp;<?php echo $row["bookstatusname"]; ?></a>
                                </div>
                              </div>                          
                            </div>                              
                            <!-- Comment Form -->
                            <form enctype="multipart/form-data" class="form-horizontal" method="POST" action="?option=ioffice&task=book_manage&action=comment">
                            <div class="modal-body">
                              <div class="well">
                                <h4 class="modal-title" id="myModalLabel">เรื่อง <?php echo $row["bookheader"]; ?></h4>
                                <h4 class="modal-title" id="myModalLabel">เรียน <?php echo $row['booklevelname']; ?></h4>
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
                                  <th>ความเห็น</th>
                                  <th>โดย</th>
                                  <th>ตำแหน่ง</th>
                                  <th>สำนัก</th>
                                  <th>เมื่อ</th>
                                  <th>สถานะ</th>
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
                                      echo "<td>".$rowcomment["commentdetail"]."</td>";
                                      echo "<td>".$rowcomment["prename"].$rowcomment["name"]." ".$rowcomment["surname"]."</td>";
                                      echo "<td>".$rowcomment["position_name"]."</td>";
                                      echo "<td>".$rowcomment["department_precis"]."</td>";
                                      echo "<td>".ThaiTimeConvert(strtotime($rowcomment['commentdate']),"","2")."</td>";
                                      echo "<td>".$rowcomment["bookstatusname"]."</td>";
                                      echo "</tr>";
                                    }
                                  ?>
                                  
                                </tbody>                                 
                              </table>
                              <input type="hidden" id="bookid" name="bookid" value="<?php echo $row['bookid']; ?>">
                              <input type="hidden" id="post_personid" name="post_personid" value="<?php echo $row['post_personid']; ?>">
                              <input type="hidden" id="bookheader" name="bookheader" value="<?php echo $row['bookheader']; ?>">
                              <input type="hidden" id="department_bookid" name="department_bookid" value="<?php echo $row['department_bookid']; ?>">
                              <input type="hidden" id="booklevelid" name="booklevelid" value="<?php echo $booklevelid; ?>">
                              <input type="hidden" id="post_departmentid" name="post_departmentid" value="<?php echo $row['post_departmentid']; ?>">
                              <input type="hidden" id="post_subdepartmentid" name="post_subdepartmentid" value="<?php echo $row['post_subdepartmentid']; ?>">
                              <hr>
                              <!-- Nav tabs -->
                              <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#approve<?php echo $row['bookid']; ?>" aria-controls="approve<?php echo $row['bookid']; ?>" role="tab" data-toggle="tab">ลงความเห็น(Approve)</a></li>
                                <?php if($row["bookstatusid"]!=4){ ?>
                                <li role="presentation"><a href="#consult<?php echo $row['bookid']; ?>" aria-controls="consult<?php echo $row['bookid']; ?>" role="tab" data-toggle="tab">ขอความเห็น(Consult)</a></li>
                                <?php } ?>
                              </ul>
                              <!-- Tab panes -->
                              <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="approve<?php echo $row['bookid']; ?>">
                                      <?php if(($user_positionid!=1) and ($receive_booklevelid!=$row["receive_booklevelid"])){ ?>
                                        <p>
                                        <label class="radio-inline">
                                          <input type="radio" name="bookstatusid" id="bookstatusid1" value="2"><span class='glyphicon glyphicon-share-alt' aria-hidden='true'></span> เสนอผู้บริหาร
                                        </label>
                                        </p>
                                      <?php } ?>
                                        <?php if(($row["bookstatusid"]!=4) or ($row["consult_personid"]!=$_SESSION["login_user_id"])) { ?>
                                        <p>
                                        <label class="radio-inline">
                                          <input type="radio" name="bookstatusid" id="bookstatusid20" value="20"><span class='glyphicon glyphicon-ok' aria-hidden='true'></span> ทราบ/อนุมัติ
                                        </label>
                                        <?php if(($user_positionid!=1) and ($receive_booklevelid!=$row["receive_booklevelid"])){ ?>
                                        <label class="radio-inline">
                                          <input type="radio" name="bookstatusid" id="bookstatusid21" value="21"><span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span> ทราบ/อนุมัติ(ปฏิบัติราชการแทน)
                                        </label>
                                        <?php 
                                        if(!isset($_SESSION["system_delegate"])){ $_SESSION["system_delegate"]=""; }
                                        if($_SESSION["system_delegate"]==1) {
                                        ?>
                                        <label class="radio-inline">
                                          <input type="radio" name="bookstatusid" id="bookstatusid22" value="22"><span class='glyphicon glyphicon-check' aria-hidden='true'></span> ทราบ/อนุมัติ(รักษาราชการแทน)
                                        </label>
                                        <?php } ?>
                                      <?php } ?>
                                      </p>
                                      <p>
                                      <label class="radio-inline">
                                        <input type="radio" name="bookstatusid" id="bookstatusid30" value="30"><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> ยุติเรื่อง
                                      </label>
                                      <label class="radio-inline">
                                        <input type="radio" name="bookstatusid" id="bookstatusid40" value="40"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span> คืนเรื่อง/แก้ไข
                                      </label>
                                      </p>
                                      <?php } ?>
                                      <textarea class="form-control" rows="4" name="commentdetail" id="commentdetail" placeholder="ส่วนสำหรับลงความเห็น"></textarea>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="consult<?php echo $row['bookid']; ?>">
                                    <p>
                                    <label class="radio-inline">
                                      <input type="radio" name="bookstatusid" id="bookstatusid4" value="4"><span class='glyphicon glyphicon-comment' aria-hidden='true'></span> ขอความเห็น
                                    </label>
                                    </p>
                                    <p>
                                      <select  name='department' id='department' class="form-control">
                                        <option  value = ''>-</option>"
                                        <?php
                                        $sqldepartment = "select * from  system_department order by department_name";
                                        $resultdepartment = mysqli_query($connect, $sqldepartment);
                                        while ($rowdepartment = $resultdepartment->fetch_assoc()){
                                          echo  "<option  value ='$rowdepartment[department]'>$rowdepartment[department_name]</option>" ;
                                        } 
                                        ?>
                                      </select>
                                    </p>
                                    <p>
                                      <select  name='sub_department' id='sub_department' class="form-control">
                                        <option  value = ''>-</option>"
                                        <?php
                                        //$sqlsubdepartment = "select * from  system_subdepartment order by sub_department_name";
                                        //$resultsubdepartment = mysqli_query($connect, $sqlsubdepartment);
                                        //while ($rowsubdepartment = $resultsubdepartment->fetch_assoc()){
                                        //  echo  "<option  value ='$rowsubdepartment[sub_department]'>$rowsubdepartment[sub_department_name]</option>" ;
                                        //} 
                                        ?>
                                      </select>
                                    </p>  
                                    <p>
                                      <select  name='person' id='person' class="form-control">
                                        <option  value = ''>-</option>"
                                        <?php
                                        //$sqlperson = "select * from  person_main order by name";
                                        //$resultperson = mysqli_query($connect, $sqlperson);
                                        //while ($rowperson = $resultperson->fetch_assoc()){
                                        //  echo  "<option  value ='$rowperson[person_id]'>".$rowperson[prename].$rowperson[name]." ".$rowperson[surname]."</option>" ;
                                        //} 
                                        ?>
                                      </select>
                                    </p>
                                    <textarea class="form-control" rows="4" name="consultdetail" id="consultdetail" placeholder="ส่วนสำหรับแจ้งขอความเห็น"></textarea>
                                </div>
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
            // รายการปฏิบัติราชการแทน
            // ตรวจสอบหน้าที่การปฏิบัติราชการแทน
            $now = date("Y-m-d");
            $sqldelegate = "SELECT * FROM person_delegate WHERE person_id='".$_SESSION["login_user_id"]."' AND '$now' BETWEEN start AND finish";
            if($resultdelegate = mysqli_query($connect,$sqldelegate)){
              $rowdelegate = $resultdelegate->fetch_assoc();
              $delegate_personid = $rowdelegate["from_person_id"];
              $sqluser = "SELECT * FROM person_main WHERE person_id = '$delegate_personid'";
              //echo "<div class='well well-sm'>$sqluser</div>";
              if($resultuser = mysqli_query($connect, $sqluser)) {
                $rowuser = $resultuser->fetch_assoc();
                $delegate_positionid = $rowuser["position_code"];
                $delegate_position_other_code = $rowuser["position_other_code"];
                $delegate_subdepartment = $rowuser["sub_department"];
                $delegate_department = $rowuser["department"];
              }else{
                $delegate_positionid = "";
                $delegate_position_other_code = "";
                $delegate_subdepartment = "";
                $delegate_department = "";
              }
              // เจ้าหน้าที่
              $sqlpass_delegate = "consult_personid = '".$delegate_personid."' ";
              $receive_booklevelid = 1;
              $booklevelid = 1;
              // หัวหน้ากลุ่มงาน
              if($delegate_position_other_code>0){
                //$sqlpass = "((ioffice_book.booklevelid = 1) or (ioffice_book.booktypeid = 4)) and post_subdepartmentid = ".$user_subdepartment." and receive_booklevelid >= 2 and ";
                $sqlpass_delegate = "(ioffice_book.booklevelid = 1) and post_subdepartmentid = ".$delegate_subdepartment." and receive_booklevelid >= 2 ";
                $receive_booklevelid = 2;
                $booklevelid = 2;
              }
              // ผอ.สำนัก
              if($delegate_positionid==9){
                $sqlpass_delegate = " ioffice_book.booklevelid = 2 and post_departmentid = ".$delegate_department." and receive_booklevelid >= 3 ";
                $receive_booklevelid = 3;
                $booklevelid = 3;
              }
              // รองเลขา และผู้ช่วยเลขา
              if($delegate_positionid==2 or $delegate_positionid==3){ 
                $receive_booklevelid = 4;
                $booklevelid = 4;
                $sqlpass_delegate = " ioffice_book.booklevelid = 3 and post_departmentid IN(SELECT departmentid FROM ioffice_bookpass WHERE personid = '".$delegate_personid."') and receive_booklevelid >= 4 ";
              }
              // เลขา
              if($delegate_positionid==1){
                $receive_booklevelid = 5;
                $booklevelid = 5;
                $sqlpass_delegate = " ioffice_book.booklevelid = 4 and receive_booklevelid >= 5 ";
              }
  
            }else{
              $delegate_personid = "";
              $sqlpass_delegate = "";
            }
              //echo "<div class='well well-sm'>$sqldelegate<br>$delegate_personid</div>";

            // Select Book
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
                        ibl.booklevelname   
                      FROM
                        ioffice_book
                        LEFT JOIN ioffice_bookstatus ON ioffice_book.bookstatusid = ioffice_bookstatus.bookstatusid
                        LEFT JOIN ioffice_booktype ON ioffice_book.booktypeid = ioffice_booktype.booktypeid
                        LEFT JOIN person_main pm1 ON ioffice_book.post_personid = pm1.person_id 
                        LEFT JOIN system_department sd1 ON sd1.department = ioffice_book.post_departmentid 
                        LEFT JOIN system_subdepartment ON system_subdepartment.sub_department = ioffice_book.post_subdepartmentid 
                        LEFT JOIN ioffice_booklevel ibl ON ioffice_book.receive_booklevelid = ibl.booklevelid 
                      WHERE ((ioffice_book.bookstatusid = 2) or (ioffice_book.bookstatusid = 4)) and
                            $sqlpass_delegate and     
                            (
                              (bookid = '$searchtext') or
                              (department_bookid like '%$searchtext%') or
                              (bookheader like '%$searchtext%')
                            )    
                      ORDER BY booktypeid DESC, bookid ASC";
              //echo "<div class='well well-sm'>$sql</div>";
            if ($result = mysqli_query($connect, $sql)) {
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
                    <td><?php echo $row['bookid']; ?></td>
                    <td><?php echo $row['department_bookid']; ?></td>
                    <td><?php echo $booktype_show; ?></td>
                    <td><?php echo $row['bookheader']; ?></td>
                    <td><?php echo $row['booklevelname']; ?></td>
                    <td><?php if($row['updatedate']){echo ThaiTimeConvert(strtotime($row['updatedate']),"","2");}else{echo ThaiTimeConvert(strtotime($row['postdate']),"","2");} ?></td>
                    <td><?php echo $row['post_prename'].$row['post_name']." ".$row['post_surname']; ?></td>
                    <td><?php echo $row["sub_department_name"]; ?></td>
                    <td><?php echo $row["post_department_precis"]; ?></td>
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
                    <td><a tabindex="0" class="btn btn-<?php echo $bookstatusclass; ?>" role="button" data-toggle="popover" data-placement="top" data-trigger="focus" title="ความเห็นล่าสุด" data-content="<?php echo $rowlastcomment["prename"].$rowlastcomment["name"]." ".$rowlastcomment["surname"]." : ".$rowlastcomment["commentdetail"]; ?>"><?php echo $row['bookstatusname']; ?></a></td>                    
                    <td>
                      <!-- Modal for Read -->
                      <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal<?php echo $row['bookid']; ?>">อ่าน&nbsp;/&nbsp;สั่งการ(แทน)</button>
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
                                  <a href="#" class="btn btn-default">ประเภท&nbsp;:&nbsp;<?php echo $booktype_show; ?></a>
                                  <a href="#" class="btn btn-default">สถานะ&nbsp;:&nbsp;<?php echo $row["bookstatusname"]; ?></a>
                                </div>
                              </div>                          
                            </div>                              
                            <!-- Comment Form -->
                            <form enctype="multipart/form-data" class="form-horizontal" method="POST" action="?option=ioffice&task=book_manage&action=comment">
                            <div class="modal-body">
                              <div class="well">
                                <h4 class="modal-title" id="myModalLabel">เรื่อง <?php echo $row["bookheader"]; ?></h4>
                                <h4 class="modal-title" id="myModalLabel">เรียน <?php echo $row['booklevelname']; ?></h4>
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
                                  <th>ความเห็น</th>
                                  <th>โดย</th>
                                  <th>ตำแหน่ง</th>
                                  <th>สำนัก</th>
                                  <th>เมื่อ</th>
                                  <th>สถานะ</th>
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
                                      echo "<td>".$rowcomment["commentdetail"]."</td>";
                                      echo "<td>".$rowcomment["prename"].$rowcomment["name"]." ".$rowcomment["surname"]."</td>";
                                      echo "<td>".$rowcomment["position_name"]."</td>";
                                      echo "<td>".$rowcomment["department_precis"]."</td>";
                                      echo "<td>".ThaiTimeConvert(strtotime($rowcomment['commentdate']),"","2")."</td>";
                                      echo "<td>".$rowcomment["bookstatusname"]."</td>";
                                      echo "</tr>";
                                    }
                                  ?>
                                  
                                </tbody>                                 
                              </table>
                              <input type="hidden" id="bookid" name="bookid" value="<?php echo $row['bookid']; ?>">
                              <input type="hidden" id="post_personid" name="post_personid" value="<?php echo $row['post_personid']; ?>">
                              <input type="hidden" id="bookheader" name="bookheader" value="<?php echo $row['bookheader']; ?>">
                              <input type="hidden" id="department_bookid" name="department_bookid" value="<?php echo $row['department_bookid']; ?>">
                              <input type="hidden" id="booklevelid" name="booklevelid" value="<?php echo $booklevelid; ?>">
                              <input type="hidden" id="post_departmentid" name="post_departmentid" value="<?php echo $row['post_departmentid']; ?>">
                              <input type="hidden" id="post_subdepartmentid" name="post_subdepartmentid" value="<?php echo $row['post_subdepartmentid']; ?>">
                              <input type="hidden" id="delegate_personid" name="delegate_personid" value="<?php echo $delegate_personid; ?>">
                              <hr>
                              <!-- Nav tabs -->
                              <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#approve<?php echo $row['bookid']; ?>" aria-controls="approve<?php echo $row['bookid']; ?>" role="tab" data-toggle="tab">ลงความเห็น(Approve)</a></li>
                                <?php if($row["bookstatusid"]!=4){ ?>
                                <li role="presentation"><a href="#consult<?php echo $row['bookid']; ?>" aria-controls="consult<?php echo $row['bookid']; ?>" role="tab" data-toggle="tab">ขอความเห็น(Consult)</a></li>
                                <?php } ?>
                              </ul>
                              <!-- Tab panes -->
                              <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="approve<?php echo $row['bookid']; ?>">
                                      <?php if(($user_positionid!=1) and ($receive_booklevelid!=$row["receive_booklevelid"])){ ?>
                                        <p>
                                        <label class="radio-inline">
                                          <input type="radio" name="bookstatusid" id="bookstatusid1" value="2"><span class='glyphicon glyphicon-share-alt' aria-hidden='true'></span> เสนอผู้บริหาร
                                        </label>
                                        </p>
                                      <?php } ?>
                                        <?php if(($row["bookstatusid"]!=4) or ($row["consult_personid"]!=$_SESSION["login_user_id"])) { ?>
                                        <p>
                                        <label class="radio-inline">
                                          <input type="radio" name="bookstatusid" id="bookstatusid20" value="20"><span class='glyphicon glyphicon-ok' aria-hidden='true'></span> ทราบ/อนุมัติ
                                        </label>
                                        <?php if(($user_positionid!=1) and ($receive_booklevelid!=$row["receive_booklevelid"])){ ?>
                                        <label class="radio-inline">
                                          <input type="radio" name="bookstatusid" id="bookstatusid21" value="21"><span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span> ทราบ/อนุมัติ(ปฏิบัติราชการแทน)
                                        </label>
                                        <?php 
                                        if(!isset($_SESSION["system_delegate"])){ $_SESSION["system_delegate"]=""; }
                                        if($_SESSION["system_delegate"]==1) {
                                        ?>
                                        <label class="radio-inline">
                                          <input type="radio" name="bookstatusid" id="bookstatusid22" value="22"><span class='glyphicon glyphicon-check' aria-hidden='true'></span> ทราบ/อนุมัติ(รักษาราชการแทน)
                                        </label>
                                        <?php } ?>
                                      <?php } ?>
                                      </p>
                                      <p>
                                      <label class="radio-inline">
                                        <input type="radio" name="bookstatusid" id="bookstatusid30" value="30"><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> ยุติเรื่อง
                                      </label>
                                      <label class="radio-inline">
                                        <input type="radio" name="bookstatusid" id="bookstatusid40" value="40"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span> คืนเรื่อง/แก้ไข
                                      </label>
                                      </p>
                                      <?php } ?>
                                      <textarea class="form-control" rows="4" name="commentdetail" id="commentdetail" placeholder="ส่วนสำหรับลงความเห็น"></textarea>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="consult<?php echo $row['bookid']; ?>">
                                    <p>
                                    <label class="radio-inline">
                                      <input type="radio" name="bookstatusid" id="bookstatusid4" value="4"><span class='glyphicon glyphicon-comment' aria-hidden='true'></span> ขอความเห็น
                                    </label>
                                    </p>
                                    <p>
                                      <select  name='department' id='department' class="form-control">
                                        <option  value = ''>-</option>"
                                        <?php
                                        $sqldepartment = "select * from  system_department order by department_name";
                                        $resultdepartment = mysqli_query($connect, $sqldepartment);
                                        while ($rowdepartment = $resultdepartment->fetch_assoc()){
                                          echo  "<option  value ='$rowdepartment[department]'>$rowdepartment[department_name]</option>" ;
                                        } 
                                        ?>
                                      </select>
                                    </p>
                                    <p>
                                      <select  name='sub_department' id='sub_department' class="form-control">
                                        <option  value = ''>-</option>"
                                        <?php
                                        //$sqlsubdepartment = "select * from  system_subdepartment order by sub_department_name";
                                        //$resultsubdepartment = mysqli_query($connect, $sqlsubdepartment);
                                        //while ($rowsubdepartment = $resultsubdepartment->fetch_assoc()){
                                        //  echo  "<option  value ='$rowsubdepartment[sub_department]'>$rowsubdepartment[sub_department_name]</option>" ;
                                        //} 
                                        ?>
                                      </select>
                                    </p>  
                                    <p>
                                      <select  name='person' id='person' class="form-control">
                                        <option  value = ''>-</option>"
                                        <?php
                                        //$sqlperson = "select * from  person_main order by name";
                                        //$resultperson = mysqli_query($connect, $sqlperson);
                                        //while ($rowperson = $resultperson->fetch_assoc()){
                                        //  echo  "<option  value ='$rowperson[person_id]'>".$rowperson[prename].$rowperson[name]." ".$rowperson[surname]."</option>" ;
                                        //} 
                                        ?>
                                      </select>
                                    </p>
                                    <textarea class="form-control" rows="4" name="consultdetail" id="consultdetail" placeholder="ส่วนสำหรับแจ้งขอความเห็น"></textarea>
                                </div>
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
    </div>
  </div>
</div> 
</body>
</html>