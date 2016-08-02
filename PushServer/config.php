<?php
include ("../database_connect.php");
/**
 * ตัวแปรสำหรับการติดต่อฐานข้อมูล
 */
define("DB_HOST", $hostname);
define("DB_USER", $user);
define("DB_PASSWORD", $password);
define("DB_DATABASE", $dbname);

/*
 * Google API Key
 */
//define("GOOGLE_API_KEY", "AIzaSyCg_XTK48PxL39bEh3RQ0HSOAaZW2pB39s"); // dev version
define("GOOGLE_API_KEY", "AIzaSyBmcjYPfWP87gsPnaliv63bHqqbxrKo4M0"); // play store version
?>
