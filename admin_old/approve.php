<?php	ob_start();
//=============================================================================//
/*  Last Modified	: 15/1/2005                                             */
/*  Script Name	: return_world.php                            	                  */
//=============================================================================//

  include_once '../includes/db-connect.php';
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

   $mode = $_GET['mode'];
   $returnUrl = $_SERVER['HTTP_REFERER'];

  switch ($mode){
  	case "approvePgm":

      $sql = "UPDATE partners_program SET program_status='active' WHERE program_status = 'inactive' ";
      mysqli_query($con,$sql);
      break;

   	case "rejectPgm":

      $sql = "UPDATE partners_program SET program_status='inactive' WHERE program_status = 'active' ";
      mysqli_query($con,$sql);
      break;

    case "approveMerchants":

      $sql = "UPDATE partners_merchant SET merchant_status='approved' WHERE merchant_status = 'waiting' ";
      mysqli_query($con,$sql);

      break;

    case "approveAffiliates":

      $sql = "UPDATE partners_affiliate SET affiliate_status='approved' WHERE affiliate_status = 'waiting' ";
      mysqli_query($con,$sql);

      break;

    case "rejectMerchants":
      $sql = "SELECT merchant_id AS id FROM partners_merchant WHERE merchant_status = 'waiting'";
      $ret = mysqli_query($con,$sql);

      if(mysqli_num_rows($ret)>0){
        while($row = mysqli_fetch_object($ret)){
            $id 	= $row->id;
            $sql1	= "delete from partners_login where login_id='$id' and login_flag='m'";
      		mysqli_query($con,$sql1) ;
        }
      }


      $sql2 = "DELETE FROM partners_merchant WHERE merchant_status = 'waiting' ";
      mysqli_query($con,$sql2);

      break;

     case "rejectAffiliates":
      $sql = "SELECT affiliate_id AS id FROM partners_affiliate WHERE affiliate_status = 'waiting'";
      $ret = mysqli_query($con,$sql);

      if(mysqli_num_rows($ret)>0){
        while($row = mysqli_fetch_object($ret)){
            $id 	= $row->id;
            $sql1	= "delete from partners_login where login_id='$id' and login_flag='a'";
      		mysqli_query($con,$sql1) ;
        }
      }

      $sql = "DELETE FROM partners_affiliate WHERE affiliate_status = 'waiting' ";
      mysqli_query($con,$sql);

      break;
  }

  header("location:$returnUrl");
  exit;

?>