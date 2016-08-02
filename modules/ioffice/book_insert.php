<?php 
include("permission.php");
?>

<!-- About Me Box -->
<div class="box box-primary">
  <div class="box-header with-border">
    <h4 class="box-title">เขียนบันทึกข้อความ</h4>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
      <form data-toggle="validator" role="form" enctype="multipart/form-data" class="form-horizontal" method="POST" action="?option=ioffice&task=book_manage&action=insert">
        <div class="form-group">
          <label for="booktypeid" class="col-sm-2 control-label">ชั้นความเร็ว</label>
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
        <!--<hr>-->
        <div class="form-group">
          <label for="bookheader" class="col-sm-2 control-label">เรื่อง</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="bookheader" id="bookheader" placeholder="ส่วนสำหรับพิมพ์ชื่อเรื่อง" required>
          </div>
        </div>
        <div class="form-group">
          <label for="receive_personid" class="col-sm-2 control-label">เรียน</label>
          <div class="col-sm-6">
          <select  name='receive_personid' id='receive_personid' class='form-control selectpicker show-tick' title='' data-live-search='true'>
            <?php
            $sql_person = "SELECT * FROM person_main pm LEFT JOIN person_position pp ON(pm.position_code=pp.position_code) LEFT JOIN system_department sd ON(pm.department=sd.department) WHERE pm.`status`=0 and pm.position_code<=11 ORDER BY pm.position_code ASC";
            echo "<div class='well'>".$sql_person."</div>";
            $result_person = mysqli_query($connect, $sql_person);
            while ($row_person = $result_person->fetch_assoc()){
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
            <textarea class="form-control" rows="25" name="bookdetail" id="bookdetail" placeholder="ส่วนสำหรับพิมพ์เนื้อหา"></textarea>
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
              <select  name='department' id='department' class='form-control'>
                <option value="">เลือกสำนัก</option>
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
              <select  name='sub_department' id='sub_department' class='form-control'>
                <option value="">เลือกกลุ่ม</option>
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
              <select  name='person' id='person' class='form-control' required>
                <option value="">เลือกบุคลากร</option>
                <?php
                $sql_comment_personid = "select ib.comment_personid,pm.prename,pm.`name`,pm.surname from ioffice_book ib left join person_main pm on(ib.comment_personid=pm.person_id) where ib.post_personid='".$_SESSION['login_user_id']."' order by ib.updatedate desc limit 1";
                $result_comment_personid = mysqli_query($connect, $sql_comment_personid);
                while ($row_comment_personid = $result_comment_personid->fetch_assoc()){
                  echo  "<option  value ='$row_comment_personid[comment_personid]' selected>".$row_comment_personid[prename].$row_comment_personid[name]." ".$row_comment_personid[surname]."</option>" ;
                } 
                ?>
              </select>
            </p>
          </div>
        </div>
        <div class="form-group">
          <input name="cntrow" type="hidden" id="cntrow" value="0">
          <label for="file" class="col-sm-2 control-label">เอกสารแนบ</label>
            <div class="col-sm-6">
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
          <div class="col-sm-4">
            <input type="text" class="form-control" id="post_personname" value="<?php echo $_SESSION['login_prename'].$_SESSION['login_name']." ".$_SESSION['login_surname']; ?>" disabled>
            <input type="hidden" class="form-control" name="post_personid" id="post_personid" value="<?php echo $_SESSION['login_user_id']; ?>">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-9">
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

/*
$(document).ready(function() {
  $("select").searchable({
    maxListSize: 100,           // if list size are less than maxListSize, show them all
    maxMultiMatch: 50,            // how many matching entries should be displayed
    exactMatch: false,            // Exact matching on search
    wildcards: true,            // Support for wildcard characters (*, ?)
    ignoreCase: true,           // Ignore case sensitivity
    latency: 200,             // how many millis to wait until starting search
    warnMultiMatch: 'top {0} matches ...',  // string to append to a list of entries cut short by maxMultiMatch 
    warnNoMatch: 'no matches ...',      // string to show in the list when no entries match
    zIndex: 'auto'              // zIndex for elements generated by this plugin
    });
});
*/

</script>
<!-- Validate Form-->