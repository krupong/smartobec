<!-- BOOTSTRAP STYLES-->
    <link href="./modules/book/assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="./modules/book/assets/css/font-awesome.css" rel="stylesheet" />
     <!-- MORRIS CHART STYLES-->
    
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
     <!-- TABLE STYLES-->
    <link href="./modules/book/assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />

<!--Bootstrap selectpicker -->
<script src="./modules/bookregister/js/bootstrap-select.min.js"></script>
<link href="./modules/bookregister/css/bootstrap-select.min.css" rel="stylesheet" media="screen">

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
    ehco 'task is '.$task;
}
else {
    include("default.php");
}
?>
<script src="./modules/book/assets/js/jquery-1.10.2.js"></script>
 <!-- DATA TABLE SCRIPTS -->
    <script src="./modules/book/assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="./modules/book/assets/js/dataTables/dataTables.bootstrap.js"></script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
    </script>
	 <!-- CUSTOM SCRIPTS -->
 