<?php   ob_start();

    /***************************************************************************************************
     PROGRAM DESCRIPTION :  PROGRAM TO VIEW FORPERIOD REPORTS  PROCESS PAGE
      VARIABLES          :   click		=total click amnt
   			  				 lead		=total lead amnt
    						 sale		=total sale amnt
    						 nclick		=total no of clicks
   						     nlead      =total no of leads
   							 nsale      =total no of sales
                             AffiliAteID=AFFILAIE ID
                             from		=from date
    						 to			=to date
                             Cfrom		=from CONVERTED date
    						 Co			=to CONVERTED  date
                             msg	  	=errmsg
                             sub		=get submit button
  //*************************************************************************************************/

	include_once '../includes/constants.php';
	include_once '../includes/db-connect.php';
	include_once '../includes/functions.php';
	include_once '../includes/session.php';
	include_once '../includes/allstripslashes.php';
	include_once "paymentsforsel.php";
   
  
	$partners=new partners;
	$partners->connection($host,$user,$pass,$db); 
	include_once 'language_include.php';

   /*************************variables****************************************/
   $AFFILIATEID     = $_POST['AFFILIATEID'];         //affiliateid
   $cfrom           =trim($_POST['txtfrom']);          //from date
   $cto             =trim($_POST['txtto']);            //to date
   $sub             =trim($_POST['sub']);              //submit button
   
   $currCaption		= stripslashes(trim($_REQUEST['currCaption']));  
   /***************************************************************************/



   /********date validation***************************************************/
   if(!$partners->is_date($cfrom) || !$partners->is_date($cto) )
   {
    $Err=$lang_report_err;
    header("location:index.php?Act=forperiod&err=$Err");
    exit;
   }
   $From                     =$partners->date2mysql($cfrom);  //changing date format
   $To                       =$partners->date2mysql($cto);
   /**************************************************************************/


   //getting joinid for specified search condition
    echo $sql             ="SELECT * from partners_joinpgm j where  joinpgm_affiliateid='$AFFILIATEID'  ";

   $result1         =mysqli_query($con,$sql);
   $total           =GetPaymentDetails($sql,$To,$From,$currCaption);         //getting   from "/paymentsforsel.php";
                                                                // $total=$approvedamnt."~".$pendingamnt."~".$paidamnt."~".$rejectedamnt;

   # calculate impressions
     $impSql = " SELECT sum(imp_count) AS impr_count FROM partners_impression_daily WHERE imp_affiliateid='$AFFILIATEID' ";
     $impSql   .= " and imp_date between '$From' and '$To'";
     $impRet	= mysqli_query($con,$impSql);
	 $row_impr	=	mysqli_fetch_object($impRet);
	 $numRec 	= $row_impr->impr_count;
	 if($numRec == '') $numRec = 0;
	 
		include("../includes/function1.php");
		$imp_obj = new impression();
		
		$pending_sql  = $impSql." AND  impression_status='pending'";
	 

     $rawClick = GetRawTrans('click', 0, $AFFILIATEID, 0, 0,  $From,$To, 0)   ;
     $rawImp   = GetRawTrans('impression', 0, $AFFILIATEID, 0, 0,  $From,$To, 0)   ;

    //initiating
	$impression	   			  =0;								//total impression amnt
	$impression_count		  =0;								//total impression count
	
    $click          =0;                                         //total click amnt
    $lead           =0;                                         //total lead amnt
    $sale           =0;                                         //total sale amnt
    $nclick         =0;                                         //total click
    $nlead          =0;                                         //total lead
    $nsale          =0;                                         //total sale


    while($rows=mysqli_fetch_object($result1))
    {
       $joinid=$rows->joinpgm_id;

			//Added by SMA to find the impression comission amt on 17-JUNE-06
            $sql       ="SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_type='impression' and transaction_joinpgmid='$joinid'";
		 
            $result    =mysqli_query($con,$sql);
            while($row=mysqli_fetch_object($result))
            {
                //$impression =$row->transaction_amttobepaid + $impression; //total impression amnt
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
			//End add on 17-JUNE-06


            $sql       ="SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_type='click' and transaction_joinpgmid='$joinid'";
            $result    =mysqli_query($con,$sql);
            $nclick    =mysqli_num_rows($result)+$nclick;   //no of click
            while($row=mysqli_fetch_object($result))
			{
				$click_amt	= $row->transaction_amttobepaid;
               
			   $click = $click_amt + $click; //total click amnt
			}



            $sql      ="SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_type='lead' and transaction_joinpgmid='$joinid'";
            $result   =mysqli_query($con,$sql);
            $nlead    =mysqli_num_rows($result)+$nlead;  //no of lead
            while($row=mysqli_fetch_object($result))
			{
 				$date		 =   $row->transaction_dateoftransaction;
				$lead_amt	= $row->transaction_amttobepaid;

                $lead = $lead_amt + $lead;// total lead amnt
			}  //end while



           // $sql="SELECT sum( transaction_amttobepaid ) sale from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='sale' and transaction_joinpgmid=$joinid";
            $sql      ="SELECT *  from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_type='sale' and transaction_joinpgmid='$joinid'";
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
							
							$sale 	 =  $sale_amt + $sale; 
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


    }
	


   $sale           =$sale."~".$subsale."~".$nsubsale."~".$numRec."~".$rawClick."~".$rawImp; ;
   header("location:index.php?Act=forperiod&click=$click&nclick=$nclick&lead=$lead&nlead=$nlead&sale=$sale&nsale=$nsale&merchant=$Merchant&affiliate=$Affiliate&from=$cfrom&to=$cto&sub=$sub&total=$total&impression_amt=$impression_amt&impression=$impression&impression_count=$impression_count");

?>