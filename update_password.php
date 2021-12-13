<?php
session_start();
include("db.php");

$userid = $_SESSION['userid'];
$email = $_SESSION['email'];
$usertype = $_SESSION['usertype'];
$password = mysqli_real_escape_string($con, $_POST['password']);
$password= md5($password);

if($usertype === "customer")
{
    $update = "UPDATE customer_login SET Password = ? WHERE C_Email = ?";
    if($stmt= mysqli_prepare($con, $update) )
    {
        //Bind the variables to prepared statements as parameters
        mysqli_stmt_bind_param($stmt, "ss", $password, $email);

        //Execute the statement
        if(mysqli_stmt_execute($stmt))
        {
            echo "Password Updated Successfully!";
        }
        else
        {
            echo "Error: Could not execute the query: " . mysqli_error($con);
            header('location: Login/login.php');
        } 
    }
    else
    {
        echo "Error: Could not prepare the query: " . mysqli_error($con);
        header('location: Login/login.php');
    }
}
else
{
    $update = "UPDATE dealer_login SET Password = ? WHERE D_Email = ?";
    if($stmt= mysqli_prepare($con, $update) )
    {
        //Bind the variables to prepared statements as parameters
        mysqli_stmt_bind_param($stmt, "ss", $password, $email);

        //Execute the statement
        if(mysqli_stmt_execute($stmt))
        {
            echo "Password Updated Successfully!";
        }
        else
        {
            echo "Error: Could not execute the query: " . mysqli_error($con);
            header('location: Login/login.php');
        } 
    }
    else
    {
        echo "Error: Could not prepare the query: " . mysqli_error($con);
        header('location: Login/login.php');
    }
}
?>