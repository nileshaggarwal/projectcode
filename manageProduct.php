<!DOCTYPE html>
<html>
  <head>

<meta charset="utf-8" />
<title>Manage Products </title>

</head>
<body>
<?php
require('../../db.php');

$vehicle_id =  isset($_GET['vehicleid']) ? $_GET['vehicleid'] : '';

$sql = "SELECT * FROM  `car`  ";
$result= mysqli_query($con,$sql);
$rows=mysqli_num_rows($result) ;



while($rows=$result->fetch_assoc())
{
?>
<table>
<thead>
<th>Vehicle ID </th>
<th>Car Model </th>
<th>Car Price </th>
<th>Car Brand </th>

</thead>
<tbody>
<tr>
<td><?php echo $rows['vehicle_id']; ?>  </td>
<td><?php echo $rows['model']; ?> </td>
<td><?php echo $rows['price']; ?> </td>
<td><?php echo $rows['brand']; ?> </td>
<td> <a href="delete.php?vehicleid=<?php echo $rows['vehicle_id'];?>">Delete </a>


</tr>
</tbody>

</table>
<?php
}
?>

<?php

?>
</body>



</html>