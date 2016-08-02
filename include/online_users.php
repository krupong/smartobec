<?php 

//require_once "database_connect.php";

//session_start();
$session=session_id();
$time=time();
$time_check=$time-300; //We Have Set Time 5 Minutes

$host=$hostname; // your Host name 
$username=$user; // your Mysql username 
$password=$password; // your Mysql password 
$db_name=$dbname; // your Database name
$tbl_name="online_users"; // Table name 

mysql_connect("$host", "$username", "$password")or die("could notconnect toserver."); 
mysql_select_db("$db_name")or die("cannot select DB");

$sql="SELECT * FROM $tbl_name WHERE session='$session'"; $result=mysql_query($sql);
$count=mysql_num_rows($result); 

//If count is 0 , then enter the values
if($count=="0"){ 
$sql1="INSERT INTO $tbl_name(session, time)VALUES('$session', '$time')"; 
$result1=mysql_query($sql1);
}

 // else update the values 
 else {
$sql2="UPDATE $tbl_name SET time='$time' WHERE session = '$session'"; 
$result2=mysql_query($sql2); 
}

 $sql3="SELECT * FROM $tbl_name";
 $result3=mysql_query($sql3); 
 $count_user_online=mysql_num_rows($result3);
 //echo "<b>Users Online : </b> $count_user_online "; 

 // after 5 minutes, session will be deleted 
 $sql4="DELETE FROM $tbl_name WHERE time<$time_check"; 
 $result4=mysql_query($sql4); 

 //To see the result run this script in multiple browser. 
mysql_close();
?>