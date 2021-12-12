<?php
require('../../db.php');

$vehicle_id = $_GET['vehicleid'];

$sql="DELETE FROM car  WHERE vehicle_id = '" .$vehicle_id. "' ";

$result=mysqli_query($con,$sql);
header("Location: manageProduct.php");


// $vehicle_id = isset($_GET['vehicleid']) ? $_GET['vehicleid'] : '';

// $sql = "DELETE FROM `car` WHERE vehicle_id = '$vehicle_id' ";
// $result=mysqli_query($con,$sql);

// $rows=mysqli_num_rows($result);
// if($rows==1){
//   echo "Record Deleted Successfullly";
// } else {
//   echo "Error deleting record " .mysqli_error($con);


// }



?>