<?php	ob_start();

   /***************************************************************************************************
     PROGRAM DESCRIPTION :  PROGRAM TO VIEW FORPERIOD REPORTS  PROCESS PAGE
      VARIABLES          :   click		=total click amnt
   			  				 lead		=total lead amnt
    						 sale		=total sale amnt
    						 nclick		=total no of clicks
   						     nlead      =total no of leads
   							 nsale      =total no of sales
                             Merchant   =MERCHANT ID
                             Affilaiete =AFFILAIE ID
                             from		=from date
    						 to			=to date
                             Cfrom		=from CONVERTED date
    						 Co			=to CONVERTED  date
                             msg	  	=errmsg
                             sub		=get submit button
  //*************************************************************************************************/

  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
  include_once '../includes/session.php';
  include_once "paymentsforsel.php";
  include_once '../includes/allstripslashes.php';

   $partners=new partners;
   $partners->connection($host,$user,$pass,$db);

   /*********************variables*********************************************/
   $Merchant		=trim($_POST['Mname']);     //merchantid
   $Affiliate		=trim($_POST['Aname']);     //affilaiteid
   $cfrom			=trim($_POST['txtfrom']);   //from date
   $cto				=trim($_POST['txtto']);     //to date
   $sub				=trim($_POST['sub']);       //submit button
   /****************************************************************************/


   /********************************date validation ***************************/
   if(!$partners->is_date($cfrom) || !$partners->is_date($cto) )
   {
    $Err="Please Enter Valid Date" ;
    header("location:index.php?Act=forperiod&err=$Err");
    exit;
   }

   $From	=$partners->date2mysql($cfrom);    //changimg date format
   $To		=$partners->date2mysql($cto);
   /****************************************************************************/



    /*searching*/
    switch($Merchant)
    {
      case 'All': //all merchant
            {
            switch ($Affiliate)
            {
               case 'All':  //all affiliate
                   {
                   $sql="SELECT * from partners_joinpgm ";


                    # calculate impressions
                   $impSql = " SELECT sum(imp_count) AS impr_count FROM partners_impression_daily WHERE 1 ";

                   $rawClick = GetRawTrans('click', 0, 0,0, 0, $From, $To, 0);
                   $rawImp   = GetRawTrans('impression',0, 0, 0,0,$From, $To, 0);

                   break;
                   }
                  default: //selected affiliate
                   {
                   $sql="SELECT * from partners_joinpgm where joinpgm_affiliateid=$Affiliate";;

                   # calculate impressions
                   $impSql = " SELECT sum(imp_count) AS impr_count FROM partners_impression_daily WHERE imp_affiliateid = '$Affiliate' ";

                   $rawClick = GetRawTrans('click', 0, $Affiliate,0, 0, $From, $To, 0);
                   $rawImp   = GetRawTrans('impression', 0, $Affiliate,0,0,$From, $To, 0);

                   break;
                   }
            }
            break;
            }

         default:   //selaected merchant
         {
           switch ($Affiliate)
            {
               case 'All': //all affiliate
                   {
                   $sql="SELECT * from partners_joinpgm j,partners_program p where program_merchantid='$Merchant' and  j.joinpgm_programid=p.program_id   ";

                   # calculate impressions
                   $impSql = " SELECT sum(imp_count) AS impr_count FROM partners_impression_daily WHERE imp_merchantid = '$Merchant' ";
                   $rawClick = GetRawTrans('click', $Merchant, 0,0, 0, $From, $To, 0);
                   $rawImp   = GetRawTrans('impression', $Merchant, 0,0,0,$From, $To, 0);

                   break;
                   }
                  default:  //selected affiliate
                   {
                    $sql="SELECT * from partners_joinpgm j,partners_program p where program_merchantid='$Merchant' and joinpgm_affiliateid='$Affiliate' and j.joinpgm_programid=p.program_id   ";

                    # calculate impressions
                   $impSql = " SELECT sum(imp_count) AS impr_count FROM partners_impression_daily WHERE imp_merchantid = '$Merchant' AND  imp_affiliateid = '$Affiliate'";

                   $rawClick = GetRawTrans('click', $Merchant, $Affiliate,0, 0, $From, $To, 0);
                   $rawImp   = GetRawTrans('impression', $Merchant, $Affiliate,0,0,$From, $To, 0);

                   break;
                   }
            }
         }
    }

    # impression count
    $impSql .= " And imp_date between '$From' AND '$To' ";

    $impRet	= mysql_query($impSql);
        $row_impr = mysql_fetch_object($impRet);
        $numRec = $row_impr->impr_count;
        if($numRec == '') $numRec = 0;


    $result1=mysql_query($sql);
    $total=GetPaymentDetails($sql,$To,$From);

    //initiating
    $click				=0;    //total click amount
    $lead				=0;    //total lead amount
    $sale				=0;    //total sale amount
    $nclick				=0;    //total click
    $nlead				=0;    //total lead
    $nsale				=0;    //total sale
	$impression         =0;    //total impression	


    while($rows=mysql_fetch_object($result1))
    {
			$joinid=$rows->joinpgm_id;
		
			$sql="SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_type='click' and transaction_joinpgmid='$joinid'";
			$result=mysql_query($sql);
			$nclick=mysql_num_rows($result)+$nclick;   //no of click
			while($row=mysql_fetch_object($result))
			{
				$click=$row->transaction_amttobepaid+$row->transaction_admin_amount+$click; //total click amnt
			}
	
	
			$sql="SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_type='lead' and transaction_joinpgmid='$joinid'";
			$result=mysql_query($sql);
			$nlead=mysql_num_rows($result)+$nlead;  //no of lead
	
			while($row=mysql_fetch_object($result))
			{
				 $lead=$row->transaction_amttobepaid+$row->transaction_admin_amount+$lead;// total lead amnt
			}  //end while
	
		
	
			$sql="SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_type='sale' and transaction_joinpgmid='$joinid'";
			$result=mysql_query($sql);
			$nsale=mysql_num_rows($result)+$nsale; //no of sale
			while($row=mysql_fetch_object($result))
			{
		//Modified on 23-JUNE-06 for Recurring Sale Commission by SMA
				 $transactionId	= $row->transaction_id;
				 $recur 	 = 	$row->transaction_recur;
		
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
							$sale 	 =  $row_recurpay->recurpayments_amount + $sale; 
						}
					}
				 }
				 else
				 {	 
		// END Modified on 23-JUNE-06
					$sale=$row->transaction_amttobepaid + $sale;//total sale amnt
				 }
				 $sale = $row->transaction_admin_amount + $sale;
			}  //end  while



			
			#Modified on 16-JUNE.06 to get impression amount from transaction table
			$sql="SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_type='impression' and transaction_joinpgmid='$joinid'";
			$result=mysql_query($sql);
			
			while($row=mysql_fetch_object($result))
			{
					#$impression=$row->transaction_amttobepaid+$row->transaction_admin_amount+$impression; //total  impression amnt
					$imp_amt = $row->transaction_amttobepaid+$row->transaction_admin_amount;
					$date                 =   $row->transaction_dateoftransaction;
					$impression = $imp_amt + $impression;
			
			}
			
    }
    // end while  1

   $sale=$sale."~".$subsale."~".$nsubsale."~".$numRec."~".$rawClick."~".$rawImp;
   header("location:index.php?Act=forperiod&click=$click&nclick=$nclick&lead=$lead&nlead=$nlead&sale=$sale&nsale=$nsale&merchant=$Merchant&affiliate=$Affiliate&from=$cfrom&to=$cto&sub=$sub&total=$total&impression=$impression");

?>