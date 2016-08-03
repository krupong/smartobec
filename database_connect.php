<?php
$hostname="localhost";
$user="root";
$password="";
$dbname="sm5"; 
$system_office_code="Smart_Obec";    //รหัสหน่วยงาน

$connect=mysqli_connect($hostname,$user,$password,$dbname) or die("Could not connect MySql");
mysqli_query($connect,"SET NAMES utf8");
?> 
