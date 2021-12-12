<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Account Verification-VroomLife</title>
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
        
        
        <?php 
        require('db.php');
        if(isset($_REQUEST['otp']))  {
            $otp=stripslashes($_REQUEST['otp']);
            $otp=mysqli_real_escape_string($con,$otp);
            $email=stripslashes($_GET['user']);
            $email=mysqli_real_escape_string($con,$email);
            $query="SELECT * FROM `dealer_login` WHERE D_Email='$email' AND vkey='$otp'";
            $result   = mysqli_query($con, $query) or die(mysql_error());
            $rows=mysqli_num_rows($result);
            if($rows==1){
                $change="UPDATE `dealer_login` SET verified=1 WHERE D_Email='$email'";
                $res=mysqli_query($con,$change);
                if($res){
                    header("Location:login.php");
                }
            }else{
                echo "<div class='form'>
                  <h3>Incorrect OTP.</h3><br/>
                  <p class='link'>Please enter again</p>
                  <p class='link'><a href='otp.php?user=$email'>Try Again</a></p>
                  </div>";
            }
        }else{
            ?>
        <form class="form" method="post">
            <h1 class="login-title">
                OTP Verification
            </h1>
            <input type="text" class="login-input" name="otp" placeholder="Please Enter OTP" autofocus="true" />
            <input type="submit" value="Verify" class="login-button"/>
            </form>
        <?php
            }
        ?>

</body>
</html>

