<?php
session_start();
include '../../../database_connect.php'; 
include 'function.php'; 

//header("content-type:text/javascript;charset=utf-8");   
//เช็ค SESSION ผู้เข้าระบบ
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
//บทบาทที่เข้ามาด้วย
$role_iddepart=$_SESSION["role_iddepart"];
$roleid_person=$_SESSION["roleid_person"];
$roleid=$_SESSION["role_id"];

$todaydatetime=date("Y-m-d H:i:s");
$todayyear=date("Y");

//ตรวจสอบการ นำเข้าข้อมูล
$data = json_decode($_POST['id']);
//$data = $_POST['id'];
//echo $data;

//ลงทะเบียนรับหนังสือ
$receive_status="1";
//ตารางเลขหนังสือรับ
$book_type="1";


                            //หากลุ่ม บทบาท
                            $sql_role="select * from book2_role where id=? ";
                            $query_role = $connect->prepare($sql_role);
                            $query_role->bind_param("i", $roleid);
                            $query_role->execute();
                            $result_qrole=$query_role->get_result();
                            
                         While ($result_role = mysqli_fetch_array($result_qrole))
                           {
                                $grouprole=$result_role['groupcode'];
                           }


                //เช็คเลขรับของหน่วยงาน
                    $sql_bookno="select * from book2_numbook where typebook_id=? and department_id=? and no_year=?  ";
                    $query_bookno = $connect->prepare($sql_bookno);
                    $query_bookno->bind_param("sss",$book_type,$role_iddepart,$todayyear);
                    $query_bookno->execute();
                    $result_qbookno=$query_bookno->get_result();

                 While ($result_bookno = mysqli_fetch_array($result_qbookno))
                   {
                     $bookno=$result_bookno['no_present'];
                   }


$countarray= count($data);

                                //ส่งทีละหน่วยงาน
                               $j=0;
                                for($i=0;$i<$countarray;$i++)
                               {
                                        $booksendid=$data[$i];
                                    //แสดงหนังสือรอส่ง
                                        $sql_booksendst="select * from book2_system where id=? ";
                                        $query_booksendst = $connect->prepare($sql_booksendst);
                                        $query_booksendst->bind_param("s", $booksendid);
                                        $query_booksendst->execute();
                                        $result_qbooksendst=$query_booksendst->get_result();

                                     While ($result_booksendst = mysqli_fetch_array($result_qbooksendst))
                                       {
                                            $bookrefid=$result_booksendst['book_refid'];
                                        }
                                   // $bookrefid=$data[$i];
                                   // $bookrefid=$data[$i];
                                   // $bookrefid=$data[$i];
                                   // $bookrefid=$data[$i];
//echo $sendidorg."<BR>";
                                $bookno=$bookno+1;

                    // อัพเดต สถานะหนังสือ    
                    $sql_bookreceiveupdate = "update book2_system set receiver_group=? , receiver_officer=? , receiver_role=? ,receiver_year=? , receiver_date=? , receiver_no=? , receiver_status=? where id=?  ";
                   if ($dbquery_bookreceiveupdate = $connect->prepare($sql_bookreceiveupdate)) {
                   $dbquery_bookreceiveupdate->bind_param("ssssssss",$grouprole,$userlogin,$roleid,$todayyear,$todaydatetime,$bookno,$receive_status,$booksendid);
                   $dbquery_bookreceiveupdate->execute();
                   $result_bookreceiveupdate=$dbquery_bookreceiveupdate->get_result();
                   }
     // อัพเดต เลขล่าสุด
     $sql_noupdate = "update book2_numbook set no_present=? where typebook_id=? and department_id=? and no_year=?  ";
    if ($dbquery_noupdate = $connect->prepare($sql_noupdate)) {
    $dbquery_noupdate->bind_param("ssss",$bookno,$book_type,$role_iddepart,$todayyear);
    $dbquery_noupdate->execute();
    $result_noupdate=$dbquery_noupdate->get_result();
    }
                   
//แสดงหนังสือรอส่ง
    $sql_booksend="select * from book2_send where book_refid=? ";
    $query_booksend = $connect->prepare($sql_booksend);
    $query_booksend->bind_param("s", $bookrefid);
    $query_booksend->execute();
    $result_qbooksend=$query_booksend->get_result();

 While ($result_booksend = mysqli_fetch_array($result_qbooksend))
   {
        $booksend_no=$result_booksend['book_num'];
        $booksend_date=  datesql2show($result_booksend['book_date']);
    }
                   
                   
                   
                   ?>

        <div  class="row container table-hover" style='margin-top:10px; '>
        <label><?php   echo $booksend_no;?> ลว <?php   echo $booksend_date;?> เลขหนังสือรับ :  <?php   echo $bookno;?>/<?php   echo yeareng2thlong($todayyear);?>
        </label>
        
        </div>                       



<?php
     }                                  
?>                            