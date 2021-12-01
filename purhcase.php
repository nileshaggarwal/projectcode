<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Purchase</title>
</head>
<body>
    <?php
        require('db.php');
        if(
            isset($_POST['address'])&&
            isset($_POST['payment_mode'])&&
            isset($_POST['purchaser_name'])
        ){
            $purchaser_name=stripslashes($_POST['purchaser_name']);
            $purchaser_name=mysqli_real_escape_string($con,$purchaser_name);
            $address=stripslashes($_POST['address']);
            $address=mysqli_real_escape_string($con,$address);
            $payment_mode=stripslashes($_POST['payment_mode']);
            $payment_mode=mysqli_real_escape_string($con,$payment_mode);
            $purchase_id=random_int(10000000000,99999999999);
            $purchase_date=date("Y-m-d");
            $vehicle_id=$_GET['car'];
            $vehicle_id=mysqli_real_escape_string($con,$vehicle_id);
            $user_id=$_GET['user'];
            $user_id=mysqli_real_escape_string($con,$user_id);
            $query="INSERT INTO `purchases` (purchase_id,vehicle_id,user_id,purchase_date,address,payment_mode,payment_info)
            VALUES ('$purchase_id','$vehicle_id','$user_id','$purchase_date','$address','$payment_mode','$payment_info')";
            $result=mysqli_query($con,$query);
            if($result){
                header("Location:purchaseinfo.php?purchase_id=".$purchase_id."?vehicle_id=".$vehicle_id);
            }else{
                echo "Your Purchase failed due to some technical error please try again later,
                Till then you can explore our other various cars,
                <a href=''>Explore Again</a>";
            }
        }else{
            ?>
            <form action="" method="POST">
            <h1>Checkout Page</h1>
            <p>Please enter the required details</p>
            <input type="text" name="purchaser_name" placeholder="Enter Purchaser Name"
            <input type="radio" name="payment_mode" id="card" />
            <label for="card">Card</label>
            <input type="submit" value="Proceed">
       <?php
        }
        ?>
</body>
</html>
    