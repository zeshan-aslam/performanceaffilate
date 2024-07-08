<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  csv_forperiod.php     		            	    */
/*     CREATED ON     :  19/JULY/2006                                   */

/*		Exporting For Period Report to CSV Format						*/
/************************************************************************/
include_once 'includes/db-connect.php';
  include 'includes/session.php';
  include 'includes/constants.php';
  include 'includes/functions.php';
  include 'includes/allstripslashes.php';
  include 'includes/function1.php';

	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);

	
	$reportobj	= new report();

	include_once 'language_include.php';

	$merchant  	= $_REQUEST['mid'];
	if($merchant == 'All') $merchantName = $lang_report_allmerchant;
	else {
		$merchantName	= $reportobj->FindMerchantName($merchant);
	}
	
	$affiliate	= $_REQUEST['aid'];
	if($affiliate == 'All') $affiliateName = $lang_report_allaffiliate;
	else {
		$affiliateName = $reportobj->FindAffiliateName($affiliate);
	}
	
	$mode		= $_REQUEST['mode'];
	$date		= $_REQUEST['date'];
	$values		= $_REQUEST['values'];
	$values		= explode("~",$values);
	$nimpr		= $values[0];
	$impr		= $values[1];
	$nclick		= $values[2];
	$click		= $values[3];
	$nlead		= $values[4];
	$lead		= $values[5];
	$nsale		= $values[6];
	$sale		= $values[7];
	
	$currsymbol	= $values[10];
	if($currsymbol == '') $currsymbol = html_entity_decode($_SESSION['DEFAULTCURRENCYSYMBOL']);

	$csv_trans = $lang_report_stat." ".$date."\r\n";
	if($mode != 'affiliate') {  
		$csv_trans .= $lang_report_merchant." : ".$merchantName."\r\n";
	}
	if($mode == 'admin' || $mode == 'affiliate') {  
		$csv_trans .= $lang_report_affiliate." : ".$affiliateName."\r\n";
	}
	$csv_trans .= $lang_report_transaction.",".$lang_report_number.",".$lang_report_commission."\r\n";
	$csv_trans .= $lang_impression.",".$nimpr.",".trim($currsymbol).round($impr,2)."\r\n";
	$csv_trans .= $lang_click.",".$nclick.",".trim($currsymbol).round($click,2)."\r\n";
	$csv_trans .= $lang_lead.",".$nlead.",".trim($currsymbol).round($lead,2)."\r\n";
	$csv_trans .= $lang_sale.",".$nsale.",".trim($currsymbol).round($sale,2)."\r\n";
	
//Creating file	
	if($mode == 'admin')
		$fileName =$_SESSION['ADMINUSERID']."_admin_forperiod.csv";
	else if($mode == 'merchant')
		$fileName = $_SESSION['MERCHANTID']."_merchant_forperiod.csv";
	else if($mode == 'affiliate')
		$fileName = $_SESSION['AFFILIATEID']."_affiliate_forperiod.csv";
	
	
	$fp = fopen( "reports/".$fileName,"w");
	fwrite($fp,$csv_trans);
	fclose($fp);

//Download file
	$newFile	= 	$fileName;
	$path		=	"reports/".$newFile;


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
