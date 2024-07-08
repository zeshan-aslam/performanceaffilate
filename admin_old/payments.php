<?php

  function  GetPaymentDetails($id,$flag)
 {
	$con = $GLOBALS["con"];

    switch ($flag)
    {
    case 1:   //merchant
         $sql="SELECT * from partners_joinpgm j,partners_program p where program_merchantid='$id' and  j.joinpgm_programid=p.program_id   ";
         break;
    case 2: //affiliate
          $sql="SELECT * from partners_joinpgm where joinpgm_affiliateid='$id'";
         break;
    }
    //echo "$sql";
    $result1		=mysqli_query($con,$sql);
    $pendingamnt   	=0;
    $approvedamnt	=0;
    $paidamnt		=0;
    $rejectedamnt	=0;


    while($rows=mysqli_fetch_object($result1))
    {
    $joinid=$rows->joinpgm_id;

    $sql="SELECT * from partners_transaction where transaction_status='pending' and transaction_joinpgmid='$joinid'";
    $result=mysqli_query($con,$sql);
     while($row=mysqli_fetch_object($result))
    {
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
				
				$sql_recurpay	= "SELECT * FROM partners_recurpayments WHERE recurpayments_recurid = '$recurId' AND recurpayments_status = 'pending' ";
				$res_recurpay	= mysqli_query($con,$sql_recurpay);
				if(mysqli_num_rows($res_recurpay) > 0)
				{
					$row_recurpay 	= mysqli_fetch_object($res_recurpay);
					$pendingamnt 	 =  $row_recurpay->recurpayments_amount + $pendingamnt; 
				}
			}
		 }
		 else
		 {	 
// END Modified on 23-JUNE-06
	   		 $pendingamnt=$row->transaction_amttobepaid+$pendingamnt; //total pending amnt
		 }
    }


   // echo "$sql";
  //  echo "$nclick";
    $sql="SELECT * from partners_transaction where transaction_status='approved' and transaction_joinpgmid='$joinid'";
    $result=mysqli_query($con,$sql);
    while($row=mysqli_fetch_object($result))
    {
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
				
				$sql_recurpay	= "SELECT * FROM partners_recurpayments WHERE recurpayments_recurid = '$recurId' AND recurpayments_status = 'approved' ";
				$res_recurpay	= mysqli_query($con,$sql_recurpay);
				if(mysqli_num_rows($res_recurpay) > 0)
				{
					$row_recurpay 	= mysqli_fetch_object($res_recurpay);
					$approvedamnt 	 =  $row_recurpay->recurpayments_amount + $approvedamnt; 
				}
			}
		 }
		 else
		 {	 
// END Modified on 23-JUNE-06
	    	$approvedamnt=$row->transaction_amttobepaid+$approvedamnt;// total approved amnt
		 }
    }  //end while



   // $sql="SELECT sum( transaction_amttobepaid ) sale from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='sale' and transaction_joinpgmid=$joinid";
    $sql="SELECT * from partners_transaction where transaction_joinpgmid='$joinid'";
    $result=mysqli_query($con,$sql);
    while($row=mysqli_fetch_object($result))
    {
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
					$paidamnt 	 =  $row_recurpay->recurpayments_amount + $paidamnt; 
				}
			}
		 }
		 else
		 {	 
// END Modified on 23-JUNE-06
	    	$paidamnt=$row->transaction_amountpaid+$paidamnt;//total sale amnt
		 }
    }
      //end  while
    $sql="SELECT * from partners_transaction where transaction_status='reversed' and transaction_joinpgmid='$joinid'";
    $result=mysqli_query($con,$sql);
    while($row=mysqli_fetch_object($result))
    {
    	$rejectedamnt=$row->transaction_amttobepaid+$rejectedamnt;//total sale amnt
    }  //end  while

		//Calculate reversed commissions fro Recurring sales
		$sql_rev = "SELECT * FROM partners_transaction, partners_recur, partners_recurpayments WHERE ".
		" transaction_joinpgmid='$joinid' AND recur_transactionid=transaction_id AND ".
		" recurpayments_recurid=recur_id  AND recurpayments_status='reversed' ";
 		$res_rev = mysqli_query($con,$sql_rev);
		if(mysqli_num_rows($res_rev) > 0)
		{
			while($row_rev = mysqli_fetch_object($res_rev))
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