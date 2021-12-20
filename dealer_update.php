<?php
session_start();
include("db.php");
$changeflag = false;
$dealerid = $_SESSION['userid']; 
$dealername = $_SESSION['username'];


$params = array();
parse_str($_POST['formdata'], $params);


$query = "SELECT * FROM dealer WHERE dealerid = $dealerid";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);


$branch_query = "SELECT * FROM branch WHERE dealerid = $dealerid";
$branch_result = mysqli_query($con, $branch_query);

$d_name =  $params['name'];
$d_phoneno =  $params['phone'];
$d_website = $params['website'];
        
if($row['DName'] != $d_name || $row['PhoneNo'] != $d_phoneno || $row['Website'] != $d_website)
{
    $dealer_update= "UPDATE dealer SET DName=?, PhoneNo=?, Website=? WHERE dealerid = $dealerid";
    if($stmt= mysqli_prepare($con, $dealer_update) )
    {
        
        mysqli_stmt_bind_param($stmt, "sss", $d_name, $d_phoneno, $d_website);

        
        if(mysqli_stmt_execute($stmt))
        {
            $_SESSION['username'] = $d_name;
            $changeflag = true;
        }
        else
        {
            echo "Error: Could not execute the query: " . mysqli_error($con);
            header("Location: error.php");
        }        
    }
    else
    {
        echo "Error: Could not prepare the query: " . mysqli_error($con);
        header("Location: error.php");
    } 
}

$branch_count = 1;
$branch_update = "UPDATE branch SET branch= ?, location = ? WHERE dealerid = $dealerid AND branch = ? AND location =?";
if($stmt = mysqli_prepare($con, $branch_update))
{
    while($branch_row = mysqli_fetch_assoc($branch_result)) 
    {
        $new_branch = $params['branch'.$branch_count.''];
        $new_location = $params['location'.$branch_count.''];
        $old_branch = $branch_row['branch'];
        $old_location = $branch_row['location'];
        if($old_branch != $new_branch || $old_location != $new_location)
        {
            mysqli_stmt_bind_param($stmt, "ssss", $new_branch, $new_location, $old_branch, $old_location);
            if(mysqli_stmt_execute($stmt))
            {
                $changeflag = true;
            }
            else
            {
                echo "Error: Could not execute the query: " . mysqli_error($con);
                header("Location: error.php");
            }    
        }
        $branch_count++;
    }   
}
else
{
    echo "Error: Could not prepare the query: " . mysqli_error($con);
    header("Location: error.php");
} 

if($changeflag)
{
    echo "Updated Successfully!";
}
else
{
    echo "No changes made!";
}
?>