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
  if($_POST["txtKhetTypeID"]){
    switch ($_POST["txtKhetTypeID"]) {
      case '999':
        $txtKhetTypeID = 999;
        unset($_SESSION["txtKhetTypeID"]);
        break;
      default:
        $txtKhetTypeID = $_POST["txtKhetTypeID"];
        $_SESSION["txtKhetTypeID"] = $_POST["txtKhetTypeID"];
        break;
    }
  }else{
    $txtKhetTypeID = $_SESSION["txtKhetTypeID"];
  }
  // file upload
  if($_GET["action"]="upload"){
    if(!isset($_POST["khet_code"])){ $_POST["khet_code"]=""; }
    $khet_code = $_POST["khet_code"];
    if(!isset($_POST["khet_nameeng"])){ $_POST["khet_nameeng"]=""; }
    $khet_nameeng = $_POST["khet_nameeng"];
    // Upload File
    // select path
    $sql = "SELECT * FROM diary WHERE diary_status=1";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($result);
    $target_dir = "./upload/diary/".$row["diary_id"]."/";
    if (!file_exists($target_dir)) {
      mkdir($target_dir, 0777, true);
    }
    $file_no = 0;
    if(empty($_FILES['UploadedFile']['tmp_name'])){$_FILES['UploadedFile']['tmp_name']="";}
    for($j=0;$j<count($_FILES['UploadedFile']['tmp_name']);$j++) {
      if(!empty($_FILES['UploadedFile']['tmp_name'][$j])) {
        //++$file_no;
        $target_file = $target_dir . basename($_FILES["UploadedFile"]["name"][$j]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        //$fnum = $row["countfile"]+1;
        $rename_file_utf = $target_dir . $row["diary_id"] . '-' . $khet_nameeng . '.' . strtolower($imageFileType);
        $rename_file = $target_dir . $row["diary_id"] . '-' . $khet_nameeng . '.' . strtolower($imageFileType);
        //$rename_file = iconv("UTF-8", "TIS-620", $rename_file);
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["UploadedFile"]["tmp_name"][$j]);
            if($check !== false) {
                //echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                //echo "File is not an image.";
                $uploadOk = 0;
            }
        }
        // Check if file already exists
        if (file_exists($rename_file)) {
            //echo "Sorry, file already exists.";
            @unlink($rename_file);
            //$uploadOk = 0;
        }
        // Check file size
        if(empty($_FILES["fileToUpload"]["size"][$j])){$_FILES["fileToUpload"]["size"][$j]=0;}
        if ($_FILES["fileToUpload"]["size"][$j] > 500000) {
            //echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        $imageFileType = strtolower($imageFileType);
        if($imageFileType != "xls" && $imageFileType != "xlsx") {
            //echo "Sorry, files type are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            //echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            
            if (move_uploaded_file($_FILES["UploadedFile"]["tmp_name"][$j], $rename_file)) {
                //echo "The file ". basename( $_FILES["UploadedFile"]["name"][$j]). " has been uploaded.";
                $sql = "DELETE FROM diary_file WHERE diary_id=".$row["diary_id"]." and khet_code='".$khet_code."'";
                //echo "<div class='well'>".$sql."</div>";
                $result = mysqli_query($connect,$sql);
                $sql = "INSERT INTO diary_file(diary_filename,diary_filepath,diary_filedate,diary_id,khet_code,person_id) VALUE('". $row["diary_id"] . '-' . $khet_nameeng . '.' . strtolower($imageFileType)."','$rename_file_utf',NOW(),".$row["diary_id"].",'$khet_code','".$_SESSION["login_user_id"]."')";
                //echo "<div class='well'>".$sql."</div>";
                $result = mysqli_query($connect,$sql);
            } else {
                //echo "Sorry, there was an error uploading your file.";
            }
        }
      }//if
    }//for
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
      <h3 class="panel-title">บันทึกไดอารี่</h3>
    </div>
    <div class="panel-body">
      <?php if($_SESSION["login_group"]==1){ ?> <!-- เริ่มฟอร์มค้นหาข้อมูล -->
      <div class="row">
        <div class="col-md-2 text-left">
          <!-- <a href="?option=diary&task=diary_insert&page=<?php echo $_GET["page"]; ?>" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>&nbsp;เพิ่มบุคลากร</a> -->
        
        </div>
        <div class="col-md-10 text-right">
          <form class="form-inline" action="#" enctype="multipart/form-data" method="POST" >
            <div class="form-group">
              <label for="searchtext"></label>
              <input type="text" class="form-control" id="searchtext" name="searchtext" placeholder="พิมพ์คำค้นหา" value="<?php echo $searchtext; ?>">
            </div>
            <div class="form-group">
              <select class="form-control" name="txtKhetTypeID" >
                <option value="999" <?php if($txtKhetTypeID==0){ echo "selected"; } ?>>ทุกกลุ่ม</option>
                <option value="1" <?php if($txtKhetTypeID==1){ echo "selected"; } ?>>สพป.</option>
                <option value="2" <?php if($txtKhetTypeID==2){ echo "selected"; } ?>>สพม.</option>
              </select>
            </div>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> ค้นหา</button>
            <a href="?option=diary&task=diary&clearsearch=1" class="btn btn-default"><span class="glyphicon glyphicon-list"></span> แสดงทั้งหมด</a>
          </form>
        </div>
      </div>
      <hr>
      <?php } ?> <!-- จบฟอร์มค้นหาข้อมูล -->
      <?php
      // Select Book
      if(($txtKhetTypeID==999) or ($txtKhetTypeID=="")){
        $sqlkhettype = "";
      }else{
        $sqlkhettype = " and sk.khet_type = ".$txtKhetTypeID." ";
      }
      $where_khetcode="";
      if($_SESSION["login_group"]==2){
        $sqlkhetcode="select * from person_khet_main where person_id='".$_SESSION["login_user_id"]."'";
        $resultkhetcode=mysqli_query($connect,$sqlkhetcode);
        $rowkhetcode=$resultkhetcode->fetch_assoc();
        $where_khetcode=" and sk.khet_code='".$rowkhetcode["khet_code"]."'";
      }
      //if($sqlkhettype!=""){ $where_khetcode=" and ".$where_khetcode; }
      $sql = "SELECT * FROM system_khet sk 
              WHERE ((sk.khet_code like '%$searchtext%') or (sk.khet_precis like '%$searchtext%') or (sk.khet_type like '%$searchtext%'))
              $sqlkhettype $where_khetcode     
              ORDER BY sk.khet_precis ASC";
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
                  echo "<li $active><a href='?option=diary&task=diary&page=$x'>$x <span class='sr-only'></span></a></li>"; 
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
                <th>ชื่อหน่วยงาน</th>
                <th>กลุ่มหน่วยงาน</th>
                <th>ส่งข้อมูลล่าสุดเมื่อ</th>
                <th>จัดการข้อมูล</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $sql = $sql." ".$limit; 
                //echo "<div class='well'>$sql</div>";
                $no = 0;
                if ($result = mysqli_query($connect, $sql)) {
                  while ($row = $result->fetch_assoc()) {
                    $sqlfile = "SELECT * FROM diary_file WHERE diary_id=(SELECT max(diary_id) FROM diary WHERE diary_status=1) and khet_code='".$row["khet_code"]."'";
                    $resultfile = mysqli_query($connect,$sqlfile);
                    $rowfile = $resultfile->fetch_assoc();
                    if($rowfile['diary_filedate']!=""){ $tr_class="class='success'"; }else{ $tr_class="class='danger'"; }
                    ?>
                      <tr <?php echo $tr_class; ?>>
                        <td><?php echo (($_GET["page"]-1)*$list)+(++$no); ?></td>
                        <td><?php echo $row['khet_code']; ?></td>
                        <td><?php echo $row['khet_precis']; ?></td>
                        <td><?php if($row['khet_type']==1){echo "สพป.";}elseif($row['khet_type']==2){echo "สพม.";} ?></td>
                        <td>
                          <?php
                          if($rowfile['diary_filedate']!=""){
                            echo "<a href='".$rowfile["diary_filepath"]."'><span class='glyphicon glyphicon-save'></span></a> ".ThaiTimeConvert(strtotime($rowfile['diary_filedate']),"","2"); 
                          }else{
                            echo "ยังไม่ส่ง";
                          }
                          ?>
                        </td>
                        <td>
                          <!-- Modal for Read -->
                          <a href="#" data-toggle="modal" data-target="#myModal<?php echo $row['khet_code']; ?>"><span class="glyphicon glyphicon-paperclip"></span></a>
                          <div class="modal fade bs-example-modal-lg" id="myModal<?php echo $row['khet_code']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  <div class="row">
                                    <div class="col-md-12 text-left">
                                      <h4><?php echo $row["khet_precis"]; ?></h4>
                                    </div>
                                  </div>
                                </div>
                                <div class="modal-body">
                                  <h4>รายการไดอารี่</h4>
                                  <table class="table table-hover table-striped table-condensed table-responsive">
                                    <thead>                                  
                                      <th>ลำดับที่</th>
                                      <th>เล่มไดอารี่</th>
                                      <th>ชื่อไฟล์</th>
                                      <th>เมื่อ</th>
                                      <th>ผู้ส่งข้อมูล</th>
                                      <th>ดาวน์โหลด</th>
                                    </thead> 
                                    <tbody>
                                      <?php
                                        $sqlsubdata = "SELECT df.*,d.diary_name FROM diary_file df LEFT JOIN diary d ON(df.diary_id=d.diary_id) WHERE df.khet_code = '".$row["khet_code"]."' ORDER BY df.diary_id DESC";
                                        //echo $sqlsubdata;
                                        if($resultsubdata = mysqli_query($connect, $sqlsubdata)){
                                          $subdatanum = 0;
                                          while ($rowsubdata = $resultsubdata->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>".++$subdatanum."</td>";
                                            echo "<td>".$rowsubdata["diary_name"]."</td>";
                                            echo "<td>".$rowsubdata["diary_filename"]."</td>";
                                            echo "<td>".ThaiTimeConvert(strtotime($rowsubdata['diary_filedate']),"","2")."</td>";
                                            if($rowsubdata["person_id"]!=""){
                                              $sqlperson="select * from person_main where person_id='".$rowsubdata["person_id"]."'";
                                              $resultperson=mysqli_query($connect,$sqlperson);
                                              $resultpersonnum=mysqli_num_rows($resultperson);
                                              if($resultpersonnum==1){
                                                $rowperson=$resultperson->fetch_assoc();
                                                echo "<td>".$rowperson["prename"].$rowperson["name"]." ".$rowperson["surname"]."</td>";
                                              }else{
                                                $sqlperson="select * from person_khet_main where person_id='".$rowsubdata["person_id"]."'";
                                                $resultperson=mysqli_query($connect,$sqlperson);
                                                $resultpersonnum=mysqli_num_rows($resultperson);
                                                if($resultpersonnum==1){
                                                  $rowperson=$resultperson->fetch_assoc();
                                                  echo "<td>".$rowperson["prename"].$rowperson["name"]." ".$rowperson["surname"]."</td>";
                                                }
                                              }
                                            }else{
                                              echo "<td>-</td>";
                                            }
                                            echo "<td><a href='".$rowsubdata["diary_filepath"]."'><span class='glyphicon glyphicon-save'></span></a></td>";
                                            echo "</tr>";
                                          }
                                        }
                                      ?>
                                    </tbody>                                 
                                  </table>
                                  <?php 
                                  $sqlopen="select * from diary where diary_status=1"; 
                                  $resultopen = mysqli_query($connect,$sqlopen);
                                  $resultopennum = mysqli_num_rows($resultopen);
                                  if($resultopennum==1){
                                  ?>
                                  <hr>
                                  <h4>ส่งข้อมูลไดอารี่</h4>
                                  <form data-toggle="validator" role="form" enctype="multipart/form-data" method="POST" action="?option=diary&task=diary&action=upload">
                                    <div class="form-group">
                                      <label for="exampleInputFile">เลือกไฟล์</label>
                                      <input type="file" name="UploadedFile[]" id="UploadedFile[]" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
                                      <input type="hidden" name="khet_code" value="<?php echo $row["khet_code"]; ?>">
                                      <input type="hidden" name="khet_nameeng" value="<?php echo $row["khet_nameeng"]; ?>">
                                      <p class="help-block">ไฟล์ excel เท่านั้น</p>
                                    </div>
                                    <button type="submit" class="btn btn-default"><span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span>&nbsp;บันทึก</button>
                                  </form>
                                  <?php } ?>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span>&nbsp;ปิด</button>
                                </div>
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
                  echo "<li $active><a href='?option=diary&task=diary&page=$x'>$x <span class='sr-only'></span></a></li>"; 
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