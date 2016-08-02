<?php
	if($_SESSION['user_os']=='mobile'){
			if($_SESSION['login_status']<=4){
			include("./modules/book2/main/receive_mobile.php");	
			}
			else if(($_SESSION['login_status']>10) and ($_SESSION['login_status']<=15)){
			include("./modules/book2/main/receive_sch_mobile.php");	
			}
	}
	else{
?>

<div id="wrapper">
        <div class="col-md-12">
                <h3>เลือกบทบาท</h3>                            
                        <div class="form-group ">
                         <div class="col-sm-6">
<?php
                             include "./modules/book2/main/function.php";
$userlogin=$_SESSION['login_user_id'];
//หาชื่อ
    $sql_user="select * from person_main  where person_id=?  ";
    $query_user = $connect->prepare($sql_user);
    $query_user->bind_param("s", $userlogin);
    $query_user->execute();
    $result_quser=$query_user->get_result();
    
    While ($result_user = mysqli_fetch_array($result_quser))
   {
        $name_user=$result_user['name']." ".$result_user['surname'];
   }


//หาบทบาท
    $sql_roleperson="select * from book2_roleperson  where person_id=? and status=1 ";
    $query_roleperson = $connect->prepare($sql_roleperson);
    $query_roleperson->bind_param("s", $userlogin);
    $query_roleperson->execute();
    $result_qroleperson=$query_roleperson->get_result();
    
    While ($result_roleperson = mysqli_fetch_array($result_qroleperson))
   {    
        $roleid_person=$result_roleperson['id'];
        $level_dep=$result_roleperson['level_dep'];
        $look_dep_subdep=$result_roleperson['look_dep_subdep'];
        $role_id=$result_roleperson['role_id'];

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
   ?>
                             <div class="form-group"><button type="button" class="btn btn-warning" onclick="session_role(<?php echo $roleid_person; ?>);" ><?php echo $name_role."[".$name_predepart."]";?></button></div>
   <?php
    }
?>
                             <div class="form-group"><button type="button" class="btn btn-info" onclick="">ส่วนบุคคล[<?php echo $name_user;?>]</button></div>

                        </div>
                    </div>
        </div>
</div>	          
            
            
<?php            
        }
?>
      <!-- My Script -->
     <script src="./modules/book2/main/function.js"></script>
     
     <?php 
/*     echo $_SESSION["roleid_person"]."<BR>";
     echo $_SESSION["role_name"]."<BR>";
     echo $_SESSION["role_iddepart"]."<BR>";
     echo $_SESSION["role_namedepart"]."<BR>";
 
 */
     ?>
