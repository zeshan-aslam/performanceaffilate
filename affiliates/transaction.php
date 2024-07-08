<?php

  function GetLinks($pgmid,$AFFILIATEID)
  {
  	$con = $GLOBALS["con"];

    switch ($pgmid)
    {
             case 0:
                           $sql     ="select * from partners_joinpgm,partners_banner where joinpgm_affiliateid ='$AFFILIATEID' and banner_programid=joinpgm_programid";
                           $result  =mysqli_query($con,$sql);
                           $nobanner=mysqli_num_rows($result);
                           $sql     ="select * from partners_text,partners_joinpgm where joinpgm_affiliateid ='$AFFILIATEID'  and text_programid=joinpgm_programid";
                           $result  =mysqli_query($con,$sql);
                           $notext  =mysqli_num_rows($result);
                           $sql     ="select * from partners_popup,partners_joinpgm where joinpgm_affiliateid ='$AFFILIATEID'  and popup_programid=joinpgm_programid";
                           $result  =mysqli_query($con,$sql);
                           $nopopup =mysqli_num_rows($result);
                           $sql     ="select * from partners_flash,partners_joinpgm  where joinpgm_affiliateid ='$AFFILIATEID'  and flash_programid=joinpgm_programid";
                           $result  =mysqli_query($con,$sql);
                           $noflash =mysqli_num_rows($result);
                           $sql     ="select * from partners_html,partners_joinpgm  where joinpgm_affiliateid ='$AFFILIATEID' and html_programid=joinpgm_programid";
                           $result  =mysqli_query($con,$sql);
                           $nohtml  =mysqli_num_rows($result);
                    //   echo "$sql";
                           break;
             default:
                           $sql     ="select * from partners_banner,partners_joinpgm where joinpgm_id ='$pgmid' and banner_programid=joinpgm_programid ";
                           $result  =mysqli_query($con,$sql);
                           $nobanner=mysqli_num_rows($result);
                           $sql     ="select * from partners_text,partners_joinpgm where joinpgm_id ='$pgmid' and text_programid=joinpgm_programid";
                           $result  =mysqli_query($con,$sql);
                           $notext  =mysqli_num_rows($result);
                           $sql     ="select * from partners_popup,partners_joinpgm where joinpgm_id ='$pgmid' and popup_programid=joinpgm_programid";
                           $result  =mysqli_query($con,$sql);
                           $nopopup =mysqli_num_rows($result);
                           $sql     ="select * from partners_flash,partners_joinpgm where joinpgm_id ='$pgmid' and flash_programid=joinpgm_programid";
                           $result  =mysqli_query($con,$sql);
                           $noflash =mysqli_num_rows($result);
                           $sql     ="select * from partners_html,partners_joinpgm where joinpgm_id ='$pgmid' and html_programid=joinpgm_programid";
                           $result  =mysqli_query($con,$sql);
                           $nohtml  =mysqli_num_rows($result);
                           break;
    }

   $nolink= $nobanner."~".$notext."~".$nopopup."~".$noflash."~".$nohtml;
   return($nolink);
  }
   function  GetPaymentDetails($sql, $currCaption,$default_currency_caption)
 {
 	$con = $GLOBALS["con"];
 		if($currCaption == '') $currCaption = $default_currency_caption;

    $result1		=	mysqli_query($con,$sql);
    $AFFILIATEID	=	$_SESSION['AFFILIATEID'];

    //initiating
	$impression	   = 0;
	$impression_count		  =0;
	
    $click         = 0;
    $lead          = 0;
    $sale          = 0;
    $nclick        = 0;
    $nlead         = 0;
    $nsale         = 0;
    $pendingamnt   = 0;
    $approvedamnt  = 0;
    $paidamnt      = 0;
    $rejectedamnt  = 0;
    $nreverse      = 0;
    $nsub          = 0;

    while($rows=mysqli_fetch_object($result1))
    {
            $joinid   =$rows->joinpgm_id;
			
			//Added by SMA to find the impression comission amt on 16-JUNE-06
            $sql      ="SELECT * from partners_transaction where transaction_type='impression' and transaction_joinpgmid ='$joinid' ";
            $result   =mysqli_query($con,$sql);
            while($row=mysqli_fetch_object($result))
            {
                //$impression=$row->transaction_amttobepaid+$impression; //total impression amt
			
				$imp_amt = $row->transaction_amttobepaid;
				$date		 =   $row->transaction_dateoftransaction;
				$impression = $imp_amt + $impression;
				
				//To get the number of impressions
				$trans_id = $row->transaction_id;
				$trans_sql = "SELECT * FROM partners_trans_rates WHERE trans_id='$trans_id'";
				$trans_result = mysqli_query($con,$trans_sql);
				if(mysqli_num_rows($trans_result) > 0)
				{ 
					$trans_row = mysqli_fetch_object($trans_result);
					$impression_count = $trans_row->trans_unit + $impression_count;
				}
            }
			//End add on 16-JUNE-06
			

            $sql      ="SELECT * from partners_transaction where transaction_type='click' and transaction_joinpgmid ='$joinid' ";
            $result   =mysqli_query($con,$sql);
            $nclick   =mysqli_num_rows($result)+$nclick;   //no of click
            while($row=mysqli_fetch_object($result))
			{
 				$date		 =   $row->transaction_dateoftransaction;
				$click_amt	= $row->transaction_amttobepaid;
				
               $click = $click_amt + $click; //total click amnt
			}


           // echo "$sql";
          //  echo "$nclick";
            $sql    ="SELECT * from partners_transaction where transaction_type='lead' and transaction_joinpgmid ='$joinid' ";
            $result =mysqli_query($con,$sql);
            $nlead  =mysqli_num_rows($result)+$nlead;  //no of lead

            while($row=mysqli_fetch_object($result))
			{
 				$date		 =   $row->transaction_dateoftransaction;
				$lead_amt	= $row->transaction_amttobepaid;
				
                $lead = $lead_amt + $lead;// total lead amnt
			}  //end while



           // $sql="SELECT sum( transaction_amttobepaid ) sale from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='sale' and transaction_joinpgmid=$joinid";
            $sql      ="SELECT *  from partners_transaction where  transaction_type='sale' and transaction_joinpgmid ='$joinid'";
            $result   =mysqli_query($con,$sql);
            $nsale    =mysqli_num_rows($result)+$nsale; //no of sale
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
							$date		 =   $row_recurpay->recurpayments_date;
							$sale_amt	= $row_recurpay->recurpayments_amount;
							
							$sale 	 = $sale_amt  + $sale; 
						}
					}
				 }
				 else
				 {	 
		// END Modified on 23-JUNE-06
	 				$date		 =   $row->transaction_dateoftransaction;
					$sale_amt	= $row->transaction_amttobepaid;
					
                	$sale = $sale_amt + $sale;//total sale amnt
				 }
            }  //end  while


           $sql="SELECT * from partners_transaction where transaction_status='pending' and transaction_joinpgmid=$joinid";
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
							$date		 =   $row_recurpay->recurpayments_date;
							$pend_amt	= $row_recurpay->recurpayments_amount;
						   
							$pendingamnt 	 = $pend_amt  + $pendingamnt; 
						}
					}
				 }
				 else
				 {	 
		// END Modified on 23-JUNE-06
					$date		 =   $row->transaction_dateoftransaction;
					$pending_amt	= $row->transaction_amttobepaid;

               		$pendingamnt = $pending_amt  + $pendingamnt; //total pending amnt
				 }
           }


         //echo "$sql";
       //  echo "$nclick";
         $sql="SELECT * from partners_transaction where transaction_status='approved' and transaction_joinpgmid=$joinid";
         $result=mysqli_query($con,$sql);
         $napproved    =mysqli_num_rows($result)+$napproved; //no of sale
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
						$date		 =   $row_recurpay->recurpayments_date;
						$app_amt	=  $row_recurpay->recurpayments_amount;
						
						$approvedamnt 	 =  $app_amt + $approvedamnt; 
					}
				}
			 }
			 else
			 {	 
	// END Modified on 23-JUNE-06
					$date		 =   $row->transaction_dateoftransaction;
					$apprv_amt	= $row->transaction_amttobepaid;
	
	               $approvedamnt = $apprv_amt + $approvedamnt;// total approved amnt
			 }
         }  //end while



        // $sql="SELECT sum( transaction_amttobepaid ) sale from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='sale' and transaction_joinpgmid=$joinid";
         $sql="SELECT * from partners_transaction where transaction_joinpgmid=$joinid";
         $result=mysqli_query($con,$sql);
        // $nsale    =mysqli_num_rows($result)+$nsale; //no of sale
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
						
						$date		 =   $row_recurpay->recurpayments_date;
						$paid_amt	=  $row_recurpay->recurpayments_amount;
						
						$paidamnt 	 = $paid_amt  + $paidamnt; 
					}
				}
			 }
			 else
			 {	 
	// END Modified on 23-JUNE-06
					$date		 =   $row->transaction_dateoftransaction;
					$paid_amt	= $row->transaction_amttobepaid;
	
	               $paidamnt = $paid_amt + $paidamnt;//total sale amnt
			 }
         }
          //end  while
			 $sql="SELECT * from partners_transaction WHERE transaction_status='reversed' and transaction_joinpgmid=$joinid";
			 $result4=mysqli_query($con,$sql);
			 $nreverse    =mysqli_num_rows($result4)+$nreverse;
			 while($row1=mysqli_fetch_object($result4))
			 {
					$date		 =   $row->transaction_dateoftransaction;
					$reject_amt	= $row->transaction_amttobepaid;
					
				  	$rejectedamnt = $reject_amt + $rejectedamnt;// total approved amnt
			 }  //end while
         }
         // end while  1




        $total=$nclick."~".$click."~".$nlead."~".$lead."~".$nsale."~".$sale."~".$approvedamnt."~".$pendingamnt."~".$pensubsale."~". $rejectedamnt."~".$subsale."~".$nsub."~".$nreverse."~".$napproved."~".$impression."~".$impression_count;

         return($total);
 }

  function GetmerchantDetails($joinid)   {
$con = $GLOBALS["con"];

              $sql           ="select * from partners_merchant where merchant_id=$joinid";
              $result        =mysqli_query($con,$sql);
              $row           =mysqli_fetch_object($result);
              $name          =stripslashes(trim($row->merchant_firstname))." ".stripslashes(trim($row->merchant_lastname));
              $company       =stripslashes(trim($row->merchant_company));
              $url           =stripslashes(trim($row->merchant_url));
            //$traffic       =stripslashes(trim($row->affiliate_traffic));
              $category      =stripslashes(trim($row->merchant_category));

              $details=$name."~".$company."~".$url."~".$traffic."~".$category;
              //echo "$details";
   return($details);
  }
    function GetTransaction($transid, $currCaption='Dollar')
    {
    	$con = $GLOBALS["con"];
     $sql        ="select *,Date_Format(transaction_dateoftransaction,'%d-%b-%Y') d from partners_transaction where transaction_id=$transid";
     $ret        =mysqli_query($con,$sql);
     $row        =mysqli_fetch_object($ret);
     $type       =$row->transaction_type;
     $status     =$row->transaction_status;
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
					
					$date		 =   $row_recurpay->recurpayments_date;
					$com_amt	=  $row_recurpay->recurpayments_amount;
					/*
					# converting to user currency
					if($currCaption != "Dollar"){
						$com_amt 	 =   getCurrencyValue($date, $currCaption, $com_amt);
					}	*/
					
					$commission 	 =  $com_amt; 
				}
			}
		 }
		 else
		 {	 
// END Modified on 23-JUNE-06
				$date		 =   $row->transaction_dateoftransaction;
				$commn_amt	= $row->transaction_amttobepaid;
				/*
				# converting to user currency
				if($currCaption != "Dollar"){
					$commn_amt 	 =   getCurrencyValue($date, $currCaption, $commn_amt);
				}	*/

		     $commission =$commn_amt;
		 }
     $date       =$row->d;
     $transStat  =$type."~".$commission."~".$date."~".$status;
     return($transStat);
    }
	
	
    function GetAffiliateDetails($joinid)   {

$con = $GLOBALS["con"];
              $sql="select * from partners_joinpgm,partners_affiliate where joinpgm_id=$joinid and joinpgm_affiliateid=affiliate_id";
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
              $sql="select *,Date_Format(joinpgm_date,'%d-%b-%Y') d  from partners_joinpgm where joinpgm_id=$joinid ";
              $result=mysqli_query($con,$sql);
              $row=mysqli_fetch_object($result);
              $status      =stripslashes(trim($row->joinpgm_status));
              $date1        =$row->d;
              $status=$status."~".$date1;
              //echo "$sql";
   return($status);
  }

   /* GetCategory($cat)
    {
        $sql=select * from partners_merchant,partners_program where program_status='active' and merchant_category='$cat[$i]' and merchant_id=program_id
        $ret=mysqli_query($con,$sql);
        $no=mysqli_num_rows($ret);
        return $no;
    }
*/




?>