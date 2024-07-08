<?php
function  GetPaymentDetails($sql,$To,$From,$currCaption='$default_currency_caption')
 {
    $affiliate_id		= $_SESSION['AFFILIATEID'];
    $result3            = mysqli_query($con,$sql);
    $pendingamnt        = 0;
    $approvedamnt       = 0;
    $paidamnt           = 0;
    $rejectedamnt       = 0;
    $pensubsale			= 0;

    while($rows=mysqli_fetch_object($result3))
    {
    $joinid                =$rows->joinpgm_id;

    $sql                ="SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_status='pending' and transaction_joinpgmid='$joinid'";
    $result4            =mysqli_query($con,$sql); 
    while($row1=mysqli_fetch_object($result4))
    {  
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
					
					$date		 =   $row_recurpay->recurpayments_date;
					$pend_amt	=  $row_recurpay->recurpayments_amount;
					
					$pendingamnt 	 =  $pend_amt + $pendingamnt; 
				}
			}
		 }
		 else
		 {	 
// END Modified on 23-JUNE-06
			$date		 =   $row1->transaction_dateoftransaction;
			$pend_amt	= $row1->transaction_amttobepaid;

	    	$pendingamnt = $pend_amt + $pendingamnt; //total pending amnt
		 }
    }  


		$sql                 ="SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_status='rejected' and transaction_joinpgmid='$joinid'";
		$result4             =mysqli_query($con,$sql);
		while($row1=mysqli_fetch_object($result4))
		{
			$date		 =   $row1->transaction_dateoftransaction;
			$rej_amt	= $row1->transaction_amttobepaid;
			
			$rejectedamnt        = $rej_amt + $rejectedamnt;// total approved amnt
		}  //end while
    }


              //-----------------------------------------------//

    $total               =$approvedamnt."~".$pendingamnt."~".$pensubsale."~".$rejectedamnt;
     return($total);
 }
?>