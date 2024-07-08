<?php

#-------------------------------------------------------------------------------
# Mercahnt Payment Form
# Payment suceess form

# Pgmmr           : RR
# Date Created :   28-11-2004
# Date Modfd   :   28-11-2004
#-------------------------------------------------------------------------------

#----------------------------------------------------------------------------
#  file including
#----------------------------------------------------------------------------
  include_once '../includes/db-connect.php';
  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
  include_once '../includes/session.php';

#----------------------------------------------------------------------------
# establishing connection
#----------------------------------------------------------------------------
    $partners =  new partners;
    $partners->connection($host,$user,$pass,$db);

#----------------------------------------------------------------------------
# including lang files
#----------------------------------------------------------------------------
    include_once 'language_include.php';


# getiing merchant id and amount
    $mid		=	$_SESSION['MERCHANTID'];
    $amount	   	=   $_GET['amount'];
    $pay_type	=   $_GET['paytype'];
#----------------------------------------------------------------------------
#   security
#----------------------------------------------------------------------------
   $secid      = $_GET['secid'];
   $secpass    = $_GET['secpass'];



   $secsql   = "select * from random_gen where rand_genid='".addslashes($secid)."' and rand_genpwd='".addslashes($secpass)."'";
   $secres   = mysqli_query($con,$secsql);
   if(mysqli_num_rows($secres)>0){
      $secdel = "delete from random_gen where rand_genid='".addslashes($secid)."' and rand_genpwd='".addslashes($secpass)."'";
      mysqli_query($con,$secdel);
   }
   else{
     $msg  = $lang_perror;
     header("location:index.php?Act=add_money&msg=$msg");
     exit;

   }
#----------------------------- security test end ------------------------------------------//


$today=date("Y-m-d");

$addSql = "INSERT INTO `partners_addmoney` ( `addmoney_id` , `addmoney_merchantid` , `addmoney_amount` , `addmoney_status`, `addmoney_paytype`,`addmoney_date`,addmoney_mode )
		   VALUES ('', '$mid', '$amount', 'waiting','$pay_type','$today','addmoney' )";
mysqli_query($con,$addSql);





$msg  = $lang_add_success_msg;
header("location:index.php?Act=add_money&msg=$msg");
?>
