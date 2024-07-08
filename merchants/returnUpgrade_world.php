<?php



# iinclude session variables
  include '../includes/session.php';

# include database constants
  include '../includes/constants.php';

# include common fuctions
  include '../includes/functions.php';

# functions on get and post variables
  include '../includes/allstripslashes.php';

# crete databse instance
  $partners	=	new partners;

# establish databse connection
  $partners->connection($host,$user,$pass,$db);

  $successurl =	"upgarde_success.php?id=$id&amount=$amount&secid=$secid&secpass=$secpass";
  $failurl    =	"index.php?Act=accounts&msg1=Payment Failed Please Try Again";


  //$transStatus = "Y";

  if($transStatus == "Y"){
   header("Location:$successurl");
   exit;
  }
  else{
   header("Location:$failurl");
   exit;
  }

?>

