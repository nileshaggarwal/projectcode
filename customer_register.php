<?php
if(isset($_POST["customerRegister"]))
{

include("db.php");


$customer_insert= "INSERT INTO CUSTOMER (CustomerName, DOB, PhoneNo, Address, DrivingLicense, C_Email) VALUES (?,?,?,?,?,?)";

$c_name = mysqli_real_escape_string($con, $_REQUEST['C_name']);
$c_dob = mysqli_real_escape_string($con, $_REQUEST['C_DOB']);
$c_phoneno =  mysqli_real_escape_string($con, $_REQUEST['C_phoneNo']);
$c_address =  mysqli_real_escape_string($con, $_REQUEST['C_address']);
$c_drivingLicense =  mysqli_real_escape_string($con, $_REQUEST['C_drivingLicense']);
$c_email = mysqli_real_escape_string($con, $_REQUEST['C_email']);
$c_password = mysqli_real_escape_string($con, $_REQUEST['C_password']);

if($stmt= mysqli_prepare($con, $customer_insert) )
{

     mysqli_stmt_bind_param($stmt, "ssssss", $c_name,  $c_dob, $c_phoneno, $c_address, $c_drivingLicense, $c_email);
   
    
    if(mysqli_stmt_execute($stmt))
    {
        echo "Inserted successfully";
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

$customer_login = "INSERT INTO CUSTOMER_LOGIN (C_Email, Password, vkey) VALUES (?, ?, ?)";
$vkey = random_int(100000, 999999);
$c_password=md5($c_password);

if($stmt = mysqli_prepare($con, $customer_login))
{
    mysqli_stmt_bind_param($stmt, "sss", $c_email, $c_password, $vkey); 
      
    if(mysqli_stmt_execute($stmt))
    {
        $to=$c_email;
            $subject='OTP Confirmation';
            $message='Please Use this Otp:'.$vkey.'Please enter it on to confirm your account';
            $header='From: artistry.goa@gmail.com';
            if(mail($to,$subject,$message,$header))
                header("Location: custotp.php?user=".$c_email);
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

