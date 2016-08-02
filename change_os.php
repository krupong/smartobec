<?php
session_start();
$_SESSION['user_os']="desktop";
echo "<script>document.location.href='index.php';</script>\n";
?>