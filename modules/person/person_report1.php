<?php
  // Define Variable
  if(!isset($_POST["searchtext"])){ $_POST["searchtext"]=""; }
  if(!isset($_POST["searchdepartmentid"])){ $_POST["searchdepartmentid"]=""; }
  if(!isset($_SESSION["searchtext"])){ $_SESSION["searchtext"]=""; }
  if(!isset($_SESSION["searchdepartmentid"])){ $_SESSION["searchdepartmentid"]=""; }
  // Search Condition
  if($_POST["searchtext"]){
    $searchtext = $_POST["searchtext"];
    $_SESSION["searchtext"] = $_POST["searchtext"];
  }else{
    $searchtext = $_SESSION["searchtext"];
  }
  if($_POST["searchdepartmentid"]){
    switch ($_POST["searchdepartmentid"]) {
      case '999':
        $searchdepartmentid = 999;
        unset($_SESSION["searchdepartmentid"]);
        break;
      default:
        $searchdepartmentid = $_POST["searchdepartmentid"];
        $_SESSION["searchdepartmentid"] = $_POST["searchdepartmentid"];
        break;
    }
  }else{
    $searchdepartmentid = $_SESSION["searchdepartmentid"];
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
      <h3 class="panel-title">ข้อมูลบุคลากรใน สพฐ. (ปัจจุบัน)</h3>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-md-2 text-left">
        </div>
        <div class="col-md-10 text-right">
          <form class="form-inline" action="#" enctype="multipart/form-data" method="POST" >
            <div class="form-group">
              <label for="searchtext"></label>
              <input type="text" class="form-control" id="searchtext" name="searchtext" placeholder="พิมพ์คำค้นหา" value="<?php echo $searchtext; ?>">
            </div>
            <div class="form-group">
              <select class="form-control" name="searchdepartmentid" >
                <option value="999" <?php if($searchdepartmentid==0){ echo "selected"; } ?>>ทุกสำนัก</option>
                <?php
                  $sqldepartment = "SELECT * FROM system_department ORDER BY department_name";
                  if($resultdepartment = mysqli_query($connect, $sqldepartment)){
                    while ($rowdepartment = $resultdepartment->fetch_assoc()) {
                      $selected = "";
                      if($searchdepartmentid==$rowdepartment["department"]){ $selected = "selected"; }
                      echo "<option value='".$rowdepartment["department"]."' ".$selected.">".$rowdepartment["department_name"]."</option>";
                    }  
                  }
                ?>
              </select>
            </div>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> ค้นหา</button>
            <a href="?option=person&task=person_manage&action=report1_clearsearchtext" class="btn btn-default"><span class="glyphicon glyphicon-list"></span> แสดงทั้งหมด</a>
          </form>
        </div>
      </div>
      <hr>
      <?php
      // Select Book
      if(($searchdepartmentid==999) or ($searchdepartmentid=="")){
        $sqldepartment = "";
      }else{
        $sqldepartment = " and pm.department = ".$searchdepartmentid." ";
      }
      $sql = "  SELECT 
                  * 
                FROM 
                  person_main pm 
                  LEFT JOIN person_position pp ON(pm.position_code=pp.position_code) 
                  LEFT JOIN system_department d ON(pm.department=d.department)
                  LEFT JOIN system_subdepartment sd ON(pm.sub_department=sd.sub_department)
                WHERE 
                  ((pm.person_id like '%$searchtext%') or (pm.name like '%$searchtext%') or (pm.surname like '%$searchtext%') or (pp.position_name like '%$searchtext%'))
                  $sqldepartment     
                ORDER BY 
                  pm.department, pm.sub_department, pm.position_other_code DESC"; 
      $result = mysqli_query($connect, $sql);
      $count = mysqli_num_rows($result);
      $list = 100;  // row per page
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
                  echo "<li $active><a href='?option=person&task=person_report1&page=$x'>$x <span class='sr-only'></span></a></li>"; 
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
            <th>ที่</th>
            <th>ชื่อ-สกุล</th>
            <th>ตำแหน่ง</th>
          	<th>สำนัก</th>
            <th>กลุ่ม</th>
            <th>รูปประจำตัว</th>
       	  </tr>
        </thead>
        <tbody>
          
          <?php
            $sql = "  SELECT 
                  * 
                FROM 
                  person_main pm 
                  LEFT JOIN person_position pp ON(pm.position_code=pp.position_code) 
                  LEFT JOIN system_department d ON(pm.department=d.department)
                  LEFT JOIN system_subdepartment sd ON(pm.sub_department=sd.sub_department)
                WHERE 
                  ((pm.person_id like '%$searchtext%') or (pm.name like '%$searchtext%') or (pm.surname like '%$searchtext%') or (pp.position_name like '%$searchtext%'))
                  $sqldepartment     
                ORDER BY 
                  pm.department, pm.sub_department, pm.position_other_code DESC 
                $limit"; 
            //echo "<div class='well'>$sql</div>";
            $no = 0;
            if ($result = mysqli_query($connect, $sql)) {
              while ($row = $result->fetch_assoc()) {
                ?>
                  <tr>
                    <td><?php echo (($_GET["page"]-1)*$list)+(++$no); ?></td>
                    <td><?php echo $row['prename'].$row['name']." ".$row['surname']; ?></td>
                    <td><?php echo $row['position_name']; ?></td>
                    <td><?php echo $row['department_precis']; ?></td>
                    <td><?php echo $row['sub_department_name']; ?></td>
                    <td>
                        <?php if(file_exists($row["pic"])){ ?>
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal<?php echo $row['person_id']; ?>"><span class="glyphicon glyphicon-picture" aria-hidden="true"></span></button>
                        <div id="myModal<?php echo $row['person_id']; ?>" class="modal fade" tabindex="-1" role="dialog">
                          <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  <h3><?php echo $row['prename'].$row['name']." ".$row['surname']." : ".$row['position_name']; ?></h3>
                                </div>
                                <div class="modal-body">
                                    <img src="<?php echo $row['pic']; ?>" class="img-responsive">
                                </div>
                            </div>
                          </div>
                        </div>
                        <?php } ?>
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
                  echo "<li $active><a href='?option=person&task=person_report1&page=$x'>$x <span class='sr-only'></span></a></li>"; 
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
</body>
</html>