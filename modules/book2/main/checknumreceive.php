<?php
session_start();
include '../../../database_connect.php'; 
include 'function.php'; 
if(isset($_SESSION['role_id'])){
$user_role_id=mysqli_real_escape_string($connect,$_SESSION['role_id']);
}else {$user_role_id=""; 
?>
<script langquage='javascript'>
window.location="?option=book2&task=main/roleperson";
</script>
<?php
}

//header("content-type:text/javascript;charset=utf-8");   
//เช็ค SESSION ผู้เข้าระบบ
$userlogin=$_SESSION['login_user_id'];
//echo $userlogin;
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
   }

}
//ตรวจสอบการ นำเข้าข้อมูล
$data = $_POST['id'];
if($data!=""){  //ตรวจสอบค่าว่าง
        
//ลงทะเบียนรับหนังสือ
$receive_status=" and (receiver_status=1 or receiver_status=2) ";
//ตารางเลขหนังสือรับ
$book_table="2";

//สถานะหนังสือ  0=ยังไม่รับ 1=ลงรับแล้ว 2=ส่งต่อ 3=ส่งผ่าน 4=ส่งกลับ 5=ยุติเรื่อง
    $receive_status_no="1";
    
$booksend_num="";
$booksend_date="";
//หาหนังสือรับใหม่
    $sql_booksystem="select * from book2_system where  receiver_department=?  and (receiver_status=1 or receiver_status=2)  order by  receiver_no DESC ";
    $query_booksystem = $connect->prepare($sql_booksystem);
    $query_booksystem->bind_param("s", $look_dep_subdep);
    $query_booksystem->execute();
    $result_qbooksystem=$query_booksystem->get_result();
    
    $i=1;
    $findbookreceive=0;
    While ($result_booksystem = mysqli_fetch_array($result_qbooksystem))
   {
        $book2system_book_refid=$result_booksystem['book_refid']; 
        $book2system_receiver_no=$result_booksystem['receiver_no']; 
        $book2system_receiver_year=$result_booksystem['receiver_year']; 
        $book2system_booktable=$result_booksystem['book_table']; 
        $book2system_receiver_date=$result_booksystem['receiver_date'];
        $book2system_id=$result_booksystem['id'];
        
 
        if($book2system_booktable=="PP"){
           //แสดงหนังสือรอส่ง
            $sql = "select * from book2_receive where book_refid='$book2system_book_refid' and book_no like '%$data%'";
            $dbquery = mysqli_query($connect,$sql);
            While ($result_booksend = mysqli_fetch_array($dbquery)){
                $booksend_num=$result_booksend['book_no'];
                $booksend_date=$result_booksend['book_date'];
            }

            }else{
        //แสดงหนังสือรอส่ง
            $sql = "select * from book2_send where book_refid='$book2system_book_refid' and book_num like '%$data%'";
            $dbquery = mysqli_query($connect,$sql);
            While ($result_booksend = mysqli_fetch_array($dbquery)){
                $booksend_num=$result_booksend['book_num'];
                $booksend_date=$result_booksend['book_date'];
            }
   
            }//จบเลือกตาราง 

            if($booksend_num!=""){
            $findbookreceive="1";
            
            ?>
        <div  class="row container table-hover" style='margin-top:10px; '>
        
        <label><span class="glyphicon glyphicon-check"  aria-hidden="true"></span><a href="#" onclick="showdetailreceived('<?php echo $book2system_id;?>')" >
            <?php echo $booksend_num;?> ลว  <?php echo $booksend_date; ?><BR>
            เลขรับ <?php echo $book2system_receiver_no;?>/<?php echo yeareng2thshort($book2system_receiver_year); ?> รับวันที่ <?php echo $book2system_receiver_date; ?><BR>
                </a></label>
        
        </div>                       

            <?php
            }
}            
        

 if($findbookreceive==0){

     ?>
        <div  class="row container table-hover " style='margin-top:10px; '>
        
        <label ><h4 style="color:green;"><span class="glyphicon glyphicon-check" aria-hidden="true"></span>
                ไม่พบเลขหนังสือนำส่งที่ระบุในทะเบียนหนังสือรับของหน่วยงาน</h4>
        </label>
        
        </div>                       
 
     <?php
     
 }
 
}else{  //ถ้าไม่ระบุเลขที่ให้แสดงข้อความ
    echo "ท่านยังไม่ได้ระบุเลขหนังสือนำส่ง";  
}// จบให้แสดงกรณีไม่ได้ระบุ




 ?>
