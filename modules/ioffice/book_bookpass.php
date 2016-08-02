<?php
  // Define Variable
  if(isset($_POST["searchtext"])){ }else{ $_POST["searchtext"]=""; }
  if(isset($_SESSION["searchtext"])){ }else{ $_SESSION["searchtext"]=""; }
  if(isset($_POST["searchbookstatusid"])){ }else{ $_POST["searchbookstatusid"]=""; }
  if(isset($_SESSION["searchbookstatusid"])){ }else{ $_SESSION["searchbookstatusid"]=""; }
  if(isset($_POST["searchdepartmentid"])){ }else{ $_POST["searchdepartmentid"]=""; }
  if(isset($_SESSION["searchdepartmentid"])){ }else{ $_SESSION["searchdepartmentid"]=""; }
  // Search Condition
  if($_POST["searchtext"]){
    $searchtext = $_POST["searchtext"];
    $_SESSION["searchtext"] = $_POST["searchtext"];
  }else{
    $searchtext = $_SESSION["searchtext"];
  }
?>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">กำหนดรองเลขาฯ / ผู้ช่วยเลขาฯ ประจำสำนัก</h3>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-md-12 text-right">
          <form class="form-inline" action="#" enctype="multipart/form-data" method="POST" >
            <div class="form-group">
              <label for="searchtext"></label>
              <input type="text" class="form-control" id="searchtext" name="searchtext" placeholder="พิมพ์คำค้นหา" value="<?php echo $searchtext; ?>">
            </div>
            <button type="submit" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="ค้นหา"><span class="glyphicon glyphicon-search"></span></button>
            <a href="?option=ioffice&task=book_manage&action=bookpass_clearsearchtext" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="แสดงทั้งหมด"><span class="glyphicon glyphicon-list"></span></a>
          </form>
        </div>
      </div>
      <hr>
      <table class="table table-hover table-striped table-condensed table-responsive">
        <thead>
          <tr>
          	<th>รองเลขาฯ / ผู้ช่วยเลขาฯ</th>
            <th>ตำแหน่ง</th>
            <th>สำนัก(จำนวน)</th> 
            <th>กำหนด</th>        
       	  </tr>
        </thead>
        <tbody>
          
          <?php 
            // Select Book
            $sql = "  SELECT
                      person_main.person_id,
                      person_main.prename,
                      person_main.name,
                      person_main.surname,
                      person_main.position_code,
                      person_position.position_name 
                      FROM
                      person_main
                      LEFT JOIN person_position ON person_main.position_code = person_position.position_code
                      WHERE
                      (person_main.position_code = 2 or person_main.position_code = 3) and person_main.name like '%$searchtext%'
                      ORDER BY person_main.position_code,person_main.name";
                //echo $sql;
            if ($result = mysqli_query($connect, $sql)) {
              while ($row = $result->fetch_assoc()) {
                ?>
                  <tr>
                    <td><?php echo $row['prename'].$row['name']." ".$row['surname']; ?></td>
                    <td><?php echo $row["position_name"]; ?></td>
                    <td>
                      <?php 
                      $sqlpasscount = "SELECT COUNT(departmentid) as bookcount FROM ioffice_bookpass WHERE personid = '".$row['person_id']."'";
                      $resultpasscount = mysqli_query($connect,$sqlpasscount);
                      $rowpasscount = $resultpasscount->fetch_assoc();
                      echo "<span class='badge progress-bar-success'>".$rowpasscount["bookcount"]."</span>"; 
                      //echo $rowpasscount["bookcount"]; 
                      ?>
                    </td>
                    <td>
                      <!-- Modal for Read -->
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal<?php echo $row['person_id']; ?>"><span class='glyphicon glyphicon-cog' aria-hidden='true'></span>&nbsp;กำหนด</button>
                      <form enctype="multipart/form-data" class="form-horizontal" method="POST" action="?option=ioffice&task=book_manage&action=bookpass">
                      <div class="modal fade bs-example-modal-lg" id="myModal<?php echo $row['person_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title" id="myModalLabel">กำหนดรองเลขาฯ ประจำสำนัก</h4>
                            </div>

                            <div class="modal-body">
                              <div class="well">
                                <h4><?php echo $row['prename'].$row['name']." ".$row['surname']; ?> : <?php echo $row["position_name"]; ?></h4>
                                <input type="hidden" name="personid" id="personid" value="<?php echo $row["person_id"]; ?>">
                              </div>
                              <div class="checkbox">
                                <div class="row">
                                    <?php
                                    $sqldepartment = "SELECT
                                                      system_department.id,
                                                      system_department.department,
                                                      system_department.department_name,
                                                      system_department.department_precis,
                                                      system_department.department_order
                                                      FROM
                                                      system_department";
                                    //echo "<div class='well'>$sqldepartment</div>";
                                    if($resultdepartment = mysqli_query($connect, $sqldepartment)){
                                      $numrowdepartment = ceil(mysqli_num_rows($resultdepartment)/2)+1;
                                      $i = 0;
                                      while ($rowdepartment = $resultdepartment->fetch_assoc()) {
                                        ++$i;
                                        $sqlpassbook = "SELECT * FROM ioffice_bookpass WHERE personid='".$row["person_id"]."' and departmentid=".$rowdepartment["department"];
                                        $resultpassbook = mysqli_query($connect, $sqlpassbook);
                                        $resultpassbooknum = mysqli_num_rows($resultpassbook);
                                        if($resultpassbooknum!=0) { $checked = "checked"; }else{ $checked = ""; }
                                        if($i==1){ echo "<div class='col-md-6'>"; }
                                        if($i==$numrowdepartment){ echo "</div><div class='col-md-6'>"; }
                                        echo "<p><label><input name='departmentid[]' id='departmentid[]' type='checkbox' value='".$rowdepartment["department"]."' ".$checked.">".$rowdepartment["department_name"]."</label></p>";
                                      }
                                      echo "</div>";
                                    }
                                    ?> 
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span>&nbsp;ปิด</button>
                              <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span>&nbsp;บันทึก</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      </form>
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

</body>
</html>