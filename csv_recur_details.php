<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  csv_recur_details.php     		                */
/*     CREATED ON     :  18/JULY/2006                                   */

/*		Exporting Recurring Details Report to CSV Format				*/
/************************************************************************/
include_once 'includes/db-connect.php';
  include 'includes/session.php';
  include 'includes/constants.php';
  include 'includes/functions.php';
  include 'includes/allstripslashes.php';
  include 'includes/function1.php';

	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);

	$recurobj	= new recur();
	
	$merchant  	= $_REQUEST['mid'];
	$display	= $_REQUEST['display'];
	$id 		= $_REQUEST['id'];
	$mode		= $_REQUEST['mode'];
	$currValue	= $_REQUEST['currValue'];
	$currsymbol	= $_REQUEST['currsymbol'];

	if($currsymbol == '') $currsymbol = html_entity_decode($_SESSION['DEFAULTCURRENCYSYMBOL']);
	
	if($currValue == '') $currValue = $default_currency_caption;
	
	
	include_once 'language_include.php';
	

if($display == 'commission')
{
	$result = $recurobj->getRecurDetails($id,$merchant);
	$recurDate		= $recurobj->recur_date;
	
	$recurAmt		= $recurobj->recur_amount; 
	$totalComm		= $recurobj->total_comm;
	$saleAmt		= $recurobj->sale_amount;
	
	 if($currValue != $default_currency_caption){
			  $recurAmt    	 	=   getCurrencyValue($recurDate, $currValue, $recurAmt);
			  $totalComm    	=   getCurrencyValue($recurDate, $currValue, $totalComm);
			  $saleAmt	    	=   getCurrencyValue($recurDate, $currValue, $saleAmt);
	 }
	
	
	$csv_trans = $recur_commission_details."\r\n";
	$csv_trans .= $recur_affiliate.",".$recurobj->aff_name."\r\n";
	$csv_trans .= $recur_aff_company.",".$recurobj->aff_company."\r\n";
	$csv_trans .= $recur_aff_url.",".$recurobj->aff_url."\r\n";
	$csv_trans .= $recur_Commission.",".$currsymbol.round($recurAmt,2)."\r\n";
	$csv_trans .= $recur_Date.",".$recurobj->recur_date."\r\n";
	$csv_trans .= $recur_commStatus.",".$recurobj->recur_status."\r\n";
	$csv_trans .= $recuring_every.",".$recurobj->recur_period." ".$recur_months_head."\r\n";
	$csv_trans .= $recur_OrderId.",".$recurobj->trans_orderid."\r\n";
	$csv_trans .= $recur_total_comm.",".$currsymbol.round($totalComm,2)."\r\n";
	$csv_trans .= $recur_saleAmount.",".$currsymbol.round($saleAmt,2)."\r\n";
}

if($display == 'transaction')
{
	$result = $recurobj->getRecurTransDetails($id,$merchant);
	$transDate		= $recurobj->trans_date;
	
	$totalComm		= $recurobj->total_comm;
	$saleAmt	    = $recurobj->sale_amount;
	$recurBal		= $recurobj->recur_balance;
	
	if($currValue != $default_currency_caption){
			  $recurBal    	 	=   getCurrencyValue($transDate, $currValue, $recurBal);
			  $totalComm    	=   getCurrencyValue($transDate, $currValue, $totalComm);
			  $saleAmt	    	=   getCurrencyValue($transDate, $currValue, $saleAmt);
	 }
	
	
	$csv_trans = $recur_trans_details."\r\n";
	$csv_trans .= $recur_affiliate.",".$recurobj->aff_name."\r\n";
	$csv_trans .= $recur_aff_company.",".$recurobj->aff_company."\r\n";
	$csv_trans .= $recur_aff_url.",".$recurobj->aff_url."\r\n";
	$csv_trans .= $recur_total_comm.",".$currsymbol.round($totalComm,2)."\r\n";
	$csv_trans .= $recur_Date.",".$recurobj->trans_date."\r\n";
	$csv_trans .= $recur_commStatus.",".$recurobj->recur_status."\r\n";
	$csv_trans .= $recur_OrderId.",".$recurobj->trans_orderid."\r\n";
	$csv_trans .= $recur_saleAmount.",".$currsymbol.round($saleAmt,2)."\r\n";
	$csv_trans .= $recuring_every.",".$recurobj->recur_period." ".$recur_months_head."\r\n";
	$csv_trans .= $recur_balance.",".$currsymbol.round($recurBal,2)."\r\n";
	if($recurobj->recur_status == 'Active' && $recurobj->recur_balance > 0) {  	
		$csv_trans .= $recur_nextdate.",".$recurobj->recur_nextpay."\r\n";	
	}
}

//Creating file	
	if($mode == 'admin')
		$fileName =$_SESSION['ADMINUSERID']."_admin_recur_details.csv";
	else if($mode == 'merchant')
		$fileName = $_SESSION['MERCHANTID']."_merchant_recur_details.csv";
	
	
	$fp = fopen( "reports/".$fileName,"w");
	fwrite($fp,$csv_trans);
	fclose($fp);

//Download file
	$newFile	= 	$fileName;
	$path		=	"reports/".$newFile;
/*	
	header('Content-Type: application/force-download; filename="'.$newFile.'"');
	header('Content-Disposition: attachment; filename="'.$newFile.'"');
	readfile($path);
	
	unlink($path);
	exit;	

*/

	header("Pragma: public");
	header('Expires: '.gmdate('D, d M Y H:i:s').' GMT');
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);
	header("Content-Type: application/force-download");
	header('Content-Disposition: attachment; filename="'.$newFile.'"');
	header("Content-Transfer-Encoding: binary");
	header('Content-Length: '.@filesize($path));
	set_time_limit(0);
	@readfile($path) OR die("file not found");
	
	unlink($path);
	
	exit;

?>
