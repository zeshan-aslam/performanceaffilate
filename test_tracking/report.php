<?php 
session_start();
include_once('connection/connection.php');

  $id =$_SESSION['id'];
  $value =$_SESSION['value'];
$query="select * from track_code where id='".$id."'";
$request =mysqli_query($conn,$query);
$row =mysqli_fetch_assoc($request);
?>
    <div>
		<label for="">Order Id</label> 
    <span><?=$row['id']?></span><br>
     <label for="">Value Amount</label>
     <span><?=$row['amount']?></span>
 