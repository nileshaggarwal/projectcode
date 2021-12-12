<!DOCTYPE html>
<html>
    <head>
        <link rel = "stylesheet" href= "category.css">
    </head>
    <body>
    <?php
        require('db.php');
        if(isset($_POST['submit'])) {
            $Bodytype=stripslashes($_POST['Bodytype']);
            $Bodytype=mysqli_real_escape_string($con, $Bodytype);
           //$sql=$con-> prepare("Select * from car where type=(:Bodytype);");
            $que = "SELECT * FROM `car` WHERE type like'%$Bodytype%' ";
            // $que->execute(array(':Bodytype'=>$Bodytype));
            $result=mysqli_query($con,$que);
            $rows=mysqli_num_rows($result);
            if($rows>0){
                echo "SEARCHED";
                while($data=$result -> fetch_assoc()){
                    echo $data['mileage'];
                }
            }else{
                echo mysql_error($result);
            }
            
        }
        ?>
        <form action="" method="post">
        <div class = "navbar">
        <label for="Brand">Brand:</label>
        <select name="color" id="color">
            <option value="Suzuki">Suzuki</option>
            <option value="Hyundia">Hyundia</option>
            <option value="TATA">TATA</option>
            <option value="NISSAN">NISSAN</option>
            <option value="Skoda">Skoda</option>
        </select>

        <label for="Bodytype">Body Type:</label>
        <select name="Bodytype" id="Bodytype">
            <option value="Sedan">Sedan</option>
            <option value="Coupe">Coupe</option>
            <option value="hatchback">HatchBack</option>
            <option value="SUV">SUV</option>
            <option value="VAN">VAN</option>
        </select>

        
        <label for="Price">Price:</label>
        <select name="Price" id="Price">
            <option value="1-2">1-2 Lakh</option>
            <option value="2-4">2-4 Lakh</option>
            <option value="4-6">4-6 Lakh</option>
            <option value="6-8">6-8 Lakh</option>
            <option value="8-10">8-10 Lakh</option>
        </select>
        <button type="submit" name= "submit">Search</button>
    </form>
    </body>

    </html>