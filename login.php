<?php 
    require_once $_SERVER['DOCUMENT_ROOT'].'/library/core/init.config.php';  
    // include 'includes/header.php';
    $studentNumber = (isset($_POST['studentNumber']))?sanitize($_POST['studentNumber']) :'' ;
    $password = (isset($_POST['password']))?sanitize($_POST['password']) :'' ;
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Log in</title>
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


  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="index.php"><b>MY</b>Library</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your account.</p>

    <?php
                    
        if(isset($_POST['login'])){
            if(empty($_POST['studentNumber']) || empty($_POST['password'])){
                echo 'Student ID and password are required to proceed.';
            } else {
                //Ensuring password is 6 or more characters long
                if(strlen($password) < 6){
                    echo 'password must be at least 6 characters';
                } else {
                    //Check if Email exists in database
                    $sql = $db->query("SELECT * FROM users WHERE student_number = '$studentNumber' ");
                    $user = mysqli_fetch_assoc($sql);
                    $count = mysqli_num_rows($sql);
                    if ($count < 1){
                        echo 'Invalid Credentials';
                    } else {
                        if(!password_verify($password, $user['password'])){
                            echo 'Invalid Credentials';
                        }else {                     
                            //FINALLY LOG THE USER IN
                            $userID = $user['id'];
                            login($userID);
                            }
                        }
                        }
                    } 
                }      
    ?>

    <form action="login.php" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="studentNumber" placeholder="Student number">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">

        <div class="col-xs-8">
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" name="login" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <a href="#">I forgot my password</a><br>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>