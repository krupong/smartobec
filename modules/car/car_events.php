<?php
header("Content-type:text/json; charset=UTF-8");              
header("Cache-Control: no-store, no-cache, must-revalidate");             
header("Cache-Control: post-check=0, pre-check=0", false);   
$con_db=mysql_connect("localhost","amss","amss") or die("Cannot connect db server");
$select_db=mysql_select_db("amss");
if($_GET['gData']){
	$event_array=array();
	$i_event=0;
	$q="SELECT * FROM car_main WHERE ORDER by id";
	$qr=mysql_query($q);
	while($rs=mysql_fetch_array($qr)){
		$event_array[$i_event]['id']=$rs['id'];
		$event_array[$i_event]['title']=$rs['place'];
		$event_array[$i_event]['start']=$rs['car_start'];
		$event_array[$i_event]['end']=$rs['car_finish'];
		$event_array[$i_event]['url']='';
		$event_array[$i_event]['allDay']=false;
		$i_event++;
	}
	echo json_encode($event_array);
	exit;	
}
?>