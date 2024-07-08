<?php
session_start();
include('connection/connection.php');
  $mid= 1;
$_SESSION['MERCHANTID']=$mid;
$id =mt_rand(10000000,99999999) ;
$value =rand(1,1000);
 $sql ="UPDATE partners_merchant SET merchant_orderId = '".$id."' , merchant_saleAmt='".$value."' WHERE merchant_id =".$mid;
  mysqli_query($conn,$sql);
   header("location:https://searlco.net/merchants/index.php?Act=getTrackingCode");
?>
<html>
<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6 mt-5">
        <center>
          <h3 class="bg-info p-3 text-light">Copy Tracking Code</h3>
          <textarea name="tracking" id="tracking" cols="70" rows="3" class="mt-1">
         
     <?php 
     $tracking_code = '<img src="track_code.php?id=' . $id . '&value=' . $value . '" hieght="1" width="1"/>';
    echo $tracking_code ?>
  </textarea>
  <a href="put_code.php" class="btn btn-primary mt-2">Click Here to Paste Tracking Code</a>
        </center>

        </div>
          
            </div>
        </div>
</body>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</html>