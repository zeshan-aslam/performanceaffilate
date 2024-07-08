<?php	

# including all needed files
   include 'includes/constants.php';
   include_once 'includes/functions.php';
   include_once 'includes/session.php';
   include_once 'includes/function1.php';

	$from = "USD";
	$amt=1;
	$today = date('Y-m-d');
	
# estabilshing connection
   $partners=new partners;
   $partners->connection($host,$user,$pass,$db);
   
 	$curobj = new currency();
	$rateobj = new   currency();

//checks if the integration with XE.com is true
if($const_getCurrencyRatesFromXe == "1")
{
	
	# For integration with xe.com
		include_once("currency_converter.inc.php");
		
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
					" VALUES( '$to', '$currAmt', '$today') ";  
					$res_rate = mysql_query($sql_rate);
				}
			}
		}
}
?>