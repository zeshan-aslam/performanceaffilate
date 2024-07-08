<?php
include_once '../includes/db-connect.php';
include_once '../includes/session.php';
$aff_id       = $_SESSION['AFFILIATEID'];
$value=$_GET['value'];
$current_date = date('y-m-d');

$sql_pgm = "SELECT link_override_value FROM partners_affiliate WHERE affiliate_id = $aff_id";
$result = mysqli_query($con, $sql_pgm);
$override_value = mysqli_fetch_assoc($result);
  if($override_value['link_override_value']==0)
  {
  $sql_pgm = "UPDATE partners_affiliate  SET link_override_value='$value' WHERE affiliate_id = $aff_id";
  $result = mysqli_query($con, $sql_pgm);
  echo "ON";
  }else {
    $sql_pgm = "UPDATE partners_affiliate  SET link_override_value='$value' WHERE affiliate_id = $aff_id";
    $result = mysqli_query($con, $sql_pgm);
    echo "OFF";
  }

?>
