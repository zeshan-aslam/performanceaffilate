<?php	

	include_once 'includes/db-connect.php';
	include_once 'includes/session.php';
    include_once 'includes/constants.php';
    include_once 'includes/functions.php';
    include_once 'testmail.php';

    $partners = new partners;
    $partners->connection($host,$user,$pass,$db);


#-------------------------------------------------------------------------------
# getting variabls
#-------------------------------------------------------------------------------

# url to where cntrols should go after executing this page
   // $url	  				=	trim($_GET['url']);

# getting ip address	
    $ipaddress			    = $HTTP_SERVER_VARS['REMOTE_ADDR'];
	if(empty($ipaddress)) $ipaddress = $_SERVER['REMOTE_ADDR'];

# sale amount
    $sale                   = trim($_GET['sale']);

# Merchantid
	$mid					= intval(trim($_GET['mid']));

# random no
   $saleRand				= trim($_GET['sec_id']);


# tranactionid
   $orderId				    = $_GET['orderId'];

   $referer 				= 	getenv(HTTP_REFERER);
# subid
	$subid					= $_GET['subid'];
	
# tid
	$GLOBALS["tid"]         = isset($_GET['tid']) && $_GET['tid'] != "" ? $_GET['tid'] : "";

	

	// Added by Ankit on 23rd June 2019
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$user_os        = getOS($user_agent);
	$user_browser   = getBrowser($user_agent);

	$productids = $_GET['products'];
	$postage = $_GET["postage"];
	$tax =  $_GET["tax"];
	$cartid = $_GET["cartid"];;
	$trafficsource = $_GET['trafficsource'];
	$auid = $_GET['auid'];
	$orderamount = $sale;
	$tid = $GLOBALS["tid"];


	$keyword = $_GET["keyword"];

	$checkCurrency = array("$"=>'USD', "AU$"=>'aus', "CA$"=>'cas', "£"=>'GBP', "€"=>'ee', "¥"=>'yy');
	$currencyReplaceValues = array("0","1","2","3","4","5","6","7","8","9","."," ");
	$symbol = str_replace($currencyReplaceValues,'',$sale);
	$currency = $checkCurrency[$symbol] ? $checkCurrency[$symbol] : 'N/A';

	$currentPageUrl = $_SERVER['REQUEST_URI'];

	$merchantCurrency = "";

	$currencyData = array();
	$sqlCurrency = " Select c.*, cr.relation_value from partners_currency c left join partners_currency_relation cr on c.currency_code = cr.relation_currency_code  " ;

	$currencyResultObj  = mysqli_query($con, $sqlCurrency);

	if(mysqli_num_rows($currencyResultObj) > 0)
	{
		while($currencyResult = mysqli_fetch_assoc($currencyResultObj))
		{
			$currencyData[] = $currencyResult;
		}
	}

	$poundCurrencyRelation = 0;
	$currencyRelation = 0;

	if($mid > 0)
	{
		$mSql = " Select * from partners_merchant where merchant_id = '$mid' ";
		$mResultObj  = mysqli_query($con, $mSql);

		if(mysqli_num_rows($mResultObj) > 0)
		{
			$mResult = mysqli_fetch_assoc($mResultObj) ;

			$merchantCurrency = $mResult["merchant_currency"];

			if(count($currencyData) > 0 && $merchantCurrency != "Pound")
			{
				foreach ($currencyData as $currencyItem) 
				{
					if($currencyItem["currency_caption"] == $merchantCurrency)
					{
						$currencyRelation = $currencyItem["relation_value"];						
					}

					if($currencyItem["currency_caption"] == "Pound")
					{
						$poundCurrencyRelation = $currencyItem["relation_value"];
					}

				}

				if($poundCurrencyRelation < $currencyRelation)
				{
					// $sale = $sale / $currencyRelation;
					$sale = $sale;
				}
				else
				{
					// $sale = $sale * $currencyRelation;
					$sale = $sale;
				}

			}
		}
	}


	$sql = " Insert into partners_aianalytics (ipaddress, browser, os, productids, postage, tax, cartid, trafficsource, auid, orderid, amount, tid, referer, keyword, currency, querystring ) ";
	$sql.= " values ('$ipaddress', '$user_browser', '$user_os', '$productids', '$postage', '$tax', '$cartid', '$trafficsource', '$auid', '$orderId', '$orderamount', '$tid', '$referer', '$keyword','$currency','$currentPageUrl'  ) ";

	//echo $sql; 

	 $ret = mysqli_query($con,$sql);


	   if($auid != "" && $mid > 0)
       {

       		$auidid = 0;
		    $ownerid = 0;

		      $sql = "select * from partners_auid where merchantid = '$mid' and auid = '$auid' ";
		      $result  = @mysqli_query($con,$sql);
		      
		      if(!(mysqli_num_rows($result) > 0))
		      {
		        $sql = " Insert into partners_auid (merchantid, auid) values ('$mid', '$auid') ";
		        @mysqli_query($con,$sql);

		        $auidid = mysqli_insert_id($con);
		      }
		      else
		      {

		        $row = @mysqli_fetch_assoc($result) ;
		        var_dump($row);
		        $auidid = $row["id"];

		        $sql = " Select * from partners_owner_auid where auidid = '$auidid' ";
		        $result  = @mysqli_query($con,$sql);

		        if(mysqli_num_rows($result) > 0)
		      	{
		        	$row = @mysqli_fetch_assoc($result) ;
		        	$ownerid = $row["ownerid"];
				}

		      }

		      $sql = " Select * from partners_ipstats where ipaddress = '$ipaddress' ";
		      $result  = @mysqli_query($con,$sql);
		      
		      if(!(mysqli_num_rows($result) > 0))
		      {
		      	if($ownerid == 0)
		      	{
			      	$sql = " Insert into partners_aiowner (count) values (0) ";
			        @mysqli_query($con,$sql);

			        $ownerid = mysqli_insert_id($con);
		    	}

		      	$sql = " Insert into partners_ipstats (ipaddress, ownerid) values ('$ipaddress', '$ownerid')";
		        @mysqli_query($con,$sql);
		      }

		      $sql = " select * from partners_owner_auid where ownerid = '$ownerid' and auidid = '$auidid' ";
	 	      $result  = @mysqli_query($con,$sql);

	      	  if(!(mysqli_num_rows($result) > 0))
	      	  {
			      $sql = " Insert into partners_owner_auid (ownerid,auidid) values ('$ownerid','$auidid') ";
			      @mysqli_query($con,$sql);
		      }


		      $sql = " Select * from partners_aiowner where id = '$ownerid' ";
     
		      $result  = @mysqli_query($con,$sql);
		    
		      if(mysqli_num_rows($result) > 0)
		      {
		        $aiowner = @mysqli_fetch_assoc($result) ;

		        $sql = " Select count(ipaddress) as totalips from partners_ipstats where ownerid = '$ownerid' ";

		        $result  = @mysqli_query($con,$sql);

		        $ipstatsCount = @mysqli_fetch_assoc($result) ;

		        $newcount =  $ipstatsCount["totalips"]  ;
		        $sql = " Update partners_aiowner set count = '$newcount' where id = '$ownerid' ";
		      
		        @mysqli_query($con,$sql);
		      }



		      /* Commented by Ankit - Below code works as per document 
		      $sql = " Select * from partners_ipstats where ipaddress = '$ipaddress' ";
		      $result  = @mysqli_query($con,$sql);

		      if(mysqli_num_rows($result) > 0)
		      {
		      	 if($auid != "")
		      	 {
		         	$sql = " SELECT affiliateid FROM `partners_auid` where auid = '".$auid."'  ";
		         	$affRes = mysqli_query($con,$sql);

		         	if(mysqli_num_rows($affRes) > 0)
		         	{
		         		$partnersAuid = mysqli_fetch_assoc($affRes);

		         		$partnersAffiliateId = $partnersAuid["affiliateid"];

		         	}

		         }
			     
		      	 $sql = " SELECT transaction_joinpgmid, transaction_linkid FROM `partners_transaction`  where transaction_ip = '".$ipaddress."' ; ";


		      }
		      */


   	   }


	  



	//echo "1<br/>";

	//Added BY SMA on 21-JUNE-2006 to check automatic decline of mutliple sale with same Orderid
	$recordSale = 0;
	
	if($fraudsettings_decline_recentsale == "0")  //if auto decline of same sale is not checked in Admin Options Fraud Settings
	{
		$recordSale = 1;   //proceed with sale tracking
	}
	else  //if auto decline of same sale is checked in Admin Options Fraud Settings
	{
		//  check  for sale by refresh
		 $sql_sameSale = "SELECT transaction_orderid FROM  partners_transaction WHERE transaction_orderid = '$orderId' AND transaction_referer='".addslashes($referer)."' AND transaction_type='sale'" ;
		 $res_sameSale = @mysqli_query($con,$sql_sameSale);

		 //echo $sql_sameSale."<br/>";
		
		 if(@mysqli_num_rows($res_sameSale)>0){
			  # sale is by refresh  do not proceed
			$recordSale = 0;
			//echo "2<br/>";
		 }
		 else {
		 	//echo "3<br/>";
			$recordSale = 1;
		}
	}
	//  End Added BY SMA on 21-JUNE-2006



	#------------------------------------------------------------------------------
	# checking whether its a geniune sale request
	#------------------------------------------------------------------------------
	
	 # chacking whether the sale request is the outcome of a rececnt click
	 # withing 60sec
	 # from the same ip as click
	

	 
	//Modified by SMA on 21-JUNE-2006 related to Automatic Decline of sale from Same OrderId in Fraud settings
 if($recordSale == 1)
 {
	 //echo "4<br/>";

	# Added on 20-JUNE-2006  for checking multiple repeating sale within sale seconds set in Admin Fraud Settings
	$presenttime  			=   date("Y-m-d  H:i:s");	
	$proceed			=  0;
	
	$sql = "SELECT * ,date_format(DATE_ADD(ipblocking_time, INTERVAL 60 MINUTE ),'%H/%i/%s/%d/%m/%y') as d ";
	$sql.= "FROM partners_ipblocking ";
	$sql.= "WHERE ipblocking_ipaddress = '".addslashes($ipaddress)."'";
	$sql.= " And ipblocking_randNo = '".addslashes($saleRand)."'  ";
	$sql.= " And ipblocking_merchantid= '$mid'   ORDER BY ipblocking_time DESC  ";
	
	//echo $sql;

	$ret = mysqli_query($con,$sql);
	
	
	

	//if there is entry in ip block table
	if(mysqli_num_rows($ret)>0)
	{
		$row                =        mysqli_fetch_object($ret);
		$linkid 			=		 $row->ipblocking_linkid;
		$joinid         	=        $row->ipblocking_joinpgmid;
		$today         		= date("Y-m-d");

		//echo "5<br/>";

		if(CheckMultipleRepeatingSales($joinid, $linkid, $today, $fraudsettings_saleseconds, $fraudsettings_recentsale, $fraudsettings_saleaction))
		{ 
			$proceed			=  1;
			//echo "6<br/>";
		} 
		else
		{
			echo $fraudsettings_saleaction."<br/>";
			if($fraudsettings_saleaction == "save") {
				$proceed			=  1;

				//echo "7<br/>";
			}
		}
 	}
 	 else if(isset($GLOBALS["tid"]) && $GLOBALS["tid"] > 0)
 	{
 		$tid = $GLOBALS["tid"];

 		  $sql = " SELECT *  FROM partners_transaction WHERE transaction_id = '".$tid ."' and transaction_type = 'click' and aiapproved = 0 ";
		  $ret = mysqli_query($con,$sql);
		
		  //if there is entry in ip block table
		  if(mysqli_num_rows($ret)>0) 
		  {
		  	$proceed =  1;
		  }
 	}
		

					
	if($proceed == 1)
	{
		//echo "8<br/>";
		
	//End Add on 20-June-2006
		 ///////////////////////////////////////////////////////////////////////////////
		 //////////// Getting all sale revenue - ( direct sale too) ////////////////////
		
		  # storing sale details
		  $saleDate	   = date("Y-m-d");
		
		  $saleQuery   = "INSERT INTO partners_track_revenue";
		  $saleQuery  .= "( revenue_trans_type, revenue_amount, revenue_date,revenue_merchantid)";
		  $saleQuery  .= " VALUES ";
		  $saleQuery  .= "('sale', '".addslashes($sale)."', '$saleDate', '$mid')";
		  $saleResult  = mysqli_query($con,$saleQuery);
		  $saleQueryId = mysqli_insert_id($con);
		
		 ///////////// Ends Here ///////////////////////////////////////////////////////
		 //////////////////////////////////////////////////////////////////////////////
		
		
		  $sql = "SELECT * ,date_format(DATE_ADD(ipblocking_time, INTERVAL 60 MINUTE ),'%H/%i/%s/%d/%m/%y') as d ";
		  $sql.= "FROM partners_ipblocking ";
		  $sql.= "WHERE ipblocking_ipaddress = '".addslashes($ipaddress)."'";
		  $sql.= " And ipblocking_randNo = '".addslashes($saleRand)."'  ";
		  $sql.= " And ipblocking_merchantid= '$mid'   ORDER BY ipblocking_time DESC  ";
		  

		  
		  $ret = mysqli_query($con,$sql);
		
		  //if there is entry in ip block table
		  if(mysqli_num_rows($ret)>0) 
		  {
		  	//echo "9<br/>";

			  $row		=	mysqli_fetch_object($ret);

			

			  $ipblock	=	$row->d;
			  $ipid		=	$row->ipblocking_id;
		
			 $mid 		=	$row->ipblocking_merchantid;
			 $aid 		=	$row->ipblocking_affiliateid;
			 $pgmid 	=	$row->ipblocking_programid;
			 $joinid 	=	$row->ipblocking_joinpgmid;
			 $linkid 	=	$row->ipblocking_linkid;
			 $salerate	=	$row->ipblocking_sale;
			 $saletype 	=	$row->ipblocking_saletype;
			 
	
			  # comparing last click and current click time
			  // in both the cases we need to record the transaction (As per client's suggestion)
			  if(!CompareTime($ipblock))  {

			  	//echo "10<br/>";
				 # recording sale
				 if($sale) GetTransaction($mid,$pgmid,$joinid,$aid,$linkid,$salerate,$saletype,$admin_salerate,$minimum_amount,$sale,$orderId, $saleQueryId,$subid, $admin_salerate_type) ;
		
				//update ip block table entry
				# updating last click time
				$sql  ="update partners_ipblocking set ipblocking_time=now(),ipblocking_randNo='".addslashes($saleRand)."'  where ipblocking_id='$ipid'";
				@mysqli_query($con,$sql);
			  }
			  else
			  {
			  		//echo "11<br/>";
				  //echo("BO ho");
				 //if within ip block period then need not update the ip block table
				 # recording sale
				 if($sale) GetTransaction($mid,$pgmid,$joinid,$aid,$linkid,$salerate,$saletype,$admin_salerate,$minimum_amount,$sale,$orderId, $saleQueryId,$subid, $admin_salerate_type) ;
			  }
		  }
		  else if(isset($GLOBALS["tid"]) && $GLOBALS["tid"] > 0)
		  {
		  		//echo "12 <br/>";
		  		$tid = $GLOBALS["tid"];


  		  $sql = " SELECT * ,date_format(DATE_ADD( ipblocking_time, INTERVAL 60 MINUTE ),'%H/%i/%s/%d/%m/%y') as d ";
		  $sql.= " FROM partners_transaction t left join partners_ipblocking ipb on t.transaction_joinpgmid = ipb.ipblocking_joinpgmid  ";
		  $sql.= " WHERE t.transaction_id = '".$tid ."' ";
		  $sql.= " And ipb.ipblocking_randNo = '".addslashes($saleRand)."'  ";
		  $sql.= " And ipb.ipblocking_merchantid= '$mid'  ORDER BY ipblocking_id DESC limit 1 ";

		  //echo($sql);
		  $ret = @mysqli_query($con,$sql);

		  $rowcount = mysqli_num_rows($ret);

			if($rowcount  > 0)
			 {
			  	//echo $rowcount ;
			     $row        = mysqli_fetch_object($ret);
			     $ipblock    = $row->d;
			     $ipid       = $row->ipblocking_id;

				$mid         = $row->ipblocking_merchantid;
				$aid         = $row->ipblocking_affiliateid;
				$pgmid       = $row->ipblocking_programid;
				$joinid      = $row->ipblocking_joinpgmid;
				$linkid      = $row->ipblocking_linkid;
				$leadrate    = $row->ipblocking_lead;
				$statusid    = $row->ipblocking_statusid;
				$salerate	=	$row->ipblocking_sale;
				$saletype 	=	$row->ipblocking_saletype;


				if($sale) 
				{
					GetTransaction($mid,$pgmid,$joinid,$aid,$linkid,$salerate,$saletype,$admin_salerate,$minimum_amount,$sale,$orderId, $saleQueryId,$subid, $admin_salerate_type) ;
				}
			}
		  }
	}
  
}


# ------------------------------------------------------------------------------
# Function records the transctions
# And updates all required tables
#-------------------------------------------------------------------------------

function   GetTransaction($mid,$pgmid,$joinid,$aid,$linkid,$salerate,$saletype,$admin_salerate,$minimum_amount,$sale,$orderId,$saleQueryId,$subid, $admin_salerate_type)
{ 



	$con = $GLOBALS["con"];

	$presenttime 	= date("Y-m-d  H:i:s");	
	$referer		= getenv(HTTP_REFERER);					# getiing http referer value
	$ip				= $HTTP_SERVER_VARS['REMOTE_ADDR'];   # getting ip address
	if(empty($ip)) 
		$ip 		= $_SERVER['REMOTE_ADDR'];

  #----------------------------------------------------------------------------
  # tracking subsale
  #----------------------------------------------------------------------------

  # intialising sub sale rates
    $subsalerate	=	0;
	$cur_subsalerate	= 0;

  #setting default parentid
    $parentid		=	0;
    $flag			=	0;

  # getting parentid
    $sql = "select * from partners_affiliate where affiliate_id='$aid'";
    $ret = mysqli_query($con,$sql);
	


  # if parentid exists updates parentid
    if(mysqli_num_rows($ret)>0){
			$row=mysqli_fetch_object($ret);
			$parentid=$row->affiliate_parentid;
			 
		# Added by SMA on 1st August 09 for Multi level Tier Commissions for Affiliates
			$tierGroupId 	= $row->affiliate_group;					
			if($tierGroupId > 0)
				$flag = 1;	# subsale found
		# END Multi level Tier Commissions for Affiliates			 
    }

		# GEts the Sale Commision for Programs
		$sql_sale = "SELECT * FROM partners_program WHERE program_id = '$pgmid' ";
		$res_sale = @mysqli_query($con,$sql_sale);
		if(@mysqli_num_rows($res_sale) > 0)
		{
			$row_sale = mysqli_fetch_object($res_sale);
	
			$pgm_admin_sale		= $row_sale->program_admin_sale;
			$pgm_admin_saletype	= $row_sale->program_admin_saletype;
			$admin_default		= $row_sale->program_admin_default;
			
			$mailmerchant 	=	$row_sale->program_mailmerchant;
			$mailaffiliate 	=	$row_sale->program_mailaffiliate;
		}	

		
		#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		# Gets the actual Sale  COmmissions value for the Affiliate
		# Checks if admin has assigned default commission structure for the affiliate
			$sql_def_comm = "SELECT * FROM partners_joinpgm, partners_pgm_commission 
				WHERE joinpgm_id='$joinid' AND joinpgm_commissionid != '0' ";
				//Commented by Ankit AND joinpgm_commissionid = commission_id ";
				
			
			$res_def_comm = mysqli_query($con,$sql_def_comm);
			if(mysqli_num_rows($res_def_comm) > 0) {

				$row_def_comm = mysqli_fetch_object($res_def_comm);
				
				 $approval	=	$row_def_comm->commission_saleapproval;
				 $salerate	=	$row_def_comm->commission_salerate; 
				 $saletype	=	$row_def_comm->commission_saletype; 
			} 
			else 
			{

				$sql_joinpgm = "SELECT * FROM partners_joinpgm WHERE joinpgm_id='$joinid' ";
				$res_joinpgm = mysqli_query($con,$sql_joinpgm);
				$row_joinpgm = mysqli_fetch_object($res_joinpgm);
				
				$salesMade	= $row_joinpgm->joinpgm_sale_count;
				if(!$salesMade)	$salesMade	= 1;
	
				

	
	
				$sql_sale_comm = "SELECT commission_saleapproval, commission_recur_sale, commission_recur_percentage, commission_recur_period, commission_salerate,  commission_saletype 
					FROM partners_pgm_commission WHERE commission_programid='$pgmid' 
					AND commission_sale_from <= '$salesMade' AND commission_sale_to >=  '$salesMade' ";
				

					
				$res_sale_comm = mysqli_query($con,$sql_sale_comm);
				if(mysqli_num_rows($res_sale_comm) > 0) 
				{
					$saleData = mysqli_fetch_row($res_sale_comm);
				
					list($approval, $sale_recur, $recur_percent, $recur_period, $salerate, $saletype)	= $saleData;
				} 
				
				
				#checking whether any group exist for this program
					$sql	=	"select * from partners_group where  group_programid='$pgmid'";
					$ret	=	@mysqli_query($con,$sql);
			
					# group exists
					if(@mysqli_num_rows($ret)>0) {
					   $row				=	@mysqli_fetch_object($ret);
					   $group			=	$row->group_id;
					   $salegroup		=	$row->group_salerate;
					   $saletypegroup	=	$row->group_saletype;
			
					   # checking whether member of any group
					   $sql1	=	"select * from partners_joinpgm where  joinpgm_id='$joinid' and joinpgm_group='$group'";
					   $ret1	=	@mysqli_query($con,$sql1);
			
					   if(@mysqli_num_rows($ret1)>0) {
							$salerate	=	$salegroup;
                         	$saletype	=	$saletypegroup;
					   }
				   }
				#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
				
			}
		#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

 
	  # if sale comm is in % finds the % to the sale amt
		 if($saletype=="%"){
			$salerate  = $sale*($salerate)/100;
		 }
		 

	# Checks the admin Sale commission Rate
		if($admin_default)
		{
			if($admin_salerate_type == "percentage") {
				$admin_sale_rate  = ($sale * $admin_salerate)/100;
			}
			else {
			 	$admin_sale_rate  =  $admin_salerate;  
			}
		}
		else  //If Admin has set Sale comm for the Program
		{
			if($pgm_admin_saletype == "%") {
				$admin_sale_rate  = ($sale * $pgm_admin_sale)/100;
			}
			else {
				$admin_sale_rate  =  $pgm_admin_sale;
			}
		}		

	
	$cur_salerate		= $salerate;
	#$cur_subsalerate	= $subsalerate;
	if($sale_recur == '1')
	{
		$cur_salerate 		= FindRecurringSaleCommission($salerate,$recur_percent);
		#$cur_subsalerate	= FindRecurringSaleCommission($subsalerate,$recur_percent);	
	}



  #----------------------------------------------------------------------------
  # checking approval type
  #----------------------------------------------------------------------------


    if($approval=="automatic")
    {
		

       # automatic approval

       $approvalstatus = "approved";
       $today          = date("Y-m-d");

       # gets admin commsion
	   $admin_amount = $admin_sale_rate;
	   
	   ///ANDY ADDED TRACKING COOKIE
	   $sql	=	"select * FROM partners_joinpgm WHERE joinpgm_id ='$joinid'";
	   $ret	=	@mysqli_query($con,$sql);
	   $row	=	@mysqli_fetch_object($ret);
	   # get transaction details
	   $joinpgm_programid 	=	$row->joinpgm_programid;
	   
	   $cookie_name = "AVAZ_USERCOOKIE_FOR_TRACKING_".$joinpgm_programid;
	   $Data_to_collect = $_COOKIE[$cookie_name];
	   // explode data
	   $pieces = explode(":", $Data_to_collect);
	   $subid = $pieces[0];
	   $check_program_link = $pieces[1];
	   

	   //Modified Query to insert trans time and recur sale value
          $sql = "INSERT INTO partners_transaction(transaction_joinpgmid,transaction_type,transaction_status,transaction_dateoftransaction,transaction_amttobepaid,transaction_linkid,transaction_subsale,transaction_parentid,transaction_flag,transaction_admin_amount,transaction_dateofpayment,transaction_referer,transaction_orderid,transaction_ip,transaction_subid,transaction_transactiontime, transaction_recur) values ('$joinid','sale','$approvalstatus','$today','$salerate','$linkid','$subsalerate','$parentid','$flag','$admin_amount','$today','".addslashes($referer)."','".addslashes($orderId)."','".addslashes($ip)."','".addslashes($subid)."','$presenttime', '$sale_recur') ";

       	  mysqli_query($con,$sql);	#die("sql  =  ".$sql);	
          $newId = mysqli_insert_id($con);
		  UpdateSalesCount($joinid);

		  InsertAiInfo($newId);

		# get merchant account
        $sql   = "SELECT *  FROM `merchant_pay`  WHERE pay_merchantid='$mid' ";
	    $res   = mysqli_query($con,$sql);

        # updating mercahnt balance
        $num	  =	mysqli_num_rows($res);
        $cut_off  =	$minimum_amount;
        if($num>0){
               $row1               =   mysqli_fetch_object($res);
               $merchant_balance   = $row1->pay_amount;

               #money emmpty status
			   if(($merchant_balance-($cur_salerate + $admin_sale_rate) )<=$cut_off)
			   {
			   		# Updates the status of transaction as not paid
					$sql_update = "UPDATE partners_transaction SET transaction_status='pending' WHERE transaction_id='$newId' ";
					$res_update = mysqli_query($con,$sql_update);
               }
               else
               {	# Update Account info of admin,affil,merchant
					
                   # getting affiliate balance
                     $sql1       ="SELECT *  FROM `affiliate_pay` where pay_affiliateid='$aid' ";
                     $res1       =mysqli_query($con,$sql1);

                   # updating affiliate balance
                     $num=mysqli_num_rows($res1);
                     if($num>0)
                     {
                        $row1   	=   mysqli_fetch_object($res1);
                        $curamount  = $row1->pay_amount;
						$curamount  = $curamount + $cur_salerate;

                        $sql2 ="update affiliate_pay set pay_amount='$curamount' where pay_affiliateid='$aid'";
                        $ret2 =mysqli_query($con,$sql2);
                     }
                     else
                     {
						$sql2 ="INSERT INTO  affiliate_pay set pay_affiliateid='$aid' , pay_amount='$cur_salerate'";
                        $ret2 =mysqli_query($con,$sql2);
                     }
    				# affiliate account editing Ends here--------------------------//



                    # Update mercahnt balance
					 	$merchant_balance = $merchant_balance-($cur_salerate + $admin_sale_rate);

    				# Subtract Money From Merchant Account ---------------------------//
                    $sql    = "UPDATE  `merchant_pay` SET  pay_amount='$merchant_balance'  WHERE pay_merchantid='$mid' ";
                    $res    = mysqli_query($con,$sql);

    				#END OF  Subtract Money From Merchant Account ---------------------------//


					#---------------------------------------------------------
					# subsale exists
					#---------------------------------------------------------

						if($flag==1) 
						{
							$adminTierCommission = 0;
							# Provide Tier commission to the x number of parents
							$baseAffiliateId	= $aid;
							
							# Gets the details of the commission to be provided to this level of parent
							$sql_get = "SELECT * FROM partners_affiliategroup_commission 
								WHERE commission_groupid='$tierGroupId' ORDER BY commission_level ";
							$res_get = mysqli_query($con,$sql_get);
							if(mysqli_num_rows($res_get) > 0)
							{
								while($row_get = mysqli_fetch_object($res_get))
								{
									$tierParentId 	= 0;
									$tierCommAmt	= $row_get->commission_amount;
									$tierCommType	= $row_get->commission_type;
									$tierLevel		= $row_get->commission_level;
									
									# Calculates the tier commission to be provided
									if($tierCommType == "%")
										$tierCommAmt = $sale*($tierCommAmt)/100;
									
									$sql_parent = "SELECT affiliate_parentid FROM partners_affiliate 
										WHERE affiliate_id='$baseAffiliateId'";
									$res_parent = mysqli_query($con,$sql_parent);
									list($tierParentId) = mysqli_fetch_row($res_parent);
										
									if($tierParentId > 0)	 
									{
										# Adds the commission details provided to table
										$sql_trans_subsale = "INSERT INTO partners_transaction_subsale SET 
											subsale_transactionid = '$newId', subsale_date='".date("Y-m-d")."', 
											subsale_affiliateid = '$tierParentId', subsale_childaffiliateid = '$baseAffiliateId', 
											subsale_level = '$tierLevel', subsale_amount = '$tierCommAmt' ";
										$res_trans_subsale = mysqli_query($con,$sql_trans_subsale);
										
										# Updates the account balance of the parent
										$sql_pay	= "SELECT *  FROM `affiliate_pay` where pay_affiliateid='$tierParentId' ";
										$res_pay 	= mysqli_query($con,$sql_pay);
										
										if(mysqli_num_rows($res_pay)) {
										   $row_pay    = mysqli_fetch_object($res_pay);
										   $curamount  = $row_pay->pay_amount;
										   $curamount  = $curamount + $tierCommAmt;
										   $sql_pay2 ="UPDATE affiliate_pay SET pay_amount='$curamount' 
										   		WHERE  pay_affiliateid='$tierParentId' ";
										   $res_pay2 =mysqli_query($con,$sql_pay2);
										}
										$adminTierCommission = $adminTierCommission + $tierCommAmt; 
										$baseAffiliateId	= $tierParentId;	
									}
									else {
										break;
									}
								}
							}

						}
						
					# END OF subsale exists
					#---------------------------------------------------------


    				# Adding To Admins Account

                     $sql1      = "SELECT *  FROM `admin_pay`  ";
                     $res1      = mysqli_query($con,$sql1);

                     $num	=	mysqli_num_rows($res1);
                     if($num>0){
                        $row1   			=  mysqli_fetch_object($res1);
                        $admin_curamount    = $row1->pay_amount;

						#$admin_curamount    = ($admin_curamount + $admin_sale_rate) - $cur_subsalerate;
						$admin_curamount    = ($admin_curamount + $admin_sale_rate) - $adminTierCommission;
                     }

                     # updating admin balance
                     $sql        = "UPDATE `admin_pay` SET `pay_amount` = '$admin_curamount'";
                     $res        = mysqli_query($con,$sql);
					# END OF Adding to admin's account
					
               }
         }
		 
		# Added BY SMA on 21-JUNE-2006 for Recur Commission
			InsertRecurringCommissionDetails($salerate,$cur_salerate,$newId,$recur_percent,$recur_period,$approvalstatus,$subsalerate,$cur_subsalerate);	
		# End Add on 21-JUNE-2006

		#Modified on 28-JUNE-06
			 $admin_pay_sql = "UPDATE partners_transaction SET ".
				" transaction_adminpaydate = '$today' WHERE transaction_id = '$newId' ";
			 $res_admin_pay = mysqli_query($con,$admin_pay_sql);
		
		# End Modify on 28-JUNE-06

          //////////////////////////////////////////////////////////////////////////
    	 /////////// setting transid//////////////////////////////////////////////

	     $saleQuery   = " UPDATE  partners_track_revenue ";
	     $saleQuery   .= " SET revenue_transaction_id = '$newId' ";
	     $saleQuery   .= " WHERE revenue_id = '$saleQueryId' ";
         mysqli_query($con,$saleQuery);
	     /////////////////// end /////////////////////////////////////////////////
	     /////////////////////////////////////////////////////////////////////////

    
	}
	else
	{

			# manuall approval
			$approvalstatus = "pending";
			$today          = date("Y-m-d");
			
			$admin_amount = $admin_sale_rate;
			
		   ///ANDY ADDED TRACKING COOKIE
		   $sql	=	"select * FROM partners_joinpgm WHERE joinpgm_id ='$joinid'";
		   $ret	=	@mysqli_query($con,$sql);
		   $row	=	@mysqli_fetch_object($ret);
		   # get transaction details
		   $joinpgm_programid 	=	$row->joinpgm_programid;
		   
		   $cookie_name = "AVAZ_USERCOOKIE_FOR_TRACKING_".$joinpgm_programid;
		   $Data_to_collect = $_COOKIE[$cookie_name];
		   // explode data
		   $pieces = explode(":", $Data_to_collect);
		   $subid = $pieces[0];
		   $check_program_link = $pieces[1];


	      $sql = "INSERT into partners_transaction(transaction_joinpgmid,transaction_type,transaction_status,transaction_dateoftransaction,transaction_amttobepaid,transaction_linkid,transaction_subsale,transaction_parentid,transaction_flag,transaction_admin_amount,transaction_dateofpayment,transaction_referer,transaction_orderid,transaction_ip,transaction_subid,transaction_transactiontime, transaction_recur) values ('$joinid','sale','$approvalstatus','$today','$salerate','$linkid','$subsalerate','$parentid','$flag','$admin_amount','$today','".addslashes($referer)."','".addslashes($orderId)."','".addslashes($ip)."','".addslashes($subid)."','$presenttime', '$sale_recur') ";
		  
		  //die($sql);
		 
	      mysqli_query($con,$sql);
	      $newId = mysqli_insert_id($con);
		  UpdateSalesCount($joinid);
		  InsertAiInfo($newId);

		# Added BY SMA on 21-JUNE-2006 for Recur Commission
			InsertRecurringCommissionDetails($salerate,$cur_salerate,$newId,$recur_percent,$recur_period,$approvalstatus,$subsalerate,$cur_subsalerate);	
		# End Add on 21-JUNE-2006

	     //////////////////////////////////////////////////////////////////////////
	     /////////// setting transid//////////////////////////////////////////////

	     $saleQuery    = " UPDATE  partners_track_revenue ";
	     $saleQuery   .= " SET revenue_transaction_id = '$newId' ";
	     $saleQuery   .= " WHERE revenue_id = '$saleQueryId' ";
		 
		
         mysqli_query($con,$saleQuery);
	     /////////////////// end /////////////////////////////////////////////////
	     /////////////////////////////////////////////////////////////////////////
      }



     # mailing
     if ($mailmerchant =="yes") {
		   MailMerchant($aid,$mid,$pgmid,$cur_salerate,$admin_sale_rate,"sale");
       }
     if($mailaffiliate =="yes") {
		   MailAffilaite($aid,$mid,$pgmid,$cur_salerate,"sale");
       }

 }

 #-----------------------------------------------------------------------------
 # comparing date
 #----------------------------------------------------------------------------
 function CompareTime($ipblock)
      {
      		$con = $GLOBALS["con"];

    # making ot mktime foamt
             $dtarray       =explode("/",$ipblock);
             $iphour        =$dtarray[0];
             $ipminute      =$dtarray[1];
             $ipsecond      =$dtarray[2];
             $ipdate        =$dtarray[3];
             $ipmonth       =$dtarray[4];
             $ipyear        =$dtarray[5];

     # current
             $d=date("d");
             $m=date("m");
             $y=date("Y");
             $h=date("H");
             $i=date("i");
             $s=date("s");
             $today=mktime($h,$i,$s,$m,$d,$y)."<br/>";
             $ipblock= mktime($iphour,$ipminute,$ipsecond,$ipmonth,$ipdate,$ipyear);

     #compare time
             if($ipblock<$today)
                return true;
             else
                return false;

      }



	//************************************************************************************	
	//  Created BY	: SMA
	//	Created On	: 20-JUNE-2006
	//  This function is used to check the fraud protection for recent sales within the specified sale seconds.
	//  The function directs to the action as specified by the admin in the fraud settings if the sale is within the time specified.
	//************************************************************************************
	function CheckMultipleRepeatingSales($joinid, $linkid, $today, $saleseconds, $recentsale, $saleaction)
	{
		$con = $GLOBALS["con"];

		if($recentsale == 1)
		{
			$ipaddress				=   $HTTP_SERVER_VARS['REMOTE_ADDR'];     //getting ip address
			if(empty($ipaddress)) $ipaddress = $_SERVER['REMOTE_ADDR'];
		
			$sql_sale = "SELECT *,date_format(transaction_transactiontime,'%H/%i/%s/%d/%m/%y') as transtime FROM partners_transaction WHERE ".
			" transaction_joinpgmid = '$joinid' AND ".
			" transaction_type = 'sale' AND ".
			" transaction_linkid = '".addslashes($linkid)."' AND ".
			" transaction_ip = '$ipaddress' ORDER BY transaction_id DESC";
			
			
			$res_sale = mysqli_query($con,$sql_sale);
			if(mysqli_num_rows($res_sale) > 0)
			{
				$row_sale = mysqli_fetch_object($res_sale);
				$lasttime = $row_sale->transaction_transactiontime;
					
				# adding currenttime + clickseconds time
				$sql_delay      =   "select date_format(DATE_ADD('$lasttime',INTERVAL $saleseconds SECOND),'%H/%i/%s/%d/%m/%y') d " ;
				$ret_delay      =   @mysqli_query($con,$sql_delay);
				# getting  currenttime + clickseconds
				$row_delay     =   @mysqli_fetch_object($ret_delay);
				$nextsaletime =   $row_delay->d;
	
				if(CompareTime($nextsaletime))
				{ 
					return true;
				} 
				else
				{
					 return false;
				}
			}
			else
				return true;
		}
		else
			return true;
	}


################### Start Function ###########################
	function FindRecurringSaleCommission($totalCommission,$recur_percent)
	{
			$currentCommission = ($totalCommission * $recur_percent) / 100;
			if($currentCommission > $totalCommission)
				$currentCommission = $totalCommission;
				
			return $currentCommission ;
	}
################### End Function ##############################


	function InsertRecurringCommissionDetails($salerate,$cur_salerate,$newId,$recur_percent,$recur_period,$approvalstatus,$subsalerate,$cur_subsalerate)
	{
		$con = $GLOBALS["con"];

			$balance_recuramt  	= $salerate - $cur_salerate;
			$balancesubsale		= $subsalerate - $cur_subsalerate;
			
			$today = date('Y-m-d');
			$sql_recur = "INSERT INTO partners_recur SET ".
			" recur_transactionid = '$newId' ,  ".
			" recur_totalcommission = '$salerate' , ".
			" recur_percentage = '$recur_percent' , ".
			" recur_period = '$recur_period' , ".
			" recur_balanceamt = '$balance_recuramt' , ".
			" recur_lastpaid = '$today' , ".
			" recur_status = 'Active' , ".
			" recur_total_subsalecommission = '$subsalerate' , ".
			" recur_balance_subsaleamt = '$balancesubsale' ";
			$res_recur 	= @mysqli_query($con,$sql_recur);
			$recurId 	= mysqli_insert_id($con);
			
			$sql_recur_paid	= "INSERT INTO partners_recurpayments SET ".
			" recurpayments_recurid = '$recurId' , ".
			" recurpayments_date = '$today' , ".
			" recurpayments_amount = '$cur_salerate' , ".
			" recurpayments_status = '$approvalstatus', ".
			" recurpayments_subsaleamount = '$cur_subsalerate'  ";
			$res_recur_paid = @mysqli_query($con,$sql_recur_paid);
	
			if($balance_recuramt == 0 && $approvalstatus == 'approved')
			{
				$sql_trans_approve = "UPDATE partners_transaction SET transaction_status='approved' WHERE transaction_id='$newId' ";
				$res_trans_approve = mysqli_query($con,$sql_trans_approve);
			}

	}
	


#-----------------------------------------------------------------------------
# Update number of Sales for the affiliate
#----------------------------------------------------------------------------
	function UpdateSalesCount($joinid)
	{
		$con = $GLOBALS["con"];
		$sql = "UPDATE partners_joinpgm SET joinpgm_sale_count=joinpgm_sale_count+1 WHERE joinpgm_id='$joinid' ";
		$res = mysqli_query($con,$sql);
	}

	function InsertAiInfo($transactionId)
	  {
	    $con = $GLOBALS["con"];

	    $querystring = mysqli_real_escape_string($con,$_SERVER["QUERY_STRING"]);
	    $remoteaddr = mysqli_real_escape_string($con,$_SERVER["REMOTE_ADDR"]);
	    $serveraddr = mysqli_real_escape_string($con,$_SERVER["SERVER_ADDR"]);
	    $cookie = mysqli_real_escape_string($con,$_SERVER["HTTP_COOKIE"]);
	    $language = mysqli_real_escape_string($con,$_SERVER["HTTP_ACCEPT_LANGUAGE"]);
	    $referrer = mysqli_real_escape_string($con,$_SERVER["HTTP_REFERER"]);
	    $useragent = mysqli_real_escape_string($con,$_SERVER["HTTP_USER_AGENT"]);


	    $sql = " Insert into partners_aitrackinginfo (transactionid, querystring, remoteaddr, serveraddr, cookie, language, referrer, useragent) ";
	    $sql.= " values ($transactionId, '$querystring', '$remoteaddr', '$serveraddr', '$cookie', '$language', '$referrer', '$useragent' ) "; 

	    mysqli_query($con,$sql) ;

	    $aid = mysqli_insert_id($con);

	    CalculateAIScore($aid, $transactionId);

	  }

	  function CalculateAIScore($aid, $transactionId)
	  {
 		$tid = $GLOBALS["tid"];
	  	 $con = $GLOBALS["con"];

	  	  $processAI = true;

	  	 if($tid != "")
	  	 {
	  	 	$sql = " Select * from partners_transaction where transaction_id = '".$tid."' and transaction_type = 'click' and aiapproved = 0  ";
	  	 	$clickResultObj =   mysqli_query($con,$sql);

	  	 	if(mysqli_num_rows($clickResultObj) > 0)
	  	 	{
	  	 	  $clickResultItem = mysqli_fetch_object($clickResultObj);
	  	 	  $sql = " update partners_transaction set transaction_subid = '".$clickResultItem->transaction_subid."'  where transaction_id = ".$transactionId;
			  mysqli_query($con,$sql);

	  	 	  $sql = " update partners_transaction set aiapproved = 1, aiscore = 2 where transaction_id in (".$tid.",".$transactionId.") ";
			  mysqli_query($con,$sql);

			  $processAI = false;
	  	 	}

	  	 }


	  	 if($processAI)
	  	 {
	  	 	$transaction_subid = "";


		  	$sql = " select ai.id as aid, transactionid, transaction_joinpgmid, remoteaddr, serveraddr, cookie, language, useragent, aiapproved, ai.createdate from  partners_aitrackinginfo ai ";
		  	$sql.= " left join partners_transaction t on ai.transactionid = t.transaction_id ";
		  	$sql.= " where ai.id = '".$aid."' and t.transaction_type = 'sale'  ";


		  	$saleResultObj =   mysqli_query($con,$sql);
			
			$saleItem   =   mysqli_fetch_object($saleResultObj);

			if($saleItem != null)
			{
				$aiapproved = 0;
				$aiscore = 0;

				$createdate = $saleItem->createdate;
				$datelimit = date('Y-m-d H:i:s', strtotime($createdate . ' -45 days'));
				$joinpgmid = $saleItem->transaction_joinpgmid;
				$remoteaddr = $saleItem->remoteaddr;
				$saleTransactionId =  $saleItem->transactionid;

				$sql = " select ai.id as aid, transactionid, transaction_joinpgmid, remoteaddr, serveraddr, cookie, language, useragent, aiapproved, ai.createdate, t.transaction_subid from  partners_aitrackinginfo ai ";
			  	$sql.= " left join partners_transaction t on ai.transactionid = t.transaction_id ";
			  	$sql.= " where t.aiapproved = 0 and   t.transaction_type = 'click' and t.transaction_joinpgmid = '".$joinpgmid."' and ai.remoteaddr = '".$remoteaddr."'  ";
			  	$sql.= " and ai.createdate between '".$datelimit."' and '".$createdate."' order by ai.id desc limit 1  ";

			  	//echo "<br/>".$sql."<br/>";

			  	$clickResultObj =   mysqli_query($con,$sql);
				$clickItem   =   mysqli_fetch_object($clickResultObj);

				if($clickItem != null)
				{
					$transaction_subid = $clickItem->transaction_subid;
					$clickTransactionId =  $clickItem->transactionid;
					$aiapproved = 1;
					$aiscore = 2;

					if($clickItem->serveraddr ==  $saleItem->serveraddr)
					{
						$aiscore++;
					}

					if($clickItem->useragent ==  $saleItem->useragent)
					{
						$aiscore++;
					}

					if($clickItem->language ==  $saleItem->language)
					{
						$aiscore++;
					}

					$sql = " update partners_transaction set aiapproved = ".$aiapproved.", aiscore = '".$aiscore."' where transaction_id = '".$clickTransactionId ."' ";
					//echo $sql;
					mysqli_query($con,$sql);

				}

				$sql = " update partners_transaction set transaction_subid='".$transaction_subid."', aiapproved = ".$aiapproved.", aiscore = '".$aiscore."' where transaction_id = '".$saleTransactionId."' ";
				//echo $sql;
				mysqli_query($con,$sql);
			}
		}

	  }


	  function getOS($user_agent) { 

    $os_platform  = "Unknown OS Platform";

    $os_array     = array(
                          '/windows nt 10/i'      =>  'Windows 10',
                          '/windows nt 6.3/i'     =>  'Windows 8.1',
                          '/windows nt 6.2/i'     =>  'Windows 8',
                          '/windows nt 6.1/i'     =>  'Windows 7',
                          '/windows nt 6.0/i'     =>  'Windows Vista',
                          '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                          '/windows nt 5.1/i'     =>  'Windows XP',
                          '/windows xp/i'         =>  'Windows XP',
                          '/windows nt 5.0/i'     =>  'Windows 2000',
                          '/windows me/i'         =>  'Windows ME',
                          '/win98/i'              =>  'Windows 98',
                          '/win95/i'              =>  'Windows 95',
                          '/win16/i'              =>  'Windows 3.11',
                          '/macintosh|mac os x/i' =>  'Mac OS X',
                          '/mac_powerpc/i'        =>  'Mac OS 9',
                          '/linux/i'              =>  'Linux',
                          '/ubuntu/i'             =>  'Ubuntu',
                          '/iphone/i'             =>  'iPhone',
                          '/ipod/i'               =>  'iPod',
                          '/ipad/i'               =>  'iPad',
                          '/android/i'            =>  'Android',
                          '/blackberry/i'         =>  'BlackBerry',
                          '/webos/i'              =>  'Mobile'
                    );

    foreach ($os_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $os_platform = $value;

    return $os_platform;
}

function getBrowser($user_agent) {

    $browser        = "Unknown Browser";

    $browser_array = array(
                            '/msie/i'      => 'Internet Explorer',
                            '/firefox/i'   => 'Firefox',
                            '/safari/i'    => 'Safari',
                            '/chrome/i'    => 'Chrome',
                            '/edge/i'      => 'Edge',
                            '/opera/i'     => 'Opera',
                            '/netscape/i'  => 'Netscape',
                            '/maxthon/i'   => 'Maxthon',
                            '/konqueror/i' => 'Konqueror',
                            '/mobile/i'    => 'Handheld Browser'
                     );

    foreach ($browser_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $browser = $value;

    return $browser;
}


	
	
?>