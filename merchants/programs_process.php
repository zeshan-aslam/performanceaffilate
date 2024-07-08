<?php		ob_start();
  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
  include_once '../includes/session.php';
  include_once 'transactions.php';

   $partners=new partners;
   $partners->connection($host,$user,$pass,$db);

   	include_once 'language_include.php';

   /*********************variables********************************************/
   $MERCHANTID                =$_SESSION['MERCHANTID'];     //merchant id
   $cfrom                     =trim($_POST['txtfrom']);     //from date
   $cto                       =trim($_POST['txtto']);       //to date
   $sub                       =trim($_POST['sub']);         //submit button
   $programs                  =trim($_POST['programs']);    //program id
   $currValue       = $_POST['currValue'];
   /*************************************************************************/

   /***********date validation************************************************/
   if(!$partners->is_date($cfrom) || !$partners->is_date($cto) )
   {
    $Err                        =$lang_report_err ;
    header("location:index.php?Act=ProgramReport&programs=$programs&err=$Err");
    exit;
   }

   $From                        =$partners->date2mysql($cfrom);
   $To                          =$partners->date2mysql($cto);
   /**************************************************************************/


   /**********************select programs*************************************/
   switch($programs)
   {
     case 'All':
        $sql                   ="SELECT * from partners_joinpgm j,partners_program p where program_merchantid='$MERCHANTID' and  j.joinpgm_programid=p.program_id   ";
         # calculate impressions
         $impSql = " SELECT sum(imp_count) AS impr_count FROM partners_impression_daily WHERE imp_merchantid = '$MERCHANTID'  ";

          $rawClick = GetRawTrans('click', $MERCHANTID, 0, 0, 0,  $From,$To, 0)   ;
          $rawImp   = GetRawTrans('impression', $MERCHANTID, 0, 0, 0,  $From,$To, 0)   ;

        break;
     default:
         $sql                  ="SELECT * from partners_joinpgm,partners_program where program_id='$programs' and  joinpgm_programid=program_id   ";

           # calculate impressions
         $impSql = " SELECT sum(imp_count) AS impr_count FROM partners_impression_daily WHERE imp_programid = '$programs'  ";

         $rawClick = GetRawTrans('click', 0, 0, $programs, 0,  $From,$To, 0)   ;
    	 $rawImp   = GetRawTrans('impression', 0, 0, $programs, 0,  $From,$To, 0)   ;

         break;
      }
    $result1                  =mysqli_query($con,$sql);
    /**************************************************************************/

    $impSql .=  " AND imp_date between '$From' AND '$To'";
    $impRet	= mysqli_query($con,$impSql);
	$row_impr	= mysqli_fetch_object($impRet);
	$numRec	= $row_impr->impr_count;
	if($numRec == '') $numRec = 0; 

    $total                    =GetPaymentDetails4($sql,$To,$From,$currValue,$default_currency_caption);
    $totalaff                 =GetTotalAffiliates($sql);
    //initiating
    $click                    =0;
    $lead                     =0;
    $sale                     =0;
    $nclick                   =0;
    $nlead                    =0;
    $nsale                    =0;
    $impression               =0;
    $impression_counts        =0;
	


    while($rows=mysqli_fetch_object($result1))
    {
            $joinid           =$rows->joinpgm_id;

            $sql       = "SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_type='click' and transaction_joinpgmid='$joinid'";
            $result    = @mysqli_query($con,$sql);
            $nclick    = @mysqli_num_rows($result)+$nclick;   //no of click
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
	            $click           = $affAmnt + $adminAmnt + $click;  //lead amnt
            }

            $sql      = "SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_type='lead' and transaction_joinpgmid='$joinid'";
            $result   = @mysqli_query($con,$sql);
            $nlead    = @mysqli_num_rows($result)+$nlead;  //no of lead
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
	            $lead            = $affAmnt + $adminAmnt + $lead;  //lead amnt
            }

            $sql      = "SELECT *  from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_type='sale' and transaction_joinpgmid='$joinid'";
            $result   = mysqli_query($con,$sql);
            $nsale    = mysqli_num_rows($result)+$nsale; //no of sale
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
	            $sale                =$affAmnt + $adminAmnt + $sale;  //lead amnt
            }  //end  while



	   
		   
   #modified on JUNE.17.06
            $sql       = "SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_type='impression' and transaction_joinpgmid='$joinid'";
            $result    = @mysqli_query($con,$sql);

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
	            $impression           = $affAmnt + $adminAmnt + $impression;  //lead amnt
            }
	#end of modification on JUNE.17.06
		   
    }
    // end while  1

   $sale =$sale."~".$subsale."~".$nsubsale."~".$totalaff."~".$numRec."~".$rawClick."~".$rawImp."~".$impression."~".$impression_counts;
   header("location:index.php?Act=ProgramReport&click=$click&nclick=$nclick&lead=$lead&nlead=$nlead&sale=$sale&nsale=$nsale&programs=$programs&from=$cfrom&to=$cto&sub=$sub&total=$total");

?>