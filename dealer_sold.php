<?php

session_start();

if (!isset($_SESSION['logged_in']) || (isset($_SESSION['logged_in']) && $_SESSION['usertype'] === "customer")) {
    header('location:index.php');
}

include("db.php");

$dealerid = $_SESSION['userid'];
$dealername = $_SESSION['username'];

?>

<!DOCTYPE html>
<html>

<head>
    <title><?php echo $dealername . "'s " ?> Sales - VroomLife</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="icon" href="icon.ico">

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./css/dealersold.css?v=<?php echo time(); ?>" />
</head>

<style>

</style>

<body>

    <div id="list">
        <div id="closelist" onclick="openlist()">
            <svg class="bi bi-chevron-left" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="white"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M11.354 1.646a.5.5 0 010 .708L5.707 8l5.647 5.646a.5.5 0 01-.708.708l-6-6a.5.5 0 010-.708l6-6a.5.5 0 01.708 0z"
                    clip-rule="evenodd" />
            </svg>
        </div>

        <a href="dealer_index.php">Home</a>
        <a href="dealer_profile.php">Profile</a>
        <a id="active">Cars Sold</a>


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
        <h2 id="carname" class="display-4 text-center">Sold Cars</h2>

    </div>

    <div class="container-fluid py-3" style="width:80%">

        <h3 id="explore" style="font-weight:lighter">New Cars</h3>

        <div class="row">

            <?php

            $soldcarsquery = "
select customername,car.carid as carid,name,DATE_FORMAT(paymentdate,'%d %M %Y') as paymentdate from owns 
inner join customer inner join car inner join newcar where car.carid=newcar.newcarid and dealerid = $dealerid and 
paymentstatus='verified' and customer.customerid = newcar.customerid and car.carid=owns.carid order by paymentdate desc";
            $ex = mysqli_query($con, $soldcarsquery);

            if (mysqli_num_rows($ex) === 0) {
            ?>

            <div
                style="width:100%;border:1px solid #C39BD3;margin-top:15px;padding:10px 0;text-align:center;font-size:1.2rem;font-weight:lighter;color:black">
                No new cars sold yet!</div>

            <?php
            }

            while ($row = mysqli_fetch_assoc($ex)) {

            ?>

            <div class="col-sm-3">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row["name"] ?></h5>
                        <h6 class="card-subtitle mb-2">Sold on
                            <?php echo $row["paymentdate"] . " to " . $row["customername"] ?></h6>
                        <hr>
                        <a href="<?php echo "newcar.php?carid=" . $row["carid"] ?>" class="card-link">Car Details</a>
                    </div>
                </div>
            </div>

            <?php

            }
            ?>

        </div>

        <h3 id="explore" style="font-weight:lighter;margin-top:50px">Resale Cars</h3>

        <div class="row">


            <?php
            $soldresalecarsquery = "
select customername,car.carid as carid,name,DATE_FORMAT(paymentdate,'%d %M %Y') as paymentdate from owns 
inner join customer inner join car inner join preownedcar where car.carid=preownedcar.preownedcarid and dealerid = $dealerid and 
paymentstatus='verified' and customer.customerid = preownedcar.customerid and car.carid=owns.carid order by paymentdate desc";

            $ex2 = mysqli_query($con, $soldresalecarsquery);

            if (mysqli_num_rows($ex2) === 0) {
            ?>


            <div
                style="width:100%;border:1px solid #C39BD3;margin-top:15px;padding:10px 0;text-align:center;font-size:1.2rem;font-weight:300;color:black">
                No resale cars sold yet!</div>

            <?php
            }

            while ($row = mysqli_fetch_assoc($ex2)) {

            ?>

            <div class="col-sm-3">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row["name"] ?></h5>
                        <h6 class="card-subtitle mb-2">Sold on
                            <?php echo $row["paymentdate"] . " to " . $row["customername"] ?></h6>
                        <hr>
                        <a href="<?php echo "resalecar.php?carid=" . $row["carid"] ?>" class="card-link">Car Details</a>
                    </div>
                </div>
            </div>

            <?php } ?>

        </div>




</body>

<script type="text/javascript" src="JS/list.js"></script>

</html>