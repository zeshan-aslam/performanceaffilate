<?php
//=============================================================================
//  Last Modfd	: 15/1/2005                                                  
//  Script Name	: return_world.php               			      
//=============================================================================


# iinclude session variables
  include 'includes/session.php';

# include database constants
  include 'includes/constants.php';

# include common fuctions
  include 'includes/functions.php';

# functions on get and post variables
  include 'includes/allstripslashes.php';

# crete databse instance
  $partners	=	new partners;

# establish databse connection
  $partners->connection($host,$user,$pass,$db);

  $successurl = "pay_paymentsuccess.php?type=$type&curid=$curid&amount=$amount&secid=$secid&secpass=$secpass";
  $failurl    = "index.php?Act=Payment&id=$curid&Errmsg=$Errmsg";

 // $transStatus = "Y";

  if($transStatus == "Y"){
   header("Location:$successurl");
   exit;
  }
  else{
   header("Location:$failurl");
   exit;
  }

?>