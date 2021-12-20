<?php

//this is the session check for this page
session_start();

if(!isset($_SESSION['logged_in'])||(isset($_SESSION['logged_in'])&&$_SESSION['usertype']==="dealer")) //user not logged in or user logged in is a dealer
{
    header('location:index.php');
}

include("db.php");

$cusid = $_SESSION['userid']; //getting the customer id
$cusname = $_SESSION['username'];

$carid=$_REQUEST["carid"];
$cartype=$_REQUEST["cartype"];
?>

<!DOCTYPE html>
<html>

<head>
    <title><?php echo $cusname."'s " ?> Payments - VroomLife</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="icon" href="icon.ico">
    <!--Google Fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">
    <!--BOOTSTRAP CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./css/paymentdirect.css?php echo time(); ?>" />
</head>


<body>

    <div class="input-group mb-3 paymentbox">
        <span id="title">PAYMENTS SECTION&#129297</span>

        <span style="text-align:justify">For now this is a dummy page. <b>In future, this will be redirected to a 3rd
                party payment gateway site.</b> Till then you can buy any car for free&#128540! Happy
            <i>Vrooming!</i></span>

        <div class="button" onclick="buycar(<?php echo $carid.',\''.$cartype.'\'' ?>)">Buy Car</div>
        <div class="button" style="background-color:#E74C3C;margin-top:10px" onclick="goback()">Go Back</div>

    </div>



</body>

<script>
function buycar(carid, cartype) {
    window.location.href = "buycar.php?carid=" + carid + "&cartype=" + cartype;
}

function goback() {
    window.history.back();
}
</script>

</html>