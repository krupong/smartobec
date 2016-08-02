<?php
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
      <h3 class="panel-title">รายการบันทึกเสนอ</h3>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-md-3 text-left">
          <a href="?option=ioffice&task=book_insert" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>&nbsp;เพิ่มบันทึกเสนอ</a>
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
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> ค้นหา</button>
            <a href="?option=ioffice&task=book_manage&action=select_clearsearchtext" class="btn btn-default"><span class="glyphicon glyphicon-list"></span> แสดงทั้งหมด</a>
          </form>
        </div>
      </div>
      <hr>
      <table class="table table-hover table-striped table-condensed table-responsive">
        <thead>
          <tr>
          	<th>เลขที่</th>
            <th>ประเภท</th>
          	<th>เรื่อง</th>
            <th>เมื่อ</th>
            <th>โดย</th>
            <th>สถานะ</th>
            <th>รายละเอียด</th>
            <th>จัดการ</th>
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
            $sql = " SELECT
                  ioffice_book.*,
                  ioffice_booktype.booktypename,
                  ioffice_bookstatus.bookstatusname,
                  person_main.prename,
                  person_main.name,
                  person_main.surname
                FROM
                  ioffice_book
                  LEFT JOIN ioffice_bookstatus ON ioffice_book.bookstatusid = ioffice_bookstatus.bookstatusid
                  LEFT JOIN ioffice_booktype ON ioffice_book.booktypeid = ioffice_booktype.booktypeid
                  LEFT JOIN person_main ON ioffice_book.post_personid = person_main.person_id
                WHERE post_personid = '$_SESSION[login_user_id]' ".$sqlbookstatus." and
                      bookheader like '%$searchtext%'
                ORDER BY bookid DESC";
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
                    $tr_class = "class = 'info'";
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

                  default:
                    $booktype_show = "&nbsp;";
                    break;
                }
                ?>
                  <tr <?php echo $tr_class; ?>>
                    <td><?php echo $row['bookid']; ?></td>
                    <td><?php echo $booktype_show; ?></td>
                    <td><?php echo $row['bookheader']; ?></td>
                    <td><?php echo ThaiTimeConvert(strtotime($row['postdate']),"","2"); ?></td>
                    <td><?php echo $row['prename'].$row['name']." ".$row['surname']; ?></td>
                    <?php
                      $sqllastcomment = " SELECT * FROM ioffice_bookcomment b
                                          LEFT JOIN person_main pm ON(b.comment_personid=pm.person_id)
                                          WHERE bookid = ".$row["bookid"]." ORDER BY commentid DESC LIMIT 0,1";
                      $resultlastcomment = mysqli_query($connect, $sqllastcomment);
                      $rowlastcomment = mysqli_fetch_assoc($resultlastcomment);
                    ?>
                    <td><a tabindex="0" class="btn btn-default btn-xs" role="button" data-toggle="popover" data-placement="top" data-trigger="focus" title="ความเห็นล่าสุด" data-content="<?php echo $rowlastcomment["prename"].$rowlastcomment["name"]." ".$rowlastcomment["surname"]." : ".$rowlastcomment["commentdetail"]; ?>"><?php echo $row['bookstatusname']; ?></a></td>
                    <td>
                      <!-- Modal for Read -->
                      <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModal<?php echo $row['bookid']; ?>">อ่าน</button>
                      <div class="modal fade bs-example-modal-lg" id="myModal<?php echo $row['bookid']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title" id="myModalLabel">เรื่อง <?php echo $row["bookheader"]; ?></h4>
                            </div>
                            <div class="modal-body">
                              <a href="#" class="btn btn-default">ประเภท&nbsp;:&nbsp;<?php echo $booktype_show; ?></a>
                              <a href="#" class="btn btn-default">สถานะ&nbsp;:&nbsp;<?php echo $row["bookstatusname"]; ?></a>
                              <hr>
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
                              <div class="well well-sm">
                              <h5>โดย&nbsp;<?php echo $row['prename'].$row['name']." ".$row['surname']; ?></h5>
                              <h5>เมื่อ&nbsp;<?php echo ThaiTimeConvert(strtotime($row['postdate']),"","2"); ?></h5>
                              </h5>
                              </div>
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
                                    //echo $sqlcomment;
                                    $resultcomment = mysqli_query($connect, $sqlcomment);
                                    $commentnum = 0;
                                    while ($rowcomment = $resultcomment->fetch_assoc()) {
                                      echo "<tr>";
                                      echo "<td>".++$commentnum."</td>";
                                      echo "<td>".$rowcomment["commentdetail"]."</td>";
                                      echo "<td>".$rowcomment["prename"].$rowcomment["name"]." ".$rowcomment["surname"]."</td>";
                                      echo "<td>".$rowcomment["position_name"]."</td>";
                                      echo "<td><a tabindex='0' class='btn btn-xs' role='button' data-toggle='popover' data-placement='top' data-trigger='focus' title='หน่วยงาน' data-content='".$rowcomment["department_name"]."''>".$rowcomment["department_precis"]."</a></td>";
                                      echo "<td>".ThaiTimeConvert(strtotime($rowcomment['commentdate']),"","2")."</td>";
                                      echo "<td>".$rowcomment["bookstatusname"]."</td>";
                                      echo "</tr>";
                                    }
                                  ?>
                                </tbody>
                              </table>
                              <hr>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span>&nbsp;ปิด</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td>
                      <?php
                        switch ($row["bookstatusid"]) {
                          case '1':
                            echo "<a href='?option=ioffice&task=book_update&bookid=".$row['bookid']."' class='btn btn-warning btn-xs'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>&nbsp;แก้ไข</a>&nbsp;<a href='?option=ioffice&task=book_manage&action=delete&bookid=".$row['bookid']."' class='btn btn-danger btn-xs' data-toggle='confirmation'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span>&nbsp;ลบ</a>";
                            break;
                          case '2':
                            echo "<a href='?option=ioffice&task=book_manage&action=update_status3&bookid=".$row['bookid']."' class='btn btn-danger btn-xs' data-toggle='confirmation'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span>&nbsp;ยกเลิก</a>";
                            break;
                          case '3':
                            echo "<a href='?option=ioffice&task=book_manage&action=copy&bookid=".$row['bookid']."' class='btn btn-info btn-xs' data-toggle='confirmation'><span class='glyphicon glyphicon-duplicate' aria-hidden='true'></span>&nbsp;คัดลอก</a>";
                            break;
                            case '20':
                            echo "<a href='#' class='btn btn-success btn-xs' data-toggle='confirmation'><span class='glyphicon glyphicon-share-alt' aria-hidden='true'></span>&nbsp;ส่งออก</a>";
                            break;
                            case '21':
                            echo "<a href='#' class='btn btn-success btn-xs' data-toggle='confirmation'><span class='glyphicon glyphicon-share-alt' aria-hidden='true'></span>&nbsp;ส่งออก</a>";
                            break;
                            case '22':
                            echo "<a href='#' class='btn btn-success btn-xs' data-toggle='confirmation'><span class='glyphicon glyphicon-share-alt' aria-hidden='true'></span>&nbsp;ส่งออก</a>";
                            break;
                          case '30':
                            echo "&nbsp;";
                            break;
                          case '40':
                            echo "<a href='?option=ioffice&task=book_manage&action=copy&bookid=".$row['bookid']."' class='btn btn-info btn-xs' data-toggle='confirmation'><span class='glyphicon glyphicon-duplicate' aria-hidden='true'></span>&nbsp;คัดลอก</a>";
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
    </div>
  </div>
</div>
</body>
</html>
