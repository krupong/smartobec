<?php
  // Define Variable
  if(!isset($_POST["searchtext"])){ $_POST["searchtext"]=""; }
  if(!isset($_POST["txtKhetTypeID"])){ $_POST["txtKhetTypeID"]=""; }
  if(!isset($_SESSION["searchtext"])){ $_SESSION["searchtext"]=""; }
  if(!isset($_SESSION["txtKhetTypeID"])){ $_SESSION["txtKhetTypeID"]=""; }
  if(!isset($_GET["clearsearch"])){ $_GET["clearsearch"]=""; }
  // Search Condition
  if($_GET["clearsearch"]=='1'){
    //$_POST["searchtext"]="";
    //$_POST["txtKhetTypeID"]="";
    $_SESSION["searchtext"]="";
    $_SESSION["txtKhetTypeID"]="";
  }
  if($_POST["searchtext"]){
    $searchtext = $_POST["searchtext"];
    $_SESSION["searchtext"] = $_POST["searchtext"];
  }else{
    $searchtext = $_SESSION["searchtext"];
  }

  // insert permission
  if(!isset($_GET["action"])){ $_GET["action"]=""; }
  if(!isset($_POST["person"])){ $_POST["person"]=""; }
  if(($_GET["action"]=="insert") and ($_POST["person"]!="")){
    $person_id=$_POST["person"];
    $sqlinsert="insert into diary_permission(person_id,officer,permissiondate) values('$person_id','".$_SESSION['login_user_id']."',now())";
    //echo "<div class='well'>$sqlinsert</div>";
    $resultinsert=mysqli_query($connect,$sqlinsert);
  }
  if(!isset($_GET["person"])){ $_GET["person"]=""; }
  if(($_GET["action"]=="delete") and ($_GET["person"]!="")){
    $person_id=$_GET["person"];
    $sqlinsert="delete from diary_permission where person_id='$person_id'";
    //echo "<div class='well'>$sqlinsert</div>";
    $resultinsert=mysqli_query($connect,$sqlinsert);
  }
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<div class="box box-primary">
  <div class="box-header with-border">
    <p><h4 class="box-title">เจ้าหน้าที่ไดอารี่</h4></p>
    <div class="row">
        <div class="col-md-2 text-left">
          <!-- Modal for Read -->
          <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus"></span> เพิ่มเจ้าหน้าที่</a>
          <div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <div class="row">
                    <div class="col-md-12 text-left">
                      <h4>เพิ่มเจ้าหน้าที่</h4>
                    </div>
                  </div>
                </div>
                <div class="modal-body">
                  <form data-toggle="validator" role="form" enctype="multipart/form-data" class="form-horizontal" method="POST" action="?option=diary&task=diary_permission&action=insert">
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
                      <select  name='person' id='person' class="form-control" required>
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
                    <button type="submit" class="btn btn-default"><span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span>&nbsp;บันทึก</button>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span>&nbsp;ปิด</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-10 text-right">
          <form class="form-inline" action="#" enctype="multipart/form-data" method="POST" >
            <div class="form-group">
              <label for="searchtext"></label>
              <input type="text" class="form-control" id="searchtext" name="searchtext" placeholder="พิมพ์คำค้นหา" value="<?php echo $searchtext; ?>">
            </div>
            <button type="submit" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="ค้นหา"><span class="glyphicon glyphicon-search"></span></button>
            <a href="?option=diary&task=diary_permission&clearsearch=1" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="แสดงทั้งหมด"><span class="glyphicon glyphicon-list"></span></a>
          </form>
        </div>
    </div>
  </div>
  <div class="panel-body">
      <?php
      $sql = "SELECT dp.*,pm.prename,pm.name,pm.surname,sd.department_name  
              FROM diary_permission dp left join person_main pm on(dp.person_id=pm.person_id) 
              left join system_department sd on(pm.department=sd.department) 
              WHERE ((pm.name like '%$searchtext%') or (pm.surname like '%$searchtext%'))     
              ORDER BY pm.name ASC";
      //echo "<div class='well'>$sql</div>"; 
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
                  echo "<li $active><a href='?option=diary&task=diary_permission&page=$x'>$x <span class='sr-only'></span></a></li>"; 
                }
              ?>
            </ul>
          </nav>
        </div>
      </div>
      <?php 
      } 
      ?>
      <div class="row">
        <div class="col-md-12">
          <table class="table table-hover table-striped table-condensed table-responsive table-bordered">
            <thead>
              <tr>
                <th>ที่</th>
                <th>รหัส</th>
                <th>ชื่อเจ้าหน้าที่</th>
                <th>สำนัก</th>
                <th>วันที่</th>
                <th>ลบ</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $sql = $sql." ".$limit; 
                //echo "<div class='well'>$sql</div>";
                $no = 0;
                if ($result = mysqli_query($connect, $sql)) {
                  while ($row = $result->fetch_assoc()) {
                    ?>
                      <tr>
                        <td><?php echo (($_GET["page"]-1)*$list)+(++$no); ?></td>
                        <td><?php echo $row['person_id']; ?></td>
                        <td><?php echo $row['prename'].$row['name']." ".$row['surname']; ?></td>
                        <td><?php echo $row['department_name']; ?></td>
                        <td><?php if($row["permissiondate"]){echo ThaiTimeConvert(strtotime($row['permissiondate']),"","2");} ?></td>
                        <td><a href="?option=diary&task=diary_permission&action=delete&person=<?php echo $row['person_id']; ?>"><span class="glyphicon glyphicon-trash"></span></a></td>     
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
                  echo "<li $active><a href='?option=diary&task=diary_permission&page=$x'>$x <span class='sr-only'></span></a></li>"; 
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

</body>
</html>