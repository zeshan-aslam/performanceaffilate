<?php

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
    $sale                   = 220; //trim($_GET['sale']);

# Merchantid
	$mid					= 9; //trim($_GET['mid']);

# random no
   $saleRand				= "M_93bO8iT5kN6yV"; //trim($_GET['sec_id']);


# tranactionid
   $orderId				    = "112233"; // $_GET['orderId'];

   $referer 				= 	getenv(HTTP_REFERER);
# subid
	$subid					= $_GET['subid'];
	




#------------------------------------------------------------------------------
# checking whether its a geniune sale request
#------------------------------------------------------------------------------

 # chacking whether the sale request is the outcome of a rececnt click
 # withing 60sec
 # from the same ip as click

 $unSql = "SELECT transaction_orderid FROM  partners_transaction WHERE transaction_orderid = '".addslashes($orderId)."' AND transaction_referer='".addslashes($referer)."' AND transaction_type='sale'" ;
 $unRet = @mysql_query($unSql);

 if(@mysql_num_rows($unRet)>0){ echo  "sale by refresh";
  # sale is by refresh
 }
 else
 {  echo "valid sale";
	# Added on 20-JUNE-2006  for checking multiple repeating sale within sale seconds set in Admin Fraud Settings
	$presenttime  			=   date("Y-m-d  H:i:s");	
	$proceed			=  0;
	
	$sql = "SELECT * ,date_format(DATE_ADD(ipblocking_time, INTERVAL 60 MINUTE ),'%H/%i/%s/%d/%m/%y') as d ";
	$sql.= "FROM partners_ipblocking ";
	$sql.= "WHERE ipblocking_ipaddress = '".addslashes($ipaddress)."'";
	$sql.= " And ipblocking_randNo = '$saleRand'  ";
	$sql.= " And ipblocking_merchantid= '$mid'  ";
	$ret = mysql_query($sql); echo '<br>qry='.$sql."<br>" ;
	
	//if there is entry in ip block table
	if(mysql_num_rows($ret)>0)
	{
		$row                =        mysql_fetch_object($ret);
		$linkid 			=		 $row->ipblocking_linkid;
		$joinid         	=        $row->ipblocking_joinpgmid;
		$today         		= date("Y-m-d");

		if(CheckMultipleRepeatingSales($joinid, $linkid, $today, $fraudsettings_saleseconds, $fraudsettings_recentsale, $fraudsettings_saleaction))
		{ 
			$proceed			=  1;
		} 
		else
		{ echo "inside time";
			if($fraudsettings_saleaction == "save") {
				$proceed			=  1;
			}
		}
 	}
		die("proced  = " .$proceed);		
	if($proceed == 1)
	{
		 ///////////////////////////////////////////////////////////////////////////////
		 //////////// Getting all sale revenue - ( direct sale too) ////////////////////
		
		  # storing sale details
		  $saleDate	   = date("Y-m-d");
		
		  $saleQuery   = "INSERT INTO partners_track_revenue";
		  $saleQuery  .= "( revenue_trans_type, revenue_amount, revenue_date,revenue_merchantid)";
		  $saleQuery  .= " VALUES ";
		  $saleQuery  .= "('sale', $sale, '$saleDate', $mid)";
		  $saleResult  = mysql_query($saleQuery);
		  $saleQueryId = mysql_insert_id();
		
		 ///////////// Ends Here ///////////////////////////////////////////////////////
		 //////////////////////////////////////////////////////////////////////////////
		
		
		  $sql = "SELECT * ,date_format(DATE_ADD(ipblocking_time, INTERVAL 60 MINUTE ),'%H/%i/%s/%d/%m/%y') as d ";
		  $sql.= "FROM partners_ipblocking ";
		  $sql.= "WHERE ipblocking_ipaddress = '".addslashes($ipaddress)."'";
		  $sql.= " And ipblocking_randNo = '$saleRand'  ";
		  $sql.= " And ipblocking_merchantid= '$mid'  ";
		  $ret = mysql_query($sql);
		
		  //if there is entry in ip block table
		  if(mysql_num_rows($ret)>0) 
		  {
			  $row		=	mysql_fetch_object($ret);
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
				 # recording sale
				 if($sale) GetTransaction($mid,$pgmid,$joinid,$aid,$linkid,$salerate,$saletype,$admin_salerate,$minimum_amount,$sale,$orderId, $saleQueryId,$subid) ;
		
				//update ip block table entry
				# updating last click time
				$sql  ="update partners_ipblocking set ipblocking_time=now(),ipblocking_randNo='$saleRand'  where ipblocking_id='$ipid'";
				@mysql_query($sql);
			  }
			  else
			  {
				 //if within ip block period then need not update the ip block table
				 # recording sale
				 if($sale) GetTransaction($mid,$pgmid,$joinid,$aid,$linkid,$salerate,$saletype,$admin_salerate,$minimum_amount,$sale,$orderId, $saleQueryId,$subid) ;
			  }
		  }
	}
  
}
#-------------------------------------------------------------------------------
# After recording the transaction the control is redirecting
# to the specified url
# with all post valus
#------------------------------------------------------------------------------
	 /*$ch = curl_init($url);
	 curl_setopt($ch, CURLOPT_SSLVERSION, 3);
	 curl_setopt($ch, CURLOPT_POST, 1);
	 curl_setopt($ch, CURLOPT_POSTFIELDS,$_POST);
	 $result=curl_exec ($ch);
	 curl_errno($ch);
	 curl_close ($ch);  */


# ------------------------------------------------------------------------------
# Function records the transctions
# And updates all required tables
#-------------------------------------------------------------------------------

 function   GetTransaction($mid,$pgmid,$joinid,$aid,$linkid,$salerate,$saletype,$admin_salerate,$minimum_amount,$sale,$orderId,$saleQueryId,$subid)
 {
	# Added on 20-JUNE-2006
	$presenttime  			=   date("Y-m-d  H:i:s");	
	$ip				=   $HTTP_SERVER_VARS['REMOTE_ADDR'];     //getting ip address
	if(empty($ip)) $ip = $_SERVER['REMOTE_ADDR'];
 
  # getiing http referer value
     $referer				= getenv(HTTP_REFERER);

  # if sale comm is in %
  # finds the % to the sale amt
     if($saletype=="%"){
        $salerate  = $sale*($salerate)/100;;
     }

  #----------------------------------------------------------------------------
  # tracking subsale
  #----------------------------------------------------------------------------

  # intialising sub sale rates
    $subsalerate	=	0;

  #setting default parentid
    $parentid		=	0;
    $flag			=	0;

  # getting parentid
    $sql = "select * from partners_affiliate where affiliate_id='$aid'";
    $ret = mysql_query($sql);

  # if parentid exists updates parentid
    if(mysql_num_rows($ret)>0){
             $row=mysql_fetch_object($ret);
             $parentid=$row->affiliate_parentid;
    }

  # chckinhg whether subsale is set for specified pgm
    $sql1 = "select * from partners_secondlevel where  secondlevel_programid='$pgmid'";
    $ret1 = mysql_query($sql1) or die($sql1."<br/>".mysql_error());

  # if subsale is offerd and a perentid exists
  # finds the subsale amount
    if((mysql_num_rows($ret1)>0) and ($parentid<>0)) {
        $rows			=	mysql_fetch_object($ret1);

      # finds the subsale amount
	    $subsalerate	= $rows->secondlevel_salerate;
	    $subsaletype	= $rows->secondlevel_saletype;

      # finds the subsale amount if comm is in %
        if($subsaletype=="%") {
               $subsalerate=$sale*($subsalerate)/100;;
        }

        # subsale found
        $flag = 1;
    }


  #----------------------------------------------------------------------------
  # checking approval type
  # ie amanual or automatic
  # set for the pgm
  # if so upadtes all payments
  #----------------------------------------------------------------------------

    # getting pgm details
    $sql1  	=	"select * from partners_pgmstatus where pgmstatus_programid='$pgmid'";
    $result	=	mysql_query($sql1)or die($sql1."<br/>".mysql_error());

    # getting approval type
    $row			=	mysql_fetch_object($result);
    $approval		=	$row->pgmstatus_saleapproval;
    $mailmerchant 	=	$row->pgmstatus_mailmerchant;
    $mailaffiliate 	=	$row->pgmstatus_mailaffiliate;
    if($approval=="automatic")
    {
       # automatic approval

       $approvalstatus = "approved";
       $today          = date("Y-m-d");

       # gets admin commsion
	   //if its in percentage (it can be in % or flat rate as determined by the admin thru Options - Payments)
	   if($GLOBALS['admin_salerate_type']=="percentage")
	   {
	       $admin_amount   = $sale*($admin_salerate)/100;
    	   $admin_salerate = round($admin_amount,2);
	   }
	   else $admin_amount = $admin_salerate;

		# get merchant account
        $sql   = "SELECT *  FROM `merchant_pay`  WHERE pay_merchantid='$mid' ";
	    $res   = mysql_query($sql);
        echo @mysql_error();

        # updating mercahnt balance
        $num	  =	mysql_num_rows($res);
        $cut_off  =	$minimum_amount;
        if($num>0){
               $row1               =   mysql_fetch_object($res);
               $merchant_balance   = $row1->pay_amount;

               #money emmpty status
               if(($merchant_balance-($salerate+$admin_salerate) )<=$cut_off){
               }
               else
               {

					# Update Account info of admin,affil,merchant

					# Adding money to affiliate account

                    # mercahnt balance
                     $merchant_balance = $merchant_balance-($salerate+$admin_salerate);

                   # getting affiliate balance
                     $sql1       ="SELECT *  FROM `affiliate_pay` where pay_affiliateid='$aid' ";
                     $res1       =mysql_query($sql1);
                     echo @mysql_error();

                   # updating affiliate balance
                     $num=mysql_num_rows($res1);
                     if($num>0)
                     {
                        $row1   	=   mysql_fetch_object($res1);
                        $curamount  = $row1->pay_amount;
                        $curamount  = $curamount+$salerate;

                        $sql2 ="update affiliate_pay set pay_amount='$curamount' where pay_affiliateid='$aid'";
                        $ret2 =mysql_query($sql2);
                     }
                     else
                     {
                        $sql2 ="INSERT INTO  affiliate_pay set pay_affiliateid='$aid' , pay_amount='$salerate'";
                        $ret2 =mysql_query($sql2);
                     }

    				# affiliate account editing Ends here--------------------------//

    				# Subtract Money From Merchant Account ---------------------------//
                    $sql    = "UPDATE  `merchant_pay` SET  pay_amount='$merchant_balance'  WHERE pay_merchantid='$mid' ";
                    $res    = mysql_query($sql);

    				#END OF  Subtract Money From Merchant Account ---------------------------//

    				# Adding To Admins Account

                    # setting admin payments
                    # gets admin balance
                     $sql1      = "SELECT *  FROM `admin_pay`  ";
                     $res1      = mysql_query($sql1);
                     echo @mysql_error();

                     $num	=	mysql_num_rows($res1);
                     if($num>0){
                        $row1   			=  mysql_fetch_object($res1);
                        $admin_curamount    = $row1->pay_amount;
                        $admin_curamount    = ($admin_curamount+$admin_salerate)-$subsalerate;
                     }

                     # updating admin balance
                     $sql        = "UPDATE `admin_pay` SET `pay_amount` = '$admin_curamount'";
                     $res        = mysql_query($sql);

                     #---------------------------------------------------------
                     # subsale exists
                     #---------------------------------------------------------

                      if($flag==1) {
                       $sql1    = "SELECT *  FROM `affiliate_pay` where pay_affiliateid='$parentid' ";
                       $res1    = mysql_query($sql1);
                       echo mysql_error();

                       $num=mysql_num_rows($res1);
                       if($num>0) {
                           $row1       =   mysql_fetch_object($res1);
                           $curamount  = $row1->pay_amount;
                           $curamount  = $curamount+$subsalerate;
                           $sql2 ="update affiliate_pay set pay_amount='$curamount' where pay_affiliateid='$parentid'";
                           $ret2 =mysql_query($sql2);
                        }
                      }
					# END OF Adding to admin's account
               }
         }
           //$ip 			= $GLOBALS['REMOTE_ADDR'];
          $sql = "INSERT into partners_transaction(transaction_joinpgmid,transaction_type,transaction_status,transaction_dateoftransaction,transaction_amttobepaid,transaction_linkid,transaction_subsale,transaction_parentid,transaction_flag,transaction_admin_amount,transaction_dateofpayment,transaction_referer,transaction_orderid,transaction_ip,transaction_subid,transaction_transactiontime) values ('$joinid','sale','$approvalstatus','$today','$salerate','$linkid','$subsalerate','$parentid','$flag','$admin_amount','$today','".addslashes($referer)."','".addslashes($orderId)."','".addslashes($ip)."','".addslashes($subid)."','$presenttime') ";
       	  mysql_query($sql);
          $newId = mysql_insert_id();

     	# END OF CODE  Added BY PRAMOD FOR UPDATE CURENT AMOUNT IN AFFIL,MERCHANT,ADMIN ACCOUNT

          //////////////////////////////////////////////////////////////////////////
    	 /////////// setting transid//////////////////////////////////////////////

	     $saleQuery   = " UPDATE  partners_track_revenue ";
	     $saleQuery   .= " SET revenue_transaction_id = '$newId' ";
	     $saleQuery   .= " WHERE revenue_id = '$saleQueryId' ";
         mysql_query($saleQuery);
	     /////////////////// end /////////////////////////////////////////////////
	     /////////////////////////////////////////////////////////////////////////

    }else{

          # manuall approval
     	  $approvalstatus = "pending";
	      $today          = date("Y-m-d");

		//if its in percentage (it can be in % or flat rate as determined by the admin thru Options - Payments)
		if($GLOBALS['admin_salerate_type']=="percentage")
		{
			$admin_amount   = $sale*($admin_salerate)/100;
			$admin_amount   = round($admin_amount,2);
		}
		else $admin_amount = $admin_salerate;

           //$ip 			= $GLOBALS['REMOTE_ADDR'];
	      $sql = "INSERT into partners_transaction(transaction_joinpgmid,transaction_type,transaction_status,transaction_dateoftransaction,transaction_amttobepaid,transaction_linkid,transaction_subsale,transaction_parentid,transaction_flag,transaction_admin_amount,transaction_referer,transaction_orderid,transaction_ip,transaction_subid,transaction_transactiontime) values ('$joinid','sale','$approvalstatus','$today','$salerate','$linkid','$subsalerate','$parentid','$flag','$admin_amount','".addslashes($referer)."','".addslashes($orderId)."','".addslashes($ip)."','".addslashes($subid)."','$presenttime') ";
	      mysql_query($sql);
	      $newId = mysql_insert_id();

	     //////////////////////////////////////////////////////////////////////////
	     /////////// setting transid//////////////////////////////////////////////

	     $saleQuery    = " UPDATE  partners_track_revenue ";
	     $saleQuery   .= " SET revenue_transaction_id = '$newId' ";
	     $saleQuery   .= " WHERE revenue_id = '$saleQueryId' ";
         mysql_query($saleQuery);
	     /////////////////// end /////////////////////////////////////////////////
	     /////////////////////////////////////////////////////////////////////////
      }



     # mailing
     if ($mailmerchant =="yes") {
           MailMerchant($aid,$mid,$pgmid,$salerate,$admin_salerate,"sale");
       }
     if($mailaffiliate =="yes") {
           MailAffilaite($aid,$mid,$pgmid,$salerate,"sale");
       }

 }

 #-----------------------------------------------------------------------------
 # comparing date
 #----------------------------------------------------------------------------
 function CompareTime($ipblock)
      {

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
	{  echo "in func";
		if($recentsale == 1)
		{
			$ipaddress				=   $HTTP_SERVER_VARS['REMOTE_ADDR'];     //getting ip address
			if(empty($ipaddress)) $ipaddress = $_SERVER['REMOTE_ADDR'];
		
			$sql_sale = "SELECT *,date_format(transaction_transactiontime,'%H/%i/%s/%d/%m/%y') as transtime FROM partners_transaction WHERE ".
			" transaction_joinpgmid = '$joinid' AND ".
			" transaction_type = 'sale' AND ".
			" transaction_linkid = '$linkid' AND ".
			" transaction_ip = '$ipaddress' ORDER BY transaction_id DESC";
			
			
			$res_sale = mysql_query($sql_sale);
			if(mysql_num_rows($res_sale) > 0)
			{
				$row_sale = mysql_fetch_object($res_sale);
				$lasttime = $row_sale->transaction_transactiontime; echo "<br> lats time = ".$lasttime."<br>sale sec = ".$saleseconds."<br>";
					
				# adding currenttime + clickseconds time
				$sql_delay      =   "select date_format(DATE_ADD('$lasttime',INTERVAL $saleseconds SECOND),'%H/%i/%s/%d/%m/%y') d " ;
				$ret_delay      =   @mysql_query($sql_delay);
				# getting  currenttime + clickseconds
				$row_delay     =   @mysql_fetch_object($ret_delay);
				$nextsaletime =   $row_delay->d;  echo "<br>next sale = ".$nextsaletime;
	
				//die("time = " .$nextclicktime);
				if(CompareTime($nextsaletime))
				{  echo "           outside sale time    ";
					return true;
				}
				else
				{ 	echo "    within sale time ";
					 return false;
				} 
			}
			else
				return true;
		}
		else
			return true;
	}


?>