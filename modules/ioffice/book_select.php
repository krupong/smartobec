<?php

include("permission.php");

// Search Condition
if($_POST["searchtext"]){
  $searchtext = $_POST["searchtext"];
  $_SESSION["searchtext"] = $_POST["searchtext"];
}else{
  $searchtext = $_SESSION["searchtext"];
}
if($_POST["searchbookstatusid"]){
  switch ($_POST["searchbookstatusid"]) {
    case '999':
      $searchbookstatusid = 999;
      unset($_SESSION["searchbookstatusid"]);
      break;
    default:
      $searchbookstatusid = $_POST["searchbookstatusid"];
      $_SESSION["searchbookstatusid"] = $_POST["searchbookstatusid"];
      break;
  }
}else{
  $searchbookstatusid = $_SESSION["searchbookstatusid"];
}

?>
<!--<div class="container">-->
<div class="box box-primary">
  <div class="box-header with-border">
    <p><h4 class="box-title">บันทึกข้อความ</h4></p>
    <div class="row">
        <div class="col-md-3 text-left">
          <a href="?option=ioffice&task=book_insert" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>&nbsp;เขียนบันทึกข้อความ</a>
        </div>
        <div class="col-md-9 text-right">
          <form class="form-inline" action="#" enctype="multipart/form-data" method="POST" >
            <div class="form-group">
              <label for="searchtext"></label>
              <input type="text" class="form-control" id="searchtext" name="searchtext" placeholder="พิมพ์คำค้นหา" value="<?php echo $searchtext; ?>">
            </div>
            <div class="form-group">
              <select class="form-control" name="searchbookstatusid" >
                <option value="999" <?php if($searchbookstatusid==0){ echo "selected"; } ?>>ทุกสถานะ</option>
                <?php
                  $sqlbookstatus = "SELECT * FROM ioffice_bookstatus";
                  if($resultbookstatus = mysqli_query($connect, $sqlbookstatus)){
                    while ($rowbookstatus = $resultbookstatus->fetch_assoc()) {
                      $selected = "";
                      if($searchbookstatusid==$rowbookstatus["bookstatusid"]){ $selected = "selected"; }
                      echo "<option value='".$rowbookstatus["bookstatusid"]."' ".$selected.">".$rowbookstatus["bookstatusname"]."</option>";
                    }  
                  }
                ?>
              </select>
            </div>
            <button type="submit" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="ค้นหา"><span class="glyphicon glyphicon-search"></span></button>
            <a href="?option=ioffice&task=book_manage&action=select_clearsearchtext" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="แสดงทั้งหมด"><span class="glyphicon glyphicon-list"></span></a>
          </form>
        </div>
    </div>
  </div>
  <div class="box-body">
      <?php
      // Select Book
      if(($searchbookstatusid==999) or ($searchbookstatusid=="")){
        $sqlbookstatus = "";
      }else{
        $sqlbookstatus = " and ioffice_book.bookstatusid = ".$searchbookstatusid." ";
      }
      $sql = " SELECT 
            ioffice_book.*,
            ioffice_booktype.booktypename,
            ioffice_bookstatus.bookstatusname,
            pm1.prename as post_prename,
            pm1.name as post_name,
            pm1.surname as post_surname,
            pm2.prename as receive_prename,
            pm2.name as receive_name,
            pm2.surname as receive_surname,
            pp2.position_name as receive_position_name
          FROM
            ioffice_book
            LEFT JOIN ioffice_bookstatus ON ioffice_book.bookstatusid = ioffice_bookstatus.bookstatusid
            LEFT JOIN ioffice_booktype ON ioffice_book.booktypeid = ioffice_booktype.booktypeid
            LEFT JOIN person_main pm1 ON ioffice_book.post_personid = pm1.person_id
            LEFT JOIN person_main pm2 ON ioffice_book.receive_personid = pm2.person_id 
            LEFT JOIN person_position pp2 ON pp2.position_code = pm2.position_code
          WHERE post_personid = '$_SESSION[login_user_id]' ".$sqlbookstatus." and 
                bookheader like '%$searchtext%'    
          ORDER BY bookid DESC";
      //echo "<div class='well'>$sql</div>";
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
                  echo "<li $active><a href='?option=ioffice&task=book_select&page=$x'>$x <span class='sr-only'></span></a></li>"; 
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
            <th>สถานะ</th>
            <th width=200>ดำเนินการ</th>
       	  </tr>
        </thead>
        <tbody>
          
          <?php 
            // Select Book
            if(($searchbookstatusid==999) or ($searchbookstatusid=="")){
              $sqlbookstatus = "";
            }else{
              $sqlbookstatus = " and ioffice_book.bookstatusid = ".$searchbookstatusid." ";
            }
            $sql = $sql.' '.$limit;
            //echo "<div class='well'>$sql</div>";
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
                    <td><?php echo $row['department_bookid'].'<br>ชั้นความเร็ว :'.$booktype_show.'<br>เมื่อ '; if($row['updatedate']){echo ThaiTimeConvert(strtotime($row['updatedate']),"","2");}else{echo ThaiTimeConvert(strtotime($row['postdate']),"","2");} ?></td>
                    <td><?php echo $row['bookheader']; ?></td>
                    <td><?php echo $row['receive_position_name'].'<br>'.$row['receive_prename'].$row['receive_name'].' '.$row['receive_surname']; ?></td>
                    <td><?php echo $row['bookstatusname']; ?></td>
                    <!--<td><?php //if($row['updatedate']){echo ThaiTimeConvert(strtotime($row['updatedate']),"","2");}else{echo ThaiTimeConvert(strtotime($row['postdate']),"","2");} ?></td>-->
                    <td>
                      <!-- Modal for Read -->
                      <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal<?php echo $row['bookid']; ?>" title="เปิด"><span class="glyphicon glyphicon-folder-open"></span></button>
                      <div class="modal fade bs-example-modal-lg" id="myModal<?php echo $row['bookid']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <div class="row">
                                <div class="col-md-6 text-left">
                                  <h4><?php echo "เลขที่ ".$row["bookid"]; ?></h4>
                                  <h4><?php echo "เลขที่สำนัก ".$row["department_bookid"]; ?></h4>
                                </div>
                                <div class="col-md-6 text-right">
                                  <a href="#" class="btn btn-default">ชั้นความเร็ว&nbsp;:&nbsp;<?php echo $booktype_show; ?></a>
                                  <a href="#" class="btn btn-default">สถานะ&nbsp;:&nbsp;<?php echo $row["bookstatusname"]; ?></a>
                                </div>
                              </div>
                            </div>
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
                                    //echo $sqlcomment;
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
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span>&nbsp;ปิด</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php
                      $sqllastcomment = " SELECT * FROM ioffice_bookcomment b  
                                          LEFT JOIN person_main pm ON(b.comment_personid=pm.person_id) 
                                          WHERE bookid = ".$row["bookid"]." ORDER BY commentid DESC LIMIT 0,1";
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
                      if($row['department_bookid']!=""){ 
                        $where_department=$row['department_bookid']; 
                      }else{
                        $where_department="ไม่พบรายการส่ง";
                      }
                      $sqlbookregister = "SELECT * FROM bookregister_send WHERE comment like '%".$where_department."%'";
                      if($resultbookregister = mysqli_query($connect,$sqlbookregister)){
                        $book_no = "";
                        $tooltip = "";
                        $btnname = "<span class='glyphicon glyphicon-envelope' aria-hidden='true'></span> ส่งออก";
                        $btnclass = "btn-success";
                        while ($rowbookregister = $resultbookregister->fetch_assoc()) {
                          if($book_no!=""){ $book_no.="<br>"; }
                          $book_no.=$rowbookregister["book_no"]." ลงวันที่ ".ThaiTimeConvert(strtotime($rowbookregister["signdate"]),"","");
                          $tooltip = " data-toggle='tooltip' data-placement='top' title='$book_no' data-html='true' ";
                          $btnname = "<span class='glyphicon glyphicon-cloud' aria-hidden='true'></span> ส่งแล้ว";
                          $btnclass = "btn-default";
                        }
                      }                      
                      switch ($row["bookstatusid"]) {
                        case '1':
                          echo "<a href='?option=ioffice&task=book_update&bookid=".$row['bookid']."' class='btn btn-warning'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>&nbsp;แก้ไข</a>&nbsp;<a href='?option=ioffice&task=book_manage&action=delete&bookid=".$row['bookid']."' class='btn btn-danger' data-toggle='confirmation'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span>&nbsp;ลบ</a>";
                          break;
                        case '2':
                          echo "<a href='?option=ioffice&task=book_manage&action=update_status3&bookid=".$row['bookid']."' class='btn btn-danger' data-toggle='confirmation'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span>&nbsp;ดึงเรื่องกลับ</a>";
                          break;  
                        case '3':
                          echo "<a href='?option=ioffice&task=book_manage&action=copy&bookid=".$row['bookid']."' class='btn btn-default' data-toggle='confirmation'><span class='glyphicon glyphicon-duplicate' aria-hidden='true'></span>&nbsp;คัดลอก</a>";
                          break;
                        case '4':
                          echo "<a href='?option=ioffice&task=book_manage&action=update_status3&bookid=".$row['bookid']."' class='btn btn-danger' data-toggle='confirmation'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span>&nbsp;ดึงเรื่องกลับ</a>";
                          break;  
                        case '20':
                          echo "<a href='?option=bookregister&task=main/send_de&index=1&ioffice_bookid=".$row['bookid']."' class='btn $btnclass' role='button' $tooltip>$btnname</a>";
                          $sql_person = "select * from person_main where person_id = '".$_SESSION["login_user_id"]."'";
                          if($result_person = mysqli_query($connect, $sql_person)) {
                            $row_person = $result_person->fetch_assoc();
                            $position_code = $row_person["position_code"];
                          }else{
                            $position_code = "99999";
                          }
                          if(($position_code<=30) and ($row["post_personid"]==$_SESSION["login_user_id"])){ //ตำแหน่งที่อนุมัติเองได้ 
                            echo "&nbsp;";
                            echo "<a href='?option=ioffice&task=book_manage&action=update_status3&bookid=".$row['bookid']."' class='btn btn-danger' data-toggle='confirmation'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span>&nbsp;ดึงเรื่องกลับ</a>";
                          }
                          break;
                        case '21':
                          echo "<a href='?option=bookregister&task=main/send_de&index=1&ioffice_bookid=".$row['bookid']."' class='btn $btnclass' role='button' $tooltip>$btnname</a>";
                          break;
                        case '22':
                          echo "<a href='?option=bookregister&task=main/send_de&index=1&ioffice_bookid=".$row['bookid']."' class='btn $btnclass' role='button' $tooltip>$btnname</a>";
                          break;
                        case '30':
                          echo "&nbsp;";
                          break;
                        case '40':
                          echo "<a href='?option=ioffice&task=book_manage&action=copy&bookid=".$row['bookid']."' class='btn btn-default' data-toggle='confirmation'><span class='glyphicon glyphicon-duplicate' aria-hidden='true'></span>&nbsp;คัดลอก</a>";
                          break;
                        default:
                          echo "&nbsp;";
                          break;
                      }
                      ?>
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
                  echo "<li $active><a href='?option=ioffice&task=book_select&page=$x'>$x <span class='sr-only'></span></a></li>"; 
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
</div>
<!--</div>--> 