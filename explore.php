<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Explore Cars</title>
        <link rel="stylesheet" href="explore.css"/>
    </head>
    <body>
        <?php 
            require('db.php');
            if(
                isset($_POST['searchinput'])
            ){
                $searchinput=stripslashes($_POST['searchinput']);
                $searchinput=mysqli_real_escape_string($con,$searchinput);
                $query="SELECT * FROM  `car` WHERE engine or transmission like'%$searchinput%' ";
                $result=mysqli_query($con,$query);
                $rows=mysqli_num_rows($result);
                if($rows>0){
                    while($cars=$result->fetch_assoc()){
                        echo $cars['mileage'];
                    }
                }else{
                    echo "<div>
                    <h3>No RESULTS FOUND!!</h3>
                    <p>Please try again entering valid name</p>
                    </div>";
                }
            }
        ?>
        <form class="searchbar" action="" method="post">
            <input type="text" name="searchinput" />
            <button type="submit">Submit</button>
        </form>
    </body>
    </html>
