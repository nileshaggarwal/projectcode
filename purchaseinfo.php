<!DOCTYPE html>
<html>
    <head>
        <title>Purchase_info</title>
        <meta charset="utf-8" />
    </head>
    <body>
        <?php
        require('dp.php');
        if(
            isset($_POST['cardnumber'])&&
            isset($_POST['nameoncard'])&&
            isset($_POST['expirymm'])&&
            isset($_POST['expiryy'])
        ){
            $cardnumber=stripslashes($_POST['cardnumber']);
            $cardnumber=mysqli_real_escape_string($con,$cardnumber);
            $nameoncard=stripslashes($_POST['nameoncard']);
            $nameoncard=mysqli_real_escape_string($con,$nameoncard);
            $expirymm=stripslashes($_POST['expirymm']);
            $expirymm=mysqli_real_escape_string($con,$expirymm);
            $expiryy=stripslashes($_POST['expiryy']);
            $expiryy=mysqli_real_escape_string($con,$expiryy);
            $purchase_id=stripslashes($_GET['purchase_id']);
            $purchase_id=mysqli_real_escape_string($con,$purchase_id);
            $vehicle_id=stripslashes($_GET['vehicle_id']);
            $vehicle_id=mysqli_real_escape_string($con,$vehicle_id);
            $query="INSERT INTO `purchaseinfor` (cardnumber,purchase_id,nameoncard,expirymm,expiryy)
            VALUES ('$cardnumber','$purchase_id','$nameoncard','$expirymm','$expiryy')";
            $result=mysqli_query($con,$query);
            if($result){
                $subquery="UPDATE `car` set stock='0' WHERE vehicle_id='$vehicle_id'";
                $subresult=mysqli_query($con,$subquery);
                if($subresult){
                    header("Location:display_car.php");
                }
            }else{
                echo "<p>Purchase Failed</p>
                      <a href='/product.php?vehicleid=$vehicle_id'>Go back to product page</a>";
            }
        }else{
        ?>
        <form action="" method="post">
            <h1>Enter Payment Details</h1>
            <input type="number" name="cardnumber" placeholder="Enter Card Number" />
            <input type="text" name="nameoncard" placeholder="Enter Name on Card" />
            <input type="number" name="expirymm" placeholder="Enter expiry Month" />
            <input type="number" name="expiryy" placeholder="Enter expiry Year" />
            <button type="Submit">Confirm Purchase</button>
        </form>
        <?php
        }
        ?>
    </body>
    </html>