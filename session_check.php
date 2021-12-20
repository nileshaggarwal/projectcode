<?php

session_start();

if(isset($_SESSION['logged_in'])) 
{
    
    if($_SESSION["usertype"]==="customer")
    {
        header('location: cus_index.php');
    }

    else
    {
        header('location: dealer_index.php');
    }  
}
?>