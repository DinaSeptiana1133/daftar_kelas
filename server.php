<?php
// connect to the database
require_once 'koneksi/db.php';

// initializing variables
$nama_lengkap = "";
$email    = "";
$errors = array();


// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($nama_lengkap)) { array_push($errors, "Nama Lengkap wajib diisi"); }
  if (empty($email)) { array_push($errors, "Email wajib diisi"); }
  if (empty($password_1)) { array_push($errors, "Password wajib diisi"); }
  if ($password_1 != $password_2) {
	array_push($errors, "Password tidak sesuai");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE nama_lengkap='$nama_lengkap' OR email='$email' LIMIT 1";
  $result = $conn->query($user_check_query);
  $user = $result->fetch_assoc();
  
  if ($user) { // if user exists
    if ($user['nama_lengkap'] === $nama_lengkap) {
      array_push($errors, "Username sudah ada");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email sudah ada");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = password_hash($password_1, PASSWORD_DEFAULT);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (nama_lengkap, email, password) 
  			  VALUES('$nama_lengkap', '$email', '$password')";
  	$conn->query($query);
  	$_SESSION['nama_lengkap'] = $nama_lengkap;
    $_SESSION['email'] = $email;
    $_SESSION['level'] = 0;
  	$_SESSION['success'] = "Berhasil login";
  	header('location: user/index.php');
  } else {
      $password = password_hash($password_1, PASSWORD_DEFAULT);//encrypt the password before saving in the database
      $query = "INSERT INTO users (nama_lengkap, email, password) 
            VALUES('$nama_lengkap', '$email', '$password')";
      $conn->query($query);
      $_SESSION['nama_lengkap'] = $nama_lengkap;
      $_SESSION['email'] = $email;
      $_SESSION['level'] = 1;
      $_SESSION['success'] = "Berhasil login";
      header('location: admin/index.php');
  }
}