<?php	ob_start();
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  fraudsettings_manage.php                        */
/*     CREATED ON     :  18/JUNE/2006                                   */
/*                                                                      */
/*     Fraud Settings Manage and Validate                                */
/************************************************************************/


#---------------------------------------------------------------------------
# including files
#---------------------------------------------------------------------------
	include_once '../includes/constants.php';
	include_once '../includes/functions.php';
	include_once '../includes/function1.php';
	include_once '../includes/session.php';
    include_once '../includes/allstripslashes.php';
#---------------------------------------------------------------------------
# setting connection
#---------------------------------------------------------------------------
    $partners	=	new partners;
    $partners->connection($host,$user,$pass,$db);
	
	$commonobj = new common();
	

	$recentclick	= stripslashes(trim($_REQUEST['chk_click']));
	$clickseconds	= stripslashes(trim($_REQUEST['txt_clickseconds']));
	$clickaction	= stripslashes(trim($_REQUEST['cmb_clickaction']));
	$recentsale		= stripslashes(trim($_REQUEST['chk_sale']));
	$saleseconds	= stripslashes(trim($_REQUEST['txt_saleseconds']));
	$saleaction		= stripslashes(trim($_REQUEST['cmb_saleaction']));
	$loginretry		= stripslashes(trim($_REQUEST['txt_login_retry']));
	$logindelay		= stripslashes(trim($_REQUEST['txt_login_delay']));
	$declinesale  	= stripslashes(trim($_REQUEST['chk_samesale']));   
	
	//assign all mandatory fields to a string separated by '~*'
	$validatestring = $loginretry."~*".$logindelay;
	if($recentclick) $validatestring .= "~*".$clickseconds;
	if($recentsale) $validatestring .= "~*".$saleseconds;

	if($recentclick) $recentclick = "1"; else $recentclick = "0";
	if($recentsale) $recentsale = "1"; else $recentsale = "0";
	if($declinesale)	$declinesale = "1"; else $declinesale = "0";  

	//assign return values into a string
	$returnstring        = "recentclick=$recentclick&clickseconds=$clickseconds&clickaction=$clickaction&recentsale=$recentsale&saleseconds=$saleseconds&saleaction=$saleaction&loginretry=$loginretry&logindelay=$logindelay&declinesale=$declinesale";
	//check all mandatory fields
	if($commonobj->nullvalidation($validatestring))
	{
			//redirect the user to entry page along with message
			$msg        = "Don't leave fields blank";
			header("location:index.php?Act=fraudsettings&msg=$msg&$returnstring");
			exit;
	}
	
//Validates Values
//*****************
		$valid = 1;
		if(!is_numeric($recentclick))
			$valid = 0;
		else if(!is_numeric($clickseconds))
			$valid = 0;
		else if(!is_numeric($recentsale))
			$valid = 0;
		else if(!is_numeric($saleseconds))
			$valid = 0;
		else if(!is_numeric($loginretry))
			$valid = 0;
		else if(!is_numeric($logindelay))
			$valid = 0;

if($valid == 0)
{
			$msg        = "Invalid Entry!!";
			header("location:index.php?Act=fraudsettings&msg=$msg&$returnstring");
			exit;
}
else
{
//Changes fraud setting vlaues in the file constants.php
//******************************************************
            $filename                  ="../includes/constants.php";
            $fd                         = fopen ($filename, "r");
            $contents                 = fread ($fd, filesize ($filename));
            fclose($fd);
            $conts                =explode("\n",$contents);
            $n                        =count($conts);
            for ($i=0; $i<$n; $i++) {
                   $tmp                =explode("=",$conts[$i]);
                   $tmp1        =trim($tmp[0]);
                   if($tmp1=="$"."fraudsettings_login_retry"){
                       $conts[$i]        =str_replace($fraudsettings_login_retry,$loginretry,$conts[$i]);
                       continue;
                   }
				   else if($tmp1=="$"."fraudsettings_login_delay"){
                       $conts[$i]        =str_replace($fraudsettings_login_delay,$logindelay,$conts[$i]);
                       continue;
                   }
				   else if($tmp1=="$"."fraudsettings_recentclick"){
                       $conts[$i]        =str_replace($fraudsettings_recentclick,$recentclick,$conts[$i]);
                       continue;
                   }
				   else if($tmp1=="$"."fraudsettings_clickseconds"){
                       $conts[$i]        =str_replace($fraudsettings_clickseconds,$clickseconds,$conts[$i]);
                       continue;
                   }
				   else if($tmp1=="$"."fraudsettings_clickaction"){
                       $conts[$i]        =str_replace($fraudsettings_clickaction,$clickaction,$conts[$i]);
                       continue;
                   }
				   else if($tmp1=="$"."fraudsettings_recentsale"){
                       $conts[$i]        =str_replace($fraudsettings_recentsale,$recentsale,$conts[$i]);
                       continue;
                   }
				   else if($tmp1=="$"."fraudsettings_saleseconds"){
                       $conts[$i]        =str_replace($fraudsettings_saleseconds,$saleseconds,$conts[$i]);
                       continue;
                   }
				   else if($tmp1=="$"."fraudsettings_saleaction"){
                       $conts[$i]        =str_replace($fraudsettings_saleaction,$saleaction,$conts[$i]);
                       continue;
                   }
				   else if($tmp1=="$"."fraudsettings_decline_recentsale"){
                       $conts[$i]        =str_replace($fraudsettings_decline_recentsale,$declinesale,$conts[$i]);
                       continue;
                   }
            }
			$fd = fopen ($filename, "w");
			$cont1  =implode("\n",$conts);
			fwrite($fd,$cont1);
			fclose($fd);
	
	
	$msg = "Fraud Settings Updated";
	header("location:index.php?Act=fraudsettings&msg=$msg&$returnstring");
	exit;
	
}	

?>