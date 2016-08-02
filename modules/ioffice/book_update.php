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
        $receive_personid = $row["receive_personid"];
        $bookdetail = $row["bookdetail"];
        $post_personid = $row["post_personid"];
        $comment_personid = $row["comment_personid"];
        $post_subdepartmentid = $row["post_subdepartmentid"];
        $post_departmentid = $row["post_departmentid"];
        $postdate = $row["postdate"];
        $updatedate = $row["updatedate"];
        $post_personname = $row["prename"].$row["name"]." ".$row["surname"];
      }
    }
  }
?>

<!-- About Me Box -->
<div class="box box-primary">
  <div class="box-header with-border">
    <h4 class="box-title">แก้ไขบันทึกข้อความ</h4>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
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
           <label for="booktypeid" class="col-sm-2 control-label">ชั้นความเร็ว</label>
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
        <!--<hr>-->
         <div class="form-group">
            <label for="bookheader" class="col-sm-2 control-label">เรื่อง</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="bookheader" id="bookheader" placeholder="ส่วนสำหรับพิมพ์ชื่อเรื่อง" value="<?php echo $bookheader; ?>" required>
          </div>
        </div>
        <div class="form-group">
          <label for="receive_booklevelid" class="col-sm-2 control-label">เรียน</label>
          <div class="col-sm-6">
          <select  name='receive_personid' id='receive_personid' class='form-control selectpicker show-tick' title='' data-live-search='true'>
            <?php
            $sql_person = "SELECT * FROM person_main pm LEFT JOIN person_position pp ON(pm.position_code=pp.position_code) LEFT JOIN system_department sd ON(pm.department=sd.department) WHERE pm.`status`=0 and pm.position_code<=11 ORDER BY pm.position_code ASC";
            $result_person = mysqli_query($connect, $sql_person);
            while ($row_person = $result_person->fetch_assoc()){
              if($row_person[person_id]==$receive_personid) { $selected = "selected"; }else{ $selected = ""; }
              if($row_person[department_precis]==""){
                echo  "<option  value ='$row_person[person_id]' $selected>".$row_person[position_name].' : '.$row_person[prename].$row_person[name].' '.$row_person[surname]."</option>" ;
              }else{                
                echo  "<option  value ='$row_person[person_id]' $selected>".$row_person[position_name].'('.$row_person[department_precis].') : '.$row_person[prename].$row_person[name].' '.$row_person[surname]."</option>" ;
              }
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
        <div class='form-group'>
          <label for="bookheader" class="col-sm-2 control-label">เสนอ</label>
          <div class="col-sm-10">
            <span class="badge">1</span> กรณีต้องการผ่านเรื่องไปที่ ผอ.กลุ่ม หรือบุคลากรในกลุ่ม เลือกสำนัก -> เลือกกลุ่ม -> และเลือกบุคลากร<br/><span class="badge">2</span> กรณีต้องการผ่านเรื่องไปที่ ผอ.สำนัก เลือกสำนัก -> และเลือกบุคลากร (เรื่องจะไม่ผ่าน ผอ.กลุ่ม)<br/><span class="badge">3</span> กรณีต้องการผ่านเรื่องไปที่ ผู้บริหาร(เลขาฯ/รองเลขาฯ/ผู้ช่วยเลขาฯ/ที่ปรึกษา/ผู้เชี่ยวชาญ) เลือกสำนักผู้บริหารระดับสูง -> และเลือกบุคลากร<br/>* บุคลากรทั่วไปโดยปกติแล้วผ่านเรื่องไปที่ ผอ.กลุ่ม
          </div>
        </div>
        <div class='form-group'>
          <label for="bookheader" class="col-sm-2 control-label"></label>
          <div class="col-sm-6">
            <p>
              <select  name='department' id='department' class="form-control">
                <option  value = ''>เลือกสำนัก</option>"
                <?php
                $sqldepartment = "select * from  system_department order by department_name";
                $resultdepartment = mysqli_query($connect, $sqldepartment);
                echo  "<option  value ='-1'>ผู้บริหารระดับสูง</option>" ; 
                echo  "<option  value ='0'>ไม่สังกัดสำนัก</option>" ; 
                while ($rowdepartment = $resultdepartment->fetch_assoc()){
                  echo  "<option  value ='$rowdepartment[department]'>$rowdepartment[department_name]</option>" ;
                } 
                ?>
              </select>
            </p>
            <p>
              <select  name='sub_department' id='sub_department' class="form-control">
                <option  value = ''>เลือกกลุ่ม</option>"
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
                <option  value = ''>เลือกบุคลากร</option>"
                <?php
                $sqlperson = "select * from  person_main where person_id='".$comment_personid."'";
                $resultperson = mysqli_query($connect, $sqlperson);
                while ($rowperson = $resultperson->fetch_assoc()){
                  echo  "<option  value ='$rowperson[person_id]'>".$rowperson[prename].$rowperson[name]." ".$rowperson[surname]."</option>" ;
                } 
                ?>
              </select>
            </p>
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
                <td width="40%">&nbsp;<a href="javascript:insRow();" class="btn btn-success"><span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>&nbsp;เพิ่มเอกสาร</a></td>
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
          <div class="col-sm-offset-2 col-sm-10">
            <?php 
              $sql_person = "select * from person_main where person_id = '".$_SESSION["login_user_id"]."'";
              if($result_person = mysqli_query($connect, $sql_person)) {
                $row_person = $result_person->fetch_assoc();
                $position_code = $row_person["position_code"];
              }else{
                $position_code = "99999";
              }
              if($position_code<=11){ //ตำแหน่งที่อนุมัติเองได้ 
            ?> 
            <button type="submit" name="bookstatusid" value="20" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span>&nbsp;บันทึก(อนุมัติ)</button>&nbsp;
            <?php } ?>
            <button type="submit" name="bookstatusid" value="2" class="btn btn-primary">
            <span class="glyphicon glyphicon-ok"></span>&nbsp;บันทึก(พร้อมเสนอ)</button>&nbsp;
            <button type="submit" name="bookstatusid" value="1" class="btn btn-primary">
            <span class="glyphicon glyphicon-pencil"></span>&nbsp;บันทึก(ฉบับร่าง)</button>&nbsp;
            <button type="submit" name="bookstatusid" value="3" class="btn btn-danger">
            <span class="glyphicon glyphicon-remove"></span>&nbsp;ดึงเรื่องกลับ</button>&nbsp;
            <button type="submit"class="btn btn-default" onClick="history.go(-1);return true;" ><span class="glyphicon glyphicon-remove"></span>&nbsp;ยกเลิก</button>
          </div>
        </div>
      </form>
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