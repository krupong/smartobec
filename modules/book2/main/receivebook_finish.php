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
$bookstatusid="5";  //สถานะยุติเรื่อง
$todaydatetime=date("Y-m-d H:i:s");
$todayyear=date("Y");

$comment=$_POST['commentfn'];
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
                    
       }                                                                          
                echo "ยุติหนังสือราชการเรียบร้อยแล้ว";
     
          
?>                            