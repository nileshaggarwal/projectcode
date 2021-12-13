<?php
session_start();
include("db.php");

$userid = $_SESSION['userid'];
$email = $_SESSION['email'];
$usertype = $_SESSION['usertype'];
$password = mysqli_real_escape_string($conn, $_POST['password']);
$password= md5($password);

if($usertype === "customer")
{
    $query = "SELECT Password FROM customer_login WHERE C_Email = '$email'";
    $result = mysqli_query($con, $query);
    $row =mysqli_fetch_assoc($result);
    if($password === $row['Password'])
    {
        echo "Password Verified!";
    }
    else
    {
        echo "Invalid Password!";
    }
}
else
{
    $query = "SELECT Password FROM dealer_login WHERE D_Email = '$email'";
    $result = mysqli_query($con, $query);
    $row =mysqli_fetch_assoc($result);
    if($password === $row['Password'])
    {
        echo "Password Verified!";
    }
    else
    {
        echo "Invalid Password!";
    }
}
?>