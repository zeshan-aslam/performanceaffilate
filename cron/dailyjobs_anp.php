<?php	
# Variables
#***********
	$basePath = "/home/alstraso/public_html/affiliates/";

#*******************************************************
#Section to Get Daily rates from XE.com  Starts HERE
#*******************************************************

# including all needed files
	$constPath = $basePath.'includes/constants.php';   

	$from = "USD";
	$amt=1;
	$today = date('Y-m-d');
	
# estabilshing connection
	mysql_connect($host,$user,$pass);
	mysql_select_db($db);
    
 	$curobj = new currency();
	$rateobj = new   currency();

//checks if the integration with XE.com is true
if($const_getCurrencyRatesFromXe == "1")
{
	
	# For integration with xe.com
		$currencyPath = $basePath."currency_converter.inc.php";
		include_once($currencyPath);
		
	#  Gets base currency code	
		$base = $default_currency_code;
		$baseCurr = new CURRENCYCONVERTER(1,$base,$from);
		$baseValue = $baseCurr->convert();
		
		
	# Gets all currencies from the table
		$result = $curobj->GetAllCurrencies($base);
		if($result)
		{
			for($i=0; $i<count($curobj->curCode); $i++)
			{
				$to 	= $curobj->curCode[$i];
				
				$curr 	= new CURRENCYCONVERTER($amt,$to,$from);
				$newAmt = $curr->convert();
				
				$currAmt = number_format(($newAmt / $baseValue),2);
				
				$rateobj->FindCurrentRate($to);
				$presentRate = $rateobj->rate;
				
				if($presentRate != $currAmt)
				{
					$sql_rate = "INSERT INTO partners_currency_relation (relation_currency_code, relation_value, relation_date) ".
					" VALUES( '$to', $currAmt, '$today') ";  
					$res_rate = mysql_query($sql_rate);
				}
			}
		}
}

#*******************************************************
# Rates Section Ends HERE
#*******************************************************

# Finding and paying Recurring Commission Starts HERE
#*******************************************************

	$today = date('Y-m-d');

//Gets commissio0n to be recurred for the current day
	$sql = "SELECT * FROM partners_recur, partners_transaction, partners_joinpgm, partners_merchant, partners_affiliate ".
	" WHERE recur_balanceamt > 0 AND recur_status='Active' AND ".
	" date_format(now(),'%Y-%m-%d') >= date_format(DATE_ADD(recur_lastpaid ,INTERVAL recur_period MONTH),'%Y-%m-%d') ".
	" AND recur_transactionid = transaction_id AND joinpgm_id = transaction_joinpgmid AND ".
	" merchant_id=joinpgm_merchantid  AND merchant_status='approved' AND affiliate_id=joinpgm_affiliateid AND affiliate_status='approved' ";

	$res = mysql_query($sql);  
	if(mysql_num_rows($res) > 0)
	{  
		//for each commission to be recurred today
		while($row = mysql_fetch_object($res))
		{
			$recurId	 		= $row->recur_id;	 
			$transId			= $row->recur_transactionid;
			$totalComm			= $row->recur_totalcommission;
			$recurPercent		= $row->recur_percentage;
			$recurPeriod		= $row->recur_period;
			$recurBalance		= $row->recur_balanceamt;
			$totalSubsaleComm	= $row->recur_total_subsalecommission;
			$balanceSubsale		= $row->recur_balance_subsaleamt;
			$transStatus		= $row->transaction_status;
			$merId				= $row->joinpgm_merchantid;
			$affId 				= $row->joinpgm_affiliateid;
			$parentid			= $row->transaction_parentid;
			
			
			//Calculates commission amount and subsale commission amount
			$currComm			= ($totalComm / $recurPercent) * 100;
			if($currComm > $recurBalance) 
				$currComm		= $recurBalance;
			$currBalanceComm	= $recurBalance - $currComm;
			$currSubsale		= ($totalSubsaleComm / $recurPercent) * 100;
			if($currSubsale > $balanceSubsale)
				$currSubsale	= $balanceSubsale;
			$currBalanceSubsale	= $balanceSubsale - $currSubsale;  

			//if Transaction Status is approved perform the Money transaction to the Merchant an dAffiliate balances
			if($transStatus == 'approved')
			{
				//Checking Merchant Balance
				$cutOfff = $minimum_amount;  //getting minimum balance for merchant
				
				$sql_mer = "SELECT * FROM merchant_pay WHERE pay_merchantid = $merId ";
				$res_mer = @mysql_query($sql_mer);

				//if Merchant balance exists
				if(mysql_num_rows($res_mer) > 0)
				{
					$row_mer = mysql_fetch_object($res_mer);
					$merchant_bal = $row_mer->pay_amount; 
					
					//if Merchnat do not have minimum Balance in his accont then set the Transaction status as pending
					// so that it can be added to the affiliate balance later
					if(($merchant_bal - $currComm) <= $cutOfff)
					{	
						$transStatus = 'pending';
					}
					else  // if merchant has minimum balance in his account
					{
						$merchant_bal = $merchant_bal - $currComm; 
						
						//getting Affiliate payment details
						$sql_aff = "SELECT * FROM  affiliate_pay WHERE pay_affiliateid = $affId ";
						$res_aff = @mysql_query($sql_aff);
						
						//If affiliate account exists update account
						if(mysql_num_rows($res_aff) > 0)
						{
							$row_aff = mysql_fetch_object($res_aff);
							$affiliate_bal = $row_aff->pay_amount; 
							$affiliate_bal = $affiliate_bal + $currComm; 
							
							$sql_affPay = "UPDATE affiliate_pay SET pay_amount = $affiliate_bal  WHERE pay_affiliateid = $affId ";
							$res_affPay = @mysql_query($sql_affPay);

						}	
						else // Add account record for the Affiliate
						{
							$sql_affPay = "INSERT INTO affiliate_pay SET pay_amount = $affiliate_bal, pay_affiliateid = $affId ";
							$res_affPay = @mysql_query($sql_affPay);
						}
						
						$sql_merPay = "UPDATE merchant_pay SET pay_amount=$merchant_bal WHERE pay_merchantid = $merId ";
						$res_merPay = @mysql_query($sql_merPay);
					
						//Adds Subsale Commission to Parent Affiliate and Subtracts it from the Admin Amount
						$admin_curamount = 0;
						if($currSubsale > 0)
						{
							//Gets details of Admin Account
							$sql_admin = "SELECT * FROM admin_pay ";
							$res_admin = @mysql_query($sql_admin);
							//If admin record exists perform subsale commission calculation
							if(mysql_num_rows($res_admin) > 0)
							{
								$row_admin = mysql_fetch_object($res_admin);
								$admin_curamount = $row_admin->pay_amount; 
								$admin_curamount = $admin_curamount - $currSubsale; 
							
								// Gets Parent Affiliate balance
								$sql_subsale = "SELECT * FROM affiliate_pay WHERE pay_affiliateid = $parentid ";
								$res_subsale = @mysql_query($sql_subsale);
								
								//If Parent affiliate accountexists updates the account balance
								if(mysql_num_rows($res_subsale) > 0)
								{
									$row_subsale = mysql_fetch_object($res_subsale);
									$parent_curamt = $row_subsale->pay_amount; 
									$parent_curamt = $parent_curamt + $currSubsale; 
									
									$sql_subsalePay = "UPDATE affiliate_pay SET pay_amount=$parent_curamt WHERE pay_affiliateid = $parentid ";
									$res_subsalePay = @mysql_query($sql_subsalePay);
								}
								else  // Adds new account balance for the parent Affiliate
								{
									$sql_subsalePay = "INSERT INTO affiliate_pay SET pay_amount=$parent_curamt, pay_affiliateid = $parentid ";
									$res_subsalePay = @mysql_query($sql_subsalePay);
								}
								
								//Updates the administrator balance
								$sql_adminPay = "UPDATE admin_pay SET pay_amount=$admin_curamount ";
								$res_adminPay = @mysql_query($sql_adminPay);
							}
							else  //Add new account for the Administrator
							{
								$sql_adminPay = "INSERT INTO admin_pay SET pay_amount=$admin_curamount ";
								$res_adminPay = @mysql_query($sql_adminPay);
							}
						}
					}
				}
				else  //If merchant do not have any account set recurring staus as pending
				{
					$transStatus = 'pending';
				}
			}
			
			
			//Updates the recur record with the new date of payment and the new balance commisison and subsale comm	 
			$sql_recur = "UPDATE partners_recur SET ".
			" recur_balanceamt 			= '$currBalanceComm' , ".
			" recur_lastpaid 			= '$today' , ".
			" recur_balance_subsaleamt	= '$currBalanceSubsale'  ".
			" WHERE recur_id 			= '$recurId' ";
			$res_recur = @mysql_query($sql_recur);
			
			//Adds new record for the Recurring payment
			$sql_recurpay = "INSERT INTO partners_recurpayments SET ".
			" recurpayments_recurid			= '$recurId' , ".
			" recurpayments_date			= '$today' , ".
			" recurpayments_amount			= '$currComm' , ".
			" recurpayments_status			= '$transStatus' , ".
			" recurpayments_subsaleamount	= '$currSubsale'  ";
			$res_recurpay = @mysql_query($sql_recurpay);
		}
	}


#*******************************************************
#  Recurring Commission Ends HERE
#*******************************************************


#*******************************************************
# Class Currency
#*******************************************************
class currency
{
		/*-------------------------------------------------------------------------------------------
		Function to find the currency details of currrencies other tahn present Base Currency
		Created By	: 	SMA
		Created On 	: 	8-AUG-2006
		-------------------------------------------------------------------------------------------*/
		function GetAllCurrencies($base)
		{
			$sql = "SELECT * FROM partners_currency WHERE currency_code != '$base' ";
			$res = mysql_query($sql);
			
			if(mysql_num_rows($res) > 0)
			{
				while($row = mysql_fetch_object($res))
				{
					$this->curCode[]   	= $row->currency_code;
					$this->curCaption[]	= $row->currency_caption;
				}
				return true;
			}
			else
				return false;
		}
	
		/*-------------------------------------------------------------------------------------------
		Function to get the present rate of a currency with respect to the Base currency
		Created By	: 	SMA
		Created On 	: 	8-AUG-2006
		-------------------------------------------------------------------------------------------*/
		function FindCurrentRate($currency)
		{
			$sql = "SELECT * FROM partners_currency_relation ".
			" WHERE relation_currency_code = '$currency' ORDER BY relation_date DESC ";
			$res = mysql_query($sql);
			
			if(mysql_num_rows($res) > 0)
			{
				$row = mysql_fetch_object($res);
				$this->rate = $row->relation_value;
			}
			else
				$this->rate = 0;
			return;
		}
}
#*******************************************************
# END Class Currency
#*******************************************************
?>