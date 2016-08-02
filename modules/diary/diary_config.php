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
  if(($_GET["action"]=="insert") and ($_POST["diary_id"]!="") and ($_POST["diary_name"]!="")){
    $diary_id=$_POST["diary_id"];
    $diary_name=$_POST["diary_name"];
    if($_POST["diary_status"]==1){
      $diary_status=1;
      $sqlinsert="update diary set diary_status=0";
      $resultinsert=mysqli_query($connect,$sqlinsert);
    }else{
      $diary_status=0;
    }
    $sqlinsert="insert into diary(diary_id,diary_name,diary_status) values('$diary_id','$diary_name','$diary_status')";
    //echo "<div class='well'>$sqlinsert</div>";
    $resultinsert=mysqli_query($connect,$sqlinsert);
  }
  if(!isset($_GET["diary"])){ $_GET["diary"]=""; }
  if(($_GET["action"]=="delete") and ($_GET["diary"]!="")){
    $diary_id=$_GET["diary"];
    $sqlinsert="delete from diary where diary_id='$diary_id'";
    //echo "<div class='well'>$sqlinsert</div>";
    $resultinsert=mysqli_query($connect,$sqlinsert);
  }
  if(($_GET["action"]=="open") and ($_GET["diary"]!="")){
    $diary_id=$_GET["diary"];
    $sqlinsert="update diary set diary_status=0";
    //echo "<div class='well'>$sqlinsert</div>";
    $resultinsert=mysqli_query($connect,$sqlinsert);
    $sqlinsert="update diary set diary_status=1 where diary_id='$diary_id'";
    //echo "<div class='well'>$sqlinsert</div>";
    $resultinsert=mysqli_query($connect,$sqlinsert);
  }
  if(($_GET["action"]=="close") and ($_GET["diary"]!="")){
    $diary_id=$_GET["diary"];
    $sqlinsert="update diary set diary_status=0 where diary_id='$diary_id'";
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
    <p><h4 class="box-title">เล่มไดอารี่</h4></p>
      <div class="row">
        <div class="col-md-2 text-left">
          <!-- Modal for Read -->
          <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus"></span> เพิ่มเล่มไดอารี่</a>
          <div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <div class="row">
                    <div class="col-md-12 text-left">
                      <h4>เพิ่มเล่มไดอารี่</h4>
                    </div>
                  </div>
                </div>
                <div class="modal-body">
                  <form data-toggle="validator" role="form" enctype="multipart/form-data" method="POST" action="?option=diary&task=diary_config&action=insert">
                    <div class="form-group">
                      <label for="exampleInputEmail1">รหัสเล่มไดอารี่</label>
                      <input type="text" class="form-control" name="diary_id" placeholder="" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">ชื่อไดอารี่</label>
                      <input type="text" class="form-control" name="diary_name" placeholder="" required>
                    </div>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="diary_status" value="1"> เปิดปรับปรุงไดอารี่
                      </label>
                    </div>
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
            <a href="?option=diary&task=diary_config&clearsearch=1" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="แสดงทั้งหมด"><span class="glyphicon glyphicon-list"></span></a>
          </form>
        </div>
      </div>
  </div>
  <div class="panel-body">
      <?php
      $sql = "SELECT *  
              FROM diary d 
              WHERE ((d.diary_id like '%$searchtext%') or (d.diary_name like '%$searchtext%'))     
              ORDER BY d.diary_id DESC";
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
                  echo "<li $active><a href='?option=diary&task=diary_config&page=$x'>$x <span class='sr-only'></span></a></li>"; 
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
                <th>ชื่อเล่มไดอารี่</th>
                <th>สถานะ</th>
                <th>เปิด</th>
                <th>ปิด</th>
                <th>แก้ไข</th>
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
                        <td><?php echo $row['diary_id']; ?></td>
                        <td><?php echo $row['diary_name']; ?></td>
                        <td><?php if($row['diary_status']==0){ echo "ปิด"; }elseif($row['diary_status']==1){ echo "เปิดปรับปรุงไดอารี่"; }; ?></td>
                        <td><a href="?option=diary&task=diary_config&action=open&diary=<?php echo $row['diary_id']; ?>"><span class="glyphicon glyphicon-folder-open"></span></a></td>     
                        <td><a href="?option=diary&task=diary_config&action=close&diary=<?php echo $row['diary_id']; ?>"><span class="glyphicon glyphicon-folder-close"></span></a></td>     
                        <td><a href="?option=diary&task=diary_config&action=edit&diary=<?php echo $row['diary_id']; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>     
                        <td><a href="?option=diary&task=diary_config&action=delete&diary=<?php echo $row['diary_id']; ?>"><span class="glyphicon glyphicon-trash"></span></a></td>     
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
                  echo "<li $active><a href='?option=diary&task=diary_config&page=$x'>$x <span class='sr-only'></span></a></li>"; 
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