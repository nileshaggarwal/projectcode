<?php

session_start();

if(!isset($_SESSION['logged_in'])||(isset($_SESSION['logged_in'])&&$_SESSION['usertype']==="customer")) //user not logged in or user logged in is a customer
{
    header('location:index.php');
}

include("db.php");

$dealerid = $_SESSION['userid']; 
$dealername = $_SESSION['username'];

$query1 = "select car.carid,dealerid from car inner join owns where owns.carid=car.carid and dealerid = $dealerid order by uploadedtime desc";
$result1 = mysqli_query($con,$query1);


$statusquery = "select count(status) as soldoutcount from car inner join owns where owns.carid=car.carid and dealerid = $dealerid and status='sold out'";
$exec = mysqli_query($con,$statusquery);
$res = mysqli_fetch_assoc($exec);

$soldoutcount = $res["soldoutcount"]; 


?>

<!DOCTYPE html>
<html>

<head>
    <title><?php echo $dealername."'s " ?> Dashboard - VroomLife</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="icon" href="icon.ico">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

    <link rel="stylesheet" href="dealerstyles.css">

    <link rel="stylesheet" type="text/css" href="./css/dealerindex.css?php echo time(); ?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>



<script>
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
</script>

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

        <a id="active">Home</a>
        <a href="dealer_profile.php">Profile</a>
        <a href="dealer_sold.php">Cars Sold</a>
        <!-- <a href="dealer_rented.php">Cars Rented</a> -->


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




    <!-- this is the add entry modal -->

    <div class="bg-modal">
        <div class="modal-contents">

            <div class="close">+</div>
            <br>

            <div class="row">
                <div class="column">
                    <a href="new_form.php" id="entry">
                        <img src="./images/car2.jpg" style="width:100%;height: 85%;margin-bottom:5px">
                        <h4 style="font-weight:300;color:black">New Car</h4>
                    </a>
                </div>

                <div class="column">
                    <a href="resale_form.php" id="entry">
                        <img src="./images/car1.jpg" style="width:100%;height: 85%;margin-bottom:5px">
                        <h4 style="font-weight:300;color:black">Pre-owned Car</h4>
                    </a>
                </div>

                <!-- <div class="column">
            <a href="rental_form.php" id="entry">
            <img src="./images/car3.jpg" style="width:100%;height: 85%;margin-bottom:5px">
            <h4 style="font-weight:300;color:black">Rental Car</h4>
            </a>
          </div> -->

            </div>



        </div>
    </div>

    <div id="discount-modal">
    </div>


    <div class="container py-3">

        <!-- 
  
  search bar hidden for now 
  <form class="example" action="/action_page.php">
  <input type="text" placeholder="Search.." name="search">
  <button type="submit"><i class="fa fa-search"></i></button>
  </form>

-->

        <div class="container" style="width:80%;margin:auto;margin-top:135px;margin-bottom:35px">

            <h2 id="carname" class="display-4 text-center"><?php echo "Welcome ".$dealername."!" ?></h2>
        </div>

        <?php 

if(isset($_SESSION['deletesoldoutcar'])&&$_SESSION['deletesoldoutcar']===true)
{
?>

        <div class="alert alert-danger" role="alert">
            <b>Sorry! You can't delete a sold out or currently rented car!</b>
        </div>

        <?php
unset($_SESSION['deletesoldoutcar']);
}

if(isset($_SESSION['discountset'])&&$_SESSION['discountset']===true)
{
?>

        <div class="alert alert-info alert-dismissible fade show" role="alert">
            Discount of car has been updated!
        </div>

        <?php
unset($_SESSION['discountset']);
}

if(isset($_SESSION['newcaradded'])&&$_SESSION['newcaradded']===true)
{

?>

        <div class="alert alert-info alert-dismissible fade show" role="alert">
            New Car has been added!
        </div>

        <?php 
unset($_SESSION['newcaradded']); //destroying the session variable
}

if(isset($_SESSION['deletedcar'])&&$_SESSION['deletedcar']===true)
{
?>

        <div class="alert alert-danger" role="alert">
            Car has been deleted!
        </div>


        <?php 
unset($_SESSION['deletedcar']); //destroying the session variable
}

if($soldoutcount>0)
{
?>

        <div class="alert alert-primary alert-dismissible fade show" role="alert"
            style="display:flex;flex-direction:column">
            <b>QUICK INFO : </b>Number of cars you have sold - <?php echo $soldoutcount ?><a href="dealer_sold.php"
                style="width:fit-content">All sales details here</a>

        </div>

        <?php } ?>

        <h3 id="explore" style="font-weight:lighter;padding:20px 0;border-bottom:1px solid #C39BD3;border-width:90%">My
            Cars</h3>

        <a href="#" id="button" class="button">Add Entry</a>


        <div class="container" style="display:flex;flex-direction:column;align-items:center">
            <?php 

  if(mysqli_num_rows($result1)===0)
  {
  ?>

            <div
                style="width:100%;margin-top:15px;padding:10px 0;text-align:center;font-size:1.2rem;font-weight:350;color:black">
                No cars have been added yet! Add a car by clicking on the <i>Add entry</i> button!
            </div>



            <?php
  }
  
  $temp=0;

  while($row= mysqli_fetch_assoc($result1))
  {

  //query to get all car details
  $mainquery = "select car.carid as carid,name,status,cartype,images from car left join images on images.carid=car.carid and 
  images=(select images from images where carid=car.carid limit 1) having car.carid=".$row["carid"];
  $mainresult = mysqli_query($con,$mainquery);
  $cardet = mysqli_fetch_assoc($mainresult);
  

  if($cardet["cartype"]==='new')
  {
  $discountquery = "select discount from newcar where newcarid=".$cardet['carid'];

  if($disex= mysqli_query($con, $discountquery)) 
  {
      $discountresult= mysqli_fetch_assoc($disex);

      if($discountresult["discount"]!==null)
      {
          $discount=$discountresult["discount"];
      }
      else
      {
          $discount="0";
      }
      
  }
  }

  else if($cardet["cartype"]==='resale')
  {
  $discountquery = "select discount from preownedcar where preownedcarid=".$cardet['carid'];

  
  if($disex= mysqli_query($con, $discountquery)) 
  {
      $discountresult= mysqli_fetch_assoc($disex);

      if($discountresult["discount"]!==null)
      {
        $discount=$discountresult["discount"];
      }
      else
      {
         $discount="0";
      }
      
  }
  }

  else
  {
      $discount="0";
  }




    
  ?>
            <!-- Card Start -->




            <div style="float: left;" class="card">
                <div class="row ">

                    <div class="col-md-5">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

                            <!--<ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>-->

                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img class="d-block w-100" src="<?php echo $cardet["images"]?>" height="275px"
                                        alt="First slide">
                                </div>
                                <!--<div class="carousel-item">
                    <img class="d-block w-100" src="car2.jpg" height="275px"  alt="Second slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="car3.jpg" height="275px"  alt="Third slide">
                </div>-->
                            </div>


                            <!--<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>-->


                        </div>
                    </div>

                    <div class="col-md-7 px-3">
                        <div class="card-block px-6">

                            <div class="pull-right">

                                <div style="float:right!important;" class="btn-group">

                                    <button class="btn btn-success">
                                        Options
                                    </button>
                                    <button class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right" style="padding:10px">
                                        <!--<li> 
                                <a href="#">Edit</a> 
                            </li> -->
                                        <li style="margin:5px">
                                            <?php if($cardet["status"]!=="sold out"&&$cardet["cartype"]!=="rental"){?>
                                            <a href="javascript:void(0)" onclick="discount(<?php echo $temp ?>)">Set
                                                Discount</a>

                                            <div class="contentbox">
                                                <!--content of discount box-->


                                                Set discount for <?php echo $cardet["name"]?>

                                                <form
                                                    action="setdiscount.php?carid=<?php echo $cardet['carid']?>&cartype=<?php echo $cardet['cartype']?>&action=add"
                                                    method="POST">
                                                    <input type="number" name="discount"
                                                        style="margin-top:20px;width:150px;font-size:1rem;padding:5px"
                                                        placeholder="Discount" min="5" max="90" required>

                                                    <div style="margin-top:20px">
                                                        <button type="submit" class="btn btn-primary">Set</button>
                                                        <button type="button" class="btn btn-danger"
                                                            onclick="closediscount()">Close</button>
                                                </form>

                                            </div>


                                </div>

                                <?php 
                                $temp++;
                               }
                               ?>
                                </li>

                                <?php if($discount!=="0"&&$cardet["status"]!=="sold out"&&$cardet["cartype"]!=="rental")
                            {
                            ?>

                                <li style="margin:5px">
                                    <a
                                        href="setdiscount.php?carid=<?php echo $cardet['carid']?>&cartype=<?php echo $cardet['cartype']?>&action=remove">Remove
                                        Discount</a>
                                </li>
                                <?php
                            }
                            ?>

                                <li style="margin:5px">
                                    <a
                                        href="<?php echo "deletedealercar.php?carid=".$cardet["carid"]."&cartype=".$cardet["cartype"]."&status=".$cardet["status"] ?>">Delete</a>
                                </li>
                                </ul>
                            </div>




                        </div>
                        <h4 class="card-title"
                            style="height:35px;margin-top:2.5px;width:60%;overflow:hidden;white-space:nowrap;text-overflow:ellipsis">
                            <?php echo $cardet["name"]?></h4>
                        <hr style="margin-top:10px;min-width:90%">
                        <div style="float:left">
                            <p class="card-text">
                                <b>Car Type - </b> <?php echo $cardet["cartype"];?>



                                <?php

            if($discount!=="0"&&$cardet["status"]!=="sold out")
            {
            ?>

                                | <b>Discount - </b><?php echo $discount;?>%

                                <?php
            }
            ?>
                            </p>

                            <p class="card-text">
                                <b>Availability - </b>
                                <?php if ($cardet["status"]==="available") { ?>

                                <span style="color:#2ECC71"><?php echo $cardet["status"];?></span>

                                <?php }
            else {
              ?>

                                <span style="color:#E74C3C"><?php echo $cardet["status"];?></span>

                                <?php
            }
            ?>

                            </p>


                            <p class="card-text">
                                <?php if ($cardet["cartype"]==="new")
          {
          ?>

                                <a href="<?php echo "newcar.php?carid=".$cardet["carid"] ?>">More details</a>

                                <?php 
          }

          else if($cardet["cartype"]==="resale")
          {
          ?>

                                <a href="<?php echo "resalecar.php?carid=".$cardet["carid"] ?>">More details</a>

                                <?php 
          }
           
          else
          {
          ?>
                                <a href="<?php echo "rentalcar.php?carid=".$cardet["carid"] ?>">More details</a>
                                <?php
          }

          ?>
                            </p>


                            <!--<p class="card-text">Made for usage, commonly searched for. Fork, like and use it. 
            Just move the carousel div above the col containing the text for left alignment of images
          </p>-->


                        </div>
                    </div>
                </div>

            </div>
        </div>

        <?php
  }
  ?>

    </div>
    <!-- End of card -->



    </div>



</body>

<script>
document.getElementById('button').addEventListener("click", function() {
    document.querySelector('.bg-modal').style.display = "flex";
});

document.querySelector('.close').addEventListener("click", function() {
    document.querySelector('.bg-modal').style.display = "none";
});

function discount(count) {
    var contentbox = document.getElementsByClassName('contentbox')[count];
    var cbclone = contentbox.cloneNode(true);

    document.getElementById('discount-modal').appendChild(cbclone);

    document.getElementById('discount-modal').style.display = "flex";
    cbclone.style.display = "flex";
}

function closediscount() {
    var modal = document.getElementById('discount-modal');

    while (modal.firstChild) modal.removeChild(modal.firstChild)

    document.getElementById('discount-modal').style.display = "none";
}
</script>

<script type="text/javascript" src="JS/list.js"></script>

</html>