<?php	ob_start();
   /***************************************************************************************************
     PROGRAM DESCRIPTION :  PROGRAM TO VIEW LINK REPORTS (PROCESSING PAGE)
      VARIABLES          :  $MERCHANTID         =merchantid
                                $From ,$cFrom       =from date
                                $To,cTo             =to date
                                $sub                =submit button
                                $msg                =errmsg
                                $LINKS              =getting statstics
                            $total              =statstics
                                $programs           =program id
                            $click              =click amnt
                            $lead               =lead amnt
                                $sale               =sale amnt
                                $nclick             =no of click
                            $nlead              =no of lead
                                $nsale              =no of sale
                                $subsale            =subsale amnt
                                $nsubsale           =total sub sale
                                $pendingamnt        =pending amnt
                                $approvedamnt       =approved amnt
                                $paidamnt           =paid amnt
                                $rejectedamnt       =reversed amnt
  //*************************************************************************************************/


  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
  include_once '../includes/session.php';


   $partners=new partners;
   $partners->connection($host,$user,$pass,$db);

         include_once 'language_include.php';

   /*******************variables************************************************/
   $cfrom             = trim($_POST['txtfrom']);  //from date
   $cto               = trim($_POST['txtto']);    //to date
   $sub               = trim($_POST['sub']);      //submit button
   $programs          = intval(trim($_POST['programs'])); //program id
   $MERCHANTID        = $_SESSION['MERCHANTID'];  //merchantid
   $_SESSION['LINKS'] = "";                      //initialise statistics
   $currValue         = $_POST['currValue'];
   /***************************************************************************/

   /*****************validation************************************************/
   if(!$partners->is_date($cfrom) || !$partners->is_date($cto) )
   {
    $Err=$lang_report_err ;
    header("location:index.php?Act=LinkReport&programs=$programs&msg=$Err");
    exit;
   }

   $From                        =$partners->date2mysql($cfrom);
   $To                          =$partners->date2mysql($cto);
   /***************************************************************************/

   /************select programs***********************************************/
   switch($programs)
   {
     case 'All':
        $sql       ="SELECT * from partners_program  where program_merchantid='$MERCHANTID'    ";
        break;
     default:
         $sql      ="SELECT * from partners_program where program_id='$programs' ";
         break;
      }
     $result       =mysqli_query($con,$sql);
    /**************************************************************************/

     /**************getting statistics of particular pgnm*************************/
     while($row=mysqli_fetch_object($result))
                          {
                                 $pgmid         =$row->program_id;
                                 $sql           ="select * from partners_banner where banner_programid='$pgmid'";
                                 $ret           =mysqli_query($con,$sql);
                                  //for all banners
                              while($rows=mysqli_fetch_object($ret))
                                 {
                                 $From          =$partners->date2mysql($txtfrom);
                                 $To            =$partners->date2mysql($txtto);
                                 $total         =get($To,$From,B.$rows->banner_id,$currValue,$default_currency_caption);
                                 $_SESSION['LINKS'] = $_SESSION['LINKS']."^".$total ;
                                 }

                                 $sql           ="select * from partners_text where text_programid='$pgmid'";
                                 $ret           =mysqli_query($con,$sql);
                                  //for all text
                              while($rows=mysqli_fetch_object($ret))
                                 {
                                 $From          =$partners->date2mysql($txtfrom);
                                 $To            =$partners->date2mysql($txtto);
                                 $total         =get($To,$From,T.$rows->text_id,$currValue,$default_currency_caption);
                                 $_SESSION['LINKS'] = $_SESSION['LINKS']."^".$total ;

                                   }

                                 $sql           ="select * from partners_popup where popup_programid='$pgmid'";
                                 $ret           =mysqli_query($con,$sql);
                                  //for all popup
                              while($rows=mysqli_fetch_object($ret))
                                 {
                                 $From          =$partners->date2mysql($txtfrom);
                                 $To            =$partners->date2mysql($txtto);
                                 $total         =get($To,$From,P.$rows->popup_id,$currValue,$default_currency_caption);
                                 $_SESSION['LINKS'] = $_SESSION['LINKS']."^".$total ;
                                 }

                                 $sql           ="select * from partners_flash where flash_programid='$pgmid'";
                                 $ret           =mysqli_query($con,$sql);
                                  //for all flash
                             while($rows=mysqli_fetch_object($ret))
                                 {
                                 $From          =$partners->date2mysql($txtfrom);
                                 $To            =$partners->date2mysql($txtto);
                                 $total         =get($To,$From,F.$rows->flash_id,$currValue,$default_currency_caption);
                                 $_SESSION['LINKS'] = $_SESSION['LINKS']."^".$total ;
                                 }


                                 $sql           ="select * from partners_html where html_programid='$pgmid'";
                                 $ret           =mysqli_query($con,$sql);
                                  //for all html
                             while($rows=mysqli_fetch_object($ret))
                                 {
                                 $From          =$partners->date2mysql($txtfrom);
                                 $To            =$partners->date2mysql($txtto);
                                 $total         =get($To,$From,H.$rows->html_id,$currValue,$default_currency_caption);
                                 $_SESSION['LINKS'] = $_SESSION['LINKS']."^".$total ;
                                 }
								 
								##added on 21.APR.06 to add the template text ad
								$sql           ="select * from partners_text1 where text_programid='$pgmid'";
								$ret           =mysqli_query($con,$sql);
								//for all template text
								while($rows=mysqli_fetch_object($ret))
								{
									$From          =$partners->date2mysql($txtfrom);
									$To            =$partners->date2mysql($txtto);
									$total         =get($To,$From,N.$rows->text_id,$currValue,$default_currency_caption);//die($total);
									$_SESSION['LINKS'] = $_SESSION['LINKS']."^".$total ;
								}

                      }
      /**************************************************************************/

  HEADER("location:index.php?Act=LinkReport&sub=$sub&i=1&txtto=$txtto&txtfrom=$txtfrom&programs=$programs");




   /******************getting statistics for particular linkid******************/
  function get($To,$From,$linkid,$currValue,$default_currency_caption)
  {
	if($currValue == '') $currValue = $default_currency_caption;

    //initiating
    $click                 =0;
    $lead                  =0;
    $sale                  =0;
    $nclick                =0;
    $nlead                 =0;
    $nsale                 =0;
    $subsale               =0;
    $nsubsale              =0;
    $pendingamnt           =0;
    $approvedamnt          =0;
    $paidamnt              =0;
    $rejectedamnt          =0;
    $impression            =0;
    $impression_counts     =0;



            $sql        = "SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_type='click' and transaction_linkid='$linkid'";
            $result     = mysqli_query($con,$sql);
            $nclick     = mysqli_num_rows($result)+$nclick;

            while($row=mysqli_fetch_object($result))
            {
                 # get transaction details
                   $date         =   $row->transaction_dateoftransaction;
                   $affAmnt      =   $row->transaction_amttobepaid;
                   $adminAmnt    =   $row->transaction_admin_amount;

                   # converting to user currency
                   if($currValue != $default_currency_caption){
                        $affAmnt     =   getCurrencyValue($date, $currValue, $affAmnt);
                        $adminAmnt   =   getCurrencyValue($date, $currValue, $adminAmnt);
                   }
                $click    = $affAmnt + $adminAmnt + $click; //total click amnt
            }


            $sql      = "SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_type='lead' and transaction_linkid='$linkid'";
            $result   = mysqli_query($con,$sql);
            $nlead    = mysqli_num_rows($result)+$nlead;  //no of lead

            while($row=mysqli_fetch_object($result))
            {
               $date         =   $row->transaction_dateoftransaction;
                   $affAmnt      =   $row->transaction_amttobepaid;
                   $adminAmnt    =   $row->transaction_admin_amount;

                   # converting to user currency
                   if($currValue != $default_currency_caption){
                        $affAmnt     =   getCurrencyValue($date, $currValue, $affAmnt);
                        $adminAmnt   =   getCurrencyValue($date, $currValue, $adminAmnt);
                   }
                $lead           = $affAmnt + $adminAmnt + $lead;// total lead amnt
            }  //end while


            $sql        =        "SELECT *  from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_type='sale' and transaction_linkid='$linkid'";
            $result =        mysqli_query($con,$sql);
            $nsale  =        mysqli_num_rows($result)+$nsale; //no of sale

            while($row=mysqli_fetch_object($result))
            {
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
					 else
					 {	 
			// END Modified on 23-JUNE-06
						   $affAmnt      =   $row->transaction_amttobepaid;
					 }

                   # converting to user currency
                   if($currValue != $default_currency_caption){
                        $affAmnt     =   getCurrencyValue($date, $currValue, $affAmnt);
                        $adminAmnt   =   getCurrencyValue($date, $currValue, $adminAmnt);
                   }
                $sale          =$affAmnt + $adminAmnt +$sale;//total sale amnt
            }

            $sql       = "SELECT *  from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_flag=1 and transaction_linkid='$linkid'";
            $result    = mysqli_query($con,$sql);
            $nsubsale  = mysqli_num_rows($result)+$nsubsale; //no of subsale
            while($row=mysqli_fetch_object($result))
            {

               $date         =   $row->transaction_dateoftransaction;
                   $affAmnt      =   $row->transaction_subsale;

                   # converting to user currency
                   if($currValue != $default_currency_caption){
                        $affAmnt     =   getCurrencyValue($date, $currValue, $affAmnt);

                   }

               $subsale      = $affAmnt+$subsale;//total sale amnt
            }  //end  while

            $sql      = "SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_status='approved' and transaction_linkid='$linkid'";
            $result4  = mysqli_query($con,$sql);

             while($row1=mysqli_fetch_object($result4))
             {

               $date         =   $row1->transaction_dateoftransaction;
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
	                   $affAmnt      =   $row1->transaction_amttobepaid;
					 }

                   # converting to user currency
                   if($currValue != $default_currency_caption){
                        $affAmnt     =   getCurrencyValue($date, $currValue, $affAmnt);
                        $adminAmnt   =   getCurrencyValue($date, $currValue, $adminAmnt);
                   }
                $approvedamnt=$affAmnt + $adminAmnt + $approvedamnt;// total approved amnt
             }


           // $sql="SELECT sum( transaction_amttobepaid ) sale from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='sale' and transaction_joinpgmid=$joinid";
            $sql       = "SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To'and transaction_linkid='$linkid'";
            $result4   = mysqli_query($con,$sql);
            while($row1=mysqli_fetch_object($result4))
            {
               $date         =   $row1->transaction_dateoftransaction;
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
	                   $affAmnt      =   $row1->transaction_amttobepaid;
				 }

                   # converting to user currency
                   if($currValue != $default_currency_caption){
                        $affAmnt     =   getCurrencyValue($date, $currValue, $affAmnt);
                        $adminAmnt   =   getCurrencyValue($date, $currValue, $adminAmnt);
                   }
               $paidamnt   = $affAmnt + $adminAmnt +$paidamnt;//total sale amnt
             }  //end  while


            $sql            ="SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_status='reversed' and transaction_linkid='$linkid'";
            $result4        =mysqli_query($con,$sql);
            while($row1=mysqli_fetch_object($result4))
            {
               $date         =   $row1->transaction_dateoftransaction;
                   $affAmnt      =   $row1->transaction_admin_amount;


                   # converting to user currency
                   if($currValue != $default_currency_caption){
                        $affAmnt     =   getCurrencyValue($date, $currValue, $affAmnt);

                   }
                $rejectedamnt=$affAmnt + $rejectedamnt;// total approved amnt
             }  //end while
			 
			//Calculate reversed commissions fro Recurring sales
			$sql_rev = "SELECT * FROM partners_transaction, partners_recur, partners_recurpayments WHERE ".
			" transaction_linkid='$linkid' AND recur_transactionid=transaction_id AND ".
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
					 if($currValue != $default_currency_caption){
							$affAmt 	 =   getCurrencyValue($date, $currValue, $affAmt);
					 }
					  
					$rejectedamnt = $affAmt + $rejectedamnt;
				}
			} 
			//End Reverse Calculation
			 

           $sql            ="SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_status='pending' and transaction_linkid='$linkid'";
           $result4        =mysqli_query($con,$sql);
           while($row1=mysqli_fetch_object($result4))
           {
               $date         =   $row1->transaction_dateoftransaction;
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
						   $affAmnt      =   $row1->transaction_amttobepaid;
					 }

                   # converting to user currency
                   if($currValue != $default_currency_caption){
                        $affAmnt     =   getCurrencyValue($date, $currValue, $affAmnt);
                        $adminAmnt   =   getCurrencyValue($date, $currValue, $adminAmnt);
                   }
               $pendingamnt=$affAmnt + $adminAmnt +$pendingamnt;// total approved amnt
           }  //end while


            $sql        = "SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_type='impression' and transaction_linkid='$linkid'";
            $result     = mysqli_query($con,$sql);


            while($row=mysqli_fetch_object($result))
            {
                 # get transaction details
                   $date         =   $row->transaction_dateoftransaction;
                   $affAmnt      =   $row->transaction_amttobepaid;
                   $adminAmnt    =   $row->transaction_admin_amount;
                   $trans_id     =   $row->transaction_id;  
                   #get the impressioncount(unit) from trans_rates table
              	   $sql_rate     = "SELECT trans_unit FROM partners_trans_rates WHERE trans_id ='$trans_id'";
	               $res_rate     = mysqli_query($con,$sql_rate);

	               if(mysqli_num_rows($res_rate) >0)
	               {
	                    while($row  = mysqli_fetch_object($res_rate))
	                    {
	                       $impression_counts  += $row->{trans_unit};
	                    }
	               }
                   # converting to user currency
                   if($currValue != $default_currency_caption){
                        $affAmnt     =   getCurrencyValue($date, $currValue, $affAmnt);
                        $adminAmnt   =   getCurrencyValue($date, $currValue, $adminAmnt);
                   }
                $impression    = $affAmnt + $adminAmnt + $impression; //total click amnt
            }


           $total          =$click."~".$nclick."~".$lead."~".$nlead."~".$sale."~".$nsale."~".$linkid."~".$approvedamnt."~".$pendingamnt."~".$paidamnt."~".$rejectedamnt."~".$impression_counts."~".$impression;
        //  echo "$total";
       return($total);

  }
  /****************************************************************************/
?>