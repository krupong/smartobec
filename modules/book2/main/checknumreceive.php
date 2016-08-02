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
//บทบาทที่เข้ามาด้วย
//หาสิทธิ์ของผู้ใช้งาน
    $sql_roleuser="select * from book2_roleuser where person_id=? order by sa_node_id ASC";
    $query_roleuser = $connect->prepare($sql_roleuser);
    $query_roleuser->bind_param("s", $userlogin);
    $query_roleuser->execute();
    $result_qroleuser=$query_roleuser->get_result();
        While ($result_roleuser = mysqli_fetch_array($result_qroleuser))
       {
            $roleuser_sa_node_id=$result_roleuser['sa_node_id'];
        }

//ตรวจสอบการ นำเข้าข้อมูล
$data = $_POST['id'];
if($data!=""){  //ตรวจสอบค่าว่าง

//ลงทะเบียนรับหนังสือ
$receive_status="1";
//ตารางเลขหนังสือรับ
$book_table="2";

//สถานะหนังสือ  0=ยังไม่รับ 1=ลงรับแล้ว 2=ส่งต่อ 3=ส่งผ่าน 4=ส่งกลับ 5=ยุติเรื่อง
    $receive_status_no="1";
    

//หาหนังสือรับใหม่
    $sql_booksystem="select * from book2_system where  receiver=? and (receiver_status=1 or receiver_status=2) order by  sender_date DESC ";
    $query_booksystem = $connect->prepare($sql_booksystem);
    $query_booksystem->bind_param("s", $roleuser_sa_node_id);
    $query_booksystem->execute();
    $result_qbooksystem=$query_booksystem->get_result();
    
    $i=1;
    $findbookreceive=0;
    While ($result_booksystem = mysqli_fetch_array($result_qbooksystem))
   {
        $book2system_book_refid=$result_booksystem['book_refid']; 
        //echo '$book2system_book_refid ='.$book2system_book_refid."<BR>";
        
        //$showdata="'%".$data."%'";
        
        //แสดงหนังสือรอส่ง
        $sql = "select * from book2_send where book_refid='$book2system_book_refid' and book_no like '%$data%'";
        $dbquery = mysqli_query($connect,$sql);
        //echo $sql;
        While ($result_booksend = mysqli_fetch_array($dbquery)){

/*
        $sql_booksend="select * from book2_send where book_refid=? and book_no like CONCAT(‘%’,?,’%’) ";
            $query_booksend = $connect->prepare($sql_booksend);
            $query_booksend->bind_param("ss", $book2system_book_refid,$data);
            $query_booksend->execute();
            $result_qbooksend=$query_booksend->get_result();

         While ($result_booksend = mysqli_fetch_array($result_qbooksend))
           {
*/
//             echo " 666 <BR>";
                $booksend_no=$result_booksend['book_no'];
                $booksend_date=$result_booksend['book_date'];
                $booksend_subject=$result_booksend['book_subject'];
                $booksend_from=$result_booksend['book_from'];

            $findbookreceive="1";
            ?>
        <div  class="row container table-hover" style='margin-top:10px; '>
        
        <label><span class="glyphicon glyphicon-check"  aria-hidden="true"></span><a href="#" onclick="showdetailreceived('<?php echo $book2system_book_refid;?>')" >
            <?php echo $booksend_no;?> ลว  <?php echo $booksend_date; ?><BR>
            เลขรับ <?php echo $booksend_no;?> เมื่อวันที่ <?php echo $booksend_date; ?><BR>
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
