<?php
session_start();
include '../../../database_connect.php'; 
include 'function.php'; 

//header("content-type:text/javascript;charset=utf-8");   
//เช็ค SESSION ผู้เข้าระบบ
$officer=$_SESSION['login_user_id'];
if(isset($_SESSION['role_id'])){
$user_role_id=mysqli_real_escape_string($connect,$_SESSION['role_id']);
}else {$user_role_id=""; 
?>
<script langquage='javascript'>
window.location="?option=book2&task=main/roleperson";
</script>
<?php
}
//บทบาทที่เข้ามาด้วย
$role_iddepart=$_SESSION["role_iddepart"];
$roleid_person=$_SESSION["roleid_person"];
$roleid=$_SESSION["role_id"];

$booktype="2";
$bookstatusid="4";  //สถานะส่งคืน(ไม่ลงรับ)
$booksendstatusid="12";  //สถานะส่งคืน
$todaydatetime=date("Y-m-d H:i:s");
$todayyear=date("Y");

$comment=$_POST['commentrt'];
//ตรวจสอบการ นำเข้าข้อมูล
$data = json_decode($_POST['id']);
//$data = $_POST['id'];
//echo $data;

                //หาบทบาท
                    $sql_roleperson="select * from book2_roleperson  where person_id=? and id=? and status=1 ";
                    $query_roleperson = $connect->prepare($sql_roleperson);
                    $query_roleperson->bind_param("ss", $officer,$roleid_person);
                    $query_roleperson->execute();
                    $result_qroleperson=$query_roleperson->get_result();

                    While ($result_roleperson = mysqli_fetch_array($result_qroleperson))
                   {    
                        $level_dep=$result_roleperson['level_dep'];
                        $look_dep_subdep=$result_roleperson['look_dep_subdep'];
                        $role_id=$result_roleperson['role_id'];
                        $role_orgtb=$result_roleperson['orgtb'];
                   }     

                    if($role_orgtb=='D'){
                        $searchorg="book2_department";
                    }else{
                        $searchorg="book2_subdepartment";            
                    }

        //นับจำนวน array
        $countarray= count($data);

        //ส่งทีละหน่วยงาน
       $j=0;
        for($i=0;$i<$countarray;$i++)
       {
                $booksendid=$data[$i];

                    // อัพเดต สถานะหนังสือ  เดิม
                    $sql_bookreceiveupdate = "update book2_system set  receiver_officer=? , receiver_role=? ,receiver_year=? , receiver_otherdate=?  , receiver_status=? , receiver_comment=? where id=? ";
                   if ($dbquery_bookreceiveupdate = $connect->prepare($sql_bookreceiveupdate)) {
                   $dbquery_bookreceiveupdate->bind_param("sssssss",$officer,$role_id,$todayyear,$todaydatetime,$bookstatusid,$comment,$booksendid);
                   $dbquery_bookreceiveupdate->execute();
                   $result_bookreceiveupdate=$dbquery_bookreceiveupdate->get_result();
                   }
                    
                    //แสดงหนังสือที่ส่ง
                        $sql_booksendst="select * from book2_system where id=? ";
                        $query_booksendst = $connect->prepare($sql_booksendst);
                        $query_booksendst->bind_param("s", $booksendid);
                        $query_booksendst->execute();
                        $result_qbooksendst=$query_booksendst->get_result();

                     While ($result_booksendst = mysqli_fetch_array($result_qbooksendst))
                       {
                            $refid=$result_booksendst['book_refid'];
                        }
                        //แสดงหน่วยงานที่ส่งหนังสือ
                            $sql_booksend="select * from book2_send where book_refid=? ";
                            $query_booksend = $connect->prepare($sql_booksend);
                            $query_booksend->bind_param("s", $refid);
                            $query_booksend->execute();
                            $result_qbooksend=$query_booksend->get_result();
                            
                         While ($result_booksend = mysqli_fetch_array($result_qbooksend))
                           {
                                $booksend_no=$result_booksend['book_num'];
                                $booksend_date=  datesql2show($result_booksend['book_date']);
                                $booksend_subject=$result_booksend['book_subject'];
                                $booksend_for=$result_booksend['book_for'];
                                $booksend_detail=$result_booksend['book_detail'];
                                $booksend_comment=$result_booksend['book_comment'];
                                $booksend_level=$result_booksend['book_level'];
                                $booksend_from=$result_booksend['book_fromdepartment'];
                                $book2other=$result_booksend['book_to_other'];
                                $booksend_comment=$result_booksend['book_comment'];
                                $booksend_secret=$result_booksend['book_secret'];
                                $booksend_fromorgtb=$result_booksend['book_fromorgtb'];
                           }


                        //แสดงหน่วยงานที่ส่งหนังสือ
                            $sql_booksend="select * from book2_department where id=? ";
                            $query_booksend = $connect->prepare($sql_booksend);
                            $query_booksend->bind_param("s", $booksend_from);
                            $query_booksend->execute();
                            $result_qbooksend=$query_booksend->get_result();
                            
                         While ($result_booksend = mysqli_fetch_array($result_qbooksend))
                           {
                                $booksend_to_departgroupcode=$result_booksend['groupcode'];
                           }
                           
                                //นำเข้าฐานข้อมูล ส่งเข้า book2_system   
                                $sql_insert = "insert into book2_system"
                                        . " (id,book_refid,send_year,sender_department,sender_role,sender_officer,sender_returnfrom,sender_date"
                                        . ",sender_no,receiver_group,receiver_department,receiver_officer,receiver_role,receiver_date"
                                        . ",receiver_no,receiver_year,receiver_status,receiver_comment,receiver_otherdate,book_type)"
                                        . " values ('',?,?,?,?,?,?,?"
                                        . ",'',?,?,'','',''"
                                        . ",'','',?,'','',?)";

                               if ($dbquery_insert = $connect->prepare($sql_insert)) {
                               $dbquery_insert->bind_param("sssssssssss",$refid,$todayyear,$look_dep_subdep,$role_id,$officer,$booksendid,$todaydatetime
                                       ,$booksend_to_departgroupcode,$booksend_from
                                       ,$booksendstatusid,$booktype);
                               $dbquery_insert->execute();
                               $result_insert=$dbquery_insert->get_result();
                               }
       }                                                                              
                echo "ส่งคืนหนังสือราชการเรียบร้อยแล้ว";
    
          
?>                            