<?php	ob_start();

# including all needed files
   include_once 'includes/constants.php';
   include_once 'includes/functions.php';
   include_once 'includes/session.php';
   include_once 'includes/function1.php';

	$from = "USD";
	
# estabilshing connection
   $partners=new partners;
   $partners->connection($host,$user,$pass,$db);
   
 	$curobj = new currency();  

# For integration with xe.com
	include_once("currency_converter.inc.php");
	
#  Gets base currency code	
	$base = "GBP" ; //$default_currency_code;
	$baseCurr = new CURRENCYCONVERTER(1,$base,$from);
	$baseValue = $baseCurr->convert();
	echo " 1 $from = $baseValue $base <br><br>";
	
# Gets all currencies from the table
	$result = $curobj->GetAllCurrencies($base);
	if($result)
	{
		for($i=0; $i<count($curobj->curCode); $i++)
		{
			$to = $curobj->curCode[$i];
			$amt=1;
			
			$curr=new CURRENCYCONVERTER($amt,$to,$from);
			$newAmt = $curr->convert();
			
			$currAmt = $newAmt / $baseValue;
			
			echo "<br/> $amt $from = $newAmt $to   >>  1 $base = ". number_format($currAmt,2)."  $to";
		}
	}

?>