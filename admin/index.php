<!-- SweetAlert -->
<script src="bower_components/sweetalert/sweetalert.js"></script>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<?php

include_once 'connectdb.php';
session_start();

if (isset($_POST['btn_login'])) {
  $login = $_POST['login'];
  $password = $_POST['txt_password'];

  //echo $useremail." - ".$password;
  $select = $pdo->prepare("SELECT * FROM tbl_user WHERE login='$login' AND password='$password'");
  $select->execute();

  $row = $select->fetch(PDO::FETCH_ASSOC);

  if ($row['login'] == $login and $row['password'] == $password and $row['role'] == "Admin") { //checks if user exists in database

    $_SESSION['userid'] = $row['userid'];
    $_SESSION['login'] = $row['login'];
    $_SESSION['username'] = $row['username'];
    $_SESSION['useremail'] = $row['useremail'];
    $_SESSION['role'] = $row['role'];
    $_SESSION['comms'] = $row['comms'];

    echo '
        <script type="text/javascript">
        jQuery(function validation(){
        swal({
          title: "Login successful",
          text: "Welcome, ' . $_SESSION['username'] . '",
          icon: "success",
        });
        });
        
        </script>';

    header('refresh:2;dashboard.php'); //redirect to dashboard.php

  } else if ($row['login'] == $login and $row['password'] == $password and ($row['role'] == "User")) {

    $_SESSION['userid'] = $row['userid'];
    $_SESSION['login'] = $row['login'];
    $_SESSION['username'] = $row['username'];
    $_SESSION['useremail'] = $row['useremail'];
    $_SESSION['role'] = $row['role'];
    $_SESSION['comms'] = $row['comms'];

    echo '
        <script type="text/javascript">
        jQuery(function validation(){
        swal({
          title: "Login successful",
          text: "Welcome, ' . $_SESSION['username'] . '",
          icon: "success",
        });
        });
        
        </script>';

    if ($row['role'] != "User") {
      header('refresh:2;agent.php');
    } else {
      header('refresh:2;user.php');
    }
  } else {
    echo '
        <script type="text/javascript">
        jQuery(function validation(){
        swal({
          title: "Login failed",
          text: "Wrong password",
          icon: "error",
        });
        });
        
        </script>';
  }
}

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Orked Shop | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page" scroll="no" style="overflow: hidden">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="" method="post">
        <div class="form-group has-feedback">
          <input type="text" class="form-control" placeholder="User ID" name="login" required>
          <span class="glyphicon glyphicon-envelope orm-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Password" name="txt_password" required>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-8">
            <a href="#" onclick="swal('Forgot your password?', 'Please contact admin or service provider','error')">I forgot my password</a><br>
          </div>
          <!-- /.col -->
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat" name="btn_login">Log In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>





    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->

  <script>
    $(function() {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' /* optional */
      });
    });
  </script>
</body>

</html>