<?php
if(isset($_POST["dealerRegister"]))
{

include("db.php");

//Prepared statement to prevent SQL injection
$dealer_insert= "INSERT INTO DEALER (DName, PhoneNo, Website, D_Email) VALUES (?,?,?,?)";
$d_name = mysqli_real_escape_string($con, $_REQUEST['D_name']);
$d_phoneno =  mysqli_real_escape_string($con, $_REQUEST['phone_no']);
$d_website =  mysqli_real_escape_string($con, $_REQUEST['website']);
$d_email = mysqli_real_escape_string($con, $_REQUEST['D_email']);
$d_password = mysqli_real_escape_string($con, $_REQUEST['D_password']);

if($stmt= mysqli_prepare($con, $dealer_insert) )
{
    //Bind the variables to prepared statements as parameters
     mysqli_stmt_bind_param($stmt, "ssss", $d_name, $d_phoneno, $d_website, $d_email);
  
    //Execute the statement
    if(mysqli_stmt_execute($stmt))
    {
        //echo "Inserted successfully";
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

//fetching userid
$info_query = "SELECT dealerID FROM dealer where d_email = '$d_email'";
$info_result = mysqli_query($con, $info_query);
$info = mysqli_fetch_array($info_result, MYSQLI_ASSOC);
$dealerid = $info['dealerID'];

//inserting into branch
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

//Inserting into dealer login
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
        

        
        /*$login_time = "UPDATE DEALER_LOGIN SET lastloggedintime = CURRENT_TIMESTAMP() WHERE D_Email = '$d_email'" ;
        $retval = mysqli_query($con, $login_time);
        if($retval)
        {
            //echo "Updated Successfully";
            session_start();
                   
            //storing the necessary information in session
            $_SESSION['userid'] = $dealerid;
            $_SESSION['username'] = $d_name;       
            $_SESSION['email'] = $email;
            $_SESSION['usertype'] = 'dealer';
            $_SESSION['logged_in'] = true;
            header("Location: dealer_index.php");
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