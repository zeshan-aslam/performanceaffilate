<?php


#-------------------------------------------------------------------------------
#    PAyment Detaisl
#-------------------------------------------------------------------------------
 function  GetPaymentDetails1($joinid, $currCaption,$default_currency_caption)
 {
  $con = $GLOBALS["con"];

 	if($currCaption == '') $currCaption = $default_currency_caption;

    //initiating
    $click	=0;
    $lead	=0;
    $sale	=0;
    $nclick	=0;
    $nlead	=0;
#$subsale=0;


    $sql 	= "SELECT * from partners_transaction where transaction_type='click' and transaction_joinpgmid='$joinid' ";
    $result = mysqli_query($con,$sql);
    $nclick = mysqli_num_rows($result)+$nclick;   //no of click

    while($row=mysqli_fetch_object($result)){

      # get transaction details
       $date		 =   $row->transaction_dateoftransaction;
       $affAmnt 	 =   $row->transaction_amttobepaid;
       $adminAmnt    =   $row->transaction_admin_amount;

       # converting to user currency
       if($currCaption != $default_currency_caption){
            $affAmnt 	 =   getCurrencyValue($date, $currCaption, $affAmnt);
       		$adminAmnt   =   getCurrencyValue($date, $currCaption, $adminAmnt);
       }

       # total amount
       $click	=	$affAmnt	+	$adminAmnt	+	$click; //total click amnt
    }


    $sql    =	"SELECT * from partners_transaction where transaction_type='lead' and transaction_joinpgmid='$joinid' ";
    $result	=	mysqli_query($con,$sql);
    $nlead	=	mysqli_num_rows($result)+$nlead;  //no of lead

     while($row=mysqli_fetch_object($result)) {

       # get transaction details
       $date		 =   $row->transaction_dateoftransaction;
       $affAmnt 	 =   $row->transaction_amttobepaid;
       $adminAmnt    =   $row->transaction_admin_amount;

       # converting to user currency
       if($currCaption != $default_currency_caption){
            $affAmnt 	 =   getCurrencyValue($date, $currCaption, $affAmnt);
       		$adminAmnt   =   getCurrencyValue($date, $currCaption, $adminAmnt);
       }

        # total amount
        $lead  = $affAmnt	+	$adminAmnt	+ $lead;// total lead amnt
     }


    $sql	=	"SELECT *  from partners_transaction where  transaction_type='sale' and transaction_joinpgmid='$joinid' ";
    $result	=	mysqli_query($con,$sql);
    $nsale	=	mysqli_num_rows($result)+$nsale; //no of sale

    while($row=mysqli_fetch_object($result))
	{
        # get transaction details
       $date		 =   $row->transaction_dateoftransaction;
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
		       $affAmnt 	 =   $row->transaction_amttobepaid;
		 }

       # converting to user currency
       if($currCaption != $default_currency_caption){
            $affAmnt 	 =   getCurrencyValue($date, $currCaption, $affAmnt);
       		$adminAmnt   =   getCurrencyValue($date, $currCaption, $adminAmnt);
       }

       # total amount

       $sale = $affAmnt	+	$adminAmnt	+ $sale;//total sale amnt
    }




   $total=$nclick."~".$click."~".$nlead."~".$lead."~".$subsale."~".$sale;

    return($total);
 }


# -------------------------------------------------------------------------------
#    PAyment Detaisl
#-------------------------------------------------------------------------------
 function  GetPaymentDetails($sql, $currCaption,$default_currency_caption )
 {
  $con = $GLOBALS["con"];
	if($currCaption == '') $currCaption = $default_currency_caption;
	
    $result1	=	mysqli_query($con,$sql);


    //initiating
    $click			=	0;
    $lead			=	0;
    $sale			=	0;
    $nclick			=	0;
    $nlead			=	0;
    $nsale			=	0;
    $pendingamnt  	=	0;
    $approvedamnt	=	0;
    $paidamnt		=	0;
    $rejectedamnt	=	0;
#$subsale		=	0;
	//added on 16-JUNE
	$impression     =   0;
	$nimpression    =   0;


    while($rows=mysqli_fetch_object($result1))
    {
            $joinid =	$rows->joinpgm_id;
			
           #Modified on 16.JUNE.06 to calculate impression commission
           $sql	=	"SELECT * from partners_transaction where transaction_type='impression' and transaction_joinpgmid='$joinid' ";
            $result	=	mysqli_query($con,$sql);
            $nimpression	=	mysqli_num_rows($result)+$nimpression;   //no ofi mpression

            while($row=mysqli_fetch_object($result)) {

                 # get transaction details
                 $date		 =   $row->transaction_dateoftransaction;
        		 $affAmnt 	 =   $row->transaction_amttobepaid;
        		 $adminAmnt  =   $row->transaction_admin_amount;

                 # converting to user currency
                 if($currCaption != $default_currency_caption){
                        $affAmnt 	 =   getCurrencyValue($date, $currCaption, $affAmnt);
        		 		$adminAmnt   =   getCurrencyValue($date, $currCaption, $adminAmnt);

                 }

               $impression	=	$affAmnt	+	$adminAmnt	+	$impression; //total click amnt

            }
           # end of Modification on 16.JUNE.06 to calculate impression commission
			

            $sql	=	"SELECT * from partners_transaction where transaction_type='click' and transaction_joinpgmid='$joinid' ";
            $result	=	mysqli_query($con,$sql);
            $nclick	=	mysqli_num_rows($result)+$nclick;   //no of click

            while($row=mysqli_fetch_object($result)) {

                 # get transaction details
                 $date		 =   $row->transaction_dateoftransaction;
        		 $affAmnt 	 =   $row->transaction_amttobepaid;
        		 $adminAmnt  =   $row->transaction_admin_amount;

                 # converting to user currency
                 if($currCaption != $default_currency_caption){
                        $affAmnt 	 =   getCurrencyValue($date, $currCaption, $affAmnt);
        		 		$adminAmnt   =   getCurrencyValue($date, $currCaption, $adminAmnt);

                 }

               $click	=	$affAmnt	+	$adminAmnt	+	$click; //total click amnt

            }

            $sql	=	"SELECT * from partners_transaction where transaction_type='lead' and transaction_joinpgmid='$joinid' ";
            $result	=	mysqli_query($con,$sql);
            $nlead	=	mysqli_num_rows($result)+$nlead;  //no of lead

            while($row=mysqli_fetch_object($result)){

                # get transaction details
                 $date		 =   $row->transaction_dateoftransaction;
        		 $affAmnt 	 =   $row->transaction_amttobepaid;
        		 $adminAmnt  =   $row->transaction_admin_amount;

                 # converting to user currency
                 if($currCaption != $default_currency_caption){
                        $affAmnt 	 =   getCurrencyValue($date, $currCaption, $affAmnt);
        		 		$adminAmnt   =   getCurrencyValue($date, $currCaption, $adminAmnt);

                 }
                $lead = $affAmnt	+	$adminAmnt	+$lead;// total lead amnt
             }


            $sql	=	"SELECT * from partners_transaction where transaction_type='sale' and transaction_joinpgmid='$joinid' ";
            $result	=	mysqli_query($con,$sql);
            $nsale	=	mysqli_num_rows($result)+$nsale; //no of sale

            while($row=mysqli_fetch_object($result))
            {
				 $date		 =   $row->transaction_dateoftransaction;
				 $adminAmnt  =   $row->transaction_admin_amount;
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
					 # get transaction details
					 $affAmnt 	 =   $row->transaction_amttobepaid;
				 }
                 # converting to user currency
                 if($currCaption != $default_currency_caption){
                        $affAmnt 	 =   getCurrencyValue($date, $currCaption, $affAmnt);
        		 		$adminAmnt   =   getCurrencyValue($date, $currCaption, $adminAmnt);

                 }
                $sale = $affAmnt	+	$adminAmnt + $sale;//total sale amnt
            }




            $sql	= " SELECT * from partners_transaction where transaction_status='pending' 
						and transaction_joinpgmid='$joinid'";
    		$result	=	mysqli_query($con,$sql);
     		while($row=mysqli_fetch_object($result))
    		{
                 # get transaction details
                 $date		 =   $row->transaction_dateoftransaction;
        		 $adminAmnt  =   $row->transaction_admin_amount;
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
						
						$sql_recurpay	= " SELECT * FROM partners_recurpayments WHERE recurpayments_recurid = '$recurId' 
											AND recurpayments_status = 'pending' ";
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
					 $affAmnt 	 =   $row->transaction_amttobepaid;
				 }

                 # converting to user currency
                 if($currCaption != $default_currency_caption){
                        $affAmnt 	 =   getCurrencyValue($date, $currCaption, $affAmnt);
        		 		$adminAmnt   =   getCurrencyValue($date, $currCaption, $adminAmnt);

                 }
                $pendingamnt=$affAmnt+$adminAmnt+$pendingamnt; //total pending amnt
    		}

 		    $sql	= " SELECT * from partners_transaction where transaction_status='approved' 
						and transaction_joinpgmid='$joinid'";
    		$result	=	mysqli_query($con,$sql);

           while($row=mysqli_fetch_object($result))
    	   {
                 # get transaction details
                 $date		 =   $row->transaction_dateoftransaction;
        		 $adminAmnt  =   $row->transaction_admin_amount;
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
							$affAmnt 	 =  $row_recurpay->recurpayments_amount; 
						}
					}
				 }
		// END Modified on 23-JUNE-06
				 else
				 {	 
	        		 $affAmnt 	 =   $row->transaction_amttobepaid;
				 }


                 # converting to user currency
                 if($currCaption != $default_currency_caption){
                        $affAmnt 	 =   getCurrencyValue($date, $currCaption, $affAmnt);
        		 		$adminAmnt   =   getCurrencyValue($date, $currCaption, $adminAmnt);

                 }

                $approvedamnt=$adminAmnt + $affAmnt + $approvedamnt;// total approved amnt
   		   }

   		   $sql	   =	"SELECT * from partners_transaction where transaction_joinpgmid='$joinid'";
    	   $result =	mysqli_query($con,$sql);

           while($row=mysqli_fetch_object($result))
    	   {

                 # get transaction details
                 $date		 =   $row->transaction_dateoftransaction;
        		 $adminAmnt  =   $row->transaction_adminpaid;
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
				 else
				 {	 
		// END Modified on 23-JUNE-06
	        		 $affAmnt 	 =   $row->transaction_amountpaid;
				 }


                 # converting to user currency
                 if($currCaption != $default_currency_caption){
                        $affAmnt 	 =   getCurrencyValue($date, $currCaption, $affAmnt);
        		 		$adminAmnt   =   getCurrencyValue($date, $currCaption, $adminAmnt);

                 }
                $paidamnt=$affAmnt+$adminAmnt+$paidamnt;//total sale amnt
           }

    	   $sql		= " SELECT * from partners_transaction WHERE transaction_status='reversed' 
		   				and transaction_joinpgmid = '$joinid'";
    	   $result4	=	mysqli_query($con,$sql);

           while($row1=mysqli_fetch_object($result4))
    	   {
                 # get transaction details
                 $date		 =   $row1->transaction_dateoftransaction;
        		 $affAmnt 	 =   $row1->transaction_admin_amount;

                 # converting to user currency
                 if($currCaption != $default_currency_caption){
                        $affAmnt 	 =   getCurrencyValue($date, $currCaption, $affAmnt);


                 }
    	    	$rejectedamnt= $affAmnt + $rejectedamnt;// total approved amnt
    	   }

			//Calculate reversed commissions fro Recurring sales
			$sql_rev = "SELECT * FROM partners_transaction, partners_recur, partners_recurpayments WHERE ".
			" transaction_joinpgmid='$joinid' AND recur_transactionid=transaction_id AND ".
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


   $total=$nclick."~".$click."~".$nlead."~".$lead."~".$nsale."~".$sale."~".$approvedamnt."~".$pendingamnt."~".$paidamnt."~". $rejectedamnt."~".$subsale."~".$nimpression."~".$impression;

    return($total);
 }

 # -------------------------------------------------------------------------------
#    PAyment Detaisl
#-------------------------------------------------------------------------------
 function  GetAffPaymentDetails($sql, $AFFILIATEID, $currCaption,$default_currency_caption )
 {
  $con = $GLOBALS["con"];

	if($currCaption == '') $currCaption = $default_currency_caption;
	
     $result1		=	mysqli_query($con,$sql);


    //initiating
    $click         =0;
    $lead          =0;
    $sale          =0;
    $nclick        =0;
    $nlead         =0;
    $nsale         =0;
    $pendingamnt   =0;
    $approvedamnt  =0;
    $paidamnt      =0;
    $rejectedamnt  =0;
#$subsale       =0;
    $nsub          =0;
    $pensubsale    =0;
    $npensub       =0;
    $nreverse      =0;
    $nsub          =0;
	
    $impression     =   0;
    $nimpression    =   0;
	

    while($rows=mysqli_fetch_object($result1))
    {
            $joinid =	$rows->joinpgm_id;

            $sql	=	"SELECT * from partners_transaction where transaction_type='click' and transaction_joinpgmid='$joinid' ";
            $result	=	mysqli_query($con,$sql);
            $nclick	=	mysqli_num_rows($result)+$nclick;   //no of click

            while($row=mysqli_fetch_object($result)) {

                 # get transaction details
                 $date		 =   $row->transaction_dateoftransaction;
        		 $affAmnt 	 =   $row->transaction_amttobepaid;
                 $adminAmnt  =   $row->transaction_admin_amount;

                 # converting to user currency
                 if($currCaption != $default_currency_caption){
                        $affAmnt 	 =   getCurrencyValue($date, $currCaption, $affAmnt);
        		 		$adminAmnt   =   getCurrencyValue($date, $currCaption, $adminAmnt);

                 }

               $click	=	$affAmnt   + $adminAmnt	+	$click; //total click amnt

            }

            $sql	=	"SELECT * from partners_transaction where transaction_type='lead' and transaction_joinpgmid='$joinid' ";
            $result	=	mysqli_query($con,$sql);
            $nlead	=	mysqli_num_rows($result)+$nlead;  //no of lead

            while($row=mysqli_fetch_object($result)){

                # get transaction details
                 $date		 =   $row->transaction_dateoftransaction;
        		 $affAmnt 	 =   $row->transaction_amttobepaid;
                 $adminAmnt  =   $row->transaction_admin_amount;

                 # converting to user currency
                 if($currCaption != $default_currency_caption){
                        $affAmnt 	 =   getCurrencyValue($date, $currCaption, $affAmnt);
        		 		$adminAmnt   =   getCurrencyValue($date, $currCaption, $adminAmnt);

                 }
                $lead = $affAmnt   + $adminAmnt + $lead;// total lead amnt
             }


            $sql	=	"SELECT * from partners_transaction where transaction_type='sale' and transaction_joinpgmid='$joinid' ";
            $result	=	mysqli_query($con,$sql);
            $nsale	=	mysqli_num_rows($result)+$nsale; //no of sale

            while($row=mysqli_fetch_object($result))
            {
                 # get transaction details
                 $date		 =   $row->transaction_dateoftransaction;
                 $adminAmnt  =   $row->transaction_admin_amount;
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
				 else
				 {	 
		// END Modified on 23-JUNE-06
	        		 $affAmnt 	 =   $row->transaction_amttobepaid;
				 }
                 # converting to user currency
                 if($currCaption != $default_currency_caption){
                        $affAmnt 	 =   getCurrencyValue($date, $currCaption, $affAmnt);
                        $adminAmnt   =   getCurrencyValue($date, $currCaption, $adminAmnt);

                 }
                $sale = $affAmnt   + $adminAmnt	+ $sale;//total sale amnt
            }

           $sql	   =	"SELECT * from partners_transaction where transaction_joinpgmid='$joinid'";
    	   $result =	mysqli_query($con,$sql);

           while($row=mysqli_fetch_object($result))
    	   {

                 # get transaction details
                 $date		 =   $row->transaction_dateoftransaction;
                 $adminAmnt  =   $row->transaction_adminpaid;
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
				 else
				 {	 
		// END Modified on 23-JUNE-06
	        		 $affAmnt 	 =   $row->transaction_amountpaid;
				 }


                 # converting to user currency
                 if($currCaption != $default_currency_caption){
                        $affAmnt 	 =   getCurrencyValue($date, $currCaption, $affAmnt);
                        $adminAmnt   =   getCurrencyValue($date, $currCaption, $adminAmnt);

                 }
                $paidamnt= $affAmnt   + $adminAmnt + $paidamnt;//total sale amnt
           }

           $sql	=	"SELECT * from partners_transaction where transaction_status='approved' and transaction_joinpgmid='$joinid'";
    	   $result	=	mysqli_query($con,$sql);
           $napproved    =mysqli_num_rows($result)+$napproved; //no of sale
           while($row=mysqli_fetch_object($result))
    	   {
                 # get transaction details
                 $date		 =   $row->transaction_dateoftransaction;
                 $adminAmnt  =   $row->transaction_admin_amount;
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
						
						$sql_recurpay	= "SELECT * FROM partners_recurpayments WHERE recurpayments_recurid = '$recurId' AND recurpayments_status = 'approved'";
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
	        		 $affAmnt 	 =   $row->transaction_amttobepaid;
				 }

                 # converting to user currency
                 if($currCaption != $default_currency_caption){
                        $affAmnt 	 =   getCurrencyValue($date, $currCaption, $affAmnt);
                        $adminAmnt   =   getCurrencyValue($date, $currCaption, $adminAmnt);

                 }

                $approvedamnt= $affAmnt   + $adminAmnt + $approvedamnt;// total approved amnt
   		   }

           $sql	   =	"SELECT * from partners_transaction where transaction_joinpgmid='$joinid'";
    	   $result =	mysqli_query($con,$sql);

           while($row=mysqli_fetch_object($result))
    	   {

                 # get transaction details
                 $date		 =   $row->transaction_dateoftransaction;
                 $adminAmnt  =   $row->transaction_adminpaid;
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
				 else
				 {	 
		// END Modified on 23-JUNE-06
	        		 $affAmnt 	 =   $row->transaction_amountpaid;
				 }

                 # converting to user currency
                 if($currCaption != $default_currency_caption){
                        $affAmnt 	 =   getCurrencyValue($date, $currCaption, $affAmnt);
                        $adminAmnt   =   getCurrencyValue($date, $currCaption, $adminAmnt);

                 }
                $paidamnt=$affAmnt   + $adminAmnt + $paidamnt;//total sale amnt
           }



         $sql		=	"SELECT * from partners_transaction WHERE transaction_status='reversed' and transaction_joinpgmid='$joinid'";
         $result4	=	mysqli_query($con,$sql);
         $nreverse    =mysqli_num_rows($result4)+$nreverse;
           while($row1=mysqli_fetch_object($result4))
    	   {
                 # get transaction details
                 $date		 =   $row1->transaction_dateoftransaction;
                 $affAmnt 	 =   $row1->transaction_admin_amount;

                 # converting to user currency
                 if($currCaption != $default_currency_caption){
                        $affAmnt 	 =   getCurrencyValue($date, $currCaption, $affAmnt);


                 }
    	    	$rejectedamnt= $affAmnt +  $rejectedamnt;// total approved amnt
    	   }
		   
   #== Modified on 17-JUNE.06 to get impression commission
            $sql	=	"SELECT * from partners_transaction where transaction_type='impression' and transaction_joinpgmid='$joinid' ";
            $result	=	mysqli_query($con,$sql);
            $nimpression	=	mysqli_num_rows($result)+$nimpression;   //no of impression

            while($row=mysqli_fetch_object($result)) {

                 # get transaction details
                 $date		 =   $row->transaction_dateoftransaction;
        		 $affAmnt 	 =   $row->transaction_amttobepaid;
                 $adminAmnt  =   $row->transaction_admin_amount;

                 # converting to user currency
                 if($currCaption != $default_currency_caption){
                        $affAmnt 	 =   getCurrencyValue($date, $currCaption, $affAmnt);
        		 		$adminAmnt   =   getCurrencyValue($date, $currCaption, $adminAmnt);

                 }

               $impression	=	$affAmnt   + $adminAmnt	+	$impression; //total click amnt

            }
   #== end of Modification on 17-JUNE.06 to get impression commission
		   
         }



         $sql		=	"SELECT *  from partners_transaction where transaction_flag=1 and transaction_parentid='$AFFILIATEID'  and transaction_status like 'pending'";
         $result	=	mysqli_query($con,$sql);
         $npensub   =  mysqli_num_rows($result)+$npensub; //no of sale

         while($row=mysqli_fetch_object($result))
         {
         		 # get transaction details
                 $date		 =   $row->transaction_dateoftransaction;
        		 $Amnt 	     =   $row->transaction_subsale;

                 # converting to user currency
                 if($currCaption != $default_currency_caption){
                        $Amnt 	 =   getCurrencyValue($date, $currCaption, $Amnt);

                 }
                      $pensubsale=$affAmnt   +  $pensubsale;//total sale amnt
         }  //end  while

        $total=$nclick."~".$click."~".$nlead."~".$lead."~".$nsale."~".$sale."~".$approvedamnt."~".$pendingamnt."~".$pensubsale."~". $rejectedamnt."~".$subsale."~".$nsub."~".$nreverse."~".$napproved."~".$impression;

         return($total);

 }

 function GetTotalAffiliates($sql)
    {
		     $MERCHANTID =$_SESSION['MERCHANTID'];   //merchantid
      $con = $GLOBALS["con"];

      //$sql      ="select * from partners_rotatorsta, partners_rotator, partners_affiliate WHERE rotatorsta_merid='$MERCHANTID'  AND rotator_id=rotatorsta_roid AND rotator_affilid=affiliate_id ";

     $MERCHANTID    =$_SESSION['MERCHANTID'];   //merchantid
     $sql3			=$sql." and joinpgm_status not like('waiting')" ;
	 
	
     $result		=mysqli_query($con,$sql3);
     $noaff			=mysqli_num_rows($result);
     $pendingtrans	=0;

     $result		=mysqli_query($con,$sql);
     while($row=mysqli_fetch_object($result))
      {
       $joinid			=$row->joinpgm_id;
       $sql2			="select * from partners_transaction where transaction_status='pending' and transaction_joinpgmid='$joinid'";
       //var_dump($sql2);
       $result3			=mysqli_query($con,$sql2);
       $pendingtrans	=$pendingtrans+mysqli_num_rows($result3);
      }
     $sql1			=$sql." and joinpgm_status like 'waiting'" ;
     $result		=mysqli_query($con,$sql1);
     $waitingaff	=mysqli_num_rows($result);
     
     $result		=mysqli_query($con,$sql);
     $rotator		=mysqli_num_rows($result);
     $totalaff		= $noaff."~".$waitingaff."~".$pendingtrans."~".$rotator;

     return($totalaff);

    }



   function GetTotalAffiliates1($sql)
    {
      $con = $GLOBALS["con"];

     $MERCHANTID =$_SESSION['MERCHANTID'];   //merchantid
     $sql3=$sql." and joinpgm_status not like('waiting')" ;
     $result=mysqli_query($con,$sql3);
     $noaff=mysqli_num_rows($result);
     $pendingtrans=0;

     $result=mysqli_query($con,$sql);
     while($row=mysqli_fetch_object($result))
      {
       $joinid=$row->joinpgm_id;
       $sql2="select * from partners_transaction where transaction_status='pending' and transaction_joinpgmid='$joinid'";
      // echo "$sql";
       $result3=mysqli_query($con,$sql2);
       $pendingtrans=$pendingtrans+mysqli_num_rows($result3);
      }
     $sql1=$sql." and joinpgm_status like 'waiting'" ;
     $result=mysqli_query($con,$sql1);
     $waitingaff=mysqli_num_rows($result);

     $totalaff= $noaff."~".$waitingaff."~".$pendingtrans;

     return($totalaff);

    }



  //getting advertising links for pgmid
  function GetLinks($pgmid,$MERCHANTID)
  {
    $con = $GLOBALS["con"];

    switch ($pgmid)
    {
             case 0:
                           $sql="select * from partners_program,partners_banner where program_merchantid='$MERCHANTID' and banner_programid=program_id";
                           $result=mysqli_query($con,$sql);
                           $nobanner=mysqli_num_rows($result);
                           $sql="select * from partners_popup,partners_program  where program_merchantid='$MERCHANTID'  and popup_programid=program_id";
                           $result=mysqli_query($con,$sql);
                           $nopopup=mysqli_num_rows($result);
                           $sql="select * from partners_flash,partners_program  where program_merchantid='$MERCHANTID'  and flash_programid=program_id";
                           $result=mysqli_query($con,$sql);
                           $noflash=mysqli_num_rows($result);
                           $sql="select * from partners_html,partners_program  where program_merchantid='$MERCHANTID' and html_programid=program_id";
                           $result=mysqli_query($con,$sql);
                           $nohtml=mysqli_num_rows($result);
                   
						   #modified for Template Text
                           $sql="select * from partners_text,partners_program where program_merchantid='$MERCHANTID'  and text_programid=program_id";
                           $result=mysqli_query($con,$sql);
                           $notemptext=mysqli_num_rows($result);
						   $sql="select * from partners_text_old,partners_program where program_merchantid='$MERCHANTID'  and text_programid=program_id";
                           $result=mysqli_query($con,$sql);
                           $notext=mysqli_num_rows($result);
				   
                        break;
             default:
                            $sql="select * from partners_banner where banner_programid='$pgmid'";
                           $result=mysqli_query($con,$sql);
                           $nobanner=mysqli_num_rows($result);
                           $sql="select * from partners_popup where popup_programid='$pgmid'";
                           $result=mysqli_query($con,$sql);
                           $nopopup=mysqli_num_rows($result);
                           $sql="select * from partners_flash where flash_programid='$pgmid'";
                           $result=mysqli_query($con,$sql);
                           $noflash=mysqli_num_rows($result);
                           $sql="select * from partners_html where html_programid='$pgmid'";
                           $result=mysqli_query($con,$sql);
                           $nohtml=mysqli_num_rows($result);
						   
						   #modified for Template Text
						   $sql="select * from partners_text where text_programid='$pgmid'";
                           $result=mysqli_query($con,$sql);
                           $notemptext=mysqli_num_rows($result);
                           $sql="select * from partners_text_old where text_programid='$pgmid'";
                           $result=mysqli_query($con,$sql);
                           $notext=mysqli_num_rows($result);
						   
                       break;
    }

   $nolink= $nobanner."~".$notext."~".$nopopup."~".$noflash."~".$nohtml."~".$notemptext;
   return($nolink);
  }


  function GetLinks1($pgmid,$AFFILIATEID)
  {
    $con = $GLOBALS["con"];

    switch ($pgmid)
    {
             case 0:
                           $sql="select * from partners_joinpgm,partners_banner where joinpgm_affiliateid='$AFFILIATEID' and banner_programid=joinpgm_programid";
                           $result=mysqli_query($con,$sql);
                           $nobanner=mysqli_num_rows($result);
                           $sql="select * from partners_text,partners_joinpgm where joinpgm_affiliateid='$AFFILIATEID'  and text_programid=joinpgm_programid";
                           $result=mysqli_query($con,$sql);
                           $notext=mysqli_num_rows($result);
                           $sql="select * from partners_popup,partners_joinpgm where joinpgm_affiliateid='$AFFILIATEID'  and popup_programid=joinpgm_programid";
                           $result=mysqli_query($con,$sql);
                           $nopopup=mysqli_num_rows($result);
                           $sql="select * from partners_flash,partners_joinpgm  where joinpgm_affiliateid='$AFFILIATEID'  and flash_programid=joinpgm_programid";
                           $result=mysqli_query($con,$sql);
                           $noflash=mysqli_num_rows($result);
                           $sql="select * from partners_html,partners_joinpgm  where joinpgm_affiliateid='$AFFILIATEID' and html_programid=joinpgm_programid";
                           $result=mysqli_query($con,$sql);
                           $nohtml=mysqli_num_rows($result);
                    //   echo "$sql";
                        break;
             default:
                            $sql="select * from partners_banner where banner_programid='$pgmid'";
                           $result=mysqli_query($con,$sql);
                           $nobanner=mysqli_num_rows($result);
                           $sql="select * from partners_text where text_programid='$pgmid'";
                           $result=mysqli_query($con,$sql);
                           $notext=mysqli_num_rows($result);
                           $sql="select * from partners_popup where popup_programid='$pgmid'";
                           $result=mysqli_query($con,$sql);
                           $nopopup=mysqli_num_rows($result);
                           $sql="select * from partners_flash where flash_programid='$pgmid'";
                           $result=mysqli_query($con,$sql);
                           $noflash=mysqli_num_rows($result);
                           $sql="select * from partners_html where html_programid='$pgmid'";
                           $result=mysqli_query($con,$sql);
                           $nohtml=mysqli_num_rows($result);
                       break;
    }

   $nolink= $nobanner."~".$notext."~".$nopopup."~".$noflash."~".$nohtml;
   return($nolink);
  }


  function GetAffiliateDetails($joinid)   {
$con = $GLOBALS["con"];

              $sql="select * from partners_joinpgm,partners_affiliate where joinpgm_id='$joinid' and joinpgm_affiliateid=affiliate_id";
              $result=mysqli_query($con,$sql);
            //  echo $sql;
              $row=mysqli_fetch_object($result);
              $name          =stripslashes(trim($row->affiliate_firstname))." ".stripslashes(trim($row->affiliate_lastname));
              $company       =stripslashes(trim($row->affiliate_company));
              $url           =stripslashes(trim($row->affiliate_url));
              $traffic       ="-----";
              $category      =stripslashes(trim($row->affiliate_category));

              $details=$name."~".$company."~".$url."~".$traffic."~".$category;
              //echo "$details";
   return($details);
  }


  function GetAffiliateDetails1($joinid)   {
$con = $GLOBALS["con"];

              $sql="select * from partners_affiliate where affiliate_id='$joinid'";
              $result=mysqli_query($con,$sql);
            //  echo $sql;
              $row=mysqli_fetch_object($result);
              $name          =stripslashes(trim($row->affiliate_firstname))." ".stripslashes(trim($row->affiliate_lastname));
              $company       =stripslashes(trim($row->affiliate_company));
              $url           =stripslashes(trim($row->affiliate_url));
              $traffic       ="-----";
              $category      =stripslashes(trim($row->affiliate_category));

              $details=$name."~".$company."~".$url."~".$traffic."~".$category;
              //echo "$details";
   return($details);
  }


   function GetAffiliateStatus($joinid)   {

$con = $GLOBALS["con"];

              $sql="select *,Date_Format(joinpgm_date,'%d-%b-%Y') d  from partners_joinpgm where joinpgm_id='$joinid' ";
              $result=mysqli_query($con,$sql);
              $row=mysqli_fetch_object($result);
              $status      =stripslashes(trim($row->joinpgm_status));
              $date1        =$row->d;
              $status=$status."~".$date1;
              //echo "$sql";
   return($status);
  }


  function GetAffiliateStatus1($joinid)   {

$con = $GLOBALS["con"];

              $sql="select *  from partners_rotatorsta where rotatorsta_id='$joinid' ";
              $result=mysqli_query($con,$sql) or die($sql. "<br/>".mysqli_error($con));
              $row=mysqli_fetch_object($result);
              $status      =stripslashes(trim($row->rotatorsta_status));

   return($status);
  }


 #-------------------------------------------------------------------------------
 #    Gte payment Details
 #-------------------------------------------------------------------------------
 function  GetPaymentStaus($joinid, $currCaption,$default_currency_caption)
 {

$con = $GLOBALS["con"];

 	if($currCaption == '') $currCaption = $default_currency_caption;

    $pendingamnt	=	0;
    $approvedamnt	=	0;
    $paidamnt		=	0;
    $rejectedamnt	=	0;

     $sql    =   "SELECT * from partners_transaction where transaction_status='pending' and transaction_joinpgmid='$joinid'";
     $result =   mysqli_query($con,$sql);
      while($row=mysqli_fetch_object($result))
      {
           # get transaction details
           $date       =   $row->transaction_dateoftransaction;
           $adminAmnt  =   $row->transaction_admin_amount;
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
						$affAmnt 	 =  $row_recurpay->recurpayments_amount; 
					}
				}
			 }
			 else
			 {	 
	// END Modified on 23-JUNE-06
	           $affAmnt    =   $row->transaction_amttobepaid;
			 }

           # converting to user currency
           if($currCaption != $default_currency_caption){
                  $affAmnt     =   getCurrencyValue($date, $currCaption, $affAmnt);
                  $adminAmnt   =   getCurrencyValue($date, $currCaption, $adminAmnt);

           }
          $pendingamnt=$affAmnt+$adminAmnt+$pendingamnt; //total pending amnt
      }

      $sql    =   "SELECT * from partners_transaction where transaction_status='approved' and transaction_joinpgmid='$joinid'";
      $result =   mysqli_query($con,$sql);

     while($row=mysqli_fetch_object($result))
     {
           # get transaction details
           $date       =   $row->transaction_dateoftransaction;
           $adminAmnt  =   $row->transaction_admin_amount;
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
						$affAmnt 	 =  $row_recurpay->recurpayments_amount; 
					}
				}
			 }
			 else
			 {	 
	// END Modified on 23-JUNE-06
	           $affAmnt    =   $row->transaction_amttobepaid;
			 }


           # converting to user currency
           if($currCaption != $default_currency_caption){
                  $affAmnt     =   getCurrencyValue($date, $currCaption, $affAmnt);
                  $adminAmnt   =   getCurrencyValue($date, $currCaption, $adminAmnt);

           }

          $approvedamnt=$adminAmnt + $affAmnt + $approvedamnt;// total approved amnt
     }

     $sql    =    "SELECT * from partners_transaction where transaction_joinpgmid='$joinid'";
     $result =    mysqli_query($con,$sql);

     while($row=mysqli_fetch_object($result))
     {

           # get transaction details
           $date       =   $row->transaction_dateoftransaction;
           $adminAmnt  =   $row->transaction_adminpaid;
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
			 else
			 {	 
	// END Modified on 23-JUNE-06
		           $affAmnt    =   $row->transaction_amountpaid;
			 }


           # converting to user currency
           if($currCaption != $default_currency_caption){
                  $affAmnt     =   getCurrencyValue($date, $currCaption, $affAmnt);
                  $adminAmnt   =   getCurrencyValue($date, $currCaption, $adminAmnt);

           }
          $paidamnt=$affAmnt+$adminAmnt+$paidamnt;//total sale amnt
     }

     $sql     =   "SELECT * from partners_transaction WHERE transaction_status='reversed' and transaction_joinpgmid='$joinid'";
     $result4 =   mysqli_query($con,$sql);

     while($row1=mysqli_fetch_object($result4))
     {
           # get transaction details
           $date       =   $row1->transaction_dateoftransaction;
           $affAmnt    =   $row1->transaction_admin_amount;

           # converting to user currency
           if($currCaption != $default_currency_caption){
                  $affAmnt     =   getCurrencyValue($date, $currCaption, $affAmnt);


           }
          $rejectedamnt= $affAmnt + $rejectedamnt;// total approved amnt
     }


    $payStatus=$approvedamnt."~".$pendingamnt."~".$paidamnt."~". $rejectedamnt;

    return($payStatus);
    }



 function  GetPaymentStaus1($joinid,$currCaption,$default_currency_caption)
 {
   $con = $GLOBALS["con"];

	if($currCaption == '') $currCaption = $default_currency_caption;
	

    $pendingamnt	=	0;
    $approvedamnt	=	0;
    $paidamnt		=	0;
    $rejectedamnt	=	0;

    $sql	=	"SELECT * from partners_transaction where transaction_status='pending' and transaction_joinpgmid='$joinid'";
    $result	=	mysqli_query($con,$sql);
    while($row=mysqli_fetch_object($result))
    {

           # get transaction details
           $date       =   $row->transaction_dateoftransaction;
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
						$affAmnt 	 =  $row_recurpay->recurpayments_amount; 
					}
				}
			 }
		// END Modified on 23-JUNE-06
			 else
			 {	 
		           $affAmnt    =   $row->transaction_amttobepaid;
			 }

           # converting to user currency
           if($currCaption != $default_currency_caption){
                  $affAmnt     =   getCurrencyValue($date, $currCaption, $affAmnt);

           }

          $pendingamnt=$affAmnt+$pendingamnt; //total pending amnt
    }


    $sql	=	"SELECT * from partners_transaction where transaction_status='approved' and transaction_joinpgmid='$joinid'";
    $result	=	mysqli_query($con,$sql);
    while($row=mysqli_fetch_object($result))
    {
          # get transaction details
           $date       =   $row->transaction_dateoftransaction;
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
						$affAmnt 	 =  $row_recurpay->recurpayments_amount; 
					}
				}
			 }
			 else
			 {	 
	// END Modified on 23-JUNE-06
			   $affAmnt    =   $row->transaction_amttobepaid;
			 }

           # converting to user currency
           if($currCaption != $default_currency_caption){
                  $affAmnt     =   getCurrencyValue($date, $currCaption, $affAmnt);

           }

          $approvedamnt =$affAmnt + $approvedamnt;

    }  //end while


    $sql	=	"SELECT * from partners_transaction where transaction_joinpgmid='$joinid'";
    $result	=	mysqli_query($con,$sql);
    while($row=mysqli_fetch_object($result))
    {
        # get transaction details
           $date       =   $row->transaction_dateoftransaction;
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
			 else
			 {	 
	// END Modified on 23-JUNE-06
		           $affAmnt    =   $row->transaction_amttobepaid;
			 }

           # converting to user currency
           if($currCaption != $default_currency_caption){
                  $affAmnt     =   getCurrencyValue($date, $currCaption, $affAmnt);

           }

          $paidamnt =$affAmnt + $paidamnt;

    }


    $sql	=	"SELECT * from partners_transaction where  transaction_status='reversed' and transaction_joinpgmid='$joinid'";
    $result4=mysqli_query($con,$sql);
    while($row1=mysqli_fetch_object($result4))
    {
        # get transaction details
           $date       =   $row1->transaction_dateoftransaction;
           $affAmnt    =   $row1->transaction_amttobepaid;

           # converting to user currency
           if($currCaption != $default_currency_caption){
                  $affAmnt     =   getCurrencyValue($date, $currCaption, $affAmnt);

           }

          $rejectedamnt =$affAmnt + $rejectedamnt;

    }  //end while



    $payStatus=$approvedamnt."~".$pendingamnt."~".$paidamnt."~". $rejectedamnt;

    return($payStatus);
    }

   #-------------------------------------------------------------------------------
   #   Get commsion RATE
   #-------------------------------------------------------------------------------
   function GetTransaction($transid ,$currCaption,$default_currency_caption)
    {
      $con = $GLOBALS["con"];

		if($currCaption == '') $currCaption = $default_currency_caption;
	
     $sql	=	"select *,Date_Format(transaction_dateoftransaction,'%d-%b-%Y') d from partners_transaction where transaction_id='$transid'";
     $ret	=	@mysqli_query($con,$sql);
     $row	=	@mysqli_fetch_object($ret);

      # get transaction details
     $type 			=	$row->transaction_type;
     $status		=	$row->transaction_status;
     $date          =   $row->transaction_dateoftransaction;
     $adminAmnt     =   $row->transaction_admin_amount;
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
		 else
		 {	 
// END Modified on 23-JUNE-06
		     $affAmnt       =   $row->transaction_amttobepaid;
		 }

       # converting to user currency
       // if($currCaption != $default_currency_caption){
       //      $affAmnt 	 =   getCurrencyValue($date, $currCaption, $affAmnt);
       // 		$adminAmnt   =   getCurrencyValue($date, $currCaption, $adminAmnt);
       // }



     $commission	=	$affAmnt + $adminAmnt;
     $date			=	$row->d;
     $transStat		=	$type."~".$commission."~".$date."~".$status;
     return($transStat);
    }


   function  GetPaymentDetails4($sql,$To,$From,$currCaption,$default_currency_caption)
 {
  $con = $GLOBALS["con"];

	if($currCaption == '') $currCaption = $default_currency_caption;

    $result3=mysqli_query($con,$sql);
    $pendingamnt=0;
    $approvedamnt=0;
    $paidamnt=0;
    $rejectedamnt=0;


    while($rows=mysqli_fetch_object($result3))
    {
    $joinid=$rows->joinpgm_id;

    $sql="SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_status='pending' and transaction_joinpgmid='$joinid'";
    $result4=mysqli_query($con,$sql);
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


   // echo "$sql";
  //  echo "$nclick";
    $sql="SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_status='approved' and transaction_joinpgmid='$joinid'";
    $result4=mysqli_query($con,$sql);
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
    $sql="SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_joinpgmid='$joinid'";
    $result4=mysqli_query($con,$sql);
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
            $affAmnt     = $affAmnt + $adminAmnt;
       }
      $affAmnt     = $affAmnt + $adminAmnt;
      $paidamnt=$affAmnt+$paidamnt;//total sale amnt
    }  //end  while

		$sql="SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_status='reversed' and transaction_joinpgmid='$joinid'";
		$result4=mysqli_query($con,$sql);
		while($row1=mysqli_fetch_object($result4))
		{
		 # get transaction details
		   $date		 =   $row1->transaction_dateoftransaction;
		   $affAmnt 	 =   $row1->transaction_amttobepaid;
		   $adminAmnt    =   $row1->transaction_admin_amount;
	
		   # converting to user currency
		   if($currCaption != $default_currency_caption){
				$affAmnt 	 =   getCurrencyValue($date, $currCaption, $affAmnt);
				$adminAmnt   =   getCurrencyValue($date, $currCaption, $adminAmnt);
	
		   }
		$rejectedamnt=$adminAmnt+$rejectedamnt;// total approved amnt
		}  //end while
		
			//Calculate reversed commissions fro Recurring sales
			$sql_rev = "SELECT * FROM partners_transaction, partners_recur, partners_recurpayments WHERE ".
			" transaction_joinpgmid=$joinid AND recur_transactionid=transaction_id AND ".
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
    $total=$approvedamnt."~".$pendingamnt."~".$paidamnt."~".$rejectedamnt;
     return($total);
 }



 function GetTotalPro($aid,$mid)
          {
            $con = $GLOBALS["con"];
            
            $today      = date("Y-m-d");
  			$query		= "select * from partners_joinpgm where joinpgm_merchantid='$mid' and joinpgm_affiliateid='$aid'";
            $ret		= mysqli_query($con,$query);     //finding joined pgms///////////////////

            // finding  joined pgms id/////////////
            $a  ="(";
            $i  =1;
            while($row=mysqli_fetch_object($ret))
            {
              if (mysqli_num_rows($ret)==$i)
                 $a  =$a.$row->joinpgm_programid;
              else
                 $a  =$a.$row->joinpgm_programid.",";
              $i=$i+1;
            }
            $a  .= ")";
            ///////////////////////////////////////

            if (mysqli_num_rows($ret)==0)          //no joined pgms
                $sql	= "select * from partners_program where program_status like ('active') and program_merchantid='$mid' ";
            else                                  //pgms which are not joined
                $sql	= "select * from partners_program where program_status like ('active') and program_id not in $a and program_merchantid='$mid' ";
             $result=mysqli_query($con,$sql);
             while($row=mysqli_fetch_object($result))
             {
                $pgmid=$row->program_id;
                $sql	= "insert partners_joinpgm(joinpgm_programid,joinpgm_merchantid,joinpgm_affiliateid,joinpgm_status,joinpgm_date) values ('$pgmid','$mid','$aid','approved','$today')  ";
                mysqli_query($con,$sql);
             }
       }
?>