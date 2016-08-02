<?php
  if($_GET["bookid"]){
    $bookid = $_GET["bookid"];
    $sql = "SELECT * FROM ioffice_book ib 
            LEFT JOIN person_main pm ON(ib.post_personid=pm.person_id) 
            WHERE bookid = $bookid";
    if($result = mysqli_query($connect, $sql)) {
      while ($row = $result->fetch_assoc()) {
        $department_bookid = $row["department_bookid"];
        $booktypeid = $row["booktypeid"];
        $bookstatusid = $row["bookstatusid"];
        $bookheader = $row["bookheader"];
        $receive_booklevelid = $row["receive_booklevelid"];
        $bookdetail = $row["bookdetail"];
        $post_personid = $row["post_personid"];
        $post_subdepartmentid = $row["post_subdepartmentid"];
        $post_departmentid = $row["post_departmentid"];
        $postdate = $row["postdate"];
        $updatedate = $row["updatedate"];
        $post_personname = $row["prename"].$row["name"]." ".$row["surname"];
      }
    }
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
      <h3 class="panel-title">แก้ไขบันทึกเสนอ</h3>
    </div>
    <div class="panel-body">
      <form data-toggle="validator" role="form" enctype="multipart/form-data" class="form-horizontal" method="POST" action="?option=ioffice&task=book_manage&action=update">
        <div class="form-group">
          <label for="bookid" class="col-sm-2 control-label">เลขที่ สพฐ.</label>
          <div class="col-sm-2">
            <input type="text" class="form-control" value="<?php echo $bookid; ?>" disabled>
            <input type="hidden" class="form-control" id="bookid" name="bookid" value="<?php echo $bookid; ?>">          
          </div>
        </div>
        <div class="form-group">
          <label for="department_bookid" class="col-sm-2 control-label">เลขที่ สำนัก</label>
          <div class="col-sm-2">
            <input type="text" class="form-control" value="<?php echo $department_bookid; ?>" disabled>
            <input type="hidden" class="form-control" id="department_bookid" name="department_bookid" value="<?php echo $department_bookid; ?>">          
          </div>
        </div>
        <hr>
        <div class="form-group">
          <input type="hidden" id="bookid" name="bookid" value="<?php echo $bookid; ?>">
          <label for="bookstatusid" class="col-sm-2 control-label">สถานะบันทึกเสนอ</label>
          <div class="col-sm-3">
            <label class="radio-inline">
              <input type="radio" name="bookstatusid" id="bookstatusid1" value="1" <?php if($bookstatusid==1)echo "checked"; ?>><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> ร่าง
            </label>
            <label class="radio-inline">
              <input type="radio" name="bookstatusid" id="bookstatusid2" value="2" <?php if($bookstatusid==2)echo "checked"; ?>><span class='glyphicon glyphicon-share-alt' aria-hidden='true'></span> เสนอ
            </label>
            <label class="radio-inline">
              <input type="radio" name="bookstatusid" id="bookstatusid3" value="3" <?php if($bookstatusid==3)echo "checked"; ?>><span class='glyphicon glyphicon-remove' aria-hidden='true'></span> ยกเลิก
            </label>
          </div>
        </div>
        <hr>
        <div class="form-group">
           <label for="booktypeid" class="col-sm-2 control-label">ประเภทบันทึกเสนอ</label>
           <div class="col-sm-6">
             <label class="radio-inline">
                <input type="radio" name="booktypeid" id="booktypeid1" value="1" <?php if($booktypeid==1)echo "checked"; ?>> ปกติ
             </label>
             <label class="radio-inline">
                <input type="radio" name="booktypeid" id="booktypeid2" value="2" <?php if($booktypeid==2)echo "checked"; ?>><span class='glyphicon glyphicon-star' aria-hidden='true'></span> ด่วน
             </label>
             <label class="radio-inline">
                <input type="radio" name="booktypeid" id="booktypeid3" value="3" <?php if($booktypeid==3)echo "checked"; ?>><span class='glyphicon glyphicon-star' aria-hidden='true'></span><span class='glyphicon glyphicon-star' aria-hidden='true'></span> ด่วนมาก
             </label>
             <label class="radio-inline">
                <input type="radio" name="booktypeid" id="booktypeid4" value="4" <?php if($booktypeid==4)echo "checked"; ?>><span class='glyphicon glyphicon-star' aria-hidden='true'></span><span class='glyphicon glyphicon-star' aria-hidden='true'></span><span class='glyphicon glyphicon-star' aria-hidden='true'></span> ด่วนที่สุด
             </label>
           </div>
         </div>
        <hr>
         <div class="form-group">
            <label for="bookheader" class="col-sm-2 control-label">เรื่อง</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="bookheader" id="bookheader" placeholder="ส่วนสำหรับพิมพ์ชื่อเรื่อง" value="<?php echo $bookheader; ?>" required>
          </div>
        </div>
        <div class="form-group">
          <label for="receive_booklevelid" class="col-sm-2 control-label">เรียน</label>
          <div class="col-sm-3">
          <select  name='receive_booklevelid' id='receive_booklevelid' class="form-control">
            <?php
            $sqlbooklevel = " SELECT
                              *
                              FROM ioffice_booklevel 
                              WHERE booklevelid <> 1 
                              ORDER BY booklevelid DESC";
            $resultbooklevel = mysqli_query($connect, $sqlbooklevel);
            while ($rowbooklevel = $resultbooklevel->fetch_assoc()){
              if($rowbooklevel[booklevelid]==$receive_booklevelid) { $selected = "selected"; }else{ $selected = ""; }
              echo  "<option  value ='$rowbooklevel[booklevelid]' $selected>".$rowbooklevel[booklevelname]."</option>" ;
            } 
            ?>
          </select>
          </div>
        </div>
        <div class="form-group">
          <label for="bookdetail" class="col-sm-2 control-label">บันทึก</label>
          <div class="col-sm-10">
            <textarea class="form-control" rows="25" name="bookdetail" id="bookdetail" placeholder="ส่วนสำหรับพิมพ์เนื้อหา"><?php echo $bookdetail; ?></textarea>
            <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'bookdetail' );
            </script>
          </div>
        </div>
        <div class="form-group">
          <input name="cntrow" type="hidden" id="cntrow" value="0">
          <label for="bookdetail" class="col-sm-2 control-label">เอกสารแนบ</label>
          <div class="col-sm-10">
            <?php
            $sql = "SELECT * FROM ioffice_bookfile WHERE bookid=$bookid";
            $result = mysqli_query($connect,$sql);
            $fnum = 0;
            while ($row = $result->fetch_assoc()) {
              echo "<p><a href='?option=ioffice&task=book_manage&action=trashfile&fileid=".$row['fileid']."' class='btn btn-danger' data-toggle='confirmation'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span>&nbsp;ลบ</a>&nbsp;<a href='".$row["filename"]."' class='btn btn-default' target='_blank'><span class='badge badge-sm'>".++$fnum."</span>&nbsp;".$row["filedesc"]."</a></p>";
            }
            ?>
            <table border="0" cellspacing="0" cellpadding="0" id="myTable">
              <tr>
                <td width="60%"><input class="form-control" name="UploadedFile[]" type="file" class="BrowsFile" id="UploadedFile" size="55"></td>
                <td width="40%">&nbsp;<a href="javascript:insRow();" class="btn btn-success"><span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>&nbsp;เพิ่มช่องรับเอกสาร</a></td>
              </tr>
            </table>
          </div>
        </div>
        <hr>
        <div class="form-group">
          <label for="post_personid" class="col-sm-2 control-label">บันทึกโดย</label>
          <div class="col-sm-3">
            <input type="text" class="form-control" id="post_personname" value="<?php echo $post_personname; ?>" disabled>
            <input type="hidden" class="form-control" name="post_personid" id="post_personid" value="<?php echo $post_personid; ?>">
          </div>
        </div>
        <div class="form-group">
          <label for="postdate" class="col-sm-2 control-label">บันทึกเมื่อ</label>
          <div class="col-sm-3">
            <input type="text" class="form-control" id="postdate" value="<?php echo ThaiTimeConvert(strtotime($postdate),"","2"); ?>" disabled>
          </div>
        </div>
        <div class="form-group">
          <label for="updatedate" class="col-sm-2 control-label">แก้ไขเมื่อ</label>
          <div class="col-sm-3">
            <input type="text" class="form-control" id="updatedate" value="<?php if($updatedate)echo ThaiTimeConvert(strtotime($updatedate),"","2"); ?>" disabled>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-6">
            <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span>&nbsp;บันทึก</button>&nbsp;<button type="submit" class="btn btn-default" onClick="history.go(-1);return true;"><span class="glyphicon glyphicon-remove"></span>&nbsp;ยกเลิก</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div> 
</body>
</html>