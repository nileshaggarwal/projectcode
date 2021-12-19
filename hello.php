<!DOCTYPE>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="assesories.css?v=<?php echo time(); ?>" />
    <!--Google Fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">
    <!--BOOTSTRAP CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
    body {
        font-family: "Open Sans", sans-serif;
    }
    </style>
</head>

<?php
    session_start();
    if(!isset($_SESSION['logged_in'])||(isset($_SESSION['logged_in'])&&$_SESSION['usertype']==="dealer")) //user not logged in or user logged in is a dealer
{
    header('location:index.php');
}

include("db.php");

$username=$_SESSION['username'];

$sql = "SELECT * FROM `accessories`";
$result = mysqli_query($con,$sql);

if(isset($_POST['addaccessory'])){
    $query1="Select accessoryid from accessories";
    $vehicle_id=$_GET['carid'];
    $cartype=$_REQUEST["cartype"];
    $result1=mysqli_query($con,$query1);
    $res1=mysqli_fetch_assoc($result1);
    $rows=mysqli_num_rows($result1);
    $accessoriesarr=array();
    if($rows>0){
        $i=0;
        $j=1;
        while($i<$rows)
        {
            
            $accessoryvalue=$_POST["accessoryid$j"];
            ${"accessory".$j}=mysqli_real_escape_string($con,$accessoryvalue);
            
            if(strlen(${"accessory".$j})>0){
                array_push($accessoriesarr,${"accessory".$j});
                $i++;
                $j++;
            }else{
                $i++;
                $j++;
            }
        }
    }
    $arrlength=sizeof($accessoriesarr);
    $i=0;
    if($arrlength>0){
    while($i<$arrlength){
        $accessoriesquery="insert into accessorychosen values ('$accessoriesarr[$i]',$vehicle_id)";
        if(!mysqli_query($con, $accessoriesquery))
                {
                  echo "Error while inserting Accessory into table!";
                  header("Location: error.php");
                }
        $i++;
    }}

    
    if($cartype=='new'){
        $subquery="select price,discount from newcar where newcarid=".$vehicle_id;
        $subresults=mysqli_query($con,$subquery);
        $ans=mysqli_fetch_assoc($subresults);
        if($ans["discount"]!==null){ 
        $discount=$ans["discount"];
        }else{
          $discount=0;
        }
        $disprice=floor(($discount/100)*$ans["price"]);
        $newprice=$ans["price"]-$disprice;
        $totalprice=$newprice;
    $i=0;
    if($arrlength>0){
        while($i<$arrlength){
            $getpricequery="select accessoryprice from accessories where accessoryid=".$accessoriesarr[$i];
            $getprice=mysqli_query($con,$getpricequery);
            $get=mysqli_fetch_assoc($getprice);
            $assprice=$get['accessoryprice'];
            $totalprice=$totalprice+$assprice;
            $i++;
        }}

    $updatequery="UPDATE newcar SET totalprice=$totalprice WHERE newcarid=$vehicle_id";
    $ex = mysqli_query($con,$updatequery);
    }else if($cartype=='resale'){
        $subquery="select price,discount from preownedcar where preownedcarid=".$vehicle_id;
        $subresults=mysqli_query($con,$subquery);
        $ans=mysqli_fetch_assoc($subresults);
        $discount=$ans["discount"];
        $disprice=floor(($discount/100)*$ans["Price"]);
        $newprice=$ans["Price"]-$disprice;
        $totalprice=$newprice;
    $i=0;
    if($arrlength>0){
        while($i<$arrlength){
            $getpricequery="select accessoryprice from accessories where accessoryid=".$accessoriesarr[$i];
            $getprice=mysqli_query($con,$getpricequery);
            $get=mysqli_fetch_assoc($getprice);
            $assprice=$get['accessoryprice'];
            $totalprice=$totalprice+$assprice;
            $i++;
        }}

    $updatequery="update preownedcar set totalprice=$totalprice where newcarid=$vehicle_id";
    $ex = mysqli_query($con,$updatequery);
    }
    header("Location:paymentredirect.php?carid=".$vehicle_id."&cartype=".$cartype);}
?>

<body>
    <h4 class="display-4 text-center username">Hello <?php echo $username ?></h4>
    <p class="accessories text-center">Choose some Accessories for your purchase</p>
    <div class="assesories_main">
        <div class="main_assec">
            <div class="ass_table">
                <div class="ass_check">
                    <span>Check</span>
                </div>
                <div class="ass_image">
                    <span>Image </spam>
                </div>
                <div class="ass_name">
                    <span>Assesories Name </span>
                </div>

                <div class="ass_description">
                    <span> Assesories Description</span>
                </div>
                <div class="ass_price">
                    <span>Assesories Price </span>
                </div>
            </div>
            <form action="" method="POST">
                <?php
        while($rows =$result -> fetch_assoc())
        {
          ?>
                <div class="ass_table1">
                    <div class="ass_check1">
                        <input type="checkbox" name="accessoryid<?php echo $rows['accessoryid'] ?>"
                            value=<?php echo $rows['accessoryid'] ?> class="check_ass" />
                    </div>
                    <div class="ass_image1">
                        <div class="imagediv"> <img src=<?php  echo $rows['accessoryphoto'] ?> alt="%" /></div>
                    </div>
                    <div class="ass_name1">
                        <span><?php  echo $rows['accessoryname']?>accessoryid<?php echo $rows['accessoryid'] ?> </span>
                    </div>
                    <div class="ass_description1">
                        <span> <?php echo $rows['accessorydescription']?></span>
                    </div>
                    <div class="ass_price1">
                        <span><?php echo $rows['accessoryprice']?> </span>
                    </div>


                </div>

                <?php

        }
?>

                <button class="purchasebutton" type="submit" name="addaccessory">Purchase this car</button>
            </form>
        </div>
    </div>
</body>

</html>