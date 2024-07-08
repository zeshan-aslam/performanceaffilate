<?php
function  GetPaymentDetails($sql,$To,$From)
 {

    $result3		=mysql_query($sql);
    $pendingamnt	=0;
    $approvedamnt	=0;
    $paidamnt		=0;
    $rejectedamnt	=0;


    while($rows=mysql_fetch_object($result3))
    {
     	$joinid    =$rows->joinpgm_id;
	     $sql       ="SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_status='pending' and transaction_joinpgmid='$joinid'";
	     $result4   =mysql_query($sql);
	     while($row1=mysql_fetch_object($result4))
	     {
	//Modified on 23-JUNE-06 for Recurring Sale Commission by SMA
			 $transactionId	= $row1->transaction_id;
			 $recur 	 = 	$row1->transaction_recur;
	
			  // If the sale commission is of recurring type
			 if($recur == '1') 
			 {
				$sql_Recur 	= "SELECT * FROM partners_recur WHERE recur_transactionid = '$transactionId' ";
				$res_Recur	= mysql_query($sql_Recur);
				if(mysql_num_rows($res_Recur) > 0)
				{
					$row_recur	= mysql_fetch_object($res_Recur);
					$recurId	= $row_recur->recur_id;
					
					$sql_recurpay	= "SELECT * FROM partners_recurpayments WHERE recurpayments_recurid = '$recurId' AND recurpayments_status = 'pending' ";
					$res_recurpay	= mysql_query($sql_recurpay);
					if(mysql_num_rows($res_recurpay) > 0)
					{
						$row_recurpay 	= mysql_fetch_object($res_recurpay);
						$pendingamnt 	 =  $row_recurpay->recurpayments_amount + $pendingamnt ; 
					}
				}
			 }
			 else
			 {	 
	// END Modified on 23-JUNE-06
		        $pendingamnt = $row1->transaction_amttobepaid + $pendingamnt; //total pending amnt
			 }
			 $pendingamnt = $row1->transaction_admin_amount + $pendingamnt;
	     }


	    $sql    ="SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_status='approved' and transaction_joinpgmid='$joinid'";
	    $result4=mysql_query($sql);
	    while($row1=mysql_fetch_object($result4))
	    {
	//Modified on 23-JUNE-06 for Recurring Sale Commission by SMA
			 $transactionId	= $row1->transaction_id;
			 $recur 	 = 	$row1->transaction_recur;
	
			  // If the sale commission is of recurring type
			 if($recur == '1') 
			 {
				$sql_Recur 	= "SELECT * FROM partners_recur WHERE recur_transactionid = '$transactionId' ";
				$res_Recur	= mysql_query($sql_Recur);
				if(mysql_num_rows($res_Recur) > 0)
				{
					$row_recur	= mysql_fetch_object($res_Recur);
					$recurId	= $row_recur->recur_id;
					
					$sql_recurpay	= "SELECT * FROM partners_recurpayments WHERE recurpayments_recurid = '$recurId' AND recurpayments_status = 'approved' ";
					$res_recurpay	= mysql_query($sql_recurpay);
					if(mysql_num_rows($res_recurpay) > 0)
					{
						$row_recurpay 	= mysql_fetch_object($res_recurpay);
						$approvedamnt 	 =  $row_recurpay->recurpayments_amount + $approvedamnt ; 
					}
				}
			 }
			 else
			 {	 
	// END Modified on 23-JUNE-06
		        $approvedamnt=$row1->transaction_amttobepaid + $approvedamnt;// total approved amnt
			 }		
			 $approvedamnt = 	$row1->transaction_admin_amount + $approvedamnt;
	    }  //end while



	   // $sql="SELECT sum( transaction_amttobepaid ) sale from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='sale' and transaction_joinpgmid=$joinid";
	    $sql    ="SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_joinpgmid='$joinid'";
	    $result4=mysql_query($sql);
	    while($row1=mysql_fetch_object($result4))
	    {
	//Modified on 23-JUNE-06 for Recurring Sale Commission by SMA
			 $transactionId	= $row1->transaction_id;
			 $recur 	 = 	$row1->transaction_recur;
	
			  // If the sale commission is of recurring type
			 if($recur == '1') 
			 {
				$sql_Recur 	= "SELECT * FROM partners_recur WHERE recur_transactionid = '$transactionId' ";
				$res_Recur	= mysql_query($sql_Recur);
				if(mysql_num_rows($res_Recur) > 0)
				{
					$row_recur	= mysql_fetch_object($res_Recur);
					$recurId	= $row_recur->recur_id;
					
					$sql_recurpay	= "SELECT * FROM partners_recurpayments WHERE recurpayments_recurid = '$recurId' ";
					$res_recurpay	= mysql_query($sql_recurpay);
					if(mysql_num_rows($res_recurpay) > 0)
					{
						$row_recurpay 	= mysql_fetch_object($res_recurpay);
						$paidamnt 	 =  $row_recurpay->recurpayments_amount + $paidamnt ; 
					}
				}
			 }
			 else
			 {	 
	// END Modified on 23-JUNE-06
		        $paidamnt=$row1->transaction_amountpaid + $paidamnt;//total sale amnt
			 }
			 $paidamnt = $row1->transaction_adminpaid + $paidamnt;
	    }  //end  while



	    $sql  ="SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_status='reversed' and transaction_joinpgmid='$joinid'";
	    $result4=mysql_query($sql);
	    while($row1=mysql_fetch_object($result4))
	    {
	        $rejectedamnt=$row1->transaction_amttobepaid +$rejectedamnt;// total approved amnt
	    }  //end while
		
		//Calculate reversed commissions fro Recurring sales
		$sql_rev = "SELECT * FROM partners_transaction, partners_recur, partners_recurpayments WHERE ".
		" transaction_joinpgmid=$joinid AND recur_transactionid=transaction_id AND ".
		" transaction_dateoftransaction between '$From' and '$To' AND ".
		" recurpayments_recurid=recur_id  AND recurpayments_status='reversed' ";
 		$res_rev = mysql_query($sql_rev);
		if(mysql_num_rows($res_rev) > 0)
		{
			while($row_rev = mysql_fetch_object($res_rev))
			{
				$rejectedamnt = $row_rev->recurpayments_amount + $rejectedamnt;
			}
		}
		//End Reverse Calculation
		
    }

    $total=$approvedamnt."~".$pendingamnt."~".$paidamnt."~".$rejectedamnt;
     return($total);
 }
?>