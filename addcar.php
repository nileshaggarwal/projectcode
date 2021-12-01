<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Add Car</title>
        <link rel="stylesheet" href="styles.css" />
</head>
<body>
    <?php
    require('db.php');
    if(
        isset($_POST['engine'])&&
        isset($_POST['mileage'])&&
        isset($_POST['brand'])&&
        isset($_POST['manufacturer'])&&
        isset($_POST['transmission'])&&
        isset($_POST['color'])&&
        isset($_POST['model'])&&
        isset($_POST['type'])&&
        isset($_POST['price'])&&
        isset($_POST['make'])&&
        isset($_POST['img_url'])
    ){
        $engine=stripslashes($_POST['engine']);
        $engine=mysqli_real_escape_string($con,$engine);
        $mileage=stripslashes($_POST['mileage']);
        $mileage=mysqli_real_escape_string($con,$mileage);
        $brand=stripslashes($_POST['brand']);
        $brand=mysqli_real_escape_string($con,$brand);
        $manufacturer=stripslashes($_POST['manufacturer']);
        $manufacturer=mysqli_real_escape_string($con,$manufacturer);
        $transmission=stripslashes($_POST['transmission']);
        $transmission=mysqli_real_escape_string($con,$transmission);
        $color=stripslashes($_POST['color']);
        $color=mysqli_real_escape_string($con,$color);
        $model=stripslashes($_POST['model']);
        $model=mysqli_real_escape_string($con,$model);
        $type=stripslashes($_POST['type']);
        $type=mysqli_real_escape_string($con,$type);
        $price=stripslashes($_POST['price']);
        $price=mysqli_real_escape_string($con,$price);
        $make=stripslashes($_POST['make']);
        $make=mysqli_real_escape_string($con,$make);
        $img_url=$_POST['img_url'];
        $yearto_invent=date("Y");
        $query="INSERT into `car` (engine,mileage,brand,manufacturer,transmission,color,model,type,yearto_invent,price,make,img_url)
                VALUES ('$engine','$mileage','$brand','$manufacturer','$transmission','$color','$model','$type','$yearto_invent','$price','$make','$img_url')";
        $result=mysqli_query($con,$query);
        if($result){
            echo "New record created successfully";
        }else{
            echo "<br><h2><center>Enter all values</center></h2>";
        }
    }  else{ 
    ?>
    <form action="" method="post">
        <h1>Add Product</h1>
        <input type="text" name="engine" placeholder="Engine Number" />
        <input type="number" name="mileage" placeholder="Mileage">
        <input type="text" name="brand" placeholder="Brand">
        <input type="text" name="manufacturer" placeholder="Manufacturer">
        <input type="text" name="transmission" placeholder="Transmission Type(Auto for automatic & manual for Manual)">
        <input type="text" name="color" placeholder="Color">
        <input type="number" name="model" placeholder="Model Year">
        <input type="text" name="type" placeholder="Type of Car">
        <input type="number" name="price" placeholder="Price">
        <input type="text" name="make" placeholder="Car Make">
        <input type="text" name="img_url" placeholder="Upload a link to the image">
        <input type="submit" name="submit" value="Add Car">
    </form>
<?php 
    }
    ?>
</body>
</html>