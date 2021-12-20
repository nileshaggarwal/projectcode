<?php


session_start();

if(!isset($_SESSION['logged_in'])||(isset($_SESSION['logged_in'])&&$_SESSION['usertype']==="customer")) //user not logged in or user logged in is a customer
{
    header('location:index.php');
}

include("db.php");

$dealerid = $_SESSION['userid']; //getting the dealer id
$dealername = $_SESSION['username'];

if(isset($_POST["submit"]))
{

$m_name = mysqli_real_escape_string($con, $_POST["m_name"]);

$query1 = "Select manufacturerid from manufacturer where mname = '$m_name'";
$ex1 = mysqli_query($con, $query1);
$res1 = mysqli_fetch_assoc($ex1);

$m_id = $res1["manufacturerid"];

$resaleprice = mysqli_real_escape_string($con, $_POST["resaleprice"]);
$kmdriven = mysqli_real_escape_string($con, $_POST["kmdriven"]);
$licenseplateno = mysqli_real_escape_string($con, $_POST["licenseplateno"]);
//prepared statement
$prepstat = "insert into car(name,cartype,mileage,color,status,fueltype,manufacturedate,licenseplateno,manufacturerid) values (?,'resale',?,?,'available',?,?,?,?)";

if($stmt = mysqli_prepare($con, $prepstat))
{

//binding variables
$name = mysqli_real_escape_string($con, $_POST["name"]);
$color = mysqli_real_escape_string($con, $_POST["color"]);
$mileage = mysqli_real_escape_string($con, $_POST["mileage"]);
$m_date = mysqli_real_escape_string($con, $_POST["m_date"]);
$fueltype = mysqli_real_escape_string($con, $_POST["fueltype"]);

//echo $name." ".$color." ".$mileage." ".$m_date." ".$fueltype." ".$price." ".$m_id;

mysqli_stmt_bind_param($stmt, "sssssss", $name,  $mileage, $color, $fueltype, $m_date,$licenseplateno, $m_id);

    if(mysqli_stmt_execute($stmt))
    {
        //echo "Inserted successfully into cars table";

        $query2 = "Select carid from car where name = '$name' order by uploadedtime desc limit 1";
        $ex2 = mysqli_query($con, $query2);
        $res2 = mysqli_fetch_assoc($ex2);

        $car_id = $res2["carid"];


        $ownsquery = "insert into owns values ($car_id,$dealerid)";

        if(mysqli_query($con, $ownsquery))
        {

          $priceinsertquery = "insert into preownedcar(preownedcarid,kmdriven,resaleprice) values ($car_id,$kmdriven,$resaleprice)";
        
        
            if(mysqli_query($con, $priceinsertquery))
            {
            //echo "Inserted successfully into newcar table!";
            
            $f1 = mysqli_real_escape_string($con, $_POST["f1"]);
            $f2 = mysqli_real_escape_string($con, $_POST["f2"]);
            $f3 = mysqli_real_escape_string($con, $_POST["f3"]);
            $f4 = mysqli_real_escape_string($con, $_POST["f4"]);

            $featuresarr = array($f1,$f2,$f3,$f4);

            $i = 0;

            while($i<4)
            {

              $featurequery = "insert into features values ($car_id,'$featuresarr[$i]')";
        
                if(!mysqli_query($con, $featurequery))
                {
                  echo "Error while inserting feature into table!";
                  header("Location: error.php");
                } 

                $i++;
            }

            //inserting image into table

            if(isset($_FILES['carimage']))
            {
              $target_dir = "Images/";
              $file_name = $_FILES['carimage']['name']; //original name of file in client's computer
              $file_tmp = $_FILES['carimage']['tmp_name'];  //temp name stored in server until processing

              $imageFileType = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));

              if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") 
              {
              //echo "Sorry only JPG, JPEG, PNG files are allowed.";
              header("location:error.php");
              }

              else
              {

              if(!is_dir($target_dir. $car_id ."/")) { //creating a new directory for that car
                  mkdir($target_dir. $car_id ."/");
              }

              $target_dir = $target_dir. $car_id."/"; //changing the target directory

              $newfilename="1.".$imageFileType;
              move_uploaded_file($file_tmp, $target_dir.$newfilename); //uploading file to the given directory

              $imgpath=$target_dir.$newfilename;

              $imageinsert = "insert into images(carid,images) values ($car_id,'$imgpath')";

              if($imageex= mysqli_query($con, $imageinsert))
              {
                $_SESSION['newcaradded'] = true;
                header("location:dealer_index.php");
              }

              else
              {
                echo "some error occured while inserting image path in database!";
                header("Location: error.php");
              }

              }

            }


            $_SESSION['newcaradded'] = true;
            header("location:dealer_index.php");
            }

            else
            {
            echo "Some error occurred while inserting data!" . mysqli_error($con);
            header("Location: error.php");
            }

        }

        else
        {
            echo "Some error occurred while inserting data in owns table!";
            header("Location: error.php");
        }
        
    }
    else
    {
        echo "Error: Could not execute the query: " . mysqli_error($con);
        header("Location: error.php");
    }

}

}
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="icon" href="icon.ico">
    <title>Add Resale Car - VroomLife</title>
    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
        integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./css/resaleform.css?v=<?php echo time(); ?>" />
</head>

<script type="text/javascript">
function back() {
    window.location.href = "dealer_index.php";
}
</script>

<body>


    <?php

      $manuquery = "select mname from manufacturer";
      $manuex = mysqli_query($con, $manuquery);

  ?>
    <div class="testbox">
        <form action="" method="POST" enctype="multipart/form-data">
            <div id="back"
                style="border-radius:5px;padding:10px;background-color:#D7BDE2;color:#512E5F;margin-bottom:10px;cursor:pointer;width:fit-content;font-size:18px"
                onclick="back()">
                < Go back</div>
                    <div class="banner">
                        <h1>Resale Car Form</h1>
                    </div>
                    <div class="item">
                        <b>Basic Car Details</b>

                        <div class="item">
                            <!--<input type="text" name="m_name" placeholder="Manufacturer Name"  required/>-->

                            Manufacturer Name
                            <select name="m_name" required>

                                <?php 
            while($row=mysqli_fetch_assoc($manuex))
            { 
            ?>
                                <option value="<?php echo $row['mname']?>"><?php echo $row['mname']?></option>
                                <?php  
            }
            ?>

                            </select>


                        </div>

                        <div class="item">
                            <input type="text" name="name"
                                placeholder="Car Name (along with manufacturer name | eg - Ford EcoSport)" required>
                        </div>

                        <div class="name-item">
                            <input type="text" name="color" placeholder="Color" required />
                            <input type="number" name="mileage" placeholder="Mileage (km/l)" step="0.1" min="0"
                                required>
                        </div>
                    </div>

                    <div class="item">
                        Manufacture Date
                        <input type="date" name="m_date" required>
                    </div>

                    <div class="item">
                        <input type="text" name="licenseplateno" placeholder="License Plate no" required>
                    </div>

                    <div class="item">
                        Fuel Type
                        <select name="fueltype" required>
                            <option value="petrol" selected>Petrol</option>
                            <option value="diesel">Diesel</option>
                        </select>
                    </div>

                    <div class="name-item">
                        <input type="number" name="kmdriven" placeholder="Kilometers driven" min="0" required>
                        <input type="number" name="resaleprice" placeholder="Resale Price (in INR only)" min="0"
                            required>
                    </div>


                    <b>FEATURES (required)</b>
                    <div class="name-item">
                        <input type="text" name="f1" placeholder="Car feature 1" required>
                        <input type="text" name="f2" placeholder="Car feature 2" required>
                    </div>

                    <div class="name-item">
                        <input type="text" name="f3" placeholder="Car feature 3" required>
                        <input type="text" name="f4" placeholder="Car feature 4" required>
                    </div>

                    <div class="item">
                        <b>Choose a car image (optional)</b>
                        <input type="file" name="carimage" style="display:flex;align-items:center">
                    </div>

                    <div class="btn-block">
                        <button type="submit" name="submit">ADD CAR</button>
                    </div>
        </form>
    </div>
</body>

</html>