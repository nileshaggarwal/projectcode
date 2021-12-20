<?php 

session_start();

if(!isset($_SESSION['logged_in'])||(isset($_SESSION['logged_in'])&&$_SESSION['usertype']==="dealer")) 
{
    header('location:index.php');
}

include("db.php");

$cusid = $_SESSION['userid']; 
$carid=$_REQUEST["carid"];
$cartype=$_REQUEST["cartype"];

if($cartype==="new")
{
    $buycarquery = "update newcar set customerid = $cusid,paymentstatus = 'verified',paymentdate = CURDATE() ,paymentstatuschangetime = CURRENT_TIMESTAMP() where newcarid = $carid";

    if(mysqli_query($con,$buycarquery))
    {
        $soldoutquery = "update car set status = 'sold out' where carid = $carid";

        if(mysqli_query($con,$soldoutquery))
        {
        $_SESSION["boughtnewcar"]=true; 
        header("location:cus_index.php");
        }

        else
        {
            echo "Some error occured while trying to update the car table!";
            header("Location: error.php");
        }
    }

    else
    {
        echo "Some error occured while buying the car! Please try again!";
        header("Location: error.php");
    }
}

else 
{
    $buycarquery = "update preownedcar set customerid = $cusid,paymentstatus = 'verified',paymentdate = CURDATE() ,paymentstatuschangetime = CURRENT_TIMESTAMP() where preownedcarid = $carid";

    if(mysqli_query($con,$buycarquery))
    {
        $soldoutquery = "update car set status = 'sold out' where carid = $carid";

        if(mysqli_query($con,$soldoutquery))
        {
        $_SESSION["boughtnewcar"]=true; 
        header("location:cus_index.php");
        }

        else
        {
            echo "Some error occured while trying to update the car table!";
            header("Location: error.php");
        }
    }

    else
    {
        echo "Some error occured while buying the car! Please try again!";
        header("Location: error.php");
    }

}
?>