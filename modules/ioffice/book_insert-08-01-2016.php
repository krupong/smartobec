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
      <h3 class="panel-title">เพิ่มบันทึกเสนอ</h3>
    </div>
    <div class="panel-body">
      <form data-toggle="validator" role="form" enctype="multipart/form-data" class="form-horizontal" method="POST" action="?option=ioffice&task=book_manage&action=insert">
        <div class="form-group">
          <label for="bookstatusid" class="col-sm-2 control-label">สถานะบันทึกเสนอ</label>
          <div class="col-sm-3">
            <label class="radio-inline">
              <input type="radio" name="bookstatusid" id="bookstatusid1" value="1" checked><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> ร่าง
            </label>
            <label class="radio-inline">
              <input type="radio" name="bookstatusid" id="bookstatusid2" value="2"><span class='glyphicon glyphicon-share-alt' aria-hidden='true'></span> เสนอ
            </label>
          </div>
        </div>
        <hr>
        <div class="form-group">
          <label for="booktypeid" class="col-sm-2 control-label">ประเภทบันทึกเสนอ</label>
           <div class="col-sm-6">
             <label class="radio-inline">
               <input type="radio" name="booktypeid" id="booktypeid1" value="1" checked> ปกติ
             </label>
             <label class="radio-inline">
               <input type="radio" name="booktypeid" id="booktypeid2" value="2"><span class='glyphicon glyphicon-star' aria-hidden='true'></span> ด่วน
             </label>
             <label class="radio-inline">
               <input type="radio" name="booktypeid" id="booktypeid2" value="3"><span class='glyphicon glyphicon-star' aria-hidden='true'></span><span class='glyphicon glyphicon-star' aria-hidden='true'></span> ด่วนมาก
             </label>
             <label class="radio-inline">
               <input type="radio" name="booktypeid" id="booktypeid2" value="4"><span class='glyphicon glyphicon-star' aria-hidden='true'></span><span class='glyphicon glyphicon-star' aria-hidden='true'></span><span class='glyphicon glyphicon-star' aria-hidden='true'></span> ด่วนที่สุด
             </label>
           </div>
         </div>
        <hr>
        <div class="form-group">
          <label for="bookheader" class="col-sm-2 control-label">เรื่อง</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="bookheader" id="bookheader" placeholder="ส่วนสำหรับพิมพ์ชื่อเรื่อง" required>
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
              if($rowbooklevel[booklevelid]==5) { $selected = "selected"; }else{ $selected = ""; }
              echo  "<option  value ='$rowbooklevel[booklevelid]' $selected>".$rowbooklevel[booklevelname]."</option>" ;
            } 
            ?>
          </select>
          </div>
        </div>
        <div class="form-group">
          <label for="bookdetail" class="col-sm-2 control-label">บันทึก</label>
          <div class="col-sm-10">
            <textarea class="form-control" rows="25" name="bookdetail" id="bookdetail" placeholder="ส่วนสำหรับพิมพ์เนื้อหา"></textarea>
            <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'bookdetail' );
            </script>
          </div>
        </div>
        <div class="form-group">
          <input name="cntrow" type="hidden" id="cntrow" value="0">
          <label for="file" class="col-sm-2 control-label">เอกสารแนบ</label>
            <div class="col-sm-6">
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
            <input type="text" class="form-control" id="post_personname" value="<?php echo $_SESSION['login_prename'].$_SESSION['login_name']." ".$_SESSION['login_surname']; ?>" disabled>
            <input type="hidden" class="form-control" name="post_personid" id="post_personid" value="<?php echo $_SESSION['login_user_id']; ?>">
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