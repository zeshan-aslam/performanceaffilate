<?php	ob_start();


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

  $orderId		= trim(stripslashes($_POST['orderId']));
  $saleAmt		= trim(stripslashes($_POST['saleAmt']));

  if(empty($orderId)) $err = "0";
  else				  $err = "1";

  if(empty($saleAmt)) $err .= ".0";
  else				  $err .= ".1";

  if($err!="1.1"){
  		$Err = 1;
    	header("Location:index.php?Act=GetCode&Err=1");
    	exit;
  }

  $sql ="UPDATE partners_merchant SET merchant_orderId = '".addslashes($orderId)."' , merchant_saleAmt='".addslashes($saleAmt)."' WHERE merchant_id =  ".$_SESSION['MERCHANTID'];
  mysqli_query($con,$sql);

  header("Location:index.php?Act=getTrackingCode");
  exit;
?>