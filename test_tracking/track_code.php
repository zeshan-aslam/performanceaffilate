<?php
session_start();
include_once('connection/connection.php');
   
$id =$_GET['id'];
$value=$_GET['value'];
$_SESSION['id'] =$id;
$_SESSION['value'] =$value;
 $query="update track_code SET amount='".$value."' where id='".$id."'";
$request =mysqli_query($conn,$query);
?>
