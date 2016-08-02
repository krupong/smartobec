<? session_start(); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<table border="1" align="center" cellpadding="0" cellspacing="0">
  <tr align="center" bgcolor="#CCCCCC">
    <td>SESSION NAME</td>
    <td>SESSION VALUE</td>
  </tr>
  <tr align="center">
    <td align="left">&nbsp;login_group</td>
    <td align="left">&nbsp;<?php echo $_SESSION['login_group']; ?></td>
  </tr>
  <tr align="center">
    <td align="left">&nbsp;login_status</td>
    <td align="left">&nbsp;<?php echo $_SESSION['login_status']; ?></td>
  </tr>
  <tr align="center">
    <td align="left">&nbsp;login_user_id</td>
    <td align="left">&nbsp;<?php echo $_SESSION['login_user_id']; ?></td>
  </tr>
  <tr align="center">
    <td align="left">&nbsp;login_name</td>
    <td align="left">&nbsp;<?php echo $_SESSION['login_name']; ?></td>
  </tr>
  <tr align="center">
    <td align="left">&nbsp;login_prename</td>
    <td align="left">&nbsp;<?php echo $_SESSION['login_prename']; ?></td>
  </tr>
  <tr align="center">
    <td align="left">&nbsp;login_surname</td>
    <td align="left">&nbsp;<?php echo $_SESSION['login_surname']; ?></td>
  </tr>
  <tr align="center">
    <td align="left">&nbsp;login_userposition</td>
    <td align="left">&nbsp;<?php echo $_SESSION['login_userposition']; ?></td>
  </tr>
  <tr align="center">
    <td align="left">&nbsp;office_code</td>
    <td align="left">&nbsp;<?php echo $_SESSION['office_code']; ?></td>
  </tr>
  <tr align="center">
    <td align="left">&nbsp;office_name</td>
    <td align="left">&nbsp;<?php echo $_SESSION['office_name']; ?></td>
  </tr>
  <tr align="center">
    <td align="left">&nbsp;login_departmentid</td>
    <td align="left">&nbsp;<?php echo $_SESSION['login_departmentid']; ?></td>
  </tr>
  <tr align="center">
    <td colspan="2" bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
</table>
</body>
</html>