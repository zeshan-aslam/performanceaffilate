<?php	ob_start();
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  currency_process.php                           */
/*     CREATED ON     :  04/AUG/2006                                    */

/*		Adds New Currency Details & Changes the base Currency			*/
/*  Writes the values for the base currency on change to constants.php  */
/************************************************************************/

# including all needed files
   include_once '../includes/constants.php';
   include_once '../includes/functions.php';
   include_once '../includes/session.php';
   include_once '../includes/function1.php';

# estabilshing connection
   $partners=new partners;
   $partners->connection($host,$user,$pass,$db);

	$commonobj		= new common();
	$currencyobj	= new currency();
	
# -------------------------------------------------------------------------
# getting form variables
# -------------------------------------------------------------------------

    $mode               = trim(stripslashes($_REQUEST['mode']));
	$txt_caption		= trim(stripslashes($_REQUEST['txt_caption']));
	$txt_code			= trim(stripslashes($_REQUEST['txt_code']));
	$txt_symbol			= trim(stripslashes($_REQUEST['txt_symbol']));
	$txt_relation		= trim(stripslashes($_REQUEST['txt_relation']));

	$validatestring = $txt_caption."~*".$txt_code."~*".$txt_symbol."~*".$txt_relation;
	$returnstring	= "txt_caption=$txt_caption&txt_code=$txt_code&txt_symbol=$txt_symbol&txt_relation=$txt_relation";

	if($mode == 'add')
	{
		//check all mandatory fields
		if($commonobj->nullvalidation($validatestring))
		{
			$note        = "Please enter all the Required Fields";
			header("location: index.php?Act=currency&mode=add&note=$note&$returnstring");
			exit;
		}
		
		if(!is_numeric($txt_relation))
		{
			$note        = "Please enter a numeric value for Currency Relation";
			header("location: index.php?Act=currency&mode=add&note=$note&$returnstring");
			exit;
		}

		if(!$currencyobj->ifCurrencyDetailsExists('caption',$txt_caption))
		{
			$note = "Currency Caption already exists";
			header("Location: index.php?Act=currency&mode=add&note=$note&$returnstring");
			exit;
		}

		if(!$currencyobj->ifCurrencyDetailsExists('code',$txt_code))
		{
			$note = "Currency Code already exists";
			header("Location: index.php?Act=currency&mode=add&note=$note&$returnstring");
			exit;
		}
	
		if(!$currencyobj->ifCurrencyDetailsExists('symbol',$txt_symbol))
		{
			$note = "Currency Symbol already exists";
			header("Location: index.php?Act=currency&mode=add&note=$note&$returnstring");
			exit;
		}
		
		if(!$currencyobj->insertCurrency($txt_caption, $txt_code, $txt_symbol, $txt_relation))
		{
			$note = "Unknown Error!.  Insertion failed";
			header("Location: index.php?Act=currency&mode=add&note=$note&$returnstring");
			exit;
		}
		else
		{
			$note = "Currency details Inserted Successfully";
			header("Location: index.php?Act=currency&mode=add&note=$note");
			exit;
		}
	}
	else if($mode == 'change')
	{
		$basecurrency = $_REQUEST['basecurrency'];
		$sql_cur = "SELECT * FROM partners_currency WHERE currency_code='$basecurrency'" ;
		$res_cur = mysql_query($sql_cur);
		if(mysql_num_rows($res_cur) > 0)
		{
			$row_cur = mysql_fetch_object($res_cur);
			$new_symbol = stripslashes(trim($row_cur->currency_symbol));
			$new_caption = stripslashes(trim($row_cur->currency_caption));
			
			$currencyobj->ConvertToNewBaseCurrency($basecurrency);
			
			//If new Currency Exists
            $filename  		="../includes/constants.php";
            $fd 			= fopen ($filename, "r");
            $contents 		= fread ($fd, filesize ($filename));
            fclose($fd);
            $conts        	=explode("\n",$contents);
            $n        		=count($conts);
            for ($i=0; $i<$n; $i++) {
                   $tmp        	=explode("=",$conts[$i]);
                   $tmp1        =trim($tmp[0]);
                   if($tmp1=="$"."default_currency_code"){
                       $conts[$i]        =str_replace($default_currency_code,$basecurrency,$conts[$i]);
                       continue;
                   }
                   if($tmp1=="$"."default_currency_caption"){
                       $conts[$i]        =str_replace($default_currency_caption,$new_caption,$conts[$i]);
                       continue;
                   }
            }
			$fd = fopen ($filename, "w");
			$cont1  =implode("\n",$conts);
			fwrite($fd,$cont1);
				fclose($fd);
				
			include_once '../update_currency_rates.php';
			 
			$msg = "Base Currency Changed successfully";
		}
		else
		{
			$msg = "Unknown Error!.  Change Base Currency Failed";
		}
		
	
		 header("Location: index.php?Act=currency&mode=add&note1=$msg");
		 exit;
	}
	else if($mode == 'rate')
	{
		//die("mode = =" .$mode);
		$chk_currency = $_REQUEST['chk_currency'];
		if($chk_currency)
			$status = "1";
		else
		 	$status = "0";

		//Toggles the status of the Integration with XE.com
		$filename  		="../includes/constants.php";
		$fd 			= fopen ($filename, "r");
		$contents 		= fread ($fd, filesize ($filename));
		fclose($fd);
		$conts        	=explode("\n",$contents);
		$n        		=count($conts);
		for ($i=0; $i<$n; $i++) {
			   $tmp        	=explode("=",$conts[$i]);
			   $tmp1        =trim($tmp[0]);
			   if($tmp1=="$"."const_getCurrencyRatesFromXe"){
				   $conts[$i]        =str_replace($const_getCurrencyRatesFromXe,$status,$conts[$i]);
				   continue;
			   }
		}
		$fd = fopen ($filename, "w");
		$cont1  =implode("\n",$conts);
		fwrite($fd,$cont1);
		fclose($fd);
	
		 header("Location: index.php?Act=currency");
		 exit;
	}
?>