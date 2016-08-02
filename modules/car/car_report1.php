<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
$user=$_SESSION['login_user_id'];
$y=date('Y')+543;
if(isset($_GET['y']))$y=$_GET['y'];
?>
<BR>
<div class="container">
  <div class="panel panel-default">
      <div class="panel-heading"><h3 class="panel-title">รายงานการใช้ยานพาหนะ</h3></div>
<?php

    $sql="select * from system_department 
    order by department_name";
    $query = mysqli_query($connect,$sql);
    $currentYear = date('Y')+543;
    ?>
      <div class="panel-body">
        <form id='frm1' name='frm1' class="form-horizontal">
        <div class="row">
            <div class="col-md-10 text-left">
                <ul class="nav nav-pills">
                    <li role="presentation" class=""><a >รายงานปีย้อนหลัง</a></li>
                <?php 
    $i=0;
    while($i<3){
        $active="";
        if($y==($currentYear-$i)) $active="active";
        ?>
                  <li role="presentation" class="<?=$active?>"><a href="?option=car&task=car_report1&y=<?=$currentYear-$i?>"><?=$currentYear-$i?></a></li>
        <?php $i++;}?>
                </ul>
            </div>
            
       </div>
        </form>
          </div>
      <table class="table table-hover table-striped table-condensed table-responsive">
          <thead>
            <tr>
              <th>ลำดับที่</th>
              <th>สำนัก</th>
                <?php 
    $i=1;
    while($i<=12){ 
        $txt=substr("0$i",-2);
        echo "<th>$t_month[$txt]</th>";
        $i=$i+1;
    }
    ?>
            </tr>
          </thead>
          <tbody>
        <?php 
$N=1; //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($query)){
    $department=$result['department'];
    $depname=$result['department_name'];
?>
              <Tr>
                  <Td><?=$N?></Td>
                  <Td><a href="?option=car&task=car_report2&y=<?=$y?>&department=<?=$department?>&depname=<?=$depname?>"><?php echo $result['department_name'];?></a></Td>
<?php
    $sql2=" select month(a.car_start) as mcs, count(month(a.car_start)) as cmc from car_main a
    left outer join person_main b on a.person_id=b.person_id
    where b.department = $department
    and year(a.car_start)=($y-543) 
    and a.commander_grant=2 
    group by month(a.car_start)
    
    ";
    $mstart=1;
    $total_each_month[1]="";
    $total_each_month[2]="";
    $total_each_month[3]="";
    $total_each_month[4]="";
    $total_each_month[5]="";
    $total_each_month[6]="";
    $total_each_month[7]="";
    $total_each_month[8]="";
    $total_each_month[9]="";
    $total_each_month[10]="";
    $total_each_month[11]="";
    $total_each_month[12]="";
    $query2 = mysqli_query($connect,$sql2);
    While ($result2 = mysqli_fetch_array($query2)){
        $cmc = $result2['cmc'];
        $mcs = $result2['mcs'];
        $total_each_month[$mcs]=$total_each_month[$mcs]+$cmc;
        while($mstart<$result2['mcs']){ //กรณีเดือนที่ไม่มีการขอใช้รถให้สร้างช่องว่างขึ้นมา
            echo "<td class='".changeColor($mstart)."'>&nbsp;</td>";
            $mstart++;
        }
        echo "<td class='".changeColor($mstart)."'>".number_format($cmc)."</td>";
        $mstart++;
    }        
    While($mstart<13){ //กรณีเดือนที่ไม่มีการขอใช้รถให้สร้างช่องว่างขึ้นมา
        echo "<td class='".changeColor($mstart)."'>&nbsp;</td>";
        $mstart++;
    }
?>
              </Tr>
<?php 
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
}
?>
              <tr>
                  <td align=center colspan=2> รวม </td>
                    <?php 
                    $i=1;
                    while($i<=12){
                        echo "<td class='".changeColorTotal($i)."'>$total_each_month[$i]</td>";
                        $i++;
                    }
                    ?>
              </tr>
    </tbody>
</Table>

    </div>
    </div>