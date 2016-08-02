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
      <h3 class="panel-title">เพิ่มบุคลากร</h3>
    </div>
    <div class="panel-body">
      <form data-toggle="validator" role="form" enctype="multipart/form-data" class="form-horizontal" method="POST" action="?option=person&task=person_manage&page=<?php echo $_GET["page"]; ?>&action=insert">
        <div class="form-group">
          <label for="person_id" class="col-sm-2 control-label">เลขประจำตัวประชาชน</label>
          <div class="col-sm-2">
            <input type="text" class="form-control" name="person_id" id="person_id" placeholder="13 หลัก" required>
          </div>
        </div>
        <hr>
        <div class="form-group">
          <label for="prename" class="col-sm-2 control-label">คำนำหน้าชื่อ</label>
          <div class="col-sm-2">
            <input type="text" class="form-control" name="prename" id="prename" required>
          </div>
        </div>
        <div class="form-group">
          <label for="name" class="col-sm-2 control-label">ชื่อ</label>
          <div class="col-sm-3">
            <input type="text" class="form-control" name="name" id="name" required>
          </div>
        </div>
        <div class="form-group">
          <label for="surname" class="col-sm-2 control-label">สกุล</label>
           <div class="col-sm-3">
            <input type="text" class="form-control" name="surname" id="surname" required>
           </div>
        </div>
        <div class="form-group">
          <label for="position_code" class="col-sm-2 control-label">ตำแหน่ง</label>
          <div class="col-sm-3">
          <select  name='position_code' id='position_code' class='selectpicker show-tick' title='' data-live-search='true'>
            <option value=""></option>
            <?php
            $sqlposition = " SELECT
                              *
                              FROM person_position 
                              ORDER BY position_code ASC";
            $resultposition = mysqli_query($connect, $sqlposition);
            while ($rowposition = $resultposition->fetch_assoc()){
              //if($rowposition[position_code]==5) { $selected = "selected"; }else{ $selected = ""; }
              echo  "<option value ='$rowposition[position_code]' $selected>".$rowposition[position_name]."</option>" ;
            } 
            ?>
          </select>
          </div>
        </div>
        <div class="form-group">
          <label for="person_order" class="col-sm-2 control-label">ลำดับบุคลากรในตำแหน่ง(ถ้ากำหนด)</label>
           <div class="col-sm-1">
            <input type="number" min=0 value="0" class="form-control" name="person_order" id="person_order">
           </div>
        </div>
        <div class="form-group">
          <label for="department" class="col-sm-2 control-label">สำนัก(ถ้ามี)</label>
          <div class="col-sm-5">
          <select  name='department' id='department' class="form-control">
            <option value=""></option>
            <?php
            $sqldepartment = " SELECT
                              *
                              FROM system_department 
                              ORDER BY department_name ASC";
            $resultdepartment = mysqli_query($connect, $sqldepartment);
            while ($rowdepartment = $resultdepartment->fetch_assoc()){
              echo  "<option value ='$rowdepartment[department]' $selected>".$rowdepartment[department_name]."</option>" ;
            } 
            ?>
          </select>
          </div>
        </div>
        <div class="form-group">
          <label for="sub_department" class="col-sm-2 control-label">กลุ่ม(ถ้ามี)</label>
          <div class="col-sm-5">
          <select  name='sub_department' id='sub_department' class="form-control">
            <option value=""></option>
            <?php
            $sqlsubdepartment = " SELECT
                              *
                              FROM system_subdepartment 
                              ORDER BY sub_department_name ASC";
            $resultsubdepartment = mysqli_query($connect, $sqlsubdepartment);
            while ($rowsubdepartment = $resultsubdepartment->fetch_assoc()){
              echo  "<option value ='$rowsubdepartment[sub_department]' $selected>".$rowsubdepartment[sub_department_name]."</option>" ;
            } 
            ?>
          </select>
          </div>
        </div>
        <div class="form-group">
          <label for="position_other_code" class="col-sm-2 control-label">ตำแหน่งอื่น(ถ้ามี)</label>
          <div class="col-sm-5">
            <div class="checkbox">
              <label>
                <input name="position_other_code1" id="position_other_code1" type="checkbox" value="1">รองผู้อำนวยการสำนัก&nbsp;
              </label>
              <label>
                <input name="position_other_code2" id="position_other_code2" type="checkbox" value="1">หัวหน้ากลุ่ม
              </label>
            </div>
          </div>
        </div>
        <div class="form-group">
          <input name="cntrow" type="hidden" id="cntrow" value="0">
          <label for="file" class="col-sm-2 control-label">รูปประจำตัว jpg หรือ png</label>
            <div class="col-sm-6">
              <table border="0" cellspacing="0" cellpadding="0" id="myTable">
                <tr>
                  <td width="60%"><input class="form-control" name="UploadedFile[]" type="file" class="BrowsFile" id="UploadedFile" size="55"></td>
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
            <button type="submit" class="btn btn-primary" name="insert" id="insert" value="insert"><span class="glyphicon glyphicon-ok"></span>&nbsp;บันทึก</button>&nbsp;<button type="submit" class="btn btn-default" onClick="history.go(-1);return true;"><span class="glyphicon glyphicon-remove"></span>&nbsp;ยกเลิก</button>
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
        url: "modules/person/return_ajax_sub_department.php", 
        data:"department="+$(this).val(),
        async: false
      }).responseText;    
      $("select#sub_department").html(datalist2);
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