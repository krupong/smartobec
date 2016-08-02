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




<!--Bootstrap datepicker -->
    <script src="./modules/mail/js/bootstrap-datepicker.js"></script>
    <script src="./modules/mail/js/bootstrap-datepicker-thai.js"></script>
    <script src="./modules/mail/js/bootstrap-datepicker.th.js"></script>
    <link href="./modules/mail/css/datepicker.css" rel="stylesheet" media="screen">
    <script id="datepicker"  type="text/javascript">
      function datepicker() {
        $('.datepicker').datepicker({
          format: 'yyyy-mm-dd',
          autoclose : 'true'
          });
      }
    </script>

<!--Bootstrap selectpicker -->
<script src="./modules/mail/js/bootstrap-select.min.js"></script>
<link href="./modules/mail/css/bootstrap-select.min.css" rel="stylesheet" media="screen">

<!--JQuery Validation -->
<script src="./modules/mail/js/jquery.validate.js"></script>
	<script>
	$().ready(function() {
		// validate signup form on keyup and submit
		$("#frm1").validate({
			rules: {
				room: "required",
				book_date_start: "required",
				book_date_end: "required",
				start_time: "required",
				finish_time: "required",
				chairman: {
					required: true,
					minlength: 5
				},
 				objective: {
					required: true,
					minlength: 5
				},
				person_num: {
					required: true,
					number: true
				},
				coordinator: {
					required: true,
					minlength: 5
				},
            },
			messages: {
				room: "กรุณาเลือกห้องประชุม",
				book_date_start: "กรุณาระบุวันเริ่มต้น",
				book_date_end: "กรุณาระบุวันที่สิ้นสุด",
				start_time: "กรุณาระบุเวลาเริ่มประชุม",
				finish_time: "กรุณาระบุเวลาเลิกประชุม",
				chairman: {
					required: "กรุณาระบุประธานการประชุม",
					minlength: "คุณต้องกรอกข้อมูลมากกว่า 5 ตัวอักษร"
				},
				objective: {
					required: "กรุณาระบุวัตถุประสงค์ของการใช้",
					minlength: "คุณต้องกรอกข้อมูลมากกว่า 5 ตัวอักษร"
				},
				person_num: {
					required: "กรุณาระบุจำนวนผู้เข้าประชุม",
					number: "คุณต้องกรอกข้อมูลเป็นตัวเลขเท่านั้น"
				},
				coordinator: {
					required: "กรุณาระบุผู้ประสานงานและเบอร์โทรศัพท์",
					minlength: "คุณต้องกรอกข้อมูลมากกว่า 5 ตัวอักษร"
				},

            }
 		});

	});
	</script>
	<style>
	#frm1 label.error {
		margin-left: 10px;
		width: auto;
		display: inline;
		color: red;
        font-size: 12px;
	}
	</style>

<?php
if(isset($_REQUEST['index'])){
$index=$_REQUEST['index'];
}
else{
$index="";
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
<script src="./bootstrap-3.3.5-dist/js/bootstrap-confirmation.min.js"></script>
<script>
	$('[data-toggle="confirmation"]').confirmation({
    title: "<B>กรุณายืนยัน</B>",
    btnOkLabel: "<i class='icon-ok-sign icon-white'></i> ยืนยัน",
    btnCancelLabel: "<i class='icon-remove-sign'></i> ยกเลิก",   
    singleton: "true",
    popout: "true"
    })
</script>

<!-- Bootstrap Select Picker -->
<script>
 	$(function () {
    $('.selectpicker').selectpicker()
     	})
</script>
