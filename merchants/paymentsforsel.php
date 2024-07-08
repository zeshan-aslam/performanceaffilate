<?php
function  GetPaymentDetails($sql,$To,$From,$currCaption,$default_currency_caption)
 {
	if($currCaption == '') $currCaption = $default_currency_caption;

    $result3		=mysqli_query($con,$sql);
    $pendingamnt	=0;
    $approvedamnt	=0;
    $paidamnt		=0;
    $rejectedamnt	=0;


    while($rows=mysqli_fetch_object($result3))
    {
    $joinid		=$rows->joinpgm_id;

    $sql		="SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_status='pending' and transaction_joinpgmid='$joinid'";
    $result4	=mysqli_query($con,$sql);
     while($row1=mysqli_fetch_object($result4))
    {
      # get transaction details
       $date		 =   $row1->transaction_dateoftransaction;
       $adminAmnt    =   $row1->transaction_admin_amount;
//Modified on 23-JUNE-06 for Recurring Sale Commission by SMA
		 $transactionId	= $row1->transaction_id;
		 $recur 	 = 	$row1->transaction_recur;

		  // If the sale commission is of recurring type
		 if($recur == '1')
		 {
			$sql_Recur 	= "SELECT * FROM partners_recur WHERE recur_transactionid = '$transactionId' ";
			$res_Recur	= mysqli_query($con,$sql_Recur);
			if(mysqli_num_rows($res_Recur) > 0)
			{
				$row_recur	= mysqli_fetch_object($res_Recur);
				$recurId	= $row_recur->recur_id;

				$sql_recurpay	= "SELECT * FROM partners_recurpayments WHERE recurpayments_recurid = '$recurId' AND recurpayments_status = 'pending' ";
				$res_recurpay	= mysqli_query($con,$sql_recurpay);
				if(mysqli_num_rows($res_recurpay) > 0)
				{
					$row_recurpay 	= mysqli_fetch_object($res_recurpay);
					$affAmnt 	 =  $row_recurpay->recurpayments_amount;
				}
			}
		 }
		 else
		 {
// END Modified on 23-JUNE-06
		       $affAmnt 	 =   $row1->transaction_amttobepaid;
		 }

       # converting to user currency
       if($currCaption != $default_currency_caption){
            $affAmnt 	 =   getCurrencyValue($date, $currCaption, $affAmnt);
       		$adminAmnt   =   getCurrencyValue($date, $currCaption, $adminAmnt);

       }
        $affAmnt     = $affAmnt + $adminAmnt;
        $pendingamnt=$affAmnt+$pendingamnt; //total pending amnt
    }



    $sql		="SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_status='approved' and transaction_joinpgmid='$joinid'";
    $result4	=mysqli_query($con,$sql);
    while($row1	=mysqli_fetch_object($result4))
    {
     # get transaction details
       $date		 =   $row1->transaction_dateoftransaction;
       $adminAmnt    =   $row1->transaction_admin_amount;
//Modified on 23-JUNE-06 for Recurring Sale Commission by SMA
		 $transactionId	= $row1->transaction_id;
		 $recur 	 = 	$row1->transaction_recur;

		  // If the sale commission is of recurring type
		 if($recur == '1')
		 {
			$sql_Recur 	= "SELECT * FROM partners_recur WHERE recur_transactionid = '$transactionId' ";
			$res_Recur	= mysqli_query($con,$sql_Recur);
			if(mysqli_num_rows($res_Recur) > 0)
			{
				$row_recur	= mysqli_fetch_object($res_Recur);
				$recurId	= $row_recur->recur_id;

				$sql_recurpay	= "SELECT * FROM partners_recurpayments WHERE recurpayments_recurid = '$recurId' AND recurpayments_status = 'approved' ";
				$res_recurpay	= mysqli_query($con,$sql_recurpay);
				if(mysqli_num_rows($res_recurpay) > 0)
				{
					$row_recurpay 	= mysqli_fetch_object($res_recurpay);
					$affAmnt 	 =  $row_recurpay->recurpayments_amount;
				}
			}
		 }
		 else
		 {
// END Modified on 23-JUNE-06
		       $affAmnt 	 =   $row1->transaction_amttobepaid;
		 }

       # converting to user currency
       if($currCaption != $default_currency_caption){
            $affAmnt 	 =   getCurrencyValue($date, $currCaption, $affAmnt);
       		$adminAmnt   =   getCurrencyValue($date, $currCaption, $adminAmnt);

       }
       $affAmnt     = $affAmnt + $adminAmnt;
       $approvedamnt=$affAmnt+$approvedamnt;// total approved amnt
    }  //end while



   // $sql="SELECT sum( transaction_amttobepaid ) sale from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='sale' and transaction_joinpgmid=$joinid";
    $sql		="SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_joinpgmid='$joinid'";
    $result4	=mysqli_query($con,$sql);
    while($row1 =mysqli_fetch_object($result4))
    {
     # get transaction details
       $date		 =   $row1->transaction_dateoftransaction;
       $adminAmnt    =   $row1->transaction_admin_amount;
//Modified on 23-JUNE-06 for Recurring Sale Commission by SMA
		 $transactionId	= $row1->transaction_id;
		 $recur 	 = 	$row1->transaction_recur;

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
		 else
		 {
// END Modified on 23-JUNE-06
		       $affAmnt 	 =   $row1->transaction_amttobepaid;
		 }

       # converting to user currency
       if($currCaption != $default_currency_caption){
            $affAmnt 	 =   getCurrencyValue($date, $currCaption, $affAmnt);
       		$adminAmnt   =   getCurrencyValue($date, $currCaption, $adminAmnt);

       }
       $affAmnt     = $affAmnt + $adminAmnt;
       $paidamnt	=$affAmnt+$paidamnt;//total sale amnt
    }  //end  while

    $sql 		="SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_status='reversed' and transaction_joinpgmid='$joinid'";
    $result4	=mysqli_query($con,$sql);
    while($row1	=mysqli_fetch_object($result4))
    {
     # get transaction details
       $date		 =   $row1->transaction_dateoftransaction;
       $affAmnt    =   $row1->transaction_admin_amount;

       # converting to user currency
       if($currCaption != $default_currency_caption){
            $affAmnt 	 =   getCurrencyValue($date, $currCaption, $affAmnt);
       		$adminAmnt   =   getCurrencyValue($date, $currCaption, $adminAmnt);

       }
    $rejectedamnt=$affAmnt+$rejectedamnt;// total approved amnt
    }  //end while

			//Calculate reversed commissions fro Recurring sales
			$sql_rev = "SELECT * FROM partners_transaction, partners_recur, partners_recurpayments WHERE ".
			" transaction_joinpgmid='$joinid' AND recur_transactionid=transaction_id AND ".
			" transaction_dateoftransaction between '$From' and '$To' AND ".
			" recurpayments_recurid=recur_id  AND recurpayments_status='reversed' ";
			$res_rev = mysqli_query($con,$sql_rev);
			if(mysqli_num_rows($res_rev) > 0)
			{
				while($row_rev = mysqli_fetch_object($res_rev))
				{
					 # get transaction details
					 $date		 =   $row_rev->transaction_dateoftransaction;
					 $affAmt	= $row_rev->recurpayments_amount;
					 # converting to user currency
					 if($currCaption != $default_currency_caption){
							$affAmt 	 =   getCurrencyValue($date, $currCaption, $affAmt);
					 }

					$rejectedamnt = $affAmt + $rejectedamnt;
				}
			}
			//End Reverse Calculation


    }

    $total		=number_format($approvedamnt,2)."~".number_format($pendingamnt,2)."~".number_format($paidamnt,2)."~".number_format($rejectedamnt,2);
     return($total);
 }
?>