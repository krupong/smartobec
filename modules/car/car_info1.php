<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

$user=$_SESSION['login_user_id'];
//กรณีเลือกแสดงเฉพาะคัน
$y=date('Y')+543;
if(isset($_GET['y']))$y=$_GET['y'];
//ส่วนหัว
?>
<BR>
<div class="container">
  <div class="panel panel-default">

      <div class="panel-heading"><h3 class="panel-title">รายงานการใช้ยานพาหนะ</h3></div>
<?php
//ส่วนของการแยกหน้า

    $sql="select * from car_type 
    order by name";
    $query = mysqli_query($connect,$sql);
    ?>
      <br>
      <table class="table table-hover table-striped table-condensed table-responsive">
          <thead>
            <tr>
              <th>ลำดับที่</th>
              <th>ประเภทของรถ</th>
              <th>จำนวนรถ</th>
            </tr>
          </thead>
          <tbody>
        <?php 
$N=0;
$total=0;
While ($result = mysqli_fetch_array($query)){
    $N++;
    $car_type_code=$result['code'];
    $car_type_name=$result['name'];
?>
              <Tr>
                  <Td><?=$N?></Td>
                  <Td><b><?php echo $result['name'];?></b></Td>
<?php
    $sql2=" 
    select count(*) as totalcar from car_car where car_type=$car_type_code";
    $query2 = mysqli_query($connect,$sql2);
    While ($result2 = mysqli_fetch_array($query2)){
        echo "<td>".$result2['totalcar']." คัน</td>";
        $total=$total+$result2['totalcar'];
    }
?>
              </Tr>
<?php 
}
?>
              <tr>
                  <td></td>
                  <td><h3>รวม</h3></td>
                    <?php echo "<td><h3>$total คัน</h3></td>"; ?>
              </tr>
    </tbody>
</Table>

    </div>
    </div>