<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Login</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
<?php
    require('db.php');
    session_start();
    // When form submitted, check and create user session.
    if (isset($_POST['username'])) {
        $username = stripslashes($_REQUEST['username']);    // removes backslashes
        $username = mysqli_real_escape_string($con, $username);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        // Check user is exist in the database
        $query    = "SELECT * FROM `users` WHERE username='$username'
                     AND password='" . md5($password) . "'";
        $result = mysqli_query($con, $query) or die(mysql_error());
        $value=mysqli_fetch_assoc($result);    
        $emailto=$value["email"];
        
        $rows = mysqli_num_rows($result);
        if ($rows == 1) {
            $check="SELECT * FROM `users` WHERE username='$username' AND status='active'";
            $verify=mysqli_query($con,$check);
            $user=mysqli_num_rows($verify);
            
            if($user==1){
                $_SESSION['username'] = $username;
            // Redirect to user dashboard page
                header("Location: dashboard.php");
            }else{
                echo "<div class='form'>
                  <h3>Not verified</h3><br/>
                  <p class='link'><a href='otp.php?user=$emailto']>Verify Now</a></p>
                  </div>";
            }
            
        } else {
            echo "<div class='form'>
                  <h3>Incorrect Username/password.</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a> again.</p>
                  </div>";
        }
    } else {
?>
    <form class="form" method="post" name="login">
        <h1 class="login-title">Login</h1>
        <input type="text" class="login-input" name="username" placeholder="Username" autofocus="true"/>
        <input type="password" class="login-input" name="password" placeholder="Password"/>
        <input type="submit" value="Login" name="submit" class="login-button"/>
        <p class="link">Don't have an account? <a href="register.html">Registration Now</a></p>
  </form>
<?php
    }
?>
</body>
</html>
