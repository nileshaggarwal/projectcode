<?php
if(isset($_POST["submit"])){
    include('db.php');

    session_start();
    $email=mysqli_real_escape_string($con,$_POST['email']);
    $password=mysqli_real_escape_string($con,$_POST['password']);
    $customer_result="SELECT * FROM customer WHERE ";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login - Rustom</title>
<link rel="icon" href="icon.ico">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
 <!--Google Fonts-->
 <link href="https://fonts.googleapis.com/css2?family=Titillium+Web&display=swap" rel="stylesheet">
    <!--BOOTSTRAP CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="./login.css" />
<head>
<body>
<div class = "bg"></div>
<div class="container">
<div class="main-logo"> <img id="logo" height='90px' src="./images/logow.png" > </div>

<div class="main-header"> Login to VroomLife </div>

<div class= "main">
<form id="login" action="" method="post">
    <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Email" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password" placeholder="Password" required >
    </div>
    <div style="text-align: center;"><button type="submit" name="submit" class="btn btn-primary">Login</button></div>
</form>
</div>

<div class="main" style="text-align: center;">
    New to Rustom? <a href="register.html">Register here</a>
</div>
</div>
</body>
</html>