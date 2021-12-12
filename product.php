<?php
require('db.php');




$vehicle_id =  isset($_GET['vehicleid']) ? $_GET['vehicleid'] : '';

  $sql = "SELECT * FROM `car` WHERE vehicle_id = '$vehicle_id' "; 
$result=mysqli_query($con,$sql); 


$rows=mysqli_num_rows($result) ;
if($rows==1){

  while($car=$result->fetch_assoc()){
    ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset = "UTF-8">
    <title>Product Page</title>

   <link rel="stylesheet" href="product.css">
      </head>
      <body>

<div class = "main_product_page">
<div class="car_product_image">
  
  <?php echo "<img src={$car['img_url']} />" ?>
  
  </div>
  <div class="product_details">
    <div class="brand">
  <span> <?php echo $car['brand']  ?> </span>

  <div class="model" >
<span> <?php echo $car['model'] ?> </span>  
</div>
<br />
<br />
<div class="price">
$<span><?php echo $car['price'] ?></span>
  </div>
  <div class="buy_now">
<button > Buy Now</button>
  </div>

  </div>
  <br />
  <br/>
  


</div>
</div>
<div class="total_info">
<div class="car_engine">
  <span> Car Engine</span>
  <br />
  <br />
  <button>
<span><?php echo $car['engine']?></span>
  </button>
  </div>
  <div class="car_engine">
  <span> Car Mileage</span>
  <br />
  <br />
  <button>
<span><?php echo $car['mileage']?> kmpl</span>
  </button>
  </div>

  <div class="car_engine">
  <span> Car Manufacturer</span>
  <br />
  <br />
  <button>
<span><?php echo $car['manufacturer']?> </span>
  </button>
  </div>
  <div class="car_engine">
  <span> Car Color</span>
  <br />
  <br />
  <button>
<span><?php echo $car['color']?> </span>
  </button>
  </div>

  <div class="car_engine">
  <span> Car Transmission</span>
  <br />
  <br />
  <button>
<span><?php echo $car['transmission']?> </span>
  </button>
  </div>

  <div class="car_engine">
  <span> Car type</span>
  <br />
  <br />
  <button>
<span><?php echo $car['type']?> </span>
  </button>
  </div>

  <div class="car_engine">
  <span> Year of Manufacture</span>
  <br />
  <br />
  <button>
<span><?php echo $car['yearto_invent']?> </span>
  </button>
  </div>

  <div class="car_engine">
  <span> Make</span>
  <br />
  <br />
  <button>
<span><?php echo $car['make']?> </span>
  </button>
  </div>


  </div>

</body>
      </html>

  <?php
  }
}else{
  echo "Car no longer exists in fucker";
}






?>
