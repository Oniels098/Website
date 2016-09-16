<?php

$fromSite = $_GET['s'];
ob_start();
 session_start();
 require_once 'dbconnect.php';
 
 if ( isset($_SESSION['user'])!="" ) {
  header("Location: http://nielsvdvreede.nl/school/admin/home/");
  exit;
 }
 
 $error = false;
 
 if( isset($_POST['btn-login']) ) { 
  
  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);
  
  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
  
  if(empty($email)){
   $error = true;
   $emailError = "Please enter your email address.";
  } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = true;
   $emailError = "Please enter valid email address.";
  }
  
  if(empty($pass)){
   $error = true;
   $passError = "Please enter your password.";
  }
  
  if (!$error) {
   
   $password = $pass;
  
   $res=mysql_query("SELECT userId, userName, userPass FROM users WHERE userEmail='$email'");
   $row=mysql_fetch_array($res);
   $count = mysql_num_rows($res);
   
   if( $count == 1 && $row['userPass']==$password) {
    $_SESSION['user'] = $row['userId'];
    header("Location: http://nielsvdvreede.nl/school/admin/home/");
   } else {
    $errMSG = "Incorrect Credentials, Try again...";
   }
    
  }
  
 }

?>
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.22.0/css/uikit.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:700,300">
<style type="text/css">html,body{font-size:16px;font-family:"Open Sans",sans-serif;font-family:300;background:#222!important;}.uk-form-row+.uk-form-row{margin-top:5px!important;}.uk-form-horizontal .uk-form-label{width:90px!important;text-align:right;margin-right:10px;}.uk-form-horizontal .uk-form-controls{margin-left:0!important;}.uk-form-horizontal .uk-form-controls .uk-button{margin-left:100px!important;}#content{position:fixed;top:50%;left:50%;width:300px;margin-top:-160px;margin-left:-150px;background:#E8E8E8;border-radius:2px;padding:0 10px 18px 15px;}.logo{width:200px;height:200px;margin:0 auto 15px auto;display:block;}</style>
</head>
<body>
<div id="content">
<img src="https://i.imgur.com/mS8hx5D.png" class="logo">
<form class="uk-form uk-form-horizontal" action="/attemptlogin" method="post">
<input type="hidden" name="redirect" value="/home">
<div class="uk-form-row">
<label class="uk-form-label">Username</label>
<div class="uk-form-controls">
<input type="text" name="username" placeholder="Steve">
</div>
</div>
<div class="uk-form-row">
<label class="uk-form-label">Password</label>
<div class="uk-form-controls">
<input type="password" name="password">
</div>
</div>
<div class="uk-form-row">
<div class="uk-form-controls">
<button class="uk-button">Login</button>
</div>
</div>
</form>
</div>
</body>
</html>
