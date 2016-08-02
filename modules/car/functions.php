<?php 
$arr_province =array("กระบี่","กรุงเทพมหานคร","กาญจนบุรี","กาฬสินธุ์","กำแพงเพชร","ขอนแก่น","จันทบุรี","ฉะเชิงเทรา" ,"ชลบุรี","ชัยนาท","ชัยภูมิ","ชุมพร","เชียงราย","เชียงใหม่","ตรัง","ตราด","ตาก","นครนายก","นครปฐม","นครพนม","นครราชสีมา" ,"นครศรีธรรมราช","นครสวรรค์","นนทบุรี","นราธิวาส","น่าน","บุรีรัมย์","ปทุมธานี","ประจวบคีรีขันธ์","ปราจีนบุรี","ปัตตานี" ,"พะเยา","พังงา","พัทลุง","พิจิตร","พิษณุโลก","เพชรบุรี","เพชรบูรณ์","แพร่","ภูเก็ต","มหาสารคาม","มุกดาหาร","แม่ฮ่องสอน" ,"ยโสธร","ยะลา","ร้อยเอ็ด","ระนอง","ระยอง","ราชบุรี","ลพบุรี","ลำปาง","ลำพูน","เลย","ศรีสะเกษ","สกลนคร","สงขลา" ,"สตูล","สมุทรปราการ","สมุทรสงคราม","สมุทรสาคร","สระแก้ว","สระบุรี","สิงห์บุรี","สุโขทัย","สุพรรณบุรี","สุราษฎร์ธานี" ,"สุรินทร์","หนองคาย","หนองบัวลำภู","อยุธยา","อ่างทอง","อำนาจเจริญ","อุดรธานี","อุตรดิตถ์","อุทัยธานี","อุบลราชธานี");
?>

<?php 
function PAGESPLIT($sql,$connect,$Rpage,$PHP_SELF,$url_link,$pagelen){
$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery);
$totalpages=ceil($num_rows/$pagelen);
if(!isset($Rpage))  $Rpage="";
if($Rpage==""){
    $page=$totalpages;
    if($page<2)   $page=1;
}
else{
    if($totalpages<$Rpage){
        $page=$totalpages;
        if($page<1) $page=1;
    }
    else    $page=$Rpage;
}
$start=($page-1)*$pagelen;
$link= "$PHP_SELF?$url_link&page=";
$spliter=5;
if($spliter>$totalpages) $spliter=$totalpages;
$starter=1;
if($page>$spliter){
    $starter=($totalpages-$spliter)+1;
    $spliter=$totalpages;
}
if($totalpages>1){
?>
        <nav>
  <ul class="pagination">
      <?php 
        for($i=$starter; $i<=$spliter; $i++){
        $active="";        
        $link= "$PHP_SELF?$url_link&page=$i";        
        $pv=$page-1;
        $nx=$page+1;
        if($pv<1)   $pv=1;
        if($i==$page) $active="active";        
        if($i==$starter){
            $link_pv= "$PHP_SELF?$url_link&page=$pv";
            if($page==1) $link_pv="#";
            echo "<li><a href='$link_pv'><span>&laquo;</span></a></li>";
        }
      ?>
        <li class="<?=$active?>"><a href="<?=$link?>"><?=$i?> <span class="sr-only">(current)</span></a></li>
      <?php 
        
        if($i==$spliter ){
            $link_nx= "$PHP_SELF?$url_link&page=$nx";
            if($page==$totalpages) $link_nx="#";
            echo "<li><a href='$link_nx'><span>&raquo;</span></a></li>";
        }
        }?>
  </ul>
</nav> 
<?php 			
}
}
function PAGESPLIT_START($sql,$connect,$Rpage,$pagelen){
    $dbquery = mysqli_query($connect,$sql);
    $num_rows = mysqli_num_rows($dbquery);
    $totalpages=ceil($num_rows/$pagelen);
    if(!isset($Rpage))  $Rpage="";
    if($Rpage==""){
        $page=$totalpages;
        if($page<2) $page=1;
    }
    else{
        if($totalpages<$Rpage){
            $page=$totalpages;
            if($page<1) $page=1;
        }
        else    $page=$Rpage;
    }
    $start=($page-1)*$pagelen;
    return $start;
}
function PAGESPLIT_TOTALPAGES($sql,$connect,$pagelen){
    $dbquery = mysqli_query($connect,$sql);
    $num_rows = mysqli_num_rows($dbquery);
    $totalpages=ceil($num_rows/$pagelen);
    return $totalpages;
}
function changeColor($i){
    if($i%2==1) $color="success";
    else $color="warning";
    return $color;
}
function changeColorTotal($i){
    if($i%2==1) $color="success";
    else $color="info";
    return $color;
}
function thyear_aclub($date){
    $f1_date=explode("-", $date);
    $thai_year=$f1_date[0]+543;
    $datethyear=$f1_date[2]."/".$f1_date[1]."/".$thai_year;
    return $datethyear;
}

function enyear_aclub($date){
    $f1_date=explode("/", $date);
    $en_year=$f1_date[2]-543;
    $dateenyear=$en_year."-".$f1_date[1]."-".$f1_date[0];
    return $dateenyear;
}

?>