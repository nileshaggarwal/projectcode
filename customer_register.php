<?php
if(isset($_POST["customerRegister"]))
{

include("db.php");

//Prepared statement to prevent SQL injection
$customer_insert= "INSERT INTO CUSTOMER (CustomerName, DOB, PhoneNo, Address, DrivingLicense, C_Email) VALUES (?,?,?,?,?,?)";
//set parameters
$c_name = mysqli_real_escape_string($con, $_REQUEST['C_name']);
$c_dob = mysqli_real_escape_string($con, $_REQUEST['C_DOB']);
$c_phoneno =  mysqli_real_escape_string($con, $_REQUEST['C_phoneNo']);
$c_address =  mysqli_real_escape_string($con, $_REQUEST['C_address']);
$c_drivingLicense =  mysqli_real_escape_string($con, $_REQUEST['C_drivingLicense']);
$c_email = mysqli_real_escape_string($con, $_REQUEST['C_email']);
$c_password = mysqli_real_escape_string($con, $_REQUEST['C_password']);

if($stmt= mysqli_prepare($con, $customer_insert) )
{
    //Bind the variables to prepared statements as parameters
     mysqli_stmt_bind_param($stmt, "ssssss", $c_name,  $c_dob, $c_phoneno, $c_address, $c_drivingLicense, $c_email);
   
    //Execute the statement
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
        

        /*$login_time = "UPDATE CUSTOMER_LOGIN SET lastloggedintime = CURRENT_TIMESTAMP() WHERE C_Email = '$c_email'" ;
        $retval = mysqli_query($con, $login_time);

        $get_cus_id = "SELECT customerid FROM Customer where customername='$c_name'";
        $result =  mysqli_query($con, $get_cus_id);
        $resfet = mysqli_fetch_assoc($result);

        $cusid = $resfet["customerid"];

        
        if($retval)
        {
            //echo "Updated Successfully";
            session_start();

            $info_query = "SELECT customerID FROM customer where c_email = '$c_email'";
            $info_result = mysqli_query($con, $info_query);
            $info = mysqli_fetch_array($info_result, MYSQLI_ASSOC);
        
        //storing the necessary information in session
            $_SESSION['userid'] = $info['customerID'];
            $_SESSION['username'] = $c_name;       
            $_SESSION['email'] = $email;
            $_SESSION['usertype'] = 'customer';
            $_SESSION['logged_in'] = true;
            
            header("Location: cus_index.php"); //moving in to customer dashboard
        }
        else
        {
            echo "Error: Could not update: ". mysqli_error($con);
            header("Location: error.php");
        }*/
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

