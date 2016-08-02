<!DOCTYPE html>
<html>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">กรุณาป้อนข้อมูลเพื่อเข้าสู่ระบบ</p>

    <form action="index.php" method="post">
      <div class="form-group has-feedback">
        <input id="username" name="username" type="text" class="form-control" placeholder="ชื่อผู้ใช้" required>
        <i class="fa fa-user form-control-feedback"></i>
      </div>
      <div class="form-group has-feedback">
        <input id="pass" name="pass" type="password" class="form-control" placeholder="รหัสผ่าน" required>
        <i class="fa fa-key form-control-feedback"></i>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-4">
          <button id="login_submit" name="login_submit" type="submit" class="btn btn-primary btn-block btn-flat">เข้าสู่ระบบ</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <!--<a href="#">I forgot my password</a><br>
    <a href="register.html" class="text-center">Register a new membership</a>-->

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- iCheck -->
<script src="adminlte233/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
