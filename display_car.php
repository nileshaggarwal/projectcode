<?php
require('db.php');


if(isset($_GET['pageno'])) {
  $pageno= $_GET['pageno'];
} else {
  $pageno = 1;
}
$no_of_records_per_page = 1;
$offset = ($pageno-1) * $no_of_records_per_page;

if (mysqli_connect_errno()){
  echo "failed to connect to database:" . mysqli_connect_error();
  die();
}

$total_pages_sql ="SELECT COUNT(*) FROM `car`";

$result1 = mysqli_query($con,$total_pages_sql);
$total_rows = mysqli_fetch_array($result1)[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);

$sql2 = "SELECT * from `car` LIMIT $offset,$no_of_records_per_page";

$res_data = mysqli_query($con,$sql2);



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title> USER DETAILS</title>

    <link rel="stylesheet" href="display_car.css">
</head>

<body>
    <div class="display_main_info">
        <div class="display_main">
            <span>Car Dealership Website </span>
            <br />
            <button>Contact Us </button>
        </div>
    </div>

    <?php 

?>

    <div class="main_display_card">
        <?php
      //loop till end of data
      while($row = mysqli_fetch_array($res_data)){  

        $sql = "SELECT * FROM `car`";
        $result = mysqli_query($con,$sql);

     
      while($rows=$result->fetch_assoc())
      {
        ?>


        <div class="single_car_card">
            <div class="car_card_image">
                <?php  echo "<img src={$rows['img_url']} />" ?>
            </div>
            <div class="price">
                <span>$<?php echo $rows['price'] ?>
            </div>
            <div class="car_brand">
                <span><?php echo $rows['brand'];?></span>
            </div>
            <div class="car_model">
                <span><?php echo $rows['model'];?></span>
            </div>
            <br />
            <div class="kms_engine_type">
                <div class="tra">
                    <div class="trans">
                        <img src="./img/transmission.svg" alt="%" />
                    </div>
                    <div>
                        <span><?php echo $rows['transmission']; ?> </span>
                    </div>
                </div>
                <div class="yearto">
                    <div class="some_logo">
                        <img src="./img/car.svg" alt="*" />
                    </div>
                    <div>
                        <span><?php echo $rows['yearto_invent']   ?> </span>
                    </div>

                </div>

            </div>


            <div class="view_but">
                <a href="product.php?vehicleid=<?php echo $rows['vehicle_id'];?>">
                    <button>View Details </button></a>
            </div>




        </div>

        <?php
      }
    }
    mysqli_close($con);
      ?>


    </div>
    <ul class="pagination">
        <li><a href="?pageno=1">First</a></li>
        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
        </li>
        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
        </li>
        <li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
    </ul>

</body>

</html>