<?php 
 include 'includes/db-connect.php';
 $banner_id =base64_decode($_GET['id']);
  $sql ="SELECT * FROM partners_banner WHERE banner_id='$banner_id'";
   $res=mysqli_query($con,$sql);
   $row=mysqli_fetch_array($res);
 $image=$row['banner_name']; //this can also be a url
$filename = basename($image);
$file_extension = strtolower(substr(strrchr($filename,"."),1));
switch( $file_extension ) {
    case "gif": $ctype="image/gif"; break;
    case "png": $ctype="image/png"; break;
    case "jpeg":
    case "jpg": $ctype="image/jpeg"; break;
    default:
}

header('Content-type: ' . $ctype);
$image = file_get_contents($image);
 echo $image;
