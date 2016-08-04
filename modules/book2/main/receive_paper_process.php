<?php

//header("content-type:text/javascript;charset=utf-8");   
$userlogin=$_SESSION['login_user_id'];
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
if(isset($_POST['bookstatus'])){
$inputbookstatus=mysqli_real_escape_string($connect,$_POST['bookstatus']);
}else {$inputbookstatus=""; }
if(isset($_POST['inputsender'])){
$inputinputsender=mysqli_real_escape_string($connect,$_POST['inputsender']);
}else {$inputinputsender=""; }
if(isset($_POST['bookfromrole'])){
$inputbookfromrole=mysqli_real_escape_string($connect,$_POST['bookfromrole']);
}else {$inputbookfromrole=""; }
if(isset($_POST['bookfromorgtb'])){
$inputfromorgtb=mysqli_real_escape_string($connect,$_POST['bookfromorgtb']);
}else {$inputfromorgtb=""; }
if(isset($_POST['booktype'])){
$inputbooktype=mysqli_real_escape_string($connect,$_POST['booktype']);
}else {$inputbooktype=""; }
if(isset($_POST['bookrefid'])){
$inputbookrefid=mysqli_real_escape_string($connect,$_POST['bookrefid']);
}else {$inputbookrefid=""; }

$bookfrom_table="PP";
//คำนวณ
    if($inputpermistype=="rcpaperbook"){

        
//นำเข้าเลขหนังสือส่ง
if(isset($_POST['bookno'])){
$inputbookno=mysqli_real_escape_string($connect,$_POST['bookno']);
}else {$inputbookno=""; }
//นำเข้าลำดับชั้นความเร็ว
if(isset($_POST['booklevel'])){
$inputbooklevel=mysqli_real_escape_string($connect,$_POST['booklevel']);
}else {$inputbooklevel=""; }
//นำเข้าลำดับชั้นความลับ
if(isset($_POST['booksecret'])){
$inputbooksecret=mysqli_real_escape_string($connect,$_POST['booksecret']);
}else {$inputbooksecret=""; }
//นำเข้าวันที่หนังสือ
if(isset($_POST['bookdate'])){
$inputbookdate=mysqli_real_escape_string($connect,$_POST['bookdate']);
$inputbookdate=dateinput2db($inputbookdate);   //
}else {$inputbookdate=""; }
//นำเข้าชื่อเรื่องหนังสือ
if(isset($_POST['booksubject'])){
$inputbooksubject=mysqli_real_escape_string($connect,$_POST['booksubject']);
}else {$inputbooksubject=""; }
//นำเข้าเรียน
if(isset($_POST['bookfor'])){
$inputbookfor=mysqli_real_escape_string($connect,$_POST['bookfor']);
}else {$inputbookfor=""; }
//นำเข้าหน่วยงานที่ส่งมา
if(isset($_POST['bookfrom'])){
$inputbookfrom=mysqli_real_escape_string($connect,$_POST['bookfrom']);
}else {$inputbookfrom=""; }
//นำเข้าหมายเหตุ
if(isset($_POST['bookcomment'])){
$inputbookcomment=mysqli_real_escape_string($connect,$_POST['bookcomment']);
}else {$inputbookcomment=""; }

//ตรวจสอบสิทธิ์
$roleid_person=$_SESSION["roleid_person"];
//หาชื่อบทบาทของบุคลากร
    $sql_role_person="select * from book2_roleperson where id=?  ";
    $query_role_person = $connect->prepare($sql_role_person);
    $query_role_person->bind_param("i", $roleid_person);
    $query_role_person->execute();
    $result_qrole_person=$query_role_person->get_result();

    While ($result_role_person = mysqli_fetch_array($result_qrole_person))
   {
        $role_id=$result_role_person['role_id']; 
        $level_dep=$result_role_person['level_dep'];  
        $look_dep_subdep=$result_role_person['look_dep_subdep'];  
        $orgtb=$result_role_person['orgtb']; 
   }
        if($level_dep=='2' || $level_dep=='4' || $level_dep>='6' && $level_dep<='12' ){
            $searchorg="book2_department";
        }else{
            $searchorg="book2_subdepartment";            
        }
//หาชื่อบทบาท
    $sql_role="select * from book2_role  where id=?  ";
    $query_role = $connect->prepare($sql_role);
    $query_role->bind_param("i", $role_id);
    $query_role->execute();
    $result_qrole=$query_role->get_result();
    
    While ($result_role = mysqli_fetch_array($result_qrole))
   {
        $role_id=$result_role['id'];
        $name_role=$result_role['name'];
   }
        
//หาชื่อหน่วยงาน
    $sql_dep="select * from $searchorg  where id=?  ";
    $query_dep = $connect->prepare($sql_dep);
    $query_dep->bind_param("i", $look_dep_subdep);
    $query_dep->execute();
    $result_qdep=$query_dep->get_result();
    
    While ($result_dep = mysqli_fetch_array($result_qdep))
   {
        $name_predepart=$result_dep['nameprecis'];
        $groupcode_depart=$result_dep['groupcode'];
   }
        
        //$inputbookno        = $_POST['bookno'];       //
        $inputbookdate      = dateinput2db($_POST['bookdate']);   //
        //echo $inputbookdate;
        //$inputofficer           = $_POST['inputofficer'];   //
        $date_time_now = date("Y-m-d H:i:s");
//        $password_real  = sha1($password); // เป็นการเข้ารหัส password แบบ sha1


    $todayyear=date("Y");
    $booktype=$inputbooktype;  //ประเภทหนังสือ

    //นำเข้าฐานข้อมูล book2_receive   
     $sql_insert = "insert into book2_receive ("
             . " book_from,book_level,book_secret,book_no,book_date"
             . ",book_subject,book_for,book_comment,book_type,book_status,book_refid"
             . ",officer,officer_department,officer_role,officer_date) values ("
             . "?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    if ($dbquery_insert = $connect->prepare($sql_insert)) {
    $dbquery_insert->bind_param("sssssssssssssss",$inputbookfrom,$inputbooklevel,$inputbooksecret,$inputbookno,$inputbookdate
            ,$inputbooksubject,$inputbookfor,$inputbookcomment,$inputbooktype,$inputbookstatus,$inputbookrefid
            ,$userlogin,$look_dep_subdep,$role_id,$todaydatetime);
    $dbquery_insert->execute();
    $result_insert=$dbquery_insert->get_result();
    }    

    //บันทึกเลขรับ
    $sql_bookno="select * from book2_numbook where typebook_id=? and department_id=? and no_year=? ";
    $query_bookno = $connect->prepare($sql_bookno);
    $query_bookno->bind_param("sss",$booktype, $look_dep_subdep,$todayyear);
    $query_bookno->execute();
    $result_qbookno=$query_bookno->get_result();

 While ($result_bookno = mysqli_fetch_array($result_qbookno))
   {
     $bookno=$result_bookno['no_present']+1;
    }

     // อัพเดต เลขล่าสุด
     $sql_noupdate = "update book2_numbook set no_present=? where typebook_id=? and department_id=? and no_year=?  ";
    if ($dbquery_noupdate = $connect->prepare($sql_noupdate)) {
    $dbquery_noupdate->bind_param("ssss",$bookno,$booktype, $look_dep_subdep,$todayyear);
    $dbquery_noupdate->execute();
    $result_noupdate=$dbquery_noupdate->get_result();
    }
    
        //นำเข้าฐานข้อมูล ส่งเข้า book2_system   
        $sql_insert = "insert into book2_system"
                . " (book_refid,send_year,receiver_group,receiver_department,receiver_officer,receiver_role"
                . ",receiver_date,receiver_no,receiver_year,receiver_status,book_type,book_table)"
                . " values (?,?,?,?,?,?,?,?,?,?,?,?)";

       if ($dbquery_insert = $connect->prepare($sql_insert)) {
       $dbquery_insert->bind_param("ssssssssssss",$inputbookrefid,$todayyear,$groupcode_depart,$look_dep_subdep,$userlogin,$role_id
               ,$todaydatetime,$bookno,$todayyear,$inputbookstatus,$booktype,$bookfrom_table);
       $dbquery_insert->execute();
       $result_insert=$dbquery_insert->get_result();
       }

    
  //redirect ไปหน้าอื่นๆ
?>

<script langquage='javascript'>
window.location="?option=book2&task=main/receive_newbook_wait";
</script>
 
 OK!!!
<?php
$inputprocess="";
    }
?>