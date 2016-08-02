<?php

//header("content-type:text/javascript;charset=utf-8");   
if(isset($_SESSION['role_id'])){
$user_role_id=mysqli_real_escape_string($connect,$_SESSION['role_id']);
}else {$user_role_id=""; 
?>
<script langquage='javascript'>
window.location="?option=book2&task=main/roleperson";
</script>
<?php
}

include 'database_connect.php'; 
include './modules/book2/main/function.php'; 
$inputbookwoshow="";
//โชว์วันที่วันนี้
$today=date("d-m-Y");
$todaydatetime=date("Y-m-d H:i:s");

//$inputusername=$_SESSION['login_user_id'];;
        
//ตรวจสอบการ นำเข้าข้อมูล
if(isset($_POST['inputprocess'])){
$inputprocess=mysqli_real_escape_string($connect,$_POST['inputprocess']);
}else {$inputprocess=""; header("location:../../../index.php");}

//ประเภทของการ query
if(isset($_POST['inputpermistype'])){
$inputpermistype=mysqli_real_escape_string($connect,$_POST['inputpermistype']);
}else {$inputpermistype=""; echo "ท่านไม่มีสิทธิ์การเข้าใช้งานในส่วนนี้";}


//คำนวณ
    if($inputpermistype=="addbook"){

        
        //นำเข้าหน่วยงาน ที่จะส่ง
if(isset($_POST['booklevel'])){
$inputbooklevel=mysqli_real_escape_string($connect,$_POST['booklevel']);
}else {$inputbooklevel=""; }
//echo $inputbooklevel;
//นำเข้าผู้ส่ง
if(isset($_POST['inputsender'])){
$inputsender=mysqli_real_escape_string($connect,$_POST['inputsender']);
}else {$inputsender=""; }
$inputbookfromofficer=$inputsender;
//echo $inputsender;
//นำเข้าหน่วยงาน ที่จะส่ง
if(isset($_POST['booksecret'])){
$inputbooksecret=mysqli_real_escape_string($connect,$_POST['booksecret']);
}else {$inputbooksecret=""; }
//echo $inputbooksecret;
//นำเข้าหน่วยงาน ที่จะส่ง
if(isset($_POST['booksubject'])){
$inputbooksubject=mysqli_real_escape_string($connect,$_POST['booksubject']);
}else {$inputbooksubject=""; }
//echo $inputbooksubject;
//นำเข้ารายละเอียด
if(isset($_POST['bookdetail'])){
$inputbookdetail=mysqli_real_escape_string($connect,$_POST['bookdetail']);
}else {$inputbookdetail=""; }
//echo $inputbookdetail;
//นำเข้าหน่วยงาน ที่จะส่ง
if(isset($_POST['bookfor'])){
$inputbookfor=mysqli_real_escape_string($connect,$_POST['bookfor']);
}else {$inputbookfor=""; }
//echo $inputbookfor;
//นำเข้าหน่วยงาน ที่จะส่ง ภายนอก
if(isset($_POST['book2other'])){
foreach ($_POST['book2other'] as $book2others){
    $arr_book2other[]=mysqli_real_escape_string($connect,$book2others);
}
$book2other=  implode(",", $arr_book2other);    
}else {$book2other=""; }
//echo $book2other;
//เลข ว
if(isset($_POST['bookwo'])){
$inputbookwo=mysqli_real_escape_string($connect,$_POST['bookwo']);
}else {$inputbookwo=""; }
//echo $inputbookwo;
//นำเข้าหน่วยงานที่ส่ง
if(isset($_POST['bookfrom'])){
$inputbookfrom=mysqli_real_escape_string($connect,$_POST['bookfrom']);
}else {$inputbookfrom=""; }
//echo $inputbookfrom;
//นำเข้าบทบาทผู้ส่ง
if(isset($_POST['bookfromrole'])){
$inputbookfromrole=mysqli_real_escape_string($connect,$_POST['bookfromrole']);
}else {$inputbookfromrole=""; }
//$inputbookfromrole=$inputbookfrom;
//นำเข้าประเภท
if(isset($_POST['booktype'])){
$inputbooktype=mysqli_real_escape_string($connect,$_POST['booktype']);
}else {$inputbooktype=""; }
//echo $inputbooktype;
//นำเข้ารหัสอ้างอิง
if(isset($_POST['bookcomment'])){
$inputbookcomment=mysqli_real_escape_string($connect,$_POST['bookcomment']);
}else {$inputbookcomment=""; }
//echo $inputbookcomment;
//นำเข้าสถานะ
if(isset($_POST['bookstatus'])){
$inputbookstatus=mysqli_real_escape_string($connect,$_POST['bookstatus']);
}else {$inputbookstatus=""; }
//echo $inputbookstatus;
//นำเข้ารหัสอ้างอิง
if(isset($_POST['bookrefid'])){
$inputbookrefid=mysqli_real_escape_string($connect,$_POST['bookrefid']);
}else {$inputbookrefid=""; }
//echo $inputbookrefid;
if(isset($_POST['bookfromorgtb'])){
$inputbookfromorgtb=mysqli_real_escape_string($connect,$_POST['bookfromorgtb']);
}else {$inputbookfromorgtb=""; }


//ตรวจสอบสิทธิ์
$roleid_person=$_SESSION["roleid_person"];
        
        
        
        //$inputbookno        = $_POST['bookno'];       //
        $inputbookdate      = dateinput2db($_POST['bookdate']);   //
        //echo $inputbookdate;
        //$inputofficer           = $_POST['inputofficer'];   //
        $date_time_now = date("Y-m-d H:i:s");
//        $password_real  = sha1($password); // เป็นการเข้ารหัส password แบบ sha1

        if($_POST['inputtoorganize']!=""){
        $inputtoorganize        = $_POST['inputtoorganize'];      //
        //แยกเอาหน่วยงาน
        	$f_inputtoorganize=explode(",", $inputtoorganize);
                        $arr_inputtoorganize=array();
                
                for($i=0;$i<count($f_inputtoorganize);$i++)
                {
                    if(!preg_match("/^_/", $f_inputtoorganize[$i])){
                        $arr_inputtoorganize[]=$f_inputtoorganize[$i];
                    }
                    
                }
                        //print_r($arr_inputmyorganize);
                        $sendtoorg=  implode(",", $arr_inputtoorganize);
        }else{
            $sendtoorg="ไม่มีประโยชน์"; 
            //ออกไปเลย แจ้งเตือนไม่เลือกหน่วยงาน
        }        

    $todayyear=date("Y");
    $booktype="2";  //ประเภทหนังสือ
    //echo    $todayyear;
    //echo $inputbookfrom;
    //echo $todayyear;
      //ประมวลผลเพื่อออกเลข
//    $sql_bookno="select * from book2_no where sa_node_id=? and no_year=? ";
//    $query_bookno = $connect->prepare($sql_bookno);
//    $query_bookno->bind_param("ss", $inputbookfrom,$todayyear);
    $sql_bookno="select * from book2_numbook where typebook_id=? and department_id=? and no_year=? ";
    $query_bookno = $connect->prepare($sql_bookno);
    $query_bookno->bind_param("sss",$booktype, $inputbookfrom,$todayyear);
    $query_bookno->execute();
    $result_qbookno=$query_bookno->get_result();

 While ($result_bookno = mysqli_fetch_array($result_qbookno))
   {
     $bookno=$result_bookno['no_present']+1;
    //echo $bookno;
    //echo $result_bookno['no_present'];
     
   }

    if($inputbookwo==1){
        $inputbookwoshow="ว";
    }
    //นำเข้า เลข ศธ
    $sql_bookcode="select department_code from book2_department_code where department_id=?  and status=1 ";
    $query_bookcode = $connect->prepare($sql_bookcode);
    $query_bookcode->bind_param("s", $inputbookfrom);
    $query_bookcode->execute();
    $result_qbookcode=$query_bookcode->get_result();

 While ($result_bookcode = mysqli_fetch_array($result_qbookcode))
   {
     $inputbookno=$result_bookcode['department_code'].$inputbookwoshow.$bookno;
     
    }
        
     //นำเข้าฐานข้อมูล book2_send   
     $sql_insert = "insert into book2_send (id,sender_id,sender_date,editor_id,editor_date,book_to_department,book_to_other,book_level,book_secret,book_num,book_date,book_subject,book_for,book_detail,book_comment,book_fromdepartment,book_fromrole,book_fromofficer,book_type,book_status,book_refid,book_fromorgtb) values ('',?,?,'','',?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

    if ($dbquery_insert = $connect->prepare($sql_insert)) {
    $dbquery_insert->bind_param("sssssssssssssssssss",$inputsender,$todaydatetime,$sendtoorg,$book2other,$inputbooklevel,$inputbooksecret,$inputbookno,$inputbookdate,$inputbooksubject,$inputbookfor,$inputbookdetail,$inputbookcomment,$inputbookfrom,$inputbookfromrole,$inputbookfromofficer,$inputbooktype,$inputbookstatus,$inputbookrefid,$inputbookfromorgtb);
    $dbquery_insert->execute();
    $result_insert=$dbquery_insert->get_result();
    }
     // อัพเดต เลขล่าสุด
     $sql_noupdate = "update book2_numbook set no_present=? where typebook_id=? and department_id=? and no_year=?  ";
    if ($dbquery_noupdate = $connect->prepare($sql_noupdate)) {
    $dbquery_noupdate->bind_param("ssss",$bookno,$booktype, $inputbookfrom,$todayyear);
    $dbquery_noupdate->execute();
    $result_noupdate=$dbquery_noupdate->get_result();
    }

  //redirect ไปหน้าอื่นๆ
?>

<script langquage='javascript'>
window.location="?option=book2&task=main/send_addbook_wait&id=<?php echo $inputbookrefid;?>";
</script>
   
<?php
    }
?>