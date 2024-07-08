<?php
include_once '../includes/db-connect.php';
include_once '../includes/session.php';
include_once '../includes/encode_decodeFunction.php';
$aff_id       = $_SESSION['AFFILIATEID'];

#color code
// Get the selected color from the AJAX request
if(isset($_POST['searchcolor'])){
$sercolor  = $_POST['searchcolor'];
}
if(isset($_POST['namecolor'])){
$namecolor = $_POST['namecolor'];
}
if(isset($_POST['btnColor'])){
$btnColor = $_POST['btnColor'];
}
// Check if the user has already selected a color
$query = "SELECT * FROM color_picks WHERE affiliate_id =$aff_id";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
  // Update the existing record
  $row = mysqli_fetch_assoc($result);
  $selection_id = $row['affiliate_id'];
  
  $query = "UPDATE color_picks SET search_color = '$sercolor', name_color='$namecolor', button_color='$btnColor' WHERE affiliate_id =$selection_id";
  mysqli_query($con, $query);
  
  echo 'Color selection updated.';
} else {
  // Insert a new record
  $query = "INSERT INTO color_picks (search_color,name_color,button_color,affiliate_id) VALUES
   ('$sercolor','$namecolor','$btnColor','$aff_id')";
  mysqli_query($con, $query);
  
  echo 'Color selection stored.';
}


