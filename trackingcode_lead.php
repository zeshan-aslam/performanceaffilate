<?php

	include_once 'includes/db-connect.php';
    include_once 'includes/session.php';
    include_once 'includes/constants.php';
    include_once 'includes/functions.php';
    include_once 'testmail.php';

    $partners=new partners;
    $partners->connection($host,$user,$pass,$db);

#------------------------------------------------------------------------------
# getting variables
#------------------------------------------------------------------------------

# getting ip address
    $ipaddress		= $HTTP_SERVER_VARS['REMOTE_ADDR'];
	if(empty($ipaddress)) $ipaddress = $_SERVER['REMOTE_ADDR'];

# Merchantid
	$mid					=    intval(trim($_GET['mid']));

# random no
   $leadRand				= trim($_GET['sec_id']);

# tranactionid
   $orderId				    = $_GET['orderId'];

	$referer 				= 	getenv(HTTP_REFERER);

# sub id
	$subid					= $_GET['subid'];

# tid
	$GLOBALS["tid"]         = isset($_GET['tid']) && $_GET['tid'] != "" ? $_GET['tid'] : "";


#------------------------------------------------------------------------------
# checking whether its a geniune lead request
#------------------------------------------------------------------------------

 # chacking whether the sale request is the outcome of a rececnt click
 # withing 60sec
 # from the same ip as click



 $unSql = "SELECT transaction_orderid FROM  partners_transaction WHERE transaction_orderid = '".addslashes($orderId)."' AND transaction_referer='".addslashes($referer)."' AND transaction_type='lead'" ;
 $unRet = @mysqli_query($con,$unSql);

 if(@mysqli_num_rows($unRet)>0){
  # lead is by refresh


 }
 else{

 	//echo "1 <br/>";

   $sql = " SELECT * ,date_format(DATE_ADD( ipblocking_time, INTERVAL 60 MINUTE ),'%H/%i/%s/%d/%m/%y') as d ";
  $sql.= " FROM partners_ipblocking ";
  $sql.= " WHERE ipblocking_ipaddress = '".addslashes($ipaddress)."'";
  $sql.= " And ipblocking_randNo = '".addslashes($leadRand)."'  ";
  $sql.= " And ipblocking_merchantid= '$mid'  ORDER BY ipblocking_time DESC ";
  $ret = @mysqli_query($con,$sql);

  //echo $sql;

  //if there is entry in ip block table
  if(mysqli_num_rows($ret)>0)
  {
  	//echo "2 <br/>";
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

 # comparing last click and current click time
     	if(!CompareTime($ipblock)) {
			//if not within ip block period
			//echo "4 <br/>";
			# updating lead
			GetTransaction($mid,$pgmid,$joinid,$aid,$linkid,$leadrate,$statusid,$minimum_amount,$admin_leadrate,$orderId,$subid, $admin_leadrate_type) ;
	
			//update ip block table entry
			# updating last click time
			$sql  ="update partners_ipblocking set ipblocking_time=now(),ipblocking_randNo='".addslashes($leadRand)."'  where ipblocking_id='$ipid'";
			@mysqli_query($con,$sql);
     	}
	 	else  {
	 		//echo "5 <br/>";
			# Added By DPT on 01/July/05
			# If within Ip block period then also mark the lead but merchant doesn't have to pay for this
			AddLeadTransaction($mid,$pgmid,$joinid,$aid,$linkid,$leadrate,$statusid,$minimum_amount,$admin_leadrate,$orderId,$subid);
		}
  }
  else if(isset($GLOBALS["tid"]) && $GLOBALS["tid"] > 0)
  {
  	//echo "3 <br/>";
  		$tid = $GLOBALS["tid"];

  		  $sql = " SELECT * ,date_format(DATE_ADD( ipblocking_time, INTERVAL 60 MINUTE ),'%H/%i/%s/%d/%m/%y') as d ";
		  $sql.= " FROM partners_transaction t left join partners_ipblocking ipb on t.transaction_joinpgmid = ipb.ipblocking_joinpgmid  ";
		  $sql.= " WHERE t.transaction_id = '".$tid ."' ";
		  $sql.= " And ipb.ipblocking_randNo = '".addslashes($leadRand)."'  ";
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


		AddLeadTransactionByTid($mid,$pgmid,$joinid,$aid,$linkid,$leadrate,$statusid,$minimum_amount,$admin_leadrate,$orderId,$subid,$admin_leadrate_type);
			}
  }
 }
 
 
# ------------------------------------------------------------------------------
# Function records the transctions
# And updates all required tables
#-------------------------------------------------------------------------------

function GetTransaction($mid,$pgmid,$joinid,$aid,$linkid,$leadrate,$statusid,$minimum_amount,$admin_leadrate,$orderId,$subid,$admin_leadrate_type)
  {
  		//echo "6 <br/>";

  		$con = $GLOBALS["con"];

		# gets the http referer
		   $referer				= getenv(HTTP_REFERER);

		# GEts the Lead Commision for Programs
		$sql_lead = "SELECT * FROM partners_program WHERE program_id = '$pgmid' ";
		$res_lead = @mysqli_query($con,$sql_lead);
		if(@mysqli_num_rows($res_lead) > 0)
		{
			$row_lead = mysqli_fetch_object($res_lead);
	
			$pgm_admin_lead		= $row_lead->program_admin_lead;
			$pgm_admin_leadtype	= $row_lead->program_admin_leadtype;
			$admin_default		= $row_lead->program_admin_default;
			
			$mailmerchant 	=	$row_lead->program_mailmerchant;
			$mailaffiliate 	=	$row_lead->program_mailaffiliate;
			
			$program_countries = $row_lead->program_countries;
		}	




		if($admin_default)
		{
			if($admin_leadrate_type == "percentage") {
				$admin_lead_rate  = ($leadrate * $admin_leadrate)/100;
			}
			else {
			 	$admin_lead_rate  =  $admin_leadrate;  
			}
		}
		else  //If Admin has set Trans comm for the Program
		{
			if($pgm_admin_leadtype == "%") {
				$admin_lead_rate  = ($leadrate * $pgm_admin_lead)/100;
			}
			else {
				$admin_lead_rate  =  $pgm_admin_lead;
			}
		}		

	#GEst the Approval method for the cyurrent lead made by the affiliate
	#$approvalValue = GetLeadApproval($pgmid, $joinid);
	list($approval, $geoLead, $leadrate) = explode("~",GetLeadValues($pgmid, $joinid));


	$ip				= $HTTP_SERVER_VARS['REMOTE_ADDR'];   # getting ip address
	if(empty($ip)) 
		$ip 		= $_SERVER['REMOTE_ADDR'];

  #  automatic approval
  if($approval=="automatic") 
  {
  	//echo "7 <br/>";
  # set status to approved
     $approvalstatus = "approved";



  $today         = date("Y-m-d");
  //$admin_amount  = $admin_leadrate;
  $admin_amount  = $admin_lead_rate;


  //checking ip of user against offer available countries  jin on 6th Jul
  $user_ip = (ip2long($ip) < 0 ? -1 * ip2long($ip) : ip2long($ip));
  $temp_con = "OUT";

  $offer_in = explode(",",$program_countries);

  //if geo-targeting feature is enabled for click, then check whether the click is from allowed list of countries
  if($geoLead)
  {
	  for($cind=0;$cind<count($offer_in);$cind++){
	  $selq = "SELECT `ip_from`,`ip_to` FROM `partners_countryFlag` WHERE `country_name` = '".$offer_in[$cind]."'"
			  ." AND ip_from <=".$user_ip." AND `ip_to` >=".$user_ip."";
			if(mysqli_num_rows(mysqli_query($con,$selq))) $temp_con = "IN";
	  }
   }
   else $temp_con = "IN";


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


  // add transaction
  $validLead = 0;
  if($temp_con == "OUT")
  {
  	//echo "8 <br/>";
    $sql = "INSERT into partners_transaction(transaction_joinpgmid,transaction_type,transaction_status,transaction_dateoftransaction,transaction_amttobepaid,transaction_linkid,transaction_admin_amount,transaction_referer,transaction_ip,transaction_orderid,transaction_subid) values ('$joinid','lead','$approvalstatus','$today',0,'$linkid',0,'".addslashes($referer)."','".addslashes($ip)."','".addslashes($orderId)."','".addslashes($subid)."') ";
  }
  else
  {
  	//echo "9 <br/>";
  	$validLead = 1;
  	$sql="INSERT into partners_transaction(transaction_joinpgmid,transaction_type,transaction_status,transaction_dateoftransaction,transaction_amttobepaid,transaction_dateofpayment ,transaction_linkid,transaction_admin_amount,transaction_referer,transaction_orderid,transaction_ip,transaction_subid) values ('$joinid','lead','$approvalstatus','$today','$leadrate','$today','$linkid','$admin_amount','".addslashes($referer)."','".addslashes($orderId)."','".addslashes($ip)."','".addslashes($subid)."') ";

  	//echo $sql; 
  }
  mysqli_query($con,$sql);
  $newId = mysqli_insert_id($con);
  UpdateLeadsCount($joinid);
  InsertAiInfo($newId);

	//If transaction is successful then transfer of money between account
	if($validLead == 1)
	{
			  # get merchant account
			  $sql        =	"SELECT *  FROM `merchant_pay`  WHERE pay_merchantid='$mid' ";
			  $res        =	mysqli_query($con,$sql);
			  $num		  =	mysqli_num_rows($res);
			  $cut_off    = $minimum_amount;
			  if($num>0) 
			  {
				  $row1               =   mysqli_fetch_object($res);
				  $merchant_balance   = $row1->pay_amount;
				  //if(($merchant_balance-($leadrate+$admin_leadrate) )<=$cut_off)
				  if(($merchant_balance-($leadrate + $admin_lead_rate) )<=$cut_off)
				  {
				  }else
				  {
			
				#---------------------------------------------------------------------------
				# Update Account info of admin,affil,merchant
				#---------------------------------------------------------------------------
			
				# Adding money to affiliate account
					//$merchant_balance = $merchant_balance-($leadrate+$admin_leadrate);
					$merchant_balance = $merchant_balance-($leadrate + $admin_lead_rate);
					$sql1       ="SELECT *  FROM `affiliate_pay` where pay_affiliateid='$aid' ";
					$res1       =mysqli_query($con,$sql1);
					//echo @mysqli_error($con);
			
					$num = mysqli_num_rows($res1);
					if($num>0)
					{
					   $row1       =  mysqli_fetch_object($res1);
					   $curamount  = $row1->pay_amount;
					   $curamount  = $curamount+$leadrate;
			
					   $sql2 ="update affiliate_pay set pay_amount='$curamount' where pay_affiliateid='$aid'";
					   $ret2 =mysqli_query($con,$sql2);
					}
					else
					{
					   $sql2 ="INSERT INTO  affiliate_pay set pay_affiliateid='$aid' , pay_amount='$leadrate'";
					   $ret2 =mysqli_query($con,$sql2);
					}
			
				# affiliate account editing Ends here-
			
				# Subtract Money From Merchant Account
				   $sql        = "UPDATE  `merchant_pay` SET  pay_amount='$merchant_balance'  WHERE pay_merchantid='$mid' ";
				   $res        = mysqli_query($con,$sql);
				# END OF  Subtract Money From Merchant Account
			
				# Adding To Admins Account
			
				   $sql1      ="SELECT *  FROM `admin_pay`  ";
				   $res1      =mysqli_query($con,$sql1);
				   //echo mysqli_error($con);
				   $num=mysqli_num_rows($res1);
				   if($num>0)
				   {
					  $row1   =   mysqli_fetch_object($res1);
					  $admin_curamount    = $row1->pay_amount;
					  //$admin_curamount    = $admin_curamount + $admin_leadrate;
					  $admin_curamount    = $admin_curamount + $admin_lead_rate;
				   }
			
				  $sql        ="UPDATE `admin_pay` SET `pay_amount` = '$admin_curamount'";
				  $res        =mysqli_query($con,$sql);
			
				# END OF Adding to admin's account
			   }
			 }
	}   //  END Valid Lead
	
 }
 else
 {
  $approvalstatus = "pending";          //manuall approval
  $today          = date("Y-m-d");
  //$admin_amount   = $admin_leadrate;
  $admin_amount   = $admin_lead_rate;
 

  //checking ip of user against offer available countries  jin on 6th Jul
  $user_ip = (ip2long($ip) < 0 ? -1 * ip2long($ip) : ip2long($ip));
  $temp_con = "OUT";

  $offer_in = explode(",",$program_countries);

  //if geo-targeting feature is enabled for click, then check whether the click is from allowed list of countries
  if($geoLead)
  {
	  for($cind=0;$cind<count($offer_in);$cind++){
	  $selq = "SELECT `ip_from`,`ip_to` FROM `partners_countryFlag` WHERE `country_name` = '".$offer_in[$cind]."'"
			  ." AND ip_from <=".$user_ip." AND `ip_to` >=".$user_ip."";
			if(mysqli_num_rows(mysqli_query($con,$selq))) $temp_con = "IN";
	  }
   }
   else $temp_con = "IN";
   
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

  // add transaction
	if($temp_con == "OUT")
		$sql = "INSERT into partners_transaction(transaction_joinpgmid,transaction_type,transaction_status,transaction_dateoftransaction,transaction_amttobepaid,transaction_linkid,transaction_admin_amount,transaction_referer,transaction_ip,transaction_orderid,transaction_subid) values ('$joinid','lead','$approvalstatus','$today',0,'$linkid',0,'".addslashes($referer)."','".addslashes($ip)."','".addslashes($orderId)."','".addslashes($subid)."') ";
	else
		$sql = "INSERT into partners_transaction(transaction_joinpgmid,transaction_type,transaction_status,transaction_dateoftransaction,transaction_amttobepaid,transaction_linkid,transaction_admin_amount,transaction_referer,transaction_orderid,transaction_ip,transaction_subid) values ('$joinid','lead','$approvalstatus','$today','$leadrate','$linkid','$admin_amount','".addslashes($referer)."','".addslashes($orderId)."','".addslashes($ip)."','".addslashes($subid)."') ";
	
	mysqli_query($con,$sql);
	$newId = mysqli_insert_id($con);
	UpdateLeadsCount($joinid);
	InsertAiInfo($newId);


 }
  # maling
 if ($mailmerchant =="yes") {
        //MailMerchant($aid,$mid,$pgmid,$leadrate,$admin_leadrate,"lead");
 		MailMerchant($aid,$mid,$pgmid,$leadrate,$admin_lead_rate,"lead");
 }
 if($mailaffiliate =="yes"){
        MailAffilaite($aid,$mid,$pgmid,$leadrate,"lead");
 }

}


#---------------------------------------------------------------------------
 # Added By Ankit Kedia on 26th/March/2019
 # if click is within IP block period mark the lead as transaction
 #---------------------------------------------------------------------------
function AddLeadTransactionByTid($mid,$pgmid,$joinid,$aid,$linkid,$leadrate,$statusid,$minimum_amount,$admin_leadrate,$orderId,$subid, $admin_leadrate_type)
{
	$con = $GLOBALS["con"];
		# gets the http referer
	   	$referer				= getenv(HTTP_REFERER);
	  	# amount will be 0 in this case
	  	$admin_amount = 0;
		$today          = date("Y-m-d");
		
		$ip		= $HTTP_SERVER_VARS['REMOTE_ADDR'];
		if(empty($ip)) $ip = $_SERVER['REMOTE_ADDR'];


		# getting lead approval type
		#Gets the Approval method for the cyurrent lead made by the affiliate
		#$approval = GetLeadValues($pgmid, $joinid);
		list($approval, $geoLead, $leadrate) = explode("~",GetLeadValues($pgmid, $joinid));

		# GEts the Mail sending type for the Program
		$sql_lead = "SELECT * FROM partners_program WHERE program_id = '$pgmid' ";
		$res_lead = @mysqli_query($con,$sql_lead);
		if(@mysqli_num_rows($res_lead) > 0)
		{
			$row_lead = mysqli_fetch_object($res_lead);

			$pgm_admin_lead		= $row_lead->program_admin_lead;
			$pgm_admin_leadtype	= $row_lead->program_admin_leadtype;
			$admin_default		= $row_lead->program_admin_default;
			
			$mailmerchant 	=	$row_lead->program_mailmerchant;
			$mailaffiliate 	=	$row_lead->program_mailaffiliate;
			
			$program_countries = $row_lead->program_countries;
		}	


		//Ankit Code Area



		if($admin_default)
		{
			if($admin_leadrate_type == "percentage") {
				$admin_lead_rate  = ($leadrate * $admin_leadrate)/100;
			}
			else {
			 	$admin_lead_rate  =  $admin_leadrate;  
			}
		}
		else  //If Admin has set Trans comm for the Program
		{
			if($pgm_admin_leadtype == "%") {
				$admin_lead_rate  = ($leadrate * $pgm_admin_lead)/100;
			}
			else {
				$admin_lead_rate  =  $pgm_admin_lead;
			}
		}		

	 $admin_amount  = $admin_lead_rate;


		// Ankit Code Area




	  #  automatic approval
	  	if($approval=="automatic")
            $approvalstatus = "approved";        # set status to approved
	 	else
          	$approvalstatus = "pending";    //manuall approval
		      

		$sql = "INSERT into partners_transaction(transaction_joinpgmid,transaction_type,transaction_status,transaction_dateoftransaction,transaction_amttobepaid,transaction_linkid,transaction_admin_amount,transaction_referer,transaction_ip,transaction_orderid,transaction_subid) values ('$joinid','lead','$approvalstatus','$today',$leadrate,'$linkid',$admin_amount,'".addslashes($referer)."','".addslashes($ip)."','".addslashes($orderId)."','".addslashes($subid)."') ";

		//echo  $sql;

		mysqli_query($con,$sql);
	 	$newId = mysqli_insert_id($con);
		UpdateLeadsCount($joinid);
		InsertAiInfo($newId);

	 # maling
	 if ($mailmerchant =="yes") {
			MailMerchant($aid,$mid,$pgmid,0,0,"lead");
	 }
	 if($mailaffiliate =="yes"){
			MailAffilaite($aid,$mid,$pgmid,0,"lead");
	 }
}

 #---------------------------------------------------------------------------
 # Added By DPT on 01/July/05
 # if click is within IP block period mark the lead as transaction
 #---------------------------------------------------------------------------
function AddLeadTransaction($mid,$pgmid,$joinid,$aid,$linkid,$leadrate,$statusid,$minimum_amount,$admin_leadrate,$orderId,$subid)
{
	$con = $GLOBALS["con"];
		# gets the http referer
	   	$referer				= getenv(HTTP_REFERER);
	  	# amount will be 0 in this case
	  	$admin_amount = 0;
		$today          = date("Y-m-d");
		$ip 			= $GLOBALS['REMOTE_ADDR'];

		# getting lead approval type
		#Gets the Approval method for the cyurrent lead made by the affiliate
		#$approval = GetLeadValues($pgmid, $joinid);
		list($approval, $geoLead, $leadrate) = explode("~",GetLeadValues($pgmid, $joinid));

		# GEts the Mail sending type for the Program
		$sql_lead = "SELECT * FROM partners_program WHERE program_id = '$pgmid' ";
		$res_lead = @mysqli_query($con,$sql_lead);
		if(@mysqli_num_rows($res_lead) > 0)
		{
			$row_lead = mysqli_fetch_object($res_lead);

			$mailmerchant 	=	$row_lead->program_mailmerchant;
			$mailaffiliate 	=	$row_lead->program_mailaffiliate;
		}	


	  #  automatic approval
	  	if($approval=="automatic")
            $approvalstatus = "approved";        # set status to approved
	 	else
          	$approvalstatus = "pending";    //manuall approval
		      

		$sql = "INSERT into partners_transaction(transaction_joinpgmid,transaction_type,transaction_status,transaction_dateoftransaction,transaction_amttobepaid,transaction_linkid,transaction_admin_amount,transaction_referer,transaction_ip,transaction_orderid,transaction_subid) values ('$joinid','lead','$approvalstatus','$today',0,'$linkid',0,'".addslashes($referer)."','".addslashes($ip)."','".addslashes($orderId)."','".addslashes($subid)."') ";

		//echo  $sql;

		mysqli_query($con,$sql);
	 	$newId = mysqli_insert_id($con);
		UpdateLeadsCount($joinid);
		InsertAiInfo($newId);

	 # maling
	 if ($mailmerchant =="yes") {
			MailMerchant($aid,$mid,$pgmid,0,0,"lead");
	 }
	 if($mailaffiliate =="yes"){
			MailAffilaite($aid,$mid,$pgmid,0,"lead");
	 }
}


 #-----------------------------------------------------------------------------
 # comparing date
 #----------------------------------------------------------------------------
function CompareTime($ipblock) {

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

#-----------------------------------------------------------------------------
# Get the Approval type of the Lead for the affiliate
#----------------------------------------------------------------------------
	function GetLeadValues($pgmid, $joinid) 
	{
		$con = $GLOBALS["con"];

		# Gets the actual Lead  COmmissions value for the Affiliate
		# Checks if admin has assigned default commission structure for the affiliate
			$sql_def_comm = "SELECT * FROM partners_joinpgm, partners_pgm_commission 
				WHERE joinpgm_id='$joinid' AND joinpgm_commissionid != '0'
				AND joinpgm_commissionid = commission_id ";

				//echo $sql_def_comm;
			$res_def_comm = mysqli_query($con,$sql_def_comm);
			if(mysqli_num_rows($res_def_comm) > 0) {
				$row_def_comm = mysqli_fetch_object($res_def_comm);
				
				 $approval	=	$row_def_comm->commission_leadapproval;
				 $geoLead 	=	$row_def_comm->commission_geotargeting_lead; 
				 $leadRate	=	$row_def_comm->commission_leadrate;  
			} 
			else 
			{
				$sql_joinpgm = "SELECT * FROM partners_joinpgm WHERE joinpgm_id='$joinid' ";
				$res_joinpgm = mysqli_query($con,$sql_joinpgm);
				$row_joinpgm = mysqli_fetch_object($res_joinpgm);
				
				$leadsMade	= $row_joinpgm->joinpgm_lead_count;
				if(!$leadsMade) $leadsMade	= 1;
	
				$sql_lead_comm = "SELECT commission_leadapproval, commission_geotargeting_lead, commission_leadrate FROM partners_pgm_commission WHERE commission_programid='$pgmid' 
					AND commission_lead_from <= '$leadsMade' AND commission_lead_to >=  '$leadsMade' ";
				$res_lead_comm = mysqli_query($con,$sql_lead_comm);
				if(mysqli_num_rows($res_lead_comm) > 0) 
				{
					list($approval, $geoLead, $leadRate)	= mysqli_fetch_row($res_lead_comm);
				} 
				
				
				#checking whether any group exist for this program
					$sql	=	"select * from partners_group where  group_programid='$pgmid'";
					$ret	=	@mysqli_query($con,$sql);
			
					# group exists
					if(@mysqli_num_rows($ret)>0) {
					   $row				=	@mysqli_fetch_object($ret);
					   $group			=	$row->group_id;
					   $leadgroup		=	$row->group_leadrate;
			
					   # checking whether member of any group
					   $sql1	=	"select * from partners_joinpgm where  joinpgm_id='$joinid' and joinpgm_group='$group'";
					   $ret1	=	@mysqli_query($con,$sql1);
			
					   if(@mysqli_num_rows($ret1)>0) {
							 $leadRate	=	$leadgroup;
					   }
				   }
				#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
				
			}
		return $approval."~".$geoLead."~".$leadRate;
	}	


#-----------------------------------------------------------------------------
# Update number of  Leads for the affiliate
#----------------------------------------------------------------------------
	function UpdateLeadsCount($joinid)
	{
		$con = $GLOBALS["con"];
		
		$sql = "UPDATE partners_joinpgm SET joinpgm_lead_count=joinpgm_lead_count+1 WHERE joinpgm_id='$joinid' ";
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

		  	$sql = " select ai.id as aid, transactionid, transaction_joinpgmid, remoteaddr, serveraddr, cookie, language, useragent, aiapproved, ai.createdate, t.transaction_subid from  partners_aitrackinginfo ai ";
		  	$sql.= " left join partners_transaction t on ai.transactionid = t.transaction_id ";
		  	$sql.= " where ai.id = '".$aid."' and t.transaction_type = 'lead'  ";

		  	//echo $sql;

		  	$leadResultObj =   mysqli_query($con,$sql);
			
			$leadItem   =   mysqli_fetch_object($leadResultObj);
			//var_dump($leadItem);
			if($leadItem != null)
			{
				

				$aiapproved = 0;
				$aiscore = 0;

				$createdate = $leadItem->createdate;
				$datelimit = date('Y-m-d H:i:s', strtotime($createdate . ' -45 days'));
				$joinpgmid = $leadItem->transaction_joinpgmid;
				$remoteaddr = $leadItem->remoteaddr;
				$leadTransactionId =  $leadItem->transactionid;

				$sql = " select ai.id as aid, transactionid, transaction_joinpgmid, remoteaddr, serveraddr, cookie, language, useragent, aiapproved, ai.createdate, t.transaction_subid from  partners_aitrackinginfo ai ";
			  	$sql.= " left join partners_transaction t on ai.transactionid = t.transaction_id ";
			  	$sql.= " where t.aiapproved = 0 and  t.transaction_type = 'click' and t.transaction_joinpgmid = '".$joinpgmid."' and ai.remoteaddr = '".$remoteaddr."'  ";
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

					if($clickItem->serveraddr ==  $leadItem->serveraddr)
					{
						$aiscore++;
					}

					if($clickItem->useragent ==  $leadItem->useragent)
					{
						$aiscore++;
					}

					if($clickItem->language ==  $leadItem->language)
					{
						$aiscore++;
					}

					$sql = " update partners_transaction set aiapproved = '".$aiapproved."', aiscore = '".$aiscore."' where transaction_id = '".$clickTransactionId ."' ";
					//echo $sql;
					mysqli_query($con,$sql);

				}

				$sql = "update partners_transaction set transaction_subid='".$transaction_subid."', aiapproved = '".$aiapproved."', aiscore = '".$aiscore."' where transaction_id = '".$leadTransactionId."' ";

				//echo $sql;
				mysqli_query($con,$sql);
			}
		}

	  }
