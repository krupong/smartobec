<?php

//header("content-type:text/javascript;charset=utf-8");   

include 'amssplus_connect.php'; 

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
//echo $inputbookfromrole;
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
        
        $inputbookno        = $_POST['bookno'];       //
        $inputbookdate      = $_POST['bookdate'];   //

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
                    if(!ereg("^_", $f_inputtoorganize[$i])){
                        $arr_inputtoorganize[]=$f_inputtoorganize[$i];
                    }
                    
                }
                        //print_r($arr_inputmyorganize);
                        $sendtoorg=  implode(",", $arr_inputtoorganize);
        }else{
            $sendtoorg="ไม่มีประโยชน์"; 
            //ออกไปเลย แจ้งเตือนไม่เลือกหน่วยงาน
        }        

        $sql_insert = "insert into book2_send (id,sender_id,sender_date,editor_id,editor_date,book_to_nodeid,book_to,book_level,book_secret,book_no,book_v,book_date,book_subject,book_detail,book_for,book_comment,book_from,book_fromrole,book_type,book_status,book_refid) values ('',?,?,'','',?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

    if ($dbquery_insert = $connect->prepare($sql_insert)) {
        echo " OK ";
    $dbquery_insert->bind_param("ssssssssssssssssss",$inputsender,$todaydatetime,$sendtoorg,$book2other,$inputbooklevel,$inputbooksecret,$inputbookno,$inputbookwo,$inputbookdate,$inputbooksubject,$inputbookdetail,$inputbookfor,$inputbookcomment,$inputbookfrom,$inputbookfromrole,$inputbooktype,$inputbookstatus,$inputbookrefid);
    $dbquery_insert->execute();
    $result_insert=$dbquery_insert->get_result();
    }
    
 /*           $sql = "INSERT INTO book2_send(id,sender_id,sender_date,editor_id,editor_date,book_to_nodeid,book_to,book_level,book_secret,book_no,book_v,book_date,book_subject,book_for,book_detail,book_comment,book_from,book_fromrole,book_type,book_status,book_refid)
                    VALUES('','$inputusername','$todaydatetime','','','$sendtoorg','$book2other','$inputbooklevel','$inputbooksecret','$inputbookno','$inputbookwo','$inputbookdate','$inputbooksubject','$inputbookfor','$inputbookdetail','$inputbookcomment','$inputbookfrom','$inputbookfromrole','$inputbooktype','$inputbookstatus','$inputbookrefid')"; //คำสั่ง sql insert ลงฐานข้อมูล
                echo $sql;

            $result = mysqli_query($connect,$sql);
            if($result)
            {
                echo $sql;
                echo "OK I Insert";
                //header('Location:user-list.php'); //ถ้า insert ลงฐานข้อมูล เรียบร้อยแล้ว ให้ไปยัง ไฟล์ user_list.php
            }
*/    
        
        echo " 55 ";
        echo $sendtoorg;
        print_r($sendtoorg) ;
        print_r($book2other) ;
//        foreach ($_POST['book2other'] as $names)
//{
//        print "You are selected $names<br/>";
//}

    }
        
        
        
        
        
        /* ของเดิมๆ
            $sql = "INSERT INTO ".$prefix."user(id,username,password,groupadmin,person_id,name,surname,position,schoolid,tel,officer,dateadd,editor,dateeditor,status)
                    VALUES('','$inputusername','$inputpassword','$inputgroupadmin','$inputidentification','$inputname','$inputsurname','$inputposition','$inputorganize','$inputtel','$inputofficer','$date_time_now','','','$inputuserstatus')"; //คำสั่ง sql insert ลงฐานข้อมูล
            $result = mysqli_query($connect,$sql);
            if($result)
            {
                header('Location:user-list.php'); //ถ้า insert ลงฐานข้อมูล เรียบร้อยแล้ว ให้ไปยัง ไฟล์ user_list.php
            }
         
         */
 /*           
$sql_insert = "insert into book2_send (id,sender_id,sender_date,editor_id,editor_date,book_to_nodeid,book_to,book_level,book_secret,book_no,book_v,book_date,book_subject,book_for,book_detail,book_comment,book_from,book_fromrole,book_type,book_status,book_refid) values ('',?,?,'','',?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

if ($dbquery_insert = $connect->prepare($sql_insert)) {

    $dbquery_insert->bind_param("ss", $inputsender , $date_time_now , $book_date_end , $start_time , $finish_time , $chairman , $objective , $person_num , $user_id , $user_id , $user_departid , $date_time_now , $coordinator , $other);
     $dbquery_insert->execute();
    $result_insert=$dbquery_insert->get_result();

                
    }
*/
?>