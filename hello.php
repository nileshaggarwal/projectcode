<?php
    session_start();
    include("db.php");
    $query1="Select accessoryid from accessories";
    $result1=mysqli_query($con,$query1);
    $res1=mysqli_fetch_assoc($result1);
    $rows=mysqli_num_rows($result1);
    if($rows>0){
        $i=1;
        while($i<=$rows)
        {
            $accessory."_".[$i]=mysqli_real_escape_string($con,$_POST["$accessoryid[$i]"]);
            $i++;
        }
    }
    
?>