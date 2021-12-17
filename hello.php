<?php
    session_start();
    include("db.php");
    $query1="Select accessoryid from accessories";
    $vehicle_id=$_GET['car'];
    $result1=mysqli_query($con,$query1);
    $res1=mysqli_fetch_assoc($result1);
    $rows=mysqli_num_rows($result1);
    $accessoriesarr=array();
    if($rows>0){
        $i=0;
        $j=1;
        while($i<$rows)
        {
            $accessory."_".[$j]=mysqli_real_escape_string($con,$_POST["$accessoryid[$j]"]);
            $i++;
            $j++;
            if($accessory."_".[$j]!=""){
                array_push($accessoriesarr,$$accessory."_".[$j]);
            }
        }
    }
    $arrlength=sizeof($accessoriesarr);
    $i=0;
    if($arrlength>0){
    while($i<$arrlength){
        $accessoriesquery="insert into accessorychosen values ($vehicle_id,'$accessoriesarr[$i]')";
        if(!mysqli_query($con, $accessoriesquery))
                {
                  echo "Error while inserting Accessory into table!";
                  header("Location: error.php");
                }
        $i++;
    }}

    $mainquery="select cartype from car where carid=".$vehicle_id;
    $mainresult = mysqli_query($con,$mainquery);
    $cardet = mysqli_fetch_assoc($mainresult);
    if($cardet['cartype']=='new'){
        $subquery="select price,discount from newcar where newcarid=".$vehicle_id;
        $subresults=mysqli_query($con,$subquery);
        $ans=mysqli_fetch_assoc($subresults);
        $discount=$ans["discount"];
        $disprice=floor(($discount/100)*$ans["Price"]);
        $newprice=$ans["Price"]-$disprice;
    }
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

    $updatequery="update newcar set totalprice=$totalprice where newcarid=$vehicle_id";
    $ex = mysqli_query($con,$updatequery);
?>