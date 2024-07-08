<?php
include('../includes/db-connect.php');
function  GetPaymentDetails1($joinid,$To,$From,$currCaption,$default_currency_caption) 
{
	global $con;
	if($currCaption == '') $currCaption = $default_currency_caption;

    //initiating
    $click   =0;
    $lead    =0;
    $sale    =0;
    $nclick  =0;
    $nlead   =0;
    $subsale =0;

    $sql      = "SELECT * from partners_transaction where transaction_type='click' and  transaction_dateoftransaction between '$From' and '$To' and transaction_joinpgmid='$joinid' ";
	$result   = mysqli_query($con,$sql);
	$nclick   = mysqli_num_rows($result)+$nclick;   //no of click
	while($row=mysqli_fetch_object($result))
	{

    	 # get transaction details
	     $date         =   $row->transaction_dateoftransaction;
	     $affAmnt      =   $row->transaction_amttobepaid;
	     $adminAmnt    =   $row->transaction_admin_amount;

	     # converting to user currency
	     if($currCaption != $default_currency_caption){
	          $affAmnt     =   getCurrencyValue($date, $currCaption, $affAmnt);
	          $adminAmnt   =   getCurrencyValue($date, $currCaption, $adminAmnt);
	     }

	     # total amount
	     $click   =   $affAmnt    +   $adminAmnt  +   $click; //total click amntt
    }


	$sql        ="SELECT * from partners_transaction where transaction_type='lead' and  transaction_dateoftransaction between '$From' and '$To'  and transaction_joinpgmid='$joinid' ";
	$result     =mysqli_query($con,$sql);
	$nlead      =mysqli_num_rows($result)+$nlead;  //no of lead
	while($row=mysqli_fetch_object($result))
	  {
    	  # get transaction details
	     $date         =   $row->transaction_dateoftransaction;
	     $affAmnt      =   $row->transaction_amttobepaid;
	     $adminAmnt    =   $row->transaction_admin_amount;

	     # converting to user currency
	     if($currCaption != $default_currency_caption){
	          $affAmnt     =   getCurrencyValue($date, $currCaption, $affAmnt);
	          $adminAmnt   =   getCurrencyValue($date, $currCaption, $adminAmnt);
	     }

	     # total amount
	     $lead    =   $affAmnt    +   $adminAmnt  +   $lead; //total click amnt
	  }  //end while


	$sql        ="SELECT *  from partners_transaction where  transaction_type='sale'and  transaction_dateoftransaction between '$From' and '$To'  and transaction_joinpgmid='$joinid' ";
	$result     =mysqli_query($con,$sql);
	$nsale      =mysqli_num_rows($result)+$nsale; //no of sale
	while($row=mysqli_fetch_object($result))
	  {
    	  # get transaction details
	     $date         =   $row->transaction_dateoftransaction;
	     $adminAmnt    =   $row->transaction_admin_amount;
	//Modified on 23-JUNE-06 for Recurring Sale Commission by SMA
		 $transactionId	= $row->transaction_id;
		 $recur 	 = 	$row->transaction_recur;

		  // If the sale commission is of recurring type
		 if($recur == '1') 
		 {
			$sql_Recur 	= "SELECT * FROM partners_recur WHERE recur_transactionid = '$transactionId' ";
			$res_Recur	= mysqli_query($con,$sql_Recur);
			if(mysqli_num_rows($res_Recur) > 0)
			{
				$row_recur	= mysqli_fetch_object($res_Recur);
				$recurId	= $row_recur->recur_id;
				
				$sql_recurpay	= "SELECT * FROM partners_recurpayments WHERE recurpayments_recurid = '$recurId' ";
				$res_recurpay	= mysqli_query($con,$sql_recurpay);
				if(mysqli_num_rows($res_recurpay) > 0)
				{
					$row_recurpay 	= mysqli_fetch_object($res_recurpay);
					$affAmnt 	 =  $row_recurpay->recurpayments_amount; 
				}
			}
		 }
	// END Modified on 23-JUNE-06
		 else
		 {	 
		     $affAmnt      =   $row->transaction_amttobepaid;
		 }

	     # converting to user currency
	     if($currCaption != $default_currency_caption){
	          $affAmnt     =   getCurrencyValue($date, $currCaption, $affAmnt);
	          $adminAmnt   =   getCurrencyValue($date, $currCaption, $adminAmnt);
	     }

	     # total amount
	     $sale    =   $affAmnt    +   $adminAmnt  +   $sale; //total click amnt
	  }  //end  while


	$totalamt  =$sale+$lead+$click;
	$total     =$nclick."~".$nlead."~".$nsale."~".$totalamt;

    return($total);
 }
 
 #modified on 27/feb/06 to get count of impressions
function  get_impression_count($pgm_id,$mer_id,$aff_id,$From,$To)
{
	global $con;
    $imp_count =0;
	$sql      = "SELECT sum(imp_count) AS impr_count from partners_impression_daily where imp_programid='$pgm_id' and  imp_date between '$From' and '$To' and imp_merchantid='$mer_id'  and imp_affiliateid ='$aff_id'";
    $result   = mysqli_query($con,$sql);
	$row_impr = mysqli_fetch_object($result);
    //$imp_count   = mysqli_num_rows($result);   //no of impression
	$imp_count   = $row_impr->impr_count;
	if($imp_count == '') $imp_count = 0;
    return $imp_count;
}
?>