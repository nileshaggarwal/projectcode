<?php
if(isset($_POST["dealerRegister"]))
{

include("db.php");


$dealer_insert= "INSERT INTO DEALER (DName, PhoneNo, Website, D_Email) VALUES (?,?,?,?)";
$d_name = mysqli_real_escape_string($con, $_REQUEST['D_name']);
$d_phoneno =  mysqli_real_escape_string($con, $_REQUEST['phone_no']);
$d_website =  mysqli_real_escape_string($con, $_REQUEST['website']);
$d_email = mysqli_real_escape_string($con, $_REQUEST['D_email']);
$d_password = mysqli_real_escape_string($con, $_REQUEST['D_password']);

if($stmt= mysqli_prepare($con, $dealer_insert) )
{
   
     mysqli_stmt_bind_param($stmt, "ssss", $d_name, $d_phoneno, $d_website, $d_email);
  
    
    if(mysqli_stmt_execute($stmt))
    {
        
    }   
    else
    {
        echo "Error: Could not execute the query: " . mysqli_error($con);
        header("Location: error.php");
    }
}
else
{
    echo "Error: Could not prepare the query: " . mysqli_error($con);
    header("Location: error.php");
}


$info_query = "SELECT dealerID FROM dealer where d_email = '$d_email'";
$info_result = mysqli_query($con, $info_query);
$info = mysqli_fetch_array($info_result, MYSQLI_ASSOC);
$dealerid = $info['dealerID'];


$branch_count = 1;
$branch = "";
$location = "";
if(isset($_POST['branch'.$branch_count.'']))
{
    $branch = mysqli_real_escape_string($con,$_POST['branch'.$branch_count.'']);
}
if(isset($_POST['location'.$branch_count.'']))
{
    $location = mysqli_real_escape_string($con,$_POST['location'.$branch_count.'']);
}
$branch_insert = "INSERT INTO branch VALUES (?,?,?)";
if($stmt = mysqli_prepare($con, $branch_insert))
{
    while($branch !== '' && $location !== '')
    {
        mysqli_stmt_bind_param($stmt, "iss", $dealerid, $branch, $location);
        if(mysqli_stmt_execute($stmt))
        {
            echo "Branch $branch_count Inserted successfully";
            $branch_count++;
            $branch = "";
            $location = "";
            if(isset($_POST['branch'.$branch_count.'']))
            {
                $branch = mysqli_real_escape_string($con,$_POST['branch'.$branch_count.'']);
            }
            if(isset($_POST['location'.$branch_count.'']))
            {
                $location = mysqli_real_escape_string($con,$_POST['location'.$branch_count.'']);
            }
            if($branch === '' || $location === '')
            {
                $branch_count--;
            }
        }
        else
        {
            echo "Error: Could not execute the query: " . mysqli_error($con);
            header("Location: error.php");
        }
    }
}
else
{
    echo "Error: Could not prepare the query: " . mysqli_error($con);
    header("Location: error.php");
}

$dealer_login = "INSERT INTO DEALER_LOGIN (D_Email, Password, vkey) VALUES (?, ?, ?)";
$vkey = random_int(100000, 999999);
$d_password=md5($d_password);

if($stmt = mysqli_prepare($con, $dealer_login))
{
    mysqli_stmt_bind_param($stmt, "sss", $d_email, $d_password, $vkey); 
      
    if(mysqli_stmt_execute($stmt))
    {
            $to=$d_email;
            $subject='OTP Confirmation';
            $message='Please Use this Otp:'.$vkey.'Please enter it on to confirm your account';
            $header='From: artistry.goa@gmail.com';
            if(mail($to,$subject,$message,$header))
                header("Location: otp.php?user=".$d_email);
            else
                echo "Email sending failed";
        

      
    }
    else
    {
        echo "Error: Could not execute the query: " . mysqli_error($con);
        header("Location: error.php");
    }
}
else
{
    echo "Error: Could not prepare the query: " . mysqli_error($con);
    header("Location: error.php");
} 
}
else
{
    header("location: register.html");
}
?>