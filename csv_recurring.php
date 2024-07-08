<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  csv_recurring.php     		                    */
/*     CREATED ON     :  17/JULY/2006                                   */

/*		Exporting Recurring Report to CSV Format						*/
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
	$mode		= $_REQUEST['mode'];
	$currValue	= $_REQUEST['currValue'];
	$currsymbol	= trim($_REQUEST['currsymbol']);

	if($currsymbol == '') $currsymbol = html_entity_decode($_SESSION['DEFAULTCURRENCYSYMBOL']);
	
	if($currValue == '') $currValue = $default_currency_caption;
	
	include_once 'language_include.php';

?>

<?
//Display the report for Recurring Transactions
	if($display == '' || $display == 'Transaction')
	{
		$trans		= $recurobj->getRecurringTransactions($merchant);		
		

		$csv_trans = $lang_recur_transaction."\r\n";
		$csv_trans .= $recur_affiliate.",".$recur_Date.",".$recur_Commission.",".$recur_OrderId.",".$recur_Status."\r\n";
?>		<?		
		for($i=0; $i<count($recurobj->trans_id); $i++)
		{	
			$affName 		= $recurobj->aff_name[$i];
			$TransDate	 	= $recurobj->trans_date[$i];
		
			$recurAmt	= $recurobj->trans_amount[$i];
			if($currValue != $default_currency_caption){
				$recurAmt   =   getCurrencyValue($TransDate, $currValue, $recurAmt);
			}
			
			$transAmt		= $currsymbol." ".$recurAmt;
			$transOrderId	= $recurobj->trans_orderid[$i];
			$transStatus	= $recurobj->recur_status[$i];
			$csv_trans .= $affName.",".$TransDate.",".$transAmt.",".$transOrderId.",".$transStatus."\r\n";
		}
	}

// Display report for approved and pending recurring commissions depending on the option selected
	if($display != 'Transaction')
	{
		$result 	= $recurobj->getRecurringCommissions($display,$merchant);
		
		$csv_trans = (($display=='Approved') ? $lang_recur_approved : $lang_recur_pending);
		$csv_trans .= "\r\n".$recur_affiliate.",".$recur_Date.",".$recur_Commission.",".$recur_OrderId.",".$recur_Status."\r\n";
		
		for($i=0; $i<count($recurobj->payment_id); $i++)
		{	
			$affName		= $recurobj->aff_name[$i];
			$recurDate 	= $recurobj->recur_date[$i];
			$recurAmt	= $recurobj->recur_amount[$i];
			if($currValue != $default_currency_caption){
				$recurAmt   =   getCurrencyValue($recurDate, $currValue, $recurAmt);
			}
			
			$recurAmount	= $currsymbol." ".$recurAmt;
			$recurOrderId	= $recurobj->trans_orderid[$i];
			$recurStatus	= $recurobj->recur_status[$i];
			
			$csv_trans .= $affName.",".$recurDate.",".$recurAmount.",".$recurOrderId.",".$recurStatus."\r\n";
		}
	}
	
//Creating file	
	if($mode == 'admin')
		$fileName =$_SESSION['ADMINUSERID']."_admin_recurring.csv";
	else if($mode == 'merchant')
		$fileName = $_SESSION['MERCHANTID']."_merchant_recurring.csv";
	
	
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
