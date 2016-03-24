<?
session_start();

session_unset();
session_destroy();

?>
<!DOCTYPE html>
<html lang='en'>
<head>
	<title>Prakongmitt</title>
	<meta charset='utf-8'>
	<meta http-equiv='X-UA-Compatible' content='IE=edge'>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<link rel='stylesheet' href='css/bootstrap.min.css' >
	<link rel='stylesheet' href='css/signin.css' >
	<script src='js/bootstrap.js' type='javascript' ></script>
</head>
<body>
	<div class='container'>
	<form class="form-signin" action='verifylogin.php' method='post'  >
		<img class="img-responsive" src="images/logo/logo_prakongmitt_300.png" />
        <h2 class="form-signin-heading">เข้าสู่ระบบ</h2>
        <label for="inpuUser" class="sr-only" >Username</label>
        <input type="text" name="inpuUser" id="inpuUser" class="form-control" placeholder="กรอก username" required autofocus>
        <label for="inputPassword" class="sr-only" >Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="กรอก password" required>
        <button class="btn btn-lg btn-primary btn-block" id='btnSignin' type="button">Sign in</button>
      </form>
   </div>
   
   <script src="js/jquery.min.js"></script>
	<script src='js/bootstrap.js' ></script>
	<script src='js/signin.js' ></script>
</body>
<html>
