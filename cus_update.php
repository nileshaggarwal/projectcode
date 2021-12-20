<?php
session_start();
include("db.php");

$cusid = $_SESSION['userid']; 
$cusname = $_SESSION['username'];

$c_name = mysqli_real_escape_string($con, $_POST['name']);
$c_dob = mysqli_real_escape_string($con, $_POST['dob']);
$c_phoneno =  mysqli_real_escape_string($con, $_POST['phone']);
$c_address =  mysqli_real_escape_string($con, $_POST['address']);
$c_drivingLicense =  mysqli_real_escape_string($con, $_POST['dlno']);


$query = "SELECT * FROM customer WHERE customerID = $cusid";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

if($row['CustomerName'] != $c_name || $row['DOB'] != $c_dob || $row['PhoneNo'] != $c_phoneno || $row['Address'] != $c_address || $row['DrivingLicense'] != $c_drivingLicense)
{
    $customer_update= "UPDATE CUSTOMER SET CustomerName=?,  DOB=?, PhoneNo=?, Address=?, DrivingLicense=? WHERE customerid = $cusid";
    if($stmt= mysqli_prepare($con, $customer_update) )
    {
        
        mysqli_stmt_bind_param($stmt, "sssss", $c_name, $c_dob, $c_phoneno, $c_address, $c_drivingLicense);

      
        if(mysqli_stmt_execute($stmt))
        {
            $_SESSION['username'] = $c_name;
            echo "Updated Successfully!";
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
    echo "No changes made!";
} 
?>