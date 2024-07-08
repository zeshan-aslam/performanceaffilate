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
  include '../includes/session.php';
  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
  include_once '../includes/session.php';
  include_once '../includes/allstripslashes.php';

#----------------------------------------------------------------------------
# establishing connection
#----------------------------------------------------------------------------
    $partners =  new partners;
    $partners->connection($host,$user,$pass,$db);

# getiing merchant id and amount
	$id = intval($_GET['id']);

# get mode (for reject)
	$mode	= $_GET['mode'];
    if($mode=="reject")
    {
    	//update status
        $sql = "UPDATE partners_addmoney SET addmoney_status = 'suspend' WHERE addmoney_id = '$id'";
        mysqli_query($con,$sql);

        //redirect back to listing page
        header("location:index.php?Act=mer_requests");
        exit;
    }

# get details
    $newSql = "SELECT * FROM partners_addmoney WHERE addmoney_id = '$id' ";
    $newRet = mysqli_query($con,$newSql);

    if(mysqli_num_rows($newRet)>0){
    	$merRow   = mysqli_fetch_object($newRet);
        $mid	  = $merRow->addmoney_merchantid;
        $amount   = $merRow->addmoney_amount;
        $mode	  = $merRow->addmoney_mode;
        $merchant_sql ="SELECT * FROM   merchant_pay  WHERE pay_merchantid='$mid'";
	    $merchant_ret =mysqli_query($con,$merchant_sql);

	    if(mysqli_num_rows($merchant_ret)>0) {
	          $row        = mysqli_fetch_object($merchant_ret);
	          $grandtotal = $row->pay_amount;
	    }

        $grandtotal  = $grandtotal +  $amount;

        $sql = "UPDATE partners_addmoney SET addmoney_status= 'approved' WHERE addmoney_id = '$id'";
        mysqli_query($con,$sql);

        $sql = "UPDATE `merchant_pay` SET `pay_amount` = '$grandtotal' WHERE `pay_merchantid` = '$mid'";
        mysqli_query($con,$sql);



         $today=date("Y-m-d");
         $sql3  = "INSERT INTO `partners_adjustment` ( `adjust_id` , `adjust_memberid` , `adjust_action` , `adjust_flag`,`adjust_amount`,`adjust_date` )  ";
         $sql3 .= "VALUES ('', '$mid', 'deposit', 'm','$amount','$today')";
         mysqli_query($con,$sql3);

         if($grandtotal>$minimum_amount)
         {
           $sql  = "UPDATE `partners_merchant` SET merchant_status='approved' where `merchant_id` = '$mid'";
           mysqli_query($con,$sql);
         }else{
           $sql  = "UPDATE `partners_merchant` SET merchant_status='empty' where `merchant_id` = '$mid'";
            mysqli_query($con,$sql);
         }

        # make user advance
        if($mode == "upgrade"){
             $sql = "UPDATE partners_merchant SET merchant_type = 'advance' WHERE merchant_id = '$mid' ";
             mysqli_query($con,$sql);
        }
    }

$msg  = "Payment Successful";
header("location:index.php?Act=mer_requests&msg=$msg");

?>