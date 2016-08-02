<style>
   .icon-primary {
        color: #428bca;
   }
   .icon-success {
        color: #5cb85c;
   }
   .icon-info {
        color: #5bc0de;
   }
   .icon-warning {
        color: #f0ad4e;
   }
   .icon-danger {
        color: #d9534f;
   }
   .icon-size1 {
        font-size: 15px;
   }
   .icon-size2 {
        font-size: 20px;
   }
   .icon-size3 {
        font-size: 25px;
   }
</style>

<!-- Bootstrap Popover -->
<script>
	$(function () {
 		$('[data-toggle="popover"]').popover()
	})
</script>


<!--Bootstrap selectpicker -->
<script src="./modules/meeting/js/bootstrap-select.min.js"></script>
<link href="./modules/meeting/css/bootstrap-select.min.css" rel="stylesheet" media="screen">
<!-- Bootstrap Select Picker -->
<script>
 	$(function () {
    $('.selectpicker').selectpicker()
     	})
</script>

<?php
if($_SESSION['user_os']=='mobile'){
//include("./modules/work/menu_mobile.php");
}
else{
//include("./modules/work/menu.php");
}
//ผนวกไฟล์
if($task!=""){
include("$task");
}
else {
include("default.php");
}
?>
<!-- Bootstrap Confirmation -->
<script>
	$('[data-toggle="confirmation"]').confirmation({
    title: "<B>กรุณายืนยัน</B>",
    btnOkLabel: "<i class='icon-ok-sign icon-white'></i> ยืนยัน",
    btnCancelLabel: "<i class='icon-remove-sign'></i> ยกเลิก",
    singleton: "true",
    popout: "true"
    })
</script>


