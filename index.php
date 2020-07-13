<?php
session_start();

if(isset($_SESSION["login"])){
    header("Location: index.php");
    exit;
}
require_once 'koneksi/db.php';

if(isset($_POST["login"])) {
    $email 		= $_POST['email'];
    $password 	= $_POST['password'];


    $sql 	= "SELECT nama_lengkap, email, password, is_admin FROM users WHERE email = '".$email."'";
    $query 	= $conn->query($sql)or die('Error: '. $conn->error);
    $user = $query->fetch_assoc();

if(is_null($user)){
  header('Location: index.php');
}

if(password_verify($password, $user['password'])){
  
  if ($user['is_admin'] == 0){
    $_SESSION['level'] = 0; 
    $_SESSION['email'] = $user['email'];
    $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
    header('Location: user/index.php');
  } else {
    $_SESSION['level'] = 1;
    $_SESSION['email'] = $user['email'];
    $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
    header('Location: admin/index.php');
  }
} else {
  header('Location: index.php');
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin/assets/js/jquery.min.js">
    <link rel="stylesheet" href="admin/assets/js/popper.js">
    <style>
        .form-container{
            border: 0px solid white;
            padding: 50px 60px;
            margin-top: 20vh;
            -webkit-box-shadow: -1px 4px 26px 11px rgba(0,0,0,0.75);
            -moz-box-shadow: -1px 4px 26px 11px rgba(0,0,0,0.75);
            box-shadow: -1px 4px 26px 11px rgba(0,0,0,0.75);
        }
    </style>
</head>
<body class="bg-primary">
    <div class="container-fluid bg">
        <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-12"></div>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <!-- form start -->
                <form action="" class="form-container" method="post" autocomplete="off">
                    <h1 class="text-center">
                        LOGIN
                    </h1>

                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button class="close" data-dismiss="alert"> &times;</button>
                            Username & Password tidak sesuai
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Masukkan Alamat Email" required>
                    </div>
                    <div class="form-group">
                        <label> Password </label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan Password">
                    </div>
                    <button type="submit" name="login" class="btn btn-success btn-block"> Login </button>
                    <p class="text-center bg-success text-white mt-2">Belum punya akun? <a class="bg-success text-dark" href="register.php">Create an Account!</a></p>
                </form>
                <!-- form end-->
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12"></div>
        </div>
    </div>
</body>
</html>