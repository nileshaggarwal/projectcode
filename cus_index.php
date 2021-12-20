<?php


session_start();

if(!isset($_SESSION['logged_in'])||(isset($_SESSION['logged_in'])&&$_SESSION['usertype']==="dealer")) 
{
    header('location:index.php');
}

include("db.php");

$cusid = $_SESSION['userid']; 
$cusname = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>

<head>
    <title><?php echo $cusname."'s " ?> Dashboard - VroomLife</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="icon" href="icon.ico">

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./css/cusindex.css?v=<?php echo time(); ?>" />

</head>



<body onload="getcardetails(<?php echo $cusid ?>)">

    <div id="list">
        <div id="closelist" onclick="openlist()">
            <svg class="bi bi-chevron-left" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="white"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M11.354 1.646a.5.5 0 010 .708L5.707 8l5.647 5.646a.5.5 0 01-.708.708l-6-6a.5.5 0 010-.708l6-6a.5.5 0 01.708 0z"
                    clip-rule="evenodd" />
            </svg>
        </div>

        <a id="active">Home</a>
        <a href="cus_profile.php">Profile</a>
        <a href="cus_purchased.php">My Purchases</a>


    </div>

    <div class="container-fluid text-white py-3" id="header"
        style="background-color:black;position:fixed;z-index:5;top:0;display:flex;align-items:center">

        <div id="listicon" onclick="openlist()">
            <svg class="bi bi-list" width="2em" height="2em" viewBox="0 0 16 16" fill="white"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M2.5 11.5A.5.5 0 013 11h10a.5.5 0 010 1H3a.5.5 0 01-.5-.5zm0-4A.5.5 0 013 7h10a.5.5 0 010 1H3a.5.5 0 01-.5-.5zm0-4A.5.5 0 013 3h10a.5.5 0 010 1H3a.5.5 0 01-.5-.5z"
                    clip-rule="evenodd" />
            </svg>
        </div>

        <a id="logout" href="logout.php">
            <svg class="bi bi-x-square" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="white"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M14 1H2a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V2a1 1 0 00-1-1zM2 0a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V2a2 2 0 00-2-2H2z"
                    clip-rule="evenodd" />
                <path fill-rule="evenodd"
                    d="M11.854 4.146a.5.5 0 010 .708l-7 7a.5.5 0 01-.708-.708l7-7a.5.5 0 01.708 0z"
                    clip-rule="evenodd" />
                <path fill-rule="evenodd" d="M4.146 4.146a.5.5 0 000 .708l7 7a.5.5 0 00.708-.708l-7-7a.5.5 0 00-.708 0z"
                    clip-rule="evenodd" />
            </svg>
        </a>



        <img src="./images/logow.png" height="50px" style="margin:auto">

    </div>

    <div class="container" style="width:80%;margin:auto;margin-top:135px">
        <h2 id="carname" class="display-4 text-center"><?php echo "Welcome ".$cusname."!" ?></h2>

    </div>


    <div class="input-group mb-3" style="width:80%;margin:auto;margin-top:65px">

        <span class="input-group-text" id="basic-addon1"
            style="position:relative;margin-right:0;background-color:#C39BD3;border:none;border-radius:0">

            <svg class="bi bi-search" width="1em" height="1em" viewBox="0 0 16 16" fill="white"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M10.442 10.442a1 1 0 011.415 0l3.85 3.85a1 1 0 01-1.414 1.415l-3.85-3.85a1 1 0 010-1.415z"
                    clip-rule="evenodd" />
                <path fill-rule="evenodd"
                    d="M6.5 12a5.5 5.5 0 100-11 5.5 5.5 0 000 11zM13 6.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"
                    clip-rule="evenodd" />
            </svg>

        </span>
        <input type="text" id="query" class="form-control shadow-none"
            placeholder="Search for cars, manufacturers and car types..." onkeyup="searchcars()" onclick="searchcars()"
            style="border-color:#C39BD3;border-radius:0;border-left:none">
    </div>


    <div class="searchbox container-fluid py-3">

    </div>

    </div>

    <div class="container-fluid py-3" style="width:80%">

        <?php if(isset($_SESSION['boughtnewcar'])&&$_SESSION['boughtnewcar']===true)
{
?>

        <div class="alert alert-primary" role="alert">
            Hooray! You just bought a new car! Go to <a href="cus_purchased.php">My Purchases</a>!
        </div>

        <?php 
unset($_SESSION['boughtnewcar']);
} ?>

        <?php if(isset($_SESSION['rentedcar'])&&$_SESSION['rentedcar']===true)
{
?>



        <?php 

} ?>

        <h3 id="explore" style="font-weight:lighter">Explore</h3>

        <div class="row">

        </div>

</body>

<script type="text/javascript" src="JS/home.js"></script>
<script type="text/javascript" src="JS/list.js"></script>

</html>