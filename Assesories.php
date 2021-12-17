<?php 
require('db.php');
$sql = "SELECT * FROM `accessories`";
$result = mysqli_query($con,$sql);


?>


<!DOCTYPE >
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="assesories.css" />
  </head>

  <body>
    <div class="assesories_main">
      <div class="main_assec">
        <div class="ass_table">
          <div class="ass_check">
            <input type="checkbox" class="check_ass" />
          </div>
          <div class="ass_image" >
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
        <?php
        while($rows =$result -> fetch_assoc())
        {
          ?>
        <div class="ass_table1">
          <div class="ass_check1">
            <input type="checkbox" name="accessoryid.<?php echo $rows['accessoryid'] ?>" value=<?php echo $rows['accessoryid'] ?> class="check_ass" />
          </div>
          <div class="ass_image1" >
<div class="imagediv"> <img src=  <?php  echo $rows['accessoryphoto'] ?> alt="%"  /></div>
</div>
          <div class="ass_name1">
<span><?php  echo $rows['accessoryname']?> </span>
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
        
      </div>
    </div>
  </body>
</html>
